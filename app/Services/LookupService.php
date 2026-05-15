<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ChapterModel;
use App\Models\KnowledgeEntryModel;
use App\Models\LegalProvisionModel;
use App\Models\SourceDocumentModel;
use App\Models\SubjectModel;
use App\Models\TopicModel;

final class LookupService
{
    public function all(): array
    {
        return [
            'subjects' => (new SubjectModel())->options(),
            'chapters' => (new ChapterModel())->options(),
            'topics' => (new TopicModel())->options(),
            'provisions' => (new LegalProvisionModel())->options(),
            'knowledgeEntries' => (new KnowledgeEntryModel())->options(),
            'sourceDocuments' => (new SourceDocumentModel())->options(),
        ];
    }
}
