<?php
session_start();
require_once 'db.php';

// 1. Auth Guard: Redirect to login if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = '';
$error = '';

// 2. Read incoming parameters
$coach_name    = trim($_GET['coach'] ?? '');
$session_title = trim($_GET['session'] ?? '1-on-1 Coaching Session');
$price         = trim($_GET['price'] ?? '₱2,500');

if (empty($coach_name)) {
    header("Location: coaches.php");
    exit;
}

// 3. Find coach ID in database
$stmt = $pdo->prepare("SELECT id, name, image FROM coaches WHERE name = :name LIMIT 1");
$stmt->execute([':name' => $coach_name]);
$coach = $stmt->fetch();

if (!$coach) {
    // Fallback if exact name match isn't in seeded table
    $error = "Selected coach was not found in database.";
}

// 4. Handle Booking Confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $coach) {
    $user_id  = $_SESSION['user_id'];
    $coach_id = $coach['id'];

    $insertStmt = $pdo->prepare("INSERT INTO bookings (user_id, coach_id, session_title, price, status) VALUES (:user_id, :coach_id, :session_title, :price, 'Pending')");
    $inserted   = $insertStmt->execute([
        ':user_id'       => $user_id,
        ':coach_id'      => $coach_id,
        ':session_title' => $session_title,
        ':price'         => $price
    ]);

    if ($inserted) {
        $message = "Reservation confirmed! Your booking for $coach_name is now pending.";
    } else {
        $error = "Failed to submit booking. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Session - NightLock</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'nav.php'; ?>

    <main class="coaches-container" style="max-width: 550px; margin: 3rem auto;">
        <h2 class="section-title" style="text-align: center;">CONFIRM BOOKING</h2>

        <?php if ($error): ?>
            <div style="color: #ff4d4d; background: rgba(255,77,77,0.1); border: 1px solid #ff4d4d; padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem; text-align: center;">
                <p style="margin: 0;"><?= htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>

        <?php if ($message): ?>
            <div style="color: #4dff88; background: rgba(77,255,136,0.1); border: 1px solid #4dff88; padding: 1.5rem; border-radius: 8px; text-align: center;">
                <h3>🎉 Booking Successful!</h3>
                <p style="margin: 0.5rem 0 1.5rem 0; color: var(--text-muted);"><?= htmlspecialchars($message); ?></p>
                <a href="coaches.php" class="book-btn" style="text-decoration: none; padding: 0.6rem 1.2rem;">Back to Coaches</a>
            </div>
        <?php else: ?>
            <div style="background: var(--bg-card); padding: 2rem; border-radius: 8px; border: 1px solid var(--border-color);">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem;">
                    <?php if (!empty($coach['image'])): ?>
                        <img src="<?= htmlspecialchars($coach['image']); ?>" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid var(--accent-gold);">
                    <?php endif; ?>
                    <div>
                        <h3 style="margin: 0;"><?= htmlspecialchars($coach_name); ?></h3>
                        <span style="font-size: 0.85rem; color: var(--text-muted);">Deadlock Coach</span>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.8rem; font-size: 0.95rem; margin-bottom: 1.5rem;">
                    <div><strong>Session:</strong> <?= htmlspecialchars($session_title); ?></div>
                    <div><strong>Price:</strong> <span style="color: var(--accent-gold); font-weight: bold;"><?= htmlspecialchars($price); ?></span></div>
                    <div><strong>Logged in as:</strong> <?= htmlspecialchars($_SESSION['email']); ?></div>
                    <div><strong>Steam ID:</strong> <?= htmlspecialchars($_SESSION['steam_id']); ?></div>
                </div>

                <form action="book.php?coach=<?= urlencode($coach_name); ?>&session=<?= urlencode($session_title); ?>&price=<?= urlencode($price); ?>" method="POST">
                    <button type="submit" class="book-btn" style="width: 100%; padding: 0.8rem; border: none; cursor: pointer; font-size: 1rem;">Confirm & Reserve Session</button>
                </form>
            </div>
        <?php endif; ?>
    </main>

</body>
</html>