<?php
// Your Name
// Date Created: [date]
// Admin page to add, edit, and delete club events.

require_once '../includes/header.php';
require_once '../quotes/db.php';

if (!$isAdmin) {
    http_response_code(403);
    echo '<div style="text-align:center;padding:80px 24px;">
            <h2 style="color:#7a003c;">Access Denied</h2>
            <p>You must be a moderator to view this page.</p>
            <a href="../index.php" class="btn btn-primary">Go Home</a>
          </div>';
    require_once '../includes/footer.php';
    exit;
}

$successMsg = '';
$errorMsg   = '';
$editEvent  = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title       = trim($_POST['title']       ?? '');
    $eventDate   = trim($_POST['eventDate']   ?? '');
    $eventTime   = trim($_POST['eventTime']   ?? '');
    $location    = trim($_POST['location']    ?? '');
    $description = trim($_POST['description'] ?? '');
    $eventID     = intval($_POST['eventID']   ?? 0); // 0 = insert, >0 = update

    $errors = [];
    if ($title === '')     $errors[] = 'Title is required.';
    if ($eventDate === '') $errors[] = 'Date is required.';
    if ($eventTime === '') $errors[] = 'Time is required.';
    if (!empty($eventDate) && strtotime($eventDate) === false)
                           $errors[] = 'Invalid date format.';

    if ($errors) {
        $errorMsg = implode(' ', $errors);
    } else {
        if ($eventID > 0) {
            $stmt = $pdo->prepare(
                'UPDATE events
                    SET title = :title,
                        eventDate = :eventDate,
                        eventTime = :eventTime,
                        location = :location,
                        description = :description
                  WHERE eventID = :eventID'
            );
            $stmt->execute([
                ':title'       => $title,
                ':eventDate'   => $eventDate,
                ':eventTime'   => $eventTime,
                ':location'    => $location,
                ':description' => $description,
                ':eventID'     => $eventID,
            ]);
            $successMsg = 'Event updated successfully.';
        } else {
            $stmt = $pdo->prepare(
                'INSERT INTO events (title, eventDate, eventTime, location, description)
                 VALUES (:title, :eventDate, :eventTime, :location, :description)'
            );
            $stmt->execute([
                ':title'       => $title,
                ':eventDate'   => $eventDate,
                ':eventTime'   => $eventTime,
                ':location'    => $location,
                ':description' => $description,
            ]);
            $successMsg = 'Event added successfully.';
        }
    }
}

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delID = intval($_GET['delete']);
    $stmt  = $pdo->prepare('DELETE FROM events WHERE eventID = :id');
    $stmt->execute([':id' => $delID]);
    $successMsg = 'Event deleted.';
}

if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM events WHERE eventID = :id');
    $stmt->execute([':id' => intval($_GET['edit'])]);
    $editEvent = $stmt->fetch(PDO::FETCH_ASSOC);
}

$allEvents = $pdo->query(
    'SELECT * FROM events ORDER BY eventDate DESC, eventTime DESC'
)->fetchAll(PDO::FETCH_ASSOC);
?>

<header class="page-hero">
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content">
        <h1>Manage Events</h1>
        <p>Add, edit, or remove upcoming meetings and events.</p>
    </div>
</header>

<section class="section">
    <div class="centered-block" style="max-width:860px;">

        <?php if ($successMsg): ?>
            <div class="flash flash-success"><?= htmlspecialchars($successMsg) ?></div>
        <?php endif; ?>
        <?php if ($errorMsg): ?>
            <div class="flash flash-error"><?= htmlspecialchars($errorMsg) ?></div>
        <?php endif; ?>

        <div class="manage-form-card">
            <h2><?= $editEvent ? 'Edit Event' : 'Add New Event' ?></h2>

            <form method="POST" action="manage_events.php" id="event-form" novalidate>

                <input type="hidden" name="eventID"
                       value="<?= $editEvent ? intval($editEvent['eventID']) : 0 ?>">

                <div class="mform-row">
                    <div class="mform-group">
                        <label for="title">Event Title *</label>
                        <input type="text" id="title" name="title" class="dash-input"
                               placeholder="e.g. Weekly Mindfulness Gathering"
                               maxlength="150" required
                               value="<?= $editEvent ? htmlspecialchars($editEvent['title']) : '' ?>">
                    </div>
                </div>

                <div class="mform-row">
                    <div class="mform-group">
                        <label for="eventDate">Date *</label>
                        <input type="date" id="eventDate" name="eventDate" class="dash-input"
                               required
                               value="<?= $editEvent ? htmlspecialchars($editEvent['eventDate']) : '' ?>">
                    </div>
                    <div class="mform-group">
                        <label for="eventTime">Time *</label>
                        <input type="time" id="eventTime" name="eventTime" class="dash-input"
                               required
                               value="<?= $editEvent ? htmlspecialchars($editEvent['eventTime']) : '' ?>">
                    </div>
                </div>

                <div class="mform-row">
                    <div class="mform-group">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" class="dash-input"
                               placeholder="e.g. Community Wellness Center, Room 204"
                               maxlength="200"
                               value="<?= $editEvent ? htmlspecialchars($editEvent['location']) : '' ?>">
                    </div>
                </div>

                <div class="mform-row">
                    <div class="mform-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="dash-input"
                                  rows="4"
                                  placeholder="What should attendees expect?"
                                  ><?= $editEvent ? htmlspecialchars($editEvent['description']) : '' ?></textarea>
                    </div>
                </div>

                <div class="mform-actions">
                    <button type="submit" class="pill-btn">
                        <?= $editEvent ? '💾 Save Changes' : '➕ Add Event' ?>
                    </button>
                    <?php if ($editEvent): ?>
                        <a href="manage_events.php" class="pill-btn-outline">Cancel</a>
                    <?php endif; ?>
                </div>

            </form>
        </div>

        <div class="manage-table-card">
            <h2>All Events</h2>

            <?php if (empty($allEvents)): ?>
                <p class="dash-placeholder">No events yet. Add one above.</p>
            <?php else: ?>
                <div class="events-table-wrap">
                    <table class="events-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Location</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($allEvents as $ev): ?>
                            <tr>
                                <td><?= htmlspecialchars($ev['title']) ?></td>
                                <td><?= htmlspecialchars(date('M j, Y', strtotime($ev['eventDate']))) ?></td>
                                <td><?= htmlspecialchars(date('g:i A', strtotime($ev['eventTime']))) ?></td>
                                <td><?= htmlspecialchars($ev['location'] ?: '—') ?></td>
                                <td class="table-actions">
                                    <a href="manage_events.php?edit=<?= $ev['eventID'] ?>"
                                       class="pill-btn-outline" style="font-size:0.75rem;padding:6px 14px;">
                                        Edit
                                    </a>
                                    <a href="manage_events.php?delete=<?= $ev['eventID'] ?>"
                                       class="pill-btn"
                                       style="font-size:0.75rem;padding:6px 14px;background:#a0323c;"
                                       onclick="return confirm('Delete this event?')">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>

<style>
    .flash { padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; font-weight: 600; font-size: 0.9rem; }
    .flash-success { background: #d4edda; color: #2c5f2e; border: 1px solid #b2dfbc; }
    .flash-error   { background: #f8d7da; color: #7a003c; border: 1px solid #f1aeb5; }
    .manage-form-card, .manage-table-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow); padding: 36px 40px; margin-bottom: 36px; }
    .manage-form-card h2, .manage-table-card h2 { font-size: 1.35rem; margin-bottom: 24px; color: var(--green-dark); }
    .mform-row { display: flex; gap: 16px; margin-bottom: 16px; }
    .mform-group { display: flex; flex-direction: column; flex: 1; gap: 6px; }
    .mform-group label { font-size: 0.8rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; color: var(--green-dark); }
    .mform-actions { display: flex; gap: 12px; margin-top: 8px; align-items: center; }
    .events-table-wrap { overflow-x: auto; }
    .events-table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
    .events-table th { text-align: left; padding: 10px 14px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; color: var(--text-muted); border-bottom: 2px solid var(--border); }
    .events-table td { padding: 12px 14px; border-bottom: 1px solid var(--border); color: var(--text); vertical-align: middle; }
    .events-table tbody tr:hover { background: var(--bg-tint); }
    .table-actions { display: flex; gap: 8px; }
    @media (max-width: 640px) { .manage-form-card, .manage-table-card { padding: 24px 20px; } .mform-row { flex-direction: column; } }
</style>

<script>
/**
 * Validates the event form before submitting.
 * Warns (but does not block) if the chosen date is in the past.
 *
 * @param {Event} e - the form submit event
 */
document.getElementById('event-form').addEventListener('submit', function (e) {
    const title     = document.getElementById('title').value.trim();
    const eventDate = document.getElementById('eventDate').value;
    const eventTime = document.getElementById('eventTime').value;
    const errors    = [];

    if (!title)     errors.push('Title is required.');
    if (!eventDate) errors.push('Date is required.');
    if (!eventTime) errors.push('Time is required.');

    if (eventDate) {
        const chosen = new Date(eventDate);
        const today  = new Date();
        today.setHours(0, 0, 0, 0);
        if (chosen < today) {
            if (!confirm('The selected date is in the past. Continue anyway?')) {
                e.preventDefault();
                return;
            }
        }
    }

    if (errors.length > 0) {
        e.preventDefault();
        alert(errors.join('\n'));
    }
});
</script>

<?php require_once '../includes/footer.php'; ?>