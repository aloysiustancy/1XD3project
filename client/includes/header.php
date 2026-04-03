<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['userID']);
$isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true;
$current_page = basename($_SERVER['PHP_SELF'], ".php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>McMaster Mindfulness Club</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <nav id="nav">
        <a href="index.php" id="nav-logo">MMC</a>
        
        <div id="nav-links">
            <a href="index.php" class="nav-link <?php echo $current_page == 'index' ? 'active' : ''; ?>">Central Hub</a>
            <a href="community.html" class="nav-link <?php echo $current_page == 'community' ? 'active' : ''; ?>">Daily Vibe</a>
            <a href="resources.html" class="nav-link <?php echo $current_page == 'resources' ? 'active' : ''; ?>">Resources</a>
            
            <?php if ($isAdmin): ?>
                <a href="adminDashboard.html" class="nav-link">Admin</a>
            <?php endif; ?>
            
            <?php if ($isLoggedIn): ?>
                <a href="logout.php" class="nav-link">Logout</a>
            <?php else: ?>
                <a href="login.php" class="nav-link">Login</a>
            <?php endif; ?>
        </div>

        <div id="nav-social"></div>
    </nav>