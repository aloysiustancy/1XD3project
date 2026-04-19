<?php
session_start();
require 'db.php';

if (!$_SESSION['isAdmin']) exit;

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];

// 🔥 1. 删除 quote（不能删 today）
$stmt = $pdo->prepare("
    DELETE FROM quotes 
    WHERE quoteID = ? 
    AND activeDate != CURDATE()
");
$stmt->execute([$id]);

// 🔥 2. 检查 tomorrow 是否还存在
$stmt = $pdo->query("
    SELECT * FROM quotes 
    WHERE activeDate = CURDATE() + INTERVAL 1 DAY
    LIMIT 1
");
$tomorrow = $stmt->fetch(PDO::FETCH_ASSOC);

// 🔥 3. 如果 tomorrow 没了 → 自动补一个
if (!$tomorrow) {

    // ❗随机选一个（排除 today）
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