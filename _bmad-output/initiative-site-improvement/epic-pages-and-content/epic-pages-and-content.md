---
type: epic
title: "Pages and imported content"
parent: initiative-site-improvement
covers: [CAP-15, CAP-11, CAP-6, CAP-5, CAP-9, CAP-7, CAP-8, CAP-13]
after: []
assignee: ""
risk: medium
---

# Pages and imported content

## Description

The texts and photographs of the live site are imported once from production (AD-16), and every page of DESIGN.md "Mockups" is built from them: home structure, "L'église" pages, donate, contact, the three form pages' texts, the legal pages and the sermons page shell. Every URL of the old site gets its fate in `url-inventory.csv`, and `_redirects` carries the 301s, old sermon URLs included.

## Outcome

A visitor on preprod finds every page of today's structure, with today's texts and photos in the new look, and no old link dies.

## Done when

1. Every page of DESIGN.md "Mockups" is on preprod with the live site's texts and photographs, matching its mockup on desktop and phone, except where an AD overrides it (sermons page per AD-6).
2. Every URL of the live site appears once in `web/ops/url-inventory.csv` with its fate, and the preview answers each accordingly; login, admin and `xmlrpc.php` paths answer 404, never 410.
3. Measured on a throttled connection, the home page and each "L'église" page weigh less than the 2026-10-12 recordings; no image is served larger than its slot.
4. No link targets `#` or a missing page, no English interface string, public pages say "tu", and the logo links home.
5. The legal notice and privacy page are published and linked from every footer and form page.
6. Every page meets AD-13 on the phone sizes of DESIGN.md "Target screens".

## Boundaries

Pages and content. The home page sermon block belongs to epic-sermons, its events block to epic-events, the form fields and sending to epic-forms; this epic leaves those slots. Not department pages (non-goal).

## References

- parent — _bmad-output/initiative-site-improvement/spec-site-improvement/spec-site-improvement.md, section Capabilities
- architecture — _bmad-output/initiative-site-improvement/architecture-new-site/architecture-new-site.md, AD-3, AD-6, AD-7, AD-9, AD-12, AD-13, AD-16
- design — design/DESIGN.md, sections Mockups, Site structure, Confirmed facts; design/maquettes/
- source — https://tonegliseavalenciennes.fr/ (live production, not the March 2026 backup)

## Notes

- Decision (2026-11-10): the nine department cards on "L'équipe" are left out until their texts arrive.
- Open question: legal-notice facts (legal form, RNA or SIREN, publication director) and who approves the legal pages; the switch waits for them.
- Open question: "Conditions générales" — keep, rewrite or drop.
- Unknown: whether `/wp-content/uploads/` files are linked from outside the site; the URL inventory answers it.
- Waits on epic-site-foundation because: layout, tokens, schemas, facts and build checks.
