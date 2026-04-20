<?php
// Name: Brian, Aloysius, Haoxuan, Jason
// Date: March 21, 2026
// Returns all mood entries grouped by date, with emoji counts per day.

session_start();
header('Content-Type: application/json');
require 'db.php';

$stmt = $pdo->query("
    SELECT entryDate, emoji, COUNT(*) as count
    FROM moodentries
    GROUP BY entryDate, emoji
");

$data = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $date = $row['entryDate'];
    if (!isset($data[$date])) {
        $data[$date] = [];
    }
    $data[$date][] = [
        "emoji" => $row['emoji'],
        "count" => $row['count']
    ];
}

echo json_encode($data);
?>