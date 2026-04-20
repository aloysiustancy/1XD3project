<!-- /includes/footer.php -->
<?php
/*
 * Name: Brian, Aloysius, Haoxuan, Jason
 * Date: March 21, 2026
 * Description: Shared page footer. Renders social links, copyright text,
 *              and loads mobileMenu.js after the rest of the page is built.
 */
?>
<footer id="footer">
    <div id="footer-social">
        <a href="https://www.facebook.com/McMasterMindfulnessClub" target="_blank" aria-label="Facebook" class="social-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
            </svg>
        </a>
        <a href="https://www.instagram.com/mcmastermindfulnessclub/" target="_blank" aria-label="Instagram" class="social-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
            </svg>
        </a>
    </div>
    <p>©2025 McMaster Mindfulness Club · Built by That One Goose</p>
</footer>

<!-- mobileMenu loaded last so DOM is guaranteed ready -->
<script src="js/mobileMenu.js"></script>

</body>
</html>