# Rubric review — Architecture spine "New church website"

- **Reviewed:** `../architecture-new-site.md` (updated 2026-10-27) and `../.memlog.md`
- **Against:** `../../spec-site-improvement/spec-site-improvement.md`, read through the memlog's 2026-10-24 direction (leave WordPress)
- **Reviewer:** independent, 2026-10-27
- **Spine not edited.**

## Verdict

**Revise before slicing into epics.** The paradigm, layering and most ADs are sound and enforceable, and the spec's still-valid capabilities are mapped. But four dimensions this altitude owns are under-decided in ways that let separately built units diverge or that cannot be implemented as written: host-level redirects and infrastructure configuration living outside the repo, the mechanism that keeps non-production hosts unindexed, content migration from the old site, and operations (cutover, rollback, domain renewal). Three memlog items did not land.

## 1. Divergence points for the level below

| Divergence point | Fixed by | Status |
| --- | --- | --- |
| Where request-time code may live | AD-1 | Fixed |
| How changes reach production | AD-2 | Fixed for code; infra config not covered (F1) |
| Content shapes and access | AD-3 | Fixed |
| Practical facts | AD-4 | Fixed |
| Form handling | AD-5 | Mostly; recipient mapping location open (F5) |
| Sermon block rendering | AD-6 | Partly: client fetch vs Astro server island vs build-time is not fixed (F5) |
| Third-party requests | AD-7 | Fixed |
| Events | AD-8 | Fixed |
| URLs and redirects | AD-9 | Not implementable as written for host redirects (F1); trailing-slash form not fixed (F6) |
| Indexing per environment | AD-10 | Mechanism not fixed (F2) |
| Mail continuity | AD-11 | Fixed in intent; cutover sequence missing (F4) |
| Visual tokens / accessibility / secrets / cost | AD-12..15 | Fixed |
| **Content migration** (source of truth, conversion, images, URL inventory) | none | **Missing (F3)** |
| **Image location** (`src/assets` through the pipeline vs `public/`) | Deferred as "image formats and sizes" | Divergence point wrongly deferred (F3) |
| **Infrastructure configuration** (DNS, zone redirect rules, custom domains, Workers Builds settings, Turnstile keys, Email Sending onboarding) | none | **Missing (F1)** |

## 2. Findings

### F1 — High — Host redirects cannot live in `_redirects`, and infrastructure config has no home

**What.** AD-9 requires `www.tonegliseavalenciennes.fr`, `add-valenciennes.fr` and `www.add-valenciennes.fr` to 301 to the canonical host, and the Consistency Conventions say "redirects in `site/public/_redirects` only". Cloudflare's `_redirects` (Pages and Workers Static Assets) is path-based: it does not do domain-level redirects, and the memlog itself records (line 43) that `_redirects` is not applied to requests served by Worker code. So the host redirects must be either zone-level Redirect Rules (dashboard config on two zones) or Worker code that runs first, and the convention as written forbids both. More broadly, a whole class of production-affecting configuration lives in the Cloudflare dashboard, not in git: DNS records for two zones, Redirect Rules, the Worker's custom domain and routes, Workers Builds settings (production branch, root directory `site/`, build command), secrets, the Turnstile widget and its allowed hostnames, Email Sending onboarding. AD-2 says "no direct dashboard edit of site files", which leaves all of this ungoverned. The spec's open question "How are admin and server actions recorded?" was never carried over.

**Why it matters.** Two epics (domains, and pages/redirects) will each pick a redirect mechanism; the first one to implement will either break the convention or fail. Dashboard changes leave no trace, which is exactly the problem the spec raised.

**Fix.** (a) Amend AD-9: host-level 301s are done by one zone-level Single Redirect rule per redirecting host (or by the Worker with `run_worker_first` restricted to non-canonical hosts — pick one); path-level 301s stay in `_redirects`. Amend the Headers convention accordingly. (b) Add an AD "Infrastructure is declared or recorded": everything expressible in `wrangler.jsonc` (custom domain route, `workers_dev`, `preview_urls`, vars, Email Sending binding, compatibility date) lives there; everything that can only be set in the dashboard is listed in one tracked runbook, e.g. `site/ops/cloudflare-settings.md`, updated in the same PR as the change that needs it. Secret values are never written there, only their names (consistent with AD-14).

### F2 — High — AD-10's "every non-production host sends noindex" has no mechanism, and production leaks through workers.dev

**What.** Static assets on Workers are served before any Worker code unless `run_worker_first` is set, and `_headers` / `robots.txt` are static build outputs. So "every non-production host sends `X-Robots-Tag: noindex` and disallows all robots" can only be enforced either at build time (branch-dependent output) or at runtime (Worker in front of assets). The spine does not choose. In addition, the production version is also reachable at `<worker>.<account>.workers.dev` unless `workers_dev` is disabled; that host serves the production build, with production `robots.txt`, and is indexable — the duplicate-site problem AD-9 and AD-10 are meant to prevent. AD-5 has the same gap: "the canonical production host" must be compared against something; the value's location is not fixed.

**Fix.** Amend AD-10's Rule: "The build writes `robots.txt` and the `X-Robots-Tag` rule in `_headers` from the branch being built (`WORKERS_CI_BRANCH`): only `main` gets the indexable versions. `workers_dev` is `false` for production in `wrangler.jsonc`. The canonical host is one non-secret var `CANONICAL_HOST` in `wrangler.jsonc`, read by AD-5's form function and by the sitemap/canonical tags." Verify against current Cloudflare docs whether preview URLs require `workers_dev` enabled; if they do, add a Worker-first noindex for `*.workers.dev` instead.

### F3 — High — Content migration from the old site is not decided, deferred or asked

**What.** The spine says pages keep their WordPress paths and sermon URLs get per-video 301s, but nothing decides how content gets from WordPress into `site/src/content/`: which source (live production vs the March 2026 local backup — the memlog assumption on line 60 that the redirect list is built from live data did not land), how page-builder (Elementor) markup becomes typed content, where media-library images go (`site/src/assets/` through Astro's image pipeline, which CAP-6 needs, vs `site/public/`, which bypasses it), and which old URLs need inventorying beyond sermons (event pages from The Events Calendar, category/tag/author archives, feeds, `/wp-content/uploads/...` links that external sites or e-mails may hold). The memlog decision on line 65 "any removed path gets a 301 in `_redirects`" also did not land in AD-9. "Image formats and sizes" is deferred, but image *location* is a cross-unit divergence point, not a build detail. The spec's constraint "kept as they are: the logo, the real photographs (children excepted), the pastoral welcome, the history, the department texts" is still valid and is not mapped.

**Fix.** Add AD-16 "Migration is a one-time, scripted import from production": (1) the source is the live site at the time of import (sitemaps plus page exports), never the local backup; (2) the URL inventory is the union of production sitemaps plus server logs if available, stored once as `site/migration/url-inventory.csv` with a target per URL (kept path, 301 target, or 410); every inventoried URL resolves after cutover; (3) content images live in `site/src/assets/` and go through the image pipeline, only fonts/favicon/files linked by exact URL go in `public/`; (4) kept texts and photos (spec constraint list, children excluded) are carried verbatim, rewriting is a separate PR. Add to Open Questions: are any `/wp-content/uploads/` URLs (PDFs, posters) linked from outside and therefore needing a redirect?

### F4 — Medium — Operations: cutover, rollback and the December 2026 domain renewal are missing

**What.** (a) AD-11 states what must be true of DNS but not the order of the cutover: lower TTLs at OVH, add both zones to Cloudflare, verify copied records, attach the custom domain, onboard Email Sending, switch nameservers, test mail both ways, keep WordPress reachable for rollback. (b) There is no rollback rule. AD-2 makes every change pass three merges; in an incident the owner will be tempted to use the Cloudflare "roll back to version" button, which AD-2 currently forbids implicitly. (c) The memlog (line 49) records that `tonegliseavalenciennes.fr` renews on **17/12/2026**, under two months away, and is the canonical domain for site and mail. A lapse would take down both. Nothing in the spine or its open questions mentions it. (d) AGENTS.md still says the owner uploads `main` by FileZilla; the memlog (line 59) says AGENTS.md must be updated to "merge to main publishes", which is not recorded as a task.

**Fix.** Add AD-17 "Rollback": "In an incident the owner may roll back to the previous version in Cloudflare; a revert PR then follows the normal flow within the same day, so `main` matches production again." Add a cutover checklist as a named Deferred item owned by the domains epic, with the rule that the nameservers switch only after mail records are verified and the OVH zone export is saved in the ops runbook (F1). Add to Open Questions: "Is `tonegliseavalenciennes.fr` set to auto-renew before 17/12/2026, and are both domains on auto-renew?" Add the AGENTS.md update to the deployment epic's scope.

### F5 — Medium — AD-6 and AD-5 leave implementation forks that two units can take differently

**AD-6 (sermon block).** Pages are prerendered (AD-1), so the latest/live sermon must be fetched in the browser from `/api/sermon`, or rendered by an Astro server island (whose route is `/_server-islands/...`, outside `/api/`, so AD-1 forbids it literally). The spine does not say which; it also does not say what the component shows when the API fails or the YouTube quota is exhausted, or with JavaScript disabled. The thumbnail route "through `/api/`" is a proxy; without a rule it can become an open proxy. **Fix:** "The sermon component fetches `/api/sermon` from the browser; its server-rendered fallback is a 'Voir les prédications sur YouTube' link to the channel, shown when JS is off or the call fails. `/api/thumbnail` only accepts an 11-character video id and only fetches from `i.ytimg.com`. The response is cached with the Cache API; no KV." Note that the Cache API is a no-op on `workers.dev` hosts, so preprod will hit YouTube on every view; acceptable if stated.

**AD-5 (forms).** Where the form-name → recipient mapping lives is not fixed: AD-14 puts *test* recipients in secrets/vars, `facts.json` holds the public e-mail, and the Layer table lets functions read facts. Three functions could each hardcode their recipient. The sender address on the church domain (needed for DMARC alignment with OVH's SPF) is not fixed either. **Fix:** "Recipients and the From address for each form are non-secret vars in `wrangler.jsonc` (`FORM_RECIPIENTS` keyed by form name); functions never read recipients from anywhere else."

### F6 — Low — Smaller gaps

- **Unratified ADs.** AD-5, AD-12, AD-13 and AD-14 carry no `[ADOPTED]` tag; AD-12, AD-13 and AD-14 have no corresponding decision in the memlog at all. Either get the owner's yes and log it, or mark them proposed so epics do not treat them as fixed.
- **Memlog question dropped.** Line 26: prayer requests are GDPR art. 9 special-category data; where they land (the OVH mailbox) and how long they are kept there is open. The spec also asks "how long are requests stored, and who reads them" and "who writes the legal pages". The spine's Open Questions list neither; "legal pages wording" is deferred but retention is not a wording question. Add it as an open question owned by the owner, blocking the prayer-request form going live.
- **Trailing slashes.** "Pages keep their current WordPress paths": WordPress paths end in `/`. Fix Astro `trailingSlash: 'always'` and the matching Workers assets `html_handling` in the conventions, or the two will disagree and create duplicates/redirect loops.
- **AD-8 without JavaScript.** Past events are hidden in the browser; with JS off, or in the sitemap and `.ics` files, past events persist until the next build. Acceptable, but say so, and exclude events from the sitemap or rebuild periodically.
- **Email Sending is beta.** No fallback is deferred. Add a Deferred line: "If Email Sending leaves beta with a price or breaks, the fallback sender is decided then; AD-5's interface (`/api/forms/<name>`) does not change."
- **Spec constraint "no photographs showing children for now"** is still valid and not mapped; one line in the Capability map or AD-12 suffices.
- **AD-2 enforcement.** Add "branch protection on `develop`, `preprod`, `main` requires a PR" and "no Cloudflare API token on agents' machines", so the rule is enforced by tools rather than by memory.

## 3. Deferred items that could let units diverge

| Deferred item | Safe? |
| --- | --- |
| CMS choice | Safe; AD-3 holds the seam |
| OVH hosting vs standalone e-mail | Safe, but AD-11's "do not cancel" must stay binding |
| Removal of `web/` | Safe |
| Form fields, legal wording | Safe; retention is not wording (F6) |
| Share buttons | Safe; AD-7 binds |
| Search, newcomer, giving | Safe |
| **Image formats and sizes** | **Not safe as worded**: location (`src/assets` vs `public`) is a divergence point (F3). Formats/sizes alone can stay deferred |
| Monitoring | Safe at this size |

## 4. Spec capability coverage

CAP-3, 5, 6, 7, 8, 9, 10, 11, 12, 13 are bound and mapped; CAP-1, 2, 4, 14 are correctly marked superseded. Residual gaps: CAP-3's "every protection applies under both domain names" becomes "redirect hosts send nothing but a 301", which needs F1 to be implementable; CAP-11's "no link target is `#`" and "no English interface string" are only implied by AD-3 (fine for this altitude); CAP-12's "full date with year" is covered by the Dates convention; CAP-5's "legal notice and privacy policy published, forms link to it" is mapped but the retention question is missing (F6).

## 5. Memlog decisions that did not land

| Memlog line | Item | Landed? |
| --- | --- | --- |
| 26 | Prayer requests are GDPR art. 9 data; retention open | No (F6) |
| 49 | `tonegliseavalenciennes.fr` renews 17/12/2026 | No (F4) |
| 54 | `jeunessentiel.fr` out of scope | No; one line in scope or Deferred would prevent someone migrating its zone |
| 59 | AGENTS.md must say merging to `main` publishes | No (F4) |
| 60 | Redirect list built from live site, not the March backup | No (F3) |
| 65 | Any removed path gets a 301 | Partly; AD-9 covers sermons only (F3) |
| 62 | Previews share production secrets and bindings | Landed indirectly in AD-5 |
| 22, 16 | Semi-automatic sermon PR, sermon library | Correctly superseded by lines 38 and 41 |
