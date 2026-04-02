<?php include 'includes/header.php'; ?>

<!-- Hero Section with Breathing Module -->
<section id="hero">
    <div id="hero-overlay"></div>
    <div id="hero-content">
        <h1>Ground Yourself</h1>
        <div id="hero-buttons">
            <a href="#event-spotlight" class="btn btn-primary">Next Meeting</a>
            <a href="breathing.html" class="btn btn-outline">Start Breathing</a>
        </div>
    </div>
</section>

<!-- Event Spotlight Section -->
<section class="section" id="event-spotlight">
    <div class="centered-block">
        <h2>Next Meeting</h2>
        
        <div class="card event-card" id="next-event-container">
            <div class="event-title" id="event-title">Loading event...</div>
            <div class="countdown" id="countdown" style="font-size:2rem; color:var(--maroon); font-weight:bold; margin:10px 0;">--:--:--</div>
            <div class="event-info" id="event-location"></div>
            <p id="event-description"></p>
        </div>
    </div>
</section>

<!-- Mindfulness Myths Section -->
<section class="section section-tinted">
    <div class="centered-block">
        <h2>Mindfulness Myths</h2>
        <p>Common misconceptions about meditation and mindfulness practice.</p>
        
        <div class="two-col" style="margin-top:40px;">
            <div class="two-col-text">
                <div class="myth">
                    <strong>Myth:</strong> Meditation means completely emptying your mind.
                    <div class="fact">
                        <strong>Fact:</strong> Meditation is about observing thoughts without judgment, not eliminating them entirely.
                    </div>
                </div>

                <div class="myth" style="margin-top:20px;">
                    <strong>Myth:</strong> You must sit cross-legged for meditation to work.
                    <div class="fact">
                        <strong>Fact:</strong> Mindfulness can be practiced sitting in a chair, walking, or even during daily activities.
                    </div>
                </div>

                <div class="myth" style="margin-top:20px;">
                    <strong>Myth:</strong> Meditation takes many hours to be effective.
                    <div class="fact">
                        <strong>Fact:</strong> Even 5–10 minutes of mindful breathing can have measurable benefits.
                    </div>
                </div>
            </div>
            
            <div class="two-col-image">
                <img src="images/hero.jpg" alt="Mindfulness practice" style="border-radius:var(--radius);">
            </div>
        </div>
    </div>
</section>

<!-- Quick Breathing Embed (Optional - embeds Haoxuan's module directly) -->
<section class="section">
    <div class="centered-block" style="text-align:center;">
        <h2>Take a Moment</h2>
        <p>Try our guided breathing exercise right here.</p>
        <div style="margin-top:30px; max-width:500px; margin-left:auto; margin-right:auto;">
            <?php include 'breathing.html'; ?>
        </div>
    </div>
</section>

<script src="js/eventCountdown.js"></script>
<?php include 'includes/footer.php'; ?>