<?php
/**
 * MS MOTORS STUDIO — fonctions du thème.
 *
 * Les informations du garage se règlent dans Apparence → Personnaliser.
 * Les contenus des pages se trouvent dans le dossier inc/ :
 *   - inc/config.php    : coordonnées et valeurs par défaut ;
 *   - inc/services.php  : contenu des quatre pôles d'activité ;
 *   - inc/contenus.php  : accueil, atelier, engagements, questions fréquentes.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MSMS_VERSION', '2.0.0' );

require_once get_theme_file_path( 'inc/config.php' );
require_once get_theme_file_path( 'inc/services.php' );
require_once get_theme_file_path( 'inc/contenus.php' );
require_once get_theme_file_path( 'inc/template-tags.php' );
require_once get_theme_file_path( 'inc/customizer.php' );
require_once get_theme_file_path( 'inc/contact-handler.php' );
require_once get_theme_file_path( 'inc/schema.php' );
require_once get_theme_file_path( 'inc/setup-pages.php' );

/** Réglages de base du thème. */
function msms_setup(): void {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'msms_setup' );

/** Feuilles de style et scripts. */
function msms_assets(): void {
	wp_enqueue_style(
		'msms-polices',
		'https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700&family=Manrope:wght@300;400;500;600&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'msms-styles', get_theme_file_uri( 'assets/css/main.css' ), array( 'msms-polices' ), MSMS_VERSION );
	wp_enqueue_script( 'msms-script', get_theme_file_uri( 'assets/js/main.js' ), array(), MSMS_VERSION, array( 'strategy' => 'defer' ) );
}
add_action( 'wp_enqueue_scripts', 'msms_assets' );

/** Préconnexion aux serveurs de polices. */
function msms_preconnect( array $urls, string $relation ): array {
	if ( 'preconnect' === $relation ) {
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'msms_preconnect', 10, 2 );

/** Nettoyage de l'en-tête : rien d'inutile dans le code source. */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

/** Désactive les emojis WordPress (poids inutile, la charte n'en utilise pas). */
function msms_sans_emojis(): void {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'msms_sans_emojis' );
