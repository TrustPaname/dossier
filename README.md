# MOTOR CONSULTING — site vitrine

Site web professionnel pour **MOTOR CONSULTING**, cabinet de conseil automobile
spécialisé dans l'achat, la vente et l'expertise de véhicules d'occasion à
Mainvilliers, Chartres et en Eure-et-Loir (28).

Site **statique** : HTML, CSS et JavaScript natifs, sans framework, sans étape de
build et sans dépendance externe. Il suffit de déposer les fichiers sur un
hébergement pour qu'il fonctionne.

---

## ⚠️ À compléter avant la mise en ligne

Certaines informations sont des **valeurs de démonstration** : elles doivent être
remplacées par les données réelles de la société.

| Élément | Valeur actuelle (fictive) | Où la modifier |
|---|---|---|
| Téléphone | `02 61 91 12 34` | `assets/js/config.js` **et** les pages HTML (`tel:+33261911234`) |
| WhatsApp | `33799123456` | `assets/js/config.js` |
| E-mail | `contact@motor-consulting.fr` | `assets/js/config.js`, `contact.html`, `mentions-legales.html` |
| Nom de domaine | `www.motor-consulting.fr` | balises `canonical` / `og:url` des pages, `sitemap.xml`, `robots.txt` |
| Chiffres clés | 1 250 véhicules, 14 ans, 4,9/5, 21 j | `index.html` (section « Chiffres clés »), `a-propos.html` |
| Témoignages | 3 avis d'exemple | `index.html` (section « Témoignages ») |
| Équipe | Julien M., Karim B., Camille L. | `a-propos.html` |
| Mentions légales | SIRET, RCS, TVA, hébergeur, assurance | `mentions-legales.html` (entre crochets `[…]`) |
| Tarifs affichés | 490 €, 190 € | `services.html` |
| Photos de véhicules | illustrations SVG génériques | voir « Ajouter des photos » ci-dessous |

> Le numéro de téléphone utilisé appartient à une plage réservée à la fiction
> (ARCEP) : il ne correspond à aucune ligne réelle, mais il **doit** être remplacé.

Vérifiez aussi l'orthographe de la commune : la commune du code postal 28300 est
officiellement **Mainvilliers**.

---

## Structure

```
.
├── index.html              Accueil (accroche, chiffres clés, services, méthode,
│                           sélection de véhicules, témoignages, FAQ)
├── services.html           Les 4 prestations en détail
├── vehicules.html          Catalogue avec recherche, filtres et tri
├── estimation.html         Formulaire d'estimation gratuite
├── a-propos.html           Histoire, valeurs, équipe, engagements
├── contact.html            Formulaire, coordonnées, horaires, carte
├── mentions-legales.html   Mentions légales et RGPD (modèle à compléter)
├── 404.html                Page d'erreur
├── robots.txt / sitemap.xml
└── assets/
    ├── css/styles.css          Feuille de style unique
    ├── js/config.js            ← coordonnées et envoi des formulaires
    ├── js/vehicules-data.js    ← catalogue des véhicules
    ├── js/vehicules.js         Affichage, recherche, filtres, tri
    ├── js/formulaires.js       Validation et envoi des formulaires
    ├── js/site.js              Menu mobile, WhatsApp, animations
    └── img/                    Logo, favicon, illustrations (SVG)
```

---

## Personnalisation courante

### 1. Coordonnées de l'entreprise

Tout est centralisé dans **`assets/js/config.js`** : téléphone, WhatsApp, e-mail,
adresse, délai de réponse annoncé. Le lien WhatsApp (bouton fixe mobile, page
contact, footer) est construit automatiquement à partir de ce fichier.

### 2. Ajouter ou modifier un véhicule

Éditez **`assets/js/vehicules-data.js`**. Chaque véhicule est un bloc :

```js
{
  marque: "Peugeot", modele: "208", version: "1.2 PureTech 100 Allure",
  annee: 2021, km: 42500, prix: 14900, type: "citadine",
  energie: "Essence", boite: "Manuelle", statut: "disponible",
  atouts: ["Carnet d'entretien complet", "1re main", "Garantie 12 mois"],
  image: ""
}
```

- `type` : `citadine`, `berline`, `suv`, `break`, `monospace` ou `utilitaire`
- `statut` : `disponible`, `reserve` ou `nouveaute` (change l'étiquette de la fiche)
- `image` : laisser vide pour l'illustration automatique selon le type

La page catalogue et la sélection affichée sur l'accueil se mettent à jour seules.

### 3. Ajouter des photos réelles

Déposez les photos dans `assets/img/` (format paysage, idéalement 1200 × 750 px,
JPEG compressé) puis renseignez le champ `image` :

```js
image: "assets/img/peugeot-208-2021.jpg"
```

### 4. Recevoir réellement les demandes

Par défaut, les formulaires sont en **mode démonstration** : ils se valident et
affichent un message de confirmation, mais **aucune donnée n'est transmise**.

Pour recevoir les demandes, renseignez une URL de réception dans
`assets/js/config.js` :

```js
endpointFormulaire: "https://formspree.io/f/xxxxxxxx",
```

Les données sont envoyées en `POST`, au format JSON, avec les champs du
formulaire plus `formulaire` (type de demande), `page` et `date`. Tout service
acceptant ce format convient : Formspree, Basin, Netlify Forms, ou un script
PHP/API hébergé avec le site.

---

## Fonctionnalités

- **Formulaires validés en français** — message d'erreur sous chaque champ,
  résumé en haut du formulaire, revalidation en direct après la première
  tentative, message de confirmation, piège anti-robots invisible.
- **Catalogue filtrable** — recherche texte (insensible aux accents), filtres
  type / budget / année / énergie, tri, compteur de résultats, état vide avec
  appel à l'action. Les filtres acceptent des paramètres d'URL :
  `vehicules.html?type=suv&prixMax=20000`.
- **Contact rapide mobile** — barre fixe Appeler / WhatsApp en bas d'écran.
- **Fiche vers contact** — le bouton d'une fiche véhicule pré-remplit le message
  du formulaire de contact.
- **Accessibilité** — navigation au clavier, lien d'évitement, libellés associés,
  `aria-live` sur les résultats, contrastes conformes, respect de
  `prefers-reduced-motion`.
- **Performance** — aucune police ni bibliothèque externe, illustrations SVG,
  images en `loading="lazy"`, une seule feuille de style.

## Référencement

- Titres et méta-descriptions uniques par page, `canonical`, Open Graph.
- Données structurées JSON-LD : `AutoDealer` (accueil, contact) et `FAQPage`.
- `sitemap.xml` et `robots.txt` fournis (à mettre à jour avec le domaine réel).
- Mots-clés travaillés naturellement dans les contenus : achat vente voiture
  occasion, rachat de voiture, expertise automobile, vendre sa voiture
  rapidement, estimation gratuite véhicule Chartres / Mainvilliers.

## Mise en ligne

Le site est statique : déposez le contenu du dépôt à la racine de l'hébergement
(OVH, o2switch, Netlify, Vercel, GitHub Pages…). Aucune base de données ni
langage serveur n'est nécessaire.

Prévisualisation locale :

```bash
python3 -m http.server 8000
# puis http://localhost:8000
```

## Navigateurs pris en charge

Chrome, Edge, Firefox et Safari récents, sur mobile comme sur ordinateur.
Sans JavaScript, les pages et les coordonnées restent lisibles ; seuls le
catalogue et l'envoi des formulaires nécessitent JavaScript activé.
