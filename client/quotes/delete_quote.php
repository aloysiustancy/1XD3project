<?php
session_start();

if (!isset($_SESSION['userId']) || $_SESSION['isAdmin'] != 1) {
    http_response_code(403);
    echo json_encode(['error' => 'Access denied.']);
    exit;
}

header('Content-Type: application/json');
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
$id   = isset($data['id']) ? (int)$data['id'] : 0;

if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid quote ID.']);
    exit;
}

try {
    $stmt = $pdo->prepare('DELETE FROM quotes WHERE id = ?');
    $stmt->execute([$id]);

    if ($stmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Quote not found.']);
        exit;
    }

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
