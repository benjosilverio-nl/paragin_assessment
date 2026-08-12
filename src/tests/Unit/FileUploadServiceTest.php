<?php

use App\Service\FileUploadService;
use App\Storage\StorageInterface;
use App\Validator\CsvValidator;
use App\Validator\ValidatorContext;
use App\Validator\XlsxValidator;
use RuntimeException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Yaml\Yaml;

function makeUploadedTestFile(string $extension, string $mimeType, int $size): UploadedFile
{
    $path = tempnam(sys_get_temp_dir(), 'upload_test_');
    file_put_contents($path, str_repeat('a', max($size, 1)));

    return new class($path, $extension, $mimeType, $size) extends UploadedFile {
        public function __construct(
            string $path,
            private string $extension,
            private string $mimeType,
            private int $size,
        ) {
            parent::__construct($path, 'upload.' . $extension, $mimeType, null, true);
        }

        public function getClientMimeType(): string
        {
            return $this->mimeType;
        }

        public function getSize(): int|false
        {
            return $this->size;
        }

        public function guessExtension(): ?string
        {
            return $this->extension;
        }
    };
}

function fileUploadSupportedTypes(): array
{
    $config = Yaml::parseFile(__DIR__ . '/../../config/packages/file_upload.yaml');

    return $config['parameters']['file_upload.supported_types'] ?? [];
}

function makeValidatorContext(): ValidatorContext
{
    return new ValidatorContext(fileUploadSupportedTypes(), [
        new CsvValidator(),
        new XlsxValidator(),
    ]);
}

test('file upload service class exists', function () {
    expect(class_exists(FileUploadService::class))->toBeTrue();
});

test('file upload service stores a supported csv file locally', function () {
    $storage = new class implements StorageInterface {
        public bool $called = false;
        public ?UploadedFile $storedFile = null;
        public ?string $storedFilename = null;

        public function store(UploadedFile $file, string $filename): string
        {
            $this->called = true;
            $this->storedFile = $file;
            $this->storedFilename = $filename;

            return 'stored/' . $filename;
        }
    };

    $service = new FileUploadService(makeValidatorContext(), $storage);
    $file = makeUploadedTestFile('csv', 'text/csv', 512);

    $storedPath = $service->handle($file);

    expect($storage->called)->toBeTrue();
    expect($storage->storedFile)->toBe($file);
    expect($storage->storedFilename)->not->toBeNull();
    expect($storage->storedFilename)->toEndWith('.csv');
    expect($storedPath)->toBe('stored/' . $storage->storedFilename);
});

test('file upload service rejects unsupported file types', function () {
    $storage = new class implements StorageInterface {
        public function store(UploadedFile $file, string $filename): string
        {
            return $filename;
        }
    };

    $service = new FileUploadService(makeValidatorContext(), $storage);
    $file = makeUploadedTestFile('pdf', 'application/pdf', 1024);

    expect(fn () => $service->handle($file))->toThrow(RuntimeException::class);
});

test('file upload service rejects csv files above configured max size', function () {
    $maxSize = fileUploadSupportedTypes()['csv']['max_size'];

    $storage = new class implements StorageInterface {
        public function store(UploadedFile $file, string $filename): string
        {
            return $filename;
        }
    };

    $service = new FileUploadService(makeValidatorContext(), $storage);
    $file = makeUploadedTestFile('csv', 'text/csv', $maxSize + 1);

    expect(fn () => $service->handle($file))->toThrow(RuntimeException::class);
});

test('file upload service rejects xlsx files above configured max size', function () {
    $maxSize = fileUploadSupportedTypes()['xlsx']['max_size'];

    $storage = new class implements StorageInterface {
        public function store(UploadedFile $file, string $filename): string
        {
            return $filename;
        }
    };

    $service = new FileUploadService(makeValidatorContext(), $storage);
    $file = makeUploadedTestFile(
        'xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        $maxSize + 1,
    );

    expect(fn () => $service->handle($file))->toThrow(RuntimeException::class);
});