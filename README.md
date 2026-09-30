# Motor Consulting — site vitrine

Site vitrine **statique** (HTML / CSS / JavaScript, sans dépendance ni build) pour une société
de conseil automobile spécialisée dans l'achat, la vente et l'expertise de véhicules d'occasion.

> **Identité** : le design reprend la charte de la carte de visite Motor Consulting —
> noir profond, or, lettrage chrome, nid d'abeille et faisceaux dorés — dans une version
> **premium et animée** : lignes de vitesse sur l'accueil, reflet chromé sur le logotype,
> bandeau défilant, cartes en verre avec halo doré et inclinaison au survol, compteurs et
> apparitions au défilement. Les quatre piliers Recherche / Négociation / Achat-Vente /
> Location structurent la page.
>
> **Coordonnées** : zone **Paris / Île-de-France** et coordonnées de démonstration
> (téléphone, e-mail, adresse, domaine). Remplacez-les avant mise en ligne — voir
> « Personnalisation » ci-dessous.

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
assets/fonts/           Polices auto-hébergées (Michroma + Archivo, woff2)
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
| Noir de fond | `--noir` | `#08080a` |
| Noir secondaire (visuels, carte) | `--noir-2` | `#111114` |
| Filets | `--line` / `--or-line` | blanc 9 % / or 28 % |
| Or principal | `--or` | `#d4af37` |
| Or clair (survol du bouton) | `--or-clair` | `#eddca0` |
| Chrome (logotype) | `--chrome-1/2/3` | `#ffffff` → `#c6ccd4` → `#767c85` |
| Texte courant | `--texte` / `--texte-2` | `#f2f1ec` / `#a5a8ad` |

L'or est utilisé en aplat (`--or`) : un seul bouton plein par écran, des filets d'un pixel,
les libellés en Michroma et les prix. Le dégradé chrome (`--grad-chrome`) ne sert qu'au
mot « MOTOR ». Deux SVG encodés en `data:` reprennent la couleur `%23d4af37` — les étoiles
des avis et la flèche des menus déroulants : pensez à les modifier si vous changez l'or.

Grammaire du design : cartes `.card` (verre, halo doré suivant le curseur, filet or en bas au
survol, coins dorés optionnels `.card__corner`), boutons à balayage doré, libellés Michroma
précédés d'un trait, sections alternées `.section--alt` avec nid d'abeille discret. Tout
le mouvement respecte `prefers-reduced-motion`.

Le site assume un **thème sombre unique** (comme la carte de visite) : il n'y a pas de
variante claire à maintenir.

**Typographie** : `Michroma` pour le lettrage large (logo, sur-titres, libellés), `Exo 2`
(gras, capitales) pour les titres, les chiffres et le texte courant. Michroma ne possède pas
le signe « € » : prix et chiffres restent en Exo 2. Les deux polices sont **auto-hébergées** dans
`assets/fonts/` (~98 Ko, formats woff2, `font-display:swap`) : aucun appel à Google Fonts,
ce qui évite le transfert d'adresses IP vers un service tiers — un point régulièrement
sanctionné en France sur le terrain du RGPD.

## Page Motor Corp (holding)

`motor-corp/index.html` est le site de la holding, autonome (CSS et JS intégrés, polices
partagées avec le site Motor Consulting). Identité noir / chrome / **rouge** ; l'or ne sert
qu'aux logos des deux marques.

Sections : accueil animé (monogramme « MC », lettrage chrome, devise), bandeau défilant,
présentation du groupe et ses trois piliers, les deux marques (Motor Studio — carrosserie,
Motor Consulting — conseil) avec lien vers leur site, parcours « synergies » en quatre étapes,
contact.

Mouvement : fond en lignes de vitesse dessiné sur `<canvas>` (170 particules, mis en pause
quand l'onglet est masqué), grille en perspective animée, reflet qui balaie le monogramme et le
lettrage, bandeau défilant, apparitions au défilement, parallaxe à la souris sur l'accueil,
inclinaison 3D et halo sur les cartes des marques. Tout est désactivé si l'utilisateur a
demandé la réduction des animations (`prefers-reduced-motion`).

À mettre à jour dans `motor-corp/index.html` : l'adresse du site Motor Studio
(`https://www.motor-studio.fr/`), le lien vers Motor Consulting (`../index.html`, à remplacer
par son domaine), l'e-mail, le téléphone et l'adresse.

## SEO

- Titre, méta-description, Open Graph, `canonical`, `sitemap.xml` et `robots.txt` renseignés.
- Données structurées **JSON-LD** `AutoDealer` (adresse, horaires, zone desservie, note).
- Mots-clés intégrés naturellement dans les contenus : achat vente voiture occasion, rachat de
  voiture, expertise automobile, vendre sa voiture rapidement, estimation gratuite véhicule Paris.
- Un seul `<h1>`, hiérarchie `h2`/`h3` cohérente, liens internes descriptifs, `lang="fr"`.

## Performance et compatibilité

- Zéro dépendance externe, zéro image bitmap, polices auto-hébergées : le rendu ne dépend
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
