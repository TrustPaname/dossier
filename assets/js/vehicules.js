/* ==========================================================================
   MOTOR CONSULTING — Affichage, recherche et filtres du catalogue
   Alimenté par assets/js/vehicules-data.js (window.VEHICULES).
   ========================================================================== */
(function () {
  "use strict";

  var vehicules = window.VEHICULES || [];
  var liste = document.getElementById("liste-vehicules");
  var vedette = document.querySelector("[data-vehicules-vedette]");
  if (!liste && !vedette) { return; }

  /* ------------------------------------------------------- Utilitaires */
  var LIBELLES_TYPE = {
    citadine: "Citadine", berline: "Berline", suv: "SUV / 4x4",
    break: "Break", monospace: "Monospace", utilitaire: "Utilitaire"
  };

  function euros(valeur) {
    return new Intl.NumberFormat("fr-FR", {
      style: "currency", currency: "EUR", maximumFractionDigits: 0
    }).format(valeur);
  }

  function nombre(valeur) {
    return new Intl.NumberFormat("fr-FR").format(valeur);
  }

  function sansAccent(texte) {
    var t = String(texte).toLowerCase();
    return t.normalize ? t.normalize("NFD").replace(/[\u0300-\u036f]/g, "") : t;
  }

  function echapper(texte) {
    return String(texte)
      .replace(/&/g, "&amp;").replace(/</g, "&lt;")
      .replace(/>/g, "&gt;").replace(/"/g, "&quot;");
  }

  var ICONES = {
    calendrier: '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>',
    compteur: '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M12 20a8 8 0 1 0-8-8"/><path d="m12 12 4-4"/><path d="M4 20h16"/></svg>',
    carburant: '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M3 22V4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v18"/><path d="M2 22h13"/><path d="M17 10h2a2 2 0 0 1 2 2v5a2 2 0 0 0 2 2"/><path d="M13 9h4"/></svg>',
    boite: '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 4v16M12 4v16M18 4v16M6 4h12M6 12h12"/></svg>'
  };

  function etiquette(v) {
    if (v.statut === "reserve") {
      return '<span class="vehicule__etiquette vehicule__etiquette--reserve">Réservé</span>';
    }
    if (v.statut === "nouveaute") {
      return '<span class="vehicule__etiquette">Nouveauté</span>';
    }
    return '<span class="vehicule__etiquette vehicule__etiquette--dispo">Disponible</span>';
  }

  function carte(v) {
    var titre = echapper(v.marque + " " + v.modele);
    var image = v.image || ("assets/img/vehicule-" + v.type + ".svg");
    var reserve = v.statut === "reserve";
    var sujet = encodeURIComponent(
      "Demande d'information : " + v.marque + " " + v.modele + " (" + v.annee + ")"
    );

    return '' +
      '<article class="vehicule">' +
        '<div class="vehicule__media">' +
          etiquette(v) +
          '<img src="' + image + '" alt="' + titre + ' ' + v.annee +
            ' - ' + echapper(LIBELLES_TYPE[v.type] || v.type) + '" loading="lazy" width="800" height="500">' +
        '</div>' +
        '<div class="vehicule__corps">' +
          '<h3 class="vehicule__titre">' + titre + '</h3>' +
          '<p class="vehicule__version">' + echapper(v.version) + '</p>' +
          '<ul class="vehicule__specs">' +
            '<li>' + ICONES.calendrier + '<span>' + v.annee + '</span></li>' +
            '<li>' + ICONES.compteur + '<span>' + nombre(v.km) + ' km</span></li>' +
            '<li>' + ICONES.carburant + '<span>' + echapper(v.energie) + '</span></li>' +
            '<li>' + ICONES.boite + '<span>' + echapper(v.boite) + '</span></li>' +
          '</ul>' +
          (v.atouts && v.atouts.length
            ? '<p class="vehicule__atouts">' + echapper(v.atouts.join(" \u00b7 ")) + '</p>'
            : '') +
          '<div class="vehicule__pied">' +
            '<p class="vehicule__prix">' + euros(v.prix) +
              '<small>Prix TTC, clé en main</small></p>' +
            '<a class="btn btn--petit ' + (reserve ? "btn--secondaire" : "btn--sombre") +
              '" href="contact.html?vehicule=' + sujet + '">' +
              (reserve ? "Être alerté" : "En savoir plus") +
              '<span class="visuellement-cache"> : ' + titre + '</span></a>' +
          '</div>' +
        '</div>' +
      '</article>';
  }

  /* ------------------------------------- Sélection mise en avant (accueil) */
  if (vedette) {
    var limite = parseInt(vedette.getAttribute("data-limite"), 10) || 3;
    var selection = vehicules
      .filter(function (v) { return v.statut !== "reserve"; })
      .slice(0, limite);
    vedette.innerHTML = selection.map(carte).join("");
  }

  if (!liste) { return; }

  /* ------------------------------------------------ Page catalogue */
  var form = document.getElementById("filtres");
  var compteur = document.getElementById("compteur");
  var aucun = document.getElementById("aucun-resultat");

  function valeur(nom) {
    var champ = form ? form.elements[nom] : null;
    return champ ? champ.value.trim() : "";
  }

  function filtrer() {
    var recherche = sansAccent(valeur("recherche"));
    var type = valeur("type");
    var energie = valeur("energie");
    var prixMax = parseInt(valeur("prixMax"), 10);
    var anneeMin = parseInt(valeur("anneeMin"), 10);
    var tri = valeur("tri") || "recent";

    var resultats = vehicules.filter(function (v) {
      if (type && v.type !== type) { return false; }
      if (energie && v.energie !== energie) { return false; }
      if (!isNaN(prixMax) && v.prix > prixMax) { return false; }
      if (!isNaN(anneeMin) && v.annee < anneeMin) { return false; }
      if (recherche) {
        var texte = sansAccent([v.marque, v.modele, v.version, v.energie,
          v.boite, LIBELLES_TYPE[v.type]].join(" "));
        var mots = recherche.split(/\s+/);
        for (var i = 0; i < mots.length; i++) {
          if (texte.indexOf(mots[i]) === -1) { return false; }
        }
      }
      return true;
    });

    resultats.sort(function (a, b) {
      if (tri === "prix-croissant") { return a.prix - b.prix; }
      if (tri === "prix-decroissant") { return b.prix - a.prix; }
      if (tri === "km-croissant") { return a.km - b.km; }
      return b.annee - a.annee;
    });

    return resultats;
  }

  function afficher() {
    var resultats = filtrer();
    liste.innerHTML = resultats.map(carte).join("");

    if (compteur) {
      compteur.innerHTML = resultats.length === 0
        ? "<strong>Aucun véhicule</strong> ne correspond à votre recherche."
        : "<strong>" + resultats.length + "</strong> véhicule" +
          (resultats.length > 1 ? "s" : "") + " sur " + vehicules.length +
          " correspond" + (resultats.length > 1 ? "ent" : "") + " à votre recherche.";
    }
    if (aucun) { aucun.hidden = resultats.length !== 0; }
    liste.hidden = resultats.length === 0;
  }

  if (form) {
    /* Pré-remplissage depuis l'URL : vehicules.html?type=suv */
    var params = new URLSearchParams(window.location.search);
    ["type", "energie", "prixMax", "anneeMin", "recherche", "tri"].forEach(function (nom) {
      var val = params.get(nom);
      if (val && form.elements[nom]) { form.elements[nom].value = val; }
    });

    form.addEventListener("submit", function (e) { e.preventDefault(); afficher(); });
    form.addEventListener("input", afficher);
    form.addEventListener("change", afficher);

    var reinit = document.getElementById("reinitialiser");
    if (reinit) {
      reinit.addEventListener("click", function () {
        form.reset();
        afficher();
        var champ = form.elements.recherche;
        if (champ) { champ.focus(); }
      });
    }
  }

  afficher();
})();
