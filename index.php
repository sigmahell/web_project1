<?php
$title = "NightLock";
$description = "Your Occult Tracker for Deadlock";

// randomizer for heros
srand(strtotime(date('Y-m-d')));

$s_tier_heroes = [
    ["name" => "Seven", "img" => "images/hero_icons/Seven_card.png"],
    ["name" => "Infernus", "img" => "images/hero_icons/Infernus_card.png"]
];
$a_tier_heroes = [
    ["name" => "Vindicta", "img" => "images/hero_icons/Vindicta_card.png"],
    ["name" => "Wraith", "img" => "images/hero_icons/Wraith_card.png"]
];
$b_tier_heroes = [
    ["name" => "Pocket", "img" => "images/hero_icons/Pocket_card.png"]
];

shuffle($s_tier_heroes);
shuffle($a_tier_heroes);
shuffle($b_tier_heroes);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'nav.php'; ?>

    <!-- Main content area -->
    <main> 
        <section id="title-card">
            <a href="index.php">
                <img src="images/logo2.png" alt="NightLock Logo">
            </a>

            <div>
                <h1>Welcome to NightLock</h1>
            </div>
            <div>
                <p>Your occult go-to resource for Deadlock match tracking, tier lists, and forbidden hero statistics. Uncover the truths hidden in the shadows.</p>
            </div>
            <button type="button" class="ent-button">ENTER THE ARCHIVE</button>
        </section>

        <!-- tier lists section -->
        <section id="tier-list">
            <h2>HERO TIER LIST</h2>
            <p>Check out tier lists for the best occult strategies in Deadlock.</p>

            <div class="tier-container">
                <div class="tier-hero tier-s">
                    <span class="tier-label">S TIER</span>
                    <div class="hero-items-container" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <?php foreach ($s_tier_heroes as $hero): ?>
                            <div class="hero-badge">
                                <img src="<?php echo $hero['img']; ?>" alt="<?php echo $hero['name']; ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="tier-hero tier-a">
                    <span class="tier-label">A TIER</span>
                    <div class="hero-items-container" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <?php foreach ($a_tier_heroes as $hero): ?>
                            <div class="hero-badge">
                                <img src="<?php echo $hero['img']; ?>" alt="<?php echo $hero['name']; ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="tier-hero tier-b">
                    <span class="tier-label">B TIER</span>
                    <div class="hero-items-container" style="display: flex; gap: 1rem; flex-wrap: wrap; ">
                        <?php foreach ($b_tier_heroes as $hero): ?>
                            <div class="hero-badge">
                                <img src="<?php echo $hero['img']; ?>" alt="<?php echo $hero['name']; ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <a href="tierlist.php" class="tier-button" style="text-decoration: none; display: inline-block;">VIEW FULL TIER LIST</a>
        </section>
                     
                   
        <!-- items and item builds section -->
        <section id="items">
            <h2>ITEMS AND ITEM BUILDS</h2>
            <div class="item-grid">
                <!-- Item 1 -->
                <div class="item-card">
                    <div class="item-header">
                        <img src="images/Split_Shot.png" alt="Split Shot Icon" class="item-icon">
                        <h3>Split Shot</h3>
                    </div>
                    <p>Make your weapon fire multishot. Hitting more than one Hero per attack will grant a stacking weapon damage bonus.</p>
                    <button type="button" class="build-button">VIEW BUILDS</button>
                </div>

                <!-- item 2 -->
                <div class="item-card">
                    <div class="item-header">
                        <img src="images/Indomitable.png" alt="Indomitable Icon" class="item-icon">
                        <h3>Indomitable</h3>
                    </div>
                    <p>The next Stun, Chain, Immobilize, Sleep or Silence is automatically cleansed. When this happens, you gain a barrier and all your ability cooldowns get reduced by 20%.</p>
                    <button type="button" class="build-button">VIEW BUILDS</button>
                </div>

                <!-- item 3 -->
                <div class="item-card">
                    <div class="item-header">
                        <img src="images/Spirit_Burn.png" alt="Spirit Burn Icon" class="item-icon">
                        <h3>Spirit Burn</h3>
                    </div>
                    <p>Dealing significant spirit damage to an enemy within 5s causes an explosion dealing damage and a burn to that enemy. While burning, enemies take damage over time and receive reduced healing.</p>
                    <button type="button" class="build-button">VIEW BUILDS</button>
                </div>
            </div>
        </section>
        <!-- Hire coaches section -->
        <section id="coach">
            <h2>HIRE PRO COACHES</h2>
            <div class="coach-grid">
                
                <div class="coach-card">
                    <img src="images/john.jpg" alt="JohnDoe" class="coach-image">
                    <div class="coach-content">
                        <h3>JohnDoe</h3>
                        <span class="coach-role">Top Tank Coach</span>
                        <p>Master and Learn advanced positioning and map awareness with me, defend and peel your team to victory.</p>
                        <button type="button" class="coach-button">BOOK SESSION</button>
                    </div>
                </div>

                <div class="coach-card">
                    <img src="images/jane.jpg" alt="JaneSmith" class="coach-image">
                    <div class="coach-content">
                        <h3>JaneSmith</h3>
                        <span class="coach-role">Top Support Coach</span>
                        <p>Master and Learn advanced positioning and map awareness with me. Heal and support your team to victory.</p>
                        <button type="button" class="coach-button">BOOK SESSION</button>
                    </div>
                </div>
                
            </div>
        </section>
        <!-- contacct -->
        <section id="contact">
            <h2>CONTACT US</h2>
            <p>Have questions or feedback? Reach out to us! Don't hesitate to get in touch.</p>
            <form method="post" action="index.php#contact">
                <input type="text" placeholder="Your Name/Alias" name="name" required>
                <input type="email" placeholder="Your Email" name="email" required>
                <textarea placeholder="INQUIRY" rows="5" name="message" required></textarea>
                <button type="submit">Submit</button>
            </form>
        </section>
    </main>

    <!-- footer -->
    <footer>
        <div class="footer-content">
            <p>&copy; <?php echo date("Y"); ?> NightLock. All rights reserved.</p>
            <p>NightLock is an independent community project and is not affiliated with Valve Corporation.</p>
            <div class="footer-links">
                <a href="#title-card">Back to Top ↑</a>
            </div>
        </div>
    </footer>

</body>
</html>