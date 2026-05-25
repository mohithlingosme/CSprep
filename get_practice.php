<?php

header('Content-Type: application/json');

require_once 'db.php';

$subjectConfig = require __DIR__ . '/subject_config.php';
$database = new Database();
$db = $database->getConnection();

$questionId = isset($_GET['q_id']) ? (int) $_GET['q_id'] : 0;
$conceptId = isset($_GET['concept_id']) ? (int) $_GET['concept_id'] : 0;
$subject = $_GET['subject'] ?? null;

if ($questionId > 0) {
    $query = "SELECT q.id, q.question_text, q.difficulty_level, q.past_paper_reference, q.total_marks,
                     s.step_number, s.step_title, s.step_logic, s.marks_awarded
              FROM practice_questions q
              LEFT JOIN solution_steps s ON q.id = s.question_id
              WHERE q.id = :id
              ORDER BY s.step_number ASC";

    $stmt = $db->prepare($query);
    $stmt->execute([':id' => $questionId]);

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

if ($conceptId > 0 && $subject && array_key_exists($subject, $subjectConfig)) {
    $domain = $subjectConfig[$subject]['domain'];

    $query = "SELECT id, question_text, difficulty_level, past_paper_reference, total_marks
              FROM practice_questions
              WHERE related_concept_id = :concept_id AND subject_domain = :subject_domain
              ORDER BY id DESC";

    $stmt = $db->prepare($query);
    $stmt->execute([
        ':concept_id' => $conceptId,
        ':subject_domain' => $domain,
    ]);

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

http_response_code(400);
echo json_encode(['error' => 'Provide either q_id or concept_id with subject']);
