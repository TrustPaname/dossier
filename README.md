# Motor Consulting — site vitrine

Site vitrine **statique** (HTML / CSS / JavaScript, sans dépendance ni build) pour une société
de conseil automobile spécialisée dans l'achat, la vente et l'expertise de véhicules d'occasion.

> **Identité** : le design reprend la charte de la carte de visite Motor Consulting —
> noir profond, or, lettrage chrome, et les quatre piliers Recherche / Négociation /
> Achat-Vente / Location.
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
index.html              Page unique (toutes les sections, ancres SEO-friendly)
assets/css/styles.css   Styles — mobile-first, thème noir/gris + accent rouge
assets/js/data.js       Données : véhicules, témoignages, silhouettes SVG
assets/js/main.js       Interactions : menu, filtres, modale, carrousel, formulaires
assets/fonts/           Polices auto-hébergées (Michroma + Archivo, woff2)
assets/img/             Favicon et image de partage (SVG)
robots.txt / sitemap.xml / site.webmanifest
```

## Sections

1. **Accueil** — accroche, phrase de présentation, boutons « Vendre ma voiture » / « Trouver un
   véhicule », mini-formulaire d'estimation et chiffres clés animés.
2. **Nos services** — recherche de véhicule, négociation, achat/vente, location (courte et
   longue durée, LOA/LLD), expertise & estimation, démarches et transaction sécurisée.
3. **Véhicules disponibles** — grille de fiches avec recherche plein texte, filtres (type,
   budget, année), tri, pagination « voir plus » et fiche détaillée en modale.
4. **Comment ça marche** — 4 étapes (contact → expertise → proposition → transaction sécurisée).
5. **Estimation gratuite** — formulaire complet avec validation et confirmation.
6. **Témoignages** — carrousel avec notes en étoiles (clavier + swipe tactile).
7. **À propos** — histoire, valeurs, équipe.
8. **Contact** — coordonnées, carte, WhatsApp et formulaire.

Fonctionnalités transverses : barre fixe Appeler / WhatsApp / Estimation sur mobile, bouton
retour en haut, navigation active au défilement, apparitions au scroll, respect de
`prefers-reduced-motion`, focus visible et libellés accessibles.

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
| Chiffres clés | attributs `data-count` dans la section `#stats` | 1 850 / 12 ans / 4,9 |

### 2. Branchement des formulaires

Les trois formulaires (mini-estimation, estimation complète, contact) partagent la même
mécanique. Par défaut, `CONFIG.formEndpoint` est vide : le site est en **mode démonstration**
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
| Noir secondaire (sections alternées) | `--noir-2` | `#0e0e11` |
| Charbon (cartes, champs) | `--charbon` | `#15151a` |
| Or principal | `--or` | `#d4af37` |
| Or clair (survols, reflets) | `--or-clair` | `#f0dc9b` |
| Or foncé (bas du dégradé) | `--or-fonce` | `#8a6e1e` |
| Chrome (logotype) | `--chrome-1/2/3` | `#ffffff` → `#c6ccd4` → `#767c85` |
| Texte courant | `--texte` / `--texte-2` | `#ededea` / `#a9adb5` |

Trois dégradés en découlent : `--grad-or` (aplats et boutons), `--grad-or-txt` (texte doré,
plus lumineux pour rester lisible sur fond noir) et `--grad-chrome` (le mot « MOTOR »).
Deux SVG encodés en `data:` reprennent la couleur `%23d4af37` — les coches des listes et la
flèche des menus déroulants : pensez à les modifier si vous changez l'or.

Le site assume un **thème sombre unique** (comme la carte de visite) : il n'y a pas de
variante claire à maintenir.

**Typographie** : `Michroma` pour le lettrage large (logo, sur-titres, libellés) et `Archivo`
pour les titres et le texte courant. Les deux polices sont **auto-hébergées** dans
`assets/fonts/` (~98 Ko, formats woff2, `font-display:swap`) : aucun appel à Google Fonts,
ce qui évite le transfert d'adresses IP vers un service tiers — un point régulièrement
sanctionné en France sur le terrain du RGPD.

**Texture** : le motif nid d'abeille et les biseaux dorés de la carte sont reproduits en CSS
pur (variable `--hex` et éléments `.hero__diag`) — aucune image de fond à charger.

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
