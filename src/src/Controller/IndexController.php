<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\FileUploadService;
use App\Parser\XlsxParser;
use App\Repository\QuestionRepositoryInterface;
use App\Repository\StudentRepositoryInterface;
use App\Service\AnalysisService;

/**
 * Handles the landing page and the result upload flow for the assessment application.
 */
final class IndexController extends AbstractController
{
    /**
     * Creates the controller dependencies.
     *
     * @param FileUploadService $uploadService Handles validation and persistence for uploaded files.
     * @param XlsxParser $parser Parses uploaded spreadsheet results.
     * @param QuestionRepositoryInterface $questionRepo Provides access to persisted question data.
     * @param StudentRepositoryInterface $studentRepo Provides access to persisted student data.
     */
    public function __construct(
        private FileUploadService $uploadService,
        private XlsxParser $parser,
        private QuestionRepositoryInterface $questionRepo,
        private StudentRepositoryInterface $studentRepo
    ) {}

    /**
     * Renders the page and processes a posted result file if one is provided.
     *
     * @param Request $request The incoming HTTP request.
     * @return Response The rendered index page or redirect response.
     */
    #[Route('/', name: 'index_page', methods: ['GET','POST'])]
    public function __invoke(Request $request): Response
    {
        if ($request->isMethod('POST') && $request->files->has('results')) {
            $file = $request->files->get('results');

            if (!$file) {
                $this->addFlash('danger', 'Please select a file.');
                return $this->redirectToRoute('index_page');
            }

            try {
                // Validate + store file
                $storedPath = $this->uploadService->handle($file);

                // Parse XLSX
                $this->parser->parse($storedPath);

            } catch (\Throwable $e) {
                // Convert validator/runtime errors into user-friendly messages
                $this->addFlash('danger', $e->getMessage());
                return $this->redirectToRoute('index_page');
            }

            $this->parser->parse($storedPath);
        }

        return $this->render('index.html.twig', [
            'questions' => $this->questionRepo->getAll(),
            'students' => $this->studentRepo->getAll()
        ]);
    }
}