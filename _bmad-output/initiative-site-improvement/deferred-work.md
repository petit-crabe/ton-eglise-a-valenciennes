- source_plan: `_bmad-output/initiative-site-improvement/epic-site-foundation/story-site-scaffold-published-to-preprod-plan.md`
  summary: AGENTS.md and the architecture name `site/` and say there is no build, while the new site now lives in `web/` with `npm run build` and `npm run check`.
  evidence: The `site/` → `web/` rewrite is on branch `chore/remove-wordpress-copy` (not merged yet); the build commands in AGENTS.md belong to story 1.2.

- source_plan: `_bmad-output/initiative-site-improvement/epic-site-foundation/story-branch-protection-and-agent-instructions-plan.md`
  summary: Move the project's hand-written AGENTS.md rules out of the bmad:context block, or refresh the block with bmad-project-context, so a refresh does not drop them and its "Verified" line is current.
  evidence: The block header says edits inside it are replaced on refresh; stories 1.1 and 1.2 edited inside it, and it still says "Verified 2026-10-12 against 4ab2564".
