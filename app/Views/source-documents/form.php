<?php $document = $document ?? []; ?>

<form method="post" enctype="multipart/form-data" action="<?= e(url($document ? '/source-documents/update/' . $document['id'] : '/source-documents/store')) ?>" class="app-card">
    <?= csrf_field() ?>
    <div class="section-heading mb-4">
        <div>
            <span class="eyebrow">Document Intake</span>
            <h3><?= $document ? 'Update source document record' : 'Upload source document' ?></h3>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Title</label>
            <input class="form-control" name="title" value="<?= e(old('title', $document['title'] ?? '')) ?>" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Document Type</label>
            <select class="form-select" name="document_type" required>
                <?php foreach (['PDF', 'Notes', 'Template', 'Act', 'Case Law', 'Circular', 'Checklist', 'Draft'] as $type): ?>
                    <option value="<?= e($type) ?>" <?= selected(old('document_type', $document['document_type'] ?? 'PDF'), $type) ?>><?= e($type) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Extraction Status</label>
            <select class="form-select" name="extraction_status">
                <?php foreach (['Pending', 'Manual Review', 'Processed'] as $status): ?>
                    <option value="<?= e($status) ?>" <?= selected(old('extraction_status', $document['extraction_status'] ?? 'Pending'), $status) ?>><?= e($status) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Upload File</label>
            <input class="form-control" type="file" name="upload_file" accept=".pdf,.doc,.docx,.txt,.md,.csv">
            <?php if (! empty($document['file_name'])): ?>
                <small class="text-muted d-block mt-2">Current file: <?= e($document['file_name']) ?></small>
            <?php endif; ?>
        </div>
        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea class="form-control" rows="3" name="description"><?= e(old('description', $document['description'] ?? '')) ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Extracted Text</label>
            <textarea class="form-control" rows="6" name="extracted_text"><?= e(old('extracted_text', $document['extracted_text'] ?? '')) ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Manual Notes</label>
            <textarea class="form-control" rows="6" name="manual_notes"><?= e(old('manual_notes', $document['manual_notes'] ?? '')) ?></textarea>
        </div>
        <div class="col-12">
            <label class="form-label">Metadata Tags</label>
            <input class="form-control" name="tag_string" value="<?= e(old('tag_string', $tagString)) ?>" placeholder="pdf, bare-act, annual-filing, drafting-sample">
        </div>
    </div>

    <div class="form-actions">
        <a class="btn btn-outline-secondary" href="<?= e(url('/source-documents')) ?>">Back</a>
        <button class="btn btn-primary" type="submit"><?= $document ? 'Update Document' : 'Save Document' ?></button>
    </div>
</form>
