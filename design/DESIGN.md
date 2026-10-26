# Design system — tonegliseavalenciennes.fr

The visual rules of the redesigned site, validated with the home page on 2026-10-25 and the three "L'église" pages on 2026-10-26. The values live in [tokens.json](tokens.json) (W3C Design Tokens format, 2025.10) and in [tokens.css](tokens.css) as CSS custom properties; this file says how to use them. Change a value in `tokens.json`, never only in a page.

Working canvas (drafts, comments, history): https://claude.ai/artifact/UbLoYdhe5z2A3no2cDeo5u. Only validated pages are copied into [maquettes/](maquettes/).

## Principles

- **Keep the brand, modernise the rest.** The logo and its two blues stay; typography, spacing and components are new.
- **Warm and communal, not childish.** Real photographs of the congregation, soft surfaces, nearly square corners.
- **Modernise, don't redesign.** Pages, menus and section order follow the live site; no section is invented. Bigger changes are proposed as options and only kept once the owner chooses them (see [Site structure](#site-structure)).
- **Short pages.** A page should read in three or four phone screens; long content is split by theme or folded (accordion) rather than stacked.
- **No invented content.** Copy comes from the live site. A missing fact is shown as a bracketed placeholder (`[Titre de l'évènement]`), never guessed.
- **Accessible by default.** The rules in [Accessibility](#accessibility) are part of the design, not a later pass.

## Colour

| Role | Token | Value | Use |
|---|---|---|---|
| Primary | `color.primary` | `#3a64aa` | Every button, links, icons, the first contact card. |
| Secondary | `color.secondary` | `#13243b` | Headings, hero overlay, footer, date badges, current menu item. |
| Accent | `color.accent` | `#ffaf00` | Underline of the hero keyword, play button, quote marks. Nothing else. |
| Text | `color.text` / `color.text-muted` | `#2d3b4e` / `#556275` | Body text / dates, labels, captions. |
| Surfaces | `color.surface-*` | white, sand `#f7f3ee`, sky `#e9f3fb`, sun `#fff1cc` | Section and card backgrounds. |

Rules:

- **All buttons are blue.** Filled `color.primary` with white text for the main action; white with a 2 px `color.primary` border and blue text for a secondary action. There is no yellow, grey or dark button.
- **Yellow is never text and never a button.** It has no meaning; it only adds warmth.
- Sections alternate surfaces (white, sky, sand) so that two neighbours never share a background.
- Do not add colours. If a new need appears, add a token first.

## Typography

| Use | Token | Computer | Phone |
|---|---|---|---|
| Hero title (h1), home | `font.size.display` | 72 px | 42 px |
| Page title (h1), inner pages | `font.size.page-title` | 56 px | 36 px |
| Section title (h2) | `font.size.section-title` | 44 px | 30 px |
| Card title (h3) | `font.size.card-title` | 24 px | 19–24 px |
| Lead paragraph | `font.size.lead` | 20 px | 17 px |
| Body | `font.size.body` | 18 px | 17 px |
| Meta, footer | `font.size.small` | 16 px | 16 px |
| Dates, labels | `font.size.caption` | 15 px | 15 px |

- Headings: **Outfit** 600–700. Body: **Source Sans 3** 400 and 700. Both from Google Fonts; self-host them on the final site so no request reaches Google before consent.
- One size per role: every section title is 44 px, whatever the section.
- Nothing below 15 px; running text never below 16 px on a phone.
- Line height 1.1 for headings, 1.6 for text. No headings in capitals.

## Spacing and layout

- Spacing scale (`space.*`): **8, 16, 24, 32, 48, 64, 96 px**. Every gap, padding and margin uses one of these.
- Every section, header included, centres its content in a **1200 px** container with 24 px side padding (16 px on a phone), so left edges line up down the page.
- Sections have **96 px** vertical padding on a computer, **48 px** on a phone.
- Two-column blocks (hero, welcome, cards with a photo) split **50/50** and stack when the window is narrower than about 980 px.

## Shape

- Corners: **4 px** for buttons, tags, badges and menu items; **6 px** for cards, tiles, photos and the map. Fully round only for icon circles and the play button.
- No pills, no decorative blobs, no shadows, no gradients.

## Components

| Component | Look | Where |
|---|---|---|
| Button | 52 px high, 24 px side padding, 4 px corners, bold label; primary or secondary as above. | Everywhere. |
| Contact card | Whole card is the link. 176 px min height (144 px phone), icon in a 48 px white circle, label in the heading font with an arrow. Backgrounds in order: primary, sky, sun, sand. | Hero: Servir à l'église, Demande de prière, Nous contacter, Demande d'entretien. |
| Content card | White, 6 px corners; image on one side or on top, text block with 48 px padding. | Latest sermon, newcomer block. |
| Event card | White; 16:10 image slot (sand placeholder until a real image exists), night-blue date badge overlapping the image, title, time and place, short text, "En savoir plus". | Events. |
| Tile | Sand, 64 px high (52 px phone), bold label, blue arrow; the whole tile is the link. | Departments. |
| Info card | Sand, 24 px padding, muted label above a bold value. | "Où sommes-nous ?". |
| Page banner | The home hero's blurred photo and overlay, 64 px vertical padding (48 px phone); breadcrumb in white, then the page title. | Top of every inner page. |
| Breadcrumb | 16 px white text, `›` separators, current page in bold; a menu heading without its own page ("L'église") is plain text, not a link. | Page banner. |
| Accordion | Native `<details>`/`<summary>`: number in primary, short title in the heading font, chevron; rows split by 1 px `color.border` lines, 64 px high (56 px phone). The first row starts open. | "Nos valeurs". |
| Timeline | 2 px primary line, white dots with a primary ring, year as an h3 in primary (left column on computer, above the text on phone); the last dot is filled with the accent. | "Notre histoire". |
| Placeholder card | White with a 1 px `color.border` outline, name as h3, one muted bracketed line per missing fact. No link until the content exists. | Departments, until their leaders provide the content. |
| Partner link card | White, 24 px padding, name in the heading font, domain in muted text, external-link icon. | "Nos partenaires". |
| Section links | "Dans la rubrique « … »" block before the footer: one tile per page of the section; the current page is a night-blue tile marked "Vous êtes ici". | Every page of a menu section. |

## Imagery

- Real photographs of the church only, cropped with `object-fit: cover` to fixed ratios (16:9, 4:3, 16:10).
- **No text directly on a photo.** The hero photo is blurred (3 px) under a `overlay.hero` layer (night blue at 74 %), which keeps white text at 6.7:1 or more.
- Map: a static image of the Google Maps view that links to Google Maps. An embedded interactive map would load Google before the visitor consents.

## Accessibility

- Text contrast at least 4.5:1 (3:1 for 24 px and above); the token descriptions give the measured ratios.
- Anything tappable is at least **44 px** high, including footer links and the hero address.
- Keyboard focus: a 3 px outline with 3 px offset, `color.secondary` on light areas and white on dark areas (`.on-dark`). Never remove it.
- Real `<a>` and `<button>` elements; icon-only links carry an `aria-label`; decorative images have an empty `alt`.
- `lang="fr"`, one `h1` per page, headings in order.

## Mockups

| Page | Status | Files |
|---|---|---|
| Accueil | Validated 2026-10-25 | [maquettes/home/](maquettes/home/): `home-desktop.html`, `home-mobile.html`, and full-page captures `home-desktop.png`, `home-mobile.png` |
| L'église › Qui sommes-nous ? | Validated 2026-10-26 | [maquettes/church/](maquettes/church/): `who-we-are-desktop.html`, `who-we-are-mobile.html` and their `.png` captures |
| L'église › L'équipe | Validated 2026-10-26 | [maquettes/church/](maquettes/church/): `team-desktop.html`, `team-mobile.html` and their `.png` captures |
| L'église › Notre histoire | Validated 2026-10-26 | [maquettes/church/](maquettes/church/): `history-desktop.html`, `history-mobile.html` and their `.png` captures |

The HTML files open in any browser without the canvas, and link to each other; each folder has its own `images/`.

## Site structure

Changes to the live site's structure, decided by the owner:

- **"L'église" menu (2026-10-26).** The five pages Notre histoire, Notre vision, Nos valeurs, Les départements and Le couple pastoral become three:
  - **Qui sommes-nous ?** — vision, then the nine values as an accordion. The short value titles were written for the accordion and approved; the full texts are the live site's.
  - **L'équipe** — the pastor couple's welcome, then one placeholder card per department.
  - **Notre histoire** — the timeline (dates taken only from the live text), the partners and the mission statement.
- **Departments.** No department page and no department text until the owner has gathered the content from each department's leader. The nine names stay: Génération Kids, Punch Group, ConneXion, Ainé'rgie, Femmes, LSV – Louange Sono Vidéos, Mission, Une prière pour toi, Entraide.
- **Pastor.** The current pastor couple is Nicolas and Mélanie Tessier; the live history page's sentence about Pastor Timothée Mele (2019) is dropped.

## Confirmed facts

Confirmed by a church member on 2026-10-25; use these everywhere, including sermon posts:

- Sunday service: **10h00** (the "09h30" in sermon posts is wrong).
- Address: **75, rue du Chauffour, 59300 Valenciennes** (double f; postcode 59300, not 59000).
