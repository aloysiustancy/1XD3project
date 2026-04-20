<?php
// Name: Brian, Aloysius, Haoxuan, Jason
// Date: March 21, 2026
// Password strength checker AJAX endpoint — evaluates password and returns score 0-4 with label

/**
 * Evaluates password strength based on length, character variety, and special characters
 * @param string $pw The password string to evaluate
 * @return int Strength score from 0 (too short) to 4 (strong)
 */
function scorePassword(string $pw): int {
    if (mb_strlen($pw) < 6) return 0;

    $score = 1;

    if (mb_strlen($pw) >= 10)                          $score++;
    if (preg_match('/[A-Z]/', $pw) &&
        preg_match('/[a-z]/', $pw))                    $score++;
    if (preg_match('/[0-9]/', $pw))                    $score++;
    if (preg_match('/[^A-Za-z0-9]/', $pw))             $score = min($score + 1, 4);

    return min($score, 4);
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data     = json_decode(file_get_contents('php://input'), true);
$password = $data['password'] ?? '';

$labels = ['Too short', 'Weak', 'Fair', 'Good', 'Strong'];
$score  = scorePassword($password);

echo json_encode([
    'score' => $score,
    'label' => $labels[$score],
]);