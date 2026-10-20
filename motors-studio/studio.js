/* Motors Studio — compléments : devis express et liens de prestation */
(function () {
  "use strict";
  const $ = (s, c) => (c || document).querySelector(s);
  const $$ = (s, c) => Array.from((c || document).querySelectorAll(s));
  const quick = $("#quick-form");
  const target = $("#e-prestation");

  // Puces « demandes fréquentes » : préremplissent la prestation du devis express
  if (quick) {
    const chips = $$("[data-prestation]", quick);
    const hidden = $("#q-demandes");
    const syncChips = () => {
      const on = chips.filter((c) => c.classList.contains("is-on"));
      if (hidden) hidden.value = on.map((c) => c.textContent.trim()).join(", ");
      const sel = $("#q-prestation");
      if (sel && on.length) {
        // prestation = famille du premier choix ; si plusieurs familles : « Plusieurs prestations »
        const fams = Array.from(new Set(on.map((c) => c.dataset.prestation)));
        if (fams.length === 1) sel.value = fams[0];
        else if (Array.from(sel.options).some((o) => o.value === "Plusieurs prestations")) sel.value = "Plusieurs prestations";
      }
    };
    chips.forEach((chip) => chip.addEventListener("click", () => {
      chip.classList.toggle("is-on");
      chip.setAttribute("aria-pressed", chip.classList.contains("is-on") ? "true" : "false");
      syncChips();
    }));
    quick.addEventListener("reset", () => { chips.forEach((c) => { c.classList.remove("is-on"); c.setAttribute("aria-pressed", "false"); }); if (hidden) hidden.value = ""; });
    // Avant l'envoi (phase de capture), recopie les champs dans le formulaire complet
    quick.addEventListener("submit", () => {
      const map = { "#q-prestation": "#e-prestation", "#q-immat": "#e-immat", "#q-tel": "#e-tel", "#q-email": "#e-email" };
      Object.keys(map).forEach((from) => {
        const a = $(from), b = $(map[from]);
        if (a && b && a.value && !b.value) b.value = a.value;
      });
      const msg = $("#e-message");
      if (msg && hidden && hidden.value && !msg.value) msg.value = "Demandes : " + hidden.value;
      const nom = $("#q-nom"), prenom = $("#q-prenom"), cible = $("#e-nom");
      if (cible && !cible.value && (nom || prenom)) cible.value = [prenom && prenom.value, nom && nom.value].filter(Boolean).join(" ");
    }, true);
  }

  // Liens « Chiffrer… » des prestations : préremplissent le devis complet
  $$("a[data-prestation]").forEach((a) => a.addEventListener("click", () => {
    if (target) target.value = a.dataset.prestation;
  }));
})();
