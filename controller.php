<?php

require_once 'db.php';

$subjectConfig = require __DIR__ . '/subject_config.php';
$db = (new Database())->getConnection();

$subject = $_GET['subject'] ?? 'law';
$subject = array_key_exists($subject, $subjectConfig) ? $subject : 'law';
$activeSubject = $subjectConfig[$subject];

$table = $activeSubject['table'];
$sql = "SELECT * FROM {$table} ORDER BY id DESC";

$stmt = $db->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($data as &$item) {
    $titleField = $activeSubject['title_field'];
    $item['display_title'] = $item[$titleField] ?? 'Untitled';

    $subtitleParts = [];
    foreach ($activeSubject['subtitle_fields'] as $field) {
        if (!empty($item[$field])) {
            $subtitleParts[] = $item[$field];
        }
    }

    $item['display_subtitle'] = implode(' · ', $subtitleParts);

    $summaryField = $activeSubject['summary_field'];
    $summary = trim((string) ($item[$summaryField] ?? ''));
    $summaryLength = function_exists('mb_strlen') ? mb_strlen($summary) : strlen($summary);
    $item['display_summary'] = function_exists('mb_substr') ? mb_substr($summary, 0, 180) : substr($summary, 0, 180);
    if ($summaryLength > 180) {
        $item['display_summary'] .= '...';
    }
}
unset($item);
