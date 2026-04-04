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
        <h1>Meet Our Team</h1>
        <p>Thanks for checking out our website! Scroll below to see our team for the 2025–2026 school year.</p>
    </div>
</header>

<!-- ══ SIGN UP CTA ══════════════════════════════════════════ -->
<section class="section">
    <div class="centered-block">
        <h2>Join the Club</h2>
        <p>McMaster students and faculty are welcome! Fill out our sign-up form to become a member and stay up to date on events.</p>

        <?php if (isset($_SESSION['userID'])): ?>
            <!-- Already logged in — show a welcome note instead -->
            <p style="text-align:center; color: var(--green-dark); font-weight:700; margin-top:16px;">
                ✅ You're already a member. Welcome back!
            </p>
        <?php else: ?>
            <div style="text-align:center; margin-top: 24px; display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
                <a href="register.php" class="btn btn-primary">Create Account</a>
                <a href="https://docs.google.com/forms/d/e/1FAIpQLSeyCuU_UpdPYjhPTZK3S5rQrc6qBPb4SkdpAzZQpWSVhThw5w/viewform"
                   target="_blank" class="btn btn-outline-green">Club Sign-Up Form</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ══ TEAM GRID ════════════════════════════════════════════ -->
<section class="section section-tinted">
    <div class="centered-block">
        <h2>Executive Team 2025–2026</h2>

        <div class="member-grid">

            <div class="member-card">
                <div class="member-photo">
                    <img src="https://placehold.co/300x300/ddecd6/2c5f2e?text=AF" alt="Ava Forbes-Schnick">
                </div>
                <h3>Ava Forbes-Schnick</h3>
                <span class="member-role">Co-President</span>
                <p>[Blurb]</p>
            </div>

            <div class="member-card">
                <div class="member-photo">
                    <img src="https://placehold.co/300x300/ddecd6/2c5f2e?text=AA" alt="Aman Arora">
                </div>
                <h3>Aman Arora</h3>
                <span class="member-role">Co-President</span>
                <p>[Blurb]</p>
            </div>

            <div class="member-card">
                <div class="member-photo">
                    <img src="https://placehold.co/300x300/ddecd6/2c5f2e?text=KV" alt="Kamalini Vundemodalu">
                </div>
                <h3>Kamalini Vundemodalu</h3>
                <span class="member-role">VP Communications</span>
                <p>[Blurb]</p>
            </div>

            <div class="member-card">
                <div class="member-photo">
                    <img src="https://placehold.co/300x300/ddecd6/2c5f2e?text=MO" alt="Meltam Othman">
                </div>
                <h3>Meltam Othman</h3>
                <span class="member-role">VP Communications</span>
                <p>[Blurb]</p>
            </div>

            <div class="member-card">
                <div class="member-photo">
                    <img src="https://placehold.co/300x300/ddecd6/2c5f2e?text=AV" alt="Akshita Varghese">
                </div>
                <h3>Akshita Varghese</h3>
                <span class="member-role">VP Education</span>
                <p>[Blurb]</p>
            </div>

            <div class="member-card">
                <div class="member-photo">
                    <img src="https://placehold.co/300x300/ddecd6/2c5f2e?text=MB" alt="Mary O'Brien">
                </div>
                <h3>Mary O'Brien</h3>
                <span class="member-role">VP Partnership &amp; Outreach</span>
                <p>[Blurb]</p>
            </div>

            <div class="member-card">
                <div class="member-photo">
                    <img src="https://placehold.co/300x300/ddecd6/2c5f2e?text=PY" alt="Parmida Yazdi Nia">
                </div>
                <h3>Parmida Yazdi Nia</h3>
                <span class="member-role">VP Events</span>
                <p>[Blurb]</p>
            </div>

            <div class="member-card">
                <div class="member-photo">
                    <img src="https://placehold.co/300x300/ddecd6/2c5f2e?text=AT" alt="Anjutha Thayalan">
                </div>
                <h3>Anjutha Thayalan</h3>
                <span class="member-role">VP Events</span>
                <p>[Blurb]</p>
            </div>

        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>