/* ==========================================================================
   MOTOR CONSULTING — Comportements generaux
   Navigation mobile, année du copyright, apparition au défilement,
   liens WhatsApp construits depuis la configuration.
   ========================================================================== */
(function () {
  "use strict";

  var config = window.MC_CONFIG || {};

  /* ------------------------------------------------ Navigation mobile */
  var bascule = document.querySelector(".nav-bascule");
  var nav = document.getElementById("navigation-principale");

  if (bascule && nav) {
    bascule.addEventListener("click", function () {
      var ouvert = nav.classList.toggle("est-ouvert");
      bascule.setAttribute("aria-expanded", ouvert ? "true" : "false");
    });

    /* Fermeture au clic sur un lien (navigation par ancre) */
    nav.addEventListener("click", function (e) {
      if (e.target.closest("a") && window.innerWidth < 992) {
        nav.classList.remove("est-ouvert");
        bascule.setAttribute("aria-expanded", "false");
      }
    });

    /* Fermeture avec la touche Échap */
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && nav.classList.contains("est-ouvert")) {
        nav.classList.remove("est-ouvert");
        bascule.setAttribute("aria-expanded", "false");
        bascule.focus();
      }
    });
  }

  /* ------------------------------------------------------ Liens WhatsApp */
  if (config.whatsapp) {
    var url = "https://wa.me/" + config.whatsapp +
      "?text=" + encodeURIComponent(config.whatsappMessage || "Bonjour");
    Array.prototype.forEach.call(
      document.querySelectorAll("[data-whatsapp]"),
      function (lien) { lien.setAttribute("href", url); }
    );
  }

  /* --------------------------------------------------- Année en cours */
  Array.prototype.forEach.call(
    document.querySelectorAll("[data-annee]"),
    function (el) { el.textContent = new Date().getFullYear(); }
  );

  /* -------------------- Pré-remplissage depuis une fiche véhicule ------- */
  var vehiculeDemande = new URLSearchParams(window.location.search).get("vehicule");
  if (vehiculeDemande) {
    var sujet = document.querySelector('[data-sujet-vehicule]');
    if (sujet) { sujet.value = vehiculeDemande; }
    var messageContact = document.querySelector('form[data-formulaire] textarea[name="message"]');
    if (messageContact && !messageContact.value) {
      messageContact.value = "Bonjour,\n\n" + vehiculeDemande +
        "\nJe souhaite obtenir plus d'informations sur ce véhicule (disponibilité, historique, essai).\n\nMerci.";
    }
  }

  /* ------------------------------------------ Apparition au défilement */
  var aAnimer = document.querySelectorAll(".apparait");
  var animationReduite = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  if (!aAnimer.length) { return; }

  if (animationReduite || typeof IntersectionObserver === "undefined") {
    Array.prototype.forEach.call(aAnimer, function (el) {
      el.classList.add("est-visible");
    });
    return;
  }

  var observateur = new IntersectionObserver(function (entrees) {
    entrees.forEach(function (entree) {
      if (entree.isIntersecting) {
        entree.target.classList.add("est-visible");
        observateur.unobserve(entree.target);
      }
    });
  }, { rootMargin: "0px 0px -60px 0px", threshold: 0.08 });

  Array.prototype.forEach.call(aAnimer, function (el) { observateur.observe(el); });
})();
