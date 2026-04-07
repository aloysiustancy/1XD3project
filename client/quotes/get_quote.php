<?php
session_start();

header('Content-Type: application/json');
require 'db.php';

try {
    $stmt = $pdo->prepare("
        SELECT * FROM quotes 
        WHERE activeDate = CURDATE()
        LIMIT 1
    ");
    $stmt->execute();
    $quote = $stmt->fetch(PDO::FETCH_ASSOC);


    if (!$quote) {
        $stmt = $pdo->query("
            SELECT * FROM quotes 
            ORDER BY RAND() 
            LIMIT 1
        ");
        $quote = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($quote) {
            $update = $pdo->prepare("
                UPDATE quotes 
                SET activeDate = CURDATE() 
                WHERE quoteID = ?
            ");
            $update->execute([$quote['quoteID']]);
        }
    }

    echo json_encode($quote);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>