# Design system — tonegliseavalenciennes.fr

The visual rules of the redesigned site, validated with the home page on 2026-10-25, the three "L'église" pages on 2026-10-26, and the events, sermons, contact and donation pages, the three footer forms and the legal pages on 2026-10-27, then harmonised across all pages the same day (see [Harmonisation](#harmonisation-2026-10-27)); the signal and mint colours were added on 2026-10-29 (see [Signal and mint](#signal-and-mint-2026-10-29)), and every page was reworked with these rules the same day (see [Charter rework](#charter-rework-2026-10-29)). The values live in [tokens.json](tokens.json) (W3C Design Tokens format, 2025.10) and in [tokens.css](tokens.css) as CSS custom properties; this file says how to use them. Change a value in `tokens.json`, never only in a page.

Working canvas (drafts, comments, history): https://claude.ai/artifact/UbLoYdhe5z2A3no2cDeo5u. Only validated pages are copied into [maquettes/](maquettes/).

## Principles

- **Members first, visitors second.** The site speaks first to church members (upcoming events, the Sunday live stream, sermons), then to visitors passing through the area who look for a place of worship (students, holidaymakers). People seeking faith are welcome, but the site does not address them first. When a block does not serve one of these two audiences, it goes.
- **Keep the brand, modernise the rest.** The logo and its two blues stay; typography, spacing and components are new.
- **Warm and communal, not childish.** Real photographs of the congregation, soft surfaces, nearly square corners.
- **Modernise, don't redesign.** Pages, menus and section order follow the live site; no section is invented. Bigger changes are proposed as options and only kept once the owner chooses them (see [Site structure](#site-structure)).
- **Short pages.** A page should read in three or four phone screens; long content is split by theme or folded (accordion) rather than stacked.
- **No invented content.** Copy comes from the live site. A missing fact is shown as a bracketed placeholder (`[Titre de l'évènement]`), never guessed.
- **No placeholder in production.** Placeholders (`[Présentation du département]`, `[Titre de l'évènement]`, `[à compléter]`) and missing texts may go to preprod, where the site is shown to the church, but never to production. Before every release to `main`, search the pages for square brackets and empty texts; any one left blocks the release.
- **Accessible by default.** The rules in [Accessibility](#accessibility) are part of the design, not a later pass.

## Colour

| Role | Token | Value | Use |
|---|---|---|---|
| Primary | `color.primary` | `#3a64aa` | Every button, links, icons, the first contact card. |
| Secondary | `color.secondary` | `#13243b` | Headings, hero overlay, footer, date badges, current menu item. |
| Accent | `color.accent` | `#ffaf00` | A small signature on every page: underline of the hero keyword (home), bar under the banner title (inner pages), every play button, the dot before "Vous êtes ici", quote marks, the last timeline dot. Nothing else. |
| Signal | `color.signal` | `#ff6b4a` | Coral. Only what is happening now or has just been added: the "En direct" tag of the Sunday live stream, the "Nouveau" tag on an event. |
| Text | `color.text` / `color.text-muted` | `#2d3b4e` / `#556275` | Body text / dates, labels, captions. |
| Surfaces | `color.surface-*` | white, sand `#f7f3ee`, sky `#e9f3fb`, sun `#fff1cc`, mint `#e2f5ec` | Section backgrounds: white, sky, mint. Panel and card backgrounds: sand, sky, sun, mint, white. Sand is never a section background. |

Rules:

- **All buttons are blue.** Filled `color.primary` with white text for the main action; white with a 2 px `color.primary` border and blue text for a secondary action. There is no yellow, grey or dark button.
- **Yellow is never text and never a button.** It has no meaning; it only adds warmth.
- **Every page shows some yellow**, at least the bar under the banner title. The menu never uses yellow: the current item stays night blue.
- **Yellow warms, coral signals.** Yellow means nothing; coral always means "now" or "new". Coral is always a filled tag with night-blue text on it (5.5:1), never text (2.8:1 on white), never a button, never a section background. It stays rare, once or twice per page at most, and never sits in the same spot as yellow: on the live sermon the tag goes above the title, away from the yellow play button.
- **Sand is for blocks, never for sections.** A full sand section looked dull where the site wants joy. Sand stays for cards and panels (form panel, practical info panel, latest sermon card, table of contents, the fourth hero card) and for the header band, which keeps it.
- **Every page shows the soft surfaces.** Sections alternate white, sky and mint so that two neighbours never share a background, on every page with no exception.
- **Sky and mint are never neighbours.** A white section always sits between them. Mint is a section background ("Chaque semaine", "Dans la rubrique", "Une autre demande ?" on the contact page) or a panel background (Bible verse, "Réduction d'impôt"). Sections are never separated by a grey line on the same background; hairlines (`color.border`, or `color.border-tint` on sky) only split rows inside a section.
- A page may end on white, sky or mint before the night-blue footer; there is no closing block.
- No colour outside this charter. If a new need appears, add a token first. Departments get no colour of their own until their content exists; this will be decided then.

## Typography

| Use | Token | Computer | Phone |
|---|---|---|---|
| Hero title (h1), home | `font.size.display` | 72 px | 42 px |
| Page title (h1), inner pages | `font.size.page-title` | 56 px | 36 px |
| Section title (h2) | `font.size.section-title` | 44 px | 30 px |
| Block title (h2 or h3) | `font.size.block-title` | 28 px | 24 px |
| Card title (h3) | `font.size.card-title` | 24 px | 20 px |
| Small title | `font.size.small-title` | 18 px | 18 px |
| Lead paragraph | `font.size.lead` | 20 px | 17 px |
| Body | `font.size.body` | 18 px | 17 px |
| Meta, footer | `font.size.small` | 16 px | 16 px |
| Dates, labels | `font.size.caption` | 15 px | 15 px |

- Headings: **Outfit** 600–700. Body: **Source Sans 3** 400 and 700. Both from Google Fonts; self-host them on the final site so no request reaches Google before consent.
- One size per role, whatever the page: every section title is 44 px. A block title is the heading of a block inside a section (form panel, "Présentation", side panel, numbered heading of a legal page). A small title heads a footer column, "Partager l'évènement" or "Dans la rubrique". The timeline years and the "Nos valeurs" accordion rows keep their own sizes.
- Nothing below 15 px; running text never below 16 px on a phone.
- Line height 1.1 for headings, 1.6 for text. No headings in capitals.

## Spacing and layout

- Spacing scale (`space.*`): **8, 16, 24, 32, 48, 64, 96 px**. Every gap, padding and margin uses one of these; the only exception is the inside of form fields (12 × 16 px).
- Every section, header included, centres its content in a **1200 px** container with 24 px side padding (16 px on a phone), so left edges line up down the page.
- Sections have **96 px** vertical padding on a computer, **48 px** on a phone.

The same gap for the same situation, on every page:

| Between | Computer | Phone |
|---|---|---|
| Section title and a paragraph | 24 px | 24 px |
| Section title and cards, a list, a form or an accordion | 32 px | 32 px |
| Block or card title and what follows | 16 px | 16 px |
| Card title and its date or place line | 8 px | 8 px |
| Two paragraphs | 16 px | 16 px |
| Two blocks of the same section | 48 px | 32 px |
| Top and bottom of a section | 96 px | 48 px |

Two-column blocks, all **top-aligned**, stack when the window is narrower than about 980 px:

- **Photo and text: 50/50** (home hero and welcome, Qui sommes-nous, L'équipe, Notre histoire).
- **Text and a panel: 7/5**, the text wider (Faire un don, latest sermon). Exception: on Nous contacter the form is the wider column (5/7).
- **Fixed column** only for the practical info panel (360 px: single event, single sermon) and the table of contents (300 px: legal pages).

## Shape

- Corners: **4 px** for buttons, tags, badges and menu items; **6 px** for cards, tiles, photos and the map. Fully round only for icon circles and the play button.
- No pills, no decorative blobs, no shadows, no gradients.

## Components

| Component | Look | Where |
|---|---|---|
| Button | 52 px high, 24 px side padding, 4 px corners, bold label; primary or secondary as above. | Everywhere. |
| Contact card | Whole card is the link. 176 px min height (144 px phone), icon in a 48 px white circle, label in the heading font with an arrow. Backgrounds in order: primary, sky, sun, sand. On the contact page the three other requests sit three in a row (primary, sky, sun). On a phone they always become 80 px rows, icon on the left, arrow on the right, home hero included, so the hero does not fill a whole phone screen. | Hero: Servir à l'église, Demande de prière, Nous contacter, Demande d'entretien. Contact page: "Une autre demande ?", on mint. |
| Contact details | Definition list: primary icon, muted label, bold value; address, e-mail and phone are links (`tel:` on the phone number), each at least 44 px high. | Contact page. |
| Form field | Bold label always visible above the field; 48 px high, 1 px grey outline, 4 px corners, 17 px text; the message box is 6–7 rows and can be resized. The form sits in a sand panel (48 px padding, 24 px × 16 px on a phone); the submit button is primary, full width on a phone. Optional fields say "(facultatif)" in grey after the label; everything else is required. Date fields open a calendar (44 px sky button with a calendar icon) instead of free typing. | Contact form, footer forms. |
| Choice list | Radio buttons or checkboxes, 22 px, one per 44 px row, primary accent; grouped in a `fieldset` with a bold legend. Long lists are split into sub-groups with a small uppercase grey legend and a key line above; 4 columns on a computer, 1 on a phone. Nothing is pre-checked. | "Servir à l'église" (attendance, serving teams). |
| Full-width form page | Heading (h2) and one or two paragraphs (max 800 px), then the form panel across the whole container; on a computer short fields go two per row (name and e-mail always together). Same order on a phone, one field per row. | Demande d'entretien, Demande de prière, Servir à l'église. |
| Side panel | Mint, 6 px corners, 48 px padding (24 px × 16 px on a phone); small heading (h3), text, and an optional key line in bold on a white inset (4 px corners). Beside the text on a computer (7/5 columns), under it on a phone. No oversized figures. | Donation page ("Réduction d'impôt"), in the white section; "Comment faire un don ?" below it is sky. |
| Signal tag | Coral fill, 4 px corners, 4 × 12 px padding, 15 px bold uppercase night-blue label; "En direct" adds a 10 px night-blue dot before the label. | "En direct" above the title of the live sermon; "Nouveau" on a recently added event card, above its title. |
| Way-to-give card | White, 6 px corners, 48 px padding (24 px × 16 px phone); icon in a 48 px sky circle, h3, then either a short text and a primary button (download) or a definition list. Two per row on a computer. | Donation page ("Par virement", "Par chèque"). |
| Content card | Sand, 6 px corners; image on one side or on top, text block with 48 px padding. | Latest sermon, in a white section. |
| Event card | White; 16:10 image slot (placeholder until a real image exists, in the soft surface that stands out from its section: sand on sky, sky on white or sand), night-blue date badge overlapping the image, title, time and place, short text, "En savoir plus". On the events page (computer) the image sits on the left (400 px) with the badge in its top-left corner. On a white section the card gets a 1 px `color.border` outline. | Home page, events page ("Les prochains évènements" on white). |
| Weekly meeting card | Sky, or white on a mint section; 32 px padding (16 px phone); night-blue square with the short day and the time, then the meeting name (h3), "Jour à HHhMM" in bold and the address as a link. | "Chaque semaine". |
| Month heading | Muted h3 in the heading font with a 1 px line under it; events of that month follow. | Events list. |
| Practical info panel | Sand, 6 px corners; a definition list (Date, Heure, Lieu), each with a primary icon, muted label and bold value; "Voir le plan" under the place. On a computer it sits in a 360 px column beside the text; on a phone right under the image. | Single event; on the single sermon it lists Date, Orateur, Passage biblique and Série with "Toute la série". |
| Share buttons | Secondary buttons, full width of the panel: "Partager sur Facebook", "Partager sur WhatsApp". | Single event, single sermon. |
| Video slot | 16:9, 6 px corners, night blue with a round accent play button (night-blue triangle); holds the YouTube player. | Latest sermon, single sermon. |
| Sermon card | White, 6 px corners, the whole card is the link; 16:9 thumbnail (sky placeholder with a round accent play button, night-blue triangle), series in small primary capitals, title (h3), "date · speaker" in muted text. Three per row on a computer, one per row on a phone. | Sermons list, "Dans la même série". |
| Filter menu | Native `<select>` with a visible bold label above, 48 px high, 1 px grey outline, chevron on the right; 280 px wide on a computer, full width on a phone. The result count sits beside or under the menus. | Sermons list (Série, Orateur). |
| Pagination | 48 px squares, current page in night blue, then "Suivante". On a phone: "Page 1 sur N" and a secondary "Plus anciennes" button. | Sermons list. |
| Tile | Sand, 64 px high (52 px phone), bold label, blue arrow; the whole tile is the link. | Unused since the home page lost its department block (2026-10-27); kept for department links once their pages exist. |
| Info card | Sand, 24 px padding, muted label above a bold value. | Unused since the home page lost "Où sommes-nous ?" (2026-10-27). |
| Page banner | A blurred photo of the section under `overlay.hero` (see [Imagery](#imagery)), 64 px vertical padding (48 px phone); breadcrumb in white, the page title, then an accent bar 24 px under it (`size.accent-bar-*`: 96 × 6 px, 64 × 4 px on a phone). | Top of every inner page. |
| Breadcrumb | 16 px white text, `›` separators, current page in bold; a menu heading without its own page ("L'église") is plain text, not a link. | Page banner. |
| Accordion | Native `<details>`/`<summary>`: number in primary, short title in the heading font, chevron; rows split by 1 px `color.border` lines, 64 px high (56 px phone). The first row starts open. | "Nos valeurs", in a white section. |
| Timeline | 2 px primary line, white dots with a primary ring, year as an h3 in primary (left column on computer, above the text on phone); the last dot is filled with the accent. | "Notre histoire". |
| Placeholder card | White with a 1 px `color.border` outline, name as h3, one muted bracketed line per missing fact. No link until the content exists. | Departments, until their leaders provide the content. |
| Partner link card | White, 24 px padding, name in the heading font, domain in muted text, external-link icon. | "Nos partenaires". |
| Table of contents | Legal and other long text pages: on a computer a sand panel (6 px corners, 24 px padding) in a 300 px column, sticky at the top while reading, small uppercase "Sommaire" label and one link per numbered section (36 px rows, the one place below 44 px, mouse use only); text column max 760 px. On a phone a closed sand `details` "Sommaire" (52 px) above the text, 44 px links. | Protection des données, Conditions générales, Mentions légales. |
| Data table | Inside a bordered card (6 px corners): sand header with the h3 and a small white category tag, then a full-width table with a grey header row and hairline rows (8 × 12 px cells, 16 px text, codes in monospace). | Cookie list ("Cookies placés"). |
| To-complete marker | Text the church must supply is written in square brackets on a sun background: `[à compléter]`. Never fill it with invented content. | Mentions légales, cookie list notice. |
| Section links | "Dans la rubrique « … »" block before the footer, on a mint section: one white tile per page of the section; the current page is a night-blue tile marked "Vous êtes ici" after a 10 px accent dot. | Every page of a menu section (the three "L'église" pages). |
| Footer | Night blue. Computer: logo, address and e-mail, then "Notre église", "Aller plus loin", "Nous suivre"; a bottom line with ©, the three legal links and "Réalisé par Florian Desmet". Phone (compact): logo with the three social links as 44 px icon buttons (each with an `aria-label`), the two link lists side by side, then ©, the legal links on one wrapping line and the credit. | Every page. |

## Imagery

- Real photographs of the church only, cropped with `object-fit: cover` to fixed ratios (16:9, 4:3, 16:10).
- **One banner photo per menu section**: the church front for L'église, the hall for Évènements, the congregation for the other pages until the church provides photos for them (Prédications, Faire un don and the others).
- **No text directly on a photo.** The hero and banner photos are blurred (3 px) under a `overlay.hero` layer (night blue at 74 %), which keeps white text at 6.7:1 or more.
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
Every page was reworked with the current charter and validated on 2026-10-29.

| Page | Files |
|---|---|
| Accueil | [maquettes/home/](maquettes/home/): `home-desktop.html`, `home-mobile.html`, and full-page captures `home-desktop.png`, `home-mobile.png` |
| L'église › Qui sommes-nous ? | [maquettes/church/](maquettes/church/): `who-we-are-desktop.html`, `who-we-are-mobile.html` and their `.png` captures |
| L'église › L'équipe | [maquettes/church/](maquettes/church/): `team-desktop.html`, `team-mobile.html` and their `.png` captures |
| L'église › Notre histoire | [maquettes/church/](maquettes/church/): `history-desktop.html`, `history-mobile.html` and their `.png` captures |
| Évènements (list) | [maquettes/events/](maquettes/events/): `events-desktop.html`, `events-mobile.html` and their `.png` captures |
| Évènements › one event | [maquettes/events/](maquettes/events/): `event-desktop.html`, `event-mobile.html` and their `.png` captures |
| Prédications (list) | [maquettes/sermons/](maquettes/sermons/): `sermons-desktop.html`, `sermons-mobile.html` and their `.png` captures |
| Prédications › one sermon | [maquettes/sermons/](maquettes/sermons/): `sermon-desktop.html`, `sermon-mobile.html` and their `.png` captures |
| Nous contacter | [maquettes/contact/](maquettes/contact/): `contact-desktop.html`, `contact-mobile.html` and their `.png` captures |
| Faire un don | [maquettes/donate/](maquettes/donate/): `donate-desktop.html`, `donate-mobile.html` and their `.png` captures |
| Demande d'entretien, Demande de prière, Servir à l'église | [maquettes/forms/](maquettes/forms/): `interview-*.html`, `prayer-*.html`, `serve-*.html` (desktop and mobile) and their `.png` captures |
| Protection des données, Conditions générales, Mentions légales | [maquettes/legal/](maquettes/legal/): `privacy-*.html`, `terms-*.html`, `legal-notice-*.html` (desktop and mobile) and their `.png` captures |

The HTML files open in any browser without the canvas, and link to each other; each folder has its own `images/`. The home page files show its usual state (the latest sermon, three upcoming events); the live-stream and no-event states are tweaks of the canvas boards `Accueil-charte*.dc.html`.

On the canvas, the reworked boards are named `<Page>-charte.dc.html` and `<Page>-charte-telephone.dc.html` (page "Validés"); the boards from before the rework moved to "Brouillons" with "(avant la nouvelle charte)" in their titles. The nine `Ecran-*` prototypes were rebuilt from the reworked boards. To refresh the exports after a canvas change, read the boards from the canvas, then run [tools/export_maquettes.py](tools/export_maquettes.py) and [tools/shoot_maquettes.mjs](tools/shoot_maquettes.mjs) (usage at the top of each file).

### Harmonisation (2026-10-27)

A review of all validated pages found inner pages mostly night blue and white (yellow on the home page only, primary under 1 % of most pages), sections split by grey lines instead of alternating backgrounds, two-column blocks in five different ratios, and seven heading sizes with uneven gaps. The owner compared before/after proposals on the canvas (page "En cours", board `Fiche-harmonisation.dc.html`) and approved the rules now written above:

- yellow on every page (banner bar, play buttons, "Vous êtes ici" dot); the proposed yellow line under the current menu item was rejected;
- the closing block before the footer (removed on 2026-10-29);
- alternating backgrounds on every page (the sand sections were replaced on 2026-10-29);
- the two-column ratios and top alignment;
- the heading sizes and spacing table;
- the compact phone footer;
- one banner photo per menu section.

### Signal and mint (2026-10-29)

The pages still felt cold after the harmonisation. The owner asked for a few touches of vivid, joyful colour that both warm the pages and carry meaning, without weighing them down. A before/after sheet (canvas page "En cours", board `Fiche-couleurs.dc.html`) was approved with these changes:

- coral `color.signal` for "now" and "new" tags, mint `color.surface-mint` as a section or panel background;
- home page, Sunday 10h00–12h00 while YouTube streams the service: the latest sermon block becomes "En direct maintenant" with one "En direct" tag above the title and the button "Suivre le culte en direct"; with no stream it stays the latest sermon;
- events page: "Chaque semaine" on mint with white cards, then "Les prochains évènements" on white with outlined cards;
- donation page: the "Réduction d'impôt" panel on mint, "Comment faire un don ?" on sky.

### Charter rework (2026-10-29)

Every page was rebuilt with the harmonisation, signal and mint rules, one menu section at a time, and validated by the owner. Decisions taken during the rework, now written in the rules above:

- **Sand leaves the sections.** The owner found full sand sections dull; sand stays for blocks, cards and panels, and for the header band.
- **No closing block.** "Une autre demande ?" was removed from every page; only Nous contacter keeps its own block, on mint.
- **Sky and mint never side by side**, and two neighbouring sections never share a background. The former rule against white content straight before the footer was dropped.
- **Home page.** Hero cards stay primary, sky, sun, sand; the Bible verse panel is mint, so the page shows some green; "La dernière prédication" is a white section with a sand card; "Les évènements" is sky, with the coral "Nouveau" tag on the first card.
- **Departments.** The nine placeholder cards on L'équipe stay for the preprod presentation; see the no-placeholder-in-production principle.
- **Legal pages.** Content unchanged; spacing moved onto the scale; phone and e-mail on Mentions légales became `tel:` and `mailto:` links.

Section backgrounds, page by page, after the banner:

| Page | Sections, top to bottom |
|---|---|
| Accueil | hero (photo), "Une église pour toi" white (mint verse panel), "Les évènements" sky, "La dernière prédication" white (sand card) |
| Qui sommes-nous ? | vision sky, values white, "Dans la rubrique" mint |
| L'équipe | pastor couple sky, departments white, "Dans la rubrique" mint |
| Notre histoire | timeline white, partners sky, statement white, "Dans la rubrique" mint |
| Évènements | "Chaque semaine" mint (white cards), "Les prochains évènements" white (outlined cards) |
| One event | one white section with the sand practical info panel |
| Prédications | latest sermon white (7/5), "Toutes les prédications" sky, YouTube band white |
| One sermon | white section, then "Dans la même série" sky |
| Nous contacter | "Nos coordonnées" white (map, 5/7 sand form), then "Une autre demande ?" mint |
| Faire un don | white with the mint "Réduction d'impôt" panel, then "Comment faire un don ?" sky |
| Footer forms | one white section with the sand form panel |
| Legal pages | one white section with the sand table of contents |

A review of the reworked pages on the same day listed six improvements still to make; they are tracked in [reviews/07-mockups-charter-rework.md](../reviews/07-mockups-charter-rework.md).

## Target screens

The validated pages are also built as clickable, scrollable prototypes (page "Validés" of the canvas) on the most common screen sizes. Test the site on these before release:

| Device | Sizes (CSS px) | Header |
|---|---|---|
| Computer | 1920 × 1080, 1536 × 864, 1366 × 768 | Full menu, "L'église" opens a drop-down |
| Tablet | 1280 × 800 (landscape), 820 × 1180, 768 × 1024 | Full menu at 1280; "Menu" button and full-screen menu below |
| Phone | 412 × 915, 390 × 844, 360 × 800 | "Menu" button and full-screen menu |

## Site structure

Changes to the live site's structure, decided by the owner:

- **Home page (2026-10-27).** The validated home page ran to about 16 phone screens, against the short-pages rule. It keeps four blocks, in this order:
  1. **Hero**: title, service times, address, the four contact cards (80 px rows on a phone).
  2. **"Une église pour toi"**: the welcome text and the Bible verse, in a mint panel.
  3. **"Les évènements"**: the next three events. With no upcoming event the block is never empty: it says there is no special event at the moment and shows the weekly meetings instead (Culte, Sunday 10h00; Réunion de prière, Tuesday 19h00) as weekly meeting cards. The same sentence sits under "Les prochains évènements" on the events page, whose "Chaque semaine" block is already above it.
  4. **"La dernière prédication"**. On Sunday between 10h00 and 12h00, the site asks YouTube whether the service is streaming live. If it is, the block becomes "En direct maintenant": the live player, one "En direct" signal tag above the title, and the button "Suivre le culte en direct". If not, or outside that window, it stays the latest sermon. Nobody has to switch anything by hand.

  Removed: "Une église où tu trouveras ta place" (department tiles; the departments have no page), "Vous cherchez une église où grandir et vivre votre foi ?" (its "Je suis nouveau" button led nowhere: no newcomer page exists) and "Où sommes-nous ?" with the map (the hero already gives the address, linked to Google Maps, and the times). The no-event sentence and "Suivre le culte en direct" are interface copy, written with the mockup.
- **"L'église" menu (2026-10-26).** The five pages Notre histoire, Notre vision, Nos valeurs, Les départements and Le couple pastoral become three:
  - **Qui sommes-nous ?** — vision, then the nine values as an accordion. The short value titles were written for the accordion and approved; the full texts are the live site's.
  - **L'équipe** — the pastor couple's welcome, then one placeholder card per department.
  - **Notre histoire** — the timeline (dates taken only from the live text), the partners and the mission statement.
- **Departments.** No department page and no department text until the owner has gathered the content from each department's leader. The nine names stay: Génération Kids, Punch Group, ConneXion, Ainé'rgie, Femmes, LSV – Louange Sono Vidéos, Mission, Une prière pour toi, Entraide.
- **Events page (2026-10-27).** The live page is empty. It becomes: "Chaque semaine" (the regular meetings), then "Les prochains évènements", listed by date, nearest first, grouped by month. Each event gets its own page (image, date, time, place, text) with the Facebook and WhatsApp share buttons the live single-event template already has. Event content is placeholders until the church provides it. Other weekly meetings (ConneXion on Saturdays, Entraide on Wednesdays) are added only once the church confirms they still run.
- **Sermons page (2026-10-27).** The live page is a paged list of YouTube videos. It becomes: the latest sermon large (video, title, date, speaker, Bible passage, series, short summary), then "Toutes les prédications" as cards with two filters, series and speaker, and page numbers, then a link to the church's YouTube channel. Each sermon page has the video, a summary, a panel with date, speaker, Bible passage and series, the share buttons, and three sermons from the same series. Titles, dates and speakers stay placeholders in the mockups. The passage and summary fields are dropped if the church does not plan to fill them; the sentence "Abonnez-vous à la chaîne de l'église pour ne manquer aucune prédication." is interface copy written for the mockup.
- **Contact page (2026-10-27).** Same content as the live page: address, meeting times, e-mail, phone, and the form (name, e-mail, message, privacy sentence). It becomes "Nos coordonnées" with the map beside the form "Écrivez-nous" (labels always visible above the fields), then "Une autre demande ?" on mint, with contact cards to Servir à l'église, Demande de prière and Demande d'entretien. The headings, "Tous les champs sont obligatoires." and "Envoyer le message" were written for the mockup.
- **Donation page (2026-10-27).** Same content as the live page: "Soutenir l'église" (the live text), the tax reduction in a side panel (the live sentence plus the example "un don de 100 € ne vous coûte réellement que 34 €", computed from it; the owner asked for no large "66 %"), then "Comment faire un don ?" with two cards: bank transfer (a "Télécharger le RIB (PDF)" button pointing to the live RIB file, no account number on the page) and cheque (payee and postal address, postcode 59300). No online giving until the church sets one up. The transfer sentence was written for the mockup.
- **Footer forms (2026-10-27).** The three pages share one layout (owner's request: form under the text, full width, same look on all three). Texts, field labels and the 21 serving teams come from the live pages. Changes: the interview day is picked in a calendar; the serving teams become checkboxes (several allowed) in five groups written for the mockup (Communication, Culte, Enfants et jeunes, Accueil et vie de l'église, Organisation); the attendance choice is no longer pre-checked; the prayer request text is required (it is optional on the live form). Written for the mockup: "Votre demande", the required-fields sentence, "Vous pouvez cocher plusieurs pôles.", "Autre pôle" and "Envoyer ma demande".
- **Legal pages (2026-10-27).** "Protection des données" and "Conditions générales" keep the full live text, with a table of contents. Changes on "Protection des données": the cookie list (generated by a WordPress plugin, half in English) becomes one table per service, translated into French, without the WordPress-only "Divers" cookies, under a "[Liste à mettre à jour avec le nouveau site]" marker; the broken no-JavaScript sentence in 7.1 becomes a "Gérer mes choix de cookies" button; postcode 59300; contact e-mail secretariat@add-valenciennes.fr instead of the live addvalenciennes.web@gmail.com (owner's choice, to confirm with the church if the Gmail address is someone's working inbox). "Conditions générales" only gets the "évanglique" typo fixed and its links; it is a generic template written for an online shop ("produits", "panier", "inscription") and should be reviewed. **Mentions légales is new** (required in France, missing on the live site): publisher details are confirmed facts; legal form, RNA or SIREN number, publication director and host are `[à compléter]`. Every footer now links the three pages and credits Florian Desmet (linking to https://floriandesmet.dev) instead of Artception.
- **Pastor.** The current pastor couple is Nicolas and Mélanie Tessier; the live history page's sentence about Pastor Timothée Mele (2019) is dropped.

## Confirmed facts

Confirmed by a church member on 2026-10-25; use these everywhere, including sermon posts:

- Sunday service: **10h00** (the "09h30" in sermon posts is wrong).
- Prayer meeting: **Tuesday, 19h00** (confirmed 2026-10-26).
- Address: **75, rue du Chauffour, 59300 Valenciennes** (double f; postcode 59300, not 59000).
- Phone: **03 61 25 80 62** (given 2026-10-27; the live site's 03 61 25 89 19 is outdated).
- Site author: **Florian Desmet**, https://floriandesmet.dev (given 2026-10-27; no longer Artception).
