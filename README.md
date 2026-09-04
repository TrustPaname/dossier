# Trust Auto Paris — site vitrine

Site vitrine **statique** (HTML / CSS / JavaScript, sans dépendance ni build) pour une société
de conseil automobile spécialisée dans l'achat, la vente et l'expertise de véhicules d'occasion.

> **Nom et coordonnées** : le site est livré avec le nom **Trust Auto Paris** et une zone
> **Paris / Île-de-France**, ainsi que des coordonnées de démonstration (téléphone, e-mail,
> adresse). Remplacez-les avant mise en ligne — voir « Personnalisation » ci-dessous.

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
assets/img/             Favicon et image de partage (SVG)
robots.txt / sitemap.xml / site.webmanifest
```

## Sections

1. **Accueil** — accroche, phrase de présentation, boutons « Vendre ma voiture » / « Trouver un
   véhicule », mini-formulaire d'estimation et chiffres clés animés.
2. **Nos services** — achat pour compte de tiers, vente accompagnée, expertise/estimation,
   contrôle technique & négociation.
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
| Nom de l'entreprise | `index.html` (titre, header, footer, JSON-LD) | Trust Auto Paris |
| Téléphone affiché | `index.html` | `06 12 34 56 78` |
| Téléphone / WhatsApp technique | `index.html` (`tel:`, `wa.me/`) et `CONFIG.whatsapp` dans `main.js` | `33612345678` |
| E-mail | `index.html` et `CONFIG.email` dans `main.js` | `contact@trustautoparis.fr` |
| Adresse + coordonnées GPS | `index.html` (bloc contact, iframe carte, JSON-LD) | 24 avenue de la Grande-Armée, 75017 Paris |
| Domaine | balises `canonical`, `og:url`, `robots.txt`, `sitemap.xml` | `www.trustautoparis.fr` |
| Chiffres clés | attributs `data-count` dans la section `#stats` | 1 850 / 12 ans / 4,9 |

### 2. Branchement des formulaires

Les trois formulaires (mini-estimation, estimation complète, contact) partagent la même
mécanique. Par défaut, `CONFIG.formEndpoint` est vide : le site est en **mode démonstration**
— la demande est validée, une référence est générée, un message de confirmation s'affiche et
la demande est conservée dans le `localStorage` du visiteur (clé `tap_demandes`).

Pour recevoir réellement les demandes, renseignez une URL en haut de `assets/js/main.js` :

```js
const CONFIG = {
  formEndpoint: "https://formspree.io/f/VOTRE_ID", // ou Getform, Brevo, votre API…
  whatsapp: "33612345678",
  email: "contact@trustautoparis.fr"
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

### 4. Couleur d'accent

Une seule variable à changer dans `assets/css/styles.css` (`:root`) pour passer du rouge au
bleu :

```css
--accent:#1d6ff2;
--accent-dark:#1557c0;
--accent-soft:rgba(29,111,242,.12);
```

Pensez à mettre à jour les deux SVG encodés en `data:` (coches des listes) qui contiennent
la couleur `%23e11d2e`, ainsi que `assets/img/favicon.svg`.

## SEO

- Titre, méta-description, Open Graph, `canonical`, `sitemap.xml` et `robots.txt` renseignés.
- Données structurées **JSON-LD** `AutoDealer` (adresse, horaires, zone desservie, note).
- Mots-clés intégrés naturellement dans les contenus : achat vente voiture occasion, rachat de
  voiture, expertise automobile, vendre sa voiture rapidement, estimation gratuite véhicule Paris.
- Un seul `<h1>`, hiérarchie `h2`/`h3` cohérente, liens internes descriptifs, `lang="fr"`.

## Performance et compatibilité

- Zéro dépendance externe, zéro webfont, zéro image bitmap : le rendu ne dépend d'aucun CDN.
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
- [ ] Mettre à jour le domaine dans `canonical`, `og:url`, `robots.txt` et `sitemap.xml`.
