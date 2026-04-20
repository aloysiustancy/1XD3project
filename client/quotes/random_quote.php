<?php
// Name: Brian, Aloysius, Haoxuan, Jason
// Date: March 21, 2026
// Returns a single random quote from the database.
// Note: uses MySQLi ($conn) instead of PDO like the rest of the project.

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require 'db.php';

$result = $conn->query('SELECT * FROM quotes ORDER BY RAND() LIMIT 1');

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    exit;
}

$quote = $result->fetch_assoc();

if (!$quote) {
    http_response_code(404);
    echo json_encode(['error' => 'No quotes found']);
    exit;
}

echo json_encode($quote);
?>