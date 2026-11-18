"""Export the *-charte boards of the canvas to design/maquettes/ as plain HTML.

usage: python3 export_maquettes.py <canvas project dir> <repo design/maquettes dir>
Shows the default state: the latest sermon and three upcoming events."""
import os, re, sys

SRC, OUT = sys.argv[1], sys.argv[2]
CANVAS = "https://claude.ai/artifact/UbLoYdhe5z2A3no2cDeo5u"
DATE = "2026-11-09"

PAGES = {
    "Accueil": ("home", "home", "home page"),
    "Eglise": ("church", "church", "\"L'église\""),
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
ANCHOR_SCRIPT = """
<style>
.snapfx #accueil>*:not(.anchor-nav),.snapfx #bienvenue>*,.snapfx #evenements>*,.snapfx #predication>*{transition:opacity 1.2s ease .15s;opacity:.15}
.snapfx[data-cur="accueil"] #accueil>*:not(.anchor-nav),.snapfx[data-cur="bienvenue"] #bienvenue>*,.snapfx[data-cur="evenements"] #evenements>*,.snapfx[data-cur="predication"] #predication>*{opacity:1}
.anchor-nav--touch .anchor-label{opacity:0;transition:opacity .4s}.anchor-nav--touch a.flash .anchor-label{opacity:1}.anchor-nav--touch a > span:last-child{position:relative}
@media (prefers-reduced-motion: reduce){.snapfx #accueil>*:not(.anchor-nav),.snapfx #bienvenue>*,.snapfx #evenements>*,.snapfx #predication>*{transition:none;opacity:1}}
</style>
<script>
(() => {
  const nav = document.querySelector('.anchor-nav');
  if (!nav) return;
  const touch = nav.classList.contains('anchor-nav--touch');
  const root = document.documentElement;
  const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;
  const links = [...nav.querySelectorAll('a')];
  const ids = links.map((a) => a.getAttribute('href').slice(1));
  const top = (id) => id === ids[0] ? 0 : document.getElementById(id).getBoundingClientRect().top + scrollY;
  // slow, eased scroll (1 s)
  let anim = false, cool = 0;
  const glide = (to) => {
    const from = scrollY, d = to - from, dur = reduce ? 0 : 1000, t0 = performance.now();
    const ease = (x) => x < 0.5 ? 4 * x * x * x : 1 - Math.pow(-2 * x + 2, 3) / 2;
    anim = true;
    const step = (now) => { const x = dur ? Math.min(1, (now - t0) / dur) : 1; scrollTo(0, from + d * ease(x)); if (x < 1) requestAnimationFrame(step); else { anim = false; cool = Date.now() + 300; } };
    requestAnimationFrame(step);
  };
  links.forEach((a) => a.addEventListener('click', (e) => { e.preventDefault(); glide(top(a.getAttribute('href').slice(1))); }));
  // computer home page: the wheel moves section by section, then to the bottom of the footer
  if (!touch && document.getElementById('bienvenue')) {
    root.classList.add('snapfx');
    addEventListener('wheel', (e) => {
      e.preventDefault();
      if (anim || Date.now() < cool || Math.abs(e.deltaY) < 4) return;
      const stops = ids.map(top).concat([root.scrollHeight - innerHeight]);
      const y = scrollY;
      const next = e.deltaY > 0 ? stops.find((v) => v > y + 2) : stops.slice().reverse().find((v) => v < y - 2);
      if (next !== undefined) glide(next);
    }, { passive: false });
  }
  let cur = null, timer;
  const set = (id) => {
    if (id === cur) return;
    cur = id; root.dataset.cur = id;
    links.forEach((a) => {
      const on = a.getAttribute('href') === '#' + id;
      const label = a.firstElementChild, mark = a.lastElementChild.firstElementChild;
      a.setAttribute('aria-current', on ? 'true' : 'false');
      mark.style.height = on ? (touch ? '20px' : '24px') : '8px';
      mark.style.background = on ? '#d9a52b' : '#556275';
      if (!touch) { label.style.fontWeight = on ? '600' : '500'; label.style.color = on ? '#15273d' : '#2d3b4e'; }
      a.classList.toggle('flash', on && touch);
    });
    if (touch) { clearTimeout(timer); timer = setTimeout(() => links.forEach((a) => a.classList.remove('flash')), 1600); }
  };
  const update = () => {
    let c = ids[0];
    ids.forEach((id) => { const el = document.getElementById(id); if (el && el.getBoundingClientRect().top < innerHeight / 2) c = id; });
    set(c);
  };
  addEventListener('scroll', update, { passive: true });
  update();
})();
</script>"""
def sheet_html(sections):
    return """
<button type="button" id="sheet-button" aria-expanded="false" aria-controls="sheet" hidden style="position: fixed; right: 16px; bottom: 24px; z-index: 30; display: inline-flex; align-items: center; gap: 10px; max-width: calc(100% - 32px); min-height: 52px; padding: 0 18px; border: 0; border-radius: 999px; background: #15273d; color: #ffffff; font-family: 'Inter Tight', system-ui, sans-serif; font-size: 16px; font-weight: 600; cursor: pointer; box-shadow: 0 6px 20px rgba(21, 39, 61, 0.25)"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><line x1="9" y1="6" x2="20" y2="6"></line><line x1="9" y1="12" x2="20" y2="12"></line><line x1="9" y1="18" x2="20" y2="18"></line><circle cx="4.5" cy="6" r="1"></circle><circle cx="4.5" cy="12" r="1"></circle><circle cx="4.5" cy="18" r="1"></circle></svg><span id="sheet-current" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap">Haut de page</span><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 15 12 9 18 15"></polyline></svg></button>
<div id="sheet-backdrop" hidden style="position: fixed; inset: 0; z-index: 44; background: rgba(21, 39, 61, 0.35)"></div>
<div id="sheet" role="dialog" aria-modal="true" aria-label="Aller à une section" hidden style="position: fixed; left: 0; right: 0; bottom: 0; z-index: 45; box-sizing: border-box; padding: 12px 20px 28px; border-radius: 16px 16px 0 0; background: #ffffff; font-family: 'Inter Tight', system-ui, sans-serif; line-height: 1.6">
  <span aria-hidden="true" style="display: block; width: 40px; height: 4px; margin: 0 auto 16px; border-radius: 2px; background: #e4e7ec"></span>
  <p style="margin: 0 0 4px; font-size: 13px; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; color: #2d3b4e">Sur cette page</p>
  <nav aria-label="Sections de la page">""" + "".join(
    f'<a href="#{k}" style="display: flex; align-items: center; gap: 12px; min-height: 56px; padding: 0 4px; border-bottom: 1px solid #e4e7ec; font-size: 18px; color: #2d3b4e; text-decoration: none"><span aria-hidden="true" style="flex: none; width: 8px; height: 8px; border-radius: 999px; background: #d9a52b"></span>{label}</a>'
    for k, label in sections) + """</nav>
</div>
<script>
(() => {
  const btn = document.getElementById('sheet-button'), sheet = document.getElementById('sheet'), back = document.getElementById('sheet-backdrop'), name = document.getElementById('sheet-current');
  const links = [...sheet.querySelectorAll('a')], ids = links.map((a) => a.getAttribute('href').slice(1));
  const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;
  const glide = (to) => {
    const from = scrollY, d = to - from, dur = reduce ? 0 : 1000, t0 = performance.now();
    const ease = (x) => x < 0.5 ? 4 * x * x * x : 1 - Math.pow(-2 * x + 2, 3) / 2;
    const step = (now) => { const x = dur ? Math.min(1, (now - t0) / dur) : 1; scrollTo(0, from + d * ease(x)); if (x < 1) requestAnimationFrame(step); };
    requestAnimationFrame(step);
  };
  const open = (on) => { sheet.hidden = back.hidden = !on; btn.setAttribute('aria-expanded', on ? 'true' : 'false'); (on ? links.find((a) => a.getAttribute('aria-current') === 'true') || links[0] : btn).focus(); };
  btn.addEventListener('click', () => open(sheet.hidden));
  back.addEventListener('click', () => open(false));
  addEventListener('keydown', (e) => { if (e.key === 'Escape' && !sheet.hidden) open(false); });
  links.forEach((a) => a.addEventListener('click', (e) => { e.preventDefault(); open(false); const id = a.getAttribute('href').slice(1); glide(id === ids[0] ? 0 : document.getElementById(id).getBoundingClientRect().top + scrollY); }));
  const update = () => {
    let cur = ids[0];
    ids.forEach((id) => { const el = document.getElementById(id); if (el && el.getBoundingClientRect().top < innerHeight / 2) cur = id; });
    btn.hidden = scrollY < 80;
    links.forEach((a) => { const on = a.getAttribute('href') === '#' + cur; a.setAttribute('aria-current', on ? 'true' : 'false'); a.style.fontWeight = on ? '600' : '500'; a.style.color = on ? '#15273d' : '#2d3b4e'; a.firstElementChild.style.visibility = on ? 'visible' : 'hidden'; if (on) name.textContent = a.textContent; });
  };
  addEventListener('scroll', update, { passive: true });
  update();
})();
</script>"""
SHEETS = {
    "bienvenue": [("accueil", "Haut de page"), ("bienvenue", "Bienvenue"), ("evenements", "Les évènements"), ("predication", "La dernière prédication")],
    "valeurs": [("vision", "Notre vision"), ("valeurs", "Nos valeurs"), ("couple-pastoral", "Le couple pastoral"), ("departements", "Les départements"), ("histoire", "Notre histoire")],
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
        # the home hero fills the browser window, as on the real site
        body = re.sub(r'<\w+\b[^>]*data-first-screen="true"[^>]*>',
                      lambda m: re.sub(r"min-height: \d+px", f"min-height: calc(100svh - {80 if phone else 120}px)", m.group(0)), body)
        if phone:
            # the board's fixed canvas frame becomes a centred 390 px column
            body, n = re.subn(r'<div style="width: 390px; min-height: \d+px; ', '<div style="max-width: 390px; margin: 0 auto; ', body, count=1)
            assert n == 1, base
        body = re.sub(r"\n{3,}", "\n\n", body)
        # phone: a floating "on this page" button opens the list of sections
        for marker, sections in SHEETS.items():
            if phone and f'id="{marker}"' in body:
                body += sheet_html(sections)
        # the section links stay on the right edge while scrolling and follow the current section
        if 'class="anchor-nav' in body:
            body = re.sub(r'(class="anchor-nav[^"]*" aria-label="Sections de la page" style=")position: absolute;', r"\1position: fixed;", body)
            body += ANCHOR_SCRIPT
            # sections after the hero fill the whole window (the header has scrolled away)
            body = re.sub(r"calc\(\d+px \+ 48px\)", "100svh", body)
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
