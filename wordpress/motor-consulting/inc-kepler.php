<?php
/**
 * Motor Consulting — connecteur Kepler VO (API v3.8).
 *
 * Réglages : Apparence → Personnaliser → Stock Kepler / flux d'annonces → « Clé API Kepler VO ».
 * Quand une clé est renseignée, le site :
 *   1. demande un jeton (POST /api/v3.0/auth-token/, apiKey), conservé 25 min ;
 *   2. lit les véhicules (GET /api/v3.8/vehicles/?page=N&count=100, en-tête X-Auth-Token) ;
 *   3. convertit les champs Kepler (brand.name, model.name, priceWeb, gallery…) au format du site.
 * Quota Kepler : 100 appels/heure → import toutes les heures, 2 à 3 appels par import.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MOTOR_KEPLER_BASE', 'https://app.keplervo.com/api/' );

function motor_kepler_key() {
	return trim( (string) get_theme_mod( 'motor_stock_kepler_key', '' ) );
}

/* ------------------------------------------------------------------
 * Réglages supplémentaires dans la section Stock
 * ---------------------------------------------------------------- */
add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_setting( 'motor_stock_kepler_key', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'motor_stock_kepler_key', array(
		'label'       => 'Clé API Kepler VO',
		'description' => 'Collez la clé envoyée par Kepler Solutions. Avec cette clé, les champs « Adresse du flux » et « En-tête » ci-dessous sont inutiles : le site se connecte directement à l\'API Véhicule v3.8.',
		'section'     => 'motor_stock',
		'type'        => 'password',
		'priority'    => 1,
	) );
	$wp_customize->add_setting( 'motor_stock_kepler_states', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'motor_stock_kepler_states', array(
		'label'       => 'Kepler : états de véhicule à afficher (facultatif)',
		'description' => 'Vide = tous les véhicules disponibles à la vente, sauf VENDU et SORTI. Sinon, liste séparée par des virgules, ex. PARC,ARRIVAGE.',
		'section'     => 'motor_stock',
		'type'        => 'text',
		'priority'    => 2,
	) );
}, 20 );

/* ------------------------------------------------------------------
 * Jeton
 * ---------------------------------------------------------------- */
function motor_kepler_token( $force = false ) {
	$key = motor_kepler_key();
	if ( ! $key ) {
		return new WP_Error( 'no_key', 'Aucune clé API Kepler renseignée.' );
	}
	$cache_id = 'motor_kepler_token_' . md5( $key );
	if ( ! $force ) {
		$t = get_transient( $cache_id );
		if ( $t ) {
			return $t;
		}
	}
	$url  = MOTOR_KEPLER_BASE . 'v3.0/auth-token/';
	$args = array( 'timeout' => 20, 'headers' => array( 'Accept' => 'application/json' ) );
	// Essai 1 : formulaire ; essai 2 : JSON.
	$res = wp_remote_post( $url, $args + array( 'body' => array( 'apiKey' => $key ) ) );
	$ok  = ! is_wp_error( $res ) && 200 === (int) wp_remote_retrieve_response_code( $res );
	if ( ! $ok ) {
		$res = wp_remote_post( $url, $args + array( 'headers' => array( 'Accept' => 'application/json', 'Content-Type' => 'application/json' ), 'body' => wp_json_encode( array( 'apiKey' => $key ) ) ) );
	}
	if ( is_wp_error( $res ) ) {
		return $res;
	}
	$code = (int) wp_remote_retrieve_response_code( $res );
	$body = json_decode( wp_remote_retrieve_body( $res ), true );
	if ( 200 !== $code || ! is_array( $body ) ) {
		return new WP_Error( 'token', 'Kepler a refusé la clé (réponse HTTP ' . $code . ' : ' . mb_substr( wp_strip_all_tags( (string) wp_remote_retrieve_body( $res ) ), 0, 160 ) . ').' );
	}
	$token = isset( $body['value'] ) ? $body['value'] : ( isset( $body['token'] ) ? $body['token'] : '' );
	if ( ! $token ) {
		return new WP_Error( 'token', 'Réponse du jeton inattendue : ' . mb_substr( wp_json_encode( $body ), 0, 160 ) );
	}
	set_transient( $cache_id, $token, 25 * MINUTE_IN_SECONDS );
	return $token;
}

/* ------------------------------------------------------------------
 * Lecture des véhicules (toutes les pages)
 * ---------------------------------------------------------------- */
function motor_kepler_fetch() {
	$token = motor_kepler_token();
	if ( is_wp_error( $token ) ) {
		return $token;
	}
	$rows = array();
	for ( $page = 1; $page <= 20; $page++ ) {
		$url  = add_query_arg( array( 'page' => $page, 'count' => 100, 'isNotAvailableForSelling' => 'false' ), MOTOR_KEPLER_BASE . 'v3.8/vehicles/' );
		$args = array( 'timeout' => 30, 'headers' => array( 'Accept' => 'application/json', 'X-Auth-Token' => $token ) );
		$res  = wp_remote_get( $url, $args );
		if ( is_wp_error( $res ) ) {
			return $res;
		}
		$code = (int) wp_remote_retrieve_response_code( $res );
		if ( 401 === $code || 403 === $code ) { // jeton expiré : on en redemande un, une fois
			$token = motor_kepler_token( true );
			if ( is_wp_error( $token ) ) {
				return $token;
			}
			$args['headers']['X-Auth-Token'] = $token;
			$res  = wp_remote_get( $url, $args );
			if ( is_wp_error( $res ) ) {
				return $res;
			}
			$code = (int) wp_remote_retrieve_response_code( $res );
		}
		if ( 429 === $code ) {
			return new WP_Error( 'quota', 'Quota Kepler dépassé (100 appels/heure). Réessayez dans une heure.' );
		}
		$body = json_decode( wp_remote_retrieve_body( $res ), true );
		if ( 200 !== $code || null === $body ) {
			return new WP_Error( 'http', 'Kepler : réponse HTTP ' . $code . ' sur la page ' . $page . ' : ' . mb_substr( wp_strip_all_tags( (string) wp_remote_retrieve_body( $res ) ), 0, 160 ) );
		}
		// Réponse Kepler v3.8 : { totalResult, nbPageList, array: [ véhicules ] }
		$list = null;
		foreach ( array( 'array', 'vehicles', 'results', 'data', 'items' ) as $k ) {
			if ( isset( $body[ $k ] ) && is_array( $body[ $k ] ) ) {
				$list = $body[ $k ];
				break;
			}
		}
		if ( null === $list ) {
			$list = motor_stock_find_list( $body, '' );
		}
		if ( is_array( $list ) && empty( $list ) ) {
			break;
		}
		if ( is_wp_error( $list ) ) {
			if ( $page > 1 ) {
				break;
			}
			return new WP_Error( 'list', 'Kepler : liste de véhicules introuvable dans la réponse. Début : ' . mb_substr( wp_json_encode( $body ), 0, 200 ) );
		}
		$rows = array_merge( $rows, $list );
		$total   = isset( $body['totalResult'] ) ? (int) $body['totalResult'] : 0;
		$perpage = isset( $body['nbPageList'] ) ? (int) $body['nbPageList'] : 100;
		if ( count( $list ) < max( 1, $perpage ) || ( $total && count( $rows ) >= $total ) ) {
			break;
		}
	}
	return $rows;
}

/* ------------------------------------------------------------------
 * Conversion Kepler → format du site
 * ---------------------------------------------------------------- */
function motor_kepler_name( $v ) {
	if ( is_array( $v ) ) {
		foreach ( array( 'name', 'label', 'libelle', 'value' ) as $k ) {
			if ( isset( $v[ $k ] ) && is_scalar( $v[ $k ] ) ) {
				return trim( (string) $v[ $k ] );
			}
		}
		return '';
	}
	return is_scalar( $v ) ? trim( (string) $v ) : '';
}

/**
 * Normalise l'état Kepler : « vehicle.state.on_arrival » → ARRIVAGE, « vehicle.state.sold » → VENDU…
 */
function motor_kepler_state( $raw ) {
	$raw = strtolower( trim( (string) $raw ) );
	if ( '' === $raw ) {
		return '';
	}
	$last = substr( $raw, strrpos( $raw, '.' ) !== false ? strrpos( $raw, '.' ) + 1 : 0 );
	$map  = array(
		'on_arrival' => 'ARRIVAGE', 'arrival' => 'ARRIVAGE', 'arrivage' => 'ARRIVAGE',
		'in_stock' => 'PARC', 'stock' => 'PARC', 'parc' => 'PARC', 'park' => 'PARC', 'available' => 'PARC',
		'sold' => 'VENDU', 'vendu' => 'VENDU',
		'out' => 'SORTI', 'exit' => 'SORTI', 'exited' => 'SORTI', 'released' => 'SORTI', 'sorti' => 'SORTI', 'delivered' => 'SORTI', 'livre' => 'SORTI', 'livré' => 'SORTI',
		'reserved' => 'RESERVE', 'reserve' => 'RESERVE', 'réservé' => 'RESERVE', 'booked' => 'RESERVE',
		'archived' => 'ARCHIVE', 'archive' => 'ARCHIVE', 'deleted' => 'SUPPRIME', 'removed' => 'SUPPRIME',
	);
	return isset( $map[ $last ] ) ? $map[ $last ] : strtoupper( $last );
}

function motor_kepler_map( $row, $i ) {
	$g = function ( $k, $d = '' ) use ( $row ) { return isset( $row[ $k ] ) ? $row[ $k ] : $d; };

	$state = motor_kepler_state( motor_kepler_name( $g( 'state' ) ) );
	$allowed = array_filter( array_map( 'trim', explode( ',', strtoupper( (string) get_theme_mod( 'motor_stock_kepler_states', '' ) ) ) ) );
	if ( $allowed ) {
		if ( $state && ! in_array( $state, $allowed, true ) ) {
			return null;
		}
	} elseif ( in_array( $state, array( 'VENDU', 'SORTI', 'SOLD', 'ARCHIVE', 'ARCHIVÉ', 'SUPPRIME', 'SUPPRIMÉ' ), true ) ) {
		return null;
	}
	if ( ! empty( $row['isNotAvailableForSelling'] ) && filter_var( $row['isNotAvailableForSelling'], FILTER_VALIDATE_BOOLEAN ) ) {
		return null;
	}

	$marque  = motor_kepler_name( $g( 'brand' ) );
	$modele  = motor_kepler_name( $g( 'model' ) );
	$version = motor_kepler_name( $g( 'version' ) );
	if ( ! $marque && ! $modele ) {
		return null;
	}

	// Prix TTC : promo web > promo > public > négociant
	$prix = 0;
	foreach ( array( 'priceWeb', 'promotionalPrice', 'priceSpecial', 'pricePublic', 'priceSeller' ) as $k ) {
		$val = (float) str_replace( array( ' ', ',' ), array( '', '.' ), (string) $g( $k, 0 ) );
		if ( $val > 0 ) {
			$prix = (int) round( $val );
			break;
		}
	}
	$tag = '';
	$pub = (float) $g( 'pricePublic', 0 );
	if ( $pub > 0 && $prix > 0 && $prix < $pub ) {
		$tag = 'Promo';
	}

	$energy    = strtolower( motor_kepler_name( $g( 'energy' ) ) );
	$carburant = 'Essence';
	if ( strpos( $energy, 'diesel' ) !== false || strpos( $energy, 'gazole' ) !== false ) {
		$carburant = strpos( $energy, 'lectrique' ) !== false ? 'Hybride' : 'Diesel';
	} elseif ( strpos( $energy, 'courant électrique' ) === 0 || 'electric' === $energy ) {
		$carburant = 'Électrique';
	} elseif ( strpos( $energy, 'elec' ) !== false || strpos( $energy, 'hybr' ) !== false ) {
		$carburant = 'Hybride';
	} elseif ( strpos( $energy, 'g.p.l' ) !== false || strpos( $energy, 'gpl' ) !== false || strpos( $energy, 'gaz' ) !== false || strpos( $energy, 'gnv' ) !== false ) {
		$carburant = 'GPL';
	} elseif ( strpos( $energy, 'hydro' ) !== false ) {
		$carburant = 'Électrique';
	}

	$gear  = strtolower( motor_kepler_name( $g( 'gearbox' ) ) );
	$boite = ( strpos( $gear, 'manuelle' ) !== false || strpos( $gear, 'mecanique' ) !== false || strpos( $gear, 'mécanique' ) !== false || strpos( $gear, 'b.v.m' ) !== false ) ? 'Manuelle' : ( $gear ? 'Automatique' : 'Manuelle' );

	$seg  = strtolower( motor_kepler_name( $g( 'segment' ) ) . ' ' . motor_kepler_name( $g( 'bodywork' ) ) . ' ' . motor_kepler_name( $g( 'vehicleType' ) ) );
	$type = 'Berline';
	foreach ( array( 'citadine' => 'Citadine', 'suv' => 'SUV', '4x4' => 'SUV', 'crossover' => 'SUV', 'tout-terrain' => 'SUV', 'tout terrain' => 'SUV', 'break' => 'Break', 'monospace' => 'Monospace', 'ludospace' => 'Monospace', 'combispace' => 'Monospace', 'utilitaire' => 'Utilitaire', 'fourgon' => 'Utilitaire', 'camionnette' => 'Utilitaire', 'pick-up' => 'Utilitaire', ' vu' => 'Utilitaire', 'coup' => 'Berline', 'cabriolet' => 'Berline', 'berline' => 'Berline' ) as $needle => $label ) {
		if ( strpos( $seg, $needle ) !== false ) { $type = $label; break; }
	}

	$annee = (int) $g( 'year', 0 );
	if ( $annee < 1950 ) {
		preg_match( '/(19|20)\d{2}/', (string) $g( 'dateOfDistribution', '' ), $m );
		$annee = isset( $m[0] ) ? (int) $m[0] : 0;
	}

	// Photos : tableau de Media Kepler v3.8 { photo (S3, publique), large/big/thumb (API, réservées à l'admin), position, category }
	$photos = array();
	$gal    = $g( 'gallery', array() );
	if ( is_array( $gal ) ) {
		// Catégorie « Commerciales » en priorité, puis ordre de position
		$items = array();
		foreach ( $gal as $m ) {
			if ( is_string( $m ) && preg_match( '#^https?://#', $m ) ) {
				$items[] = array( 'cands' => array( $m ), 'pos' => count( $items ), 'com' => 1 );
			} elseif ( is_array( $m ) ) {
				$cands = array();
				foreach ( array( 'photo', 'url', 'original', 'urlOriginal', 'large', 'urlLarge', 'big', 'src', 'path', 'link', 'thumbnail', 'thumb' ) as $k ) {
					if ( ! empty( $m[ $k ] ) && is_string( $m[ $k ] ) && preg_match( '#^https?://#', $m[ $k ] ) ) {
						$cands[] = $m[ $k ];
					}
				}
				if ( ! $cands ) {
					array_walk_recursive( $m, function ( $x ) use ( &$cands ) { if ( is_string( $x ) && preg_match( '#^https?://#', $x ) ) { $cands[] = $x; } } );
				}
				if ( $cands ) {
					$cat     = isset( $m['category'] ) ? strtolower( (string) $m['category'] ) : '';
					$items[] = array(
						'cands' => array_values( array_unique( $cands ) ),
						'pos'   => isset( $m['position'] ) ? (int) $m['position'] : count( $items ),
						'com'   => ( '' === $cat || false !== strpos( $cat, 'commercial' ) ) ? 1 : 0,
					);
				}
			}
		}
		usort( $items, function ( $a, $b ) { return ( $b['com'] - $a['com'] ) ?: ( $a['pos'] - $b['pos'] ); } );
		if ( array_sum( array_column( $items, 'com' ) ) > 0 ) {
			$items = array_filter( $items, function ( $x ) { return $x['com']; } );
		}
		foreach ( $items as $it ) {
			$photos[] = $it['cands'];
		}
	}
	$photos = motor_kepler_local_photos( array_slice( $photos, 0, 12 ) );

	// Description : note site web > note publique > note
	$desc  = '';
	$notes = $g( 'notes', array() );
	if ( is_array( $notes ) ) {
		foreach ( array( 'website', 'public' ) as $k ) {
			if ( ! empty( $notes[ $k ] ) && is_string( $notes[ $k ] ) ) { $desc = $notes[ $k ]; break; }
		}
	}
	if ( ! $desc && is_string( $g( 'note', '' ) ) ) {
		$desc = (string) $g( 'note', '' );
	}

	$options = array();
	// Kepler v3.8 : equipmentStandard / equipmentOptional (tableaux d'Equipement {name}).
	foreach ( array( 'equipmentOptional', 'equipmentStandard', 'options', 'equipments', 'equipements', 'features' ) as $k ) {
		$o = $g( $k, null );
		if ( is_array( $o ) ) {
			foreach ( $o as $x ) { $n = motor_kepler_name( $x ); if ( $n ) { $options[] = $n; } }
		}
	}
	// additionalEquipments : texte libre, séparé par virgules / retours à la ligne.
	$add = $g( 'additionalEquipments', '' );
	if ( is_string( $add ) && trim( $add ) ) {
		foreach ( preg_split( '/[\n,;]+/', $add ) as $x ) { $x = trim( $x ); if ( $x ) { $options[] = $x; } }
	}
	$options = array_values( array_unique( $options ) );
	$extras = array();
	if ( (int) $g( 'horsePower', 0 ) > 0 ) { $extras[] = (int) $g( 'horsePower' ) . ' ch'; }
	if ( (int) $g( 'taxHorsepower', 0 ) > 0 ) { $extras[] = (int) $g( 'taxHorsepower' ) . ' CV fiscaux'; }
	if ( (int) $g( 'doors', 0 ) > 0 ) { $extras[] = (int) $g( 'doors' ) . ' portes'; }
	$couleur = motor_kepler_name( $g( 'color' ) );
	if ( $couleur && 'inconnu' !== strtolower( $couleur ) ) { $extras[] = 'Couleur ' . $couleur; }
	if ( ! empty( $row['firstHand'] ) && filter_var( $row['firstHand'], FILTER_VALIDATE_BOOLEAN ) ) { $extras[] = 'Première main'; }
	$options = array_merge( $options, $extras );

	$garantie = '12 mois';
	if ( (int) $g( 'warrantyDuration', 0 ) > 0 ) {
		$garantie = (int) $g( 'warrantyDuration' ) . ' mois';
	} elseif ( motor_kepler_name( $g( 'warrantyLabel' ) ) ) {
		$garantie = motor_kepler_name( $g( 'warrantyLabel' ) );
	}

	return array(
		'id'          => $i,
		'ref'         => (string) ( $g( 'reference' ) ?: $g( 'internalReference' ) ?: $g( 'vo' ) ?: $g( 'uuid' ) ?: $i ),
		'marque'      => $marque,
		'modele'      => $modele,
		'version'     => $version,
		'annee'       => $annee,
		'km'          => (int) $g( 'distanceTraveled', 0 ),
		'prix'        => $prix,
		'carburant'   => $carburant,
		'boite'       => $boite,
		'type'        => $type,
		'places'      => (int) $g( 'seats', 5 ) ?: 5,
		'tag'         => $tag,
		'garantie'    => $garantie,
		'description' => wp_strip_all_tags( $desc ),
		'options'     => array_slice( $options, 0, 12 ),
		'photo'       => $photos ? $photos[0] : '',
		'photos'      => array_slice( $photos, 0, 12 ),
		'url'         => '',
	);
}

/* ------------------------------------------------------------------
 * Copie locale des photos
 * Les visuels Kepler peuvent exiger le jeton ou refuser l'affichage depuis
 * un autre site : on les recopie une fois dans wp-content/uploads/kepler/.
 * ---------------------------------------------------------------- */
function motor_kepler_local_photos( $urls ) {
	if ( empty( $urls ) ) {
		return array();
	}
	$up = wp_upload_dir();
	if ( ! empty( $up['error'] ) ) {
		return $urls;
	}
	$dir  = trailingslashit( $up['basedir'] ) . 'kepler';
	$base = trailingslashit( $up['baseurl'] ) . 'kepler';
	if ( ! is_dir( $dir ) ) {
		wp_mkdir_p( $dir );
	}
	$index = get_option( 'motor_kepler_media', array() );
	if ( ! is_array( $index ) ) {
		$index = array();
	}
	$out     = array();
	$changed = false;
	foreach ( $urls as $item ) {
		$cands = array_values( array_filter( (array) $item, 'is_string' ) );
		if ( ! $cands ) {
			continue;
		}
		// Adresse de secours si la copie échoue : une adresse publique (pas « context=admin »)
		$public = $cands[0];
		foreach ( $cands as $c ) {
			if ( false === strpos( $c, 'context=admin' ) ) { $public = $c; break; }
		}
		$key = md5( $cands[0] );
		if ( isset( $index[ $key ] ) && file_exists( $dir . '/' . $index[ $key ] ) ) {
			$out[] = $base . '/' . $index[ $key ];
			continue;
		}
		$img = null;
		foreach ( $cands as $c ) {
			$try = motor_kepler_download_image( $c );
			if ( ! is_wp_error( $try ) ) { $img = $try; break; }
		}
		if ( ! $img ) {
			$out[] = $public;
			continue;
		}
		$file = $key . '.' . $img['ext'];
		if ( false === file_put_contents( $dir . '/' . $file, $img['body'] ) ) {
			$out[] = $public;
			continue;
		}
		motor_kepler_shrink( $dir . '/' . $file );
		$index[ $key ] = $file;
		$changed       = true;
		$out[]         = $base . '/' . $file;
	}
	if ( $changed ) {
		update_option( 'motor_kepler_media', $index, false );
	}
	return $out;
}

/**
 * Télécharge une image Kepler (jeton envoyé si l'adresse est chez Kepler).
 * Si l'adresse renvoie du JSON décrivant le média, suit l'adresse ou le contenu base64 qu'il contient.
 * Retourne array( body, ext, type, code, url ) ou WP_Error avec le diagnostic.
 */
function motor_kepler_download_image( $url, $depth = 0 ) {
	$headers = array( 'Accept' => 'image/*,*/*' );
	if ( false !== strpos( $url, 'keplervo.com' ) || false !== strpos( $url, 'kepler-soft' ) || false !== strpos( $url, 'kepler' ) ) {
		$token = motor_kepler_token();
		if ( ! is_wp_error( $token ) ) {
			$headers['X-Auth-Token'] = $token;
		}
	}
	$res = wp_remote_get( $url, array( 'timeout' => 20, 'headers' => $headers ) );
	if ( is_wp_error( $res ) ) {
		return new WP_Error( 'http', 'Erreur réseau : ' . $res->get_error_message() );
	}
	$code = (int) wp_remote_retrieve_response_code( $res );
	$body = (string) wp_remote_retrieve_body( $res );
	$type = (string) wp_remote_retrieve_header( $res, 'content-type' );
	if ( 200 !== $code ) {
		return new WP_Error( 'http', 'HTTP ' . $code . ' (' . $type . ') : ' . mb_substr( wp_strip_all_tags( $body ), 0, 200 ) );
	}
	$ext = '';
	if ( preg_match( '#image/(jpe?g|png|webp|gif)#i', $type, $m ) ) {
		$ext = 'jpeg' === strtolower( $m[1] ) ? 'jpg' : strtolower( $m[1] );
	} elseif ( strlen( $body ) > 4 && "\xFF\xD8\xFF" === substr( $body, 0, 3 ) ) {
		$ext = 'jpg';
	} elseif ( strlen( $body ) > 8 && "\x89PNG" === substr( $body, 0, 4 ) ) {
		$ext = 'png';
	} elseif ( strlen( $body ) > 12 && 'RIFF' === substr( $body, 0, 4 ) && 'WEBP' === substr( $body, 8, 4 ) ) {
		$ext = 'webp';
	} elseif ( preg_match( '#\.(jpe?g|png|webp|gif)(\?|$)#i', $url, $m ) && strlen( $body ) > 1000 && false === stripos( $type, 'json' ) && false === stripos( $type, 'html' ) ) {
		$ext = strtolower( $m[1] );
	}
	if ( $ext ) {
		return array( 'body' => $body, 'ext' => $ext, 'type' => $type, 'code' => $code, 'url' => $url );
	}
	// Réponse JSON : l'adresse décrit peut-être le média (adresse réelle ou contenu encodé)
	$json = json_decode( $body, true );
	if ( is_array( $json ) && $depth < 2 ) {
		$found = '';
		array_walk_recursive( $json, function ( $x, $k ) use ( &$found ) {
			if ( ! $found && is_string( $x ) && preg_match( '#^https?://#', $x ) && in_array( strtolower( (string) $k ), array( 'url', 'link', 'href', 'src', 'path', 'content', 'file', 'download', 'downloadurl', 'original', 'large' ), true ) ) {
				$found = $x;
			}
		} );
		if ( ! $found ) {
			array_walk_recursive( $json, function ( $x ) use ( &$found ) {
				if ( ! $found && is_string( $x ) && preg_match( '#^https?://.*\.(jpe?g|png|webp)#i', $x ) ) {
					$found = $x;
				}
			} );
		}
		if ( $found && $found !== $url ) {
			return motor_kepler_download_image( $found, $depth + 1 );
		}
		foreach ( array( 'content', 'data', 'base64', 'file' ) as $k ) {
			if ( ! empty( $json[ $k ] ) && is_string( $json[ $k ] ) && strlen( $json[ $k ] ) > 1000 ) {
				$raw = base64_decode( preg_replace( '#^data:[^,]+,#', '', $json[ $k ] ), true );
				if ( $raw && "\xFF\xD8\xFF" === substr( $raw, 0, 3 ) ) {
					return array( 'body' => $raw, 'ext' => 'jpg', 'type' => 'base64', 'code' => $code, 'url' => $url );
				}
				if ( $raw && "\x89PNG" === substr( $raw, 0, 4 ) ) {
					return array( 'body' => $raw, 'ext' => 'png', 'type' => 'base64', 'code' => $code, 'url' => $url );
				}
			}
		}
	}
	return new WP_Error( 'notimage', 'HTTP ' . $code . ' mais pas une image (' . ( $type ? $type : 'type inconnu' ) . ', ' . strlen( $body ) . ' octets) : ' . mb_substr( wp_strip_all_tags( $body ), 0, 200 ) );
}

/**
 * Bloc de diagnostic des photos pour la page Véhicules → Stock Kepler.
 */
function motor_kepler_photo_diagnostic( $sample ) {
	if ( ! is_array( $sample ) ) {
		return;
	}
	echo '<h2>Photos du premier véhicule (diagnostic)</h2>';
	$gal = null;
	foreach ( array( 'gallery', 'photos', 'medias', 'media', 'images', 'pictures' ) as $k ) {
		if ( isset( $sample[ $k ] ) ) {
			$gal = $sample[ $k ];
			echo '<p><strong>Champ « ' . esc_html( $k ) . ' »</strong> (' . ( is_array( $gal ) ? count( $gal ) . ' éléments' : gettype( $gal ) ) . '). Premier élément :</p>';
			echo '<pre style="max-height:220px;overflow:auto;background:#fff;border:1px solid #ccd0d4;padding:12px">' . esc_html( wp_json_encode( is_array( $gal ) ? reset( $gal ) : $gal, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) ) . '</pre>';
			break;
		}
	}
	if ( null === $gal ) {
		echo '<p>Aucun champ gallery / photos / medias dans le véhicule reçu. Clés présentes : <code>' . esc_html( implode( ', ', array_keys( $sample ) ) ) . '</code></p>';
		return;
	}
	$v = motor_kepler_map( $sample, 1 );
	$first = ( $v && ! empty( $v['photos'] ) ) ? $v['photos'][0] : '';
	if ( ! $first ) {
		echo '<p>Aucune adresse d\'image reconnue dans ce champ.</p>';
		return;
	}
	echo '<p><strong>Adresse utilisée sur le site :</strong> <code>' . esc_html( $first ) . '</code></p>';
	// Test de téléchargement de l'adresse d'origine (avant copie locale)
	$orig = '';
	if ( is_array( $gal ) ) {
		$first_m = reset( $gal );
		if ( is_array( $first_m ) ) {
			foreach ( array( 'photo', 'url', 'original', 'large', 'big', 'thumb' ) as $k ) {
				if ( ! empty( $first_m[ $k ] ) && is_string( $first_m[ $k ] ) && preg_match( '#^https?://#', $first_m[ $k ] ) ) { $orig = $first_m[ $k ]; break; }
			}
		}
		if ( ! $orig ) {
			array_walk_recursive( $gal, function ( $x ) use ( &$orig ) { if ( ! $orig && is_string( $x ) && preg_match( '#^https?://#', $x ) ) { $orig = $x; } } );
		}
	}
	$up = wp_upload_dir();
	$kd = trailingslashit( $up['basedir'] ) . 'kepler';
	echo '<p><strong>Dossier des copies locales :</strong> <code>' . esc_html( $kd ) . '</code> — ' . ( is_dir( $kd ) ? ( wp_is_writable( $kd ) ? 'existe, accessible en écriture, ' . count( glob( $kd . '/*' ) ) . ' fichier(s)' : 'existe mais <strong>non accessible en écriture</strong>' ) : '<strong>absent</strong> (création impossible ?)' ) . '</p>';
	if ( $orig ) {
		$t = motor_kepler_download_image( $orig );
		if ( is_wp_error( $t ) ) {
			echo '<div class="notice notice-error inline"><p><strong>Test de téléchargement de la photo d\'origine :</strong> ' . esc_html( $t->get_error_message() ) . '<br><code>' . esc_html( $orig ) . '</code></p></div>';
		} else {
			echo '<div class="notice notice-success inline"><p><strong>Test de téléchargement :</strong> image ' . esc_html( $t['ext'] ) . ' de ' . esc_html( number_format( strlen( $t['body'] ) / 1024, 0, ',', ' ' ) ) . ' Ko reçue (' . esc_html( $t['type'] ) . ').</p></div>';
		}
	}
}

/**
 * Réduit une photo trop lourde à 1600 px de large maximum (qualité 82).
 */
function motor_kepler_shrink( $path ) {
	if ( ! function_exists( 'wp_get_image_editor' ) || filesize( $path ) < 400 * 1024 ) {
		return;
	}
	$ed = wp_get_image_editor( $path );
	if ( is_wp_error( $ed ) ) {
		return;
	}
	$size = $ed->get_size();
	if ( empty( $size['width'] ) || $size['width'] <= 1600 ) {
		if ( method_exists( $ed, 'set_quality' ) ) { $ed->set_quality( 82 ); $ed->save( $path ); }
		return;
	}
	$ed->resize( 1600, null, false );
	if ( method_exists( $ed, 'set_quality' ) ) { $ed->set_quality( 82 ); }
	$ed->save( $path );
}
