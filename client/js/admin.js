/* ── Admin Modal ── */

function openAdminModal() {
    document.getElementById('admin-modal-overlay').classList.add('open');
    document.getElementById('adm-first').focus();
}

function closeAdminModal(e) {
    if (e && e.target !== document.getElementById('admin-modal-overlay')) return;
    document.getElementById('admin-modal-overlay').classList.remove('open');
    document.getElementById('admin-form').reset();
    document.getElementById('adm-pw-error').style.display = 'none';
}

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        document.getElementById('admin-modal-overlay').classList.remove('open');
        document.getElementById('admin-form').reset();
        document.getElementById('adm-pw-error').style.display = 'none';
    }
});

/* ── Submit admin ── */
async function submitAdmin(e) {
    e.preventDefault();

    const password = document.getElementById('adm-password').value;
    const confirm  = document.getElementById('adm-confirm').value;
    const pwError  = document.getElementById('adm-pw-error');

    if (password !== confirm) {
        pwError.style.display = 'block';
        document.getElementById('adm-confirm').focus();
        return;
    }
    pwError.style.display = 'none';

    const payload = {
        firstName:   document.getElementById('adm-first').value.trim(),
        lastName:    document.getElementById('adm-last').value.trim(),
        email:       document.getElementById('adm-email').value.trim(),
        phoneNumber: document.getElementById('adm-phone').value.trim(),
        password:    password
    };

    const btn = document.getElementById('btn-submit-admin');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner"></span> Creating…';

    try {
        const res = await fetch('addAdmin.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });
        const data = await res.json();
        if (data.error) throw new Error(data.error);
        showToast('Admin account created!');
        document.getElementById('admin-modal-overlay').classList.remove('open');
        document.getElementById('admin-form').reset();
    } catch (err) {
        showToast(err.message || 'Failed to create admin.', true);
    } finally {
        btn.disabled = false;
        btn.textContent = 'SUBMIT';
    }
}
