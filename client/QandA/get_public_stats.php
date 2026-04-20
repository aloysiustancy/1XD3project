<?php
session_start();
header('Content-Type: application/json');
require 'db.php';

// Calculate the mood of all users today (not limited to the current user).
$stmt = $pdo->prepare("
SELECT emoji, COUNT(*) as count
FROM moodentries
WHERE entryDate = CURDATE()
GROUP BY emoji
");
$stmt->execute();
$stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($stats);
?>