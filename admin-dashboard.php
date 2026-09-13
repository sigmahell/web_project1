<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';

// Auth Guard: Require logged in user
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Admin Guard: Verify user is an admin
$stmt = $pdo->prepare("SELECT is_admin FROM users WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$currentUser = $stmt->fetch();

if (!$currentUser || (int)$currentUser['is_admin'] !== 1) {
    header('Location: profile.php');
    exit;
}

// Handle Action Requests (Approve / Cancel)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'], $_POST['action'])) {
    $booking_id = intval($_POST['booking_id']);
    $action     = $_POST['action'];

    $newStatus = ($action === 'approve') ? 'Confirmed' : (($action === 'cancel') ? 'Cancelled' : null);

    if ($newStatus) {
        $updateStmt = $pdo->prepare("UPDATE bookings SET status = :status WHERE id = :id");
        $updateStmt->execute(['status' => $newStatus, 'id' => $booking_id]);
        $_SESSION['success_message'] = "Booking #{$booking_id} status updated to {$newStatus}.";
    }
    header('Location: admin-dashboard.php');
    exit;
}

// Fetch all bookings joined with user info
$bookingsStmt = $pdo->query("
    SELECT b.*, u.email 
    FROM bookings b 
    LEFT JOIN users u ON b.user_id = u.id 
    ORDER BY b.id DESC
");
$allBookings = $bookingsStmt->fetchAll();

// Calculate Stats
$totalBookings   = count($allBookings);
$pendingBookings = 0;
$totalRevenue    = 0;

foreach ($allBookings as $b) {
    $status = strtolower($b['status'] ?? '');
    if ($status === 'pending') {
        $pendingBookings++;
    }
    if ($status === 'confirmed') {
        // Strip non-numeric currency characters for revenue total
        $numericPrice = floatval(preg_replace('/[^\d.]/', '', $b['price'] ?? '0'));
        $totalRevenue += $numericPrice;
    }
}

$success = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - NightLock</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'nav.php'; ?>

    <main class="coaches-container">
        <h2 class="section-title">ADMIN DASHBOARD</h2>

        <?php if ($success): ?>
            <div class="alert-success"><?= htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <!-- OVERVIEW STATS -->
        <div class="admin-stats-grid">
            <div class="stat-card">
                <div>Total Sessions</div>
                <div class="stat-number"><?= $totalBookings; ?></div>
            </div>
            <div class="stat-card">
                <div>Pending Actions</div>
                <div class="stat-number"><?= $pendingBookings; ?></div>
            </div>
            <div class="stat-card">
                <div>Confirmed Revenue</div>
                <div class="stat-number">₱<?= number_format($totalRevenue, 2); ?></div>
            </div>
        </div>

        <!-- RECENT BOOKINGS TABLE -->
        <h2 class="section-title">BOOKING NOTIFICATIONS & MANAGEMENT</h2>
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Email</th>
                        <th>Coach</th>
                        <th>Session</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($allBookings)): ?>
                        <tr>
                            <td colspan="7">No bookings found in database.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($allBookings as $b): 
                            $coach_name = $b['coach_name'] ?? $b['coach'] ?? 'Coach';
                            $status     = $b['status'] ?? 'Pending';
                            $status_lc  = strtolower($status);
                        ?>
                            <tr>
                                <td>#<?= htmlspecialchars($b['id']); ?></td>
                                <td><?= htmlspecialchars($b['email'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($coach_name); ?></td>
                                <td><?= htmlspecialchars($b['session_title'] ?? $b['session'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($b['price'] ?? ''); ?></td>
                                <td>
                                    <span class="booking-status-pill <?= $status_lc === 'cancelled' ? 'cancelled' : ''; ?>">
                                        <?= htmlspecialchars($status); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="admin-action-group">
                                        <?php if ($status_lc !== 'confirmed'): ?>
                                            <form method="POST" action="admin-dashboard.php">
                                                <input type="hidden" name="booking_id" value="<?= htmlspecialchars($b['id']); ?>">
                                                <input type="hidden" name="action" value="approve">
                                                <button type="submit" class="btn-approve">Approve</button>
                                            </form>
                                        <?php endif; ?>

                                        <?php if ($status_lc !== 'cancelled'): ?>
                                            <form method="POST" action="admin-dashboard.php">
                                                <input type="hidden" name="booking_id" value="<?= htmlspecialchars($b['id']); ?>">
                                                <input type="hidden" name="action" value="cancel">
                                                <button type="submit" class="btn-cancel">Cancel</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; <?= date("Y"); ?> NightLock. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>