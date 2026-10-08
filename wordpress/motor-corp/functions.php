<?php
/**
 * Motor Corp — fonctions du thème (liens et coordonnées dans le Personnalisateur).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function corp_defaults() {
	return array(
		'studio_url'     => 'https://www.motors-studio.fr/',
		'consulting_url' => 'https://www.motorconsulting.fr/',
		'email'          => 'contact@motorcorp.fr',
		'phone_display'  => '06 12 34 56 78',
		'phone_e164'     => '+33612345678',
		'address'        => '24 avenue de la Grande-Armée, 75017 Paris',
	);
}

function corp_opt( $key ) {
	$defaults = corp_defaults();
	$value    = get_theme_mod( 'corp_' . $key, isset( $defaults[ $key ] ) ? $defaults[ $key ] : '' );
	return is_string( $value ) ? trim( $value ) : $value;
}

add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_section( 'corp_links', array( 'title' => 'Motor Corp — liens et coordonnées', 'priority' => 20 ) );
	$fields = array(
		'studio_url'     => array( 'Adresse du site Motors Studio', 'url' ),
		'consulting_url' => array( 'Adresse du site Motor Consulting', 'url' ),
		'email'          => array( 'E-mail de la holding', 'email' ),
		'phone_display'  => array( 'Téléphone affiché', 'text' ),
		'phone_e164'     => array( 'Téléphone pour les liens (format +33…)', 'text' ),
		'address'        => array( 'Adresse', 'text' ),
	);
	$defaults = corp_defaults();
	foreach ( $fields as $key => $f ) {
		$sanitize = 'url' === $f[1] ? 'esc_url_raw' : ( 'email' === $f[1] ? 'sanitize_email' : 'sanitize_text_field' );
		$wp_customize->add_setting( 'corp_' . $key, array( 'default' => $defaults[ $key ], 'sanitize_callback' => $sanitize ) );
		$wp_customize->add_control( 'corp_' . $key, array( 'label' => $f[0], 'section' => 'corp_links', 'type' => $f[1] ) );
	}
} );

add_action( 'after_setup_theme', function () {
	add_theme_support( 'html5', array( 'script', 'style' ) );
} );

/* -------------------------------------------------------------------------
 * Redirection de www vers l'adresse sans www (hébergement mutualisé OVH).
 * OVH n'accepte pas deux domaines sur un même dossier : www.<domaine> est
 * rattaché au dossier voisin « motor-corp-www », où le thème dépose un
 * .htaccess qui renvoie tout vers l'adresse principale (sauf Let's Encrypt).
 * ---------------------------------------------------------------------- */
function corp_www_redirect_dir() {
	return dirname( rtrim( ABSPATH, '/\\' ) ) . '/motor-corp-www';
}

function corp_www_redirect_rules() {
	$home = rtrim( home_url( '/' ), '/' );
	return "# Généré par le thème Motor Corp — redirige www vers " . $home . "\n"
		. "RewriteEngine On\n"
		. "RewriteCond %{REQUEST_URI} !^/\\.well-known/ [NC]\n"
		. "RewriteRule ^(.*)$ " . $home . "/$1 [R=301,L]\n";
}

add_action( 'admin_init', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$dir   = corp_www_redirect_dir();
	$file  = $dir . '/.htaccess';
	$rules = corp_www_redirect_rules();
	if ( ! is_dir( $dir ) ) {
		@mkdir( $dir, 0755 );
	}
	if ( is_dir( $dir ) && ( ! file_exists( $file ) || file_get_contents( $file ) !== $rules ) ) {
		@file_put_contents( $file, $rules );
		@file_put_contents( $dir . '/index.html', '<!doctype html><meta charset="utf-8"><meta http-equiv="refresh" content="0;url=' . esc_attr( home_url( '/' ) ) . '">' );
	}
} );

add_action( 'admin_notices', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || ! in_array( $screen->id, array( 'dashboard', 'themes' ), true ) ) {
		return;
	}
	$host = wp_parse_url( home_url(), PHP_URL_HOST );
	echo '<div class="notice notice-success is-dismissible"><p><strong>Motor Corp :</strong> la redirection de <code>www.' . esc_html( $host ) . '</code> vers ce site est prête dans le dossier <code>motor-corp-www</code>. Rien à faire si ce domaine www est déjà rattaché à ce dossier chez OVH (Hébergement → Mes sites). Sinon, rattachez-le une fois : Ajouter un site → www → Configuration avancée → dossier <code>motor-corp-www</code>.</p></div>';
} );
