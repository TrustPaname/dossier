# Mettre les sites en ligne chez OVH (WordPress)

Objectif : deux sites WordPress — **motor-consulting.fr** et **motor-corp.fr** — sur un seul
hébergement OVH, chacun avec son thème (`motor-consulting.zip`, `motor-corp.zip`).

Tout se passe dans l'espace client OVH : https://www.ovh.com/manager/ → onglet **Web Cloud**.

## Étape 0 — Ce qu'il vous faut

- Les deux noms de domaine (Web Cloud → Noms de domaine). S'ils ne sont pas encore
  commandés : Web Cloud → Commander → Nom de domaine.
- Un **Hébergement Web** (offre *Pro* recommandée pour deux sites ; l'offre *Perso* fonctionne
  aussi). Web Cloud → Commander → Hébergement Web. Lors de la commande, rattachez
  motor-consulting.fr ; motor-corp.fr sera ajouté ensuite.
- Deux adresses e-mail sur vos domaines (contact@motor-consulting.fr, contact@motor-corp.fr) :
  Web Cloud → E-mails → votre domaine → **Ajouter un compte**. Elles serviront aux formulaires.

Compter 10 à 30 minutes pour l'activation de l'hébergement (e-mail d'OVH), jusqu'à 24 h pour
la propagation des domaines.

## Étape 1 — Rattacher le second domaine à l'hébergement

1. Web Cloud → **Hébergements** → votre hébergement → onglet **Multisite**.
2. **Ajouter un domaine ou sous-domaine** → choisissez *motor-corp.fr* (domaine OVH).
3. Cochez **www**, indiquez le dossier racine `motor-corp`, cochez **SSL**, laissez le pays
   par défaut, validez. OVH configure la zone DNS tout seul.
4. Vérifiez que *motor-consulting.fr* est bien présent lui aussi (dossier `motor-consulting`
   ou `www`, SSL coché). Sinon, ajoutez-le de la même façon.
5. Onglet **Informations générales** → bloc *Configuration* → **Modifier** → version PHP
   **8.2** ou supérieure, moteur *php*. Validez.

Si un domaine est hébergé ailleurs qu'OVH : dans sa zone DNS, faites pointer `@` et `www`
(enregistrements A) vers l'adresse IP de l'hébergement indiquée dans **Informations
générales → IPv4**.

## Étape 2 — Installer WordPress en un clic (à faire deux fois)

1. Hébergement → onglet **Modules en 1 clic** → **Ajouter un module**.
2. Choisissez **WordPress**, puis le domaine (*motor-consulting.fr* la première fois,
   *motor-corp.fr* la seconde). Langue : Français.
3. Laissez « Installation avec les paramètres par défaut » ou renseignez vous-même
   l'identifiant administrateur et le mot de passe.
4. Validez. Une base de données est créée automatiquement. Dans les 10 minutes, OVH vous
   envoie un e-mail avec l'adresse d'administration (`https://motor-consulting.fr/wp-admin`)
   et les identifiants.

Refaites l'opération pour *motor-corp.fr*.

## Étape 3 — Installer le thème (sur chaque site)

1. Connectez-vous à `https://votre-domaine/wp-admin`.
2. **Apparence → Thèmes → Ajouter un thème → Téléverser un thème** → choisissez
   `motor-consulting.zip` (ou `motor-corp.zip`) → **Installer maintenant** → **Activer**.
3. **Apparence → Personnaliser** → renseignez téléphone, WhatsApp, e-mail, adresse (et pour
   Motor Corp, les adresses des deux sites de marque) → **Publier**.
4. **Réglages → Permaliens** → « Titre de la publication » → Enregistrer.
5. **Réglages → Généraux** → titre du site, slogan, fuseau horaire « Paris ».
6. Supprimez les extensions préinstallées inutiles (Hello Dolly, Akismet si non utilisé) et
   les thèmes par défaut (Twenty …) sauf un, gardé en secours.

## Étape 4 — HTTPS partout

1. Le SSL Let's Encrypt a été activé à l'étape 1 (Multisite → colonne SSL). S'il indique
   « en cours », attendez quelques heures.
2. Dans WordPress : **Réglages → Généraux** → *Adresse web de WordPress* et *Adresse web du
   site* en `https://`.
3. Installez l'extension **Really Simple SSL** (Extensions → Ajouter) et activez la
   redirection : tout le trafic passe en HTTPS.

## Étape 5 — Les e-mails des formulaires (Motor Consulting)

OVH n'envoie pas de façon fiable les e-mails générés par WordPress ; passez par la boîte de
votre domaine.

1. Extensions → Ajouter → **WP Mail SMTP** → Installer → Activer.
2. WP Mail SMTP → Réglages : *Autre SMTP* avec
   - Serveur SMTP : `ssl0.ovh.net`
   - Chiffrement : **SSL**, port **465**
   - Authentification : oui — identifiant : l'adresse complète (`contact@motor-consulting.fr`),
     mot de passe : celui de la boîte créée à l'étape 0
   - Adresse d'expédition : la même adresse, nom : Motor Consulting
3. Onglet **Test e-mail** : envoyez-vous un message.
4. Dans Apparence → Personnaliser → Coordonnées, vérifiez **« E-mail qui reçoit les
   demandes »**, puis faites une vraie demande depuis le site pour valider la chaîne complète.

## Étape 6 — Contenu Motor Consulting

- **Véhicules → Ajouter un véhicule** pour chacune de vos annonces (photo, prix, kilométrage…).
- **Témoignages → Ajouter** pour vos avis clients.
- Une fois vos véhicules saisis, décochez « Afficher les véhicules et avis de démonstration »
  dans le Personnalisateur.

## Étape 7 — Finitions

- **Cache** : Extensions → Ajouter → *WP Super Cache* (ou *LiteSpeed Cache* si l'hébergement
  est en LiteSpeed) → activer la mise en cache.
- **Sauvegardes** : OVH conserve des sauvegardes automatiques (Hébergement → FTP-SSH →
  Restaurer). Ajoutez l'extension *UpdraftPlus* pour une sauvegarde hebdomadaire de votre côté.
- **Google** : déclarez les deux sites dans Google Search Console et Google Business Profile.
- Gardez WordPress, le thème et les extensions à jour (Tableau de bord → Mises à jour).

## En cas de problème

| Symptôme | Cause probable | Solution |
|---|---|---|
| Le domaine affiche la page OVH « Félicitations » | DNS pas encore propagé ou mauvais dossier racine | Attendre, puis vérifier Multisite → dossier |
| « Le lien que vous avez suivi a expiré » au téléversement du thème | Limite d'envoi PHP trop basse | Hébergement → Informations générales → Configuration → passer en PHP 8.2 ; ou téléverser le thème décompressé par FTP dans `wp-content/themes/` |
| Formulaire : « L'envoi a échoué » | REST API ou e-mail | Réglages → Permaliens → réenregistrer ; vérifier WP Mail SMTP |
| Page blanche après activation | Version PHP trop ancienne | PHP 8.1 minimum dans la configuration de l'hébergement |
| Carte absente dans Contact | Bloqueur ou iframe interdite | Normal sur certains navigateurs ; le lien « Itinéraire » reste actif |

## Mettre à jour le site plus tard

Après une modification des sources, `python3 wordpress/build.py` régénère les archives.
Téléversez la nouvelle archive : WordPress propose de remplacer le thème existant. Vos
véhicules, avis et coordonnées sont conservés.
