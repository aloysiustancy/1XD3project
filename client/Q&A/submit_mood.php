<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json');
require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

$emoji = $data['emoji'];
$userID = $_SESSION['userId'] ?? null;

// If it exists -> Update, do not insert.
$stmt = $pdo->prepare("
    SELECT entryID FROM moodEntries
    WHERE userID <=> ? AND entryDate = CURDATE()
");
$stmt->execute([$userID]);

$existing = $stmt->fetch();

if ($existing) {
    $stmt = $pdo->prepare("
        UPDATE moodEntries
        SET emoji = ?
        WHERE entryID = ?
    ");
    $stmt->execute([$emoji, $existing['entryID']]);

    echo json_encode(["status" => "updated"]);
    exit;
}

// Insert new record
$stmt = $pdo->prepare("
    INSERT INTO moodEntries (userID, entryDate, emoji)
    VALUES (?, CURDATE(), ?)
");
$stmt->execute([$userID, $emoji]);

echo json_encode(["status" => "success"]);