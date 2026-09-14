<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';

$error = '';    

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT id, email, password_hash, steam_id, is_admin FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);

            $_SESSION['user_id']  = $user['id'];
            $_SESSION['email']    = $user['email'];
            $_SESSION['steam_id'] = $user['steam_id'];
            $_SESSION['is_admin'] = (int)($user['is_admin'] ?? 0);

            header("Location: coaches.php");
            exit;
        } else {
            $error = "Invalid email address or password.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NightLock</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'nav.php'; ?>

    <main class="coaches-container">
        <h2 class="section-title auth-title">LOGIN TO YOUR ACCOUNT</h2>

        <div class="auth-card">
            <?php if ($error): ?>
                <div class="alert-error"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label>EMAIL ADDRESS</label>
                    <input type="email" name="email" required placeholder="e.g. user@example.com">
                </div>

                <div class="form-group">
                    <label>PASSWORD</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit" class="book-btn">LOGIN NOW</button>
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