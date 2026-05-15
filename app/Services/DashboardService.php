<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use App\Models\CaseLawModel;
use App\Models\ComplianceObligationModel;
use App\Models\KnowledgeEntryModel;
use App\Models\LegalProvisionModel;
use App\Models\SourceDocumentModel;
use App\Models\StudyItemModel;
use App\Models\SubjectModel;
use App\Models\TopicModel;

final class DashboardService
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::instance();
    }

    public function metrics(): array
    {
        $subjectModel = new SubjectModel();
        $topicModel = new TopicModel();
        $knowledgeModel = new KnowledgeEntryModel();
        $provisionModel = new LegalProvisionModel();
        $caseLawModel = new CaseLawModel();
        $studyItemModel = new StudyItemModel();
        $complianceModel = new ComplianceObligationModel();
        $sourceModel = new SourceDocumentModel();

        $topicCoverage = $this->db->selectOne(
            'SELECT
                COUNT(*) AS total_topics,
                SUM(CASE WHEN next_revision_at IS NOT NULL THEN 1 ELSE 0 END) AS revision_mapped,
                AVG(mastery_score) AS avg_mastery
             FROM topics'
        );

        $aiCoverage = $this->db->selectOne(
            'SELECT
                COUNT(*) AS total_entries,
                SUM(CASE WHEN ai_ready = 1 THEN 1 ELSE 0 END) AS ai_ready_total
             FROM knowledge_entries'
        );

        $mockAverage = $this->db->selectOne(
            'SELECT AVG((score / NULLIF(total_marks, 0)) * 100) AS average_score
             FROM mock_attempts'
        );

        $overdue = $this->db->selectOne(
            'SELECT COUNT(*) AS total
             FROM compliance_obligations
             WHERE due_date IS NOT NULL AND due_date < CURDATE() AND status <> "Completed"'
        );

        return [
            'founder' => [
                'subjects' => $subjectModel->count(),
                'topics' => $topicModel->count(),
                'knowledge_entries' => $knowledgeModel->count(),
                'legal_provisions' => $provisionModel->count(),
                'case_laws' => $caseLawModel->count(),
                'study_items' => $studyItemModel->count(),
                'source_documents' => $sourceModel->count(),
                'compliance_items' => $complianceModel->count(),
                'ai_ready' => (int) ($aiCoverage['ai_ready_total'] ?? 0),
                'ai_readiness_pct' => (int) round(
                    ((int) ($aiCoverage['ai_ready_total'] ?? 0) / max(1, (int) ($aiCoverage['total_entries'] ?? 0))) * 100
                ),
                'revision_mapped_pct' => (int) round(
                    ((int) ($topicCoverage['revision_mapped'] ?? 0) / max(1, (int) ($topicCoverage['total_topics'] ?? 0))) * 100
                ),
            ],
            'student' => [
                'average_mastery' => (int) round((float) ($topicCoverage['avg_mastery'] ?? 0)),
                'mock_average' => (int) round((float) ($mockAverage['average_score'] ?? 0)),
                'weak_topics' => $topicModel->weakTopics(),
                'revision_tasks' => $this->db->select(
                    'SELECT rt.*, t.title AS topic_name
                     FROM revision_tasks rt
                     LEFT JOIN topics t ON t.id = rt.topic_id
                     ORDER BY rt.task_date ASC
                     LIMIT 8'
                ),
                'mock_attempts' => $this->db->select(
                    'SELECT * FROM mock_attempts ORDER BY attempted_on DESC LIMIT 6'
                ),
            ],
            'corporate' => [
                'overdue' => (int) ($overdue['total'] ?? 0),
                'due_soon' => $complianceModel->dueSoon(),
                'status_breakdown' => $complianceModel->statusBreakdown(),
            ],
            'latest' => [
                'knowledge' => $knowledgeModel->latest(),
                'case_laws' => $caseLawModel->latest(),
                'documents' => $sourceModel->latest(),
            ],
        ];
    }
}
