# Design system — tonegliseavalenciennes.fr

The visual rules of the redesigned site, validated with the home page on 2026-10-25, the three "L'église" pages on 2026-10-26, and the events, sermons, contact and donation pages, the three footer forms and the legal pages on 2026-10-27. The values live in [tokens.json](tokens.json) (W3C Design Tokens format, 2025.10) and in [tokens.css](tokens.css) as CSS custom properties; this file says how to use them. Change a value in `tokens.json`, never only in a page.

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
| Contact card | Whole card is the link. 176 px min height (144 px phone), icon in a 48 px white circle, label in the heading font with an arrow. Backgrounds in order: primary, sky, sun, sand. On the contact page the three other requests sit three in a row (primary, sky, sun); on a phone they become 80 px rows, icon on the left, arrow on the right. | Hero: Servir à l'église, Demande de prière, Nous contacter, Demande d'entretien. Contact page: "Une autre demande ?". |
| Contact details | Definition list: primary icon, muted label, bold value; address, e-mail and phone are links (`tel:` on the phone number), each at least 44 px high. | Contact page. |
| Form field | Bold label always visible above the field; 48 px high, 1 px grey outline, 4 px corners, 17 px text; the message box is 6–7 rows and can be resized. The form sits in a sand panel (48 px padding, 24 px × 16 px on a phone); the submit button is primary, full width on a phone. Optional fields say "(facultatif)" in grey after the label; everything else is required. Date fields open a calendar (44 px sky button with a calendar icon) instead of free typing. | Contact form, footer forms. |
| Choice list | Radio buttons or checkboxes, 22 px, one per 44 px row, primary accent; grouped in a `fieldset` with a bold legend. Long lists are split into sub-groups with a small uppercase grey legend and a key line above; 4 columns on a computer, 1 on a phone. Nothing is pre-checked. | "Servir à l'église" (attendance, serving teams). |
| Full-width form page | Heading (h2) and one or two paragraphs (max 800 px), then the form panel across the whole container; on a computer short fields go two per row (name and e-mail always together). Same order on a phone, one field per row. | Demande d'entretien, Demande de prière, Servir à l'église. |
| Side panel | Sky, 6 px corners, 48 px padding (24 px × 16 px on a phone); small heading (h3), text, and an optional key line in bold on a white inset (4 px corners). Beside the text on a computer (7/5 columns), under it on a phone. No oversized figures. | Donation page ("Réduction d'impôt"). |
| Way-to-give card | White, 6 px corners, 48 px padding (24 px × 16 px phone); icon in a 48 px sky circle, h3, then either a short text and a primary button (download) or a definition list. Two per row on a computer. | Donation page ("Par virement", "Par chèque"). |
| Content card | White, 6 px corners; image on one side or on top, text block with 48 px padding. | Latest sermon, newcomer block. |
| Event card | White; 16:10 image slot (sand placeholder until a real image exists), night-blue date badge overlapping the image, title, time and place, short text, "En savoir plus". On the events page (computer) the image sits on the left (400 px) with the badge in its top-left corner. | Home page, events page. |
| Weekly meeting card | Sky, 32 px padding (16 px phone); night-blue square with the short day and the time, then the meeting name (h3), "Jour à HHhMM" in bold and the address as a link. | "Chaque semaine". |
| Month heading | Muted h3 in the heading font with a 1 px line under it; events of that month follow. | Events list. |
| Practical info panel | Sand, 6 px corners; a definition list (Date, Heure, Lieu), each with a primary icon, muted label and bold value; "Voir le plan" under the place. On a computer it sits in a 360 px column beside the text; on a phone right under the image. | Single event; on the single sermon it lists Date, Orateur, Passage biblique and Série with "Toute la série". |
| Share buttons | Secondary buttons, full width of the panel: "Partager sur Facebook", "Partager sur WhatsApp". | Single event, single sermon. |
| Video slot | 16:9, 6 px corners, night blue with a round white play button; holds the YouTube player. | Latest sermon, single sermon. |
| Sermon card | White, 6 px corners, the whole card is the link; 16:9 thumbnail (sky placeholder with a night-blue play button), series in small primary capitals, title (h3), "date · speaker" in muted text. Three per row on a computer, one per row on a phone. | Sermons list, "Dans la même série". |
| Filter menu | Native `<select>` with a visible bold label above, 48 px high, 1 px grey outline, chevron on the right; 280 px wide on a computer, full width on a phone. The result count sits beside or under the menus. | Sermons list (Série, Orateur). |
| Pagination | 48 px squares, current page in night blue, then "Suivante". On a phone: "Page 1 sur N" and a secondary "Plus anciennes" button. | Sermons list. |
| Tile | Sand, 64 px high (52 px phone), bold label, blue arrow; the whole tile is the link. | Departments. |
| Info card | Sand, 24 px padding, muted label above a bold value. | "Où sommes-nous ?". |
| Page banner | The home hero's blurred photo and overlay, 64 px vertical padding (48 px phone); breadcrumb in white, then the page title. | Top of every inner page. |
| Breadcrumb | 16 px white text, `›` separators, current page in bold; a menu heading without its own page ("L'église") is plain text, not a link. | Page banner. |
| Accordion | Native `<details>`/`<summary>`: number in primary, short title in the heading font, chevron; rows split by 1 px `color.border` lines, 64 px high (56 px phone). The first row starts open. | "Nos valeurs". |
| Timeline | 2 px primary line, white dots with a primary ring, year as an h3 in primary (left column on computer, above the text on phone); the last dot is filled with the accent. | "Notre histoire". |
| Placeholder card | White with a 1 px `color.border` outline, name as h3, one muted bracketed line per missing fact. No link until the content exists. | Departments, until their leaders provide the content. |
| Partner link card | White, 24 px padding, name in the heading font, domain in muted text, external-link icon. | "Nos partenaires". |
| Table of contents | Legal and other long text pages: on a computer a sand panel (6 px corners, 24 px padding) in a 300 px column, sticky at the top while reading, small uppercase "Sommaire" label and one link per numbered section (36 px rows, the one place below 44 px, mouse use only); text column max 760 px. On a phone a closed sand `details` "Sommaire" (52 px) above the text, 44 px links. | Protection des données, Conditions générales, Mentions légales. |
| Data table | Inside a bordered card (6 px corners): sand header with the h3 and a small white category tag, then a full-width table with a grey header row and hairline rows (8 × 12 px cells, 16 px text, codes in monospace). | Cookie list ("Cookies placés"). |
| To-complete marker | Text the church must supply is written in square brackets on a sun background: `[à compléter]`. Never fill it with invented content. | Mentions légales, cookie list notice. |
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
| Évènements (list) | Validated 2026-10-27 | [maquettes/events/](maquettes/events/): `events-desktop.html`, `events-mobile.html` and their `.png` captures |
| Évènements › one event | Validated 2026-10-27 | [maquettes/events/](maquettes/events/): `event-desktop.html`, `event-mobile.html` and their `.png` captures |
| Prédications (list) | Validated 2026-10-27 | [maquettes/sermons/](maquettes/sermons/): `sermons-desktop.html`, `sermons-mobile.html` and their `.png` captures |
| Nous contacter | Validated 2026-10-27 | [maquettes/contact/](maquettes/contact/): `contact-desktop.html`, `contact-mobile.html` and their `.png` captures |
| Faire un don | Validated 2026-10-27 | [maquettes/donate/](maquettes/donate/): `donate-desktop.html`, `donate-mobile.html` and their `.png` captures |
| Demande d'entretien, Demande de prière, Servir à l'église | Validated 2026-10-27 | [maquettes/forms/](maquettes/forms/): `interview-*.html`, `prayer-*.html`, `serve-*.html` (desktop and mobile) and their `.png` captures |
| Protection des données, Conditions générales, Mentions légales | Validated 2026-10-27 | [maquettes/legal/](maquettes/legal/): `privacy-*.html`, `terms-*.html`, `legal-notice-*.html` (desktop and mobile) and their `.png` captures |
| Prédications › one sermon | Validated 2026-10-27 | [maquettes/sermons/](maquettes/sermons/): `sermon-desktop.html`, `sermon-mobile.html` and their `.png` captures |

The HTML files open in any browser without the canvas, and link to each other; each folder has its own `images/`.

## Target screens

The validated pages are also built as clickable, scrollable prototypes (page "Validés" of the canvas) on the most common screen sizes. Test the site on these before release:

| Device | Sizes (CSS px) | Header |
|---|---|---|
| Computer | 1920 × 1080, 1536 × 864, 1366 × 768 | Full menu, "L'église" opens a drop-down |
| Tablet | 1280 × 800 (landscape), 820 × 1180, 768 × 1024 | Full menu at 1280; "Menu" button and full-screen menu below |
| Phone | 412 × 915, 390 × 844, 360 × 800 | "Menu" button and full-screen menu |

On the home page the department tiles and "Découvrir les départements" lead to "L'équipe", since the departments have no page of their own yet.

## Site structure

Changes to the live site's structure, decided by the owner:

- **"L'église" menu (2026-10-26).** The five pages Notre histoire, Notre vision, Nos valeurs, Les départements and Le couple pastoral become three:
  - **Qui sommes-nous ?** — vision, then the nine values as an accordion. The short value titles were written for the accordion and approved; the full texts are the live site's.
  - **L'équipe** — the pastor couple's welcome, then one placeholder card per department.
  - **Notre histoire** — the timeline (dates taken only from the live text), the partners and the mission statement.
- **Departments.** No department page and no department text until the owner has gathered the content from each department's leader. The nine names stay: Génération Kids, Punch Group, ConneXion, Ainé'rgie, Femmes, LSV – Louange Sono Vidéos, Mission, Une prière pour toi, Entraide.
- **Events page (2026-10-27).** The live page is empty. It becomes: "Chaque semaine" (the regular meetings), then "Les prochains évènements", listed by date, nearest first, grouped by month. Each event gets its own page (image, date, time, place, text) with the Facebook and WhatsApp share buttons the live single-event template already has. Event content is placeholders until the church provides it. Other weekly meetings (ConneXion on Saturdays, Entraide on Wednesdays) are added only once the church confirms they still run.
- **Sermons page (2026-10-27).** The live page is a paged list of YouTube videos. It becomes: the latest sermon large (video, title, date, speaker, Bible passage, series, short summary), then "Toutes les prédications" as cards with two filters, series and speaker, and page numbers, then a link to the church's YouTube channel. Each sermon page has the video, a summary, a panel with date, speaker, Bible passage and series, the share buttons, and three sermons from the same series. Titles, dates and speakers stay placeholders in the mockups. The passage and summary fields are dropped if the church does not plan to fill them; the sentence "Abonnez-vous à la chaîne de l'église pour ne manquer aucune prédication." is interface copy written for the mockup.
- **Contact page (2026-10-27).** Same content as the live page: address, meeting times, e-mail, phone, and the form (name, e-mail, message, privacy sentence). It becomes "Nos coordonnées" with the map beside the form "Écrivez-nous" (labels always visible above the fields), then "Une autre demande ?" with contact cards to Servir à l'église, Demande de prière and Demande d'entretien. The headings, "Tous les champs sont obligatoires." and "Envoyer le message" were written for the mockup.
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
