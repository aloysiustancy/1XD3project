<?php
session_start();
header('Content-Type: application/json');
require 'db.php';

$userID = $_SESSION['userId'] ?? null;

$stmt = $pdo->prepare("
    SELECT emoji FROM moodEntries
    WHERE userID <=> ? AND entryDate = CURDATE()
    ORDER BY entryID DESC
    LIMIT 1
");

$stmt->execute([$userID]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    echo json_encode([
        "exists" => true,
        "emoji" => $result['emoji']
    ]);
} else {
    echo json_encode([
        "exists" => false
    ]);
}