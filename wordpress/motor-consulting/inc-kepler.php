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

function motor_kepler_map( $row, $i ) {
	$g = function ( $k, $d = '' ) use ( $row ) { return isset( $row[ $k ] ) ? $row[ $k ] : $d; };

	$state = strtoupper( motor_kepler_name( $g( 'state' ) ) );
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

	// Photos : tableau de Media (url, path, src, thumbnail…) ou chaînes
	$photos = array();
	$gal    = $g( 'gallery', array() );
	if ( is_array( $gal ) ) {
		foreach ( $gal as $m ) {
			if ( is_string( $m ) && preg_match( '#^https?://#', $m ) ) {
				$photos[] = $m;
			} elseif ( is_array( $m ) ) {
				foreach ( array( 'url', 'urlLarge', 'large', 'src', 'path', 'link', 'original', 'urlOriginal', 'thumbnail' ) as $k ) {
					if ( ! empty( $m[ $k ] ) && is_string( $m[ $k ] ) && preg_match( '#^https?://#', $m[ $k ] ) ) {
						$photos[] = $m[ $k ];
						break;
					}
				}
				if ( empty( $photos ) || end( $photos ) === null ) {
					array_walk_recursive( $m, function ( $x ) use ( &$photos ) { if ( is_string( $x ) && preg_match( '#^https?://.*\.(jpe?g|png|webp)#i', $x ) ) { $photos[] = $x; } } );
				}
			}
		}
	}
	$photos = array_values( array_unique( $photos ) );

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
