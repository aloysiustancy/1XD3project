<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require 'db.php';

try {
    $stmt = $pdo->query('SELECT * FROM quotes ORDER BY created_at DESC');
    $quotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($quotes);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
