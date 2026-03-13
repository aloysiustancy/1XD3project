<?php
$host = 'localhost';
$user = 'root';
$password = 'yourpassword';
$database = 'yourdb';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}
?>