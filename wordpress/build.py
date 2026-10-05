#!/usr/bin/env python3
"""Construit les deux thèmes WordPress à partir des sources du dépôt.

  python3 wordpress/build.py

Produit wordpress/motor-consulting/ et wordpress/motor-corp/ (front-page.php + assets)
puis wordpress/motor-consulting.zip et wordpress/motor-corp.zip, prêts à téléverser
dans Apparence → Thèmes → Ajouter → Téléverser un thème.
"""
import os, re, shutil, zipfile

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
WP   = os.path.join(ROOT, "wordpress")
URI  = "<?php echo esc_url( get_template_directory_uri() ); ?>"

def php_head_foot(html):
    html = html.replace('<html lang="fr">', '<html <?php language_attributes(); ?>>')
    html = html.replace('</head>', '<?php wp_head(); ?>\n</head>')
    html = html.replace('<body>', '<body <?php body_class(); ?>>')
    html = html.replace('</body>', '<?php wp_footer(); ?>\n</body>')
    return html

def copy_tree(src, dst):
    if os.path.isdir(dst):
        shutil.rmtree(dst)
    shutil.copytree(src, dst)

# ---------------------------------------------------------------- Motor Consulting
def build_consulting():
    theme = os.path.join(WP, "motor-consulting")
    html  = open(os.path.join(ROOT, "index.html"), encoding="utf-8").read()
    html  = '<?php\n/**\n * Page d\'accueil Motor Consulting — générée par wordpress/build.py à partir de index.html.\n * Ne pas modifier ici : modifiez index.html à la racine puis relancez le script.\n */\n?>\n' + html

    # ressources gérées par functions.php
    html = re.sub(r'<link rel="stylesheet" href="assets/css/styles.css">\n', '', html)
    html = re.sub(r'<link rel="manifest" href="site.webmanifest">\n', '', html)
    html = re.sub(r'<script src="assets/js/[^"]+" defer></script>\n', '', html)
    html = html.replace('href="assets/img/favicon.svg"', f'href="{URI}/assets/img/favicon.svg"')
    html = html.replace('https://www.motor-consulting.fr/assets/img/og-cover.png', f'{URI}/assets/img/og-cover.png')
    html = html.replace('href="https://www.motor-consulting.fr/"', 'href="<?php echo esc_url( home_url( \'/\' ) ); ?>"')
    html = html.replace('content="https://www.motor-consulting.fr/"', 'content="<?php echo esc_url( home_url( \'/\' ) ); ?>"')
    html = html.replace('"url": "https://www.motor-consulting.fr/"', '"url": "<?php echo esc_url( home_url( \'/\' ) ); ?>"')

    # coordonnées → Personnalisateur
    rep = {
        '06 12 34 56 78'                          : "<?php echo esc_html( motor_opt( 'phone_display' ) ); ?>",
        '+33612345678'                            : "<?php echo esc_attr( motor_opt( 'phone_e164' ) ); ?>",
        'wa.me/33612345678'                       : "wa.me/<?php echo esc_attr( motor_opt( 'whatsapp' ) ); ?>",
        'contact@motor-consulting.fr'             : "<?php echo esc_html( motor_opt( 'email' ) ); ?>",
        '24 avenue de la Grande-Armée, 75017 Paris': "<?php echo esc_html( motor_opt( 'address' ) ); ?>",
        'Lun–Ven 9h–19h · Sam 10h–17h'            : "<?php echo esc_html( motor_opt( 'hours' ) ); ?>",
    }
    for a, b in rep.items():
        html = html.replace(a, b)
    # l'adresse postale structurée du JSON-LD reste à compléter à la main (rue / code postal / ville)

    html = php_head_foot(html)
    open(os.path.join(theme, "front-page.php"), "w", encoding="utf-8").write(html)

    copy_tree(os.path.join(ROOT, "assets"), os.path.join(theme, "assets"))
    print("thème motor-consulting : front-page.php + assets")

# ---------------------------------------------------------------- Motor Corp
def build_corp():
    theme = os.path.join(WP, "motor-corp")
    html  = open(os.path.join(ROOT, "motor-corp", "index.html"), encoding="utf-8").read()
    html  = '<?php\n/**\n * Page d\'accueil Motor Corp — générée par wordpress/build.py à partir de motor-corp/index.html.\n */\n?>\n' + html
    html = html.replace("url('../assets/fonts/", f"url('{URI}/assets/fonts/")
    html = html.replace('src="../assets/img/', f'src="{URI}/assets/img/')
    html = html.replace('href="favicon.svg"', f'href="{URI}/favicon.svg"')
    html = html.replace('href="https://www.motor-corp.fr/"', 'href="<?php echo esc_url( home_url( \'/\' ) ); ?>"')
    html = html.replace('content="https://www.motor-corp.fr/"', 'content="<?php echo esc_url( home_url( \'/\' ) ); ?>"')
    rep = {
        'https://www.motor-studio.fr/'             : "<?php echo esc_url( corp_opt( 'studio_url' ) ); ?>",
        '../index.html#contact'                    : "<?php echo esc_url( corp_opt( 'consulting_url' ) ); ?>#contact",
        '../index.html#apropos'                    : "<?php echo esc_url( corp_opt( 'consulting_url' ) ); ?>#apropos",
        '../index.html'                            : "<?php echo esc_url( corp_opt( 'consulting_url' ) ); ?>",
        'contact@motor-corp.fr'                    : "<?php echo esc_html( corp_opt( 'email' ) ); ?>",
        '06 12 34 56 78'                           : "<?php echo esc_html( corp_opt( 'phone_display' ) ); ?>",
        '+33612345678'                             : "<?php echo esc_attr( corp_opt( 'phone_e164' ) ); ?>",
        '24 avenue de la Grande-Armée, 75017 Paris': "<?php echo esc_html( corp_opt( 'address' ) ); ?>",
    }
    for a, b in rep.items():
        html = html.replace(a, b)
    html = php_head_foot(html)
    open(os.path.join(theme, "front-page.php"), "w", encoding="utf-8").write(html)

    fonts = os.path.join(theme, "assets", "fonts")
    copy_tree(os.path.join(ROOT, "assets", "fonts"), fonts)
    img = os.path.join(theme, "assets", "img"); os.makedirs(img, exist_ok=True)
    for f in ("logo-motor-corp.png", "logo-motors-studio.png", "logo-motor-consulting-600.png"):
        shutil.copy(os.path.join(ROOT, "assets", "img", f), os.path.join(img, f))
    shutil.copy(os.path.join(ROOT, "motor-corp", "favicon.svg"), os.path.join(theme, "favicon.svg"))
    print("thème motor-corp : front-page.php + polices")

# ---------------------------------------------------------------- Archives
def zip_theme(name):
    theme = os.path.join(WP, name)
    out   = os.path.join(WP, name + ".zip")
    with zipfile.ZipFile(out, "w", zipfile.ZIP_DEFLATED) as z:
        for base, _, files in os.walk(theme):
            for f in files:
                full = os.path.join(base, f)
                z.write(full, os.path.join(name, os.path.relpath(full, theme)))
    print(f"{out} ({os.path.getsize(out) // 1024} Ko)")

if __name__ == "__main__":
    build_consulting()
    build_corp()
    zip_theme("motor-consulting")
    zip_theme("motor-corp")
