<?php

namespace App\Validator;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use RuntimeException;

/**
 * Validates uploaded XLSX files against the configured size limit.
 */
final class XlsxValidator implements ValidatorStrategy
{
    /**
     * Checks whether the uploaded XLSX file is within the allowed size threshold.
     *
     * @param UploadedFile $file The uploaded XLSX file.
     * @param int $maxSize The maximum allowed size in bytes.
     * @throws RuntimeException When the XLSX size cannot be determined or exceeds the limit.
     * @return void
     */
    public function validate(UploadedFile $file, int $maxSize): void
    {
        $size = $file->getSize();

        if ($size === false || $size === null) {
            throw new RuntimeException('Unable to determine XLSX file size.');
        }

        if ($size > $maxSize) {
            throw new RuntimeException('XLSX file exceeds the maximum allowed size.');
        }
    }
}