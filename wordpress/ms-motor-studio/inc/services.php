<?php
/**
 * MS MOTORS STUDIO — contenu des quatre pôles d'activité.
 *
 * Tout le contenu éditorial des pages de prestations est réuni ici :
 * textes, étapes de travail, prestations détaillées, conseils et questions
 * fréquentes. Modifier ce fichier suffit à mettre à jour les pages.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function msms_services(): array {
	$assurance = '1' === msms_get( 'opt_assurance' );
	$adas      = '1' === msms_get( 'opt_adas' );
	$stockage  = '1' === msms_get( 'opt_stockage' );

	return array(

		/* ────────────────────────── 01 · CARROSSERIE ────────────────────────── */
		'carrosserie-peinture' => array(
			'index'     => '01',
			'nav'       => 'Carrosserie & peinture',
			'titre'     => 'Carrosserie et peinture',
			'kicker'    => 'Tôlerie, préparation, cabine',
			'meta_titre' => 'Carrosserie et peinture à Mainvilliers, près de Chartres',
			'meta_desc' => 'Carrosserie à Mainvilliers : débosselage, redressage, remplacement d’éléments et peinture en cabine avec recherche de teinte d’origine. Devis après examen du véhicule, prise en charge assurance.',
			'lead'      => 'Une carrosserie bien réparée ne se remarque pas. C’est toute la difficulté du métier : redonner à un élément accidenté sa forme, sa teinte et son brillant d’origine, sans que rien ne trahisse l’intervention.',
			'intro'     => array(
				'Un choc de parking, un accrochage, une portière enfoncée : avant de parler réparation, nous examinons le véhicule avec vous. Certains dégâts se traitent par débosselage en conservant la peinture d’origine. D’autres demandent une remise en forme, un masticage et un passage en cabine. D’autres encore justifient le remplacement pur et simple de l’élément, parce qu’il coûtera moins cher qu’une remise en état longue. Ce diagnostic honnête, fait devant vous, détermine le devis.',
				'La qualité d’une peinture se joue à 90 % avant le pistolet : dégraissage, ponçage par grains successifs, masticage fin, apprêt, marouflage précis des zones à protéger. Nous ne brûlons aucune de ces étapes. La teinte est identifiée par le code constructeur, puis ajustée sur plaquette d’essai pour tenir compte du vieillissement de la peinture en place — un gris métallisé de dix ans n’est plus exactement celui qui est sorti d’usine.',
				'L’application se fait en cabine fermée, à température maîtrisée, en respectant les temps de désolvatation entre les couches. Après séchage, l’élément est verni, poli si nécessaire, puis contrôlé en lumière rasante : c’est sous cet éclairage que se voient les défauts, et c’est sous cet éclairage que nous validons le travail avant de vous rendre les clés.',
			),
			'methode'   => array(
				array( 'Examen du véhicule', 'Nous regardons le dégât avec vous, sondons la tôle et vérifions les jeux d’ouvrants. Vous repartez avec un avis clair : réparation, remise en forme ou remplacement.' ),
				array( 'Devis détaillé', 'Pièces, ingrédients peinture et main-d’œuvre sont chiffrés ligne par ligne. En cas de sinistre, nous préparons le dossier pour votre assureur.' ),
				array( 'Réparation et préparation', 'Débosselage, redressage ou remplacement, puis préparation complète des fonds : c’est elle qui garantit la tenue de la peinture dans le temps.' ),
				array( 'Peinture et contrôle', 'Mise en teinte sur plaquette, application en cabine, vernis, puis contrôle en lumière rasante et remontage des éléments avec réglage des jeux.' ),
			),
			'prestations' => array_values( array_filter( array(
				array( 'Débosselage et redressage', 'Traitement des bosses, plis et enfoncements, y compris le débosselage sans peinture quand l’état du support le permet. La tôle retrouve sa ligne, l’élément d’origine est conservé.' ),
				array( 'Remplacement d’éléments', 'Pare-chocs, ailes, portières, capots, optiques : dépose, pose et ajustage précis des jeux, avec des pièces d’origine ou de qualité équivalente certifiée, mentionnées telles quelles sur le devis.' ),
				array( 'Peinture en cabine', 'Application des bases et du vernis en cabine chauffée et filtrée. Temps de séchage respectés, aucun remontage sur peinture fraîche.' ),
				array( 'Recherche de teinte', 'Identification du code couleur constructeur, réalisation d’une plaquette d’essai et ajustement de la formule avant toute application sur le véhicule.' ),
				array( 'Raccords fondus', 'Sur un élément voisin de la zone réparée, le raccord fondu évite la démarcation de teinte visible sur les réparations bâclées. La transition devient indécelable.' ),
				array( 'Rénovation esthétique', 'Polissage en plusieurs passes pour effacer micro-rayures, tourbillons de lavage et voile d’oxydation. La peinture retrouve sa profondeur, notamment sur les teintes sombres.' ),
				array( 'Rénovation d’optiques', 'Ponçage et traitement des optiques ternis ou jaunis. Un éclairage retrouvé, et un point de moins à reprendre au contrôle technique.' ),
				array( 'Pare-chocs et plastiques', 'Réparation des plastiques fissurés ou déformés lorsque le support s’y prête, avec préparation spécifique avant mise en peinture.' ),
				$assurance ? array( 'Assurance et expertise', 'Nous constituons le dossier, recevons l’expert à l’atelier et échangeons directement avec votre assureur. Vous n’avancez que ce que prévoit votre contrat.' ) : null,
				$adas ? array( 'Aides à la conduite', 'Recalibrage des caméras et radars lorsque l’intervention touche à leur position : une obligation de sécurité sur les véhicules récents.' ) : null,
			) ) ),
			'conseils'  => array(
				array( 'Un impact traité tôt coûte moins cher', 'Un éclat de peinture laissé nu laisse l’humidité atteindre la tôle. La corrosion s’installe en quelques mois et transforme une retouche en réparation lourde.' ),
				array( 'Franchise et vétusté : on vous explique', 'Avant d’accepter une prise en charge, vous devez savoir ce qui reste à votre charge. Nous détaillons franchise et éventuelle vétusté avant de commencer, pas après.' ),
				array( 'La lumière rasante ne pardonne rien', 'C’est le juge de paix du carrossier. Nous contrôlons chaque élément peint sous cet éclairage avant restitution — vous pouvez le faire avec nous.' ),
			),
			'faq'       => array(
				array( 'Combien de temps dure une réparation de carrosserie ?', 'Une retouche localisée prend une à deux journées. Un élément complet avec peinture, deux à quatre jours selon le séchage et les pièces. Une réparation après collision dépend du délai des pièces : la durée estimée figure sur le devis, et nous vous prévenons si elle évolue.' ),
				array( 'Puis-je faire réparer chez vous plutôt que chez le carrossier de mon assurance ?', 'Oui. Le libre choix du réparateur est un droit inscrit dans la loi : votre assureur ne peut pas vous imposer un atelier. Nous gérons le dossier et l’expertise avec lui, comme le ferait un réparateur agréé.' ),
				array( 'La teinte sera-t-elle exactement la même ?', 'C’est l’objet de la recherche de teinte : la formule du constructeur est ajustée sur plaquette pour correspondre à la peinture vieillie de votre véhicule, puis validée à côté de la zone à peindre avant application. Sur les teintes délicates, un raccord fondu sur l’élément voisin garantit une transition invisible.' ),
				array( 'Réparez-vous les jantes et les rayures profondes ?', 'Les rayures, même profondes, se traitent dès lors que la tôle n’est pas déformée. Pour les jantes, nous vous orientons selon le type de dommage : voile, accroc de trottoir ou corrosion ne se traitent pas de la même façon.' ),
			),
			'cta'       => 'Envoyez-nous une photo du dégât ou passez à l’atelier : l’examen du véhicule et l’avis sur la meilleure réparation ne vous engagent à rien.',
		),

		/* ────────────────────────── 02 · MÉCANIQUE ────────────────────────── */
		'mecanique-entretien' => array(
			'index'     => '02',
			'nav'       => 'Mécanique & entretien',
			'titre'     => 'Mécanique et entretien',
			'kicker'    => 'Entretien, diagnostic, réparation',
			'meta_titre' => 'Garage mécanique et entretien auto à Mainvilliers (Chartres)',
			'meta_desc' => 'Mécanique auto à Mainvilliers : révision constructeur, vidange, freinage, distribution, suspension, climatisation et diagnostic électronique. Devis ligne par ligne avant toute intervention, garantie constructeur préservée.',
			'lead'      => 'Un moteur bien entretenu ne se contente pas de durer : il consomme moins, pollue moins et garde sa valeur à la revente. Notre travail consiste à faire ce qui est nécessaire — et uniquement ce qui est nécessaire.',
			'intro'     => array(
				'Chaque véhicule qui entre à l’atelier passe par un point de contrôle. Nous relevons trois catégories de constats : ce qui est urgent pour votre sécurité, ce qui peut attendre la prochaine échéance, et ce qui n’a pas besoin d’être touché. Cette distinction figure noir sur blanc sur le devis. Vous décidez ensuite, en connaissance de cause, sans jamais découvrir une ligne imprévue au moment de payer.',
				'Nous intervenons sur la plupart des marques, essence, diesel et hybrides, en suivant le plan d’entretien du constructeur. Un point important que beaucoup d’automobilistes ignorent : entretenir votre véhicule hors du réseau de la marque ne fait pas perdre la garantie constructeur, dès lors que les préconisations sont respectées. Nous utilisons les huiles aux normes exigées, des pièces d’origine ou de qualité équivalente, et nous tamponnons le carnet.',
				'Les pièces remplacées sont conservées et vous sont présentées à la restitution. Une plaquette usée jusqu’au support ou un amortisseur qui fuit se comprennent mieux quand on les a en main : c’est aussi comme cela que se construit la confiance.',
			),
			'methode'   => array(
				array( 'Prise de rendez-vous', 'Par téléphone ou via le formulaire. Décrivez le symptôme — bruit, voyant, comportement — ou l’échéance d’entretien : nous réservons le créneau et commandons les pièces courantes.' ),
				array( 'Point de contrôle', 'Le véhicule est examiné sur pont : freinage, trains roulants, niveaux, fuites, état des pneus, lecture électronique. Chaque constat est classé : urgent, à prévoir, ou rien à signaler.' ),
				array( 'Accord sur devis', 'Pièces et main-d’œuvre chiffrées ligne par ligne. Rien ne démarre sans votre accord ; si un point apparaît en cours d’intervention, nous vous appelons avant de continuer.' ),
				array( 'Intervention et restitution', 'Travail réalisé dans les règles, essai routier si nécessaire, remise à zéro des indicateurs, carnet tamponné. Les pièces déposées vous sont présentées.' ),
			),
			'prestations' => array(
				array( 'Vidange et filtration', 'Vidange avec huile conforme à la norme constructeur de votre moteur — pas une huile « universelle » —, remplacement des filtres à huile, à air, à carburant et d’habitacle selon l’échéance.' ),
				array( 'Révision constructeur', 'L’entretien complet du carnet, opération par opération, avec remise à zéro des indicateurs de maintenance. Votre garantie constructeur est intégralement préservée.' ),
				array( 'Freinage', 'Plaquettes, disques, étriers, flexibles et liquide de frein. Nous mesurons l’épaisseur des disques et le taux d’humidité du liquide plutôt que de remplacer au jugé.' ),
				array( 'Distribution', 'Remplacement du kit complet — courroie ou chaîne, galets, et pompe à eau lorsqu’elle est entraînée par la courroie. L’intervention qui ne tolère aucune approximation : une rupture détruit le moteur.' ),
				array( 'Embrayage', 'Diagnostic du patinage ou des à-coups, remplacement du kit et du volant moteur bi-masse si son état l’exige, purge et réglage de la commande.' ),
				array( 'Suspension et direction', 'Amortisseurs, ressorts, rotules, silentblocs, biellettes de barre stabilisatrice. Un train roulant en bon état, c’est une voiture qui freine droit et des pneus qui durent.' ),
				array( 'Climatisation', 'Contrôle d’étanchéité, recherche de fuite au traceur, recharge au gaz adapté à votre circuit et remplacement du filtre d’habitacle.' ),
				array( 'Batterie et charge', 'Test de la batterie sous charge, contrôle de l’alternateur et du démarreur. Remplacement avec enregistrement de la batterie sur les véhicules qui l’exigent.' ),
				array( 'Diagnostic électronique', 'Lecture des calculateurs, analyse des valeurs en temps réel et recherche méthodique de panne. On remplace la pièce en cause, pas trois pièces « pour voir ».' ),
				array( 'Échappement et dépollution', 'Ligne d’échappement, sondes, vanne EGR, filtre à particules : contrôle, nettoyage ou remplacement selon l’état, notamment avant un contrôle technique.' ),
				array( 'Contrôle technique : préparation et contre-visite', 'Point de contrôle avant le passage pour éviter la contre-visite, ou reprise ciblée des défauts relevés sur le procès-verbal.' ),
			),
			'conseils'  => array(
				array( 'Un voyant moteur ne s’ignore pas', 'Allumé fixe, il signale un défaut à faire lire rapidement. Clignotant, il impose de s’arrêter : continuer à rouler peut détruire le catalyseur.' ),
				array( 'Le liquide de frein vieillit', 'Il absorbe l’humidité de l’air et perd en efficacité avec le temps. Nous mesurons son taux d’humidité à chaque point de contrôle : au-delà du seuil, le remplacement s’impose.' ),
				array( 'La distribution ne prévient pas', 'Elle se remplace au kilométrage ou à l’âge préconisé, même si « tout va bien ». C’est la seule pièce d’usure dont la défaillance condamne le moteur.' ),
			),
			'faq'       => array(
				array( 'Vais-je perdre ma garantie constructeur en venant chez vous ?', 'Non. La réglementation européenne garantit le libre choix du réparateur : la garantie est maintenue dès lors que l’entretien respecte les préconisations du constructeur, ce que nous faisons — huiles aux normes, pièces d’origine ou équivalentes, opérations du carnet, et tampon à l’appui.' ),
				array( 'Proposez-vous un devis avant l’intervention ?', 'Systématiquement. Le point de contrôle donne lieu à un devis ligne par ligne, pièces et main-d’œuvre séparées, classé par urgence. Rien n’est remplacé sans votre accord explicite.' ),
				array( 'Travaillez-vous sur les hybrides ?', 'Oui, pour l’entretien courant et la mécanique conventionnelle des véhicules hybrides. Pour une intervention lourde sur la chaîne haute tension, nous vous le disons franchement et vous orientons.' ),
				array( 'Que faites-vous des pièces remplacées ?', 'Elles sont conservées et vous sont présentées à la restitution du véhicule. Vous pouvez les emporter, à l’exception des pièces consignées ou soumises à une filière de recyclage obligatoire.' ),
			),
			'cta'       => 'Une échéance d’entretien, un bruit inhabituel, un voyant allumé ? Appelez l’atelier : un premier avis par téléphone ne coûte rien.',
		),

		/* ────────────────────────── 03 · VITRAGE ────────────────────────── */
		'pare-brise-vitrage' => array(
			'index'     => '03',
			'nav'       => 'Pare-brise & vitrage',
			'titre'     => 'Pare-brise et vitrage',
			'kicker'    => 'Impact, fissure, remplacement',
			'meta_titre' => 'Réparation et remplacement de pare-brise à Mainvilliers (Chartres)',
			'meta_desc' => 'Pare-brise à Mainvilliers : réparation d’impact par injection de résine, remplacement de pare-brise, vitres latérales et lunette arrière. Diagnostic immédiat du vitrage et accompagnement avec votre assurance.',
			'lead'      => 'Un impact de gravillon se répare en moins d’une heure. Attendez quelques semaines, un coup de froid ou une bosse sur la route, et il devient une fissure — et la fissure, elle, ne se répare pas.',
			'intro'     => array(
				'Le diagnostic décide de tout. Trois critères déterminent si un impact est réparable : sa taille (jusqu’à une pièce de deux euros environ), sa position (hors du champ de vision direct du conducteur et à distance des bords du vitrage) et son ancienneté. Nous examinons l’impact et vous donnons une réponse immédiate et argumentée : réparation ou remplacement, jamais l’un pour vendre l’autre.',
				'La réparation consiste à injecter sous pression une résine dans l’impact, puis à la polymériser aux UV et à la polir. Elle stoppe définitivement la propagation, restaure la solidité du vitrage et efface l’essentiel de la trace visuelle. C’est une intervention rapide, couverte par la plupart des garanties bris de glace, et qui évite un remplacement bien plus coûteux.',
				'Quand le remplacement s’impose, il se fait dans les règles : dépose propre, préparation de la baie, primaires et colle homologués, vitrage aux spécifications d’origine, repose des capteurs et accessoires. Nous vous indiquons le temps de séchage de la colle avant de reprendre la route — le pare-brise participe à la rigidité de la caisse et retient l’airbag passager : son collage n’est pas un détail.',
			),
			'methode'   => array(
				array( 'Diagnostic du vitrage', 'Taille, position, profondeur, ancienneté : nous examinons l’impact ou la fissure et vous donnons immédiatement le verdict — réparable ou non — avec l’explication.' ),
				array( 'Point assurance', 'Nous vérifions avec vous ce que couvre votre garantie bris de glace, le montant exact de votre franchise, et nous préparons la déclaration. Aucune mauvaise surprise.' ),
				array( 'Intervention', 'Injection de résine pour un impact ; dépose, collage et repose pour un remplacement, avec des produits homologués et un vitrage aux spécifications d’origine.' ),
				array( 'Contrôle et consignes', 'Vérification de l’étanchéité et des équipements (capteur de pluie, dégivrage, caméra), consignes claires : délai avant de rouler, lavage à éviter les premiers jours.' ),
			),
			'prestations' => array_values( array_filter( array(
				array( 'Réparation d’impact', 'Injection de résine sous pression, polymérisation UV et polissage. Vingt à quarante minutes d’intervention, la solidité du vitrage restaurée et la propagation stoppée.' ),
				array( 'Remplacement de pare-brise', 'Dépose, préparation de la baie, collage aux produits homologués et repose des accessoires. Vitrage conforme aux spécifications d’origine : teinte, capteurs, dégivrage, acoustique.' ),
				array( 'Vitres latérales et custodes', 'Remplacement après bris ou effraction, avec aspiration soigneuse des débris dans la portière et l’habitacle — jusque dans les glissières du lève-vitre.' ),
				array( 'Lunette arrière', 'Remplacement avec reconnexion et contrôle du dégivrage et de l’antenne lorsque le vitrage en est équipé.' ),
				array( 'Joints et étanchéité', 'Recherche d’entrée d’eau, remplacement des joints fatigués et contrôle d’étanchéité après toute pose.' ),
				array( 'Capteurs et équipements', 'Repose et vérification du capteur de pluie et de luminosité, des caméras et des connexions après remplacement du vitrage.' ),
				$assurance ? array( 'Démarches assurance', 'Déclaration de bris de glace, échanges avec l’assureur, facturation directe quand votre contrat le permet : vous ne réglez que votre franchise éventuelle.' ) : null,
				$adas ? array( 'Recalibrage ADAS', 'Recalibrage des caméras d’aide à la conduite après remplacement du pare-brise sur les véhicules équipés — une étape obligatoire pour que freinage d’urgence et maintien de voie restent fiables.' ) : null,
			) ) ),
			'conseils'  => array(
				array( 'Couvrez l’impact en attendant', 'Un simple adhésif transparent posé sur l’impact empêche l’eau et les poussières d’y entrer, et préserve les chances d’une réparation propre.' ),
				array( 'Évitez le dégivrage brutal', 'Verser de l’eau chaude sur un pare-brise gelé qui porte un impact, c’est presque à coup sûr transformer l’impact en fissure traversante.' ),
				array( 'Un impact dans le champ de vision', 'Même petit, un impact situé juste devant les yeux du conducteur impose souvent le remplacement : la réparation laisse une trace optique incompatible avec cette zone. C’est aussi un motif de contre-visite au contrôle technique.' ),
			),
			'faq'       => array(
				array( 'La réparation d’un impact est-elle prise en charge par l’assurance ?', 'Dans la plupart des contrats avec garantie bris de glace, la réparation d’impact est couverte, souvent sans franchise — mais cela dépend de votre contrat, pas de nous. Nous vérifions le vôtre avec vous et vous annonçons le montant exact restant à votre charge avant d’intervenir.' ),
				array( 'Combien de temps avant de pouvoir rouler ?', 'Après une réparation d’impact, immédiatement. Après un remplacement de pare-brise, il faut respecter le temps de prise de la colle — généralement une à deux heures selon le produit et la température. Nous vous donnons l’heure exacte à la restitution.' ),
				array( 'Une fissure passe-t-elle au contrôle technique ?', 'Une fissure ou un impact important dans le champ de vision du conducteur est un motif de contre-visite. Remplacer un vitrage endommagé avant le passage vous évite ce désagrément.' ),
				array( 'Utilisez-vous des vitrages d’origine ?', 'Nous posons des vitrages conformes aux spécifications d’origine, homologués et adaptés aux équipements de votre véhicule. L’origine exacte de la pièce figure sur le devis, comme pour toutes nos interventions.' ),
			),
			'cta'       => 'Un impact sur votre pare-brise ? Passez à l’atelier pour le diagnostic : il prend cinq minutes et vous saurez exactement à quoi vous en tenir.',
		),

		/* ────────────────────────── 04 · PNEUMATIQUES ────────────────────────── */
		'pneumatiques' => array(
			'index'     => '04',
			'nav'       => 'Pneumatiques',
			'titre'     => 'Pneumatiques',
			'kicker'    => 'Montage, équilibrage, géométrie',
			'meta_titre' => 'Pneus, équilibrage et géométrie à Mainvilliers (Chartres)',
			'meta_desc' => 'Pneumatiques à Mainvilliers : montage toutes marques, équilibrage, géométrie et parallélisme, réparation de crevaison, permutation et conseil. Le bon pneu selon votre usage, pas selon le stock.',
			'lead'      => 'Quatre surfaces de la taille d’une carte postale : c’est tout ce qui relie votre voiture à la route. Le choix, le montage et le réglage de vos pneus méritent mieux qu’un travail à la chaîne.',
			'intro'     => array(
				'Le bon pneu n’est pas le même pour tout le monde. Un grand rouleur d’autoroute, un conducteur urbain et un habitué des routes de campagne du département n’ont pas les mêmes besoins. Nous choisissons avec vous selon trois critères : votre usage réel, les dimensions et indices homologués pour votre véhicule, et votre budget — en vous expliquant ce que change concrètement le passage d’une gamme à l’autre.',
				'Le montage est aussi important que le pneu lui-même. Passage au démonte-pneu avec précaution pour les jantes en alliage, valve ou capteur de pression traité à chaque montage, serrage des roues à la clé dynamométrique au couple prescrit, puis équilibrage systématique. Une roue mal équilibrée, ce sont des vibrations dans le volant, des trains roulants qui fatiguent et des pneus qui s’usent en facettes.',
				'Reste la géométrie : les angles des trains avant et arrière. Un trottoir pris de biais ou un nid-de-poule suffisent à la dérégler. Les symptômes sont connus — la voiture tire d’un côté, le volant n’est pas droit, les pneus s’usent sur un bord. Nous contrôlons, nous vous montrons les valeurs, et nous ne réglons que si c’est nécessaire.',
			),
			'methode'   => array(
				array( 'Conseil et devis', 'Dimensions, indices de charge et de vitesse, saisonnalité, comparaison de deux ou trois gammes selon votre usage : vous choisissez en connaissant les différences réelles.' ),
				array( 'Montage dans les règles', 'Démontage et montage soignés, valves ou capteurs traités, serrage au couple à la clé dynamométrique — jamais à la clé à choc seule.' ),
				array( 'Équilibrage systématique', 'Chaque roue montée passe à l’équilibreuse. C’est inclus, pas une option : rouler avec des roues déséquilibrées use la voiture et le conducteur.' ),
				array( 'Contrôle final', 'Pressions ajustées à la préconisation constructeur, serrage vérifié, témoin de pression réinitialisé. Un contrôle du serrage est conseillé après une centaine de kilomètres.' ),
			),
			'prestations' => array_values( array_filter( array(
				array( 'Montage et démontage', 'Tous types de pneus — été, hiver, quatre saisons, runflat — sur jantes acier ou alliage, avec protection des jantes fragiles et traitement de la valve à chaque montage.' ),
				array( 'Équilibrage', 'Équilibrage sur machine à chaque montage et sur demande en cas de vibrations. Masses adaptées au type de jante, y compris masses collées invisibles pour les jantes alliage.' ),
				array( 'Géométrie et parallélisme', 'Mesure des angles des deux trains, comparaison aux valeurs constructeur, réglage si nécessaire. Indispensable après un choc, un remplacement de train ou une usure irrégulière.' ),
				array( 'Réparation de crevaison', 'Réparation par l’intérieur — dépose du pneu, inspection complète et pose d’une mèche-champignon vulcanisée — uniquement lorsque la zone et la taille de la perforation le permettent. Un flanc perforé ne se répare pas : question de sécurité, pas de rentabilité.' ),
				array( 'Permutation', 'Croisement des roues selon le schéma adapté à votre transmission pour répartir l’usure et prolonger la vie du train complet.' ),
				array( 'Contrôle d’usure et pressions', 'Mesure de la profondeur des sculptures en plusieurs points, lecture des indices d’usure, contrôle de l’âge des pneus et des pressions à froid.' ),
				array( 'Capteurs de pression (TPMS)', 'Remplacement, programmation et réinitialisation des capteurs sur les véhicules équipés de la surveillance directe de pression.' ),
				array( 'Pneus hiver et loi Montagne', 'Conseil sur les obligations d’équipement hivernal selon vos trajets, montage saisonnier et croisement des trains été/hiver.' ),
				$stockage ? array( 'Gardiennage de pneus', 'Votre second train de pneus stocké à l’atelier entre deux saisons, étiqueté et contrôlé au remontage. Fini les pneus qui encombrent le garage de la maison.' ) : null,
			) ) ),
			'conseils'  => array(
				array( 'La pression se vérifie à froid', 'Une fois par mois et avant tout long trajet, sur des pneus qui n’ont pas roulé. Sous-gonflé de 0,5 bar, un pneu chauffe, use ses épaules et allonge le freinage.' ),
				array( '1,6 mm, c’est le minimum légal — pas le bon repère', 'Sous 3 mm, les performances sur sol mouillé chutent nettement, bien avant le témoin légal. Nous mesurons et vous donnons les chiffres, pneu par pneu.' ),
				array( 'Deux pneus neufs ? À l’arrière', 'Contre-intuitif mais constant dans les essais : les pneus les plus récents se montent à l’arrière pour préserver la stabilité en courbe et sous la pluie, quelle que soit la transmission.' ),
			),
			'faq'       => array(
				array( 'Quelles marques de pneus proposez-vous ?', 'Nous travaillons toutes les grandes marques et plusieurs niveaux de gamme, du premium au budget maîtrisé. Plutôt qu’un catalogue imposé, nous vous présentons deux ou trois options chiffrées adaptées à votre usage, avec les différences expliquées.' ),
				array( 'Réparez-vous toutes les crevaisons ?', 'Non, et c’est volontaire : seule la bande de roulement se répare, dans les règles, par l’intérieur du pneu. Une perforation sur le flanc, trop large, ou un pneu qui a roulé à plat compromettent la structure — dans ces cas, nous refusons la réparation et vous expliquons pourquoi.' ),
				array( 'Faut-il faire une géométrie avec des pneus neufs ?', 'Pas systématiquement. Elle s’impose si l’ancien train montrait une usure irrégulière, après un choc, ou si le véhicule tire d’un côté. Le contrôle donne la réponse : si les valeurs sont bonnes, nous ne facturons pas un réglage inutile.' ),
				array( 'Montez-vous des pneus achetés ailleurs ?', 'Oui, nous montons les pneus que vous apportez, y compris achetés en ligne, avec le même soin : équilibrage, valve et serrage au couple. Nous vérifions simplement qu’ils correspondent aux homologations de votre véhicule.' ),
			),
			'cta'       => 'Donnez-nous vos dimensions — elles figurent sur le flanc du pneu — et votre usage : vous recevez deux ou trois propositions chiffrées, sans engagement.',
		),
	);
}

/** Un pôle par son slug de page. */
function msms_service( string $slug ): ?array {
	$services = msms_services();
	return $services[ $slug ] ?? null;
}
