<!-- /includes/header.php -->
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

    <nav id="nav">
        <a href="index.php" id="nav-logo">McMaster Mindfulness Club</a>
        
        <div id="nav-links">
            <a href="index.php" class="nav-link <?php echo $current_page == 'index' ? 'active' : ''; ?>">Home</a>
            <a href="community.php" class="nav-link <?php echo $current_page == 'community' ? 'active' : ''; ?>">Community</a>
            <a href="events.php" class="nav-link <?php echo $current_page == 'events' ? 'active' : ''; ?>">Events</a>
            <a href="members.php" class="nav-link <?php echo $current_page == 'members' ? 'active' : ''; ?>">Members</a>
            <a href="resources.php" class="nav-link <?php echo $current_page == 'resources' ? 'active' : ''; ?>">Resources</a>
        </div>
        
        <div id="nav-social">
            <a href="https://www.facebook.com/McMasterMindfulnessClub" target="_blank" aria-label="Facebook">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                </svg>
            </a>
            <a href="https://www.instagram.com/mcmastermindfulnessclub/" target="_blank" aria-label="Instagram">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                </svg>
            </a>
        </div>
    </nav>