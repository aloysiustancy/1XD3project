<?php
// Name: Brian, Aloysius, Haoxuan, Jason
// Date: March 21, 2026
// Saves the user's mood for today. Updates the existing entry if one already exists.

session_start();
header('Content-Type: application/json');
require 'db.php';

$data   = json_decode(file_get_contents("php://input"), true);
$emoji  = $data['emoji'];
$userID = $_SESSION['userId'] ?? null;

$stmt = $pdo->prepare("
    SELECT entryID FROM moodentries
    WHERE userID <=> ? AND entryDate = CURDATE()
");
$stmt->execute([$userID]);
$existing = $stmt->fetch();

if ($existing) {
    $stmt = $pdo->prepare("UPDATE moodentries SET emoji = ? WHERE entryID = ?");
    $stmt->execute([$emoji, $existing['entryID']]);
    echo json_encode(["status" => "updated"]);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO moodentries (userID, entryDate, emoji) VALUES (?, CURDATE(), ?)");
$stmt->execute([$userID, $emoji]);

echo json_encode(["status" => "success"]);