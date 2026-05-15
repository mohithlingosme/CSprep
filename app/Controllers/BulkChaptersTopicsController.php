<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\SubjectModel;
use App\Services\BulkSyllabusService;

final class BulkChaptersTopicsController extends Controller
{
    public function index(): void
    {
        $subjects = (new SubjectModel())->options();

        $this->render('imports/bulk-chapters-topics', [
            'title' => 'Bulk Add Chapters & Topics',
            'subjects' => $subjects,
            'selected_subject_id' => (int) $this->input('subject_id', 0),
            'inputValue' => (string) $this->input('bulk_text', ''),
            'preview' => null,
        ]);
    }

    public function handle(): void
    {
        $this->requirePost();

        $subjectId = (int) $this->input('subject_id', 0);
        $bulkText = (string) $this->input('bulk_text', '');
        $action = (string) $this->input('action', 'preview');

        $subjects = (new SubjectModel())->options();
        $service = new BulkSyllabusService();

        $validActions = ['preview', 'import'];
        if (! in_array($action, $validActions, true)) {
            $this->render('imports/bulk-chapters-topics', [
                'title' => 'Bulk Add Chapters & Topics',
                'subjects' => $subjects,
                'selected_subject_id' => $subjectId,
                'inputValue' => $bulkText,
                'preview' => null,
                'error' => 'Invalid action requested.',
            ]);
            return;
        }

        try {
            if ($action === 'preview') {
                $preview = $service->preview($subjectId, $bulkText);

                $this->render('imports/bulk-chapters-topics', [
                    'title' => 'Bulk Add Chapters & Topics',
                    'subjects' => $subjects,
                    'selected_subject_id' => $subjectId,
                    'inputValue' => $bulkText,
                    'preview' => $preview,
                ]);
                return;
            }

            $result = $service->import($subjectId, $bulkText);
            $this->redirect('/imports', 'Bulk import completed. Inserted chapters: ' . ($result['inserted']['chapters'] ?? 0) . ', topics: ' . ($result['inserted']['topics'] ?? 0) . '.');
        } catch (\Throwable $e) {
            $this->render('imports/bulk-chapters-topics', [
                'title' => 'Bulk Add Chapters & Topics',
                'subjects' => $subjects,
                'selected_subject_id' => $subjectId,
                'inputValue' => $bulkText,
                'preview' => $service->preview($subjectId, $bulkText),
                'error' => $e->getMessage(),
            ]);
        }
    }
}



