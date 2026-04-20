<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "tana42_local";
$password = "+im}Zbr.";
$dbname = "tana42_db";
//$username = "caij95_local";
//$password = "J(gqn9V%";
//$dbname = "caii95_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$firstName = trim($_POST['firstName'] ?? '');
$lastName = trim($_POST['lastName'] ?? '');
$phoneNumber = trim($_POST['phoneNumber'] ?? '');
$email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$passwordRaw = $_POST['password'] ?? '';

if (!$email || empty($passwordRaw)) {
    die("Invalid input");
}

$hashedPassword = password_hash($passwordRaw, PASSWORD_DEFAULT);
$stmt1 = $conn->prepare("INSERT INTO Users (isAdmin, password) VALUES (?, ?)");
$stmt1->bind_param("is", $isAdmin, $hashedPassword);

$isAdmin = 0;

if ($stmt1->execute()) {

    $userId = $stmt1->insert_id;

    /* Insert into UserInfo table safely */
    $stmt2 = $conn->prepare("INSERT INTO UserInfo (userId, firstName, lastName, phoneNumber, email) VALUES (?, ?, ?, ?, ?)");
    $stmt2->bind_param("issss", $userId, $firstName, $lastName, $phoneNumber, $email);

    if ($stmt2->execute()) {
        echo "User created successfully!";
    } else {
        echo "Error inserting user info: " . $stmt2->error;
    }

    $stmt2->close();

} else {
    echo "Error inserting user: " . $stmt1->error;
}

$stmt1->close();
$conn->close();
?>