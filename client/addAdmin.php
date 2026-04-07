<?php
session_start();

if (!isset($_SESSION['userId']) || $_SESSION['isAdmin'] != 1) {
    http_response_code(403);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Access denied.']);
    exit;
}

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$firstName   = trim($data['firstName']   ?? '');
$lastName    = trim($data['lastName']    ?? '');
$email       = trim($data['email']       ?? '');
$phoneNumber = trim($data['phoneNumber'] ?? '');
$password    = $data['password']         ?? '';

if (!$firstName || !$lastName || !$email || !$password) {
    http_response_code(400);
    echo json_encode(['error' => 'First name, last name, email, and password are required.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid email address.']);
    exit;
}

if (strlen($password) < 8) {
    http_response_code(400);
    echo json_encode(['error' => 'Password must be at least 8 characters.']);
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'clientproj');

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed.']);
    exit;
}

/* Check for duplicate email */
$check = $conn->prepare('SELECT ui.userId FROM UserInfo ui WHERE ui.email = ? LIMIT 1');
$check->bind_param('s', $email);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    $check->close();
    $conn->close();
    http_response_code(409);
    echo json_encode(['error' => 'An account with that email already exists.']);
    exit;
}
$check->close();

$passwordHash = password_hash($password, PASSWORD_DEFAULT);
$isAdmin = 1;

$conn->begin_transaction();
try {
    $s1 = $conn->prepare('INSERT INTO Users (isAdmin, password) VALUES (?, ?)');
    $s1->bind_param('is', $isAdmin, $passwordHash);
    $s1->execute();
    $userId = $conn->insert_id;
    $s1->close();

    $s2 = $conn->prepare('INSERT INTO UserInfo (userId, firstName, lastName, phoneNumber, email) VALUES (?, ?, ?, ?, ?)');
    $s2->bind_param('issss', $userId, $firstName, $lastName, $phoneNumber, $email);
    $s2->execute();
    $s2->close();

    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Admin account created.']);
} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode(['error' => 'Failed to create admin: ' . $e->getMessage()]);
}

$conn->close();
?>
