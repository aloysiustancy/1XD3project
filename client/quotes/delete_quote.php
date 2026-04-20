<?php
session_start();
require 'db.php';

if (!$_SESSION['isAdmin']) exit;

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];

// 1. Delete the quote (but not today).
$stmt = $pdo->prepare("
    DELETE FROM quotes 
    WHERE quoteID = ? 
    AND activeDate != CURDATE()
");
$stmt->execute([$id]);

// 2. Check if tomorrow still exists.
$stmt = $pdo->query("
    SELECT * FROM quotes 
    WHERE activeDate = CURDATE() + INTERVAL 1 DAY
    LIMIT 1
");
$tomorrow = $stmt->fetch(PDO::FETCH_ASSOC);

// 3. If "tomorrow" is missing -> it will be automatically added.
if (!$tomorrow) {

    // Choose one randomly (excluding today).
    $stmt = $pdo->query("
        SELECT * FROM quotes
        WHERE activeDate IS NULL
        OR activeDate > CURDATE() + INTERVAL 1 DAY
        ORDER BY RAND()
        LIMIT 1
    ");
    $new = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($new) {
        $stmt = $pdo->prepare("
            UPDATE quotes
            SET activeDate = CURDATE() + INTERVAL 1 DAY
            WHERE quoteID = ?
        ");
        $stmt->execute([$new['quoteID']]);
    }
}

echo json_encode(["success"=>true]);
?>