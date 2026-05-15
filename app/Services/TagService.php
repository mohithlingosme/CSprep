<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

final class TagService
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::instance();
    }

    public function sync(string $entityType, int $entityId, string $tagString): void
    {
        $tags = array_filter(array_map(
            static fn (string $tag): string => trim($tag),
            explode(',', $tagString)
        ));

        $this->db->execute(
            'DELETE FROM entity_tags WHERE entity_type = :entity_type AND entity_id = :entity_id',
            ['entity_type' => $entityType, 'entity_id' => $entityId]
        );

        foreach ($tags as $tagName) {
            $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $tagName), '-'));
            $tag = $this->db->selectOne('SELECT id FROM tags WHERE slug = :slug LIMIT 1', ['slug' => $slug]);
            if (! $tag) {
                $this->db->execute(
                    'INSERT INTO tags (name, slug, created_at, updated_at)
                     VALUES (:name, :slug, :created_at, :updated_at)',
                    [
                        'name' => $tagName,
                        'slug' => $slug,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]
                );
                $tagId = $this->db->lastInsertId();
            } else {
                $tagId = (int) $tag['id'];
            }

            $this->db->execute(
                'INSERT INTO entity_tags (tag_id, entity_type, entity_id, created_at)
                 VALUES (:tag_id, :entity_type, :entity_id, :created_at)',
                [
                    'tag_id' => $tagId,
                    'entity_type' => $entityType,
                    'entity_id' => $entityId,
                    'created_at' => date('Y-m-d H:i:s'),
                ]
            );
        }
    }

    public function getTagString(string $entityType, int $entityId): string
    {
        $rows = $this->db->select(
            'SELECT t.name
             FROM entity_tags et
             INNER JOIN tags t ON t.id = et.tag_id
             WHERE et.entity_type = :entity_type AND et.entity_id = :entity_id
             ORDER BY t.name ASC',
            ['entity_type' => $entityType, 'entity_id' => $entityId]
        );

        return implode(', ', array_column($rows, 'name'));
    }
}
