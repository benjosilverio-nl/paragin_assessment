<?php

namespace App\Repository;

use App\Repository\StudentRepositoryInterface;

/**
 * Persists student assessment results in a JSON file for the application.
 */
final class JsonStudentRepository implements StudentRepositoryInterface
{
    private string $file;

    /**
     * Creates the repository and ensures the backing JSON store exists.
     *
     * @param string $filePath The full path to the JSON student store.
     */
    public function __construct(string $filePath)
    {
        $this->file = $filePath;

        $directory = \dirname($filePath);

        // Create directory if it doesn't exist
        if (!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        // Ensure directory is writable
        if (!is_writable($directory)) {
            chmod($directory, 0775);
        }

        // Create the JSON file if it doesn't exist
        if (!file_exists($filePath)) {
            file_put_contents($filePath, json_encode([]));
            chmod($filePath, 0664);
        }
    }

    /**
     * Loads the stored student records from the JSON file.
     *
     * @return array<int, array<string, mixed>> The stored student records.
     */
    private function load(): array
    {
        if (!file_exists($this->file)) {
            return [];
        }
        
        return json_decode(file_get_contents($this->file), true);
    }

    /**
     * Replaces the stored student data with the supplied records.
     *
     * @param array<int, array<string, mixed>> $data The student records to persist.
     * @return void
     */
    public function update(array $data): void
    {
        file_put_contents($this->file, json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Clears all persisted student records.
     *
     * @return void
     */
    public function reset(): void
    {
        file_put_contents($this->file, json_encode([]));
    }

    /**
     * Retrieves a student record by identifier.
     *
     * @param string $studentId The student identifier.
     * @return array<string, mixed>|null The matching student record, or null when not found.
     */
    public function getStudent(string $studentId): ?array
    {
        foreach ($this->load() as $student) {
            if ($student['student_id'] === $studentId) {
                return $student;
            }
        }
        return null;
    }

    /**
     * Returns all stored student records.
     *
     * @return array<int, array<string, mixed>> The stored student records.
     */
    public function getAll(): array
    {
        return $this->load();
    }
}