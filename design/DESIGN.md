# Design system — tonegliseavalenciennes.fr

The visual rules of the redesigned site, validated with the home page on 2026-10-25, the three "L'église" pages on 2026-10-26, and the events, sermons, contact and donation pages, the three footer forms and the legal pages on 2026-10-27, then harmonised across all pages the same day (see [Harmonisation](#harmonisation-2026-10-27)); the signal and mint colours were added on 2026-10-29 (see [Signal and mint](#signal-and-mint-2026-10-29)), and every page was reworked with these rules the same day (see [Charter rework](#charter-rework-2026-10-29)). The values live in [tokens.json](tokens.json) (W3C Design Tokens format, 2025.10) and in [tokens.css](tokens.css) as CSS custom properties; this file says how to use them. Change a value in `tokens.json`, never only in a page.

Working canvas (drafts, comments, history): https://claude.ai/artifact/UbLoYdhe5z2A3no2cDeo5u. Only validated pages are copied into [maquettes/](maquettes/).

**Style Épuré (2026-11-13).** The church asked for a more modern and clean look. The components now follow the style Épuré: one font (Inter Tight) for titles and text, white panels with a hairline instead of tinted ones, 4 px corners, white header and page banner without photo. The pages are reworked one by one: the home page, the menu and the footer were done on 2026-11-16 and 2026-11-17 (see [Home page and shared parts](#home-page-and-shared-parts-2026-11-17)), the single page "L'église" on 2026-11-18 (see [The page L'église](#the-page-léglise-2026-11-18)), the events, sermon and contact pages the same day (see [The events pages](#the-events-pages-2026-11-18), [The sermon pages](#the-sermon-pages-2026-11-18) and [The contact page](#the-contact-page-2026-11-18)), the donation page on 2026-11-23 (see [The donation page](#the-donation-page-2026-11-23)); until its turn, an inner page may still show the alternation described under Colour. See [Style Épuré](#style-épuré-2026-11-13).

## Principles

- **Members first, visitors second.** The site speaks first to church members (upcoming events, the Sunday live stream, sermons), then to visitors passing through the area who look for a place of worship (students, holidaymakers). People seeking faith are welcome, but the site does not address them first. When a block does not serve one of these two audiences, it goes.
- **Keep the brand, modernise the rest.** The logo stays and its colours set the palette (since 2026-11-09, those of the 90-year jubilee logo); typography, spacing and components are new.
- **Warm and communal, not childish.** Real photographs of the congregation, soft surfaces, nearly square corners.
- **Modernise, don't redesign.** Pages, menus and section order follow the live site; no section is invented. Bigger changes are proposed as options and only kept once the owner chooses them (see [Site structure](#site-structure)).
- **Short pages.** A page should read in three or four phone screens; long content is split by theme or folded (accordion) rather than stacked. Exception: "L'église" gathers five sections on one page, about 7 phone screens with the footer, because its section links lead straight to each one.
- **No invented content.** Copy comes from the live site. A missing fact is shown as a bracketed placeholder (`[Titre de l'évènement]`), never guessed.
- **No placeholder in production.** Placeholders (`[Présentation du département]`, `[Titre de l'évènement]`, `[à compléter]`) and missing texts may go to preprod, where the site is shown to the church, but never to production. Before every release to `main`, search the pages for square brackets and empty texts; any one left blocks the release.
- **Accessible by default.** The rules in [Accessibility](#accessibility) are part of the design, not a later pass.

## Colour

The palette comes from the 90-year jubilee logo (`logo/Logo-TEAV-new.jpg`): royal blue, night blue and gold. It became the default on 2026-11-09, replacing the first blues, the sun yellow and the mint.

| Role | Token | Value | Use |
|---|---|---|---|
| Primary | `color.primary` | `#0b49b0` | Royal blue. Every button, links, icons, the arrows of the contact cards. |
| Secondary | `color.secondary` | `#15273d` | Night blue. Headings, date badges, the current menu item (text), the "Sur cette page" button. |
| Accent | `color.accent` | `#d9a52b` | Gold. A small signature on every page: the dot before the current menu item and before small section labels ("Église Évangélique de Valenciennes", "L'église", "Agenda"…), the bar beside the home verse, the bar under the banner title (inner pages), every play button, the current section in the section links, the last timeline dot. Nothing else. |
| Signal | `color.signal` | `#ff6b4a` | Coral. Only what is happening now or has just been added: the "En direct" tag of the Sunday live stream, the "Nouveau" tag on an event. |
| Text | `color.text` / `color.text-muted` | `#2d3b4e` / `#556275` | Body text / dates, labels, captions. |
| Surfaces | `color.surface-*` | white, sand (ivory) `#f8f3e8`, sky `#e8eefa`, sun (light gold) `#f8e7b0`, gold (pale gold) `#fbf3dc` | Section backgrounds: white, sky, pale gold. Panel and card backgrounds: ivory, sky, light gold, pale gold, white. Ivory is never a section background. |
| Mist | `color.surface-mist` | `#f5f6f8` | Light neutral grey (style Épuré): image slots, light panels, the one tinted section a page may have, the footer. Muted text drops to 4.3:1 on it: on mist, small text uses `color.text`. |
| Field outline | `color.border-field` | `#768191` | The 1 px outline of every form field and filter menu: 3.2:1 or more on every surface, so everyone sees where to type (WCAG 1.4.11 asks 3:1). |

Every pairing used on the site was measured: body text 9:1 or more and muted text 5:1 or more on every surface, white on royal blue 8.1:1, night blue on gold 6.7:1 and on coral 5.4:1.

Rules:

- **All buttons are royal blue.** Filled `color.primary` with white text for the main action; white with a 1 px `color.border` hairline and night-blue text for a secondary action (style Épuré). There is no gold, grey or dark button.
- **Gold is never text and never a button.** It has no meaning; it only adds warmth.
- **Every page shows some gold**, at least the bar under the banner title. In the menu, gold is only the 6 px dot before the current item (2026-11-17): the current item is night blue and semibold, the others `color.text-muted`; there is no underline and no fill.
- **Gold warms, coral signals.** Gold means nothing; coral always means "now" or "new". Coral is always a filled tag with night-blue text on it, never text (2.8:1 on white), never a button, never a section background. It stays rare, once or twice per page at most, and never sits in the same spot as gold: on the live sermon the tag goes above the title, away from the gold play button.
- **Style Épuré: mostly white.** Components no longer use ivory or pale gold: panels and cards are white with a 1 px `color.border` hairline, image slots `color.surface-mist`. A page shows at most one tinted section (`color.surface-mist`, or sky). The three rules below describe the alternation of the pages drawn before 2026-11-13 and go once each section is reworked.
- **Ivory is for blocks, never for sections.** A full ivory section looks dull where the site wants joy. Ivory stays for cards and panels (form panel, practical info panel, latest sermon card, table of contents, the fourth hero card) and for the header band.
- **Every page shows the soft surfaces.** Sections alternate white, sky and pale gold so that two neighbours never share a background, on every page with no exception.
- **Sky and pale gold are never neighbours.** A white section always sits between them. Pale gold is a section background ("Chaque semaine") or a card background (Bible verse, "Réduction d'impôt"). Sections are never separated by a grey line on the same background; hairlines (`color.border`, or `color.border-tint` on sky) only split rows inside a section.
- A page may end on any section before the footer, which is mist with a hairline above (2026-11-17); there is no closing block.
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

- One family: **Inter Tight**, 400 for text, 500 for meta lines, 600 for headings, buttons and labels (style Épuré, 2026-11-13; it replaces Outfit and Source Sans 3). Headings are tightened: −0.025 em to −0.045 em, the larger the tighter. From Google Fonts; self-host it on the final site so no request reaches Google before consent.
- One size per role, whatever the page: every section title is 44 px. Exception: the home sections open with a title band whose title uses the page-title size (56 px, 36 px on a phone), to match the hero. A block title is the heading of a block inside a section (form panel, "Présentation", side panel, numbered heading of a legal page). A small title heads "Partager l'évènement". The timeline years and the "Nos valeurs" accordion rows keep their own sizes.
- Nothing below 15 px; running text never below 16 px on a phone.
- Line height 1.1 for headings, 1.6 for text. No headings in capitals.

## Spacing and layout

- Spacing scale (`space.*`): **8, 16, 24, 32, 48, 64, 96 px**. Every gap, padding and margin uses one of these. Exceptions, inside a component only, where a value lines something up with an icon or a line:
  - form fields (12 × 16 px inside; 56 px on the right of the date field, room for its calendar button) and filter menus (44 px on the right, room for the chevron);
  - tags and badges (4 × 12 px, 2 × 8 px), choice rows (12 px between box and label), 2 px nudges that centre an icon on its first text line;
  - the timeline indent (34 px on a computer, 26 px on a phone), which centres the dots on the line.
- Every section, header and footer included, centres its content in a **1200 px** container with 24 px side padding (16 px on a phone), so left and right edges line up down the page: on a 1440 px screen everything runs from 120 to 1320 px. Use `max-width: 1200px` on a content-box container; a `border-box` or 1152 px container moves the edges by 24 px (the home sections and the header did until 2026-11-17).
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

- **Photo and text: 50/50** ("Notre vision", "Le couple pastoral" and "Nos partenaires" on L'église).
- **Text and a panel: 7/5**, the text wider (latest sermon). On Faire un don both sections use two equal columns, so the text lines up with the transfer card and the tax card with the cheque card. Exception: on Nous contacter the form is the wider column (5/7).
- **Fixed column** only for the practical info panel (360 px: single event, single sermon) and the table of contents (300 px: legal pages).

### Folding

Three layouts. The computer layout from 980 px, the tablet layout from 768 to 979 px, the phone layout below 768 px. The tablet layout is the computer page with these changes:

| Computer | Tablet (768–979 px) | Phone (below 768 px) |
|---|---|---|
| Header with the full menu | Header with the "Menu" button and the full-screen menu, 24 px side padding | Same, 16 px side padding |
| Three cards in a row | Three in a row (two per row would leave one card alone with 3 or 9 items) | One per row |
| Four columns (serving teams, footer) | Two columns | One column (footer: two link lists side by side) |
| Photo and text 50/50 | One above the other (they wrap below 928 px); a 4:5 portrait photo becomes 4:3 | One above the other |
| Text and panel 7/5 or 5/7, text and 360 px panel | One above the other | One above the other |
| Table of contents (300 px column, 36 px rows) | Above the text, 44 px rows (touched, not clicked) | Closed "Sommaire" drop-down above the text |
| Sections 96 px top and bottom | 64 px | 48 px |

The content and the header share the same side padding, so left edges line up from the logo to the footer at every width.

## Shape

- Corners: **4 px** everywhere (buttons, tags, cards, panels, photos, the map), since the style Épuré. Fully round only for icon circles, the play button, the section dots and the floating "Sur cette page" button; the bottom sheet has 16 px top corners.
- No decorative blobs and no gradients. Shadows only on what floats above the page: the compact header once scrolled, the hover labels of the section dots, the "Sur cette page" button.

## Components

Every component below is linked: its shared style lives in [source/components/](source/components/) and on the canvas page "Composants" (see [Mockups](#mockups)).

| Component | Look | Where |
|---|---|---|
| Button | 52 px high, 24 px side padding, 4 px corners, semibold label; filled royal blue, or white with a grey hairline and night-blue text (style Épuré). | Everywhere. |
| Contact card | Whole card is the link. A white square with a 1 px hairline (style Épuré): a muted number (01–04) and the icon on top, then the label in semibold with a royal-blue arrow at the bottom. Home hero: four squares in a row; on a phone a list of 64 px rows (icon, label, arrow, no number). No photo (tried and dropped, 2026-11-17). | Hero: Servir avec nous, Confier une prière, Nous contacter, Demander un entretien (home texts of 2026-11-13). |
| Form field | Bold label always visible above the field; 48 px high, 1 px `color.border-field` outline, 4 px corners, 17 px text; the message box is 6–7 rows and can be resized. The form sits in a sand panel (48 px padding, 24 px × 16 px on a phone); the submit button is primary, full width on a phone. Optional fields say "(facultatif)" in grey after the label; everything else is required. A date field can be typed (its format, "(jj/mm/aaaa)", in grey after the label; the browser checks it and the form refuses to send without it) or picked in a calendar (44 px sky button with a calendar icon). | Contact form, footer forms. |
| Choice list | Radio buttons or checkboxes, 22 px, one per 44 px row, primary accent; grouped in a `fieldset` with a bold legend. Long lists are split into sub-groups with a small uppercase grey legend and a key line above; 4 columns on a computer, 1 on a phone. Nothing is pre-checked. | "Servir à l'église" (attendance, serving teams). |
| Full-width form page | Heading (h2) and one or two paragraphs (max 800 px), then the form panel across the whole container; on a computer short fields go two per row (name and e-mail always together). Same order on a phone, one field per row. | Demande d'entretien, Demande de prière, Servir à l'église. |
| Signal tag | Coral fill, 4 px corners, 4 × 12 px padding, 15 px bold uppercase night-blue label; "En direct" adds a 10 px night-blue dot before the label. | "En direct" above the title of the live sermon; "Nouveau" on a recently added event: in the top-left corner of the image of a home event card (16 px in), above the title of a phone agenda row. |
| Latest sermon | No frame (2026-11-17): the video (16:9, 4 px corners, gold play button) and, beside it (7/5, vertically centred), the date in royal blue, the title (32 px) and one "Regarder la prédication" button; on a phone the video on top and the button full width. The live state keeps the same layout with the "En direct" tag in place of the date. | Home page. |
| Event card | White with a 1 px `color.border` outline; 16:9 image slot (`color.surface-mist` placeholder until a real image exists), night-blue date badge overlapping the image, title, time and place, short text, "En savoir plus". | Home page on a computer (three in a row). |
| Agenda row | Phone home page (2026-11-17): white row with a hairline, 16 px padding; 64 px night-blue date badge, then the "Nouveau" tag if any, the title (18 px, h3) and "time · place" in muted text, and a royal-blue arrow; the whole row is the link. No image, no short text. | Home page on a phone, in place of the event cards. |
| Weekly meeting card | Sky, or white on a pale gold section; 32 px padding (16 px phone); night-blue square with the short day and the time, then the meeting name (h3), "Jour à HHhMM" in bold and the address as a link. | Home page, when fewer than three events are announced. |
| Month heading | Muted h3 in the heading font, without a line; events of that month follow. | Events list. |
| Event row | A row with a hairline under it, the whole row is the link: night-blue date badge (72 px, 64 px phone), the "Nouveau" tag if any, the title (24 px, 18 px phone, h3), "day · time · place" in muted text, a royal-blue arrow. No image and no short text. | Events list, under a month heading. |
| Facts list | Definition list without lines, 24 px between pairs: muted label above a semibold value (Date, Heure, Lieu with "Voir le plan"; Date, Orateur; or the contact details). No panel and no icons. | Single event and single sermon, in the 360 px column on a computer, under the image or video on a phone. Nous contacter, left column. |
| Share buttons | Secondary buttons, full width of the panel: "Partager sur Facebook", "Partager sur WhatsApp". | Single event, single sermon. |
| Video slot | 16:9, 4 px corners, night blue with a round accent play button (night-blue triangle); holds the YouTube player. | Sermons list (latest sermon), single sermon. |
| Sermon card | The whole card is the link, without frame: 16:9 thumbnail (`color.surface-mist` placeholder, round accent play button), title (20 px, h3), "date · speaker" in muted text. Three per row on a computer; on a phone a row with a 128 px thumbnail on the left, without a line. | Sermons list. |
| Filter menu | Native `<select>` with a visible bold label above, 48 px high, 1 px `color.border-field` outline, chevron on the right; 280 px wide on a computer, full width on a phone. The result count sits beside or under the menu. | Sermons list (Orateur). |
| Pagination | 48 px squares, current page in night blue, then "Suivante". On a phone: "Page 1 sur N" and a secondary "Plus anciennes" button. | Sermons list. |
| Tile | Sand, 64 px high (52 px phone), bold label, blue arrow; the whole tile is the link. | Unused since the home page lost its department block (2026-10-27); kept for department links once their pages exist. |
| Info card | Sand, 24 px padding, muted label above a bold value. | Unused since the home page lost "Où sommes-nous ?" (2026-10-27). |
| Page banner | White with a hairline under it, no photo (style Épuré); title 64 px (40 px phone) in night blue, a 56 × 4 px gold bar (40 × 4 phone). No breadcrumb (removed from every page on 2026-11-18). On L'église the hairline moves into the top of the first section. | Top of every inner page. |
| Accordion | Native `<details>`/`<summary>`: short title in the heading font, chevron, with a number in primary for the values; rows split by 1 px `color.border` lines, 64 px high (56 px phone). The first value starts open; the departments start closed. | L'église: "Nos valeurs", "Les départements" (three columns of three on a computer and tablet, one list on a phone). |
| Timeline | Computer and tablet: steps in columns (four, two on a tablet), each with a 2 px primary line on top, a white dot with a primary ring at its left end, the year as an h3 in primary and the text. Phone: vertical line, dots on the left, year above the text. The last dot is filled with the accent. | L'église, "Notre histoire". |
| Partner link | A row without a line, at least 64 px high: name (semibold, 20 px, 18 px phone), domain in muted text, external-link icon. | L'église, "Nos partenaires". |
| Table of contents | Legal and other long text pages: on a computer a sand panel (6 px corners, 24 px padding) in a 300 px column, sticky at the top while reading, small uppercase "Sommaire" label and one link per numbered section (36 px rows, the one place below 44 px, mouse use only); text column max 760 px. On a phone a closed sand `details` "Sommaire" (52 px) above the text, 44 px links. | Protection des données, Conditions générales, Mentions légales. |
| Data table | Inside a bordered card (6 px corners): sand header with the h3 and a small white category tag, then a full-width table with a grey header row and hairline rows (8 × 12 px cells, 16 px text, codes in monospace). | Cookie list ("Cookies placés"). |
| To-complete marker | Text the church must supply is written in square brackets on a sun background: `[à compléter]`. Never fill it with invented content. | Mentions légales, cookie list notice. |
| Header | White. At the top of the page it is tall and airy: 120 px on a computer (logo 72 px, 18 px links 40 px apart), 88 px on a tablet, 80 px on a phone, with no line under it on a computer. Once the reader scrolls it stays on screen and shrinks to a compact bar (72 / 68 / 64 px) with a hairline and a soft shadow. Links are `color.text-muted`; the current one is night blue, semibold, after a 6 px gold dot; "Faire un don" is a filled button (the dot sits inside it on the donation page). Tablets and phones show a "Menu" button that opens a white full-screen menu with the same current-item marker. | Every page. |
| Section title band | Opens each home section after the hero: a small label in muted text after an 8 px gold dot ("L'église", "Agenda", "Prédications"; no numbers), the title (56 px, 36 px phone) on the left and, where useful, a text link with an arrow on the right ("Tous les évènements", "Toutes les prédications"; under the content on a phone); a 1 px hairline under the band. | Home page: Bienvenue, Les évènements, La dernière prédication. |
| Verse | A sentence without a panel: a 4 px gold bar on its left (32 px gap, 20 px phone), the text in 32 px semibold night blue (22 px phone), the reference, if any, in muted text under it. | Home "Bienvenue", beside the welcome text (under it on a phone); the mission statement at the end of L'église. |
| Section dots | Computer, home page and L'église: a column of 8 px dots fixed on the right edge, vertically centred; the current section's dot becomes an 8 × 24 px gold bar. Each dot is a link named after its section title (home: "Haut de page", "Bienvenue", "Les évènements", "La dernière prédication" or "En ce moment"; L'église: "Notre vision", "Nos valeurs", "Le couple pastoral", "Les départements", "Notre histoire"); the name shows in a small white label on hover or keyboard focus. A click glides to the section. | Home page and L'église, computer and 1280 px landscape tablet. |
| "Sur cette page" button | Touch screens, home page and L'église: a night-blue pill (52 px, list icon, the current section title, chevron) floating 16 px from the right and 24 px from the bottom, hidden at the top of the page. It opens a white bottom sheet "Sur cette page" with the section titles as 56 px rows, the current one semibold after a gold dot; choosing one closes the sheet and glides there; a tap on the dimmed page or Escape closes it. Focus moves into the list and back to the button. | Home page and L'église, phones and portrait tablets. |
| Footer | Mist with a hairline above it (2026-11-17). Computer: the colour logo with the address (a Google Maps link) and "Culte le dimanche à 10h00 · Prière le mardi à 19h00" on the left, the three social links as 44 px icon buttons (each with an `aria-label`) on the right; a bottom line with "© 2026 Église Évangélique de Valenciennes", the three legal links and "Réalisé par Florian Desmet". Phone: the same, one block under the other. Text in `color.text` (muted text is too light on mist). Social links go to the church's accounts (Facebook `eglise.evangelique.add.valenciennes`, Instagram `tonegliseavalenciennes`, the YouTube channel). The link lists, the e-mail and the Assemblées de Dieu / CNEF line left the footer: the menu and the hero cards give the links, "Nous contacter" the e-mail, "Notre histoire" presents the two networks. | Every page. |

Links the real site builds, left empty (`href="#"`) in the mockups on purpose: the share buttons (Facebook and WhatsApp share addresses of the page), "Voir le plan" (Google Maps search of the event's address), and the sermon page numbers. The "Gérer mes choix de cookies" button opens the consent banner of the real site. Every other link has its real address or a visible `[à compléter]` marker, like the PDF of the Conditions générales, which the new site does not have yet.

## Imagery

- Real photographs of the church only, cropped with `object-fit: cover` to fixed ratios (16:9, 4:3, 16:10).
- **One banner photo per menu section**: the church front for L'église, the hall for Évènements, the congregation for the other pages until the church provides photos for them (Prédications, Faire un don and the others).
- **No text directly on a photo.** Since the style Épuré the home hero and the page banners have no photo. Should a photo carry text again, blur it (3 px) under the `overlay.hero` layer (night blue at 74 %), which keeps white text at 6.7:1 or more.
- Map: a static image of the Google Maps view that links to Google Maps. An embedded interactive map would load Google before the visitor consents.

## Accessibility

- Text contrast at least 4.5:1 (3:1 for 24 px and above); the token descriptions give the measured ratios.
- Anything tappable is at least **44 px** high, including footer links and the hero address.
- Keyboard focus: a 3 px outline with 3 px offset, `color.secondary` on light areas and white on dark areas (`.on-dark`). Never remove it.
- Real `<a>` and `<button>` elements; icon-only links carry an `aria-label`; decorative images have an empty `alt`.
- `lang="fr"`, one `h1` per page, headings in order.
- Motion respects `prefers-reduced-motion`: with it, the section-by-section scroll, the glides and the fade of the home sections are off.
- Anything fixed over the page (section dots, "Sur cette page" button) carries readable names, and its current item is marked with `aria-current`, not only by colour.

## Mockups

Every page was reworked with the current charter and validated on 2026-10-29; the six improvements of the following review were validated on 2026-11-06.

| Page | Files |
|---|---|
| Accueil | [maquettes/home/](maquettes/home/): `home-desktop.html`, `home-mobile.html`, and full-page captures `home-desktop.png`, `home-mobile.png` |
| L'église | [maquettes/church/](maquettes/church/): `church-desktop.html`, `church-mobile.html` and their `.png` captures, written at the next refresh; until then the folder still holds the three former pages |
| Évènements (list) | [maquettes/events/](maquettes/events/): `events-desktop.html`, `events-mobile.html` and their `.png` captures |
| Évènements › one event | [maquettes/events/](maquettes/events/): `event-desktop.html`, `event-mobile.html` and their `.png` captures |
| Prédications (list) | [maquettes/sermons/](maquettes/sermons/): `sermons-desktop.html`, `sermons-mobile.html` and their `.png` captures |
| Prédications › one sermon | [maquettes/sermons/](maquettes/sermons/): `sermon-desktop.html`, `sermon-mobile.html` and their `.png` captures |
| Nous contacter | [maquettes/contact/](maquettes/contact/): `contact-desktop.html`, `contact-mobile.html` and their `.png` captures |
| Faire un don | [maquettes/donate/](maquettes/donate/): `donate-desktop.html`, `donate-mobile.html` and their `.png` captures |
| Demande d'entretien, Demande de prière, Servir à l'église | [maquettes/forms/](maquettes/forms/): `interview-*.html`, `prayer-*.html`, `serve-*.html` (desktop and mobile) and their `.png` captures |
| Protection des données, Conditions générales, Mentions légales | [maquettes/legal/](maquettes/legal/): `privacy-*.html`, `terms-*.html`, `legal-notice-*.html` (desktop and mobile) and their `.png` captures |

The HTML files open in any browser without the canvas, and link to each other; each folder has its own `images/`. The home page files show its usual state (the latest sermon, three upcoming events); the live-stream and no-event states are tweaks of the canvas boards `Accueil-charte*.dc.html`.

On the canvas, the reworked boards are named `<Page>-charte.dc.html` and `<Page>-charte-telephone.dc.html` (page "Validés"); the boards from before the rework moved to "Brouillons" with "(avant la nouvelle charte)" in their titles.

**One source.** [source/](source/) holds one header, one footer and one helmet per device (`shell/`), the body of each page (`pages/<Page>.desktop.html`, `pages/<Page>.phone.html`), the components (`components/`), the shells of the three kinds of prototype, and the titles, sizes and tweaks of every board (`boards.json`, `prototypes.json`). Colours are written as `[[token]]` and read from [tokens.json](tokens.json). [tools/build_maquettes.py](tools/build_maquettes.py) builds the 28 boards, the 9 prototypes and the 27 component boards from it, the tablet layout included.

**Linked components (2026-11-09).** Each of the 25 components of [components/catalog.json](source/components/catalog.json) (the table below, plus the home hero, the verse panel, the latest-sermon card and the share buttons) has one shared style per device in `components/<name>.<device>.css`. On the pages, its elements carry a class (`c-<name>` on the root, `c-<name>__<path>` on each styled part) and keep inline only what differs from one instance to the next: a card's background, a button's width. Every board and prototype gets these styles in its helmet. The 52 px buttons were brought to two models on the way (filled, outlined), which moved some by 4 px at most. The canvas page "Composants" shows one board per component, plus the header and the footer, with a computer and a phone example taken from the pages and the number of uses: a change made there reaches every page at the next pull and build. Only styles travel: a change of structure (an added element) is made on the pages. A component drawn inside another (a button in a card, a tag on an event card, the fields of a form) is shown on that board with its own shared style, but is edited only on its own board: an edit to it on the host board is not pulled back. A component with several models shows the first instance of each (the Button board: filled, then outlined; `variant` in the catalog names the inline property that tells them apart). `build_maquettes.py link` splits the styles again after a new instance has been pasted on a page; a component is recognised by its class, or by the rules of the catalog.

The way round:

1. The owner edits component boards for anything shared and page boards for the rest, never the prototypes (they are rebuilt).
2. Download the `*-charte*` boards, the `Ecran-*` prototypes and the `Composant-*` boards, then `build_maquettes.py pull <folder>`: the edits land in `source/`; every page whose header, footer or prototype menu differs from the shared one is reported (the shared one wins, so a menu change is made once), and changes on the component boards win over the pages.
3. `build_maquettes.py build <folder>` and `build_maquettes.py components <folder>`, publish the changed files to the canvas.
4. To refresh the repository, run [tools/export_maquettes.py](tools/export_maquettes.py) on the built boards and [tools/shoot_maquettes.mjs](tools/shoot_maquettes.mjs) for the captures (usage at the top of each file).

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
- **No closing block.** "Une autre demande ?" was removed from every page; only Nous contacter keeps its own, a short sentence with three links on a computer.
- **Sky and mint never side by side**, and two neighbouring sections never share a background. The former rule against white content straight before the footer was dropped.
- **Home page.** Hero cards stay primary, sky, sun, sand; the Bible verse panel is mint, so the page shows some green; "La dernière prédication" is a white section with a sand card; "Les évènements" is sky, with the coral "Nouveau" tag on the first card.
- **Departments.** The nine placeholder cards on L'équipe stay for the preprod presentation; see the no-placeholder-in-production principle.
- **Legal pages.** Content unchanged; spacing moved onto the scale; phone and e-mail on Mentions légales became `tel:` and `mailto:` links.

Section backgrounds, page by page, after the banner:

| Page | Sections, top to bottom |
|---|---|
| Accueil | hero (photo), "Bienvenue" white (pale gold verse panel), "Les évènements" sky, "La dernière prédication" white (sand card) |
| Qui sommes-nous ? | vision sky, values white, "Dans la rubrique" pale gold |
| L'équipe | pastor couple sky, departments white, "Dans la rubrique" pale gold |
| Notre histoire | timeline white, partners sky, statement white, "Dans la rubrique" pale gold |
| Évènements | "Chaque semaine" pale gold (white cards), "Les prochains évènements" white (outlined cards) |
| One event | one white section with the sand practical info panel |
| Prédications | latest sermon white (7/5), "Toutes les prédications" sky, YouTube band white |
| One sermon | white section, then "Dans la même série" sky |
| Nous contacter | White throughout: "Nos coordonnées" (details and map, 5/7 form without frame), then "Une autre demande ?" |
| Faire un don | white: "Comment faire un don ?" (two framed cards), then "Soutenir l'église" with the pale gold "Réduction d'impôt" card |
| Footer forms | one white section with the sand form panel |
| Legal pages | one white section with the sand table of contents |

A review of the reworked pages on the same day listed six improvements; all six were made and validated between 2026-10-29 and 2026-11-06, see [reviews/07-mockups-charter-rework.md](../reviews/07-mockups-charter-rework.md).

### Jubilee colours (2026-11-09)

The church's 90-year jubilee logo came with its own palette. A colour variant of every page was drawn from it on 2026-11-06, and the owner made it the default on 2026-11-09, keeping the current style otherwise: royal blue `#0b49b0` replaces the first blue, night blue `#15273d` the first one, gold `#d9a52b` the sun yellow, ivory, pale sky and light gold the sand, sky and sun surfaces, and pale gold (`color.surface-gold`, `#fbf3dc`) the mint, which the logo does not have. Coral stays: it carries a meaning. The rules are unchanged, mint read as pale gold. Three home pages in other styles (modern, classic, dynamic) were drawn the same week and set aside.

### Style Épuré (2026-11-13)

The church's wish for a more modern and clean look led to a new round on the home hero: three styles with a contrasting title font (handwritten, soft serif, bold grotesque), then photo cards, then three modern styles (Épuré, Éditorial, Bento) on the canvas page "En cours". The owner chose **Épuré** for the whole site, with Inter Tight for titles and text, mostly white sections, a white header with a hairline and the night-blue footer kept, and asked to change the components first. The component boards were redrawn (canvas page "Composants Épuré") and validated the same day:

- Inter Tight everywhere, semibold headings tightened; 4 px corners everywhere;
- ivory and pale gold leave the components: white panels with a hairline (form, practical info, side panel, table of contents, verse, giving card, latest sermon), `color.surface-mist` for image slots;
- date tags become royal-blue text; secondary buttons a grey hairline with night-blue text;
- header and page banner white, without photo; home hero without photo, the title then the four contact cards as white squares;
- the footer keeps its night blue.

Done on the home page and the shared parts on 2026-11-16 and 2026-11-17 (see below). Still to do, page by page: the section backgrounds of the inner pages (at most one tinted section per page).

### Home page and shared parts (2026-11-17)

The owner reworked the home page section by section on the canvas page "En cours", choosing each time among three drafts (boards kept there: `Cartes-accueil-styles`, `Bienvenue-organisations`, `Evenements-structures`, `Predications-structures`, `Gauche-1-editorial` to `Gauche-3-bandeau`, `Menus-propositions`, `Pieds-de-page-propositions`, `Ancres-styles`, `Ancres-mobile`, and the separate page of scroll animations https://claude.ai/artifact/P1FSosq6k8hQyro4K3vgP9). Decisions, now in the rules above:

- **Hero.** Mostly white; the church's name above the title after a gold dot; the four contact cards numbered 01–04, without photo (the church's own photos were tried in the cards, then dropped). On a phone the cards become list rows.
- **Text aligned left everywhere.** Centred sections were tried and refused. Each section after the hero opens with a title band, without numbers (they were confused with the card numbers).
- **Bienvenue.** Welcome text on the left, the verse on the right with a gold bar; verse Lamentations 3:22 ("La bonté du SEIGNEUR n'est pas épuisée, il n'a pas fini de montrer son amour.").
- **Les évènements.** Mist section; three cards on a computer, agenda rows on a phone (a swipe carousel was tried and dropped).
- **La dernière prédication.** White; video and text side by side, no frame.
- **One screen per section on a computer.** The hero fills the first screen under the tall header; each following section fills one screen under the compact header (`calc(100svh - 72px)` once scrolled). The wheel moves section by section, then to the bottom of the footer, in a 1 s eased glide (the browser's own snap was too quick); the coming section fades in over 1.2 s while the others stay faint. Keyboard and touch scroll freely. On a phone the sections keep their natural height (the hero alone fills the first screen), so tall phones show no empty bands.
- **Section links.** Gold-marked dots on the right edge on a computer; on touch screens the "Sur cette page" button (dots were not visible or accessible enough there).
- **Menu** tall at the top, compact once scrolled, current item marked by the gold dot; **footer** light and short.
- **Alignment.** Header, sections and footer on the same 1200 px column.

The captures in [maquettes/](maquettes/) still show the home page before this round; they are refreshed once every page is reworked.

### The page L'église (2026-11-18)

The owner chose to gather the three pages of the section on one page, with the section links of the home page, then chose each part among drafts on the canvas page "En cours" (boards `Eglise-haut-propositions`, `Eglise-valeurs-propositions`, `Eglise-couple-propositions`, `Eglise-departements-propositions`, `Eglise-histoire-propositions`, and the assembled `Eglise-page-complete`). Decisions, now in the rules above:

- **Few elements.** Under the header: the title "L'église" and its gold bar alone. No breadcrumb, here and on every other page.
- **Every section opens the same way:** a hairline, a small label after a gold dot (the former page name: "Qui sommes-nous ?", "L'équipe", "Notre histoire"), then its title. All sections are white.
- **Notre vision:** label, title and text on the left, photo on the right. **Nos valeurs:** title and introduction, then the list across the full width. **Le couple pastoral:** photo on the left, message on the right; on a phone the message folds after its first paragraph ("Lire la suite", "Réduire"). **Les départements:** three columns of closed rows, without numbers. **Notre histoire:** the timeline in columns, the partners beside the church front (no photo on a phone), then the mission statement.
- **Free scrolling.** The section dots and the "Sur cette page" button come from the home page, but not its section-by-section glide or fade: this page is for reading, and some sections are taller than the screen.
- **Length.** About 6 computer screens and a little over 7 phone screens, footer included.

### The events pages (2026-11-18)

The owner chose the list, then the page of one event, on the canvas page "En cours" (boards `Evenements-liste-propositions`, `Evenement-propositions`, and the assembled `Evenements-pages-completes`). They open like L'église: the title and its gold bar alone, then a hairline. All sections are white.

- **List.** "Chaque semaine" comes first: it is short and keeps the page useful when no event is announced. The weekly meetings are two date cards side by side (see below). "Les prochains évènements" follows, grouped under month headings, as event rows without image.
- **One event.** Image and presentation on the left, event facts and share buttons in the 360 px column on the right; on a phone: image, facts, presentation, share. The date line left the banner, since the facts repeat it, and "Tous les évènements" moved to the end of the page.

### The sermon pages (2026-11-18)

The owner chose the list, then the page of one sermon, on the canvas page "En cours" (boards `Predications-liste-propositions`, `Predication-propositions`, and the assembled `Predications-pages-completes`). They open like the events pages.

- **List.** "La dernière prédication" first, video and text side by side (7/5), as on the home page. "Toutes les prédications" follows, with the YouTube channel link in its title band, the speaker filter, thumbnail cards and page numbers. On a phone the cards become rows with a small thumbnail.
- **One sermon.** Video on the left, date, speaker and share buttons in the 360 px column on the right; "Toutes les prédications" at the end. The former summary, passage, series and "Dans la même série" are gone.

### The contact page (2026-11-18)

The owner chose the layout, then the end of the page, on the canvas page "En cours" (boards `Contact-propositions` and `Contact-autre-demande`). The page opens like the events and sermon pages and uses no hairline except the one opening each section.

- **Nos coordonnées.** The label and the title run above both columns, so "Écrivez-nous" starts level with the first detail. Left (5/12): address, meeting times, e-mail and phone as plain muted-label and semibold-value pairs, 24 px apart, without icons or hairlines, then the 16:9 map. Right (7/12): the form panel without its frame. On a phone: details, map, form.
- **Une autre demande ?** On a computer, the title and one sentence across the full width, with three underlined links to Servir, Prière and Entretien. On a phone, three 48 px links with an arrow, easier to tap.

### The donation page (2026-11-23)

The owner chose two columns, then the variant with thin-framed cards, on the canvas page "En cours" (boards `Don-propositions`, `Don-variantes` and `Don-page`). The page opens like the contact page.

- **Comment faire un don ?** comes first: two cards of equal height with a 1 px hairline and 4 px corners, no icon. "Par virement": a short sentence and the "Télécharger le RIB (PDF)" button (full width on a phone). "Par chèque": payee and postal address as muted-label and semibold-value pairs.
- **Soutenir l'église** follows: the live text on the left, and on the right a "Réduction d'impôt" card on pale gold (`color.surface-gold`), without a frame. Its key sentence, "Un don de 100 € ne vous coûte réellement que 34 €.", is semibold at body size; the 66 % rule follows in muted 16 px text.
- Both sections use the same two equal columns on a computer and a tablet, so the cards line up. On a phone everything stacks: transfer, cheque, text, tax card.
- The way-to-give card and side panel components were removed; the cards are drawn on the page.

### Weekly meetings on the events page (2026-11-18)

"Chaque semaine" shows two cards in the style of the event rows, without a line or an arrow: the night-blue date badge, the meeting name, then "day · time · address" (the address is the map link). Two columns on a computer and a landscape tablet; one column on a phone. On a phone and a portrait tablet the address goes on its own line.

The badge always shows the next date, in Paris time, computed in the visitor's browser because the site is built in advance. It moves to the next week when the meeting ends: Sunday at 12:00 (the service lasts two hours) and Tuesday at 20:00 (the prayer meeting lasts one hour). The built page must carry a sensible date for visitors without JavaScript.

### Thin lines (2026-11-18)

The owner reviewed every hairline of the reworked pages (board `Revue-des-traits` on the canvas page "En cours"). Space does the separating wherever it can.

- **Kept:** the line opening each section, the line under the home title bands, the lines between accordion rows and between event rows, the timeline.
- **Removed:** between the facts of an event, a sermon or the contact details; above the weekly meetings; under the month headings; above accordion lists; around the partner links; between the sermon rows on a phone.

## Target screens

The validated pages are also built as clickable, scrollable prototypes (page "Validés" of the canvas) on the most common screen sizes. Test the site on these before release:

| Device | Sizes (CSS px) | Header |
|---|---|---|
| Computer | 1920 × 1080, 1536 × 864, 1366 × 768 | Full menu; tall at the top, compact once scrolled |
| Tablet | 1280 × 800 (landscape), 820 × 1180, 768 × 1024 | Full menu at 1280; "Menu" button and full-screen menu below |
| Phone | 412 × 915, 390 × 844, 360 × 800 | "Menu" button and full-screen menu |

The 1280 px landscape tablet shows the computer layout, the two portrait tablets the tablet layout (see [Folding](#folding)), the phones the phone layout. Each prototype has two settings under "États des pages": the sermon block ("La dernière prédication" or "En direct") and the events block ("Des évènements à venir" or "Aucun évènement à venir").

## Site structure

Changes to the live site's structure, decided by the owner:

- **Home page (2026-10-27).** The validated home page ran to about 16 phone screens, against the short-pages rule. It keeps four blocks, in this order:
  1. **Hero**: the church's name, title, service times, address, the four contact cards (64 px list rows on a phone). Header and hero fill exactly the first screen, whatever its height (`min-height: calc(100svh - header)`, content centred), so the opening screen never cuts a line of text nor ends on an empty band (owner's rules, 2026-11-06). Inner pages keep their short banner: the owner tried banners sized to the screen and kept the short ones.
  2. **"Bienvenue"**: the welcome text and the Bible verse (Lamentations 3:22), side by side on a computer.
  3. **"Les évènements"**: the next three events (cards on a computer, agenda rows on a phone). With one or two upcoming events, the cards keep their size and weekly meeting cards (Culte, then Réunion de prière) fill the rest of the row (owner, 2026-11-06). With no upcoming event the block is never empty: it says there is no special event at the moment and shows the weekly meetings instead (Culte, Sunday 10h00; Réunion de prière, Tuesday 19h00) as weekly meeting cards. On the home page the sentence is "Rien de particulier n'est prévu pour l'instant. Nous nous retrouvons quand même chaque semaine." (home texts of 2026-11-13), and the weekly cards read "Ouvert à tous" and "Ouverte à tous" under their titles, the time staying in their badge; the events page keeps "Aucun évènement particulier n'est prévu pour le moment." until its own texts are reviewed.
  4. **"La dernière prédication"**. On Sunday between 10h00 and 12h00, the site asks YouTube whether the service is streaming live. If it is, the block becomes "En ce moment": the live player, one "En direct" signal tag above the title, "Sur YouTube, de 10h00 à 12h00." and the button "Regarder le culte". The block follows YouTube, not the clock (owner, 2026-11-06): before a late start and as soon as the stream ends, even before 12h00, it shows the latest sermon again. Nobody has to switch anything by hand.

  Removed: "Une église où tu trouveras ta place" (department tiles; the departments have no page), "Vous cherchez une église où grandir et vivre votre foi ?" (its "Je suis nouveau" button led nowhere: no newcomer page exists) and "Où sommes-nous ?" with the map (the hero already gives the address, linked to Google Maps, and the times). The no-event sentence and "Suivre le culte en direct" are interface copy, written with the mockup.
- **"L'église" (2026-11-18).** The live site's five pages Notre histoire, Notre vision, Nos valeurs, Les départements and Le couple pastoral become one page, reached by a direct link in the menu (no drop-down, no "Dans la rubrique" block). It replaces the three pages of 2026-10-26. Sections, in order: Notre vision, Nos valeurs, Le couple pastoral, Les départements, Notre histoire (with the partners and the mission statement). The short value titles were written for the accordion and approved; every other text is the live site's.
- **Departments.** One closed row per department on L'église; no department page and no department text until the owner has gathered the content from each department's leader. The nine names stay: Génération Kids, Punch Group, ConneXion, Ainé'rgie, Femmes, LSV – Louange Sono Vidéos, Mission, Une prière pour toi, Entraide.
- **Events page (2026-10-27, layout reworked 2026-11-18).** The live page is empty. It becomes: "Chaque semaine" (the regular meetings), then "Les prochains évènements", listed by date, nearest first, grouped by month. Each event gets its own page (image, date, time, place, text) with the Facebook and WhatsApp share buttons the live single-event template already has. Event content is placeholders until the church provides it. Other weekly meetings (ConneXion on Saturdays, Entraide on Wednesdays) are added only once the church confirms they still run.
- **Sermons pages (2026-11-18).** The live page is a paged list of YouTube videos. It becomes: the latest sermon (video, title, date, speaker, "Regarder la prédication"), then "Toutes les prédications" as cards with a speaker filter, page numbers and a link to the church's YouTube channel. Each sermon page has the video, the date, the speaker, the share buttons and a link back to the list. No summary, Bible passage or series, which the church would have to enter for every sermon. The speaker must be available for each video, or the filter cannot work. Titles, dates and speakers stay placeholders in the mockups.
- **Contact page (2026-11-18).** Same content as the live page: address, meeting times, e-mail, phone and the form (name, e-mail, message, privacy sentence), under "Nos coordonnées", then "Une autre demande ?" towards the three footer forms. See [The contact page](#the-contact-page-2026-11-18).
- **Donation page (2026-10-27, layout reworked 2026-11-23).** Same content as the live page: "Comment faire un don ?" now comes first, then "Soutenir l'église" (the live text) with the tax reduction in a pale gold card (the live sentence plus the example "un don de 100 € ne vous coûte réellement que 34 €", computed from it; the owner asked for no large "66 %"). The two ways to give are two cards: bank transfer (a "Télécharger le RIB (PDF)" button pointing to the live RIB file, no account number on the page) and cheque (payee and postal address, postcode 59300). No online giving until the church sets one up. The transfer sentence was written for the mockup.
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
