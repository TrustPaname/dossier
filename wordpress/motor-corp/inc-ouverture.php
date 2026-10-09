<?php
/**
 * Page « Ouverture prochaine » avec compte à rebours.
 *
 * Partagée par les thèmes Motor Consulting, Motor Corp et Motors Studio
 * (copiée dans chaque thème par wordpress/build.py).
 *
 * Le thème qui l'inclut définit avant le require :
 *   $motor_ouverture = array(
 *     'prefix'  => 'motor_',            // préfixe des réglages du Personnalisateur
 *     'nom'     => 'Motor Consulting',  // nom affiché
 *     'logo'    => 'assets/img/x.png',  // chemin du logo dans le thème
 *     'couleur' => '#0a8cff',           // couleur d'accent
 *     'police'  => array( 'Outfit', 'assets/fonts/outfit-300-800-latin.woff2' ), // facultatif
 *   );
 *
 * Réglages : Apparence → Personnaliser → Ouverture prochaine.
 * Les administrateurs connectés voient toujours le vrai site.
 * Une fois la date passée, le site s'affiche automatiquement.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$GLOBALS['motor_ouverture_cfg'] = isset( $motor_ouverture ) ? $motor_ouverture : array();

function motor_ouverture_cfg( $k, $d = '' ) {
	$c = $GLOBALS['motor_ouverture_cfg'];
	return isset( $c[ $k ] ) ? $c[ $k ] : $d;
}

function motor_ouverture_mod( $k, $d = '' ) {
	return get_theme_mod( motor_ouverture_cfg( 'prefix', 'motor_' ) . 'ouverture_' . $k, $d );
}

/** Date-heure d'ouverture (objet DateTime dans le fuseau du site) ou null. */
function motor_ouverture_date() {
	$date  = trim( (string) motor_ouverture_mod( 'date', '2026-11-05' ) );
	$heure = trim( (string) motor_ouverture_mod( 'heure', '09:00' ) );
	try {
		return new DateTime( $date . ' ' . ( $heure ? $heure : '09:00' ), wp_timezone() );
	} catch ( Exception $e ) {
		return null;
	}
}

/** La page d'attente doit-elle s'afficher pour ce visiteur ? */
function motor_ouverture_active() {
	if ( ! motor_ouverture_mod( 'active', 1 ) ) {
		return false;
	}
	if ( is_user_logged_in() && current_user_can( 'edit_theme_options' ) ) {
		return false; // l'administrateur continue de voir et régler le vrai site
	}
	if ( is_customize_preview() ) {
		return false;
	}
	$d = motor_ouverture_date();
	if ( ! $d ) {
		return false;
	}
	return $d->getTimestamp() > current_time( 'timestamp', true );
}

add_action( 'customize_register', function ( $wp_customize ) {
	$p = motor_ouverture_cfg( 'prefix', 'motor_' );
	$wp_customize->add_section( $p . 'ouverture', array(
		'title'       => 'Ouverture prochaine (compte à rebours)',
		'priority'    => 10,
		'description' => 'Tant que la case est cochée et que la date n\'est pas passée, les visiteurs voient une page « Ouverture le … » avec un compte à rebours. Vous, connecté, voyez le vrai site.',
	) );
	$fields = array(
		'active'  => array( 'Afficher la page d\'attente aux visiteurs', 'checkbox', 1 ),
		'date'    => array( 'Date d\'ouverture (AAAA-MM-JJ)', 'text', '2026-11-05' ),
		'heure'   => array( 'Heure d\'ouverture (HH:MM)', 'text', '09:00' ),
		'titre'   => array( 'Texte au-dessus de la date', 'text', 'Ouverture le' ),
		'message' => array( 'Phrase sous le compte à rebours (facultatif)', 'text', '' ),
	);
	foreach ( $fields as $k => $f ) {
		$wp_customize->add_setting( $p . 'ouverture_' . $k, array(
			'default'           => $f[2],
			'sanitize_callback' => 'checkbox' === $f[1] ? 'absint' : 'sanitize_text_field',
		) );
		$wp_customize->add_control( $p . 'ouverture_' . $k, array(
			'label'   => $f[0],
			'section' => $p . 'ouverture',
			'type'    => $f[1],
		) );
	}
} );

/** Bandeau de rappel dans l'administration tant que la page d'attente est active. */
add_action( 'admin_notices', function () {
	if ( ! current_user_can( 'edit_theme_options' ) || ! motor_ouverture_mod( 'active', 1 ) ) {
		return;
	}
	$d = motor_ouverture_date();
	if ( ! $d || $d->getTimestamp() <= current_time( 'timestamp', true ) ) {
		return;
	}
	echo '<div class="notice notice-warning"><p><strong>' . esc_html( motor_ouverture_cfg( 'nom', 'Site' ) ) . ' :</strong> les visiteurs voient la page « Ouverture le ' . esc_html( wp_date( 'j F Y', $d->getTimestamp() ) ) . ' » avec le compte à rebours. Vous voyez le vrai site parce que vous êtes connecté. Pour ouvrir le site : Apparence → Personnaliser → Ouverture prochaine → décochez la case.</p></div>';
} );

/** Interception de toutes les pages publiques. */
add_action( 'template_redirect', function () {
	if ( ! motor_ouverture_active() ) {
		return;
	}
	if ( is_feed() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}
	status_header( 200 );
	nocache_headers();
	header( 'Content-Type: text/html; charset=utf-8' );
	motor_ouverture_render();
	exit;
} );

function motor_ouverture_render() {
	$nom     = motor_ouverture_cfg( 'nom', get_bloginfo( 'name' ) );
	$couleur = motor_ouverture_cfg( 'couleur', '#0a8cff' );
	$logo    = motor_ouverture_cfg( 'logo' );
	$logo    = $logo ? get_template_directory_uri() . '/' . ltrim( $logo, '/' ) : '';
	$police  = motor_ouverture_cfg( 'police' );
	$d       = motor_ouverture_date();
	$iso     = $d->format( 'c' );
	$jour    = wp_date( 'j F Y', $d->getTimestamp() );
	$titre   = motor_ouverture_mod( 'titre', 'Ouverture le' );
	$message = motor_ouverture_mod( 'message', '' );
	$font_face = '';
	$font_name = 'system-ui, -apple-system, "Segoe UI", sans-serif';
	if ( is_array( $police ) && ! empty( $police[0] ) ) {
		$font_name = '"' . $police[0] . '", ' . $font_name;
		if ( ! empty( $police[1] ) ) {
			$font_face = '@font-face{font-family:"' . $police[0] . '";font-weight:300 800;font-display:swap;src:url("' . esc_url( get_template_directory_uri() . '/' . ltrim( $police[1], '/' ) ) . '") format("woff2")}';
		}
	}
	?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, follow">
<title><?php echo esc_html( $nom ); ?> — <?php echo esc_html( $titre . ' ' . $jour ); ?></title>
<?php if ( function_exists( 'wp_site_icon' ) ) { wp_site_icon(); } ?>
<style>
<?php echo $font_face; // phpcs:ignore WordPress.Security.EscapeOutput -- URL échappée ci-dessus ?>
*{box-sizing:border-box;margin:0}
html,body{height:100%}
body{font-family:<?php echo $font_name; // phpcs:ignore WordPress.Security.EscapeOutput ?>;background:#0b0c10;color:#fff;display:grid;place-items:center;text-align:center;padding:32px 20px;overflow:hidden;position:relative;-webkit-font-smoothing:antialiased}
body::before{content:"";position:fixed;inset:0;background:
  radial-gradient(60% 50% at 50% 35%,<?php echo esc_attr( $couleur ); ?>33,transparent 65%),
  radial-gradient(40% 35% at 85% 90%,<?php echo esc_attr( $couleur ); ?>22,transparent 60%),
  linear-gradient(180deg,#15171c 0%,#0b0c10 70%);z-index:-2}
body::after{content:"";position:fixed;inset:0;background-image:linear-gradient(rgba(255,255,255,.035) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.035) 1px,transparent 1px);background-size:56px 56px;mask-image:radial-gradient(70% 70% at 50% 50%,#000 20%,transparent 100%);-webkit-mask-image:radial-gradient(70% 70% at 50% 50%,#000 20%,transparent 100%);z-index:-1}
.o{display:grid;gap:26px;justify-items:center;max-width:860px;animation:in .9s ease both}
@keyframes in{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:none}}
.o__logo{width:min(300px,64vw);height:auto;filter:drop-shadow(0 20px 40px rgba(0,0,0,.6))}
.o__nom{font-size:clamp(1.1rem,2.4vw,1.5rem);font-weight:600;letter-spacing:.32em;text-transform:uppercase;color:rgba(255,255,255,.72)}
.o__kicker{display:inline-flex;align-items:center;gap:.7em;padding:9px 18px;border-radius:999px;border:1px solid rgba(255,255,255,.18);background:rgba(255,255,255,.05);font-size:.72rem;font-weight:700;letter-spacing:.18em;text-transform:uppercase}
.o__kicker::before{content:"";width:7px;height:7px;border-radius:50%;background:<?php echo esc_attr( $couleur ); ?>;box-shadow:0 0 12px <?php echo esc_attr( $couleur ); ?>}
.o__date{font-size:clamp(2rem,6.5vw,4.4rem);font-weight:800;line-height:1.05;letter-spacing:-.02em}
.o__date em{font-style:italic;color:<?php echo esc_attr( $couleur ); ?>}
.o__cd{display:flex;flex-wrap:wrap;justify-content:center;gap:12px;margin-top:6px}
.o__cell{min-width:clamp(74px,16vw,118px);padding:16px 10px 12px;border-radius:18px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);backdrop-filter:blur(8px)}
.o__cell b{display:block;font-size:clamp(1.9rem,5.2vw,3.2rem);font-weight:800;line-height:1;font-variant-numeric:tabular-nums;color:#fff}
.o__cell span{display:block;margin-top:8px;font-size:.64rem;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:rgba(255,255,255,.55)}
.o__msg{color:rgba(255,255,255,.7);font-size:1rem;max-width:520px;line-height:1.6}
.o__foot{margin-top:10px;font-size:.78rem;color:rgba(255,255,255,.4);letter-spacing:.06em}
.o__open{display:none}
.is-open .o__cd,.is-open .o__kicker{display:none}
.is-open .o__open{display:inline-block;margin-top:8px;padding:14px 26px;border-radius:999px;background:<?php echo esc_attr( $couleur ); ?>;color:#fff;font-weight:700;text-decoration:none}
@media (prefers-reduced-motion:reduce){.o{animation:none}}
</style>
</head>
<body>
<main class="o" id="o" data-date="<?php echo esc_attr( $iso ); ?>">
	<?php if ( $logo ) : ?>
	<img class="o__logo" src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $nom ); ?>">
	<?php else : ?>
	<p class="o__nom"><?php echo esc_html( $nom ); ?></p>
	<?php endif; ?>
	<p class="o__kicker"><?php echo esc_html( $nom ); ?> · Site en préparation</p>
	<h1 class="o__date"><?php echo esc_html( $titre ); ?> <em><?php echo esc_html( $jour ); ?></em></h1>
	<div class="o__cd" aria-live="polite" aria-label="Compte à rebours">
		<div class="o__cell"><b id="cd-j">—</b><span>jours</span></div>
		<div class="o__cell"><b id="cd-h">—</b><span>heures</span></div>
		<div class="o__cell"><b id="cd-m">—</b><span>minutes</span></div>
		<div class="o__cell"><b id="cd-s">—</b><span>secondes</span></div>
	</div>
	<?php if ( $message ) : ?><p class="o__msg"><?php echo esc_html( $message ); ?></p><?php endif; ?>
	<a class="o__open" href="<?php echo esc_url( home_url( '/' ) ); ?>">Découvrir le site</a>
	<p class="o__foot">© <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php echo esc_html( $nom ); ?></p>
</main>
<script>
(function(){
  var el=document.getElementById('o'),cible=new Date(el.getAttribute('data-date')).getTime();
  var j=document.getElementById('cd-j'),h=document.getElementById('cd-h'),m=document.getElementById('cd-m'),s=document.getElementById('cd-s');
  var p=function(n){return n<10?'0'+n:String(n);};
  function maj(){
    var d=cible-Date.now();
    if(d<=0){el.classList.add('is-open');return;}
    var sec=Math.floor(d/1000);
    j.textContent=Math.floor(sec/86400);h.textContent=p(Math.floor(sec%86400/3600));m.textContent=p(Math.floor(sec%3600/60));s.textContent=p(sec%60);
    setTimeout(maj,1000-(Date.now()%1000));
  }
  maj();
})();
</script>
</body>
</html>
	<?php
}
