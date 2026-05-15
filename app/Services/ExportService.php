<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

final class ExportService
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::instance();
    }

    public function getDataset(string $dataset): array
    {
        return match ($dataset) {
            'subjects' => $this->db->select('SELECT * FROM subjects ORDER BY display_order ASC, name ASC'),
            'chapters' => $this->db->select('SELECT * FROM chapters ORDER BY study_order ASC, title ASC'),
            'topics' => $this->db->select('SELECT * FROM topics ORDER BY title ASC'),
            'legal_provisions' => $this->db->select('SELECT * FROM legal_provisions ORDER BY reference_code ASC'),
            'knowledge' => $this->db->select('SELECT * FROM knowledge_entries ORDER BY updated_at DESC'),
            'case_laws' => $this->db->select('SELECT * FROM case_laws ORDER BY case_year DESC, case_name ASC'),
            'study_items' => $this->db->select('SELECT * FROM study_items ORDER BY updated_at DESC'),
            'compliance' => $this->db->select('SELECT * FROM compliance_obligations ORDER BY due_date ASC'),
            'source_documents' => $this->db->select('SELECT * FROM source_documents ORDER BY created_at DESC'),
            'full_corpus' => [
                'subjects' => $this->db->select('SELECT * FROM subjects'),
                'chapters' => $this->db->select('SELECT * FROM chapters'),
                'topics' => $this->db->select('SELECT * FROM topics'),
                'legal_provisions' => $this->db->select('SELECT * FROM legal_provisions'),
                'knowledge_entries' => $this->db->select('SELECT * FROM knowledge_entries'),
                'case_laws' => $this->db->select('SELECT * FROM case_laws'),
                'study_items' => $this->db->select('SELECT * FROM study_items'),
                'compliance_obligations' => $this->db->select('SELECT * FROM compliance_obligations'),
                'source_documents' => $this->db->select('SELECT * FROM source_documents'),
                'content_versions' => $this->db->select('SELECT * FROM content_versions'),
                'knowledge_relations' => $this->db->select('SELECT * FROM knowledge_relations'),
            ],
            'ai_jsonl' => $this->aiCorpus(),
            default => [],
        };
    }

    public function toJson(array $data): string
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function toJsonl(array $data): string
    {
        $lines = [];

        foreach ($data as $row) {
            $lines[] = json_encode($row, JSON_UNESCAPED_UNICODE);
        }

        return implode(PHP_EOL, $lines);
    }

    public function toCsv(array $data): string
    {
        if ($data === []) {
            return '';
        }

        $stream = fopen('php://temp', 'r+');
        fputcsv($stream, array_keys($data[0]));
        foreach ($data as $row) {
            fputcsv($stream, $row);
        }
        rewind($stream);
        $csv = stream_get_contents($stream) ?: '';
        fclose($stream);

        return $csv;
    }

    public function toMarkdown(array $data, string $title): string
    {
        $markdown = '# ' . $title . PHP_EOL . PHP_EOL;

        foreach ($data as $row) {
            $heading = $row['title'] ?? $row['name'] ?? $row['case_name'] ?? $row['reference_code'] ?? 'Record';
            $markdown .= '## ' . $heading . PHP_EOL;
            foreach ($row as $key => $value) {
                $markdown .= '- **' . $key . ':** ' . str_replace(PHP_EOL, ' ', (string) $value) . PHP_EOL;
            }
            $markdown .= PHP_EOL;
        }

        return $markdown;
    }

    public function toXml(array $data, string $root = 'records'): string
    {
        $xml = new \SimpleXMLElement('<' . $root . '/>');
        foreach ($data as $row) {
            $record = $xml->addChild('record');
            foreach ($row as $key => $value) {
                $record->addChild($key, htmlspecialchars((string) $value));
            }
        }

        return $xml->asXML() ?: '';
    }

    private function aiCorpus(): array
    {
        $rows = $this->db->select(
            'SELECT k.id,
                    k.title,
                    k.summary,
                    k.content_html,
                    k.key_takeaways,
                    k.entry_type,
                    k.citation_reference,
                    k.ai_label,
                    s.name AS subject_name,
                    c.title AS chapter_name,
                    t.title AS topic_name
             FROM knowledge_entries k
             INNER JOIN subjects s ON s.id = k.subject_id
             INNER JOIN chapters c ON c.id = k.chapter_id
             INNER JOIN topics t ON t.id = k.topic_id
             WHERE k.status IN ("Published", "Review")'
        );

        $dataset = [];
        foreach ($rows as $row) {
            $dataset[] = [
                'id' => 'knowledge-' . $row['id'],
                'dataset' => 'corporate_law_training',
                'instruction' => 'Explain the corporate law concept in a structured, exam-ready and compliance-aware way.',
                'input' => sprintf(
                    'Subject: %s | Chapter: %s | Topic: %s | Type: %s | Title: %s | Citation: %s',
                    $row['subject_name'],
                    $row['chapter_name'],
                    $row['topic_name'],
                    $row['entry_type'],
                    $row['title'],
                    $row['citation_reference']
                ),
                'output' => trim(strip_tags(
                    'Summary: ' . ($row['summary'] ?? '') . PHP_EOL .
                    'Content: ' . ($row['content_html'] ?? '') . PHP_EOL .
                    'Key Takeaways: ' . ($row['key_takeaways'] ?? '')
                )),
                'metadata' => [
                    'ai_label' => $row['ai_label'],
                    'topic' => $row['topic_name'],
                    'subject' => $row['subject_name'],
                ],
            ];
        }

        return $dataset;
    }
}
