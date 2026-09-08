<?php
/**
 * En-tête du site : bandeau d'ouverture, navigation et actions.
 *
 * @package ms-motor-studio
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="ms-evitement" href="#contenu">Aller au contenu</a>

<?php if ( msms_promo_active() ) : ?>
<aside class="ms-promo" aria-label="Offre d’ouverture">
	<div class="ms-boite ms-promo-int">
		<p>
			<strong><?php echo esc_html( msms_get( 'promo_titre' ) ); ?></strong>
			<span class="ms-promo-sep" aria-hidden="true"></span>
			<span><?php echo esc_html( msms_get( 'promo_offre' ) ); ?>. <?php echo esc_html( msms_get( 'promo_detail' ) ); ?> <em><?php echo esc_html( msms_get( 'promo_legal' ) ); ?></em></span>
			<a href="<?php echo esc_url( msms_page_url( 'contact' ) ); ?>" data-rdv>Prendre rendez-vous</a>
		</p>
		<button type="button" class="ms-promo-fermer" aria-label="Masquer l’offre d’ouverture">
			<svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="m1 1 12 12M13 1 1 13"/></svg>
		</button>
	</div>
</aside>
<?php endif; ?>

<header class="ms-entete" id="ms-entete">
	<div class="ms-boite ms-entete-int">
		<a class="ms-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( msms_get( 'nom' ) ); ?> — accueil">
			<span class="ms-logo-ms">
				<svg class="ms-logo-arc" viewBox="0 0 120 22" aria-hidden="true" fill="none"><path d="M2 20C14 6 34 1 60 1s46 5 58 19" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
				<b>MS</b>
			</span>
			<span class="ms-logo-texte">
				<span class="ms-logo-motor">Motors</span>
				<span class="ms-logo-studio"><i aria-hidden="true"></i>Studio<i aria-hidden="true"></i></span>
			</span>
		</a>

		<nav class="ms-nav" aria-label="Navigation principale">
			<div class="ms-nav-groupe">
				<button type="button" class="ms-nav-lien ms-nav-declencheur" aria-expanded="false" aria-controls="ms-panneau">Prestations</button>
				<div class="ms-panneau" id="ms-panneau">
					<div class="ms-boite ms-panneau-grille">
						<?php foreach ( msms_services() as $slug => $service ) : ?>
						<a class="ms-panneau-carte" href="<?php echo esc_url( msms_page_url( $slug ) ); ?>">
							<span class="ms-index"><?php echo esc_html( $service['index'] ); ?></span>
							<strong><?php echo esc_html( $service['titre'] ); ?></strong>
							<span class="ms-panneau-desc"><?php echo esc_html( $service['kicker'] ); ?></span>
						</a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<a class="ms-nav-lien<?php echo is_page( 'atelier' ) ? ' est-actif' : ''; ?>" href="<?php echo esc_url( msms_page_url( 'atelier' ) ); ?>">L’atelier</a>
			<a class="ms-nav-lien<?php echo is_page( 'contact' ) ? ' est-actif' : ''; ?>" href="<?php echo esc_url( msms_page_url( 'contact' ) ); ?>">Contact</a>
			<a class="ms-nav-tel" href="tel:<?php echo esc_attr( msms_get( 'telephone_lien' ) ); ?>">
				<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true"><path d="M2 3.6C2 2.7 2.7 2 3.6 2h1.2c.5 0 .9.3 1 .8l.6 2.2c.1.4 0 .8-.4 1l-1 .7a9 9 0 0 0 3.9 3.9l.7-1c.2-.3.6-.5 1-.4l2.2.6c.5.1.8.5.8 1v1.2c0 .9-.7 1.6-1.6 1.6A11.4 11.4 0 0 1 2 3.6Z"/></svg>
				<?php echo esc_html( msms_get( 'telephone' ) ); ?>
			</a>
			<a class="ms-btn ms-btn--plein ms-btn--compact" href="<?php echo esc_url( msms_page_url( 'contact' ) ); ?>" data-rdv>Rendez-vous</a>
		</nav>

		<button type="button" class="ms-burger" aria-expanded="false" aria-controls="ms-menu-mobile" aria-label="Ouvrir le menu">
			<span></span><span></span>
		</button>
	</div>

	<div class="ms-menu-mobile" id="ms-menu-mobile" hidden>
		<nav aria-label="Navigation mobile">
			<?php foreach ( msms_services() as $slug => $service ) : ?>
			<a class="ms-menu-mobile-lien" href="<?php echo esc_url( msms_page_url( $slug ) ); ?>">
				<span class="ms-index"><?php echo esc_html( $service['index'] ); ?></span>
				<?php echo esc_html( $service['titre'] ); ?>
			</a>
			<?php endforeach; ?>
			<a class="ms-menu-mobile-lien" href="<?php echo esc_url( msms_page_url( 'atelier' ) ); ?>">L’atelier</a>
			<a class="ms-menu-mobile-lien" href="<?php echo esc_url( msms_page_url( 'contact' ) ); ?>">Contact</a>
			<div class="ms-menu-mobile-infos">
				<a href="tel:<?php echo esc_attr( msms_get( 'telephone_lien' ) ); ?>"><?php echo esc_html( msms_get( 'telephone' ) ); ?></a>
				<p><?php echo esc_html( msms_get( 'adresse_rue' ) ); ?><br><?php echo esc_html( msms_get( 'adresse_cp' ) . ' ' . msms_get( 'adresse_ville' ) ); ?></p>
				<p><?php echo esc_html( msms_get( 'horaires_jours' ) ); ?> · <?php echo esc_html( msms_get( 'horaires_matin' ) ); ?> et <?php echo esc_html( msms_get( 'horaires_aprem' ) ); ?></p>
			</div>
		</nav>
	</div>
</header>

<main id="contenu">
