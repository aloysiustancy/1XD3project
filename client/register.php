<?php include 'includes/header.php'; ?>

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
    }
    input:focus { outline: none; border-color: #4a90e2; }
    .error { background: #ffe0e0; color: #c0392b; padding: 0.6rem 0.8rem; border-radius: 5px; margin-bottom: 1rem; }
    .success { background: #e0f7e9; color: #27ae60; padding: 0.6rem 0.8rem; border-radius: 5px; margin-bottom: 1rem; }
    button {
        width: 100%; padding: 0.75rem; background: #4a90e2;
        color: #fff; border: none; border-radius: 5px; font-size: 1rem; cursor: pointer;
    }
    button:hover { background: #357abd; }
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

    <form method="POST" action="">
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
        </div>

        <div class="form-group">
            <label for="phoneNumber">Phone Number</label>
            <input type="tel" id="phoneNumber" name="phoneNumber"
                value="<?= htmlspecialchars($_POST['phoneNumber'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
        </div>

        <button type="submit">Create Account</button>
    </form>

    <p class="login-link">Already have an account? <a href="login.php">Log in</a></p>
</div>

<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        const pw  = document.getElementById('password').value;
        const cpw = document.getElementById('confirmPassword').value;
        if (pw !== cpw) {
            e.preventDefault();
            alert('Passwords do not match.');
        }
    });
</script>