<?php
session_start();
header('Content-Type: application/json');
require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

$questionID = $data['questionID'];
$answerText = $data['answerText'];

$userID = $_SESSION['userId'] ?? null;

// Insert answer
// First check if it has been answered
$stmt = $pdo->prepare("
    SELECT * FROM communityanswers
    WHERE questionID = ? AND userID <=> ?
");
$stmt->execute([$questionID, $userID]);

if ($stmt->fetch()) {
    echo json_encode(["status" => "exists"]);
    exit;
}

// Insert
$stmt = $pdo->prepare("
    INSERT INTO communityanswers (questionID, userID, answerText)
    VALUES (?, ?, ?)
");
$stmt->execute([$questionID, $userID, $answerText]);

echo json_encode(["status" => "success"]);
?>