<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';

// Redirect if not logged in or not an admin
if (!isset($_SESSION['user_id']) || (int)$_SESSION['is_admin'] !== 1) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['id'] ?? null;
    $action     = $_POST['action'] ?? null;

    if ($booking_id && $action) {
        try {
            if ($action === 'approve') {
                $stmt = $pdo->prepare("UPDATE bookings SET status = 'Approved' WHERE id = ?");
                $stmt->execute([$booking_id]);
            } elseif ($action === 'cancel') {
                $stmt = $pdo->prepare("UPDATE bookings SET status = 'Cancelled' WHERE id = ?");
                $stmt->execute([$booking_id]);
            } elseif ($action === 'delete') {
                $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
                $stmt->execute([$booking_id]);
            }
        } catch (PDOException $e) {
            die("Database update failed: " . $e->getMessage());
        }
    }
}

// Return back to admin dashboard
header("Location: admin-dashboard.php");
exit;