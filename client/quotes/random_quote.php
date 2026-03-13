<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require 'db.php';

$result = $conn->query('SELECT * FROM quotes ORDER BY RAND() LIMIT 1');
$quote  = $result->fetch_assoc();

echo json_encode($quote);
?>
