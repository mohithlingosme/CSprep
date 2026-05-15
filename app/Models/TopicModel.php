<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class TopicModel extends Model
{
    protected string $table = 'topics';

    protected array $fillable = [
        'chapter_id',
        'parent_id',
        'title',
        'slug',
        'learning_objectives',
        'difficulty',
        'revision_interval_days',
        'mastery_score',
        'exam_relevance',
        'next_revision_at',
        'dependency_map',
    ];

    public function listDetailed(): array
    {
        return $this->db->select(
            'SELECT t.*,
                    c.title AS chapter_name,
                    s.name AS subject_name,
                    parent.title AS parent_topic
             FROM topics t
             INNER JOIN chapters c ON c.id = t.chapter_id
             INNER JOIN subjects s ON s.id = c.subject_id
             LEFT JOIN topics parent ON parent.id = t.parent_id
             ORDER BY s.display_order ASC, c.study_order ASC, t.title ASC'
        );
    }

    public function options(): array
    {
        return $this->db->select(
            'SELECT t.id, t.title, c.title AS chapter_name, s.name AS subject_name
             FROM topics t
             INNER JOIN chapters c ON c.id = t.chapter_id
             INNER JOIN subjects s ON s.id = c.subject_id
             ORDER BY s.display_order ASC, c.study_order ASC, t.title ASC'
        );
    }

    public function weakTopics(int $limit = 6): array
    {
        return $this->db->select(
            "SELECT t.*, c.title AS chapter_name, s.name AS subject_name
             FROM topics t
             INNER JOIN chapters c ON c.id = t.chapter_id
             INNER JOIN subjects s ON s.id = c.subject_id
             ORDER BY t.mastery_score ASC, t.exam_relevance DESC
             LIMIT {$limit}"
        );
    }
}
