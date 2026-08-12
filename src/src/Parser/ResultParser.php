<?php

namespace App\Parser;

/**
 * Defines the contract for parsing uploaded result files into a normalized data structure.
 */
interface ResultParser
{
    /**
     * Parses a result file and returns the structured outcome data.
     *
     * @param string $filePath The path to the uploaded result file.
     * @return array<string, mixed> The parsed result payload.
     */
    public function parse(string $filePath): array;
}