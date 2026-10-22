<?php
/**
 * Envoi des e-mails du site par SMTP (boîte Zimbra OVH ou autre) + page de test.
 *
 * Le thème définit $motor_mail avant l'inclusion :
 *   array( 'prefix' => 'motor_', 'opt' => 'motor_opt', 'nom' => 'Motor Consulting' )
 *
 * - Apparence → Personnaliser → Envoi des e-mails (SMTP) : serveur, port,
 *   adresse et mot de passe de la boîte qui envoie.
 * - Réglages → E-mails du site : état, dernière erreur, bouton de test.
 * Sans mot de passe SMTP, WordPress envoie par le serveur web (moins fiable).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$GLOBALS['mc_mail_cfg'] = array_merge( array(
	'prefix' => 'motor_',
	'opt'    => 'motor_opt',
	'nom'    => get_bloginfo( 'name' ),
), isset( $motor_mail ) && is_array( $motor_mail ) ? $motor_mail : array() );

function mc_mail_cfg( $k ) {
	return $GLOBALS['mc_mail_cfg'][ $k ];
}

function mc_mail_defaults() {
	$opt = mc_mail_cfg( 'opt' );
	return array(
		'host'      => 'smtp.mail.ovh.net',
		'port'      => '465',
		'secure'    => 'ssl',
		'user'      => function_exists( $opt ) ? call_user_func( $opt, 'email' ) : '',
		'pass'      => '',
		'from_name' => mc_mail_cfg( 'nom' ),
	);
}

function mc_mail_opt( $key ) {
	$d = mc_mail_defaults();
	$v = get_theme_mod( mc_mail_cfg( 'prefix' ) . 'smtp_' . $key, isset( $d[ $key ] ) ? $d[ $key ] : '' );
	return is_string( $v ) ? trim( $v ) : $v;
}

function mc_mail_smtp_actif() {
	return '' !== mc_mail_opt( 'pass' ) && '' !== mc_mail_opt( 'user' ) && '' !== mc_mail_opt( 'host' );
}

/* ------------------------------------------------------------------
 * Personnalisateur
 * ---------------------------------------------------------------- */
add_action( 'customize_register', function ( $wp_customize ) {
	$p = mc_mail_cfg( 'prefix' );
	$wp_customize->add_section( $p . 'smtp', array(
		'title'       => 'Envoi des e-mails (SMTP)',
		'description' => 'Pour que les demandes des formulaires arrivent à coup sûr, le site envoie les e-mails depuis votre boîte (ex. Zimbra OVH : serveur smtp.mail.ovh.net, port 465, SSL, votre adresse et son mot de passe). Laissez le mot de passe vide pour envoyer par le serveur web.',
		'priority'    => 24,
	) );
	$fields = array(
		'host'      => array( 'Serveur SMTP', 'text' ),
		'port'      => array( 'Port (465 pour SSL, 587 pour STARTTLS)', 'text' ),
		'secure'    => array( 'Sécurité', 'select', array( 'ssl' => 'SSL (port 465)', 'tls' => 'STARTTLS (port 587)', 'none' => 'Aucune' ) ),
		'user'      => array( 'Adresse e-mail qui envoie (identifiant SMTP)', 'email' ),
		'pass'      => array( 'Mot de passe de cette boîte', 'password' ),
		'from_name' => array( 'Nom de l\'expéditeur affiché', 'text' ),
	);
	$d = mc_mail_defaults();
	foreach ( $fields as $key => $f ) {
		$wp_customize->add_setting( $p . 'smtp_' . $key, array(
			'default'           => $d[ $key ],
			'sanitize_callback' => 'email' === $f[1] ? 'sanitize_email' : ( 'password' === $f[1] ? 'wp_unslash' : 'sanitize_text_field' ),
		) );
		$ctl = array( 'label' => $f[0], 'section' => $p . 'smtp', 'type' => $f[1] );
		if ( 'select' === $f[1] ) {
			$ctl['choices'] = $f[2];
		}
		$wp_customize->add_control( $p . 'smtp_' . $key, $ctl );
	}
} );

/* ------------------------------------------------------------------
 * Expéditeur et SMTP
 * ---------------------------------------------------------------- */
add_filter( 'wp_mail_from', function ( $from ) {
	$user = mc_mail_opt( 'user' );
	if ( is_email( $user ) ) {
		return $user; // l'expéditeur doit être la boîte authentifiée (exigé par Zimbra / anti-spam)
	}
	$opt = mc_mail_cfg( 'opt' );
	$site = function_exists( $opt ) ? call_user_func( $opt, 'email' ) : '';
	return is_email( $site ) ? $site : $from;
} );

add_filter( 'wp_mail_from_name', function ( $name ) {
	$n = mc_mail_opt( 'from_name' );
	return $n ? $n : $name;
} );

add_action( 'phpmailer_init', function ( $phpmailer ) {
	if ( ! mc_mail_smtp_actif() ) {
		return;
	}
	$phpmailer->isSMTP();
	$phpmailer->Host       = mc_mail_opt( 'host' );
	$phpmailer->Port       = (int) mc_mail_opt( 'port' );
	$phpmailer->SMTPAuth   = true;
	$phpmailer->Username   = mc_mail_opt( 'user' );
	$phpmailer->Password   = mc_mail_opt( 'pass' );
	$secure                = mc_mail_opt( 'secure' );
	$phpmailer->SMTPSecure = 'none' === $secure ? '' : $secure;
	$phpmailer->SMTPAutoTLS = 'none' !== $secure;
	$phpmailer->Timeout    = 15;
	$phpmailer->CharSet    = 'UTF-8';
} );

/** Mémorise la dernière erreur d'envoi pour l'afficher dans l'administration. */
add_action( 'wp_mail_failed', function ( $error ) {
	update_option( 'mc_mail_last_error', array(
		'date'    => wp_date( 'd/m/Y H:i' ),
		'message' => $error->get_error_message(),
	), false );
} );

/* ------------------------------------------------------------------
 * Réglages → E-mails du site : état + test
 * ---------------------------------------------------------------- */
add_action( 'admin_menu', function () {
	add_options_page( 'E-mails du site', 'E-mails du site', 'manage_options', 'mc-mail', 'mc_mail_admin_page' );
} );

add_action( 'admin_post_mc_mail_test', function () {
	if ( ! current_user_can( 'manage_options' ) || ! check_admin_referer( 'mc_mail_test' ) ) {
		wp_die( 'Accès refusé.' );
	}
	$opt = mc_mail_cfg( 'opt' );
	$to  = isset( $_POST['to'] ) ? sanitize_email( wp_unslash( $_POST['to'] ) ) : '';
	if ( ! is_email( $to ) && function_exists( $opt ) ) {
		$to = call_user_func( $opt, 'lead_email' );
	}
	delete_option( 'mc_mail_last_error' );
	$ok = wp_mail( $to, '[' . mc_mail_cfg( 'nom' ) . '] E-mail de test', "Ceci est un e-mail de test envoyé depuis le site " . home_url( '/' ) . " le " . wp_date( 'd/m/Y à H:i' ) . ".\n\nSi vous le lisez, l'envoi fonctionne." );
	$err = get_option( 'mc_mail_last_error' );
	set_transient( 'mc_mail_test_result', array( 'ok' => $ok && ! $err, 'to' => $to, 'error' => $err ? $err['message'] : '' ), 120 );
	wp_safe_redirect( admin_url( 'options-general.php?page=mc-mail' ) );
	exit;
} );

function mc_mail_admin_page() {
	$opt    = mc_mail_cfg( 'opt' );
	$lead   = function_exists( $opt ) ? call_user_func( $opt, 'lead_email' ) : get_option( 'admin_email' );
	$result = get_transient( 'mc_mail_test_result' );
	delete_transient( 'mc_mail_test_result' );
	$last   = get_option( 'mc_mail_last_error' );
	?>
	<div class="wrap">
		<h1>E-mails du site</h1>
		<?php if ( $result ) : ?>
			<?php if ( $result['ok'] ) : ?>
				<div class="notice notice-success"><p><strong>E-mail de test envoyé à <?php echo esc_html( $result['to'] ); ?>.</strong> Vérifiez la boîte de réception (et les indésirables) dans les deux minutes.</p></div>
			<?php else : ?>
				<div class="notice notice-error"><p><strong>L'envoi a échoué.</strong> <?php echo esc_html( $result['error'] ? $result['error'] : 'Le serveur a refusé l\'envoi sans message.' ); ?></p></div>
			<?php endif; ?>
		<?php endif; ?>
		<table class="form-table">
			<tr><th>Mode d'envoi</th><td><?php echo mc_mail_smtp_actif() ? '<strong style="color:#1a7f37">SMTP</strong> via ' . esc_html( mc_mail_opt( 'host' ) ) . ':' . esc_html( mc_mail_opt( 'port' ) ) . ' (' . esc_html( strtoupper( mc_mail_opt( 'secure' ) ) ) . ') avec ' . esc_html( mc_mail_opt( 'user' ) ) : '<strong style="color:#b26a00">Serveur web</strong> (sans SMTP) — moins fiable : <a href="' . esc_url( admin_url( 'customize.php?autofocus[section]=' . mc_mail_cfg( 'prefix' ) . 'smtp' ) ) . '">configurer le SMTP</a>'; ?></td></tr>
			<tr><th>Expéditeur</th><td><?php echo esc_html( apply_filters( 'wp_mail_from_name', '' ) ); ?> &lt;<?php echo esc_html( apply_filters( 'wp_mail_from', get_option( 'admin_email' ) ) ); ?>&gt;</td></tr>
			<tr><th>Destinataire des demandes</th><td><?php echo esc_html( $lead ); ?> — <a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=' . mc_mail_cfg( 'prefix' ) . 'coords' ) ); ?>">modifier</a></td></tr>
			<tr><th>Dernière erreur</th><td><?php echo $last ? '<span style="color:#b32d2e">' . esc_html( $last['date'] . ' — ' . $last['message'] ) . '</span>' : 'aucune'; ?></td></tr>
		</table>
		<h2>Envoyer un e-mail de test</h2>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'mc_mail_test' ); ?>
			<input type="hidden" name="action" value="mc_mail_test">
			<p><label>Envoyer à <input type="email" name="to" value="<?php echo esc_attr( $lead ); ?>" class="regular-text"></label></p>
			<?php submit_button( 'Envoyer le test', 'primary', 'submit', false ); ?>
		</form>
		<p class="description" style="margin-top:24px">Réglages recommandés pour une boîte Zimbra OVH : serveur <code>smtp.mail.ovh.net</code>, port <code>465</code>, SSL, identifiant = l'adresse complète, mot de passe de la boîte.</p>
	</div>
	<?php
}

/** Rappel dans l'administration tant que le SMTP n'est pas configuré ou qu'une erreur est enregistrée. */
add_action( 'admin_notices', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( $screen && 'settings_page_mc-mail' === $screen->id ) {
		return;
	}
	$last = get_option( 'mc_mail_last_error' );
	if ( $last ) {
		echo '<div class="notice notice-error"><p><strong>Un e-mail du site n\'a pas pu partir</strong> (' . esc_html( $last['date'] ) . ') : ' . esc_html( $last['message'] ) . ' — <a href="' . esc_url( admin_url( 'options-general.php?page=mc-mail' ) ) . '">voir et tester</a>.</p></div>';
	} elseif ( ! mc_mail_smtp_actif() ) {
		echo '<div class="notice notice-warning is-dismissible"><p><strong>E-mails des formulaires :</strong> l\'envoi passe par le serveur web, qui peut être filtré. Pour un envoi fiable, renseignez votre boîte dans <a href="' . esc_url( admin_url( 'customize.php?autofocus[section]=' . mc_mail_cfg( 'prefix' ) . 'smtp' ) ) . '">Apparence → Personnaliser → Envoi des e-mails (SMTP)</a>, puis testez dans <a href="' . esc_url( admin_url( 'options-general.php?page=mc-mail' ) ) . '">Réglages → E-mails du site</a>.</p></div>';
	}
} );
