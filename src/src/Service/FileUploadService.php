<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Validator\ValidatorContext;
use App\Storage\StorageInterface;

/**
 * Validates and stores uploaded assessment files before parsing them.
 */
final class FileUploadService
{
    /**
     * Creates the upload service with validation and storage dependencies.
     *
     * @param ValidatorContext $validator The validator used to confirm the file type and size.
     * @param StorageInterface $storage The storage strategy used to persist the uploaded file.
     */
    public function __construct(private ValidatorContext $validator, private StorageInterface $storage)  {}

    /**
     * Validates and persists an uploaded file.
     *
     * @param UploadedFile $file The uploaded assessment file.
     * @return string The path to the saved file.
     */
    public function handle(UploadedFile $file): string
    {
        $filename = $this->generateFilename($file);

        $this->validator->validate($file);

        return $this->storage->store($file, $filename);
    }

    /**
     * Generates a unique filename for the uploaded file.
     *
     * @param UploadedFile $file The uploaded assessment file.
     * @return string The generated filename including the extension.
     */
    public function generateFilename(UploadedFile $file): string
    {
        return uniqid() . '.' . $file->guessExtension();
    }
}