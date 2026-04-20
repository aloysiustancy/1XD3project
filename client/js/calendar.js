const daysTag = document.querySelector(".days");
const currentDate = document.querySelector(".current-date");
const prevNextIcon = document.querySelectorAll(".icons span");

let date = new Date(),
    currYear = date.getFullYear(),
    currMonth = date.getMonth();

const months = ["January", "February", "March", "April", "May", "June", "July",
    "August", "September", "October", "November", "December"];

const renderCalendar = () => {
    let firstDayofMonth = new Date(currYear, currMonth, 1).getDay();
    let lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate();
    let lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay();
    let lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate();
    let liTag = "";

    for (let i = firstDayofMonth; i > 0; i--) {
        liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
    }
    for (let i = 1; i <= lastDateofMonth; i++) {
        let isToday = i === date.getDate() && currMonth === new Date().getMonth() && currYear === new Date().getFullYear() ? "active" : "";
        const month = String(currMonth + 1).padStart(2, '0');
        const day = String(i).padStart(2, '0');

        liTag += `<li class="${isToday}" data-date="${currYear}-${month}-${day}">
            <div class="day-num">${i}</div>
            <div class="day-emoji" id="emoji-${currYear}-${month}-${day}"></div>
        </li>`;
    }
    for (let i = lastDayofMonth; i < 6; i++) {
        liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`;
    }
    currentDate.innerText = `${months[currMonth]} ${currYear}`;
    daysTag.innerHTML = liTag;
};

async function loadMoods() {
    try {
        const res = await fetch("qanda/public_moods.php");
        const data = await res.json();
        for (let dateKey in data) {
            const cell = document.getElementById("emoji-" + dateKey);
            if (!cell) continue;
            let html = "";
            data[dateKey].forEach(m => {
                html += `<span class="mood-emoji">${m.emoji}</span>`;
            });
            cell.innerHTML = html;
        }
    } catch (e) {
        console.error("loadMoods error:", e);
    }
}

async function loadStats() {
    const container = document.getElementById("mood-stats");
    if (!container) return;

    try {
        // 1. Check if the user has selected today.
        const checkRes = await fetch("qanda/get_today_mood.php");
        const userData = await checkRes.json();

        // 2. If you haven't selected anything today -> a red notification will appear.
        if (!userData.exists) {
            container.innerHTML = `
                <h4>Today's Mood Stats</h4>
                <p style="color: red; text-align: center; margin-top: 15px; font-weight: bold;">
                    ⚠️ Select your mood in the Poll above to see today's stats!
                </p>
            `;
            return;
        }

        // 3. If already selected -> Request today's full staff statistics
        const res = await fetch("qanda/get_today_stats.php");
        const data = await res.json();
        
        console.log("Stats data received:", data);

        let html = `
            <h4>Today's Mood Stats</h4>
            <table class="stats-table">
                <tr>
                    <th>Mood</th>
                    <th># of People</th>
                </tr>
        `;

        // Check if there is data
        if (!data || data.length === 0) {
            html += `
                <tr>
                    <td colspan="2" style="text-align: center; color: gray;">
                        No mood data available for today
                    </td>
                </tr>
            `;
        } else {
            // Iterate through all the counted expressions
            data.forEach(row => {
                if (row.emoji && row.count) {
                    html += `
                        <tr>
                            <td class="mood-emoji">${row.emoji}</td>
                            <td>${row.count}</td>
                        </tr>
                    `;
                }
            });
        }

        html += `</table>`;
        container.innerHTML = html;

    } catch (e) {
        console.error("loadStats error:", e);
    }
}

function updateCalendar() {
    renderCalendar();
    loadMoods();
}

// initialization
updateCalendar();
loadStats();

prevNextIcon.forEach(icon => {
    icon.addEventListener("click", () => {
        currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;
        if (currMonth < 0 || currMonth > 11) {
            date = new Date(currYear, currMonth, new Date().getDate());
            currYear = date.getFullYear();
            currMonth = date.getMonth();
        } else {
            date = new Date();
        }
        updateCalendar();
    });
});