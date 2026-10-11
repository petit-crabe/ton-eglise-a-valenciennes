# Project rules

These rules apply to every BMad agent and workflow in this repository.

## Project layout

- The `specs/` folder holds the project's design and planning documents.
- The `design/` folder holds the Design System and the project mockups.
- The `web/` folder holds the website source code.

## Language

- Always talk to the user in French, in plain everyday language, with no technical terms. If a technical notion cannot be avoided, explain it in simple words instead of naming it.
- Write every produced file in English: documents, specs, code, comments.
- Write everything sent to git and GitHub in English: commit messages, branch names, pull request titles and descriptions.

## Git branches

- `main` and `preprod` are protected and never receive direct changes. Never commit or push directly to them.
- `develop` is the development branch; it receives changes from branches created for each new story.
- For each new story, create a dedicated branch from `develop`, and deliver the work to `develop` from that branch.

## Framing questions

- Before producing anything, ask the user framing questions, 3 at most at a time. Ask again whenever the direction becomes unclear during the work.
