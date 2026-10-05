/* =========================================================
   Motor Consulting — Interactions
   ========================================================= */
(function () {
  "use strict";

  /* ----------------------------------------------------------
     CONFIGURATION
     formEndpoint : URL qui reçoit les formulaires (Formspree,
     Getform, Brevo, votre propre API…). Laissez vide pour le
     mode démo : la demande est enregistrée localement et le
     visiteur reçoit une confirmation + un relais WhatsApp/e-mail.
     ---------------------------------------------------------- */
  const CONFIG = Object.assign({
    formEndpoint: "",
    whatsapp: "33612345678",
    email: "contact@motor-consulting.fr"
  }, window.MC_CONFIG || {});

  /* Sur WordPress, les véhicules et les avis viennent de l'administration
     (window.MC_VEHICLES / window.MC_TESTIMONIALS) ; sinon, de data.js. */
  const LIST = Array.isArray(window.MC_VEHICLES) ? window.MC_VEHICLES : VEHICLES;
  const AVIS = Array.isArray(window.MC_TESTIMONIALS) ? window.MC_TESTIMONIALS : TESTIMONIALS;
  const media = (v, suffix) => v.photo
    ? `<img src="${v.photo}" alt="${v.marque} ${v.modele}" loading="lazy" width="800" height="440">`
    : carSvg(v, suffix);

  const $ = (sel, ctx) => (ctx || document).querySelector(sel);
  const $$ = (sel, ctx) => Array.from((ctx || document).querySelectorAll(sel));
  const euros = (n) => new Intl.NumberFormat("fr-FR", { style: "currency", currency: "EUR", maximumFractionDigits: 0 }).format(n);
  const nombre = (n) => new Intl.NumberFormat("fr-FR").format(n);

  /* =========================================================
     1. Navigation
     ========================================================= */
  const header = $("#header");
  const nav = $("#nav");
  const burger = $("#burger");

  burger.addEventListener("click", () => {
    const open = nav.classList.toggle("is-open");
    burger.setAttribute("aria-expanded", String(open));
    burger.setAttribute("aria-label", open ? "Fermer le menu" : "Ouvrir le menu");
  });

  $$('a[href^="#"]').forEach((a) => {
    a.addEventListener("click", () => {
      nav.classList.remove("is-open");
      burger.setAttribute("aria-expanded", "false");
    });
  });

  // Pré-remplit le sujet du formulaire de contact selon l'intention cliquée
  $$("[data-intent]").forEach((el) => {
    el.addEventListener("click", () => {
      const sujet = $("#c-sujet");
      if (!sujet) return;
      if (el.dataset.intent === "vendre") sujet.value = "Vendre un véhicule";
      if (el.dataset.intent === "estimation") sujet.value = "Expertise / estimation";
    });
  });

  const onScroll = () => {
    const y = window.scrollY;
    header.classList.toggle("is-scrolled", y > 20);
    if (toTop) toTop.classList.toggle("is-visible", y > 600);
  };

  const toTop = $("#to-top");
  if (toTop) toTop.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));
  window.addEventListener("scroll", onScroll, { passive: true });
  onScroll();

  // Lien de navigation actif selon la section visible
  const sections = $$("main section[id]");
  const navLinks = $$('.nav__list a[href^="#"]');
  if ("IntersectionObserver" in window) {
    const spy = new IntersectionObserver((entries) => {
      entries.forEach((e) => {
        if (!e.isIntersecting) return;
        navLinks.forEach((l) => l.classList.toggle("is-active", l.getAttribute("href") === "#" + e.target.id));
      });
    }, { rootMargin: "-45% 0px -50% 0px" });
    sections.forEach((s) => spy.observe(s));
  }

  /* =========================================================
     2. Apparitions au défilement
     ========================================================= */
  if ("IntersectionObserver" in window) {
    const io = new IntersectionObserver((entries, obs) => {
      entries.forEach((e) => {
        if (e.isIntersecting) { e.target.classList.add("is-in"); obs.unobserve(e.target); }
      });
    }, { threshold: 0.15 });
    $$(".reveal").forEach((el, i) => { el.style.transitionDelay = (i % 4) * 70 + "ms"; io.observe(el); });
  } else {
    $$(".reveal").forEach((el) => el.classList.add("is-in"));
  }

  /* =========================================================
     3. Compteurs des chiffres clés
     ========================================================= */
  function animateCount(el) {
    const target = parseFloat(el.dataset.count);
    const decimals = parseInt(el.dataset.decimals || "0", 10);
    const suffix = el.dataset.suffix || "";
    const reduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    if (reduced) { el.textContent = target.toFixed(decimals).replace(".", ",") + suffix; return; }

    const duration = 1400;
    const start = performance.now();
    const tick = (now) => {
      const p = Math.min((now - start) / duration, 1);
      const eased = 1 - Math.pow(1 - p, 3);
      const value = target * eased;
      el.textContent = (decimals ? value.toFixed(decimals).replace(".", ",") : nombre(Math.round(value))) + suffix;
      if (p < 1) requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);
  }

  const statsEl = $("#stats");
  if (statsEl && "IntersectionObserver" in window) {
    const so = new IntersectionObserver((entries, obs) => {
      entries.forEach((e) => {
        if (!e.isIntersecting) return;
        $$(".stat__value", e.target).forEach(animateCount);
        obs.unobserve(e.target);
      });
    }, { threshold: 0.4 });
    so.observe(statsEl);
  } else if (statsEl) {
    $$(".stat__value", statsEl).forEach(animateCount);
  }

  /* =========================================================
     4. Véhicules : rendu, filtres, tri, modale
     ========================================================= */
  const grid = $("#vehicles-grid");
  const emptyMsg = $("#vehicles-empty");
  const countEl = $("#results-count");
  const loadMore = $("#load-more");
  const PAGE = 6;
  let visible = PAGE;
  let filtered = LIST.slice();

  const state = { q: "", type: "", price: "", year: "", sort: "recent" };

  const garantieLabel = (v) => (/garantie/i.test(v.garantie) ? v.garantie : "Garantie " + v.garantie);

  function vehicleCard(v) {
    return `
      <article class="vehicle card" data-vehicle="${v.id}">
        <div class="vehicle__media">
          ${media(v, "g")}
          ${v.tag ? `<span class="vehicle__tag">${v.tag}</span>` : ""}
        </div>
        <div class="vehicle__head">
          <h3 class="vehicle__title">${v.marque} ${v.modele}<span>${v.version}</span></h3>
          <p class="vehicle__price">${euros(v.prix)}</p>
        </div>
        <ul class="vehicle__specs">
          <li>${v.annee}</li>
          <li>${nombre(v.km)} km</li>
          <li>${v.carburant}</li>
          <li>${v.boite}</li>
        </ul>
        <button class="link" type="button" data-vehicle="${v.id}">Voir la fiche <span aria-hidden="true">→</span></button>
      </article>`;
  }

  function applyFilters() {
    const q = state.q.trim().toLowerCase();
    filtered = LIST.filter((v) => {
      const hay = `${v.marque} ${v.modele} ${v.version} ${v.carburant} ${v.type} ${v.boite}`.toLowerCase();
      if (q && !q.split(/\s+/).every((w) => hay.includes(w))) return false;
      if (state.type && v.type !== state.type) return false;
      if (state.price && v.prix > parseInt(state.price, 10)) return false;
      if (state.year && v.annee < parseInt(state.year, 10)) return false;
      return true;
    });

    const sorters = {
      "recent": (a, b) => b.id - a.id,
      "price-asc": (a, b) => a.prix - b.prix,
      "price-desc": (a, b) => b.prix - a.prix,
      "km-asc": (a, b) => a.km - b.km,
      "year-desc": (a, b) => b.annee - a.annee
    };
    filtered.sort(sorters[state.sort] || sorters.recent);

    visible = PAGE;
    render();
  }

  function render() {
    const list = filtered.slice(0, visible);
    grid.innerHTML = list.map(vehicleCard).join("");

    emptyMsg.hidden = filtered.length > 0;
    loadMore.hidden = visible >= filtered.length;

    const n = filtered.length;
    countEl.innerHTML = n === 0
      ? "Aucun véhicule trouvé."
      : `<strong>${n}</strong> véhicule${n > 1 ? "s" : ""} disponible${n > 1 ? "s" : ""}${n > list.length ? ` · ${list.length} affiché${list.length > 1 ? "s" : ""}` : ""}`;
  }

  loadMore.addEventListener("click", () => { visible += PAGE; render(); });

  const searchInput = $("#f-search");
  let debounce;
  searchInput.addEventListener("input", (e) => {
    clearTimeout(debounce);
    debounce = setTimeout(() => { state.q = e.target.value; applyFilters(); }, 180);
  });
  $("#f-type").addEventListener("change", (e) => { state.type = e.target.value; applyFilters(); });
  $("#f-price").addEventListener("change", (e) => { state.price = e.target.value; applyFilters(); });
  $("#f-year").addEventListener("change", (e) => { state.year = e.target.value; applyFilters(); });
  $("#f-sort").addEventListener("change", (e) => { state.sort = e.target.value; applyFilters(); });
  $("#f-reset").addEventListener("click", () => {
    $("#filters").reset();
    Object.assign(state, { q: "", type: "", price: "", year: "", sort: "recent" });
    applyFilters();
  });
  $("#filters").addEventListener("submit", (e) => e.preventDefault());

  applyFilters();

  /* ------------------------- Modale véhicule ------------------------- */
  const modal = $("#vehicle-modal");
  const modalContent = $("#modal-content");
  let lastFocus = null;

  function openVehicle(id) {
    const v = LIST.find((x) => x.id === Number(id));
    if (!v) return;
    lastFocus = document.activeElement;
    const waText = encodeURIComponent(`Bonjour, je suis intéressé(e) par la ${v.marque} ${v.modele} ${v.version} (${v.annee}, ${nombre(v.km)} km) à ${euros(v.prix)}.`);

    modalContent.innerHTML = `
      <div class="modal__media" id="modal-media">${media(v, "m")}</div>
      ${Array.isArray(v.photos) && v.photos.length > 1 ? `<div class="modal__thumbs">${v.photos.map((p, i) => `<button type="button" class="${i === 0 ? "is-active" : ""}" data-photo="${p}" aria-label="Photo ${i + 1}"><img src="${p}" alt="" loading="lazy"></button>`).join("")}</div>` : ""}
      <div class="modal__body">
        <h3 id="modal-title">${v.marque} ${v.modele}</h3>
        <p class="modal__version">${v.version}</p>
        <p class="modal__price">${euros(v.prix)}</p>
        <dl class="specs-table">
          <div><dt>Année</dt><dd>${v.annee}</dd></div>
          <div><dt>Kilométrage</dt><dd>${nombre(v.km)} km</dd></div>
          <div><dt>Carburant</dt><dd>${v.carburant}</dd></div>
          <div><dt>Boîte</dt><dd>${v.boite}</dd></div>
          <div><dt>Type</dt><dd>${v.type} · ${v.places} places</dd></div>
          <div><dt>Garantie</dt><dd>${v.garantie}</dd></div>
        </dl>
        <p>${v.description}</p>
        <p class="modal__subtitle">Équipements principaux</p>
        <ul class="ticks">${v.options.map((o) => `<li>${o}</li>`).join("")}</ul>
        <div class="modal__actions">
          <a class="btn btn--primary" href="https://wa.me/${CONFIG.whatsapp}?text=${waText}" target="_blank" rel="noopener">Demander un essai</a>
          <a class="btn" href="#contact" data-close>Poser une question</a>
        </div>
      </div>`;

    modal.hidden = false;
    document.body.classList.add("is-locked");
    $(".modal__close", modal).focus();
  }

  function closeModal() {
    modal.hidden = true;
    document.body.classList.remove("is-locked");
    if (lastFocus) lastFocus.focus();
  }

  grid.addEventListener("click", (e) => {
    const btn = e.target.closest("[data-vehicle]");
    if (btn) openVehicle(btn.dataset.vehicle);
  });
  modal.addEventListener("click", (e) => {
    if (e.target.closest("[data-close]")) return closeModal();
    const t = e.target.closest("[data-photo]");
    if (t) {
      const img = $("#modal-media img");
      if (img) img.src = t.dataset.photo;
      $$(".modal__thumbs button", modal).forEach((b) => b.classList.toggle("is-active", b === t));
    }
  });
  document.addEventListener("keydown", (e) => { if (e.key === "Escape" && !modal.hidden) closeModal(); });

  /* =========================================================
     5. Témoignages
     ========================================================= */
  const track = $("#testimonials-track");
  const dotsBox = $("#t-dots");

  function starsHtml(note) {
    let out = "";
    for (let i = 1; i <= 5; i++) out += `<i class="${i <= note ? "" : "is-empty"}"></i>`;
    return `<span class="stars" role="img" aria-label="Note de ${note} sur 5">${out}</span>`;
  }

  track.innerHTML = AVIS.map((t) => `
    <article class="testimonial card">
      ${starsHtml(t.note)}
      <p class="testimonial__quote">${t.texte}</p>
      <p class="testimonial__who">
        <strong>${t.nom}</strong>
        <small>${t.ville} · ${t.service}</small>
      </p>
    </article>`).join("");

  $$(".stars--lg").forEach((el) => { el.innerHTML = "<i></i><i></i><i></i><i></i><i></i>"; });

  let slide = 0;
  const perView = () => (window.innerWidth >= 900 ? 3 : window.innerWidth >= 600 ? 2 : 1);
  const maxSlide = () => Math.max(0, AVIS.length - perView());

  function goTo(i) {
    slide = Math.min(Math.max(i, 0), maxSlide());
    const card = $(".testimonial", track);
    if (!card) return;
    const step = card.getBoundingClientRect().width + 20;
    track.style.transform = `translateX(-${slide * step}px)`;
    $$("button", dotsBox).forEach((d, idx) => {
      d.classList.toggle("is-active", idx === slide);
      d.setAttribute("aria-selected", String(idx === slide));
    });
  }

  function buildDots() {
    dotsBox.innerHTML = "";
    for (let i = 0; i <= maxSlide(); i++) {
      const b = document.createElement("button");
      b.type = "button";
      b.setAttribute("role", "tab");
      b.setAttribute("aria-label", "Témoignage " + (i + 1));
      b.addEventListener("click", () => goTo(i));
      dotsBox.appendChild(b);
    }
    goTo(Math.min(slide, maxSlide()));
  }

  $("#t-prev").addEventListener("click", () => goTo(slide - 1));
  $("#t-next").addEventListener("click", () => goTo(slide + 1));
  buildDots();

  let resizeTimer;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(buildDots, 150);
  });

  // Défilement tactile
  let touchX = null;
  track.addEventListener("touchstart", (e) => { touchX = e.touches[0].clientX; }, { passive: true });
  track.addEventListener("touchend", (e) => {
    if (touchX === null) return;
    const dx = e.changedTouches[0].clientX - touchX;
    if (Math.abs(dx) > 50) goTo(slide + (dx < 0 ? 1 : -1));
    touchX = null;
  }, { passive: true });

  /* =========================================================
     6. Formulaires : validation + envoi
     ========================================================= */
  const RE_EMAIL = /^[^\s@]+@[^\s@]+\.[a-z]{2,}$/i;
  const RE_TEL = /^(?:(?:\+|00)33[\s.-]?(?:\(0\)[\s.-]?)?|0)[1-9](?:[\s.-]?\d{2}){4}$/;

  function showError(field, message) {
    const box = field.closest(".field") || field.closest("fieldset") || field.parentElement;
    if (box) box.classList.add("has-error");
    const id = field.name === "etat" ? "etat" : field.id;
    const err = document.querySelector(`[data-error-for="${id}"]`);
    if (err) { err.textContent = message; err.classList.add("is-visible"); }
  }

  function clearError(field) {
    const box = field.closest(".field") || field.closest("fieldset") || field.parentElement;
    if (box) box.classList.remove("has-error");
    const id = field.name === "etat" ? "etat" : field.id;
    const err = document.querySelector(`[data-error-for="${id}"]`);
    if (err) { err.textContent = ""; err.classList.remove("is-visible"); }
  }

  function validateField(field) {
    const val = (field.value || "").trim();
    const type = field.type;

    if (type === "checkbox") {
      if (field.required && !field.checked) { showError(field, "Merci de cocher cette case pour continuer."); return false; }
      clearError(field); return true;
    }
    if (type === "radio") {
      const group = document.getElementsByName(field.name);
      const checked = Array.from(group).some((r) => r.checked);
      if (!checked) { showError(field, "Sélectionnez l'état du véhicule."); return false; }
      clearError(field); return true;
    }
    if (field.required && !val) { showError(field, "Ce champ est obligatoire."); return false; }
    if (!val) { clearError(field); return true; }

    if (type === "email" && !RE_EMAIL.test(val)) { showError(field, "Adresse e-mail invalide (ex. vous@exemple.fr)."); return false; }
    if (type === "tel" && !RE_TEL.test(val)) { showError(field, "Numéro invalide (ex. 06 12 34 56 78)."); return false; }

    if (field.name === "annee") {
      const y = parseInt(val, 10);
      const max = new Date().getFullYear() + 1;
      if (isNaN(y) || y < 1950 || y > max) { showError(field, `Indiquez une année entre 1950 et ${max}.`); return false; }
    }
    if (field.name === "km" || field.name === "kilometrage") {
      const k = parseInt(val, 10);
      if (isNaN(k) || k < 0 || k > 1000000) { showError(field, "Indiquez un kilométrage réaliste (0 à 1 000 000 km)."); return false; }
    }
    if (field.name === "nom" && val.length < 2) { showError(field, "Indiquez votre nom complet."); return false; }
    if (field.name === "message" && field.required && val.length < 10) { showError(field, "Détaillez un peu votre demande (10 caractères minimum)."); return false; }

    clearError(field);
    return true;
  }

  function validateForm(form) {
    const fields = $$("input, select, textarea", form).filter((f) => f.type !== "hidden" && f.name !== "website");
    const seenRadios = new Set();
    let ok = true;
    let first = null;

    fields.forEach((f) => {
      if (f.type === "radio") {
        if (seenRadios.has(f.name)) return;
        seenRadios.add(f.name);
        const anyRequired = Array.from(document.getElementsByName(f.name)).some((r) => r.required);
        if (!anyRequired) return;
      }
      if (!f.required && !f.value) { clearError(f); return; }
      if (!validateField(f)) { ok = false; if (!first) first = f; }
    });

    if (first) {
      first.focus({ preventScroll: true });
      first.scrollIntoView({ behavior: "smooth", block: "center" });
    }
    return ok;
  }

  function setStatus(el, message, kind) {
    el.className = "form__status is-visible is-" + kind;
    el.innerHTML = message;
  }

  function reference() {
    const d = new Date();
    return "MC-" + d.getFullYear() + String(d.getMonth() + 1).padStart(2, "0") + "-" + Math.random().toString(36).slice(2, 6).toUpperCase();
  }

  function saveLocally(payload) {
    try {
      const key = "mc_demandes";
      const all = JSON.parse(localStorage.getItem(key) || "[]");
      all.push(payload);
      localStorage.setItem(key, JSON.stringify(all.slice(-50)));
    } catch (e) { /* stockage indisponible : sans conséquence */ }
  }

  async function submitForm(form, statusEl, successMsg) {
    const data = Object.fromEntries(new FormData(form).entries());
    data.reference = reference();
    data.date = new Date().toISOString();
    data.page = location.href;

    const btn = $('button[type="submit"]', form);
    const label = btn.textContent;
    btn.disabled = true;
    btn.textContent = "Envoi en cours…";

    try {
      if (CONFIG.formEndpoint) {
        const res = await fetch(CONFIG.formEndpoint, {
          method: "POST",
          headers: { "Accept": "application/json", "Content-Type": "application/json" },
          body: JSON.stringify(data)
        });
        if (!res.ok) throw new Error("HTTP " + res.status);
      } else {
        saveLocally(data);
        await new Promise((r) => setTimeout(r, 600));
      }

      const waText = encodeURIComponent(`Bonjour, je viens d'envoyer une demande sur votre site (référence ${data.reference}).`);
      setStatus(statusEl,
        `${successMsg}<br><small style="font-weight:500">Référence de votre demande : <strong>${data.reference}</strong> — besoin d'une réponse immédiate ?
         <a href="https://wa.me/${CONFIG.whatsapp}?text=${waText}" target="_blank" rel="noopener" >écrivez-nous sur WhatsApp</a>.</small>`,
        "success");
      form.reset();
      $$(".field.has-error", form).forEach((f) => f.classList.remove("has-error"));
    } catch (err) {
      setStatus(statusEl,
        `L'envoi a échoué. Réessayez ou contactez-nous directement au
         <a href="tel:+${CONFIG.whatsapp}" >06 12 34 56 78</a>
         ou par e-mail à <a href="mailto:${CONFIG.email}" >${CONFIG.email}</a>.`,
        "error");
    } finally {
      btn.disabled = false;
      btn.textContent = label;
    }
  }

  function wireForm(formId, statusId, successMsg) {
    const form = $(formId);
    if (!form) return;
    const statusEl = $(statusId);

    $$("input, select, textarea", form).forEach((f) => {
      if (f.name === "website") return;
      f.addEventListener("blur", () => { if (f.value || f.required) validateField(f); });
      f.addEventListener("input", () => { if ((f.closest(".field") || {}).classList?.contains("has-error")) validateField(f); });
      f.addEventListener("change", () => { if (f.type === "radio" || f.type === "checkbox") validateField(f); });
    });

    form.addEventListener("submit", (e) => {
      e.preventDefault();
      statusEl.className = "form__status";
      if (!validateForm(form)) {
        setStatus(statusEl, "Certains champs doivent être corrigés avant l'envoi.", "error");
        return;
      }
      submitForm(form, statusEl, successMsg);
    });
  }

  wireForm("#quick-form", "#quick-status", "Merci ! Votre demande d'estimation est bien reçue : un expert vous répond sous 24h ouvrées.");
  wireForm("#estimation-form", "#estimation-status", "Merci ! Votre demande d'estimation gratuite est enregistrée. Un expert analyse votre véhicule et vous répond sous 24h ouvrées.");
  wireForm("#contact-form", "#contact-status", "Merci ! Votre message est bien parti. Nous vous recontactons sous 24h ouvrées.");

  // Le mini-formulaire du hero renvoie vers le formulaire complet
  const quick = $("#quick-form");
  if (quick) {
    quick.addEventListener("submit", () => {
      setTimeout(() => {
        const m = quick.querySelector("#q-marque");
        const a = quick.querySelector("#q-annee");
        const k = quick.querySelector("#q-km");
        if (!m) return;
        const eMarque = $("#e-marque"), eAnnee = $("#e-annee"), eKm = $("#e-km");
        if (eMarque && !eMarque.value && m.dataset.sent) eMarque.value = m.dataset.sent;
        if (eAnnee && !eAnnee.value && a.dataset.sent) eAnnee.value = a.dataset.sent;
        if (eKm && !eKm.value && k.dataset.sent) eKm.value = k.dataset.sent;
      }, 700);
    });
    // mémorise les valeurs saisies avant le reset
    quick.addEventListener("submit", () => {
      $$("input", quick).forEach((i) => { i.dataset.sent = i.value; });
    }, true);
  }


  /* =========================================================
     6 bis. Mouvement : lignes de vitesse, parallaxe, inclinaison
     ========================================================= */
  const reduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  const fine = window.matchMedia("(pointer:fine)").matches;

  const canvas = $("#speed");
  if (canvas && !reduced) {
    const ctx = canvas.getContext("2d");
    let w, h, cx, cy, dpr, particles = [], raf, running = true;
    const N = 150;
    const resize = () => {
      dpr = Math.min(window.devicePixelRatio || 1, 2);
      w = canvas.clientWidth; h = canvas.clientHeight;
      canvas.width = w * dpr; canvas.height = h * dpr;
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
      cx = w * .62; cy = h * .45;
    };
    const spawn = (p) => { p.a = Math.random() * Math.PI * 2; p.r = Math.random() * 40; p.v = .5 + Math.random() * 1.5; p.blue = Math.random() < .3; return p; };
    const init = () => { particles = Array.from({ length: N }, () => spawn({})); };
    const step = () => {
      if (!running) return;
      ctx.clearRect(0, 0, w, h);
      const maxR = Math.hypot(w, h) * .6;
      for (const p of particles) {
        p.r += p.v * (1 + p.r / 130);
        if (p.r > maxR) spawn(p);
        const len = 6 + p.r * .13;
        const x1 = cx + Math.cos(p.a) * p.r, y1 = cy + Math.sin(p.a) * p.r;
        const x0 = cx + Math.cos(p.a) * Math.max(0, p.r - len), y0 = cy + Math.sin(p.a) * Math.max(0, p.r - len);
        const alpha = Math.min(1, p.r / 180) * (p.blue ? .8 : .45);
        ctx.strokeStyle = p.blue ? `rgba(10,140,255,${alpha})` : `rgba(200,205,212,${alpha})`;
        ctx.lineWidth = p.blue ? 1.3 : .8;
        ctx.beginPath(); ctx.moveTo(x0, y0); ctx.lineTo(x1, y1); ctx.stroke();
      }
      raf = requestAnimationFrame(step);
    };
    resize(); init(); step();
    window.addEventListener("resize", resize);
    document.addEventListener("visibilitychange", () => { running = !document.hidden; if (running) step(); else cancelAnimationFrame(raf); });
  }

  const heroInner = $("#hero-inner");
  if (heroInner && !reduced && fine) {
    let tx = 0, ty = 0, x = 0, y = 0;
    window.addEventListener("mousemove", (e) => { tx = (e.clientX / window.innerWidth - .5) * 14; ty = (e.clientY / window.innerHeight - .5) * 10; }, { passive: true });
    const loop = () => { x += (tx - x) * .06; y += (ty - y) * .06; heroInner.style.transform = `translate(${x}px,${y}px)`; requestAnimationFrame(loop); };
    loop();
  }

  if (!reduced && fine) {
    document.addEventListener("mousemove", (e) => {
      const card = e.target.closest(".card");
      if (!card) return;
      const r = card.getBoundingClientRect();
      const px = (e.clientX - r.left) / r.width, py = (e.clientY - r.top) / r.height;
      card.style.setProperty("--mx", (px * 100) + "%"); card.style.setProperty("--my", (py * 100) + "%");
      if (card.classList.contains("tilt")) card.style.transform = `perspective(1000px) rotateX(${(py - .5) * -5}deg) rotateY(${(px - .5) * 7}deg) translateY(-4px)`;
    }, { passive: true });
    document.addEventListener("mouseout", (e) => {
      const card = e.target.closest(".card.tilt");
      if (card && !card.contains(e.relatedTarget)) card.style.transform = "";
    });
  }

  // Cartes véhicules et avis générées après coup : apparition immédiate
  const revealNow = () => $$(".vehicle.reveal, .testimonial.reveal").forEach((el) => el.classList.add("is-in"));
  revealNow();

  /* =========================================================
     7. Divers
     ========================================================= */
  const yearEl = $("#year");
  if (yearEl) yearEl.textContent = new Date().getFullYear();
})();
