/* ==========================================================================
   MOTOR CONSULTING — Configuration du site
   --------------------------------------------------------------------------
   Centralise les informations modifiables sans toucher au reste du code.
   ========================================================================== */

window.MC_CONFIG = {
  nom: "MOTOR CONSULTING",

  /* Téléphone affiché et lien d'appel */
  telephone: "02 61 91 12 34",
  telephoneLien: "+33261911234",

  /* Numero WhatsApp au format international, sans + ni espace */
  whatsapp: "33799123456",
  whatsappMessage: "Bonjour, je souhaite des informations sur la vente / la recherche d'un véhicule.",

  email: "contact@motor-consulting.fr",
  adresse: "3 rue Florence Arthaud, 28300 Mainvilliers",

  /* --------------------------------------------------------------------
     Envoi des formulaires
     --------------------------------------------------------------------
     Laissez la valeur `null` pour le mode démonstration : le formulaire est
     validé, un message de confirmation s'affiche, mais rien n'est envoyé.

     Pour recevoir réellement les demandes, indiquez ici l'URL d'un service
     de réception de formulaire (Formspree, Basin, Netlify Forms, ou votre
     propre script PHP/API). Les données sont envoyées en POST au format JSON.
     Exemple : endpointFormulaire: "https://formspree.io/f/xxxxxxx"
     -------------------------------------------------------------------- */
  endpointFormulaire: null,

  /* Délai de réponse annoncé dans les messages de confirmation */
  delaiReponse: "24 heures ouvrées"
};
