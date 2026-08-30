/* ==========================================================================
   MOTOR CONSULTING — Catalogue des vehicules
   --------------------------------------------------------------------------
   Pour ajouter / modifier / supprimer un véhicule, éditez simplement ce
   fichier : la page « Véhicules disponibles » se met à jour automatiquement.

   Champs :
     marque, modele, version : texte libre
     annee   : nombre (année de mise en circulation)
     km      : nombre (kilométrage)
     prix    : nombre (prix de vente TTC en euros)
     type    : citadine | berline | suv | break | monospace | utilitaire
     energie : Essence | Diesel | Hybride | Électrique | GPL
     boite   : Manuelle | Automatique
     statut  : disponible | reserve | nouveaute
     atouts  : liste de 2 à 3 arguments courts
     image   : chemin d'une photo (laisser vide pour l'illustration par défaut)
   ========================================================================== */

window.VEHICULES = [
  {
    marque: "Peugeot", modele: "208", version: "1.2 PureTech 100 Allure",
    annee: 2021, km: 42500, prix: 14900, type: "citadine",
    energie: "Essence", boite: "Manuelle", statut: "disponible",
    atouts: ["Carnet d'entretien complet", "1re main", "Garantie 12 mois"],
    image: ""
  },
  {
    marque: "Renault", modele: "Clio V", version: "TCe 100 Intens",
    annee: 2020, km: 58900, prix: 13490, type: "citadine",
    energie: "Essence", boite: "Manuelle", statut: "disponible",
    atouts: ["Distribution faite", "Non fumeur", "Caméra de recul"],
    image: ""
  },
  {
    marque: "Volkswagen", modele: "Golf VII", version: "1.6 TDI 115 Confortline",
    annee: 2019, km: 96400, prix: 15900, type: "berline",
    energie: "Diesel", boite: "Manuelle", statut: "disponible",
    atouts: ["Entretien réseau", "Révision neuve", "Garantie 12 mois"],
    image: ""
  },
  {
    marque: "Toyota", modele: "Yaris", version: "116h Hybride Design",
    annee: 2022, km: 28300, prix: 18900, type: "citadine",
    energie: "Hybride", boite: "Automatique", statut: "nouveaute",
    atouts: ["Garantie constructeur", "Faible consommation", "1re main"],
    image: ""
  },
  {
    marque: "Dacia", modele: "Duster", version: "Blue dCi 115 Prestige",
    annee: 2020, km: 74200, prix: 16490, type: "suv",
    energie: "Diesel", boite: "Manuelle", statut: "disponible",
    atouts: ["4 pneus neufs", "Attelage", "Historique complet"],
    image: ""
  },
  {
    marque: "Peugeot", modele: "3008", version: "BlueHDi 130 EAT8 Allure Pack",
    annee: 2021, km: 61800, prix: 25900, type: "suv",
    energie: "Diesel", boite: "Automatique", statut: "disponible",
    atouts: ["Boîte automatique", "GPS + caméra", "Garantie 12 mois"],
    image: ""
  },
  {
    marque: "Citroën", modele: "C4 Picasso", version: "BlueHDi 120 Shine",
    annee: 2018, km: 118500, prix: 12490, type: "monospace",
    energie: "Diesel", boite: "Automatique", statut: "disponible",
    atouts: ["7 places", "Toit panoramique", "Révision faite"],
    image: ""
  },
  {
    marque: "Skoda", modele: "Octavia Combi", version: "2.0 TDI 150 Business",
    annee: 2020, km: 102300, prix: 17900, type: "break",
    energie: "Diesel", boite: "Automatique", statut: "disponible",
    atouts: ["Grand coffre", "Véhicule de société suivi", "Cuir"],
    image: ""
  },
  {
    marque: "BMW", modele: "Série 3", version: "320d 190 Business Design",
    annee: 2019, km: 88700, prix: 24500, type: "berline",
    energie: "Diesel", boite: "Automatique", statut: "reserve",
    atouts: ["Full options", "Entretien BMW", "Sièges chauffants"],
    image: ""
  },
  {
    marque: "Renault", modele: "Mégane IV Estate", version: "Blue dCi 115 Business",
    annee: 2021, km: 79600, prix: 15490, type: "break",
    energie: "Diesel", boite: "Manuelle", statut: "disponible",
    atouts: ["Faible cote à l'argus", "GPS", "Garantie 12 mois"],
    image: ""
  },
  {
    marque: "Tesla", modele: "Model 3", version: "Standard Plus Autonomie",
    annee: 2021, km: 54200, prix: 26900, type: "berline",
    energie: "Électrique", boite: "Automatique", statut: "nouveaute",
    atouts: ["Batterie garantie", "Autopilot", "Recharge rapide"],
    image: ""
  },
  {
    marque: "Ford", modele: "Puma", version: "1.0 EcoBoost 125 Titanium",
    annee: 2022, km: 33900, prix: 19900, type: "suv",
    energie: "Essence", boite: "Manuelle", statut: "disponible",
    atouts: ["Micro-hybride", "1re main", "Sous garantie"],
    image: ""
  },
  {
    marque: "Renault", modele: "Trafic", version: "L1H1 dCi 120 Confort",
    annee: 2019, km: 132400, prix: 15900, type: "utilitaire",
    energie: "Diesel", boite: "Manuelle", statut: "disponible",
    atouts: ["TVA récupérable", "3 places", "Entretien suivi"],
    image: ""
  },
  {
    marque: "Audi", modele: "A1 Sportback", version: "30 TFSI 110 S line",
    annee: 2020, km: 47800, prix: 21500, type: "citadine",
    energie: "Essence", boite: "Automatique", statut: "disponible",
    atouts: ["Finition S line", "Virtual cockpit", "Garantie 12 mois"],
    image: ""
  },
  {
    marque: "Volkswagen", modele: "Tiguan", version: "2.0 TDI 150 DSG Life",
    annee: 2021, km: 68900, prix: 28900, type: "suv",
    energie: "Diesel", boite: "Automatique", statut: "disponible",
    atouts: ["Boîte DSG", "Hayon électrique", "Historique complet"],
    image: ""
  },
  {
    marque: "Opel", modele: "Corsa", version: "1.2 75 Edition",
    annee: 2019, km: 65400, prix: 10900, type: "citadine",
    energie: "Essence", boite: "Manuelle", statut: "disponible",
    atouts: ["Petit budget", "Faible consommation", "CT vierge"],
    image: ""
  }
];
