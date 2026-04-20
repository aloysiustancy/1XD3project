<?php
// Shared database for team
define('DB_HOST', 'localhost');
//define('DB_NAME', 'tana42_db');  
//define('DB_USER', 'tana42_local');               
//define('DB_PASS', '+im}Zbr.');   
define('DB_NAME', 'caij95_db');  
//define('DB_USER', 'caij95_local');               
//define('DB_PASS', 'J(gqn9V%');   
define('DB_USER', 'root');               
define('DB_PASS', '');   
define('DB_CHARSET', 'utf8mb4');

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . htmlspecialchars($e->getMessage()));
}
?>