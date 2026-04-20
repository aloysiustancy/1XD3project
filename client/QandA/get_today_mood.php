<?php
// Name: Brian, Aloysius, Haoxuan, Jason
// Date: March 21, 2026
// Returns whether the current user has logged a mood today, and which emoji they picked.
 
session_start();
header('Content-Type: application/json');
require 'db.php';

$userID = $_SESSION['userId'] ?? null;

$stmt = $pdo->prepare("
    SELECT emoji FROM moodentries
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