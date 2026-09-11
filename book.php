<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$coach_name    = $_GET['coach'] ?? 'Unknown Coach';
$session_title = $_GET['session'] ?? 'Coaching Session';
$price         = $_GET['price'] ?? '₱0';

// Handle booking confirmation POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    
    $stmt = $pdo->prepare("
        INSERT INTO bookings (user_id, coach_name, session_title, price, status) 
        VALUES (:user_id, :coach, :session, :price, 'Confirmed')
    ");
    
    $stmt->execute([
        'user_id' => $user_id,
        'coach'   => $coach_name,
        'session' => $session_title,
        'price'   => $price
    ]);

    $_SESSION['success_message'] = "Booking confirmed! Your session with {$coach_name} is scheduled.";
    header('Location: profile.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Booking - NightLock</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'nav.php'; ?>

    <main class="coaches-container">
        <h2 class="section-title">CONFIRM BOOKING</h2>

        <div class="auth-card">
            <form method="POST" action="">
                <div class="booking-summary-details">
                    <h3>Coaching Session Overview</h3>
                    <p><strong>Coach:</strong> <?= htmlspecialchars($coach_name); ?></p>
                    <p><strong>Session:</strong> <?= htmlspecialchars($session_title); ?></p>
                    <p><strong>Total Price:</strong> <?= htmlspecialchars($price); ?></p>
                </div>

                <div class="booking-confirm-actions">
                    <button type="submit" class="book-btn">Confirm Session</button>
                    <a href="index.php" class="btn-cancel">Back to Home</a>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; <?= date("Y"); ?> NightLock. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>