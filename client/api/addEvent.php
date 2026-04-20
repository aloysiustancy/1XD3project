<?php
/*
 * Name: Brian, Aloysius, Haoxuan, Jason
 * Date: March 21, 2026
 * Description: Handles adding a new event to the database.
 *              Only accessible to logged-in admins.
 *              Also saves an uploaded image if one is included.
 */

session_start();

if (!isset($_SESSION['userId']) || $_SESSION['isAdmin'] != 1) {
    http_response_code(403);
    echo json_encode(['error' => 'Access denied.']);
    exit;
}

header('Content-Type: application/json');
require_once '../quotes/db.php';

$title     = trim($_POST['title']     ?? '');
$eventDate = trim($_POST['eventDate'] ?? '');
$eventTime = trim($_POST['eventTime'] ?? '') ?: null;
$location  = trim($_POST['location']  ?? '') ?: null;

if (!$title || !$eventDate) {
    echo json_encode(['error' => 'Event name and date/time are required.']);
    exit;
}

/* ── Handle image upload ── */
$imagePath = null;
if (!empty($_FILES['image']['tmp_name'])) {
    $file     = $_FILES['image'];
    $allowed  = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $mimeType = mime_content_type($file['tmp_name']); // check real file type, not just the extension

    if (!in_array($mimeType, $allowed)) {
        echo json_encode(['error' => 'Only JPEG, PNG, GIF, and WebP images are allowed.']);
        exit;
    }

    $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid('event_', true) . '.' . strtolower($ext); // unique name prevents overwriting existing files
    $destDir  = dirname(__DIR__) . '/images/';
    $destPath = $destDir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        echo json_encode(['error' => 'Failed to save the uploaded image.']);
        exit;
    }

    $imagePath = 'images/' . $filename;
}

/* ── Insert into DB ── */
try {
    $stmt = $pdo->prepare(
        "INSERT INTO events (title, eventDate, eventTime, location, image)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->execute([$title, $eventDate, $eventTime, $location, $imagePath]);
    echo json_encode(['success' => true, 'message' => 'Event created!', 'image' => $imagePath]);
} catch (Exception $e) {
    // Delete the uploaded image if the DB insert fails so we don't leave orphan files
    if ($imagePath && file_exists(dirname(__DIR__) . '/' . $imagePath)) {
        unlink(dirname(__DIR__) . '/' . $imagePath);
    }
    echo json_encode(['error' => $e->getMessage()]);
}
?>