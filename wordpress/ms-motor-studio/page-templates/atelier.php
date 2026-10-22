<?php
/**
 * Template Name: L'atelier
 *
 * @package ms-motor-studio
 */

get_header();
$atelier = msms_atelier();
?>

<section class="ms-hero ms-hero--page">
	<div class="ms-hero-fond" aria-hidden="true"></div>
	<div class="ms-boite ms-hero-int">
		<div class="ms-hero-texte">
			<?php msms_fil_ariane( 'L’atelier' ); ?>
			<?php msms_kicker( 'Qui nous sommes' ); ?>
			<h1><span class="ms-ligne"><i><?php echo esc_html( $atelier['titre'] ); ?></i></span></h1>
			<p class="ms-hero-sous" data-anim><?php echo esc_html( $atelier['lead'] ); ?></p>
		</div>
	</div>
</section>

<section class="ms-section">
	<div class="ms-boite ms-deux-colonnes">
		<div data-anim>
			<?php msms_kicker( 'L’idée' ); ?>
			<?php foreach ( $atelier['texte'] as $paragraphe ) : ?>
			<p class="ms-texte"><?php echo esc_html( $paragraphe ); ?></p>
			<?php endforeach; ?>
		</div>
		<div data-anim>
			<?php msms_media_ou_reserve( 'La façade de l’atelier', '4/5' ); ?>
		</div>
	</div>
</section>

<section class="ms-section ms-section--carbone">
	<div class="ms-boite">
		<div class="ms-tete-section" data-anim>
			<?php msms_kicker( 'Les lieux' ); ?>
			<h2>Les postes de travail</h2>
			<p class="ms-chapeau">Chaque intervention se déroule au poste qui lui correspond, avec l’outillage adapté et dans les conditions qu’elle exige.</p>
		</div>
		<div class="ms-grille-prestations">
			<?php foreach ( $atelier['postes'] as $i => $poste ) : ?>
			<article class="ms-prestation" data-anim>
				<span class="ms-index"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
				<h3><?php echo esc_html( $poste[0] ); ?></h3>
				<p><?php echo esc_html( $poste[1] ); ?></p>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="ms-section">
	<div class="ms-boite">
		<div class="ms-tete-section" data-anim>
			<?php msms_kicker( 'En images' ); ?>
			<h2>L’atelier au quotidien</h2>
			<p class="ms-chapeau">Les photos réelles de l’atelier, des équipements et de l’équipe prendront place ici — ajoutez-les depuis la médiathèque WordPress.</p>
		</div>
		<div class="ms-galerie">
			<?php foreach ( $atelier['galerie'] as $i => $legende ) : ?>
			<div data-anim><?php msms_media_reserve( $legende, 0 === $i % 5 ? '3/4' : '4/3' ); ?></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="ms-section ms-section--carbone">
	<div class="ms-boite ms-deux-colonnes ms-deux-colonnes--inverse">
		<div data-anim>
			<?php msms_kicker( 'Engagements' ); ?>
			<h2>Ce que nous vous devons</h2>
			<p class="ms-texte">Des règles simples, appliquées à chaque véhicule qui entre à l’atelier.</p>
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

<?php
msms_cta_final();
get_footer();
