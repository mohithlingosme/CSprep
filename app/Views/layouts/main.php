<?php $flashMessage = flash('message'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?> | <?= e(config('app_name')) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(asset('css/app.css')) ?>">
</head>
<body>
<?php if (is_guest() && request_path() === '/login'): ?>
    <main class="app-shell auth-shell container-fluid">
        <?php if ($flashMessage): ?>
            <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1080; width: min(520px, calc(100% - 24px));">
                <div class="alert alert-<?= e($flashMessage['level'] ?? 'info') ?> alert-dismissible fade show mb-0" role="alert">
                    <?= e($flashMessage['text'] ?? '') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
        <?= $content ?>
    </main>
<?php else: ?>
    <div class="app-shell">
        <aside class="app-sidebar">
            <div class="brand-block">
                <span class="eyebrow">Founder Console</span>
                <h2><?= e(config('app_name')) ?></h2>
                <p>Knowledge ERP + AI training corpus builder</p>
            </div>

            <nav class="nav flex-column app-nav">
                <a class="nav-link <?= is_active_route('/dashboard') || is_active_route('/') ? 'active' : '' ?>" href="<?= e(url('/dashboard')) ?>">Dashboard</a>
                <a class="nav-link <?= is_active_route('/subjects') ? 'active' : '' ?>" href="<?= e(url('/subjects')) ?>">Subjects</a>
                <a class="nav-link <?= is_active_route('/chapters') ? 'active' : '' ?>" href="<?= e(url('/chapters')) ?>">Chapters</a>
                <a class="nav-link <?= is_active_route('/topics') ? 'active' : '' ?>" href="<?= e(url('/topics')) ?>">Topics</a>
                <a class="nav-link <?= is_active_route('/legal-provisions') ? 'active' : '' ?>" href="<?= e(url('/legal-provisions')) ?>">Legal Provisions</a>
                <a class="nav-link <?= is_active_route('/knowledge') ? 'active' : '' ?>" href="<?= e(url('/knowledge')) ?>">Knowledge Bank</a>
                <a class="nav-link <?= is_active_route('/case-laws') ? 'active' : '' ?>" href="<?= e(url('/case-laws')) ?>">Case Laws</a>
                <a class="nav-link <?= is_active_route('/study-items') ? 'active' : '' ?>" href="<?= e(url('/study-items')) ?>">Study Engine</a>
                <a class="nav-link <?= is_active_route('/compliance') ? 'active' : '' ?>" href="<?= e(url('/compliance')) ?>">Compliance</a>
                <a class="nav-link <?= is_active_route('/source-documents') ? 'active' : '' ?>" href="<?= e(url('/source-documents')) ?>">Source Documents</a>
                <a class="nav-link <?= is_active_route('/imports') ? 'active' : '' ?>" href="<?= e(url('/imports')) ?>">Imports</a>
                <a class="nav-link <?= is_active_route('/exports') ? 'active' : '' ?>" href="<?= e(url('/exports')) ?>">Exports</a>
            </nav>

            <form method="post" action="<?= e(url('/logout')) ?>" class="mt-auto">
                <?= csrf_field() ?>
                <button class="btn btn-outline-light w-100" type="submit">Sign Out</button>
            </form>
        </aside>

        <main class="app-content">
            <header class="app-header">
                <div>
                    <span class="eyebrow">Institution Builder</span>
                    <h1 class="page-title"><?= e($title) ?></h1>
                </div>
                <?php if ($user = current_user()): ?>
                    <div class="user-pill">
                        <strong><?= e($user['name']) ?></strong>
                        <span><?= e(ucfirst($user['role'])) ?></span>
                    </div>
                <?php endif; ?>
            </header>

            <?php if ($flashMessage): ?>
                <div class="alert alert-<?= e($flashMessage['level'] ?? 'info') ?> alert-dismissible fade show" role="alert">
                    <?= e($flashMessage['text'] ?? '') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?= $content ?>
        </main>
    </div>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= e(asset('js/app.js')) ?>"></script>
</body>
</html>
