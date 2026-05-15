<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Services\ExportService;

final class ExportController extends Controller
{
    public function index(): void
    {
        $this->render('exports/index', [
            'title' => 'AI Export Studio',
            'datasets' => [
                'subjects',
                'chapters',
                'topics',
                'legal_provisions',
                'knowledge',
                'case_laws',
                'study_items',
                'compliance',
                'source_documents',
                'full_corpus',
                'ai_jsonl',
            ],
            'formats' => ['json', 'jsonl', 'csv', 'markdown', 'xml', 'sql'],
        ]);
    }

    public function download(): void
    {
        $dataset = (string) $this->input('dataset', 'knowledge');
        $format = (string) $this->input('format', 'json');

        if ($format === 'sql') {
            $path = dirname(__DIR__, 2) . '/database/schema.sql';
            header('Content-Type: application/sql');
            header('Content-Disposition: attachment; filename="corporate-law-schema.sql"');
            readfile($path);
            exit;
        }

        $service = new ExportService();
        $data = $service->getDataset($dataset);

        if ($dataset === 'full_corpus' && $format !== 'json') {
            $format = 'json';
        }

        $content = match ($format) {
            'json' => $service->toJson($data),
            'jsonl' => $service->toJsonl(is_array($data) ? array_values($data) : []),
            'csv' => $service->toCsv(is_array($data) ? array_values($data) : []),
            'markdown' => $service->toMarkdown(is_array($data) ? array_values($data) : [], strtoupper(str_replace('_', ' ', $dataset))),
            'xml' => $service->toXml(is_array($data) ? array_values($data) : []),
            default => $service->toJson($data),
        };

        $mime = match ($format) {
            'json' => 'application/json',
            'jsonl' => 'application/x-ndjson',
            'csv' => 'text/csv',
            'markdown' => 'text/markdown',
            'xml' => 'application/xml',
            default => 'text/plain',
        };

        header('Content-Type: ' . $mime);
        header('Content-Disposition: attachment; filename="' . $dataset . '.' . ($format === 'markdown' ? 'md' : $format) . '"');
        echo $content;
        exit;
    }
}
