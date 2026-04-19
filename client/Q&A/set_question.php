<?php
session_start();
require 'db.php';

if (!$_SESSION['isAdmin']) {
    echo json_encode(['error' => 'Not authorized']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$text = trim($data['text'] ?? '');

if (!$text) {
    echo json_encode(['error' => 'Empty']);
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO communityQuestions (questionText, postedBy, postedAt)
    VALUES (?, ?, NOW())
");

$stmt->execute([$text, $_SESSION['userId']]);

echo json_encode(['success' => true]);
?>