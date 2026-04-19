<?php
session_start();
require_once 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

$emoji = $data['emoji'];
$userID = $_SESSION['userId'] ?? null;

// 如果存在 → 更新，不插入
$stmt = $pdo->prepare("
    SELECT entryID FROM moodEntries
    WHERE userID <=> ? AND entryDate = CURDATE()
");
$stmt->execute([$userID]);

$existing = $stmt->fetch();

if ($existing) {
    // 🔥 改成 UPDATE
    $stmt = $pdo->prepare("
        UPDATE moodEntries
        SET emoji = ?
        WHERE entryID = ?
    ");
    $stmt->execute([$emoji, $existing['entryID']]);

    echo json_encode(["status" => "updated"]);
    exit;
}

// 插入新记录
$stmt = $pdo->prepare("
    INSERT INTO moodEntries (userID, entryDate, emoji)
    VALUES (?, CURDATE(), ?)
");
$stmt->execute([$userID, $emoji]);

echo json_encode(["status" => "success"]);