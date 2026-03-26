<?php
session_start();
require_once "includes/db.php";
include "includes/header.php";

// 1. Validation: Ensure an ID is passed in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: attractions.php");
    exit;
}

$attr_id = mysqli_real_escape_string($link, $_GET['id']);

// 2. Fetch Attraction Details
$sql_attr = "SELECT * FROM attractions WHERE id = '$attr_id'";
$res_attr = mysqli_query($link, $sql_attr);
$attraction = mysqli_fetch_assoc($res_attr);

if (!$attraction) {
    echo "<div class='container' style='text-align:center; padding:100px;'><h2>Attraction not found.</h2><a href='attractions.php'>Go Back</a></div>";
    exit;
}

// 3. Logic: Find Guides who work in this specific County/Location
$target_county = mysqli_real_escape_string($link, $attraction['location']);
$sql_guides = "SELECT * FROM guides WHERE location = '$target_county' AND status = 'active'";
$res_guides = mysqli_query($link, $sql_guides);
$num_guides = mysqli_num_rows($res_guides);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body { background-color: #f8faf9; font-family: 'Poppins', sans-serif; color: #333; }
        .container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
        
        /* --- Attraction Hero Section --- */
        .attraction-hero {
            display: flex; gap: 40px; background: #fff; padding: 30px;
            border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-bottom: 50px; align-items: center;
        }
        .hero-img { width: 450px; height: 320px; border-radius: 20px; object-fit: cover; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .hero-text h1 { font-size: 2.5rem; color: #2c3e50; margin: 10px 0; }
        .county-tag { background: #e8f5e9; color: #27ae60; padding: 6px 15px; border-radius: 30px; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; }
        .description { line-height: 1.8; color: #666; margin-bottom: 20px; }

        /* --- Guides Section --- */
        .section-title { font-size: 1.8rem; color: #2c3e50; margin-bottom: 30px; display: flex; align-items: center; gap: 10px; }
        .guide-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; }
        
        .guide-card {
            background: #fff; border: 1px solid #eee; border-radius: 20px; padding: 30px 20px;
            text-align: center; transition: 0.3s ease; position: relative; overflow: hidden;
        }
        .guide-card:hover { transform: translateY(-10px); border-color: #27ae60; box-shadow: 0 15px 35px rgba(0,0,0,0.08); }
        
        .guide-thumb { width: 110px; height: 110px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; border: 4px solid #f0fdf4; }
        .guide-name { font-size: 1.3rem; font-weight: 700; color: #2c3e50; margin-bottom: 5px; }
        .guide-rate { color: #27ae60; font-weight: 800; font-size: 1.1rem; margin-bottom: 15px; display: block; }
        
        .guide-bio { font-size: 0.9rem; color: #7f8c8d; height: 55px; overflow: hidden; margin-bottom: 20px; line-height: 1.5; }
        
        .btn-book {
            display: block; width: 100%; background: #2c3e50; color: white;
            padding: 12px; border-radius: 10px; text-decoration: none;
            font-weight: 600; transition: 0.3s;
        }
        .btn-book:hover { background: #27ae60; box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3); }

        /* Empty State */
        .no-guides { grid-column: 1/-1; background: #fff; padding: 60px; border-radius: 20px; text-align: center; border: 1px dashed #ccc; }

        @media (max-width: 900px) {
            .attraction-hero { flex-direction: column; text-align: center; }
            .hero-img { width: 100%; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="attraction-hero">
        <img src="images/<?php echo htmlspecialchars($attraction['img_url']); ?>" class="hero-img" alt="Destination">
        <div class="hero-text">
            <span class="county-tag"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($attraction['location']); ?> County</span>
            <h1><?php echo htmlspecialchars($attraction['name']); ?></h1>
            <p class="description"><?php echo nl2br(htmlspecialchars($attraction['description'])); ?></p>
            <div style="font-size: 0.9rem; color: #2c3e50; font-weight: 600;">
                <i class="fas fa-users" style="color: #27ae60;"></i> <?php echo $num_guides; ?> Verified Guides in this region
            </div>
        </div>
    </div>

    <h2 class="section-title">Select Your Preferred Guide</h2>
    
    <div class="guide-grid">
        <?php if($num_guides > 0): ?>
            <?php while($guide = mysqli_fetch_assoc($res_guides)): ?>
                <div class="guide-card">
                    <img src="images/guides/<?php echo htmlspecialchars($guide['profile_pic']); ?>" class="guide-thumb" alt="Guide">
                    
                    <div class="guide-name"><?php echo htmlspecialchars($guide['name']); ?></div>
                    <span class="guide-rate">Ksh <?php echo number_format($guide['rate_per_day']); ?> / day</span>
                    
                    <p class="guide-bio"><?php echo htmlspecialchars($guide['bio']); ?></p>
                    
                    <a href="book.php?attr_id=<?php echo $attr_id; ?>&guide_id=<?php echo $guide['id']; ?>" class="btn-book">
                        Select <?php echo htmlspecialchars(explode(' ', $guide['name'])[0]); ?>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-guides">
                <i class="fas fa-user-clock fa-3x" style="color: #ddd; margin-bottom: 20px;"></i>
                <h3>No guides available yet.</h3>
                <p>We are currently vetting local experts for <?php echo htmlspecialchars($attraction['location']); ?>. Please check back later!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>
</body>
</html>