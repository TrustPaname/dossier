# Motor Consulting — site vitrine

Site vitrine **statique** (HTML / CSS / JavaScript, sans dépendance ni build) pour une société
de conseil automobile spécialisée dans l'achat, la vente et l'expertise de véhicules d'occasion.

> **Identité** : mise en page « concession » claire inspirée des sites de distributeurs
> professionnels — en-tête blanc avec menu centré, accueil plein écran sur photo sombre
> avec moteur de recherche, titres gras avec une ligne d'accent en italique, boutons et
> pastilles arrondis, cartes blanches à coins arrondis. Les couleurs restent celles du logo
> Motor Consulting : **bleu électrique** sur blanc, noir profond pour l'accueil et le pied
> de page. Les quatre piliers Recherche / Négociation / Achat-Vente / Location structurent
> la page. Une bulle de discussion WhatsApp est fixée en bas à droite.

## Aperçu local

```bash
python3 -m http.server 8000
# puis ouvrir http://localhost:8000
```

Aucun build, aucun `npm install` : le site peut être déposé tel quel sur n'importe quel
hébergement statique (OVH, Netlify, Vercel, GitHub Pages, o2switch…).

## Structure

```
index.html              Site Motor Consulting — page unique (toutes les sections)
motor-corp/index.html   Page d'entrée de la holding Motor Corp (écran coupé en deux)
assets/css/styles.css   Styles — mobile-first, thème noir/gris + accent rouge
assets/js/data.js       Données : véhicules, témoignages, silhouettes SVG
assets/js/main.js       Interactions : menu, filtres, modale, carrousel, formulaires
assets/fonts/           Polices auto-hébergées (Outfit + Inter ; Michroma + Archivo pour Motor Corp)
assets/img/             Favicon et image de partage (SVG)
robots.txt / sitemap.xml / site.webmanifest
```

## Sections

1. **Accueil** — accroche, phrase de présentation, bouton « Vendre ma voiture », lien vers les
   véhicules, et les chiffres clés sur une ligne discrète.
2. **Nos services** — recherche de véhicule, négociation, achat/vente, location (courte et
   longue durée, LOA/LLD). L'expertise et les démarches sont mentionnées en introduction.
3. **Véhicules disponibles** — grille de fiches avec recherche plein texte, filtres (type,
   budget, année), tri, pagination « voir plus » et fiche détaillée en modale.
4. **Comment ça marche** — 4 étapes (contact → expertise → proposition → transaction sécurisée).
5. **Estimation gratuite** — formulaire complet avec validation et confirmation.
6. **Témoignages** — une citation à la fois, notes en étoiles, navigation clavier et swipe.
7. **À propos** — histoire, valeurs, équipe.
8. **Contact** — coordonnées, carte, WhatsApp et formulaire.

Fonctionnalités transverses : barre fixe Appeler / WhatsApp / Estimation sur mobile,
navigation active au défilement, respect de `prefers-reduced-motion`, focus visible et
libellés accessibles.

## Personnalisation

### 1. Coordonnées et identité

Un simple rechercher-remplacer dans `index.html` (et `assets/js/main.js` pour le numéro
WhatsApp) suffit :

| À remplacer | Où | Valeur de démonstration |
|---|---|---|
| Nom de l'entreprise | `index.html` (titre, header, footer, JSON-LD) | Motor Consulting |
| Téléphone affiché | `index.html` | `06 12 34 56 78` |
| Téléphone / WhatsApp technique | `index.html` (`tel:`, `wa.me/`) et `CONFIG.whatsapp` dans `main.js` | `33612345678` |
| E-mail | `index.html` et `CONFIG.email` dans `main.js` | `contact@motor-consulting.fr` |
| Adresse + coordonnées GPS | `index.html` (bloc contact, iframe carte, JSON-LD) | 24 avenue de la Grande-Armée, 75017 Paris |
| Domaine | balises `canonical`, `og:url`, `robots.txt`, `sitemap.xml` | `www.motor-consulting.fr` |
| Chiffres clés | liste `.facts` sous l'accroche de la page d'accueil | 1 850 / 12 ans / 4,9 |

### 2. Branchement des formulaires

Les deux formulaires (estimation, contact) partagent la même mécanique. Par défaut, `CONFIG.formEndpoint` est vide : le site est en **mode démonstration**
— la demande est validée, une référence est générée, un message de confirmation s'affiche et
la demande est conservée dans le `localStorage` du visiteur (clé `mc_demandes`).

Pour recevoir réellement les demandes, renseignez une URL en haut de `assets/js/main.js` :

```js
const CONFIG = {
  formEndpoint: "https://formspree.io/f/VOTRE_ID", // ou Getform, Brevo, votre API…
  whatsapp: "33612345678",
  email: "contact@motor-consulting.fr"
};
```

Les données sont envoyées en `POST` JSON avec les champs du formulaire plus `reference`,
`date` et `page`. En cas d'échec réseau, un message d'erreur propose le téléphone et l'e-mail
en secours.

### 3. Véhicules et témoignages

Tout se passe dans `assets/js/data.js` : ajoutez ou modifiez les objets des tableaux
`VEHICLES` et `TESTIMONIALS`, la grille, les filtres et le carrousel se mettent à jour seuls.

Les visuels des véhicules sont des **silhouettes SVG générées à la volée** (aucune image à
charger, chargement instantané). Le style est choisi via le champ `type`
(Citadine, Berline, SUV, Break, Monospace, Utilitaire) et les deux teintes du champ `couleurs`.
Pour utiliser de vraies photos, remplacez l'appel à `carSvg(v, …)` par une balise
`<img src="…" alt="…" loading="lazy" width="800" height="500">` dans `vehicleCard()`
(`assets/js/main.js`) et dans la modale.

### 4. Charte graphique

Toute l'identité tient dans les variables du bloc `:root` de `assets/css/styles.css` :

| Rôle | Variable | Valeur |
|---|---|---|
| Fond principal / secondaire | `--bg` / `--bg-2` | `#ffffff` / `#f5f6f8` |
| Texte | `--ink` / `--ink-2` / `--ink-3` | `#0f172a` / `#4b5563` / `#8b93a1` |
| Filets | `--line` | `#e5e8ee` |
| Noir (accueil, pied de page, visuels) | `--dark` | `#0f1115` |
| Bleu principal | `--bleu` | `#0a8cff` |
| Bleu foncé (survols) | `--bleu-fonce` | `#0066cc` |
| Bleu clair (ligne d'accent de l'accueil) | `--bleu-clair` | `#5fc3ff` |
| Bleu pâle (fonds d'icônes, pastilles) | `--bleu-soft` | `#e8f3ff` |
| Rayons | `--radius` / `--pill` | `16px` / `999px` |
| Photo d'accueil | `--hero-photo` | `none` (voir ci-dessous) |

Le bleu sert aux boutons pleins, aux sur-titres, aux liens et à la **ligne d'accent en
italique** de chaque titre (`<span class="accent">`). Le logo officiel existe en deux
versions : `logo-motor-consulting*.png` (mot CONSULTING clair, pour les fonds sombres :
pied de page, bulle WhatsApp) et `logo-motor-consulting-light*.png` (mot CONSULTING
foncé, pour l'en-tête blanc). Deux SVG encodés en `data:` reprennent la couleur `%230a8cff`
— les étoiles des avis et la flèche des menus déroulants : pensez à les modifier si vous
changez le bleu.

**Photo d'accueil** : par défaut, l'accueil affiche un fond sombre généré en CSS. Pour y
mettre une photo (showroom, véhicule), déposez-la dans `assets/img/hero.jpg` et remplacez
`--hero-photo:none` par `--hero-photo:url(../img/hero.jpg)` dans `styles.css`. Un voile
sombre est appliqué automatiquement pour garder le texte lisible.

**Moteur de recherche de l'accueil** : le bloc « Trouvez votre véhicule » (recherche
libre, budget, carburant, transmission, carrosserie, recherches populaires) alimente les
filtres de la section Véhicules et y fait défiler la page.

**Bulle WhatsApp** : le bouton rond en bas à droite ouvre un petit panneau de discussion
(logo, message d'accueil, champ de saisie). L'envoi ouvre WhatsApp avec le message
pré-rempli vers le numéro `whatsapp` de `window.MC_CONFIG` (ou celui de `main.js`).

**Typographie** : `Outfit` (gras, 700–800) pour les titres, les prix et les chiffres,
`Inter` (400–600) pour le texte courant, les menus et les formulaires. Les polices sont
**auto-hébergées** dans `assets/fonts/` (formats woff2, `font-display:swap`) : aucun appel
à Google Fonts, ce qui évite le transfert d'adresses IP vers un service tiers — un point
régulièrement sanctionné en France sur le terrain du RGPD.

## Page Motor Corp (holding)

`motor-corp/index.html` est le site de la holding, autonome (CSS et JS intégrés, polices
partagées avec le site Motor Consulting). Identité noir / chrome / **rouge** ; l'or ne sert
qu'aux logos des deux marques.

Sections : accueil animé (monogramme « MC », lettrage chrome, devise), bandeau défilant,
présentation du groupe et ses trois piliers, les deux marques (Motors Studio — carrosserie,
Motor Consulting — conseil) avec lien vers leur site, parcours « synergies » en quatre étapes,
contact.

Mouvement : fond en lignes de vitesse dessiné sur `<canvas>` (170 particules, mis en pause
quand l'onglet est masqué), grille en perspective animée, reflet qui balaie le monogramme et le
lettrage, bandeau défilant, apparitions au défilement, parallaxe à la souris sur l'accueil,
inclinaison 3D et halo sur les cartes des marques. Tout est désactivé si l'utilisateur a
demandé la réduction des animations (`prefers-reduced-motion`).

À mettre à jour dans `motor-corp/index.html` : l'adresse du site Motors Studio
(`https://www.motor-studio.fr/`), le lien vers Motor Consulting (`../index.html`, à remplacer
par son domaine), l'e-mail, le téléphone et l'adresse.

## SEO

- Titre, méta-description, Open Graph, `canonical`, `sitemap.xml` et `robots.txt` renseignés.
- Données structurées **JSON-LD** `AutoDealer` (adresse, horaires, zone desservie, note).
- Mots-clés intégrés naturellement dans les contenus : achat vente voiture occasion, rachat de
  voiture, expertise automobile, vendre sa voiture rapidement, estimation gratuite véhicule Paris.
- Un seul `<h1>`, hiérarchie `h2`/`h3` cohérente, liens internes descriptifs, `lang="fr"`.

## Performance et compatibilité

- Zéro dépendance externe, images limitées aux logos, polices auto-hébergées : le rendu ne dépend
  d'aucun CDN.
- Seule ressource tierce : l'iframe OpenStreetMap de la section contact, chargée en `lazy`
  (un texte de repli s'affiche si elle est bloquée). Supprimez le bloc `.map` pour un site
  totalement autonome.
- Mobile-first, points de rupture à 600 px et 900 px, testé de 320 px à 1440 px.
- JavaScript défensif : si le script ne s'exécute pas, le contenu reste entièrement lisible.

## Avant la mise en ligne

- [ ] Remplacer les coordonnées et le nom de l'entreprise (tableau ci-dessus).
- [ ] Renseigner `CONFIG.formEndpoint` et tester la réception d'une demande.
- [ ] Remplacer les véhicules et témoignages de démonstration par les vôtres.
- [ ] Rédiger les pages Mentions légales / Politique de confidentialité / CGV (liens du footer).
- [ ] Vérifier les chiffres clés et la note clients annoncés (ils doivent être exacts).
- [ ] Remplacer le monogramme SVG du header/footer par votre logo définitif si vous en avez
      une version vectorielle (chercher `brand__mark` dans `index.html`).
- [ ] Mettre à jour le domaine dans `canonical`, `og:url`, `robots.txt` et `sitemap.xml`.
