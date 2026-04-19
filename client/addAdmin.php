<?php

session_start();

/* ── Auth check ─────────────────────────────────────────────── */
if (empty($_SESSION['userId']) || $_SESSION['isAdmin'] !== 1) {
    http_response_code(403);
    die("Access denied.");
}

/* ── CSRF check ─────────────────────────────────────────────── */
if (
    empty($_POST['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])
) {
    http_response_code(403);
    die("Invalid request.");
}

/* ── Input validation ───────────────────────────────────────── */
$errors = [];

$firstName   = trim($_POST['firstName']   ?? '');
$lastName    = trim($_POST['lastName']    ?? '');
$phoneNumber = trim($_POST['phoneNumber'] ?? '');
$email       = trim($_POST['email']       ?? '');
$password    =      $_POST['password']   ?? '';

if ($firstName === '' || mb_strlen($firstName) > 50)
    $errors[] = "First name is required and must be under 50 characters.";

if ($lastName === '' || mb_strlen($lastName) > 50)
    $errors[] = "Last name is required and must be under 50 characters.";

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 255)
    $errors[] = "A valid email address is required.";

if (!preg_match('/^\+?[0-9\s\-().]{7,20}$/', $phoneNumber))
    $errors[] = "Phone number is invalid.";

if (mb_strlen($password) < 8)
    $errors[] = "Password must be at least 8 characters.";

if (!empty($errors)) {
    http_response_code(422);
    foreach ($errors as $e) {
        echo htmlspecialchars($e) . "<br>";
    }
    exit;
}

/* ── DB connection (credentials from environment) ───────────── *
 *  Set these in your server environment or a .env file loaded   *
 *  before this script — never hardcode credentials in PHP.      *
 *  Example Apache (.htaccess / VirtualHost):                    *
 *    SetEnv DB_HOST     localhost                               *
 *    SetEnv DB_USER     tana42_local                           *
 *    SetEnv DB_PASS     +im}Zbr                                *
 *    SetEnv DB_NAME     tana42_db                              *
 * ─────────────────────────────────────────────────────────── */
$servername = "localhost";
$username = "tana42_local";
$password = "+im}Zbr";
$dbname = "tana42_db";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_errno) {
    error_log("DB connection failed: " . $conn->connect_error);
    http_response_code(500);
    die("A server error occurred. Please try again later.");
}

$conn->set_charset('utf8mb4');

/* ── Duplicate email check ──────────────────────────────────── */
$chk = $conn->prepare("SELECT userId FROM UserInfo WHERE email = ? LIMIT 1");
$chk->bind_param("s", $email);
$chk->execute();
$chk->store_result();

if ($chk->num_rows > 0) {
    $chk->close();
    $conn->close();
    http_response_code(409);
    die("An account with that email already exists.");
}
$chk->close();

/* ── Hash password ──────────────────────────────────────────── */
$passwordHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

$isAdmin = 1;

/* ── Insert into Users ──────────────────────────────────────── */
$stmt1 = $conn->prepare("INSERT INTO Users (isAdmin, password) VALUES (?, ?)");
if (!$stmt1) {
    error_log("Prepare failed: " . $conn->error);
    http_response_code(500);
    die("A server error occurred.");
}

$stmt1->bind_param("is", $isAdmin, $passwordHash);

if (!$stmt1->execute()) {
    error_log("Insert Users failed: " . $stmt1->error);
    http_response_code(500);
    $stmt1->close();
    $conn->close();
    die("A server error occurred.");
}

$userId = $conn->insert_id;
$stmt1->close();

/* ── Insert into UserInfo ───────────────────────────────────── */
$stmt2 = $conn->prepare(
    "INSERT INTO UserInfo (userId, firstName, lastName, phoneNumber, email)
     VALUES (?, ?, ?, ?, ?)"
);
if (!$stmt2) {
    error_log("Prepare failed: " . $conn->error);
    http_response_code(500);
    die("A server error occurred.");
}

$stmt2->bind_param("issss", $userId, $firstName, $lastName, $phoneNumber, $email);

if (!$stmt2->execute()) {
    error_log("Insert UserInfo failed: " . $stmt2->error);
    /* Roll back the Users row so we don't leave an orphan */
    $conn->query("DELETE FROM Users WHERE userId = " . intval($userId));
    http_response_code(500);
    $stmt2->close();
    $conn->close();
    die("A server error occurred.");
}

$stmt2->close();
$conn->close();

/* ── Rotate CSRF token after successful use ─────────────────── */
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

echo "Admin created successfully.";