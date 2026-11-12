# Accessibility review

Date: 2026-10-12 · Target: https://tonegliseavalenciennes.fr/ (production) · Reference: WCAG 2.1 level AA (the basis of the French RGAA).

## Method and limits

- Automated reading of the HTML of 35 pages (headings, landmarks, images, links, form fields, language, viewport) and manual reading of the home, contact and sermon page code.
- Visual check on screenshots at 1440 px and 390 px.
- **Not done**: keyboard walkthrough, screen reader test, measured colour contrast, zoom to 200 %, reduced-motion behaviour, form error messages. The items marked "to verify" need those tests on the local copy. This is a first pass, not a conformance audit.

A church site has a public that makes this matter more than usual: older members, people with low vision, and people arriving in a moment of distress who need the prayer or interview form to simply work.

## Findings

| # | Priority | WCAG | Finding |
|---|----------|------|---------|
| A1 | High | 1.4.4, 1.4.10 | Zoom is blocked on phones |
| A2 | High | 1.3.1, 3.3.2, 4.1.2 | Form fields have no labels |
| A3 | High | 2.4.4, 4.1.2 | Links and buttons with no name, including the mobile menu button |
| A4 | High | 2.4.1, 1.3.1 | No skip link and no main landmark |
| A5 | High | 1.4.3 | Low-contrast text (to measure) |
| A6 | Medium | 1.3.1, 2.4.6 | Heading structure is broken on every page |
| A7 | Medium | 2.2.2 | The home headline animates without a pause control |
| A8 | Medium | 1.2.2, 1.2.3 | Sermon videos: blocked player with no alternative; captions unknown |
| A9 | Medium | 1.1.1 | Image alternatives are present but often wrong |
| A10 | Medium | 2.1.1, 2.4.7 | Keyboard use of menu, accordion and banner (to verify) |
| A11 | Low | 3.1.2, 3.2.5 | English fragments; links opening new tabs unannounced |
| A12 | Low | — | No accessibility statement |

### A1 — Zoom blocked

Every page has `<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">`. `maximum-scale=1` asks mobile browsers to forbid pinch-zoom. Some browsers ignore it, others obey. One-line fix in the theme; in the redesign, never set it.

### A2 — Unlabelled form fields

All Contact Form 7 forms (contact, prayer request, interview request, volunteering) use `placeholder` as the only label: no `<label>`, no `aria-label`. Seventeen fields across four forms. A screen reader may announce "edit text" with nothing else; the hint vanishes once typing starts; placeholder grey is low contrast. The two radio buttons on the volunteering form ("Je suis membre" / "Je viens régulièrement") have no group label. The newsletter form (Mailchimp) is in the same state for its automated-check purposes and has one label in English.

Required fields carry `aria-required` but nothing visible. Error and confirmation messages were not triggered (to verify, on the local copy only and without submitting to real services).

The blog search field has a visually hidden "Rechercher :" text but it is not tied to the input.

### A3 — Nameless links and buttons

Ten to twenty-four per page. On every page:

- The logo link: `href="#"`, image alt "Ton église à Valenciennes". It has a name but goes nowhere.
- The mobile menu button: `<a href="#">` containing only an icon span. No text, no `aria-label`, not a `<button>`, no `aria-expanded`. A screen reader user on a phone cannot identify the way into the menu.
- The mobile menu close control: `<a class="menu_mobile_close">` with no `href` and no text, so it is neither named nor focusable.
- Header social links (Facebook, YouTube): icon only, no name.
- Footer social links: image alts are file names ("Facebook-logo", "Instagram_Glyph_Gradient", "Youtube-logo").
- "L'église" parent menu item: `href="#"`.

On sermon lists, each card has three links to the same post, one of them empty with `aria-hidden="true"` yet still focusable: keyboard users tab three times per card, once onto something hidden.

Repeated "Découvrir" (nine times on the departments page) and "En savoir plus" (ten times on archives) are not distinguishable out of context.

### A4 — Skip link and landmarks

No "skip to content" link. No `<main>` element or `role="main"` on any page. `<header>`, `<nav>`, `<footer>` and `<aside>` exist. Keyboard users must tab through the whole menu on every page; screen reader users cannot jump to the content.

### A5 — Contrast (to measure)

Suspect combinations seen on screenshots:

- Yellow-orange links on white: active menu item on inner pages, footer credits.
- White thin-weight headline on a light, busy photograph (home hero).
- White menu text on the same photograph.
- Mid-grey body text on white.
- White text on the sky-blue panels and buttons ("Où sommes-nous ?", "Voir tous les évènements"): light blue with white often fails 4.5:1 for small text.
- Placeholder text in form fields, which is also the only label (A2).

Measure with a contrast tool on the local copy; fix by token in the new design system rather than page by page.

### A6 — Headings

- Home: `h1` is "Une église pour moi nous toi" (all three rotating words read in a row), then `h2`, then sermon titles at `h4`, an `h3` after them, and footer column titles at `h6`.
- Inner pages jump from `h1` straight to `h6` (footer), or `h1` → `h4`/`h5` (contact, Entraide, Punch Group).
- Many inner pages print the page title two or three times in the DOM.
- The 404 page has three `h1` ("URL not found", "404", "Mince...").
- Entraide's section titles are typed in capitals rather than styled; screen readers may spell some out.

### A7 — Motion

The home headline rotates "moi / nous / toi" indefinitely with no way to pause, and no check of the visitor's reduced-motion preference was found (to verify). The words overlap mid-transition. Content that moves for more than five seconds needs a pause control.

### A8 — Video

- With cookies refused, a sermon page shows an `<iframe src="about:blank">` with a placeholder image. No visible text says how to enable it and there is no plain link to the video on YouTube. Keyboard and screen reader access to Complianz's placeholder was not tested.
- The iframe does have a `title` with the sermon name: good.
- Whether the YouTube videos have captions was not checked. Auto-generated captions are a start; a text summary per sermon would help deaf visitors and everyone else.

### A9 — Images

Every `<img>` has an `alt` attribute (none missing across 35 pages). Quality is the issue:

- Social icons: file names as alt.
- Department illustrations and content photos mostly have empty alt, including some that carry information.
- Sermon thumbnails repeat the title as alt next to the same title as text: redundant; empty alt would be better there.
- The donation page's key action is "Téléchargez le RIB en cliquant **ici**": the link text is "ici", and the target is a PDF with no mention of format or size. The PDF's own accessibility was not checked.

### A10 — Keyboard (to verify)

- Desktop sub-menu ("L'église") opens with a hover script (Superfish); keyboard opening and `aria-expanded` state need testing.
- Donation accordion uses `role="tab"` / `tabpanel` on `div`s; arrow-key behaviour and focus need testing.
- Cookie banner is a `role="dialog"`; check that focus moves into it and that it does not trap or get skipped.
- Visible focus indicator: not assessed from static captures.

### A11 — Language and new tabs

`lang="fr-FR"` is set on every page: good. English fragments are not marked and should simply be translated ("All Posts", "URL not found", "Next", "Email address:", form `aria-label="Contact form"`). Social links and the privacy link inside forms open a new tab without warning; in a form this can lose what the person has typed on some phones.

### A12 — Statement

No accessibility statement. Private associations are not bound by the public-sector obligation, but a short honest page ("what works, what does not yet, who to contact") costs little and fits the church's message.

## What is already right

- Page language declared.
- Every image has an alt attribute.
- Video iframes have titles.
- Real `<nav>`, `<header>`, `<footer>` elements.
- No horizontal scrolling at 390 px.
- Cookie banner buttons are real `<button>` elements with text.

## For the redesign

Most of A2–A7 come from the theme and page builder, not from the content. They are expensive to fix in place and nearly free to get right in a new build. Put them in the definition of done of the new templates: labelled fields, one `h1`, a `main` landmark and skip link, named controls, zoom allowed, contrast-checked tokens, motion that respects the visitor's setting.
