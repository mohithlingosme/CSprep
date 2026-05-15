<?php
$founder = $dashboard['founder'];
$student = $dashboard['student'];
$corporate = $dashboard['corporate'];
$latest = $dashboard['latest'];
?>

<section class="hero-panel mb-4">
    <div class="row g-4 align-items-center">
        <div class="col-lg-7">
            <span class="eyebrow">Knowledge Infrastructure</span>
            <h2 class="hero-title">Founder-driven corporate law corpus, revision engine, and compliance control room.</h2>
            <p class="hero-copy">Every note, section, case law, checklist, and study asset is captured once and reused for learning, legal reasoning, AI training, and future monetization.</p>
        </div>
        <div class="col-lg-5">
            <div class="hero-metrics">
                <div>
                    <strong><?= e(format_number($founder['knowledge_entries'])) ?></strong>
                    <span>knowledge entries</span>
                </div>
                <div>
                    <strong><?= e(format_number($founder['ai_ready'])) ?> / <?= e($founder['ai_readiness_pct']) ?>%</strong>
                    <span>AI-ready corpus</span>
                </div>
                <div>
                    <strong><?= e(format_number($founder['compliance_items'])) ?></strong>
                    <span>compliance obligations</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="metric-card">
                    <span>Subjects</span>
                    <strong><?= e(format_number($founder['subjects'])) ?></strong>
                    <small>Core domains mapped</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="metric-card">
                    <span>Legal Provisions</span>
                    <strong><?= e(format_number($founder['legal_provisions'])) ?></strong>
                    <small>Sections, rules, standards</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="metric-card">
                    <span>Case Laws</span>
                    <strong><?= e(format_number($founder['case_laws'])) ?></strong>
                    <small>Reasoning and precedent bank</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="metric-card">
                    <span>Study Items</span>
                    <strong><?= e(format_number($founder['study_items'])) ?></strong>
                    <small>MCQs, PYQs, flashcards</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="metric-card">
                    <span>Revision Coverage</span>
                    <strong><?= e($founder['revision_mapped_pct']) ?>%</strong>
                    <small>Topics with revision mapping</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="metric-card">
                    <span>Documents</span>
                    <strong><?= e(format_number($founder['source_documents'])) ?></strong>
                    <small>PDFs, drafts, sources</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="app-card h-100">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Student Engine</span>
                    <h3>Readiness snapshot</h3>
                </div>
            </div>
            <div class="score-grid">
                <div>
                    <strong><?= e($student['average_mastery']) ?>%</strong>
                    <span>avg mastery</span>
                </div>
                <div>
                    <strong><?= e($student['mock_average']) ?>%</strong>
                    <span>mock average</span>
                </div>
                <div>
                    <strong><?= e(count($student['revision_tasks'])) ?></strong>
                    <span>upcoming tasks</span>
                </div>
                <div>
                    <strong><?= e($corporate['overdue']) ?></strong>
                    <span>overdue compliance</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="row g-4 mb-4">
    <div class="col-xl-6">
        <div class="app-card">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Corpus Analytics</span>
                    <h3>Knowledge distribution</h3>
                </div>
            </div>
            <canvas id="founderChart" height="220"></canvas>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="app-card">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Corporate Pulse</span>
                    <h3>Compliance status mix</h3>
                </div>
            </div>
            <canvas id="complianceChart" height="220"></canvas>
        </div>
    </div>
</section>

<section class="row g-4 mb-4">
    <div class="col-xl-4">
        <div class="app-card h-100">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Weak Topics</span>
                    <h3>Revision attention list</h3>
                </div>
            </div>
            <div class="list-stack">
                <?php foreach ($student['weak_topics'] as $topic): ?>
                    <div class="list-item">
                        <div>
                            <strong><?= e($topic['title']) ?></strong>
                            <p><?= e($topic['subject_name']) ?> / <?= e($topic['chapter_name']) ?></p>
                        </div>
                        <span class="badge text-bg-<?= e(badge_class((string) $topic['difficulty'])) ?>"><?= e($topic['mastery_score']) ?>%</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="app-card h-100">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Revision Queue</span>
                    <h3>Daily tasks</h3>
                </div>
            </div>
            <div class="list-stack">
                <?php if ($student['revision_tasks']): ?>
                    <?php foreach ($student['revision_tasks'] as $task): ?>
                        <div class="list-item">
                            <div>
                                <strong><?= e($task['title']) ?></strong>
                                <p><?= e($task['topic_name'] ?? 'Unlinked topic') ?> · <?= e(format_date($task['task_date'])) ?></p>
                            </div>
                            <span class="badge text-bg-<?= e(badge_class((string) $task['status'])) ?>"><?= e($task['status']) ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">Add revision tasks directly in the database or extend the dashboard workflow in the next phase.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="app-card h-100">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Upcoming Filings</span>
                    <h3>Due soon</h3>
                </div>
            </div>
            <div class="list-stack">
                <?php if ($corporate['due_soon']): ?>
                    <?php foreach (array_slice($corporate['due_soon'], 0, 6) as $item): ?>
                        <div class="list-item">
                            <div>
                                <strong><?= e($item['title']) ?></strong>
                                <p><?= e($item['subject_name']) ?> · <?= e(format_date($item['due_date'])) ?></p>
                            </div>
                            <span class="badge text-bg-<?= e(badge_class((string) $item['priority'])) ?>"><?= e($item['priority']) ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">No active due-soon filings recorded.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="row g-4">
    <div class="col-xl-4">
        <div class="app-card h-100">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Latest Knowledge</span>
                    <h3>Recently edited notes</h3>
                </div>
            </div>
            <div class="list-stack">
                <?php foreach ($latest['knowledge'] as $entry): ?>
                    <div class="list-item">
                        <div>
                            <strong><?= e($entry['title']) ?></strong>
                            <p><?= e($entry['entry_type']) ?> · <?= e(format_date($entry['updated_at'], 'd M Y H:i')) ?></p>
                        </div>
                        <span class="badge text-bg-<?= e(badge_class((string) $entry['status'])) ?>"><?= e($entry['status']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="app-card h-100">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Latest Cases</span>
                    <h3>Case law updates</h3>
                </div>
            </div>
            <div class="list-stack">
                <?php foreach ($latest['case_laws'] as $case): ?>
                    <div class="list-item">
                        <div>
                            <strong><?= e($case['case_name']) ?></strong>
                            <p><?= e($case['citation']) ?> · <?= e($case['case_year']) ?></p>
                        </div>
                        <span class="badge text-bg-primary"><?= e($case['court_level']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="app-card h-100">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Latest Sources</span>
                    <h3>Document intake</h3>
                </div>
            </div>
            <div class="list-stack">
                <?php foreach ($latest['documents'] as $document): ?>
                    <div class="list-item">
                        <div>
                            <strong><?= e($document['title']) ?></strong>
                            <p><?= e($document['document_type']) ?> · <?= e(format_date($document['created_at'])) ?></p>
                        </div>
                        <span class="badge text-bg-<?= e(badge_class((string) $document['extraction_status'])) ?>"><?= e($document['extraction_status']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<script>
window.dashboardChartData = {
    founder: {
        labels: ['Knowledge', 'Provisions', 'Cases', 'Study', 'Compliance', 'Documents'],
        values: [
            <?= (int) $founder['knowledge_entries'] ?>,
            <?= (int) $founder['legal_provisions'] ?>,
            <?= (int) $founder['case_laws'] ?>,
            <?= (int) $founder['study_items'] ?>,
            <?= (int) $founder['compliance_items'] ?>,
            <?= (int) $founder['source_documents'] ?>
        ]
    },
    compliance: {
        labels: <?= json_encode(array_column($corporate['status_breakdown'], 'status')) ?>,
        values: <?= json_encode(array_map('intval', array_column($corporate['status_breakdown'], 'total'))) ?>
    }
};
</script>
