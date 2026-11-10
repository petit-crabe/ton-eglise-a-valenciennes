---
type: epic
title: "Forms reach the church mailboxes"
parent: initiative-site-improvement
covers: [CAP-16, CAP-5, CAP-7, CAP-8, CAP-13]
after: []
assignee: ""
risk: high
---

# Forms reach the church mailboxes

## Description

The four forms — contact, prayer request, interview request, "Servir à l'église" — post to `/api/forms/<form-name>`, which checks Turnstile and a honeypot, validates against the form's one schema, and sends one e-mail through Cloudflare Email Sending to the church's OVH mailbox for that form, storing nothing (AD-5).

## Outcome

A visitor sends a message or request, and the church receives it by e-mail; the site keeps nothing.

## Done when

1. On preprod, each form submits and is answered; a filled honeypot or a failed Turnstile check is refused.
2. A form sent from preprod, with Turnstile test keys, never reaches a church mailbox.
3. Nothing about a submission is stored by the site, logs included, and no copy is sent to the visitor.
4. The form pages load Turnstile only through the form-pages CSP block; the privacy page lists exactly the services in use (Turnstile, YouTube, Web Analytics, checked for cookies).
5. The forms match their mockups and meet AD-13.

## Boundaries

The form schemas, `/api/forms`, the Email Sending onboarding and its DNS records. The form pages' texts come from epic-pages-and-content. The check that a production form reaches the church mailbox is done at the switch (epic-switch-over).

## References

- parent — _bmad-output/initiative-site-improvement/spec-site-improvement/spec-site-improvement.md, CAP-16, CAP-5
- architecture — _bmad-output/initiative-site-improvement/architecture-new-site/architecture-new-site.md, AD-5, AD-7, AD-11, AD-14, AD-15
- design — design/maquettes/forms/, design/maquettes/contact/

## Notes

- Decision (2026-11-10): the switch may happen without the prayer-request form; until the church leaders answer, its page shows only the phone and e-mail.
- Open question: which OVH mailbox receives each form, and which domain `FORM_SENDER` uses.
- Open question: who reads prayer and interview requests, and how long they stay in the mailbox.
- Unknown: does the `send_email` binding work in Cloudflare previews; if not, preview forms refuse with a test message.
- hitl: Turnstile keys and Email Sending onboarding by the owner.
- Waits on epic-site-foundation because: `/api` and the CSP. Waits on epic-pages-and-content because: form and privacy pages. Waits on epic-dns-to-cloudflare because: an active zone for the sending domain.
