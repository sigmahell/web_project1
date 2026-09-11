<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <!-- Brand Logo & Title -->
    <div class="brand"> 
        <a href="index.php">
            <img src="images/logo.png" alt="NightLock Logo">
        </a>
        <h1>NIGHTLOCK</h1>
    </div>
            
    <!-- Main Navigation -->
    <nav class="nav-links">
        <a href="index.php">HOME</a>
        <a href="tierlist.php">TIER LIST</a>
        <a href="index.php#items">ITEMS</a>
        <a href="coaches.php">COACHING</a>
        <a href="index.php#contact">CONTACT</a>
    </nav>
            
    <!-- Dynamic Auth Buttons -->
    <div class="auth-buttons"> 
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="my-bookings.php"><button type="button" id="login-btn">MY BOOKINGS</button></a>
            <a href="logout.php"><button type="button">LOGOUT</button></a>
        <?php else: ?>
            <a href="login.php"><button type="button" id="login-btn">LOGIN</button></a>
            <a href="register.php"><button type="button">REGISTER</button></a>
        <?php endif; ?>
    </div>
</header>