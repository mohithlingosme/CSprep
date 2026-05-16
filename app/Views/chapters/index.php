<section class="page-actions mb-4">
    <p class="text-muted mb-0">Break each subject into chapters with weightage, order, and dependency notes for revision planning.</p>
    <a class="btn btn-primary" href="<?= e(url('/chapters/create')) ?>">Add Chapter</a>
</section>

<div class="app-card">
    <table class="table table-hover align-middle datatable">
        <thead>
        <tr>
            <th>Subject</th>
            <th>Code</th>
            <th>Chapter</th>
            <th>Weightage</th>
            <th>Study Order</th>
            <th>Topics</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach (($chapters ?? []) as $chapter): ?>
            <tr>
                <td><?= e($chapter['subject_name']) ?></td>
                <td><code><?= e($chapter['code']) ?></code></td>
                <td>
                    <strong><?= e($chapter['title']) ?></strong>
                    <div class="table-subtext"><?= e($chapter['summary']) ?></div>
                </td>
                <td><?= e($chapter['weightage']) ?></td>
                <td><?= e($chapter['study_order']) ?></td>
                <td><?= e($chapter['topic_count']) ?></td>
                <td class="text-end">
                    <a class="btn btn-sm btn-outline-primary" href="<?= e(url('/chapters/edit/' . $chapter['id'])) ?>">Edit</a>
                    <button type="button" class="btn btn-sm btn-outline-danger js-confirm-delete"
                            data-delete-target="form-delete-<?= e($chapter['id']) ?>"
                            data-confirm-title="Delete chapter"
                            data-confirm-message="This will delete the chapter and related content. Proceed?">
                        Delete
                    </button>
                    <form id="form-delete-<?= e($chapter['id']) ?>" class="d-inline" method="post" action="<?= e(url('/chapters/delete/' . $chapter['id'])) ?>">
                        <?= csrf_field() ?>
                        <button class="d-none" type="submit">Confirm Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
