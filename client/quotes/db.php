<?php
$conn = new mysqli('127.0.0.1', 'root', '', '', 3307);

if ($conn->connect_error) {
    header('Content-Type: application/json');
    http_response_code(500);
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$conn->query('CREATE DATABASE IF NOT EXISTS quotes');
$conn->select_db('quotes');

$conn->query('CREATE TABLE IF NOT EXISTS quotes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    text TEXT NOT NULL,
    author VARCHAR(255) DEFAULT "Unknown",
    source VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)');
?>