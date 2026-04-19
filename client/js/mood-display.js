let moodLocked = false;
let todayEmoji = null;

// 页面加载时检查今天的 mood
document.addEventListener("DOMContentLoaded", () => {
    checkTodayMood();
});

// 点击 emoji
function submitMood(emoji, btn) {

    // 如果今天已经选过
    if (moodLocked) {
        showModal(
            "Mood Locked",
            "Today's mood already selected. Please come back tomorrow."
        );
        return;
    }

    // 提交到后端
    fetch("Q&A/submit_mood.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ emoji: emoji })
    })
    .then(res => res.json())
    .then(data => {

        // 后端说已经选过（双保险）
        if (data.status === "exists") {
            moodLocked = true;

            showModal(
                "Mood Locked",
                "Today's mood already selected. Please come back tomorrow."
            );
            return;
        }

        // 高亮当前选中的 emoji
        highlightEmoji(emoji);

        moodLocked = true;
        todayEmoji = emoji;

        showModal("Saved!", "Your mood has been recorded.");
    })
    .catch(err => {
        console.error(err);
    });
}

// 页面加载时调用
function checkTodayMood() {
    fetch("Q&A/get_today_mood.php")
        .then(res => res.json())
        .then(data => {

            if (!data.exists) return;

            moodLocked = true;
            todayEmoji = data.emoji;

            highlightEmoji(todayEmoji);
        })
        .catch(err => {
            console.error(err);
        });
}

// 高亮函数（单独封装）
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

// 关闭 modal（修复多个 close-modal 冲突）
document.querySelectorAll("#close-modal").forEach(btn => {
    btn.onclick = () => {
        document.getElementById("global-modal").classList.add("hidden");
    };
});

document.getElementById("modal-ok-btn").onclick = () => {
    document.getElementById("global-modal").classList.add("hidden");
};

// 点击背景关闭
document.getElementById("global-modal").onclick = (event) => {
    if (event.target.id === "global-modal") {
        event.currentTarget.classList.add("hidden");
    }
};