<?php

namespace App\Validator;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use RuntimeException;

/**
 * Validates uploaded CSV files against the configured size limit.
 */
final class CsvValidator implements ValidatorStrategy
{
    /**
     * Checks whether the uploaded CSV is within the allowed size threshold.
     *
     * @param UploadedFile $file The uploaded CSV file.
     * @param int $maxSize The maximum allowed size in bytes.
     * @throws RuntimeException When the CSV size cannot be determined or exceeds the limit.
     * @return void
     */
    public function validate(UploadedFile $file, int $maxSize): void
    {
        $size = $file->getSize();

        if ($size === false || $size === null) {
            throw new RuntimeException('Unable to determine CSV file size.');
        }

        if ($size > $maxSize) {
            throw new RuntimeException('CSV file exceeds the maximum allowed size.');
        }
    }
}