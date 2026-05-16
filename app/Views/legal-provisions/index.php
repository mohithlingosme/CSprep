<section class="page-actions mb-4">
    <p class="text-muted mb-0">Capture bare act text, simplified interpretation, checklists, penalties, drafting notes, and amendments in one structured legal engine.</p>
    <a class="btn btn-primary" href="<?= e(url('/legal-provisions/create')) ?>">Add Provision</a>
</section>

<div class="app-card">
    <table class="table table-hover align-middle datatable">
        <thead>
        <tr>
            <th>Reference</th>
            <th>Title</th>
            <th>Framework</th>
            <th>Subject</th>
            <th>Topic</th>
            <th>Effective Date</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach (($provisions ?? []) as $provision): ?>
            <tr>
                <td><code><?= e($provision['reference_code']) ?></code></td>
                <td>
                    <strong><?= e($provision['title']) ?></strong>
                    <div class="table-subtext"><?= e($provision['act_name']) ?></div>
                </td>
                <td><?= e($provision['framework_type']) ?></td>
                <td><?= e($provision['subject_name']) ?></td>
                <td><?= e($provision['topic_name'] ?: '-') ?></td>
                <td><?= e(format_date($provision['effective_date'])) ?></td>
                <td><span class="badge text-bg-<?= e(badge_class((string) $provision['status'])) ?>"><?= e($provision['status']) ?></span></td>
                <td class="text-end">
                    <a class="btn btn-sm btn-outline-primary" href="<?= e(url('/legal-provisions/edit/' . $provision['id'])) ?>">Edit</a>
                    <button type="button" class="btn btn-sm btn-outline-danger js-confirm-delete"
                            data-delete-target="form-delete-<?= e($provision['id']) ?>"
                            data-confirm-title="Delete provision"
                            data-confirm-message="This will delete the provision record. Proceed?">
                        Delete
                    </button>
                    <form id="form-delete-<?= e($provision['id']) ?>" class="d-inline" method="post" action="<?= e(url('/legal-provisions/delete/' . $provision['id'])) ?>">
                        <?= csrf_field() ?>
                        <button class="d-none" type="submit">Confirm Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
