<section class="page-actions mb-4">
    <p class="text-muted mb-0">Inject proprietary notes, interpretation layers, drafting templates, revision sheets, and AI-ready legal knowledge.</p>
    <a class="btn btn-primary" href="<?= e(url('/knowledge/create')) ?>">Add Knowledge Entry</a>
</section>

<div class="app-card">
    <table class="table table-hover align-middle datatable">
        <thead>
        <tr>
            <th>Title</th>
            <th>Type</th>
            <th>Subject</th>
            <th>Topic</th>
            <th>AI</th>
            <th>Difficulty</th>
            <th>Status</th>
            <th>Version</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($entries as $entry): ?>
            <tr>
                <td>
                    <strong><?= e($entry['title']) ?></strong>
                    <div class="table-subtext"><?= e($entry['summary']) ?></div>
                </td>
                <td><?= e($entry['entry_type']) ?></td>
                <td><?= e($entry['subject_name']) ?></td>
                <td><?= e($entry['topic_name']) ?></td>
                <td><?= (int) $entry['ai_ready'] === 1 ? 'Ready' : 'Pending' ?></td>
                <td><?= e($entry['difficulty']) ?></td>
                <td><span class="badge text-bg-<?= e(badge_class((string) $entry['status'])) ?>"><?= e($entry['status']) ?></span></td>
                <td>v<?= e($entry['version_no']) ?></td>
                <td class="text-end">
                    <a class="btn btn-sm btn-outline-primary" href="<?= e(url('/knowledge/edit/' . $entry['id'])) ?>">Edit</a>
                    <form class="d-inline" method="post" action="<?= e(url('/knowledge/delete/' . $entry['id'])) ?>">
                        <?= csrf_field() ?>
                        <button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Delete this entry?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
