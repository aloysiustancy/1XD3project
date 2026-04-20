let moodLocked = false;
let todayEmoji = null;

// Check today's mood when the page loads
document.addEventListener("DOMContentLoaded", () => {
    checkTodayMood();
});

// Click emoji
function submitMood(emoji, btn) {

    // If you have already chosen today
    if (moodLocked) {
        showModal(
            "Mood Locked",
            "Today's mood already selected. Please come back tomorrow."
        );
        return;
    }

    // Submit to backend
    fetch("qanda/submit_mood.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ emoji: emoji })
    })
    .then(res => res.json())
    .then(data => {

        // The backend team said they've already made a selection (double insurance).
        if (data.status === "exists") {
            moodLocked = true;

            showModal(
                "Mood Locked",
                "Today's mood already selected. Please come back tomorrow."
            );
            return;
        }

        // Highlight the currently selected emoji
        highlightEmoji(emoji);
        updateCalendar();
        loadStats();

        moodLocked = true;
        todayEmoji = emoji;

        showModal("Saved!", "Your mood has been recorded.");
    })
    .catch(err => {
        console.error(err);
    });
}

// Called when the page loads
function checkTodayMood() {
    moodLocked = false;
    todayEmoji = null;
    fetch("qanda/get_today_mood.php")
        .then(res => res.json())
        .then(data => {

            if (!data.exists) return;

            moodLocked = true;
            todayEmoji = data.emoji;

            highlightEmoji(todayEmoji);

            loadStats();
        })
        .catch(err => {
            console.error(err);
        });
}

// Highlight function (separately encapsulated)
function highlightEmoji(emoji) {
    document.querySelectorAll(".emoji-btn").forEach(btn => {
        btn.classList.remove("active");

        if (btn.dataset.emoji === emoji) {
            btn.classList.add("active");
        }
    });
}

// ===== Modal =====
function showModal(title, message) {
    const modal = document.getElementById("global-modal");

    document.getElementById("modal-title").textContent = title;
    document.getElementById("modal-message-text").textContent = message;

    modal.classList.remove("hidden");
}

// Turn off modal
document.querySelectorAll("#close-modal").forEach(btn => {
    btn.onclick = () => {
        document.getElementById("global-modal").classList.add("hidden");
    };
});

document.getElementById("modal-ok-btn").onclick = () => {
    document.getElementById("global-modal").classList.add("hidden");
};

// Click the background icon to turn off.
document.getElementById("global-modal").onclick = (event) => {
    if (event.target.id === "global-modal") {
        event.currentTarget.classList.add("hidden");
    }
};