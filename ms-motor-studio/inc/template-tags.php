<?php
/**
 * MS MOTORS STUDIO — petites fonctions d'affichage réutilisées par les gabarits.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Flèche fine utilisée sur les boutons et liens. */
function msms_fleche(): string {
	return '<svg class="ms-fleche" viewBox="0 0 20 8" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M0 4h18M14.5 1 18 4l-3.5 3" stroke-linecap="square"/></svg>';
}

/** Bouton lien. $style : 'plein' ou 'contour'. */
function msms_bouton( string $url, string $texte, string $style = 'plein', bool $fleche = true ): void {
	printf(
		'<a class="ms-btn ms-btn--%1$s" href="%2$s">%3$s%4$s</a>',
		esc_attr( $style ),
		esc_url( $url ),
		esc_html( $texte ),
		$fleche ? msms_fleche() : '' // phpcs:ignore WordPress.Security.EscapeOutput
	);
}

/**
 * Bouton de prise de rendez-vous.
 *
 * Le lien pointe vers la page de contact : sans JavaScript, il fonctionne
 * donc normalement. Avec JavaScript, l'attribut `data-rdv` déclenche
 * l'ouverture de la fenêtre laissant le choix entre appeler et remplir le
 * formulaire.
 */
function msms_bouton_rdv( string $texte = 'Prendre rendez-vous', string $style = 'plein', bool $fleche = true, string $classe = '' ): void {
	printf(
		'<a class="ms-btn ms-btn--%1$s%5$s" href="%2$s" data-rdv>%3$s%4$s</a>',
		esc_attr( $style ),
		esc_url( msms_page_url( 'contact' ) ),
		esc_html( $texte ),
		$fleche ? msms_fleche() : '', // phpcs:ignore WordPress.Security.EscapeOutput
		$classe ? ' ' . esc_attr( $classe ) : ''
	);
}

/** URL d'une page du site par son slug. */
function msms_page_url( string $slug ): string {
	$page = get_page_by_path( $slug );
	return $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
}

/** Étiquette de section : petit texte doré en capitales espacées. */
function msms_kicker( string $texte, bool $filet = true ): void {
	echo '<p class="ms-kicker">';
	if ( $filet ) {
		echo '<span class="ms-kicker-filet" aria-hidden="true"></span>';
	}
	echo esc_html( $texte ) . '</p>';
}

/** Fil d'Ariane simple. */
function msms_fil_ariane( string $courant ): void {
	echo '<nav class="ms-ariane" aria-label="Fil d’Ariane"><ol>';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">Accueil</a></li>';
	echo '<li aria-hidden="true">/</li>';
	echo '<li aria-current="page">' . esc_html( $courant ) . '</li>';
	echo '</ol></nav>';
}

/** Emplacement photo : affiché tant que l'image n'est pas fournie. */
function msms_media_reserve( string $legende, string $ratio = '4/3' ): void {
	echo '<figure class="ms-reserve" style="aspect-ratio:' . esc_attr( $ratio ) . '">';
	echo '<div class="ms-reserve-fond" aria-hidden="true">';
	echo '<svg viewBox="0 0 48 34" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M3 25V15l6-9h20l8 9h8v10" stroke-linecap="round" stroke-linejoin="round"/><circle cx="13" cy="26" r="4"/><circle cx="36" cy="26" r="4"/><path d="M17 26h15M3 20h4M41 20h4" stroke-linecap="round"/></svg>';
	echo '<span>Photo à venir</span>';
	echo '</div>';
	echo '<figcaption>' . esc_html( $legende ) . '</figcaption>';
	echo '</figure>';
}

/**
 * Image mise en avant de la page si elle existe, sinon emplacement réservé.
 * Permet de remplacer chaque visuel depuis l'administration WordPress
 * (Pages → modifier → Image mise en avant).
 */
function msms_media_ou_reserve( string $legende, string $ratio = '4/3' ): void {
	if ( has_post_thumbnail() ) {
		echo '<figure class="ms-figure" style="aspect-ratio:' . esc_attr( $ratio ) . '">';
		the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) );
		echo '<figcaption>' . esc_html( $legende ) . '</figcaption></figure>';
		return;
	}
	msms_media_reserve( $legende, $ratio );
}

/** Bloc d'appel final commun à toutes les pages. */
function msms_cta_final( string $titre = '', string $texte = '' ): void {
	$titre = $titre ?: 'Un devis, une question, un rendez-vous';
	$texte = $texte ?: 'Décrivez-nous votre besoin par téléphone ou depuis le formulaire de contact : nous revenons vers vous avec un créneau et le déroulé de l’intervention.';
	?>
	<section class="ms-cta-final">
		<div class="ms-boite">
			<div class="ms-cta-final-grille">
				<div data-anim>
					<?php msms_kicker( 'Prendre contact', false ); ?>
					<h2><?php echo esc_html( $titre ); ?></h2>
					<p><?php echo esc_html( $texte ); ?></p>
				</div>
				<div class="ms-cta-final-actions" data-anim>
					<a class="ms-cta-tel" href="tel:<?php echo esc_attr( msms_get( 'telephone_lien' ) ); ?>"><?php echo esc_html( msms_get( 'telephone' ) ); ?></a>
					<div class="ms-btn-rangee">
						<?php msms_bouton_rdv(); ?>
						<?php msms_bouton( msms_itineraire_url(), 'Itinéraire', 'contour' ); ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Fenêtre de prise de rendez-vous : appeler ou remplir le formulaire.
 * Affichée une seule fois, en bas de page.
 */
function msms_dialogue_rdv(): void {
	?>
	<dialog class="ms-rdv" id="ms-rdv" aria-labelledby="ms-rdv-titre">
		<div class="ms-rdv-int">
			<button type="button" class="ms-rdv-fermer" aria-label="Fermer">
				<svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="m1 1 12 12M13 1 1 13"/></svg>
			</button>

			<?php msms_kicker( 'Rendez-vous', false ); ?>
			<h2 id="ms-rdv-titre">Comment préférez-vous nous joindre ?</h2>
			<p class="ms-rdv-texte">Les deux mènent au même endroit : un créneau à l’atelier. À vous de choisir le plus pratique.</p>

			<div class="ms-rdv-choix">
				<a class="ms-rdv-option" href="tel:<?php echo esc_attr( msms_get( 'telephone_lien' ) ); ?>">
					<span class="ms-rdv-icone" aria-hidden="true">
						<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M2 3.6C2 2.7 2.7 2 3.6 2h1.2c.5 0 .9.3 1 .8l.6 2.2c.1.4 0 .8-.4 1l-1 .7a9 9 0 0 0 3.9 3.9l.7-1c.2-.3.6-.5 1-.4l2.2.6c.5.1.8.5.8 1v1.2c0 .9-.7 1.6-1.6 1.6A11.4 11.4 0 0 1 2 3.6Z"/></svg>
					</span>
					<strong>Appeler l’atelier</strong>
					<span class="ms-rdv-numero"><?php echo esc_html( msms_get( 'telephone' ) ); ?></span>
					<span class="ms-rdv-detail"><?php echo esc_html( msms_get( 'horaires_jours' ) ); ?> · <?php echo esc_html( msms_get( 'horaires_matin' ) ); ?> et <?php echo esc_html( msms_get( 'horaires_aprem' ) ); ?></span>
				</a>

				<a class="ms-rdv-option" href="<?php echo esc_url( msms_page_url( 'contact' ) ); ?>">
					<span class="ms-rdv-icone" aria-hidden="true">
						<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.2"><rect x="2.5" y="1.8" width="11" height="12.4" rx="1.2"/><path d="M5 5.4h6M5 8h6M5 10.6h3.5" stroke-linecap="round"/></svg>
					</span>
					<strong>Remplir le formulaire</strong>
					<span class="ms-rdv-numero">En ligne, à toute heure</span>
					<span class="ms-rdv-detail">Décrivez votre besoin et votre véhicule : nous vous rappelons pour fixer le créneau.</span>
				</a>
			</div>
		</div>
	</dialog>
	<?php
}

/** Accordéon de questions fréquentes. */
function msms_faq_bloc( array $faq ): void {
	echo '<div class="ms-faq">';
	foreach ( $faq as $item ) {
		echo '<details class="ms-faq-item" data-anim>';
		echo '<summary><span>' . esc_html( $item[0] ) . '</span><i aria-hidden="true"></i></summary>';
		echo '<p>' . esc_html( $item[1] ) . '</p>';
		echo '</details>';
	}
	echo '</div>';
}
