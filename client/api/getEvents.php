<?php
/*
 * Name: Brian, Aloysius, Haoxuan, Jason
 * Date: March 21, 2026
 * Description: Returns the next upcoming event as JSON.
 *              Used by the home page to display a countdown timer.
 */

header('Content-Type: application/json');
require_once '../quotes/db.php';

try {
    // CURDATE() filters out events that have already passed
    $stmt = $pdo->prepare("
        SELECT eventID, title, eventDate, eventTime, description, location 
        FROM events 
        WHERE eventDate >= CURDATE() 
        ORDER BY eventDate ASC, eventTime ASC 
        LIMIT 1
    ");
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($event) {
        echo json_encode([
            'success' => true,
            'event'   => $event,
            'target'  => $event['eventDate'] . ' ' . ($event['eventTime'] ?: '00:00:00') // default to midnight if no time set
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No upcoming events']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>