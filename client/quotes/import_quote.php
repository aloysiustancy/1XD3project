<?php
session_start();

if (!isset($_SESSION['userId']) || $_SESSION['isAdmin'] != 1) {
    http_response_code(403);
    echo json_encode(['error' => 'Access denied.']);
    exit;
}

header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

try {
    require 'db.php';

    $data  = json_decode(file_get_contents('php://input'), true);
    $count = isset($data['count']) ? min((int)$data['count'], 50) : 5;

    // Fetch from external API
    $url = "https://dummyjson.com/quotes?limit=$count";

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        $curlErr  = curl_error($ch);
        curl_close($ch);
        if ($response === false) {
            throw new Exception('cURL error: ' . $curlErr);
        }
    } else {
        $ctx = stream_context_create(['http' => ['timeout' => 10], 'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
        $response = @file_get_contents($url, false, $ctx);
        if ($response === false) {
            throw new Exception('file_get_contents failed for ' . $url);
        }
    }

    $body   = json_decode($response, true);
    $quotes = isset($body['quotes']) ? $body['quotes'] : null;

    if (!$quotes || !is_array($quotes)) {
        throw new Exception('Unexpected response from quotes API');
    }

    $stmt = $pdo->prepare('INSERT INTO quotes (text, author, source) VALUES (?, ?, ?)');

    $imported = 0;
    foreach ($quotes as $q) {
        $stmt->execute([$q['quote'], $q['author'], 'api']);
        $imported++;
    }

    echo json_encode(['message' => $imported . ' quotes imported!']);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
