# Review: technology currency of the architecture spine

- **Reviewed:** `architecture-new-site.md` (updated 2026-10-27) and `.memlog.md`
- **Lens:** check that every committed technology decision was researched or checked against reality, not asserted from training data
- **Date of checks:** 2026-10-27 (npm registry, official vendor docs)
- **Reviewer:** independent agent. The spine was not edited.

## Verdict

**Mostly well grounded, but two load-bearing decisions rest on facts that changed in October 2026.** The memlog shows real research for versions, Email Sending and `_redirects` limits. However, (1) Workers Builds now turns non-production branches into isolated **Previews** that do *not* inherit production settings, which contradicts the memlog entry the preprod and form-guard design relies on. (2) YouTube `search.list` now has its own cap of **100 calls/day**, which a "cached a few minutes" live check would exceed. Two medium gaps also need fixing: the Astro adapter's default runtime image service, and cross-domain redirects that cannot live in `_redirects`.

## Findings

### F1. HIGH: the preprod environment model is out of date (Workers Builds Previews)

- **Spine / memlog claim:** `preprod` is "the fixed branch preview address". The memlog says "version/preview URLs share the Worker's production configuration (secrets, bindings) unless the newer isolated Previews feature is used". AD-5's host guard is justified by "previews share production secrets".
- **Reality:** Workers Builds now runs `npx wrangler preview` by default for non-production branches, which "creates or updates a Preview and produces a Preview URL". The Previews docs state "Previews do not inherit production settings". Vars go in a `previews` block of `wrangler.jsonc`, and secrets are set with `wrangler preview base-config secret put` / `wrangler preview secret put --name <preview>`. The old behaviour (Version URLs with `--preview-alias`, sharing the version's configuration) is only what you get if the deploy command is changed to `npx wrangler versions upload`.
  - Previews config docs list storage, data, queue and API bindings but **do not mention `send_email`**. Whether the form function can send mail at all from preprod is unconfirmed.
  - `workers.dev` Preview URLs automatically send `X-Robots-Tag: noindex`. Custom-domain Preview URLs do not.
  - How a Preview name is derived from the branch name (the "fixed address") is not documented on the pages checked.
- **Fix:** add a decision to the spine that names the mechanism. Either:
  - (a) **Previews (default):** declare `previews.vars.ENVIRONMENT = "preview"`, set the test recipient and YouTube key as preview secrets, and confirm that `send_email` can be bound in `previews`. Keep the AD-5 host guard as defence in depth.
  - (b) **Version URLs:** set the non-production deploy command to `npx wrangler versions upload --preview-alias preprod`. The memlog premise then holds (production secrets shared) and the host guard becomes essential.

  Then correct the memlog entry and the Structural Seed label "preview alias".
- **Sources:** https://developers.cloudflare.com/workers/ci-cd/builds/configuration/ , https://developers.cloudflare.com/workers/previews/ , https://developers.cloudflare.com/workers/previews/configuration/ , https://developers.cloudflare.com/workers/configuration/previews/

### F2. HIGH: the YouTube live check as implied would exceed the new `search.list` cap

- **Spine claim:** AD-6 says `/api/sermon` returns the live broadcast or the latest video, "cached a few minutes". The open question leaves the quota cost to be confirmed later.
- **Reality (Google docs, last updated 2026-10-15):** `search.list` now has its own bucket: "Quota impact: 100 calls per day. A call to this method has a quota cost of 1 unit in the Search Queries quota bucket." `videos.list`, `playlistItems.list` and `channels.list` cost 1 unit each, from a shared 10,000 units/day. The usual way to detect a live stream, `search.list?channelId=…&eventType=live&type=video`, would use 288 calls/day with a 5-minute cache. That is before multiplying by Cloudflare data centres, because the Workers Cache API is per location. This is almost 3 times the cap.
- **Fix:** write the method into AD-6.
  1. Read the channel's uploads playlist (`UU` + channel id suffix) with `playlistItems.list` (1 unit).
  2. Read the newest items with `videos.list?part=snippet,liveStreamingDetails` (1 unit).
  3. Use `snippet.liveBroadcastContent == "live"` to choose live versus latest.

  That makes 2 units per refresh, far under 10,000/day. If `search.list` is kept, only call it in a Sunday window and at most once every 15 minutes. Check during the build that a live stream appears in the uploads playlist while it is live, because this was not verified here. Close the Open Question.
- **Sources:** https://developers.google.com/youtube/v3/determine_quota_cost , https://developers.google.com/youtube/v3/docs/search/list

### F3. MEDIUM: Astro's Cloudflare adapter transforms images at runtime by default (billed, Worker-served)

- **Spine claim:** CAP-6 lives in the "build, Astro image pipeline". AD-1 says static first. AD-15 says no new paid service.
- **Reality:** in `@astrojs/cloudflare` the default `imageService` is `'cloudflare-binding'`, which "enables image optimization using the Cloudflare Images binding only at runtime". The binding is provisioned automatically on deploy. The Images binding is billed at $0.50 per 1,000 unique transformations beyond 5,000/month. Image requests would also go through the Worker, which goes against AD-1.
- **Fix:** add a rule (under AD-1 or the Stack) to set `imageService: 'compile'` in `astro.config.mjs`. Images are then transformed at build time for prerendered routes, and no Images binding is used.
- **Sources:** https://docs.astro.build/en/guides/integrations-guide/cloudflare/ , https://developers.cloudflare.com/images/pricing/

### F4. MEDIUM: cross-domain and www redirects cannot be done in `_redirects`

- **Spine claim:** AD-9 says `www.tonegliseavalenciennes.fr`, `add-valenciennes.fr` and `www.add-valenciennes.fr` answer with a 301 to the same path. The conventions say "redirects in `site/public/_redirects` only".
- **Reality:** Workers static assets `_redirects` lists "Domain-level redirects" as unsupported, and it is "not applied to requests served by your Worker code". Cross-host redirects need Cloudflare **Single Redirects** (per zone, 10 rules on Free, wildcard supported) or **Bulk Redirects** (account level, 15 rules / 10,000 URLs on Free). Both require the source hostnames' DNS records to be **proxied**.
- **Fix:**
  - Amend AD-9 and the Headers/redirects convention so that host redirects are Cloudflare Redirect Rules on each zone (for example a wildcard Single Redirect `https://*add-valenciennes.fr/*` → `https://tonegliseavalenciennes.fr/${2}`, 301, query string preserved), with proxied placeholder records. Keep `_redirects` for same-host paths such as old sermon URLs (about 303 lines, under the 2,000 static limit).
  - Note that these rules are dashboard/API configuration outside git, which is an exception to AD-2 that should be stated.
  - Check on preprod that `_redirects` path rules still fire for paths that would otherwise fall through to the Worker.
- **Sources:** https://developers.cloudflare.com/workers/static-assets/redirects/ , https://developers.cloudflare.com/rules/url-forwarding/

### F5. LOW: `_headers` does not cover Worker responses

- **Claim:** "Security headers and cache rules in `site/public/_headers`". AD-10 says every non-production host sends noindex.
- **Reality:** `_headers` supports host-specific absolute-URL rules (for example `https://<preview host>/*`), up to 100 rules. However, "Custom headers defined in the `_headers` file are not applied to responses generated by your Worker code", which covers everything under `/api` and any page that falls through to the Worker.
- **Fix:** state that `/api` responses get their security, cache and `X-Robots-Tag` headers set in code (one shared helper or Astro middleware). Use a host-specific `_headers` rule for the preprod noindex, or rely on the automatic `workers.dev` Preview header (F1).
- **Source:** https://developers.cloudflare.com/workers/static-assets/headers/

### F6. LOW: Cloudflare Email Sending is confirmed, with two gaps still unconfirmed

- **Confirmed:**
  - Beta, available on Workers Paid.
  - 3,000 emails/month included, then $0.35 per 1,000.
  - "You must be using Cloudflare DNS".
  - Onboarding adds MX, SPF and DKIM on the `cf-bounce` subdomain plus a `_dmarc` TXT record.
  - Binding shape: `"send_email": [{ "name": "EMAIL", "remote": true }]`, called as `env.EMAIL.send({...})`.
- **Still unconfirmed:**
  - The docs do not say that the root MX and SPF are left alone. The spine is right to keep this open, and AD-11's "merge `_dmarc`" is the correct precaution.
  - `send_email` support inside Previews is unconfirmed (see F1).
  - The pricing page says sends to *verified destination addresses* are free on all plans. Verified destinations belong to Email Routing, and enabling Email Routing on a zone takes over the root MX. Do not enable Email Routing on `tonegliseavalenciennes.fr` to get this.
- **Fix:** add these points to the memlog with sources. Keep the open question until onboarding shows the actual records.
- **Sources:** https://developers.cloudflare.com/email-service/ , https://developers.cloudflare.com/email-service/get-started/send-emails/ , https://developers.cloudflare.com/email-service/platform/pricing/

### F7. LOW: Node "24 LTS" is now Maintenance LTS; versions drifted slightly

- **Reality:**
  - Node 24's active support ended on 2026-10-20. It is now Maintenance LTS, with security fixes until 2028-04-30.
  - Node 26 (released 2026-05-05) moves to LTS in October 2026.
  - The Workers Builds image default is Node 24.22.1, while the local machine runs 24.18.0.
  - Astro 7.4.2 requires node >= 22.23.4, which is fine.
  - Wrangler is now 4.153.0 (published 2026-10-26; the spine has 4.152.0). Previews need >= 4.135.0. The adapter peer range is `wrangler ^4.125.0`.
  - `@astrojs/cloudflare` 15.0.0-beta.3 exists. Stay on 14.x.
- **Fix:**
  - Write "Node.js 24 (Maintenance LTS, pinned in `.nvmrc`)" or move to 26 once it is officially LTS.
  - Pin the same version locally and in the build with `.nvmrc`.
  - Treat Stack versions as minimums with a lockfile instead of exact patch numbers.
- **Sources:** https://endoflife.date/nodejs , https://developers.cloudflare.com/workers/ci-cd/builds/build-image/ , `npm view astro|@astrojs/cloudflare|wrangler` (2026-10-27)

### F8. LOW: "cookieless" Web Analytics is a vendor claim; verify it

- **Reality:** the current official Web Analytics FAQ does not mention cookies or storage. Cloudflare's launch blog says it uses no cookies and no localStorage. A 2020 independent review reported that the beacon set an identifier cookie. Automatic setup injects the beacon on every page of the zone, including subdomains.
- **Fix:** before the legal pages state "no cookies", check on preprod in the browser storage panel. Use the manual snippet, not auto-injection, so that it stays under AD-7 control. Add `static.cloudflareinsights.com`, `cloudflareinsights.com` and `challenges.cloudflare.com` (Turnstile) to the CSP.
- **Sources:** https://developers.cloudflare.com/web-analytics/faq/ , https://blog.cloudflare.com/free-privacy-first-analytics-for-a-better-web/ , https://www.ctrl.blog/entry/review-cloudflare-analytics/

## Confirmed as stated

| Decision | Status | Source |
| --- | --- | --- |
| Astro 7.4.2 is the latest version | Confirmed (npm `latest`, 2026-10-27) | `npm view astro` |
| @astrojs/cloudflare 14.4.2 is the latest version | Confirmed (15.0.0-beta.3 also exists) | `npm view @astrojs/cloudflare` |
| Astro on Workers with static assets: prerendered pages served as assets, unmatched requests go to the Worker, `prerender = false` routes for `/api` | Confirmed. Bindings come from `import { env } from 'cloudflare:workers'` (`Astro.locals.runtime` was removed in v13+) | https://docs.astro.build/en/guides/integrations-guide/cloudflare/ |
| `_redirects` limits of 2,000 static and 100 dynamic | Confirmed | https://developers.cloudflare.com/workers/static-assets/redirects/ |
| Turnstile is free | Confirmed. Free plan: 20 widgets, 10 hostnames per widget, unlimited challenges. Add the preprod host to the widget | https://developers.cloudflare.com/turnstile/plans/ |
| YouTube Data API v3 | Current. The quota model changed on 2026-10-15 (F2) | https://developers.google.com/youtube/v3/determine_quota_cost |

## Process note

The memlog has dated version entries for most stack items, which is good practice. Two entries are not reflected in the spine:

- The YouTube quota was left as "not confirmed" and is now resolvable.
- The preview-sharing claim was recorded as fact without a source URL.

Add the source URL to every `(version)` entry so future reviewers can re-check it quickly.
