<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch only the columns needed — avoids pulling sensitive data like password_hash
$userStmt = $pdo->prepare("SELECT id, email, steam_id FROM users WHERE id = :user_id");
$userStmt->execute(['user_id' => $user_id]);
$user = $userStmt->fetch();

// Resolve display name safely
$display_name = $user['username'] ?? $user['name'] ?? $user['full_name'] ?? (isset($user['email']) ? explode('@', $user['email'])[0] : 'User');

// Fetch user's bookings
$stmt = $pdo->prepare("SELECT * FROM bookings WHERE user_id = :user_id ORDER BY id DESC");
$stmt->execute(['user_id' => $user_id]);
$bookings = $stmt->fetchAll();

$success = $_SESSION['success_message'] ?? null;
$error   = $_SESSION['error_message'] ?? null;
unset($_SESSION['success_message'], $_SESSION['error_message']);

$initial = strtoupper(substr($display_name, 0, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - NightLock</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'nav.php'; ?>

    <main class="coaches-container">
        
        <!-- USER PROFILE ACCOUNT SUMMARY -->
        <h2 class="section-title">MY PROFILE</h2>
        <div class="profile-card">
            <div class="profile-avatar">
                <?= htmlspecialchars($initial); ?>
            </div>
            <div class="profile-info">
                <h3 style="margin-bottom: 0.5rem; font-size: 1.5rem;"><?= htmlspecialchars($display_name); ?></h3>
                
                <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 0.5rem;">
                    <!-- Simple Google/Email Integration -->
                    <a href="mailto:<?= htmlspecialchars($user['email']); ?>" style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(255,255,255,0.1); color: #fff; text-decoration: none; padding: 0.4rem 0.8rem; border-radius: 4px; font-size: 0.85rem; border: 1px solid rgba(255,255,255,0.2);">
                        📧 <?= htmlspecialchars($user['email'] ?? 'No email on file'); ?>
                    </a>

                    <!-- Simple Steam Integration -->
                    <?php if (!empty($user['steam_id'])): ?>
                    <a href="https://steamcommunity.com/profiles/<?= htmlspecialchars($user['steam_id']); ?>" target="_blank" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #171a21; color: #66c0f4; text-decoration: none; padding: 0.4rem 0.8rem; border-radius: 4px; font-size: 0.85rem; border: 1px solid #66c0f4; font-weight: bold;">
                        🎮 View Steam Profile
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- BOOKINGS SECTION -->
        <h2 class="section-title">MY BOOKINGS</h2>

        <?php if ($success): ?>
            <div class="alert-success"><?= htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert-error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (empty($bookings)): ?>
            <div class="auth-card">
                <p>You have no active coaching sessions booked yet.</p>
            </div>
        <?php else: ?>
            <div class="community-list">
                <?php foreach ($bookings as $b): 
                    $coach_display = $b['coach_name'] ?? $b['coach'] ?? 'Coach';
                    $is_cancelled  = (strtolower($b['status'] ?? '') === 'cancelled');
                    $date_formatted = !empty($b['booking_date']) ? date('M j, Y - g:i A', strtotime($b['booking_date'])) : null;
                ?>
                    <div class="booking-item-card">
                        <div>
                            <h4 class="booking-title"><?= htmlspecialchars($coach_display); ?></h4>
                            <div class="sub-text"><?= htmlspecialchars($b['session_title'] ?? $b['session'] ?? ''); ?></div>
                            
                            <?php if ($date_formatted): ?>
                                <div class="sub-text" style="color: var(--accent-gold); margin-top: 0.25rem;">
                                     <?= htmlspecialchars($date_formatted); ?>
                                </div>
                            <?php endif; ?>

                            <div class="price-text" style="margin-top: 0.4rem;">₱<?= htmlspecialchars(number_format((float)($b['price'] ?? 0))); ?></div>
                        </div>

                        <div class="booking-actions">
                            <span class="booking-status-pill <?= $is_cancelled ? 'cancelled' : ''; ?>">
                                <?= htmlspecialchars($b['status'] ?? 'Pending'); ?>
                            </span>

                            <?php if (!$is_cancelled): ?>
                                <form action="cancel-booking.php" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                    <input type="hidden" name="booking_id" value="<?= htmlspecialchars($b['id']); ?>">
                                    <button type="submit" class="btn-cancel">Cancel</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; <?= date("Y"); ?> NightLock. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>