<?php

namespace App\Repository;

/**
 * Defines the contract for reading and querying persisted question data.
 */
interface QuestionRepositoryInterface
{
    /**
     * Returns all question records currently stored.
     *
     * @return array<int, array<string, mixed>> The stored question records.
     */
    public function getAll(): array;

    /**
     * Finds a question by its identifier.
     *
     * @param int $id The question identifier.
     * @return array<string, mixed>|null The matching question record, or null when not found.
     */
    public function findQuestionById(int $id): ?array;
}