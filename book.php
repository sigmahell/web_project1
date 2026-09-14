<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Extract parameters from GET or POST
$coach_name    = trim($_GET['coach'] ?? $_POST['coach'] ?? '');
$session_title = trim($_GET['session'] ?? $_POST['session'] ?? '');
$booking_date  = $_POST['booking_date'] ?? null;

if (empty($coach_name) || empty($session_title)) {
    header("Location: coaches.php");
    exit;
}

// Fetch the real price from the DB — never trust client-supplied price
$priceStmt = $pdo->prepare("
    SELECT s.price
    FROM coach_sessions s
    JOIN coaches c ON s.coach_id = c.id
    WHERE c.name = :coach AND s.title = :session
    LIMIT 1
");
$priceStmt->execute([':coach' => $coach_name, ':session' => $session_title]);
$price = $priceStmt->fetchColumn();

// If no matching session found, redirect back to coaches
if ($price === false) {
    header("Location: coaches.php");
    exit;
}

// Strip non-numeric characters for storage (price may include ₱ symbol)
$price = preg_replace('/[^0-9.]/', '', $price);

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($booking_date)) {

    // Server-side date validation — HTML min attribute can be bypassed via DevTools
    if (strtotime($booking_date) < time()) {
        $booking_error = "Please select a future date and time for your booking.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO bookings (user_id, coach_name, session_title, price, booking_date, status) VALUES (:user_id, :coach, :session, :price, :booking_date, 'Pending')");
            $stmt->execute([
                ':user_id'      => $_SESSION['user_id'],
                ':coach'        => $coach_name,
                ':session'      => $session_title,
                ':price'        => $price,
                ':booking_date' => $booking_date
            ]);

            $_SESSION['success_message'] = "Booking submitted successfully!";
            header("Location: profile.php");
            exit;
        } catch (PDOException $e) {
            die("Booking failed: " . $e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Booking - NightLock</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'nav.php'; ?>

    <main class="coaches-container">
        <h2 class="section-title auth-title">SCHEDULE YOUR SESSION</h2>
        
        <div class="auth-card">
            <?php if (!empty($booking_error)): ?>
                <div class="alert-error"><?= htmlspecialchars($booking_error); ?></div>
            <?php endif; ?>
            <div style="margin-bottom: 1.5rem;">
                <h3 style="color: var(--accent-gold); margin-bottom: 0.5rem;"><?= htmlspecialchars($coach_name); ?></h3>
                <p style="color: var(--text-muted); font-size: 0.9rem;"><?= htmlspecialchars($session_title); ?></p>
                <p class="price-text" style="margin-top: 0.5rem; font-size: 1.2rem;">₱<?= htmlspecialchars(number_format((float)$price)); ?></p>
            </div>

            <form method="POST" action="book.php">
                <input type="hidden" name="coach" value="<?= htmlspecialchars($coach_name); ?>">
                <input type="hidden" name="session" value="<?= htmlspecialchars($session_title); ?>">
                <!-- price is fetched from the DB server-side; no longer passed via form -->

                <div class="form-group">
                    <label for="booking_date">Select Date & Time</label>
                    <input 
                        type="datetime-local" 
                        id="booking_date" 
                        name="booking_date" 
                        min="<?= date('Y-m-d\TH:i'); ?>" 
                        required>
                </div>

                <button type="submit" class="book-btn" style="width: 100%; border: none; font-size: 0.9rem; padding: 0.75rem;">Confirm & Book</button>
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