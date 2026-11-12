---
reviews: ../architecture-new-site.md
companion-read: ../.memlog.md
lens: adversarial (pairs of units that each obey every AD yet build incompatibly)
date: 2026-10-27
also-read: design/DESIGN.md, design/tokens.json, design/maquettes/ (validated mockups the spine cites in AD-12)
---

# Adversarial review: architecture spine, new church website

## Verdict

**Not ready to bind builders.** The ADs are sound in intent, but at least 14 pairs of units can each follow every rule exactly and still produce parts that do not fit together. Four of them are serious. (1) The validated sermon mockups contradict AD-6. (2) Host redirects and per-environment headers cannot live where the Conventions table puts them. (3) Consent behaviour is undefined, and the validated privacy page adds a "manage my cookie choices" button. (4) Several entities have two homes: tokens, the weekly schedule and form recipients.

## Method

A "unit" is one epic one level below the spine: design system, header/footer and menus, home page, sermon block plus `/api/sermon`, thumbnail proxy, events, forms, legal pages, redirects and domains, headers, caching and CSP, environments. For each pair I asked whether two teams could take opposite decisions that each respect every AD and Convention as written. I also checked the spine against `design/DESIGN.md` and `design/maquettes/`, because AD-12 binds builders to those mockups. The spine was not edited.

Severity: **Critical** means a unit cannot be built without breaking an AD, or the AD contradicts another binding source. **High** means two compliant units will clash at integration or in production. **Medium** means drift or rework is likely. **Low** is hygiene.

---

## H1. Sermon block vs the validated sermon mockups (two incompatible sermon models). Critical

- **Unit A (sermon block, AD-6):** one component, fed by `/api/sermon`, showing the live or latest video plus a link to the channel. There are no sermon pages.
- **Unit B (design system and sermons page, AD-12 "from Sally's validated charter `design/maquettes/`"):** the validated mockups `sermons/sermons-*.html` and `sermons/sermon-*.html`, plus DESIGN.md lines 82-84, 127 and 153, specify a list called "Toutes les prédications" with **series and speaker filters and pagination**, a **single sermon page** (passage, series, "Toute la série", share buttons, "Dans la même série"), and a sermon card. A team that follows AD-12 builds these pages. A team that follows AD-6 forbids them.
- **Knock-on effects:** AD-9 sends each old sermon URL to YouTube, so a single sermon page would have no URL of its own. `/api/sermon` returns one video and has no field for speaker, series or passage, which the YouTube Data API does not provide anyway. The "latest sermon large" block in the mockup shows a speaker, a passage and a series that the API cannot supply.
- **Proposed rule (tighten AD-6):** *"The validated sermon list, single sermon page, sermon card filters and pagination in `design/maquettes/sermons/` are superseded by AD-6 and are not built. The only sermon UI is `LatestSermon`, whose fields are exactly those `/api/sermon` returns: `{ ok, kind: "live" | "latest", videoId, title, publishedAt, channelUrl }`. No speaker, series or passage is shown unless a content collection supplies it. Where AD-12 (mockups) and another AD disagree, the other AD wins, and the mockup gets a dated 'superseded' note."* Also add a precedence clause to AD-12 for this case.

## H2. Domain redirects and per-environment headers have no workable owner. High

- **Pair 1 (redirects epic vs domains epic):** the Conventions table says "redirects in `site/public/_redirects` only". AD-9 requires `www.*` and `add-valenciennes.fr` to answer 301 to the same path. Workers static-asset `_redirects` matches **paths, not hosts**, so a host-based 301 cannot be written there. One team writes it in the Worker, and that code then runs for every request (`run_worker_first`), which changes how `_redirects` and `_headers` apply. Another team adds a Cloudflare Redirect Rule in the dashboard, which keeps the "redirects in `_redirects` only" convention in spirit and breaks it in fact. Both readings are defensible, and they give different behaviour: a POST to `www…/api/forms/x` that is 301-redirected becomes a GET and the submission is lost.
- **Pair 2 (environments epic vs headers epic):** AD-10 requires `X-Robots-Tag: noindex` and a disallow-all `robots.txt` on every non-production host. The Conventions table puts all headers in `_headers`, but `_headers` and `robots.txt` are **the same static files on every deployment of one Worker**. The environments team generates them per branch at build time. The headers team writes one static `_headers` file. Either preprod gets indexed or production gets `noindex`.
- **Pair 3 (forms vs environments):** AD-5 tells production apart **at request time by Host**. AD-10, implemented in `_headers` or `robots.txt`, tells it apart **at build time by branch**. These are two different definitions of "production" that can disagree. Workers Builds previews share production secrets and bindings (memlog), and the preview alias host is not listed anywhere.
- **Pair 4 (`/api` vs headers):** `_headers` does not apply to responses produced by Worker code. Security headers, `noindex` and `Cache-Control` on `/api/*` are therefore unowned, even though the Conventions table says `_headers` owns them.
- **Proposed rule (new AD, "Edge ownership"):** *"(a) Host-level redirects (non-canonical host to canonical) are one Cloudflare Redirect Rule, recorded in `site/ops/cloudflare-settings.md`, and preserve method (308 for non-GET). Path redirects live only in `_redirects`. (b) The environment is decided once, at build, from one variable `SITE_ENV` (`production` only when the branch is `main`). A single build step generates `_headers` and `robots.txt` from it. (c) At runtime, `/api` code compares the request Host with `CANONICAL_HOST` (a `wrangler.jsonc` var) and treats every other host as non-production. (d) `/api` responses set their own security, `noindex` (off production) and cache headers through one shared helper; `_headers` covers static assets only."* Then fix the Headers row of the Conventions table to match.

## H3. Consent behaviour is ambiguous, and the validated privacy page contradicts AD-7. High

- **Unit A (legal pages):** the validated `legal/privacy-*.html` (DESIGN.md line 157) adds a **"Gérer mes choix de cookies" button** and a per-service cookie table carried over from the WordPress consent plugin, including "statistics" and "marketing" cookie sections. A team building the legal pages as validated ships a consent-manager entry point that has nothing behind it, or builds a consent manager.
- **Unit B (sermon block, AD-7):** one click on a placeholder loads YouTube. AD-7 does not say whether that click is **remembered**. Team B1 stores the choice in `localStorage` so the next video loads automatically. That is a device write, which then has to be declared and made revocable, and the "manage choices" button now has a job. Team B2 asks again on every click. Both obey AD-7, and the privacy text can only be true for one of them.
- **Unit C (content pages, event pages):** AD-7 binds "every component", but nothing stops a Markdown page or event body from carrying a raw `<iframe src="youtube.com/…">`. AD-3 schemas do not forbid HTML. The same applies to a Google Static Maps URL used for the map image (DESIGN.md line 102 says "a static image of the Google Maps view"). If it is hot-linked rather than stored as a file, it is a request to Google before any click.
- **Proposed rule (tighten AD-7):** *"Consent is per click and is never stored: no cookie, `localStorage` or other device storage is written by the site. There is no consent manager, so the privacy page states this and has no 'Gérer mes choix' control. Every third-party embed goes through one `ConsentEmbed` component, and content files may not contain `<iframe>`, `<script>` or third-party `src` URLs (enforced by the content schema or the Markdown pipeline at build). Maps and thumbnails are files in the repository or `/api` proxies, never hot-linked. The cookie table on the privacy page is generated from, or checked against, an allowlist kept in one place."*

## H4. One entity, two homes: weekly schedule, form recipients, design tokens, facts schema. High

- **Weekly schedule (facts vs events):** AD-4 puts service and prayer times in `facts.json`. The validated events page (DESIGN.md line 152) opens with **"Chaque semaine"** (regular meetings, including ConneXion and Entraide). The events team models them as recurring `events` entries. The facts team has them in `facts.json`. Neither breaks a rule, and the times now live in two places, which is exactly what AD-4 forbids.
- **Form recipients (forms vs facts vs secrets vs binding):** AD-5 says "the OVH mailbox that receives that form today". AD-14 makes *test* recipients secrets. AD-4 holds the public church e-mail. The Email Sending binding may also need an allowed-destinations list in `wrangler.jsonc`. That gives four plausible homes for "where prayer requests go". The contact e-mail is also being changed to `secretariat@add-valenciennes.fr`, which is on the non-canonical domain.
- **Design tokens:** AD-12 says tokens "live only in `site/src/styles/tokens.css`". DESIGN.md line 3 says **"Change a value in `tokens.json`, never only in a page"**, and the repository holds both `design/tokens.json` and `design/tokens.css`. The design-system team edits `tokens.json` and the component team edits `tokens.css`, so the two drift apart.
- **Facts schema:** AD-3 lists practical facts as a collection type with a schema in `content.config.ts`. AD-4 places it at `site/src/data/facts.json`, and the layer table lets `/api` read it. `/api` cannot use Astro collections at runtime, so it imports the raw JSON without validation. That makes two readers and one schema that only one of them enforces.
- **Proposed rules:** *(AD-4+) "Recurring weekly meetings are facts (`facts.json → schedule[]`). The `events` collection holds dated one-off events only. The events page reads its 'Chaque semaine' block from facts." (AD-5+) "Production recipients per form are one `wrangler.jsonc` var map `FORM_RECIPIENTS` keyed by form name. The test recipient is a secret. Facts hold only the public contact address." (AD-12+) "`design/tokens.json` is the single source. `site/src/styles/tokens.css` is generated from it at build and never hand-edited." (AD-3/4+) "Facts are validated by one Zod schema in `site/src/data/facts.ts`, which exports the typed object. Both the collection loader and `/api` import that module and never the raw JSON."*

## H5. `/api/sermon` caching and YouTube quota are left to each implementer. High

- **Pair (sermon API vs headers/caching):** "Cached a few minutes" does not name a mechanism. Team A sets `Cache-Control: max-age=300` and assumes Cloudflare caches it, but Worker responses are not cached at the edge by default and `_headers` does not reach them (H2). Team B uses the Cache API, which is **per data centre**, so each location calls YouTube separately. Team C puts it in KV, which AD-1 forbids. Browser `max-age` also delays the switch to "live" by up to five minutes, and nobody owns that trade-off.
- **Quota:** detecting a live broadcast with `search.list` costs 100 units, against a default quota of 10,000 per day. At a five-minute TTL, 288 refreshes a day per location can exhaust the quota on a busy Sunday. When that happens, AD-6 gives no fallback.
- **Thumbnail proxy (`/api/thumbnail`):** nothing restricts which IDs it fetches, so as written it is an open proxy to `i.ytimg.com`.
- **Proposed rule (tighten AD-6):** *"`/api/sermon` caches with the Cache API (TTL set in `wrangler.jsonc`, default 300 s) and returns `Cache-Control: public, max-age=60`. When YouTube fails or the quota is exhausted it returns the last cached value, or `{ ok:false, error:"unavailable" }`, and the component falls back to the channel link. The live check uses the cheapest call confirmed in the open question, and the quota budget is written down. `/api/thumbnail` serves only the `videoId` currently returned by `/api/sermon` and nothing else."*

## H6. Request-time code can escape `/api/` through framework features. Medium

AD-1 says request-time code "lives only under `/api/`". Astro offers three compliant-looking ways to break that. **Server islands** (`server:defer`, served from `/_server-islands/`) let the sermon team render the block on the server without writing an `/api` route. **Actions** (`/_actions/…`) let the forms team skip `/api/forms`. **Middleware** runs for every Worker-handled request. Each team can argue it wrote "a component", not a route.

**Proposed rule:** *"Every route except `src/pages/api/**` sets `prerender = true` (or `output: 'static'` with explicit opt-out for `/api`). Server islands, Actions and on-demand middleware are not used. Pages receive request-time data only by browser `fetch` to `/api/*`."*

## H7. The forms contract is incomplete: response mode, error codes, form list, Turnstile keys. Medium

- **Response mode:** the Conventions table makes API responses JSON, so the page has to submit with `fetch`. A forms team that wants the form to work without JavaScript posts natively and has the function answer with a 303 to a thank-you page. Each choice breaks the other's page code. Turnstile needs JavaScript in any case.
- **Error codes:** "visitor-facing messages are written in the page" while codes are written in the API, and no list is shared between them. The page and the function will invent different code strings.
- **Form list:** AD-5 binds three forms (contact, prayer request, interview request). The validated mockups add a **fourth, "Servir à l'église"** (`forms/serve-*.html`, with name, e-mail, attendance, 21 team checkboxes and "other"). A team could reasonably say AD-5 does not cover it. The interview form also has a date field with no wire format.
- **Turnstile:** the site key (public, needed at build) and the secret key (runtime) have no defined home. Preprod either uses production keys, in which case the preview host must be in the widget's hostname list, or test keys. Neither is decided.
- **Proposed rule (tighten AD-5):** *"Forms are `contact`, `prayer`, `interview`, `serve`, and no other form exists without amending this AD. Each has one field schema in `site/src/forms/<name>.ts` (Zod), imported by both the page and the function. Submission is `fetch` with JSON in both directions. Error codes form a closed enum in `site/src/forms/errors.ts`. Dates are sent as `YYYY-MM-DD`. The Turnstile site key is the build variable `PUBLIC_TURNSTILE_SITE_KEY`, the secret is a Worker secret, and non-production builds use Cloudflare's test keys."*

## H8. Home events block vs events page: filtering and limiting happen in different places. Medium

- AD-8 says lists hide past events in the browser. If the home team picks "next 3" **at build** and then hides the past ones in the browser, the home block can end up empty while the events page, which renders everything and filters later, still shows upcoming events.
- The end time is not required by any schema, yet hiding depends on it. "ISO 8601 with offset" lets an author write `+01:00` for a July event (wrong for Paris summer time). The `.ics` team may emit UTC while the page shows local time. The site gives no reading without JavaScript.
- **Proposed rule (tighten AD-8):** *"The event schema requires `start` and `end` as local Europe/Paris date-times without offset. The build converts them with the zone database. Every list renders all events not yet ended at build time and applies both filtering and any 'first N' limit in the browser, through one shared function. `.ics` files use `TZID=Europe/Paris`. Without JavaScript, events ended before the build are still not listed."*

## H9. URL shape has four uncoordinated owners. Medium

WordPress paths end with `/`. Astro `trailingSlash` and `build.format`, Workers assets `html_handling` in `wrangler.jsonc`, `_redirects` entries, the sitemap and `<link rel=canonical>` each decide the canonical form separately. A mismatch produces redirect chains or loops, or duplicate URLs, which is what AD-9 exists to prevent. The 404 page (`not_found_handling`) has no owner either.

**Proposed rule (tighten AD-9):** *"Canonical paths end with `/`. `astro.config.mjs` sets `trailingSlash: 'always'` and `build.format: 'directory'`. `wrangler.jsonc` sets `html_handling: 'auto-trailing-slash'` and `not_found_handling: '404-page'`. Every `_redirects` source and target, sitemap entry and canonical link uses the trailing-slash form, and a build check rejects any that do not."*

## H10. CSP and the analytics beacon. Medium

Each feature adds sources: Turnstile (`challenges.cloudflare.com`, form pages only), the Web Analytics beacon, the YouTube frame after a click, and `/api` images. The headers team writes one site-wide CSP, and feature teams cannot change it without editing a file they do not own. The beacon can be injected automatically by Cloudflare (dashboard setting on the proxied zone) **or** added by hand in the layout. If both are done, page views are counted twice, and the automatic injection is invisible in the repository.

**Proposed rule:** *"CSP lives in `_headers`, with per-route blocks: a base policy, plus a form-pages block that adds Turnstile. Adding a source requires an AD-7 check in the PR. The Web Analytics beacon is added by hand in the base layout, and automatic injection stays off."*

## H11. Header/footer and menus vs routes and legal links. Low to medium

The `menus` collection holds links as free strings. A page renamed through the redirects flow leaves menus pointing at a 301, or at a 404. The footer's three legal links and the credit line may be hard-coded by the footer team (they appear on every page and the tone rule exempts legal pages) or added to `menus`. AD-3 forbids hard-coding visitor-facing text, and two footers will diverge.

**Proposed rule:** *"Menus reference pages by collection entry ID, not by path, so the build fails on a dangling reference. The footer, legal links and credit included, is rendered only from the `menus` collection and from facts."*

## H12. Settings outside the repository have no record. Low

DNS, the host Redirect Rule, Turnstile widgets, Web Analytics, Email Sending onboarding, secrets and Workers Builds branch settings all live in the Cloudflare dashboard. AD-2 forbids dashboard edits of *site files* only, so these are allowed but untracked. Two maintainers end up with two different mental models of the production configuration.

**Proposed rule (tighten AD-2):** *"Every Cloudflare setting that affects the site and is not in `wrangler.jsonc` is listed (name and purpose, never a value) in `site/ops/cloudflare-settings.md`. A change to one of them goes with a PR updating that file."*

---

## Smaller observations

- **Share buttons** (deferred, but validated in the mockups for events): state now that they are plain links (`https://www.facebook.com/sharer/…`, `https://wa.me/?text=…`) with no SDK. That keeps AD-7 satisfied by construction.
- **Fonts:** DESIGN.md requires self-hosting Outfit and Source Sans 3. Say which file owns `@font-face`: tokens or a separate `fonts.css`.
- **Logging (Conventions):** "never visitor identifiers" conflicts with Workers Logs' default fields (IP address, `cf` object) unless the request fields are switched off. Say so explicitly.
- **Prayer requests (GDPR art. 9):** the memlog leaves this open. AD-5 should at least require TLS-only delivery and no copy to the sender ("send a copy to me" would put religious data in third-party inboxes).
- **AD-11:** the `_dmarc` merge is still an open question but is not a gate. Make "Email Sending onboarding records reviewed against the OVH zone" an explicit step before the nameserver change.

## Summary table

| # | Pair | Severity | Fix |
| --- | --- | --- | --- |
| H1 | Sermon block (AD-6) vs validated sermon mockups (AD-12) | Critical | Tighten AD-6 and add a precedence clause to AD-12 |
| H2 | Redirects / headers / environments / `/api` | High | New "Edge ownership" AD |
| H3 | Legal pages vs sermon embed vs content embeds (consent) | High | Tighten AD-7 |
| H4 | Facts vs events, recipients, tokens, facts schema | High | Tighten AD-3, AD-4, AD-5, AD-12 |
| H5 | `/api/sermon` cache vs headers vs quota, thumbnail proxy | High | Tighten AD-6 |
| H6 | Sermon or forms through server islands or Actions | Medium | Tighten AD-1 |
| H7 | Form page vs form function | Medium | Tighten AD-5 |
| H8 | Home events block vs events page vs `.ics` | Medium | Tighten AD-8 |
| H9 | Astro config vs wrangler vs `_redirects` vs sitemap | Medium | Tighten AD-9 |
| H10 | CSP owner vs feature teams, beacon injection | Medium | New convention |
| H11 | Menus/footer vs routes | Low-Medium | Tighten AD-3 |
| H12 | Dashboard settings | Low | Tighten AD-2 |
