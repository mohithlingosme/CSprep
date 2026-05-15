<section class="page-actions mb-4">
    <p class="text-muted mb-0">Map your syllabus, legal domains, and content buckets before injecting detailed knowledge.</p>
    <a class="btn btn-primary" href="<?= e(url('/subjects/create')) ?>">Add Subject</a>
</section>

<div class="app-card">
    <table class="table table-hover align-middle datatable">
        <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Domain</th>
            <th>Syllabus</th>
            <th>Chapters</th>
            <th>Topics</th>
            <th>Knowledge</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($subjects as $subject): ?>
            <tr>
                <td><code><?= e($subject['code']) ?></code></td>
                <td>
                    <strong><?= e($subject['name']) ?></strong>
                    <div class="table-subtext"><?= e($subject['description']) ?></div>
                </td>
                <td><?= e($subject['domain_type']) ?></td>
                <td><?= e($subject['syllabus_version']) ?></td>
                <td><?= e($subject['chapter_count']) ?></td>
                <td><?= e($subject['topic_count']) ?></td>
                <td><?= e($subject['knowledge_count']) ?></td>
                <td><span class="badge text-bg-<?= e(badge_class((string) $subject['status'])) ?>"><?= e($subject['status']) ?></span></td>
                <td class="text-end">
                    <a class="btn btn-sm btn-outline-primary" href="<?= e(url('/subjects/edit/' . $subject['id'])) ?>">Edit</a>
                    <form class="d-inline" method="post" action="<?= e(url('/subjects/delete/' . $subject['id'])) ?>">
                        <?= csrf_field() ?>
                        <button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Delete this subject?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
