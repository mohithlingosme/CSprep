<section class="page-actions mb-4">
    <p class="text-muted mb-0">Build nested topics, assign revision intervals, and track mastery for exam and AI-readiness planning.</p>
    <a class="btn btn-primary" href="<?= e(url('/topics/create')) ?>">Add Topic</a>
</section>

<?php
$filters = $filters ?? [];
$selectedChapterId = isset($filters['chapter_id']) ? (int) $filters['chapter_id'] : 0;
$provisionQuery = isset($filters['provision_query']) ? (string) $filters['provision_query'] : '';
$sort = isset($filters['sort']) ? (string) $filters['sort'] : 'default';
$dir = strtolower((string) ($filters['dir'] ?? 'asc')) === 'desc' ? 'desc' : 'asc';
?>


<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="app-card p-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Filter by Chapter</label>
                    <select class="form-select" name="chapter_id" form="topics-filter-form" onchange="document.getElementById('topics-filter-form').submit()">
                        <option value="">All chapters</option>
                        <?php foreach (($chapters ?? []) as $ch): ?>
                            <option value="<?= (int) $ch['id'] ?>" <?= $selectedChapterId === (int) $ch['id'] ? 'selected' : '' ?>>
                                <?= e($ch['subject_name']) ?> — <?= e($ch['title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-5">
                    <label class="form-label">Statutes / Legal provisions (search)</label>
                    <input class="form-control" type="text" name="provision_query" value="<?= e($provisionQuery) ?>" placeholder="e.g. 2013, reference code, act name" form="topics-filter-form" />
                </div>

                <div class="col-md-3 d-grid gap-2">
                    <button class="btn btn-primary" type="submit" form="topics-filter-form">Apply</button>
                    <a class="btn btn-outline-secondary" href="<?= e(url('/topics')) ?>">Reset</a>
                </div>
            </div>

            <form id="topics-filter-form" method="get" action="<?= e(url('/topics')) ?>" class="mt-3">
                <input type="hidden" name="chapter_id" value="<?= e((string) $selectedChapterId) ?>" />
                <input type="hidden" name="provision_query" value="<?= e($provisionQuery) ?>" />
                <input type="hidden" name="sort" value="<?= e($sort) ?>" />
                <input type="hidden" name="dir" value="<?= e($dir) ?>" />
            </form>

        </div>
    </div>

    <div class="col-lg-4">
        <div class="app-card p-3">
            <div class="section-heading">
                <div>
                    <span class="eyebrow">Topics-wise Dashboard</span>
                    <h3 class="mb-0">Mapped legal statutes</h3>
                </div>
            </div>
            <p class="text-muted mb-3">Shows legal provisions linked to topics currently in the filtered table.</p>

            <div class="list-stack" style="max-height: 420px; overflow: auto;">
                <?php foreach (($topics ?? []) as $topic): ?>
                    <?php $tId = (int) ($topic['id'] ?? 0); ?>
                    <div class="list-item">
                        <div>
                            <strong><?= e($topic['title']) ?></strong>
                            <p class="mb-0"><?= e($topic['subject_name']) ?> · <?= e($topic['chapter_name']) ?></p>
                        </div>
                        <span class="badge text-bg-primary"><?= e((string) ($topic['provision_count'] ?? 0)) ?> provisions</span>
                    </div>
                <?php endforeach; ?>
                <?php if (!($topics ?? [])): ?>
                    <p class="text-muted mb-0">No topics match the selected filters.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="app-card">
    <table class="table table-hover align-middle datatable">
        <thead>
        <tr>
            <th>Subject</th>
            <th>Chapter</th>
            <th>
                Topic
                <?php if ($sort === 'title'): ?>
                    <span class="text-muted">(<?= e($dir) ?>)</span>
                <?php endif; ?>
            </th>
            <th>Parent</th>
            <th>Difficulty</th>
            <th>Revision</th>
            <th>Mastery</th>
            <th>Exam Relevance</th>
            <th>Statutes</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach (($topics ?? []) as $topic): ?>
            <?php $tId = (int) ($topic['id'] ?? 0); ?>
            <tr>
                <td><?= e($topic['subject_name']) ?></td>
                <td><?= e($topic['chapter_name']) ?></td>
                <td>
                    <strong><?= e($topic['title']) ?></strong>
                    <div class="table-subtext"><?= e($topic['learning_objectives']) ?></div>
                    <?php if (!empty($provisionGroups[$tId] ?? [])): ?>
                        <div class="table-subtext" style="margin-top:6px;">
                            <strong>Top statute:</strong> <code><?= e($provisionGroups[$tId][0]['reference_code'] ?? '-') ?></code>
                        </div>
                    <?php endif; ?>
                </td>
                <td><?= e($topic['parent_topic'] ?: '-') ?></td>
                <td><span class="badge text-bg-<?= e(badge_class((string) $topic['difficulty'])) ?>"><?= e($topic['difficulty']) ?></span></td>
                <td><?= e($topic['revision_interval_days']) ?> days</td>
                <td><?= e($topic['mastery_score']) ?>%</td>
                <td><?= e($topic['exam_relevance']) ?>/5</td>
                <td>
                    <span class="badge text-bg-<?= ((int) ($topic['provision_count'] ?? 0) > 0) ? 'primary' : 'secondary' ?>">
                        <?= e((string) ($topic['provision_count'] ?? 0)) ?>
                    </span>
                </td>
                <td class="text-end">
                    <a class="btn btn-sm btn-outline-primary" href="<?= e(url('/topics/edit/' . $topic['id'])) ?>">Edit</a>
                    <button type="button" class="btn btn-sm btn-outline-danger js-confirm-delete"
                            data-delete-target="form-delete-<?= e($topic['id']) ?>"
                            data-confirm-title="Delete topic"
                            data-confirm-message="This will delete the topic and related content. Proceed?">
                        Delete
                    </button>
                    <form id="form-delete-<?= e($topic['id']) ?>" class="d-inline" method="post" action="<?= e(url('/topics/delete/' . $topic['id'])) ?>">
                        <?= csrf_field() ?>
                        <button class="d-none" type="submit">Confirm Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

