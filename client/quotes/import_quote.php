<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require 'db.php';

$data  = json_decode(file_get_contents('php://input'), true);
$count = isset($data['count']) ? (int)$data['count'] : 5;

// Fetch from external API
$url      = "https://api.quotable.io/quotes/random?limit=$count";
$response = file_get_contents($url);
$quotes   = json_decode($response, true);

if (!$quotes) {
    echo json_encode(['error' => 'Failed to fetch from API']);
    exit;
}

$stmt   = $conn->prepare('INSERT INTO quotes (text, author, source) VALUES (?, ?, ?)');
$source = 'api';
$stmt->bind_param('sss', $text, $author, $source);

foreach ($quotes as $q) {
    $text   = $q['content'];
    $author = $q['author'];
    $stmt->execute();
}

echo json_encode(['message' => count($quotes) . ' quotes imported!']);
?>