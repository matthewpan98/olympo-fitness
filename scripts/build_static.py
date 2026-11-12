#!/usr/bin/env python3
"""Genera una versione statica (demo) del sito per GitHub Pages.

Richiede il sito PHP in esecuzione con il database popolato, ad es.:
  DB_HOST=localhost DB_USER=demo DB_PASSWORD=demo DB_NAME=demo \
    php -S 127.0.0.1:8080 -t website
Poi:  python3 scripts/build_static.py [base_url] [out_dir]
"""
import re, shutil, sys, urllib.request
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
SRC = ROOT / "website"
BASE = sys.argv[1] if len(sys.argv) > 1 else "http://127.0.0.1:8080/"
OUT = Path(sys.argv[2]) if len(sys.argv) > 2 else ROOT / "docs"

BANNER = ('<p style="margin:0;padding:.5em 1em;background:#222;color:#fff;'
          'text-align:center;font-size:.9em" role="note">Versione demo statica: '
          'login, registrazione e carrello non sono attivi.</p>')
FORM_JS = "alert('Versione demo statica: questa funzione non è disponibile.');return false;"

def static_name(link):
    m = re.fullmatch(r"prodotto\.php\?id=(\d+)", link)
    if m:
        return f"prodotto-{m.group(1)}.html"
    if link == "logout.php":
        return "index.html"
    if link.endswith(".php"):
        return link[:-4] + ".html"
    return link

def rewrite(html):
    def href(m):
        return f'{m.group(1)}="{static_name(m.group(2))}"'
    html = re.sub(r'(href)="([A-Za-z0-9_]+\.php(?:\?id=\d+)?)"', href, html)
    html = re.sub(r'<form\b[^>]*>',
                  lambda m: f'<form action="#" onsubmit="{FORM_JS}">', html)
    html = re.sub(r'(<body[^>]*>)', r'\1' + BANNER, html, count=1)
    return html

def fetch(path):
    with urllib.request.urlopen(BASE + path) as r:
        return r.read().decode("utf-8")

if OUT.exists():
    shutil.rmtree(OUT)
OUT.mkdir(parents=True)
for item in ["images", "javascript"]:
    shutil.copytree(SRC / item, OUT / item)
for css in SRC.glob("*.css"):
    shutil.copy(css, OUT)
for page in ["chiSiamo.html", "error500.html"]:
    (OUT / page).write_text(rewrite((SRC / page).read_text("utf-8")), "utf-8")
(OUT / "404.html").write_text(rewrite((SRC / "error404.html").read_text("utf-8")), "utf-8")
(OUT / ".nojekyll").write_text("")

queue, seen = ["index.php"], set()
while queue:
    link = queue.pop()
    if link in seen:
        continue
    seen.add(link)
    html = fetch(link)
    for l in re.findall(r'href="([A-Za-z0-9_]+\.php(?:\?id=\d+)?)"', html):
        if l != "logout.php":
            queue.append(l)
    (OUT / static_name(link)).write_text(rewrite(html), "utf-8")
    print("ok", link, "->", static_name(link))
