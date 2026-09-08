<?php
/**
 * Template Name: Contact et rendez-vous
 *
 * @package ms-motor-studio
 */

get_header();

$message = isset( $_GET['msg'] ) ? sanitize_key( wp_unslash( $_GET['msg'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
?>

<section class="ms-hero ms-hero--page">
	<div class="ms-hero-fond" aria-hidden="true"></div>
	<div class="ms-boite ms-hero-int">
		<div class="ms-hero-texte">
			<?php msms_fil_ariane( 'Contact' ); ?>
			<?php msms_kicker( 'Rendez-vous' ); ?>
			<h1><span class="ms-ligne"><i>Prenons rendez-vous</i></span></h1>
			<p class="ms-hero-sous" data-anim>Par téléphone pour une réponse immédiate, ou par le formulaire ci-dessous. Plus votre description est précise — symptôme, modèle, disponibilités —, plus notre réponse le sera.</p>
			<div class="ms-btn-rangee" data-anim>
				<?php msms_bouton( 'tel:' . msms_get( 'telephone_lien' ), 'Appeler ' . msms_get( 'telephone' ), 'plein', false ); ?>
				<?php msms_bouton( msms_itineraire_url(), 'Itinéraire', 'contour' ); ?>
			</div>
		</div>
	</div>
</section>

<section class="ms-section">
	<div class="ms-boite ms-contact-grille">
		<div data-anim>
			<h2 class="ms-h2-simple">Demande de rendez-vous</h2>
			<p class="ms-texte">Nous revenons vers vous par téléphone, du lundi au samedi, pendant les heures d’ouverture de l’atelier.</p>

			<?php if ( 'merci' === $message ) : ?>
			<div class="ms-avis ms-avis--ok" role="status">
				<strong>Merci, votre demande est bien partie.</strong>
				<p>Nous vous rappelons pour convenir d’un créneau. Pour une demande urgente, appelez directement l’atelier au <a href="tel:<?php echo esc_attr( msms_get( 'telephone_lien' ) ); ?>"><?php echo esc_html( msms_get( 'telephone' ) ); ?></a>.</p>
			</div>
			<?php elseif ( 'champs' === $message ) : ?>
			<div class="ms-avis ms-avis--erreur" role="alert">
				<strong>Certains champs sont incomplets.</strong>
				<p>Vérifiez votre nom, votre numéro de téléphone, votre message (dix caractères minimum) et la case de consentement, puis renvoyez la demande.</p>
			</div>
			<?php elseif ( 'limite' === $message ) : ?>
			<div class="ms-avis ms-avis--erreur" role="alert">
				<strong>Trop de demandes envoyées.</strong>
				<p>Merci de nous appeler directement au <a href="tel:<?php echo esc_attr( msms_get( 'telephone_lien' ) ); ?>"><?php echo esc_html( msms_get( 'telephone' ) ); ?></a>.</p>
			</div>
			<?php elseif ( 'erreur' === $message ) : ?>
			<div class="ms-avis ms-avis--erreur" role="alert">
				<strong>L’envoi a échoué.</strong>
				<p>Rechargez la page et réessayez, ou appelez-nous directement.</p>
			</div>
			<?php endif; ?>

			<?php if ( 'merci' !== $message ) : ?>
			<form class="ms-formulaire" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="msms_contact">
				<?php wp_nonce_field( 'msms_contact', 'msms_nonce' ); ?>

				<div class="ms-form-grille">
					<p class="ms-champ">
						<label for="msms_nom">Nom et prénom *</label>
						<input type="text" id="msms_nom" name="msms_nom" required minlength="2" maxlength="120" autocomplete="name" placeholder="Votre nom">
					</p>
					<p class="ms-champ">
						<label for="msms_telephone">Téléphone *</label>
						<input type="tel" id="msms_telephone" name="msms_telephone" required pattern="[+0-9][0-9 .\-()]{7,19}" autocomplete="tel" placeholder="06 00 00 00 00">
					</p>
					<p class="ms-champ">
						<label for="msms_email">E-mail</label>
						<input type="email" id="msms_email" name="msms_email" maxlength="160" autocomplete="email" placeholder="vous@exemple.fr">
					</p>
					<p class="ms-champ">
						<label for="msms_prestation">Prestation *</label>
						<select id="msms_prestation" name="msms_prestation" required>
							<option value="" disabled selected>Choisir une prestation</option>
							<?php foreach ( msms_services() as $service ) : ?>
							<option value="<?php echo esc_attr( $service['titre'] ); ?>"><?php echo esc_html( $service['titre'] ); ?></option>
							<?php endforeach; ?>
							<option value="Autre demande">Autre demande</option>
						</select>
					</p>
					<p class="ms-champ">
						<label for="msms_vehicule">Véhicule</label>
						<input type="text" id="msms_vehicule" name="msms_vehicule" maxlength="160" placeholder="Marque, modèle, année">
					</p>
					<p class="ms-champ">
						<label for="msms_plaque">Immatriculation (facultatif)</label>
						<input type="text" id="msms_plaque" name="msms_plaque" maxlength="20" placeholder="AA-123-AA">
					</p>
				</div>

				<p class="ms-champ">
					<label for="msms_message">Votre demande *</label>
					<textarea id="msms_message" name="msms_message" rows="6" required minlength="10" maxlength="4000" placeholder="Décrivez le besoin : nature des dégâts, entretien souhaité, symptôme, disponibilités…"></textarea>
				</p>

				<p class="ms-note">Des photos aident à préparer le devis : envoyez-les par e-mail à <a href="mailto:<?php echo esc_attr( msms_get( 'email' ) ); ?>"><?php echo esc_html( msms_get( 'email' ) ); ?></a> en rappelant votre nom.</p>

				<p class="ms-piege" aria-hidden="true">
					<label for="msms_societe">Société</label>
					<input type="text" id="msms_societe" name="msms_societe" tabindex="-1" autocomplete="off">
				</p>

				<p class="ms-consentement">
					<input type="checkbox" id="msms_consentement" name="msms_consentement" required>
					<label for="msms_consentement">J’accepte que les informations transmises soient utilisées par <?php echo esc_html( msms_get( 'nom' ) ); ?> pour traiter ma demande de rendez-vous. Elles ne sont ni revendues ni utilisées à des fins publicitaires. <a href="<?php echo esc_url( msms_page_url( 'politique-de-confidentialite' ) ); ?>">Politique de confidentialité</a>.</label>
				</p>

				<p class="ms-form-pied">
					<button type="submit" class="ms-btn ms-btn--plein">Envoyer la demande<?php echo msms_fleche(); // phpcs:ignore WordPress.Security.EscapeOutput ?></button>
					<span>* Champs obligatoires</span>
				</p>
			</form>
			<?php endif; ?>
		</div>

		<aside data-anim>
			<div class="ms-encart">
				<h2 class="ms-pied-titre">L’atelier</h2>
				<address>
					<div class="ms-encart-ligne"><span>Adresse</span><p><?php echo esc_html( msms_get( 'adresse_rue' ) ); ?><br><?php echo esc_html( msms_get( 'adresse_cp' ) . ' ' . msms_get( 'adresse_ville' ) ); ?></p></div>
					<div class="ms-encart-ligne"><span>Téléphone</span><p><a class="ms-coordonnees-tel" href="tel:<?php echo esc_attr( msms_get( 'telephone_lien' ) ); ?>"><?php echo esc_html( msms_get( 'telephone' ) ); ?></a></p></div>
					<div class="ms-encart-ligne"><span>E-mail</span><p><a href="mailto:<?php echo esc_attr( msms_get( 'email' ) ); ?>"><?php echo esc_html( msms_get( 'email' ) ); ?></a></p></div>
					<div class="ms-encart-ligne"><span>Horaires</span><p><?php echo esc_html( msms_get( 'horaires_jours' ) ); ?><br><?php echo esc_html( msms_get( 'horaires_matin' ) ); ?> · <?php echo esc_html( msms_get( 'horaires_aprem' ) ); ?><br><?php echo esc_html( msms_get( 'horaires_ferme' ) ); ?></p></div>
				</address>
			</div>
			<div class="ms-carte">
				<iframe src="<?php echo esc_url( msms_carte_url() ); ?>" title="Carte — <?php echo esc_attr( msms_get( 'nom' ) . ', ' . msms_adresse() ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
				<p class="ms-carte-source">Carte OpenStreetMap. <a href="<?php echo esc_url( msms_itineraire_url() ); ?>" target="_blank" rel="noopener noreferrer">Ouvrir l’itinéraire</a></p>
			</div>
		</aside>
	</div>
</section>

<section class="ms-section ms-section--carbone">
	<div class="ms-boite">
		<div class="ms-tete-section" data-anim>
			<?php msms_kicker( 'Questions fréquentes' ); ?>
			<h2>Avant de venir</h2>
		</div>
		<?php msms_faq_bloc( msms_faq_generale() ); ?>
	</div>
</section>

<?php get_footer(); ?>
