<?php
// Name: Brian, Aloysius, Haoxuan, Jason
// Date: March 21, 2026
// The admin dashboard that manages events and creates new admins 

session_start();

if (!isset($_SESSION['userId']) || $_SESSION['isAdmin'] != 1) {
    header('Location: login.php');
    exit;
}

/* ── Fetch admin's first name for the welcome heading ── */
$adminName = 'Admin';
try {
    $dsn = "mysql:host=localhost;dbname=tana42_db;charset=utf8mb4";
    $pdo = new PDO($dsn, 'tana42_local', '+im}Zbr.');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare(
        "SELECT ui.firstName FROM UserInfo ui WHERE ui.userId = ? LIMIT 1"
    );
    $stmt->execute([$_SESSION['userId']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && $row['firstName']) {
        $adminName = htmlspecialchars($row['firstName']);
    }
} catch (Exception $e) {
    // Non-fatal — welcome heading falls back to 'Admin'
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | McMaster Mindfulness Club</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>

    <!-- ══ NAVIGATION ══════════════════════════════════════════ -->
    <nav id="nav">
        <a href="index.php" id="nav-logo">McMaster Mindfulness Club</a>
        <div id="nav-links">
            <a class="nav-link" href="index.php">Home</a>
            <a class="nav-link" href="community.php">Community</a>
            <a class="nav-link" href="events.php">Events</a>
            <a class="nav-link" href="members.php">Members</a>
            <a class="nav-link" href="resources.php">Resources</a>
        </div>
        <div id="nav-social">
            <a href="https://www.facebook.com/McMasterMindfulnessClub" target="_blank" aria-label="Facebook">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
            </a>
            <a href="https://www.instagram.com/mcmastermindfulnessclub/" target="_blank" aria-label="Instagram">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
            </a>
        </div>
    </nav>

    <!-- ══ DASHBOARD ════════════════════════════════════════════ -->
    <div class="dashboard-wrap">
        <div class="dashboard-panel">

            <h1 class="dashboard-welcome">Welcome <?= $adminName ?></h1>

            <div class="dashboard-grid">

                <!-- ── LEFT COLUMN ── -->
                <div>

                    <!-- Schedule an Event -->
                    <div class="dash-section">
                        <p class="dash-label">Schedule an Event</p>
                        <form id="event-form" onsubmit="submitEvent(event)">
                            <div class="modal-field">
                                <label class="modal-label" for="ev-name">Event name</label>
                                <input class="modal-input" id="ev-name" type="text" required>
                            </div>
                            <div class="modal-row">
                                <div class="modal-field">
                                    <label class="modal-label" for="ev-datetime">Time</label>
                                    <input class="modal-input" id="ev-datetime" type="datetime-local" required>
                                </div>
                                <div class="modal-field">
                                    <label class="modal-label" for="ev-location">Location</label>
                                    <input class="modal-input" id="ev-location" type="text">
                                </div>
                            </div>
                            <div class="modal-field">
                                <label class="modal-label" for="ev-image">Image</label>
                                <label class="upload-area" id="upload-area" for="ev-image">
                                    <input type="file" id="ev-image" name="image" accept="image/*" onchange="previewImage(this)">
                                    <div class="upload-placeholder" id="upload-placeholder">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                        <span>Click to upload an image</span>
                                    </div>
                                    <img id="upload-preview" class="upload-preview" src="" alt="Preview" style="display:none;">
                                </label>
                            </div>
                            <div style="text-align:center; margin-top:8px;">
                                <button class="pill-btn" id="btn-submit-event" type="submit">SUBMIT</button>
                            </div>
                        </form>
                    </div>

                </div>

                <!-- ── RIGHT COLUMN ── -->
                <div>

                    <!-- Add Admin -->
                    <div class="dash-section">
                        <p class="dash-label">Create a new admin</p>
                        <form id="admin-form" onsubmit="submitAdmin(event)">
                            <div class="modal-row">
                                <div class="modal-field">
                                    <label class="modal-label" for="adm-first">First name</label>
                                    <input class="modal-input" id="adm-first" type="text" required>
                                </div>
                                <div class="modal-field">
                                    <label class="modal-label" for="adm-last">Last name</label>
                                    <input class="modal-input" id="adm-last" type="text" required>
                                </div>
                            </div>
                            <div class="modal-field">
                                <label class="modal-label" for="adm-email">Email</label>
                                <input class="modal-input" id="adm-email" type="email" required>
                            </div>
                            <div class="modal-field">
                                <label class="modal-label" for="adm-phone">Phone number</label>
                                <input class="modal-input" id="adm-phone" type="tel" required minlength="7" maxlength="20">
                            </div>
                            <div class="modal-field">
                                <label class="modal-label" for="adm-password">Password</label>
                                <input class="modal-input" id="adm-password" type="password" minlength="8" required>
                            </div>
                            <div style="text-align:center; margin-top:8px;">
                                <button class="pill-btn" id="btn-submit-admin" type="submit">CREATE</button>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- ── END RIGHT COLUMN ── -->

            </div>
        </div>
    </div>

    <!-- ══ TOAST ════════════════════════════════════════════════ -->
    <div id="toast"></div>

    <!-- ══ FOOTER ════════════════════════════════════════════════ -->
    <footer id="footer">
        <div id="footer-social">
            <a href="https://www.facebook.com/McMasterMindfulnessClub" target="_blank" aria-label="Facebook" class="social-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
            </a>
            <a href="https://www.instagram.com/mcmastermindfulnessclub/" target="_blank" aria-label="Instagram" class="social-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
            </a>
        </div>
        <p>©2025 McMaster Mindfulness Club · Built by That One Goose</p>
    </footer>

    <script src="js/quote.js"></script>
    <script src="js/event.js"></script>
    <script>
        async function submitAdmin(e) {
            e.preventDefault();
            const btn = document.getElementById('btn-submit-admin');
            btn.disabled = true;
            btn.textContent = 'Creating…';

            const body = new FormData();
            body.append('firstName',   document.getElementById('adm-first').value.trim());
            body.append('lastName',    document.getElementById('adm-last').value.trim());
            body.append('email',       document.getElementById('adm-email').value.trim());
            body.append('phoneNumber', document.getElementById('adm-phone').value.trim());
            body.append('password',    document.getElementById('adm-password').value);

            try {
                const res  = await fetch('addAdmin.php', { method: 'POST', body });
                const text = await res.text();
                const ok   = res.ok;
                showToast(text, !ok);
                if (ok) document.getElementById('admin-form').reset();
            } catch {
                showToast('Request failed. Please try again.', true);
            } finally {
                btn.disabled = false;
                btn.textContent = 'CREATE';
            }
        }
    </script>

</body>
</html>
