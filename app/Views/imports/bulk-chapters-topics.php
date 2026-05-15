<?php
$subjectId = (int) ($selected_subject_id ?? 0);
$subjects = $subjects ?? [];
$preview = $preview ?? null;
$inputValue = $inputValue ?? '';
$error = $error ?? null;
?>


<section class="row g-4">
    <div class="col-xl-5">
        <form method="post" action="<?= e(url('/imports/bulk-chapters-topics')) ?>" class="app-card" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="section-heading mb-4">
                <div>
                    <span class="eyebrow">Bulk Add Chapters & Topics</span>
                    <h3>Textarea-driven syllabus ingestion</h3>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Subject</label>
                <select class="form-select" name="subject_id" required>
                    <option value="">Select subject...</option>
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?= e((string) $subject['id']) ?>" <?= $subjectId === (int) $subject['id'] ? 'selected' : '' ?>>
                            <?= e($subject['name'] ?? $subject['title'] ?? '') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Bulk Input</label>
                <textarea class="form-control" name="bulk_text" rows="12" required placeholder="Chapter: Company Formation\n\nIncorporation\nCertificate of Incorporation\nMemorandum of Association\nArticles of Association\n\nChapter: Share Capital\n\nTypes of Share Capital\n- Issue of Shares\nShare Certificates"><?php echo htmlspecialchars((string) $inputValue); ?></textarea>
                <div class="form-text">Lines starting with <code>Chapter:</code> create chapters. Lines starting with <code>-</code> or plain lines after a chapter create topics.</div>
            </div>

            <div class="d-grid gap-2 d-md-flex">
                <button class="btn btn-outline-primary" type="submit" name="action" value="preview">Preview</button>
                <button class="btn btn-primary" type="submit" name="action" value="import">Import</button>
            </div>
        </form>
    </div>

    <div class="col-xl-7">
        <div class="app-card h-100">
            <div class="section-heading mb-4">
                <div>
                    <span class="eyebrow">Preview</span>
                    <h3>Parsed chapter/topic structure</h3>
                </div>
            </div>

            <?php if ($preview === null): ?>
                <p class="text-muted mb-0">Use Preview to validate parsing and hierarchy before importing.</p>
            <?php elseif (! empty($error)): ?>
                <div class="alert alert-danger"><?= e((string) $error) ?></div>
            <?php else: ?>

                <div class="mb-3">
                    <span class="badge text-bg-primary">Chapters: <?= e((string) ($preview['chapters_count'] ?? 0)) ?></span>
                    <span class="badge text-bg-secondary">Topics: <?= e((string) ($preview['topics_count'] ?? 0)) ?></span>
                </div>

                <div class="preview-stack">
                    <?php foreach (($preview['chapters'] ?? []) as $chapter): ?>
                        <div class="preview-chapter mb-3">
                            <div class="fw-semibold">Chapter: <?= e((string) ($chapter['chapter_title'] ?? '')) ?></div>
                            <ul class="mt-2">
                                <?php foreach (($chapter['topics'] ?? []) as $topic): ?>
                                    <li><?= e((string) ($topic['title'] ?? '')) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>


