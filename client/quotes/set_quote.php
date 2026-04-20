<?php
// Name: Brian, Aloysius, Haoxuan, Jason
// Date: March 21, 2026
// Lets an admin add a new quote to the database. Quote starts unscheduled (activeDate = NULL).

session_start();
header('Content-Type: application/json');
require 'db.php';

if (!$_SESSION['isAdmin']) {
    echo json_encode(['error' => 'Not authorized']);
    exit;
}

$data   = json_decode(file_get_contents("php://input"), true);
$text   = trim($data['text']   ?? '');
$author = trim($data['author'] ?? '');

if (!$text || !$author) {
    echo json_encode(['error' => 'All fields required']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO quotes (quoteText, author, activeDate, createdBy) VALUES (?, ?, NULL, ?)");
    $stmt->execute([$text, $author, $_SESSION['userId']]);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>