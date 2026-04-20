<?php
session_start();
$_SESSION['userId'] = 6;
$_SESSION['isAdmin'] = true;

if (!isset($_SESSION['userId'])) {
    header('Location: login.php');
    exit;
}
?>

<?php include 'includes/header.php'; ?>

<style>
    .page-hero {
        position: relative;
        width: 100%;
        min-height: 280px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #2c5f2e;
    }
    .page-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(160deg, rgba(44,95,46,0.45) 0%, rgba(122,0,60,0.30) 100%);
    }
    .page-hero-content {
        position: relative;
        text-align: center;
        padding: 36px 48px;
        max-width: 640px;
        background-color: rgba(44, 95, 46, 0.62);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 14px;
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }
    .page-hero-content h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.16rem, 6vw, 3.6rem);
        color: #fff;
        text-shadow: 0 2px 16px rgba(0,0,0,0.25);
        margin-bottom: 12px;
    }
    .page-hero-content p {
        color: rgba(255,255,255,0.85);
        font-size: 1.2rem;
        margin: 0;
    }

    .admin-btn {
        margin-top: 10px;
        padding: 8px 14px;
        background: #2c5f2e;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .admin-note {
        font-size: 0.8rem;
        color: gray;
    }

    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.4);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .hidden {
        display: none;
    }

    .modal-content {
        background: white;
        padding: 20px;
        border-radius: 10px;
        width: 300px;
        text-align: center;
    }

    .close-modal {
        float: right;
        cursor: pointer;
    }

    /* ── Small screens ── */
    @media (max-width: 530px) {
        .page-hero {
            padding: 24px 16px;
        }
        .page-hero-content {
            padding: 24px 20px;
        }
        .page-hero-content h1 {
            font-size: 1.8rem;
        }
        .page-hero-content p {
            font-size: 1rem;
        }
        .feature-grid {
            grid-template-columns: 1fr !important;
        }
        .emoji-row {
            flex-wrap: wrap;
            justify-content: center;
        }
        .wrapper {
            width: 100% !important;
            max-width: 100% !important;
        }
    }

    .admin-btn {
        margin-top: 10px;
        padding: 10px 18px;
        background: #2c5f2e;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    /* hover effect 🔥 */
    .admin-btn:hover {
        background: #3d7a40;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.2);
    }

    /* Click effect */
    .admin-btn:active {
        transform: scale(0.95);
    }

    #modal-message {
        margin-top: 10px;
        font-weight: bold;
    }

    .success {
        color: green;
    }

    .error {
        color: red;
    }

    /* Input box beautification 🔥 */
    .input {
        width: 90%;
        padding: 10px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        outline: none;
        transition: all 0.2s ease;
    }

    /* Focusing effect */
    .input {
        border-color: #2c5f2e;
        box-shadow: 0 0 5px rgba(44,95,46,0.3);
    }

    .submit {
        margin-top: 10px;
        padding: 8px 14px;
        background: #2c5f2e;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.2s;
    }

    .submit:hover {
        background: #3d7a40;
    }

    .emoji-btn.active {
        border: 3px solid #2c5f2e;
        transform: scale(1.2);
    }

    .emoji-btn.disabled {
        opacity: 0.4;
        pointer-events: none;
    }

    /* Message modal */
    .modal {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);

        display: flex;
        justify-content: center;
        align-items: center;

        z-index: 999;
    }

    .modal-content {
        background: #ffffff;
        padding: 24px 20px;
        border-radius: 16px;
        width: 320px;
        text-align: center;

        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        animation: modalFade 0.25s ease;
    }

    #modal-title {
        font-size: 1.6rem;
        color: #2c5f2e;
        margin-bottom: 10px;
        font-family: 'Playfair Display', serif;
    }

    #modal-message-text {
        font-size: 1rem;
        color: #444;
        margin-bottom: 18px;
        line-height: 1.5;
    }

    #modal-ok-btn {
        padding: 10px 18px;
        background: #2c5f2e;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;

        transition: all 0.25s ease;
    }

    #modal-ok-btn:hover {
        background: #3d7a40;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.2);
    }

    #modal-ok-btn:active {
        transform: scale(0.95);
    }

    .close-modal {
        float: right;
        cursor: pointer;
        font-size: 18px;
        color: #888;
    }

    .close-modal:hover {
        color: #000;
    }

    @keyframes modalFade {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .hidden {
        display: none;
    }

    .qa-response {
        background: #f3f8f4;
    }

    #qa-question {
        font-size: 1.6rem;
        font-weight: 600;
        margin: 10px 0 14px;

        /* Gradient text */
        background: linear-gradient(90deg, #ff7338, #ff5c25);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;

        /* Glowing effect */
        text-shadow: 0 0 8px rgba(44,95,46,0.25);

        /* Animation */
        animation: glowPulse 2.5s infinite alternate;
    }

    /* 呼吸光效 */
    @keyframes glowPulse {
        from {
            text-shadow: 0 0 5px rgba(44,95,46,0.2);
        }
        to {
            text-shadow: 0 0 15px rgba(44,95,46,0.5);
        }
    }

    .qa-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .qa-table th {
        background: #2c5f2e;
        color: white;
        padding: 8px;
        font-size: 0.9rem;
    }

    .qa-table td {
        padding: 8px;
        border-bottom: 1px solid #ddd;
        font-size: 0.9rem;
    }

    .qa-table tr:hover {
        background: #f5f5f5;
    }
</style>

<!-- ══ PAGE HERO ════════════════════════════════════════════ -->
<header class="page-hero">
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content">
        <h1>Community</h1>
        <p>Your daily moment of calm — the Daily Vibe, Wall of Wisdom, Gesture Poll &amp; Calendar.</p>
    </div>
</header>

<!-- ══ FEATURE PREVIEWS (placeholders) ════════════════════ -->
<section class="section section-tinted">
    <div class="centered-block">

        <div class="feature-grid">

            <!-- Wall of Wisdom -->

            <div class="feature-card" id="wow-card">
                <div class="feature-icon">📜</div>
                <h3>Wall of Wisdom</h3>

                    <blockquote id="wow-text" style="font-style:italic;">
                        Loading quote...
                    </blockquote>
                    <p id="wow-author"></p>

                    <?php if ($_SESSION['isAdmin']): ?>
                        <button id="add-quote-btn" class="admin-btn">+ Add Quote</button>
                        <a href="quotes/quote_management.php">
                            <button class="admin-btn" style="margin-left:8px;">Quote Management</button>
                        </a>
                        <p class="admin-note">Moderator only</p>
                    <?php endif; ?>
            </div>

            <!-- Gesture Poll -->
            <div class="feature-card">
                <div class="feature-icon">💬</div>
                <h3>Gesture Poll</h3>
                <p>"How are you feeling?" — click an emoji to receive a curated Acceptance message from the club.</p>
                <div class="feature-placeholder">
                    <!-- TODO: PHP — submit emoji vote, return acceptance message from DB -->
                    <div class="emoji-row">
                        <button class="emoji-btn" data-emoji="😌" onclick="submitMood('😌', this)">😌</button>
                        <button class="emoji-btn" data-emoji="😐" onclick="submitMood('😐', this)">😐</button>
                        <button class="emoji-btn" data-emoji="😔" onclick="submitMood('😔', this)">😔</button>
                        <button class="emoji-btn" data-emoji="😤" onclick="submitMood('😤', this)">😤</button>
                        <button class="emoji-btn" data-emoji="😴" onclick="submitMood('😴', this)">😴</button>
                    </div>
                    <div id="mood-msg"></div>
                </div>
            </div>

            <!-- Gesture Calendar -->
            <div class="feature-card">
                <div class="wrapper">
                    <header>
                        <p class="current-date"></p>
                        <div class="icons">
                            <span id="prev" class="material-symbols-rounded">&lt;</span>
                            <span id="next" class="material-symbols-rounded">&gt;</span>
                        </div>
                    </header>
                    <div class="calendar">
                        <ul class="weeks">
                            <li>Sun</li>
                            <li>Mon</li>
                            <li>Tue</li>
                            <li>Wed</li>
                            <li>Thu</li>
                            <li>Fri</li>
                            <li>Sat</li>
                        </ul>
                        <ul class="days"></ul>
                    </div>
                </div>
                <div id="mood-stats"></div>
            </div>

            <!-- Community qanda -->
            <div class="feature-card">
                <div class="feature-icon">🌿</div>
                <h3>Moderator Q&amp;A</h3>
                <div class="feature-placeholder">
                    <!-- TODO: PHP — fetch moderator question + community answers from DB -->
                    <div class="qa-placeholder">
                        <div id="qa-container">
                            <p id="qa-question"></p>

                            <div id="qa-answer-box" class="hidden">
                                <input class="input" id="qa-input" placeholder="Your answer..." />
                                <button class="submit" onclick="submitAnswer()">Submit</button>
                            </div>

                            <p id="qa-user-answer" class="hidden"></p><br>

                            <div id="qa-others"></div> 

                            <?php if ($_SESSION['isAdmin']): ?>
                                <button onclick="showQuestionModal()" class="admin-btn">+ Add Question</button>
                                <p class="admin-note">Moderator only</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="quote-modal" class="modal hidden">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h3>Add Quote</h3>
            <?php if ($_SESSION['isAdmin']): ?>
                <p class="admin-warning">You are an administrator</p>
            <?php endif; ?>

            <input class="input" id="quote-input" placeholder="Enter quote"><br>
            <input class="input" id="author-input" placeholder="Author"><br>
            <button class="submit" id="submit-quote">Submit</button>

            <p id="modal-message"></p>
        </div>
    </div>

    <div id="global-modal" class="modal hidden">
        <div class="modal-content">

            <h3 id="modal-title">Title</h3>
            <p id="modal-message-text">Message</p>

            <button id="modal-ok-btn">OK</button>
        </div>
    </div>

    <div id="question-modal" class="modal hidden">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h3>Add Question</h3>

        <input class="input" id="question-input" placeholder="Enter question"><br>
        <button class="submit" id="submit-question">Submit</button>

        <p id="question-message"></p>
    </div>
</div>
</section>

<script>
    const isAdmin = <?php echo $_SESSION['isAdmin'] ? 'true' : 'false'; ?>;
</script>

<link rel="stylesheet" href="css/calendar.css">
<script src="js/calendar.js"></script>
<script src="js/quote-display.js"></script>
<script src="js/qa_feed.js"></script>
<script src="js/mood-display.js"></script>

<?php include 'includes/footer.php'; ?>