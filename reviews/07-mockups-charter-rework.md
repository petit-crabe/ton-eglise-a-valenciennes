# Mockups review after the charter rework

Date: 2026-10-29 · Target: the 32 reworked mockups (16 pages × computer and phone) and the 9 clickable prototypes, before they were saved to [design/maquettes/](../design/maquettes/).

This report is meant to be picked up in a new working session. Each axis below stands on its own: problem, evidence, proposed change, and when it is done. The owner decides which ones are applied and in what order.

## Where things are

- Rules: [design/DESIGN.md](../design/DESIGN.md) and [design/tokens.json](../design/tokens.json). The rework decisions are in its "Charter rework (2026-10-29)" section.
- Exported mockups: [design/maquettes/](../design/maquettes/), one folder per menu section, `*-desktop.html` (1440 px) and `*-mobile.html` (390 px) with full-page `.png` captures.
- Working canvas: https://claude.ai/artifact/UbLoYdhe5z2A3no2cDeo5u, page "Validés".
  - Page boards: `<Page>-charte.dc.html` and `<Page>-charte-telephone.dc.html`. Pages: Accueil, Qui-sommes-nous, Equipe, Notre-histoire, Evenements, Evenement, Predications, Predication, Contact, Don, Entretien, Priere, Servir, Donnees, Conditions, Mentions.
  - Clickable prototypes: `Ecran-ordinateur-1920/1536/1366`, `Ecran-tablette-1280/820/768`, `Ecran-telephone-412/390/360`.
  - The owner edits the canvas by hand: always re-read a board before publishing a change to it.
- Export tools: [design/tools/](../design/tools/). `export_maquettes.py` turns the canvas boards into the files of `design/maquettes/`; `shoot_maquettes.mjs` retakes the captures. Any change made on the canvas reaches the repository through these two.

## How it was done

The review used two angles: an adversarial reading (what is missing or wrong) and a hunt for unusual situations (what happens when the content or the moment is not the expected one). Contrast, spacing, type sizes, heading order, section backgrounds, empty links and placeholders were checked by script on every page.

Already sound on every page:

- Text contrast passes everywhere: muted text at least 5.5:1 on every surface, night blue on coral 5.5:1, white on the blue buttons 5.9:1.
- One `h1` per page, no skipped heading level, no duplicate `id`, every image has an `alt`.
- Section backgrounds follow the rules: no sand section, sky and mint never adjacent, two neighbours never share a background.
- No link points to a board from before the rework.
- No invented copy beyond the interface sentences already accepted.

## Summary

| # | Size | Axis |
|---|---|---|
| M1 | Major | Make the form fields visible to everyone and the date field really required |
| M2 | Major | Define how pages fold between computer and phone, and draw a real tablet layout |
| M3 | Major | Keep one source for the header and the footer |
| m1 | Minor | Fill the links that lead nowhere |
| m2 | Minor | Finish aligning the pages on the charter |
| m3 | Minor | Show every page state in the prototypes and write the edge cases down |

## M1 — Form fields visible to everyone (major)

**Problem.** The field outline `#8a94a3` reaches 2.78:1 on the sand form panel and 3.07:1 on white. WCAG 1.4.11 asks 3:1 for the outline that shows where a field is. On the four form pages (Nous contacter, Demande d'entretien, Demande de prière, Servir à l'église) a person with low vision may not see where to type.

The "Jour de rendez-vous" field on Demande d'entretien is `readonly required`. Browsers skip read-only fields when they check a form, so the request can be sent with no date, and the date cannot be typed with the keyboard.

**Proposed change.**

- Darken the outline to at least 3:1 on sand (for example `#6b7686`, to measure), add it to `tokens.json` as a border token for fields, and use it on every field and filter menu.
- Make the date a field the browser checks and that accepts the keyboard (a native date field, or a text field checked on submit), keeping the calendar button.

**Done when** every field outline measures 3:1 or more on its background, in the boards, the exports and the prototypes, and the interview form refuses to send without a date.

## M2 — How pages fold, and a tablet layout (major)

**Problem.** The computer boards use fixed grids (7fr/5fr, three and four columns, the 400 px event image, the 360 px info panel, the four-column footer) with no rule for narrower windows. DESIGN.md only says "stack below about 980 px". Between 980 px and the phone, the developer would have to guess.

The portrait tablet prototypes (820 and 768 px) show the phone pages stretched: cards and images about 790 px wide, a two-column footer lost in a wide screen. They look empty.

**Proposed change.**

- Write the fold points in DESIGN.md, per component: when three cards become two then one, when two columns stack, when the footer goes from four columns to two.
- Draw a tablet layout for 768–979 px: content limited in width, cards two per row, the footer on two columns, and use it in `Ecran-tablette-820` and `Ecran-tablette-768`.
- Align the header of the 820 and 768 prototypes on the content (24 px header padding against 16 px content today).

**Done when** DESIGN.md states the fold points and the two portrait tablet prototypes use the tablet layout.

**Open question for the owner:** one tablet layout for both portrait sizes, or the phone layout kept at 768?

## M3 — One source for the header and the footer (major)

**Problem.** The header and footer are copied into 32 boards and 9 prototypes, 41 copies in all. The scripts that produced the reworked boards were one-shot transforms of the earlier boards and were not kept. The next change to the menu or the footer has to be made by hand 41 times, with the risk of pages drifting apart. Colours are also written as raw values in every page, not as tokens.

**Proposed change.** Pick one of:

1. a small generator kept in `design/tools/` that builds every board and prototype from one header, one footer and the page bodies, reading colours from `tokens.json`;
2. or keep the canvas as the source and accept hand edits, but add a check script that compares the header and footer of every board and flags differences.

The choice depends on how long the mockups remain the reference before the real site is built.

**Done when** a change to the footer is made in one place, or is checked automatically on every page.

**Open question for the owner:** how long will the mockups remain the reference before the real site is built?

## m1 — Links that lead nowhere (minor)

**Problem.** Several links are `href="#"`:

- everywhere: Facebook, Instagram, YouTube in the footer;
- computer footer: "Assemblées de Dieu" and "CNEF", although their addresses are already used on Notre histoire;
- Faire un don: "Télécharger le RIB (PDF)";
- one event: "Voir le plan" and the two share buttons; one sermon: the share buttons;
- Protection des données: "Gérer mes choix de cookies".

**Proposed change.** Fill the known addresses (Assemblées de Dieu, CNEF, the RIB file and the social accounts of the live site, Google Maps for the plan). Mark the others visibly as `[à compléter]`, so they fall under the no-placeholder-in-production rule. Share buttons and the cookie button are behaviours of the real site: say so in DESIGN.md rather than invent addresses.

**Done when** no `href="#"` is left without an address or a visible marker.

## m2 — Finish aligning on the charter (minor)

- **Type size.** The "Marketing" tags of the cookie tables (Protection des données) are 14 px; the charter says nothing below 15 px.
- **Spacing.** A few values are off the 8/16/24/32/48/64/96 scale: 26, 34, 44 and 56 px in the timeline (Notre histoire), the calendar (Demande d'entretien) and the pagination (Prédications). Align them, or write the exception down.
- **"Dans la rubrique".** 64 px top and bottom padding against 96 px for every other section on a computer. Align it, or write the exception down.
- **No-event sentence.** The charter says the home page and the events page use the same sentence. Today the home page adds "… Nous nous retrouvons chaque semaine :" and the events page does not. Use one sentence with an optional end.

**Done when** the script checks find no size under 15 px and no spacing off the scale except the documented ones.

## m3 — Page states and edge cases (minor)

**Problem.** The prototypes always show three events and never the live stream, so the Sunday-morning page and the week with no event cannot be shown to the church. The boards `Accueil-charte*.dc.html` already have both states as tweaks.

Some situations are not described:

- the live stream stops before 12h00, or starts late;
- only one or two events are coming up (wider cards, or completed by the weekly meetings?);
- in the prototypes, the table of contents anchors of the three legal pages (`#s1`…) exist several times in the same screen; this works only because one page is shown at a time.

**Proposed change.** Add two switches to the prototypes ("En direct", "Aucun évènement") wired to the existing `live`, `notLive`, `hasEvents`, `noEvents` values. Write the rules for the stream and for one or two events in DESIGN.md, "Site structure", home page. Prefix the legal anchors by page.

**Done when** both states can be shown in every prototype and the two cases are written in DESIGN.md.

**Open questions for the owner:** with one or two events, should the cards grow or should the weekly meetings fill the row? When the stream ends early, should the block switch back to the latest sermon straight away?

## Placeholders to collect before production

Under the no-placeholder-in-production rule, these must be filled before any release to `main`:

- L'équipe: the nine department cards (presentation, days and times, leader and contact).
- Accueil, Évènements, one event: event titles, dates, times, places, texts and images.
- Accueil, Prédications, one sermon: titles, dates, speakers, passages, series and summaries (they come from YouTube on the real site).
- Mentions légales: legal form, RNA or SIREN number, publication director, host.
- Protection des données: the cookie list of the new site.
