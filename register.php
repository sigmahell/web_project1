<?php
session_start();
require_once 'db.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Sanitization (Trim whitespaces and strip illegal characters)
    $email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $steam_id = trim($_POST['steam_id'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // 2. Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    // Steam64 ID validation: Must be exactly 17 numeric digits
    if (!preg_match('/^[0-9]{17}$/', $steam_id)) {
        $errors[] = "Steam ID must be a valid 17-digit Steam64 ID.";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    // 3. Database Integrity Check & Insertion
    if (empty($errors)) {
        // Check if email or Steam ID is already registered
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email OR steam_id = :steam_id LIMIT 1");
        $stmt->execute([':email' => $email, ':steam_id' => $steam_id]);

        if ($stmt->fetch()) {
            $errors[] = "An account with this email or Steam ID already exists.";
        } else {
            // Hash password securely
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user with PDO Prepared Statement
            $insertStmt = $pdo->prepare("INSERT INTO users (email, password_hash, steam_id) VALUES (:email, :password, :steam_id)");
            $inserted = $insertStmt->execute([
                ':email'    => $email,
                ':password' => $hashed_password,
                ':steam_id' => $steam_id
            ]);

            if ($inserted) {
                $success = "Registration successful! You can now log in.";
            } else {
                $errors[] = "Registration failed. Please try again later.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - NightLock</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'nav.php'; ?>

    <main class="coaches-container" style="max-width: 450px; margin: 3rem auto;">
        <h2 class="section-title" style="text-align: center;">CREATE ACCOUNT</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert-error">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert-success">
                <p><?= htmlspecialchars($success); ?></p>
                <a href="login.php" style="color: var(--accent-gold); display: inline-block; margin-top: 0.5rem; font-weight: bold;">Click here to Login</a>
            </div>
        <?php endif; ?>

        <form action="register.php" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem; background: var(--bg-card); padding: 2rem; border-radius: 8px; border: 1px solid var(--border-color);">
            <div class="form-col">
                <label>Email Address</label>
                <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>" required>
            </div>

            <div class="form-col">
                <label>Steam64 ID (17 Digits)</label>
                <input type="text" name="steam_id" maxlength="17" value="<?= htmlspecialchars($_POST['steam_id'] ?? ''); ?>" placeholder="e.g. 76561198000000000" required>
            </div>

            <div class="form-col">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-col">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required>
            </div>

            <button type="submit" class="book-btn" style="padding: 0.8rem; margin-top: 0.5rem; text-align: center; border: none; cursor: pointer;">Register Now</button>
        </form>
    </main>

</body>
</html>