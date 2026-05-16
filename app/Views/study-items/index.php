<section class="page-actions mb-4">
    <p class="text-muted mb-0">Build MCQs, PYQs, flashcards, mock prompts, and answer banks linked to your proprietary knowledge graph.</p>
    <a class="btn btn-primary" href="<?= e(url('/study-items/create')) ?>">Add Study Item</a>
</section>

<div class="app-card">
    <table class="table table-hover align-middle datatable">
        <thead>
        <tr>
            <th>Type</th>
            <th>Prompt</th>
            <th>Subject</th>
            <th>Topic</th>
            <th>Difficulty</th>
            <th>Marks</th>
            <th>AI</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
<?php foreach (($items ?? []) as $item): ?>
            <tr>
                <td><?= e($item['item_type']) ?></td>
                <td>
                    <strong><?= e(strlen((string) $item['prompt']) > 70 ? substr((string) $item['prompt'], 0, 67) . '...' : (string) $item['prompt']) ?></strong>
                    <div class="table-subtext"><?= e($item['explanation']) ?></div>
                </td>
                <td><?= e($item['subject_name']) ?></td>
                <td><?= e($item['topic_name'] ?: '-') ?></td>
                <td><?= e($item['difficulty']) ?></td>
                <td><?= e($item['marks'] ?: '-') ?></td>
                <td><?= (int) $item['ai_ready'] === 1 ? 'Ready' : 'Pending' ?></td>
                <td class="text-end">
                    <a class="btn btn-sm btn-outline-primary" href="<?= e(url('/study-items/edit/' . $item['id'])) ?>">Edit</a>
                    <button type="button" class="btn btn-sm btn-outline-danger js-confirm-delete"
                            data-delete-target="form-delete-<?= e($item['id']) ?>"
                            data-confirm-title="Delete study item"
                            data-confirm-message="This will delete the study item record. Proceed?">
                        Delete
                    </button>
                    <form id="form-delete-<?= e($item['id']) ?>" class="d-inline" method="post" action="<?= e(url('/study-items/delete/' . $item['id'])) ?>">
                        <?= csrf_field() ?>
                        <button class="d-none" type="submit">Confirm Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
