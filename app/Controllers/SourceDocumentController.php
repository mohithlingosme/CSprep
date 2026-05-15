<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\SourceDocumentModel;
use App\Services\TagService;

final class SourceDocumentController extends Controller
{
    public function index(): void
    {
        $this->render('source-documents/index', [
            'title' => 'Source Document Intake',
            'documents' => (new SourceDocumentModel())->listDetailed(),
        ]);
    }

    public function create(): void
    {
        $this->render('source-documents/form', [
            'title' => 'Upload Source Document',
            'document' => null,
            'tagString' => '',
        ]);
    }

    public function store(): void
    {
        $this->requirePost();
        remember_old($_POST);

        $errors = $this->requireFields([
            'title' => 'Document title',
            'document_type' => 'Document type',
        ]);

        if ($errors) {
            flash('message', ['text' => implode(' ', $errors), 'level' => 'danger']);
            redirect_to('/source-documents/create');
        }

        $payload = $this->payload();
        $id = (new SourceDocumentModel())->create($payload);
        (new TagService())->sync('source_document', $id, (string) $this->input('tag_string'));

        clear_old();
        $this->redirect('/source-documents', 'Source document saved successfully.');
    }

    public function edit(int $id): void
    {
        $document = (new SourceDocumentModel())->find($id);
        if (! $document) {
            $this->redirect('/source-documents', 'Document not found.', 'danger');
        }

        $this->render('source-documents/form', [
            'title' => 'Edit Source Document',
            'document' => $document,
            'tagString' => (new TagService())->getTagString('source_document', $id),
        ]);
    }

    public function update(int $id): void
    {
        $this->requirePost();
        remember_old($_POST);

        $model = new SourceDocumentModel();
        $existing = $model->find($id);
        if (! $existing) {
            $this->redirect('/source-documents', 'Document not found.', 'danger');
        }

        $payload = $this->payload($existing);
        $model->update($id, $payload);
        (new TagService())->sync('source_document', $id, (string) $this->input('tag_string'));

        clear_old();
        $this->redirect('/source-documents', 'Source document updated successfully.');
    }

    public function delete(int $id): void
    {
        $this->requirePost();
        $model = new SourceDocumentModel();
        $document = $model->find($id);
        if ($document && ! empty($document['file_path'])) {
            $fullPath = dirname(__DIR__, 2) . '/' . ltrim($document['file_path'], '/');
            if (is_file($fullPath)) {
                unlink($fullPath);
            }
        }

        $model->delete($id);
        $this->redirect('/source-documents', 'Source document deleted successfully.');
    }

    private function payload(array $existing = []): array
    {
        $upload = $this->handleUpload();

        return [
            'title' => $this->input('title'),
            'document_type' => $this->input('document_type'),
            'file_name' => $upload['file_name'] ?? ($existing['file_name'] ?? null),
            'file_path' => $upload['file_path'] ?? ($existing['file_path'] ?? null),
            'mime_type' => $upload['mime_type'] ?? ($existing['mime_type'] ?? null),
            'file_size' => $upload['file_size'] ?? ($existing['file_size'] ?? null),
            'description' => $this->input('description'),
            'extraction_status' => $this->input('extraction_status', 'Pending'),
            'extracted_text' => $this->input('extracted_text'),
            'manual_notes' => $this->input('manual_notes'),
            'tags' => $this->input('tag_string'),
            'uploaded_by' => (int) (current_user()['id'] ?? 1),
        ];
    }

    private function handleUpload(): array
    {
        if (! isset($_FILES['upload_file']) || ($_FILES['upload_file']['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return [];
        }

        $file = $_FILES['upload_file'];
        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            throw new \RuntimeException('File upload failed.');
        }

        $directory = config('storage.uploads');
        if (! is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        $originalName = (string) $file['name'];
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $safeName = date('YmdHis') . '-' . slugify(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . strtolower($extension);
        $targetPath = rtrim($directory, '/\\') . DIRECTORY_SEPARATOR . $safeName;

        move_uploaded_file((string) $file['tmp_name'], $targetPath);

        return [
            'file_name' => $originalName,
            'file_path' => 'storage/uploads/' . $safeName,
            'mime_type' => mime_content_type($targetPath) ?: ($file['type'] ?? null),
            'file_size' => (int) $file['size'],
        ];
    }
}
