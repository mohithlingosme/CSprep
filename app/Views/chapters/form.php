<?php $chapter = $chapter ?? []; ?>

<form method="post" action="<?= e(url($chapter ? '/chapters/update/' . $chapter['id'] : '/chapters/store')) ?>" class="app-card">
    <?= csrf_field() ?>
    <div class="section-heading mb-4">
        <div>
            <span class="eyebrow">Chapter Management</span>
            <h3><?= $chapter ? 'Update chapter structure' : 'Create a chapter' ?></h3>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Subject</label>
            <select class="form-select" name="subject_id" required>
                <option value="">Choose subject</option>
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?= e($subject['id']) ?>" <?= selected(old('subject_id', $chapter['subject_id'] ?? ''), $subject['id']) ?>><?= e($subject['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Code</label>
            <input class="form-control" name="code" value="<?= e(old('code', $chapter['code'] ?? '')) ?>">
        </div>
        <div class="col-md-5">
            <label class="form-label">Title</label>
            <input class="form-control" name="title" value="<?= e(old('title', $chapter['title'] ?? '')) ?>" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Weightage</label>
            <input class="form-control" name="weightage" value="<?= e(old('weightage', $chapter['weightage'] ?? '')) ?>" placeholder="15%">
        </div>
        <div class="col-md-3">
            <label class="form-label">Study Order</label>
            <input class="form-control" name="study_order" type="number" value="<?= e(old('study_order', $chapter['study_order'] ?? 0)) ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Dependency Notes</label>
            <input class="form-control" name="dependency_notes" value="<?= e(old('dependency_notes', $chapter['dependency_notes'] ?? '')) ?>" placeholder="Link prerequisite chapters or topics">
        </div>
        <div class="col-12">
            <label class="form-label">Summary</label>
            <textarea class="form-control" rows="5" name="summary"><?= e(old('summary', $chapter['summary'] ?? '')) ?></textarea>
        </div>
    </div>

    <div class="form-actions">
        <a class="btn btn-outline-secondary" href="<?= e(url('/chapters')) ?>">Back</a>
        <button class="btn btn-primary" type="submit"><?= $chapter ? 'Update Chapter' : 'Create Chapter' ?></button>
    </div>
</form>
