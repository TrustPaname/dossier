<?php
/**
 * Template Name: Prestation
 *
 * Page d'un pôle d'activité. Le contenu est lu dans inc/services.php
 * d'après le slug de la page (carrosserie-peinture, mecanique-entretien,
 * pare-brise-vitrage ou pneumatiques).
 *
 * @package ms-motor-studio
 */

get_header();

$slug    = get_post_field( 'post_name', get_queried_object_id() );
$service = msms_service( (string) $slug );

if ( ! $service ) :
	?>
	<section class="ms-section"><div class="ms-boite">
		<h1>Page de prestation non reconnue</h1>
		<p class="ms-texte">Cette page utilise le gabarit « Prestation » mais son identifiant « <?php echo esc_html( (string) $slug ); ?> » ne correspond à aucun pôle. Identifiants attendus : carrosserie-peinture, mecanique-entretien, pare-brise-vitrage, pneumatiques.</p>
	</div></section>
	<?php
	get_footer();
	return;
endif;

$services = msms_services();
$autres   = array_diff_key( $services, array( $slug => true ) );
?>

<!-- ───────────────────────── Ouverture ───────────────────────── -->
<section class="ms-hero ms-hero--page">
	<div class="ms-hero-fond" aria-hidden="true"></div>
	<span class="ms-hero-filigrane" aria-hidden="true"><?php echo esc_html( $service['index'] ); ?></span>
	<div class="ms-boite ms-hero-int">
		<div class="ms-hero-texte">
			<?php msms_fil_ariane( $service['titre'] ); ?>
			<?php msms_kicker( 'Prestation ' . $service['index'] . ' — ' . $service['kicker'] ); ?>
			<h1><span class="ms-ligne"><i><?php echo esc_html( $service['titre'] ); ?></i></span></h1>
			<p class="ms-hero-sous" data-anim><?php echo esc_html( $service['lead'] ); ?></p>
			<div class="ms-btn-rangee" data-anim>
				<?php msms_bouton_rdv(); ?>
				<?php msms_bouton( 'tel:' . msms_get( 'telephone_lien' ), msms_get( 'telephone' ), 'contour', false ); ?>
			</div>
		</div>
	</div>
</section>

<!-- ───────────────────────── Approche ───────────────────────── -->
<section class="ms-section">
	<div class="ms-boite ms-deux-colonnes">
		<div data-anim>
			<?php msms_kicker( 'Notre approche' ); ?>
			<?php foreach ( $service['intro'] as $paragraphe ) : ?>
			<p class="ms-texte"><?php echo esc_html( $paragraphe ); ?></p>
			<?php endforeach; ?>
		</div>
		<div data-anim>
			<?php msms_media_ou_reserve( $service['titre'] . ' — à l’atelier', '4/5' ); ?>
		</div>
	</div>
</section>

<!-- ───────────────────────── Déroulé ───────────────────────── -->
<section class="ms-section ms-section--carbone">
	<div class="ms-boite">
		<div class="ms-tete-section" data-anim>
			<?php msms_kicker( 'Comment ça se passe' ); ?>
			<h2>Le déroulé, étape par étape</h2>
		</div>
		<ol class="ms-etapes">
			<?php foreach ( $service['methode'] as $i => $etape ) : ?>
			<li class="ms-etape" data-anim>
				<span class="ms-etape-num" aria-hidden="true"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
				<h3><?php echo esc_html( $etape[0] ); ?></h3>
				<p><?php echo esc_html( $etape[1] ); ?></p>
			</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<!-- ───────────────────────── Prestations détaillées ───────────────────────── -->
<section class="ms-section">
	<div class="ms-boite">
		<div class="ms-tete-section" data-anim>
			<?php msms_kicker( 'Le détail' ); ?>
			<h2>Ce que comprend <span class="ms-or"><?php echo esc_html( mb_strtolower( $service['titre'] ) ); ?></span></h2>
		</div>
		<div class="ms-grille-prestations">
			<?php foreach ( $service['prestations'] as $i => $prestation ) : ?>
			<article class="ms-prestation" data-anim>
				<span class="ms-index"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
				<h3><?php echo esc_html( $prestation[0] ); ?></h3>
				<p><?php echo esc_html( $prestation[1] ); ?></p>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ───────────────────────── Bon à savoir ───────────────────────── -->
<section class="ms-section ms-section--carbone">
	<div class="ms-boite">
		<div class="ms-tete-section" data-anim>
			<?php msms_kicker( 'Bon à savoir' ); ?>
			<h2>Les conseils de l’atelier</h2>
		</div>
		<div class="ms-conseils">
			<?php foreach ( $service['conseils'] as $conseil ) : ?>
			<article class="ms-conseil" data-anim>
				<i class="ms-filet-or" aria-hidden="true"></i>
				<h3><?php echo esc_html( $conseil[0] ); ?></h3>
				<p><?php echo esc_html( $conseil[1] ); ?></p>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ───────────────────────── Questions fréquentes ───────────────────────── -->
<section class="ms-section">
	<div class="ms-boite">
		<div class="ms-tete-section" data-anim>
			<?php msms_kicker( 'Questions fréquentes' ); ?>
			<h2>Vos questions sur <span class="ms-or"><?php echo esc_html( mb_strtolower( $service['titre'] ) ); ?></span></h2>
		</div>
		<?php msms_faq_bloc( $service['faq'] ); ?>
	</div>
</section>

<!-- ───────────────────────── Autres prestations ───────────────────────── -->
<section class="ms-section ms-section--carbone">
	<div class="ms-boite">
		<div class="ms-tete-section" data-anim>
			<?php msms_kicker( 'Également à l’atelier' ); ?>
			<h2>Les autres prestations</h2>
		</div>
		<div class="ms-autres">
			<?php foreach ( $autres as $autre_slug => $autre ) : ?>
			<a class="ms-autre" href="<?php echo esc_url( msms_page_url( $autre_slug ) ); ?>" data-anim>
				<span class="ms-index"><?php echo esc_html( $autre['index'] ); ?></span>
				<strong><?php echo esc_html( $autre['titre'] ); ?></strong>
				<span><?php echo esc_html( $autre['kicker'] ); ?></span>
			</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
msms_cta_final( $service['titre'] . ' : parlons-en', $service['cta'] );
get_footer();
