<?php

session_start();

if (!isset($_SESSION['userId']) || $_SESSION['isAdmin'] != 1) {
    die("Access denied.");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clientproj";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$phoneNumber = $_POST['phoneNumber'];
$email = $_POST['email'];

$passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

$isAdmin = 1;

/* Insert into Users */

$sql1 = "INSERT INTO Users (isAdmin, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql1);
$stmt->bind_param("is", $isAdmin, $passwordHash);
$stmt->execute();

$userId = $conn->insert_id;

/* Insert into UserInfo */

$sql2 = "INSERT INTO UserInfo (userId, firstName, lastName, phoneNumber, email)
         VALUES (?, ?, ?, ?, ?)";

$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("issss", $userId, $firstName, $lastName, $phoneNumber, $email);
$stmt2->execute();

echo "Admin created successfully.";

$conn->close();

?>
