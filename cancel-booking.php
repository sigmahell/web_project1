<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $booking_id = intval($_POST['booking_id']);
    $user_id    = $_SESSION['user_id'];

    // Verify booking 
    $stmt = $pdo->prepare("SELECT id FROM bookings WHERE id = :id AND user_id = :user_id");
    $stmt->execute(['id' => $booking_id, 'user_id' => $user_id]);
    $booking = $stmt->fetch();

    if ($booking) {
        $updateStmt = $pdo->prepare("UPDATE bookings SET status = 'Cancelled' WHERE id = :id AND user_id = :user_id");
        $updateStmt->execute(['id' => $booking_id, 'user_id' => $user_id]);

        $_SESSION['success_message'] = "Booking #{$booking_id} has been cancelled successfully.";
    } else {
        $_SESSION['error_message'] = "Unable to cancel session. Booking not found.";
    }
}

header('Location: profile.php');
exit;
