<?php

namespace App\Storage;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Defines how uploaded files are persisted for the assessment workflow.
 */
interface StorageInterface
{
    /**
     * Stores an uploaded file and returns the saved path.
     *
     * @param UploadedFile $file The uploaded file to persist.
     * @param string $filename The name to assign to the stored file.
     * @return string The saved file path.
     */
    public function store(UploadedFile $file, string $filename): string;
}