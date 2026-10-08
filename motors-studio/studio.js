/* Motors Studio — compléments : devis express et liens de prestation */
(function () {
  "use strict";
  const $ = (s, c) => (c || document).querySelector(s);
  const $$ = (s, c) => Array.from((c || document).querySelectorAll(s));
  const quick = $("#quick-form");
  const target = $("#e-prestation");

  // Puces « demandes fréquentes » : préremplissent la prestation du devis express
  if (quick) {
    $$("[data-prestation]", quick).forEach((chip) => chip.addEventListener("click", () => {
      const sel = $("#q-prestation");
      if (sel) sel.value = chip.dataset.prestation;
      chip.classList.add("is-on");
      const tel = $("#q-tel"); if (tel) tel.focus({ preventScroll: true });
    }));
    // Avant l'envoi (phase de capture), recopie les champs dans le formulaire complet
    quick.addEventListener("submit", () => {
      const map = { "#q-prestation": "#e-prestation", "#q-marque": "#e-marque", "#q-tel": "#e-tel" };
      Object.keys(map).forEach((from) => {
        const a = $(from), b = $(map[from]);
        if (a && b && a.value && !b.value) b.value = a.value;
      });
    }, true);
  }

  // Liens « Chiffrer… » des prestations : préremplissent le devis complet
  $$("a[data-prestation]").forEach((a) => a.addEventListener("click", () => {
    if (target) target.value = a.dataset.prestation;
  }));
})();
