---
type: epic
title: "Site foundation and publishing path"
parent: initiative-site-improvement
covers: [CAP-19, CAP-10, CAP-9, CAP-3, CAP-5, CAP-7, CAP-8, CAP-11, CAP-13]
after: []
assignee: ""
risk: medium
---

# Site foundation and publishing path

## Description

The opening epic: the `web/` Astro project, its publishing path through Workers Builds, and everything every later page reads — tokens, practical facts, collection schemas, the base layout with header and footer, the shared components, the generated edge files, and the shared `/api` helper. It leaves a home page shell visible on preprod.

## Outcome

The owner merges a change and sees it on the preprod link without uploading anything; later epics only add pages and functions on this base.

## Done when

1. Merging to `preprod` updates a link-only preview that is `noindex` and disallows all robots; merging to `main` builds the production Worker (not yet on the domain); a direct push to `develop`, `preprod` or `main` is refused.
2. Every colour, type size, spacing and radius in the site's styles comes from `design/tokens.json`; the header, footer and shared components (button, page banner, breadcrumb, section links) match their mockups on desktop and phone and meet AD-13.
3. The practical facts are stored once in `facts.json` and the footer, structured data and contact links read them; phone, e-mail and address open the phone, mail and maps apps.
4. Every response of the preview carries the 01-S7 security headers and the base CSP, names no software version, and the sitemap lists only public pages.
5. A content file with an `iframe`, `script` or third-party `src`, or a menu link to a missing route, fails the build.
6. `web/ops/cloudflare-settings.md` names every dashboard-only setting made so far, and `AGENTS.md` says the new site's flow.

## Boundaries

Platform baseline. Not the content of the pages (epic-pages-and-content), not the domain (epic-switch-over). Includes the shared API helper and error-code list, but no `/api` route beyond a health check if one is needed to prove the path.

## References

- parent — _bmad-output/initiative-site-improvement/spec-site-improvement/spec-site-improvement.md, section Capabilities
- architecture — _bmad-output/initiative-site-improvement/architecture-new-site/architecture-new-site.md, AD-1, AD-2, AD-3, AD-4, AD-7, AD-10, AD-12, AD-13, AD-14, Consistency Conventions, Stack, Structural Seed
- design — design/DESIGN.md, design/tokens.json, design/maquettes/home/

## Notes

- Decision (2026-11-10): done when verified on preprod; production reaches the domain in epic-switch-over.
- Decision (2026-11-10): stories are built one at a time, interactively with bmad-build; the owner reviews each on preprod.
- Decision (2026-11-10): this epic builds only the components used on nearly every page (header, footer, button, page banner, breadcrumb, section links); every other component is built with the page that uses it.
- Decision (2026-11-10): menu targets get a "page en préparation" until epic-pages-and-content replaces them, so the menu-link check stays strict.
- Decision (2026-11-10): the events schema belongs to epic-events and the form-pages CSP block to epic-forms; this epic provides the base.
- Tracer bullet: story 1, the home page built by Workers Builds and visible on the preprod link.
- Open question: church name and contact e-mail to show (spec Open Questions); `facts.json` may carry a provisional value on preprod, never on the switch.
- hitl: the owner connects the repository to Workers Builds, sets branch protection, and turns off automatic Web Analytics injection.
