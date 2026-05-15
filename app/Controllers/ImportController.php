<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\ImportLogModel;
use App\Services\ImportService;

final class ImportController extends Controller
{
    public function index(): void
    {
        $this->render('imports/index', [
            'title' => 'Bulk Import Console',
            'logs' => (new ImportLogModel())->latest(20),
            'modules' => [
                'subjects',
                'chapters',
                'topics',
                'legal_provisions',
                'knowledge',
                'case_laws',
                'study_items',
                'compliance',
            ],
        ]);
    }

    public function upload(): void
    {
        $this->requirePost();

        $module = (string) $this->input('module_name');
        if (! isset($_FILES['csv_file']) || ($_FILES['csv_file']['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            $this->redirect('/imports', 'Please choose a CSV file.', 'danger');
        }

        $recordsImported = (new ImportService())->importCsv($module, (string) $_FILES['csv_file']['tmp_name']);
        $this->redirect('/imports', "Imported {$recordsImported} rows into {$module}.");
    }
}
