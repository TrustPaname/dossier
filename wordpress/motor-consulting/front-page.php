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
<meta property="og:image" content="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/og-cover.svg">
<meta name="twitter:card" content="summary_large_image">
<meta name="theme-color" content="#08080a">

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
  "image": "<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/og-cover.svg",
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

<!-- ============ HEADER ============ -->
<header class="header" id="header">
  <div class="container header__inner">
    <a class="logo logo--compact" href="#accueil" aria-label="Motor Consulting, retour à l'accueil">
      <svg class="logo__mark" viewBox="0 0 300 96" aria-hidden="true">
        <defs>
          <linearGradient id="lg-chr-h" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0%" stop-color="#ffffff"/><stop offset="45%" stop-color="#cfd4da"/><stop offset="55%" stop-color="#6c727a"/><stop offset="100%" stop-color="#f1f4f7"/>
          </linearGradient>
          <linearGradient id="lg-gld-h" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0%" stop-color="#8a6e1e"/><stop offset="40%" stop-color="#f3e2a4"/><stop offset="60%" stop-color="#d4af37"/><stop offset="100%" stop-color="#8a6e1e"/>
          </linearGradient>
        </defs>
        <path d="M126 46V32l24-18 24 18v14" fill="none" stroke="url(#lg-gld-h)" stroke-width="5.5" stroke-linejoin="round" stroke-linecap="round"/>
        <path d="M2 80C34 62 68 46 108 38c34-7 72-7 108 0 34 7 60 20 80 40-26-14-56-22-90-24-44-3-90 4-130 14-26 6-50 12-74 12Z" fill="url(#lg-chr-h)"/>
        <path d="M60 86c40-10 90-14 180-8" fill="none" stroke="url(#lg-chr-h)" stroke-width="3.5" stroke-linecap="round"/>
      </svg>
      <span class="logo__text">
        <span class="logo__name chrome">MOTOR</span>
        <span class="logo__sub"><i></i>CONSULTING<i></i></span>
      </span>
    </a>

    <nav class="nav" id="nav" aria-label="Navigation principale">
      <ul class="nav__list">
        <li><a href="#services">Services</a></li>
        <li><a href="#vehicules">Véhicules</a></li>
        <li><a href="#methode">Méthode</a></li>
        <li><a href="#avis">Avis</a></li>
        <li><a href="#apropos">À propos</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
      <div class="nav__cta">
        <a class="nav__tel" href="tel:<?php echo esc_attr( motor_opt( 'phone_e164' ) ); ?>"><?php echo esc_html( motor_opt( 'phone_display' ) ); ?></a>
        <a class="btn" href="#estimation" data-intent="vendre">Estimation gratuite</a>
      </div>
    </nav>

    <button class="burger" id="burger" type="button" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="nav">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>

<main id="main">

<!-- ============ ACCUEIL ============ -->
<section class="hero" id="accueil">
  <canvas class="hero__canvas" id="speed" aria-hidden="true"></canvas>
  <div class="hero__hex" aria-hidden="true"></div>
  <span class="hero__beam hero__beam--l" aria-hidden="true"></span>
  <span class="hero__beam hero__beam--r" aria-hidden="true"></span>
  <div class="hero__vignette" aria-hidden="true"></div>
  <div class="container hero__inner">
    <div id="hero-inner">
      <div class="hero__brand">
        <svg class="logo__mark" viewBox="0 0 300 96" aria-hidden="true">
          <defs>
            <linearGradient id="lg-chr-x" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="#ffffff"/><stop offset="45%" stop-color="#cfd4da"/><stop offset="55%" stop-color="#6c727a"/><stop offset="100%" stop-color="#f1f4f7"/></linearGradient>
            <linearGradient id="lg-gld-x" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#8a6e1e"/><stop offset="40%" stop-color="#f3e2a4"/><stop offset="60%" stop-color="#d4af37"/><stop offset="100%" stop-color="#8a6e1e"/></linearGradient>
          </defs>
          <path d="M126 46V32l24-18 24 18v14" fill="none" stroke="url(#lg-gld-x)" stroke-width="5.5" stroke-linejoin="round" stroke-linecap="round"/>
          <path d="M2 80C34 62 68 46 108 38c34-7 72-7 108 0 34 7 60 20 80 40-26-14-56-22-90-24-44-3-90 4-130 14-26 6-50 12-74 12Z" fill="url(#lg-chr-x)"/>
          <path d="M60 86c40-10 90-14 180-8" fill="none" stroke="url(#lg-chr-x)" stroke-width="3.5" stroke-linecap="round"/>
        </svg>
        <span class="logo__text">
          <span class="logo__name chrome chrome--live">MOTOR</span>
          <span class="logo__sub"><i></i>CONSULTING<i></i></span>
          <span class="logo__tag">L'expertise automobile à votre service</span>
        </span>
      </div>
      <h1>Achat, vente et location de véhicules d'occasion, <span class="or">sans mauvaise surprise</span>.</h1>
      <p class="lead">Nous cherchons, inspectons et négocions le véhicule à votre place. Ou nous vendons le vôtre, au juste prix, sans que vous ayez rien à gérer.</p>
      <div class="hero__actions">
        <a class="btn btn--primary" href="#estimation" data-intent="vendre">Vendre ma voiture <span aria-hidden="true">→</span></a>
        <a class="btn" href="#vehicules">Voir les véhicules</a>
      </div>
      <ul class="hero__trust">
        <li>Expertise indépendante</li>
        <li>Réponse sous 24h</li>
        <li>Transaction sécurisée</li>
      </ul>
    </div>
    <ul class="stats" id="stats">
      <li class="stat reveal"><span class="stat__value" data-count="1850" data-suffix="+">0</span><span class="stat__label">véhicules accompagnés</span></li>
      <li class="stat reveal reveal--d1"><span class="stat__value" data-count="12" data-suffix=" ans">0</span><span class="stat__label">d'expérience</span></li>
      <li class="stat reveal reveal--d2"><span class="stat__value" data-count="4.9" data-decimals="1" data-suffix="/5">0</span><span class="stat__label">note clients · 312 avis</span></li>
      <li class="stat reveal reveal--d3"><span class="stat__value" data-count="24" data-suffix="h">0</span><span class="stat__label">délai de réponse</span></li>
    </ul>
  </div>
</section>

<div class="marquee" aria-hidden="true">
  <div class="marquee__track">
    <span>Recherche</span><span>Négociation</span><span>Achat / Vente</span><span>Location</span><span>Expertise</span><span>Paris &amp; Île-de-France</span>
    <span>Recherche</span><span>Négociation</span><span>Achat / Vente</span><span>Location</span><span>Expertise</span><span>Paris &amp; Île-de-France</span>
  </div>
</div>

<!-- ============ SERVICES ============ -->
<section class="section" id="services">
  <div class="container">
    <header class="section__head reveal">
      <span class="label">Nos services</span>
      <h2>Quatre expertises, un seul interlocuteur</h2>
      <p class="lead">Pour les particuliers comme pour les professionnels. L'expertise du véhicule, le contrôle technique et les démarches administratives sont inclus à chaque étape.</p>
    </header>

    <div class="services">
      <article class="service card tilt reveal ">
        <span class="card__corner card__corner--tl" aria-hidden="true"></span><span class="card__corner card__corner--br" aria-hidden="true"></span>
        <span class="service__icon" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="10.5" cy="10.5" r="6.5" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="m15.5 15.5 5 5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span>
        <span class="label">Recherche</span>
        <h3>Le bon véhicule, trouvé pour vous</h3>
        <p>Vous décrivez le véhicule et le budget. Nous le trouvons partout en France, vérifions son historique et l'inspectons avant toute visite.</p>
        <a class="link" href="#contact">Confier ma recherche <span aria-hidden="true">→</span></a>
      </article>
      <article class="service card tilt reveal reveal--d1">
        <span class="card__corner card__corner--tl" aria-hidden="true"></span><span class="card__corner card__corner--br" aria-hidden="true"></span>
        <span class="service__icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 4v16M7.5 20h9M3.5 8.5h17" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M3.5 8.5 1.4 13.6a2.6 2.6 0 0 0 4.2 0L3.5 8.5Zm17 0-2.1 5.1a2.6 2.6 0 0 0 4.2 0L20.5 8.5Z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg></span>
        <span class="label">Négociation</span>
        <h3>Le juste prix, argumenté</h3>
        <p>État réel, historique, cote du marché : nous négocions à votre place, à l'achat comme à la vente. En moyenne 1 480 € économisés par dossier.</p>
        <a class="link" href="#contact">Faire négocier mon dossier <span aria-hidden="true">→</span></a>
      </article>
      <article class="service card tilt reveal reveal--d2">
        <span class="card__corner card__corner--tl" aria-hidden="true"></span><span class="card__corner card__corner--br" aria-hidden="true"></span>
        <span class="service__icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M3.5 17.5v-3.4l2-4.4c.35-.8 1-1.2 1.9-1.2h9.2c.9 0 1.55.4 1.9 1.2l2 4.4v3.4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M3.5 17.5h17M5.6 14.1h2.6M15.8 14.1h2.6M10.4 14.1h3.2" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></span>
        <span class="label">Achat / Vente</span>
        <h3>Une transaction sans effort</h3>
        <p>Achat pour votre compte ou vente accompagnée : photos, annonce, visites filtrées, paiement sécurisé et dossier administratif complet.</p>
        <a class="link" href="#estimation" data-intent="vendre">Mettre en vente <span aria-hidden="true">→</span></a>
      </article>
      <article class="service card tilt reveal reveal--d3">
        <span class="card__corner card__corner--tl" aria-hidden="true"></span><span class="card__corner card__corner--br" aria-hidden="true"></span>
        <span class="service__icon" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="15.6" cy="8.4" r="4.4" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M12.5 11.5 3.5 20.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="m6.4 17.6 2.1 2.1M8.8 15.2l2.1 2.1" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></span>
        <span class="label">Location</span>
        <h3>Courte ou longue durée</h3>
        <p>Location, LOA ou LLD : nous comparons les offres, décryptons les contrats et sélectionnons la formule réellement adaptée à votre usage.</p>
        <a class="link" href="#contact">Étudier une location <span aria-hidden="true">→</span></a>
      </article>
    </div>
  </div>
</section>

<!-- ============ VEHICULES ============ -->
<section class="section section--alt" id="vehicules">
  <div class="container">
    <header class="section__head section__head--row reveal">
      <div>
        <span class="label">Véhicules disponibles</span>
        <h2>La sélection du moment</h2>
        <p class="lead">Chaque véhicule est inspecté, son historique vérifié et son prix négocié.</p>
      </div>
      <a class="link" href="#contact">Recherche personnalisée <span aria-hidden="true">→</span></a>
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
    <p class="empty" id="vehicles-empty" hidden>
      Aucun véhicule ne correspond à votre recherche. <a href="#contact">Confiez-nous votre recherche</a> : nous trouvons le véhicule pour vous, sous 15 jours en moyenne.
    </p>
    <div class="center">
      <button class="btn" id="load-more" type="button">Voir plus de véhicules <span aria-hidden="true">→</span></button>
    </div>
  </div>
</section>

<!-- ============ METHODE ============ -->
<section class="section" id="methode">
  <div class="container">
    <header class="section__head reveal">
      <span class="label">Comment ça marche</span>
      <h2>Quatre étapes, du premier appel à la remise des clés</h2>
    </header>
    <ol class="steps">
      <li class="step card reveal ">
        <span class="step__num">01</span><span class="label">Contact</span>
        <h3>Vous nous décrivez votre projet</h3>
        <p>Formulaire ou appel. Dix minutes suffisent pour cadrer le besoin, le budget et les délais.</p>
      </li>
      <li class="step card reveal reveal--d1">
        <span class="step__num">02</span><span class="label">Expertise</span>
        <h3>Nous inspectons le véhicule</h3>
        <p>Mécanique, carrosserie, historique, kilométrage, documents. Vous recevez un rapport écrit.</p>
      </li>
      <li class="step card reveal reveal--d2">
        <span class="step__num">03</span><span class="label">Proposition</span>
        <h3>Vous recevez une offre chiffrée</h3>
        <p>Prix conseillé, offre de rachat ou formule de location, avec les arguments qui justifient chaque euro.</p>
      </li>
      <li class="step card reveal reveal--d3">
        <span class="step__num">04</span><span class="label">Transaction</span>
        <h3>Nous sécurisons la vente</h3>
        <p>Négociation, paiement vérifié, carte grise et certificat de cession : l'administratif est géré jusqu'au bout.</p>
      </li>
    </ol>
  </div>
</section>

<!-- ============ ESTIMATION ============ -->
<section class="section section--alt" id="estimation">
  <div class="container estimation">
    <div>
      <span class="label">Estimation gratuite</span>
      <h2>Le vrai prix de votre voiture, sous 24h</h2>
      <p class="lead">Un expert analyse votre véhicule, la cote du marché et la demande réelle dans votre région, puis vous envoie une fourchette de prix argumentée.</p>
      <ul class="list">
        <li>Gratuit et sans engagement</li>
        <li>Réponse d'un expert sous 24h ouvrées</li>
        <li>Offre de rachat immédiat possible</li>
        <li>Vos données ne sont jamais revendues</li>
      </ul>
    </div>
    <form class="form card" id="estimation-form" novalidate>
      <span class="card__corner card__corner--tl" aria-hidden="true"></span><span class="card__corner card__corner--br" aria-hidden="true"></span>
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

<!-- ============ TEMOIGNAGES ============ -->
<section class="section" id="avis">
  <div class="container">
    <header class="section__head section__head--row reveal">
      <div>
        <span class="label">Avis clients</span>
        <h2>Ils nous ont fait confiance</h2>
      </div>
      <div class="rating" aria-label="Note moyenne de 4,9 sur 5">
        <span class="stars stars--lg" aria-hidden="true"></span>
        <span><strong>4,9 / 5</strong> · 312 avis vérifiés</span>
      </div>
    </header>
    <div class="testimonials" id="testimonials">
      <div class="testimonials__track" id="testimonials-track"></div>
    </div>
    <div class="testimonials__nav">
      <button class="round-btn" type="button" id="t-prev" aria-label="Témoignage précédent">←</button>
      <div class="dots" id="t-dots" role="tablist" aria-label="Sélection du témoignage"></div>
      <button class="round-btn" type="button" id="t-next" aria-label="Témoignage suivant">→</button>
    </div>
  </div>
</section>

<!-- ============ A PROPOS ============ -->
<section class="section section--alt" id="apropos">
  <div class="container about">
    <div class="about__text">
      <span class="label">À propos</span>
      <h2>Le conseil automobile que nous aurions aimé trouver</h2>
      <p>Motor Consulting est né en 2013 d'un constat simple : acheter ou vendre une voiture d'occasion reste une épreuve. Prix opaques, historiques flous, acheteurs fantômes, démarches interminables.</p>
      <p>Anciens expert automobile et acheteur en concession, nous avons créé une structure <strong>100&nbsp;% indépendante</strong>, payée ni par les vendeurs ni par les constructeurs. Notre seul intérêt est que votre transaction soit la bonne.</p>
      <div class="values">
        <div class="value card">
          <span class="label">Expertise</span>
          <p>12 ans de métier, une inspection en 120 points, une lecture fine de la cote réelle.</p>
        </div>
        <div class="value card">
          <span class="label">Confiance</span>
          <p>Un tarif annoncé à l'avance et un rapport écrit sur chaque véhicule, défauts compris.</p>
        </div>
        <div class="value card">
          <span class="label">Exigence</span>
          <p>Un véhicule sur cinq seulement passe notre sélection.</p>
        </div>
      </div>
    </div>
    <div class="about__team">
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
<section class="section" id="contact">
  <div class="container">
    <header class="section__head reveal">
      <span class="label">Contact</span>
      <h2>Parlons de votre projet</h2>
    </header>
    <div class="contact">
      <div>
        <ul class="infos">
          <li class="card"><strong>Téléphone</strong><a href="tel:<?php echo esc_attr( motor_opt( 'phone_e164' ) ); ?>"><?php echo esc_html( motor_opt( 'phone_display' ) ); ?></a><small><?php echo esc_html( motor_opt( 'hours' ) ); ?></small></li>
          <li class="card"><strong>E-mail</strong><a href="mailto:<?php echo esc_html( motor_opt( 'email' ) ); ?>"><?php echo esc_html( motor_opt( 'email' ) ); ?></a></li>
          <li class="card"><strong>WhatsApp</strong><a href="https://wa.me/<?php echo esc_attr( motor_opt( 'whatsapp' ) ); ?>?text=Bonjour%2C%20je%20souhaite%20des%20informations%20sur%20la%20vente%20de%20mon%20v%C3%A9hicule." target="_blank" rel="noopener">Discuter sur WhatsApp</a><small>Envoyez-nous directement vos photos</small></li>
          <li class="card"><strong>Adresse</strong><span><?php echo esc_html( motor_opt( 'address' ) ); ?></span><small>Sur rendez-vous · Déplacements en Île-de-France</small></li>
        </ul>
        <div class="map">
          <p class="map__fallback"><?php echo esc_html( motor_opt( 'address' ) ); ?></p>
          <iframe title="Localisation de Motor Consulting sur la carte"
            src="https://www.openstreetmap.org/export/embed.html?bbox=2.2755%2C48.8705%2C2.3035%2C48.8815&amp;layer=mapnik&amp;marker=48.8759%2C2.2895"
            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          <a class="map__link" href="https://www.openstreetmap.org/?mlat=48.8759&amp;mlon=2.2895#map=16/48.8759/2.2895" target="_blank" rel="noopener">Itinéraire ↗</a>
        </div>
      </div>
      <form class="form card" id="contact-form" novalidate>
        <span class="card__corner card__corner--tl" aria-hidden="true"></span><span class="card__corner card__corner--br" aria-hidden="true"></span>
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

<!-- ============ FOOTER ============ -->
<footer class="footer">
  <div class="container footer__inner">
    <div class="footer__brand">
      <a class="logo" href="#accueil" aria-label="Motor Consulting, retour à l'accueil">
      <svg class="logo__mark" viewBox="0 0 300 96" aria-hidden="true">
        <defs>
          <linearGradient id="lg-chr-f" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0%" stop-color="#ffffff"/><stop offset="45%" stop-color="#cfd4da"/><stop offset="55%" stop-color="#6c727a"/><stop offset="100%" stop-color="#f1f4f7"/>
          </linearGradient>
          <linearGradient id="lg-gld-f" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0%" stop-color="#8a6e1e"/><stop offset="40%" stop-color="#f3e2a4"/><stop offset="60%" stop-color="#d4af37"/><stop offset="100%" stop-color="#8a6e1e"/>
          </linearGradient>
        </defs>
        <path d="M126 46V32l24-18 24 18v14" fill="none" stroke="url(#lg-gld-f)" stroke-width="5.5" stroke-linejoin="round" stroke-linecap="round"/>
        <path d="M2 80C34 62 68 46 108 38c34-7 72-7 108 0 34 7 60 20 80 40-26-14-56-22-90-24-44-3-90 4-130 14-26 6-50 12-74 12Z" fill="url(#lg-chr-f)"/>
        <path d="M60 86c40-10 90-14 180-8" fill="none" stroke="url(#lg-chr-f)" stroke-width="3.5" stroke-linecap="round"/>
      </svg>
      <span class="logo__text">
        <span class="logo__name chrome">MOTOR</span>
        <span class="logo__sub"><i></i>CONSULTING<i></i></span>
      <span class="logo__tag">L'expertise automobile à votre service</span>
      </span>
    </a>
      <p>L'expertise automobile à votre service. Recherche, négociation, achat, vente et location de véhicules d'occasion à Paris et en Île-de-France.</p>
    </div>
    <nav class="footer__col" aria-label="Services">
      <h3>Services</h3>
      <ul>
        <li><a href="#services">Recherche de véhicule</a></li>
        <li><a href="#services">Négociation</a></li>
        <li><a href="#services">Achat / Vente</a></li>
        <li><a href="#services">Location</a></li>
        <li><a href="#estimation">Estimation gratuite</a></li>
      </ul>
    </nav>
    <nav class="footer__col" aria-label="Navigation">
      <h3>Le site</h3>
      <ul>
        <li><a href="#vehicules">Véhicules disponibles</a></li>
        <li><a href="#methode">Comment ça marche</a></li>
        <li><a href="#avis">Avis clients</a></li>
        <li><a href="#apropos">À propos</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </nav>
    <div class="footer__col">
      <h3>Zone d'intervention</h3>
      <p class="footer__seo">Achat vente de voiture d'occasion à Paris, Boulogne-Billancourt, Neuilly-sur-Seine, Levallois, Versailles et toute l'Île-de-France. Rachat de voiture, expertise automobile et estimation gratuite de véhicule, déplacements dans toute la France.</p>
    </div>
  </div>
  <div class="container footer__bottom">
    <p>© <span id="year">2026</span> Motor Consulting</p>
    <ul class="footer__legal">
      <li><a href="#apropos">Mentions légales</a></li>
      <li><a href="#apropos">Confidentialité</a></li>
      <li><a href="#contact">CGV</a></li>
    </ul>
  </div>
</footer>

<div class="mobile-bar" aria-label="Contact rapide">
  <a class="mobile-bar__btn" href="tel:<?php echo esc_attr( motor_opt( 'phone_e164' ) ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.5 3.5h3l1.5 4-2 1.5a12 12 0 0 0 6 6l1.5-2 4 1.5v3c0 .9-.7 1.6-1.6 1.5C10.6 19.9 4.1 13.4 3.5 5.1A1.5 1.5 0 0 1 5 3.5h1.5Z" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg> Appeler</a>
  <a class="mobile-bar__btn mobile-bar__btn--wa" href="https://wa.me/<?php echo esc_attr( motor_opt( 'whatsapp' ) ); ?>?text=Bonjour%2C%20je%20souhaite%20une%20estimation%20de%20mon%20v%C3%A9hicule." target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3.5a8.5 8.5 0 0 0-7.3 12.8L3.5 20.5l4.4-1.1A8.5 8.5 0 1 0 12 3.5Z" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg> WhatsApp</a>
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
