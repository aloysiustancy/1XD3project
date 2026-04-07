<?php
session_start();

if (!isset($_SESSION['userId']) || $_SESSION['isAdmin'] != 1) {
    http_response_code(403);
    echo json_encode(['error' => 'Access denied.']);
    exit;
}

header('Content-Type: application/json');

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
