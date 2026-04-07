<?php
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

try {
    $source = 'admin';
    $stmt = $pdo->prepare('INSERT INTO quotes (text, author, source) VALUES (?, ?, ?)');
    $stmt->execute([$text, $author, $source]);
    echo json_encode(['message' => 'Quote added successfully!']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
