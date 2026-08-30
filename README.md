# AutoPrestige Conseil — site vitrine

Site vitrine d’une société de conseil automobile spécialisée dans l’achat, la vente et
l’expertise de véhicules d’occasion. Objectif : générer des demandes de contact
(estimation gratuite, mise en vente, recherche de véhicule) et rassurer sur le sérieux
de l’entreprise.

Site **statique**, en français, **mobile-first**, sans framework, sans étape de build et
sans dépendance externe : les polices sont celles du système, les visuels sont des SVG
générés à la volée. Le site s’ouvre directement depuis le disque ou depuis n’importe
quel hébergement.

---

## ⚠️ À remplacer avant la mise en ligne

Tout le contenu est rédigé mais les données de l’entreprise sont **fictives**. À changer
impérativement :

| Élément | Valeur actuelle (à remplacer) | Où |
| --- | --- | --- |
| Nom de l’entreprise | AutoPrestige Conseil | toutes les pages `.html` |
| Ville / zone | Paris et Île-de-France | toutes les pages `.html` |
| Téléphone | 01 84 60 12 40 | pages `.html` + `assets/js/config.js` |
| E-mail | contact@autoprestige-conseil.fr | pages `.html` + `assets/js/config.js` |
| WhatsApp | 33612345678 | `assets/js/config.js` |
| Adresse | 18 rue des Ateliers, 92300 Levallois-Perret | `contact.html`, `mentions-legales.html`, pied de page |
| Domaine | `https://www.autoprestige-conseil.fr/` | balises `canonical` / `og:url`, `sitemap.xml`, `robots.txt` |
| Carte | coordonnées OpenStreetMap | `contact.html` (iframe) |
| Mentions légales | SIRET, TVA, RCS, hébergeur | `mentions-legales.html` |

**Chiffres, avis clients et membres de l’équipe sont eux aussi des exemples**
(1 250 véhicules, 4,9/5, 180 avis, Thomas Marchand…). Publier des chiffres ou des avis
inventés est une pratique commerciale trompeuse : remplacez-les par vos données réelles,
ou retirez les blocs concernés.

Remplacement en masse :

```bash
grep -rl "AutoPrestige Conseil" . --include="*.html" --include="*.js" \
  | xargs sed -i "s/AutoPrestige Conseil/Votre Enseigne/g"
```

---

## Recevoir les demandes des formulaires

Les trois formulaires (estimation express en page d’accueil, estimation complète,
contact) valident les saisies côté navigateur et affichent un message de confirmation.
Il reste à choisir **où arrivent les demandes** — une seule ligne à renseigner dans
`assets/js/config.js` :

```js
endpointFormulaire: "https://formspree.io/f/xxxxxxx",
```

N’importe quel service acceptant un `POST` JSON convient (Formspree, Web3Forms, Getform,
Netlify Forms, ou votre propre API).

**Tant que ce champ est vide**, le site bascule automatiquement en mode « mailto » : le
logiciel de messagerie du visiteur s’ouvre avec la demande déjà rédigée, et les moyens de
contact directs sont rappelés. Aucune demande n’est donc perdue en silence — mais ce mode
reste un dépannage, configurez un endpoint pour la production.

Chaque formulaire embarque un champ-piège invisible (`pot-de-miel`) qui bloque les
robots spammeurs sans gêner les visiteurs.

---

## Mettre à jour le stock de véhicules

Le catalogue vit dans un seul tableau, en haut de `assets/js/vehicules.js` :

```js
{
  marque: "Peugeot", modele: "308 BlueHDi 130 Allure",
  annee: 2021, km: 62400, prix: 18900,
  type: "berline",          // citadine | berline | suv | break | utilitaire
  carburant: "Diesel", boite: "Automatique",
  teinte: "#3d4d63",        // couleur du visuel de remplacement
  etiquette: "Révisé",      // facultatif — "Coup de cœur" s'affiche en rouge
  photo: "assets/img/308.jpg"  // facultatif : sinon un visuel SVG est généré
}
```

Ajoutez ou retirez une entrée, tout le reste suit : fiches, compteur, liste des années,
plage du curseur de budget, filtres et tri. La page d’accueil affiche automatiquement les
véhicules étiquetés (attribut `data-limite="3"` sur la grille).

Pour de vraies photos, déposez-les dans `assets/img/` et renseignez le champ `photo`.
Format conseillé : 800 × 600 px, `.webp` ou `.jpg` compressé.

---

## Structure

```
index.html              Accueil : héros, chiffres clés, services, méthode,
                        véhicules à la une, témoignages, FAQ, appel à l'action
services.html           Les 4 prestations en détail + comparatif
vehicules.html          Catalogue avec recherche, filtres et tri
estimation.html         Formulaire d'estimation complet + FAQ
a-propos.html           Histoire, valeurs, équipe
contact.html            Coordonnées, carte, formulaire, WhatsApp
mentions-legales.html   Mentions légales et politique RGPD

assets/css/style.css    Feuille de style unique (jetons de design en tête de fichier)
assets/js/config.js     ← le seul fichier à configurer (endpoint, coordonnées)
assets/js/main.js       Menu mobile, animations, compteurs, liens WhatsApp
assets/js/forms.js      Validation et envoi des formulaires
assets/js/vehicules.js  Données du stock, fiches, filtres et tri

robots.txt / sitemap.xml
```

L’en-tête et le pied de page sont dupliqués dans chaque page HTML : c’est le prix à payer
pour un site sans build. Une modification du menu ou du pied de page doit donc être
répercutée dans les 7 fichiers.

### Design

Palette noir / gris avec un accent rouge `#c41220`, définie en variables CSS au début de
`assets/css/style.css`. Pour passer au bleu, il suffit de changer trois valeurs :

```css
--accent: #c41220;        /* couleur principale       */
--accent-fonce: #9d0e19;  /* survol des boutons       */
--accent-clair: #ff4a54;  /* accent sur fond sombre   */
```

---

## Développer et déployer

```bash
python3 -m http.server 8000     # puis http://localhost:8000
```

Le site étant 100 % statique, il se déploie tel quel sur GitHub Pages, Netlify, Vercel,
Cloudflare Pages ou un hébergement mutualisé classique (dépôt FTP à la racine).

---

## Référencement

- Titre et méta-description propres à chaque page, autour des mots-clés visés :
  *achat vente voiture occasion*, *rachat de voiture*, *expertise automobile*,
  *vendre sa voiture rapidement*, *estimation gratuite véhicule Paris*.
- Balises Open Graph, `canonical`, `lang="fr"`, un seul `<h1>` par page.
- Données structurées JSON-LD : `AutoDealer` (accueil, contact) et `FAQPage` (accueil).
- `sitemap.xml` et `robots.txt` à la racine.
- Pas de note globale ni d’avis dans le balisage structuré tant que les avis ne sont pas
  réels et vérifiables : un balisage d’avis fictifs expose à une pénalité Google.

Après changement de domaine, pensez à mettre à jour les `canonical`, `og:url`,
`sitemap.xml` et `robots.txt`.

### Accessibilité

Lien d’évitement, navigation au clavier, `aria-live` sur les messages de formulaire et
les résultats de recherche, contrastes conformes AA, respect de
`prefers-reduced-motion`.

---

## Annexe — serveur MCP

Le serveur MCP `21st` (https://21st.dev/api/mcp) est déclaré dans `.mcp.json`.
La clé d’API n’est pas versionnée : exportez-la avant de lancer Claude Code.

```bash
export TWENTY_FIRST_API_KEY="21st_sk_..."
```
