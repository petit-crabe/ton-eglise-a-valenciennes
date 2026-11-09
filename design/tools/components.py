"""Components of the mockups: one shared style per component, kept in design/source/components/.

Every element of a component carries a class: `c-<name>` on its root, `c-<name>__<path>` on each
styled descendant (path = tag and rank among same-tag siblings, from the root). The declarations
all instances share live in `<name>.<device>.css`; what differs stays inline, on the page.
`link` recomputes that split from the pages, so a new instance only needs to be pasted in."""
import json, os, re

VOID = {"img", "input", "br", "hr", "meta", "link", "source", "area", "col", "wbr"}
TAG = re.compile(r"<!--.*?-->|<(/?)([a-zA-Z][\w-]*)((?:[^>\"']|\"[^\"]*\"|'[^']*')*)>", re.S)
RULE = re.compile(r"\.(c-[\w-]+)\.\1\{([^}]*)\}")


class Node:
    def __init__(self, tag, start, open_end, attrs, parent):
        self.tag, self.start, self.open_end, self.attrs, self.parent = tag, start, open_end, attrs, parent
        self.end, self.children = None, []


def parse(html):
    """Elements in document order, with their offsets; svg internals and comments included as text."""
    root = Node("#root", 0, 0, "", None)
    stack, nodes = [root], []
    for m in TAG.finditer(html):
        if m.group(0).startswith("<!--"):
            continue
        closing, tag, attrs = m.group(1), m.group(2).lower(), m.group(3)
        if closing:
            for i in range(len(stack) - 1, 0, -1):
                if stack[i].tag == tag:
                    for n in stack[i:]:
                        n.end = m.end() if n is stack[i] else m.start()
                    del stack[i:]
                    break
            continue
        node = Node(tag, m.start(), m.end(), attrs, stack[-1])
        stack[-1].children.append(node)
        nodes.append(node)
        if tag in VOID or attrs.rstrip().endswith("/"):
            node.end = m.end()
        else:
            stack.append(node)
    for n in stack[1:]:
        n.end = len(html)
    return nodes


def attr(node, name):
    m = re.search(rf'\s{name}="([^"]*)"', node.attrs)
    return m.group(1) if m else None


def decls(style):
    """'a: b; c: d' -> [('a', 'b'), ('c', 'd')]; values may hold commas, quotes and parentheses."""
    out, depth, cur = [], 0, ""
    for ch in style or "":
        depth += ch == "("
        depth -= ch == ")"
        if ch == ";" and depth == 0:
            out.append(cur); cur = ""
        else:
            cur += ch
    out.append(cur)
    return [(d.split(":", 1)[0].strip(), d.split(":", 1)[1].strip()) for d in out if ":" in d]


def style_text(ds):
    return "; ".join(f"{p}: {v}" for p, v in ds)


def matches(node, rule, html, page, css):
    if node.tag != rule["tag"]:
        return False
    if rule.get("page") and rule["page"] != page:
        return False
    st = style_text(full_style(node, css))
    if not all(s in st for s in rule.get("style", [])):
        return False
    if rule.get("attr") and not re.search(rule["attr"], node.attrs):
        return False
    if rule.get("contains"):
        if rule["contains"] not in html[node.start:node.end]:
            return False
        # the deepest element that fits the whole rule
        inner = dict(rule, contains=None)
        if any(c.tag == node.tag and rule["contains"] in html[c.start:c.end] and matches(c, inner, html, page, css)
               for c in descendants(node)):
            return False
    return True


def descendants(node):
    for c in node.children:
        yield c
        yield from descendants(c)


def path(node, root):
    segs = []
    while node is not root:
        same = [c for c in node.parent.children if c.tag == node.tag]
        segs.append(f"{node.tag}{same.index(node) + 1}")
        node = node.parent
    return "-".join(reversed(segs))


def classes_of(node):
    return (attr(node, "class") or "").split()


def load_css(folder, name, dev):
    p = os.path.join(folder, f"{name}.{dev}.css")
    if not os.path.exists(p):
        return {}
    return {m.group(1): decls(m.group(2)) for m in RULE.finditer(open(p, encoding="utf-8").read())}


def css_text(rules):
    return "\n".join(f".{cls}.{cls}{{{style_text(ds)}}}" for cls, ds in rules.items()) + ("\n" if rules else "")


def assign(html, catalog, page, css):
    """(element, component name, class) for every styled element that belongs to a component.
    A root is known by its class once linked, else by its full style and content."""
    nodes = parse(html)
    root_of = {}
    names = {c["name"] for c in catalog}
    for n in nodes:
        own = [c[2:] for c in classes_of(n) if c.startswith("c-") and "__" not in c and c[2:] in names]
        if own:
            root_of[id(n)] = own[0]
            continue
        for comp in catalog:
            if any(matches(n, r, html, page, css) for r in comp["match"]):
                root_of[id(n)] = comp["name"]
                break
    out = []
    for n in nodes:
        if attr(n, "style") is None and not any(c.startswith("c-") for c in classes_of(n)) and id(n) not in root_of:
            continue
        a = n
        while a is not None and id(a) not in root_of:
            a = a.parent
        if a is None:
            continue
        name = root_of[id(a)]
        p = path(n, a)
        out.append((n, name, f"c-{name}" + (f"__{p}" if p else "")))
    return out


def full_style(node, css):
    """The element's declarations with its component class folded back in."""
    ds = []
    for c in classes_of(node):
        if c.startswith("c-"):
            ds += css.get(c, [])
    inline = decls(attr(node, "style"))
    props = {p for p, _ in inline}
    return [d for d in ds if d[0] not in props] + inline


def rewrite(html, edits):
    """edits: {node: (class list, declarations)}; rewrites opening tags from the end."""
    for n, (cls, ds) in sorted(edits.items(), key=lambda kv: -kv[0].start):
        tag = html[n.start:n.open_end]
        tag = re.sub(r'\s(class|style)="[^"]*"', "", tag)
        extra = (f' class="{" ".join(cls)}"' if cls else "") + (f' style="{style_text(ds)}"' if ds else "")
        tag = re.sub(rf"^<{n.tag}\b", lambda m: m.group(0) + extra, tag, count=1, flags=re.I) if extra else tag
        html = html[:n.start] + tag + html[n.open_end:]
    return html


def link(pages, catalog, folder, devices):
    """pages: {(page, device): html}. Returns the rewritten pages and writes the css files."""
    old = {(c["name"], d): load_css(folder, c["name"], d) for c in catalog for d in devices}
    allcss = {d: {k: v for (n, dd), r in old.items() if dd == d for k, v in r.items()} for d in devices}
    found = {}
    for (page, dev), html in pages.items():
        for n, name, cls in assign(html, catalog, page, allcss[dev]):
            found.setdefault((dev, name, cls), []).append(((page, dev), n, full_style(n, allcss[dev])))
    shared = {}
    for (dev, name, cls), items in found.items():
        # the first-screen height depends on the screen: it stays on the page
        common = [d for d in items[0][2] if "[[first-screen]]" not in d[1]]
        for _, _, ds in items[1:]:
            common = [d for d in common if d in ds]
        shared.setdefault((name, dev), {})[cls] = common
    edits = {}
    for (dev, name, cls), items in found.items():
        common = shared[(name, dev)][cls]
        for key, n, ds in items:
            others = [c for c in classes_of(n) if not c.startswith("c-")]
            edits.setdefault(key, {})[n] = (others + [cls], [d for d in ds if d not in common])
    out = {key: rewrite(html, edits.get(key, {})) for key, html in pages.items()}
    for c in catalog:
        for d in devices:
            rules = {k: v for k, v in shared.get((c["name"], d), {}).items() if v}
            p = os.path.join(folder, f"{c['name']}.{d}.css")
            if rules:
                open(p, "w", encoding="utf-8").write(css_text(dict(sorted(rules.items(), key=lambda kv: (kv[0].count("-"), kv[0])))))
            elif os.path.exists(p):
                os.remove(p)
    return out


def device_css(folder, catalog, dev):
    return "".join(open(os.path.join(folder, f"{c['name']}.{dev}.css"), encoding="utf-8").read()
                   for c in catalog if os.path.exists(os.path.join(folder, f"{c['name']}.{dev}.css")))


def catalog_of(folder):
    return json.load(open(os.path.join(folder, "catalog.json"), encoding="utf-8"))
