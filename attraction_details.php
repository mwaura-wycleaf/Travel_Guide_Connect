<?php
session_start();
require_once "includes/db.php"; 
include "includes/header.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: attractions.php");
    exit;
}

// Using $link as defined in your db.php
$attr_id = mysqli_real_escape_string($link, $_GET['id']);

$sql_attr = "SELECT * FROM attractions WHERE id = '$attr_id'";
$res_attr = mysqli_query($link, $sql_attr);
$attraction = mysqli_fetch_assoc($res_attr);

if (!$attraction) {
    echo "<div class='container' style='text-align:center; padding:100px;'><h2>Attraction not found.</h2><a href='attractions.php'>Go Back</a></div>";
    exit;
}

$target_county = mysqli_real_escape_string($link, $attraction['location']);
// Filter by availability and county
$sql_guides = "SELECT * FROM guides WHERE location = '$target_county' AND is_available = 1";
$res_guides = mysqli_query($link, $sql_guides);
$num_guides = mysqli_num_rows($res_guides);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($attraction['name']); ?> - Travel Guide Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f8faf9; font-family: 'Poppins', sans-serif; color: #333; }
        .container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }

        .back-link {
            display: inline-block; margin-bottom: 20px; text-decoration: none;
            color: #7f8c8d; font-weight: 600; transition: 0.3s;
        }
        .back-link:hover { color: #27ae60; }
        
        /* --- Attraction Hero --- */
        .attraction-hero {
            display: flex; gap: 40px; background: #fff; padding: 35px;
            border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-bottom: 50px; align-items: center;
        }
        .hero-img { width: 450px; height: 320px; border-radius: 20px; object-fit: cover; }
        .hero-text h1 { font-size: 2.5rem; color: #2c3e50; margin: 10px 0; }
        .county-tag { background: #e8f5e9; color: #27ae60; padding: 6px 15px; border-radius: 30px; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; }
        .description { line-height: 1.8; color: #666; margin-bottom: 25px; }

        /* --- NEW: Map Button Style --- */
        .btn-map {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #27ae60;
            color: white;
            padding: 12px 25px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.2);
        }
        .btn-map:hover {
            background: #219150;
            transform: translateY(-2px);
        }

        /* --- Guides Grid --- */
        .section-title { font-size: 1.8rem; color: #2c3e50; margin-bottom: 30px; display: flex; align-items: center; gap: 10px; }
        .guide-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; }
        
        .guide-card {
            background: #fff; border: 1px solid #eee; border-radius: 20px; padding: 30px 20px;
            text-align: center; transition: 0.3s ease; position: relative;
        }
        .guide-card:hover { transform: translateY(-10px); border-color: #27ae60; box-shadow: 0 15px 35px rgba(0,0,0,0.08); }
        
        .guide-thumb { 
            width: 110px; height: 110px; border-radius: 50%; object-fit: cover; 
            margin-bottom: 15px; border: 4px solid #f0fdf4; background-color: #eee;
        }
        
        .guide-name { font-size: 1.2rem; font-weight: 700; color: #2c3e50; margin-bottom: 5px; }
        .guide-spec { color: #27ae60; font-weight: 600; font-size: 0.85rem; margin-bottom: 10px; display: block; }
        .guide-bio { font-size: 0.85rem; color: #7f8c8d; height: 45px; overflow: hidden; margin-bottom: 15px; line-height: 1.4; }
        .guide-meta { font-size: 0.8rem; color: #2c3e50; margin-bottom: 15px; font-weight: 600; border-top: 1px solid #f0f0f0; padding-top: 10px; }

        .btn-book {
            display: block; width: 100%; background: #2c3e50; color: white;
            padding: 12px; border-radius: 10px; text-decoration: none;
            font-weight: 600; transition: 0.3s; font-size: 0.9rem;
        }
        .btn-book:hover { background: #27ae60; box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3); }

        .no-guides { grid-column: 1/-1; background: #fff; padding: 60px; border-radius: 20px; text-align: center; border: 1px dashed #ccc; }

        @media (max-width: 900px) {
            .attraction-hero { flex-direction: column; text-align: center; }
            .hero-img { width: 100%; height: auto; }
        }
    </style>
</head>
<body>

<div class="container">
    <a href="attractions.php" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Destinations
    </a>

    <div class="attraction-hero">
        <img src="images/<?php echo htmlspecialchars($attraction['img_url']); ?>" class="hero-img" alt="Destination">
        <div class="hero-text">
            <span class="county-tag"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($attraction['location']); ?> County</span>
            <h1><?php echo htmlspecialchars($attraction['name']); ?></h1>
            <p class="description"><?php echo nl2br(htmlspecialchars($attraction['description'])); ?></p>
            
            <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                <a href="view_map.php?id=<?php echo $attr_id; ?>" class="btn-map">
                    <i class="fas fa-map-location-dot"></i> View on Interactive Map
                </a>

                <div style="font-size: 0.9rem; color: #2c3e50; font-weight: 600;">
                    <i class="fas fa-certificate" style="color: #27ae60;"></i> <?php echo $num_guides; ?> Experts in this region
                </div>
            </div>
        </div>
    </div>

    <h2 class="section-title"><i class="fas fa-user-shield"></i> Recommended Local Guides</h2>
    
    <div class="guide-grid">
        <?php if($num_guides > 0): ?>
            <?php while($guide = mysqli_fetch_assoc($res_guides)): ?>
                <div class="guide-card">
                    <?php 
                        // Path check for guide images
                        $guide_img_path = "images/guides/" . $guide['profile_img'];
                        if (empty($guide['profile_img']) || !file_exists($guide_img_path)) {
                            $display_img = "https://ui-avatars.com/api/?name=" . urlencode($guide['name']) . "&background=random&color=fff&size=128";
                        } else {
                            $display_img = $guide_img_path;
                        }
                    ?>
                    
                    <img src="<?php echo $display_img; ?>" class="guide-thumb" alt="Guide Profile">
                    
                    <div class="guide-name"><?php echo htmlspecialchars($guide['name']); ?></div>
                    <span class="guide-spec"><?php echo htmlspecialchars($guide['specialization'] ?? 'Tour'); ?> Expert</span>
                    
                    <p class="guide-bio"><?php echo htmlspecialchars($guide['bio'] ?? 'Dedicated local guide with deep knowledge of the area.'); ?></p>

                    <div class="guide-meta">
                        <span>⭐ <?php echo $guide['rating'] ?? '5.0'; ?></span> | 
                        <span><?php echo $guide['experience_years'] ?? '2'; ?> Yrs Exp.</span> |
                        <span style="color: #27ae60;">Ksh <?php echo number_format($guide['rate_per_day'] ?? 2500); ?></span>
                    </div>
                    
                    <a href="book.php?attr_id=<?php echo $attr_id; ?>&guide_id=<?php echo $guide['id']; ?>" class="btn-book">
                        Book <?php echo htmlspecialchars(explode(' ', $guide['name'])[0]); ?>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-guides">
                <i class="fas fa-search-location fa-3x" style="color: #ddd; margin-bottom: 20px;"></i>
                <h3>No local guides available.</h3>
                <p>We are still onboarding experts for the <?php echo htmlspecialchars($attraction['location']); ?> region.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>
</body>
</html>