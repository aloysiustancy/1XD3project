/**
 * Name: Brian, Aloysius, Haoxuan, Jason
 * Date: March 21, 2026
 * Description: Fetches the next upcoming event from the server and displays it
 *              on the home page with a live countdown timer (days, hours, minutes, seconds).
 */

document.addEventListener('DOMContentLoaded', function () {

    const titleEl      = document.getElementById('event-title');
    const timeEl       = document.getElementById('event-time');
    const locEl        = document.getElementById('event-location');
    const descEl       = document.getElementById('event-description');
    const countdownRow = document.getElementById('countdown-row');
    const cdDays       = document.getElementById('cd-days');
    const cdHours      = document.getElementById('cd-hours');
    const cdMins       = document.getElementById('cd-mins');
    const cdSecs       = document.getElementById('cd-secs');

    if (!countdownRow) return;

    fetch('api/getEvents.php')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                renderEvent(data.event, data.target);
            } else {
                if (titleEl) titleEl.textContent = 'No upcoming events';
                countdownRow.style.display = 'none';
            }
        })
        .catch(() => {
            if (titleEl) titleEl.textContent = 'Unable to load events';
            countdownRow.style.display = 'none';
        });

    /**
     * Fills in the event details on the page and starts the countdown timer.
     *
     * @param {Object} event      - Event object from the server (title, eventTime, location, etc.)
     * @param {String} targetDate - Event start datetime string (e.g. "2026-05-10 14:00:00")
     */
    function renderEvent(event, targetDate) {

        // Replace space with T so all browsers parse the date correctly
        const target = new Date(targetDate.replace(' ', 'T'));

        if (titleEl) titleEl.textContent = event.title       || '';
        if (timeEl)  timeEl.textContent  = event.eventTime   || '';
        if (locEl)   locEl.textContent   = event.location    || '';
        if (descEl)  descEl.textContent  = event.description || '';

        const dateObj = new Date(event.eventDate + 'T00:00:00');
        const monthEl = document.querySelector('#spotlight-date .month');
        const dayEl   = document.querySelector('#spotlight-date .day');
        const yearEl  = document.querySelector('#spotlight-date .year');
        if (monthEl) monthEl.textContent = dateObj.toLocaleString('default', { month: 'long' });
        if (dayEl)   dayEl.textContent   = dateObj.getDate();
        if (yearEl)  yearEl.textContent  = dateObj.getFullYear();

        /**
         * Recalculates the time remaining and updates the countdown numbers.
         */
        function update() {
            const diff = target - new Date();
            if (diff <= 0) {
                cdDays.textContent = cdHours.textContent = cdMins.textContent = cdSecs.textContent = '0';
                return;
            }
            cdDays.textContent  = Math.floor(diff / 86400000);
            cdHours.textContent = Math.floor((diff % 86400000) / 3600000);
            cdMins.textContent  = Math.floor((diff % 3600000)  / 60000);
            cdSecs.textContent  = Math.floor((diff % 60000)    / 1000);
        }

        update();
        setInterval(update, 1000);
    }

});