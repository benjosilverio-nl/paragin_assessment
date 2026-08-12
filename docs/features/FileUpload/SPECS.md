# File Upload Specs

## Background Service

- A `FileUploadService` is responsible for validation and persistence of uploaded exam-result files.

## Current Signatures

- `FileUploadService::__construct(ValidatorContext $validator, StorageInterface $storage)`
- `FileUploadService::handle(UploadedFile $file): string`
- `FileUploadService::generateFilename(UploadedFile $file): string`
- `StorageInterface::store(UploadedFile $file, string $filename): string`
- `ValidatorStrategy::validate(UploadedFile $file, int $maxSize): void`
- `ValidatorContext::__construct(array $config, iterable $strategies)`
- `ValidatorContext::validate(UploadedFile $file): void`

## Initial Test Case

- `file upload service class exists`
  - Location: `src/tests/Unit/FileUploadServiceTest.php`
  - Purpose: enforce creation of `App\\Service\\FileUploadService` as the first TDD step.

## Storage Contract Tests

- `storage interface exists`
  - Location: `src/tests/Unit/StorageInterfaceTest.php`
  - Purpose: enforce creation of `App\\Storage\\StorageInterface` as the storage contract.
- `local storage class exists`
  - Location: `src/tests/Unit/LocalStorageTest.php`
  - Purpose: enforce creation of `App\\Storage\\LocalStorage` as the concrete storage implementation.
- `local storage implements storage interface`
  - Location: `src/tests/Unit/LocalStorageTest.php`
  - Purpose: enforce that `LocalStorage` implements `StorageInterface`.

## Implementation Mapping

- `FileUploadService` depends on `ValidatorContext` for validation and `StorageInterface` for persistence.
- `FileUploadService::handle()` validates the incoming `UploadedFile` first, then delegates persistence to `StorageInterface::store(UploadedFile $file, string $filename): string`.
- `StorageInterface` defines the storage contract used by `FileUploadService`.
- `LocalStorage` is the concrete adapter that implements `StorageInterface` for filesystem storage.
- `ValidatorContext` matches the uploaded file MIME type against configured supported types and dispatches to the configured validator strategy.
- `CsvValidator` and `XlsxValidator` implement `ValidatorStrategy` and enforce max-size validation.

## File Validation Tests

- `file upload service stores a supported csv file locally`
  - Location: `src/tests/Unit/FileUploadServiceTest.php`
  - Ensures `FileUploadService::handle()` accepts a CSV file and delegates storage to `StorageInterface`.
- `file upload service rejects unsupported file types`
  - Location: `src/tests/Unit/FileUploadServiceTest.php`
  - Ensures uploads outside configured CSV/XLSX MIME types are rejected with a `RuntimeException`.
- `file upload service rejects csv files above configured max size`
  - Location: `src/tests/Unit/FileUploadServiceTest.php`
  - Ensures CSV files larger than `parameters.file_upload.supported_types.csv.max_size` are rejected with a `RuntimeException`.
- `file upload service rejects xlsx files above configured max size`
  - Location: `src/tests/Unit/FileUploadServiceTest.php`
  - Ensures XLSX files larger than `parameters.file_upload.supported_types.xlsx.max_size` are rejected with a `RuntimeException`.

## Validation Configuration

- Supported upload types are configured under `parameters.file_upload.supported_types` in `src/config/packages/file_upload.yaml`.
- Each configured type provides:
  - `mime`
  - `validator`
  - `max_size`

## Custom Package and Service Wiring

- `src/config/packages/file_upload.yaml` contains the allowed file types and maximum sizes.
- `src/config/services.yaml` wires the upload stack into the Symfony container:
  - `App\Validator\ValidatorContext` receives the configured MIME map and validator strategies.
  - `App\Storage\LocalStorage` receives the upload target directory.
  - The repositories and parser are also autowired in the same container configuration.
- This keeps the storage and validation code decoupled from Symfony-specific bootstrapping while still using the framework dependency injection container.

## Module Notes

- The upload module intentionally owns file validation and import persistence only.
- The actual parsing and scoring logic remains separated into the parser and analysis modules so the upload layer can stay focused on accepting valid files and storing them safely.