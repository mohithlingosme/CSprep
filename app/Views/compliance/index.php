<section class="page-actions mb-4">
    <p class="text-muted mb-0">Track governance obligations, filing dates, regulators, responsible owners, penalty exposure, and operational status.</p>
    <a class="btn btn-primary" href="<?= e(url('/compliance/create')) ?>">Add Compliance Item</a>
</section>

<div class="app-card">
    <table class="table table-hover align-middle datatable">
        <thead>
        <tr>
            <th>Title</th>
            <th>Subject</th>
            <th>Form</th>
            <th>Frequency</th>
            <th>Due Date</th>
            <th>Priority</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td>
                    <strong><?= e($item['title']) ?></strong>
                    <div class="table-subtext"><?= e($item['description']) ?></div>
                </td>
                <td><?= e($item['subject_name']) ?></td>
                <td><?= e($item['form_name'] ?: '-') ?></td>
                <td><?= e($item['frequency']) ?></td>
                <td><?= e(format_date($item['due_date'])) ?></td>
                <td><span class="badge text-bg-<?= e(badge_class((string) $item['priority'])) ?>"><?= e($item['priority']) ?></span></td>
                <td><span class="badge text-bg-<?= e(badge_class((string) $item['status'])) ?>"><?= e($item['status']) ?></span></td>
                <td class="text-end">
                    <a class="btn btn-sm btn-outline-primary" href="<?= e(url('/compliance/edit/' . $item['id'])) ?>">Edit</a>
                    <form class="d-inline" method="post" action="<?= e(url('/compliance/delete/' . $item['id'])) ?>">
                        <?= csrf_field() ?>
                        <button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Delete this compliance item?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
