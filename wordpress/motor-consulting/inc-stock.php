<?php
/**
 * Motor Consulting — connecteur de stock (Kepler VO ou tout flux JSON / XML / CSV).
 *
 * Lit périodiquement le flux fourni par le logiciel de gestion, le convertit au
 * format attendu par assets/js/main.js et le met en cache. Les véhicules saisis
 * à la main dans WordPress restent possibles en complément.
 *
 * Réglages : Apparence → Personnaliser → Stock Kepler / flux d'annonces.
 * Suivi   : menu Véhicules → Stock Kepler (état, dernier import, bouton de synchronisation).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ------------------------------------------------------------------
 * Réglages (Personnalisateur)
 * ---------------------------------------------------------------- */
function motor_stock_defaults() {
	return array(
		'url'          => '',
		'auth_header'  => '',   // ex. "X-API-KEY" ou "Authorization"
		'auth_value'   => '',   // ex. la clé, ou "Bearer xxxx"
		'format'       => 'auto',
		'root'         => '',   // clé du tableau dans le JSON/XML (vide = détection automatique)
		'interval'     => 1,    // heures
		'mode'         => 'replace', // replace : le flux remplace les véhicules WP ; merge : les deux
	);
}

function motor_stock_opt( $key ) {
	$d = motor_stock_defaults();
	$v = get_theme_mod( 'motor_stock_' . $key, isset( $d[ $key ] ) ? $d[ $key ] : '' );
	return is_string( $v ) ? trim( $v ) : $v;
}

add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_section( 'motor_stock', array(
		'title'       => 'Stock Kepler / flux d\'annonces',
		'description' => 'Collez l\'adresse du flux fourni par Kepler VO (API véhicule ou export). Le site se met à jour automatiquement.',
		'priority'    => 21,
	) );
	$fields = array(
		'url'         => array( 'Adresse du flux (URL)', 'url' ),
		'auth_header' => array( 'Nom de l\'en-tête d\'authentification (ex. X-API-KEY, laisser vide si la clé est dans l\'URL)', 'text' ),
		'auth_value'  => array( 'Valeur de l\'en-tête (clé API, ou "Bearer …")', 'text' ),
		'format'      => array( 'Format', 'select', array( 'auto' => 'Détection automatique', 'json' => 'JSON', 'xml' => 'XML', 'csv' => 'CSV' ) ),
		'root'        => array( 'Clé du tableau de véhicules dans le flux (vide = automatique)', 'text' ),
		'interval'    => array( 'Fréquence de mise à jour (heures)', 'number' ),
		'mode'        => array( 'Véhicules saisis dans WordPress', 'select', array( 'replace' => 'Ignorés quand le flux est actif', 'merge' => 'Affichés en plus du flux' ) ),
	);
	$d = motor_stock_defaults();
	foreach ( $fields as $key => $f ) {
		$args = array( 'default' => $d[ $key ], 'sanitize_callback' => 'url' === $f[1] ? 'esc_url_raw' : 'sanitize_text_field' );
		$wp_customize->add_setting( 'motor_stock_' . $key, $args );
		$ctl = array( 'label' => $f[0], 'section' => 'motor_stock', 'type' => $f[1] );
		if ( 'select' === $f[1] ) {
			$ctl['choices'] = $f[2];
		}
		$wp_customize->add_control( 'motor_stock_' . $key, $ctl );
	}
} );

/* ------------------------------------------------------------------
 * Planification
 * ---------------------------------------------------------------- */
add_filter( 'cron_schedules', function ( $s ) {
	$h = max( 1, (int) motor_stock_opt( 'interval' ) );
	$s['motor_stock_interval'] = array( 'interval' => $h * HOUR_IN_SECONDS, 'display' => 'Stock Motor Consulting' );
	return $s;
} );

add_action( 'init', function () {
	if ( motor_stock_opt( 'url' ) && ! wp_next_scheduled( 'motor_stock_sync' ) ) {
		wp_schedule_event( time() + 60, 'motor_stock_interval', 'motor_stock_sync' );
	}
	if ( ! motor_stock_opt( 'url' ) && wp_next_scheduled( 'motor_stock_sync' ) ) {
		wp_clear_scheduled_hook( 'motor_stock_sync' );
	}
} );
add_action( 'motor_stock_sync', 'motor_stock_import' );

/* ------------------------------------------------------------------
 * Import
 * ---------------------------------------------------------------- */
function motor_stock_import() {
	$url = motor_stock_opt( 'url' );
	if ( ! $url ) {
		return new WP_Error( 'no_url', 'Aucune adresse de flux configurée.' );
	}
	$args = array( 'timeout' => 30, 'headers' => array( 'Accept' => 'application/json, application/xml, text/csv, */*' ) );
	if ( motor_stock_opt( 'auth_header' ) && motor_stock_opt( 'auth_value' ) ) {
		$args['headers'][ motor_stock_opt( 'auth_header' ) ] = motor_stock_opt( 'auth_value' );
	}
	$res = wp_remote_get( $url, $args );
	if ( is_wp_error( $res ) ) {
		motor_stock_status( 'error', $res->get_error_message() );
		return $res;
	}
	$code = wp_remote_retrieve_response_code( $res );
	$body = wp_remote_retrieve_body( $res );
	if ( 200 !== (int) $code || '' === $body ) {
		motor_stock_status( 'error', 'Réponse HTTP ' . $code );
		return new WP_Error( 'http', 'Réponse HTTP ' . $code );
	}

	$rows = motor_stock_parse( $body, wp_remote_retrieve_header( $res, 'content-type' ) );
	if ( is_wp_error( $rows ) ) {
		motor_stock_status( 'error', $rows->get_error_message() );
		return $rows;
	}

	$vehicules = array();
	$i         = 0;
	foreach ( $rows as $row ) {
		$v = motor_stock_map( $row, ++$i );
		if ( $v ) {
			$vehicules[] = $v;
		}
	}
	if ( empty( $vehicules ) ) {
		motor_stock_status( 'error', 'Flux lu mais aucun véhicule reconnu. Vérifiez la clé du tableau ou le format.' );
		return new WP_Error( 'empty', 'Aucun véhicule reconnu' );
	}

	update_option( 'motor_stock_vehicules', $vehicules, false );
	motor_stock_status( 'ok', count( $vehicules ) . ' véhicules importés' );
	return $vehicules;
}

function motor_stock_status( $state, $message ) {
	update_option( 'motor_stock_status', array( 'state' => $state, 'message' => $message, 'time' => time() ), false );
}

/** Détecte et décode JSON / XML / CSV en une liste de lignes associatives. */
function motor_stock_parse( $body, $content_type ) {
	$format = motor_stock_opt( 'format' );
	$body   = trim( $body );
	if ( 'auto' === $format ) {
		if ( '{' === $body[0] || '[' === $body[0] ) {
			$format = 'json';
		} elseif ( '<' === $body[0] ) {
			$format = 'xml';
		} else {
			$format = 'csv';
		}
	}
	$root = motor_stock_opt( 'root' );

	if ( 'json' === $format ) {
		$data = json_decode( $body, true );
		if ( null === $data ) {
			return new WP_Error( 'json', 'JSON illisible.' );
		}
		return motor_stock_find_list( $data, $root );
	}

	if ( 'xml' === $format ) {
		libxml_use_internal_errors( true );
		$xml = simplexml_load_string( $body, 'SimpleXMLElement', LIBXML_NOCDATA );
		if ( ! $xml ) {
			return new WP_Error( 'xml', 'XML illisible.' );
		}
		$data = json_decode( wp_json_encode( $xml ), true );
		return motor_stock_find_list( $data, $root );
	}

	// CSV : première ligne = en-têtes ; séparateur ; ou ,
	$lines = preg_split( '/\r\n|\n|\r/', $body );
	$sep   = substr_count( $lines[0], ';' ) >= substr_count( $lines[0], ',' ) ? ';' : ',';
	$head  = array_map( 'trim', str_getcsv( array_shift( $lines ), $sep ) );
	$rows  = array();
	foreach ( $lines as $line ) {
		if ( '' === trim( $line ) ) {
			continue;
		}
		$cells = str_getcsv( $line, $sep );
		if ( count( $cells ) < 2 ) {
			continue;
		}
		$rows[] = array_combine( array_slice( $head, 0, count( $cells ) ), array_slice( $cells, 0, count( $head ) ) );
	}
	return $rows;
}

/** Trouve la liste de véhicules dans une structure décodée (clé donnée ou détection). */
function motor_stock_find_list( $data, $root ) {
	if ( $root ) {
		foreach ( explode( '.', $root ) as $seg ) {
			if ( ! is_array( $data ) || ! isset( $data[ $seg ] ) ) {
				return new WP_Error( 'root', 'Clé « ' . $root . ' » introuvable dans le flux.' );
			}
			$data = $data[ $seg ];
		}
	}
	// Liste directe
	if ( is_array( $data ) && isset( $data[0] ) && is_array( $data[0] ) ) {
		return $data;
	}
	// Objet contenant une liste (vehicules, vehicles, items, data, annonces, stock, ads…)
	if ( is_array( $data ) ) {
		foreach ( array( 'vehicules', 'vehicles', 'vehicule', 'vehicle', 'annonces', 'annonce', 'items', 'data', 'stock', 'ads', 'results', 'list' ) as $k ) {
			if ( isset( $data[ $k ] ) && is_array( $data[ $k ] ) ) {
				$sub = $data[ $k ];
				if ( isset( $sub[0] ) && is_array( $sub[0] ) ) {
					return $sub;
				}
				if ( ! empty( $sub ) && ! isset( $sub[0] ) ) { // XML : un seul élément
					return array( $sub );
				}
			}
		}
		foreach ( $data as $v ) { // première liste trouvée
			if ( is_array( $v ) && isset( $v[0] ) && is_array( $v[0] ) ) {
				return $v;
			}
		}
	}
	return new WP_Error( 'list', 'Impossible de trouver la liste des véhicules ; indiquez la clé du tableau.' );
}

/* ------------------------------------------------------------------
 * Conversion d'une ligne du flux vers le format du site
 * ---------------------------------------------------------------- */
function motor_stock_pick( $row, $keys, $default = '' ) {
	$flat = array();
	foreach ( $row as $k => $v ) {
		$flat[ strtolower( preg_replace( '/[^a-z0-9]/i', '', (string) $k ) ) ] = $v;
	}
	foreach ( $keys as $k ) {
		$k = strtolower( preg_replace( '/[^a-z0-9]/i', '', $k ) );
		if ( isset( $flat[ $k ] ) && '' !== $flat[ $k ] && ! is_array( $flat[ $k ] ) ) {
			return $flat[ $k ];
		}
	}
	return $default;
}

function motor_stock_num( $v ) {
	return (int) round( (float) preg_replace( '/[^0-9.,]/', '', str_replace( ',', '.', (string) $v ) ) );
}

function motor_stock_photos( $row ) {
	$out = array();
	foreach ( array( 'photos', 'images', 'pictures', 'photo', 'image', 'picture', 'urlphotos', 'photosurl', 'medias', 'media' ) as $k ) {
		$v = motor_stock_pick( $row, array( $k ), null );
		if ( null === $v ) {
			foreach ( $row as $rk => $rv ) {
				if ( strtolower( preg_replace( '/[^a-z0-9]/i', '', $rk ) ) === $k ) {
					$v = $rv;
				}
			}
		}
		if ( null === $v ) {
			continue;
		}
		if ( is_string( $v ) ) {
			$v = preg_split( '/[|;\s,]+/', $v );
		}
		if ( is_array( $v ) ) {
			array_walk_recursive( $v, function ( $x ) use ( &$out ) {
				if ( is_string( $x ) && preg_match( '#^https?://#i', $x ) ) {
					$out[] = $x;
				}
			} );
		}
		if ( $out ) {
			break;
		}
	}
	return array_values( array_unique( $out ) );
}

function motor_stock_map( $row, $i ) {
	if ( ! is_array( $row ) ) {
		return null;
	}
	$p = function ( $keys, $d = '' ) use ( $row ) { return motor_stock_pick( $row, $keys, $d ); };

	$marque = $p( array( 'marque', 'brand', 'make', 'constructeur', 'marque_libelle' ) );
	$modele = $p( array( 'modele', 'model', 'modele_libelle' ) );
	if ( ! $marque && ! $modele ) {
		$titre = (string) $p( array( 'titre', 'title', 'libelle', 'name', 'designation' ) );
		if ( $titre ) {
			list( $marque, $modele ) = array_pad( explode( ' ', $titre, 2 ), 2, '' );
		}
	}
	if ( ! $marque && ! $modele ) {
		return null;
	}

	$carb = strtolower( (string) $p( array( 'carburant', 'energie', 'fuel', 'fuel_type', 'motorisation' ) ) );
	$carburant = 'Essence';
	if ( strpos( $carb, 'dies' ) !== false || strpos( $carb, 'gazole' ) !== false ) $carburant = 'Diesel';
	elseif ( strpos( $carb, 'hyb' ) !== false ) $carburant = 'Hybride';
	elseif ( strpos( $carb, 'elec' ) !== false || strpos( $carb, 'électr' ) !== false ) $carburant = 'Électrique';
	elseif ( strpos( $carb, 'gpl' ) !== false ) $carburant = 'GPL';

	$bv    = strtolower( (string) $p( array( 'boite', 'boite_vitesse', 'gearbox', 'transmission', 'bv' ) ) );
	$boite = 'Manuelle';
	foreach ( array( 'auto', 'dsg', 'eat', 'tronic', 'dct', 'cvt', 'bva', 'robot', 'edc', 'powershift', 'steptronic', 'tiptronic', 'multitronic' ) as $needle ) {
		if ( strpos( $bv, $needle ) !== false ) { $boite = 'Automatique'; break; }
	}
	if ( 'a' === $bv || 'bva' === $bv ) { $boite = 'Automatique'; }

	$cat  = strtolower( (string) $p( array( 'carrosserie', 'type', 'categorie', 'category', 'segment', 'body', 'bodytype' ) ) );
	$type = 'Berline';
	foreach ( array( 'citadine' => 'Citadine', 'suv' => 'SUV', '4x4' => 'SUV', 'crossover' => 'SUV', 'break' => 'Break', 'monospace' => 'Monospace', 'utilitaire' => 'Utilitaire', 'fourgon' => 'Utilitaire', 'camionnette' => 'Utilitaire', 'coupe' => 'Berline', 'coupé' => 'Berline', 'cabriolet' => 'Berline', 'berline' => 'Berline' ) as $needle => $label ) {
		if ( strpos( $cat, $needle ) !== false ) { $type = $label; break; }
	}

	$annee = motor_stock_num( $p( array( 'annee', 'year', 'millesime', 'annee_mec', 'mec', 'date_mec', 'first_registration' ) ) );
	if ( $annee > 10000 ) { // date complète → année
		$annee = (int) substr( (string) $p( array( 'annee', 'year', 'millesime', 'annee_mec', 'mec', 'date_mec', 'first_registration' ) ), 0, 4 );
	}
	if ( $annee < 1950 || $annee > (int) gmdate( 'Y' ) + 1 ) {
		preg_match( '/(19|20)\d{2}/', (string) $p( array( 'date_mec', 'mec', 'mise_en_circulation', 'first_registration' ) ), $m );
		$annee = isset( $m[0] ) ? (int) $m[0] : 0;
	}

	$options = array();
	foreach ( $row as $k => $v ) {
		if ( preg_match( '/option|equip|feature/i', (string) $k ) ) {
			$options = is_array( $v ) ? $v : preg_split( '/\r\n|\n|;|\|/', (string) $v );
			break;
		}
	}
	if ( $options && ! isset( $options[0] ) ) { // XML : <equipement> répété ou imbriqué
		$options = array_values( $options );
		if ( isset( $options[0] ) && is_array( $options[0] ) ) { $options = $options[0]; }
	}
	$options = array_values( array_filter( array_map( 'trim', array_map( 'strval', (array) $options ) ) ) );

	$photos = motor_stock_photos( $row );
	$ref    = (string) $p( array( 'reference', 'ref', 'id', 'identifiant', 'immatriculation' ), $i );

	$v = array(
		'id'          => $i,
		'ref'         => $ref,
		'marque'      => trim( (string) $marque ),
		'modele'      => trim( (string) $modele ),
		'version'     => trim( (string) $p( array( 'version', 'finition', 'trim', 'motorisation', 'libelle_version' ) ) ),
		'annee'       => $annee,
		'km'          => motor_stock_num( $p( array( 'kilometrage', 'km', 'mileage', 'kms', 'kilometres' ) ) ),
		'prix'        => motor_stock_num( $p( array( 'prix', 'prix_ttc', 'prix_vente', 'price', 'prix_affiche' ) ) ),
		'carburant'   => $carburant,
		'boite'       => $boite,
		'type'        => $type,
		'places'      => motor_stock_num( $p( array( 'places', 'nb_places', 'seats' ), 5 ) ) ?: 5,
		'tag'         => trim( (string) $p( array( 'tag', 'etiquette', 'label', 'promo' ) ) ),
		'garantie'    => trim( (string) $p( array( 'garantie', 'warranty' ), '12 mois' ) ),
		'description' => wp_strip_all_tags( (string) $p( array( 'description', 'commentaire', 'texte', 'comment', 'annonce' ) ) ),
		'options'     => array_slice( $options, 0, 12 ),
		'photo'       => $photos ? $photos[0] : '',
		'photos'      => array_slice( $photos, 0, 12 ),
		'url'         => (string) $p( array( 'url', 'lien', 'link', 'permalink' ) ),
	);

	/**
	 * Point d'extension : adapter la conversion au format exact de Kepler.
	 * add_filter( 'motor_stock_map', function ( $v, $row ) { …; return $v; }, 10, 2 );
	 */
	return apply_filters( 'motor_stock_map', $v, $row );
}

/* ------------------------------------------------------------------
 * Fusion avec les véhicules saisis dans WordPress
 * ---------------------------------------------------------------- */
add_filter( 'motor_vehicules', function ( $wp_vehicules ) {
	if ( ! motor_stock_opt( 'url' ) ) {
		return $wp_vehicules;
	}
	$flux = get_option( 'motor_stock_vehicules', array() );
	if ( empty( $flux ) ) {
		return $wp_vehicules;
	}
	if ( 'merge' === motor_stock_opt( 'mode' ) ) {
		$n = count( $flux );
		foreach ( $wp_vehicules as &$v ) {
			$v['id'] = ++$n;
		}
		return array_merge( $flux, $wp_vehicules );
	}
	return $flux;
} );

/* ------------------------------------------------------------------
 * Page d'administration : Véhicules → Stock Kepler
 * ---------------------------------------------------------------- */
add_action( 'admin_menu', function () {
	add_submenu_page( 'edit.php?post_type=vehicule', 'Stock Kepler', 'Stock Kepler', 'manage_options', 'motor-stock', 'motor_stock_admin_page' );
} );

add_action( 'admin_post_motor_stock_sync', function () {
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'motor_stock_sync' ) ) {
		wp_die( 'Non autorisé' );
	}
	motor_stock_import();
	wp_safe_redirect( admin_url( 'edit.php?post_type=vehicule&page=motor-stock&synced=1' ) );
	exit;
} );

function motor_stock_admin_page() {
	$status = get_option( 'motor_stock_status', array() );
	$list   = get_option( 'motor_stock_vehicules', array() );
	$url    = motor_stock_opt( 'url' );
	echo '<div class="wrap"><h1>Stock Kepler / flux d\'annonces</h1>';
	if ( ! $url ) {
		echo '<div class="notice notice-warning"><p>Aucun flux configuré. Renseignez l\'adresse du flux dans <a href="' . esc_url( admin_url( 'customize.php?autofocus[section]=motor_stock' ) ) . '">Apparence → Personnaliser → Stock Kepler</a>.</p></div>';
	} else {
		echo '<p><strong>Flux :</strong> <code>' . esc_html( $url ) . '</code></p>';
		if ( $status ) {
			$cls = 'ok' === $status['state'] ? 'notice-success' : 'notice-error';
			echo '<div class="notice ' . $cls . '"><p><strong>' . ( 'ok' === $status['state'] ? 'Dernier import réussi' : 'Erreur' ) . '</strong> — ' . esc_html( $status['message'] ) . ' (' . esc_html( wp_date( 'd/m/Y H:i', $status['time'] ) ) . ')</p></div>';
		}
		$next = wp_next_scheduled( 'motor_stock_sync' );
		echo '<p>Prochaine synchronisation automatique : ' . ( $next ? esc_html( wp_date( 'd/m/Y H:i', $next ) ) : 'non planifiée' ) . '.</p>';
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
		wp_nonce_field( 'motor_stock_sync' );
		echo '<input type="hidden" name="action" value="motor_stock_sync">';
		submit_button( 'Synchroniser maintenant', 'primary', 'submit', false );
		echo '</form>';
	}
	if ( $list ) {
		echo '<h2>' . count( $list ) . ' véhicules dans le flux</h2><table class="widefat striped"><thead><tr><th>Réf.</th><th>Véhicule</th><th>Année</th><th>Km</th><th>Prix</th><th>Photos</th></tr></thead><tbody>';
		foreach ( array_slice( $list, 0, 100 ) as $v ) {
			echo '<tr><td>' . esc_html( $v['ref'] ) . '</td><td>' . esc_html( $v['marque'] . ' ' . $v['modele'] . ' ' . $v['version'] ) . '</td><td>' . esc_html( $v['annee'] ) . '</td><td>' . esc_html( number_format( $v['km'], 0, ',', ' ' ) ) . '</td><td>' . esc_html( number_format( $v['prix'], 0, ',', ' ' ) ) . ' €</td><td>' . count( $v['photos'] ) . '</td></tr>';
		}
		echo '</tbody></table>';
	}
	echo '<h2>Marche à suivre avec Kepler VO</h2><ol>
	<li>Dans Kepler VO, demandez l\'activation de l\'<strong>API véhicule</strong> (ou d\'un export de stock) pour votre site internet : votre conseiller Kepler vous fournit une <strong>adresse</strong> et, le cas échéant, une <strong>clé</strong>.</li>
	<li>Collez-les dans Apparence → Personnaliser → Stock Kepler, puis cliquez « Synchroniser maintenant ».</li>
	<li>Si le tableau ci-dessus reste vide ou incomplet, envoyez un extrait du flux à votre webmaster : la correspondance des champs s\'ajuste en quelques lignes (filtre <code>motor_stock_map</code>).</li>
	</ol></div>';
}
