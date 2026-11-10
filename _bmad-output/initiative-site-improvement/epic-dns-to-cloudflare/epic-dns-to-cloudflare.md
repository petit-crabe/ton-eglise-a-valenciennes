---
type: epic
title: "Domain names managed by Cloudflare, e-mail untouched"
parent: initiative-site-improvement
covers: [CAP-18]
after: []
assignee: ""
risk: high
---

# Domain names managed by Cloudflare, e-mail untouched

## Description

The DNS of `tonegliseavalenciennes.fr` and `add-valenciennes.fr` moves from OVH to Cloudflare while both domains stay registered at OVH, the WordPress site keeps being served from OVH, and every OVH mail record is copied identically first (AD-11). This gives Email Sending the active zone it needs, before the site itself switches.

## Outcome

The church's e-mail never stops, and the domains are ready for the forms and the site switch.

## Done when

1. The OVH zone exports of both domains are saved, and every mail record (MX, SPF, DKIM, DMARC, autodiscover) exists identically in the Cloudflare zones, checked against them, before the nameserver change.
2. After the nameserver change, a message sent from outside reaches each OVH mailbox, and the WordPress site still answers on its addresses.
3. Email Routing is not enabled on either zone.
4. Every setting made is recorded by name in `site/ops/cloudflare-settings.md`.

## Boundaries

DNS only. The site records keep pointing to OVH; the switch of the site, the host redirects and the custom domain belong to epic-switch-over. `jeunessentiel.fr` is out of scope. The Email Sending records are added in epic-forms, merging with these.

## References

- parent — _bmad-output/initiative-site-improvement/spec-site-improvement/spec-site-improvement.md, CAP-18
- architecture — _bmad-output/initiative-site-improvement/architecture-new-site/architecture-new-site.md, AD-2, AD-11, AD-15

## Notes

- Decision (2026-11-10): the DNS move is its own epic before epic-forms, because Email Sending needs an active Cloudflare zone.
- Open question: is the OVH payment method valid for the renewal of `tonegliseavalenciennes.fr` on 17/12/2026?
- Unknown: does an existing `_dmarc` record need merging with the one Email Sending adds.
- hitl: almost all of it is done by the owner in the OVH and Cloudflare dashboards.
- Waits on epic-site-foundation because: the Cloudflare account set up for the site.
