---
id: SPEC-site-improvement
companions:
  - finding-coverage.md
  - ../architecture-new-site/architecture-new-site.md
  - ../../../design/DESIGN.md
  - ../../../reviews/README.md
  - ../../../reviews/01-security.md
  - ../../../reviews/02-ux.md
  - ../../../reviews/03-ui.md
  - ../../../reviews/04-content.md
  - ../../../reviews/05-accessibility.md
  - ../../../reviews/06-code.md
  - ../../../AGENTS.md
sources: []
---

> **Canonical contract.** This SPEC and the files in `companions:` are the complete, preservation-validated contract for what to build, test, and validate. Source documents listed in frontmatter are for traceability — consult them only if you need narrative rationale or prose color this contract intentionally omits.

# New site — tonegliseavalenciennes.fr

## Why

A pain to solve and a vision to realise. The review of 2026-10-12 found the church's WordPress site exposed (PHP 7.4, years-old plugins, about 80 password attempts a day), heavy (up to 6.6 MB for one page on a phone), hard to read on a phone, and contradicting itself on practical facts. Fixing it in place proved impossible: the 2019 theme, Elementor 3.1.1 and PHP 7.4 cannot be updated piece by piece. On 2026-10-24 the owner decided to leave WordPress: a new site replaces it, hosted on the owner's Cloudflare account, keeping the pages, menus, texts and photographs of today with a modernised look. Members come first (events, the Sunday live stream, sermons), then people passing through Valenciennes looking for a church; the owner, sole editor for now, publishes every change.

Finding ids carry their report number: `01-S4` is S4 of `reviews/01-security.md`. `finding-coverage.md` maps every finding. `AD-n` are the rules of `architecture-new-site.md`.

## Capabilities

CAP-1, CAP-2, CAP-4 and CAP-14 are retired: they kept the WordPress site maintained, and leaving WordPress removes their object.

- **CAP-3 — Closed server exposure**
  - **intent:** An anonymous visitor finds no admin or login page, no browsable folder, no leftover file and no software version.
  - **success:** On production, every response carries the security headers of 01-S7; no login, admin or `xmlrpc.php` path answers anything but 404 or a redirect; no response names a software version; the sitemap lists only public pages; preprod and any `workers.dev` address are `noindex` and disallow all robots.
- **CAP-5 — Honest handling of personal data**
  - **intent:** A visitor knows who publishes the site and what happens to what they send, and nothing reaches a third party before they click.
  - **success:** A legal notice and a privacy page are published and linked from every footer and form; no font, image, map or script is requested from another domain before a click, except Turnstile on form pages and the Cloudflare Web Analytics beacon; the Content-Security-Policy allows no other source; every video shows a placeholder naming YouTube's cookies and loads only on click; no cookie banner, and the privacy page lists only services in use.
- **CAP-6 — Lighter pages**
  - **intent:** Pages download only what they display.
  - **success:** Measured on a throttled connection, the home page and each page of the "L'église" menu weigh less than the 2026-10-12 recordings of their live counterparts; no image is served larger than its slot; no unused font or stylesheet loads.
- **CAP-7 — Readable and usable on a phone**
  - **intent:** A phone visitor reads every page and reaches every control without zooming, and can zoom when they want.
  - **success:** On the phone sizes of DESIGN.md "Target screens" (360 to 412 px): body text at least 16 px; every tappable item at least 44 px; pinch-zoom works; the "Menu" button is identical on every page.
- **CAP-8 — Legible colours**
  - **intent:** All text can be read against its background, in every state.
  - **success:** Every text and background pair reaches 4.5:1 (3:1 for large text); text over a photograph has a backing; hover and focus raise contrast; the accent gold never carries text.
- **CAP-9 — One visual language on every page**
  - **intent:** Every page follows the charter of `design/DESIGN.md` and the validated mockups.
  - **success:** Every colour, type size, spacing and radius in the site's styles comes from `design/tokens.json`; each page matches its validated mockup in `design/maquettes/`, except where an AD overrides it (sermon pages, cookie-choice button).
- **CAP-10 — One set of true practical facts**
  - **intent:** A visitor finds the same, correct facts wherever they look, and acts on them in one tap.
  - **success:** Service time, prayer meeting, address, phone, e-mail, church name and pastor couple are stored once and every page, the footer, structured data and calendar files read them from there; the values are those of DESIGN.md "Confirmed facts" and the pastor couple Nicolas and Mélanie Tessier; phone, e-mail and address open the phone, mail and maps apps.
- **CAP-11 — No dead end, leftover or placeholder**
  - **intent:** Every link and page a visitor can reach leads to real, French, finished content in one voice.
  - **success:** No link target is `#` or a missing page, and a menu link to a missing or redirected page fails the build; header and footer are built only from the menus and the facts; no English interface string; public pages say "tu" (legal pages excepted); before each release to `main`, no page contains a square-bracket placeholder or an empty text; the logo links to the home page.
- **CAP-12 — Sermons watchable**
  - **intent:** A member watches the Sunday service live or the latest sermon from the site, and finds the rest on YouTube.
  - **success:** The home and sermons pages show the live broadcast while the channel streams, otherwise the latest video, each with a link to the channel; when YouTube fails, only the channel link shows; no YouTube request happens before the visitor clicks; every old sermon URL answers a 301 to its own video, or to the sermons page when the video is gone.
- **CAP-13 — Keyboard and screen-reader basics**
  - **intent:** A visitor using a keyboard or a screen reader reaches the content and uses the menu and forms.
  - **success:** Every page meets WCAG 2.1 AA: skip link, main landmark, one `h1`, headings in order, every link, button and field named, focus always visible, no motion over five seconds without pause, reduced motion respected.
- **CAP-15 — The new site replaces WordPress**
  - **intent:** Every page of the current structure is served by the new site under one address, and no old link dies.
  - **success:** Each page listed in DESIGN.md "Mockups" is live on `tonegliseavalenciennes.fr` with the live site's texts and photographs, imported once from production; every URL of the old site is listed once with its fate (kept, 301, or 410) and answers accordingly; `www.tonegliseavalenciennes.fr`, `add-valenciennes.fr` and `www.add-valenciennes.fr` answer a 301 to the same path on the canonical address; WordPress no longer serves the domain.
- **CAP-16 — Forms reach the church and keep nothing**
  - **intent:** A visitor sends a message, a prayer request, an interview request or an offer to serve, and the church receives it by e-mail.
  - **success:** Each of the four forms delivers a submission to the church's OVH mailbox for it; spam protection rejects a filled honeypot or a failed Turnstile check; nothing about the submission is stored by the site, logs included; no copy is ever sent to the visitor; a form sent from preprod, which uses Turnstile test keys, never reaches a church mailbox.
- **CAP-17 — Events relaunched**
  - **intent:** The owner announces an event and members see it until it is over.
  - **success:** Adding one event file and merging publishes it; lists show upcoming events only, nearest first, grouped by month, and without JavaScript hide only events ended before the build; times are typed as local Paris time and show, and land in calendars, at that time in summer and winter; each event has a page with share links and an "Ajouter à mon agenda" file; with no upcoming event, the weekly meetings show instead of an empty block.
- **CAP-18 — Church e-mail keeps flowing**
  - **intent:** The move of the site never interrupts the church's e-mail.
  - **success:** Before and after the DNS move, a message sent from outside reaches each OVH mailbox; every OVH mail record (MX, SPF, DKIM, DMARC, autodiscover) exists in the new DNS identically, checked against the saved OVH zone export, before the nameserver change; Email Routing is never enabled on either zone.
- **CAP-19 — One path to publish**
  - **intent:** Production changes only when the owner merges to `main`, and every change can be seen on preprod first.
  - **success:** Merging to `main` publishes production with no manual upload; branch protection refuses any change to `develop`, `preprod` or `main` except through a PR; no Cloudflare API token is kept on an agent's machine; `preprod` has its own link-only preview; every setting that exists only in the Cloudflare dashboard is recorded by name in the repository.

## Constraints

- Hosting is the owner's Cloudflare account. No new paid service beyond the existing Workers Paid plan, the OVH domains and the OVH e-mail.
- Domains stay registered at OVH and the OVH e-mail stays as it is; the OVH web hosting is not cancelled while the mailboxes depend on it.
- No CMS now: the owner is the sole editor, through agent sessions, and content lives as typed files in the repository so that a CMS can be added later without rewriting pages.
- The page and menu structure is that of the validated mockups for now, and must stay changeable later.
- Modernise, do not redesign: keep the logo, the real photographs, the pastoral welcome, the history and the live texts; no invented content.
- No page carries a photograph showing children, for now.
- The prayer request and interview request forms stay.
- Agents never merge to `develop`, `preprod` or `main` and never deploy. Until the switch, the owner uploads `main` to OVH by hand; after it, merging to `main` publishes.
- Every change, content included, follows the git flow: task branch, PR to `develop`, then `preprod`, then `main`.
- No value from the WordPress `wp-config.php` and no secret in a tracked file.
- Repository files are in English; site content is in French and addresses the visitor as "tu".

## Non-goals

- Sermon pages or a sermon library on the site; the YouTube channel holds past sermons.
- A site search, a newcomer page, online giving.
- A CMS before the owner knows who will edit the site.
- Department pages before their content is gathered from each department.
- An archive of past events.
- A cookie banner or consent manager.
- A numeric weight or speed target.
- A full accessibility conformance statement.

## Success signal

- `tonegliseavalenciennes.fr` is served by the new site from Cloudflare; the checks of the 2026-10-12 review run on it find no Critical or High finding open; a form sent from the site arrives in the church's mailbox; an outside e-mail still reaches every OVH mailbox; on the following Sunday the home page shows the live service without anyone touching the site.

## Assumptions

- Legal pages are excepted from the "tu" rule.
- An automated test suite stays a non-goal for the new site, as it was for WordPress (06-C8).
- The old-sermon redirect list is built from production, not from the March 2026 backup.
- The status-less MX Plan lines at OVH are the e-mail included with the web hosting `az10525-ovh`.

## Open Questions

- Which OVH mailbox receives each of the four forms (CAP-16)?
- Who reads prayer and interview requests, and how long do they stay in the mailbox (CAP-5, CAP-16)? Passed to the church leaders; the prayer-request form does not go live before the answer.
- Legal notice facts: legal form, RNA or SIREN number, publication director. Who writes and approves the legal pages (CAP-5)?
- "Conditions générales" is a shop template: keep, rewrite or drop it?
- Contact e-mail: `secretariat@add-valenciennes.fr` replaces the Gmail address on the live site; is that Gmail inbox still someone's working mailbox? Which church name is shown (CAP-10)?
- Do ConneXion (Saturdays) and Entraide (Wednesdays) still run, to be shown as weekly meetings (CAP-17)?
- Department texts, to be gathered from each department leader.
- Is the OVH payment method valid for the renewal of `tonegliseavalenciennes.fr` on 17/12/2026 (CAP-18)?
- Technical checks deferred to building: `send_email` in Cloudflare previews, the live broadcast in the uploads playlist, an existing `_dmarc` record to merge, no cookie set by Web Analytics, `/wp-content/uploads/` files linked from outside the site (answered by the URL inventory, CAP-15). Listed in `architecture-new-site.md`.
