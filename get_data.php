<?php

header('Content-Type: application/json');

require_once 'db.php';

$subjectConfig = require __DIR__ . '/subject_config.php';
$database = new Database();
$db = $database->getConnection();

$subject = $_GET['subject'] ?? null;
if (!$subject || !array_key_exists($subject, $subjectConfig)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid subject']);
    exit;
}

$table = $subjectConfig[$subject]['table'];
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

$query = "SELECT * FROM {$table}";
$params = [];
$conditions = [];

if ($id) {
    $conditions[] = 'id = :id';
    $params[':id'] = $id;
}

if ($conditions) {
    $query .= ' WHERE ' . implode(' AND ', $conditions);
}

$query .= ' ORDER BY id DESC';

$stmt = $db->prepare($query);
$stmt->execute($params);

$results = $id ? $stmt->fetch(PDO::FETCH_ASSOC) : $stmt->fetchAll(PDO::FETCH_ASSOC);

$jsonColumns = [
    'journal_entries',
    'schedule_iii_presentation',
    'ledger_account_format',
    'standard_calculation_table',
    'flowcharts_json',
];

$decodeJson = static function (&$row) use ($jsonColumns): void {
    if (!$row) {
        return;
    }

    foreach ($jsonColumns as $column) {
        if (!empty($row[$column]) && is_string($row[$column])) {
            $decoded = json_decode($row[$column], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $row[$column] = $decoded;
            }
        }
    }
};

if ($id) {
    $decodeJson($results);
    echo json_encode($results ?: ['error' => 'Record not found']);
    exit;
}

foreach ($results as &$row) {
    $decodeJson($row);
}
unset($row);

echo json_encode($results);
