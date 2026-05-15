<?php $subject = $subject ?? []; ?>

<form method="post" action="<?= e(url($subject ? '/subjects/update/' . $subject['id'] : '/subjects/store')) ?>" class="app-card">
    <?= csrf_field() ?>
    <div class="section-heading mb-4">
        <div>
            <span class="eyebrow">Subject Builder</span>
            <h3><?= $subject ? 'Update subject metadata' : 'Create a new subject domain' ?></h3>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-3">
            <label class="form-label">Code</label>
            <input class="form-control" name="code" value="<?= e(old('code', $subject['code'] ?? '')) ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Subject Name</label>
            <input class="form-control" name="name" value="<?= e(old('name', $subject['name'] ?? '')) ?>" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Display Order</label>
            <input class="form-control" name="display_order" type="number" value="<?= e(old('display_order', $subject['display_order'] ?? 0)) ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Domain Type</label>
            <input class="form-control" name="domain_type" value="<?= e(old('domain_type', $subject['domain_type'] ?? 'CS Executive')) ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Syllabus Version</label>
            <input class="form-control" name="syllabus_version" value="<?= e(old('syllabus_version', $subject['syllabus_version'] ?? '2026')) ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Status</label>
            <select class="form-select" name="status">
                <?php foreach (['Active', 'Draft', 'Archived'] as $status): ?>
                    <option value="<?= e($status) ?>" <?= selected(old('status', $subject['status'] ?? 'Active'), $status) ?>><?= e($status) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea class="form-control" rows="5" name="description"><?= e(old('description', $subject['description'] ?? '')) ?></textarea>
        </div>
    </div>

    <div class="form-actions">
        <a class="btn btn-outline-secondary" href="<?= e(url('/subjects')) ?>">Back</a>
        <button class="btn btn-primary" type="submit"><?= $subject ? 'Update Subject' : 'Create Subject' ?></button>
    </div>
</form>
