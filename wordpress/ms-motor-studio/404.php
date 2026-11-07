<?php
/**
 * Page 404 personnalisée.
 *
 * @package ms-motor-studio
 */

get_header();
?>
<section class="ms-hero ms-hero--page">
	<div class="ms-hero-fond" aria-hidden="true"></div>
	<span class="ms-hero-filigrane" aria-hidden="true">404</span>
	<div class="ms-boite ms-hero-int">
		<div class="ms-hero-texte">
			<?php msms_kicker( 'Erreur 404' ); ?>
			<h1><span class="ms-ligne"><i>Cette page n’existe pas — ou plus.</i></span></h1>
			<p class="ms-hero-sous" data-anim>Le lien est peut-être incorrect. Reprenez depuis l’accueil, ou appelez directement l’atelier au <a class="ms-lien-or" href="tel:<?php echo esc_attr( msms_get( 'telephone_lien' ) ); ?>"><?php echo esc_html( msms_get( 'telephone' ) ); ?></a>.</p>
			<div class="ms-btn-rangee" data-anim>
				<?php msms_bouton( home_url( '/' ), 'Retour à l’accueil' ); ?>
				<?php msms_bouton_rdv( 'Prendre rendez-vous', 'contour' ); ?>
			</div>
		</div>
	</div>
</section>

<section class="ms-section">
	<div class="ms-boite">
		<div class="ms-autres">
			<?php foreach ( msms_services() as $slug => $service ) : ?>
			<a class="ms-autre" href="<?php echo esc_url( msms_page_url( $slug ) ); ?>">
				<span class="ms-index"><?php echo esc_html( $service['index'] ); ?></span>
				<strong><?php echo esc_html( $service['titre'] ); ?></strong>
				<span><?php echo esc_html( $service['kicker'] ); ?></span>
			</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php
get_footer();
