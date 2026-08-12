<?php

namespace App\Service;

use App\Config\GradingConfig;

/**
 * Calculates aggregate outcomes and per-question statistics for imported assessment data.
 */
class AnalysisService
{
    /**
     * Creates the analysis service with the configured grading anchors.
     *
     * @param GradingConfig $gradingConfig The grade mapping used for score conversion.
     */
    public function __construct(
        private GradingConfig $gradingConfig
    ) {}

    /**
     * Analyzes question and student data and returns the derived assessment statistics.
     *
     * @param array<int, array<string, mixed>> $questions The question definitions and max scores.
     * @param array<string, array<string, mixed>> $students The student score records.
     * @return array{students: array<int, array<string, mixed>>, questions: array<int, array<string, mixed>>} The aggregated analysis result.
     */
    public function analyze(array $questions, array $students): array
    {
        // Extract max scores per question
        
        $questionMaxScores = array_column($questions, 'max_score');

        // Compute student totals
        $studentResults = [];
        $totalScores = [];

        foreach ($students as $student) {
            
            $scores = $student['scores'];

            $total = array_sum(array_column($scores, 'score'));
            $max   = array_sum($questionMaxScores);
            $percentage = $max > 0 ? $total / $max : 0;

            $grade = $this->calculateGrade($percentage);
            $passed = $grade >= 5.5;

            $studentResults[] = [
                'student_id' => $student['student_id'],
                'performance' => [
                    'total' => $total,
                    'max' => $max,
                    'percentage' => $percentage,
                    'grade' => $grade,
                    'passed' => $passed,
                ],
                'scores' => $scores,
            ];

            $totalScores[] = $total;
        }

        // Compute question statistics
        $questionResults = [];

        foreach ($questions as $index => $question) {
            $itemScores = array_column($students, 'scores');
            $itemScores = array_column($itemScores, $index);

            $pValue = $this->calculatePValue($itemScores, $question['max_score']);
            $rit = $this->pearson($itemScores, $totalScores);

            $questionResults[] = [
                'id' => $question['id'],
                'title' => $question['title'],
                'max_score' => $question['max_score'],
                'pValue' => $pValue,
                'rit' => $rit,
            ];
        }

        return [
            'students' => $studentResults,
            'questions' => $questionResults,
        ];
    }

    /**
     * Converts a percentage score into a final grade using the configured anchor points.
     *
     * @param float $p The percentage value to convert.
     * @return float The calculated grade between 1.0 and 10.0.
     */
    private function calculateGrade(float $p): float
    {
        $anchors = $this->gradingConfig->anchors;

        // Sort anchors by percentage
        usort($anchors, fn($a, $b) => $a['p'] <=> $b['p']);

        // Below first anchor
        if ($p <= $anchors[0]['p']) {
            return $anchors[0]['g'];
        }

        // Above last anchor
        $last = count($anchors) - 1;
        if ($p >= $anchors[$last]['p']) {
            return $anchors[$last]['g'];
        }

        // Find segment
        for ($i = 0; $i < $last; $i++) {
            $a = $anchors[$i];
            $b = $anchors[$i + 1];

            if ($p >= $a['p'] && $p <= $b['p']) {
                // Linear interpolation
                $grade = $a['g'] + ($p - $a['p']) * (($b['g'] - $a['g']) / ($b['p'] - $a['p']));
                return max(1.0, min(10.0, $grade));
            }
        }

        return 1.0;
    }

    /**
     * Calculates the item difficulty value for a question.
     *
     * @param array<int, array<string, mixed>> $scores The score entries for the question.
     * @param float $maxScore The maximum possible score for the question.
     * @return float The p-value for the item difficulty.
     */
    private function calculatePValue(array $scores, float $maxScore): float
    {
        if ($maxScore <= 0 || count($scores) === 0) {
            return 0;
        }
        
        $avg = array_sum(array_column($scores, 'score')) / count($scores);
        return $avg / $maxScore;
    }

    /**
     * Calculates the Pearson correlation between an item and the total scores.
     *
     * @param array<int, array<string, mixed>> $x The item score values.
     * @param array<int, float> $y The total score values.
     * @return float The Pearson correlation coefficient.
     */
    private function pearson(array $x, array $y): float
    {
        $n = count($x);
        if ($n === 0) {
            return 0;
        }
        
        $meanX = array_sum(array_column($x, 'score')) / $n;
        $meanY = array_sum($y) / $n;

        $num = 0;
        $denX = 0;
        $denY = 0;

        for ($i = 0; $i < $n; $i++) {
            $dx = $x[$i]['score'] - $meanX;
            $dy = $y[$i] - $meanY;

            $num += $dx * $dy;
            $denX += $dx * $dx;
            $denY += $dy * $dy;
        }

        return ($denX && $denY) ? $num / sqrt($denX * $denY) : 0;
    }
}
