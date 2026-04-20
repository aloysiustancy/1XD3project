<?php
session_start();
require 'db.php';

if (!$_SESSION['isAdmin']) exit;

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];

// Clear away "tomorrow"
$pdo->exec("
    UPDATE quotes 
    SET activeDate = NULL 
    WHERE activeDate = CURDATE() + INTERVAL 1 DAY
");

// Setting a New Tomorrow
$stmt = $pdo->prepare("
    UPDATE quotes
    SET activeDate = CURDATE() + INTERVAL 1 DAY
    WHERE quoteID = ?
");
$stmt->execute([$id]);

echo json_encode(["success"=>true]);