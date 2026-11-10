---
title: 'Site scaffold published to preprod'
type: 'feature'
ticket: '1'
created: '2026-11-10'
status: 'in-progress'
baseline_revision: 'f438da362838e07735b7ef1d98580a196543ef30'
route: 'full'
route_source: 'auto'
risk: 'high'
review: ''
review_source: ''
lenses_ran: []
review_loop_iteration: 0
context:
  - '{project-root}/_bmad-output/initiative-site-improvement/architecture-new-site/architecture-new-site.md'
---

<frozen-after-approval reason="human-owned intent — do not modify unless human renegotiates">

## Intent

**Problem:** The new site has no code and no publishing path, so nothing can be seen on preprod and no later story has a base to build on.

**Approach:** Create the `web/` Astro project with the Cloudflare adapter and one prerendered home page, configured so Workers Builds deploys `main` as the production Worker and turns `preprod` into a public, link-only Cloudflare Preview; the build writes `robots.txt` and `_headers` from the branch it builds, so only `main` is indexable. The owner connects the repository in the dashboard; the settings are recorded in `web/ops/cloudflare-settings.md`.

## Boundaries & Constraints

**Always:** Every route prerendered (AD-1); `output: 'static'`, `imageService: 'compile'`, `trailingSlash: 'always'`, `build.format: 'directory'`. Production `workers_dev: false`; `preview_urls: true` set explicitly so Previews keep working. `SITE_ENV` is `production` only when `WORKERS_CI_BRANCH` is exactly `main`; unset or any other branch means non-production. Visitor text in French, "tu". Versions from the architecture Stack as minimums, exact ones in `web/package-lock.json`.

**Decisions (owner, 2026-11-10):** Node 26 is installed locally with nvm, beside the existing versions, and all checks run on it. The Worker is named `ton-eglise-a-valenciennes`.

**Never:** No `/api` route, no tokens, fonts, layout, facts or content collections (stories 1.3–1.8). No secret, API token or `wp-config.php` value in a tracked file. No change under `web/www/`; its removal ships in its own pull request. No deploy or `wrangler` command that talks to the Cloudflare account; only local builds and `--dry-run`.

## I/O & Edge-Case Matrix

| Scenario | Input / State | Expected Output / Behavior | Error Handling |
|----------|--------------|---------------------------|----------------|
| Production build | `WORKERS_CI_BRANCH=main` | `robots.txt` allows all; `_headers` has no `X-Robots-Tag` | No error expected |
| Preprod build | `WORKERS_CI_BRANCH=preprod` | `robots.txt` = `User-agent: *` / `Disallow: /`; `_headers` sets `/*` → `X-Robots-Tag: noindex` | No error expected |
| Local build | variable unset | same as preprod | No error expected |
| Branch name close to main | `WORKERS_CI_BRANCH=main-fix` | non-production output | No error expected |

</frozen-after-approval>

## Code Map

- `web/` -- holds only the WordPress copy `web/www/` and its `web/.gitignore`; this story adds the new site beside them. Layout per architecture Structural Seed, rooted at `web/` instead of `web/`.
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

## Plan Change Log

- 2026-11-10, owner: the new site lives directly in `web/` instead of `site/`; `web/www/` is archived outside the repository and removed in a separate pull request. Paths in the frozen section and tasks renamed accordingly; the Never rule now protects only `web/www/`. The architecture and AGENTS.md are updated in the removal pull request.

## Review Triage Log

## Design Notes

Branch, not hostname, decides the environment because static assets are served before any Worker code; this matches AD-10. The `_headers` and `robots.txt` go into the directory Astro returns from `astro:build:done` — check where the adapter puts static files (likely `dist/client/`) and that the generated Wrangler config keeps the `previews` block; if it drops it, record that in Implementation Notes and find the supported way.

## Verification

**Commands:**
- `cd site && npm ci && npm run build` -- expected: success, `index.html` in the static output.
- `WORKERS_CI_BRANCH=main npm run build` then `WORKERS_CI_BRANCH=preprod npm run build`, inspecting `robots.txt` and `_headers` each time -- expected: matrix rows.
- `npx wrangler deploy --dry-run` -- expected: valid config, assets listed.
- `npx astro check` -- expected: no errors.

**Manual checks (if no CLI):**
- Owner, after merging: preview link, `curl -I` on it for `X-Robots-Tag`, production workers.dev address unreachable.
