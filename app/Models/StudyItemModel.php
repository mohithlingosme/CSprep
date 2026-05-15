<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class StudyItemModel extends Model
{
    protected string $table = 'study_items';

    protected array $fillable = [
        'subject_id',
        'topic_id',
        'knowledge_entry_id',
        'item_type',
        'prompt',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'explanation',
        'marks',
        'difficulty',
        'exam_year',
        'revision_bucket',
        'ai_ready',
    ];

    public function listDetailed(): array
    {
        return $this->db->select(
            'SELECT si.*, s.name AS subject_name, t.title AS topic_name, k.title AS knowledge_title
             FROM study_items si
             INNER JOIN subjects s ON s.id = si.subject_id
             LEFT JOIN topics t ON t.id = si.topic_id
             LEFT JOIN knowledge_entries k ON k.id = si.knowledge_entry_id
             ORDER BY si.updated_at DESC'
        );
    }
}
