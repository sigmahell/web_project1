<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';
$title = "Coaches - NightLock";
$description = "Learn from the best Deadlock players.";

// Fetch coaches and their sessions from MySQL
$sql = "
    SELECT 
        c.id AS coach_id, c.name, c.rating, c.image, c.bio,
        s.title AS session_title, s.price AS session_price
    FROM coaches c
    LEFT JOIN coach_sessions s ON c.id = s.coach_id
    ORDER BY c.id ASC
";
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll();

// Group DB rows into structured coach arrays
$coaches = [];
foreach ($rows as $row) {
    $id = $row['coach_id'];
    if (!isset($coaches[$id])) {
        $coaches[$id] = [
            'id'       => $row['coach_id'],
            'name'     => $row['name'],
            'rating'   => $row['rating'],
            'image'    => $row['image'],
            'bio'      => $row['bio'],
            'sessions' => []
        ];
    }
    if ($row['session_title']) {
        $coaches[$id]['sessions'][] = [
            'title' => $row['session_title'],
            'price' => $row['session_price']
        ];
    }
}

// Separate coaches into display tiers
$coach_list        = array_values($coaches);
$featured_coach    = $coach_list[0] ?? null;
$pro_coaches       = array_slice($coach_list, 1, 3);
$community_coaches = array_slice($coach_list, 4);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coaches - NightLock</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'nav.php'; ?>

    <main class="coaches-container">
        
        <!-- SECTION 1: FEATURED COACH -->
        <?php if ($featured_coach): ?>
        <section>
            <h2 class="section-title">FEATURED COACH</h2>
            <div class="featured-card">
                <div class="featured-profile">
                    <span class="badge-number1">#1</span>
                    <img src="<?= htmlspecialchars($featured_coach['image']); ?>" alt="<?= htmlspecialchars($featured_coach['name']); ?>" class="featured-avatar">
                    <h3><?= htmlspecialchars($featured_coach['name']); ?></h3>
                    <div class="coach-meta">Rating: ★ <?= htmlspecialchars($featured_coach['rating']); ?></div>
                </div>

                <div class="featured-details">
                    <p class="featured-bio"><?= htmlspecialchars($featured_coach['bio']); ?></p>
                    <div class="session-list">
                        <?php foreach ($featured_coach['sessions'] as $s): ?>
                            <div class="session-row">
                                <div>
                                    <strong><?= htmlspecialchars($s['title']); ?></strong>
                                    <div class="sub-text">Includes live feedback & chat summary</div>
                                </div>
                                <div class="session-action">
                                    <span class="price-pill"><?= htmlspecialchars($s['price']); ?></span>
                                    <a href="book.php?coach=<?= urlencode($featured_coach['name']); ?>&session=<?= urlencode($s['title']); ?>&price=<?= urlencode($s['price']); ?>" class="book-btn">Book</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="featured-reviews">
                    <h4>STUDENT REVIEWS</h4>
                    <div class="review-item">
                        <div class="review-header">
                            <span class="rev-rating">★ 10.0</span>
                            <span class="rev-user">Viper_Deadlock</span>
                            <span class="rev-time">2 days ago</span>
                        </div>
                        <p>OHDM helped me fix my lane positioning instantly. Unlocked 2K MMR gain in 2 weeks!</p>
                    </div>
                    <div class="review-item">
                        <div class="review-header">
                            <span class="rev-rating">★ 10.0</span>
                            <span class="rev-user">SoulCollector</span>
                            <span class="rev-time">1 week ago</span>
                        </div>
                        <p>Incredible macro advice. Taught me exactly when to force mid bosses.</p>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- SECTION 2: PRO COACHES -->
        <section>
            <h2 class="section-title">PRO COACHES</h2>
            <div class="pro-grid">
                <?php foreach ($pro_coaches as $index => $coach): 
                    $session = $coach['sessions'][0] ?? ['title' => 'Session', 'price' => '₱0'];
                ?>
                    <div class="pro-card">
                        <div class="pro-card-header">
                            <img src="images/background.png" class="pro-banner-img" alt="Card Banner">
                            <span class="rank-badge">#<?= $index + 2; ?></span>
                        </div>
                        <div class="pro-card-body">
                            <div class="pro-user-row">
                                <img src="<?= htmlspecialchars($coach['image']); ?>" class="pro-avatar" alt="<?= htmlspecialchars($coach['name']); ?>">
                                <div>
                                    <h3 class="pro-card-title"><?= htmlspecialchars($coach['name']); ?></h3>
                                    <span class="pro-card-rating">★ <?= htmlspecialchars($coach['rating']); ?></span>
                                </div>
                            </div>
                            <p class="pro-bio"><?= htmlspecialchars($coach['bio']); ?></p>
                            <div class="session-row compact">
                                <div>
                                    <div class="compact-session-title"><?= htmlspecialchars($session['title']); ?></div>
                                    <span class="price-text"><?= htmlspecialchars($session['price']); ?></span>
                                </div>
                                <a href="book.php?coach=<?= urlencode($coach['name']); ?>&session=<?= urlencode($session['title']); ?>&price=<?= urlencode($session['price']); ?>" class="book-btn">Book</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- SECTION 3: HIGH-RANK COACHES -->
        <section>
            <h2 class="section-title">HIGH-RANK COACHES</h2>
            <div class="community-list">
                <?php foreach ($community_coaches as $index => $coach): 
                    $session = $coach['sessions'][0] ?? ['title' => 'Session', 'price' => '₱0'];
                ?>
                    <div class="community-row">
                        <span class="comm-rank">#<?= $index + 5; ?></span>
                        <img src="<?= htmlspecialchars($coach['image']); ?>" class="comm-avatar" alt="<?= htmlspecialchars($coach['name']); ?>">
                        <div class="comm-main">
                            <div class="comm-header">
                                <h4><?= htmlspecialchars($coach['name']); ?></h4>
                                <span class="comm-rating">★ <?= htmlspecialchars($coach['rating']); ?></span>
                            </div>
                            <p class="comm-bio"><?= htmlspecialchars($coach['bio']); ?></p>
                            <div class="comm-packages">
                                <div class="package-tag">
                                    <span><?= htmlspecialchars($session['title']); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="comm-action">
                            <span class="price-text"><?= htmlspecialchars($session['price']); ?></span>
                            <a href="book.php?coach=<?= urlencode($coach['name']); ?>&session=<?= urlencode($session['title']); ?>&price=<?= urlencode($session['price']); ?>" class="book-btn">Book</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <p>&copy; <?= date("Y"); ?> NightLock. All rights reserved.</p>
            <p>NightLock is an independent community project and is not affiliated with Valve Corporation.</p>
        </div>
    </footer>

</body>
</html>
