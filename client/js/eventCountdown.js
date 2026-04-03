document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('next-event-container');
    const titleEl = document.getElementById('event-title');
    const locEl = document.getElementById('event-location');
    const descEl = document.getElementById('event-description');
    const countdownEl = document.getElementById('countdown');
    
    if (!container) return;

    fetch('api/getEvents.php')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                renderEvent(data.event, data.target);
            } else {
                titleEl.textContent = "No upcoming events";
                countdownEl.style.display = 'none';
            }
        })
        .catch(() => {
            titleEl.textContent = "Unable to load events";
            countdownEl.style.display = 'none';
        });

    function renderEvent(event, targetDate) {
        const target = new Date(targetDate);
        
        titleEl.textContent = event.title;
        locEl.innerHTML = `<strong>Date:</strong> ${event.eventDate} | <strong>Location:</strong> ${event.location}`;
        if (descEl) descEl.textContent = event.description || '';

        function update() {
            const now = new Date();
            const diff = target - now;
            
            if (diff <= 0) {
                countdownEl.textContent = "Event starting now!";
                return;
            }
            
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const secs = Math.floor((diff % (1000 * 60)) / 1000);
            
            // This logic now ensures seconds are always included
            // Format: "2d 05h 12m 08s" or "05:12:08" if days are 0
            if (days > 0) {
                countdownEl.textContent = `${days}d ${hours}h ${mins}m ${secs}s`;
            } else {
                countdownEl.textContent = `${hours.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            }
        }
        
        update();
        setInterval(update, 1000); // 1000ms = 1 second
    }
});