<?php 
// 1. Start the session and connect to your database
session_start();
require_once "includes/db.php"; // This should point to your config with port 3307

// 2. Include the header (with your logo and navigation)
include "includes/header.php"; 
?>

<div class="container my-5">
    <div class="text-center mb-5">
        <h1 class="display-4">Explore Kenya</h1>
        <p class="lead">Discover the best destinations across the country</p>
        <hr style="width: 100px; border: 2px solid #27ae60; margin: auto;">
    </div>

    <div class="attractions-grid">
        <?php
        // 3. Fetch data from your new 'attractions' table
        $sql = "SELECT * FROM attractions ORDER BY name ASC";
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="attraction-card">
                    <div class="attraction-image">
                        <img src="assets/images/<?php echo htmlspecialchars($row['img_url']); ?>" 
                             alt="<?php echo htmlspecialchars($row['name']); ?>" 
                             onerror="this.src='assets/images/default.jpg';">
                    </div>
                    
                    <div class="attraction-details">
                        <span class="location-tag">
                            <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['location']); ?>
                        </span>
                        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        
                        <div class="seasons">
                            <small class="text-muted d-block mb-2">Best time to visit:</small>
                            <?php if($row['is_dry_season']) echo '<span class="badge badge-dry">Dry Season</span>'; ?>
                            <?php if($row['is_long_rains']) echo '<span class="badge badge-rains">Long Rains</span>'; ?>
                            <?php if($row['is_short_rains']) echo '<span class="badge badge-short">Short Rains</span>'; ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<div class="alert alert-info text-center">No attractions added yet. Time to add some in phpMyAdmin!</div>';
        }
        ?>
    </div>
</div>

<?php 
// 5. Include your footer
include "includes/footer.php"; 
?>