<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require 'db.php';

try {
    $stmt = $pdo->query('SELECT * FROM quotes ORDER BY RAND() LIMIT 1');
    $quote = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$quote) {
        http_response_code(404);
        echo json_encode(['error' => 'No quotes found']);
        exit;
    }

    echo json_encode($quote);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
