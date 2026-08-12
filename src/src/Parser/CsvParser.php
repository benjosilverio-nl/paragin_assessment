<?php

namespace App\Parser;

use App\Parser\ResultParser;
use League\Csv\Reader;

/**
 * Parses CSV assessment uploads into the application's normalized result format.
 */
final class CsvParser implements ResultParser
{
    /**
     * Parses a CSV file from disk and returns the normalized result dataset.
     *
     * @param string $filePath The path to the CSV file to parse.
     * @return array<string, mixed> The parsed result data.
     */
    public function parse(string $filePath): array
    {
    }

    /**
     * Normalizes a CSV row by trimming whitespace from each cell.
     *
     * @param array<int, mixed> $row The row values from the CSV file.
     * @return array<int, string> The cleaned row values.
     */
    private function normalizeRow(array $row): array
    {
        return array_map(static fn($value) => trim((string) $value), $row);
    }
}
