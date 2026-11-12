---
title: 'Branch protection and agent instructions'
type: 'chore'
ticket: '2'
created: '2026-11-12'
status: 'built'
baseline_revision: 'a5534023ca9e5ad4e88308f2a69ab0cb618c6b25'
route: 'oneshot'
route_source: 'auto'
risk: 'low'
review: 'quick'
review_source: 'pinned'
lenses_ran: ['quick']
review_loop_iteration: 0
context:
  - '{project-root}/_bmad-output/initiative-site-improvement/architecture-new-site/architecture-new-site.md'
---

<frozen-after-approval reason="human-owned intent — do not modify unless human renegotiates">

## Intent

**Problem:** `develop`, `preprod` and `main` are unprotected on GitHub (checked 2026-11-12: no ruleset, `protected: false` on all three), so a direct push could change preprod or production without a PR, against AD-2 and CAP-19. `AGENTS.md` still describes the WordPress era: it says there is no build, that `main` is uploaded to OVH with FileZilla, and it says nothing about running `web/`, preprod being the prototype, or merging to `main` publishing through Workers Builds.

**Approach:** Give the owner French step-by-step instructions to protect the three branches with one GitHub ruleset (PR required, no direct push, no force push, no deletion, no bypass so the owner is refused too), and record the applied settings, names only, in the repository. Rewrite the affected parts of `AGENTS.md`: the commands that run, build and check `web/` on Node 26, preprod as the link-only prototype, and merging to `main` building the production Worker that goes live on the domain only at the switch-over.

**Decisions (owner, 2026-11-12):** The owner applies the ruleset by hand in GitHub, following the instructions; the agent does not change GitHub settings. The instructions and the record of the applied settings live in a new French owner document `web/ops/github-settings.md`, beside `cloudflare-settings.md`. `AGENTS.md` drops the FileZilla upload: the live WordPress site on OVH is no longer touched from this repository.

</frozen-after-approval>

## Implementation Notes

Oneshot route: two documentation files and one GitHub setting, about 80 lines, no code.

Facts checked: repository `petit-crabe/ton-eglise-a-valenciennes` is public and owned by a personal account, so rulesets are available on the free plan; the local `gh` login has admin rights on it. `web/package.json` scripts: `dev`, `build`, `preview`, `check`; `web/.nvmrc` = `26`. Workers Builds settings are in `web/ops/cloudflare-settings.md`; preprod link `preprod-ton-eglise-a-valenciennes.contact-floriandesmet.workers.dev`.

- Files: new `web/ops/github-settings.md` (French owner guide: one branch ruleset `protect-develop-preprod-main`, Active, empty bypass list, targets `develop`/`preprod`/`main`, Restrict deletions, Block force pushes, Require a pull request with 0 approvals; safe check through GitHub's web editor, which must refuse to commit on `preprod`; history row left for the owner). `AGENTS.md`: deploy rule rewritten (Workers Builds, preprod preview link, main without public address until the switch, no account-facing `wrangler`), new branch-protection rule, `web/ops/` named for both owner documents, run/build/check commands, FileZilla removed.
- 0 approvals because GitHub never lets an author approve their own PR and the owner is the only reviewer; no bypass so the owner's own direct push is refused too (the story's verify). Linear history and status checks left off: merges use merge commits, and Workers Builds checks are not required yet.
- Edits stay inside the `bmad:context` block, as earlier stories did; its "Verified" line was not changed since `bmad-project-context` was not run.
- Ran on Node 26.13.0 from `web/`: `npm ci`, `npm run build` (robots disallow all), `npm run check` (0 errors), `npx wrangler deploy --dry-run` (valid), `WORKERS_CI_BRANCH=main npm run build` (robots allow all). 2026-11-12: the owner applied the ruleset and the direct-commit check on `preprod` was refused; `gh api …/rulesets` shows `protect-develop-preprod-main` active, empty bypass list, the three branches, rules deletion, non_fast_forward and pull_request (0 approvals). github-settings.md updated to the applied state.

## Review Triage Log

| # | Finding | Verdict | Route | Evidence |
|---|---------|---------|-------|----------|
| 1 | AGENTS.md states the branches are already protected; no ruleset exists yet | medium | patch | `gh api …/rulesets` returned `[]` on 2026-11-12; reworded as a rule pointing to the owner's ruleset. |
| 2 | github-settings.md titles the table "Réglage appliqué" before it is applied | low | patch | Renamed "Réglage attendu"; the history row stays for the owner to fill, as cloudflare-settings.md did. |
| 3 | AGENTS.md says the production Worker has no public address | medium | patch | `preview_urls: true` gives each production version a noindex `<version>-…workers.dev` link (wrangler.jsonc, edge-files.mjs); reworded. |
| 4 | French exception widened to every file in `web/ops/` | low | patch | AD-9 puts `web/ops/url-inventory.csv` there; restored the narrow wording, naming both owner documents. |
| 5 | Failed check sends the owner only to step 3 | low | patch | Targets and rules are steps 4–5; now points to steps 3 to 5. |
| 6 | Edits sit inside the `bmad:context` block, which a refresh replaces; its "Verified" line is stale | low | defer | Fix edits AGENTS.md; earlier stories edited inside the block the same way. |

## Verification

**Commands:**
- `cd web && nvm use && npm ci && npm run build && npm run check` (the commands AGENTS.md gives) -- expected: success.
- `gh api repos/petit-crabe/ton-eglise-a-valenciennes/rulesets` after the owner applies it -- expected: one active ruleset targeting the three branches.

**Manual checks (if no CLI):**
- Owner: a direct push to `preprod` is refused by GitHub.
