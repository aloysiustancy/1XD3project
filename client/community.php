<?php
session_start();

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

    #close-modal {
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
    #quote-input,
    #author-input {
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
    #quote-input:focus,
    #author-input:focus {
        border-color: #2c5f2e;
        box-shadow: 0 0 5px rgba(44,95,46,0.3);
    }

    #submit-quote {
        margin-top: 10px;
        padding: 8px 14px;
        background: #2c5f2e;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.2s;
    }

    #submit-quote:hover {
        background: #3d7a40;
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

<!-- ══ PLACEHOLDER NOTICE ══════════════════════════════════ -->
<section class="section">
    <div class="centered-block">
        <div class="placeholder-notice">
            <span class="placeholder-icon">🚧</span>
            <h2>Coming Soon</h2>
            <p>The Community Hub is currently under development. These features are part of the TOG (Tenses Off and Grounded) interactive experience and will be powered by a PHP backend.</p>
        </div>
    </div>
</section>

<!-- ══ Wall of Wisdom ════════════════════ -->
<section class="section section-tinted">
    <div class="centered-block">
        <h2>Wall of Wisdom</h2>
        <div class="feature-card" id="wow-card">
            
            <div class="feature-icon">📜</div>
            <p>A daily quote to give the community a sense of calm and grounding.</p>

            <blockquote id="wow-text" style="font-style:italic;">
                Loading quote...
            </blockquote>
            <p id="wow-author"></p>

            <?php if ($_SESSION['isAdmin']): ?>
                <button id="add-quote-btn" class="admin-btn">+ Add Quote</button>
                <p class="admin-note">Moderator only</p>
            <?php endif; ?>
        </div>

    </div>
</section>

<!-- ══ FEATURE PREVIEWS (placeholders) ════════════════════ -->
<section class="section">
    <div class="centered-block">
        <h2>What's Coming</h2>

        <div class="feature-grid">

            <!-- Gesture Poll -->
            <div class="feature-card">
                <div class="feature-icon">💬</div>
                <h3>Gesture Poll</h3>
                <p>A simple "How are you feeling?" tool — click an emoji to receive a curated Acceptance message from the club.</p>
                <div class="feature-placeholder">
                    <!-- TODO: PHP — submit emoji vote, return acceptance message from DB -->
                    <div class="emoji-row">
                        <button class="emoji-btn" disabled>😌</button>
                        <button class="emoji-btn" disabled>😐</button>
                        <button class="emoji-btn" disabled>😔</button>
                        <button class="emoji-btn" disabled>😤</button>
                        <button class="emoji-btn" disabled>😴</button>
                    </div>
                    <p class="placeholder-label">PHP integration pending</p>
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
            </div>

            <!-- Community Q&A -->
            <div class="feature-card">
                <div class="feature-icon">🌿</div>
                <h3>Moderator Q&amp;A</h3>
                <p>Moderators post a question for the community to reflect on and respond to — encouraging small, meaningful interaction.</p>
                <div class="feature-placeholder">
                    <!-- TODO: PHP — fetch moderator question + community answers from DB -->
                    <div class="qa-placeholder">
                        <p class="qa-question">"What is one small thing that brought you calm today?"</p>
                        <div class="qa-responses">
                            <div class="qa-response-stub"></div>
                            <div class="qa-response-stub"></div>
                            <div class="qa-response-stub"></div>
                        </div>
                    </div>
                    <p class="placeholder-label">PHP integration pending</p>
                </div>
            </div>

        </div>
    </div>

    <div id="quote-modal" class="modal hidden">
        <div class="modal-content">
            <span id="close-modal">&times;</span>
            <h3>Add Quote</h3>
            <?php if ($_SESSION['isAdmin']): ?>
                <p class="admin-warning">You are an administrator</p>
            <?php endif; ?>

            <input id="quote-input" placeholder="Enter quote"><br>
            <input id="author-input" placeholder="Author"><br>
            <button id="submit-quote">Submit</button>

            <p id="modal-message"></p>
        </div>
    </div>
</section>

<script>
    const isAdmin = <?php echo $_SESSION['isAdmin'] ? 'true' : 'false'; ?>;
</script>

<link rel="stylesheet" href="css/calendar.css">
<script src="js/calendar.js"></script>
<script src="js/quote-display.js"></script>

<?php include 'includes/footer.php'; ?>