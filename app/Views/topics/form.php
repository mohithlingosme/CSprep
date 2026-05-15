<?php $topic = $topic ?? []; ?>

<form method="post" action="<?= e(url($topic ? '/topics/update/' . $topic['id'] : '/topics/store')) ?>" class="app-card">
    <?= csrf_field() ?>
    <div class="section-heading mb-4">
        <div>
            <span class="eyebrow">Topic Builder</span>
            <h3><?= $topic ? 'Update topic hierarchy' : 'Create a topic node' ?></h3>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Chapter</label>
            <select class="form-select" name="chapter_id" required>
                <option value="">Choose chapter</option>
                <?php foreach ($chapters as $chapterOption): ?>
                    <option value="<?= e($chapterOption['id']) ?>" <?= selected(old('chapter_id', $topic['chapter_id'] ?? ''), $chapterOption['id']) ?>>
                        <?= e($chapterOption['subject_name'] . ' / ' . $chapterOption['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Parent Topic</label>
            <select class="form-select" name="parent_id">
                <option value="">No parent</option>
                <?php foreach ($parents as $parent): ?>
                    <option value="<?= e($parent['id']) ?>" <?= selected(old('parent_id', $topic['parent_id'] ?? ''), $parent['id']) ?>>
                        <?= e($parent['subject_name'] . ' / ' . $parent['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-8">
            <label class="form-label">Title</label>
            <input class="form-control" name="title" value="<?= e(old('title', $topic['title'] ?? '')) ?>" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">Difficulty</label>
            <select class="form-select" name="difficulty">
                <?php foreach (['Basic', 'Intermediate', 'Advanced'] as $difficulty): ?>
                    <option value="<?= e($difficulty) ?>" <?= selected(old('difficulty', $topic['difficulty'] ?? 'Intermediate'), $difficulty) ?>><?= e($difficulty) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Exam Score</label>
            <input class="form-control" name="exam_relevance" type="number" min="1" max="5" value="<?= e(old('exam_relevance', $topic['exam_relevance'] ?? 3)) ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Revision Interval (days)</label>
            <input class="form-control" name="revision_interval_days" type="number" value="<?= e(old('revision_interval_days', $topic['revision_interval_days'] ?? 7)) ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Mastery Score (%)</label>
            <input class="form-control" name="mastery_score" type="number" min="0" max="100" step="0.01" value="<?= e(old('mastery_score', $topic['mastery_score'] ?? 0)) ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Next Revision Date</label>
            <input class="form-control" name="next_revision_at" type="date" value="<?= e(old('next_revision_at', $topic['next_revision_at'] ?? '')) ?>">
        </div>
        <div class="col-12">
            <label class="form-label">Learning Objectives</label>
            <textarea class="form-control" rows="5" name="learning_objectives"><?= e(old('learning_objectives', $topic['learning_objectives'] ?? '')) ?></textarea>
        </div>
        <div class="col-12">
            <label class="form-label">Dependency Map</label>
            <textarea class="form-control" rows="4" name="dependency_map"><?= e(old('dependency_map', $topic['dependency_map'] ?? '')) ?></textarea>
        </div>
    </div>

    <div class="form-actions">
        <a class="btn btn-outline-secondary" href="<?= e(url('/topics')) ?>">Back</a>
        <button class="btn btn-primary" type="submit"><?= $topic ? 'Update Topic' : 'Create Topic' ?></button>
    </div>
</form>
