<?php
session_start();

if (isset($_SESSION['userId'])) {
    header('Location: ' . ($_SESSION['isAdmin'] ? 'adminDashboard.php' : 'index.php'));
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conn = new mysqli("localhost", "tana42_local", "+im}Zbr.", "tana42_db");
    //$conn = new mysqli("localhost", "root", "", "caij95_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = trim($_POST['email']);
    $passwordInput = $_POST['password'];

    $sql = "SELECT u.userId, u.password, u.isAdmin
            FROM Users u
            JOIN UserInfo ui ON u.userId = ui.userId
            WHERE ui.email = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($passwordInput, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['userId']  = $user['userId'];
        $_SESSION['isAdmin'] = $user['isAdmin'];

        header('Location: ' . ($user['isAdmin'] ? 'adminDashboard.php' : 'index.php'));
        exit;
    } else {
        $error = "Invalid email or password.";
    }

    $stmt->close();
    $conn->close();
}

include 'includes/header.php'; // outputs <!DOCTYPE html>, <html>, <head>, <body>, and <nav>
?>

<style>
    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 70px);
        background: #f0f2f5;
    }

    .login-card {
        background: #fff;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 360px;
    }

    h2 {
        margin-bottom: 1.5rem;
        text-align: center;
        color: #333;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    label {
        display: block;
        margin-bottom: 0.4rem;
        font-size: 0.9rem;
        color: #555;
    }

    input {
        width: 100%;
        padding: 0.65rem 0.8rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
    }

    input:focus {
        outline: none;
        border-color: #4a90e2;
    }

    .error {
        background: #ffe0e0;
        color: #c0392b;
        padding: 0.6rem 0.8rem;
        border-radius: 5px;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .login-card button {
        width: 100%;
        padding: 0.75rem;
        background: #4a90e2;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        margin-top: 0.5rem;
    }

    .login-card button:hover {
        background: #357abd;
    }

    .register-link {
        text-align: center;
        margin-top: 1rem;
        font-size: 0.9rem;
        color: #555;
    }

    .register-link a {
        color: #4a90e2;
        text-decoration: none;
    }

    .register-link a:hover {
        text-decoration: underline;
    }
</style>

<div class="login-wrapper">
    <div class="login-card">
        <h2>Login</h2>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                    required
                    autofocus
                >
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Log In</button>

            <p class="register-link">
                Don't have an account? <a href="register.php">Register here</a>
            </p>
        </form>
    </div>
</div>

</body>
</html>