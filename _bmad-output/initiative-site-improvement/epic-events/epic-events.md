---
type: epic
title: "Events relaunched"
parent: initiative-site-improvement
covers: [CAP-17, CAP-7, CAP-8, CAP-13]
after: []
assignee: ""
risk: low
---

# Events relaunched

## Description

Events are one file each in the `events` collection (AD-8): an events list, one page per event with share links and an `.ics` file, and the home page events block, hiding ended events on the visitor's clock and falling back to the weekly meetings when none is upcoming.

## Outcome

The owner announces an event by adding one file, and members see it until it is over.

## Done when

1. Adding one event file and merging publishes it on preprod, on the list, the home block and its own page.
2. Lists show upcoming events only, nearest first, grouped by month; without JavaScript only events ended before the build are hidden.
3. An event typed in Paris local time shows, and lands in a calendar through "Ajouter à mon agenda", at that time in summer and in winter.
4. With no upcoming event, the weekly meetings from `facts.json` show instead of an empty block.
5. The pages match their mockups and meet AD-13.

## Boundaries

The events collection, pages and home block. Not an archive of past events (non-goal).

## References

- parent — _bmad-output/initiative-site-improvement/spec-site-improvement/spec-site-improvement.md, CAP-17
- architecture — _bmad-output/initiative-site-improvement/architecture-new-site/architecture-new-site.md, AD-3, AD-4, AD-8
- design — design/maquettes/events/, design/maquettes/home/

## Notes

- Open question: do ConneXion (Saturdays) and Entraide (Wednesdays) still run, to be shown as weekly meetings.
- Waits on epic-site-foundation because: schemas and facts. Waits on epic-pages-and-content because: the home page events slot.
