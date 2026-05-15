<?php $entry = $entry ?? []; ?>

<form method="post" action="<?= e(url($entry ? '/knowledge/update/' . $entry['id'] : '/knowledge/store')) ?>" class="app-card">
    <?= csrf_field() ?>
    <div class="section-heading mb-4">
        <div>
            <span class="eyebrow">Knowledge Injection</span>
            <h3><?= $entry ? 'Update founder knowledge entry' : 'Create a new knowledge asset' ?></h3>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Subject</label>
            <select class="form-select" name="subject_id" required>
                <option value="">Choose subject</option>
                <?php foreach ($lookup['subjects'] as $subject): ?>
                    <option value="<?= e($subject['id']) ?>" <?= selected(old('subject_id', $entry['subject_id'] ?? ''), $subject['id']) ?>><?= e($subject['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Chapter</label>
            <select class="form-select" name="chapter_id" required>
                <option value="">Choose chapter</option>
                <?php foreach ($lookup['chapters'] as $chapter): ?>
                    <option value="<?= e($chapter['id']) ?>" <?= selected(old('chapter_id', $entry['chapter_id'] ?? ''), $chapter['id']) ?>><?= e($chapter['subject_name'] . ' / ' . $chapter['title']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Topic</label>
            <select class="form-select" name="topic_id" required>
                <option value="">Choose topic</option>
                <?php foreach ($lookup['topics'] as $topic): ?>
                    <option value="<?= e($topic['id']) ?>" <?= selected(old('topic_id', $entry['topic_id'] ?? ''), $topic['id']) ?>><?= e($topic['subject_name'] . ' / ' . $topic['title']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Entry Type</label>
            <select class="form-select" name="entry_type">
                <?php foreach (['Note', 'Bare Act', 'Interpretation', 'Checklist', 'Template', 'Governance', 'Regulatory Update', 'Revision', 'Drafting', 'Advisory'] as $type): ?>
                    <option value="<?= e($type) ?>" <?= selected(old('entry_type', $entry['entry_type'] ?? 'Note'), $type) ?>><?= e($type) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Title</label>
            <input class="form-control" name="title" value="<?= e(old('title', $entry['title'] ?? '')) ?>" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Status</label>
            <select class="form-select" name="status">
                <?php foreach (['Draft', 'Review', 'Published', 'Archived'] as $status): ?>
                    <option value="<?= e($status) ?>" <?= selected(old('status', $entry['status'] ?? 'Draft'), $status) ?>><?= e($status) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Linked Legal Provision</label>
            <select class="form-select" name="legal_provision_id">
                <option value="">Optional provision</option>
                <?php foreach ($lookup['provisions'] as $provision): ?>
                    <option value="<?= e($provision['id']) ?>" <?= selected(old('legal_provision_id', $entry['legal_provision_id'] ?? ''), $provision['id']) ?>><?= e($provision['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Source Document</label>
            <select class="form-select" name="source_document_id">
                <option value="">Optional source</option>
                <?php foreach ($lookup['sourceDocuments'] as $document): ?>
                    <option value="<?= e($document['id']) ?>" <?= selected(old('source_document_id', $entry['source_document_id'] ?? ''), $document['id']) ?>><?= e($document['title']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Summary</label>
            <textarea class="form-control" rows="3" name="summary"><?= e(old('summary', $entry['summary'] ?? '')) ?></textarea>
        </div>
        <div class="col-12">
            <label class="form-label">Rich Content</label>
            <div class="rich-editor-wrapper">
                <div class="editor-toolbar">
                    <button type="button" data-command="bold">Bold</button>
                    <button type="button" data-command="italic">Italic</button>
                    <button type="button" data-command="insertUnorderedList">List</button>
                    <button type="button" data-command="formatBlock" data-value="h3">H3</button>
                    <button type="button" data-command="formatBlock" data-value="blockquote">Quote</button>
                </div>
                <div class="rich-editor" contenteditable="true"><?= old('content_html', $entry['content_html'] ?? '') ?></div>
                <textarea class="d-none rich-editor-input" name="content_html"><?= e(old('content_html', $entry['content_html'] ?? '')) ?></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Key Takeaways</label>
            <textarea class="form-control" rows="5" name="key_takeaways"><?= e(old('key_takeaways', $entry['key_takeaways'] ?? '')) ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Compliance Map</label>
            <textarea class="form-control" rows="5" name="compliance_map"><?= e(old('compliance_map', $entry['compliance_map'] ?? '')) ?></textarea>
        </div>
        <div class="col-md-3">
            <label class="form-label">Difficulty</label>
            <select class="form-select" name="difficulty">
                <?php foreach (['Basic', 'Intermediate', 'Advanced'] as $difficulty): ?>
                    <option value="<?= e($difficulty) ?>" <?= selected(old('difficulty', $entry['difficulty'] ?? 'Intermediate'), $difficulty) ?>><?= e($difficulty) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Exam Relevance</label>
            <input class="form-control" name="exam_relevance" type="number" min="1" max="5" value="<?= e(old('exam_relevance', $entry['exam_relevance'] ?? 3)) ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">AI Label</label>
            <input class="form-control" name="ai_label" value="<?= e(old('ai_label', $entry['ai_label'] ?? '')) ?>" placeholder="director-appointment">
        </div>
        <div class="col-md-3">
            <label class="form-label">AI Ready</label>
            <select class="form-select" name="ai_ready">
                <option value="0" <?= selected(old('ai_ready', $entry['ai_ready'] ?? 0), 0) ?>>No</option>
                <option value="1" <?= selected(old('ai_ready', $entry['ai_ready'] ?? 0), 1) ?>>Yes</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Revision Tags</label>
            <input class="form-control" name="revision_tags" value="<?= e(old('revision_tags', $entry['revision_tags'] ?? '')) ?>" placeholder="rapid-recall, weekly, board-process">
        </div>
        <div class="col-md-6">
            <label class="form-label">Citation Reference</label>
            <input class="form-control" name="citation_reference" value="<?= e(old('citation_reference', $entry['citation_reference'] ?? '')) ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Metadata Tags</label>
            <input class="form-control" name="tag_string" value="<?= e(old('tag_string', $tagString)) ?>" placeholder="mca, board meeting, penalty, exam hot topic">
        </div>
        <div class="col-md-6">
            <label class="form-label">Knowledge Graph Mapping</label>
            <textarea class="form-control" rows="4" name="relation_lines" placeholder="supports|legal_provision|12|Maps to Section 173&#10;explains|case_law|3|Judicial interpretation"><?= e(old('relation_lines', $relationLines)) ?></textarea>
        </div>
    </div>

    <div class="form-actions">
        <a class="btn btn-outline-secondary" href="<?= e(url('/knowledge')) ?>">Back</a>
        <button class="btn btn-primary" type="submit"><?= $entry ? 'Update Entry' : 'Create Entry' ?></button>
    </div>
</form>
