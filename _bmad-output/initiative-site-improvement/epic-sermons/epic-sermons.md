---
type: epic
title: "Sermons from YouTube"
parent: initiative-site-improvement
covers: [CAP-12, CAP-5, CAP-7, CAP-8, CAP-13]
after: []
assignee: ""
risk: medium
---

# Sermons from YouTube

## Description

`/api/sermon` and `/api/sermon/thumbnail` read the channel's live broadcast or latest video (AD-6), and the `LatestSermon` component shows it on the home and sermons pages through `ConsentEmbed`, which loads YouTube only on a click.

## Outcome

A member watches Sunday's live service or the latest sermon from the site, and finds the rest on the channel.

## Done when

1. On preprod, the home and sermons pages show the latest video with a link to the channel; while the channel streams, they show the live broadcast.
2. When YouTube fails, only the channel link shows.
3. No request reaches YouTube before the visitor clicks; the placeholder names YouTube's cookies; the CSP allows YouTube only as the AD-7 embed needs.
4. Every old sermon URL in the inventory answers a 301 to its own video, or to the sermons page when the video is gone.
5. The components meet AD-13.

## Boundaries

The sermon function, its components and its CSP addition. The sermon redirects are built by epic-pages-and-content's import; this epic verifies them. No sermon pages (non-goal).

## References

- parent — _bmad-output/initiative-site-improvement/spec-site-improvement/spec-site-improvement.md, CAP-12
- architecture — _bmad-output/initiative-site-improvement/architecture-new-site/architecture-new-site.md, AD-6, AD-7, AD-9, AD-14
- design — design/maquettes/home/, design/maquettes/sermons/ (overridden by AD-6 where they differ)

## Notes

- Unknown: whether a live broadcast appears in the uploads playlist while it is live.
- hitl: the owner sets the YouTube API key as a Worker secret, for production and preview.
- Waits on epic-site-foundation because: `/api` route, API helper and base CSP. Waits on epic-pages-and-content because: home and sermons pages, sermon redirects.
