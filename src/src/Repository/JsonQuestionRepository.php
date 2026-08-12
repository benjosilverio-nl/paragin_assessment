<?php

namespace App\Repository;

use App\Repository\QuestionRepositoryInterface;

/**
 * Persists question metadata in a JSON file for the assessment application.
 */
final class JsonQuestionRepository implements QuestionRepositoryInterface
{
    private string $file;

    /**
     * Creates the repository and ensures the backing JSON store exists.
     *
     * @param string $filePath The full path to the JSON question store.
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
     * Loads the question records from the JSON file.
     *
     * @return array<int, array<string, mixed>> The stored question records.
     */
    private function load(): array
    {
        if (!file_exists($this->file)) {
            return [];
        }

        return json_decode(file_get_contents($this->file), true);
    }

    /**
     * Replaces the stored question data with the supplied records.
     *
     * @param array<int, array<string, mixed>> $data The question records to persist.
     * @return void
     */
    public function update(array $data): void
    {
        file_put_contents($this->file, json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Clears all persisted question data.
     *
     * @return void
     */
    public function reset(): void
    {
        file_put_contents($this->file, json_encode([]));
    }

    /**
     * Returns all stored question records.
     *
     * @return array<int, array<string, mixed>> The stored question records.
     */
    public function getAll(): array
    {
        return $this->load();
    }

    /**
     * Finds a question record by its identifier.
     *
     * @param int $id The question identifier.
     * @return array<string, mixed>|null The matching question record, or null when not found.
     */
    public function findQuestionById(int $id): ?array
    {
        foreach ($this->load() as $q) {
            if ($q['id'] === $id) {
                return $q;
            }
        }
        return null;
    }
}