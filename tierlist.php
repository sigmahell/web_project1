<?php




$title = "Tier List - NightLock";
$description = "Discover the best occult strategies and hero rankings in Deadlock.";



srand(strtotime(date('Y-m-d')));

// heroes array goes here
$s_tier_heroes = [
    ["name" => "Seven", "img" => "images/hero_icons/Seven_card.png"],
    ["name" => "Infernus", "img" => "images/hero_icons/Infernus_card.png"]
];
$a_tier_heroes = [
    ["name" => "Vindicta", "img" => "images/hero_icons/Vindicta_card.png"],
    ["name" => "Wraith", "img" => "images/hero_icons/Wraith_card.png"],
    ["name"=> "Infernus", "img" => "images/hero_icons/Graves_card.png"]
];


// Shuffle 
shuffle($s_tier_heroes);
shuffle($a_tier_heroes);

?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo $description; ?>">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'nav.php'; ?>
    
    <main>
        <section id="tier-list"> 
            <h2>HERO TIER LIST</h2>
            <p>Explore the latest tier lists for Deadlock heroes.</p>
            
            <div class="tier-container-rows">
                <!-- S TIER -->
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

                <!-- A TIER -->
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

                <!-- B TIER -->
                <div class="tier-hero tier-b">
                    <span class="tier-label">B TIER</span>
                            
                    <div class="hero-items-container" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <?php foreach ($a_tier_heroes as $hero): ?>
                            <div class="hero-badge">
                                <img src="<?php echo $hero['img']; ?>" alt="<?php echo $hero['name']; ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- C TIER -->
                <div class="tier-hero tier-c">
                    <span class="tier-label">C TIER</span>
                   
                    <div class="hero-items-container" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <?php foreach ($a_tier_heroes as $hero): ?>
                            <div class="hero-badge">
                                <img src="<?php echo $hero['img']; ?>" alt="<?php echo $hero['name']; ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- D TIER -->
                <div class="tier-hero tier-d">
                    <span class="tier-label">D TIER</span>
                  
                    <div class="hero-items-container" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <?php foreach ($a_tier_heroes as $hero): ?>
                            <div class="hero-badge">
                                <img src="<?php echo $hero['img']; ?>" alt="<?php echo $hero['name']; ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; <?php echo date("Y"); ?> NightLock. All rights reserved.</p>
            <p>NightLock is an independent community project and is not affiliated with Valve Corporation.</p>
            <div class="footer-links">
                <a href="#tier-list">Back to Top ↑</a>
            </div>
        </div>
    </footer>
</body>
</html>