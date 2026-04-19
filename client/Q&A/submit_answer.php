<?php
session_start();

header('Content-Type: application/json');
require_once 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

$questionID = $data['questionID'];
$answerText = $data['answerText'];

$userID = $_SESSION['userId'] ?? null;

// 插入答案
// 先检查是否回答过
$stmt = $pdo->prepare("
    SELECT * FROM communityAnswers
    WHERE questionID = ? AND userID <=> ?
");
$stmt->execute([$questionID, $userID]);

if ($stmt->fetch()) {
    echo json_encode(["status" => "exists"]);
    exit;
}

// 插入
$stmt = $pdo->prepare("
    INSERT INTO communityAnswers (questionID, userID, answerText)
    VALUES (?, ?, ?)
");
$stmt->execute([$questionID, $userID, $answerText]);

echo json_encode(["status" => "success"]);
?>