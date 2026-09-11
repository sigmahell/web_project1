<?php
session_start();
require_once 'db.php';

$error = '';    

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        // Fetch user record by email
        $stmt = $pdo->prepare("SELECT id, email, password_hash, steam_id FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        // Verify password hash
        if ($user && password_verify($password, $user['password_hash'])) {
            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            $_SESSION['user_id']  = $user['id'];
            $_SESSION['email']    = $user['email'];
            $_SESSION['steam_id'] = $user['steam_id'];

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
    <title>Login - NightLock</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <main class="coaches-container" style="max-width: 450px; margin: 3rem auto;">
        <h2>LOGIN TO YOUR ACCOUNT</h2>

        <?php if ($error): ?>
            <div style="color: #ff4d4d; background: rgba(255,0,0,0.1); padding: 0.75rem 1rem; border-radius: 6px; margin-bottom: 1rem;">
                <p style="margin: 0; font-size: 0.85rem;"><?= htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
            <div>
                <label style="font-size: 0.85rem; color: var(--text-muted);">Email Address</label>
                <input type="email" name="email" required style="width: 100%; padding: 0.75rem; border-radius: 4px; border: 1px solid var(--border-color); background: var(--bg-card); color: #fff;">
            </div>

            <div>
                <label style="font-size: 0.85rem; color: var(--text-muted);">Password</label>
                <input type="password" name="password" required style="width: 100%; padding: 0.75rem; border-radius: 4px; border: 1px solid var(--border-color); background: var(--bg-card); color: #fff;">
            </div>

            <button type="submit" class="book-btn" style="padding: 0.75rem; margin-top: 0.5rem; text-align: center;">Login</button>
        </form>
    </main>
</body>
</html>