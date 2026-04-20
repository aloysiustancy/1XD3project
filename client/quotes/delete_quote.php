<?php
session_start();
header('Content-Type: application/json'); // ✅ 添加 JSON 响应头
require 'db.php';

if (!$_SESSION['isAdmin']) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode(['success' => false, 'error' => 'Invalid ID']);
    exit;
}

try {
    // 1. First check if this quote exists.
    $stmt = $pdo->prepare("SELECT * FROM quotes WHERE quoteID = ?");
    $stmt->execute([$id]);
    $quote = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$quote) {
        echo json_encode(['success' => false, 'error' => 'Quote not found']);
        exit;
    }
    
    // 2. Today's quote cannot be deleted.
    if ($quote['activeDate'] && $quote['activeDate'] == date('Y-m-d')) {
        echo json_encode(['success' => false, 'error' => "Cannot delete today's quote"]);
        exit;
    }
    
    // 3. Delete quotes (excluding today's).
    $stmt = $pdo->prepare("
        DELETE FROM quotes
        WHERE quoteID = ?
        AND activeDate != CURDATE()
    ");
    $stmt->execute([$id]);
    
    // Check if it has really been deleted.
    if ($stmt->rowCount() === 0) {
        echo json_encode(['success' => false, 'error' => 'Failed to delete quote']);
        exit;
    }
    
    // 4. Check if there are any quotes tomorrow.
    $stmt = $pdo->query("
        SELECT * FROM quotes
        WHERE activeDate = CURDATE() + INTERVAL 1 DAY
        LIMIT 1
    ");
    $tomorrow = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // 5. If there are no quotes tomorrow, choose one randomly.
    if (!$tomorrow) {
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
    
    echo json_encode(['success' => true]);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>