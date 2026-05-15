<section class="page-actions mb-4">
    <p class="text-muted mb-0">Build nested topics, assign revision intervals, and track mastery for exam and AI-readiness planning.</p>
    <a class="btn btn-primary" href="<?= e(url('/topics/create')) ?>">Add Topic</a>
</section>

<div class="app-card">
    <table class="table table-hover align-middle datatable">
        <thead>
        <tr>
            <th>Subject</th>
            <th>Chapter</th>
            <th>Topic</th>
            <th>Parent</th>
            <th>Difficulty</th>
            <th>Revision</th>
            <th>Mastery</th>
            <th>Exam Relevance</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($topics as $topic): ?>
            <tr>
                <td><?= e($topic['subject_name']) ?></td>
                <td><?= e($topic['chapter_name']) ?></td>
                <td>
                    <strong><?= e($topic['title']) ?></strong>
                    <div class="table-subtext"><?= e($topic['learning_objectives']) ?></div>
                </td>
                <td><?= e($topic['parent_topic'] ?: '-') ?></td>
                <td><span class="badge text-bg-<?= e(badge_class((string) $topic['difficulty'])) ?>"><?= e($topic['difficulty']) ?></span></td>
                <td><?= e($topic['revision_interval_days']) ?> days</td>
                <td><?= e($topic['mastery_score']) ?>%</td>
                <td><?= e($topic['exam_relevance']) ?>/5</td>
                <td class="text-end">
                    <a class="btn btn-sm btn-outline-primary" href="<?= e(url('/topics/edit/' . $topic['id'])) ?>">Edit</a>
                    <form class="d-inline" method="post" action="<?= e(url('/topics/delete/' . $topic['id'])) ?>">
                        <?= csrf_field() ?>
                        <button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Delete this topic?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
