<?php
/**
 * Gabarit de repli : renvoie sur le gabarit de page ou la liste minimale.
 *
 * @package ms-motor-studio
 */

get_header();
?>
<section class="ms-section">
	<div class="ms-boite ms-prose">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				?>
				<article>
					<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					<?php the_excerpt(); ?>
				</article>
				<?php
			endwhile;
		else :
			?>
			<h1>Aucun contenu</h1>
			<p>Cette adresse ne correspond à aucun contenu publié.</p>
			<?php
		endif;
		?>
	</div>
</section>
<?php
get_footer();
