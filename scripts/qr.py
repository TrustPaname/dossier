#!/usr/bin/env python3
"""Génère les QR codes de la page Motor Corp (SVG, sans dépendance à l'exécution).

Usage : python3 scripts/qr.py [URL_STUDIO] [URL_CONSULTING] [DOSSIER_SORTIE]
Pré-requis : pip install segno
"""
import sys, segno

studio     = sys.argv[1] if len(sys.argv) > 1 else "https://www.motor-studio.fr/"
consulting = sys.argv[2] if len(sys.argv) > 2 else "https://www.motor-consulting.fr/"
outdir     = sys.argv[3] if len(sys.argv) > 3 else "motor-corp"

def qr_svg(url, label):
    qr = segno.make(url, error="m")
    matrix = [list(row) for row in qr.matrix]
    n = len(matrix); quiet = 2; size = n + 2 * quiet
    cells = []
    for y, row in enumerate(matrix):
        run_start = None
        for x, v in enumerate(row + [0]):
            if v and run_start is None:
                run_start = x
            elif not v and run_start is not None:
                cells.append(f"M{run_start + quiet} {y + quiet}h{x - run_start}v1h-{x - run_start}z")
                run_start = None
    path = "".join(cells)
    return (f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {size} {size}" shape-rendering="crispEdges" '
            f'role="img" aria-label="{label}">'
            f'<rect width="{size}" height="{size}" rx="1.2" fill="#d9dde2"/>'
            f'<path d="{path}" fill="#0b0b0c"/></svg>')

for name, url, label in (("qr-studio", studio, "QR code vers le site Motor Studio"),
                         ("qr-consulting", consulting, "QR code vers le site Motor Consulting")):
    with open(f"{outdir}/{name}.svg", "w", encoding="utf-8") as f:
        f.write(qr_svg(url, label))
    print(f"{outdir}/{name}.svg ← {url}")
