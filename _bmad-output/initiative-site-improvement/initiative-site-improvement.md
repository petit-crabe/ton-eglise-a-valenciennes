---
type: initiative
title: "New church website replaces WordPress"
parent: none
covers: [CAP-3, CAP-5, CAP-6, CAP-7, CAP-8, CAP-9, CAP-10, CAP-11, CAP-12, CAP-13, CAP-15, CAP-16, CAP-17, CAP-18, CAP-19]
after: []
assignee: ""
risk: high
---

# New church website replaces WordPress

## Description

`tonegliseavalenciennes.fr` moves from the exposed, heavy WordPress site to a pre-built Astro site on the owner's Cloudflare account, keeping today's pages, texts and photographs with the modernised look of the validated mockups, while the church's OVH e-mail keeps flowing. The spec owns the capabilities, constraints and non-goals; the architecture spine owns the rules (AD-1 to AD-16) every epic adopts.

## Outcome

Members and visitors get a safe, light, readable site with true practical facts, the Sunday live stream and the church's forms; the signal is the spec's success signal.

## Done when

1. `tonegliseavalenciennes.fr` is served by the new site from Cloudflare and WordPress no longer serves the domain; the other three host names answer a 301 to it.
2. The checks of the 2026-10-12 review, run on production, find no Critical or High finding open.
3. A form sent from the site arrives in the church's mailbox, and an outside e-mail still reaches every OVH mailbox.
4. On the Sunday after the switch, the home page shows the live service without anyone touching the site.
5. The communication department and the church leaders have approved the site on preprod before the switch.

## Boundaries

Capability boundary, one owner (the site owner, working through agent sessions). Not the spec's non-goals: sermon pages, site search, newcomer page, online giving, a CMS, department pages, an event archive, a cookie banner, a numeric speed target, a conformance statement. Tracer path: the home page shell built from `main` and `preprod` by Workers Builds and visible on the preprod link (epic 1).

- Touch point: OVH registrar and mailboxes — configured only, never moved; owner: epic-dns-to-cloudflare, then epic-switch-over
- Touch point: YouTube channel — read through the Data API; owner: epic-sermons
- Touch point: `web/` WordPress copy — untouched; its removal is a separate task the owner approves

## References

- spec — _bmad-output/initiative-site-improvement/spec-site-improvement/spec-site-improvement.md, section Capabilities
- constraint — the same spec, sections Constraints and Non-goals
- architecture — _bmad-output/initiative-site-improvement/architecture-new-site/architecture-new-site.md
- design — design/DESIGN.md and design/maquettes/

## Notes

- Decision (2026-11-10): seven epics in the order of `tickets.toml`; the DNS move to Cloudflare is its own epic before the forms, because Cloudflare Email Sending needs an active Cloudflare zone.
- Decision (2026-11-10): epics 1 to 6 are done when verified on preprod; production goes live on the domain only in epic-switch-over.
- Decision (2026-11-10): preprod serves as a prototype until the communication department and the church leaders validate the site; every choice made in an epic stays provisional until the switch, so epics may take their time.
- Decision (2026-11-10): the switch waits for the legal-notice facts and for the church name and contact e-mail; the nine department cards on "L'équipe" are left out until their texts arrive.
- Decision (2026-11-10): the switch may happen without the prayer-request form; until the church leaders answer who reads the requests and how long they are kept, its page shows only the phone and e-mail.
- Open question: the spec's Open Questions (form mailboxes, legal facts, "Conditions générales", contact e-mail and church name, ConneXion and Entraide, department texts, OVH renewal on 17/12/2026); each epic notes the ones it waits on.
