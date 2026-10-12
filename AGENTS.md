<!-- bmad:context -->
<!-- Verified 2026-10-12 against 4ab2564. Managed by bmad-project-context; edits inside this block are replaced on refresh. Keep anything you want preserved outside the markers. -->

## ton-eglise-a-valenciennes

Website of a church in Valenciennes: an existing WordPress 6.9 site (purchased Nazareth theme, `nazareth-child` child theme, 12 plugins) that is due for a complete redesign. The current phase is in-depth reviews of the production site: security, UX, UI, content, accessibility. Planning documents live in `specs/`, the design system and mockups in `design/`, review reports in `reviews/`.

## Policy

- Talk to the user in French, in plain everyday language with no technical terms; explain an unavoidable technical notion in simple words.
- Write in English every file and everything sent to git and GitHub: code, comments, documents, commit messages, branch names, pull requests.
- Before producing anything, ask framing questions, 3 at most at a time; ask again when the direction becomes unclear.
- Never commit or push to `develop`, `preprod` or `main`. Branch from `develop`, commit there, push, and open a pull request to `develop`.
- Never open a pull request to `preprod` or `main` unless the user asks: `preprod` only receives `develop`, `main` only receives `preprod`. Never merge either one; the user merges by hand.
- Never deploy. The user uploads `main` to the OVH server by hand with FileZilla, so merging to `main` puts nothing online.
- During the review phase, never change the site under `web/`. Write findings and proposed changes in `reviews/`; the user decides what gets applied.
- Keep WordPress: do not replace or remove it until the user starts the redesign.
- Never copy values from `web/www/wp-config.php` into a tracked file or a reply; it holds credentials and is git-ignored on purpose.

## Where things are

- WordPress root: `web/www/`. The only custom code is `web/www/wp-content/themes/nazareth-child/`.
- Skip `wp-admin/`, `wp-includes/`, `wp-content/plugins/` and `wp-content/themes/nazareth/` in searches unless the task is about them; they are third-party code and about 13,400 of the 14,009 tracked files.

## Running and verifying

- There is no build, test suite or CI. Do not invent a command; say plainly that a change was not executed.
- A local copy of the site lives outside this repository, in `../ton-eglise-a-valenciennes-local/www`. Start it with `sudo service mariadb start` (the user types the password), then `php -S localhost:8080 -t ../ton-eglise-a-valenciennes-local/www`, and open http://localhost:8080.
- Never start a server on `web/www` itself: its `wp-config.php` points at the production database.
- The local copy is not production. Its content is the backup of 18 March 2026, it runs on PHP 8.3 with one line patched in the `trx_addons` plugin so the home page renders, and `wp-fastest-cache` and WP-Cron are switched off. Do not submit its forms; they may still reach the real third-party services.
- Review the live production site at https://tonegliseavalenciennes.fr/, not only this checkout or the local copy: the current database, media library and server rules are not in the repository, so up-to-date content and settings are only visible online.

<!-- /bmad:context -->
