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

    public function listDetailedWithFilters(array $filters = []): array
    {
        $chapterId = isset($filters['chapter_id']) && (string) $filters['chapter_id'] !== '' ? (int) $filters['chapter_id'] : null;
        $provisionQuery = isset($filters['provision_query']) ? trim((string) $filters['provision_query']) : '';

        $sort = isset($filters['sort']) ? (string) $filters['sort'] : 'default';
        $dir = strtolower((string) ($filters['dir'] ?? 'asc'));
        $dir = $dir === 'desc' ? 'DESC' : 'ASC';

        $orderBy = 's.display_order ASC, c.study_order ASC, t.title ASC';
        if ($sort !== 'default') {
            $allowed = [
                'title' => 't.title',
                'mastery_score' => 't.mastery_score',
                'exam_relevance' => 't.exam_relevance',
                'revision_interval_days' => 't.revision_interval_days',
                'updated_at' => 't.updated_at',
            ];
            if (isset($allowed[$sort])) {
                $orderBy = $allowed[$sort] . ' ' . $dir . ', s.display_order ASC, c.study_order ASC, t.title ASC';
            }
        }

        $params = [];

        $where = '1=1';
        if ($chapterId !== null) {
            $where .= ' AND t.chapter_id = :chapter_id';
            $params['chapter_id'] = $chapterId;
        }

        $joinProvision = 'LEFT JOIN legal_provisions lp ON lp.topic_id = t.id AND lp.subject_id = s.id';

        if ($provisionQuery !== '') {
            $where .= ' AND (
                lp.reference_code LIKE :provision_like OR
                lp.act_name LIKE :provision_like OR
                lp.title LIKE :provision_like
            )';
            $params['provision_like'] = '%' . $provisionQuery . '%';
        }

        return $this->db->select(
            "SELECT
                t.*, c.title AS chapter_name, s.name AS subject_name, parent.title AS parent_topic,
                SUM(CASE WHEN lp.id IS NOT NULL THEN 1 ELSE 0 END) AS provision_count
             FROM topics t
             INNER JOIN chapters c ON c.id = t.chapter_id
             INNER JOIN subjects s ON s.id = c.subject_id
             LEFT JOIN topics parent ON parent.id = t.parent_id
             {$joinProvision}
             WHERE {$where}
             GROUP BY t.id
             ORDER BY {$orderBy}"
            ,
            $params
        );

    }

    public function provisionGroupsByTopicIds(array $topicIds): array
    {
        $topicIds = array_values(array_filter(array_map(static fn ($v) => (int) $v, $topicIds), static fn (int $v) => $v > 0));
        if (! $topicIds) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($topicIds), '?'));

        $rows = $this->db->select(
            "SELECT
                lp.*, lp.id AS provision_id,
                t.id AS topic_id,
                t.title AS topic_name,
                s.name AS subject_name
             FROM legal_provisions lp
             INNER JOIN topics t ON t.id = lp.topic_id
             INNER JOIN subjects s ON s.id = lp.subject_id
             WHERE lp.topic_id IN ({$placeholders})
             ORDER BY lp.effective_date DESC, lp.reference_code ASC",
            $topicIds
        );

        $groups = [];
        foreach ($rows as $row) {
            $topicId = (int) ($row['topic_id'] ?? 0);
            if (! isset($groups[$topicId])) {
                $groups[$topicId] = [];
            }
            $groups[$topicId][] = $row;
        }

        return $groups;
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

