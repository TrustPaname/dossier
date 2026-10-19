# -*- coding: utf-8 -*-
"""
Pages légales (mentions légales, politique de confidentialité, CGV) générées
pour chaque site : version statique (HTML à la racine du site) et version
WordPress (legal-<slug>.php dans le thème, textes reliés au Personnalisateur).

Utilisé par wordpress/build.py. Les jetons {{x}} sont remplacés :
  - en statique par la valeur fournie dans la configuration du site ;
  - en PHP par un appel au Personnalisateur (coordonnées et informations légales).
"""
import os, re

MAJ = "19 octobre 2026"

# jetons communs : nom -> (valeur statique via cfg, expression PHP)
ACTIVITE = {
    "negoce":  "<p>{{nom}} exerce une activité de conseil automobile, d'achat, de vente et de location de véhicules d'occasion ainsi que de recherche, de négociation et d'expertise de véhicules pour le compte de particuliers et de professionnels. Les véhicules présentés sur le site sont proposés sous réserve de disponibilité ; les photographies, descriptions et prix sont donnés à titre indicatif et ne constituent pas une offre contractuelle. Seul le bon de commande signé fait foi.</p>",
    "holding": "<p>{{nom}} est la société holding du groupe automobile réunissant Motors Studio (carrosserie, peinture et mécanique) et Motor Consulting (achat, vente, dépôt-vente, expertise et location de véhicules d'occasion), à Mainvilliers près de Chartres. Le site présente le groupe et oriente vers les sites de chaque marque ; il ne propose ni vente en ligne ni prise de commande.</p>",
    "atelier": "<p>{{nom}} est un atelier de carrosserie, peinture et mécanique automobile toutes marques. Les prestations, délais et prix mentionnés sur le site sont donnés à titre indicatif ; seul le devis accepté et l'ordre de réparation signé engagent les parties. Les exemples d'interventions présentés illustrent les prestations courantes de l'atelier.</p>",
}

def tokens(cfg):
    opt = cfg["opt"]            # ex. motor_opt
    leg = cfg["legal_fn"]       # ex. mc_legal (echo) — défini dans inc-legal.php
    s = cfg["static"]
    t = {
        "nom":        (cfg["nom"],            "<?php echo esc_html( mc_legal_nom() ); ?>"),
        "home":       ("index.html",          "<?php echo esc_url( home_url( '/' ) ); ?>"),
        "domaine":    (cfg["domaine"],        "<?php echo esc_html( wp_parse_url( home_url(), PHP_URL_HOST ) ); ?>"),
        "logo":       (cfg["logo"],           "<?php echo esc_url( get_template_directory_uri() . '/" + cfg["logo"] + "' ); ?>"),
        "css":        (cfg.get("css_extra", ""),  ""),
        "maj":        (MAJ,                   MAJ),
        "annee":      ("2026",                "<?php echo esc_html( wp_date( 'Y' ) ); ?>"),
        "tel":        (s["tel"],              "<?php echo esc_html( %s( 'phone_display' ) ); ?>" % opt),
        "tel_link":   (s["tel_link"],         "<?php echo esc_attr( %s( 'phone_e164' ) ); ?>" % opt),
        "email":      (s["email"],            "<?php echo esc_html( %s( 'email' ) ); ?>" % opt),
        "adresse":    (s["adresse"],          "<?php echo esc_html( %s( 'address' ) ); ?>" % opt),
        "p_mentions": ("mentions-legales.html", "<?php echo esc_url( home_url( '/mentions-legales/' ) ); ?>"),
        "p_confid":   ("confidentialite.html",  "<?php echo esc_url( home_url( '/confidentialite/' ) ); ?>"),
        "p_cgv":      ("cgv.html",              "<?php echo esc_url( home_url( '/cgv/' ) ); ?>"),
    }
    act = ACTIVITE[cfg.get("type", "negoce")]
    t["activite"] = (act, act)
    for k in ("raison", "forme", "capital", "siret", "rcs", "tva", "gerant", "mediateur", "mediateur_url"):
        t[k] = (s.get(k) or "<span class=\"legal__todo\">à compléter</span>", "<?php %s( '%s' ); ?>" % (leg, k))
    return t

def fill(tpl, cfg, mode):
    t = tokens(cfg)
    i = 0 if mode == "static" else 1
    out = tpl
    for _ in range(3):
        out = re.sub(r"\{\{(\w+)\}\}", lambda m: t[m.group(1)][i], out)
    return out

# ------------------------------------------------------------------ gabarit
PAGE = """<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{titre} — {{nom}}</title>
<meta name="description" content="{desc}">
<meta name="robots" content="noindex, follow">
<link rel="icon" href="assets/img/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="assets/css/styles.css">{{css}}{style}
<script>document.documentElement.classList.add("js");</script>
</head>
<body class="legal-page">
<a class="skip-link" href="#main">Aller au contenu principal</a>
<header class="header" id="header">
  <div class="container header__inner">
    <a class="logo logo--compact" href="{{home}}" aria-label="{{nom}}, retour à l'accueil">
      <img src="{{logo}}" alt="{{nom}}" width="300" height="172">
    </a>
    <nav class="nav legal__topnav" aria-label="Navigation">
      <div class="nav__cta">
        <a class="nav__tel" href="tel:{{tel_link}}">{{tel}}</a>
        <a class="btn btn--primary" href="{{home}}">Retour au site</a>
      </div>
    </nav>
  </div>
</header>
<main id="main" class="legal">
  <div class="container legal__inner">
    <p class="label">{label}</p>
    <h1>{titre}</h1>
    <p class="legal__maj">Dernière mise à jour : {{maj}}</p>
{corps}
    <nav class="legal__nav" aria-label="Autres pages légales">
{nav}    </nav>
  </div>
</main>
<footer class="footer footer--legal">
  <div class="container footer__bottom">
    <p>© {{annee}} {{nom}}</p>
    <ul class="footer__legal">{footnav}</ul>
  </div>
</footer>
</body>
</html>
"""

# ------------------------------------------------------------------ contenus
MENTIONS = """
    <h2>Éditeur du site</h2>
    <p>Le site <strong>{{domaine}}</strong> est édité par la société <strong>{{raison}}</strong>, {{forme}} au capital de {{capital}}, immatriculée au Registre du commerce et des sociétés de {{rcs}} sous le numéro SIRET {{siret}}, numéro de TVA intracommunautaire {{tva}}.</p>
    <ul>
      <li>Siège social : {{adresse}}</li>
      <li>Téléphone : <a href="tel:{{tel_link}}">{{tel}}</a></li>
      <li>E-mail : <a href="mailto:{{email}}">{{email}}</a></li>
      <li>Directeur de la publication : {{gerant}}</li>
    </ul>

    <h2>Hébergement</h2>
    <p>Le site est hébergé par <strong>OVH SAS</strong>, société au capital de 10 174 560 €, RCS Lille Métropole 424 761 419 00045, dont le siège social est situé 2 rue Kellermann, 59100 Roubaix, France. Téléphone : 1007. Site : <a href="https://www.ovhcloud.com" target="_blank" rel="noopener">www.ovhcloud.com</a>.</p>

    <h2>Activité</h2>
    {{activite}}

    <h2>Propriété intellectuelle</h2>
    <p>L'ensemble des éléments du site (structure, textes, logos, images, graphismes, vidéos, code) est protégé par le droit de la propriété intellectuelle et reste la propriété exclusive de {{raison}} ou de ses partenaires. Toute reproduction, représentation, modification ou diffusion, totale ou partielle, sans autorisation écrite préalable est interdite et constitue une contrefaçon sanctionnée par les articles L.335-2 et suivants du Code de la propriété intellectuelle. Les marques et logos de constructeurs cités appartiennent à leurs propriétaires respectifs et ne sont utilisés qu'à des fins d'identification des véhicules.</p>

    <h2>Responsabilité</h2>
    <p>{{raison}} s'efforce d'assurer l'exactitude et la mise à jour des informations diffusées sur le site, dont elle se réserve le droit de corriger le contenu à tout moment et sans préavis. Elle ne saurait être tenue responsable des erreurs, omissions ou de l'indisponibilité temporaire du site, ni des dommages directs ou indirects résultant de l'accès au site ou de son utilisation. Les liens vers des sites tiers sont fournis à titre d'information ; {{raison}} n'exerce aucun contrôle sur leur contenu et décline toute responsabilité à leur égard.</p>

    <h2>Données personnelles et cookies</h2>
    <p>Les traitements de données réalisés par l'intermédiaire du site sont décrits dans notre <a href="{{p_confid}}">politique de confidentialité</a>. Le site n'utilise pas de cookies publicitaires ni de traceurs de mesure d'audience ; seuls des cookies strictement nécessaires au fonctionnement peuvent être déposés.</p>

    <h2>Médiation de la consommation</h2>
    <p>Conformément aux articles L.612-1 et suivants du Code de la consommation, le consommateur peut recourir gratuitement à un médiateur de la consommation en vue de la résolution amiable d'un litige l'opposant à {{raison}}. Médiateur compétent : {{mediateur}} — {{mediateur_url}}. La plateforme européenne de règlement en ligne des litiges est accessible à l'adresse <a href="https://ec.europa.eu/consumers/odr" target="_blank" rel="noopener">ec.europa.eu/consumers/odr</a>.</p>

    <h2>Crédits</h2>
    <p>Conception et réalisation du site : {{raison}}. Cartographie : © les contributeurs <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a>.</p>

    <h2>Droit applicable</h2>
    <p>Les présentes mentions légales sont soumises au droit français. En cas de litige et à défaut de résolution amiable, les tribunaux français seront seuls compétents.</p>
"""

CONFID = """
    <p class="legal__intro">{{raison}} (ci-après « {{nom}} », « nous ») accorde une grande importance à la protection de vos données personnelles. La présente politique décrit les données que nous collectons par l'intermédiaire du site {{domaine}}, l'usage que nous en faisons et vos droits, conformément au Règlement général sur la protection des données (RGPD, règlement UE 2016/679) et à la loi Informatique et Libertés.</p>

    <h2>1. Responsable du traitement</h2>
    <p>Le responsable du traitement est {{raison}}, {{adresse}}. Contact : <a href="mailto:{{email}}">{{email}}</a> — <a href="tel:{{tel_link}}">{{tel}}</a>.</p>

    <h2>2. Données collectées</h2>
    <p>Nous collectons uniquement les données que vous nous transmettez volontairement :</p>
    <ul>
      <li><strong>Formulaires d'estimation et de contact</strong> : nom, téléphone, adresse e-mail, informations sur votre véhicule (marque, modèle, année, kilométrage, carburant, état), message.</li>
      <li><strong>Prise de contact par WhatsApp, téléphone ou e-mail</strong> : votre numéro ou votre adresse, le contenu de vos échanges et les photos que vous nous envoyez.</li>
      <li><strong>Transaction ou réparation</strong> : en cas d'achat, de vente, de reprise, de location ou de réparation, les données nécessaires au contrat et aux formalités (identité, justificatif de domicile, permis de conduire, carte grise, immatriculation, dossier d'assurance, coordonnées bancaires pour le paiement ou la restitution d'un dépôt de garantie).</li>
      <li><strong>Données techniques</strong> : adresse IP et horodatage lors de l'envoi d'un formulaire, à des fins de sécurité et de lutte contre les abus.</li>
    </ul>

    <h2>3. Finalités et bases légales</h2>
    <ul>
      <li>Répondre à vos demandes d'estimation, de recherche de véhicule, de location ou d'information (mesures précontractuelles prises à votre demande).</li>
      <li>Établir, exécuter et suivre les contrats de vente, de reprise, de location ou de mandat de recherche (exécution du contrat) et accomplir les formalités légales associées, notamment la déclaration de cession et le livre de police (obligation légale).</li>
      <li>Gérer la relation commerciale, les réclamations et la comptabilité (obligation légale et intérêt légitime).</li>
      <li>Vous adresser, le cas échéant, des informations sur nos services similaires (intérêt légitime, avec possibilité de vous y opposer à tout moment).</li>
      <li>Assurer la sécurité du site et prévenir les fraudes (intérêt légitime).</li>
    </ul>

    <h2>4. Destinataires</h2>
    <p>Vos données sont destinées aux personnes habilitées de {{raison}}. Elles peuvent être transmises, dans la stricte limite des besoins, à nos prestataires : hébergeur du site (OVH, France), logiciel de gestion du stock et des annonces, organismes de financement ou d'assurance que vous sollicitez, service d'immatriculation (ANTS / habilitation SIV), garages et centres de contrôle technique partenaires. Lorsque vous nous contactez par WhatsApp, vos messages transitent par les services de WhatsApp (Meta Platforms Ireland Ltd), soumis à leur propre politique de confidentialité. Nous ne vendons ni ne louons vos données à des tiers.</p>

    <h2>5. Durée de conservation</h2>
    <ul>
      <li>Demandes sans suite (prospects) : 3 ans à compter du dernier contact.</li>
      <li>Clients : pendant la durée de la relation contractuelle puis 5 ans au titre de la prescription commerciale ; les pièces comptables sont conservées 10 ans.</li>
      <li>Registre des véhicules (livre de police) : conformément aux obligations légales applicables aux professionnels de l'automobile.</li>
      <li>Données techniques de sécurité : 12 mois maximum.</li>
    </ul>

    <h2>6. Vos droits</h2>
    <p>Vous disposez d'un droit d'accès, de rectification, d'effacement, de limitation du traitement, d'opposition et de portabilité de vos données, ainsi que du droit de définir des directives relatives à leur sort après votre décès. Pour l'exercer, écrivez-nous à <a href="mailto:{{email}}">{{email}}</a> ou par courrier à {{raison}}, {{adresse}}, en joignant si nécessaire un justificatif d'identité. Nous répondons dans un délai d'un mois. Vous pouvez également introduire une réclamation auprès de la CNIL (<a href="https://www.cnil.fr" target="_blank" rel="noopener">www.cnil.fr</a>, 3 place de Fontenoy, TSA 80715, 75334 Paris Cedex 07).</p>

    <h2>7. Cookies et contenus tiers</h2>
    <p>Le site n'utilise aucun cookie publicitaire ni outil de mesure d'audience. Seuls des éléments techniques strictement nécessaires (préférences d'affichage, protection des formulaires) peuvent être stockés dans votre navigateur. La carte de localisation est fournie par OpenStreetMap ; son affichage peut transmettre votre adresse IP à la fondation OpenStreetMap. Les boutons WhatsApp n'activent aucun traceur tant que vous ne cliquez pas dessus.</p>

    <h2>8. Sécurité</h2>
    <p>Le site est accessible exclusivement en HTTPS. Les données transmises par les formulaires sont chiffrées pendant leur transport et stockées sur des serveurs situés en France. L'accès aux données est limité aux personnes habilitées et protégé par mot de passe. Nous mettons en œuvre les mesures techniques et organisationnelles appropriées pour prévenir toute perte, altération ou accès non autorisé.</p>

    <h2>9. Modifications</h2>
    <p>Nous pouvons modifier la présente politique pour tenir compte de l'évolution de nos services ou de la réglementation. La version applicable est celle publiée sur le site à la date de votre visite.</p>
"""

CGV = """
    <p class="legal__intro">Les présentes conditions générales de vente (« CGV ») régissent les relations entre {{raison}} (« {{nom}} », « le Professionnel ») et toute personne physique ou morale (« le Client ») qui recourt à ses services : vente de véhicules d'occasion, reprise et rachat, recherche et négociation, location de véhicules, expertise et conseil. Toute commande implique l'acceptation sans réserve des présentes CGV, dont le Client reconnaît avoir pris connaissance avant de s'engager.</p>

    <h2>1. Identification du Professionnel</h2>
    <p>{{raison}}, {{forme}} au capital de {{capital}}, RCS {{rcs}}, SIRET {{siret}}, TVA intracommunautaire {{tva}}. Siège : {{adresse}}. Téléphone : <a href="tel:{{tel_link}}">{{tel}}</a>. E-mail : <a href="mailto:{{email}}">{{email}}</a>.</p>

    <h2>2. Véhicules d'occasion proposés à la vente</h2>
    <p>Chaque véhicule fait l'objet d'une description précisant sa marque, son modèle, sa version, sa date de première mise en circulation, son kilométrage au compteur, son énergie, sa boîte de vitesses et ses principaux équipements. Les véhicules de plus de quatre ans sont vendus avec un procès-verbal de contrôle technique de moins de six mois. Les photographies et descriptions publiées sur le site sont données à titre indicatif et peuvent comporter des erreurs ; elles ne constituent pas une offre contractuelle. Le Client est invité à examiner et à essayer le véhicule avant la commande. Seul le bon de commande signé par les deux parties fait foi.</p>

    <h2>3. Prix</h2>
    <p>Les prix sont exprimés en euros toutes taxes comprises. Sauf mention contraire sur le bon de commande, ils ne comprennent pas les frais d'immatriculation (certificat d'immatriculation, taxes régionales et malus éventuel), ni les frais de livraison à domicile, qui sont facturés en sus sur devis. Les prix affichés sur le site peuvent être modifiés à tout moment ; le prix applicable est celui figurant sur le bon de commande.</p>

    <h2>4. Commande et réservation</h2>
    <p>La vente est conclue par la signature d'un bon de commande précisant le véhicule, le prix, les éventuelles prestations annexes, le mode de paiement et la date de livraison prévue. Un acompte de 10 % du prix est versé à la commande, sauf accord contraire. Le véhicule est alors retiré de la vente. En cas d'annulation par le Client en dehors des cas prévus par la loi, l'acompte reste acquis au Professionnel à titre d'indemnité ; en cas d'annulation par le Professionnel, l'acompte est restitué au double, conformément à l'article 1590 du Code civil.</p>

    <h2>5. Paiement</h2>
    <p>Le solde du prix est payable au plus tard à la livraison, par virement bancaire ou chèque de banque. Aucun véhicule ni document n'est remis avant l'encaissement complet du prix. Lorsque le Client sollicite un financement auprès d'un organisme de crédit, la vente est conclue sous la condition suspensive de l'obtention du prêt, conformément aux articles L.312-44 et suivants du Code de la consommation ; en cas de refus du financement, l'acompte est intégralement restitué. Pour les professionnels, tout retard de paiement entraîne de plein droit des pénalités calculées au taux de trois fois le taux d'intérêt légal et une indemnité forfaitaire de recouvrement de 40 €.</p>

    <h2>6. Livraison et remise du véhicule</h2>
    <p>Le véhicule est remis au Client dans nos locaux, {{adresse}}, à la date convenue sur le bon de commande, ou livré à l'adresse de son choix sur devis. Le Client reçoit le certificat d'immatriculation barré et signé ou son récépissé, le certificat de cession, le certificat de situation administrative (non-gage) de moins de 15 jours, le procès-verbal de contrôle technique, le carnet d'entretien et les clés disponibles. Un état du véhicule contradictoire est établi à la remise ; toute réserve doit y être mentionnée. En cas de retard de livraison supérieur à sept jours imputable au Professionnel, le Client peut, après mise en demeure restée sans effet, résoudre la vente et obtenir le remboursement des sommes versées.</p>

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
    <p>Les données du Client sont traitées conformément à notre <a href="{{p_confid}}">politique de confidentialité</a>.</p>

    <h2>16. Médiation et litiges</h2>
    <p>En cas de réclamation, le Client est invité à nous contacter en priorité à <a href="mailto:{{email}}">{{email}}</a>. À défaut de solution amiable dans un délai de deux mois, le consommateur peut saisir gratuitement le médiateur de la consommation : {{mediateur}} — {{mediateur_url}}, ou utiliser la plateforme européenne de règlement en ligne des litiges (<a href="https://ec.europa.eu/consumers/odr" target="_blank" rel="noopener">ec.europa.eu/consumers/odr</a>). Les présentes CGV sont soumises au droit français ; à défaut d'accord amiable, les tribunaux français sont compétents, et pour les professionnels le tribunal de commerce du siège du Professionnel.</p>
"""

CGV_ATELIER = """
    <p class="legal__intro">Les présentes conditions générales (« CGV ») régissent les prestations de carrosserie, peinture, débosselage, vitrage, mécanique, entretien et services associés réalisées par {{raison}} (« {{nom}} », « l'Atelier ») pour toute personne physique ou morale (« le Client »). Toute commande de prestation implique l'acceptation sans réserve des présentes CGV, dont le Client reconnaît avoir pris connaissance avant de s'engager.</p>

    <h2>1. Identification de l'Atelier</h2>
    <p>{{raison}}, {{forme}} au capital de {{capital}}, RCS {{rcs}}, SIRET {{siret}}, TVA intracommunautaire {{tva}}. Atelier et siège : {{adresse}}. Téléphone : <a href="tel:{{tel_link}}">{{tel}}</a>. E-mail : <a href="mailto:{{email}}">{{email}}</a>.</p>

    <h2>2. Devis</h2>
    <p>Toute intervention fait l'objet d'un devis écrit gratuit, établi après examen du véhicule ou, pour une première estimation, à partir des photos et informations transmises par le Client. Le devis précise les travaux, les pièces, la main-d'œuvre, le délai prévisionnel et le prix TTC ; il est valable trente jours. Une estimation sur photos n'engage pas l'Atelier : elle est confirmée ou ajustée après examen du véhicule. Les travaux ne commencent qu'après acceptation du devis par le Client (signature, accord écrit ou e-mail), qui vaut ordre de réparation.</p>

    <h2>3. Travaux supplémentaires</h2>
    <p>Si, en cours d'intervention, des travaux non prévus au devis s'avèrent nécessaires (dommage caché, pièce défectueuse découverte au démontage), l'Atelier en informe le Client et lui soumet un devis complémentaire. Aucun travail supplémentaire payant n'est réalisé sans son accord. En cas de refus, le véhicule est remonté dans l'état permis par les travaux déjà effectués, qui restent dus.</p>

    <h2>4. Prix et paiement</h2>
    <p>Les prix sont exprimés en euros toutes taxes comprises. Un acompte peut être demandé à l'acceptation du devis, notamment pour la commande de pièces. Le solde est payable à la restitution du véhicule, par carte bancaire, virement ou espèces dans la limite légale. Pour les professionnels, tout retard de paiement entraîne de plein droit des pénalités au taux de trois fois le taux d'intérêt légal et une indemnité forfaitaire de recouvrement de 40 €. Conformément à l'article L.3251-1 du Code civil (droit de rétention), l'Atelier peut conserver le véhicule jusqu'au paiement intégral des sommes dues.</p>

    <h2>5. Sinistres et assurance</h2>
    <p>Lorsque la réparation est prise en charge par un assureur, l'Atelier établit le devis et le transmet à l'expert mandaté, puis réalise les travaux validés par le rapport d'expertise. Le Client reste redevable des sommes non prises en charge (franchise, vétusté, travaux refusés par l'assureur ou demandés en plus), payables à la restitution. Le Client est libre de choisir son réparateur, conformément à l'article L.211-5-1 du Code des assurances.</p>

    <h2>6. Pièces</h2>
    <p>Sauf demande contraire du Client, les pièces remplacées sont des pièces d'origine ou de qualité équivalente. Conformément à l'article L.224-67 du Code de la consommation, le Client peut opter pour des pièces issues de l'économie circulaire lorsqu'elles sont disponibles ; l'Atelier l'informe de cette possibilité. Les pièces remplacées sont tenues à la disposition du Client jusqu'à la restitution du véhicule, sauf pièces sous garantie constructeur ou échange standard qui doivent être restituées au fournisseur.</p>

    <h2>7. Délais</h2>
    <p>Les délais indiqués au devis sont donnés à titre indicatif et courent à compter de l'accord du Client, de la réception des pièces et, le cas échéant, de l'accord de l'assureur. Un retard raisonnable lié à l'approvisionnement, à l'expertise ou à la découverte de dommages cachés ne peut donner lieu à indemnité. Le Client est prévenu de tout décalage important.</p>

    <h2>8. Dépôt, garde et restitution du véhicule</h2>
    <p>Un état des lieux contradictoire (kilométrage, niveau de carburant, dommages apparents, objets visibles) est établi au dépôt et à la restitution. Le Client est invité à retirer tout objet de valeur ; l'Atelier n'en est pas responsable. Le véhicule est couvert par l'assurance responsabilité civile professionnelle de l'Atelier pendant la durée des travaux. Le Client s'engage à reprendre son véhicule dans les cinq jours suivant l'avis de fin de travaux ; au-delà, des frais de gardiennage peuvent être facturés, au tarif affiché à l'atelier. Si le véhicule n'est pas retiré dans un délai de trois mois après mise en demeure, l'Atelier pourra engager la procédure de vente prévue par la loi du 31 décembre 1903.</p>

    <h2>9. Véhicule de courtoisie</h2>
    <p>Un véhicule de courtoisie peut être prêté selon disponibilité, dans le cadre d'un contrat de prêt précisant les conditions (permis valide, franchise en cas de dommage, carburant, kilométrage). Les amendes et contraventions encourues pendant le prêt sont à la charge du Client.</p>

    <h2>10. Garanties</h2>
    <p>Les réparations sont garanties pièces et main-d'œuvre selon les conditions précisées sur la facture, sans préjudice des garanties légales : garantie légale de conformité (articles L.217-3 et suivants du Code de la consommation) et garantie des vices cachés (articles 1641 et suivants du Code civil). Les travaux de peinture sont garantis contre les défauts d'application (cloquage, décollement, écaillage) selon la durée indiquée sur la facture. La garantie ne couvre pas l'usure normale, les dommages résultant d'un choc postérieur, d'un défaut d'entretien, d'une utilisation anormale ou d'une intervention extérieure, ni les pièces fournies par le Client, qui sont montées sous sa seule responsabilité.</p>

    <h2>11. Droit de rétractation</h2>
    <p>Les prestations commandées dans les locaux de l'Atelier ne sont pas soumises au droit de rétractation. Pour un devis accepté à distance, le consommateur dispose de quatorze jours pour se rétracter (articles L.221-18 et suivants du Code de la consommation), sauf s'il a demandé que les travaux commencent avant la fin de ce délai ; il doit alors régler les prestations déjà réalisées.</p>

    <h2>12. Responsabilité</h2>
    <p>L'Atelier est tenu d'une obligation de moyens dans la réalisation des travaux et d'une obligation de résultat quant à leur conformité au devis accepté. Sa responsabilité ne saurait être engagée en cas d'inexécution due au fait du Client, d'un tiers ou à un cas de force majeure, ni pour les conséquences de défauts du véhicule étrangers aux travaux commandés et signalés au Client.</p>

    <h2>13. Données personnelles</h2>
    <p>Les données du Client sont traitées conformément à notre <a href="{{p_confid}}">politique de confidentialité</a>.</p>

    <h2>14. Médiation et litiges</h2>
    <p>En cas de réclamation, le Client est invité à nous contacter en priorité à <a href="mailto:{{email}}">{{email}}</a>. À défaut de solution amiable dans un délai de deux mois, le consommateur peut saisir gratuitement le médiateur de la consommation : {{mediateur}} — {{mediateur_url}}, ou utiliser la plateforme européenne de règlement en ligne des litiges (<a href="https://ec.europa.eu/consumers/odr" target="_blank" rel="noopener">ec.europa.eu/consumers/odr</a>). Les présentes CGV sont soumises au droit français ; à défaut d'accord amiable, les tribunaux français sont compétents, et pour les professionnels le tribunal de commerce du siège de l'Atelier.</p>
"""

PAGES = {
    "mentions-legales": dict(titre="Mentions légales", label="Informations légales",
                             desc="Mentions légales du site : éditeur, hébergeur, propriété intellectuelle, médiation.", corps=MENTIONS),
    "confidentialite":  dict(titre="Politique de confidentialité", label="Données personnelles",
                             desc="Politique de confidentialité et de protection des données personnelles (RGPD).", corps=CONFID),
    "cgv":              dict(titre="Conditions générales de vente", label="CGV",
                             desc="Conditions générales de vente : véhicules d'occasion, reprise, recherche, location, expertise.", corps=CGV),
}

def build(cfg, php_head_foot):
    """Écrit les pages statiques (cfg['static_dir']) et PHP (cfg['theme_dir'])."""
    wanted = cfg.get("pages", list(PAGES))
    libelles = {"mentions-legales": ("Mentions légales", "Mentions légales", "{{p_mentions}}"),
                "confidentialite": ("Politique de confidentialité", "Confidentialité", "{{p_confid}}"),
                "cgv": ("Conditions générales de vente" if cfg.get("type") != "atelier" else "Conditions générales de réparation", "CGV" if cfg.get("type") != "atelier" else "Conditions de réparation", "{{p_cgv}}")}
    nav = "".join('      <a href="%s">%s</a>\n' % (libelles[k][2], libelles[k][0]) for k in wanted)
    footnav = "".join('<li><a href="%s">%s</a></li>' % (libelles[k][2], libelles[k][1]) for k in wanted)
    style = ("\n<style>" + cfg["extra_style"] + "</style>") if cfg.get("extra_style") else ""
    for slug, p in PAGES.items():
        if slug not in wanted:
            continue
        p = dict(p)
        if slug == "cgv" and cfg.get("type") == "atelier":
            p["corps"] = CGV_ATELIER
            p["titre"] = "Conditions générales de réparation"
            p["desc"]  = "Conditions générales : devis, réparation, pièces, garanties, dépôt et restitution du véhicule."
        html = PAGE
        for k in ("titre", "label", "desc", "corps"):
            html = html.replace("{" + k + "}", p[k])
        html = html.replace("{nav}", nav).replace("{footnav}", footnav).replace("{style}", style)
        # statique
        out = fill(html, cfg, "static")
        if cfg.get("assets_prefix"):
            out = out.replace('href="assets/', 'href="' + cfg["assets_prefix"] + 'assets/').replace('src="assets/', 'src="' + cfg["assets_prefix"] + 'assets/')
        open(os.path.join(cfg["static_dir"], slug + ".html"), "w", encoding="utf-8").write(out)
        # WordPress
        php = html.replace('<link rel="stylesheet" href="assets/css/styles.css">', '<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/css/styles.css">' if cfg.get("php_css") else "")
        php = php.replace('href="assets/img/favicon.svg"', "href=\"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/favicon.svg\"")
        php = fill(php, cfg, "php")
        php = php_head_foot(php)
        php = ("<?php\n/**\n * %s — générée par wordpress/build.py (wordpress/legal.py). Ne pas modifier ici.\n */\n?>\n" % p["titre"]) + php
        open(os.path.join(cfg["theme_dir"], "legal-" + slug + ".php"), "w", encoding="utf-8").write(php)
    print("pages légales : %s (statique + thème)" % cfg["nom"])
