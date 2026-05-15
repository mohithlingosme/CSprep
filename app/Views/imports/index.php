<section class="row g-4">
    <div class="col-xl-5">
        <form method="post" enctype="multipart/form-data" action="<?= e(url('/imports/upload')) ?>" class="app-card">
            <?= csrf_field() ?>
            <div class="section-heading mb-4">
                <div>
                    <span class="eyebrow">Bulk Injection</span>
                    <h3>CSV import workflow</h3>
                </div>
            </div>

            <p class="text-muted">Upload founder-maintained CSV files using headers that match the database column names for the selected module.</p>

            <div class="mb-3">
                <label class="form-label">Module</label>
                <select class="form-select" name="module_name" required>
                    <?php foreach ($modules as $module): ?>
                        <option value="<?= e($module) ?>"><?= e(strtoupper(str_replace('_', ' ', $module))) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">CSV File</label>
                <input class="form-control" type="file" name="csv_file" accept=".csv" required>
            </div>

            <button class="btn btn-primary" type="submit">Run Import</button>
        </form>
    </div>

    <div class="col-xl-7">
        <div class="app-card h-100">

            <div class="section-heading mb-4">
                <div>
                    <span class="eyebrow">Founder Guidance</span>
                    <h3>Recommended import headers</h3>
                </div>
            </div>

            <div class="mb-4">
                <a class="btn btn-outline-primary" href="<?= e(url('/imports/bulk-chapters-topics')) ?>">
                    Bulk Add Chapters & Topics
                </a>
            </div>


            <div class="hint-list">
                <div><code>subjects</code>: code, name, domain_type, description, syllabus_version, status, display_order</div>
                <div><code>chapters</code>: subject_id, code, title, weightage, study_order, dependency_notes, summary</div>
                <div><code>topics</code>: chapter_id, parent_id, title, learning_objectives, difficulty, revision_interval_days, mastery_score, exam_relevance, next_revision_at, dependency_map</div>
                <div><code>legal_provisions</code>: subject_id, topic_id, framework_type, reference_code, title, act_name, bare_text, simplified_text, compliance_checklist, drafting_notes, penalties, forms_involved, effective_date, amendment_notes, ai_labels, status</div>
                <div><code>knowledge</code>: subject_id, chapter_id, topic_id, legal_provision_id, source_document_id, entry_type, title, summary, content_html, key_takeaways, exam_relevance, difficulty, ai_ready, ai_label, revision_tags, compliance_map, citation_reference, status</div>
                <div><code>case_laws</code>: subject_id, topic_id, legal_provision_id, case_name, citation, court_name, court_level, case_year, facts, issues, held_text, legal_principles, exam_relevance, linked_sections</div>
                <div><code>study_items</code>: subject_id, topic_id, knowledge_entry_id, item_type, prompt, option_a, option_b, option_c, option_d, correct_answer, explanation, marks, difficulty, exam_year, revision_bucket, ai_ready</div>
                <div><code>compliance</code>: subject_id, topic_id, provision_id, title, entity_type, frequency, due_date, form_name, regulator, priority, status, description, checklist, penalty_risk, owner_name</div>
            </div>
        </div>
    </div>
</section>

<div class="app-card mt-4">
    <div class="section-heading mb-4">
        <div>
            <span class="eyebrow">Import History</span>
            <h3>Recent CSV runs</h3>
        </div>
    </div>
    <table class="table table-hover align-middle">
        <thead>
        <tr>
            <th>Module</th>
            <th>File</th>
            <th>Rows</th>
            <th>Status</th>
            <th>Created</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= e($log['module_name']) ?></td>
                <td><?= e($log['file_name']) ?></td>
                <td><?= e($log['records_imported']) ?></td>
                <td><span class="badge text-bg-<?= e(badge_class((string) $log['status'])) ?>"><?= e($log['status']) ?></span></td>
                <td><?= e(format_date($log['created_at'], 'd M Y H:i')) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
