<?php
/**
 * check_password.php
 * AJAX endpoint — accepts POST { password: string }
 * Returns JSON { score: 0-4, label: string }
 */

header('Content-Type: application/json');

// Only allow POST from same origin
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data     = json_decode(file_get_contents('php://input'), true);
$password = $data['password'] ?? '';

/* ── Scoring ─────────────────────────────────────────────────────
   0  Too short  (< 6 chars)
   1  Weak       (6+ chars, nothing else)
   2  Fair       (+ length ≥ 10 OR mixed case)
   3  Good       (+ digits)
   4  Strong     (+ special characters)
──────────────────────────────────────────────────────────────── */
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

$labels = ['Too short', 'Weak', 'Fair', 'Good', 'Strong'];
$score  = scorePassword($password);

echo json_encode([
    'score' => $score,
    'label' => $labels[$score],
]);