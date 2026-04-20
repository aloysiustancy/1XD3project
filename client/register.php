<?php
// Name: Brian, Aloysius, Haoxuan, Jason
// Date: March 21, 2026
// Registration page — handles new user sign-up with real-time validation for email, password strength, and confirmation

include 'includes/header.php';
?>

<style>
    .register-card {
        background: #fff;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 400px;
        margin: 4rem auto;
    }
    .form-row { display: flex; gap: 1rem; }
    .form-row .form-group { flex: 1; }
    .form-group { margin-bottom: 1rem; }
    label { display: block; margin-bottom: 0.4rem; font-size: 0.9rem; color: #555; }
    input {
        width: 100%; padding: 0.65rem 0.8rem;
        border: 1px solid #ccc; border-radius: 5px; font-size: 1rem;
        box-sizing: border-box; transition: border-color 0.2s;
    }
    input:focus   { outline: none; border-color: #4a90e2; }
    input.invalid { border-color: #e74c3c; }
    input.valid   { border-color: #27ae60; }
 
    .field-hint { font-size: 0.78rem; margin-top: 4px; min-height: 1.1em; }
    .field-hint.ok  { color: #27ae60; }
    .field-hint.err { color: #e74c3c; }
 
    .strength-bar-wrap { display: flex; gap: 4px; margin-top: 6px; }
    .strength-seg {
        flex: 1; height: 4px; border-radius: 2px;
        background: #e0e0e0; transition: background 0.3s;
    }
    .seg-weak   { background: #e74c3c; }
    .seg-fair   { background: #f39c12; }
    .seg-good   { background: #2ecc71; }
    .seg-strong { background: #27ae60; }
 
    .strength-label { font-size: 0.78rem; margin-top: 4px; font-weight: 500; min-height: 1.1em; }
 
    .error   { background: #ffe0e0; color: #c0392b; padding: 0.6rem 0.8rem; border-radius: 5px; margin-bottom: 1rem; }
    .success { background: #e0f7e9; color: #27ae60; padding: 0.6rem 0.8rem; border-radius: 5px; margin-bottom: 1rem; }
 
    button {
        width: 100%; padding: 0.75rem; background: #4a90e2;
        color: #fff; border: none; border-radius: 5px; font-size: 1rem;
        cursor: pointer; transition: background 0.2s;
    }
    button:hover    { background: #357abd; }
    button:disabled { background: #aac8ef; cursor: not-allowed; }
 
    .login-link { text-align: center; margin-top: 1rem; font-size: 0.9rem; color: #555; }
    .login-link a { color: #4a90e2; text-decoration: none; }
</style>
 
<div class="register-card">
    <h2>Create Account</h2>
 
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include 'addUser.php';
    }
    ?>
 
    <form method="POST" action="" id="registerForm" novalidate>
 
        <div class="form-row">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName"
                    value="<?= htmlspecialchars($_POST['firstName'] ?? '') ?>" required autofocus>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName"
                    value="<?= htmlspecialchars($_POST['lastName'] ?? '') ?>" required>
            </div>
        </div>
 
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            <div class="field-hint" id="emailHint"></div>
        </div>
 
        <div class="form-group">
            <label for="phoneNumber">Phone Number</label>
            <input type="tel" id="phoneNumber" name="phoneNumber"
                value="<?= htmlspecialchars($_POST['phoneNumber'] ?? '') ?>" required>
        </div>
 
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <div class="strength-bar-wrap" aria-hidden="true">
                <div class="strength-seg" id="seg1"></div>
                <div class="strength-seg" id="seg2"></div>
                <div class="strength-seg" id="seg3"></div>
                <div class="strength-seg" id="seg4"></div>
            </div>
            <div class="strength-label" id="strengthLabel"></div>
        </div>
 
        <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
            <div class="field-hint" id="confirmHint"></div>
        </div>
 
        <button type="submit" id="submitBtn">Create Account</button>
    </form>
 
    <p class="login-link">Already have an account? <a href="login.php">Log in</a></p>
</div>
 
<script>
(function () {
 
    /* ── DOM Elements ── */
    var emailEl       = document.getElementById('email');
    var emailHint     = document.getElementById('emailHint');
    var pwEl          = document.getElementById('password');
    var cpwEl         = document.getElementById('confirmPassword');
    var confirmHint   = document.getElementById('confirmHint');
    var segs          = ['seg1','seg2','seg3','seg4'].map(function(id){ return document.getElementById(id); });
    var strengthLabel = document.getElementById('strengthLabel');
    var form          = document.getElementById('registerForm');
 
    /**
     * Validates email format using regex and updates UI feedback
     * @returns {boolean} True if email is valid, false otherwise
     */
    function validateEmail() {
        var val = emailEl.value.trim();
        if (!val)               { setEmail('', '',      '');                             return false; }
        if (EMAIL_RE.test(val)) { setEmail('valid',   'ok',  'Looks good!');            return true;  }
        else                    { setEmail('invalid', 'err', 'Enter a valid email.');   return false; }
    }
 
    /**
     * Updates email field styling and hint message
     * @param {string} cls  - CSS class for field state ('valid', 'invalid', or '')
     * @param {string} hint - Hint class suffix ('ok', 'err', or '')
     * @param {string} msg  - Text to display in the hint element
     * @returns {void}
     */
    function setEmail(cls, hint, msg) {
        emailEl.className     = cls;
        emailHint.className   = 'field-hint ' + hint;
        emailHint.textContent = msg;
    }
 
    emailEl.addEventListener('input', validateEmail);
    emailEl.addEventListener('blur',  validateEmail);
 
    /* ── Password strength — AJAX ── */
    var debounceTimer = null;
    var lastScore = 0;
    var SEG_COLORS   = ['', 'seg-weak', 'seg-fair', 'seg-good', 'seg-strong'];
    var LABEL_COLORS = { 0: '#e74c3c', 1: '#e74c3c', 2: '#f39c12', 3: '#27ae60', 4: '#27ae60' };
    var EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
 
    /**
     * Updates password strength UI based on score from server
     * @param {number} score - Strength score 0-4 from check_password.php
     * @param {string} label - Human-readable label (e.g., "Weak", "Strong")
     * @returns {void}
     */
    function applyStrength(score, label) {
        lastScore = score;
        var color = SEG_COLORS[score];
        segs.forEach(function (seg, i) {
            seg.className = 'strength-seg';
            if (pwEl.value.length && i < score) seg.classList.add(color);
        });
        strengthLabel.textContent = pwEl.value.length ? label : '';
        strengthLabel.style.color = LABEL_COLORS[score] || '#e74c3c';
        validateConfirm();
    }
 
    /**
     * Fetches password strength score from server via AJAX
     * @returns {void}
     */
    function fetchStrength() {
        var pw = pwEl.value;
        if (!pw) { applyStrength(0, ''); return; }
 
        fetch('check_password.php', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify({ password: pw })
        })
        .then(function (res) { return res.json(); })
        .then(function (data) { applyStrength(data.score, data.label); })
        .catch(function () { /* silently fail — never block the user */ });
    }
 
    pwEl.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        if (pwEl.value.length < 6) { applyStrength(0, 'Too short'); return; }
        debounceTimer = setTimeout(fetchStrength, 350);
    });
 
    /**
     * Validates that password and confirmation match, updates UI
     * @returns {boolean} True if passwords match, false otherwise
     */
    function validateConfirm() {
        var pw  = pwEl.value;
        var cpw = cpwEl.value;
        if (!cpw) { confirmHint.textContent = ''; cpwEl.className = ''; return false; }
        if (pw === cpw) {
            cpwEl.className       = 'valid';
            confirmHint.className   = 'field-hint ok';
            confirmHint.textContent = 'Passwords match.';
            return true;
        } else {
            cpwEl.className       = 'invalid';
            confirmHint.className   = 'field-hint err';
            confirmHint.textContent = 'Passwords do not match.';
            return false;
        }
    }
 
    cpwEl.addEventListener('input', validateConfirm);
 
    /* ── Submit guard ── */
    form.addEventListener('submit', function (e) {
        var emailOk   = validateEmail();
        var confirmOk = validateConfirm();
 
        if (!emailOk) {
            e.preventDefault(); emailEl.focus(); return;
        }
        if (lastScore < 2) {
            e.preventDefault();
            strengthLabel.textContent = 'Please choose a stronger password.';
            strengthLabel.style.color = '#e74c3c';
            pwEl.focus(); return;
        }
        if (!confirmOk) {
            e.preventDefault(); cpwEl.focus();
        }
    });
 
}());
</script>

<?php include 'includes/footer.php'; ?>