<?php

namespace App\Parser;

use App\Parser\ResultParser;
use App\Repository\QuestionRepositoryInterface;
use App\Repository\StudentRepositoryInterface;
use App\Service\AnalysisService;
use OpenSpout\Reader\Common\Creator\ReaderFactory;
use OpenSpout\Common\Type;
use OpenSpout\Reader\XLSX\Reader;

/**
 * Parses XLSX assessment exports into repository data and derived analytics output.
 */
final class XlsxParser implements ResultParser
{
    /**
     * Creates the parser with the spreadsheet reader and repository dependencies.
     *
     * @param Reader $reader The XLSX reader used to load spreadsheet rows.
     * @param QuestionRepositoryInterface $questionRepo The repository used to store question data.
     * @param StudentRepositoryInterface $studentRepo The repository used to store student results.
     * @param AnalysisService $analysisService The service used to calculate statistics.
     */
    public function __construct(
        private Reader $reader,
        private QuestionRepositoryInterface $questionRepo,
        private StudentRepositoryInterface $studentRepo,
        private AnalysisService $analysisService
    ) {}

    /**
     * Reads the spreadsheet, computes derived assessment data, and persists the results.
     *
     * @param string $filePath The path to the XLSX import file.
     * @return array<string, mixed> An empty array placeholder for the parser result contract.
     */
    public function parse(string $filePath): array
    {
        $this->reader->open($filePath);
        $this->questionRepo->reset();
        $this->studentRepo->reset();
        
        $rowIndex = 0;
        $questions = [];
        $students = [];
        $maxScore = 0;

        foreach ($this->reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $cells = $row->toArray();
                $rowIndex++;

                // Row 1: question titles
                if ($rowIndex === 1) {
                    foreach ($cells as $colIndex => $value) {
                        if ($colIndex === 0) continue;
                        if (empty($value)) break;

                        $questions[$colIndex] = [
                            "id" => $colIndex,
                            "title" => str_replace("Score ", "", trim((string)$value)),
                        ];
                    }
                    continue;
                }

                // Row 2: max scores
                if ($rowIndex === 2) {
                    foreach ($cells as $colIndex => $value) {
                        if ($colIndex === 0) continue;
                        if (!isset($questions[$colIndex])) continue;

                        $questions[$colIndex]['max_score'] = is_numeric($value) ? (float)$value : null;
                        $maxScore += is_numeric($value) ? (float)$value : 0;
                    }
                    continue;
                }

                // Row 3+: students
                $studentId = str_replace("Student ", "", trim((string)$cells[0]));
                if ($studentId === '') continue;
                $students[$studentId] = [
                    'student_id' => $studentId,
                    'scores' => [],
                    'performance' => []
                ];

                foreach ($cells as $colIndex => $value) {
                    if ($colIndex === 0) continue;
                    if (!isset($questions[$colIndex])) continue;
                    
                    $students[$studentId]['scores'][] = [
                        "question_id" => $colIndex,
                        "score" => is_numeric($value) ? (float)$value : null                        
                    ];
                }
            }
        }
        
        $result = $this->analysisService->analyze($questions, $students);
        
        $this->questionRepo->update($result['questions']);
        $this->studentRepo->update($result['students']);

        $this->reader->close();
        
        return [];
    }
}