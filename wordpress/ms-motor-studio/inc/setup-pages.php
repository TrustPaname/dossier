<?php
/**
 * MS MOTORS STUDIO — création automatique des pages à l'activation du thème.
 *
 * À la première activation, le thème crée les pages du site avec le bon
 * gabarit, définit la page d'accueil et remplit les pages légales.
 * L'opération ne s'exécute qu'une fois et ne touche jamais aux pages
 * existantes.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function msms_creer_pages(): void {
	$pages = array(
		'accueil' => array(
			'titre'   => 'Accueil',
			'gabarit' => '',
		),
		'carrosserie-peinture' => array(
			'titre'   => 'Carrosserie et peinture',
			'gabarit' => 'page-templates/service.php',
		),
		'mecanique-entretien' => array(
			'titre'   => 'Mécanique et entretien',
			'gabarit' => 'page-templates/service.php',
		),
		'pare-brise-vitrage' => array(
			'titre'   => 'Pare-brise et vitrage',
			'gabarit' => 'page-templates/service.php',
		),
		'pneumatiques' => array(
			'titre'   => 'Pneumatiques',
			'gabarit' => 'page-templates/service.php',
		),
		'atelier' => array(
			'titre'   => 'L’atelier',
			'gabarit' => 'page-templates/atelier.php',
		),
		'contact' => array(
			'titre'   => 'Contact et rendez-vous',
			'gabarit' => 'page-templates/contact.php',
		),
		'mentions-legales' => array(
			'titre'   => 'Mentions légales',
			'gabarit' => '',
			'contenu' => msms_contenu_mentions(),
		),
		'politique-de-confidentialite' => array(
			'titre'   => 'Politique de confidentialité',
			'gabarit' => '',
			'contenu' => msms_contenu_confidentialite(),
		),
	);

	foreach ( $pages as $slug => $page ) {
		if ( get_page_by_path( $slug ) ) {
			continue; // Ne jamais écraser une page existante.
		}
		$id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_name'    => $slug,
				'post_title'   => $page['titre'],
				'post_content' => $page['contenu'] ?? '',
			)
		);
		if ( $id && ! is_wp_error( $id ) && $page['gabarit'] ) {
			update_post_meta( $id, '_wp_page_template', $page['gabarit'] );
		}
	}

	// Page d'accueil statique.
	$accueil = get_page_by_path( 'accueil' );
	if ( $accueil ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $accueil->ID );
	}
}
add_action( 'after_switch_theme', 'msms_creer_pages' );

/** Contenu de la page Mentions légales (blocs WordPress, modifiable ensuite). */
function msms_contenu_mentions(): string {
	$nom     = msms_get( 'nom' );
	$adresse = msms_adresse();
	$tel     = msms_get( 'telephone' );
	$email   = msms_get( 'email' );

	return <<<HTML
<!-- wp:heading --><h2>Éditeur du site</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>{$nom} — [forme juridique à compléter]<br>{$adresse}<br>Téléphone : {$tel}<br>E-mail : {$email}</p><!-- /wp:paragraph -->
<!-- wp:paragraph --><p>SIRET : [à compléter]<br>RCS : [à compléter]<br>TVA intracommunautaire : [à compléter]<br>Directeur de la publication : [à compléter]<br>Assurance professionnelle : [à compléter]</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2>Hébergement</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>[Nom et coordonnées de l’hébergeur du site — à compléter selon votre offre d’hébergement WordPress.]</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2>Propriété intellectuelle</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>L’ensemble des contenus du site (textes, identité visuelle, photographies et vidéos) est la propriété de {$nom}, sauf mention contraire. Toute reproduction ou diffusion sans autorisation écrite préalable est interdite.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2>Responsabilité</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Les informations publiées sur ce site sont données à titre indicatif. Les prestations, les délais et les tarifs sont confirmés par un devis établi après examen du véhicule à l’atelier. Les offres promotionnelles sont soumises aux conditions affichées à l’atelier et à leur période de validité.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2>Médiation de la consommation</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>En cas de litige non résolu directement avec l’atelier, le client peut recourir gratuitement à un médiateur de la consommation. Les coordonnées du médiateur retenu sont [à compléter] et affichées à l’atelier.</p><!-- /wp:paragraph -->
HTML;
}

/** Contenu de la page Politique de confidentialité. */
function msms_contenu_confidentialite(): string {
	$nom     = msms_get( 'nom' );
	$adresse = msms_adresse();
	$email   = msms_get( 'email' );

	return <<<HTML
<!-- wp:heading --><h2>Responsable du traitement</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>{$nom}, {$adresse}. Pour toute question relative à vos données : {$email}.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2>Données collectées</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Seules les informations saisies dans le formulaire de demande de rendez-vous sont collectées : nom, téléphone, adresse e-mail si vous la renseignez, prestation souhaitée, informations sur le véhicule (marque, modèle, immatriculation facultative) et contenu du message. Le site ne pratique aucun profilage, n’utilise pas de régie publicitaire et ne revend aucune donnée.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2>Finalité et base légale</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Ces données servent uniquement à traiter votre demande, à vous recontacter et à préparer l’intervention. Le traitement repose sur votre consentement, recueilli par la case à cocher du formulaire, et sur les mesures précontractuelles nécessaires à l’établissement d’un devis.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2>Durée de conservation</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Les demandes sans suite sont conservées douze mois. Lorsqu’une intervention est réalisée, les informations liées au dossier sont conservées pendant la durée légale applicable aux documents comptables et aux garanties.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2>Cookies</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Ce thème ne dépose aucun cookie publicitaire ni cookie de mesure d’audience ; aucune bannière de consentement n’est donc nécessaire au titre du thème. Si vous ajoutez une extension de statistiques ou de publicité, il vous appartient de mettre en place la gestion du consentement correspondante. La carte affichée sur le site est fournie par OpenStreetMap ; son chargement transmet votre adresse IP à ce service, comme toute consultation d’un site externe.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2>Vos droits</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>Vous disposez d’un droit d’accès, de rectification, d’effacement, de limitation et d’opposition sur vos données. Écrivez-nous à {$email} ou par courrier à l’adresse de l’atelier. Vous pouvez également introduire une réclamation auprès de la CNIL (www.cnil.fr).</p><!-- /wp:paragraph -->
HTML;
}
