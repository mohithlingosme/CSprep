<?php $caseLaw = $caseLaw ?? []; ?>

<form method="post" action="<?= e(url($caseLaw ? '/case-laws/update/' . $caseLaw['id'] : '/case-laws/store')) ?>" class="app-card">
    <?= csrf_field() ?>
    <div class="section-heading mb-4">
        <div>
            <span class="eyebrow">Case Law Engine</span>
            <h3><?= $caseLaw ? 'Update case law analysis' : 'Create case law record' ?></h3>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Subject</label>
            <select class="form-select" name="subject_id" required>
                <option value="">Choose subject</option>
                <?php foreach ($lookup['subjects'] as $subject): ?>
                    <option value="<?= e($subject['id']) ?>" <?= selected(old('subject_id', $caseLaw['subject_id'] ?? ''), $subject['id']) ?>><?= e($subject['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Topic</label>
            <select class="form-select" name="topic_id">
                <option value="">Optional topic link</option>
                <?php foreach ($lookup['topics'] as $topic): ?>
                    <option value="<?= e($topic['id']) ?>" <?= selected(old('topic_id', $caseLaw['topic_id'] ?? ''), $topic['id']) ?>><?= e($topic['subject_name'] . ' / ' . $topic['title']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Legal Provision</label>
            <select class="form-select" name="legal_provision_id">
                <option value="">Optional provision link</option>
                <?php foreach ($lookup['provisions'] as $provision): ?>
                    <option value="<?= e($provision['id']) ?>" <?= selected(old('legal_provision_id', $caseLaw['legal_provision_id'] ?? ''), $provision['id']) ?>><?= e($provision['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Case Name</label>
            <input class="form-control" name="case_name" value="<?= e(old('case_name', $caseLaw['case_name'] ?? '')) ?>" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Citation</label>
            <input class="form-control" name="citation" value="<?= e(old('citation', $caseLaw['citation'] ?? '')) ?>" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">Year</label>
            <input class="form-control" name="case_year" type="number" value="<?= e(old('case_year', $caseLaw['case_year'] ?? '')) ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Court Name</label>
            <input class="form-control" name="court_name" value="<?= e(old('court_name', $caseLaw['court_name'] ?? '')) ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Court Level</label>
            <select class="form-select" name="court_level">
                <?php foreach (['Supreme Court', 'High Court', 'NCLAT', 'NCLT', 'Tribunal', 'Other'] as $level): ?>
                    <option value="<?= e($level) ?>" <?= selected(old('court_level', $caseLaw['court_level'] ?? 'High Court'), $level) ?>><?= e($level) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Exam Relevance</label>
            <input class="form-control" name="exam_relevance" type="number" min="1" max="5" value="<?= e(old('exam_relevance', $caseLaw['exam_relevance'] ?? 3)) ?>">
        </div>
        <div class="col-12">
            <label class="form-label">Facts</label>
            <textarea class="form-control" rows="4" name="facts"><?= e(old('facts', $caseLaw['facts'] ?? '')) ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Issues</label>
            <textarea class="form-control" rows="4" name="issues"><?= e(old('issues', $caseLaw['issues'] ?? '')) ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Held</label>
            <textarea class="form-control" rows="4" name="held_text"><?= e(old('held_text', $caseLaw['held_text'] ?? '')) ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Legal Principles</label>
            <textarea class="form-control" rows="4" name="legal_principles"><?= e(old('legal_principles', $caseLaw['legal_principles'] ?? '')) ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Linked Sections</label>
            <textarea class="form-control" rows="4" name="linked_sections"><?= e(old('linked_sections', $caseLaw['linked_sections'] ?? '')) ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Metadata Tags</label>
            <input class="form-control" name="tag_string" value="<?= e(old('tag_string', $tagString)) ?>" placeholder="oppression, mismanagement, audit, dividends">
        </div>
        <div class="col-md-6">
            <label class="form-label">Knowledge Graph Mapping</label>
            <textarea class="form-control" rows="4" name="relation_lines" placeholder="interprets|legal_provision|21|Explains penal consequence&#10;linked_to|knowledge_entry|8|Use in short answer"><?= e(old('relation_lines', $relationLines)) ?></textarea>
        </div>
    </div>

    <div class="form-actions">
        <a class="btn btn-outline-secondary" href="<?= e(url('/case-laws')) ?>">Back</a>
        <button class="btn btn-primary" type="submit"><?= $caseLaw ? 'Update Case Law' : 'Create Case Law' ?></button>
    </div>
</form>
