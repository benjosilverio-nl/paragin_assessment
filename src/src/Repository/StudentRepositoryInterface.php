<?php

namespace App\Repository;

/**
 * Defines the contract for reading and querying persisted student result data.
 */
interface StudentRepositoryInterface
{
    /**
     * Retrieves a student record by its unique identifier.
     *
     * @param string $studentId The student identifier.
     * @return array<string, mixed>|null The matching student record, or null when not found.
     */
    public function getStudent(string $studentId): ?array;

    /**
     * Returns all student records currently stored.
     *
     * @return array<int, array<string, mixed>> The stored student records.
     */
    public function getAll(): array;
}