<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class CaseLawModel extends Model
{
    protected string $table = 'case_laws';

    protected bool $versioned = true;

    protected string $entityType = 'case_law';

    protected array $fillable = [
        'subject_id',
        'topic_id',
        'legal_provision_id',
        'case_name',
        'citation',
        'court_name',
        'court_level',
        'case_year',
        'facts',
        'issues',
        'held_text',
        'legal_principles',
        'exam_relevance',
        'linked_sections',
    ];

    public function listDetailed(): array
    {
        return $this->db->select(
            'SELECT cl.*, s.name AS subject_name, t.title AS topic_name
             FROM case_laws cl
             INNER JOIN subjects s ON s.id = cl.subject_id
             LEFT JOIN topics t ON t.id = cl.topic_id
             ORDER BY cl.case_year DESC, cl.case_name ASC'
        );
    }
}
