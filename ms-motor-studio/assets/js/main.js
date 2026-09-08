/**
 * MS MOTORS STUDIO — interactions du thème.
 * Sans JavaScript, le site reste entièrement lisible et navigable :
 * ce script n'ajoute que le confort (menu mobile, panneau, révélations).
 */
(function () {
	"use strict";

	var docEl = document.documentElement;
	var reduit = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

	/* ── En-tête : fond opaque après défilement ─────────────────────────── */
	var entete = document.getElementById("ms-entete");
	if (entete) {
		var majEntete = function () {
			entete.classList.toggle("est-figee", window.scrollY > 24);
		};
		majEntete();
		window.addEventListener("scroll", majEntete, { passive: true });
	}

	/* ── Bandeau promo : masquage pour la durée de la visite ────────────── */
	var promo = document.querySelector(".ms-promo");
	if (promo) {
		try {
			if (sessionStorage.getItem("msms-promo") === "1") promo.hidden = true;
		} catch (e) { /* stockage indisponible : le bandeau reste affiché */ }
		var fermer = promo.querySelector(".ms-promo-fermer");
		if (fermer) {
			fermer.addEventListener("click", function () {
				promo.hidden = true;
				try { sessionStorage.setItem("msms-promo", "1"); } catch (e) { /* sans gravité */ }
			});
		}
	}

	/* ── Menu mobile ────────────────────────────────────────────────────── */
	var burger = document.querySelector(".ms-burger");
	var menu = document.getElementById("ms-menu-mobile");
	if (burger && menu) {
		burger.addEventListener("click", function () {
			var ouvert = burger.getAttribute("aria-expanded") === "true";
			burger.setAttribute("aria-expanded", String(!ouvert));
			burger.setAttribute("aria-label", ouvert ? "Ouvrir le menu" : "Fermer le menu");
			menu.hidden = ouvert;
			if (entete) entete.classList.toggle("est-ouvert", !ouvert);
			document.body.style.overflow = ouvert ? "" : "hidden";
		});
	}

	/* ── Panneau « Prestations » (bureau) ───────────────────────────────── */
	var groupe = document.querySelector(".ms-nav-groupe");
	var declencheur = document.querySelector(".ms-nav-declencheur");
	if (groupe && declencheur) {
		declencheur.addEventListener("click", function () {
			var ouvert = groupe.classList.toggle("est-ouvert");
			declencheur.setAttribute("aria-expanded", String(ouvert));
		});
		document.addEventListener("click", function (e) {
			if (!groupe.contains(e.target)) {
				groupe.classList.remove("est-ouvert");
				declencheur.setAttribute("aria-expanded", "false");
			}
		});
	}

	/* ── Fermeture au clavier ───────────────────────────────────────────── */
	document.addEventListener("keydown", function (e) {
		if (e.key !== "Escape") return;
		if (groupe) {
			groupe.classList.remove("est-ouvert");
			if (declencheur) declencheur.setAttribute("aria-expanded", "false");
		}
		if (burger && menu && !menu.hidden) burger.click();
	});

	/* ── Vidéo d'arrière-plan ───────────────────────────────────────────── */
	document.querySelectorAll("video[data-fond]").forEach(function (video) {
		if (reduit) {
			// Animations réduites : la vidéo reste sur sa première image.
			video.removeAttribute("autoplay");
			video.pause();
			return;
		}
		// Certains navigateurs bloquent la lecture automatique : on réessaie
		// une fois la vidéo prête, toujours sans le son.
		var lire = function () { var p = video.play(); if (p) p.catch(function () {}); };
		video.addEventListener("canplay", lire);
		lire();
	});

	/* ── Fenêtre de prise de rendez-vous ────────────────────────────────── */
	var dialogue = document.getElementById("ms-rdv");
	// Sur la page qui porte déjà le formulaire, les boutons continuent d'y
	// mener directement : ouvrir la fenêtre n'aurait pas de sens.
	var surFormulaire = !!document.querySelector(".ms-formulaire");

	if (dialogue && typeof dialogue.showModal === "function" && !surFormulaire) {
		document.addEventListener("click", function (e) {
			var lien = e.target.closest("[data-rdv]");
			if (!lien) return;
			e.preventDefault();
			dialogue.showModal();
		});

		var fermer = dialogue.querySelector(".ms-rdv-fermer");
		if (fermer) fermer.addEventListener("click", function () { dialogue.close(); });

		// Clic en dehors du cadre : on referme.
		dialogue.addEventListener("click", function (e) {
			var r = dialogue.getBoundingClientRect();
			var dedans = e.clientX >= r.left && e.clientX <= r.right &&
			             e.clientY >= r.top && e.clientY <= r.bottom;
			if (!dedans) dialogue.close();
		});
	}

	/* ── Carrousel de flyers ────────────────────────────────────────────── */
	document.querySelectorAll("[data-flyers]").forEach(function (carrousel) {
		var piste = carrousel.querySelector(".ms-flyers-piste");
		var points = carrousel.querySelectorAll(".ms-flyers-points button");
		if (!piste) return;

		var total = piste.querySelectorAll(".ms-flyer").length;
		if (total < 2) return;

		// Un clone du premier visuel est ajouté en fin de piste : le défilement
		// se poursuit ainsi toujours vers la gauche, sans retour en arrière
		// visible au moment de reboucler.
		var clone = piste.querySelector(".ms-flyer").cloneNode(true);
		clone.setAttribute("aria-hidden", "true");
		piste.appendChild(clone);

		var index = 0;
		var minuteur = null;
		var duree = (parseInt(carrousel.getAttribute("data-duree"), 10) || 5) * 1000;

		function majPoints() {
			var reel = index % total;
			points.forEach(function (point, i) {
				point.classList.toggle("est-actif", i === reel);
				point.setAttribute("aria-selected", i === reel ? "true" : "false");
			});
		}

		function aller(cible, anime) {
			index = cible;
			piste.style.transition = anime ? "" : "none";
			piste.style.transform = "translateX(-" + index * 100 + "%)";
			if (!anime) {
				void piste.offsetWidth; // force le recalcul avant de rétablir la transition
				piste.style.transition = "";
			}
			majPoints();
		}

		// Arrivé sur le clone, on revient au premier visuel sans animation :
		// le saut est invisible puisque l'image affichée est la même.
		piste.addEventListener("transitionend", function (e) {
			if (e.propertyName === "transform" && index >= total) aller(0, false);
		});

		function lancer() {
			if (reduit) return; // animations réduites : pas de défilement automatique
			arreter();
			minuteur = setInterval(function () { aller(index + 1, true); }, duree);
		}
		function arreter() {
			if (minuteur) { clearInterval(minuteur); minuteur = null; }
		}

		points.forEach(function (point) {
			point.addEventListener("click", function () {
				var cible = parseInt(point.getAttribute("data-index"), 10) || 0;
				if (index >= total) aller(0, false); // repartir du début si l'on est sur le clone
				aller(cible, true);
				lancer();
			});
		});

		/* Balayage au doigt et glisser à la souris */
		var cadre = carrousel.querySelector(".ms-flyers-cadre");
		var depart = 0, ecart = 0, largeur = 0, glisse = false;

		function positionPx() { return -index * cadre.offsetWidth; }

		function debutGlisse(e) {
			if (e.pointerType === "mouse" && 0 !== e.button) return;
			glisse = true;
			depart = e.clientX;
			ecart = 0;
			largeur = cadre.offsetWidth;
			arreter();
			piste.style.transition = "none";
			cadre.classList.add("est-saisi");
			if (cadre.setPointerCapture) cadre.setPointerCapture(e.pointerId);
		}

		function pendantGlisse(e) {
			if (!glisse) return;
			ecart = e.clientX - depart;
			piste.style.transform = "translateX(" + (positionPx() + ecart) + "px)";
		}

		function finGlisse() {
			if (!glisse) return;
			glisse = false;
			cadre.classList.remove("est-saisi");
			piste.style.transition = "";

			// Un dixième de la largeur suffit à valider le changement de visuel.
			var seuil = Math.max(40, largeur * 0.12);

			if (ecart < -seuil) {
				if (index >= total) aller(0, false);
				aller(index + 1, true);
			} else if (ecart > seuil) {
				// Vers l'arrière depuis le premier visuel : on se place d'abord
				// sur le clone de fin, identique à l'écran, puis on recule.
				if (0 === index) aller(total, false);
				aller(index - 1, true);
			} else {
				aller(index, true); // pas assez loin : le visuel reprend sa place
			}

			ecart = 0;
			lancer();
		}

		cadre.addEventListener("pointerdown", debutGlisse);
		cadre.addEventListener("pointermove", pendantGlisse);
		cadre.addEventListener("pointerup", finGlisse);
		cadre.addEventListener("pointercancel", finGlisse);
		cadre.addEventListener("dragstart", function (e) { e.preventDefault(); });

		carrousel.addEventListener("mouseenter", arreter);
		carrousel.addEventListener("mouseleave", function () { if (!glisse) lancer(); });
		document.addEventListener("visibilitychange", function () {
			if (document.hidden) { arreter(); } else { lancer(); }
		});

		lancer();
	});

	/* ── Révélations au défilement ──────────────────────────────────────── */
	if (!reduit && "IntersectionObserver" in window) {
		docEl.classList.add("ms-anime");
		var observateur = new IntersectionObserver(
			function (entrees) {
				entrees.forEach(function (entree) {
					if (entree.isIntersecting) {
						entree.target.classList.add("est-visible");
						observateur.unobserve(entree.target);
					}
				});
			},
			{ rootMargin: "0px 0px -8% 0px", threshold: 0.12 }
		);
		document.querySelectorAll("[data-anim], .ms-ligne").forEach(function (el) {
			observateur.observe(el);
		});
	}
})();
