# Paragin Group Senior Backend Developer Assessment

This project is a PHP/Symfony application that processes assessment results from uploaded spreadsheet files, calculates pass/fail outcomes, and reports question quality metrics for a tutor or examiner.

## Overview

The application is designed for a backend assessment workflow where the user uploads an XLSX result file, the data is validated and stored, and the system calculates:

- per-student totals and grade outcomes
- pass/fail status based on configurable grading anchors
- question-level statistics such as P'-value and r_it correlation

The solution is built to be extensible for different exam configurations and grading rules.

## Features

- Upload and validate assessment files
- Parse spreadsheet result data
- Persist questions and student results in JSON-backed repositories
- Calculate student percentage, grade, and pass/fail status
- Compute question item difficulty and correlation metrics
- Serve the application through Docker and nginx

## Technology Stack

- PHP
- Symfony
- Docker Compose
- Nginx
- OpenSpout for spreadsheet parsing

## Project Structure

- `src/` – application source code
- `config/` – Symfony configuration
- `templates/` – Twig templates for the UI
- `tests/` – automated tests
- `docker/` – Docker and web server configuration
- `docs/` – assessment and project documents

## Running the Application

To start the application locally:

```bash
docker compose up
```

Then open the app in your browser at:

```text
http://localhost
```

## Notes

The application is configured to run in a containerized development environment, making local setup straightforward and consistent across machines.

---

The application can be run by using:

```bash
docker compose up
```

Then open:

```text
http://localhost
```
