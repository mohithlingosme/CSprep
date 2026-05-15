<?php $provision = $provision ?? []; ?>

<form method="post" action="<?= e(url($provision ? '/legal-provisions/update/' . $provision['id'] : '/legal-provisions/store')) ?>" class="app-card">
    <?= csrf_field() ?>
    <div class="section-heading mb-4">
        <div>
            <span class="eyebrow">Legal Content Engine</span>
            <h3><?= $provision ? 'Update provision intelligence' : 'Add legal provision' ?></h3>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Subject</label>
            <select class="form-select" name="subject_id" required>
                <option value="">Choose subject</option>
                <?php foreach ($lookup['subjects'] as $subject): ?>
                    <option value="<?= e($subject['id']) ?>" <?= selected(old('subject_id', $provision['subject_id'] ?? ''), $subject['id']) ?>><?= e($subject['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Topic</label>
            <select class="form-select" name="topic_id">
                <option value="">Optional topic link</option>
                <?php foreach ($lookup['topics'] as $topic): ?>
                    <option value="<?= e($topic['id']) ?>" <?= selected(old('topic_id', $provision['topic_id'] ?? ''), $topic['id']) ?>><?= e($topic['subject_name'] . ' / ' . $topic['title']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Framework Type</label>
            <select class="form-select" name="framework_type">
                <?php foreach (['Section', 'Rule', 'Secretarial Standard', 'Regulation', 'Form', 'Procedure', 'Checklist'] as $type): ?>
                    <option value="<?= e($type) ?>" <?= selected(old('framework_type', $provision['framework_type'] ?? 'Section'), $type) ?>><?= e($type) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Reference Code</label>
            <input class="form-control" name="reference_code" value="<?= e(old('reference_code', $provision['reference_code'] ?? '')) ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Title</label>
            <input class="form-control" name="title" value="<?= e(old('title', $provision['title'] ?? '')) ?>" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Effective Date</label>
            <input class="form-control" name="effective_date" type="date" value="<?= e(old('effective_date', $provision['effective_date'] ?? '')) ?>">
        </div>
        <div class="col-md-8">
            <label class="form-label">Act / Framework Name</label>
            <input class="form-control" name="act_name" value="<?= e(old('act_name', $provision['act_name'] ?? 'Companies Act, 2013')) ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Status</label>
            <select class="form-select" name="status">
                <?php foreach (['Published', 'Review', 'Draft', 'Archived'] as $status): ?>
                    <option value="<?= e($status) ?>" <?= selected(old('status', $provision['status'] ?? 'Published'), $status) ?>><?= e($status) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Bare Act Text</label>
            <textarea class="form-control" rows="6" name="bare_text"><?= e(old('bare_text', $provision['bare_text'] ?? '')) ?></textarea>
        </div>
        <div class="col-12">
            <label class="form-label">Simplified Interpretation</label>
            <textarea class="form-control" rows="5" name="simplified_text"><?= e(old('simplified_text', $provision['simplified_text'] ?? '')) ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Compliance Checklist</label>
            <textarea class="form-control" rows="5" name="compliance_checklist"><?= e(old('compliance_checklist', $provision['compliance_checklist'] ?? '')) ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Drafting Notes</label>
            <textarea class="form-control" rows="5" name="drafting_notes"><?= e(old('drafting_notes', $provision['drafting_notes'] ?? '')) ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Penalties</label>
            <textarea class="form-control" rows="4" name="penalties"><?= e(old('penalties', $provision['penalties'] ?? '')) ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Forms Involved</label>
            <textarea class="form-control" rows="4" name="forms_involved"><?= e(old('forms_involved', $provision['forms_involved'] ?? '')) ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Amendment Notes</label>
            <textarea class="form-control" rows="4" name="amendment_notes"><?= e(old('amendment_notes', $provision['amendment_notes'] ?? '')) ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">AI Labels</label>
            <input class="form-control" name="ai_labels" value="<?= e(old('ai_labels', $provision['ai_labels'] ?? '')) ?>" placeholder="board powers, incorporation, director duties">
        </div>
    </div>

    <div class="form-actions">
        <a class="btn btn-outline-secondary" href="<?= e(url('/legal-provisions')) ?>">Back</a>
        <button class="btn btn-primary" type="submit"><?= $provision ? 'Update Provision' : 'Create Provision' ?></button>
    </div>
</form>
