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

<!-- ══ FEATURE PREVIEWS (placeholders) ════════════════════ -->
<section class="section section-tinted">
    <div class="centered-block">
        <h2>What's Coming</h2>

        <div class="feature-grid">

            <!-- Wall of Wisdom -->
            <div class="feature-card" id="wow-card">
                <div class="feature-icon">📜</div>
                <h3>Wall of Wisdom</h3>
                <p>A moderator-curated Quote of the Day to give the community a sense of direction and grounding.</p>
                <div class="feature-placeholder" id="wow-content">
                    <blockquote class="quote-placeholder" id="wow-text" style="font-style:italic;">
                        Loading quote…
                    </blockquote>
                    <p class="placeholder-label" id="wow-author"></p>
                </div>
            </div>

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
</section>

<link rel="stylesheet" href="css/calendar.css">
<script src="js/calendar.js"></script>
<script src="js/quote.js"></script>

<?php include 'includes/footer.php'; ?>