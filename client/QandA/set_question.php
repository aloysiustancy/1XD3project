<?php
session_start();
header('Content-Type: application/json');
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

$stmtCheck = $pdo->prepare("
    SELECT COUNT(*) FROM communityquestions
    WHERE DATE(postedAt) = CURDATE()
");
$stmtCheck->execute();

if ($stmtCheck->fetchColumn() > 0) {
    echo json_encode([
        'error' => 'You or another moderator have already set up a different question.'
    ]);
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO communityquestions (questionText, postedBy, postedAt)
    VALUES (?, ?, NOW())
");

$stmt->execute([$text, $_SESSION['userId']]);

echo json_encode(['success' => true]);
?>