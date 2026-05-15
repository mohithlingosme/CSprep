<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class SubjectModel extends Model
{
    protected string $table = 'subjects';

    protected array $fillable = [
        'code',
        'name',
        'slug',
        'domain_type',
        'description',
        'syllabus_version',
        'status',
        'display_order',
    ];

    public function listDetailed(): array
    {
        return $this->db->select(
            'SELECT s.*,
                    COUNT(DISTINCT c.id) AS chapter_count,
                    COUNT(DISTINCT t.id) AS topic_count,
                    COUNT(DISTINCT k.id) AS knowledge_count
             FROM subjects s
             LEFT JOIN chapters c ON c.subject_id = s.id
             LEFT JOIN topics t ON t.chapter_id = c.id
             LEFT JOIN knowledge_entries k ON k.subject_id = s.id
             GROUP BY s.id
             ORDER BY s.display_order ASC, s.name ASC'
        );
    }

    public function options(): array
    {
        return $this->db->select('SELECT id, name FROM subjects ORDER BY display_order ASC, name ASC');
    }
}
