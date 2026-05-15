<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class SourceDocumentModel extends Model
{
    protected string $table = 'source_documents';

    protected array $fillable = [
        'title',
        'document_type',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
        'description',
        'extraction_status',
        'extracted_text',
        'manual_notes',
        'tags',
        'uploaded_by',
    ];

    public function listDetailed(): array
    {
        return $this->db->select(
            'SELECT sd.*, u.name AS uploader_name
             FROM source_documents sd
             LEFT JOIN users u ON u.id = sd.uploaded_by
             ORDER BY sd.created_at DESC'
        );
    }

    public function options(): array
    {
        return $this->db->select('SELECT id, title FROM source_documents ORDER BY created_at DESC, title ASC');
    }
}
