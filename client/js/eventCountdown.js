document.addEventListener('DOMContentLoaded', function () {
    console.log('eventCountdown.js loaded');

    const titleEl      = document.getElementById('event-title');
    const timeEl       = document.getElementById('event-time');
    const locEl        = document.getElementById('event-location');
    const descEl       = document.getElementById('event-description');
    const countdownRow = document.getElementById('countdown-row');
    const cdDays       = document.getElementById('cd-days');
    const cdHours      = document.getElementById('cd-hours');
    const cdMins       = document.getElementById('cd-mins');
    const cdSecs       = document.getElementById('cd-secs');

    console.log('Elements found:', {titleEl, timeEl, locEl, descEl, countdownRow, cdDays, cdHours, cdMins, cdSecs});

    if (!countdownRow) return; // only bail if the countdown itself is missing

    fetch('api/getEvents.php')
        .then(res => {
            console.log('Fetch response status:', res.status);
            return res.json();
        })
        .then(data => {
            console.log('API data:', data);
            if (data.success) {
                renderEvent(data.event, data.target);
            } else {
                console.log('No upcoming events');
                if (titleEl) titleEl.textContent = 'No upcoming events';
                countdownRow.style.display = 'none';
            }
        })
        .catch(err => {
            console.log('Fetch error:', err);
            if (titleEl) titleEl.textContent = 'Unable to load events';
            countdownRow.style.display = 'none';
        });

    function renderEvent(event, targetDate) {
        console.log('Rendering event:', event, 'targetDate:', targetDate);
        // Replace space with T so Safari and all browsers parse it correctly
        const target = new Date(targetDate.replace(' ', 'T'));
        console.log('Parsed target date:', target);

        if (titleEl) titleEl.textContent = event.title       || '';
        if (timeEl)  timeEl.textContent  = event.eventTime   || '';
        if (locEl)   locEl.textContent   = event.location    || '';
        if (descEl)  descEl.textContent  = event.description || '';

        // Update the left-panel date block
        const dateObj = new Date((event.eventDate + 'T00:00:00'));
        const monthEl = document.querySelector('#spotlight-date .month');
        const dayEl   = document.querySelector('#spotlight-date .day');
        const yearEl  = document.querySelector('#spotlight-date .year');
        if (monthEl) monthEl.textContent = dateObj.toLocaleString('default', { month: 'long' });
        if (dayEl)   dayEl.textContent   = dateObj.getDate();
        if (yearEl)  yearEl.textContent  = dateObj.getFullYear();

        function update() {
            const now = new Date();
            const diff = target - now;
            console.log('Update called, now:', now, 'target:', target, 'diff:', diff);
            if (diff <= 0) {
                cdDays.textContent = cdHours.textContent = cdMins.textContent = cdSecs.textContent = '0';
                return;
            }
            cdDays.textContent  = Math.floor(diff / 86400000);
            cdHours.textContent = Math.floor((diff % 86400000) / 3600000);
            cdMins.textContent  = Math.floor((diff % 3600000)  / 60000);
            cdSecs.textContent  = Math.floor((diff % 60000)    / 1000);
            console.log('Countdown updated:', cdDays.textContent, cdHours.textContent, cdMins.textContent, cdSecs.textContent);
        }

        update();
        setInterval(update, 1000);
    }
});