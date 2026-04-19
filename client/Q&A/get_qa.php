<?php
header('Content-Type: application/json');
require_once 'db.php';

// 获取当前 active 问题
session_start();
$userID = $_SESSION['userId'] ?? null;

$stmt = $pdo->prepare("
    SELECT * FROM communityQuestions
    WHERE DATE(postedAt) <= CURDATE()
    ORDER BY RAND()
    LIMIT 1
");
$stmt->execute();
$question = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$question) {
    echo json_encode(["question" => null]);
    exit;
}

// 🔥 检查用户是否回答过
$stmt2 = $pdo->prepare("
    SELECT answerText FROM communityAnswers
    WHERE questionID = ? AND userID <=> ?
    LIMIT 1
");
$stmt2->execute([$question['questionID'], $userID]);
$userAnswer = $stmt2->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    "question" => $question,
    "userAnswer" => $userAnswer
]);
?>