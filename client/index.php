<?php include 'includes/header.php'; ?>

<link rel="stylesheet" href="css/indexStyle.css">
<link rel="stylesheet" href="css/breathing.css">
<!-- ══ HERO ════════════════════════════════════════════════════ -->
<section id="hero">
    <div id="hero-overlay"></div>
    <div id="hero-content">
        <h1>McMaster Mindfulness Club</h1>
        <div id="hero-buttons">
            <a href="members.php" class="btn btn-primary">Sign Up</a>
            <a href="#contact" class="btn btn-outline">Contact Us</a>
        </div>
    </div>
</section>

<!-- ══ NEXT MEETING SPOTLIGHT ══════════════════════════════════ -->
<section class="section" id="event-spotlight">
    <div class="centered-block">
        <h2 class="section-heading">Next Meeting</h2>

        <div class="event-spotlight">

            <div class="event-spotlight-panel">
                <span class="event-spotlight-badge">Upcoming</span>
                <div class="event-spotlight-date-block" id="spotlight-date">
                    <span class="month">—</span>
                    <span class="day">—</span>
                    <span class="year">—</span>
                </div>
            </div>

            <div class="event-spotlight-body">
                <h3 id="event-title">Loading event…</h3>

                <div class="event-meta">
                    <span class="event-meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <span id="event-time"></span>
                    </span>
                    <span class="event-meta-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                        </svg>
                        <span id="event-location"></span>
                    </span>
                </div>

                <div class="countdown-row" id="countdown-row">
                    <div class="countdown-unit"><span class="num" id="cd-days">--</span><span class="label">Days</span></div>
                    <div class="countdown-unit"><span class="num" id="cd-hours">--</span><span class="label">Hrs</span></div>
                    <div class="countdown-unit"><span class="num" id="cd-mins">--</span><span class="label">Min</span></div>
                    <div class="countdown-unit"><span class="num" id="cd-secs">--</span><span class="label">Sec</span></div>
                </div>

                <p id="event-description"></p>

                <div>
                    <a href="events.php" class="btn btn-primary">See All Events</a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ══ WHAT IS MINDFULNESS ═════════════════════════════════════ -->
<section id="about" class="section section-tinted">
    <div class="two-col">
        <div class="two-col-text">
            <h2>What is Mindfulness?</h2>
            <p>
                Mindfulness is a quality that every human being already possesses — <em>"presence"</em>.
                This presence is to be had in every moment, living and existing in your body, environment, and mind.
                Mindfulness is especially helpful in challenging situations, because it reminds you of choice:
                to decide and act with clarity, over anxiety and confusion.
            </p>
            <p class="attr">— Definition adapted from <a href="https://www.headspace.com/mindfulness/mindfulness-101" target="_blank">Headspace</a></p>
            <p>Mindfulness has many forms, and can be created through:</p>
            <ul>
                <li>Meditation — Seated, or Yoga</li>
                <li>Taking short reflective pauses</li>
                <li>Self-compassion</li>
                <li>Realizing your power over your thoughts</li>
                <li>Simply appreciating the moment</li>
            </ul>
        </div>
        <div class="two-col-image">
            <img src="https://placehold.co/520x390/ddecd6/2c5f2e?text=Mindfulness" alt="Mindfulness">
        </div>
    </div>
</section>

<!-- ══ OUR PURPOSE ════════════════════════════════════════════ -->
<section id="purpose" class="section">
    <div class="centered-block">
        <h2 class="section-heading">Our Purpose</h2>
        <p>
            The McMaster Mindfulness Club aims to create a safe(r), brave, and relaxing space for students
            to develop deep appreciation, awareness and acceptance around one's mental health, emotions, and
            bodily sensations while living in the moment — through meditation, yoga, arts, reflection, and
            various safe relaxation methods.
        </p>
        <p>
            Founded in 2020, the MMC is dedicated to promoting mindfulness and maintaining self-wellbeing.
            Through online and in-person initiatives, events, and student outreach, the MMC is committed to
            acting as the central hub for mindfulness on campus.
        </p>
    </div>
</section>

<!-- ══ MINDFULNESS MYTHS ══════════════════════════════════════ -->
<section class="section section-tinted" id="myths">
    <div class="centered-block">
        <h2 class="section-heading">Mindfulness Myths</h2>
        <p>Common misconceptions about meditation and mindfulness practice.</p>

        <div class="myths-grid">

            <div class="myth-card">
                <div class="myth-card-header">
                    <span class="myth-label">Myth</span>
                    <p>Meditation means completely emptying your mind.</p>
                </div>
                <div class="myth-card-fact">
                    <span class="fact-label">Fact</span>
                    <p>Meditation is about observing thoughts without judgment, not eliminating them entirely.</p>
                </div>
            </div>

            <div class="myth-card">
                <div class="myth-card-header">
                    <span class="myth-label">Myth</span>
                    <p>You must sit cross-legged for meditation to work.</p>
                </div>
                <div class="myth-card-fact">
                    <span class="fact-label">Fact</span>
                    <p>Mindfulness can be practiced sitting in a chair, walking, or even during daily activities.</p>
                </div>
            </div>

            <div class="myth-card">
                <div class="myth-card-header">
                    <span class="myth-label">Myth</span>
                    <p>Meditation takes many hours to be effective.</p>
                </div>
                <div class="myth-card-fact">
                    <span class="fact-label">Fact</span>
                    <p>Even 5–10 minutes of mindful breathing can have measurable, lasting benefits.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ══ BREATHING MODULE ════════════════════════════════════════ -->
<!-- <section class="section" id="breathing-section">
    <div class="centered-block">
        <h2 class="section-heading">Take a Moment</h2>
        <p>Try our guided breathing exercise right here.</p>
        <div class="breathing-wrapper">
            <?php include 'breathing.html'; ?>
        </div>
    </div>
</section> -->

<script src="js/eventCountdown.js?v=<?= filemtime('js/eventCountdown.js') ?>"></script>
<?php include 'includes/footer.php'; ?>