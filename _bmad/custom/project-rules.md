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

## Git flow

Changes travel in one direction: task branch -> `develop` -> `preprod` -> `main`.

- Before starting any story or task, create a dedicated branch from `develop`.
- When the task is done, commit it on that branch, then merge the branch into `develop`.
- `preprod` is the staging branch. It only receives `develop`, through a pull request opened when the user asks for it. Never open a pull request to `preprod` from any other branch.
- `main` is production. It only receives `preprod`, once the user has validated preprod and asks for it.
- Never commit or push directly to `main` or `preprod`.

## Framing questions

- Before producing anything, ask the user framing questions, 3 at most at a time. Ask again whenever the direction becomes unclear during the work.
