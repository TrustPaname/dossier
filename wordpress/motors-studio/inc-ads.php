<?php
/**
 * Google Ads : balise Google (gtag.js) et suivi des conversions — module partagé.
 *
 * Le thème définit $motor_ads avant l'inclusion : array( 'prefix' => 'motor_' )
 * Réglages : Apparence → Personnaliser → Google Ads (suivi des conversions).
 *  - ID de la balise Google Ads (ex. AW-123456789)
 *  - Libellé de conversion « formulaire envoyé » (ex. AbCdEfGhIj)
 *  - Libellé de conversion « appel téléphonique » (facultatif)
 * Les formulaires du site émettent l'évènement JS « mc:lead » à l'envoi réussi.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$GLOBALS['mc_ads_prefix'] = isset( $motor_ads['prefix'] ) ? $motor_ads['prefix'] : 'motor_';

function mc_ads_opt( $key ) {
	return trim( (string) get_theme_mod( $GLOBALS['mc_ads_prefix'] . 'ads_' . $key, '' ) );
}

add_action( 'customize_register', function ( $wp_customize ) {
	$p = $GLOBALS['mc_ads_prefix'];
	$wp_customize->add_section( $p . 'ads', array(
		'title'       => 'Google Ads (suivi des conversions)',
		'description' => 'Dans Google Ads : Objectifs → Conversions → Nouvelle action → Site web → « Installer la balise vous-même ». Copiez l\'identifiant AW-… et le libellé de conversion ici. Le site compte alors chaque demande de rendez-vous envoyée.',
		'priority'    => 25,
	) );
	$fields = array(
		'id'        => 'ID de la balise Google Ads (AW-…)',
		'label'     => 'Libellé de conversion : formulaire envoyé',
		'label_tel' => 'Libellé de conversion : clic sur le téléphone (facultatif)',
		'ga4'       => 'ID Google Analytics 4 (G-…, facultatif)',
	);
	foreach ( $fields as $key => $label ) {
		$wp_customize->add_setting( $p . 'ads_' . $key, array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( $p . 'ads_' . $key, array( 'label' => $label, 'section' => $p . 'ads', 'type' => 'text' ) );
	}
} );

/** Balise Google dans l'en-tête (seulement si un identifiant est renseigné, jamais pour les administrateurs connectés). */
add_action( 'wp_head', function () {
	$id  = mc_ads_opt( 'id' );
	$ga4 = mc_ads_opt( 'ga4' );
	if ( ( ! $id && ! $ga4 ) || ( is_user_logged_in() && current_user_can( 'edit_theme_options' ) ) ) {
		return;
	}
	$main = $id ? $id : $ga4;
	echo '<script async src="https://www.googletagmanager.com/gtag/js?id=' . esc_attr( $main ) . '"></script>' . "\n";
	echo '<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag("js",new Date());';
	if ( $id ) {
		echo 'gtag("config","' . esc_js( $id ) . '");';
	}
	if ( $ga4 ) {
		echo 'gtag("config","' . esc_js( $ga4 ) . '");';
	}
	echo '</script>' . "\n";
}, 1 );

/** Conversions : formulaire envoyé (évènement mc:lead) et clics téléphone / WhatsApp. */
add_action( 'wp_footer', function () {
	$id = mc_ads_opt( 'id' );
	if ( ! $id || ( is_user_logged_in() && current_user_can( 'edit_theme_options' ) ) ) {
		return;
	}
	$lead = mc_ads_opt( 'label' );
	$tel  = mc_ads_opt( 'label_tel' );
	?>
<script>
(function(){
  function conv(label,extra){ if(!window.gtag||!label) return; var p={send_to:"<?php echo esc_js( $id ); ?>/"+label}; if(extra){ for(var k in extra){ p[k]=extra[k]; } } gtag("event","conversion",p); }
  document.addEventListener("mc:lead",function(e){ conv("<?php echo esc_js( $lead ); ?>",{transaction_id:(e.detail&&e.detail.reference)||""}); if(window.gtag){ gtag("event","generate_lead",{form_id:(e.detail&&e.detail.form)||""}); } });
  document.addEventListener("click",function(e){ var a=e.target.closest&&e.target.closest('a[href^="tel:"],a[href*="wa.me"]'); if(!a) return; conv("<?php echo esc_js( $tel ); ?>"); if(window.gtag){ gtag("event", a.getAttribute("href").indexOf("tel:")===0?"phone_click":"whatsapp_click"); } },true);
})();
</script>
	<?php
}, 5 );
