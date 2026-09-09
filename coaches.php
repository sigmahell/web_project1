<?php
$title = "Coaches - NightLock";
$description = "Learn from top-tier Deadlock players and pro coaches.";

// 1. Featured Coach (#1)
$featured_coach = [
    'rank' => '#1 Coach',
    'name' => 'Eixn',
    'rating' => '10.0',
    'tz' => 'GMT+3',
    'image' => 'images/john.jpg',
    'banner' => 'images/john.jpg',
    'bio' => 'I played professionally for years, competed at a high level, and won a lot of tournaments. Dedicated to elevating your gameplay.',
    'sessions' => [
        ['title' => '1-on-1 Coaching session', 'details' => '1 Session • 1.5 hrs', 'price' => '₱3,000'],
        ['title' => '2-Session Pack – Offer of the Month', 'details' => '2 Sessions • 3 hrs', 'price' => '₱5,500']
    ],
    'reviews' => [
        ['user' => 'Kin', 'time' => '8 days ago', 'text' => 'It is my first session and I already learned a lot. Looking forward to more hours.'],
        ['user' => 'Bakeran', 'time' => 'a month ago', 'text' => 'Really helped me understand the game better. Calm and informative approach.'],
        ['user' => 'Andre', 'time' => 'a month ago', 'text' => 'Jad is a very knowledgeable guy. High value insights!']
    ]
];

// 2. Pro Coaches (3-Column Grid)
$pro_coaches = [
    [
        'rank' => '2',
        'name' => 'AlexDota2',
        'community' => "AlexDota2's Community",
        'rating' => '10.0',
        'tz' => 'GMT+2',
        'image' => 'images/john.jpg',
        'banner' => 'images/john.jpg',
        'bio' => 'Professional & Structured coaching. Free consultation available to analyze your replay.',
        'session' => ['title' => 'Professional & Structured', 'details' => '3 Sessions • 3 hrs', 'price' => '₱3,500']
    ],
    [
        'rank' => '3',
        'name' => 'kicknay',
        'community' => "kicknay's Community",
        'rating' => '10.0',
        'tz' => 'GMT+2',
        'image' => 'images/john.jpg',
        'banner' => 'images/john.jpg',
        'bio' => "Hey, I'm Kicknay! High-MMR competitive player currently coaching for regional esports teams.",
        'session' => ['title' => 'Personalized 1-on-1 Replay', 'details' => '1 Session • 1 hr', 'price' => '₱600']
    ],
    [
        'rank' => '4',
        'name' => 'poloson',
        'community' => "poloson's Community",
        'rating' => '10.0',
        'tz' => 'GMT+8',
        'image' => 'images/john.jpg',
        'banner' => 'images/john.jpg',
        'bio' => 'Ex-Xtreme Gaming pro player. Hi everyone, I am poloson, ready to teach high-tier macro.',
        'session' => ['title' => '1 to 1 Coaching session', 'details' => '1 Session • 1 hr', 'price' => '₱2,300']
    ]
];
// 3. Community / List Coaches (Horizontal Rows)
$community_coaches = [
    [
        'rank' => '5',
        'name' => 'famousar3a',
        'rating' => '10.0',
        'tz' => 'GMT+3',
        'image' => 'images/john.jpg',
        'bio' => 'Unlock your full potential with a coach who has competed alongside the biggest names in the scene.',
        'packages' => [
            ['title' => 'First time coaching + free time', 'price' => '₱4,000'],
            ['title' => '3 Hours Package', 'price' => '₱5,400']
        ]
    ],
    [
        'rank' => '6',
        'name' => 'Khezu',
        'rating' => '9.9',
        'tz' => 'GMT+2',
        'image' => 'images/john.jpg',
        'bio' => "Hi I'm Khezu. I'm a professional player with 7+ years of top-level competitive experience.",
        'packages' => [
            ['title' => 'Replay review', 'price' => '₱4,500'],
            ['title' => 'Draft coaching + insights', 'price' => '₱17,000']
        ]
    ],
    [
        'rank' => '7',
        'name' => 'iAnnihilate',
        'rating' => '10.0',
        'tz' => 'GMT-4',
        'image' => 'images/john.jpg',
        'bio' => 'Competitive player known for high-tier lane dominance and aggressive pacing.',
        'packages' => [
            ['title' => 'Mid Laning Focus', 'price' => '₱2,300'],
            ['title' => 'Comprehensive Coaching', 'price' => '₱2,800']
        ]
    ],
    [
        'rank' => '8',
        'name' => 'SlashStrike',
        'rating' => '9.8',
        'tz' => 'GMT+3',
        'image' => 'images/john.jpg',
        'bio' => "Pro player here to enable you to get what you want out of this game effectively.",
        'packages' => [
            ['title' => 'Free Intro (15 mins)', 'price' => '₱0'],
            ['title' => 'Live Coaching', 'price' => '₱3,300'],
            ['title' => 'Ultimate Guide to Ranking UP', 'price' => '₱26,000']
        ]
    ]
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include 'nav.php'; ?>

    <main class="coaches-container">

        <!-- SECTION 1: FEATURED / #1 COACH -->
        <section class="coach-section">
            <h2 class="section-title">FEATURED COACH</h2>
            
            <div class="featured-card">
                <!-- Left: Profile Info -->
                <div class="featured-profile">
                    <span class="badge-number1"><?= $featured_coach['rank']; ?></span>
                    <img src="<?= $featured_coach['image']; ?>" alt="<?= $featured_coach['name']; ?>" class="featured-avatar">
                    <h3><?= $featured_coach['name']; ?></h3>
                    <div class="coach-meta">
                        <span>★ <?= $featured_coach['rating']; ?></span> • <span><?= $featured_coach['tz']; ?></span>
                    </div>
                </div>

                <!-- Middle: Bio & Sessions -->
                <div class="featured-details">
                    <div class="banner-crop">
                        <img src="<?= $featured_coach['banner']; ?>" alt="Banner">
                    </div>
                    <p class="featured-bio"><?= $featured_coach['bio']; ?></p>
                    
                    <div class="session-list">
                        <?php foreach ($featured_coach['sessions'] as $s): ?>
                            <div class="session-row">
                                <div>
                                    <strong><?= $s['title']; ?></strong>
                                    <div class="sub-text"><?= $s['details']; ?></div>
                                </div>
                                <div class="session-action">
                                    <span class="price-text"><?= $s['price']; ?></span>
                                    <a href="index.php?coach=<?= urlencode($featured_coach['name']); ?>&session=<?= urlencode($s['title']); ?>#contact" class="book-btn">
                                        Book
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Right: Reviews Panel -->
                <div class="featured-reviews">
                    <h4>RECENT REVIEWS</h4>
                    <?php foreach ($featured_coach['reviews'] as $rev): ?>
                        <div class="review-item">
                            <div class="review-header">
                                <span class="rev-rating">10</span>
                                <strong class="rev-user"><?= $rev['user']; ?></strong>
                                <span class="rev-time"><?= $rev['time']; ?></span>
                            </div>
                            <p><?= $rev['text']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

  <!-- SECTION 2: PRO COACHES GRID -->
<section class="coach-section">
    <h2 class="section-title">PRO COACHES</h2>
    
    <div class="pro-grid">
        <?php foreach ($pro_coaches as $coach): ?>
            <div class="pro-card">
                <div class="pro-card-header">
                    <img src="<?= $coach['banner']; ?>" class="pro-banner-img" alt="Banner">
                    <span class="rank-badge"><?= $coach['rank']; ?></span>
                </div>
                <div class="pro-card-body">
                    <div class="pro-user-row">
                        <img src="<?= $coach['image']; ?>" class="pro-avatar" alt="<?= $coach['name']; ?>">
                        <div>
                            <h4><?= $coach['name']; ?></h4>
                            <span class="sub-text"><?= $coach['community']; ?></span>
                        </div>
                    </div>
                    <div class="coach-meta" style="margin: 0.5rem 0;">
                        <span>★ <?= $coach['rating']; ?></span> • <span><?= $coach['tz']; ?></span>
                    </div>
                    <p class="pro-bio"><?= $coach['bio']; ?></p>
                    
                    <div class="session-row compact">
                        <div>
                            <strong><?= $coach['session']['title']; ?></strong>
                            <div class="sub-text"><?= $coach['session']['details']; ?></div>
                        </div>
                        <div class="session-action">
                            <span class="price-text"><?= $coach['session']['price']; ?></span>
                            <a href="index.php?coach=<?= urlencode($coach['name']); ?>&session=<?= urlencode($coach['session']['title']); ?>#contact" class="book-btn">
                                Book
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

        <!-- SECTION 3: COMMUNITY COACHES (ROWS) -->
         <!-- SECTION 3: COMMUNITY COACHES (ROWS) -->
<section class="coach-section">
    <h2 class="section-title">COMMUNITY COACHES</h2>
    
    <div class="community-list">
        <?php foreach ($community_coaches as $coach): ?>
            <div class="community-row">
                <div class="comm-rank"><?= $coach['rank']; ?></div>
                <img src="<?= $coach['image']; ?>" class="comm-avatar" alt="<?= $coach['name']; ?>">
                
                <div class="comm-main">
                    <div class="comm-header">
                        <h4><?= $coach['name']; ?></h4>
                        <span class="coach-meta">★ <?= $coach['rating']; ?> • <?= $coach['tz']; ?></span>
                    </div>
                    <p class="comm-bio"><?= $coach['bio']; ?></p>
                    
                    <div class="comm-packages">
                        <?php foreach ($coach['packages'] as $pkg): ?>
                            <div class="package-tag">
                                <span><?= $pkg['title']; ?></span>
                                <strong class="tag-price"><?= $pkg['price']; ?></strong>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="comm-action">
                    <a href="index.php?coach=<?= urlencode($coach['name']); ?>#contact" class="book-btn">
                        Book
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; <?= date("Y"); ?> NightLock. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>