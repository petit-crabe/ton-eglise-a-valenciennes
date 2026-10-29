"""Export the *-charte boards of the canvas to design/maquettes/ as plain HTML.

usage: python3 export_maquettes.py <canvas project dir> <repo design/maquettes dir>
Shows the default state: the latest sermon and three upcoming events."""
import os, re, sys

SRC, OUT = sys.argv[1], sys.argv[2]
CANVAS = "https://claude.ai/artifact/UbLoYdhe5z2A3no2cDeo5u"
DATE = "2026-10-29"

PAGES = {
    "Accueil": ("home", "home", "home page"),
    "Qui-sommes-nous": ("church", "who-we-are", "\"Qui sommes-nous ?\""),
    "Equipe": ("church", "team", "\"L'équipe\""),
    "Notre-histoire": ("church", "history", "\"Notre histoire\""),
    "Evenements": ("events", "events", "\"Évènements\""),
    "Evenement": ("events", "event", "single event"),
    "Predications": ("sermons", "sermons", "\"Prédications\""),
    "Predication": ("sermons", "sermon", "single sermon"),
    "Contact": ("contact", "contact", "\"Nous contacter\""),
    "Don": ("donate", "donate", "\"Faire un don\""),
    "Entretien": ("forms", "interview", "\"Demande d'entretien\""),
    "Priere": ("forms", "prayer", "\"Demande de prière\""),
    "Servir": ("forms", "serve", "\"Servir à l'église\""),
    "Donnees": ("legal", "privacy", "\"Protection des données\""),
    "Conditions": ("legal", "terms", "\"Conditions générales\""),
    "Mentions": ("legal", "legal-notice", "\"Mentions légales\""),
}
BLOBS = {
    "0539f0012d7824fc385a9795071dc942": "vision.jpg",
    "513278200da79a2601d13dcd3ae8d93d": "logo-color.png",
    "6439ea63be316dd7de4c6b58170eebc2": "map.png",
    "78c1d11448c0dad69a505e1d26e1a474": "church-front.jpg",
    "b273af9e48439e9be1d5f414b7ca3fba": "congregation.jpg",
    "bdbccc094e7c470502f9d22616d34b57": "pastor-couple.jpg",
    "dd5d8b616197d3ba424b25a1bc819367": "logo-white.png",
    "f4aa364211b32a70c240f4440d6ff2c1": "sermon-latest.jpg",
    "f8b3f9e1f54cd1e9206abffc31d1a5d4": "hall.jpg",
}
KEEP = {"hasEvents": True, "noEvents": False, "live": False, "notLive": True}

# every image already exists somewhere in design/maquettes/
STOCK = {}
for d in os.listdir(OUT):
    imgs = os.path.join(OUT, d, "images")
    if os.path.isdir(imgs):
        for f in os.listdir(imgs):
            STOCK.setdefault(f, os.path.join(imgs, f))
STOCK = {k: open(v, "rb").read() for k, v in STOCK.items()}

def resolve_ifs(s):
    """Keep or drop <sc-if> blocks according to KEEP (blocks may nest)."""
    tag = re.compile(r'<sc-if value="\{\{(\w+)\}\}"[^>]*>|</sc-if>')
    while True:
        opens = [m for m in tag.finditer(s) if m.group(0) != "</sc-if>"]
        if not opens:
            return s
        # innermost: an opening tag followed by a closing tag with no opening tag in between
        for m in reversed(opens):
            close = s.index("</sc-if>", m.end())
            inner = s[m.end():close]
            if "<sc-if" not in inner:
                s = s[:m.start()] + (inner if KEEP[m.group(1)] else "") + s[close + len("</sc-if>"):]
                break

def target(base, phone, here_folder):
    folder, slug, _ = PAGES[base]
    name = f"{slug}-{'mobile' if phone else 'desktop'}.html"
    return name if folder == here_folder else f"../{folder}/{name}"

used = {}
for base, (folder, slug, label) in PAGES.items():
    for phone in (False, True):
        s = open(os.path.join(SRC, f"{base}-charte{'-telephone' if phone else ''}.dc.html")).read()
        title = re.search(r"<title>(.*?)</title>", s).group(1).replace(" – nouvelle charte", "")
        helmet = s[s.index("<helmet>") + 8:s.index("</helmet>")].strip("\n")
        body = s[s.index("</helmet>") + 9:s.index("</x-dc>")].strip("\n")
        body = resolve_ifs(body)
        assert "{{" not in body and "<sc-" not in body, base
        for blob, img in BLOBS.items():
            if blob in body:
                used.setdefault(folder, set()).add(img)
            body = body.replace(f"/_blob/{blob}", f"images/{img}")
        assert "/_blob/" not in body, base
        body = re.sub(r'href="([A-Za-z-]+)-charte(-telephone)?\.dc\.html(#[^"]*)?"',
                      lambda m: f'href="{target(m.group(1), bool(m.group(2)), folder)}{m.group(3) or ""}"', body)
        assert ".dc.html" not in body, base
        if phone:
            # the board's fixed canvas frame becomes a centred 390 px column
            body, n = re.subn(r'<div style="width: 390px; min-height: \d+px; ', '<div style="max-width: 390px; margin: 0 auto; ', body, count=1)
            assert n == 1, base
        body = re.sub(r"\n{3,}", "\n\n", body)
        size = "phone, 390 px" if phone else "computer, 1440 px"
        html = f"""<!doctype html>
<!-- Validated {label} mockup ({size}), new charter, exported from the Claude Design canvas
     {CANVAS} on {DATE}.
     Values come from ../../tokens.json; see ../../DESIGN.md for the rules. -->
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{title}</title>
{helmet}
</head>
<body>
{body}
</body>
</html>
"""
        path = os.path.join(OUT, folder, target(base, phone, folder))
        open(path, "w").write(html)
        print(path, len(html))

# each folder's images/ holds exactly the images its pages use
for folder, imgs in used.items():
    d = os.path.join(OUT, folder, "images")
    for f in os.listdir(d):
        if f not in imgs:
            os.remove(os.path.join(d, f))
            print("removed", folder, f)
    for img in imgs:
        p = os.path.join(d, img)
        if not os.path.exists(p):
            open(p, "wb").write(STOCK[img])
            print("added", folder, img)
