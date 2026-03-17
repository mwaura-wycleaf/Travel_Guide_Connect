<?php 
// 1. Start the session and connect to your database
session_start();
require_once "includes/db.php"; 

// 2. Include the header
include "includes/header.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Kenya | Travel Guide Connect</title>
    
    <style>
        /* --- EMBEDDED ATTRACTIONS CSS --- */
        body {
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .text-center { text-align: center; }
        .mb-5 { margin-bottom: 3rem; }

        .display-4 {
            font-size: 2.5rem;
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .lead { color: #7f8c8d; font-size: 1.1rem; }

        /* The Responsive Grid */
        .attractions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
            padding-bottom: 50px;
        }

        /* Card Styling */
        .attraction-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #eee;
        }

        .attraction-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        /* Image Handling */
        .attraction-image {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .attraction-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .attraction-card:hover .attraction-image img {
            transform: scale(1.1);
        }

        /* Content Details */
        .attraction-details {
            padding: 20px;
        }

        .location-tag {
            font-size: 0.85rem;
            color: #27ae60;
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
        }

        .attraction-details h3 {
            margin: 0 0 10px 0;
            font-size: 1.4rem;
            color: #2c3e50;
        }

        .attraction-details p {
            font-size: 0.95rem;
            color: #666;
            line-height: 1.5;
            margin-bottom: 20px;
            height: 60px; /* Limits description height to keep cards uniform */
            overflow: hidden;
        }

        /* Seasonal Badges */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 5px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .badge-dry { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .badge-rains { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        .badge-short { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

        .text-muted { font-size: 0.8rem; color: #999; }
        .d-block { display: block; }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .display-4 { font-size: 2rem; }
            .attractions-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="text-center mb-5">
        <h1 class="display-4">Explore Kenya</h1>
        <p class="lead">Discover the best destinations across the country</p>
        <hr style="width: 80px; border: 2px solid #27ae60; margin: auto;">
    </div>

    <div class="attractions-grid">
        <?php
        // 3. Fetch data from your database
        $sql = "SELECT * FROM attractions ORDER BY name ASC";
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="attraction-card">
                    <div class="attraction-image">
                        <img src="images/<?php echo htmlspecialchars($row['img_url']); ?>" 
                             alt="<?php echo htmlspecialchars($row['name']); ?>" 
                             onerror="this.src='images/default.jpg';">
                    </div>
                    
                    <div class="attraction-details">
                        <span class="location-tag">
                            <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['location']); ?>
                        </span>
                        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        
                        <div class="seasons">
                            <small class="text-muted d-block mb-2">Best time to visit:</small>
                            <?php if(isset($row['is_dry_season']) && $row['is_dry_season']) echo '<span class="badge badge-dry">Dry Season</span>'; ?>
                            <?php if(isset($row['is_long_rains']) && $row['is_long_rains']) echo '<span class="badge badge-rains">Long Rains</span>'; ?>
                            <?php if(isset($row['is_short_rains']) && $row['is_short_rains']) echo '<span class="badge badge-short">Short Rains</span>'; ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<div style="grid-column: 1/-1; text-align: center; padding: 50px; background: #fff; border-radius: 15px;">
                    <i class="fas fa-info-circle" style="font-size: 3rem; color: #27ae60; margin-bottom: 20px;"></i>
                    <h3>No attractions added yet.</h3>
                    <p>Time to add some destinations in your database!</p>
                  </div>';
        }
        ?>
    </div>
</div>

<?php 
include "includes/footer.php"; 
?>

</body>
</html>