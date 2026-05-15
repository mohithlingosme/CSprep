<?php

declare(strict_types=1);

namespace App\Core;

abstract class Model
{
    protected Database $db;

    protected string $table;

    protected string $primaryKey = 'id';

    protected array $fillable = [];

    protected bool $versioned = false;

    protected string $entityType = '';

    public function __construct()
    {
        $this->db = Database::instance();
    }

    public function count(): int
    {
        $row = $this->db->selectOne("SELECT COUNT(*) AS aggregate FROM {$this->table}");
        return (int) ($row['aggregate'] ?? 0);
    }

    public function all(string $orderBy = 'id DESC'): array
    {
        return $this->db->select("SELECT * FROM {$this->table} ORDER BY {$orderBy}");
    }

    public function find(int $id): ?array
    {
        return $this->db->selectOne(
            "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1",
            ['id' => $id]
        );
    }

    public function latest(int $limit = 5): array
    {
        return $this->db->select("SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT {$limit}");
    }

    public function create(array $data): int
    {
        $payload = $this->filterFillable($data);
        $payload['created_at'] = date('Y-m-d H:i:s');
        $payload['updated_at'] = date('Y-m-d H:i:s');

        $columns = array_keys($payload);
        $placeholders = array_map(static fn (string $column): string => ':' . $column, $columns);

        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );

        $this->db->execute($sql, $payload);
        return $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $existing = $this->find($id);
        if (! $existing) {
            return false;
        }

        if ($this->versioned) {
            $this->createVersionSnapshot($id, $existing);
        }

        $payload = $this->filterFillable($data);
        $payload['updated_at'] = date('Y-m-d H:i:s');
        if (array_key_exists('version_no', $existing)) {
            $payload['version_no'] = ((int) $existing['version_no']) + 1;
        }

        $assignments = [];
        foreach (array_keys($payload) as $column) {
            $assignments[] = "{$column} = :{$column}";
        }

        $payload['id'] = $id;

        return $this->db->execute(
            sprintf(
                'UPDATE %s SET %s WHERE %s = :id',
                $this->table,
                implode(', ', $assignments),
                $this->primaryKey
            ),
            $payload
        );
    }

    public function delete(int $id): bool
    {
        return $this->db->execute(
            "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id",
            ['id' => $id]
        );
    }

    protected function filterFillable(array $data): array
    {
        $payload = [];

        foreach ($this->fillable as $field) {
            if (array_key_exists($field, $data)) {
                $payload[$field] = $data[$field];
            }
        }

        return $payload;
    }

    protected function createVersionSnapshot(int $id, array $existing): void
    {
        $nextVersion = $this->db->selectOne(
            'SELECT COALESCE(MAX(version_no), 0) + 1 AS next_version
             FROM content_versions
             WHERE entity_type = :entity_type AND entity_id = :entity_id',
            [
                'entity_type' => $this->entityType ?: $this->table,
                'entity_id' => $id,
            ]
        );

        $this->db->execute(
            'INSERT INTO content_versions (entity_type, entity_id, version_no, snapshot_json, changed_at)
             VALUES (:entity_type, :entity_id, :version_no, :snapshot_json, :changed_at)',
            [
                'entity_type' => $this->entityType ?: $this->table,
                'entity_id' => $id,
                'version_no' => (int) ($nextVersion['next_version'] ?? 1),
                'snapshot_json' => json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                'changed_at' => date('Y-m-d H:i:s'),
            ]
        );
    }
}
