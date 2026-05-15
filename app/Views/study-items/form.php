<?php $item = $item ?? []; ?>

<form method="post" action="<?= e(url($item ? '/study-items/update/' . $item['id'] : '/study-items/store')) ?>" class="app-card">
    <?= csrf_field() ?>
    <div class="section-heading mb-4">
        <div>
            <span class="eyebrow">Education Engine</span>
            <h3><?= $item ? 'Update study asset' : 'Create study item' ?></h3>
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
            <label class="form-label">Knowledge Entry</label>
            <select class="form-select" name="knowledge_entry_id">
                <option value="">Optional knowledge link</option>
                <?php foreach ($lookup['knowledgeEntries'] as $entry): ?>
                    <option value="<?= e($entry['id']) ?>" <?= selected(old('knowledge_entry_id', $item['knowledge_entry_id'] ?? ''), $entry['id']) ?>><?= e($entry['title']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Item Type</label>
            <select class="form-select" name="item_type">
                <?php foreach (['MCQ', 'PYQ', 'Flashcard', 'Mock', 'Short Answer', 'Long Answer', 'Checklist'] as $type): ?>
                    <option value="<?= e($type) ?>" <?= selected(old('item_type', $item['item_type'] ?? 'MCQ'), $type) ?>><?= e($type) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Difficulty</label>
            <select class="form-select" name="difficulty">
                <?php foreach (['Basic', 'Intermediate', 'Advanced'] as $difficulty): ?>
                    <option value="<?= e($difficulty) ?>" <?= selected(old('difficulty', $item['difficulty'] ?? 'Intermediate'), $difficulty) ?>><?= e($difficulty) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Marks</label>
            <input class="form-control" name="marks" type="number" value="<?= e(old('marks', $item['marks'] ?? '')) ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">Exam Year</label>
            <input class="form-control" name="exam_year" type="number" value="<?= e(old('exam_year', $item['exam_year'] ?? '')) ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">AI Ready</label>
            <select class="form-select" name="ai_ready">
                <option value="0" <?= selected(old('ai_ready', $item['ai_ready'] ?? 0), 0) ?>>No</option>
                <option value="1" <?= selected(old('ai_ready', $item['ai_ready'] ?? 0), 1) ?>>Yes</option>
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Prompt / Question</label>
            <textarea class="form-control" rows="4" name="prompt"><?= e(old('prompt', $item['prompt'] ?? '')) ?></textarea>
        </div>
        <div class="col-md-3">
            <label class="form-label">Option A</label>
            <input class="form-control" name="option_a" value="<?= e(old('option_a', $item['option_a'] ?? '')) ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Option B</label>
            <input class="form-control" name="option_b" value="<?= e(old('option_b', $item['option_b'] ?? '')) ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Option C</label>
            <input class="form-control" name="option_c" value="<?= e(old('option_c', $item['option_c'] ?? '')) ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Option D</label>
            <input class="form-control" name="option_d" value="<?= e(old('option_d', $item['option_d'] ?? '')) ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Correct Answer</label>
            <input class="form-control" name="correct_answer" value="<?= e(old('correct_answer', $item['correct_answer'] ?? '')) ?>">
        </div>
        <div class="col-md-8">
            <label class="form-label">Revision Bucket</label>
            <input class="form-control" name="revision_bucket" value="<?= e(old('revision_bucket', $item['revision_bucket'] ?? '')) ?>" placeholder="daily, weekly, exam-sprint">
        </div>
        <div class="col-12">
            <label class="form-label">Explanation / Answer Key</label>
            <textarea class="form-control" rows="5" name="explanation"><?= e(old('explanation', $item['explanation'] ?? '')) ?></textarea>
        </div>
    </div>

    <div class="form-actions">
        <a class="btn btn-outline-secondary" href="<?= e(url('/study-items')) ?>">Back</a>
        <button class="btn btn-primary" type="submit"><?= $item ? 'Update Item' : 'Create Item' ?></button>
    </div>
</form>
