<?php
/**
 * Pages légales (mentions légales, confidentialité, CGV) — module partagé.
 *
 * Le thème définit $motor_legal avant de l'inclure :
 *   array( 'prefix' => 'motor_', 'nom' => 'Motor Consulting', 'opt' => 'motor_opt' )
 *
 * - Apparence → Personnaliser → Informations légales : raison sociale, forme,
 *   capital, SIRET, RCS, TVA, directeur de publication, médiateur.
 * - Adresses : /mentions-legales/, /confidentialite/, /cgv/ (fichiers legal-*.php
 *   du thème, générés par wordpress/build.py).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$GLOBALS['mc_legal_cfg'] = array_merge( array(
	'prefix' => 'motor_',
	'nom'    => get_bloginfo( 'name' ),
	'opt'    => 'motor_opt',
), isset( $motor_legal ) && is_array( $motor_legal ) ? $motor_legal : array() );

function mc_legal_cfg( $k ) {
	return $GLOBALS['mc_legal_cfg'][ $k ];
}

function mc_legal_fields() {
	return array(
		'raison'        => array( 'Raison sociale (ex. MOTOR CONSULTING)', 'text' ),
		'forme'         => array( 'Forme juridique (ex. SAS, SARL, EI)', 'text' ),
		'capital'       => array( 'Capital social (ex. 1 000 €)', 'text' ),
		'siret'         => array( 'Numéro SIRET', 'text' ),
		'rcs'           => array( 'Ville du RCS (ex. Chartres)', 'text' ),
		'tva'           => array( 'Numéro de TVA intracommunautaire (ex. FR12 123456789)', 'text' ),
		'gerant'        => array( 'Directeur de la publication (nom du gérant)', 'text' ),
		'mediateur'     => array( 'Médiateur de la consommation (nom)', 'text' ),
		'mediateur_url' => array( 'Médiateur : site ou adresse', 'text' ),
	);
}

function mc_legal_defaults() {
	$cfg = $GLOBALS['mc_legal_cfg'];
	return array_merge( array(
		'raison'        => strtoupper( mc_legal_cfg( 'nom' ) ),
		'forme'         => '',
		'capital'       => '',
		'siret'         => '',
		'rcs'           => 'Chartres',
		'tva'           => '',
		'gerant'        => '',
		'mediateur'     => '',
		'mediateur_url' => '',
	), isset( $cfg['defaults'] ) && is_array( $cfg['defaults'] ) ? $cfg['defaults'] : array() );
}

function mc_legal_val( $key ) {
	$d = mc_legal_defaults();
	$v = get_theme_mod( mc_legal_cfg( 'prefix' ) . 'legal_' . $key, isset( $d[ $key ] ) ? $d[ $key ] : '' );
	return is_string( $v ) ? trim( $v ) : '';
}

/** Affiche la valeur, ou un repère « à compléter » visible par l'administrateur. */
function mc_legal( $key ) {
	$v = mc_legal_val( $key );
	if ( '' === $v ) {
		echo '<span class="legal__todo" title="À renseigner dans Apparence → Personnaliser → Informations légales">à compléter</span>';
		return;
	}
	if ( 'mediateur_url' === $key && preg_match( '#^https?://#', $v ) ) {
		echo '<a href="' . esc_url( $v ) . '" target="_blank" rel="noopener">' . esc_html( preg_replace( '#^https?://(www\.)?#', '', $v ) ) . '</a>';
		return;
	}
	echo esc_html( $v );
}

function mc_legal_nom() {
	return mc_legal_cfg( 'nom' );
}

add_action( 'customize_register', function ( $wp_customize ) {
	$prefix = mc_legal_cfg( 'prefix' );
	$wp_customize->add_section( $prefix . 'legal', array(
		'title'       => 'Informations légales',
		'description' => 'Ces informations alimentent les pages Mentions légales, Confidentialité et CGV. Tant qu\'un champ est vide, la page affiche « à compléter ».',
		'priority'    => 23,
	) );
	$d = mc_legal_defaults();
	foreach ( mc_legal_fields() as $key => $f ) {
		$wp_customize->add_setting( $prefix . 'legal_' . $key, array(
			'default'           => $d[ $key ],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( $prefix . 'legal_' . $key, array(
			'label'   => $f[0],
			'section' => $prefix . 'legal',
			'type'    => $f[1],
		) );
	}
} );

/* ------------------------------------------------------------------
 * Adresses /mentions-legales/, /confidentialite/, /cgv/
 * ---------------------------------------------------------------- */
function mc_legal_slugs() {
	return array( 'mentions-legales', 'confidentialite', 'cgv' );
}

add_action( 'init', function () {
	add_rewrite_rule( '^(' . implode( '|', mc_legal_slugs() ) . ')/?$', 'index.php?mc_legal=$matches[1]', 'top' );
	// Première activation du module : enregistre les adresses sans attendre une sauvegarde des permaliens.
	if ( get_option( 'mc_legal_rules' ) !== '2' ) {
		flush_rewrite_rules( false );
		update_option( 'mc_legal_rules', '2' );
	}
} );

add_filter( 'query_vars', function ( $vars ) {
	$vars[] = 'mc_legal';
	return $vars;
} );

add_action( 'template_redirect', function () {
	$slug = get_query_var( 'mc_legal' );
	// Secours si les permaliens ne sont pas réécrits (ex. réglage « Simple ») : /?mc_legal=cgv
	if ( ! $slug && isset( $_GET['mc_legal'] ) ) {
		$slug = sanitize_key( $_GET['mc_legal'] );
	}
	if ( ! $slug || ! in_array( $slug, mc_legal_slugs(), true ) ) {
		return;
	}
	$file = get_template_directory() . '/legal-' . $slug . '.php';
	if ( ! file_exists( $file ) ) {
		return;
	}
	status_header( 200 );
	include $file;
	exit;
}, 5 );

/** Le titre de l'onglet reflète la page. */
add_filter( 'pre_get_document_title', function ( $title ) {
	$slug = get_query_var( 'mc_legal' );
	$noms = array( 'mentions-legales' => 'Mentions légales', 'confidentialite' => 'Politique de confidentialité', 'cgv' => 'Conditions générales de vente' );
	return isset( $noms[ $slug ] ) ? $noms[ $slug ] . ' — ' . mc_legal_nom() : $title;
} );
