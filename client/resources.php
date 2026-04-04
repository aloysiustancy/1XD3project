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
        font-size: clamp(2.16rem, 3vw, 3.6rem);
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
        <h1>Resources &amp; Recommendations</h1>
        <p>What to read, watch, listen to, and courses to take — all related to mindfulness.</p>
    </div>
</header>

<!-- ══ INTRO / LINKS ════════════════════════════════════════ -->
<section class="section">
    <div class="centered-block">
        <p>
            Have a mindfulness recommendation? We'd love to hear it!
            <a href="https://www.instagram.com/mcmastermindfulnessclub/" target="_blank">Reach out on Instagram</a>
            or email us at <a href="mailto:macmmc@mcmaster.ca">macmmc@mcmaster.ca</a>.
        </p>
    </div>
</section>

<!-- ══ EDUCATIONAL REPOSITORY ══════════════════════════════ -->
<section class="section section-tinted">
    <div class="centered-block">
        <h2>Educational Repository</h2>
        <h3>Mindfulness Myths</h3>

        <div class="myth">
            <strong>Myth:</strong> Meditation means completely emptying your mind.
            <div class="fact">
                <strong>Fact:</strong> Meditation is about observing thoughts without judgment, not eliminating them entirely.
            </div>
        </div>

        <div class="myth">
            <strong>Myth:</strong> You must sit cross-legged for meditation to work.
            <div class="fact">
                <strong>Fact:</strong> Mindfulness can be practiced sitting in a chair, walking, or even during daily activities.
            </div>
        </div>

        <div class="myth">
            <strong>Myth:</strong> Meditation takes many hours to be effective.
            <div class="fact">
                <strong>Fact:</strong> Even 5–10 minutes of mindful breathing can have measurable benefits.
            </div>
        </div>
    </div>
</section>

<!-- ══ FOR READING ══════════════════════════════════════════ -->
<section class="section">
    <div class="centered-block">
        <div class="resource-section-label">📖 For Reading</div>
        <div class="resource-grid">

            <div class="resource-card">
                <div class="resource-card-image">
                    <img src="https://placehold.co/300x420/ddecd6/2c5f2e?text=Atomic+Habits" alt="Atomic Habits by James Clear">
                </div>
                <div class="resource-card-body">
                    <h3>Atomic Habits</h3>
                    <p class="resource-author">James Clear</p>
                    <p>A practical guide to making small changes that deliver big results — building good habits, breaking bad ones, and redesigning your environment for success.</p>
                    <ul>
                        <li>Develop a stronger identity and believe in yourself</li>
                        <li>Make tiny, easy changes that deliver big results</li>
                        <li>Get back on track when you get off course</li>
                        <li>Overcome a lack of motivation and willpower</li>
                        <li>Design your environment to make success easier</li>
                    </ul>
                    <div class="resource-links">
                        <a href="https://www.amazon.ca/Atomic-Habits-Proven-Build-Break/dp/0735211299/" target="_blank" class="btn btn-outline-green">Amazon</a>
                        <a href="https://www.chapters.indigo.ca/en-ca/books/atomic-habits-an-easy-proven/9780735211292-item.html" target="_blank" class="btn btn-outline-green">Indigo</a>
                        <a href="https://itunes.apple.com/us/book/id1384286945" target="_blank" class="btn btn-outline-green">iBooks</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ══ FOR WATCHING ═════════════════════════════════════════ -->
<section class="section section-tinted">
    <div class="centered-block">
        <div class="resource-section-label">🎬 For Watching</div>
        <div class="resource-grid">

            <div class="resource-card">
                <div class="resource-card-image">
                    <img src="https://placehold.co/300x420/ddecd6/2c5f2e?text=Headspace%3A+Guide+to+Meditation" alt="Headspace Guide to Meditation on Netflix">
                </div>
                <div class="resource-card-body">
                    <h3>Headspace: Guide to Meditation</h3>
                    <p class="resource-author">Netflix · Headspace</p>
                    <p>A meditation series that explores the benefits of meditation and offers techniques and guided sessions. Learn to let go, deal with stress, manage pain, and achieve limitless potential.</p>
                    <div class="resource-links">
                        <a href="https://youtu.be/H77PL7SlI1M" target="_blank" class="btn btn-outline-green">▶ Watch Trailer</a>
                    </div>
                </div>
            </div>

            <div class="resource-card">
                <div class="resource-card-image">
                    <img src="https://placehold.co/300x420/ddecd6/2c5f2e?text=Headspace%3A+Guide+to+Sleep" alt="Headspace Guide to Sleep on Netflix">
                </div>
                <div class="resource-card-body">
                    <h3>Headspace: Guide to Sleep</h3>
                    <p class="resource-author">Netflix · Headspace</p>
                    <p>Helps viewers improve their sleep by unpacking misconceptions, offering friendly tips, and providing a guided wind-down session to close out the day mindfully.</p>
                    <div class="resource-links">
                        <a href="https://youtu.be/GVzKqr3Dss0" target="_blank" class="btn btn-outline-green">▶ Watch Trailer</a>
                    </div>
                </div>
            </div>

            <div class="resource-card">
                <div class="resource-card-image">
                    <img src="https://placehold.co/300x420/ddecd6/2c5f2e?text=Headspace%3A+Unwind+Your+Mind" alt="Headspace Unwind Your Mind Interactive">
                </div>
                <div class="resource-card-body">
                    <h3>Headspace: Unwind Your Mind</h3>
                    <p class="resource-author">Netflix · Headspace · Interactive</p>
                    <p>An interactive Netflix experience where viewers choose their own personalized breathing exercises and path to relaxation based on their current mood or mindset.</p>
                    <div class="resource-links">
                        <a href="https://youtu.be/H65oSNmSLmc" target="_blank" class="btn btn-outline-green">▶ Watch Trailer</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ══ MCMASTER COURSES ═════════════════════════════════════ -->
<section class="section">
    <div class="centered-block">
        <div class="resource-section-label">🎓 Courses at McMaster</div>
        <div class="course-grid">

            <div class="course-card">
                <div class="course-code">PSYCH 3BA3</div>
                <h3>Positive Psychology</h3>
                <p>Explores the physiology, psychological effects, and adaptive value of positive emotional and cognitive responses to the outside world and to our own thoughts and behaviours.</p>
                <div class="course-meta">⏱ 3-credit course</div>
            </div>

            <div class="course-card">
                <div class="course-code">HLTHSCI 3E03</div>
                <h3>Body, Mind, Spirit</h3>
                <p>Students apply concepts related to body, mind, and spirit for a happier, calmer, and more successful student life. Includes an eight-week modified Mindfulness-Based Stress Reduction program to develop greater calm and practical stress management skills.</p>
                <div class="course-meta">⏱ 3-credit course</div>
            </div>

        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>