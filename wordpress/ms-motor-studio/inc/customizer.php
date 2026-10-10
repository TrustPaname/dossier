<?php
/**
 * MS MOTORS STUDIO — réglages dans Apparence → Personnaliser.
 * Toutes les coordonnées du garage sont modifiables sans toucher au code.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function msms_customize_register( WP_Customize_Manager $wp ): void {
	$defaults = msms_defaults();

	$sections = array(
		'msms_coordonnees' => array(
			'titre'  => 'Coordonnées du garage',
			'champs' => array(
				'nom'            => 'Nom du garage',
				'telephone'      => 'Téléphone affiché (ex. 01 00 00 00 00)',
				'telephone_lien' => 'Téléphone au format international (ex. +33100000000)',
				'email'          => 'Adresse e-mail (reçoit les demandes du formulaire)',
				'whatsapp'       => 'Numéro WhatsApp, format international sans + (ex. 33612345678 ; vide = téléphone)',
				'adresse_rue'    => 'Adresse (rue)',
				'adresse_cp'     => 'Code postal',
				'adresse_ville'  => 'Ville',
				'gps_lat'        => 'Latitude GPS',
				'gps_lng'        => 'Longitude GPS',
			),
		),
		'msms_horaires' => array(
			'titre'  => 'Horaires',
			'champs' => array(
				'horaires_jours' => 'Jours d’ouverture',
				'horaires_matin' => 'Créneau du matin',
				'horaires_aprem' => 'Créneau de l’après-midi',
				'horaires_ferme' => 'Jour de fermeture',
			),
		),
		'msms_promo' => array(
			'titre'  => 'Offre d’ouverture (bandeau)',
			'champs' => array(
				'promo_active' => 'Bandeau actif ? (1 = oui, 0 = non)',
				'promo_titre'  => 'Titre du bandeau',
				'promo_offre'  => 'Offre',
				'promo_detail' => 'Condition',
				'promo_legal'  => 'Mention légale',
				'promo_fin'    => 'Date de fin d’affichage (AAAA-MM-JJ)',
			),
		),
		'msms_options' => array(
			'titre'  => 'Prestations optionnelles',
			'champs' => array(
				'opt_assurance' => 'Prise en charge assurance (1 = oui, 0 = non)',
				'opt_adas'      => 'Recalibrage ADAS (1 = oui, 0 = non)',
				'opt_stockage'  => 'Gardiennage de pneus (1 = oui, 0 = non)',
			),
		),
		'msms_video' => array(
			'titre'  => 'Vidéo d’accueil (arrière-plan)',
			'champs' => array(
				'video_active' => 'Vidéo active ? (1 = oui, 0 = non)',
				'video_webm'   => 'URL du fichier .webm (vide = vidéo fournie)',
				'video_mp4'    => 'URL du fichier .mp4 (recommandé en plus du webm)',
			),
		),
		'msms_flyers_reglage' => array(
			'titre'  => 'Flyers d’ouverture (accueil)',
			'champs' => array(
				'flyers_duree' => 'Durée d’affichage de chaque flyer, en secondes',
			),
		),
		'msms_reseaux' => array(
			'titre'  => 'Réseaux sociaux',
			'champs' => array(
				'instagram' => 'Lien Instagram (vide = masqué)',
				'facebook'  => 'Lien Facebook (vide = masqué)',
			),
		),
	);

	$position = 30;
	foreach ( $sections as $section_id => $section ) {
		$wp->add_section(
			$section_id,
			array(
				'title'    => $section['titre'],
				'priority' => $position,
			)
		);
		$position += 5;

		foreach ( $section['champs'] as $key => $label ) {
			$setting = 'msms_' . $key;
			$wp->add_setting(
				$setting,
				array(
					'default'           => $defaults[ $key ] ?? '',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp->add_control(
				$setting,
				array(
					'label'   => $label,
					'section' => $section_id,
					'type'    => 'text',
				)
			);
		}
	}

	// Quatre sélecteurs d'image pour les flyers, dans la même section.
	for ( $i = 1; $i <= 4; $i++ ) {
		$wp->add_setting(
			'msms_flyer_' . $i,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp->add_control(
			new WP_Customize_Image_Control(
				$wp,
				'msms_flyer_' . $i,
				array(
					'label'       => 'Flyer ' . $i,
					'section'     => 'msms_flyers_reglage',
					'priority'    => $i,
					'description' => 1 === $i
						? 'Téléversez ici vos flyers d’ouverture : ils défileront sur la page d’accueil. Format portrait recommandé. Laissez vide pour afficher à la place la carte d’informations pratiques.'
						: '',
				)
			)
		);
	}
}
add_action( 'customize_register', 'msms_customize_register' );
