/* =========================================================
   Motor Consulting — Données du site
   Modifiez librement ce fichier : véhicules et témoignages
   sont rendus dynamiquement à partir de ces tableaux.
   ========================================================= */

/* --- Silhouettes de véhicules (SVG inline, aucun fichier image à charger) --- */
const CAR_SHAPES = {
  citadine: {
    body: "M36 166 C36 146 42 136 58 132 L106 120 C124 100 142 88 168 85 L246 83 C266 83 280 92 288 108 L300 134 L342 140 C356 144 362 152 362 166 Z",
    glass: "M126 116 C140 99 154 91 172 89 L196 88 L196 115 Z M208 88 L242 87 C258 87 268 94 274 106 L279 115 L208 115 Z",
    wheels: [[112, 166], [300, 166]], r: 29
  },
  berline: {
    body: "M30 166 C30 146 36 136 52 132 L104 120 C122 100 142 88 168 85 L232 82 C258 80 278 90 294 110 L316 132 L352 140 C368 144 374 152 374 166 Z",
    glass: "M122 117 C137 100 153 92 173 90 L196 89 L196 116 Z M208 89 L231 88 C251 87 265 94 277 108 L285 116 L208 116 Z",
    wheels: [[108, 166], [304, 166]], r: 30
  },
  suv: {
    body: "M28 164 C28 140 34 128 52 124 L100 112 C116 88 138 74 166 71 L236 68 C264 66 284 78 298 100 L316 126 L354 134 C370 138 376 148 376 164 Z",
    glass: "M120 108 C134 89 150 80 170 78 L196 77 L196 107 Z M208 77 L234 76 C254 75 268 83 279 98 L286 107 L208 107 Z",
    wheels: [[110, 164], [302, 164]], r: 34
  },
  break: {
    body: "M30 166 C30 146 36 136 52 132 L104 120 C122 100 142 88 168 85 L286 82 C310 82 324 92 332 108 L344 134 L356 140 C368 145 374 152 374 166 Z",
    glass: "M122 117 C137 100 153 92 173 90 L196 89 L196 116 Z M208 89 L284 88 C300 88 310 95 316 107 L320 116 L208 116 Z",
    wheels: [[108, 166], [304, 166]], r: 30
  },
  utilitaire: {
    body: "M30 166 V132 C30 122 36 116 48 112 L96 104 C110 84 128 74 152 72 L336 72 C356 72 366 82 366 100 V166 Z",
    glass: "M118 104 C130 87 144 80 160 79 L196 78 L196 103 Z",
    wheels: [[104, 166], [306, 166]], r: 30
  }
};

const TYPE_TO_SHAPE = {
  "Citadine": "citadine",
  "Berline": "berline",
  "SUV": "suv",
  "Break": "break",
  "Monospace": "break",
  "Utilitaire": "utilitaire"
};

/**
 * Génère l'illustration SVG d'un véhicule.
 * @param {object} v véhicule
 * @param {string} idSuffix suffixe unique pour les dégradés
 */
function carSvg(v, idSuffix) {
  const shape = CAR_SHAPES[TYPE_TO_SHAPE[v.type] || "berline"];
  const uid = `c${v.id}${idSuffix || ""}`;
  const couleurs = v.couleurs && v.couleurs.length === 2 ? v.couleurs : ["#3c4652", "#1b2027"];
  const wheels = shape.wheels.map(([cx, cy]) => `
      <circle cx="${cx}" cy="${cy}" r="${shape.r}" fill="#08080a"/>
      <circle cx="${cx}" cy="${cy}" r="${shape.r}" fill="none" stroke="#0a8cff" stroke-opacity=".3"/>
      <circle cx="${cx}" cy="${cy}" r="${shape.r - 9}" fill="#2b3138"/>
      <circle cx="${cx}" cy="${cy}" r="${shape.r - 15}" fill="#c6ccd4"/>`).join("");

  return `
<svg viewBox="0 0 400 220" role="img" aria-label="${v.marque} ${v.modele}" preserveAspectRatio="xMidYMid slice">
  <defs>
    <linearGradient id="bg-${uid}" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="#141417"/><stop offset="100%" stop-color="#0c0c0e"/>
    </linearGradient>
    <linearGradient id="body-${uid}" x1="0" y1="0" x2="0" y2="1">
      <stop offset="0%" stop-color="${couleurs[0]}"/><stop offset="100%" stop-color="${couleurs[1]}"/>
    </linearGradient>
  </defs>
  <rect width="400" height="220" fill="url(#bg-${uid})"/>
  <path d="M0 196h400" stroke="#0a8cff" stroke-opacity=".25" stroke-width="1"/>
  <ellipse cx="200" cy="188" rx="168" ry="14" fill="#000" opacity=".38"/>
  <path d="${shape.body}" fill="url(#body-${uid})" opacity=".8"/>
  <path d="${shape.glass}" fill="#0d1218" opacity=".72"/>
  <path d="${shape.body}" fill="none" stroke="#0a8cff" stroke-opacity=".55" stroke-width="1.6"/>
  ${wheels}
  <rect x="0" y="196" width="400" height="24" fill="#0a0a0b"/>
</svg>`;
}

/* --------------------------- Véhicules --------------------------- */
const VEHICLES = []; // aucun véhicule d'exemple : le stock arrive du flux Kepler (Apparence → Personnaliser → Stock Kepler) ou du menu Véhicules

/* ------------------------- Témoignages ------------------------- */
const TESTIMONIALS = []; // aucun avis inventé : les vrais avis seront ajoutés depuis WordPress (menu Témoignages)
