---
type: epic
title: "The new site takes over the domain"
parent: initiative-site-improvement
covers: [CAP-15, CAP-3, CAP-18, CAP-5]
after: [epic-pages-and-content, epic-sermons, epic-events, epic-dns-to-cloudflare, epic-forms]
assignee: ""
risk: high
---

# The new site takes over the domain

## Description

After the communication department and the church leaders approve preprod, the production Worker is attached to `tonegliseavalenciennes.fr`, the other three host names redirect to it, WordPress stops serving the domain, and the switch is checked end to end, following a switch-over checklist this epic writes (order, checks, rollback).

## Outcome

`tonegliseavalenciennes.fr` is the new site; the spec's success signal is met.

## Done when

1. The communication department and the church leaders have approved the site on preprod, and no page contains a square-bracket placeholder or an empty text.
2. `tonegliseavalenciennes.fr` serves the new site; `www.tonegliseavalenciennes.fr`, `add-valenciennes.fr` and `www.add-valenciennes.fr` answer a 301 to the same path; WordPress no longer serves the domain; `workers.dev` is off.
3. On production, no login, admin or `xmlrpc.php` path answers anything but 404 or a redirect, and the checks of the 2026-10-12 review find no Critical or High finding open.
4. A form sent from production arrives in the church's mailbox, and an outside e-mail still reaches every OVH mailbox.
5. The privacy page lists only the services in use on production.
6. On the following Sunday, the home page shows the live service without anyone touching the site.

## Boundaries

The switch and its checks. Not the removal of `web/` (separate task), not the choice between OVH hosting and a standalone e-mail offer (deferred).

## References

- parent — _bmad-output/initiative-site-improvement/spec-site-improvement/spec-site-improvement.md, CAP-15, CAP-18, section Success signal
- architecture — _bmad-output/initiative-site-improvement/architecture-new-site/architecture-new-site.md, AD-2, AD-9, AD-10, AD-11, section Deferred (switch-over checklist)
- reviews — reviews/README.md

## Notes

- Decision (2026-11-10): preprod is a prototype until the communication department and the church leaders validate it; everything decided in earlier epics stays provisional until this epic.
- Decision (2026-11-10): waits for the legal-notice facts and the church name and contact e-mail; may go without the prayer-request form.
- Open question: OVH renewal of `tonegliseavalenciennes.fr` on 17/12/2026 must be secured before the switch.
- hitl: the owner attaches the custom domain, sets the Single Redirect rules, and runs the final checks.
- Waits on every other content epic and on epic-dns-to-cloudflare because: the switch publishes the whole site at once.
