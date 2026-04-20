<?php
// Name: Brian, Aloysius, Haoxuan, Jason
// Date: March 21, 2026
// Returns all mood entries grouped by date, with emoji counts per day.

session_start();
header('Content-Type: application/json');
require 'db.php';

$userID = $_SESSION['userId'] ?? null;
if (!$userID) {
    echo json_encode([]);
    exit;
}

// Only query the current user's mood records (for calendar display).
$stmt = $pdo->prepare("
    SELECT entryDate, emoji
    FROM moodentries
    WHERE userID = ?
");
$stmt->execute([$userID]);

$data = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $date = $row['entryDate'];
    if (!isset($data[$date])) {
        $data[$date] = [];
    }
    $data[$date][] = [
        "emoji" => $row['emoji']
    ];
}

echo json_encode($data);
?>