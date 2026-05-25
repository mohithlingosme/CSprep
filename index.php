<?php require __DIR__ . '/controller.php'; ?>
<?php $normalizeCase = static fn(string $value): string => function_exists('mb_strtolower') ? mb_strtolower($value) : strtolower($value); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS Prep Repository</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar">
            <div>
                <p class="eyebrow">Study System</p>
                <h1>CS Prep Repository</h1>
                <p class="sidebar-copy">Browse concepts, open full notes, and review linked practice questions from the same screen.</p>
            </div>

            <nav class="subject-nav" aria-label="Subjects">
                <?php foreach ($subjectConfig as $key => $config): ?>
                    <a class="subject-link <?php echo $key === $subject ? 'is-active' : ''; ?>" href="?subject=<?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($config['label'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                <?php endforeach; ?>
            </nav>

            <div class="sidebar-meta">
                <span><?php echo count($data); ?> concepts</span>
                <span>Current subject: <?php echo htmlspecialchars($activeSubject['label'], ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
        </aside>

        <main class="main-panel">
            <section class="toolbar">
                <div>
                    <p class="eyebrow">Active Collection</p>
                    <h2><?php echo htmlspecialchars($activeSubject['label'], ENT_QUOTES, 'UTF-8'); ?></h2>
                </div>
                <label class="search-box" for="concept-search">
                    <span>Search</span>
                    <input id="concept-search" type="search" placeholder="Filter concepts, statutes, topics...">
                </label>
            </section>

            <section id="card-grid" class="grid" aria-live="polite">
                <?php foreach ($data as $item): ?>
                    <article
                        class="card"
                        data-id="<?php echo (int) $item['id']; ?>"
                        data-title="<?php echo htmlspecialchars($normalizeCase($item['display_title']), ENT_QUOTES, 'UTF-8'); ?>"
                        data-subtitle="<?php echo htmlspecialchars($normalizeCase($item['display_subtitle']), ENT_QUOTES, 'UTF-8'); ?>"
                        data-summary="<?php echo htmlspecialchars($normalizeCase($item['display_summary']), ENT_QUOTES, 'UTF-8'); ?>"
                    >
                        <p class="card-kicker"><?php echo htmlspecialchars($item['display_subtitle'] ?: $activeSubject['label'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <h3><?php echo htmlspecialchars($item['display_title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p class="card-summary"><?php echo htmlspecialchars($item['display_summary'] ?: 'Open the concept to view the full repository entry.', ENT_QUOTES, 'UTF-8'); ?></p>
                        <div class="card-actions">
                            <button class="btn-primary" type="button" data-action="open-detail" data-id="<?php echo (int) $item['id']; ?>">Open Detail</button>
                            <button class="btn-secondary" type="button" data-action="open-practice" data-id="<?php echo (int) $item['id']; ?>">Practice</button>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>

            <template id="empty-state-template">
                <div class="empty-state">
                    <h3>No concepts match this search.</h3>
                    <p>Try a broader keyword or switch subjects.</p>
                </div>
            </template>
        </main>
    </div>

    <div id="exam-modal" class="modal hidden" aria-hidden="true">
        <div class="modal-backdrop" data-close-modal="true"></div>
        <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="modal-title">
            <button class="modal-close" type="button" data-close-modal="true" aria-label="Close">×</button>
            <div id="modal-content"></div>
        </div>
    </div>

    <script>
        window.APP_STATE = {
            subject: <?php echo json_encode($subject, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>,
            subjectLabel: <?php echo json_encode($activeSubject['label'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
        };
    </script>
    <script src="app.js"></script>
</body>
</html>
