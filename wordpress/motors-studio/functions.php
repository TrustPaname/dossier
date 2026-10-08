<?php
/**
 * Motors Studio — fonctions du thème.
 *
 * 1. Chargement des styles et scripts
 * 2. Coordonnées modifiables dans le Personnalisateur
 * 3. Témoignages gérables dans l'administration
 * 4. Réception des formulaires (devis, contact) par e-mail
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
} );

add_action( 'wp_enqueue_scripts', function () {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_style( 'motor-styles', $uri . '/assets/css/styles.css', array(), filemtime( $dir . '/assets/css/styles.css' ) );
	wp_enqueue_style( 'motor-studio', $uri . '/assets/css/studio.css', array( 'motor-styles' ), filemtime( $dir . '/assets/css/studio.css' ) );
	wp_enqueue_script( 'motor-data', $uri . '/assets/js/data.js', array(), filemtime( $dir . '/assets/js/data.js' ), true );
	wp_enqueue_script( 'motor-main', $uri . '/assets/js/main.js', array( 'motor-data' ), filemtime( $dir . '/assets/js/main.js' ), true );
	wp_enqueue_script( 'motor-studio', $uri . '/assets/js/studio.js', array( 'motor-main' ), filemtime( $dir . '/assets/js/studio.js' ), true );

	$config = array(
		'formEndpoint' => esc_url_raw( rest_url( 'motor/v1/lead' ) ),
		'whatsapp'     => motor_opt( 'whatsapp' ),
		'email'        => motor_opt( 'email' ),
		'refPrefix'    => 'MS',
		'brand'        => 'Motors Studio',
	);
	wp_add_inline_script( 'motor-main', 'window.MC_CONFIG = ' . wp_json_encode( $config ) . ';', 'before' );

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
		'email'         => 'contact@motors-studio.fr',
		'lead_email'    => get_option( 'admin_email' ),
		'address'       => '3 rue Florence Arthaud, 28310 Mainvilliers',
		'hours'         => 'Lun–Sam 9h–12h · 13h30–19h',
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
		'title'    => 'Coordonnées Motors Studio',
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
		'label'       => 'Afficher les avis de démonstration tant qu\'aucun n\'est saisi',
		'description' => 'Décochez quand vos propres témoignages sont saisis.',
		'section'     => 'motor_coords',
		'type'        => 'checkbox',
	) );
} );

/* ------------------------------------------------------------------
 * 3. Témoignages
 * ---------------------------------------------------------------- */
add_action( 'init', function () {
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

function motor_temoignage_fields() {
	return array(
		'ville'   => array( 'Intervention (ex. Rayure portière)', 'text', 'Rayure portière' ),
		'note'    => array( 'Note (1 à 5)', 'number', '5' ),
		'service' => array( 'Prestation concernée', 'text', 'Carrosserie' ),
	);
}

add_action( 'add_meta_boxes', function () {
	add_meta_box( 'motor_temoignage', 'Informations sur l\'avis', 'motor_render_meta_box', 'temoignage', 'normal', 'high', array( 'fields' => motor_temoignage_fields() ) );
} );

function motor_render_meta_box( $post, $box ) {
	wp_nonce_field( 'motor_meta', 'motor_meta_nonce' );
	echo '<p style="color:#666">Le titre sert de nom du client (ex. « Sophie L. »). Le texte principal est le témoignage.</p>';
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
	$fields = 'temoignage' === $type ? motor_temoignage_fields() : array();
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
	$tel   = isset( $clean['telephone'] ) ? $clean['telephone'] : '';
	if ( ! is_email( $email ) && '' === $tel ) {
		return new WP_REST_Response( array( 'ok' => false, 'message' => 'Un téléphone ou un e-mail valide est requis.' ), 400 );
	}
	if ( empty( $clean['nom'] ) ) {
		$clean['nom'] = 'Devis express';
	}

	$is_devis = isset( $clean['prestation'] );
	$ref      = isset( $clean['reference'] ) ? $clean['reference'] : 'MS-' . strtoupper( wp_generate_password( 4, false ) );
	$sujet    = $is_devis ? 'Demande de devis' : ( isset( $clean['sujet'] ) ? $clean['sujet'] : 'Contact' );

	$labels = array(
		'nom' => 'Nom', 'telephone' => 'Téléphone', 'email' => 'E-mail', 'sujet' => 'Demande',
		'prestation' => 'Prestation', 'marque' => 'Marque', 'modele' => 'Modèle', 'vehicule' => 'Véhicule',
		'immatriculation' => 'Immatriculation', 'etat' => 'Dossier assurance', 'assurance' => 'Dossier assurance',
		'message' => 'Message', 'reference' => 'Référence',
	);
	$lines = array( 'Nouvelle demande reçue sur le site Motors Studio.', '' );
	foreach ( $labels as $k => $label ) {
		if ( isset( $clean[ $k ] ) && '' !== $clean[ $k ] ) {
			$lines[] = $label . ' : ' . $clean[ $k ];
		}
	}
	$lines[] = '';
	$lines[] = 'Reçue le ' . wp_date( 'd/m/Y à H:i' ) . ' — IP ' . $ip;

	$to      = motor_opt( 'lead_email' );
	$subject = '[Motors Studio] ' . $sujet . ' — ' . $clean['nom'] . ' (' . $ref . ')';
	$headers = is_email( $email ) ? array( 'Reply-To: ' . $clean['nom'] . ' <' . $email . '>' ) : array();
	$sent    = wp_mail( $to, $subject, implode( "\n", $lines ), $headers );

	// Accusé de réception au visiteur.
	if ( is_email( $email ) ) wp_mail( $email, 'Votre demande ' . $ref . ' — Motors Studio',
		"Bonjour " . $clean['nom'] . ",\n\nNous avons bien reçu votre demande (référence " . $ref . "). L'atelier vous répond sous 24h ouvrées, avec un premier chiffrage si vous avez décrit les dégâts.\n\nMotors Studio — Carrosserie & mécanique toutes marques\n" . motor_opt( 'phone_display' ) );

	set_transient( $key, 1, MINUTE_IN_SECONDS );

	if ( ! $sent ) {
		return new WP_REST_Response( array( 'ok' => false, 'message' => 'L\'envoi de l\'e-mail a échoué.' ), 500 );
	}
	return new WP_REST_Response( array( 'ok' => true, 'reference' => $ref ), 200 );
}

/* -------------------------------------------------------------------------
 * Redirection de www vers l'adresse sans www (hébergement mutualisé OVH).
 *
 * OVH n'accepte pas deux domaines sur un même dossier. On rattache donc
 * www.<domaine> à un dossier voisin « <dossier-du-site>-www » et on y dépose
 * un .htaccess qui renvoie tout vers l'adresse principale en 301, sauf les
 * fichiers de validation Let's Encrypt (pour que le certificat www s'émette).
 * Le fichier est (re)créé automatiquement à chaque visite de l'administration.
 * ---------------------------------------------------------------------- */
function motor_www_redirect_dir() {
	$site_dir = rtrim( ABSPATH, '/\\' );
	return dirname( $site_dir ) . '/' . basename( $site_dir ) . '-www';
}

function motor_www_redirect_rules() {
	$home = rtrim( home_url( '/' ), '/' );
	return "# Généré par le thème Motor Consulting — redirige www vers " . $home . "\n"
		. "RewriteEngine On\n"
		. "RewriteCond %{REQUEST_URI} !^/\\.well-known/ [NC]\n"
		. "RewriteRule ^(.*)$ " . $home . "/$1 [R=301,L]\n";
}

add_action( 'admin_init', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$dir   = motor_www_redirect_dir();
	$file  = $dir . '/.htaccess';
	$rules = motor_www_redirect_rules();
	if ( ! is_dir( $dir ) ) {
		@mkdir( $dir, 0755 );
	}
	if ( is_dir( $dir ) && ( ! file_exists( $file ) || file_get_contents( $file ) !== $rules ) ) {
		@file_put_contents( $file, $rules );
		@file_put_contents( $dir . '/index.html', '<!doctype html><meta charset="utf-8"><meta http-equiv="refresh" content="0;url=' . esc_attr( home_url( '/' ) ) . '">' );
	}
} );

// Rappel dans l'administration : quel dossier rattacher à www chez OVH.
add_action( 'admin_notices', function () {
	if ( ! current_user_can( 'manage_options' ) || get_option( 'motor_www_notice_dismissed' ) ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || ! in_array( $screen->id, array( 'dashboard', 'themes' ), true ) ) {
		return;
	}
	$dir  = basename( motor_www_redirect_dir() );
	$host = wp_parse_url( home_url(), PHP_URL_HOST );
	echo '<div class="notice notice-success is-dismissible"><p><strong>Motors Studio :</strong> la redirection de <code>www.' . esc_html( $host ) . '</code> vers ce site est prête dans le dossier <code>' . esc_html( $dir ) . '</code>. Rien à faire si ce domaine www est déjà rattaché à ce dossier chez OVH (Hébergement → Mes sites). Sinon, rattachez-le une fois : Ajouter un site → www → Configuration avancée → dossier <code>' . esc_html( $dir ) . '</code>.</p></div>';
} );
