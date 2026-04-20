<?php
// Name: Brian, Aloysius, Haoxuan, Jason
// Date: March 21, 2026
// Deletes a quote. Will not delete today's active quote.
// If tomorrow's quote gets deleted, automatically picks a new one to replace it.

session_start();
require 'db.php';

if (!$_SESSION['isAdmin']) exit;

$data = json_decode(file_get_contents("php://input"), true);
$id   = $data['id'];

$stmt = $pdo->prepare("DELETE FROM quotes WHERE quoteID = ? AND activeDate != CURDATE()");
$stmt->execute([$id]);

// Check if tomorrow still has a quote after the deletion
$stmt     = $pdo->query("SELECT * FROM quotes WHERE activeDate = CURDATE() + INTERVAL 1 DAY LIMIT 1");
$tomorrow = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tomorrow) {
    // Pick a replacement for tomorrow
    $stmt = $pdo->query("
        SELECT * FROM quotes
        WHERE activeDate IS NULL OR activeDate > CURDATE() + INTERVAL 1 DAY
        ORDER BY RAND() LIMIT 1
    ");
    $new = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($new) {
        $stmt = $pdo->prepare("UPDATE quotes SET activeDate = CURDATE() + INTERVAL 1 DAY WHERE quoteID = ?");
        $stmt->execute([$new['quoteID']]);
    }
}

echo json_encode(["success" => true]);
?>