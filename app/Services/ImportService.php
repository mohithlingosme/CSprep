<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\CaseLawModel;
use App\Models\ChapterModel;
use App\Models\ComplianceObligationModel;
use App\Models\ImportLogModel;
use App\Models\KnowledgeEntryModel;
use App\Models\LegalProvisionModel;
use App\Models\StudyItemModel;
use App\Models\SubjectModel;
use App\Models\TopicModel;

final class ImportService
{
    public function importCsv(string $module, string $filePath): int
    {
        $model = $this->resolveModel($module);
        $handle = fopen($filePath, 'r');
        if ($handle === false) {
            throw new \RuntimeException('Unable to open CSV file.');
        }

        $headers = fgetcsv($handle);
        if (! $headers) {
            fclose($handle);
            throw new \RuntimeException('CSV file is empty.');
        }

        $recordsImported = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $payload = [];
            foreach ($headers as $index => $header) {
                $payload[trim($header)] = $row[$index] ?? null;
            }

            if ($module === 'knowledge') {
                $payload['ai_ready'] = (int) ($payload['ai_ready'] ?? 0);
                $payload['created_by'] = (int) ($payload['created_by'] ?? 1);
                $payload['version_no'] = (int) ($payload['version_no'] ?? 1);
            }

            if ($module === 'study_items') {
                $payload['ai_ready'] = (int) ($payload['ai_ready'] ?? 0);
            }

            $model->create($payload);
            $recordsImported++;
        }

        fclose($handle);

        (new ImportLogModel())->create([
            'module_name' => $module,
            'file_name' => basename($filePath),
            'records_imported' => $recordsImported,
            'status' => 'Completed',
            'notes' => 'Imported via founder CSV workflow.',
        ]);

        return $recordsImported;
    }

    private function resolveModel(string $module): object
    {
        return match ($module) {
            'subjects' => new SubjectModel(),
            'chapters' => new ChapterModel(),
            'topics' => new TopicModel(),
            'legal_provisions' => new LegalProvisionModel(),
            'knowledge' => new KnowledgeEntryModel(),
            'case_laws' => new CaseLawModel(),
            'study_items' => new StudyItemModel(),
            'compliance' => new ComplianceObligationModel(),
            default => throw new \InvalidArgumentException('Unsupported import module.'),
        };
    }
}
