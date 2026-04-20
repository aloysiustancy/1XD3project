<?php
// Name: Brian, Aloysius, Haoxuan, Jason
// Date: March 21, 2026
// Events page — displays upcoming meeting spotlight with live countdown and past event archive

include 'includes/header.php';
?>
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

<!-- ══ PAGE HERO ═══════════════════════════════════════════════ -->
<header class="page-hero">
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content">
        <h1>Events</h1>
        <p>Workshops, sessions, and mindful gatherings — past and upcoming.</p>
    </div>
</header>

<!-- ══ NEXT MEETING SPOTLIGHT ══════════════════════════════════ -->
<section class="section">
    <div class="centered-block">
        <h2 class="section-heading">Next Meeting</h2>

        <div class="event-spotlight">

            <!-- Left: date panel (populated by JS too if needed) -->
            <div class="event-spotlight-panel">
                <span class="event-spotlight-badge">Upcoming</span>
                <div class="event-spotlight-date-block" id="spotlight-date">
                    <span class="month">April</span>
                    <span class="day">12</span>
                    <span class="year">2026</span>
                </div>
            </div>

            <!-- Right: details + live countdown -->
            <div class="event-spotlight-body">
                <h3 id="event-title">Weekly Mindfulness Gathering</h3>

                <div class="event-meta">
                    <span class="event-meta-item">
                        <!-- clock icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <span id="event-time">6:00 PM – 7:30 PM</span>
                    </span>
                    <span class="event-meta-item">
                        <!-- pin icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                        </svg>
                        <span id="event-location">Community Wellness Center, Room 204</span>
                    </span>
                </div>

                <!-- Live countdown -->
                <div class="countdown-row" id="countdown-row">
                    <div class="countdown-unit"><span class="num" id="cd-days">--</span><span class="label">Days</span></div>
                    <div class="countdown-unit"><span class="num" id="cd-hours">--</span><span class="label">Hrs</span></div>
                    <div class="countdown-unit"><span class="num" id="cd-mins">--</span><span class="label">Min</span></div>
                    <div class="countdown-unit"><span class="num" id="cd-secs">--</span><span class="label">Sec</span></div>
                </div>

                <p id="event-description">Join us for guided meditation, open sharing, and practical techniques to reduce stress and improve focus. All experience levels welcome — just bring yourself.</p>

                <div>
                    <a href="https://www.instagram.com/mcmastermindfulnessclub/" target="_blank" class="btn btn-primary">
                        Follow on Instagram
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ══ PAST EVENTS ═════════════════════════════════════════════ -->
<section class="section section-tinted">
    <div class="centered-block">
        <h2 class="section-heading">Past Events</h2>

        <div class="events-list">

            <!-- Event 1 -->
            <div class="event-card">
                <div class="event-card-image">
                    <img src="images/1events.png"
                         alt="MacRehab x Mindfulness Meditative Yoga">
                </div>
                <div class="event-card-body">
                    <span class="event-tag">Collaboration</span>
                    <h3>Meditative Yoga: MacRehab × McMaster Mindfulness</h3>
                    <p>
                        MacRehab Club and McMaster Mindfulness joined forces for a meditative yoga session,
                        blending rehabilitation science with mindful movement for the McMaster community.
                    </p>
                </div>
            </div>

            <!-- Event 2 -->
            <div class="event-card event-card-reverse">
                <div class="event-card-image">
                    <img src="images/2events.png"
                         alt="Mindfulness and Creativity Workshop">
                </div>
                <div class="event-card-body">
                    <span class="event-tag">Workshop · April 2022</span>
                    <h3>Mindfulness and Creativity</h3>
                    <p>
                        In collaboration with Open Circle McMaster, this interactive workshop explored mindfulness
                        through creative expression — drawing, painting, and speech — led by Expressive Arts
                        facilitator <strong>Marybeth Leis Druery</strong>. Attendees created mandalas as a focus
                        for meditation.
                    </p>
                    <div class="event-links">
                        <a href="http://www.opencircle.mcmaster.ca/" target="_blank" class="btn btn-outline-green">Open Circle McMaster</a>
                        <a href="http://www.marybethleisdruery.ca/" target="_blank" class="btn btn-outline-green">Marybeth Leis Druery</a>
                    </div>
                </div>
            </div>

            <!-- Event 3 -->
            <div class="event-card">
                <div class="event-card-image">
                    <img src="images/3events.png"
                         alt="Mindfulness with Dr. JP Pawliw-Fry">
                </div>
                <div class="event-card-body">
                    <span class="event-tag">Speaker Event · November 2021</span>
                    <h3>Mindfulness with Dr. JP Pawliw-Fry</h3>
                    <p>
                        Dr. JP Pawliw-Fry — co-author of <em>Performing Under Pressure</em> and creator of
                        <em>The Last 8%</em> Podcast — shared breathing meditations and his
                        <strong>ETA Tool</strong> (Explore, Tenderness, Acceptance) for navigating difficult emotions.
                    </p>
                </div>
            </div>

            <!-- Event 4 -->
            <div class="event-card event-card-reverse">
                <div class="event-card-image">
                    <img src="images/4events.png"
                         alt="Mindful Self Compassion Workshop">
                </div>
                <div class="event-card-body">
                    <span class="event-tag">Workshop · March 2021</span>
                    <h3>Mindful Self-Compassion</h3>
                    <p>
                        Registered psychotherapist <strong>Sally Dwyer</strong> led an MSC workshop on how
                        self-compassion practices reduce depression, stress, and anxiety while enhancing happiness
                        and optimism. Participants explored burnout and empathy fatigue in open discussion.
                    </p>
                </div>
            </div>

            <!-- Event 5 -->
            <div class="event-card">
                <div class="event-card-image">
                    <img src="images/6events.png"
                         alt="Mindful Body Scan — First Event">
                </div>
                <div class="event-card-body">
                    <span class="event-tag">First Event · December 2020</span>
                    <h3>Mindful Body Scan</h3>
                    <p>
                        MMC's very first event! The McMaster community joined us for a virtual Mindful Body Scan
                        using guided audio from Mindfulness Hamilton. Try it yourself any time:
                    </p>
                    <div class="event-links">
                        <a href="https://mindfulnesshamilton.ca/wp-content/uploads/Body-Scan.mp3"
                           target="_blank" class="btn btn-outline-green">▶ Listen to Body Scan</a>
                        <a href="https://mindfulnesshamilton.ca/"
                           target="_blank" class="btn btn-outline-green">Mindfulness Hamilton</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script src="js/eventCountdown.js?v=<?= filemtime('js/eventCountdown.js') ?>"></script>
<?php include 'includes/footer.php'; ?>