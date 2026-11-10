# Cloudflare settings outside the repository

Settings that exist only in the Cloudflare dashboard, recorded by name (AD-2).
Never write a secret, token or key value here (AD-14). The owner changes these
settings and updates this file through a pull request.

## Workers Builds connection

Worker: `ton-eglise-a-valenciennes` (Workers & Pages > the Worker > Settings > Builds).

| Setting | Value |
| --- | --- |
| Git repository | `petit-crabe/ton-eglise-a-valenciennes` |
| Root directory | `web` |
| Production branch | `main` |
| Build command | `npm run build` |
| Deploy command (production branch) | `npx wrangler deploy` |
| Non-production branch deploy command | `npx wrangler preview` |
| Builds for non-production branches | on, for `preprod` only (branch include filter: `preprod`) |
| Node version | read from `web/.nvmrc` |

The build reads `WORKERS_CI_BRANCH`, set by Workers Builds, to decide whether it
is production (`main` only) and writes `robots.txt` and `_headers` accordingly
(AD-10). No build variable is needed for this.

`npx wrangler preview` names the Preview after the branch, so the preprod link is
`preprod-ton-eglise-a-valenciennes.<account subdomain>.workers.dev`, public to
anyone with the link.

## Domains and routes

| Setting | Value |
| --- | --- |
| workers.dev route of production | off (`workers_dev: false` in `wrangler.jsonc`) |
| Preview URLs | on (`preview_urls: true` in `wrangler.jsonc`) |

## Web Analytics

| Setting | Value |
| --- | --- |
| Automatic injection of the Web Analytics beacon | off (the beacon is added by hand, AD-7) |

## Change record

| Date | Who | What |
| --- | --- | --- |
| _to fill by the owner_ | _to fill by the owner_ | Workers Builds connected with the settings above |
