# Project Instructions

## Prompt Logging

- Log every user prompt for this project in [docs/PROMPTS.md](docs/PROMPTS.md) before taking any other action.
- Preserve existing entries and append each new prompt as the next numbered prompt.
- Include the full user prompt text unless it contains sensitive information, secrets, or other content that should not be persisted.
- If [docs/PROMPTS.md](docs/PROMPTS.md) does not exist, create it.

## Working Style

- Keep changes focused and minimal.
- Prefer updating existing project markdown files instead of creating duplicates.

## Documentation Standards for Generated Code

- Add full PHPDoc blocks to every custom class, interface, trait, method, and constructor we generate for this project.
- Include a concise summary, all relevant @param tags, @return tags, and @throws tags when applicable.
- Use precise project-specific wording instead of generic placeholders.
- Keep the docblocks limited to the code we create in this repository and skip Symfony or vendor framework internals.
- Treat this as a standard for all generated code in the application layer.