const daysTag = document.querySelector(".days"),
currentDate = document.querySelector(".current-date"),
prevNextIcon = document.querySelectorAll(".icons span");
// getting new date, current year and month
let date = new Date(),
currYear = date.getFullYear(),
currMonth = date.getMonth();
// storing full name of all months in array
const months = ["January", "February", "March", "April", "May", "June", "July",
              "August", "September", "October", "November", "December"];
const renderCalendar = () => {
    let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(), // getting first day of month
    lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(), // getting last date of month
    lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(), // getting last day of month
    lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // getting last date of previous month
    let liTag = "";
    for (let i = firstDayofMonth; i > 0; i--) { // creating li of previous month last days
        liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
    }
    for (let i = 1; i <= lastDateofMonth; i++) { // creating li of all days of current month
        // adding active class to li if the current day, month, and year matched
        let isToday = i === date.getDate() && currMonth === new Date().getMonth() 
                     && currYear === new Date().getFullYear() ? "active" : "";
        
        const month = String(currMonth + 1).padStart(2, '0');
        const day = String(i).padStart(2, '0');

        liTag += `
        <li class="${isToday}" data-date="${currYear}-${month}-${day}">
            <div class="day-num">${i}</div>
            <div class="day-emoji" id="emoji-${currYear}-${month}-${day}"></div>
        </li>`;
    }
    for (let i = lastDayofMonth; i < 6; i++) { // creating li of next month first days
        liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`
    }
    currentDate.innerText = `${months[currMonth]} ${currYear}`; // passing current mon and yr as currentDate text
    daysTag.innerHTML = liTag;
}

async function loadMoods() {
    const res = await fetch("QandA/public_moods.php");
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

function updateCalendar() {
    renderCalendar();
    loadMoods();
}

async function loadStats() {

    const container = document.getElementById("mood-stats");

    // 1. First ask the backend: Did I make a selection today?
    const checkRes = await fetch("QandA/get_today_mood.php");
    const userData = await checkRes.json();

    // Not selected → Not displayed
    if (!userData.exists) {
        container.innerHTML = `
        <p style="color: red; text-align:center; font-size:20px">
            Select your mood to see stats
        </p>
        `;
        return;
    }

    // 2. Statistics will only load after selection →
    const res = await fetch("QandA/public_moods.php");
    const data = await res.json();

    const today = new Date().toISOString().split("T")[0];

    let total = {};

    if (data[today]) {
        data[today].forEach(m => {
            total[m.emoji] = m.count;
        });
    }

    let html = `
    <h4>Today's Mood Stats</h4>
    <table class="stats-table">
        <tr>
            <th>Mood</th>
            <th># of People</th>
        </tr>
    `;

    for (let e in total) {
        html += `
        <tr>
            <td class="mood-emoji">${e}</td>
            <td>${total[e]}</td>
        </tr>`;
    }

    html += "</table>";

    container.innerHTML = html;
}

// Called after render
updateCalendar();
loadStats();

prevNextIcon.forEach(icon => { // getting prev and next icons
    icon.addEventListener("click", () => { // adding click event on both icons
        // if clicked icon is previous icon then decrement current month by 1 else increment it by 1
        currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;
        if(currMonth < 0 || currMonth > 11) { // if current month is less than 0 or greater than 11
            // creating a new date of current year & month and pass it as date value
            date = new Date(currYear, currMonth, new Date().getDate());
            currYear = date.getFullYear(); // updating current year with new date year
            currMonth = date.getMonth(); // updating current month with new date month
        } else {
            date = new Date(); // pass the current date as date value
        }
        updateCalendar(); // calling renderCalendar function
    });
});