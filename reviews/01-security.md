# Security review

Date: 2026-10-12 · Target: https://tonegliseavalenciennes.fr/ (production) and this checkout.

## Method and limits

- Read the tracked code and the local copy of the server files (`web/www`).
- Visited production as an ordinary visitor: one GET per public page, plus single GET/HEAD requests on well-known WordPress addresses. Nothing was downloaded from the backup folder (headers only), no form was submitted, no login was attempted, no scanner was run.
- Not covered: the WordPress admin, the database, the OVH control panel, server logs, user passwords and roles, e-mail configuration, brute-force protection on the login page. These need admin access.
- `wp-config.php` was only checked for the presence and on/off state of non-secret settings. No value from it appears here.

## Summary

| # | Severity | Finding |
|---|----------|---------|
| S1 | **Critical** | Five full-site backups are downloadable from the public web |
| S2 | High | Production runs PHP 7.4, unsupported since November 2022 |
| S3 | High | Several plugins and the theme are years out of date, with published vulnerabilities |
| S4 | Medium | Directory listing is open on the media library |
| S5 | Medium | Account names are public, and one is `admin` |
| S6 | Medium | Login page is exposed with no visible extra protection |
| S7 | Medium | No security headers; software versions are advertised |
| S8 | Medium | Forms collect sensitive personal data with no visible anti-spam and no real privacy policy |
| S9 | Low | Leftovers on the server: old database dumps, logs, test files, sample files |
| S10 | Low | The page index (sitemap) publishes internal templates and author pages |
| S11 | Low | Abandoned or unused plugins are still installed |

## S1 — Public full-site backups (critical)

**Status, 2026-10-12, later the same day: the owner deleted the archives. All five addresses now return `404`. Steps 2 to 5 below remain open.**

At the time of the review, `wp-content/ai1wm-backups/` on production held five All-in-One WP Migration archives (`.wpress`), dated December 2023 (two) and March 2026 (three), 520 MB to 1.1 GB each. A HEAD request on each exact file name returns `200`, `application/octet-stream` and the full `Content-Length`. A made-up name returns `404`, so the responses are real.

The folder's own `.htaccess` only disables the file listing; it does not deny access. The only barrier is the six random characters at the end of each file name. File names are deliberately not written in this report.

Each archive contains the database (user accounts with password hashes, form submissions, newsletter data, any personal-data export) and the site files, including `wp-config.php` with the database credentials and the secret keys.

Whether anyone has downloaded them is unknown. The OVH access logs can answer that: search for requests to `/wp-content/ai1wm-backups/` ending in `.wpress`.

Proposed actions, in order:

1. ~~Copy the archives off the server if they are still wanted, then delete them from the server.~~ Done.
2. Check the OVH access logs for past downloads.
3. Whatever the logs say, change the database password, regenerate the secret keys in `wp-config.php`, and reset the passwords of all WordPress accounts. The archives have been reachable for up to three years.
4. If the logs show a download by a third party, this is a personal-data breach: the church, as data controller, has 72 hours to assess notifying the CNIL.
5. Stop storing backups under the web root. Remove All-in-One WP Migration once the redesign no longer needs it (see S11).

## S2 — PHP 7.4

Production answers with `X-Powered-By: PHP/7.4`. PHP 7.4 has had no security fixes since 28 November 2022. The local copy needed a one-line patch in `trx_addons` to render on PHP 8.3, so the current theme stack is what holds the site on 7.4. This is a strong argument for the redesign rather than a quick switch: raising PHP on OVH today would likely break the home page.

## S3 — Outdated components

Versions read from the checkout and confirmed in production page source where the version is printed.

| Component | Installed | Notes |
|-----------|-----------|-------|
| WordPress core | 6.9.10 | Recent branch. Confirm automatic minor updates are on. |
| Elementor | 3.1.1 (early 2021, "tested up to WP 5.6") | Every page is built with it. Many fixes since, mostly needing a logged-in account: file upload fixed in 3.18.2 (CVE-2023-48777), missing permission checks fixed in 3.13.2, critical fix in 3.6.3. |
| Essential Grid | 2.3.6 | Below 3.1.2, the fix for CVE-2024-3235 (visitors without an account can read private and password-protected posts through the public `Essential_Grid_Front_request_ajax` action, which this copy registers). Also below 3.0.19 (CVE-2023-47771, needs an account). |
| ThemeREX Addons (`trx_addons`) | 1.6.52.2 | Bundled with the theme, only updatable through the theme vendor. Recent critical advisories (unauthenticated file upload CVE-2026-1969 fixed in 2.38.5; object injection CVE-2026-62105 reported fixed in 2.45.0) target the 2.x line. The upload function named in the advisory is not present in this 1.6 copy, so exposure to those two is **not confirmed**. The 2020 takeover flaw (CVE-2020-10257) used a REST route that production does not expose. The copy does register public login and registration actions (`trx_addons_login_user`, `trx_addons_registration_user`) and uses `unserialize()` in nine files; these deserve a proper code audit if the plugin stays. |
| Nazareth theme | 1.0.5 | Purchased theme, no update channel visible in the code. |
| Tube Video Curator | 1.1.9 ("tested up to WP 5.2.2") | Abandoned since 2019. |
| Contact Form 7 6.1.5, Complianz 7.5.5, MC4WP 4.12.0, The Events Calendar 6.15.17.1, UpdraftPlus 1.26.2, WP Fastest Cache 1.4.6, AIO WP Migration 7.103 | recent | Check each against the current release in the admin. |

`DISALLOW_FILE_MODS` is off, so updates from the admin are possible. Elementor is the blocker: jumping five years of versions under a 2019 theme is a migration, not an update.

Proposed action: do not attempt a big-bang update of Elementor/Essential Grid/trx_addons on the live site. Treat them as the reason for the redesign, and reduce exposure meanwhile (S1, S4–S7, and removing what is unused, S11). Before any update, test on the local copy.

## S4 — Open directory listing

`/wp-content/uploads/` and its year/month subfolders return an Apache index page. Anyone can browse every uploaded file, including documents never linked from a page. The library contains at least the bank details PDF linked from the donation page and a `wp-personal-data-exports/` folder (empty index today).

Proposed action: add `Options -Indexes` to the root `.htaccess`. Then review the library for files that should not be public.

## S5 — Public account names

- `/wp-json/wp/v2/users` lists two accounts: `admin` and `fdesmet` (with display name).
- `/?author=1` redirects to `/author/admin/`.
- `/wp-sitemap-users-1.xml` lists both author pages.
- All sermons are published by `admin`, so the name is on every author archive.

An account literally named `admin` is the first name any password-guessing robot tries.

Proposed actions: publish under a dedicated editor-role account, not an administrator; rename or replace the `admin` account; hide the users endpoint and author archives for anonymous visitors; drop users from the sitemap.

## S6 — Login page

`/wp-login.php` answers normally and `/wp-admin/` redirects to it. No CAPTCHA, no renamed address, no visible lockout plugin in the installed list (traces of WP Defender and All-In-One WP Security exist on disk but neither plugin is installed any more). Lockout behaviour was not tested.

Good point: public registration is disabled.

Correction after reading one day of server logs (see "Evidence from the access log" below): `xmlrpc.php` answers `405` to a GET, which is normal, but it accepts POST requests. That route for mass password guessing is **open**.

Proposed actions: two-factor authentication for administrators, login attempt limiting, block `xmlrpc.php` unless something needs it, and confirm that every administrator account is still needed.

## S7 — Headers and version disclosure

Production sends none of: `Strict-Transport-Security`, `Content-Security-Policy`, `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy`.

It does send `X-Powered-By: PHP/7.4`, and pages carry `<meta name="generator" content="WordPress 6.9.10">` plus `?ver=` on plugin files (Elementor 3.1.1, Essential Grid 2.3.6, Contact Form 7 6.1.5). `/readme.html` and `/license.txt` are served. This hands an attacker the exact shopping list in S3.

Good points: HTTP and `www` both redirect to HTTPS; the certificate (Let's Encrypt) is valid until 2 December 2026; `.htaccess.bk`, `debug.log`, `.git/` and `wp-includes/` listings return `403`.

Proposed actions: add the basic headers in `.htaccess` (HSTS, `nosniff`, `SAMEORIGIN`, a referrer policy), remove `X-Powered-By` and the generator tag, delete `readme.html`.

## S8 — Forms and personal data

Six public forms: contact, prayer request, interview request (name, e-mail, phone, subject, message), volunteering, newsletter (first name, last name, birthday, e-mail), search.

- Prayer and pastoral interview requests reveal religious belief and often health or family matters: special-category data under GDPR. They travel by e-mail and may be stored in the database, which is inside the archives of S1.
- No CAPTCHA or other anti-spam is visible in the Contact Form 7 forms, although the cookie policy declares Google reCAPTCHA. Only the newsletter form has a honeypot.
- The forms say "you accept our Privacy policy" but link to the cookie policy. There is no privacy policy and no legal notice page (see the content review).
- The newsletter consent text cites a French law number rather than saying in plain words what the data is used for, and asks for a birthday without saying why.

Proposed actions: decide what is stored and for how long; add spam protection that does not need a third-party cookie (honeypot plus time check); write a real privacy policy; drop the birthday field unless it has a use.

Good point: Google Analytics is correctly held back until consent (`type="text/plain"` under Complianz), and YouTube embeds are blocked until consent.

Less good: two Google Fonts stylesheets load from `fonts.googleapis.com` before any consent. German case law has treated this as a transfer of the visitor's IP address without legal basis; hosting the fonts locally removes the question.

## S9 — Leftovers on the server

- `wp-content/aiowps_backups/`: two database dumps from 2020 (`403` from the web, but still on disk).
- `wp-content/updraft/`: twelve backup logs.
- `wp-content/uploads/wp-defender/defender.log`, `uploads/wp-migrate-db/`.
- 24 empty `temp-write-test-*` files in `wp-content/`.
- `.htaccess.bk` at the root, `wp-config-sample.php` (returns a `500` error), `readme.html`, `license.txt`.
- `/wp-cron.php` is publicly callable (WordPress default).

Proposed action: delete all of them during the clean-up of S1.

## S10 — Sitemap exposure

`/wp-sitemap.xml` lists 64 Elementor templates (57 of them auto-generated "The Events Calendar starter" entries from March 2026), 9 theme layout parts (`/layouts/header-default/` renders as a public page titled "Header Default"), and the author pages. None of this should be indexed.

## S11 — Plugins to remove

Production's REST index shows no route for The Events Calendar or Tube Video Curator, which suggests they are inactive there; confirm in the admin. An inactive plugin can still be attacked through its files.

Candidates for removal after confirmation: Tube Video Curator (abandoned), The Events Calendar (if inactive; the events page is empty), All-in-One WP Migration (source of S1), one of the two backup tools, Complianz Terms & Conditions (generates an ill-fitting text, see the content review).

## Evidence from the access log

The owner supplied the OVH web access log for one day, 10 October 2026 (6,635 requests, all domains of the hosting). OVH keeps 14 months of logs; the other days have not been read yet, so nothing here clears the period before or after that day.

- **Backups**: no request to `ai1wm-backups` and no request for any `.wpress`, `.sql` or `.zip` file that day.
- **Password guessing is continuous**: 172 login attempts (`POST /wp-login.php`) from 124 different addresses, two or three each, spread evenly over the 24 hours. This is the signature of a botnet working around per-address limits. None was answered with the redirect that follows a successful login.
- **`xmlrpc.php`**: 33 POST requests from a single address, all answered `200`.
- **Account-name harvesting**: 32 requests to the users endpoint or `?author=`, plus probes for the member lists of plugins the site does not have.
- **Backdoor probing**: requests for a randomly named plugin file (`/wp-content/plugins/wp_…/wp_….php`), answered `404`. Robots check whether a known malicious plugin is installed; it is not.
- **Second domain**: `www.add-valenciennes.fr` reaches the same WordPress, and 105 of its 143 requests were for the login page. Decide whether that domain should serve the site at all.
- **No administrator session** appears in the log that day.
- For the UX review: seven requests hit the 404 at `/je-suis-nouveau/` that day, and several robots looked for `/mentions-legales`.

This turns S5 and S6 from theoretical to observed: the account names are being collected and the login page is under daily attack. Two-factor login and an attempt limiter are the answer; a strong password alone is the only protection today.

## What is already right

- `wp-config.php`, media, backups and caches are git-ignored; no credential is tracked.
- The database table prefix is not the default.
- Theme and plugin file editing from the admin is disabled.
- Public registration is off.
- HTTPS everywhere with a valid certificate.
- Analytics and video embeds wait for consent.
- The child theme's own code (`functions.php`, 50 lines) contains nothing risky.

## Sources for the vulnerability references

- https://www.wordfence.com/threat-intel/vulnerabilities/wordpress-plugins/essential-grid-2/essential-grid-311-unauthenticated-private-post-disclosure
- https://nvd.nist.gov/vuln/detail/CVE-2024-3235
- https://www.wiz.io/vulnerability-database/cve/cve-2023-47771
- https://www.csa.gov.sg/alerts-advisories/alerts/2023/al-2023-061
- https://wordfence.com/threat-intel/vulnerabilities/id/b66e2537-f187-4237-b248-f8a361f9cb00
- https://www.wordfence.com/threat-intel/vulnerabilities/wordpress-plugins/trx_addons
- https://opencve.alliance.unm.edu/cve/CVE-2026-1969
- https://www.sentinelone.com/vulnerability-database/cve-2026-62105/
