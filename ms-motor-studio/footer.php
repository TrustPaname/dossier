<?php
/**
 * Pied de page : plan du site, coordonnées et barre d'actions mobile.
 *
 * @package ms-motor-studio
 */
?>
</main>

<footer class="ms-pied">
	<div class="ms-boite">
		<div class="ms-pied-grille">
			<div>
				<p class="ms-pied-logo">
					<b aria-hidden="true">MS</b>
					<span>Motors <i>Studio</i></span>
				</p>
				<p class="ms-pied-texte">Carrosserie, mécanique, vitrage et pneumatiques à <?php echo esc_html( msms_get( 'adresse_ville' ) ); ?>, près de Chartres. Interventions sur rendez-vous.</p>
				<?php if ( msms_get( 'instagram' ) || msms_get( 'facebook' ) ) : ?>
				<p class="ms-pied-reseaux">
					<?php if ( msms_get( 'instagram' ) ) : ?><a href="<?php echo esc_url( msms_get( 'instagram' ) ); ?>" target="_blank" rel="noopener noreferrer">Instagram</a><?php endif; ?>
					<?php if ( msms_get( 'facebook' ) ) : ?><a href="<?php echo esc_url( msms_get( 'facebook' ) ); ?>" target="_blank" rel="noopener noreferrer">Facebook</a><?php endif; ?>
				</p>
				<?php endif; ?>
			</div>

			<nav aria-label="Prestations">
				<h2 class="ms-pied-titre">Prestations</h2>
				<ul>
					<?php foreach ( msms_services() as $slug => $service ) : ?>
					<li><a href="<?php echo esc_url( msms_page_url( $slug ) ); ?>"><?php echo esc_html( $service['titre'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</nav>

			<nav aria-label="Le garage">
				<h2 class="ms-pied-titre">Le garage</h2>
				<ul>
					<li><a href="<?php echo esc_url( msms_page_url( 'atelier' ) ); ?>">L’atelier</a></li>
					<li><a href="<?php echo esc_url( msms_page_url( 'contact' ) ); ?>">Contact et rendez-vous</a></li>
					<li><a href="<?php echo esc_url( msms_page_url( 'mentions-legales' ) ); ?>">Mentions légales</a></li>
					<li><a href="<?php echo esc_url( msms_page_url( 'politique-de-confidentialite' ) ); ?>">Politique de confidentialité</a></li>
				</ul>
			</nav>

			<div>
				<h2 class="ms-pied-titre">Atelier</h2>
				<address>
					<p><?php echo esc_html( msms_get( 'adresse_rue' ) ); ?><br><?php echo esc_html( msms_get( 'adresse_cp' ) . ' ' . msms_get( 'adresse_ville' ) ); ?></p>
					<p>
						<a class="ms-pied-tel" href="tel:<?php echo esc_attr( msms_get( 'telephone_lien' ) ); ?>"><?php echo esc_html( msms_get( 'telephone' ) ); ?></a><br>
						<a href="mailto:<?php echo esc_attr( msms_get( 'email' ) ); ?>"><?php echo esc_html( msms_get( 'email' ) ); ?></a>
					</p>
					<p class="ms-pied-horaires"><?php echo esc_html( msms_get( 'horaires_jours' ) ); ?><br><?php echo esc_html( msms_get( 'horaires_matin' ) ); ?> · <?php echo esc_html( msms_get( 'horaires_aprem' ) ); ?><br><?php echo esc_html( msms_get( 'horaires_ferme' ) ); ?></p>
					<a class="ms-lien-or" href="<?php echo esc_url( msms_itineraire_url() ); ?>" target="_blank" rel="noopener noreferrer">Itinéraire<?php echo msms_fleche(); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
				</address>
			</div>
		</div>

		<div class="ms-pied-filet" aria-hidden="true"></div>

		<div class="ms-pied-bas">
			<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( msms_get( 'nom' ) ); ?> — <?php echo esc_html( msms_adresse() ); ?></p>
			<p>Zone d’intervention : Mainvilliers, Chartres et l’Eure-et-Loir (28).</p>
		</div>
	</div>
</footer>

<div class="ms-barre-mobile" role="navigation" aria-label="Actions rapides">
	<a href="tel:<?php echo esc_attr( msms_get( 'telephone_lien' ) ); ?>">
		<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true"><path d="M2 3.6C2 2.7 2.7 2 3.6 2h1.2c.5 0 .9.3 1 .8l.6 2.2c.1.4 0 .8-.4 1l-1 .7a9 9 0 0 0 3.9 3.9l.7-1c.2-.3.6-.5 1-.4l2.2.6c.5.1.8.5.8 1v1.2c0 .9-.7 1.6-1.6 1.6A11.4 11.4 0 0 1 2 3.6Z"/></svg>
		Appeler
	</a>
	<a href="<?php echo esc_url( msms_itineraire_url() ); ?>" target="_blank" rel="noopener noreferrer">
		<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true"><path d="M8 14.5s5-4.6 5-8a5 5 0 0 0-10 0c0 3.4 5 8 5 8Z"/><circle cx="8" cy="6.4" r="1.9"/></svg>
		Itinéraire
	</a>
	<a class="ms-barre-mobile-rdv" href="<?php echo esc_url( msms_page_url( 'contact' ) ); ?>" data-rdv>
		<svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true"><rect x="2" y="3.2" width="12" height="10.8" rx="1.4"/><path d="M2 6.6h12M5.4 1.8v2.6M10.6 1.8v2.6" stroke-linecap="round"/></svg>
		Rendez-vous
	</a>
</div>

<?php msms_dialogue_rdv(); ?>
<?php wp_footer(); ?>
</body>
</html>
