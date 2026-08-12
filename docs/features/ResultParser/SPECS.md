# Result Parser Specs

## Goal

- Introduce parser contracts and implementations for exam-result inputs.
- Persist parsed question and student data through repository contracts backed by JSON files.
- Feed parsed results into the analysis service so the landing page can display questions and student performance.

## Parser Contracts and Implementations

- Parser contract: `App\Parser\ResultParser`
  - `parse(string $filePath): array`
- Parser implementations:
  - `App\Parser\CsvParser`
  - `App\Parser\XlsxParser`

## Repository Contracts and Implementations

- Student repository contract: `App\Repository\StudentRepositoryInterface`
  - `getStudent(string $studentId): ?array`
  - `getAll(): array`
- Question repository contract: `App\Repository\QuestionRepositoryInterface`
  - `getAll(): array`
  - `findQuestionById(int $id): ?array`
- JSON repository implementations:
  - `App\Repository\JsonStudentRepository`
  - `App\Repository\JsonQuestionRepository`

## Repository Behaviour

- Each JSON repository initialises its backing directory and file when absent.
- Repositories support read access via `getAll()` and targeted lookup by ID.
- Implementations also expose persistence helpers such as `update()` and `reset()` to support parser-driven refreshes.
- Parsed results are written to the JSON files before the page renders the question and student lists.

## Parsing Flow

- `XlsxParser` reads the uploaded spreadsheet and normalises row data into a question list and student score list.
- The parser resets the question and student stores before loading the new batch.
- After analysis, it calls the repository `update()` methods to persist the processed results.
- `AnalysisService` calculates student totals, grade thresholds, P'-value, and r_it correlation values.

## Dependency Wiring

- `src/config/services.yaml` registers:
  - `OpenSpout\Reader\XLSX\Reader`
  - `App\Validator\ValidatorContext`
  - `App\Repository\JsonQuestionRepository`
  - `App\Repository\JsonStudentRepository`
  - `App\Storage\LocalStorage`
  - `App\Config\GradingConfig`
- Repository interfaces are resolved to their concrete JSON implementations through the container.
- `App\Controller\IndexController` receives the repositories and parser through autowiring.

## Grading Configuration

- `src/config/packages/grading.yaml` defines the grading anchors used by the analysis layer:
  - `0.20 -> 1.0`
  - `0.70 -> 5.5`
  - `1.00 -> 10.0`
- `App\Config\GradingConfig` is a simple configuration object that exposes the anchors list to the service container.
- `AnalysisService` consumes this configuration to calculate a student's grade and pass/fail result on a continuous scale.

## Initial TDD Scope

- Existence of parser contract interface: `App\\Parser\\ResultParser`.
- Existence of parser implementations:
  - `App\\Parser\\CsvParser`
  - `App\\Parser\\XlsxParser`
- `parse()` method contract on `ResultParser`.
- `parse()` method implementation presence on both `CsvParser` and `XlsxParser`.
- `parse()` method signature should accept one argument typed as `string` (file path) on `ResultParser`, `CsvParser`, and `XlsxParser`.
- Existence of repository contract interfaces:
  - `App\\Repository\\StudentRepositoryInterface`
  - `App\\Repository\\QuestionRepositoryInterface`
- Existence of JSON repository implementations:
  - `App\\Repository\\JsonStudentInterface`
  - `App\\Repository\\JsonQuestionInterface`
- JSON implementations must satisfy all contract methods defined by their interfaces.

## Tests

- `result parser interface exists`
- `result parser interface defines parse method`
- `result parser parse method accepts a string file path`
- `csv parser class exists`
- `xlsx parser class exists`
- `csv parser implements result parser`
- `xlsx parser implements result parser`
- `csv parser defines parse method`
- `csv parser parse method accepts a string file path`
- `xlsx parser defines parse method`
- `xlsx parser parse method accepts a string file path`
- `student repository interface exists`
- `question repository interface exists`
- `json student repository class exists`
- `json question repository class exists`
- `json student repository implements student repository interface`
- `json question repository implements question repository interface`
- `json student repository implements all student repository contract methods`
- `json question repository implements all question repository contract methods`

Test location:
- `src/tests/Unit/ResultParserTest.php`
- `src/tests/Unit/StudentRepositoryTest.php`
- `src/tests/Unit/QuestionRepositoryTest.php`