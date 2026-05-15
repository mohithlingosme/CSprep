<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

final class RelationService
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::instance();
    }

    public function syncFromLines(string $sourceType, int $sourceId, string $relationLines): void
    {
        $this->db->execute(
            'DELETE FROM knowledge_relations WHERE source_type = :source_type AND source_id = :source_id',
            ['source_type' => $sourceType, 'source_id' => $sourceId]
        );

        $lines = preg_split('/\r\n|\r|\n/', trim($relationLines));
        if (! $lines) {
            return;
        }

        foreach ($lines as $line) {
            if (trim($line) === '') {
                continue;
            }

            [$relationType, $targetType, $targetId, $notes] = array_pad(array_map('trim', explode('|', $line, 4)), 4, '');
            if ($relationType === '' || $targetType === '' || $targetId === '') {
                continue;
            }

            $this->db->execute(
                'INSERT INTO knowledge_relations
                (source_type, source_id, relation_type, target_type, target_id, notes, created_at)
                VALUES
                (:source_type, :source_id, :relation_type, :target_type, :target_id, :notes, :created_at)',
                [
                    'source_type' => $sourceType,
                    'source_id' => $sourceId,
                    'relation_type' => $relationType,
                    'target_type' => $targetType,
                    'target_id' => (int) $targetId,
                    'notes' => $notes,
                    'created_at' => date('Y-m-d H:i:s'),
                ]
            );
        }
    }

    public function getLines(string $sourceType, int $sourceId): string
    {
        $rows = $this->db->select(
            'SELECT relation_type, target_type, target_id, notes
             FROM knowledge_relations
             WHERE source_type = :source_type AND source_id = :source_id
             ORDER BY id ASC',
            ['source_type' => $sourceType, 'source_id' => $sourceId]
        );

        $lines = [];
        foreach ($rows as $row) {
            $lines[] = implode('|', [
                $row['relation_type'],
                $row['target_type'],
                $row['target_id'],
                $row['notes'],
            ]);
        }

        return implode(PHP_EOL, $lines);
    }
}
