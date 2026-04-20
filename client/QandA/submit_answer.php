<?php
// Name: Brian, Aloysius, Haoxuan, Jason
// Date: March 21, 2026
// Saves a user's answer to today's community question. Each user can only answer once.

session_start();
header('Content-Type: application/json');
require 'db.php';

$data       = json_decode(file_get_contents("php://input"), true);
$questionID = $data['questionID'];
$answerText = $data['answerText'];
$userID     = $_SESSION['userId'] ?? null;

// Check if user already answered
$stmt = $pdo->prepare("
    SELECT * FROM communityanswers
    WHERE questionID = ? AND userID <=> ?
");
$stmt->execute([$questionID, $userID]);

if ($stmt->fetch()) {
    echo json_encode(["status" => "exists"]);
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO communityanswers (questionID, userID, answerText)
    VALUES (?, ?, ?)
");
$stmt->execute([$questionID, $userID, $answerText]);

echo json_encode(["status" => "success"]);
?>