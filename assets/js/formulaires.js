/* ==========================================================================
   MOTOR CONSULTING — Validation et envoi des formulaires
   --------------------------------------------------------------------------
   - Validation en français, message sous chaque champ concerné
   - Message de confirmation affiché après envoi
   - Envoi réel si `endpointFormulaire` est renseigné dans config.js,
     sinon mode démonstration (le formulaire se valide et confirme).
   ========================================================================== */
(function () {
  "use strict";

  var config = window.MC_CONFIG || {};
  var formulaires = document.querySelectorAll("form[data-formulaire]");
  if (!formulaires.length) { return; }

  /* ------------------------------------------------------- Messages */
  function message(champ) {
    var v = champ.validity;
    var type = (champ.getAttribute("type") || "").toLowerCase();

    if (v.valueMissing) {
      if (type === "checkbox") { return "Merci de cocher cette case pour continuer."; }
      if (champ.tagName === "SELECT") { return "Merci de choisir une option dans la liste."; }
      return "Ce champ est obligatoire.";
    }
    if (v.typeMismatch && type === "email") {
      return "Merci de saisir une adresse e-mail valide (ex. prenom@exemple.fr).";
    }
    if (v.patternMismatch && type === "tel") {
      return "Merci de saisir un numéro de téléphone valide (ex. 06 12 34 56 78).";
    }
    if (v.patternMismatch) { return "Le format saisi n'est pas valide."; }
    if (v.rangeUnderflow) { return "La valeur doit être supérieure ou égale à " + champ.min + "."; }
    if (v.rangeOverflow) { return "La valeur doit être inférieure ou égale à " + champ.max + "."; }
    if (v.stepMismatch) { return "Merci de saisir un nombre entier."; }
    if (v.tooShort) {
      return "Merci de détailler un peu plus (au moins " + champ.minLength + " caractères).";
    }
    if (v.badInput) { return "Merci de saisir une valeur numérique."; }
    return "Cette valeur n'est pas valide.";
  }

  function zoneErreur(champ) {
    var groupe = champ.closest(".champ") || champ.parentNode;
    var zone = groupe.querySelector(".champ__erreur");
    if (!zone) {
      zone = document.createElement("p");
      zone.className = "champ__erreur";
      groupe.appendChild(zone);
    }
    return zone;
  }

  function afficherErreur(champ) {
    var zone = zoneErreur(champ);
    zone.textContent = message(champ);
    champ.setAttribute("aria-invalid", "true");
    if (zone.id) { champ.setAttribute("aria-describedby", zone.id); }
  }

  function effacerErreur(champ) {
    zoneErreur(champ).textContent = "";
    champ.removeAttribute("aria-invalid");
  }

  function valider(champ) {
    if (champ.disabled || champ.type === "hidden" || champ.name === "societe_site") {
      return true;
    }
    if (champ.checkValidity()) { effacerErreur(champ); return true; }
    afficherErreur(champ);
    return false;
  }

  /* --------------------------------------------------------- Alertes */
  function afficherAlerte(form, type, titre, texte) {
    var alerte = form.querySelector("[data-alerte-" + type + "]");
    if (!alerte) { return; }
    var corps = alerte.querySelector("[data-alerte-texte]");
    if (corps) { corps.innerHTML = "<strong>" + titre + "</strong>" + texte; }
    alerte.hidden = false;
    alerte.setAttribute("tabindex", "-1");
    alerte.focus({ preventScroll: true });
    alerte.scrollIntoView({ behavior: "smooth", block: "center" });
  }

  function masquerAlertes(form) {
    Array.prototype.forEach.call(
      form.querySelectorAll(".alerte"),
      function (a) { a.hidden = true; }
    );
  }

  /* ---------------------------------------------------------- Envoi */
  function donnees(form) {
    var resultat = {};
    Array.prototype.forEach.call(form.elements, function (champ) {
      if (!champ.name || champ.name === "societe_site" || champ.type === "submit") { return; }
      if (champ.type === "checkbox") { resultat[champ.name] = champ.checked ? "oui" : "non"; return; }
      resultat[champ.name] = champ.value;
    });
    resultat.formulaire = form.getAttribute("data-formulaire");
    resultat.page = window.location.pathname;
    resultat.date = new Date().toISOString();
    return resultat;
  }

  function envoyer(form) {
    var charge = donnees(form);

    if (!config.endpointFormulaire) {
      /* Mode démonstration : aucune donnée n'est transmise. */
      return new Promise(function (resoudre) {
        setTimeout(function () {
          if (window.console && console.info) {
            console.info("[MOTOR CONSULTING] Demande simulée (mode démonstration) :", charge);
          }
          resoudre();
        }, 650);
      });
    }

    return fetch(config.endpointFormulaire, {
      method: "POST",
      headers: { "Content-Type": "application/json", "Accept": "application/json" },
      body: JSON.stringify(charge)
    }).then(function (reponse) {
      if (!reponse.ok) { throw new Error("Reponse " + reponse.status); }
    });
  }

  /* ------------------------------------------------------ Branchement */
  Array.prototype.forEach.call(formulaires, function (form) {
    form.setAttribute("novalidate", "novalidate");
    var soumis = false;

    /* Revalidation en direct après une première tentative */
    form.addEventListener("input", function (e) {
      if (soumis && e.target.name) { valider(e.target); }
    });
    form.addEventListener("change", function (e) {
      if (soumis && e.target.name) { valider(e.target); }
    });

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      soumis = true;
      masquerAlertes(form);

      var champs = Array.prototype.filter.call(form.elements, function (c) {
        return c.name && c.type !== "submit";
      });

      var invalides = champs.filter(function (c) { return !valider(c); });

      if (invalides.length) {
        afficherAlerte(
          form, "erreur",
          "Votre demande n'a pas pu être envoyée. ",
          "Merci de corriger les " + invalides.length + " champ" +
          (invalides.length > 1 ? "s indiqués" : " indiqué") + " ci-dessous."
        );
        invalides[0].focus();
        return;
      }

      /* Piège à robots : on simule un succès sans rien envoyer. */
      var piege = form.querySelector('[name="societe_site"]');
      if (piege && piege.value) { form.reset(); return; }

      var bouton = form.querySelector('button[type="submit"]');
      var libelle = bouton ? bouton.innerHTML : "";
      if (bouton) {
        bouton.disabled = true;
        bouton.innerHTML = "Envoi en cours\u2026";
      }

      envoyer(form).then(function () {
        var type = form.getAttribute("data-formulaire");
        var titre = type === "estimation"
          ? "Merci, votre demande d'estimation est bien enregistrée. "
          : "Merci, votre message a bien été envoyé. ";
        afficherAlerte(
          form, "succes", titre,
          "Un expert " + (config.nom || "") + " vous recontacte sous " +
          (config.delaiReponse || "24 heures ouvrees") +
          ". Pour une réponse immédiate, appelez-nous au " +
          (config.telephone || "") + "."
        );
        form.reset();
        champs.forEach(effacerErreur);
        soumis = false;
      }).catch(function () {
        afficherAlerte(
          form, "erreur",
          "L'envoi a échoué. ",
          "Merci de réessayer dans un instant ou de nous joindre directement au " +
          (config.telephone || "") + "."
        );
      }).then(function () {
        if (bouton) { bouton.disabled = false; bouton.innerHTML = libelle; }
      });
    });
  });
})();
