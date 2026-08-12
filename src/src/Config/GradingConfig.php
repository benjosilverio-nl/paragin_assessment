<?php

namespace App\Config;

/**
 * Stores the grade anchor rules used to convert a percentage into a final grade.
 */
class GradingConfig
{
    /**
     * Creates the grading configuration.
     *
     * @param array<int, array{p: float, g: float}> $anchors The percentage-to-grade anchors.
     */
    public function __construct(
        public array $anchors
    ) {}
}
