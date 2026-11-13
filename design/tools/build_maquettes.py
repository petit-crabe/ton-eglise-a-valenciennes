"""Keep one source for the mockups: one header, one footer, one body per page.

usage: python3 build_maquettes.py pull <canvas project dir>
       python3 build_maquettes.py build <out project dir>
       python3 build_maquettes.py link
       python3 build_maquettes.py components <out project dir>
       python3 build_maquettes.py variant <out project dir> <tokens.json> <name> <label>

pull reads the *-charte boards and the Ecran-* prototypes downloaded from the canvas
and writes design/source/. It reports every header or footer that differs from the
shared one (a hand edit made on one page only); the shared one wins.
build writes the 32 boards and the 9 prototypes from design/source/, colours from
design/tokens.json. Portrait tablets (768 and 820 px) get the tablet layout: the
computer pages folded by the rules of DESIGN.md, "Folding".
link splits the styles of every component (design/source/components/) between the shared
rule and what each page keeps inline; see components.py. components writes one board per
component (Composant-<name>.dc.html, canvas page "Composants"); pull reads them back last, so a
change made on a component board wins over the pages."""
import html, json, os, re, sys
from collections import Counter

import components as comp

HERE = os.path.dirname(os.path.abspath(__file__))
SOURCE = os.path.join(HERE, "..", "source")
TOKENS = os.path.join(HERE, "..", "tokens.json")

# board base name -> prototype page key
PAGES = {
    "Accueil": "home", "Qui-sommes-nous": "qui", "Equipe": "equipe", "Notre-histoire": "histoire",
    "Evenements": "evenements", "Evenement": "evenement", "Predications": "predications",
    "Predication": "predication", "Contact": "contact", "Don": "don", "Entretien": "entretien",
    "Priere": "priere", "Servir": "servir", "Donnees": "donnees", "Conditions": "conditions",
    "Mentions": "mentions",
}
DEVICES = {"desktop": "", "phone": "-telephone"}
# prototype -> shell; each shell is read from the first prototype that uses it
PROTOTYPES = {
    "Ecran-ordinateur-1920": "desktop", "Ecran-ordinateur-1536": "desktop", "Ecran-ordinateur-1366": "desktop",
    "Ecran-tablette-1280": "desktop", "Ecran-tablette-820": "tablet", "Ecran-tablette-768": "tablet",
    "Ecran-telephone-412": "phone", "Ecran-telephone-390": "phone", "Ecran-telephone-360": "phone",
}
# which page bodies each shell shows
BODIES = {"desktop": "desktop", "tablet": "tablet", "phone": "phone"}
# First screen = header + banner (+ the first line of the first block) = the screen height.
# Boards show it on a typical screen; prototypes on their own; the real site uses 100svh.
BOARD_SCREEN = {"desktop": 900, "phone": 844}
HEADER = {"desktop": 92, "tablet": 68, "phone": 64}

# Tablet layout (768-979 px): the computer page with these changes
FOLD = [
    # rows of three cards stay three (lists of 3 and 9 would leave a card alone on two per row)
    ("grid-template-columns: repeat(4, minmax(0, 1fr))", "grid-template-columns: repeat(2, minmax(0, 1fr))"),
    ("grid-template-columns: minmax(0, 7fr) minmax(0, 5fr)", "grid-template-columns: minmax(0, 1fr)"),
    ("grid-template-columns: minmax(0, 5fr) minmax(0, 7fr)", "grid-template-columns: minmax(0, 1fr)"),
    ("grid-template-columns: minmax(0, 1fr) 360px", "grid-template-columns: minmax(0, 1fr)"),
    ("grid-template-columns: 300px minmax(0, 1fr)", "grid-template-columns: minmax(0, 1fr)"),
    ("grid-template-columns: minmax(0, 400px) minmax(0, 1fr)", "grid-template-columns: minmax(0, 2fr) minmax(0, 3fr)"),
    # a portrait photo stacked above its text would fill the screen
    ("aspect-ratio: 4 / 5", "aspect-ratio: 4 / 3"),
    # table of contents links are touched, not clicked, on a tablet
    ("min-height: 36px", "min-height: 44px"),
]


def color_tokens():
    """name -> hex for every opaque colour token, in tokens.json order."""
    out = {}
    def walk(node, path):
        for k, v in node.items():
            if k.startswith("$") or not isinstance(v, dict):
                continue
            if v.get("$type") == "color":
                val = v["$value"]
                if "alpha" not in val:
                    out[(path + [k])[-1] if path == ["color"] else ".".join(path + [k])] = val["hex"].lower()
            else:
                walk(v, path + [k])
    walk(json.load(open(TOKENS)), [])
    return out


def to_tokens(s, warn):
    by_hex = {}
    for name, hex_ in color_tokens().items():
        by_hex.setdefault(hex_, name)
    def sub(m):
        h = m.group(0).lower()
        if h not in by_hex:
            warn(f"colour {h} is not a token")
            return m.group(0)
        return f"[[{by_hex[h]}]]"
    return re.sub(r"#[0-9a-fA-F]{6}\b", sub, s)


def first_screen(s):
    """The fixed height of the first screen in a board or prototype -> [[first-screen]]."""
    return re.sub(r'<\w+\b[^>]*data-first-screen="true"[^>]*>',
                  lambda m: re.sub(r"min-height: \d+px", "min-height: [[first-screen]]", m.group(0)), s)


def from_tokens(s, screen=None):
    if screen is not None:
        s = s.replace("[[first-screen]]", f"{screen}px")
    toks = color_tokens()
    return re.sub(r"\[\[([\w.-]+)\]\]", lambda m: toks[m.group(1)], s)


def split_board(s):
    h0 = s.index("<header")
    h1 = s.index("</header>", h0) + len("</header>")
    f0 = s.rindex("<footer")
    f1 = s.index("</footer>", f0) + len("</footer>")
    helmet = s[s.index("<helmet>") + len("<helmet>"):s.index("</helmet>")]
    root = re.search(r"</helmet>\s*(<div [^>]*>)", s).group(1)
    # the canvas editor may save the props double-quoted and entity-encoded
    script = re.search(r"<script type=\"text/x-dc\" data-dc-script data-props=(['\"])(.*?)\1>\n(.*?)</script>", s, re.S)
    props = html.unescape(script.group(2)) if script.group(1) == '"' else script.group(2)
    return {
        "title": re.search(r"<title>(.*?)</title>", s).group(1),
        "helmet": helmet, "root": root, "header": s[h0:h1], "body": s[h1:f0], "footer": s[f0:f1],
        "props": props, "code": script.group(3),
    }


def block_end(s, start):
    """End of the <sc-if> block opening at start, past its newline; blocks may nest."""
    depth = 0
    for m in re.compile(r"<sc-if\b|</sc-if>").finditer(s, start):
        depth += 1 if m.group(0) == "<sc-if" else -1
        if depth == 0:
            end = m.end()
            return end + 1 if s[end:end + 1] == "\n" else end
    raise ValueError("unclosed sc-if")


def components_dir():
    return os.path.join(SOURCE, "components")


def inject(text, dev):
    """Component styles for a device, inside the first <style> of a helmet or prototype shell."""
    folder = components_dir()
    css = comp.device_css(folder, comp.catalog_of(folder), "desktop" if dev == "tablet" else dev)
    if dev == "tablet":
        css = fold(css)
    return text.replace("</style>", f"/* components */\n{css}/* end components */\n</style>", 1)


def strip_injected(text):
    return re.sub(r"/\* components \*/\n.*?/\* end components \*/\n", "", text, flags=re.S)


def most_common(items):
    return Counter(items).most_common(1)[0][0]


def write(path, text):
    os.makedirs(os.path.dirname(path), exist_ok=True)
    open(path, "w", encoding="utf-8").write(text)


def pull(canvas):
    warnings = []
    boards = {}
    for base in PAGES:
        for dev, suffix in DEVICES.items():
            boards[base, dev] = split_board(strip_injected(open(os.path.join(canvas, f"{base}-charte{suffix}.dc.html"), encoding="utf-8").read()))
    meta = {}
    for dev in DEVICES:
        mine = {b: p for (b, d), p in boards.items() if d == dev}
        bg_free = lambda h: re.sub(r"body\{margin:0;background:#\w+\}", "body{margin:0;background:@@BG@@}", h)
        helmet = most_common(bg_free(p["helmet"]) for p in mine.values())
        footer = most_common(p["footer"] for p in mine.values())
        # header: nav links split into chunks; the shared chunk is the most common one at each place
        chunks = {b: re.split(r"(?=<a )", p["header"]) for b, p in mine.items()}
        size = most_common(len(c) for c in chunks.values())
        shared = [most_common(c[i] for c in chunks.values() if len(c) == size) for i in range(size)]
        write(os.path.join(SOURCE, "shell", f"{dev}-helmet.html"), to_tokens(helmet, warnings.append))
        write(os.path.join(SOURCE, "shell", f"{dev}-header.html"), to_tokens("".join(shared), warnings.append))
        write(os.path.join(SOURCE, "shell", f"{dev}-footer.html"), to_tokens(footer, warnings.append))
        for base, p in mine.items():
            name = f"{base}-charte{DEVICES[dev]}"
            if bg_free(p["helmet"]) != helmet:
                warnings.append(f"{name}: helmet differs from the shared one, replaced")
            if p["footer"] != footer:
                warnings.append(f"{name}: footer differs from the shared one, replaced")
            current = {}
            if len(chunks[base]) != size:
                warnings.append(f"{name}: header differs from the shared one, replaced")
            else:
                for i, (mine_c, shared_c) in enumerate(zip(chunks[base], shared)):
                    if mine_c == shared_c:
                        continue
                    if "aria-current" in mine_c:
                        current[str(i)] = to_tokens(mine_c, warnings.append)
                    else:
                        warnings.append(f"{name}: header differs from the shared one, replaced")
            write(os.path.join(SOURCE, "pages", f"{base}.{dev}.html"), first_screen(to_tokens(p["body"], warnings.append)))
            meta[name] = {
                "title": p["title"],
                "background": to_tokens(re.search(r"body\{margin:0;background:(#\w+)\}", p["helmet"]).group(1), warnings.append),
                "root": to_tokens(p["root"], warnings.append),
                "current": current, "props": p["props"], "code": p["code"],
            }
    write(os.path.join(SOURCE, "boards.json"), json.dumps(meta, ensure_ascii=False, indent=1) + "\n")

    protos, seen = {}, set()
    for name, shell in PROTOTYPES.items():
        s = strip_injected(open(os.path.join(canvas, f"{name}.dc.html"), encoding="utf-8").read())
        title = re.search(r"<title>(.*?)</title>", s).group(1)
        w, h = map(int, re.search(r'"\$preview":\{"width":(\d+),"height":(\d+)\}', s).groups())
        protos[name] = {"shell": shell, "title": title, "width": w, "height": h}
        head = s[:s.index('<sc-if value="{{ isHome }}"')]
        tail = s[block_end(s, s.index('<sc-if value="{{ isMentions }}"')):].lstrip(" ")
        head = head.replace(f"<title>{title}</title>", "<title>@@TITLE@@</title>").replace(
            f"width: {w}px; height: {h}px;", "width: @@W@@px; height: @@H@@px;")
        tail = tail.replace(f'"$preview":{{"width":{w},"height":{h}}}', '"$preview":{"width":@@W@@,"height":@@H@@}')
        text = to_tokens(head + "@@PAGES@@" + tail, warnings.append)
        path = os.path.join(SOURCE, "shell", f"prototype-{shell}.html")
        if shell not in seen:
            seen.add(shell)
            write(path, text)
        elif open(path, encoding="utf-8").read() != text:
            warnings.append(f"{name}: menu or script differs from the other {shell} prototypes, replaced")
    write(os.path.join(SOURCE, "prototypes.json"), json.dumps(protos, ensure_ascii=False, indent=1) + "\n")
    pull_components(canvas, warnings)
    for w in sorted(set(warnings)):
        print("warning:", w)
    print(f"pulled {len(boards)} boards and {len(protos)} prototypes into {os.path.normpath(SOURCE)}")


def read(*parts):
    return open(os.path.join(SOURCE, *parts), encoding="utf-8").read()


def board(base, dev, meta):
    m = meta[f"{base}-charte{DEVICES[dev]}"]
    chunks = re.split(r"(?=<a )", read("shell", f"{dev}-header.html"))
    for i, chunk in m["current"].items():
        chunks[int(i)] = chunk
    helmet = inject(read("shell", f"{dev}-helmet.html").replace("@@BG@@", m["background"]), dev)
    return (f'<!doctype html>\n<html lang="fr">\n<head>\n<meta charset="utf-8">\n<title>{m["title"]}</title>\n'
            f'<script src="./support.js"></script>\n</head>\n<body>\n<x-dc>\n<helmet>{helmet}</helmet>\n{m["root"]}\n\n  '
            + "".join(chunks) + read("pages", f"{base}.{dev}.html") + read("shell", f"{dev}-footer.html")
            + f"\n</div>\n</x-dc>\n<script type=\"text/x-dc\" data-dc-script data-props='{m['props']}'>\n{m['code']}</script>\n</body>\n</html>\n")


def fold(s):
    for old, new in FOLD:
        s = s.replace(old, new)
    # sections: 64 px top and bottom instead of 96
    return re.sub(r'(padding(?:-top|-bottom)?: )([^;"]*)', lambda m: m.group(1) + m.group(2).replace("96px", "64px"), s)


def page_block(base, bodies):
    dev = "desktop" if bodies == "tablet" else bodies
    s = "  " + read("pages", f"{base}.{dev}.html").strip() + "\n\n  " + read("shell", f"{dev}-footer.html")
    if bodies == "tablet":
        s = fold(s)
    s = re.sub(r'href="([A-Za-z-]+)-charte(?:-telephone)?\.dc\.html"',
               lambda m: f'href="#" onClick="{{{{ go{PAGES[m.group(1)].capitalize()} }}}}"', s)
    s = s.replace('<form action="#"', '<form action="#" onSubmit="{{ noSubmit }}"')
    # one prototype holds every page: prefix ids and in-page anchors with the page
    page = PAGES[base]
    s = re.sub(r'\b(id|for|aria-labelledby|aria-describedby)="([^"{]+)"',
               lambda m: f'{m.group(1)}="' + " ".join(f"{page}-{i}" for i in m.group(2).split()) + '"', s)
    s = re.sub(r'href="#([^"]+)"', lambda m: f'href="#{page}-{m.group(1)}"', s)
    key = page.capitalize()
    first = "true" if base == "Accueil" else "false"
    return f'<sc-if value="{{{{ is{key} }}}}" hint-placeholder-val="{{{{ {first} }}}}">\n{s}\n  </sc-if>\n  '


def build(out):
    meta = json.load(open(os.path.join(SOURCE, "boards.json"), encoding="utf-8"))
    protos = json.load(open(os.path.join(SOURCE, "prototypes.json"), encoding="utf-8"))
    os.makedirs(out, exist_ok=True)
    files = {}
    for base in PAGES:
        for dev, suffix in DEVICES.items():
            files[f"{base}-charte{suffix}.dc.html"] = (board(base, dev, meta), BOARD_SCREEN[dev] - HEADER[dev])
    for name, p in protos.items():
        pages = "".join(page_block(base, BODIES[p["shell"]]) for base in PAGES)
        files[f"{name}.dc.html"] = (inject(read("shell", f"prototype-{p['shell']}.html"), p["shell"]).replace("@@PAGES@@", pages)
                                    .replace("@@TITLE@@", p["title"]).replace("@@W@@", str(p["width"]))
                                    .replace("@@H@@", str(p["height"])), p["height"] - HEADER[p["shell"]])
    for f, (text, screen) in files.items():
        text = from_tokens(text, screen)
        assert "[[" not in text and "@@" not in text, f
        write(os.path.join(out, f), text)
    print(f"built {len(files)} files into {out}")


def link():
    """Shared component styles from the pages: rewrites the pages and the components' css files."""
    pages = {(base, dev): read("pages", f"{base}.{dev}.html") for base in PAGES for dev in DEVICES}
    folder = components_dir()
    out = comp.link(pages, comp.catalog_of(folder), folder, list(DEVICES))
    for (base, dev), text in out.items():
        write(os.path.join(SOURCE, "pages", f"{base}.{dev}.html"), text)
    print(f"linked {len(out)} pages; css in {os.path.normpath(folder)}")


SHELL_PARTS = {"header": ("En-tête", "Logo et menu ; sur téléphone et tablette, le bouton « Menu » ouvre un menu plein écran."),
               "footer": ("Pied de page", "Bleu nuit : adresse, liens du site, réseaux, mentions légales et crédit.")}
SAMPLE_PAD = 24


SAMPLE_GAP = '<div style="height: 16px"></div>'


def component_samples(name, variant=None):
    """First instance of a component on each device, in page order, and how often it is used.
    With `variant` (an inline property, such as background), the first instance of each value of it,
    so a component with several models shows them all."""
    out, seen, count, pages = {}, {}, 0, set()
    for dev in DEVICES:
        for base in PAGES:
            body = read("pages", f"{base}.{dev}.html")
            for n in comp.parse(body):
                if f"c-{name}" in comp.classes_of(n):
                    count += dev == "desktop"
                    pages.add(base)
                    key = dict(comp.decls(comp.attr(n, "style"))).get(variant) if variant else None
                    if key in seen.setdefault(dev, []) or (not variant and seen[dev]):
                        continue
                    seen[dev].append(key)
                    sample = body[n.start:n.end].replace("[[first-screen]]", f"{BOARD_SCREEN[dev] - HEADER[dev]}px")
                    # desktop and phone samples share the board: keep their ids apart
                    sample = re.sub(r'\b(id|for|aria-labelledby|aria-describedby)="([^"{]+)"',
                                    lambda m: f'{m.group(1)}="' + " ".join(f"{dev[0]}-{i}" for i in m.group(2).split()) + '"', sample)
                    out[dev] = out[dev] + SAMPLE_GAP + sample if dev in out else sample
    return out, count, len(pages)


def nested_components(name, samples):
    """Other components drawn inside the samples (a button in a card): their boards need their styles too."""
    found = []
    for sample in samples.values():
        for n in comp.parse(sample):
            for c in comp.classes_of(n):
                if c.startswith("c-") and "__" not in c and c != f"c-{name}" and c[2:] not in found:
                    found.append(c[2:])
    return found


def own_class(name, cls):
    return cls == f"c-{name}" or cls.startswith(f"c-{name}__")


def scoped_css(dev, rules_text):
    return re.sub(r"(^|\n)(\.c-)", lambda m: f"{m.group(1)}.dev-{dev} {m.group(2)}", rules_text)


def component_board(name, title, text, samples, widths, usage, height, css):
    full = widths[0] >= 1440
    pad = 0 if full else SAMPLE_PAD
    width = 2 * 48 + widths[0] + 2 * pad + 80 + widths[1] + 2 * pad
    base = read("shell", "desktop-helmet.html").replace("@@BG@@", "[[surface-white]]")
    helmet = base.replace("</style>", "/* components */\n" + css + "/* end components */\n</style>", 1)
    col = lambda dev, w, size, sample: (
        f'<section style="flex: none"><h2 style="margin: 0 0 16px; font-family: \'Inter Tight\', system-ui, sans-serif; font-size: 20px; color: [[secondary]]">'
        f'{"Ordinateur" if dev == "desktop" else "Téléphone"}</h2>'
        f'<div class="dev-{dev}" data-sample="{dev}" style="box-sizing: content-box; width: {w}px; padding: {pad}px; background: [[border]]; '
        f'border-radius: 6px; font-size: {size}px; line-height: 1.6">{sample}<!--/sample--></div></section>')
    return (f'<!doctype html>\n<html lang="fr">\n<head>\n<meta charset="utf-8">\n<title>{title} – composant</title>\n'
            f'<script src="./support.js"></script>\n</head>\n<body>\n<x-dc>\n<helmet>{helmet}</helmet>\n'
            f'<div style="box-sizing: border-box; width: {width}px; padding: 48px; background: [[surface-white]]; font-family: \'Inter Tight\', system-ui, sans-serif; color: [[text]]">\n'
            f'  <h1 style="margin: 0 0 8px; font-family: \'Inter Tight\', system-ui, sans-serif; font-size: 40px; line-height: 1.1; color: [[secondary]]">{title}</h1>\n'
            f'  <p style="margin: 0 0 8px; max-width: 880px; font-size: 18px; line-height: 1.6">{text}</p>\n'
            f'  <p style="margin: 0 0 32px; font-size: 15px; color: [[text-muted]]">{usage} Modifiez cet exemple : toutes les pages qui utilisent ce composant suivent.</p>\n'
            f'  <div style="display: flex; gap: 80px; align-items: flex-start">\n    '
            + col("desktop", widths[0], 18, samples.get("desktop", "")) + "\n    " + col("phone", widths[1], 17, samples.get("phone", ""))
            + f'\n  </div>\n</div>\n</x-dc>\n<script type="text/x-dc" data-dc-script data-props=\'{{"$preview":{{"width":{width},"height":{height}}}}}\'>\n'
            'class Component extends DCLogic {\n  renderVals() {\n    return {};\n  }\n}\n</script>\n</body>\n</html>\n'), width


def component_boards():
    """name -> (board text, width, height) for every component, header and footer included."""
    folder = components_dir()
    catalog = comp.catalog_of(folder)
    heights = json.load(open(os.path.join(folder, "boards.json"), encoding="utf-8")) if os.path.exists(os.path.join(folder, "boards.json")) else {}
    out = {}
    for part, (title, text) in SHELL_PARTS.items():
        samples = {dev: read("shell", f"{dev}-{part}.html") for dev in DEVICES}
        css = ""
        h = heights.get(part, 900)
        board_text, w = component_board(part, title, text, samples, (1440, 390), "Partagé par toutes les pages.", h, css)
        out[f"Composant-{part}"] = (board_text, w, h)
    for c in catalog:
        samples, count, pages = component_samples(c["name"], c.get("variant"))
        # nested components first, so the board's own component wins where both style an element
        css = "".join(scoped_css(dev, open(os.path.join(folder, f"{part}.{dev}.css"), encoding="utf-8").read())
                      for part in nested_components(c["name"], samples) + [c["name"]]
                      for dev in DEVICES if os.path.exists(os.path.join(folder, f"{part}.{dev}.css")))
        usage = f"Utilisé {count} fois sur {pages} page{'s' if pages > 1 else ''} (version ordinateur)."
        h = heights.get(c["name"], 900)
        board_text, w = component_board(c["name"], c["title"], c["text"], samples, tuple(c["width"]), usage, h, css)
        out[f"Composant-{c['name']}"] = (board_text, w, h)
    return out


def components(out):
    os.makedirs(out, exist_ok=True)
    for name, (text, w, h) in component_boards().items():
        text = from_tokens(text)
        assert "[[" not in text, name
        write(os.path.join(out, f"{name}.dc.html"), text)
    print(f"built {len(component_boards())} component boards into {out}")


def pull_components(canvas, warnings):
    """Changes made on the component boards: their css rules, and inline styles added on the samples."""
    folder = components_dir()
    catalog = comp.catalog_of(folder)
    built = {name: to_tokens(from_tokens(text), warnings.append) for name, (text, _, _) in component_boards().items()}
    for name, before in built.items():
        path = os.path.join(canvas, f"{name}.dc.html")
        if not os.path.exists(path):
            continue
        after = to_tokens(open(path, encoding="utf-8").read(), warnings.append)
        if after == before:
            continue
        part = name[len("Composant-"):]
        if part in SHELL_PARTS:
            for dev in DEVICES:
                m = re.search(rf'data-sample="{dev}"[^>]*>(.*?)<!--/sample-->', after, re.S)
                if m and m.group(1) != read("shell", f"{dev}-{part}.html"):
                    write(os.path.join(SOURCE, "shell", f"{dev}-{part}.html"), m.group(1))
                    warnings.append(f"{name}: shared {part} updated from its component board ({dev})")
            continue
        helmet = re.search(r"/\* components \*/\n(.*?)/\* end components \*/", after, re.S).group(1)
        rules = {dev: {} for dev in DEVICES}
        # only the board's own component: a nested one (a button in a card) is edited on its own board
        for m in re.finditer(r"\.dev-(\w+) \.(c-[\w-]+)\.\2\{([^}]*)\}", helmet):
            if own_class(part, m.group(2)):
                rules[m.group(1)][m.group(2)] = comp.decls(m.group(3))
        for dev in DEVICES:
            old = re.search(rf'data-sample="{dev}"[^>]*>(.*?)<!--/sample-->', before, re.S).group(1)
            new = re.search(rf'data-sample="{dev}"[^>]*>(.*?)<!--/sample-->', after, re.S).group(1)
            olds = [n for n in comp.parse(old) if any(own_class(part, c) for c in comp.classes_of(n))]
            news = [n for n in comp.parse(new) if any(own_class(part, c) for c in comp.classes_of(n))]
            if len(olds) != len(news):
                warnings.append(f"{name}: the {dev} sample changed shape; only its styles are kept")
            for o, n in zip(olds, news):
                cls = next(c for c in comp.classes_of(n) if own_class(part, c))
                was = dict(comp.decls(comp.attr(o, "style")))
                added = [(p, v) for p, v in comp.decls(comp.attr(n, "style")) if was.get(p) != v]
                if added and cls in rules[dev]:
                    keep = [(p, v) for p, v in rules[dev][cls] if p not in {a for a, _ in added}]
                    rules[dev][cls] = keep + added
        for dev in DEVICES:
            p = os.path.join(folder, f"{part}.{dev}.css")
            if rules[dev]:
                write(p, comp.css_text(rules[dev]))
        warnings.append(f"{name}: component styles updated from its board")


def variant(out, tokens, name, label):
    """Colour variant: the 32 boards with another tokens.json, as <Page>-<name>[-telephone].dc.html."""
    global TOKENS
    TOKENS = tokens
    meta = json.load(open(os.path.join(SOURCE, "boards.json"), encoding="utf-8"))
    os.makedirs(out, exist_ok=True)
    for base in PAGES:
        for dev, suffix in DEVICES.items():
            text = from_tokens(board(base, dev, meta), BOARD_SCREEN[dev] - HEADER[dev])
            text = re.sub(r'href="([A-Za-z-]+)-charte(-telephone)?\.dc\.html', rf'href="\1-{name}\2.dc.html', text)
            text = text.replace(" – nouvelle charte – ", f" – {label} – ", 1)
            write(os.path.join(out, f"{base}-{name}{suffix}.dc.html"), text)
    print(f"built {len(PAGES) * len(DEVICES)} {name} boards into {out}")


if __name__ == "__main__":
    if sys.argv[1] == "link":
        link()
    elif sys.argv[1] == "components":
        components(sys.argv[2])
    elif sys.argv[1] == "variant":
        # variant <out project dir> <tokens.json> <name> <label>
        variant(*sys.argv[2:6])
    else:
        {"pull": pull, "build": build}[sys.argv[1]](sys.argv[2])
