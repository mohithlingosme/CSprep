<?php $item = $item ?? []; ?>

<form method="post" action="<?= e(url($item ? '/compliance/update/' . $item['id'] : '/compliance/store')) ?>" class="app-card">
    <?= csrf_field() ?>
    <div class="section-heading mb-4">
        <div>
            <span class="eyebrow">Compliance System</span>
            <h3><?= $item ? 'Update compliance obligation' : 'Create compliance obligation' ?></h3>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Subject</label>
            <select class="form-select" name="subject_id" required>
                <option value="">Choose subject</option>
                <?php foreach ($lookup['subjects'] as $subject): ?>
                    <option value="<?= e($subject['id']) ?>" <?= selected(old('subject_id', $item['subject_id'] ?? ''), $subject['id']) ?>><?= e($subject['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Topic</label>
            <select class="form-select" name="topic_id">
                <option value="">Optional topic link</option>
                <?php foreach ($lookup['topics'] as $topic): ?>
                    <option value="<?= e($topic['id']) ?>" <?= selected(old('topic_id', $item['topic_id'] ?? ''), $topic['id']) ?>><?= e($topic['subject_name'] . ' / ' . $topic['title']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Linked Provision</label>
            <select class="form-select" name="provision_id">
                <option value="">Optional provision link</option>
                <?php foreach ($lookup['provisions'] as $provision): ?>
                    <option value="<?= e($provision['id']) ?>" <?= selected(old('provision_id', $item['provision_id'] ?? ''), $provision['id']) ?>><?= e($provision['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Title</label>
            <input class="form-control" name="title" value="<?= e(old('title', $item['title'] ?? '')) ?>" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Entity Type</label>
            <input class="form-control" name="entity_type" value="<?= e(old('entity_type', $item['entity_type'] ?? 'Private Company')) ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Frequency</label>
            <input class="form-control" name="frequency" value="<?= e(old('frequency', $item['frequency'] ?? 'Annual')) ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Due Date</label>
            <input class="form-control" name="due_date" type="date" value="<?= e(old('due_date', $item['due_date'] ?? '')) ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Form Name</label>
            <input class="form-control" name="form_name" value="<?= e(old('form_name', $item['form_name'] ?? '')) ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Regulator</label>
            <input class="form-control" name="regulator" value="<?= e(old('regulator', $item['regulator'] ?? 'MCA')) ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Priority</label>
            <select class="form-select" name="priority">
                <?php foreach (['Low', 'Medium', 'High', 'Critical'] as $priority): ?>
                    <option value="<?= e($priority) ?>" <?= selected(old('priority', $item['priority'] ?? 'Medium'), $priority) ?>><?= e($priority) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Status</label>
            <select class="form-select" name="status">
                <?php foreach (['Planned', 'In Progress', 'Completed', 'Overdue'] as $status): ?>
                    <option value="<?= e($status) ?>" <?= selected(old('status', $item['status'] ?? 'Planned'), $status) ?>><?= e($status) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Owner</label>
            <input class="form-control" name="owner_name" value="<?= e(old('owner_name', $item['owner_name'] ?? 'Founder')) ?>">
        </div>
        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea class="form-control" rows="4" name="description"><?= e(old('description', $item['description'] ?? '')) ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Checklist</label>
            <textarea class="form-control" rows="5" name="checklist"><?= e(old('checklist', $item['checklist'] ?? '')) ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Penalty Risk</label>
            <textarea class="form-control" rows="5" name="penalty_risk"><?= e(old('penalty_risk', $item['penalty_risk'] ?? '')) ?></textarea>
        </div>
    </div>

    <div class="form-actions">
        <a class="btn btn-outline-secondary" href="<?= e(url('/compliance')) ?>">Back</a>
        <button class="btn btn-primary" type="submit"><?= $item ? 'Update Compliance Item' : 'Create Compliance Item' ?></button>
    </div>
</form>
