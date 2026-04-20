const daysTag = document.querySelector(".days");
const currentDate = document.querySelector(".current-date");
const prevNextIcon = document.querySelectorAll(".icons span");

let date = new Date(),
    currYear = date.getFullYear(),
    currMonth = date.getMonth();

/**
 * Name: Brian, Aloysius, Haoxuan, Jason
 * Date: March 21, 2026
 * Description: Powers the mood calendar on the community page. Builds the
 *              calendar grid, loads mood emojis from the server onto each day,
 *              and shows a stats table for today's moods.
 */

const daysTag      = document.querySelector(".days");
const currentDate  = document.querySelector(".current-date");
const prevNextIcon = document.querySelectorAll(".icons span");

let date      = new Date();
let currYear  = date.getFullYear();
let currMonth = date.getMonth();

const months = ["January", "February", "March", "April", "May", "June", "July",
    "August", "September", "October", "November", "December"];

                "August", "September", "October", "November", "December"];

/**
 * Builds and displays the calendar grid for the current month and year.
 * Greys out days from adjacent months and highlights today.
 */
const renderCalendar = () => {
    let firstDayofMonth = new Date(currYear, currMonth, 1).getDay();
    let lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate();
    let lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay();
    let lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate();

    let firstDayofMonth     = new Date(currYear, currMonth, 1).getDay();
    let lastDateofMonth     = new Date(currYear, currMonth + 1, 0).getDate();
    let lastDayofMonth      = new Date(currYear, currMonth, lastDateofMonth).getDay();
    let lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate();

    let liTag = "";

    for (let i = firstDayofMonth; i > 0; i--) {

    for (let i = firstDayofMonth; i > 0; i--) {
        liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
    }
    for (let i = 1; i <= lastDateofMonth; i++) {
        let isToday = i === date.getDate() && currMonth === new Date().getMonth() && currYear === new Date().getFullYear() ? "active" : "";

    for (let i = 1; i <= lastDateofMonth; i++) {
        let isToday = i === date.getDate() && currMonth === new Date().getMonth()
                     && currYear === new Date().getFullYear() ? "active" : "";

        const month = String(currMonth + 1).padStart(2, '0');
        const day   = String(i).padStart(2, '0');

        liTag += `<li class="${isToday}" data-date="${currYear}-${month}-${day}">
            <div class="day-num">${i}</div>
            <div class="day-emoji" id="emoji-${currYear}-${month}-${day}"></div>
        </li>`;
    }
    for (let i = lastDayofMonth; i < 6; i++) {
        liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`;

    for (let i = lastDayofMonth; i < 6; i++) {
        liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`;
    }
    currentDate.innerText = `${months[currMonth]} ${currYear}`;

    currentDate.innerText = `${months[currMonth]} ${currYear}`;
    daysTag.innerHTML = liTag;
};
};

/**
 * Fetches mood data from the server and places emojis on the matching calendar cells.
 */
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
    const res  = await fetch("qanda/public_moods.php");
    const data = await res.json();

    for (let date in data) {
        const cell = document.getElementById("emoji-" + date);
        if (!cell) continue;

        let html = "";
        data[date].forEach(m => {
            html += `<span class="mood-emoji">${m.emoji}</span>`;
        });

        cell.innerHTML = html;
    }
}

/**
 * Redraws the calendar and reloads mood emojis. Called on page load and month change.
 */
function updateCalendar() {
    renderCalendar();
    loadMoods();
}

/**
 * Fetches and displays today's mood stats. If the user hasn't picked a mood yet,
 * shows a prompt instead of the stats table.
 */
async function loadStats() {
    const container = document.getElementById("mood-stats");
    if (!container) return;

    try {
        // 1. Check if the user has selected today.
        const checkRes = await fetch("qanda/get_today_mood.php");
        const userData = await checkRes.json();
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
    if (!userData.exists) {
        container.innerHTML = `
        <p style="color: red; text-align:center; font-size:20px">
            Select your mood to see stats
        </p>
        `;
        return;
    }

        // 3. If already selected -> Request today's full staff statistics
        const res = await fetch("qanda/get_today_stats.php");
        const data = await res.json();
        
        console.log("Stats data received:", data);
    const res   = await fetch("qanda/public_moods.php");
    const data  = await res.json();
    const today = new Date().toISOString().split("T")[0];

    let total = {};
    if (data[today]) {
        data[today].forEach(m => { total[m.emoji] = m.count; });
    }

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
    let html = `
    <h4>Today's Mood Stats</h4>
    <table class="stats-table">
        <tr><th>Mood</th><th># of People</th></tr>
    `;
    for (let e in total) {
        html += `<tr><td class="mood-emoji">${e}</td><td>${total[e]}</td></tr>`;
    }
    html += "</table>";

    container.innerHTML = html;
}

updateCalendar();
loadStats();

prevNextIcon.forEach(icon => {
    icon.addEventListener("click", () => {
prevNextIcon.forEach(icon => {
    icon.addEventListener("click", () => {
        currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;
        if (currMonth < 0 || currMonth > 11) {
            date = new Date(currYear, currMonth, new Date().getDate());
            currYear = date.getFullYear();
            currMonth = date.getMonth();

        // Roll over to the next or previous year if we go past December or before January
        if (currMonth < 0 || currMonth > 11) {
            date      = new Date(currYear, currMonth, new Date().getDate());
            currYear  = date.getFullYear();
            currMonth = date.getMonth();
        } else {
            date = new Date();
            date = new Date();
        }
        updateCalendar();

        updateCalendar();
    });
});