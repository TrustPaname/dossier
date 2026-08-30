/* ==========================================================================
   Véhicules disponibles : données, affichage des fiches et filtres
   --------------------------------------------------------------------------
   Les véhicules sont décrits dans le tableau `VEHICULES` ci-dessous.
   Pour mettre le stock à jour, il suffit de modifier ce tableau : ajoutez,
   retirez ou éditez une entrée, le reste (fiches, filtres, compteur, tri)
   s'adapte automatiquement.

   Champ `photo` : chemin vers une vraie photo (ex. "assets/img/golf.jpg").
   S'il est absent, un visuel de remplacement est généré automatiquement.
   ========================================================================== */
(function () {
  "use strict";

  var VEHICULES = [
    {
      marque: "Peugeot", modele: "308 BlueHDi 130 Allure",
      annee: 2021, km: 62400, prix: 18900,
      type: "berline", carburant: "Diesel", boite: "Automatique",
      teinte: "#3d4d63", etiquette: "Révisé"
    },
    {
      marque: "Renault", modele: "Clio V TCe 90 Intens",
      annee: 2022, km: 28150, prix: 15400,
      type: "citadine", carburant: "Essence", boite: "Manuelle",
      teinte: "#7a3038", etiquette: "Nouveau"
    },
    {
      marque: "Volkswagen", modele: "Golf 8 TSI 150 Life",
      annee: 2021, km: 47800, prix: 21500,
      type: "berline", carburant: "Essence", boite: "Automatique",
      teinte: "#2f3a45"
    },
    {
      marque: "Toyota", modele: "Yaris Hybride 116h Design",
      annee: 2022, km: 31200, prix: 19700,
      type: "citadine", carburant: "Hybride", boite: "Automatique",
      teinte: "#1f5a52", etiquette: "Coup de cœur"
    },
    {
      marque: "Dacia", modele: "Duster TCe 130 Journey",
      annee: 2023, km: 18600, prix: 20900,
      type: "suv", carburant: "Essence", boite: "Manuelle",
      teinte: "#5c4a2e"
    },
    {
      marque: "BMW", modele: "Série 3 320d xDrive M Sport",
      annee: 2020, km: 89300, prix: 29800,
      type: "berline", carburant: "Diesel", boite: "Automatique",
      teinte: "#26303d"
    },
    {
      marque: "Citroën", modele: "C3 PureTech 83 Shine",
      annee: 2021, km: 44900, prix: 12600,
      type: "citadine", carburant: "Essence", boite: "Manuelle",
      teinte: "#6b4a5e"
    },
    {
      marque: "Skoda", modele: "Octavia Combi 2.0 TDI Style",
      annee: 2021, km: 71500, prix: 22400,
      type: "break", carburant: "Diesel", boite: "Automatique",
      teinte: "#33474a"
    },
    {
      marque: "Renault", modele: "Captur E-Tech 145 Techno",
      annee: 2023, km: 14200, prix: 24300,
      type: "suv", carburant: "Hybride", boite: "Automatique",
      teinte: "#4a3f6b", etiquette: "Nouveau"
    },
    {
      marque: "Audi", modele: "A1 Sportback 30 TFSI S line",
      annee: 2020, km: 58700, prix: 20200,
      type: "citadine", carburant: "Essence", boite: "Automatique",
      teinte: "#3a3a3a"
    },
    {
      marque: "Peugeot", modele: "Partner Van L1 BlueHDi 100",
      annee: 2021, km: 96800, prix: 14900,
      type: "utilitaire", carburant: "Diesel", boite: "Manuelle",
      teinte: "#4d5a3c"
    },
    {
      marque: "Tesla", modele: "Model 3 Propulsion",
      annee: 2022, km: 39400, prix: 27900,
      type: "berline", carburant: "Électrique", boite: "Automatique",
      teinte: "#2b3f57", etiquette: "Coup de cœur"
    }
  ];

  var LIBELLES_TYPE = {
    citadine: "Citadine",
    berline: "Berline",
    suv: "SUV / Crossover",
    break: "Break",
    utilitaire: "Utilitaire"
  };

  /* ----------------------------------------------------------------------
     Utilitaires
     ---------------------------------------------------------------------- */
  function echapper(texte) {
    return String(texte)
      .replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;").replace(/'/g, "&#39;");
  }

  function formaterPrix(valeur) {
    return valeur.toLocaleString("fr-FR") + " €";
  }

  function formaterKm(valeur) {
    return valeur.toLocaleString("fr-FR") + " km";
  }

  /* Visuel de remplacement : dégradé sobre + silhouette de véhicule.
     Remplacez-le par de vraies photos via le champ `photo`. */
  function visuelParDefaut(v) {
    var teinte = v.teinte || "#3a3f47";
    var svg =
      '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 300" width="400" height="300">' +
        '<defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1">' +
          '<stop offset="0%" stop-color="' + teinte + '"/>' +
          '<stop offset="100%" stop-color="#0a0b0d"/>' +
        '</linearGradient></defs>' +
        '<rect width="400" height="300" fill="url(#g)"/>' +
        '<g fill="none" stroke="#ffffff" stroke-opacity="0.06" stroke-width="1">' +
          '<path d="M-40 260 L200 20"/><path d="M20 300 L280 10"/><path d="M120 310 L380 20"/>' +
        '</g>' +
        '<g fill="#ffffff" fill-opacity="0.9" transform="translate(30 60)">' +
          '<path d="M14 118 q3-24 24-30 l44-11 q27-25 60-27 l50 0 q33 2 58 25 l48 12 q25 6 27 31 l0 13 ' +
            'q0 8-8 8 l-23 0 a29 29 0 0 0-58 0 l-91 0 a29 29 0 0 0-58 0 l-21 0 q-8 0-8-8 z" ' +
            'fill="#ffffff" fill-opacity="0.92"/>' +
          '<path d="M96 78 q22-18 48-19 l46 0 q26 1 46 19 z" fill="' + teinte + '" fill-opacity="0.85"/>' +
        '</g>' +
        '<g transform="translate(30 60)">' +
          '<circle cx="88" cy="147" r="29" fill="#0a0b0d"/>' +
          '<circle cx="88" cy="147" r="13" fill="#ffffff" fill-opacity="0.85"/>' +
          '<circle cx="237" cy="147" r="29" fill="#0a0b0d"/>' +
          '<circle cx="237" cy="147" r="13" fill="#ffffff" fill-opacity="0.85"/>' +
        '</g>' +
      "</svg>";
    return "data:image/svg+xml;charset=utf-8," + encodeURIComponent(svg);
  }

  var ICONES = {
    calendrier: '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4M16 3v4M3 10h18"/></svg>',
    compteur: '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 18a8 8 0 1 1 16 0"/><path d="M12 14l4-4"/></svg>',
    carburant: '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 20V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v15"/><path d="M3 20h12"/><path d="M14 9h3a2 2 0 0 1 2 2v5a1.5 1.5 0 0 0 3 0V9l-3-3"/></svg>',
    boite: '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 4v16M12 4v16M18 4v8"/><circle cx="6" cy="4" r="1.4"/><circle cx="12" cy="4" r="1.4"/><circle cx="18" cy="4" r="1.4"/></svg>'
  };

  /* ----------------------------------------------------------------------
     Rendu d'une fiche
     ---------------------------------------------------------------------- */
  function gabaritFiche(v) {
    var titreComplet = v.marque + " " + v.modele;
    var image = v.photo || visuelParDefaut(v);
    var etiquette = v.etiquette
      ? '<span class="vehicule__etiquette' +
        (v.etiquette === "Coup de cœur" ? " vehicule__etiquette--accent" : "") +
        '">' + echapper(v.etiquette) + "</span>"
      : "";

    var sujetWa = "Bonjour, je suis intéressé par la " + titreComplet +
      " (" + v.annee + ", " + formaterKm(v.km) + ") vue sur votre site.";

    return '<article class="vehicule">' +
      '<div class="vehicule__visuel">' +
        '<img src="' + echapper(image) + '" width="400" height="300" loading="lazy" ' +
          'alt="' + echapper(titreComplet + " de " + v.annee + " d’occasion") + '">' +
        etiquette +
      "</div>" +
      '<div class="vehicule__corps">' +
        '<p class="vehicule__marque">' + echapper(v.marque) + " · " +
          echapper(LIBELLES_TYPE[v.type] || v.type) + "</p>" +
        '<h3 class="vehicule__titre">' + echapper(v.modele) + "</h3>" +
        '<ul class="vehicule__specs">' +
          "<li>" + ICONES.calendrier + "<span>" + v.annee + "</span></li>" +
          "<li>" + ICONES.compteur + "<span>" + formaterKm(v.km) + "</span></li>" +
          "<li>" + ICONES.carburant + "<span>" + echapper(v.carburant) + "</span></li>" +
          "<li>" + ICONES.boite + "<span>" + echapper(v.boite) + "</span></li>" +
        "</ul>" +
        '<div class="vehicule__pied">' +
          '<p class="vehicule__prix">' + formaterPrix(v.prix) +
            "<small>Prix conseillé, frais inclus</small></p>" +
          '<a class="btn btn--sombre" data-whatsapp="' + echapper(sujetWa) + '" ' +
            'href="contact.html">M’intéresse<span class="visuellement-cache"> : ' +
            echapper(titreComplet) + "</span></a>" +
        "</div>" +
      "</div>" +
    "</article>";
  }

  /* ----------------------------------------------------------------------
     Filtres
     ---------------------------------------------------------------------- */
  var grille = document.querySelector("[data-vehicules]");
  if (!grille) return;

  var champRecherche = document.getElementById("filtre-recherche");
  var champType = document.getElementById("filtre-type");
  var champAnnee = document.getElementById("filtre-annee");
  var champPrix = document.getElementById("filtre-prix");
  var sortiePrix = document.getElementById("filtre-prix-valeur");
  var champTri = document.getElementById("filtre-tri");
  var compteur = document.querySelector("[data-compteur-vehicules]");
  var blocVide = document.querySelector("[data-aucun-resultat]");
  var boutonReset = document.querySelector("[data-reinitialiser]");

  var prixMax = Math.max.apply(null, VEHICULES.map(function (v) { return v.prix; }));
  var prixPlafond = Math.ceil(prixMax / 1000) * 1000;

  // Le curseur de prix et la liste des années sont dérivés des données,
  // pour rester justes quand le stock change.
  if (champPrix) {
    champPrix.min = "5000";
    champPrix.max = String(prixPlafond);
    champPrix.step = "500";
    champPrix.value = String(prixPlafond);
  }

  if (champAnnee) {
    var annees = VEHICULES.map(function (v) { return v.annee; })
      .filter(function (a, i, t) { return t.indexOf(a) === i; })
      .sort(function (a, b) { return a - b; });
    annees.forEach(function (an) {
      var option = document.createElement("option");
      option.value = String(an);
      option.textContent = "À partir de " + an;
      champAnnee.appendChild(option);
    });
  }

  function valeursFiltres() {
    return {
      recherche: champRecherche ? champRecherche.value.trim().toLowerCase() : "",
      type: champType ? champType.value : "",
      annee: champAnnee && champAnnee.value ? parseInt(champAnnee.value, 10) : 0,
      prix: champPrix ? parseInt(champPrix.value, 10) : Infinity,
      tri: champTri ? champTri.value : "prix-asc"
    };
  }

  function trier(liste, tri) {
    if (!champTri) return liste.slice(); // ordre d'origine hors page catalogue
    var copie = liste.slice();
    switch (tri) {
      case "prix-desc": return copie.sort(function (a, b) { return b.prix - a.prix; });
      case "annee-desc": return copie.sort(function (a, b) { return b.annee - a.annee; });
      case "km-asc": return copie.sort(function (a, b) { return a.km - b.km; });
      default: return copie.sort(function (a, b) { return a.prix - b.prix; });
    }
  }

  function appliquer() {
    var f = valeursFiltres();

    if (sortiePrix && champPrix) {
      var plafondAtteint = parseInt(champPrix.value, 10) >= prixPlafond;
      sortiePrix.textContent = plafondAtteint
        ? "Tous les prix"
        : "jusqu’à " + formaterPrix(f.prix);
    }

    var resultats = VEHICULES.filter(function (v) {
      var texte = (v.marque + " " + v.modele + " " + v.carburant + " " +
        (LIBELLES_TYPE[v.type] || "")).toLowerCase();
      if (f.recherche && texte.indexOf(f.recherche) === -1) return false;
      if (f.type && v.type !== f.type) return false;
      if (f.annee && v.annee < f.annee) return false;
      if (v.prix > f.prix) return false;
      return true;
    });

    resultats = trier(resultats, f.tri);

    // Une grille « à la une » (attribut data-limite) met en avant les véhicules
    // porteurs d'une étiquette, puis complète avec le reste du stock.
    var limite = parseInt(grille.getAttribute("data-limite") || "0", 10);
    if (limite > 0) {
      var vedettes = resultats.filter(function (v) { return v.etiquette; });
      var autres = resultats.filter(function (v) { return !v.etiquette; });
      resultats = vedettes.concat(autres).slice(0, limite);
    }

    grille.innerHTML = resultats.map(gabaritFiche).join("");

    if (compteur) {
      compteur.innerHTML = resultats.length === 0
        ? "<strong>Aucun véhicule</strong> ne correspond à votre recherche"
        : "<strong>" + resultats.length + "</strong> véhicule" +
          (resultats.length > 1 ? "s" : "") + " sur " + VEHICULES.length + " disponibles";
    }
    if (blocVide) blocVide.classList.toggle("est-visible", resultats.length === 0);

    // Les fiches sont recréées : les liens WhatsApp doivent être réarmés.
    document.dispatchEvent(new CustomEvent("vehicules:rendus"));
  }

  [champRecherche, champType, champAnnee, champPrix, champTri].forEach(function (champ) {
    if (!champ) return;
    champ.addEventListener("input", appliquer);
    champ.addEventListener("change", appliquer);
  });

  if (boutonReset) {
    boutonReset.addEventListener("click", function () {
      if (champRecherche) champRecherche.value = "";
      if (champType) champType.value = "";
      if (champAnnee) champAnnee.value = "";
      if (champPrix) champPrix.value = String(prixPlafond);
      if (champTri) champTri.value = "prix-asc";
      appliquer();
      if (champRecherche) champRecherche.focus();
    });
  }

  appliquer();
})();
