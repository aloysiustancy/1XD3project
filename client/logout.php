<?php
// Name: Brian, Aloysius, Haoxuan, Jason
// Date: March 21, 2026
// Logout handler — destroys user session and redirects to homepage

session_start();
session_destroy();
header('Location: index.php');
exit;