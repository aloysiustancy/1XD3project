/**
 * Name: Brian, Aloysius, Haoxuan, Jason
 * Date: March 21, 2026
 * Description: Handles the event creation form on the admin dashboard.
 *              Lets admins preview an image before uploading, and sends the
 *              new event data to the server on form submission.
 */

/**
 * Shows a preview of the selected image file in the upload area.
 *
 * @param {HTMLInputElement} input - The file input element
 */
function previewImage(input) {
    const preview     = document.getElementById('upload-preview');
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

/**
 * Clears the image preview and shows the upload placeholder again.
 */
function resetImagePreview() {
    const preview     = document.getElementById('upload-preview');
    const placeholder = document.getElementById('upload-placeholder');
    preview.src = '';
    preview.style.display = 'none';
    placeholder.style.display = 'flex';
}

/**
 * Sends the event form data to the server as a POST request.
 * Shows a toast on success or failure.
 *
 * @param {Event} e - The form submit event (used to prevent page refresh)
 */
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
        const res  = await fetch('api/addEvent.php', { method: 'POST', body: formData });
        const data = await res.json();
        if (data.error) throw new Error(data.error);
        showToast('Event created!');
        document.getElementById('event-form').reset();
        resetImagePreview();
    } catch (err) {
        showToast(err.message || 'Failed to create event.', true);
    } finally {
        btn.disabled = false;
        btn.textContent = 'SUBMIT';
    }
}