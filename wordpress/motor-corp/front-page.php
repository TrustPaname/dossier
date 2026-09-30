<?php
/**
 * Page d'accueil Motor Corp — générée par wordpress/build.py à partir de motor-corp/index.html.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Motor Corp — Holding automobile · Motor Studio &amp; Motor Consulting</title>
<meta name="description" content="Motor Corp, holding automobile : Motor Studio (carrosserie) et Motor Consulting (conseil, achat, vente, location). Performance. Passion. Partenariat.">
<meta name="robots" content="index, follow">
<link rel="canonical" href="<?php echo esc_url( home_url( '/' ) ); ?>">
<meta property="og:type" content="website">
<meta property="og:locale" content="fr_FR">
<meta property="og:site_name" content="Motor Corp">
<meta property="og:title" content="Motor Corp — Holding automobile">
<meta property="og:description" content="Un groupe, deux expertises : la carrosserie et le conseil automobile. Performance. Passion. Partenariat.">
<meta property="og:url" content="<?php echo esc_url( home_url( '/' ) ); ?>">
<meta name="theme-color" content="#000000">
<link rel="icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/favicon.svg" type="image/svg+xml">
<script>document.documentElement.classList.add("js");</script>

<style>
@font-face{font-family:'Archivo';font-style:normal;font-weight:300 700;font-display:swap;src:url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/fonts/archivo-latin-ext.woff2') format('woff2');unicode-range:U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF}
@font-face{font-family:'Archivo';font-style:normal;font-weight:300 700;font-display:swap;src:url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/fonts/archivo-latin.woff2') format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD}
@font-face{font-family:'Michroma';font-style:normal;font-weight:400;font-display:swap;src:url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/fonts/michroma-latin-ext.woff2') format('woff2');unicode-range:U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF}
@font-face{font-family:'Michroma';font-style:normal;font-weight:400;font-display:swap;src:url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/fonts/michroma-latin.woff2') format('woff2');unicode-range:U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD}

:root{
  color-scheme:dark;
  --noir:#000;
  --noir-2:#08080a;
  --noir-3:#101013;
  --rouge:#d8161f;
  --rouge-vif:#ff2a33;
  --rouge-glow:rgba(216,22,31,.5);
  --or:#d4af37;
  --argent:#c9ced4;
  --texte:#f2f1ec;
  --texte-2:#aeb2b8;
  --texte-3:#6b6f75;
  --line:rgba(255,255,255,.08);
  --grad-chrome:linear-gradient(180deg,#ffffff 0%,#d3d7dc 42%,#7a8087 52%,#cfd4da 62%,#f4f6f8 100%);
  --grad-or:linear-gradient(90deg,#8a6e1e 0%,#f3e2a4 40%,#d4af37 60%,#8a6e1e 100%);
  --font:"Archivo",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Arial,sans-serif;
  --font-display:"Michroma","Archivo",sans-serif;
  --container:1180px;
  --header-h:76px;
  --t:.35s cubic-bezier(.4,0,.2,1);
}
*,*::before,*::after{box-sizing:border-box}
html{scroll-behavior:smooth;scroll-padding-top:var(--header-h)}
body{
  margin:0;background:var(--noir);color:var(--texte);font-family:var(--font);font-weight:300;
  line-height:1.65;-webkit-font-smoothing:antialiased;overflow-x:hidden
}
a{color:inherit;text-decoration:none}
button{font:inherit}
h1,h2,h3{margin:0 0 .5em;color:#fff;font-weight:300;letter-spacing:-.02em;line-height:1.1;text-wrap:balance}
h2{font-size:clamp(1.8rem,4vw,3rem)}
h3{font-size:1.15rem;font-weight:400;letter-spacing:.01em}
p{margin:0 0 1em}
ul,ol{margin:0;padding:0;list-style:none}
strong{color:#fff;font-weight:500}
.container{width:100%;max-width:var(--container);margin-inline:auto;padding-inline:24px}
:focus-visible{outline:1px solid var(--rouge);outline-offset:5px}
.sr-only{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0);white-space:nowrap}

/* ---------- Lettrage chrome animé ---------- */
.chrome{
  background:var(--grad-chrome);-webkit-background-clip:text;background-clip:text;color:transparent;-webkit-text-fill-color:transparent;
  filter:drop-shadow(0 2px 1px rgba(0,0,0,.85))
}
.chrome--live{
  background-image:linear-gradient(180deg,#ffffff 0%,#d3d7dc 42%,#7a8087 52%,#cfd4da 62%,#f4f6f8 100%),
                   linear-gradient(100deg,transparent 30%,rgba(255,255,255,.85) 50%,transparent 70%);
  background-size:100% 100%,240% 100%;background-position:0 0,200% 0;
  animation:sheen 6s ease-in-out infinite
}
@keyframes sheen{0%,55%{background-position:0 0,200% 0}80%,100%{background-position:0 0,-100% 0}}

.label{
  display:inline-block;font-family:var(--font-display);font-size:.6rem;letter-spacing:.34em;text-transform:uppercase;
  color:var(--rouge-vif);margin-bottom:1.6em;padding-left:.34em
}
.lead{color:var(--texte-2);font-size:1.08rem;max-width:56ch;margin:0}

/* ---------- Boutons ---------- */
.btn{
  position:relative;display:inline-flex;align-items:center;justify-content:center;gap:.6em;overflow:hidden;
  padding:15px 30px;border:1px solid rgba(255,255,255,.28);color:#fff;background:transparent;
  font-family:var(--font);font-size:.8rem;letter-spacing:.18em;text-transform:uppercase;cursor:pointer;
  transition:border-color var(--t),color var(--t),transform var(--t)
}
.btn::before{content:"";position:absolute;inset:0;background:var(--rouge);transform:translateX(-101%);transition:transform .4s cubic-bezier(.4,0,.2,1);z-index:-1}
.btn:hover{border-color:var(--rouge);transform:translateY(-2px)}
.btn:hover::before{transform:translateX(0)}
.btn--primary{border-color:var(--rouge);background:var(--rouge);color:#fff;box-shadow:0 10px 30px var(--rouge-glow)}
.btn--primary::before{background:#fff}
.btn--primary:hover{color:#000}
.btn span{transition:transform var(--t)}
.btn:hover span{transform:translateX(4px)}

/* ---------- Header ---------- */
.header{
  position:fixed;inset:0 0 auto 0;z-index:100;height:var(--header-h);
  background:linear-gradient(180deg,rgba(0,0,0,.85),rgba(0,0,0,0));transition:background var(--t),backdrop-filter var(--t)
}
.header.is-scrolled{background:rgba(0,0,0,.86);backdrop-filter:blur(14px);border-bottom:1px solid var(--line)}
.header__inner{display:flex;align-items:center;justify-content:space-between;height:var(--header-h)}
.brand{display:flex;align-items:center;gap:12px}
.brand svg{width:44px;height:auto;filter:drop-shadow(0 2px 2px rgba(0,0,0,.8))}
.brand__text{font-family:var(--font-display);font-size:.78rem;letter-spacing:.24em;padding-left:.24em}
.nav{display:none;gap:34px;align-items:center}
.nav a{font-size:.78rem;letter-spacing:.14em;text-transform:uppercase;color:var(--texte-2);position:relative;padding:6px 0;transition:color var(--t)}
.nav a::after{content:"";position:absolute;left:0;right:100%;bottom:0;height:1px;background:var(--rouge);transition:right var(--t)}
.nav a:hover,.nav a.is-active{color:#fff}
.nav a:hover::after,.nav a.is-active::after{right:0}
.burger{width:44px;height:44px;display:grid;place-content:center;gap:6px;background:none;border:0;cursor:pointer;padding:0}
.burger span{display:block;width:22px;height:1px;background:#fff;transition:transform var(--t),opacity var(--t)}
.burger[aria-expanded="true"] span:nth-child(1){transform:translateY(7px) rotate(45deg)}
.burger[aria-expanded="true"] span:nth-child(2){opacity:0}
.burger[aria-expanded="true"] span:nth-child(3){transform:translateY(-7px) rotate(-45deg)}
.nav.is-open{display:flex;flex-direction:column;position:fixed;top:var(--header-h);left:0;right:0;background:rgba(0,0,0,.96);padding:20px 24px 30px;gap:0;align-items:stretch;border-bottom:1px solid var(--line)}
.nav.is-open a{padding:14px 0;border-bottom:1px solid var(--line);font-size:.95rem}

/* ---------- Hero ---------- */
.hero{position:relative;min-height:100svh;display:flex;flex-direction:column;justify-content:center;align-items:center;text-align:center;padding:calc(var(--header-h) + 40px) 24px 90px;overflow:hidden}
.hero__canvas{position:absolute;inset:0;width:100%;height:100%;display:block}
.hero__grid{
  position:absolute;left:-20%;right:-20%;bottom:-2%;height:46%;pointer-events:none;
  background-image:linear-gradient(rgba(216,22,31,.28) 1px,transparent 1px),linear-gradient(90deg,rgba(216,22,31,.28) 1px,transparent 1px);
  background-size:80px 80px;transform:perspective(600px) rotateX(64deg);transform-origin:50% 0;
  -webkit-mask-image:linear-gradient(180deg,transparent,#000 40%,transparent);mask-image:linear-gradient(180deg,transparent,#000 40%,transparent);
  animation:gridmove 3s linear infinite
}
@keyframes gridmove{from{background-position:0 0,0 0}to{background-position:0 80px,0 0}}
.hero__vignette{position:absolute;inset:0;pointer-events:none;background:radial-gradient(60% 55% at 50% 45%,transparent 30%,rgba(0,0,0,.72) 100%)}
.hero__inner{position:relative;display:flex;flex-direction:column;align-items:center;will-change:transform}
.mc{width:min(320px,58vw);height:auto;filter:drop-shadow(0 6px 6px rgba(0,0,0,.9))}
.mc__sheen{animation:mcsheen 6s ease-in-out infinite}
@keyframes mcsheen{0%,55%{transform:translateX(0)}85%,100%{transform:translateX(440px)}}
.hero__name{margin:26px 0 0;font-family:var(--font-display);font-weight:400;font-size:clamp(1.6rem,5.4vw,3.6rem);letter-spacing:.24em;padding-left:.24em;line-height:1.1}
.hero__sub{display:flex;align-items:center;gap:22px;margin:14px 0 0;width:min(720px,88vw);font-family:var(--font-display);font-size:clamp(.78rem,1.9vw,1.1rem);letter-spacing:.44em;padding-left:.44em}
.hero__sub i{flex:1;height:2px;background:var(--rouge);box-shadow:0 0 10px var(--rouge-glow);transform-origin:center;animation:linegrow 1.2s cubic-bezier(.2,.7,.2,1) .3s both}
@keyframes linegrow{from{transform:scaleX(0)}to{transform:scaleX(1)}}
.hero__tag{margin:28px 0 0;font-size:clamp(.7rem,1.6vw,.95rem);letter-spacing:.32em;padding-left:.32em;text-transform:uppercase;color:var(--texte-2);font-weight:500}
.hero__tag b{font-weight:500;display:inline-block;opacity:0;transform:translateY(8px);animation:wordin .7s ease forwards}
.hero__tag b:nth-child(2){animation-delay:.25s}.hero__tag b:nth-child(3){animation-delay:.5s}
@keyframes wordin{to{opacity:1;transform:none}}
.hero__lead{margin:30px auto 0;max-width:58ch;color:var(--texte-2);font-size:1.05rem}
.hero__actions{display:flex;flex-wrap:wrap;justify-content:center;gap:14px;margin-top:38px}
.scroll-cue{
  position:absolute;bottom:26px;left:50%;transform:translateX(-50%);display:flex;flex-direction:column;align-items:center;gap:10px;
  font-family:var(--font-display);font-size:.5rem;letter-spacing:.34em;color:var(--texte-3);text-transform:uppercase
}
.scroll-cue i{width:1px;height:44px;background:linear-gradient(180deg,var(--rouge),transparent);animation:cue 1.8s ease-in-out infinite}
@keyframes cue{0%{transform:scaleY(0);transform-origin:top}50%{transform:scaleY(1);transform-origin:top}51%{transform-origin:bottom}100%{transform:scaleY(0);transform-origin:bottom}}

/* ---------- Bandeau défilant ---------- */
.marquee{position:relative;overflow:hidden;border-top:1px solid rgba(216,22,31,.45);border-bottom:1px solid rgba(216,22,31,.45);background:var(--noir-2);padding:16px 0}
.marquee__track{display:flex;width:max-content;gap:0;animation:marquee 32s linear infinite}
.marquee:hover .marquee__track{animation-play-state:paused}
.marquee__track span{font-family:var(--font-display);font-size:.72rem;letter-spacing:.36em;text-transform:uppercase;color:var(--texte-2);padding:0 34px;white-space:nowrap}
.marquee__track span::after{content:"◆";color:var(--rouge);margin-left:68px;font-size:.5rem;vertical-align:middle}
@keyframes marquee{from{transform:translateX(0)}to{transform:translateX(-50%)}}

/* ---------- Sections ---------- */
.section{position:relative;padding:110px 0}
.section + .section{border-top:1px solid var(--line)}
.section__head{max-width:62ch;margin-bottom:56px}
.section__head--row{display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:24px;max-width:none}
.section__head--row>div{max-width:62ch}

/* ---------- Le groupe ---------- */
.group{display:grid;gap:56px}
.group__text p{color:var(--texte-2)}
.group__text p+p{margin-top:0}
.pillars{display:grid;gap:18px}
.pillar{
  position:relative;padding:30px 26px;border:1px solid var(--line);background:linear-gradient(180deg,rgba(255,255,255,.03),transparent);
  overflow:hidden;transition:border-color var(--t),transform var(--t)
}
.pillar::before{content:"";position:absolute;left:0;top:0;bottom:0;width:2px;background:var(--rouge);transform:scaleY(0);transform-origin:top;transition:transform .5s ease}
.pillar:hover{border-color:rgba(216,22,31,.5);transform:translateY(-4px)}
.pillar:hover::before{transform:scaleY(1)}
.pillar__num{font-family:var(--font-display);font-size:.55rem;letter-spacing:.3em;color:var(--rouge-vif);display:block;margin-bottom:18px}
.pillar h3{font-family:var(--font-display);font-size:.95rem;letter-spacing:.2em;text-transform:uppercase;font-weight:400;margin-bottom:.8em}
.pillar p{margin:0;color:var(--texte-2);font-size:.94rem}
.stats{display:flex;flex-wrap:wrap;gap:12px 40px;margin-top:40px;padding-top:26px;border-top:1px solid var(--line);font-size:.86rem;color:var(--texte-3)}
.stats strong{font-family:var(--font-display);font-size:1.05rem;color:#fff;font-weight:400;margin-right:.5em}

/* ---------- Les marques ---------- */
.brands{display:grid;gap:22px}
.bcard{
  position:relative;display:flex;flex-direction:column;gap:26px;padding:44px 32px 40px;
  background:var(--noir-2);border:1px solid var(--line);overflow:hidden;
  transform-style:preserve-3d;transition:border-color var(--t),box-shadow var(--t);
}
.bcard::before{
  content:"";position:absolute;inset:0;pointer-events:none;opacity:0;transition:opacity var(--t);
  background:radial-gradient(420px circle at var(--mx,50%) var(--my,50%),rgba(255,255,255,.08),transparent 60%)
}
.bcard:hover{border-color:rgba(255,255,255,.22);box-shadow:0 30px 80px rgba(0,0,0,.7)}
.bcard:hover::before{opacity:1}
.bcard__logo{display:flex;flex-direction:column;align-items:center;text-align:center;gap:4px;width:min(320px,100%);margin:0 auto;transform:translateZ(30px)}
.mark{width:100%;height:auto;display:block;filter:drop-shadow(0 3px 3px rgba(0,0,0,.9));margin-bottom:-8px}
.mark__name{font-family:var(--font-display);font-size:clamp(1.9rem,6vw,2.8rem);letter-spacing:.12em;padding-left:.12em;line-height:1}
.mark__sub{
  display:flex;align-items:center;gap:14px;width:100%;font-family:var(--font-display);font-size:clamp(.78rem,2vw,1.05rem);letter-spacing:.34em;padding-left:.34em;
  background:var(--grad-or);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent;color:transparent;filter:drop-shadow(0 1px 1px rgba(0,0,0,.8))
}
.mark__sub i{flex:1;height:1.5px;background:var(--grad-or)}
.bcard__kicker{text-align:center;font-size:.7rem;letter-spacing:.28em;text-transform:uppercase;color:var(--texte-2);margin:8px 0 0}
.bcard__desc{color:var(--texte-2);margin:0;text-align:center;max-width:44ch;margin-inline:auto}
.bcard__list{display:grid;gap:10px;margin:0 auto;max-width:40ch;width:100%;font-size:.92rem;color:var(--texte-2)}
.bcard__list li{position:relative;padding-left:22px}
.bcard__list li::before{content:"";position:absolute;left:0;top:.8em;width:10px;height:1px;background:var(--rouge)}
.bcard__cta{align-self:center;margin-top:6px}
.bcard__num{position:absolute;top:20px;right:22px;font-family:var(--font-display);font-size:.55rem;letter-spacing:.3em;color:var(--texte-3)}

/* ---------- Synergies ---------- */
.path{position:relative;display:grid;gap:34px;margin-top:10px}
.path__line{display:none}
.pstep{position:relative;padding-top:26px;border-top:1px solid var(--line)}
.pstep::before{content:"";position:absolute;top:-1px;left:0;width:0;height:1px;background:var(--rouge);transition:width 1.2s ease}
.pstep.is-in::before{width:100%}
.pstep__tag{font-family:var(--font-display);font-size:.55rem;letter-spacing:.3em;text-transform:uppercase;color:var(--texte-3);display:block;margin-bottom:14px}
.pstep__tag em{color:var(--or);font-style:normal}
.pstep__tag em.red{color:var(--rouge-vif)}
.pstep h3{margin-bottom:.5em}
.pstep p{margin:0;color:var(--texte-2);font-size:.94rem}

/* ---------- Contact ---------- */
.contact{display:grid;gap:40px}
.infos{display:grid}
.infos li{padding:20px 0;border-top:1px solid var(--line);display:grid;gap:4px}
.infos li:last-child{border-bottom:1px solid var(--line)}
.infos strong{font-size:.68rem;letter-spacing:.26em;text-transform:uppercase;color:var(--texte-3);font-weight:400}
.infos a,.infos span{font-size:1.05rem;color:#fff}
.infos a{border-bottom:1px solid transparent;transition:border-color var(--t);justify-self:start}
.infos a:hover{border-bottom-color:var(--rouge)}
.contact__cta{display:flex;flex-direction:column;gap:14px;align-items:flex-start}

/* ---------- Footer ---------- */
.footer{border-top:1px solid rgba(216,22,31,.4);padding:44px 0 40px;font-size:.78rem;color:var(--texte-3)}
.footer__inner{display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;gap:16px 30px}
.footer ul{display:flex;flex-wrap:wrap;gap:22px}
.footer a:hover{color:#fff}

/* ---------- Apparitions ---------- */
.js .reveal{opacity:0;transform:translateY(24px);transition:opacity .8s ease,transform .8s cubic-bezier(.2,.7,.2,1)}
.js .reveal.is-in{opacity:1;transform:none}
.js .reveal--d1{transition-delay:.12s}.js .reveal--d2{transition-delay:.24s}.js .reveal--d3{transition-delay:.36s}

/* ---------- Bureau ---------- */
@media (min-width:860px){
  .nav{display:flex}
  .burger{display:none}
  .section{padding:140px 0}
  .group{grid-template-columns:1fr 1fr;gap:80px;align-items:start}
  .pillars{grid-template-columns:1fr}
  .brands{grid-template-columns:1fr 1fr}
  .bcard{padding:56px 44px 48px}
  .path{grid-template-columns:repeat(4,1fr);gap:32px}
  .contact{grid-template-columns:1fr 1fr;gap:96px;align-items:start}
  .contact__cta{flex-direction:row;flex-wrap:wrap}
}
@media (prefers-reduced-motion:reduce){
  *,*::before,*::after{animation-duration:.001ms!important;animation-iteration-count:1!important;transition-duration:.001ms!important;scroll-behavior:auto!important}
  .js .reveal{opacity:1;transform:none}
  .hero__tag b{opacity:1;transform:none}
  .hero__canvas{display:none}
}
</style>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<a class="sr-only" href="#groupe">Aller au contenu</a>

<header class="header" id="header">
  <div class="container header__inner">
    <a class="brand" href="#top" aria-label="Motor Corp, haut de page">
      <svg viewBox="0 0 300 130" aria-hidden="true"><use href="#mc-sym"/></svg>
      <span class="brand__text chrome">MOTOR CORP</span>
    </a>
    <nav class="nav" id="nav" aria-label="Navigation">
      <a href="#groupe">Le groupe</a>
      <a href="#marques">Nos marques</a>
      <a href="#synergies">Synergies</a>
      <a href="#contact">Contact</a>
    </nav>
    <button class="burger" id="burger" type="button" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="nav"><span></span><span></span><span></span></button>
  </div>
</header>

<main id="top">

<!-- ============ HERO ============ -->
<section class="hero" aria-label="Motor Corp, holding automobile">
  <canvas class="hero__canvas" id="speed" aria-hidden="true"></canvas>
  <div class="hero__grid" aria-hidden="true"></div>
  <div class="hero__vignette" aria-hidden="true"></div>

  <div class="hero__inner" id="hero-inner">
    <span class="label">Holding automobile · Paris</span>
    <svg class="mc" viewBox="0 0 300 130" role="img" aria-label="Monogramme MC">
        <defs>
          <linearGradient id="mc-chr" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0%" stop-color="#ffffff"/><stop offset="42%" stop-color="#d3d7dc"/><stop offset="52%" stop-color="#7a8087"/><stop offset="63%" stop-color="#cfd4da"/><stop offset="100%" stop-color="#f4f6f8"/>
          </linearGradient>
          <linearGradient id="mc-red" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0%" stop-color="#ff3b43"/><stop offset="55%" stop-color="#d8161f"/><stop offset="100%" stop-color="#8f0b12"/>
          </linearGradient>
          <linearGradient id="mc-sheen" x1="0" y1="0" x2="1" y2="0">
            <stop offset="0%" stop-color="#fff" stop-opacity="0"/><stop offset="50%" stop-color="#fff" stop-opacity=".9"/><stop offset="100%" stop-color="#fff" stop-opacity="0"/>
          </linearGradient>
          <clipPath id="mc-clip">
            <path d="M10 118V12h30l44 58 44-58h30v106h-26V52l-48 62-48-62v66Z" transform="skewX(-12) translate(22 0)"/>
            <path d="M202 12h48v24h-40c-5 0-8 3-8 8v42c0 5 3 8 8 8h56v24h-64c-18 0-28-10-28-28V40c0-18 10-28 28-28Z" transform="skewX(-12) translate(22 0)"/>
          </clipPath>
        </defs>
        <g transform="skewX(-12) translate(22 0)">
          <path d="M10 118V12h30l44 58 44-58h30v106h-26V52l-48 62-48-62v66Z" fill="url(#mc-chr)" stroke="#2b2f34" stroke-width="1.2" stroke-linejoin="round"/>
          <path d="M202 12h48v24h-40c-5 0-8 3-8 8v42c0 5 3 8 8 8h56v24h-64c-18 0-28-10-28-28V40c0-18 10-28 28-28Z" fill="url(#mc-chr)" stroke="#2b2f34" stroke-width="1.2" stroke-linejoin="round"/>
          <path d="M258 12h34l-8 24h-34Z" fill="url(#mc-red)"/>
        </g>
        <rect class="mc__sheen" x="-120" y="0" width="120" height="130" fill="url(#mc-sheen)" clip-path="url(#mc-clip)" opacity=".7"/>
      </svg>
    <h1 class="hero__name chrome chrome--live">MOTOR CORP</h1>
    <p class="hero__sub chrome"><i></i>HOLDING<i></i></p>
    <p class="hero__tag"><b>Performance.</b> <b>Passion.</b> <b>Partenariat.</b></p>
    <p class="hero__lead">Un groupe, deux expertises. La carrosserie et le conseil automobile, réunis pour accompagner chaque véhicule — de la recherche à la remise en état.</p>
    <div class="hero__actions">
      <a class="btn btn--primary" href="#marques">Découvrir nos marques <span aria-hidden="true">→</span></a>
      <a class="btn" href="#groupe">Le groupe</a>
    </div>
  </div>
  <a class="scroll-cue" href="#groupe" aria-label="Faire défiler"><i></i>Défiler</a>
</section>

<!-- ============ BANDEAU ============ -->
<div class="marquee" aria-hidden="true">
  <div class="marquee__track">
    <span>Performance</span><span>Passion</span><span>Partenariat</span><span>Motor Studio</span><span>Motor Consulting</span><span>Motor Corp Holding</span>
    <span>Performance</span><span>Passion</span><span>Partenariat</span><span>Motor Studio</span><span>Motor Consulting</span><span>Motor Corp Holding</span>
  </div>
</div>

<!-- ============ LE GROUPE ============ -->
<section class="section" id="groupe">
  <div class="container group">
    <div class="group__text reveal">
      <span class="label">Le groupe</span>
      <h2>Une vision : l'automobile sans compromis</h2>
      <p class="lead" style="margin-bottom:1.2em">Motor Corp est la holding qui réunit deux métiers complémentaires sous une même exigence.</p>
      <p><strong>Motor Consulting</strong> trouve, expertise, négocie et vend les véhicules. <strong>Motor Studio</strong> les répare, les restaure et les sublime. Entre les deux, un seul fil conducteur : livrer à chaque client une voiture dont il est sûr — mécaniquement, esthétiquement, administrativement.</p>
      <p>Cette organisation nous permet de maîtriser l'intégralité du parcours d'un véhicule, sans intermédiaire ni sous-traitance opaque, et de garantir le même niveau de qualité à chaque étape.</p>
      <ul class="stats">
        <li><strong>2</strong>marques</li>
        <li><strong>1</strong>parcours complet</li>
        <li><strong>100 %</strong>indépendant</li>
        <li><strong>Paris</strong>&amp; Île-de-France</li>
      </ul>
    </div>
    <div class="pillars">
      <article class="pillar reveal">
        <span class="pillar__num">01</span>
        <h3>Performance</h3>
        <p>Des process précis, des délais tenus et des résultats mesurables. Chaque véhicule est traité comme un dossier à part entière, avec un rapport écrit et des engagements chiffrés.</p>
      </article>
      <article class="pillar reveal reveal--d1">
        <span class="pillar__num">02</span>
        <h3>Passion</h3>
        <p>Nous sommes d'abord des passionnés. C'est ce qui nous fait refuser un véhicule douteux, reprendre une peinture jusqu'au bon rendu, et défendre le juste prix jusqu'au dernier euro.</p>
      </article>
      <article class="pillar reveal reveal--d2">
        <span class="pillar__num">03</span>
        <h3>Partenariat</h3>
        <p>Particuliers, professionnels, assureurs, loueurs : nous construisons des relations de long terme, fondées sur la transparence et la confiance plutôt que sur le volume.</p>
      </article>
    </div>
  </div>
</section>

<!-- ============ NOS MARQUES ============ -->
<section class="section" id="marques">
  <div class="container">
    <header class="section__head reveal">
      <span class="label">Nos marques</span>
      <h2>Deux maisons, une même signature</h2>
      <p class="lead">Chaque marque a son métier, son équipe et son site. Toutes deux partagent l'exigence Motor Corp.</p>
    </header>
    <div class="brands">
      <a class="bcard reveal tilt" href="<?php echo esc_url( corp_opt( 'studio_url' ) ); ?>" aria-label="Accéder au site Motor Studio, carrosserie">
        <span class="bcard__num">01</span>
        <div class="bcard__logo"><svg class="mark" viewBox="0 0 300 96" aria-hidden="true">
            <defs>
              <linearGradient id="mk-chr-s" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#ffffff"/><stop offset="45%" stop-color="#cfd4da"/><stop offset="55%" stop-color="#6c727a"/><stop offset="100%" stop-color="#f1f4f7"/>
              </linearGradient>
              <linearGradient id="mk-gld-s" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%" stop-color="#8a6e1e"/><stop offset="40%" stop-color="#f3e2a4"/><stop offset="60%" stop-color="#d4af37"/><stop offset="100%" stop-color="#8a6e1e"/>
              </linearGradient>
            </defs>
            <path d="M126 46V32l24-18 24 18v14" fill="none" stroke="url(#mk-gld-s)" stroke-width="5.5" stroke-linejoin="round" stroke-linecap="round"/>
            <path d="M2 80C34 62 68 46 108 38c34-7 72-7 108 0 34 7 60 20 80 40-26-14-56-22-90-24-44-3-90 4-130 14-26 6-50 12-74 12Z" fill="url(#mk-chr-s)"/>
            <path d="M60 86c40-10 90-14 180-8" fill="none" stroke="url(#mk-chr-s)" stroke-width="3.5" stroke-linecap="round"/>
          </svg>
          <span class="mark__name chrome">MOTOR</span>
          <span class="mark__sub"><i></i>STUDIO<i></i></span></div>
        <p class="bcard__kicker">Carrosserie</p>
        <p class="bcard__desc">L'atelier du groupe. Réparation, peinture, débosselage et remise en état de véhicules, du quotidien au premium.</p>
        <ul class="bcard__list">
          <li>Carrosserie et peinture toutes marques</li>
          <li>Prise en charge assurance et véhicule de courtoisie</li>
          <li>Préparation esthétique et protection</li>
        </ul>
        <span class="btn bcard__cta">Accéder au site <span aria-hidden="true">→</span></span>
      </a>
      <a class="bcard reveal reveal--d1 tilt" href="<?php echo esc_url( corp_opt( 'consulting_url' ) ); ?>" aria-label="Accéder au site Motor Consulting, l'expertise automobile à votre service">
        <span class="bcard__num">02</span>
        <div class="bcard__logo"><svg class="mark" viewBox="0 0 300 96" aria-hidden="true">
            <defs>
              <linearGradient id="mk-chr-c" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#ffffff"/><stop offset="45%" stop-color="#cfd4da"/><stop offset="55%" stop-color="#6c727a"/><stop offset="100%" stop-color="#f1f4f7"/>
              </linearGradient>
              <linearGradient id="mk-gld-c" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0%" stop-color="#8a6e1e"/><stop offset="40%" stop-color="#f3e2a4"/><stop offset="60%" stop-color="#d4af37"/><stop offset="100%" stop-color="#8a6e1e"/>
              </linearGradient>
            </defs>
            <path d="M126 46V32l24-18 24 18v14" fill="none" stroke="url(#mk-gld-c)" stroke-width="5.5" stroke-linejoin="round" stroke-linecap="round"/>
            <path d="M2 80C34 62 68 46 108 38c34-7 72-7 108 0 34 7 60 20 80 40-26-14-56-22-90-24-44-3-90 4-130 14-26 6-50 12-74 12Z" fill="url(#mk-chr-c)"/>
            <path d="M60 86c40-10 90-14 180-8" fill="none" stroke="url(#mk-chr-c)" stroke-width="3.5" stroke-linecap="round"/>
          </svg>
          <span class="mark__name chrome">MOTOR</span>
          <span class="mark__sub"><i></i>CONSULTING<i></i></span></div>
        <p class="bcard__kicker">L'expertise automobile à votre service</p>
        <p class="bcard__desc">Le conseil du groupe. Recherche, négociation, achat, vente et location de véhicules d'occasion, pour particuliers et professionnels.</p>
        <ul class="bcard__list">
          <li>Recherche et achat pour compte de tiers</li>
          <li>Expertise, estimation gratuite et négociation</li>
          <li>Vente accompagnée et location</li>
        </ul>
        <span class="btn bcard__cta">Accéder au site <span aria-hidden="true">→</span></span>
      </a>
    </div>
  </div>
</section>

<!-- ============ SYNERGIES ============ -->
<section class="section" id="synergies">
  <div class="container">
    <header class="section__head reveal">
      <span class="label">Synergies</span>
      <h2>Un parcours complet, sous un même toit</h2>
      <p class="lead">Ce que le groupe rend possible : un véhicule suivi de bout en bout, par des équipes qui se parlent.</p>
    </header>
    <ol class="path">
      <li class="pstep reveal">
        <span class="pstep__tag"><em class="red">01</em> · Motor Consulting</span>
        <h3>Trouver</h3>
        <p>Recherche du véhicule selon votre cahier des charges, partout en France, et négociation du prix.</p>
      </li>
      <li class="pstep reveal reveal--d1">
        <span class="pstep__tag"><em class="red">02</em> · Motor Consulting</span>
        <h3>Expertiser</h3>
        <p>Inspection mécanique et carrosserie, vérification de l'historique, rapport écrit avant tout engagement.</p>
      </li>
      <li class="pstep reveal reveal--d2">
        <span class="pstep__tag"><em class="red">03</em> · Motor Studio</span>
        <h3>Remettre en état</h3>
        <p>Les défauts relevés à l'expertise sont traités à l'atelier : carrosserie, peinture, préparation esthétique.</p>
      </li>
      <li class="pstep reveal reveal--d3">
        <span class="pstep__tag"><em class="red">04</em> · Motor Corp</span>
        <h3>Livrer et suivre</h3>
        <p>Transaction sécurisée, administratif géré, puis entretien esthétique et revente accompagnée le moment venu.</p>
      </li>
    </ol>
  </div>
</section>

<!-- ============ CONTACT ============ -->
<section class="section" id="contact">
  <div class="container contact">
    <div class="reveal">
      <span class="label">Contact</span>
      <h2>Parlons de votre projet</h2>
      <p class="lead">Une question sur le groupe, un partenariat, un projet pour votre flotte&nbsp;? Écrivez-nous, ou adressez-vous directement à la marque concernée.</p>
      <div class="contact__cta" style="margin-top:32px">
        <a class="btn" href="<?php echo esc_url( corp_opt( 'studio_url' ) ); ?>">Motor Studio <span aria-hidden="true">→</span></a>
        <a class="btn" href="<?php echo esc_url( corp_opt( 'consulting_url' ) ); ?>#contact">Motor Consulting <span aria-hidden="true">→</span></a>
      </div>
    </div>
    <ul class="infos reveal reveal--d1">
      <li><strong>E-mail</strong><a href="mailto:<?php echo esc_html( corp_opt( 'email' ) ); ?>"><?php echo esc_html( corp_opt( 'email' ) ); ?></a></li>
      <li><strong>Téléphone</strong><a href="tel:<?php echo esc_attr( corp_opt( 'phone_e164' ) ); ?>"><?php echo esc_html( corp_opt( 'phone_display' ) ); ?></a></li>
      <li><strong>Adresse</strong><span><?php echo esc_html( corp_opt( 'address' ) ); ?></span></li>
      <li><strong>Marques</strong><span>Motor Studio · Motor Consulting</span></li>
    </ul>
  </div>
</section>

</main>

<footer class="footer">
  <div class="container footer__inner">
    <p style="margin:0">© <span id="year">2026</span> Motor Corp — Holding automobile</p>
    <ul>
      <li><a href="<?php echo esc_url( corp_opt( 'studio_url' ) ); ?>">Motor Studio</a></li>
      <li><a href="<?php echo esc_url( corp_opt( 'consulting_url' ) ); ?>">Motor Consulting</a></li>
      <li><a href="<?php echo esc_url( corp_opt( 'consulting_url' ) ); ?>#apropos">Mentions légales</a></li>
    </ul>
  </div>
</footer>

<!-- Symbole MC réutilisé dans l'en-tête -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <symbol id="mc-sym" viewBox="0 0 300 130">
    <g transform="skewX(-12) translate(22 0)">
      <path d="M10 118V12h30l44 58 44-58h30v106h-26V52l-48 62-48-62v66Z" fill="url(#mc-chr)"/>
      <path d="M202 12h48v24h-40c-5 0-8 3-8 8v42c0 5 3 8 8 8h56v24h-64c-18 0-28-10-28-28V40c0-18 10-28 28-28Z" fill="url(#mc-chr)"/>
      <path d="M258 12h34l-8 24h-34Z" fill="url(#mc-red)"/>
    </g>
  </symbol>
</svg>

<script>
(function () {
  "use strict";
  const reduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  const $ = (s, c) => (c || document).querySelector(s);
  const $$ = (s, c) => Array.from((c || document).querySelectorAll(s));

  /* ---- Header & menu ---- */
  const header = $("#header"), nav = $("#nav"), burger = $("#burger");
  const onScroll = () => header.classList.toggle("is-scrolled", window.scrollY > 30);
  window.addEventListener("scroll", onScroll, { passive: true }); onScroll();
  burger.addEventListener("click", () => {
    const open = nav.classList.toggle("is-open");
    burger.setAttribute("aria-expanded", String(open));
  });
  $$("a", nav).forEach(a => a.addEventListener("click", () => { nav.classList.remove("is-open"); burger.setAttribute("aria-expanded", "false"); }));

  /* ---- Lien actif ---- */
  const links = $$(".nav a");
  if ("IntersectionObserver" in window) {
    const spy = new IntersectionObserver(es => es.forEach(e => {
      if (e.isIntersecting) links.forEach(l => l.classList.toggle("is-active", l.getAttribute("href") === "#" + e.target.id));
    }), { rootMargin: "-45% 0px -50% 0px" });
    $$("main section[id]").forEach(s => spy.observe(s));

    /* ---- Apparitions ---- */
    const io = new IntersectionObserver((es, obs) => es.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add("is-in"); obs.unobserve(e.target); }
    }), { threshold: .15 });
    $$(".reveal").forEach(el => io.observe(el));
  } else {
    $$(".reveal").forEach(el => el.classList.add("is-in"));
  }

  /* ---- Fond animé : lignes de vitesse ---- */
  const canvas = $("#speed");
  if (canvas && !reduced) {
    const ctx = canvas.getContext("2d");
    let w, h, cx, cy, dpr, particles = [], raf, running = true;
    const N = 170;
    const resize = () => {
      dpr = Math.min(window.devicePixelRatio || 1, 2);
      w = canvas.clientWidth; h = canvas.clientHeight;
      canvas.width = w * dpr; canvas.height = h * dpr;
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
      cx = w / 2; cy = h * .42;
    };
    const spawn = (p) => {
      const a = Math.random() * Math.PI * 2;
      p.a = a; p.r = Math.random() * 40; p.v = .6 + Math.random() * 1.6;
      p.red = Math.random() < .08; p.life = 0;
      return p;
    };
    const init = () => { particles = Array.from({ length: N }, () => spawn({})); };
    const step = () => {
      if (!running) return;
      ctx.clearRect(0, 0, w, h);
      const maxR = Math.hypot(w, h) * .6;
      for (const p of particles) {
        p.r += p.v * (1 + p.r / 120); p.life++;
        if (p.r > maxR) spawn(p);
        const x1 = cx + Math.cos(p.a) * p.r, y1 = cy + Math.sin(p.a) * p.r;
        const len = 6 + p.r * .14;
        const x0 = cx + Math.cos(p.a) * Math.max(0, p.r - len), y0 = cy + Math.sin(p.a) * Math.max(0, p.r - len);
        const alpha = Math.min(1, p.r / 160) * (p.red ? .85 : .55);
        ctx.strokeStyle = p.red ? `rgba(216,22,31,${alpha})` : `rgba(205,210,216,${alpha})`;
        ctx.lineWidth = p.red ? 1.4 : .9;
        ctx.beginPath(); ctx.moveTo(x0, y0); ctx.lineTo(x1, y1); ctx.stroke();
      }
      raf = requestAnimationFrame(step);
    };
    resize(); init(); step();
    window.addEventListener("resize", () => { resize(); });
    document.addEventListener("visibilitychange", () => {
      running = !document.hidden;
      if (running) step(); else cancelAnimationFrame(raf);
    });
  }

  /* ---- Parallaxe souris sur le bloc central ---- */
  const inner = $("#hero-inner");
  if (inner && !reduced && window.matchMedia("(pointer:fine)").matches) {
    let tx = 0, ty = 0, x = 0, y = 0;
    window.addEventListener("mousemove", e => {
      tx = (e.clientX / window.innerWidth - .5) * 18; ty = (e.clientY / window.innerHeight - .5) * 12;
    }, { passive: true });
    const loop = () => { x += (tx - x) * .06; y += (ty - y) * .06; inner.style.transform = `translate(${x}px,${y}px)`; requestAnimationFrame(loop); };
    loop();
  }

  /* ---- Cartes des marques : inclinaison et halo suivant le curseur ---- */
  if (!reduced && window.matchMedia("(pointer:fine)").matches) {
    $$(".tilt").forEach(card => {
      card.addEventListener("mousemove", e => {
        const r = card.getBoundingClientRect();
        const px = (e.clientX - r.left) / r.width, py = (e.clientY - r.top) / r.height;
        card.style.setProperty("--mx", (px * 100) + "%"); card.style.setProperty("--my", (py * 100) + "%");
        card.style.transform = `perspective(1100px) rotateX(${(py - .5) * -6}deg) rotateY(${(px - .5) * 8}deg) translateY(-4px)`;
      });
      card.addEventListener("mouseleave", () => { card.style.transform = ""; });
    });
  }

  $("#year").textContent = new Date().getFullYear();
})();
</script>
<?php wp_footer(); ?>
</body>
</html>
