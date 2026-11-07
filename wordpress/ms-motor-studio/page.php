<?php
/**
 * Gabarit des pages simples (mentions légales, confidentialité…).
 *
 * @package ms-motor-studio
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="ms-hero ms-hero--page ms-hero--court">
		<div class="ms-hero-fond" aria-hidden="true"></div>
		<div class="ms-boite ms-hero-int">
			<div class="ms-hero-texte">
				<?php msms_fil_ariane( get_the_title() ); ?>
				<h1><span class="ms-ligne"><i><?php the_title(); ?></i></span></h1>
			</div>
		</div>
	</section>

	<section class="ms-section">
		<div class="ms-boite ms-prose">
			<?php the_content(); ?>
		</div>
	</section>
	<?php
endwhile;

get_footer();
