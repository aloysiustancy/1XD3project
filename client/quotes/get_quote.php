<?php
session_start();
header('Content-Type: application/json');
require 'db.php';

// 1️⃣ 先查今天有没有
$stmt = $pdo->prepare("
    SELECT * FROM quotes
    WHERE activeDate = CURDATE()
    LIMIT 1
");
$stmt->execute();
$quote = $stmt->fetch(PDO::FETCH_ASSOC);

// 2️⃣ 如果没有 → 随机选一个
if (!$quote) {

    $stmt = $pdo->query("
        SELECT * FROM quotes
        ORDER BY RAND()
        LIMIT 1
    ");

    $quote = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($quote) {

        // 清空旧的
        $pdo->exec("UPDATE quotes SET activeDate = NULL");

        // 设置今天的
        $update = $pdo->prepare("
            UPDATE quotes
            SET activeDate = CURDATE()
            WHERE quoteID = ?
        ");
        $update->execute([$quote['quoteID']]);
    }
}

// ❗关键：保证返回的是 JSON object
if (!$quote) {
    echo json_encode([
        "quoteText" => "No quote available",
        "author" => ""
    ]);
    exit;
}

echo json_encode($quote);
?>