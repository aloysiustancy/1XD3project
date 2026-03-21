<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$phoneNumber = $_POST['phoneNumber'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

/* Insert into Users table */

$sql1 = "INSERT INTO Users (isAdmin, password)
         VALUES (0, '$password')";

if ($conn->query($sql1) === TRUE) {

    $userId = $conn->insert_id;

    /* Insert into UserInfo table */

    $sql2 = "INSERT INTO UserInfo (userId, firstName, lastName, phoneNumber, email)
             VALUES ('$userId', '$firstName', '$lastName', '$phoneNumber', '$email')";

    if ($conn->query($sql2) === TRUE) {
        echo "User created successfully!";
    } else {
        echo "Error inserting user info: " . $conn->error;
    }

} else {
    echo "Error inserting user: " . $conn->error;
}

$conn->close();

?>
