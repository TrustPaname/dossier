<?php
/**
 * Motor Corp — fonctions du thème (liens et coordonnées dans le Personnalisateur).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function corp_defaults() {
	return array(
		'studio_url'     => 'https://www.motor-studio.fr/',
		'consulting_url' => 'https://www.motor-consulting.fr/',
		'email'          => 'contact@motor-corp.fr',
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
