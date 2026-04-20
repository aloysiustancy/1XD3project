<?php
// Name: Brian, Aloysius, Haoxuan, Jason
// Date: March 21, 2026
// Admin page to view, schedule, and delete quotes.
// If no quote is scheduled for tomorrow, one is picked randomly and saved.

session_start();
require 'db.php';

if (!$_SESSION['isAdmin']) {
    header("Location: ../community.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM quotes WHERE activeDate = CURDATE() LIMIT 1");
$stmt->execute();
$todayQuote = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM quotes WHERE activeDate = CURDATE() + INTERVAL 1 DAY LIMIT 1");
$stmt->execute();
$tomorrowQuote = $stmt->fetch(PDO::FETCH_ASSOC);

// If no quote is set for tomorrow, pick one randomly and save it
if (!$tomorrowQuote) {
    $stmt = $pdo->prepare("
        SELECT * FROM quotes
        WHERE activeDate IS NULL OR activeDate != CURDATE()
        ORDER BY RAND()
        LIMIT 1
    ");
    $stmt->execute();
    $tomorrowQuote = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($tomorrowQuote) {
        $pdo->exec("UPDATE quotes SET activeDate = NULL WHERE activeDate = CURDATE() + INTERVAL 1 DAY");
        $stmt = $pdo->prepare("UPDATE quotes SET activeDate = CURDATE() + INTERVAL 1 DAY WHERE quoteID = ?");
        $stmt->execute([$tomorrowQuote['quoteID']]);
    }
}

$stmt   = $pdo->query("SELECT * FROM quotes ORDER BY quoteID DESC");
$quotes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../includes/header.php'; ?>
<link rel="stylesheet" href="../css/style.css">

<style>
.container { max-width: 900px; margin: auto; padding: 20px; }
h1 { text-align:center; margin-bottom:30px; }
.preview { background:#ffffff; padding:24px; border-radius:16px; margin-bottom:30px; box-shadow: 0 10px 30px rgba(0,0,0,0.12); }
.small { font-size:0.9rem; color:gray; }
table { width:100%; border-collapse: collapse; background:white; border-radius:12px; overflow:hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
th, td { padding:10px; border-bottom:1px solid #ddd; }
th { background:#2c5f2e; color:white; }
.btn { padding:6px 10px; border:none; border-radius:6px; cursor:pointer; }
.green { background:#2c5f2e; color:white; }
.red { background:#c0392b; color:white; }
.small-btn { padding: 6px 12px; font-size: 13px; border-radius: 6px; white-space: nowrap; }
.disabled-btn { background: #bbb; color: white; cursor: not-allowed; }
.back { margin-top:20px; width:100%; background:#c0392b; color:white; padding:10px; border-radius:8px; font-size:14px; }
.modal { position: fixed; inset: 0; background: rgba(0,0,0,0.45); display: flex; justify-content: center; align-items: center; z-index: 999; }
.modal-content { background: #ffffff; padding: 24px 20px; border-radius: 16px; width: 320px; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.2); }
#modal-title { font-size: 1.6rem; color: #2c5f2e; margin-bottom: 10px; }
#modal-message-text { font-size: 1rem; color: #444; margin-bottom: 18px; }
#modal-ok-btn { padding: 10px 18px; background: #2c5f2e; color: white; border: none; border-radius: 8px; cursor: pointer; }
#modal-cancel-btn { padding: 10px 18px; background: transparent; color: #555; border: 2px solid #ccc; border-radius: 8px; cursor: pointer; font-weight: 500; transition: all 0.2s ease; }
#modal-cancel-btn:hover { background: #f5f5f5; border-color: #999; }
.hidden { display: none; }
</style>

<header class="page-hero">
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content">
        <h1>Quote Management</h1>
        <p>Manage, schedule, and curate the Wall of Wisdom.</p>
    </div>
</header>

<div class="container">

<div class="preview">
    <div style="color:orange; font-size: 20px">Tomorrow's display:</div>
    <blockquote>"<?= htmlspecialchars($tomorrowQuote['quoteText']) ?>"</blockquote>
    <p class="small">— <?= htmlspecialchars($tomorrowQuote['author']) ?></p>
</div>

<table>
<tr>
    <th>Quote</th>
    <th>Author</th>
    <th>Tomorrow's Display</th>
    <th>Delete</th>
</tr>

<?php foreach ($quotes as $q):
    $isToday = ($todayQuote && $q['quoteID'] == $todayQuote['quoteID']);
?>
<tr id="row-<?= $q['quoteID'] ?>">
    <td>
        <?= htmlspecialchars($q['quoteText']) ?>
        <?php if ($isToday): ?>
            <span style="color:red; font-size:12px; margin-left:8px;">(Today's Quote)</span>
        <?php endif; ?>
    </td>
    <td><?= htmlspecialchars($q['author']) ?></td>
    <td>
        <?php if ($isToday): ?>
            <button class="btn disabled-btn" disabled>TODAY</button>
        <?php else: ?>
            <button class="btn green small-btn" onclick="setTomorrow(<?= $q['quoteID'] ?>)">Tomorrow</button>
        <?php endif; ?>
    </td>
    <td>
        <?php if ($isToday): ?>
            <button class="btn disabled-btn" disabled>Locked</button>
        <?php else: ?>
            <button class="btn red small-btn" onclick="deleteQuote(<?= $q['quoteID'] ?>)">Delete</button>
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
</table>

<button class="btn back small-btn" onclick="location.href='../community.php'">Back to Community</button>

</div>

<div id="global-modal" class="modal hidden">
    <div class="modal-content">
        <h3 id="modal-title">Title</h3>
        <p id="modal-message-text">Message</p>
        <div style="display:flex; justify-content:center; gap:10px;">
            <button id="modal-ok-btn">OK</button>
            <button id="modal-cancel-btn" class="hidden">Cancel</button>
        </div>
    </div>
</div>

<script>
let currentTomorrow = <?= $tomorrowQuote['quoteID'] ?? 'null' ?>;

/**
 * Sets a quote to display tomorrow.
 * @param {number} id - quoteID to schedule
 */
function setTomorrow(id) {
    if (id === currentTomorrow) { showModal("Notice", "You have selected this quote"); return; }
    fetch("set_tomorrow_quote.php", { method: "POST", headers: {"Content-Type":"application/json"}, body: JSON.stringify({id}) })
        .then(res => res.json())
        .then(data => { if (data.success) showModal("Success", "Congratulations, successful setup.", () => location.reload()); });
}

/**
 * Deletes a quote after the user confirms.
 * @param {number} id - quoteID to delete
 */
function deleteQuote(id) {
    showConfirm("Are you sure to delete this quote?", () => {
        fetch("delete_quote.php", { method: "POST", headers: {"Content-Type":"application/json"}, body: JSON.stringify({id}) })
            .then(res => res.json())
            .then(data => { if (data.success) showModal("Deleted", "Quote deleted successfully.", () => location.reload()); });
    });
}

/**
 * Shows an alert-style modal with an OK button.
 * @param {string} title
 * @param {string} message
 * @param {Function|null} callback - runs after OK is clicked
 */
function showModal(title, message, callback = null) {
    const modal = document.getElementById("global-modal");
    document.getElementById("modal-title").innerText       = title;
    document.getElementById("modal-message-text").innerText = message;
    document.getElementById("modal-cancel-btn").classList.add("hidden");
    modal.classList.remove("hidden");
    document.getElementById("modal-ok-btn").onclick = () => { modal.classList.add("hidden"); if (callback) callback(); };
}

/**
 * Shows a confirm modal with OK and Cancel buttons.
 * @param {string} message
 * @param {Function} onConfirm - runs if user clicks OK
 */
function showConfirm(message, onConfirm) {
    const modal     = document.getElementById("global-modal");
    const cancelBtn = document.getElementById("modal-cancel-btn");
    document.getElementById("modal-title").innerText       = "Confirm";
    document.getElementById("modal-message-text").innerText = message;
    cancelBtn.classList.remove("hidden");
    modal.classList.remove("hidden");
    document.getElementById("modal-ok-btn").onclick = () => { modal.classList.add("hidden"); onConfirm(); };
    cancelBtn.onclick = () => modal.classList.add("hidden");
}
</script>

<?php include '../includes/footer.php'; ?>