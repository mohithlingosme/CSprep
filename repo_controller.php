<?php
include_once 'db.php';
$db = (new Database())->getConnection();

// Fetch all Law Provisions
$query = "SELECT * FROM law_provisions ORDER BY id DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$provisions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>