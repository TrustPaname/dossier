<?php
/**
 * Conditions générales de vente — générée par wordpress/build.py (wordpress/legal.py). Ne pas modifier ici.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Conditions générales de vente — <?php echo esc_html( mc_legal_nom() ); ?></title>
<meta name="description" content="Conditions générales de vente : véhicules d'occasion, reprise, recherche, location, expertise.">
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
      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo-motor-consulting-light-300.png' ); ?>" alt="<?php echo esc_html( mc_legal_nom() ); ?>" width="300" height="172">
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
    <p class="label">CGV</p>
    <h1>Conditions générales de vente</h1>
    <p class="legal__maj">Dernière mise à jour : 19 octobre 2026</p>

    <p class="legal__intro">Les présentes conditions générales de vente (« CGV ») régissent les relations entre <?php mc_legal( 'raison' ); ?> (« <?php echo esc_html( mc_legal_nom() ); ?> », « le Professionnel ») et toute personne physique ou morale (« le Client ») qui recourt à ses services : vente de véhicules d'occasion, reprise et rachat, recherche et négociation, location de véhicules, expertise et conseil. Toute commande implique l'acceptation sans réserve des présentes CGV, dont le Client reconnaît avoir pris connaissance avant de s'engager.</p>

    <h2>1. Identification du Professionnel</h2>
    <p><?php mc_legal( 'raison' ); ?>, <?php mc_legal( 'forme' ); ?> au capital de <?php mc_legal( 'capital' ); ?>, RCS <?php mc_legal( 'rcs' ); ?>, SIRET <?php mc_legal( 'siret' ); ?>, TVA intracommunautaire <?php mc_legal( 'tva' ); ?>. Siège : <?php echo esc_html( motor_opt( 'address' ) ); ?>. Téléphone : <a href="tel:<?php echo esc_attr( motor_opt( 'phone_e164' ) ); ?>"><?php echo esc_html( motor_opt( 'phone_display' ) ); ?></a>. E-mail : <a href="mailto:<?php echo esc_html( motor_opt( 'email' ) ); ?>"><?php echo esc_html( motor_opt( 'email' ) ); ?></a>.</p>

    <h2>2. Véhicules d'occasion proposés à la vente</h2>
    <p>Chaque véhicule fait l'objet d'une description précisant sa marque, son modèle, sa version, sa date de première mise en circulation, son kilométrage au compteur, son énergie, sa boîte de vitesses et ses principaux équipements. Les véhicules de plus de quatre ans sont vendus avec un procès-verbal de contrôle technique de moins de six mois. Les photographies et descriptions publiées sur le site sont données à titre indicatif et peuvent comporter des erreurs ; elles ne constituent pas une offre contractuelle. Le Client est invité à examiner et à essayer le véhicule avant la commande. Seul le bon de commande signé par les deux parties fait foi.</p>

    <h2>3. Prix</h2>
    <p>Les prix sont exprimés en euros toutes taxes comprises. Sauf mention contraire sur le bon de commande, ils ne comprennent pas les frais d'immatriculation (certificat d'immatriculation, taxes régionales et malus éventuel), ni les frais de livraison à domicile, qui sont facturés en sus sur devis. Les prix affichés sur le site peuvent être modifiés à tout moment ; le prix applicable est celui figurant sur le bon de commande.</p>

    <h2>4. Commande et réservation</h2>
    <p>La vente est conclue par la signature d'un bon de commande précisant le véhicule, le prix, les éventuelles prestations annexes, le mode de paiement et la date de livraison prévue. Un acompte de 10 % du prix est versé à la commande, sauf accord contraire. Le véhicule est alors retiré de la vente. En cas d'annulation par le Client en dehors des cas prévus par la loi, l'acompte reste acquis au Professionnel à titre d'indemnité ; en cas d'annulation par le Professionnel, l'acompte est restitué au double, conformément à l'article 1590 du Code civil.</p>

    <h2>5. Paiement</h2>
    <p>Le solde du prix est payable au plus tard à la livraison, par virement bancaire ou chèque de banque. Aucun véhicule ni document n'est remis avant l'encaissement complet du prix. Lorsque le Client sollicite un financement auprès d'un organisme de crédit, la vente est conclue sous la condition suspensive de l'obtention du prêt, conformément aux articles L.312-44 et suivants du Code de la consommation ; en cas de refus du financement, l'acompte est intégralement restitué. Pour les professionnels, tout retard de paiement entraîne de plein droit des pénalités calculées au taux de trois fois le taux d'intérêt légal et une indemnité forfaitaire de recouvrement de 40 €.</p>

    <h2>6. Livraison et remise du véhicule</h2>
    <p>Le véhicule est remis au Client dans nos locaux, <?php echo esc_html( motor_opt( 'address' ) ); ?>, à la date convenue sur le bon de commande, ou livré à l'adresse de son choix sur devis. Le Client reçoit le certificat d'immatriculation barré et signé ou son récépissé, le certificat de cession, le certificat de situation administrative (non-gage) de moins de 15 jours, le procès-verbal de contrôle technique, le carnet d'entretien et les clés disponibles. Un état du véhicule contradictoire est établi à la remise ; toute réserve doit y être mentionnée. En cas de retard de livraison supérieur à sept jours imputable au Professionnel, le Client peut, après mise en demeure restée sans effet, résoudre la vente et obtenir le remboursement des sommes versées.</p>

    <h2>7. Transfert de propriété et des risques</h2>
    <p>Le transfert de propriété intervient au paiement intégral du prix ; le transfert des risques intervient à la remise effective du véhicule au Client, qui doit l'assurer à compter de cette date.</p>

    <h2>8. Garanties légales</h2>
    <p>Le Client consommateur bénéficie de la garantie légale de conformité (articles L.217-3 à L.217-20 du Code de la consommation) et de la garantie des vices cachés (articles 1641 à 1649 du Code civil). Pour un véhicule d'occasion, les défauts de conformité qui apparaissent dans les douze mois suivant la livraison sont présumés exister au jour de la livraison, sauf preuve contraire. Le consommateur dispose d'un délai de deux ans à compter de la délivrance pour agir ; il peut choisir entre la réparation et le remplacement du bien, sous réserve des conditions de coût prévues à l'article L.217-12, et obtenir à défaut une réduction du prix ou la résolution de la vente. Ces garanties s'appliquent indépendamment de toute garantie commerciale éventuellement proposée, dont les conditions sont précisées sur le bon de commande. Elles ne couvrent pas l'usure normale, les pièces d'usure, les défauts connus du Client lors de la vente ni les dommages résultant d'un usage non conforme, d'un défaut d'entretien ou d'une intervention extérieure.</p>
    <p>Pour les ventes entre professionnels, le véhicule est vendu en l'état, sans autre garantie que celle expressément convenue.</p>

    <h2>9. Droit de rétractation</h2>
    <p>Les ventes conclues dans les locaux du Professionnel ne sont pas soumises au droit de rétractation. Pour les contrats conclus à distance ou hors établissement, le consommateur dispose d'un délai de quatorze jours à compter de la livraison pour se rétracter sans motif (articles L.221-18 et suivants du Code de la consommation), en nous adressant une déclaration dénuée d'ambiguïté par e-mail ou par courrier. Le véhicule doit être restitué dans l'état où il a été livré, les frais de retour restant à la charge du Client ; sa responsabilité peut être engagée en cas de dépréciation résultant d'une utilisation allant au-delà de ce qui est nécessaire pour établir sa nature et son bon fonctionnement.</p>

    <h2>10. Reprise et rachat de véhicule</h2>
    <p>L'estimation en ligne est gratuite et indicative. Une offre ferme est formulée après inspection du véhicule et vérification de ses documents ; elle est valable sept jours, sous réserve que le véhicule soit conforme à la description faite par le Client et qu'aucun événement n'en modifie l'état entre-temps. Le Client garantit être propriétaire du véhicule, que celui-ci est libre de tout gage, opposition ou location avec option d'achat, et il remet le certificat d'immatriculation, le certificat de situation administrative, le contrôle technique, les clés et le carnet d'entretien. Le paiement intervient par virement sous quarante-huit heures ouvrées après la remise du véhicule et des documents. Toute déclaration inexacte (kilométrage, sinistres, modifications) peut entraîner la révision du prix ou l'annulation de la transaction.</p>

    <h2>11. Mission de recherche et de négociation</h2>
    <p>Le Client peut confier au Professionnel la recherche d'un véhicule correspondant à un cahier des charges défini ensemble. La mission fait l'objet d'un mandat écrit précisant le budget, les critères, la durée et les honoraires du Professionnel, qui ne sont dus qu'en cas de conclusion de l'achat sauf stipulation contraire. Le Professionnel est tenu d'une obligation de moyens : il sélectionne, inspecte et négocie les véhicules proposés, mais la décision d'achat appartient au Client.</p>

    <h2>12. Location de véhicule</h2>
    <p>Toute location fait l'objet d'un contrat précisant le véhicule, la durée, le kilométrage inclus, le prix, le dépôt de garantie et le montant de la franchise. Le conducteur doit être âgé d'au moins 21 ans, titulaire d'un permis de conduire valide depuis plus de trois ans et présenter une pièce d'identité et un justificatif de domicile. Un état des lieux contradictoire est établi au départ et au retour ; le véhicule est restitué au même niveau de carburant et dans l'état où il a été remis, les dommages, le carburant manquant, les kilomètres supplémentaires et le nettoyage éventuel étant facturés selon la grille jointe au contrat. Les amendes, contraventions et frais de fourrière encourus pendant la location sont à la charge du Client, majorés de frais de gestion. Le dépôt de garantie est restitué dans les quinze jours suivant le retour, déduction faite des sommes dues.</p>

    <h2>13. Expertise et conseil</h2>
    <p>Les prestations d'expertise (inspection avant achat, évaluation, accompagnement) donnent lieu à un rapport écrit fondé sur un examen visuel et, le cas échéant, un essai routier, sans démontage. Elles relèvent d'une obligation de moyens et ne constituent ni une garantie du véhicule ni une expertise judiciaire.</p>

    <h2>14. Responsabilité</h2>
    <p>La responsabilité du Professionnel ne saurait être engagée en cas d'inexécution ou de mauvaise exécution due au fait du Client, d'un tiers ou à un cas de force majeure. Pour les Clients professionnels, la responsabilité du Professionnel est limitée au montant de la prestation concernée.</p>

    <h2>15. Données personnelles</h2>
    <p>Les données du Client sont traitées conformément à notre <a href="<?php echo esc_url( home_url( '/confidentialite/' ) ); ?>">politique de confidentialité</a>.</p>

    <h2>16. Médiation et litiges</h2>
    <p>En cas de réclamation, le Client est invité à nous contacter en priorité à <a href="mailto:<?php echo esc_html( motor_opt( 'email' ) ); ?>"><?php echo esc_html( motor_opt( 'email' ) ); ?></a>. À défaut de solution amiable dans un délai de deux mois, le consommateur peut saisir gratuitement le médiateur de la consommation : <?php mc_legal( 'mediateur' ); ?> — <?php mc_legal( 'mediateur_url' ); ?>, ou utiliser la plateforme européenne de règlement en ligne des litiges (<a href="https://ec.europa.eu/consumers/odr" target="_blank" rel="noopener">ec.europa.eu/consumers/odr</a>). Les présentes CGV sont soumises au droit français ; à défaut d'accord amiable, les tribunaux français sont compétents, et pour les professionnels le tribunal de commerce du siège du Professionnel.</p>

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
