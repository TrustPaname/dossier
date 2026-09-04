/* =========================================================
   Trust Auto Paris — Données du site
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
  const wheels = shape.wheels.map(([cx, cy]) => `
      <circle cx="${cx}" cy="${cy}" r="${shape.r}" fill="#0b0d10"/>
      <circle cx="${cx}" cy="${cy}" r="${shape.r - 9}" fill="#2b3138"/>
      <circle cx="${cx}" cy="${cy}" r="${shape.r - 15}" fill="#8d97a4"/>`).join("");

  return `
<svg viewBox="0 0 400 220" role="img" aria-label="${v.marque} ${v.modele}" preserveAspectRatio="xMidYMid slice">
  <defs>
    <linearGradient id="bg-${uid}" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="#1c2128"/><stop offset="100%" stop-color="#0d0f12"/>
    </linearGradient>
    <linearGradient id="body-${uid}" x1="0" y1="0" x2="0" y2="1">
      <stop offset="0%" stop-color="${v.couleurs[0]}"/><stop offset="100%" stop-color="${v.couleurs[1]}"/>
    </linearGradient>
  </defs>
  <rect width="400" height="220" fill="url(#bg-${uid})"/>
  <circle cx="330" cy="46" r="72" fill="#ffffff" opacity=".05"/>
  <ellipse cx="200" cy="188" rx="168" ry="14" fill="#000" opacity=".38"/>
  <path d="${shape.body}" fill="url(#body-${uid})"/>
  <path d="${shape.glass}" fill="#0d1218" opacity=".72"/>
  <path d="${shape.body}" fill="none" stroke="#ffffff" stroke-opacity=".18" stroke-width="2"/>
  ${wheels}
  <rect x="0" y="196" width="400" height="24" fill="#0b0d10"/>
</svg>`;
}

/* --------------------------- Véhicules --------------------------- */
const VEHICLES = [
  {
    id: 1, marque: "Peugeot", modele: "3008", version: "1.5 BlueHDi 130 Allure Pack EAT8",
    annee: 2021, km: 62400, prix: 22900, carburant: "Diesel", boite: "Automatique",
    type: "SUV", places: 5, tag: "Coup de cœur", garantie: "12 mois",
    couleurs: ["#3c4652", "#1b2027"],
    description: "SUV familial très bien équipé, entretien exclusivement en réseau, deuxième main. Contrôle technique vierge et inspection 120 points réalisée par nos soins.",
    options: ["i-Cockpit numérique", "Caméra de recul", "Régulateur adaptatif", "Sièges chauffants"]
  },
  {
    id: 2, marque: "Renault", modele: "Clio V", version: "TCe 100 Intens",
    annee: 2020, km: 48900, prix: 12490, carburant: "Essence", boite: "Manuelle",
    type: "Citadine", places: 5, tag: "Petit budget", garantie: "12 mois",
    couleurs: ["#c9ccd2", "#8d939c"],
    description: "Citadine idéale pour la ville, faible kilométrage et carnet d'entretien complet. Parfaite première voiture.",
    options: ["Écran tactile 7\"", "Apple CarPlay", "Clim automatique", "Radar de recul"]
  },
  {
    id: 3, marque: "Volkswagen", modele: "Golf VIII", version: "2.0 TDI 150 Life DSG",
    annee: 2022, km: 39500, prix: 24800, carburant: "Diesel", boite: "Automatique",
    type: "Berline", places: 5, tag: "Faible kilométrage", garantie: "24 mois",
    couleurs: ["#1f2a3a", "#0f1622"],
    description: "Compacte polyvalente, sortie de garantie constructeur, aucun frais à prévoir. Idéale gros rouleurs.",
    options: ["GPS Discover", "Feux LED Matrix", "Aide au stationnement", "Régulateur adaptatif"]
  },
  {
    id: 4, marque: "Toyota", modele: "Yaris", version: "116h Hybride Design",
    annee: 2023, km: 21300, prix: 19900, carburant: "Hybride", boite: "Automatique",
    type: "Citadine", places: 5, tag: "Hybride", garantie: "Garantie constructeur",
    couleurs: ["#d8dade", "#a2a8b1"],
    description: "Hybride autorechargeable, 4,2 l/100 km en usage urbain, reste de garantie constructeur jusqu'en 2026.",
    options: ["Toyota Safety Sense", "Caméra de recul", "Sièges chauffants", "Jantes 17\""]
  },
  {
    id: 5, marque: "BMW", modele: "Série 3", version: "320d 190 xDrive Business",
    annee: 2019, km: 96700, prix: 24500, carburant: "Diesel", boite: "Automatique",
    type: "Berline", places: 5, tag: "Premium", garantie: "12 mois",
    couleurs: ["#2b3038", "#14181d"],
    description: "Berline premium 4 roues motrices, historique d'entretien complet en concession, pneus neufs.",
    options: ["Cuir Dakota", "Navigation Pro", "Hayon électrique", "Affichage tête haute"]
  },
  {
    id: 6, marque: "Dacia", modele: "Sandero", version: "TCe 90 Stepway Expression",
    annee: 2022, km: 31200, prix: 14300, carburant: "Essence", boite: "Manuelle",
    type: "Citadine", places: 5, tag: "Petit budget", garantie: "12 mois",
    couleurs: ["#3b6d5a", "#1e3a30"],
    description: "Le meilleur rapport équipement/prix du marché, garantie constructeur restante et faible coût d'usage.",
    options: ["Écran Media Display", "Clim automatique", "Barres de toit", "Radar de recul"]
  },
  {
    id: 7, marque: "Audi", modele: "A4 Avant", version: "35 TDI 163 S line S tronic",
    annee: 2021, km: 71800, prix: 29900, carburant: "Diesel", boite: "Automatique",
    type: "Break", places: 5, tag: "Premium", garantie: "12 mois",
    couleurs: ["#8b1f28", "#4d0f16"],
    description: "Break familial haut de gamme, finition S line, révision complète effectuée avant mise en vente.",
    options: ["Virtual Cockpit", "Hayon mains libres", "Sièges sport", "Phares LED"]
  },
  {
    id: 8, marque: "Tesla", modele: "Model 3", version: "Grande Autonomie AWD",
    annee: 2022, km: 44100, prix: 31900, carburant: "Électrique", boite: "Automatique",
    type: "Berline", places: 5, tag: "100 % électrique", garantie: "Garantie batterie",
    couleurs: ["#e8eaee", "#b0b6be"],
    description: "Autonomie réelle mesurée à 480 km, batterie contrôlée (santé 94 %), Superchargeurs inclus.",
    options: ["Autopilot", "Toit panoramique", "Intérieur premium", "Attelage"]
  },
  {
    id: 9, marque: "Citroën", modele: "C4 SpaceTourer", version: "BlueHDi 130 Shine EAT8",
    annee: 2019, km: 108500, prix: 15900, carburant: "Diesel", boite: "Automatique",
    type: "Monospace", places: 7, tag: "7 places", garantie: "12 mois",
    couleurs: ["#4a5568", "#242c39"],
    description: "Monospace 7 places très confortable, idéal familles nombreuses, distribution récemment remplacée.",
    options: ["Toit panoramique", "3 sièges indépendants", "Caméra 360°", "Attelage"]
  },
  {
    id: 10, marque: "Ford", modele: "Transit Custom", version: "2.0 TDCi 130 L1H1 Trend",
    annee: 2020, km: 89400, prix: 18900, carburant: "Diesel", boite: "Manuelle",
    type: "Utilitaire", places: 3, tag: "Pro · TVA récupérable", garantie: "12 mois",
    couleurs: ["#dfe2e6", "#a8aeb6"],
    description: "Utilitaire d'entreprise entretenu en concession, TVA récupérable, prêt à travailler.",
    options: ["Cloison de séparation", "Bluetooth", "Radar de recul", "Attelage"]
  },
  {
    id: 11, marque: "Mercedes-Benz", modele: "Classe A", version: "180 d 116 AMG Line 7G-DCT",
    annee: 2020, km: 67300, prix: 25400, carburant: "Diesel", boite: "Automatique",
    type: "Berline", places: 5, tag: "Premium", garantie: "12 mois",
    couleurs: ["#0f1318", "#05070a"],
    description: "Compacte premium finition AMG Line, système MBUX, première main avec historique complet.",
    options: ["MBUX écrans jumelés", "Sièges AMG", "Caméra de recul", "Éclairage d'ambiance"]
  },
  {
    id: 12, marque: "Renault", modele: "Captur", version: "E-Tech 145 Techno",
    annee: 2023, km: 18700, prix: 23200, carburant: "Hybride", boite: "Automatique",
    type: "SUV", places: 5, tag: "Faible kilométrage", garantie: "Garantie constructeur",
    couleurs: ["#e5762a", "#a34a14"],
    description: "SUV urbain hybride quasi neuf, consommation moyenne 4,8 l/100 km, garantie constructeur jusqu'en 2027.",
    options: ["Écran vertical 9,3\"", "Caméra de recul", "Régulateur adaptatif", "Sellerie mixte"]
  }
];

/* ------------------------- Témoignages ------------------------- */
const TESTIMONIALS = [
  {
    nom: "Sophie L.", ville: "Paris 15e", note: 5, service: "Vente accompagnée",
    texte: "J'ai vendu ma Golf en 11 jours à 1 900 € de plus que la reprise proposée par mon concessionnaire. Tout a été géré : photos, annonce, visites, papiers. Je n'ai eu qu'à signer."
  },
  {
    nom: "Marc D.", ville: "Boulogne-Billancourt", note: 5, service: "Achat pour compte de tiers",
    texte: "Je cherchais un SUV hybride depuis trois mois sans succès. Ils ont trouvé le bon modèle en deux semaines, l'ont inspecté et négocié. Le rapport d'expertise était d'une précision impressionnante."
  },
  {
    nom: "Nadia B.", ville: "Créteil", note: 5, service: "Estimation gratuite",
    texte: "Estimation reçue le lendemain matin, argumentée et réaliste — très loin des estimateurs en ligne. Aucune pression commerciale derrière, ce qui change tout."
  },
  {
    nom: "Julien P.", ville: "Versailles", note: 4, service: "Expertise avant achat",
    texte: "L'expertise m'a évité d'acheter une voiture au kilométrage trafiqué. 150 € qui m'en ont fait économiser plusieurs milliers. Réactivité et honnêteté au rendez-vous."
  },
  {
    nom: "Karine M.", ville: "Neuilly-sur-Seine", note: 5, service: "Vente accompagnée",
    texte: "Un interlocuteur unique, disponible, qui explique chaque étape sans jargon. La transaction et le paiement ont été totalement sécurisés. Je recommande sans réserve."
  },
  {
    nom: "Éric T.", ville: "Saint-Denis · Pro", note: 5, service: "Gestion de flotte",
    texte: "Nous leur confions le renouvellement de nos utilitaires depuis trois ans. Délais tenus, prix négociés, factures claires. Un vrai gain de temps pour notre société."
  }
];
