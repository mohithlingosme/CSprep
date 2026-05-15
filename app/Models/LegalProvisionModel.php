<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class LegalProvisionModel extends Model
{
    protected string $table = 'legal_provisions';

    protected bool $versioned = true;

    protected string $entityType = 'legal_provision';

    protected array $fillable = [
        'subject_id',
        'topic_id',
        'framework_type',
        'reference_code',
        'title',
        'act_name',
        'bare_text',
        'simplified_text',
        'compliance_checklist',
        'drafting_notes',
        'penalties',
        'forms_involved',
        'effective_date',
        'amendment_notes',
        'ai_labels',
        'status',
    ];

    public function listDetailed(): array
    {
        return $this->db->select(
            'SELECT lp.*, s.name AS subject_name, t.title AS topic_name
             FROM legal_provisions lp
             INNER JOIN subjects s ON s.id = lp.subject_id
             LEFT JOIN topics t ON t.id = lp.topic_id
             ORDER BY lp.effective_date DESC, lp.reference_code ASC'
        );
    }

    public function options(): array
    {
        return $this->db->select(
            'SELECT id, CONCAT(reference_code, " - ", title) AS name
             FROM legal_provisions
             ORDER BY reference_code ASC, title ASC'
        );
    }
}
