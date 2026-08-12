<?php

namespace App\Validator;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Defines the validation contract for a specific uploaded file type.
 */
interface ValidatorStrategy
{
    /**
     * Validates an uploaded file against the configured size rules.
     *
     * @param UploadedFile $file The uploaded file instance.
     * @param int $maxSize The maximum allowed size in bytes.
     * @throws \RuntimeException When the file does not meet the validation rules.
     */
    public function validate(UploadedFile $file, int $maxSize): void;
}