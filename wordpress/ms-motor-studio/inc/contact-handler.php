<?php
/**
 * MS MOTORS STUDIO — traitement du formulaire de rendez-vous.
 *
 * Envoi réel via wp_mail() vers l'adresse e-mail du garage (réglable dans
 * Apparence → Personnaliser). Pour une délivrabilité fiable, installez une
 * extension SMTP (ex. « WP Mail SMTP ») : voir le guide d'installation.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function msms_traiter_contact(): void {
	$redirection = wp_get_referer() ?: msms_page_url( 'contact' );

	// Jeton de sécurité.
	if ( ! isset( $_POST['msms_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['msms_nonce'] ), 'msms_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'msg', 'erreur', $redirection ) );
		exit;
	}

	// Champ piège : rempli uniquement par les robots.
	if ( ! empty( $_POST['msms_societe'] ) ) {
		wp_safe_redirect( add_query_arg( 'msg', 'merci', $redirection ) );
		exit;
	}

	// Limitation : cinq envois par adresse IP et par heure.
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'inconnue';
	$cle = 'msms_limite_' . md5( $ip );
	$nb  = (int) get_transient( $cle );
	if ( $nb >= 5 ) {
		wp_safe_redirect( add_query_arg( 'msg', 'limite', $redirection ) );
		exit;
	}
	set_transient( $cle, $nb + 1, HOUR_IN_SECONDS );

	// Lecture et nettoyage des champs.
	$champ = static function ( string $nom, int $max = 200 ): string {
		$valeur = isset( $_POST[ $nom ] ) ? sanitize_text_field( wp_unslash( $_POST[ $nom ] ) ) : '';
		return mb_substr( trim( $valeur ), 0, $max );
	};
	$nom        = $champ( 'msms_nom', 120 );
	$telephone  = $champ( 'msms_telephone', 30 );
	$email      = sanitize_email( wp_unslash( $_POST['msms_email'] ?? '' ) );
	$prestation = $champ( 'msms_prestation', 80 );
	$vehicule   = $champ( 'msms_vehicule', 160 );
	$plaque     = $champ( 'msms_plaque', 20 );
	$message    = isset( $_POST['msms_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['msms_message'] ) ) : '';
	$message    = mb_substr( trim( $message ), 0, 4000 );
	$accord     = ! empty( $_POST['msms_consentement'] );

	// Validation.
	if ( mb_strlen( $nom ) < 2 || ! preg_match( '/^[+0-9][0-9 .\-()]{7,19}$/', $telephone ) || mb_strlen( $message ) < 10 || ! $accord ) {
		wp_safe_redirect( add_query_arg( 'msg', 'champs', $redirection ) );
		exit;
	}

	// Composition du message.
	$corps = implode( "\n", array(
		'Nouvelle demande de rendez-vous reçue depuis le site ' . msms_get( 'nom' ) . ' :',
		'',
		'Nom : ' . $nom,
		'Téléphone : ' . $telephone,
		'E-mail : ' . ( $email ?: 'non communiqué' ),
		'Prestation : ' . ( $prestation ?: 'non précisée' ),
		'Véhicule : ' . ( $vehicule ?: 'non communiqué' ),
		'Immatriculation : ' . ( $plaque ?: 'non communiquée' ),
		'',
		'Message :',
		$message,
	) );

	$entetes = array();
	if ( $email ) {
		$entetes[] = 'Reply-To: ' . $nom . ' <' . $email . '>';
	}

	wp_mail(
		msms_get( 'email' ),
		'Rendez-vous — ' . ( $prestation ?: 'demande' ) . ' — ' . $nom,
		$corps,
		$entetes
	);

	wp_safe_redirect( add_query_arg( 'msg', 'merci', $redirection ) );
	exit;
}
add_action( 'admin_post_msms_contact', 'msms_traiter_contact' );
add_action( 'admin_post_nopriv_msms_contact', 'msms_traiter_contact' );
