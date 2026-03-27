<!DOCTYPE html>
<html>
<head>
    <title>Register Admin</title>
</head>
<body>

<h2>Create Admin Account</h2>
<?php
    session_start();
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: login.php");
        exit();
    }
?>

<form action="addAdmin.php" method="post">

First Name:<br>
<input type="text" name="firstName" required><br><br>

Last Name:<br>
<input type="text" name="lastName" required><br><br>

Phone Number:<br>
<input type="text" name="phoneNumber"><br><br>

Email:<br>
<input type="email" name="email" required><br><br>

Password:<br>
<input type="password" name="password" required><br><br>

<input type="submit" value="Register">

</form>

</body>
</html>
