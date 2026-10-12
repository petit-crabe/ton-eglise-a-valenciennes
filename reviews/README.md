# Site review — October 2026

Full review of https://tonegliseavalenciennes.fr/ before the redesign, carried out on 2026-10-12. Nothing under `web/` was changed; every item below is a finding or a proposal for the owner to decide on.

| Report | Scope |
|--------|-------|
| [01-security.md](01-security.md) | Server exposure, outdated components, accounts, personal data |
| [02-ux.md](02-ux.md) | Visitor paths, navigation, forms, sermons, practical information |
| [03-ui.md](03-ui.md) | Visual design, with screenshots in `screenshots/` |
| [04-content.md](04-content.md) | Page inventory, accuracy, legal pages, voice, search engines |
| [05-accessibility.md](05-accessibility.md) | First-pass WCAG 2.1 AA check |

## How it was done

Production was visited as an ordinary visitor: one request per public page (35 pages), single requests on well-known WordPress addresses, screenshots at desktop and phone width with cookies refused. The tracked code and the local copy of the server files were read. No form was submitted, no login attempted, no file downloaded from the backup folder, no scanner run. Each report lists what it could not cover.

## Do now, on the live site

These do not wait for the redesign.

1. **Five full-site backups were downloadable from the public backup folder.** They were deleted on 2026-10-12 and no longer answer. Twelve months of OVH logs show no download by a third party; earlier logs no longer exist. Still to do, from security S1: change the database password and secret keys, reset account passwords.
2. **Unpublish the two filler-text pages** (`/decouvrir-la-foi/`, `/la-technique/`).
3. **Fix the "Je suis nouveau" button** on the home page, which leads to a 404: point it to the contact page or remove it until a newcomer page exists.
4. **Settle and correct the practical facts everywhere**: Sunday time (10h00 or 09h30), postcode (59300, not 59000), street spelling, the single contact e-mail, the current pastor on "Notre histoire".
5. **Turn off directory listing** on the media library.
6. **Hide the empty events block** on the home page, or fill it.
7. **Delete server leftovers**: 2020 database dumps, backup logs, test files, `readme.html`.

## Do soon

8. Publish a legal notice and a real privacy policy; retire the generated "Conditions générales".
9. Stop publishing as `admin`; add two-factor login for administrators.
10. Add basic security headers and stop advertising versions.
11. Remove unused or abandoned plugins after confirming their state in the admin.
12. Allow zoom on phones (one attribute in the theme).

## Carry into the redesign

- **The platform is the root cause.** PHP 7.4, Elementor 3.1.1, Essential Grid 2.3.6 and the 2019 theme with its bundled add-on cannot be brought up to date piece by piece without breaking the site. Most accessibility defects and half the UI defects come from the same stack.
- **Design for the newcomer first**: a first screen with who, when and where; a "first visit" page; a map and tappable phone number.
- **One source of truth** for address, times and contacts.
- **A real sermon library**: speaker, series and date as fields, a text summary, a fallback link when the video embed is blocked.
- **Accessibility in the definition of done** of every new template.
- **Keep** the logo, the real photographs, the pastoral welcome, the history, the department texts and the 303 sermons.

## Open questions for the church

- Which Sunday time and which contact e-mail are correct?
- Is The Events Calendar in use? Who would maintain events?
- Who set up the automatic YouTube import of sermons (Tube Video Curator), and does anyone still have its settings?
- Is there written image-rights consent for the photographs, especially of children?
- What happens today to a prayer request or interview request after it is sent, and how long is it kept?