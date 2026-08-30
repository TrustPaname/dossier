/* ==========================================================================
   Configuration du site — à adapter avant la mise en ligne.
   Ce fichier est le SEUL endroit où régler l'envoi des formulaires.
   ========================================================================== */

window.SITE_CONFIG = {
  /* ------------------------------------------------------------------
     Envoi des formulaires
     ------------------------------------------------------------------
     Renseignez `endpointFormulaire` avec l'URL de votre service de
     réception (Formspree, Web3Forms, Getform, Netlify Forms, ou votre
     propre API). Les données sont alors envoyées en POST au format JSON.

     Tant que ce champ est vide, le site bascule automatiquement sur le
     mode « mailto » : le logiciel de messagerie du visiteur s'ouvre avec
     la demande pré-remplie, et un rappel des moyens de contact directs
     s'affiche. Aucune demande n'est donc jamais perdue en silence.
  */
  endpointFormulaire: "",

  /* Coordonnées utilisées par le mode « mailto » et les liens WhatsApp.
     Elles doivent rester identiques à celles affichées dans les pages. */
  email: "contact@autoprestige-conseil.fr",
  telephone: "+33 1 84 60 12 40",
  telephoneLien: "+33184601240",
  whatsapp: "33612345678",

  /* Délai de réponse annoncé dans les messages de confirmation. */
  delaiReponse: "24 heures ouvrées"
};
