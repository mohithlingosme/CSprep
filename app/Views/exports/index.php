<section class="row g-4">
    <div class="col-xl-5">
        <form method="get" action="<?= e(url('/exports/download')) ?>" class="app-card">
            <div class="section-heading mb-4">
                <div>
                    <span class="eyebrow">AI Export Studio</span>
                    <h3>Generate deployable datasets</h3>
                </div>
            </div>

            <p class="text-muted">Export structured legal corpora for SQL backup, markdown notes, semantic search, or JSONL fine-tuning pipelines.</p>

            <div class="mb-3">
                <label class="form-label">Dataset</label>
                <select class="form-select" name="dataset">
                    <?php foreach ($datasets as $dataset): ?>
                        <option value="<?= e($dataset) ?>"><?= e(strtoupper(str_replace('_', ' ', $dataset))) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">Format</label>
                <select class="form-select" name="format">
                    <?php foreach ($formats as $format): ?>
                        <option value="<?= e($format) ?>"><?= e(strtoupper($format)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button class="btn btn-primary" type="submit">Download Export</button>
        </form>
    </div>
    <div class="col-xl-7">
        <div class="app-card h-100">
            <div class="section-heading mb-4">
                <div>
                    <span class="eyebrow">Export Modes</span>
                    <h3>Recommended use cases</h3>
                </div>
            </div>
            <div class="hint-list">
                <div><strong>JSON:</strong> full structured objects for APIs, backups, and internal integrations.</div>
                <div><strong>JSONL:</strong> line-separated records for embeddings, RAG chunks, and AI training pipelines.</div>
                <div><strong>CSV:</strong> spreadsheet-friendly extraction for bulk editing and audit review.</div>
                <div><strong>Markdown:</strong> portable study notes or legal handbook publishing.</div>
                <div><strong>XML:</strong> structured interchange for external systems.</div>
                <div><strong>SQL:</strong> schema bootstrap for fresh XAMPP or server deployment.</div>
                <div><strong>AI JSONL:</strong> normalized instruction-style corpus from founder-authored knowledge entries.</div>
                <div><strong>Full Corpus:</strong> combined export across knowledge, case laws, provisions, study items, relations, and version history.</div>
            </div>
        </div>
    </div>
</section>
