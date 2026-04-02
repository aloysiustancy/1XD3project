<?php
header('Content-Type: application/json');
require_once '../quotes/db.php';

try {
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
            'event' => $event,
            'target' => $event['eventDate'] . ' ' . ($event['eventTime'] ?: '00:00:00')
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No upcoming events']);
    }
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>