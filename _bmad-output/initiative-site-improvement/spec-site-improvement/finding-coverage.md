# Finding coverage

Where each finding of the 2026-10-12 review lands now that a new site replaces WordPress. Ids carry the report number: `01` security, `02` UX, `03` UI, `04` content, `05` accessibility, `06` code.

## By capability

| Capability | Findings |
|------------|----------|
| CAP-3 Closed server exposure | 01-S4, 01-S5 (login surface), 01-S6 (account names), 01-S7, 01-S9, 01-S10 |
| CAP-5 Personal data | 01-S8, 04-C3 |
| CAP-6 Lighter pages | 02-U11, 06-C1, 03-V4 (unused fonts), 03-V15 (oversized files) |
| CAP-7 Phone | 02-U12, 02-U13, 03-V10, 03-V16, 05-A1, 06-C6 |
| CAP-8 Legible colours | 03-V1, 03-V2, 03-V11, 03-V13, 03-V14, 05-A5, 06-C4 |
| CAP-9 One visual language | 03-V3, 03-V4, 03-V5, 03-V6, 03-V7, 03-V8, 03-V9, 03-V12, 03-V15, 03-V17, 02-U19 |
| CAP-10 Practical facts | 02-U2, 02-U8, 04-C1 |
| CAP-11 No dead end, leftover or placeholder | 02-U3, 02-U6, 02-U10, 02-U20, 04-C2, 04-C5, 04-C8, 05-A11 |
| CAP-12 Sermons | 02-U5, 05-A8, 03-V7 (duplicate image) |
| CAP-13 Keyboard and screen reader | 02-U14, 02-U15, 05-A2, 05-A3, 05-A4, 05-A6, 05-A7, 05-A9, 05-A10 |
| CAP-15 New site replaces WordPress | 02-U16 (old sermon addresses), 04-C6 (sermon posts, via redirects) |
| CAP-16 Forms | 01-S8 (spam protection), 02-U7 (labels and required fields, as drawn in the mockups) |
| CAP-17 Events | 02-U3 (empty events page) |

## Already done on 2026-10-12

| Finding | State |
|---------|-------|
| 01-S1 steps 1–3 | Archives deleted, logs checked for twelve months, database password and secret keys changed |
| 01-S5 (`admin` account) | Account deleted |
| 04-C2 filler pages | `/decouvrir-la-foi/` and `/la-technique/` answer 404 |
| 02-U1 dead button, 02-U3 empty home block | Both blocks removed from the home page |

## Retired with WordPress

The WordPress site stays live until the switch, but these findings are not fixed in place: the new site replaces it (owner, 2026-10-24).

| Finding | Former capability |
|---------|-------------------|
| 01-S2 PHP, 01-S3 outdated plugins and theme, 06-C9 | CAP-1 Supported versions |
| 01-S11 removal candidates, Tube Video Curator | CAP-2 Lean toolset |
| 01-S5 and 01-S6 on the WordPress login | CAP-4 Protected admin access |
| 06-C2, 06-C3, 06-C5, 06-C7 | CAP-14 Custom code in the child theme |
| 01-S1 step 5, the personal-data export file of the 01 access-log section | Leave with the WordPress files at the switch |

## Not carried

| Item | Reason |
|------|--------|
| 02-U1, 02-U4 (newcomer path) | Non-goal: no newcomer page |
| 02-U9 (giving online), 02-U17 (search) | Non-goals: no online giving, no site search |
| 02-U18 (next steps) | Not in the validated structure |
| 04-C4 (voice), 04-C7 (search engines) | Not in the validated structure; "tu" voice is in CAP-11 |
| 02-U16 sermon list paging, 04-C6 summaries | No sermon pages (owner, 2026-10-25) |
| 05-A12 (accessibility statement) | Non-goal |
| 06-C8 (no automatic check) | Assumed still a non-goal |
| "Reviewer findings not kept" of `06-code.md` | Rejected by the review itself |
