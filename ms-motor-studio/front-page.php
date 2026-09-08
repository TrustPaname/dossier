<?php
/**
 * Page d'accueil.
 *
 * @package ms-motor-studio
 */

get_header();
$accueil  = msms_accueil();
$services = msms_services();
$flyers   = msms_flyers();
?>

<!-- ───────────────────────── Grand écran d'ouverture ───────────────────────── -->
<?php $video_sources = msms_video_sources(); ?>
<section class="ms-hero<?php echo $video_sources ? ' ms-hero--video' : ''; ?><?php echo $flyers ? ' ms-hero--flyers' : ''; ?>">
	<?php if ( $video_sources ) : ?>
	<video class="ms-hero-video" data-fond autoplay muted loop playsinline preload="metadata" disablepictureinpicture aria-hidden="true">
		<?php foreach ( $video_sources as $source ) : ?>
		<source src="<?php echo esc_url( $source[0] ); ?>" type="<?php echo esc_attr( $source[1] ); ?>">
		<?php endforeach; ?>
	</video>
	<?php endif; ?>
	<div class="ms-hero-fond" aria-hidden="true"></div>
	<div class="ms-boite ms-hero-int">
		<div class="ms-hero-texte">
			<?php msms_kicker( msms_promo_active() ? msms_get( 'promo_titre' ) . ' · ' . msms_get( 'adresse_ville' ) : 'Atelier automobile · ' . msms_get( 'adresse_ville' ) ); ?>
			<h1>
				<span class="ms-ligne"><i><?php echo esc_html( $accueil['hero_titre_1'] ); ?></i></span>
				<span class="ms-ligne"><i><?php echo esc_html( $accueil['hero_titre_2'] ); ?></i></span>
			</h1>
			<p class="ms-hero-sous" data-anim><?php echo esc_html( $accueil['hero_texte'] ); ?></p>
			<div class="ms-btn-rangee" data-anim>
				<?php msms_bouton_rdv(); ?>
				<?php msms_bouton( '#prestations', 'Découvrir nos services', 'contour' ); ?>
			</div>
		</div>

		<?php if ( $flyers ) : ?>
		<div class="ms-flyers" data-flyers data-duree="<?php echo esc_attr( max( 2, (int) msms_get( 'flyers_duree' ) ) ); ?>" data-anim>
			<div class="ms-flyers-cadre">
				<div class="ms-flyers-piste">
					<?php foreach ( $flyers as $index => $flyer ) : ?>
					<figure class="ms-flyer">
						<img
							src="<?php echo esc_url( $flyer ); ?>"
							alt="Flyer d’ouverture <?php echo esc_attr( msms_get( 'nom' ) ); ?> — visuel <?php echo (int) ( $index + 1 ); ?>"
							loading="<?php echo 0 === $index ? 'eager' : 'lazy'; ?>">
					</figure>
					<?php endforeach; ?>
				</div>
			</div>

			<?php if ( count( $flyers ) > 1 ) : ?>
			<div class="ms-flyers-points" role="tablist" aria-label="Choisir un visuel">
				<?php foreach ( $flyers as $index => $flyer ) : ?>
				<button type="button" role="tab"
					class="<?php echo 0 === $index ? 'est-actif' : ''; ?>"
					data-index="<?php echo (int) $index; ?>"
					aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>"
					aria-label="Visuel <?php echo (int) ( $index + 1 ); ?>"></button>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
		<?php else : ?>
		<aside class="ms-hero-carte" data-anim aria-label="Informations pratiques">
			<div class="ms-hero-carte-ligne">
				<span>Atelier</span>
				<p><?php echo esc_html( msms_get( 'adresse_rue' ) ); ?><br><?php echo esc_html( msms_get( 'adresse_cp' ) . ' ' . msms_get( 'adresse_ville' ) ); ?></p>
			</div>
			<div class="ms-hero-carte-ligne">
				<span>Horaires</span>
				<p><?php echo esc_html( msms_get( 'horaires_jours' ) ); ?><br><?php echo esc_html( msms_get( 'horaires_matin' ) ); ?> · <?php echo esc_html( msms_get( 'horaires_aprem' ) ); ?></p>
			</div>
			<div class="ms-hero-carte-ligne">
				<span>Téléphone</span>
				<p><a href="tel:<?php echo esc_attr( msms_get( 'telephone_lien' ) ); ?>"><?php echo esc_html( msms_get( 'telephone' ) ); ?></a></p>
			</div>
			<a class="ms-lien-or" href="<?php echo esc_url( msms_itineraire_url() ); ?>" target="_blank" rel="noopener noreferrer">Itinéraire<?php echo msms_fleche(); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
		</aside>
		<?php endif; ?>
	</div>
	<div class="ms-hero-indicateur" aria-hidden="true"><span>Défiler</span><i></i></div>
</section>

<?php if ( $flyers ) : ?>
<!-- ─────────────── Informations pratiques (déplacées sous le hero) ─────────────── -->
<section class="ms-infos-bande">
	<div class="ms-boite ms-infos-bande-grille">
		<div><span>Atelier</span><p><?php echo esc_html( msms_adresse() ); ?></p></div>
		<div><span>Horaires</span><p><?php echo esc_html( msms_get( 'horaires_jours' ) ); ?> · <?php echo esc_html( msms_get( 'horaires_matin' ) ); ?> et <?php echo esc_html( msms_get( 'horaires_aprem' ) ); ?></p></div>
		<div><span>Téléphone</span><p><a href="tel:<?php echo esc_attr( msms_get( 'telephone_lien' ) ); ?>"><?php echo esc_html( msms_get( 'telephone' ) ); ?></a></p></div>
		<div><a class="ms-lien-or" href="<?php echo esc_url( msms_itineraire_url() ); ?>" target="_blank" rel="noopener noreferrer">Itinéraire<?php echo msms_fleche(); // phpcs:ignore WordPress.Security.EscapeOutput ?></a></div>
	</div>
</section>
<?php endif; ?>

<!-- ───────────────────────── Les quatre pôles ───────────────────────── -->
<section class="ms-section" id="prestations">
	<div class="ms-boite">
		<div class="ms-tete-section" data-anim>
			<?php msms_kicker( 'Nos prestations' ); ?>
			<h2><?php echo esc_html( $accueil['poles_titre'] ); ?></h2>
			<p class="ms-chapeau"><?php echo esc_html( $accueil['poles_texte'] ); ?></p>
		</div>

		<div class="ms-poles">
			<?php foreach ( $services as $slug => $service ) : ?>
			<a class="ms-pole" href="<?php echo esc_url( msms_page_url( $slug ) ); ?>" data-anim>
				<span class="ms-pole-index" aria-hidden="true"><?php echo esc_html( $service['index'] ); ?></span>
				<span class="ms-pole-corps">
					<span class="ms-pole-kicker"><?php echo esc_html( $service['kicker'] ); ?></span>
					<strong><?php echo esc_html( $service['titre'] ); ?></strong>
					<span class="ms-pole-texte"><?php echo esc_html( $accueil['poles_teaser'][ $slug ] ); ?></span>
				</span>
				<span class="ms-pole-fleche" aria-hidden="true"><?php echo msms_fleche(); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
			</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ───────────────────────── Bande de repères ───────────────────────── -->
<section class="ms-bande">
	<div class="ms-boite ms-bande-grille">
		<?php foreach ( $accueil['chiffres'] as $chiffre ) : ?>
		<div class="ms-bande-item" data-anim>
			<b><?php echo esc_html( $chiffre[0] ); ?></b>
			<span><?php echo esc_html( $chiffre[1] ); ?></span>
		</div>
		<?php endforeach; ?>
	</div>
</section>

<!-- ───────────────────────── Savoir-faire ───────────────────────── -->
<section class="ms-section ms-section--carbone">
	<div class="ms-boite ms-deux-colonnes">
		<div data-anim>
			<?php msms_kicker( 'L’atelier' ); ?>
			<h2><?php echo esc_html( $accueil['savoir_titre'] ); ?></h2>
			<?php foreach ( $accueil['savoir_texte'] as $paragraphe ) : ?>
			<p class="ms-texte"><?php echo esc_html( $paragraphe ); ?></p>
			<?php endforeach; ?>
			<div class="ms-btn-rangee">
				<?php msms_bouton( msms_page_url( 'atelier' ), 'Découvrir l’atelier', 'contour' ); ?>
			</div>
		</div>
		<div data-anim>
			<?php msms_media_ou_reserve( 'L’atelier en activité', '4/5' ); ?>
		</div>
	</div>
</section>

<!-- ───────────────────────── Méthode ───────────────────────── -->
<section class="ms-section">
	<div class="ms-boite">
		<div class="ms-tete-section" data-anim>
			<?php msms_kicker( 'Méthode' ); ?>
			<h2>La prise en charge de votre véhicule</h2>
			<p class="ms-chapeau">Quatre étapes, toujours dans le même ordre. Vous savez à chaque instant où en est votre voiture, ce qui a été décidé et pourquoi.</p>
		</div>
		<ol class="ms-etapes">
			<?php foreach ( msms_methode() as $i => $etape ) : ?>
			<li class="ms-etape" data-anim>
				<span class="ms-etape-num" aria-hidden="true"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
				<h3><?php echo esc_html( $etape[0] ); ?></h3>
				<p><?php echo esc_html( $etape[1] ); ?></p>
			</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<!-- ───────────────────────── Engagements ───────────────────────── -->
<section class="ms-section ms-section--carbone">
	<div class="ms-boite ms-deux-colonnes ms-deux-colonnes--inverse">
		<div data-anim>
			<?php msms_kicker( 'Engagements' ); ?>
			<h2>Ce que nous vous devons</h2>
			<p class="ms-texte">Des règles simples, appliquées à chaque véhicule qui entre à l’atelier — et vérifiables par vous à chaque restitution.</p>
		</div>
		<ul class="ms-engagements">
			<?php foreach ( msms_engagements() as $engagement ) : ?>
			<li data-anim>
				<i class="ms-filet-or" aria-hidden="true"></i>
				<h3><?php echo esc_html( $engagement[0] ); ?></h3>
				<p><?php echo esc_html( $engagement[1] ); ?></p>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<!-- ───────────────────────── Zone d'intervention ───────────────────────── -->
<section class="ms-section">
	<div class="ms-boite ms-deux-colonnes">
		<div data-anim>
			<?php msms_kicker( 'Zone d’intervention' ); ?>
			<h2><?php echo esc_html( $accueil['zone_titre'] ); ?></h2>
			<p class="ms-texte"><?php echo esc_html( $accueil['zone_texte'] ); ?></p>
		</div>
		<ul class="ms-villes" data-anim>
			<?php foreach ( $accueil['zone_villes'] as $i => $ville ) : ?>
			<li><span class="ms-index"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span><?php echo esc_html( $ville ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<!-- ───────────────────────── Questions fréquentes ───────────────────────── -->
<section class="ms-section ms-section--carbone">
	<div class="ms-boite">
		<div class="ms-tete-section" data-anim>
			<?php msms_kicker( 'Questions fréquentes' ); ?>
			<h2>Avant de venir</h2>
		</div>
		<?php msms_faq_bloc( msms_faq_generale() ); ?>
	</div>
</section>

<!-- ───────────────────────── Coordonnées et carte ───────────────────────── -->
<section class="ms-section">
	<div class="ms-boite ms-deux-colonnes">
		<div data-anim>
			<?php msms_kicker( 'Nous trouver' ); ?>
			<h2>L’atelier, <span class="ms-or"><?php echo esc_html( msms_get( 'adresse_rue' ) ); ?></span></h2>
			<p class="ms-texte">À <?php echo esc_html( msms_get( 'adresse_ville' ) ); ?>, à quelques minutes du centre de Chartres. Les interventions se font sur rendez-vous, par téléphone ou directement sur place.</p>
			<dl class="ms-coordonnees">
				<div><dt>Adresse</dt><dd><?php echo esc_html( msms_get( 'adresse_rue' ) ); ?><br><?php echo esc_html( msms_get( 'adresse_cp' ) . ' ' . msms_get( 'adresse_ville' ) ); ?></dd></div>
				<div><dt>Horaires</dt><dd><?php echo esc_html( msms_get( 'horaires_jours' ) ); ?><br><?php echo esc_html( msms_get( 'horaires_matin' ) ); ?> · <?php echo esc_html( msms_get( 'horaires_aprem' ) ); ?></dd></div>
				<div><dt>Téléphone</dt><dd><a class="ms-coordonnees-tel" href="tel:<?php echo esc_attr( msms_get( 'telephone_lien' ) ); ?>"><?php echo esc_html( msms_get( 'telephone' ) ); ?></a></dd></div>
				<div><dt>E-mail</dt><dd><a href="mailto:<?php echo esc_attr( msms_get( 'email' ) ); ?>"><?php echo esc_html( msms_get( 'email' ) ); ?></a></dd></div>
			</dl>
			<div class="ms-btn-rangee">
				<?php msms_bouton_rdv(); ?>
				<?php msms_bouton( msms_itineraire_url(), 'Itinéraire', 'contour' ); ?>
			</div>
		</div>
		<div class="ms-carte" data-anim>
			<iframe src="<?php echo esc_url( msms_carte_url() ); ?>" title="Carte — <?php echo esc_attr( msms_get( 'nom' ) . ', ' . msms_adresse() ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			<p class="ms-carte-source">Carte OpenStreetMap. <a href="<?php echo esc_url( msms_itineraire_url() ); ?>" target="_blank" rel="noopener noreferrer">Ouvrir l’itinéraire</a></p>
		</div>
	</div>
</section>

<?php
msms_cta_final();
get_footer();
