<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class KnowledgeEntryModel extends Model
{
    protected string $table = 'knowledge_entries';

    protected bool $versioned = true;

    protected string $entityType = 'knowledge_entry';

    protected array $fillable = [
        'subject_id',
        'chapter_id',
        'topic_id',
        'legal_provision_id',
        'source_document_id',
        'entry_type',
        'title',
        'summary',
        'content_html',
        'key_takeaways',
        'exam_relevance',
        'difficulty',
        'ai_ready',
        'ai_label',
        'revision_tags',
        'compliance_map',
        'citation_reference',
        'status',
        'version_no',
        'created_by',
    ];

    public function listDetailed(): array
    {
        return $this->db->select(
            'SELECT k.*,
                    s.name AS subject_name,
                    c.title AS chapter_name,
                    t.title AS topic_name,
                    lp.reference_code,
                    sd.title AS source_title
             FROM knowledge_entries k
             INNER JOIN subjects s ON s.id = k.subject_id
             INNER JOIN chapters c ON c.id = k.chapter_id
             INNER JOIN topics t ON t.id = k.topic_id
             LEFT JOIN legal_provisions lp ON lp.id = k.legal_provision_id
             LEFT JOIN source_documents sd ON sd.id = k.source_document_id
             ORDER BY k.updated_at DESC'
        );
    }

    public function options(): array
    {
        return $this->db->select('SELECT id, title FROM knowledge_entries ORDER BY updated_at DESC, title ASC');
    }

    public function aiReadyCount(): int
    {
        $row = $this->db->selectOne('SELECT COUNT(*) AS aggregate FROM knowledge_entries WHERE ai_ready = 1');
        return (int) ($row['aggregate'] ?? 0);
    }
}
