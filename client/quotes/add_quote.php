<?php
// Name: Brian, Aloysius, Haoxuan, Jason
// Date: March 21, 2026
// Adds a new quote to the database via AJAX POST request.

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

$text   = isset($data['text'])   ? trim($data['text'])   : '';
$author = isset($data['author']) ? trim($data['author']) : 'Unknown';

if (empty($text)) {
    echo json_encode(['error' => 'Quote text is required']);
    exit;
}

$source = 'admin';
$stmt = $conn->prepare('INSERT INTO quotes (text, author, source) VALUES (?, ?, ?)');
$stmt->bind_param('sss', $text, $author, $source);
$stmt->execute();

echo json_encode(['message' => 'Quote added successfully!']);
?>