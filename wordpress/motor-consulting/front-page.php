<?php
/**
 * Page d'accueil Motor Consulting — générée par wordpress/build.py à partir de index.html.
 * Ne pas modifier ici : modifiez index.html à la racine puis relancez le script.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Motor Consulting — Achat, vente et location de voitures d'occasion à Paris</title>
<meta name="description" content="Motor Consulting, l'expertise automobile à votre service : recherche, négociation, achat, vente et location de véhicules d'occasion à Paris et en Île-de-France. Estimation gratuite sous 24h.">
<meta name="keywords" content="achat vente voiture occasion, rachat de voiture, expertise automobile, vendre sa voiture rapidement, estimation gratuite véhicule Paris, location véhicule">
<meta name="author" content="Motor Consulting">
<meta name="robots" content="index, follow">
<link rel="canonical" href="<?php echo esc_url( home_url( '/' ) ); ?>">

<meta property="og:type" content="website">
<meta property="og:locale" content="fr_FR">
<meta property="og:site_name" content="Motor Consulting">
<meta property="og:title" content="Motor Consulting — L'expertise automobile à votre service">
<meta property="og:description" content="Recherche, négociation, achat, vente et location de véhicules d'occasion. Estimation gratuite sous 24h, transaction sécurisée.">
<meta property="og:url" content="<?php echo esc_url( home_url( '/' ) ); ?>">
<meta property="og:image" content="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/og-cover.png">
<meta name="twitter:card" content="summary_large_image">
<meta name="theme-color" content="#ffffff">

<link rel="icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/favicon.svg">

<script>document.documentElement.classList.add("js");</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "AutoDealer",
  "name": "Motor Consulting",
  "slogan": "L'expertise automobile à votre service",
  "description": "Conseil automobile indépendant : recherche de véhicule, négociation, achat, vente, location et expertise de voitures d'occasion.",
  "url": "<?php echo esc_url( home_url( '/' ) ); ?>",
  "telephone": "<?php echo esc_attr( motor_opt( 'phone_e164' ) ); ?>",
  "email": "<?php echo esc_html( motor_opt( 'email' ) ); ?>",
  "priceRange": "€€",
  "image": "<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/og-cover.png",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "24 avenue de la Grande-Armée",
    "postalCode": "75017",
    "addressLocality": "Paris",
    "addressRegion": "Île-de-France",
    "addressCountry": "FR"
  },
  "geo": { "@type": "GeoCoordinates", "latitude": 48.8759, "longitude": 2.2895 },
  "areaServed": [
    { "@type": "City", "name": "Paris" },
    { "@type": "AdministrativeArea", "name": "Île-de-France" }
  ],
  "openingHoursSpecification": [
    { "@type": "OpeningHoursSpecification", "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"], "opens": "09:00", "closes": "19:00" },
    { "@type": "OpeningHoursSpecification", "dayOfWeek": "Saturday", "opens": "10:00", "closes": "17:00" }
  ],
  "aggregateRating": { "@type": "AggregateRating", "ratingValue": "4.9", "reviewCount": "312", "bestRating": "5" }
}
</script>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<a class="skip-link" href="#main">Aller au contenu principal</a>

<!-- ============ EN-TÊTE ============ -->
<header class="header" id="header">
  <div class="container header__inner">
    <a class="logo logo--compact" href="#accueil" aria-label="Motor Consulting, retour à l'accueil">
      <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/logo-motor-consulting-light-300.png" alt="Motor Consulting" width="300" height="172">
    </a>
    <nav class="nav" id="nav" aria-label="Navigation principale">
      <ul class="nav__list">
        <li><a href="#vehicules">Acheter</a></li>
        <li><a href="#estimation">Vendre</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#methode">Méthode</a></li>
        <li><a href="#avis">Avis</a></li>
        <li><a href="#apropos">À propos</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
      <div class="nav__cta">
        <a class="nav__tel" href="tel:<?php echo esc_attr( motor_opt( 'phone_e164' ) ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.5 3.5h3l1.5 4-2 1.5a12 12 0 0 0 6 6l1.5-2 4 1.5v3c0 .9-.7 1.6-1.6 1.5C10.6 19.9 4.1 13.4 3.5 5.1A1.5 1.5 0 0 1 5 3.5h1.5Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg> <?php echo esc_html( motor_opt( 'phone_display' ) ); ?></a>
        <a class="btn btn--primary" href="#estimation" data-intent="vendre">Estimation gratuite</a>
      </div>
    </nav>
    <button class="burger" id="burger" type="button" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="nav"><span></span><span></span><span></span></button>
  </div>
</header>

<main id="main">

<!-- ============ ACCUEIL ============ -->
<section class="hero" id="accueil">
  <div class="hero__bg" aria-hidden="true"></div>
  <div class="container hero__inner">
    <div>
      <span class="hero__badge">L'expertise automobile à votre service</span>
      <h1>Achetez, vendez ou louez votre véhicule <span class="accent">en toute confiance !</span></h1>
      <p class="hero__sub">Agent dédié · Estimation gratuite · Transaction 100 % sécurisée</p>
      <p class="hero__sub2"><strong id="hero-count">12</strong> véhicules disponibles, inspectés et négociés, à Paris et partout en France.</p>
      <div class="hero__actions">
        <a class="btn btn--primary" href="#vehicules"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6.5" fill="none" stroke="currentColor" stroke-width="2"/><path d="m16 16 4.5 4.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg> Acheter un véhicule</a>
        <a class="btn btn--light" href="#estimation" data-intent="vendre">Vendre ma voiture <span aria-hidden="true">→</span></a>
      </div>
      <ul class="hero__proof">
        <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2.6 2.9 6 6.6.9-4.8 4.6 1.2 6.5-5.9-3.1-5.9 3.1 1.2-6.5L2.5 9.5l6.6-.9 2.9-6Z" fill="currentColor"/></svg> <strong>4,9/5</strong> · 312 avis clients</li>
        <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3.5 17.5v-3.4l2-4.4c.35-.8 1-1.2 1.9-1.2h9.2c.9 0 1.55.4 1.9 1.2l2 4.4v3.4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M3.5 17.5h17M5.6 14.1h2.6M15.8 14.1h2.6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg> <strong>1 850</strong> véhicules accompagnés</li>
        <li><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="m8.5 12.3 2.4 2.4 4.8-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> <strong>Gratuit</strong> · estimation sous 24h</li>
      </ul>
    </div>

    <form class="search" id="hero-search" aria-label="Trouver un véhicule">
      <div class="search__head">
        <p class="search__title"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6.5" fill="none" stroke="currentColor" stroke-width="2"/><path d="m16 16 4.5 4.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg> Trouvez votre véhicule</p>
        <span class="search__count"><span id="hero-count-2">12</span> annonces</span>
      </div>
      <div class="search__bar">
        <label class="sr-only" for="hs-q">Marque, modèle, référence</label>
        <input type="search" id="hs-q" placeholder="Marque, modèle, référence…" autocomplete="off">
        <button type="submit"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6.5" fill="none" stroke="currentColor" stroke-width="2"/><path d="m16 16 4.5 4.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg> Rechercher</button>
      </div>
      <div class="search__grid">
        <div class="search__field"><label for="hs-price">Budget max</label>
          <select id="hs-price"><option value="">Tous les prix</option><option value="10000">10 000 €</option><option value="15000">15 000 €</option><option value="20000">20 000 €</option><option value="30000">30 000 €</option><option value="50000">50 000 €</option></select></div>
        <div class="search__field"><label for="hs-fuel">Carburant</label>
          <select id="hs-fuel"><option value="">Tous</option><option>Essence</option><option>Diesel</option><option>Hybride</option><option>Électrique</option></select></div>
        <div class="search__field"><label for="hs-gear">Transmission</label>
          <select id="hs-gear"><option value="">Toutes</option><option>Manuelle</option><option>Automatique</option></select></div>
        <div class="search__field"><label for="hs-type">Carrosserie</label>
          <select id="hs-type"><option value="">Toutes</option><option>Citadine</option><option>Berline</option><option>SUV</option><option>Break</option><option>Monospace</option><option>Utilitaire</option></select></div>
      </div>
      <div class="search__pop">
        <span>Recherches populaires</span>
        <div class="search__chips">
          <button type="button" data-q="BMW">BMW</button><button type="button" data-q="Mercedes">Mercedes</button><button type="button" data-q="Peugeot">Peugeot</button><button type="button" data-q="Audi">Audi</button><button type="button" data-q="Tesla">Tesla</button>
        </div>
      </div>
    </form>
  </div>
</section>

<!-- ============ RÉASSURANCE ============ -->
<div class="reassure">
  <div class="container">
    <ul class="reassure__grid">
      <li class="reassure__item"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.5 4 5.4v6c0 5 3.4 9.3 8 10.9 4.6-1.6 8-5.9 8-10.9v-6l-8-2.9Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="m8.6 12 2.4 2.4 4.6-4.6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><div><strong>Inspection 120 points</strong><span>Mécanique, carrosserie, historique vérifiés</span></div></li>
      <li class="reassure__item"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="m8.5 12.3 2.4 2.4 4.8-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><div><strong>Transaction sécurisée</strong><span>Paiement vérifié, carte grise et cession gérés</span></div></li>
      <li class="reassure__item"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 7v5.4l3.4 2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg><div><strong>Estimation gratuite sous 24h</strong><span>Réponse d'un expert, sans engagement</span></div></li>
      <li class="reassure__item"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6.5h11v9H3zM14 10h4l3 3v2.5h-7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><circle cx="7" cy="17.5" r="1.8" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="17" cy="17.5" r="1.8" fill="none" stroke="currentColor" stroke-width="1.8"/></svg><div><strong>Livraison partout en France</strong><span>À domicile ou en agence, selon votre choix</span></div></li>
    </ul>
  </div>
</div>

<!-- ============ VÉHICULES ============ -->
<section class="section section--alt" id="vehicules">
  <div class="container">
    <header class="section__head section__head--row reveal">
      <div>
        <span class="label">Acheter</span>
        <h2>Nos véhicules d'occasion <span class="accent">disponibles</span></h2>
        <p class="lead">Chaque véhicule est inspecté, son historique vérifié et son prix négocié. Vous ne trouvez pas votre bonheur&nbsp;? Nous le cherchons pour vous.</p>
      </div>
      <a class="btn btn--outline" href="#contact">Recherche personnalisée <span aria-hidden="true">→</span></a>
    </header>
    <form class="filters" id="filters" aria-label="Filtrer les véhicules" novalidate>
      <div class="filters__search">
        <svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6.5" fill="none" stroke="currentColor" stroke-width="1.4"/><path d="m16 16 4.5 4.5" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        <label class="sr-only" for="f-search">Rechercher une marque ou un modèle</label>
        <input type="search" id="f-search" placeholder="Marque, modèle, carburant…" autocomplete="off">
      </div>
      <div class="filters__row">
        <div class="field field--select">
          <label for="f-type">Type</label>
          <select id="f-type">
            <option value="">Tous</option>
            <option>Citadine</option><option>Berline</option><option>SUV</option><option>Break</option><option>Monospace</option><option>Utilitaire</option>
          </select>
        </div>
        <div class="field field--select">
          <label for="f-price">Budget</label>
          <select id="f-price">
            <option value="">Indifférent</option>
            <option value="10000">Jusqu'à 10 000 €</option>
            <option value="15000">Jusqu'à 15 000 €</option>
            <option value="20000">Jusqu'à 20 000 €</option>
            <option value="30000">Jusqu'à 30 000 €</option>
            <option value="50000">Jusqu'à 50 000 €</option>
          </select>
        </div>
        <div class="field field--select">
          <label for="f-year">Année minimum</label>
          <select id="f-year">
            <option value="">Indifférente</option>
            <option value="2016">2016</option><option value="2018">2018</option><option value="2020">2020</option><option value="2022">2022</option><option value="2023">2023</option>
          </select>
        </div>
        <div class="field field--select">
          <label for="f-fuel">Carburant</label>
          <select id="f-fuel"><option value="">Tous</option><option>Essence</option><option>Diesel</option><option>Hybride</option><option>Électrique</option></select>
        </div>
        <div class="field field--select">
          <label for="f-gear">Boîte</label>
          <select id="f-gear"><option value="">Toutes</option><option>Manuelle</option><option>Automatique</option></select>
        </div>
        <div class="field field--select">
          <label for="f-sort">Tri</label>
          <select id="f-sort">
            <option value="recent">Ajouts récents</option>
            <option value="price-asc">Prix croissant</option>
            <option value="price-desc">Prix décroissant</option>
            <option value="km-asc">Kilométrage croissant</option>
            <option value="year-desc">Année récente</option>
          </select>
        </div>
        <button type="button" class="filters__reset" id="f-reset">Réinitialiser</button>
      </div>
    </form>
    <p class="results-count" id="results-count" role="status" aria-live="polite"></p>
    <div class="grid" id="vehicles-grid"></div>
    <p class="empty" id="vehicles-empty" hidden>Aucun véhicule ne correspond à votre recherche. <a href="#contact">Confiez-nous votre recherche</a> : nous trouvons le véhicule pour vous, sous 15 jours en moyenne.</p>
    <div class="center"><button class="btn btn--outline" id="load-more" type="button">Voir plus de véhicules <span aria-hidden="true">→</span></button></div>
  </div>
</section>

<!-- ============ SERVICES ============ -->
<section class="section" id="services">
  <div class="container">
    <header class="section__head reveal">
      <span class="label">Nos services</span>
      <h2>Quatre expertises, <span class="accent">un seul interlocuteur</span></h2>
      <p class="lead">Pour les particuliers comme pour les professionnels. L'expertise du véhicule, le contrôle technique et les démarches administratives sont inclus à chaque étape.</p>
    </header>
    <div class="services">
      <article class="service card reveal"><span class="service__icon"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6.5" fill="none" stroke="currentColor" stroke-width="2"/><path d="m16 16 4.5 4.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></span><span class="label">Recherche</span><h3>Le bon véhicule, trouvé pour vous</h3><p>Vous décrivez le véhicule et le budget. Nous le trouvons partout en France, vérifions son historique et l'inspectons avant toute visite.</p><a class="link" href="#contact">Confier ma recherche <span aria-hidden="true">→</span></a></article>
      <article class="service card reveal reveal--d1"><span class="service__icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v16M7.5 20h9M3.5 8.5h17" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M3.5 8.5 1.4 13.6a2.6 2.6 0 0 0 4.2 0L3.5 8.5Zm17 0-2.1 5.1a2.6 2.6 0 0 0 4.2 0L20.5 8.5Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg></span><span class="label">Négociation</span><h3>Le juste prix, argumenté</h3><p>État réel, historique, cote du marché : nous négocions à votre place, à l'achat comme à la vente. En moyenne 1 480 € économisés par dossier.</p><a class="link" href="#contact">Faire négocier mon dossier <span aria-hidden="true">→</span></a></article>
      <article class="service card reveal reveal--d2"><span class="service__icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3.5 17.5v-3.4l2-4.4c.35-.8 1-1.2 1.9-1.2h9.2c.9 0 1.55.4 1.9 1.2l2 4.4v3.4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M3.5 17.5h17M5.6 14.1h2.6M15.8 14.1h2.6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span><span class="label">Achat / Vente</span><h3>Une transaction sans effort</h3><p>Achat pour votre compte ou vente accompagnée : photos, annonce, visites filtrées, paiement sécurisé et dossier administratif complet.</p><a class="link" href="#estimation" data-intent="vendre">Mettre en vente <span aria-hidden="true">→</span></a></article>
      <article class="service card reveal reveal--d3"><span class="service__icon"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="15.6" cy="8.4" r="4.4" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12.5 11.5 3.5 20.5M6.4 17.6l2.1 2.1M8.8 15.2l2.1 2.1" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span><span class="label">Location</span><h3>Courte ou longue durée</h3><p>Location, LOA ou LLD : nous comparons les offres, décryptons les contrats et sélectionnons la formule réellement adaptée à votre usage.</p><a class="link" href="#contact">Étudier une location <span aria-hidden="true">→</span></a></article>
    </div>
  </div>
</section>

<!-- ============ MÉTHODE ============ -->
<section class="section section--alt" id="methode">
  <div class="container">
    <header class="section__head reveal">
      <span class="label">Comment ça marche</span>
      <h2>Quatre étapes, du premier appel <span class="accent">à la remise des clés</span></h2>
    </header>
    <ol class="steps">
      <li class="step card reveal"><span class="step__num">1</span><h3>Vous nous décrivez votre projet</h3><p>Formulaire ou appel. Dix minutes suffisent pour cadrer le besoin, le budget et les délais.</p></li>
      <li class="step card reveal reveal--d1"><span class="step__num">2</span><h3>Nous inspectons le véhicule</h3><p>Mécanique, carrosserie, historique, kilométrage, documents. Vous recevez un rapport écrit.</p></li>
      <li class="step card reveal reveal--d2"><span class="step__num">3</span><h3>Vous recevez une offre chiffrée</h3><p>Prix conseillé, offre de rachat ou formule de location, avec les arguments qui justifient chaque euro.</p></li>
      <li class="step card reveal reveal--d3"><span class="step__num">4</span><h3>Nous sécurisons la vente</h3><p>Négociation, paiement vérifié, carte grise et certificat de cession : l'administratif est géré jusqu'au bout.</p></li>
    </ol>
  </div>
</section>

<!-- ============ ESTIMATION ============ -->
<section class="section" id="estimation">
  <div class="container estimation">
    <div class="reveal">
      <span class="label">Vendre</span>
      <h2>Le vrai prix de votre voiture, <span class="accent">sous 24h</span></h2>
      <p class="lead">Un expert analyse votre véhicule, la cote du marché et la demande réelle dans votre région, puis vous envoie une fourchette de prix argumentée.</p>
      <ul class="list">
        <li>Gratuit et sans engagement</li>
        <li>Réponse d'un expert sous 24h ouvrées</li>
        <li>Offre de rachat immédiat possible</li>
        <li>Vos données ne sont jamais revendues</li>
      </ul>
    </div>
    <form class="form card" id="estimation-form" novalidate>
      <h3 class="form__title">Demander mon estimation</h3>
      <p class="hp" aria-hidden="true"><label>Ne pas remplir <input type="text" name="website" tabindex="-1" autocomplete="off"></label></p>
            <div class="field-row">
        <div class="field">
          <label for="e-nom">Nom et prénom <span class="req" aria-hidden="true">*</span></label>
          <input type="text" id="e-nom" name="nom" autocomplete="name" required>
          <p class="field__error" data-error-for="e-nom"></p>
        </div>
        <div class="field">
          <label for="e-tel">Téléphone <span class="req" aria-hidden="true">*</span></label>
          <input type="tel" id="e-tel" name="telephone" autocomplete="tel" placeholder="<?php echo esc_html( motor_opt( 'phone_display' ) ); ?>" required>
          <p class="field__error" data-error-for="e-tel"></p>
        </div>
      </div>
      <div class="field">
        <label for="e-email">E-mail <span class="req" aria-hidden="true">*</span></label>
        <input type="email" id="e-email" name="email" autocomplete="email" placeholder="vous@exemple.fr" required>
        <p class="field__error" data-error-for="e-email"></p>
      </div>
      <div class="field-row">
        <div class="field">
          <label for="e-marque">Marque <span class="req" aria-hidden="true">*</span></label>
          <input type="text" id="e-marque" name="marque" placeholder="Renault" required>
          <p class="field__error" data-error-for="e-marque"></p>
        </div>
        <div class="field">
          <label for="e-modele">Modèle <span class="req" aria-hidden="true">*</span></label>
          <input type="text" id="e-modele" name="modele" placeholder="Clio V" required>
          <p class="field__error" data-error-for="e-modele"></p>
        </div>
      </div>
      <div class="field-row field-row--3">
        <div class="field">
          <label for="e-annee">Année <span class="req" aria-hidden="true">*</span></label>
          <input type="number" id="e-annee" name="annee" placeholder="2019" min="1950" max="2026" inputmode="numeric" required>
          <p class="field__error" data-error-for="e-annee"></p>
        </div>
        <div class="field">
          <label for="e-km">Kilométrage <span class="req" aria-hidden="true">*</span></label>
          <input type="number" id="e-km" name="kilometrage" placeholder="85000" min="0" max="1000000" inputmode="numeric" required>
          <p class="field__error" data-error-for="e-km"></p>
        </div>
        <div class="field field--select">
          <label for="e-carburant">Carburant</label>
          <select id="e-carburant" name="carburant">
            <option>Essence</option><option>Diesel</option><option>Hybride</option><option>Électrique</option><option>GPL</option>
          </select>
        </div>
      </div>
      <fieldset class="field field--radios">
        <legend>État général <span class="req" aria-hidden="true">*</span></legend>
        <div class="radios">
          <label class="radio"><input type="radio" name="etat" value="Excellent" required><span>Excellent</span></label>
          <label class="radio"><input type="radio" name="etat" value="Bon"><span>Bon</span></label>
          <label class="radio"><input type="radio" name="etat" value="Moyen"><span>Moyen</span></label>
          <label class="radio"><input type="radio" name="etat" value="À réparer"><span>À réparer</span></label>
        </div>
        <p class="field__error" data-error-for="etat"></p>
      </fieldset>
      <div class="field">
        <label for="e-message">Précisions</label>
        <textarea id="e-message" name="message" rows="2" placeholder="Options, entretien, sinistres…"></textarea>
      </div>
      <label class="check">
        <input type="checkbox" id="e-rgpd" name="consentement" required>
        <span>J'accepte d'être recontacté(e) au sujet de ma demande. <span class="req" aria-hidden="true">*</span></span>
      </label>
      <p class="field__error" data-error-for="e-rgpd"></p>
      <button class="btn btn--primary btn--block" type="submit">Recevoir mon estimation</button>
      <p class="form__note">Réponse sous 24h ouvrées · Sans engagement · <span class="req">*</span> champs obligatoires</p>
      <p class="form__status" role="status" aria-live="polite" id="estimation-status"></p>
    </form>
  </div>
</section>

<!-- ============ AVIS ============ -->
<section class="section section--alt" id="avis">
  <div class="container">
    <header class="section__head section__head--row reveal">
      <div>
        <span class="label">Avis clients</span>
        <h2>Ils nous ont <span class="accent">fait confiance</span></h2>
      </div>
      <div class="rating" aria-label="Note moyenne de 4,9 sur 5"><span class="stars stars--lg" aria-hidden="true"></span><span><strong>4,9 / 5</strong> · 312 avis vérifiés</span></div>
    </header>
    <div class="testimonials" id="testimonials"><div class="testimonials__track" id="testimonials-track"></div></div>
    <div class="testimonials__nav">
      <button class="round-btn" type="button" id="t-prev" aria-label="Témoignage précédent">←</button>
      <div class="dots" id="t-dots" role="tablist" aria-label="Sélection du témoignage"></div>
      <button class="round-btn" type="button" id="t-next" aria-label="Témoignage suivant">→</button>
    </div>
  </div>
</section>

<!-- ============ À PROPOS ============ -->
<section class="section" id="apropos">
  <div class="container about">
    <div class="about__text reveal">
      <span class="label">À propos</span>
      <h2>Le conseil automobile que nous <span class="accent">aurions aimé trouver</span></h2>
      <p>Motor Consulting est né en 2013 d'un constat simple : acheter ou vendre une voiture d'occasion reste une épreuve. Prix opaques, historiques flous, acheteurs fantômes, démarches interminables.</p>
      <p>Anciens expert automobile et acheteur en concession, nous avons créé une structure <strong>100&nbsp;% indépendante</strong>, payée ni par les vendeurs ni par les constructeurs. Notre seul intérêt est que votre transaction soit la bonne.</p>
      <div class="values">
        <div class="value card"><span class="label">Expertise</span><p>12 ans de métier, une inspection en 120 points, une lecture fine de la cote réelle.</p></div>
        <div class="value card"><span class="label">Confiance</span><p>Un tarif annoncé à l'avance et un rapport écrit sur chaque véhicule, défauts compris.</p></div>
        <div class="value card"><span class="label">Exigence</span><p>Un véhicule sur cinq seulement passe notre sélection.</p></div>
      </div>
    </div>
    <div class="about__team reveal reveal--d1">
      <h3 class="team__title">L'équipe</h3>
      <ul class="team">
        <li class="member card"><strong>Karim M.</strong><span>Fondateur · Expert automobile</span><p>15 ans d'expertise technique, spécialiste des véhicules premium et hybrides.</p></li>
        <li class="member card"><strong>Laure D.</strong><span>Responsable achats</span><p>Ancienne acheteuse en concession, elle négocie chaque dossier.</p></li>
        <li class="member card"><strong>Thomas B.</strong><span>Conseiller clients</span><p>Votre interlocuteur unique, du premier appel à la remise des clés.</p></li>
      </ul>
    </div>
  </div>
</section>

<!-- ============ CONTACT ============ -->
<section class="section section--alt" id="contact">
  <div class="container">
    <header class="section__head reveal">
      <span class="label">Contact</span>
      <h2>Parlons de <span class="accent">votre projet</span></h2>
    </header>
    <div class="contact">
      <div class="reveal">
        <ul class="infos">
          <li class="card"><strong>Téléphone</strong><a href="tel:<?php echo esc_attr( motor_opt( 'phone_e164' ) ); ?>"><?php echo esc_html( motor_opt( 'phone_display' ) ); ?></a><small><?php echo esc_html( motor_opt( 'hours' ) ); ?></small></li>
          <li class="card"><strong>E-mail</strong><a href="mailto:<?php echo esc_html( motor_opt( 'email' ) ); ?>"><?php echo esc_html( motor_opt( 'email' ) ); ?></a></li>
          <li class="card"><strong>WhatsApp</strong><a href="https://wa.me/<?php echo esc_attr( motor_opt( 'whatsapp' ) ); ?>?text=Bonjour%2C%20je%20souhaite%20des%20informations%20sur%20la%20vente%20de%20mon%20v%C3%A9hicule." target="_blank" rel="noopener">Discuter sur WhatsApp</a><small>Envoyez-nous directement vos photos</small></li>
          <li class="card"><strong>Adresse</strong><span><?php echo esc_html( motor_opt( 'address' ) ); ?></span><small>Sur rendez-vous · Déplacements en Île-de-France</small></li>
        </ul>
        <div class="map">
          <p class="map__fallback"><?php echo esc_html( motor_opt( 'address' ) ); ?></p>
          <iframe title="Localisation de Motor Consulting sur la carte" src="https://www.openstreetmap.org/export/embed.html?bbox=2.2755%2C48.8705%2C2.3035%2C48.8815&amp;layer=mapnik&amp;marker=48.8759%2C2.2895" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          <a class="map__link" href="https://www.openstreetmap.org/?mlat=48.8759&amp;mlon=2.2895#map=16/48.8759/2.2895" target="_blank" rel="noopener">Itinéraire ↗</a>
        </div>
      </div>
      <form class="form card" id="contact-form" novalidate>
        <h3 class="form__title">Nous écrire</h3>
        <p class="hp" aria-hidden="true"><label>Ne pas remplir <input type="text" name="website" tabindex="-1" autocomplete="off"></label></p>
              <div class="field-row">
          <div class="field">
            <label for="c-nom">Nom et prénom <span class="req" aria-hidden="true">*</span></label>
            <input type="text" id="c-nom" name="nom" autocomplete="name" required>
            <p class="field__error" data-error-for="c-nom"></p>
          </div>
          <div class="field">
            <label for="c-tel">Téléphone <span class="req" aria-hidden="true">*</span></label>
            <input type="tel" id="c-tel" name="telephone" autocomplete="tel" placeholder="<?php echo esc_html( motor_opt( 'phone_display' ) ); ?>" required>
            <p class="field__error" data-error-for="c-tel"></p>
          </div>
        </div>
        <div class="field">
          <label for="c-email">E-mail <span class="req" aria-hidden="true">*</span></label>
          <input type="email" id="c-email" name="email" autocomplete="email" required>
          <p class="field__error" data-error-for="c-email"></p>
        </div>
        <div class="field field--select">
          <label for="c-sujet">Votre demande</label>
          <select id="c-sujet" name="sujet">
            <option value="Vendre un véhicule">Vendre un véhicule</option>
            <option value="Rechercher un véhicule">Rechercher un véhicule</option>
            <option value="Location (courte ou longue durée)">Location (courte ou longue durée)</option>
            <option value="Expertise / estimation">Expertise / estimation</option>
            <option value="Question sur un véhicule en vente">Question sur un véhicule en vente</option>
            <option value="Autre">Autre</option>
          </select>
        </div>
        <div class="field">
          <label for="c-message">Votre message <span class="req" aria-hidden="true">*</span></label>
          <textarea id="c-message" name="message" rows="3" placeholder="Décrivez votre projet en quelques lignes…" required></textarea>
          <p class="field__error" data-error-for="c-message"></p>
        </div>
        <label class="check">
          <input type="checkbox" id="c-rgpd" name="consentement" required>
          <span>J'accepte d'être recontacté(e) au sujet de ma demande. <span class="req" aria-hidden="true">*</span></span>
        </label>
        <p class="field__error" data-error-for="c-rgpd"></p>
        <button class="btn btn--primary btn--block" type="submit">Envoyer</button>
        <p class="form__note">Réponse sous 24h ouvrées · <span class="req">*</span> champs obligatoires</p>
        <p class="form__status" role="status" aria-live="polite" id="contact-status"></p>
      </form>
    </div>
  </div>
</section>

</main>

<!-- ============ PIED DE PAGE ============ -->
<footer class="footer">
  <div class="container footer__inner">
    <div class="footer__brand">
      <a class="logo" href="#accueil" aria-label="Motor Consulting, retour à l'accueil"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/logo-motor-consulting-600.png" alt="Motor Consulting" width="600" height="345" loading="lazy"></a>
      <p>L'expertise automobile à votre service. Recherche, négociation, achat, vente et location de véhicules d'occasion à Paris et en Île-de-France.</p>
    </div>
    <nav class="footer__col" aria-label="Services"><h3>Services</h3><ul><li><a href="#services">Recherche de véhicule</a></li><li><a href="#services">Négociation</a></li><li><a href="#services">Achat / Vente</a></li><li><a href="#services">Location</a></li><li><a href="#estimation">Estimation gratuite</a></li></ul></nav>
    <nav class="footer__col" aria-label="Navigation"><h3>Le site</h3><ul><li><a href="#vehicules">Véhicules disponibles</a></li><li><a href="#methode">Comment ça marche</a></li><li><a href="#avis">Avis clients</a></li><li><a href="#apropos">À propos</a></li><li><a href="#contact">Contact</a></li></ul></nav>
    <div class="footer__col"><h3>Zone d'intervention</h3><p class="footer__seo">Achat vente de voiture d'occasion à Paris, Boulogne-Billancourt, Neuilly-sur-Seine, Levallois, Versailles et toute l'Île-de-France. Rachat de voiture, expertise automobile et estimation gratuite de véhicule, déplacements dans toute la France.</p></div>
  </div>
  <div class="container footer__bottom">
    <p>© <span id="year">2026</span> Motor Consulting</p>
    <ul class="footer__legal"><li><a href="#apropos">Mentions légales</a></li><li><a href="#apropos">Confidentialité</a></li><li><a href="#contact">CGV</a></li></ul>
  </div>
</footer>

<!-- ============ WHATSAPP EN DIRECT ============ -->
<div class="wa" id="wa">
  <div class="wa__panel" id="wa-panel" hidden>
    <div class="wa__head">
      <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/logo-motor-consulting-300.png" alt="" width="40" height="40">
      <div><strong>Motor Consulting</strong><small>En ligne · répond en quelques minutes</small></div>
      <button class="wa__close" type="button" id="wa-close" aria-label="Fermer la discussion">✕</button>
    </div>
    <div class="wa__body">
      <div class="wa__msg">Bonjour 👋 Une question sur un véhicule, une estimation ou une recherche&nbsp;? Écrivez-nous ici, on vous répond sur WhatsApp.<small id="wa-time"></small></div>
    </div>
    <div class="wa__form">
      <label class="sr-only" for="wa-text">Votre message</label>
      <input type="text" id="wa-text" placeholder="Écrivez votre message…" autocomplete="off">
      <a id="wa-send" href="https://wa.me/<?php echo esc_attr( motor_opt( 'whatsapp' ) ); ?>" target="_blank" rel="noopener" aria-label="Envoyer sur WhatsApp"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3.5 11.5 20 4l-4 16-4.5-6.5L3.5 11.5Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="m11.5 13.5 8.5-9.5" fill="none" stroke="currentColor" stroke-width="1.8"/></svg></a>
    </div>
  </div>
  <button class="wa__btn" id="wa-open" type="button" aria-label="Discuter en direct sur WhatsApp" aria-expanded="false" aria-controls="wa-panel">
    <span class="wa__ring" aria-hidden="true"></span>
    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/logo-motor-consulting-300.png" alt="" width="44" height="25">
    <span class="wa__badge" aria-hidden="true">1</span>
  </button>
</div>

<!-- Barre d'action mobile -->
<div class="mobile-bar" aria-label="Contact rapide">
  <a class="mobile-bar__btn" href="tel:<?php echo esc_attr( motor_opt( 'phone_e164' ) ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.5 3.5h3l1.5 4-2 1.5a12 12 0 0 0 6 6l1.5-2 4 1.5v3c0 .9-.7 1.6-1.6 1.5C10.6 19.9 4.1 13.4 3.5 5.1A1.5 1.5 0 0 1 5 3.5h1.5Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg> Appeler</a>
  <a class="mobile-bar__btn mobile-bar__btn--wa" href="https://wa.me/<?php echo esc_attr( motor_opt( 'whatsapp' ) ); ?>?text=Bonjour%2C%20je%20souhaite%20une%20estimation%20de%20mon%20v%C3%A9hicule." target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3.5a8.5 8.5 0 0 0-7.3 12.8L3.5 20.5l4.4-1.1A8.5 8.5 0 1 0 12 3.5Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M9 8.6c.3-.6.6-.6 1-.6.4 0 .6.4.8.9.2.5.4.9.1 1.3-.2.3-.5.4-.3.8.4.9 1.4 1.9 2.3 2.3.4.2.5-.1.8-.3.4-.3.8-.1 1.3.1.5.2.9.4.9.8s0 .7-.6 1c-.6.3-1.6.4-3-.2a8 8 0 0 1-3.7-3.7c-.6-1.4-.5-2.4-.2-3Z" fill="currentColor"/></svg> WhatsApp</a>
  <a class="mobile-bar__btn mobile-bar__btn--cta" href="#estimation" data-intent="vendre">Estimation</a>
</div>

<div class="modal" id="vehicle-modal" hidden>
  <div class="modal__overlay" data-close></div>
  <div class="modal__dialog" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <button class="modal__close" type="button" data-close aria-label="Fermer">✕</button>
    <div id="modal-content"></div>
  </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
