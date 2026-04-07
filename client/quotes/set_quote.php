<?php
session_start();
header('Content-Type: application/json');
require 'db.php';


$isAdmin = $_SESSION['isAdmin'];
$userID = $_SESSION['userID'];

if (!$isAdmin) {
    echo json_encode(['error' => 'Not authorized']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$text = trim($data['text'] ?? '');
$author = trim($data['author'] ?? '');

if (!$text || !$author) {
    echo json_encode(['error' => 'All fields required']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO quotes (quoteText, author, activeDate, createdBy)
        VALUES (?, ?, CURDATE(), ?)
    ");
    $stmt->execute([$text, $author, $userID]);

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>