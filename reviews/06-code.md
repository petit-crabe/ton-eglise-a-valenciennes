# Code review

Date: 2026-10-12 · Target: the custom code of the site and the way the site is assembled · Purpose: what is worth correcting on the current site. Redesign advice is out of scope here.

## Method and limits

- **Custom code read in full**: `nazareth-child/functions.php` (51 lines) and `nazareth-child/style.css` (228 lines). These two files are the only code written for the church in the child theme.
- **Three independent reviewers** read the same two files without seeing each other's notes or this report's draft; their findings were checked one by one and are merged below. Rejected ones are listed at the end with the reason.
- **Assembly**: targeted reading of the purchased theme (`nazareth` 1.0.5) and of `trx_addons` where the custom code depends on them, a search of the purchased theme for hand edits, the non-secret switches of `wp-config.php`, and the ignore rules.
- **Checked while running**: the local copy (March 2026 content, PHP 8.3) for the home, contact and events pages; production with three ordinary visitor requests (home page, the parent stylesheet, the child `functions.php` address) and one on a leftover file name.
- **Not done**: no event exists in the local copy, so the single-event template (C3, C5) was read but never seen rendered. Mobile menu behaviour between 480 and 767 px (C6) was read from the stylesheets, not viewed in a browser. Third-party plugins were not reviewed line by line; their versions and known weaknesses are in [01-security.md](01-security.md) S3. Nothing under `web/` was changed.

## Answer to the open note in the UI review

[03-ui.md](03-ui.md) asked whether the 228 lines of `nazareth-child/style.css` are live or dead. **They are live.** The parent theme loads the child stylesheet by itself (`nazareth/functions.php:363-371`, handle `nazareth-child`), and both the local copy and production serve it. The comment in the child `functions.php` that says otherwise is wrong (C2). The file is a reliable record of the current overrides.

## Findings

| # | Priority | Finding | Verified |
|---|----------|---------|----------|
| C1 | Medium | The parent stylesheet is downloaded twice on every page | Production and local |
| C2 | Medium | Comments in `functions.php` contradict the code and would mislead the next change | Code |
| C3 | Medium | Share buttons were hand-written into the purchased theme, with an unescaped address | Code only |
| C4 | Medium | Text added by the child stylesheet fails contrast, measured | Computed |
| C5 | Low | The "Home" translation filter is wider than needed; one function has no prefix | Code and local |
| C6 | Low | Mobile menu overrides stop at 479 px while the mobile menu runs to 767 px | Code only |
| C7 | Low | Leftovers in the child theme: dead rules, duplicate translation folder, no version on the stylesheet | Code |
| C8 | Info | Nothing checks the site automatically | — |
| C9 | Info | PHP 8.3 already raises warnings in three plugins | Local |

### C1 — Parent stylesheet loaded twice

`nazareth-child/functions.php:24-27` enqueues `nazareth/style.css` under the handle `nazareth-style`. The parent theme already enqueues the same file as `nazareth-main` (`nazareth/functions.php`, priority 1000). The two addresses differ only by a `?ver=6.9.10` suffix, so the browser treats them as two files.

Production home page, 2026-10-12: both `nazareth-style-css` and `nazareth-main-css` are present. The file is 285 kB, about 43 kB once compressed, fetched and parsed twice by every first-time visitor. WP Fastest Cache does not merge them.

Proposed change: delete `nazareth_child_scripts()` and its `add_action` line. Nothing visible changes, because `nazareth-main` stays and the child stylesheet depends on it. Check the home page and one inner page on the local copy afterwards, then clear the page cache on production.

### C2 — Comments that no longer describe the site

- `functions.php:20-22` states "no CSS overrides exist in the child theme" and advises enqueueing the child stylesheet "if overrides are added later". There are 228 lines of overrides, already loaded by the parent. Following the advice would load the child stylesheet twice as well. This comment is what raised the question in the UI review.
- `functions.php:13` and `:32` justify the breadcrumb filter by "ThemeREX Addons 1.6.22". The installed version is 1.6.52.2. The reasoning still holds: no `trx_addons_filter_breadcrumbs` hook exists in the installed plugin.
- The file header is a change log by "Session 10". The label means nothing outside the conversation that produced it; git history is the place for it. The one fact worth keeping is that Google Analytics must stay under Complianz, and that is true today: production serves the tag as `type="text/plain" data-category="statistics"`.

Proposed change: rewrite the header and the two docblocks to say what is true now, in the same edit as C1.

### C3 — Share buttons edited into the purchased theme

`nazareth/tribe-events/single-event.php:78-83` holds a block that is not part of the vendor's theme: a French heading and two links, "Partager sur Facebook" and "Partager sur Whatsapp". The child stylesheet styles them (`.facebook-share-btn`, `.whatsapp-share-btn`). It is the only hand edit found in the purchased theme.

- **It will be lost** if the theme is ever reinstalled or updated, and nothing records that it exists.
- **The page address is printed without escaping**, into an `href` and into the query of two third-party links: `'...sharer.php?u=' .$current_url. '"'`. The value comes from `$wp->request`, which is the path part of the address, on a template that only renders for an existing event, so no working attack was demonstrated. It is still the standard mistake `esc_url()` and `rawurlencode()` exist for, and an address with an accent or a space yields a broken share link.
- It uses `<center>` and an inline style, and the links open a new tab without `rel="noopener"`.

Proposed change: copy the template to `nazareth-child/tribe-events/single-event.php`, restore the vendor's version in the parent, and write the block with `esc_url()` around each full link and `rawurlencode()` around the shared address. Needs one test event on the local copy to see it render. If The Events Calendar is not in use (open question in the README), remove the block instead.

### C4 — Contrast of text styled by the child theme

Measured from the colours in `style.css` (WCAG 2.1 needs 4.5:1 for normal text). This puts numbers on A5 in [05-accessibility.md](05-accessibility.md) and V2 in [03-ui.md](03-ui.md).

| Where | Colours | Ratio |
|-------|---------|-------|
| Footer credit links (`style.css:84-86`) | `#ffbd11` on white | 1.67:1 |
| WhatsApp share button (`:135-143`) | white on `#25d366` | 1.98:1 |
| Event date badge, set at 10 px (`:151-157`) | white on `#ff9000` | 2.27:1 |
| Mobile menu current item (`:70-72`) | `#f26837` on white | 3.08:1 |
| Facebook share button | white on `#3b5998` | 6.84:1, passes |

The footer links are also underlined only on hover, so colour is their only cue. Every interactive state in the file is `:hover`; none has a `:focus` counterpart (see A10).

Proposed change: the footer link colour is one line and is visible on every page; a dark blue from the logo with a permanent underline fixes it. The others matter only if events come back.

### C5 — "Home" to "Accueil" filter

The filter works: inner pages of the local copy show "Accueil" in the breadcrumb.

- Of its three text domains, only `trx_addons` needs it. `nazareth` already gets "Accueil" from the theme's own French file, and `nazareth-child` is never loaded by anything.
- It replaces every "Home" of those domains, not only the breadcrumb one. On a French site that is harmless.
- `translate_home_to_accueil` has no theme prefix, unlike `nazareth_child_scripts`.

Proposed change, only when the file is next edited: keep `trx_addons` alone in the list and rename the function `nazareth_child_translate_home`.

### C6 — Mobile menu overrides stop at 479 px

`style.css:54-73` sets the mobile menu's link size, case and weight, and the orange colour of the current page, inside `max-width: 479px`. The theme switches to the mobile menu below 768 px (`mobile_layout_width => 767`). The rules that turn the menu white with dark text sit outside the query and apply at every width. Read from the code: between 480 and 767 px (large phones in landscape, small tablets) the menu keeps the white background but loses the current-page highlight and falls back to the vendor's uppercase sizing.

Proposed change: widen the query to `max-width: 767px` after viewing it at 600 px on the local copy.

### C7 — Leftovers in the child theme

- `style.css:197-199`: an "AUDIO PLAYER" heading over an empty rule.
- `style.css:202-212`: `margin` declared twice in one rule; the first is dead.
- `.facebook-share-btn` and `.whatsapp-share-btn` repeat seven declarations each.
- 29 `!important` declarations. Most are forced by the parent's own specificity; they are a cost of the theme, not an error to chase.
- `nazareth-child/languages/` is a byte-for-byte copy of `nazareth/languages/` (19 translated strings out of about 900). The theme loads the parent's copy; an edit to the child's copy would do nothing.
- The child stylesheet is served with no version in its address. After any edit, returning visitors keep the old file until their browser cache expires. Any change proposed in this report should raise `Version:` in the header and be followed by a cache clear in WP Fastest Cache.

### C8 — No automatic check

There is no test, build or CI in the repository. The only safeguard for the one behavioural function (C5) is a person looking at a breadcrumb. For a 51-line file on a frozen site, a test harness is not worth building. The practical rule: after any edit to the child theme, open the home page and one inner page on the local copy before uploading.

### C9 — PHP 8.3 warnings on the local copy

Loading a few pages of the local copy on PHP 8.3 logged warnings in `tube-video-curator` (undefined property, three places), `complianz-gdpr` (one) and `trx_addons` (the line already patched locally still warns). Production runs PHP 7.4 and does not show them. This is first-hand evidence for S2 in the security review: moving production to PHP 8 is not a switch to flip; the sermon import plugin is among the code that reacts.

## What is already right

- The child theme's PHP has no database access, no form handling and no output of visitor input.
- Google Analytics waits for consent on production.
- `wp-config.php` has `WP_DEBUG` off and the admin file editor disabled; it is correctly kept out of git, as are `.htaccess`, uploads, caches and backups.
- Requesting the child `functions.php` directly on production returns an empty error page with no server path.
- `/.htaccess.bk` is refused (403) on production.
- Apart from C3, no hand edit was found in the purchased theme.

## Suggested order

1. C1 and C2 together: one small edit to `functions.php`, tested on the local copy.
2. C4, footer link colour only: one line of `style.css`, with the version raised (C7).
3. C3 once the church says whether events are used.
4. C5, C6, C7 only if the files are opened for another reason.

## Reviewer findings not kept

| Claim | Why it was rejected |
|-------|---------------------|
| Audience measurement may be gone since the analytics block was removed | False: the tag is on production, held until consent. |
| Add an `ABSPATH` guard; direct access could reveal the server path | False here: production answers 500 with an empty body. |
| White breadcrumb text unreadable on a page with no banner image | Not reachable: every inner page uses the banner (V6). |
| Sub-menu offset `top: 5em` breaks if the header height changes | Not shown to happen on the current header. |
| The event map is hidden by CSS and may still call Google | Not settled: no Maps request on the events list; a single event could not be rendered. Low stakes, to look at with C3. |
| The filter also changes "Home" in the admin | True but harmless on a French-only site; a guard would add code for no gain. |
| The filter runs on every translated string | Negligible cost. |
