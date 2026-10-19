<?php
/**
 * Mentions légales — générée par wordpress/build.py (wordpress/legal.py). Ne pas modifier ici.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mentions légales — <?php echo esc_html( mc_legal_nom() ); ?></title>
<meta name="description" content="Mentions légales du site : éditeur, hébergeur, propriété intellectuelle, médiation.">
<meta name="robots" content="noindex, follow">
<link rel="icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/favicon.svg" type="image/svg+xml">

<script>document.documentElement.classList.add("js");</script>
<?php wp_head(); ?>
</head>
<body class="legal-page">
<a class="skip-link" href="#main">Aller au contenu principal</a>
<header class="header" id="header">
  <div class="container header__inner">
    <a class="logo logo--compact" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_html( mc_legal_nom() ); ?>, retour à l'accueil">
      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo-motors-studio-light.png' ); ?>" alt="<?php echo esc_html( mc_legal_nom() ); ?>" width="300" height="172">
    </a>
    <nav class="nav legal__topnav" aria-label="Navigation">
      <div class="nav__cta">
        <a class="nav__tel" href="tel:<?php echo esc_attr( motor_opt( 'phone_e164' ) ); ?>"><?php echo esc_html( motor_opt( 'phone_display' ) ); ?></a>
        <a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">Retour au site</a>
      </div>
    </nav>
  </div>
</header>
<main id="main" class="legal">
  <div class="container legal__inner">
    <p class="label">Informations légales</p>
    <h1>Mentions légales</h1>
    <p class="legal__maj">Dernière mise à jour : 19 octobre 2026</p>

    <h2>Éditeur du site</h2>
    <p>Le site <strong><?php echo esc_html( wp_parse_url( home_url(), PHP_URL_HOST ) ); ?></strong> est édité par la société <strong><?php mc_legal( 'raison' ); ?></strong>, <?php mc_legal( 'forme' ); ?> au capital de <?php mc_legal( 'capital' ); ?>, immatriculée au Registre du commerce et des sociétés de <?php mc_legal( 'rcs' ); ?> sous le numéro SIRET <?php mc_legal( 'siret' ); ?>, numéro de TVA intracommunautaire <?php mc_legal( 'tva' ); ?>.</p>
    <ul>
      <li>Siège social : <?php echo esc_html( motor_opt( 'address' ) ); ?></li>
      <li>Téléphone : <a href="tel:<?php echo esc_attr( motor_opt( 'phone_e164' ) ); ?>"><?php echo esc_html( motor_opt( 'phone_display' ) ); ?></a></li>
      <li>E-mail : <a href="mailto:<?php echo esc_html( motor_opt( 'email' ) ); ?>"><?php echo esc_html( motor_opt( 'email' ) ); ?></a></li>
      <li>Directeur de la publication : <?php mc_legal( 'gerant' ); ?></li>
    </ul>

    <h2>Hébergement</h2>
    <p>Le site est hébergé par <strong>OVH SAS</strong>, société au capital de 10 174 560 €, RCS Lille Métropole 424 761 419 00045, dont le siège social est situé 2 rue Kellermann, 59100 Roubaix, France. Téléphone : 1007. Site : <a href="https://www.ovhcloud.com" target="_blank" rel="noopener">www.ovhcloud.com</a>.</p>

    <h2>Activité</h2>
    <p><?php echo esc_html( mc_legal_nom() ); ?> est un atelier de carrosserie, peinture et mécanique automobile toutes marques. Les prestations, délais et prix mentionnés sur le site sont donnés à titre indicatif ; seul le devis accepté et l'ordre de réparation signé engagent les parties. Les exemples d'interventions présentés illustrent les prestations courantes de l'atelier.</p>

    <h2>Propriété intellectuelle</h2>
    <p>L'ensemble des éléments du site (structure, textes, logos, images, graphismes, vidéos, code) est protégé par le droit de la propriété intellectuelle et reste la propriété exclusive de <?php mc_legal( 'raison' ); ?> ou de ses partenaires. Toute reproduction, représentation, modification ou diffusion, totale ou partielle, sans autorisation écrite préalable est interdite et constitue une contrefaçon sanctionnée par les articles L.335-2 et suivants du Code de la propriété intellectuelle. Les marques et logos de constructeurs cités appartiennent à leurs propriétaires respectifs et ne sont utilisés qu'à des fins d'identification des véhicules.</p>

    <h2>Responsabilité</h2>
    <p><?php mc_legal( 'raison' ); ?> s'efforce d'assurer l'exactitude et la mise à jour des informations diffusées sur le site, dont elle se réserve le droit de corriger le contenu à tout moment et sans préavis. Elle ne saurait être tenue responsable des erreurs, omissions ou de l'indisponibilité temporaire du site, ni des dommages directs ou indirects résultant de l'accès au site ou de son utilisation. Les liens vers des sites tiers sont fournis à titre d'information ; <?php mc_legal( 'raison' ); ?> n'exerce aucun contrôle sur leur contenu et décline toute responsabilité à leur égard.</p>

    <h2>Données personnelles et cookies</h2>
    <p>Les traitements de données réalisés par l'intermédiaire du site sont décrits dans notre <a href="<?php echo esc_url( home_url( '/confidentialite/' ) ); ?>">politique de confidentialité</a>. Le site n'utilise pas de cookies publicitaires ni de traceurs de mesure d'audience ; seuls des cookies strictement nécessaires au fonctionnement peuvent être déposés.</p>

    <h2>Médiation de la consommation</h2>
    <p>Conformément aux articles L.612-1 et suivants du Code de la consommation, le consommateur peut recourir gratuitement à un médiateur de la consommation en vue de la résolution amiable d'un litige l'opposant à <?php mc_legal( 'raison' ); ?>. Médiateur compétent : <?php mc_legal( 'mediateur' ); ?> — <?php mc_legal( 'mediateur_url' ); ?>. La plateforme européenne de règlement en ligne des litiges est accessible à l'adresse <a href="https://ec.europa.eu/consumers/odr" target="_blank" rel="noopener">ec.europa.eu/consumers/odr</a>.</p>

    <h2>Crédits</h2>
    <p>Conception et réalisation du site : <?php mc_legal( 'raison' ); ?>. Cartographie : © les contributeurs <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a>.</p>

    <h2>Droit applicable</h2>
    <p>Les présentes mentions légales sont soumises au droit français. En cas de litige et à défaut de résolution amiable, les tribunaux français seront seuls compétents.</p>

    <nav class="legal__nav" aria-label="Autres pages légales">
      <a href="<?php echo esc_url( home_url( '/mentions-legales/' ) ); ?>">Mentions légales</a>
      <a href="<?php echo esc_url( home_url( '/confidentialite/' ) ); ?>">Politique de confidentialité</a>
      <a href="<?php echo esc_url( home_url( '/cgv/' ) ); ?>">Conditions générales de vente</a>
    </nav>
  </div>
</main>
<footer class="footer footer--legal">
  <div class="container footer__bottom">
    <p>© <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php echo esc_html( mc_legal_nom() ); ?></p>
    <ul class="footer__legal"><li><a href="<?php echo esc_url( home_url( '/mentions-legales/' ) ); ?>">Mentions légales</a></li><li><a href="<?php echo esc_url( home_url( '/confidentialite/' ) ); ?>">Confidentialité</a></li><li><a href="<?php echo esc_url( home_url( '/cgv/' ) ); ?>">CGV</a></li></ul>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
