/* ==========================================================================
   Formulaires : validation en français et envoi de la demande
   --------------------------------------------------------------------------
   Un formulaire est pris en charge dès qu'il porte l'attribut
   `data-formulaire="<nom>"`. Chaque champ à valider doit avoir un `id`,
   et son message d'erreur un id de la forme `<id>-erreur`.
   ========================================================================== */
(function () {
  "use strict";

  var config = window.SITE_CONFIG || {};
  var REGEX_EMAIL = /^[^\s@]+@[^\s@]+\.[a-z]{2,}$/i;
  // Numéros français et internationaux : chiffres, espaces, points, tirets, +
  var REGEX_TEL = /^(?:\+?\d[\d\s.\-()]{7,})$/;

  /* ----------------------------------------------------------------------
     Messages d'erreur
     ---------------------------------------------------------------------- */
  function messageErreur(champ) {
    var valeur = (champ.value || "").trim();
    var type = champ.getAttribute("type");
    var libelle = champ.getAttribute("data-libelle") || "ce champ";

    if (champ.type === "checkbox") {
      return champ.required && !champ.checked
        ? "Merci de cocher cette case pour continuer."
        : "";
    }

    if (champ.required && !valeur) {
      return champ.tagName === "SELECT"
        ? "Merci de sélectionner une option."
        : "Merci d'indiquer " + libelle + ".";
    }

    if (!valeur) return ""; // champ facultatif laissé vide

    if (type === "email" && !REGEX_EMAIL.test(valeur)) {
      return "Cette adresse e-mail semble incomplète (exemple : prenom@domaine.fr).";
    }

    if (type === "tel" && !REGEX_TEL.test(valeur)) {
      return "Ce numéro de téléphone semble incorrect (exemple : 06 12 34 56 78).";
    }

    if (type === "number") {
      var nombre = Number(valeur);
      if (isNaN(nombre)) return "Merci d'indiquer un nombre.";
      var min = champ.getAttribute("min");
      var max = champ.getAttribute("max");
      if (min !== null && nombre < Number(min)) {
        return "La valeur doit être supérieure ou égale à " + min + ".";
      }
      if (max !== null && nombre > Number(max)) {
        return "La valeur doit être inférieure ou égale à " + max + ".";
      }
    }

    var minLength = parseInt(champ.getAttribute("minlength") || "0", 10);
    if (minLength && valeur.length < minLength) {
      return "Merci de saisir au moins " + minLength + " caractères.";
    }

    return "";
  }

  /* ----------------------------------------------------------------------
     Affichage de l'état d'un champ
     ---------------------------------------------------------------------- */
  function elementErreur(champ) {
    return champ.id ? document.getElementById(champ.id + "-erreur") : null;
  }

  function afficherErreur(champ, message) {
    var bloc = elementErreur(champ);
    if (message) {
      champ.setAttribute("aria-invalid", "true");
      if (bloc) {
        bloc.textContent = message;
        bloc.classList.add("est-visible");
      }
    } else {
      champ.removeAttribute("aria-invalid");
      if (bloc) {
        bloc.textContent = "";
        bloc.classList.remove("est-visible");
      }
    }
  }

  function validerChamp(champ) {
    var message = messageErreur(champ);
    afficherErreur(champ, message);
    return !message;
  }

  function champsAValider(formulaire) {
    return Array.prototype.filter.call(
      formulaire.querySelectorAll("input, select, textarea"),
      function (champ) {
        return !champ.disabled &&
               champ.type !== "hidden" &&
               champ.type !== "submit" &&
               !champ.closest(".pot-de-miel");
      }
    );
  }

  /* ----------------------------------------------------------------------
     Messages de confirmation / d'erreur
     ---------------------------------------------------------------------- */
  var ICONE_OK = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg>';
  var ICONE_KO = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16.5v.01"/></svg>';

  function afficherMessage(formulaire, type, titre, corpsHtml) {
    var bloc = formulaire.querySelector("[data-message]");
    if (!bloc) return;
    bloc.className = "formulaire__message formulaire__message--" + type + " est-visible";
    bloc.innerHTML = (type === "succes" ? ICONE_OK : ICONE_KO) +
      "<div><strong>" + titre + "</strong>" + corpsHtml + "</div>";
    bloc.setAttribute("role", type === "succes" ? "status" : "alert");
    bloc.scrollIntoView({ behavior: "smooth", block: "center" });
  }

  function masquerMessage(formulaire) {
    var bloc = formulaire.querySelector("[data-message]");
    if (bloc) bloc.className = "formulaire__message";
  }

  /* ----------------------------------------------------------------------
     Récupération et mise en forme des données
     ---------------------------------------------------------------------- */
  function collecterDonnees(formulaire) {
    var donnees = {};
    champsAValider(formulaire).forEach(function (champ) {
      if (!champ.name) return;
      if (champ.type === "checkbox") {
        donnees[champ.name] = champ.checked ? "oui" : "non";
      } else {
        donnees[champ.name] = (champ.value || "").trim();
      }
    });
    return donnees;
  }

  function libelleDuChamp(formulaire, nom) {
    var champ = formulaire.querySelector('[name="' + nom + '"]');
    if (!champ || !champ.id) return nom;
    var label = formulaire.querySelector('label[for="' + champ.id + '"]');
    if (!label) return nom;
    return label.textContent.replace(/\s*\*\s*$/, "").trim();
  }

  function construireCorpsTexte(formulaire, donnees) {
    var lignes = [];
    Object.keys(donnees).forEach(function (nom) {
      if (!donnees[nom]) return;
      lignes.push(libelleDuChamp(formulaire, nom) + " : " + donnees[nom]);
    });
    return lignes.join("\n");
  }

  /* ----------------------------------------------------------------------
     Envoi
     ---------------------------------------------------------------------- */
  function envoyerVersEndpoint(url, charge) {
    return fetch(url, {
      method: "POST",
      headers: { "Content-Type": "application/json", Accept: "application/json" },
      body: JSON.stringify(charge)
    }).then(function (reponse) {
      if (!reponse.ok) throw new Error("Réponse " + reponse.status);
      return reponse;
    });
  }

  function replierSurMail(formulaire, sujet, corps) {
    var destinataire = config.email || "";
    var lien = "mailto:" + destinataire +
      "?subject=" + encodeURIComponent(sujet) +
      "&body=" + encodeURIComponent(corps);

    // Ouvre le logiciel de messagerie avec la demande déjà rédigée.
    window.location.href = lien;

    var secours = "";
    if (destinataire) {
      secours += '<br>Si rien ne s\'est ouvert, envoyez votre demande à ' +
        '<a href="mailto:' + destinataire + '">' + destinataire + "</a>";
    }
    if (config.telephone) {
      secours += ' ou appelez le <a href="tel:' + (config.telephoneLien || "") + '">' +
        config.telephone + "</a>.";
    }

    afficherMessage(
      formulaire,
      "succes",
      "Votre demande est prête à être envoyée.",
      "<p>Votre logiciel de messagerie vient de s'ouvrir avec le récapitulatif " +
        "pré-rempli : il ne reste qu'à cliquer sur « Envoyer »." + secours + "</p>"
    );
  }

  /* ----------------------------------------------------------------------
     Initialisation
     ---------------------------------------------------------------------- */
  function initialiser(formulaire) {
    var nom = formulaire.getAttribute("data-formulaire");
    var sujet = formulaire.getAttribute("data-sujet") ||
      "Demande depuis le site — " + nom;
    var bouton = formulaire.querySelector('[type="submit"]');
    var texteBouton = bouton ? bouton.textContent : "";

    formulaire.setAttribute("novalidate", "novalidate");

    // Validation à la sortie du champ, puis en direct une fois l'erreur signalée.
    champsAValider(formulaire).forEach(function (champ) {
      var evenement = champ.tagName === "SELECT" || champ.type === "checkbox"
        ? "change" : "blur";
      champ.addEventListener(evenement, function () { validerChamp(champ); });
      champ.addEventListener("input", function () {
        if (champ.getAttribute("aria-invalid") === "true") validerChamp(champ);
      });
    });

    formulaire.addEventListener("submit", function (e) {
      e.preventDefault();
      masquerMessage(formulaire);

      // Piège à robots : un humain ne remplit jamais ce champ.
      var piege = formulaire.querySelector(".pot-de-miel input");
      if (piege && piege.value) return;

      var champs = champsAValider(formulaire);
      var premierInvalide = null;
      champs.forEach(function (champ) {
        if (!validerChamp(champ) && !premierInvalide) premierInvalide = champ;
      });

      if (premierInvalide) {
        afficherMessage(
          formulaire,
          "erreur",
          "Le formulaire est incomplet.",
          "<p>Merci de corriger les champs signalés en rouge, puis de renvoyer votre demande.</p>"
        );
        premierInvalide.focus();
        return;
      }

      var donnees = collecterDonnees(formulaire);
      var corps = construireCorpsTexte(formulaire, donnees);
      donnees._formulaire = nom;
      donnees._page = window.location.href;

      if (!config.endpointFormulaire) {
        // Aucun service de réception configuré : voir assets/js/config.js
        replierSurMail(formulaire, sujet, corps);
        formulaire.reset();
        return;
      }

      if (bouton) {
        bouton.disabled = true;
        bouton.textContent = "Envoi en cours…";
      }

      envoyerVersEndpoint(config.endpointFormulaire, donnees)
        .then(function () {
          afficherMessage(
            formulaire,
            "succes",
            "Demande bien reçue, merci !",
            "<p>Un conseiller vous répond sous " +
              (config.delaiReponse || "24 heures ouvrées") +
              ". Vous recevrez notre retour par e-mail ou par téléphone.</p>"
          );
          formulaire.reset();
          champs.forEach(function (champ) { afficherErreur(champ, ""); });
        })
        .catch(function () {
          var secours = config.telephone
            ? ' ou appelez-nous au <a href="tel:' + (config.telephoneLien || "") + '">' +
              config.telephone + "</a>"
            : "";
          afficherMessage(
            formulaire,
            "erreur",
            "L'envoi n'a pas abouti.",
            "<p>Un incident technique nous empêche d'enregistrer votre demande. " +
              "Merci de réessayer dans quelques instants" + secours + ".</p>"
          );
        })
        .then(function () {
          if (bouton) {
            bouton.disabled = false;
            bouton.textContent = texteBouton;
          }
        });
    });
  }

  var formulaires = document.querySelectorAll("[data-formulaire]");
  Array.prototype.forEach.call(formulaires, initialiser);

  if (formulaires.length && !config.endpointFormulaire) {
    console.info(
      "[Formulaires] Aucun endpoint configuré : mode « mailto » actif. " +
      "Renseignez SITE_CONFIG.endpointFormulaire dans assets/js/config.js " +
      "pour recevoir les demandes automatiquement."
    );
  }
})();
