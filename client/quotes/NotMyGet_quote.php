<?php
// Name: Brian, Aloysius, Haoxuan, Jason
// Date: March 21, 2026
// Returns all quotes from the database, newest first.
// Note: uses MySQLi ($conn) instead of PDO like the rest of the project.
 
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require 'db.php';

$result = $conn->query('SELECT * FROM quotes ORDER BY created_at DESC');

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed: ' . $conn->error]);
    exit;
}

$quotes = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($quotes);
?>