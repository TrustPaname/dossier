# Publier les sites sur WordPress

Deux thèmes WordPress prêts à l'emploi, construits à partir des sources de ce dépôt :

| Thème | Archive | Pour quel site |
|---|---|---|
| **Motor Consulting** | `wordpress/motor-consulting.zip` | motorconsulting.fr (conseil, achat, vente, location) |
| **Motor Corp** | `wordpress/motor-corp.zip` | motorcorp.fr (holding) |

Chaque site est une installation WordPress distincte (un domaine = un WordPress = un thème).

## 1. Installer un thème (5 minutes)

1. Dans l'administration WordPress : **Apparence → Thèmes → Ajouter un thème → Téléverser un thème**.
2. Choisissez l'archive `.zip`, cliquez **Installer maintenant**, puis **Activer**.
3. Ouvrez la page d'accueil du site : le design est en place.

Le thème affiche sa page unique quelle que soit la page demandée : inutile de créer des pages
ou un menu dans WordPress.

## 2. Renseigner vos coordonnées

**Apparence → Personnaliser → Coordonnées** (Motor Consulting) ou **Motor Corp — liens et
coordonnées** (Motor Corp). Téléphone, WhatsApp, e-mail, adresse, horaires, et pour Motor Corp
les adresses des sites Motors Studio et Motor Consulting. Les changements sont visibles en direct
avant publication.

## 3. Motor Consulting : véhicules, avis, formulaires

### Véhicules
Menu **Véhicules → Ajouter un véhicule** :
- **Titre** : nom affiché (ex. « Peugeot 3008 ») ;
- **Texte principal** : description de la fiche ;
- **Photo principale** (colonne de droite) : la photo du véhicule, qui remplace l'illustration ;
- bloc **Caractéristiques** : marque, modèle, version, année, kilométrage, prix, carburant,
  boîte, type, places, étiquette, garantie, équipements (un par ligne) ;
- case **Véhicule vendu** : le retire du site sans le supprimer.

Les filtres, le tri et la fiche détaillée fonctionnent automatiquement avec ces données.

### Stock synchronisé avec Kepler VO (recommandé)
Plutôt que de saisir les véhicules à la main, le thème peut lire le **flux de stock** de votre
logiciel de gestion (Kepler VO : « API véhicule » ou export). Le site se met alors à jour tout
seul, avec les photos, à la fréquence choisie.

1. Demandez à votre conseiller Kepler VO l'**adresse du flux pour votre site internet** et,
   le cas échéant, la **clé d'accès**.
2. Apparence → Personnaliser → **Stock Kepler / flux d'annonces** : collez l'adresse, la clé,
   choisissez la fréquence (1 h par défaut) → Publier.
3. Menu **Véhicules → Stock Kepler** → **Synchroniser maintenant** : le tableau liste les
   véhicules reconnus.

Le convertisseur reconnaît les champs usuels (marque, modèle, version, année ou date de mise
en circulation, kilométrage, prix, énergie, boîte, carrosserie, photos, équipements,
description) en JSON, XML ou CSV. Si un champ n'est pas repris correctement, envoyez un
extrait du flux : la correspondance s'ajuste via le filtre `motor_stock_map` dans
`inc-stock.php`.

Les véhicules saisis à la main peuvent être ignorés ou affichés en plus du flux (réglage
« Véhicules saisis dans WordPress »).

### Témoignages
Menu **Témoignages → Ajouter** : titre = nom du client, texte = témoignage, puis ville, note
sur 5 et service concerné.

### Démonstration
Tant qu'aucun véhicule (ou avis) n'est saisi, le site montre les exemples de démonstration.
Avant la mise en ligne, décochez **« Afficher les véhicules et avis de démonstration »** dans
le Personnalisateur si vous n'avez pas encore saisi vos véhicules.

### Formulaires (estimation et contact)
Aucun service tiers : chaque demande est envoyée par e-mail à l'adresse **« E-mail qui reçoit
les demandes »** du Personnalisateur (par défaut l'e-mail administrateur), avec un accusé de
réception au visiteur et un numéro de référence.

Protection intégrée : champ piège contre les robots et limite d'une demande par minute et
par visiteur.

**Important — délivrabilité des e-mails.** Les hébergeurs mutualisés envoient souvent les
e-mails WordPress en spam, ou pas du tout. Installez l'extension gratuite **WP Mail SMTP**
(Extensions → Ajouter) et configurez-la avec la boîte e-mail de votre domaine (OVH, o2switch,
Gmail Workspace…). Envoyez ensuite une demande de test depuis le site.

## 4. Réglages WordPress recommandés

- **Réglages → Généraux** : titre du site « Motor Consulting » (ou « Motor Corp »), slogan
  « L'expertise automobile à votre service », fuseau horaire Paris.
- **Réglages → Permaliens** : « Titre de la publication » (nécessaire au bon fonctionnement
  des formulaires via l'API REST).
- **Réglages → Discussion** : décochez les commentaires (site sans articles).
- **Réglages → Lecture** : laissez « Vos derniers articles » ; le thème impose sa page d'accueil.
- Installez une extension de cache (WP Super Cache ou LiteSpeed Cache selon l'hébergeur) et un
  certificat HTTPS (gratuit chez la plupart des hébergeurs).
- Supprimez les thèmes et extensions inutilisés, gardez WordPress à jour.

## 5. Mettre à jour un thème

Le design vient des fichiers à la racine du dépôt (`index.html`, `assets/`, `motor-corp/`).
Après une modification :

```bash
python3 wordpress/build.py
```

régénère `front-page.php`, copie les ressources et recrée les deux archives. Téléversez la
nouvelle archive : WordPress propose de **remplacer** le thème existant. Vos coordonnées,
véhicules et témoignages sont conservés (ils sont dans la base de données, pas dans le thème).

## 6. Ce qui reste manuel

- Dans `motor-consulting/front-page.php`, la partie « adresse structurée » des données
  Google (`streetAddress`, `postalCode`, `addressLocality`, coordonnées GPS et carte) est
  à adapter si l'adresse change : recherchez `PostalAddress` et `openstreetmap`.
- Les textes du site (services, à propos, équipe) se modifient dans `index.html` puis
  reconstruction du thème.
