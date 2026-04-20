<?php
session_start();
header('Content-Type: application/json');
require 'db.php';

// Statistics on the distribution of all users' Moods today
$stmt = $pdo->prepare("
    SELECT emoji, COUNT(*) as count
    FROM moodentries
    WHERE DATE(entryDate) = CURDATE()
    GROUP BY emoji, HEX(emoji)
    ORDER BY count DESC
");
$stmt->execute();
$stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($stats);
?>