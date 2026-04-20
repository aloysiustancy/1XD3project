<?php
// Name: Brian, Aloysius, Haoxuan, Jason
// Date: March 21, 2026
// Returns today's community question, the current user's answer, and up to 10 random answers from others.

session_start();
header('Content-Type: application/json');
require 'db.php';
// Get the current active issue
$userID = $_SESSION['userId'] ?? null;

$stmt = $pdo->prepare("
    SELECT * FROM communityquestions
    WHERE DATE(postedAt) = CURDATE()
    LIMIT 1
");
$stmt->execute();
$question = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$question) {
    echo json_encode(["question" => null]);
    exit;
}

// Check if the user has answered
$stmt2 = $pdo->prepare("
    SELECT answerText FROM communityanswers
    WHERE questionID = ? AND userID <=> ?
    LIMIT 1
");
$stmt2->execute([$question['questionID'], $userID]);
$userAnswer = $stmt2->fetch(PDO::FETCH_ASSOC);

// Randomly retrieve answers from other users (maximum 10).
$stmt3 = $pdo->prepare("
    SELECT userID, answerText
    FROM communityanswers
    WHERE questionID = ?
      AND (userID <> ? OR ? IS NULL)
    ORDER BY RAND()
    LIMIT 10
");
$stmt3->execute([$question['questionID'], $userID, $userID]);
$others = $stmt3->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "question" => $question,
    "userAnswer" => $userAnswer,
    "others" => $others
]);