<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isAdmin = isset($_SESSION['is_admin']) && (int)$_SESSION['is_admin'] === 1;
?>
<header>
    <!-- Brand Logo & Title -->
    <div class="brand"> 
        <a href="<?= $isAdmin ? 'admin-dashboard.php' : 'index.php'; ?>">
            <img src="images/logo.png" alt="NightLock Logo">
        </a>
        <h1>NIGHTLOCK</h1>
    </div>
            
    <!-- Main Navigation) -->
    <?php if (!$isAdmin): ?>
    <nav class="nav-links">
        <a href="index.php">HOME</a>
        <a href="tierlist.php">TIER LIST</a>
        <a href="index.php#items">ITEMS</a>
        <a href="coaches.php">COACHING</a>
        <a href="index.php#contact">CONTACT</a>
    </nav>
    <?php endif; ?>
            
    <!-- Dynamic Auth Buttons -->
    <div class="auth-buttons"> 
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if ($isAdmin): ?>
                <a href="admin-dashboard.php"><button type="button" id="login-btn">ADMIN DASHBOARD</button></a>
            <?php else: ?>
                <a href="profile.php"><button type="button" id="login-btn">MY PROFILE</button></a>
            <?php endif; ?>
            <a href="logout.php"><button type="button">LOGOUT</button></a>
        <?php else: ?>
            <a href="login.php"><button type="button" id="login-btn">LOGIN</button></a>
            <a href="register.php"><button type="button">REGISTER</button></a>
        <?php endif; ?>
    </div>
</header>
