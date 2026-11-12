<!-- bmad:context -->
<!-- Verified 2026-10-12 against 4ab2564. Managed by bmad-project-context; edits inside this block are replaced on refresh. Keep anything you want preserved outside the markers. -->

## ton-eglise-a-valenciennes

Website of a church in Valenciennes. The live site is WordPress 6.9 (purchased Nazareth theme, `nazareth-child` child theme, 12 plugins) on OVH. Since 2026-10-24 it is being replaced by a new site: same pages and texts with a modernised look, built with Astro as a pre-built static site with a few small functions, hosted on the owner's Cloudflare account; domains and e-mail stay at OVH. The project description is `_bmad-output/initiative-site-improvement/spec-site-improvement/spec-site-improvement.md`, its architecture `_bmad-output/initiative-site-improvement/architecture-new-site/architecture-new-site.md`. The design system and validated mockups live in `design/`, the 2026-10-12 review reports in `reviews/`.

## Policy

- Talk to the user in French, in plain everyday language with no technical terms; explain an unavoidable technical notion in simple words.
- Write in English every file and everything sent to git and GitHub: code, comments, documents, commit messages, branch names, pull requests. One exception: setup and operations documents addressed to the owner (such as `web/ops/cloudflare-settings.md`) are written in French, in plain language; Cloudflare menu and field names stay as they appear in the dashboard.
- Before producing anything, ask framing questions, 3 at most at a time; ask again when the direction becomes unclear.
- Never commit or push to `develop`, `preprod` or `main`. Branch from `develop`, commit there, push, and open a pull request to `develop`.
- Never open a pull request to `preprod` or `main` unless the user asks: `preprod` only receives `develop`, `main` only receives `preprod`. Never merge either one; the user merges by hand.
- Never deploy. Until the switch to Cloudflare, the user uploads `main` to the OVH server by hand with FileZilla, so merging to `main` puts nothing online. Once the new site is connected to Cloudflare, merging to `main` publishes production: treat every PR towards `main` as a release.
- The new site lives directly in `web/`. Follow `design/DESIGN.md` and the validated mockups; where they contradict the architecture, the architecture wins.
- Never copy values from the WordPress `wp-config.php` into a tracked file or a reply; it holds credentials.

## Where things are

- New site: `web/`, layout per the architecture's Structural Seed.
- The WordPress copy was removed from the repository on 2026-11-10. Its files are in git history before that date; the files git never tracked (`wp-config.php`, media library, plugin backups, cache) are archived outside the repository in `../ton-eglise-a-valenciennes-archive/web/www/`.

## Running and verifying

- There is no build, test suite or CI. Do not invent a command; say plainly that a change was not executed.
- A local copy of the site lives outside this repository, in `../ton-eglise-a-valenciennes-local/www`. Start it with `sudo service mariadb start` (the user types the password), then `php -S localhost:8080 -t ../ton-eglise-a-valenciennes-local/www`, and open http://localhost:8080.
- Never start a server on the archived WordPress files: their `wp-config.php` points at the production database.
- The local copy is not production. Its content is the backup of 18 March 2026, it runs on PHP 8.3 with one line patched in the `trx_addons` plugin so the home page renders, and `wp-fastest-cache` and WP-Cron are switched off. Do not submit its forms; they may still reach the real third-party services.
- Review the live production site at https://tonegliseavalenciennes.fr/, not only this checkout or the local copy: the current database, media library and server rules are not in the repository, so up-to-date content and settings are only visible online.

<!-- /bmad:context -->
