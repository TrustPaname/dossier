/* ==========================================================================
   Comportements généraux : menu mobile, animations, compteurs, liens
   ========================================================================== */
(function () {
  "use strict";

  var config = window.SITE_CONFIG || {};

  /* ----------------------------------------------------------------------
     Menu de navigation mobile
     ---------------------------------------------------------------------- */
  var burger = document.querySelector("[data-burger]");
  var menu = document.querySelector("[data-menu-mobile]");

  if (burger && menu) {
    burger.addEventListener("click", function () {
      var ouvert = burger.getAttribute("aria-expanded") === "true";
      burger.setAttribute("aria-expanded", String(!ouvert));
      menu.classList.toggle("est-ouvert", !ouvert);
    });

    // Un clic sur un lien referme le menu (utile pour les ancres).
    menu.addEventListener("click", function (e) {
      if (e.target.closest("a")) {
        burger.setAttribute("aria-expanded", "false");
        menu.classList.remove("est-ouvert");
      }
    });

    // Le passage en affichage bureau réinitialise l'état du menu.
    var mqBureau = window.matchMedia("(min-width: 1024px)");
    var fermerSiBureau = function (e) {
      if (e.matches) {
        burger.setAttribute("aria-expanded", "false");
        menu.classList.remove("est-ouvert");
      }
    };
    if (mqBureau.addEventListener) mqBureau.addEventListener("change", fermerSiBureau);

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && menu.classList.contains("est-ouvert")) {
        burger.setAttribute("aria-expanded", "false");
        menu.classList.remove("est-ouvert");
        burger.focus();
      }
    });
  }

  /* ----------------------------------------------------------------------
     Apparition progressive des blocs au défilement
     ---------------------------------------------------------------------- */
  var aAnimer = document.querySelectorAll(".apparait");
  var mouvementReduit = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  if (!("IntersectionObserver" in window) || mouvementReduit) {
    // Sans observateur (ou si l'utilisateur limite les animations),
    // tout est affiché immédiatement.
    Array.prototype.forEach.call(aAnimer, function (el) {
      el.classList.add("est-visible");
    });
  } else {
    var observateur = new IntersectionObserver(
      function (entrees) {
        entrees.forEach(function (entree) {
          if (!entree.isIntersecting) return;
          var el = entree.target;
          var delai = parseInt(el.getAttribute("data-delai") || "0", 10);
          setTimeout(function () { el.classList.add("est-visible"); }, delai);
          observateur.unobserve(el);
        });
      },
      { threshold: 0.12, rootMargin: "0px 0px -40px 0px" }
    );
    Array.prototype.forEach.call(aAnimer, function (el) { observateur.observe(el); });
  }

  /* ----------------------------------------------------------------------
     Compteurs animés des chiffres clés
     ---------------------------------------------------------------------- */
  var compteurs = document.querySelectorAll("[data-compteur]");

  function formaterNombre(valeur, decimales) {
    return valeur.toLocaleString("fr-FR", {
      minimumFractionDigits: decimales,
      maximumFractionDigits: decimales
    });
  }

  function animerCompteur(el) {
    var cible = parseFloat(el.getAttribute("data-compteur"));
    if (isNaN(cible)) return;
    var decimales = (el.getAttribute("data-compteur").split(".")[1] || "").length;
    var duree = 1400;
    var debut = null;

    function etape(horodatage) {
      if (debut === null) debut = horodatage;
      var avancement = Math.min((horodatage - debut) / duree, 1);
      // Courbe d'atténuation : rapide au début, douce à l'arrivée.
      var eased = 1 - Math.pow(1 - avancement, 3);
      el.textContent = formaterNombre(cible * eased, decimales);
      if (avancement < 1) requestAnimationFrame(etape);
      else el.textContent = formaterNombre(cible, decimales);
    }
    requestAnimationFrame(etape);
  }

  if (compteurs.length) {
    if (!("IntersectionObserver" in window) || mouvementReduit) {
      Array.prototype.forEach.call(compteurs, function (el) {
        var cible = parseFloat(el.getAttribute("data-compteur"));
        var decimales = (el.getAttribute("data-compteur").split(".")[1] || "").length;
        if (!isNaN(cible)) el.textContent = formaterNombre(cible, decimales);
      });
    } else {
      var obsCompteur = new IntersectionObserver(
        function (entrees) {
          entrees.forEach(function (entree) {
            if (!entree.isIntersecting) return;
            animerCompteur(entree.target);
            obsCompteur.unobserve(entree.target);
          });
        },
        { threshold: 0.5 }
      );
      Array.prototype.forEach.call(compteurs, function (el) { obsCompteur.observe(el); });
    }
  }

  /* ----------------------------------------------------------------------
     Liens WhatsApp : ajout du message pré-rempli et du numéro configuré
     ---------------------------------------------------------------------- */
  function armerLiensWhatsapp() {
    var numero = (config.whatsapp || "").replace(/[^0-9]/g, "");
    if (!numero) return; // sans numéro configuré, le lien d'origine est conservé
    var liens = document.querySelectorAll("[data-whatsapp]");
    Array.prototype.forEach.call(liens, function (lien) {
      var message = lien.getAttribute("data-whatsapp") ||
        "Bonjour, je souhaite être accompagné pour l'achat ou la vente d'un véhicule d'occasion.";
      lien.href = "https://wa.me/" + numero + "?text=" + encodeURIComponent(message);
      lien.rel = "noopener";
    });
  }

  armerLiensWhatsapp();

  // Les fiches véhicules sont régénérées à chaque filtrage : on réarme les liens.
  document.addEventListener("vehicules:rendus", armerLiensWhatsapp);

  /* ----------------------------------------------------------------------
     Année courante dans le pied de page
     ---------------------------------------------------------------------- */
  var annee = document.querySelectorAll("[data-annee]");
  Array.prototype.forEach.call(annee, function (el) {
    el.textContent = String(new Date().getFullYear());
  });
})();
