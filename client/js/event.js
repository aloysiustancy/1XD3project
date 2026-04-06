/* ── Event Modal ── */

function openEventModal() {
    document.getElementById('event-modal-overlay').classList.add('open');
    document.getElementById('ev-name').focus();
}

function closeEventModal(e) {
    if (e && e.target !== document.getElementById('event-modal-overlay')) return;
    document.getElementById('event-modal-overlay').classList.remove('open');
    document.getElementById('event-form').reset();
    resetImagePreview();
}

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        document.getElementById('event-modal-overlay').classList.remove('open');
        document.getElementById('event-form').reset();
        resetImagePreview();
    }
});

/* ── Image preview ── */
function previewImage(input) {
    const preview = document.getElementById('upload-preview');
    const placeholder = document.getElementById('upload-placeholder');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function resetImagePreview() {
    const preview = document.getElementById('upload-preview');
    const placeholder = document.getElementById('upload-placeholder');
    preview.src = '';
    preview.style.display = 'none';
    placeholder.style.display = 'flex';
}

/* ── Submit event ── */
async function submitEvent(e) {
    e.preventDefault();

    const datetimeVal = document.getElementById('ev-datetime').value;
    const [eventDate, eventTime] = datetimeVal ? datetimeVal.split('T') : ['', ''];

    const formData = new FormData();
    formData.append('title',     document.getElementById('ev-name').value.trim());
    formData.append('eventDate', eventDate);
    formData.append('eventTime', eventTime || '');
    formData.append('location',  document.getElementById('ev-location').value.trim());

    const imageFile = document.getElementById('ev-image').files[0];
    if (imageFile) {
        formData.append('image', imageFile);
    }

    const btn = document.getElementById('btn-submit-event');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner"></span> Saving…';

    try {
        const res = await fetch('api/addEvent.php', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();
        if (data.error) throw new Error(data.error);
        showToast('Event created!');
        document.getElementById('event-modal-overlay').classList.remove('open');
        document.getElementById('event-form').reset();
        resetImagePreview();
    } catch (err) {
        showToast(err.message || 'Failed to create event.', true);
    } finally {
        btn.disabled = false;
        btn.textContent = 'SUBMIT';
    }
}
