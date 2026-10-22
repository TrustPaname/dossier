<?php
/**
 * MS MOTORS STUDIO — données structurées Schema.org et balises de référencement.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Description propre à chaque page, pour la balise meta description. */
function msms_meta_description(): string {
	if ( is_front_page() ) {
		return 'Garage automobile à Mainvilliers, près de Chartres : carrosserie et peinture, mécanique et entretien, pare-brise et vitrage, pneumatiques. Devis détaillé, interventions sur rendez-vous.';
	}
	if ( is_page() ) {
		$slug    = get_post_field( 'post_name', get_queried_object_id() );
		$service = msms_service( (string) $slug );
		if ( $service ) {
			return $service['meta_desc'];
		}
		$autres = array(
			'atelier' => 'Un atelier automobile à Mainvilliers, près de Chartres : carrosserie, cabine de peinture, mécanique, vitrage et pneumatiques réunis sous le même toit.',
			'contact' => 'Prenez rendez-vous chez MS MOTORS STUDIO à Mainvilliers : téléphone, adresse, horaires, itinéraire et formulaire de demande de rendez-vous.',
		);
		if ( isset( $autres[ $slug ] ) ) {
			return $autres[ $slug ];
		}
	}
	return '';
}

function msms_afficher_meta(): void {
	$description = msms_meta_description();
	if ( $description ) {
		echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
	}
	echo '<meta property="og:site_name" content="' . esc_attr( msms_get( 'nom' ) ) . '">' . "\n";
	echo '<meta property="og:type" content="website">' . "\n";
	echo '<meta property="og:locale" content="fr_FR">' . "\n";
}
add_action( 'wp_head', 'msms_afficher_meta', 4 );

/** Titre de page adapté aux recherches locales. */
function msms_titre_document( array $parts ): array {
	if ( is_front_page() ) {
		$parts['title'] = msms_get( 'nom' ) . ' — Garage, carrosserie et peinture à Mainvilliers';
		unset( $parts['tagline'] );
		return $parts;
	}
	if ( is_page() ) {
		$slug    = get_post_field( 'post_name', get_queried_object_id() );
		$service = msms_service( (string) $slug );
		if ( $service ) {
			$parts['title'] = $service['meta_titre'];
		}
	}
	return $parts;
}
add_filter( 'document_title_parts', 'msms_titre_document' );

/** JSON-LD AutoRepair sur tout le site + Service et FAQ sur les pages concernées. */
function msms_json_ld(): void {
	$base = home_url( '/' );

	$donnees = array(
		'@context' => 'https://schema.org',
		'@type'    => 'AutoRepair',
		'@id'      => $base . '#atelier',
		'name'     => msms_get( 'nom' ),
		'url'      => $base,
		'telephone' => msms_get( 'telephone_lien' ),
		'email'    => msms_get( 'email' ),
		'address'  => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => msms_get( 'adresse_rue' ),
			'postalCode'      => msms_get( 'adresse_cp' ),
			'addressLocality' => msms_get( 'adresse_ville' ),
			'addressRegion'   => 'Eure-et-Loir',
			'addressCountry'  => 'FR',
		),
		'geo'      => array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => (float) msms_get( 'gps_lat' ),
			'longitude' => (float) msms_get( 'gps_lng' ),
		),
		'openingHoursSpecification' => array(
			array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ),
				'opens'     => '09:00',
				'closes'    => '12:00',
			),
			array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ),
				'opens'     => '13:30',
				'closes'    => '19:00',
			),
		),
		'areaServed' => array_map(
			static fn( $ville ) => array( '@type' => 'City', 'name' => $ville ),
			msms_accueil()['zone_villes']
		),
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $donnees, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";

	// Page de prestation : Service + FAQ.
	if ( is_page() ) {
		$slug    = get_post_field( 'post_name', get_queried_object_id() );
		$service = msms_service( (string) $slug );
		if ( $service ) {
			$service_ld = array(
				'@context'    => 'https://schema.org',
				'@type'       => 'Service',
				'name'        => $service['titre'],
				'serviceType' => $service['titre'],
				'description' => $service['meta_desc'],
				'url'         => get_permalink(),
				'provider'    => array( '@id' => $base . '#atelier' ),
				'areaServed'  => array(
					array( '@type' => 'City', 'name' => 'Mainvilliers' ),
					array( '@type' => 'City', 'name' => 'Chartres' ),
				),
			);
			echo '<script type="application/ld+json">' . wp_json_encode( $service_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";

			$faq_ld = array(
				'@context'   => 'https://schema.org',
				'@type'      => 'FAQPage',
				'mainEntity' => array_map(
					static fn( $item ) => array(
						'@type'          => 'Question',
						'name'           => $item[0],
						'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $item[1] ),
					),
					$service['faq']
				),
			);
			echo '<script type="application/ld+json">' . wp_json_encode( $faq_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
		}
	}
}
add_action( 'wp_head', 'msms_json_ld', 20 );
