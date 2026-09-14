<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';

// admin access
if (!isset($_SESSION['user_id']) || (int)$_SESSION['is_admin'] !== 1) {
    header('Location: login.php');
    exit;
}

// Fetch all booking stats in a single query instead 
$stats = $pdo->query("
    SELECT
        COUNT(*) AS total,
        SUM(LOWER(status) = 'pending')  AS pending,
        SUM(LOWER(status) = 'approved') AS approved
    FROM bookings
")->fetch();

$total_count   = $stats['total'];
$pending_count = $stats['pending'];
$approved_count = $stats['approved'];


$sql = "
    SELECT 
        b.id,
        b.coach_name,
        b.price,
        b.booking_date,
        b.status,
        u.email AS user_email
    FROM bookings b
    LEFT JOIN users u ON b.user_id = u.id
    ORDER BY b.id DESC
";
$stmt = $pdo->query($sql);
$bookings = $stmt->fetchAll();
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

    <main style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">
        <h2 class="section-title" style="text-align: center; margin-bottom: 2rem;">ADMIN DASHBOARD</h2>

        <!-- STATS CARDS -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div class="stat-card">
                <h4>Total Bookings</h4>
                <span class="stat-value color-white"><?= $total_count; ?></span>
            </div>
            <div class="stat-card">
                <h4>Pending</h4>
                <span class="stat-value color-pending"><?= $pending_count; ?></span>
            </div>
            <div class="stat-card">
                <h4>Approved</h4>
                <span class="stat-value color-approved"><?= $approved_count; ?></span>
            </div>
        </div>

        <!-- BOOKINGS TABLE -->
        <div class="admin-table-wrap">
            <table style="width: 100%; border-collapse: collapse; text-align: left; min-width: 800px;">
                <thead>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.15); color: var(--text-muted, #8a8f99); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">
                        <th style="padding: 1rem;">User Email</th>
                        <th style="padding: 1rem;">Coach</th>
                        <th style="padding: 1rem; white-space: nowrap;">Date & Time</th>
                        <th style="padding: 1rem;">Price</th>
                        <th style="padding: 1rem;">Status</th>
                        <th style="padding: 1rem; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($bookings)): ?>
                        <tr>
                            <td colspan="6" style="padding: 2rem; text-align: center; color: var(--text-muted, #8a8f99);">No bookings found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($bookings as $b): 
                            $status = strtolower($b['status'] ?? 'pending');
                            $formatted_date = !empty($b['booking_date']) ? date('M j, Y - g:i A', strtotime($b['booking_date'])) : 'N/A';
                        ?>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                <td style="padding: 1rem; white-space: nowrap;"><?= htmlspecialchars($b['user_email'] ?? 'N/A'); ?></td>
                                <td style="padding: 1rem; font-weight: 600; color: #fff; white-space: nowrap;"><?= htmlspecialchars($b['coach_name'] ?? 'N/A'); ?></td>
                                <td style="padding: 1rem; color: #ffc107; white-space: nowrap;"><?= htmlspecialchars($formatted_date); ?></td>
                                <td style="padding: 1rem; white-space: nowrap;">₱<?= htmlspecialchars(number_format((float)($b['price'] ?? 0))); ?></td>
                                <td style="padding: 1rem; white-space: nowrap;">
                                    <span class="booking-status-pill <?= $status; ?>" style="padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.8rem; font-weight: 600; display: inline-block;">
                                        <?= ucfirst(htmlspecialchars($b['status'] ?? 'Pending')); ?>
                                    </span>
                                </td>
                                <td style="padding: 1rem; text-align: center; white-space: nowrap;">
                                    <div style="display: flex; gap: 0.4rem; justify-content: center; align-items: center;">
                                        <form action="update_status.php" method="POST" style="display:inline; margin:0;">
                                            <input type="hidden" name="id" value="<?= $b['id']; ?>">
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" style="background: #28a745; color: white; border: none; padding: 0.45rem 0.8rem; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 0.85rem;">Approve</button>
                                        </form>
                                        
                                        <form action="update_status.php" method="POST" style="display:inline; margin:0;">
                                            <input type="hidden" name="id" value="<?= $b['id']; ?>">
                                            <input type="hidden" name="action" value="cancel">
                                            <button type="submit" style="background: #dc3545; color: white; border: none; padding: 0.45rem 0.8rem; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 0.85rem;">Cancel</button>
                                        </form>

                                        <form action="update_status.php" method="POST" style="display:inline; margin:0;" onsubmit="return confirm('Remove this booking permanently?');">
                                            <input type="hidden" name="id" value="<?= $b['id']; ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <button type="submit" style="background: #6c757d; color: white; border: none; padding: 0.45rem 0.8rem; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 0.85rem;">Remove</button>
                                        </form>
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
