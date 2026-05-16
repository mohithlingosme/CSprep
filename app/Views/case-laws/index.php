<section class="page-actions mb-4">
    <p class="text-muted mb-0">Store facts, issues, holdings, legal principles, and exam relevance with direct topic and section linkages.</p>
    <a class="btn btn-primary" href="<?= e(url('/case-laws/create')) ?>">Add Case Law</a>
</section>

<div class="app-card">
    <table class="table table-hover align-middle datatable">
        <thead>
        <tr>
            <th>Case</th>
            <th>Citation</th>
            <th>Subject</th>
            <th>Topic</th>
            <th>Court</th>
            <th>Year</th>
            <th>Exam Relevance</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach (($caseLaws ?? []) as $case): ?>
            <tr>
                <td>
                    <strong><?= e($case['case_name']) ?></strong>
                    <div class="table-subtext"><?= e($case['legal_principles']) ?></div>
                </td>
                <td><?= e($case['citation']) ?></td>
                <td><?= e($case['subject_name']) ?></td>
                <td><?= e($case['topic_name'] ?: '-') ?></td>
                <td><?= e($case['court_level']) ?></td>
                <td><?= e($case['case_year']) ?></td>
                <td><?= e($case['exam_relevance']) ?>/5</td>
                <td class="text-end">
                    <a class="btn btn-sm btn-outline-primary" href="<?= e(url('/case-laws/edit/' . $case['id'])) ?>">Edit</a>
                    <button type="button" class="btn btn-sm btn-outline-danger js-confirm-delete"
                            data-delete-target="form-delete-<?= e($case['id']) ?>"
                            data-confirm-title="Delete case law"
                            data-confirm-message="This will delete the case law record. Proceed?">
                        Delete
                    </button>
                    <form id="form-delete-<?= e($case['id']) ?>" class="d-inline" method="post" action="<?= e(url('/case-laws/delete/' . $case['id'])) ?>">
                        <?= csrf_field() ?>
                        <button class="d-none" type="submit">Confirm Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
