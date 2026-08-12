# Landing Page Specs

## Entry Point

- `IndexController` is the entry point for the landing page.
- Route: `GET /`
- Controller action: `__invoke()`
- Rendered template: `index.html.twig`

## Template

- Template file: `src/templates/index.html.twig`
- Current state: intentionally empty placeholder template.

## Current Tests

- `index route returns a successful response`
  - Verifies that `GET /` responds successfully.
- `index route returns an html response`
  - Verifies that `GET /` returns a `text/html` content type.