---
title: 'Site scaffold published to preprod'
type: 'feature'
ticket: '1'
created: '2026-11-10'
status: 'built'
baseline_revision: 'f438da362838e07735b7ef1d98580a196543ef30'
route: 'full'
route_source: 'auto'
risk: 'high'
review: 'quick'
review_source: 'pinned'
lenses_ran: ['quick']
review_loop_iteration: 1
context:
  - '{project-root}/_bmad-output/initiative-site-improvement/architecture-new-site/architecture-new-site.md'
---

<frozen-after-approval reason="human-owned intent — do not modify unless human renegotiates">

## Intent

**Problem:** The new site has no code and no publishing path, so nothing can be seen on preprod and no later story has a base to build on.

**Approach:** Create the `web/` Astro project with the Cloudflare adapter and one prerendered home page, configured so Workers Builds deploys `main` as the production Worker and turns `preprod` into a public, link-only Cloudflare Preview; the build writes `robots.txt` and `_headers` from the branch it builds, so only `main` is indexable. The owner connects the repository in the dashboard; the settings are recorded in `web/ops/cloudflare-settings.md`.

## Boundaries & Constraints

**Always:** Every route prerendered (AD-1); `output: 'static'`, `imageService: 'compile'`, `trailingSlash: 'always'`, `build.format: 'directory'`. Production `workers_dev: false`; `preview_urls: true` set explicitly so Previews keep working; because it also gives every production version a `workers.dev` link, every build marks all `workers.dev` hosts noindex. `SITE_ENV` is `production` only when `WORKERS_CI_BRANCH` is exactly `main`; unset or any other branch means non-production. Visitor text in French, "tu". Versions from the architecture Stack as minimums, exact ones in `web/package-lock.json`.

**Decisions (owner, 2026-11-10):** Node 26 is installed locally with nvm, beside the existing versions, and all checks run on it. The Worker is named `ton-eglise-a-valenciennes`.

**Never:** No `/api` route, no tokens, fonts, layout, facts or content collections (stories 1.3–1.8). No secret, API token or `wp-config.php` value in a tracked file. No change under `web/www/`; its removal ships in its own pull request. No deploy or `wrangler` command that talks to the Cloudflare account; only local builds and `--dry-run`.

## I/O & Edge-Case Matrix

| Scenario | Input / State | Expected Output / Behavior | Error Handling |
|----------|--------------|---------------------------|----------------|
| Production build | `WORKERS_CI_BRANCH=main` | `robots.txt` allows all; `_headers` sets `X-Robots-Tag: noindex` only for `https://:version.:account.workers.dev/*`, no `X-Robots-Tag` rule for any other host | No error expected |
| Preprod build | `WORKERS_CI_BRANCH=preprod` | `robots.txt` = `User-agent: *` / `Disallow: /`; `_headers` sets `/*` → `X-Robots-Tag: noindex` | No error expected |
| Local build | variable unset | same as preprod | No error expected |
| Branch name close to main | `WORKERS_CI_BRANCH=main-fix` | non-production output | No error expected |

</frozen-after-approval>

## Code Map

- `web/` -- holds only the WordPress copy `web/www/` and its `web/.gitignore`; this story adds the new site beside them. Layout per architecture Structural Seed, rooted at `web/` instead of `site/`.
- `.gitignore` -- root ignore file; already covers `node_modules/`; add `web/dist/`, `web/.astro/`, `web/.wrangler/`, `web/.dev.vars*`.
- `design/maquettes/home/` -- not used yet; the real home page comes in epic-pages-and-content.
- Facts checked: latest `astro` 7.4.9, `@astrojs/cloudflare` 14.4.6, `wrangler` 4.160.0. Workers Builds exposes `WORKERS_CI_BRANCH`; production deploy command `npx wrangler deploy`, non-production `npx wrangler preview` (Previews need wrangler ≥ 4.135.0, a `previews` block — may be empty — and do not inherit production vars). Preview URL: `<preview-name>-<worker-name>.<subdomain>.workers.dev`, public by default. `preview_urls`' initial value follows `workers_dev` when unset. Adapter: `main` = `@astrojs/cloudflare/entrypoints/server`; prerendering runs in workerd by default, so read the branch in Node through an integration hook, not inside a page.
- Local machine has Node 20/24 under nvm, no 26.

## Tasks & Acceptance

**Execution:**
- [x] `web/.nvmrc` -- `26` -- one Node pin for local and Workers Builds.
- [x] `web/package.json`, `web/package-lock.json` -- private package, `engines.node >=26`, scripts `dev`, `build`, `preview`, `check`; deps astro, @astrojs/cloudflare, wrangler (dev) -- install with npm to get the lockfile.
- [x] `web/astro.config.mjs` -- site `https://tonegliseavalenciennes.fr`, the Always options, cloudflare adapter with `imageService: 'compile'`, the edge-files integration.
- [x] `web/integrations/edge-files.mjs` -- on `astro:build:done`, compute `SITE_ENV` from `WORKERS_CI_BRANCH`, write `robots.txt` and `_headers` into the static output directory, log the environment -- one generator later stories extend (1.7 security headers).
- [x] `web/integrations/edge-files.mjs` -- production `_headers` also sets `X-Robots-Tag: noindex` on `https://:version.:account.workers.dev/*` (one splat only; a second splat makes Cloudflare drop the rule).
- [x] `web/wrangler.jsonc` -- `assets.directory` is `./dist/client`, the adapter's static output; a comment says the build-generated config is what gets deployed.
- [x] `web/wrangler.jsonc` -- name `ton-eglise-a-valenciennes`, `main`, compatibility date, `workers_dev: false`, `preview_urls: true`, `assets` (directory, `ASSETS` binding, `html_handling: auto-trailing-slash`, `not_found_handling: 404-page`), `vars.CANONICAL_HOST`, `previews.vars.CANONICAL_HOST` -- comments in English.
- [x] `web/tsconfig.json` -- Astro strict preset; `include` limited to the new site's own folders so `web/www/` is never checked.
- [x] `web/src/pages/index.astro` -- minimal French home page: `lang="fr"`, title, one `h1`, short "site en préparation" line; no external request.
- [x] `web/ops/cloudflare-settings.md` -- names only: Workers Builds connection (repo, root `web`, production branch `main`, build `npm run build`, deploy and preview commands, preview builds on for `preprod` only), workers.dev off, automatic Web Analytics injection off; who set it and when, left for the owner to fill.
- [x] `.gitignore` -- the ignores listed in Code Map.

**Acceptance Criteria:**
- Given a clean clone, when `npm ci && npm run build` runs in `web/` on Node 26, then it succeeds and `/` is a prerendered `index.html`.
- Given the built output, when `npx wrangler deploy --dry-run` runs, then it validates without contacting the account.
- Given the owner has connected Workers Builds and merged to `preprod`, when they open the preview link, then the home page shows, `robots.txt` disallows all and responses carry `X-Robots-Tag: noindex`.
- Given a merge to `main`, when Workers Builds runs, then the build succeeds and the production `workers.dev` address does not answer.

## Implementation Notes

- Node 26.13.0 was already installed under nvm; every check ran on it. Installed: astro 7.4.9, @astrojs/cloudflare 14.4.6, wrangler 4.160.0, plus dev deps @astrojs/check 0.9.12 and typescript 6.0.3 for `npm run check`.
- npm 11 blocks dependency install scripts by default (`workerd`, `esbuild` postinstall); builds and the dry-run work without them because the platform binaries come as optional packages. Watch for this in Workers Builds logs.
- The adapter enables Astro sessions backed by a KV binding unless told otherwise; `session: false` in `astro.config.mjs` keeps KV out (AD-1).
- With `output: 'static'` the adapter builds an assets-only Worker: static output is `dist/client/`, the generated config is `dist/client/wrangler.json` (excluded from upload by `.assetsignore`) and `wrangler deploy` follows `.wrangler/deploy/config.json` to it. The generated config keeps the `previews` block. `main` and the `ASSETS` binding are dropped from it while no route is on-demand.
- The adapter's own `astro:build:done` hook writes an immutable `Cache-Control` rule for `/_astro/*` into `_headers` before ours runs; `edge-files` prepends its block and keeps that content instead of overwriting it.
- `compatibility_date` is 2026-11-03, the date of the installed workerd runtime.
- `previews.vars.CANONICAL_HOST` is `preview.invalid`, a host no request carries, so preview code always takes the non-production path; the account's workers.dev subdomain is not known in the repository.
- `npx wrangler preview` names the Preview after the branch (`--name` defaults to the current git branch).
- Review loop 1: with `WORKERS_CI_BRANCH=main`, `wrangler dev --local` answered `x-robots-tag: noindex` for `Host: 3f2a91c4-ton-eglise-a-valenciennes.flo.workers.dev` and no such header for `Host: tonegliseavalenciennes.fr`. Behaviour on Cloudflare itself is confirmed only once Workers Builds is connected.

## Plan Change Log

- 2026-11-10, review loop 1, owner: finding #2 (version preview links expose indexable production builds on `workers.dev`) was an intent gap. Owner chose to block indexing on every `workers.dev` host, production builds included; matrix row 1 and the Always rule amended, two tasks added. Known-bad state avoided: a production build reachable at `<version>-ton-eglise-a-valenciennes.<subdomain>.workers.dev` with `Allow: /` and no noindex. KEEP: everything else in the first implementation (branch logic, adapter `_headers` merge, `session: false`, `previews` vars, scoped tsconfig); it is extended, not reverted. Host placeholders checked against miniflare's `generateRuleRegExp`: `:name` in a host matches `[^/.]+`.

- 2026-11-10, owner: the new site lives directly in `web/` instead of `site/`; `web/www/` is archived outside the repository and removed in a separate pull request. Paths in the frozen section and tasks renamed accordingly; the Never rule now protects only `web/www/`. The architecture and AGENTS.md are updated in the removal pull request.

## Review Triage Log

| # | Finding | Verdict | Route | Evidence |
|---|---------|---------|-------|----------|
| 1 | AGENTS.md and the architecture still say `site/` on this branch; AGENTS.md says there is no build | low | defer | Real until the removal PR (`chore/remove-wordpress-copy`) merges, which rewrites both to `web/`; the build commands belong to story 1.2. Fix edits agent-context files. |
| 2 | `preview_urls: true` gives every version, production included, a `<version>-ton-eglise-a-valenciennes.<subdomain>.workers.dev` link that serves an indexable production build | medium | intent_gap | Wrangler's schema: preview_urls serves `<version>-<name>.<subdomain>.workers.dev`; `WORKERS_CI_BRANCH=main` build gives `Allow: /` and no `X-Robots-Tag`. Breaks AD-10; the frozen Always (`preview_urls: true`) and matrix row 1 (no `X-Robots-Tag` on main) leave no in-plan fix. |
| 3 | `assets.directory` is `./dist` while static output is `dist/client/` | low | patch | `dist/` holds `client/` and `server/`; deploy only works through `.wrangler/deploy/config.json` redirecting to `dist/client/wrangler.json` (`directory: "."`). Moot until the loopback for #2 settles. |
| 4 | Code Map says no Node 26 locally | false | rejected | Fix edits this build's plan; the line described the state before the owner's decision. |
| 5 | AGENTS.md and the architecture still say `site/` and "no build" (review loop 2) | low | defer (carried) | carried: same location and claim as #1; still fixed only on `chore/remove-wordpress-copy`, which should merge first. |
| 6 | `not_found_handling: 404-page` with no 404 page built | low | rejected | Real: an unknown path gets Cloudflare's bare 404, still a correct 404 status and noindex on preprod. The French 404 page belongs to epic-pages-and-content; adding one here is more than a direct correction. |

## Design Notes

Branch, not hostname, decides the environment because static assets are served before any Worker code; this matches AD-10. The `_headers` and `robots.txt` go into the directory Astro returns from `astro:build:done` — check where the adapter puts static files (likely `dist/client/`) and that the generated Wrangler config keeps the `previews` block; if it drops it, record that in Implementation Notes and find the supported way.

## Verification

**Commands:**
- `cd web && npm ci && npm run build` -- expected: success, `index.html` in the static output.
- `WORKERS_CI_BRANCH=main npm run build` then `WORKERS_CI_BRANCH=preprod npm run build`, inspecting `robots.txt` and `_headers` each time -- expected: matrix rows.
- `npx wrangler deploy --dry-run` -- expected: valid config, assets listed.
- `npx astro check` -- expected: no errors.

**Manual checks (if no CLI):**
- Owner, after merging: preview link, `curl -I` on it for `X-Robots-Tag`, production workers.dev address unreachable.
