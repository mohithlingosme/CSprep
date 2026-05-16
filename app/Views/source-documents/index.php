<section class="page-actions mb-4">
    <p class="text-muted mb-0">Register PDFs, notes, templates, drafts, and raw materials before converting them into structured knowledge assets.</p>
    <a class="btn btn-primary" href="<?= e(url('/source-documents/create')) ?>">Upload Document</a>
</section>

<div class="app-card">
    <table class="table table-hover align-middle datatable">
        <thead>
        <tr>
            <th>Title</th>
            <th>Type</th>
            <th>File</th>
            <th>Extraction</th>
            <th>Tags</th>
            <th>Uploaded</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($documents as $document): ?>
            <tr>
                <td>
                    <strong><?= e($document['title']) ?></strong>
                    <div class="table-subtext"><?= e($document['description']) ?></div>
                </td>
                <td><?= e($document['document_type']) ?></td>
                <td><?= e($document['file_name'] ?: 'Metadata only') ?></td>
                <td><span class="badge text-bg-<?= e(badge_class((string) $document['extraction_status'])) ?>"><?= e($document['extraction_status']) ?></span></td>
                <td><?= e($document['tags']) ?></td>
                <td><?= e(format_date($document['created_at'])) ?></td>
                <td class="text-end">
                    <a class="btn btn-sm btn-outline-primary" href="<?= e(url('/source-documents/edit/' . $document['id'])) ?>">Edit</a>
<button type="button" class="btn btn-sm btn-outline-danger js-confirm-delete"
                            data-delete-target="form-delete-<?= e($document['id']) ?>"
                            data-confirm-title="Delete source document"
                            data-confirm-message="This will delete the source document record. Proceed?">
                        Delete
                    </button>
                    <form id="form-delete-<?= e($document['id']) ?>" class="d-inline" method="post" action="<?= e(url('/source-documents/delete/' . $document['id'])) ?>">
                        <?= csrf_field() ?>
                        <button class="d-none" type="submit">Confirm Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
