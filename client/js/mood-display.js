/**
 * Name: Brian, Aloysius, Haoxuan, Jason
 * Date: March 21, 2026
 * Description: Handles the mood emoji picker on the community page. Checks if the
 *              user already picked a mood today on load, and lets them submit one
 *              emoji per day. Controls the global modal popup.
 */

let moodLocked = false;
let todayEmoji = null;

document.addEventListener("DOMContentLoaded", () => {
    checkTodayMood();
});

/**
 * Submits the selected mood emoji to the server.
 * Blocks submission if the user already picked today.
 *
 * @param {String}           emoji - The emoji character the user clicked
 * @param {HTMLButtonElement} btn  - The button that was clicked
 */
function submitMood(emoji, btn) {

    if (moodLocked) {
        showModal("Mood Locked", "Today's mood already selected. Please come back tomorrow.");
        return;
    }

    fetch("qanda/submit_mood.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ emoji: emoji })
    })
    .then(res => res.json())
    .then(data => {

        if (data.status === "exists") {
            moodLocked = true;
            showModal("Mood Locked", "Today's mood already selected. Please come back tomorrow.");
            return;
        }

        highlightEmoji(emoji);
        updateCalendar();
        loadStats();

        moodLocked = true;
        todayEmoji = emoji;

        showModal("Saved!", "Your mood has been recorded.");
    })
    .catch(err => console.error(err));
}

/**
 * Checks on page load if the user already picked a mood today.
 * If so, highlights their emoji and locks the picker.
 */
function checkTodayMood() {
    fetch("qanda/get_today_mood.php")
        .then(res => res.json())
        .then(data => {
            if (!data.exists) return;
            moodLocked = true;
            todayEmoji = data.emoji;
            highlightEmoji(todayEmoji);
            loadStats();
        })
        .catch(err => console.error(err));
}

/**
 * Adds the "active" CSS class to the button matching the given emoji
 * and removes it from all others.
 *
 * @param {String} emoji - The emoji character to highlight
 */
function highlightEmoji(emoji) {
    document.querySelectorAll(".emoji-btn").forEach(btn => {
        btn.classList.remove("active");
        if (btn.dataset.emoji === emoji) btn.classList.add("active");
    });
}

/**
 * Opens the global modal with a title and message.
 *
 * @param {String} title   - Modal heading
 * @param {String} message - Modal body text
 */
function showModal(title, message) {
    const modal = document.getElementById("global-modal");
    document.getElementById("modal-title").textContent        = title;
    document.getElementById("modal-message-text").textContent = message;
    modal.classList.remove("hidden");
}

document.querySelectorAll("#close-modal").forEach(btn => {
    btn.onclick = () => document.getElementById("global-modal").classList.add("hidden");
});

document.getElementById("modal-ok-btn").onclick = () => {
    document.getElementById("global-modal").classList.add("hidden");
};

document.getElementById("global-modal").onclick = (event) => {
    if (event.target.id === "global-modal") event.currentTarget.classList.add("hidden");
};