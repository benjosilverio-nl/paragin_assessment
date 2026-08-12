<?php

namespace App\Storage;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Storage\StorageInterface;

/**
 * Persists uploaded files in a local directory on disk.
 */
final class LocalStorage implements StorageInterface
{
    /**
     * Creates the local storage service with the target directory.
     *
     * @param string $targetDirectory The directory where uploaded files are stored.
     */
    public function __construct(private string $targetDirectory) {}

    /**
     * Saves the uploaded file to the configured local directory.
     *
     * @param UploadedFile $file The uploaded file to persist.
     * @param string $filename The target filename.
     * @return string The path to the saved file.
     */
    public function store(UploadedFile $file, string $filename): string
    {
        // Ensure the directory exists
        if (!is_dir($this->targetDirectory)) {
            mkdir($this->targetDirectory, 0775, true);
        }

        // Ensure it is writable
        if (!is_writable($this->targetDirectory)) {
            chmod($this->targetDirectory, 0775);
        }

        return $file->move($this->targetDirectory, $filename);
    }
}