<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class ChapterModel extends Model
{
    protected string $table = 'chapters';

    protected array $fillable = [
        'subject_id',
        'code',
        'title',
        'weightage',
        'study_order',
        'dependency_notes',
        'summary',
    ];

    public function listDetailed(): array
    {
        return $this->db->select(
            'SELECT c.*, s.name AS subject_name, COUNT(t.id) AS topic_count
             FROM chapters c
             INNER JOIN subjects s ON s.id = c.subject_id
             LEFT JOIN topics t ON t.chapter_id = c.id
             GROUP BY c.id
             ORDER BY s.display_order ASC, c.study_order ASC, c.title ASC'
        );
    }

    public function options(): array
    {
        return $this->db->select(
            'SELECT c.id, c.title, s.name AS subject_name
             FROM chapters c
             INNER JOIN subjects s ON s.id = c.subject_id
             ORDER BY s.display_order ASC, c.study_order ASC, c.title ASC'
        );
    }
}
