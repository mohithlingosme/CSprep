<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class ComplianceObligationModel extends Model
{
    protected string $table = 'compliance_obligations';

    protected array $fillable = [
        'subject_id',
        'topic_id',
        'provision_id',
        'title',
        'entity_type',
        'frequency',
        'due_date',
        'form_name',
        'regulator',
        'priority',
        'status',
        'description',
        'checklist',
        'penalty_risk',
        'owner_name',
    ];

    public function listDetailed(): array
    {
        return $this->db->select(
            'SELECT co.*, s.name AS subject_name, t.title AS topic_name, lp.reference_code
             FROM compliance_obligations co
             INNER JOIN subjects s ON s.id = co.subject_id
             LEFT JOIN topics t ON t.id = co.topic_id
             LEFT JOIN legal_provisions lp ON lp.id = co.provision_id
             ORDER BY co.due_date ASC, co.priority DESC'
        );
    }

    public function dueSoon(int $days = 30): array
    {
        return $this->db->select(
            "SELECT co.*, s.name AS subject_name
             FROM compliance_obligations co
             INNER JOIN subjects s ON s.id = co.subject_id
             WHERE co.due_date IS NOT NULL
               AND co.due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL {$days} DAY)
             ORDER BY co.due_date ASC"
        );
    }

    public function statusBreakdown(): array
    {
        return $this->db->select(
            'SELECT status, COUNT(*) AS total
             FROM compliance_obligations
             GROUP BY status
             ORDER BY total DESC'
        );
    }
}
