<?php
/**
 * Motor Consulting — fonctions du thème.
 *
 * 1. Chargement des styles et scripts
 * 2. Coordonnées modifiables dans le Personnalisateur
 * 3. Véhicules et témoignages gérables dans l'administration
 * 4. Réception des formulaires (estimation, contact) par e-mail
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MOTOR_VERSION', '1.0.0' );

/* ------------------------------------------------------------------
 * 1. Réglages de base, styles et scripts
 * ---------------------------------------------------------------- */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'script', 'style' ) );
	add_image_size( 'motor-vehicule', 1200, 660, true );
} );

add_action( 'wp_enqueue_scripts', function () {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_style( 'motor-styles', $uri . '/assets/css/styles.css', array(), filemtime( $dir . '/assets/css/styles.css' ) );
	wp_enqueue_script( 'motor-data', $uri . '/assets/js/data.js', array(), filemtime( $dir . '/assets/js/data.js' ), true );
	wp_enqueue_script( 'motor-main', $uri . '/assets/js/main.js', array( 'motor-data' ), filemtime( $dir . '/assets/js/main.js' ), true );

	$config = array(
		'formEndpoint' => esc_url_raw( rest_url( 'motor/v1/lead' ) ),
		'whatsapp'     => motor_opt( 'whatsapp' ),
		'email'        => motor_opt( 'email' ),
	);
	wp_add_inline_script( 'motor-main', 'window.MC_CONFIG = ' . wp_json_encode( $config ) . ';', 'before' );

	$vehicules = motor_get_vehicules();
	if ( ! empty( $vehicules ) || ! motor_opt( 'demo' ) ) {
		wp_add_inline_script( 'motor-main', 'window.MC_VEHICLES = ' . wp_json_encode( $vehicules ) . ';', 'before' );
	}
	$avis = motor_get_temoignages();
	if ( ! empty( $avis ) || ! motor_opt( 'demo' ) ) {
		wp_add_inline_script( 'motor-main', 'window.MC_TESTIMONIALS = ' . wp_json_encode( $avis ) . ';', 'before' );
	}
} );

/* ------------------------------------------------------------------
 * 2. Coordonnées : Apparence → Personnaliser → Coordonnées
 * ---------------------------------------------------------------- */
function motor_defaults() {
	return array(
		'phone_display' => '06 12 34 56 78',
		'phone_e164'    => '+33612345678',
		'whatsapp'      => '33612345678',
		'email'         => 'contact@motor-consulting.fr',
		'lead_email'    => get_option( 'admin_email' ),
		'address'       => '24 avenue de la Grande-Armée, 75017 Paris',
		'hours'         => 'Lun–Ven 9h–19h · Sam 10h–17h',
		'demo'          => 1,
	);
}

function motor_opt( $key ) {
	$defaults = motor_defaults();
	$value    = get_theme_mod( 'motor_' . $key, isset( $defaults[ $key ] ) ? $defaults[ $key ] : '' );
	return is_string( $value ) ? trim( $value ) : $value;
}

add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_section( 'motor_coords', array(
		'title'    => 'Coordonnées Motor Consulting',
		'priority' => 20,
	) );

	$fields = array(
		'phone_display' => array( 'Téléphone affiché', 'text' ),
		'phone_e164'    => array( 'Téléphone pour les liens (format +33…)', 'text' ),
		'whatsapp'      => array( 'Numéro WhatsApp (chiffres seulement, ex. 33612345678)', 'text' ),
		'email'         => array( 'E-mail affiché sur le site', 'email' ),
		'lead_email'    => array( 'E-mail qui reçoit les demandes des formulaires', 'email' ),
		'address'       => array( 'Adresse', 'text' ),
		'hours'         => array( 'Horaires', 'text' ),
	);
	$defaults = motor_defaults();
	foreach ( $fields as $key => $f ) {
		$wp_customize->add_setting( 'motor_' . $key, array(
			'default'           => $defaults[ $key ],
			'sanitize_callback' => 'email' === $f[1] ? 'sanitize_email' : 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'motor_' . $key, array(
			'label'   => $f[0],
			'section' => 'motor_coords',
			'type'    => $f[1],
		) );
	}

	$wp_customize->add_setting( 'motor_demo', array( 'default' => 1, 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control( 'motor_demo', array(
		'label'       => 'Afficher les véhicules et avis de démonstration tant qu\'aucun n\'est saisi',
		'description' => 'Décochez avant la mise en ligne si vous n\'avez pas encore saisi de véhicules.',
		'section'     => 'motor_coords',
		'type'        => 'checkbox',
	) );
} );

/* ------------------------------------------------------------------
 * 3. Véhicules et témoignages
 * ---------------------------------------------------------------- */
add_action( 'init', function () {
	register_post_type( 'vehicule', array(
		'labels' => array(
			'name'          => 'Véhicules',
			'singular_name' => 'Véhicule',
			'add_new'       => 'Ajouter un véhicule',
			'add_new_item'  => 'Ajouter un véhicule',
			'edit_item'     => 'Modifier le véhicule',
			'all_items'     => 'Tous les véhicules',
			'featured_image'=> 'Photo principale du véhicule',
			'set_featured_image' => 'Choisir la photo',
		),
		'public'       => false,
		'show_ui'      => true,
		'menu_icon'    => 'dashicons-car',
		'menu_position'=> 5,
		'supports'     => array( 'title', 'editor', 'thumbnail' ),
	) );

	register_post_type( 'temoignage', array(
		'labels' => array(
			'name'          => 'Témoignages',
			'singular_name' => 'Témoignage',
			'add_new'       => 'Ajouter un témoignage',
			'add_new_item'  => 'Ajouter un témoignage',
			'edit_item'     => 'Modifier le témoignage',
			'all_items'     => 'Tous les témoignages',
		),
		'public'       => false,
		'show_ui'      => true,
		'menu_icon'    => 'dashicons-format-quote',
		'menu_position'=> 6,
		'supports'     => array( 'title', 'editor' ),
	) );
} );

function motor_vehicule_fields() {
	return array(
		'marque'    => array( 'Marque', 'text', 'Peugeot' ),
		'modele'    => array( 'Modèle', 'text', '3008' ),
		'version'   => array( 'Version / finition', 'text', '1.5 BlueHDi 130 Allure EAT8' ),
		'annee'     => array( 'Année', 'number', '2021' ),
		'km'        => array( 'Kilométrage', 'number', '62400' ),
		'prix'      => array( 'Prix (€)', 'number', '22900' ),
		'carburant' => array( 'Carburant', 'select', array( 'Essence', 'Diesel', 'Hybride', 'Électrique', 'GPL' ) ),
		'boite'     => array( 'Boîte', 'select', array( 'Manuelle', 'Automatique' ) ),
		'type'      => array( 'Type', 'select', array( 'Citadine', 'Berline', 'SUV', 'Break', 'Monospace', 'Utilitaire' ) ),
		'places'    => array( 'Places', 'number', '5' ),
		'tag'       => array( 'Étiquette (ex. Coup de cœur, Faible kilométrage)', 'text', '' ),
		'garantie'  => array( 'Garantie', 'text', '12 mois' ),
		'options'   => array( 'Équipements principaux (un par ligne)', 'textarea', '' ),
		'vendu'     => array( 'Véhicule vendu (masqué du site)', 'checkbox', '' ),
	);
}

function motor_temoignage_fields() {
	return array(
		'ville'   => array( 'Ville', 'text', 'Paris 15e' ),
		'note'    => array( 'Note (1 à 5)', 'number', '5' ),
		'service' => array( 'Service concerné', 'text', 'Vente accompagnée' ),
	);
}

add_action( 'add_meta_boxes', function () {
	add_meta_box( 'motor_vehicule', 'Caractéristiques du véhicule', 'motor_render_meta_box', 'vehicule', 'normal', 'high', array( 'fields' => motor_vehicule_fields() ) );
	add_meta_box( 'motor_temoignage', 'Informations sur l\'avis', 'motor_render_meta_box', 'temoignage', 'normal', 'high', array( 'fields' => motor_temoignage_fields() ) );
} );

function motor_render_meta_box( $post, $box ) {
	wp_nonce_field( 'motor_meta', 'motor_meta_nonce' );
	echo '<p style="color:#666">Le titre de la fiche sert de nom affiché (ex. « Peugeot 3008 »). Le texte principal sert de description. La photo principale remplace l\'illustration par défaut.</p>';
	echo '<table class="form-table">';
	foreach ( $box['args']['fields'] as $key => $f ) {
		$name  = 'motor_' . $key;
		$value = get_post_meta( $post->ID, $name, true );
		echo '<tr><th scope="row"><label for="' . esc_attr( $name ) . '">' . esc_html( $f[0] ) . '</label></th><td>';
		switch ( $f[1] ) {
			case 'select':
				echo '<select id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '">';
				foreach ( $f[2] as $opt ) {
					echo '<option value="' . esc_attr( $opt ) . '"' . selected( $value, $opt, false ) . '>' . esc_html( $opt ) . '</option>';
				}
				echo '</select>';
				break;
			case 'textarea':
				echo '<textarea id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" rows="4" class="large-text">' . esc_textarea( $value ) . '</textarea>';
				break;
			case 'checkbox':
				echo '<label><input type="checkbox" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" value="1"' . checked( $value, '1', false ) . '> Oui</label>';
				break;
			default:
				echo '<input type="' . esc_attr( $f[1] ) . '" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" placeholder="' . esc_attr( is_string( $f[2] ) ? $f[2] : '' ) . '" class="regular-text">';
		}
		echo '</td></tr>';
	}
	echo '</table>';
}

add_action( 'save_post', function ( $post_id ) {
	if ( ! isset( $_POST['motor_meta_nonce'] ) || ! wp_verify_nonce( $_POST['motor_meta_nonce'], 'motor_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$type   = get_post_type( $post_id );
	$fields = 'vehicule' === $type ? motor_vehicule_fields() : ( 'temoignage' === $type ? motor_temoignage_fields() : array() );
	foreach ( $fields as $key => $f ) {
		$name = 'motor_' . $key;
		if ( 'checkbox' === $f[1] ) {
			update_post_meta( $post_id, $name, isset( $_POST[ $name ] ) ? '1' : '' );
			continue;
		}
		if ( ! isset( $_POST[ $name ] ) ) {
			continue;
		}
		$raw = wp_unslash( $_POST[ $name ] );
		$val = 'textarea' === $f[1] ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw );
		update_post_meta( $post_id, $name, $val );
	}
} );

/** Liste des véhicules au format attendu par assets/js/main.js */
function motor_get_vehicules() {
	$posts = get_posts( array(
		'post_type'      => 'vehicule',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'meta_query'     => array(
			'relation' => 'OR',
			array( 'key' => 'motor_vendu', 'compare' => 'NOT EXISTS' ),
			array( 'key' => 'motor_vendu', 'value' => '1', 'compare' => '!=' ),
		),
	) );
	$out = array();
	$id  = count( $posts );
	foreach ( $posts as $p ) {
		$m = function ( $k, $d = '' ) use ( $p ) {
			$v = get_post_meta( $p->ID, 'motor_' . $k, true );
			return '' === $v ? $d : $v;
		};
		$options = array_values( array_filter( array_map( 'trim', explode( "\n", $m( 'options' ) ) ) ) );
		$photo   = get_the_post_thumbnail_url( $p->ID, 'motor-vehicule' );
		$out[]   = array(
			'id'          => $id--,
			'marque'      => $m( 'marque', $p->post_title ),
			'modele'      => $m( 'modele' ),
			'version'     => $m( 'version' ),
			'annee'       => (int) $m( 'annee', 0 ),
			'km'          => (int) $m( 'km', 0 ),
			'prix'        => (int) $m( 'prix', 0 ),
			'carburant'   => $m( 'carburant', 'Essence' ),
			'boite'       => $m( 'boite', 'Manuelle' ),
			'type'        => $m( 'type', 'Berline' ),
			'places'      => (int) $m( 'places', 5 ),
			'tag'         => $m( 'tag' ),
			'garantie'    => $m( 'garantie', '12 mois' ),
			'description' => wp_strip_all_tags( $p->post_content ),
			'options'     => $options,
			'photo'       => $photo ? $photo : '',
		);
	}
	return $out;
}

/** Liste des témoignages au format attendu par assets/js/main.js */
function motor_get_temoignages() {
	$posts = get_posts( array( 'post_type' => 'temoignage', 'post_status' => 'publish', 'posts_per_page' => -1 ) );
	$out   = array();
	foreach ( $posts as $p ) {
		$note  = (int) get_post_meta( $p->ID, 'motor_note', true );
		$out[] = array(
			'nom'     => $p->post_title,
			'ville'   => get_post_meta( $p->ID, 'motor_ville', true ),
			'note'    => $note >= 1 && $note <= 5 ? $note : 5,
			'service' => get_post_meta( $p->ID, 'motor_service', true ),
			'texte'   => wp_strip_all_tags( $p->post_content ),
		);
	}
	return $out;
}

/* Colonnes utiles dans la liste des véhicules */
add_filter( 'manage_vehicule_posts_columns', function ( $cols ) {
	return array( 'cb' => $cols['cb'], 'title' => 'Véhicule', 'prix' => 'Prix', 'annee' => 'Année', 'km' => 'Kilométrage', 'vendu' => 'Statut', 'date' => $cols['date'] );
} );
add_action( 'manage_vehicule_posts_custom_column', function ( $col, $post_id ) {
	switch ( $col ) {
		case 'prix':  echo esc_html( number_format( (int) get_post_meta( $post_id, 'motor_prix', true ), 0, ',', ' ' ) . ' €' ); break;
		case 'annee': echo esc_html( get_post_meta( $post_id, 'motor_annee', true ) ); break;
		case 'km':    echo esc_html( number_format( (int) get_post_meta( $post_id, 'motor_km', true ), 0, ',', ' ' ) . ' km' ); break;
		case 'vendu': echo get_post_meta( $post_id, 'motor_vendu', true ) ? 'Vendu (masqué)' : 'En vente'; break;
	}
}, 10, 2 );

/* ------------------------------------------------------------------
 * 4. Formulaires : POST /wp-json/motor/v1/lead → e-mail
 * ---------------------------------------------------------------- */
add_action( 'rest_api_init', function () {
	register_rest_route( 'motor/v1', '/lead', array(
		'methods'             => 'POST',
		'permission_callback' => '__return_true',
		'callback'            => 'motor_handle_lead',
	) );
} );

function motor_handle_lead( WP_REST_Request $req ) {
	$data = $req->get_json_params();
	if ( ! is_array( $data ) ) {
		$data = $req->get_body_params();
	}

	// Pot de miel : un robot remplit le champ caché.
	if ( ! empty( $data['website'] ) ) {
		return new WP_REST_Response( array( 'ok' => true ), 200 );
	}

	// Limite : une demande par minute et par adresse IP.
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '0';
	$key = 'motor_lead_' . md5( $ip );
	if ( get_transient( $key ) ) {
		return new WP_REST_Response( array( 'ok' => false, 'message' => 'Merci de patienter une minute avant une nouvelle demande.' ), 429 );
	}

	$clean = array();
	foreach ( $data as $k => $v ) {
		$k = sanitize_key( $k );
		if ( 'website' === $k || 'page' === $k ) {
			continue;
		}
		$clean[ $k ] = is_scalar( $v ) ? sanitize_textarea_field( (string) $v ) : '';
	}

	$email = isset( $clean['email'] ) ? sanitize_email( $clean['email'] ) : '';
	if ( empty( $clean['nom'] ) || ! is_email( $email ) ) {
		return new WP_REST_Response( array( 'ok' => false, 'message' => 'Nom et e-mail valides requis.' ), 400 );
	}

	$is_estimation = isset( $clean['marque'] ) && isset( $clean['kilometrage'] );
	$ref           = isset( $clean['reference'] ) ? $clean['reference'] : 'MC-' . strtoupper( wp_generate_password( 4, false ) );
	$sujet         = $is_estimation ? 'Demande d\'estimation' : ( isset( $clean['sujet'] ) ? $clean['sujet'] : 'Contact' );

	$labels = array(
		'nom' => 'Nom', 'telephone' => 'Téléphone', 'email' => 'E-mail', 'sujet' => 'Demande',
		'marque' => 'Marque', 'modele' => 'Modèle', 'annee' => 'Année', 'kilometrage' => 'Kilométrage',
		'carburant' => 'Carburant', 'etat' => 'État', 'message' => 'Message', 'reference' => 'Référence',
	);
	$lines = array( 'Nouvelle demande reçue sur le site Motor Consulting.', '' );
	foreach ( $labels as $k => $label ) {
		if ( isset( $clean[ $k ] ) && '' !== $clean[ $k ] ) {
			$lines[] = $label . ' : ' . $clean[ $k ];
		}
	}
	$lines[] = '';
	$lines[] = 'Reçue le ' . wp_date( 'd/m/Y à H:i' ) . ' — IP ' . $ip;

	$to      = motor_opt( 'lead_email' );
	$subject = '[Motor Consulting] ' . $sujet . ' — ' . $clean['nom'] . ' (' . $ref . ')';
	$headers = array( 'Reply-To: ' . $clean['nom'] . ' <' . $email . '>' );
	$sent    = wp_mail( $to, $subject, implode( "\n", $lines ), $headers );

	// Accusé de réception au visiteur.
	wp_mail( $email, 'Votre demande ' . $ref . ' — Motor Consulting',
		"Bonjour " . $clean['nom'] . ",\n\nNous avons bien reçu votre demande (référence " . $ref . "). Un expert vous répond sous 24h ouvrées.\n\nMotor Consulting — L'expertise automobile à votre service\n" . motor_opt( 'phone_display' ) );

	set_transient( $key, 1, MINUTE_IN_SECONDS );

	if ( ! $sent ) {
		return new WP_REST_Response( array( 'ok' => false, 'message' => 'L\'envoi de l\'e-mail a échoué.' ), 500 );
	}
	return new WP_REST_Response( array( 'ok' => true, 'reference' => $ref ), 200 );
}
