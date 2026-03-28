<?php
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
