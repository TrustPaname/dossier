<?php
/**
 * MS MOTORS STUDIO — configuration par défaut du thème.
 *
 * Toutes les informations du garage sont réunies ici. Chaque valeur peut
 * ensuite être modifiée sans toucher au code depuis l'administration :
 * Apparence → Personnaliser → Coordonnées du garage.
 *
 * Les valeurs marquées « À REMPLACER » sont provisoires (reprises des flyers).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function msms_defaults(): array {
	return array(
		// Identité.
		'nom'            => 'MS MOTORS STUDIO',
		'slogan'         => 'Carrosserie · Mécanique · Vitrage · Pneumatiques',

		// Adresse.
		'adresse_rue'    => '3 rue Florence Arthaud',
		'adresse_cp'     => '28310',
		'adresse_ville'  => 'Mainvilliers',
		'gps_lat'        => '48.4497',
		'gps_lng'        => '1.4595',

		// Contact — À REMPLACER : numéro provisoire repris des flyers.
		'telephone'      => '01 00 00 00 00',
		'telephone_lien' => '+33100000000',
		// Adresse du domaine, à créer chez OVH (voir GUIDE-OVH.md, étape 7).
		'email'          => 'contact@motors-studio.fr',

		// Horaires.
		'horaires_jours' => 'Du lundi au samedi',
		'horaires_matin' => '9h00 – 12h00',
		'horaires_aprem' => '13h30 – 19h00',
		'horaires_ferme' => 'Fermé le dimanche',

		// Réseaux sociaux (laisser vide pour masquer).
		'instagram'      => '',
		'facebook'       => '',

		// Offre d'ouverture. Le bandeau disparaît seul après la date de fin.
		'promo_active'   => '1',
		'promo_titre'    => 'Ouverture le 5 octobre 2026',
		'promo_offre'    => '-50 % sur toutes vos prestations',
		'promo_detail'   => 'Pour tout rendez-vous pris avant le 19 octobre 2026.',
		'promo_legal'    => 'Voir conditions à l’atelier.',
		'promo_fin'      => '2026-10-19',

		// Flyers d'ouverture affichés en carrousel sur la page d'accueil.
		// Se téléversent depuis Apparence → Personnaliser → Flyers d'ouverture.
		// Tant qu'aucun n'est fourni, la carte d'informations habituelle
		// reste affichée à leur place.
		'flyer_1'        => '',
		'flyer_2'        => '',
		'flyer_3'        => '',
		'flyer_4'        => '',
		'flyers_duree'   => '5', // secondes par flyer

		// Vidéo d'arrière-plan de l'accueil.
		// « 1 » = active. Laisser les URL vides pour utiliser la vidéo
		// d'ambiance fournie avec le thème ; les remplir pour afficher vos
		// propres fichiers (URL de la médiathèque WordPress).
		'video_active'   => '1',
		'video_webm'     => '',
		'video_mp4'      => '',

		// Options de prestations : « 1 » = proposée, « 0 » = masquée du site.
		'opt_assurance'  => '1', // Prise en charge assurance et expertise.
		'opt_adas'       => '0', // Recalibrage des caméras et radars (ADAS).
		'opt_stockage'   => '1', // Stockage des pneus entre deux saisons.
	);
}

/** Lit une valeur : réglage du personnalisateur, sinon valeur par défaut. */
function msms_get( string $key ): string {
	$defaults = msms_defaults();
	$value    = get_theme_mod( 'msms_' . $key, $defaults[ $key ] ?? '' );
	return is_string( $value ) ? $value : (string) $value;
}

/** Adresse complète sur une ligne. */
function msms_adresse(): string {
	return msms_get( 'adresse_rue' ) . ', ' . msms_get( 'adresse_cp' ) . ' ' . msms_get( 'adresse_ville' );
}

/** Lien d'itinéraire Google Maps. */
function msms_itineraire_url(): string {
	return 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode( msms_get( 'nom' ) . ', ' . msms_adresse() );
}

/** URL de la carte OpenStreetMap intégrée (sans cookie tiers). */
function msms_carte_url(): string {
	$lat = (float) msms_get( 'gps_lat' );
	$lng = (float) msms_get( 'gps_lng' );
	$d   = 0.008;
	$bbox = implode( '%2C', array( $lng - $d, $lat - $d / 2, $lng + $d, $lat + $d / 2 ) );
	return 'https://www.openstreetmap.org/export/embed.html?bbox=' . $bbox . '&layer=mapnik&marker=' . $lat . '%2C' . $lng;
}

/** L'offre d'ouverture doit-elle encore s'afficher ? */
function msms_promo_active(): bool {
	if ( '1' !== msms_get( 'promo_active' ) ) {
		return false;
	}
	$fin = msms_get( 'promo_fin' );
	if ( '' === $fin ) {
		return true;
	}
	return current_time( 'Y-m-d' ) <= $fin;
}

/**
 * Flyers d'ouverture à faire défiler sur la page d'accueil.
 * Retourne les URL réellement renseignées, dans l'ordre.
 */
function msms_flyers(): array {
	$flyers = array();
	for ( $i = 1; $i <= 4; $i++ ) {
		$url = msms_get( 'flyer_' . $i );
		if ( '' !== $url ) {
			$flyers[] = $url;
		}
	}
	return $flyers;
}

/**
 * Sources de la vidéo d'arrière-plan de la page d'accueil.
 *
 * Par défaut, le thème utilise la vidéo d'ambiance fournie
 * (assets/video/hero.webm : balayage de lumière dorée, en boucle).
 * Pour la remplacer par une vraie vidéo de l'atelier : téléversez vos
 * fichiers dans Médias, copiez leur URL et collez-la dans
 * Apparence → Personnaliser → Vidéo d'accueil.
 */
function msms_video_sources(): array {
	if ( '1' !== msms_get( 'video_active' ) ) {
		return array();
	}

	$sources = array();
	$mp4     = msms_get( 'video_mp4' );
	$webm    = msms_get( 'video_webm' );

	if ( $webm ) {
		$sources[] = array( $webm, 'video/webm' );
	}
	if ( $mp4 ) {
		$sources[] = array( $mp4, 'video/mp4' );
	}
	if ( ! $sources && file_exists( get_theme_file_path( 'assets/video/hero.webm' ) ) ) {
		$sources[] = array( get_theme_file_uri( 'assets/video/hero.webm' ), 'video/webm' );
	}

	return $sources;
}
