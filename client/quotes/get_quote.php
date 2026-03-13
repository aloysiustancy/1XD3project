<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require 'db.php';

$result = $conn->query('SELECT * FROM quotes ORDER BY created_at DESC');
$quotes = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($quotes);
?>