<?php
/**
 * MS MOTORS STUDIO — contenus transverses.
 *
 * Page d'accueil, page atelier, engagements, questions fréquentes générales
 * et zone d'intervention. Tout le texte du site hors pages de prestations.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Page d'accueil. */
function msms_accueil(): array {
	return array(
		'hero_titre_1' => 'L’exigence automobile,',
		'hero_titre_2' => 'dans chaque détail.',
		'hero_texte'   => 'Carrosserie, mécanique, vitrage et pneumatiques réunis dans un seul atelier, à Mainvilliers, aux portes de Chartres. Un interlocuteur unique suit votre véhicule du devis à la restitution.',

		'poles_titre'  => 'Quatre métiers, un seul atelier',
		'poles_texte'  => 'Faire le tour de trois prestataires pour une même voiture — le carrossier, le garagiste, le poseur de pare-brise — coûte du temps et multiplie les interlocuteurs. Nous avons réuni les quatre métiers sous le même toit, chacun avec son poste de travail et son outillage. Résultat : un seul devis, un seul dossier, une seule personne à appeler.',
		'poles_teaser' => array(
			'carrosserie-peinture' => 'Du débosselage sans peinture à la réparation après collision, avec cabine de peinture et recherche de teinte d’origine. La réparation qui ne se voit pas.',
			'mecanique-entretien'  => 'Révision constructeur, freinage, distribution, diagnostic électronique. Un point de contrôle honnête, un devis ligne par ligne, et rien sans votre accord.',
			'pare-brise-vitrage'   => 'Impact réparé en moins d’une heure ou pare-brise remplacé dans les règles, avec le dossier assurance préparé pour vous.',
			'pneumatiques'         => 'Le bon pneu pour votre usage, monté au couple, équilibré systématiquement, avec contrôle de géométrie quand il se justifie.',
		),

		'savoir_titre' => 'Le travail se juge sur les finitions',
		'savoir_texte' => array(
			'Un jeu de portière régulier, une teinte raccordée invisible sous la lumière rasante, un volant droit après la géométrie, un habitacle rendu propre : c’est à ces détails que se reconnaît un travail sérieux. Ce sont eux que nous contrôlons avant chaque restitution.',
			'L’atelier est organisé en postes distincts — zone de tôlerie et de préparation, cabine de peinture, ponts de mécanique, poste vitrage et poste pneumatique — pour que chaque intervention se fasse dans les conditions qu’elle exige. On ne ponce pas à côté d’un vernis frais, on ne colle pas un pare-brise dans la poussière.',
		),

		'chiffres'     => array(
			array( '4', 'métiers réunis sous un même toit' ),
			array( '1', 'interlocuteur qui suit votre dossier' ),
			array( '0', 'intervention lancée sans votre accord' ),
			array( '6 j/7', 'l’atelier ouvert du lundi au samedi' ),
		),

		'zone_titre'   => 'Mainvilliers, Chartres et l’Eure-et-Loir',
		'zone_texte'   => 'L’atelier se trouve rue Florence Arthaud à Mainvilliers, en bordure immédiate de Chartres. Nos clients viennent de toute l’agglomération chartraine — Lucé, Lèves, Champhol, Luisant, Le Coudray, Barjouville — et plus largement du département. Vous venez de plus loin ? Appelez-nous : nous vous dirons ce qu’il est possible de planifier.',
		'zone_villes'  => array( 'Mainvilliers', 'Chartres', 'Lucé', 'Lèves', 'Champhol', 'Luisant', 'Le Coudray', 'Barjouville', 'Amilly', 'Bailleau-l’Évêque' ),
	);
}

/** Méthode générale de prise en charge (accueil). */
function msms_methode(): array {
	return array(
		array( 'Rendez-vous', 'Par téléphone, via le formulaire ou directement à l’atelier. Décrivez le besoin en quelques mots : nous réservons le créneau et le poste de travail.' ),
		array( 'Examen et devis', 'Le véhicule est examiné devant vous quand c’est possible. Le devis distingue l’urgent, ce qui peut attendre et ce qui n’a pas besoin d’être touché.' ),
		array( 'Intervention', 'Rien ne démarre sans votre accord. Si un point imprévu apparaît en cours de travail, nous vous appelons avant de continuer — jamais de ligne surprise.' ),
		array( 'Restitution', 'Contrôle final, véhicule rendu propre, explications sur ce qui a été fait et pièces remplacées présentées. Vous repartez en sachant exactement ce qui a été réalisé.' ),
	);
}

/** Engagements (accueil + atelier). */
function msms_engagements(): array {
	return array(
		array( 'Le devis avant les travaux', 'Chiffré ligne par ligne, pièces et main-d’œuvre séparées, remis avant toute intervention. Le prix annoncé est le prix payé.' ),
		array( 'La franchise du diagnostic', 'Quand une réparation ne vaut pas la peine, nous vous le disons. Quand une pièce peut encore durer, aussi. Vendre l’inutile détruit la confiance — et la confiance, ici, c’est le fonds de commerce.' ),
		array( 'Le respect du véhicule', 'Housses de siège, protection de volant, aire de travail propre, contrôle final systématique. La voiture est rendue dans l’état où elle mérite d’être rendue.' ),
		array( 'La transparence sur les pièces', 'Origine constructeur ou qualité équivalente certifiée : la nature exacte de chaque pièce figure sur le devis, et les pièces déposées vous sont présentées.' ),
	);
}

/** Page atelier. */
function msms_atelier(): array {
	return array(
		'titre'      => 'Un atelier, quatre métiers.',
		'lead'       => 'MS MOTORS STUDIO est un atelier automobile installé rue Florence Arthaud à Mainvilliers, aux portes de Chartres. Carrosserie, mécanique, vitrage et pneumatiques y sont pratiqués sous le même toit, chacun à son poste.',
		'texte'      => array(
			'L’idée derrière l’atelier tient en une phrase : qu’un automobiliste de l’agglomération chartraine n’ait plus à courir entre trois adresses pour une même voiture. Un accrochage implique souvent de la tôlerie, un passage en peinture, parfois un vitrage et un contrôle de géométrie — autant d’allers-retours et d’interlocuteurs quand les métiers sont dispersés. Ici, le dossier reste dans les mêmes mains du début à la fin.',
			'L’organisation des lieux suit cette logique. La zone de tôlerie et de préparation est séparée de la mécanique pour contenir poussières et projections. La cabine de peinture, fermée et filtrée, garantit des applications propres. Les ponts accueillent l’entretien et les interventions lourdes, et un poste dédié regroupe démonte-pneu, équilibreuse et géométrie. Chaque métier dispose de son outillage, entretenu et étalonné.',
			'Le reste tient à la façon de travailler : parler clairement, montrer plutôt qu’affirmer, chiffrer avant d’agir, refuser ce qui ne se justifie pas. Vous parlez directement à la personne qui intervient sur votre voiture — pas à un standard. C’est une manière artisanale de faire, au sens exigeant du mot, et c’est celle que nous défendons.',
		),
		'postes'     => array(
			array( 'Cabine de peinture', 'Application des bases et vernis en atmosphère filtrée et à température maîtrisée. La condition d’une peinture sans poussière ni voile.' ),
			array( 'Zone de tôlerie', 'Postes de débosselage, redressage et préparation, séparés du reste de l’atelier pour travailler proprement.' ),
			array( 'Ponts de mécanique', 'Accès complet aux trains roulants et aux organes moteur pour l’entretien, le freinage, la distribution et les diagnostics.' ),
			array( 'Poste vitrage', 'Outillage de dépose et de collage, produits homologués et zone propre : un pare-brise se colle dans de bonnes conditions ou ne se colle pas.' ),
			array( 'Poste pneumatique', 'Démonte-pneu, équilibreuse et banc de géométrie pour le montage, l’équilibrage et le réglage des trains.' ),
			array( 'Contrôle et livraison', 'Vérification finale, nettoyage et préparation du véhicule avant restitution, pièces déposées présentées au client.' ),
		),
		'galerie'    => array(
			'La façade de l’atelier',
			'La cabine de peinture',
			'La zone mécanique',
			'Le poste pneumatique',
			'L’outillage',
			'Un véhicule en intervention',
		),
	);
}

/** Questions fréquentes générales (accueil + contact). */
function msms_faq_generale(): array {
	return array(
		array( 'Faut-il prendre rendez-vous ?', 'Oui, les interventions se font sur rendez-vous — par téléphone, via le formulaire ou directement à l’atelier. Cela nous permet de réserver le poste de travail et de commander les pièces à l’avance. Pour un diagnostic rapide (impact de pare-brise, bruit suspect), passez aux heures d’ouverture : nous regardons dès que possible.' ),
		array( 'Combien de temps mon véhicule sera-t-il immobilisé ?', 'Quelques heures pour un entretien courant ou un train de pneus, une à quatre journées pour de la carrosserie avec peinture, selon le séchage et le délai des pièces. La durée estimée figure sur le devis et nous vous prévenons si elle évolue.' ),
		array( 'Travaillez-vous avec les assurances ?', 'Oui. En cas de sinistre, nous constituons le dossier, recevons l’expert à l’atelier et échangeons directement avec votre assureur. Le libre choix du réparateur est un droit : vous pouvez confier votre véhicule à l’atelier de votre choix, quelle que soit votre compagnie.' ),
		array( 'Intervenez-vous sur toutes les marques ?', 'Sur la plupart des marques de véhicules particuliers, essence, diesel et hybrides. Si un modèle sort de notre champ — véhicule de collection, intervention haute tension lourde —, nous vous le disons dès le premier échange et vous orientons.' ),
		array( 'Où se trouve l’atelier et comment venir ?', 'Au 3 rue Florence Arthaud à Mainvilliers, à quelques minutes du centre de Chartres et accessible facilement depuis toute l’agglomération. Le bouton « Itinéraire » du site ouvre le trajet dans votre application de navigation.' ),
	);
}
