<?php
// Name: Brian, Aloysius, Haoxuan, Jason
// Date: March 21, 2026
// Returns today's quote. If none is set, picks one randomly and assigns it to today.
 
session_start();
header('Content-Type: application/json');
require 'db.php';

// 1️ First check if there is one today.
$stmt = $pdo->prepare("
    SELECT * FROM quotes
    WHERE activeDate = CURDATE()
    LIMIT 1
");
$stmt->execute();
$quote = $stmt->fetch(PDO::FETCH_ASSOC);

// 2️ If not, select one randomly.
if (!$quote) {

    $stmt = $pdo->query("
        SELECT * FROM quotes
        ORDER BY RAND()
        LIMIT 1
    ");

    $quote = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($quote) {

        // Clear the old
        $pdo->exec("UPDATE quotes SET activeDate = NULL");

        // Set today
        $update = $pdo->prepare("
            UPDATE quotes
            SET activeDate = CURDATE()
            WHERE quoteID = ?
        ");
        $update->execute([$quote['quoteID']]);
    }
}

// Ensure that the returned value is a JSON object.
if (!$quote) {
    echo json_encode([
        "quoteText" => "No quote available",
        "author" => ""
    ]);
    exit;
}

echo json_encode($quote);
?>