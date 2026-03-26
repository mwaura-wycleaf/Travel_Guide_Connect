<?php 
session_start();
include 'includes/db.php'; 

// --- Logic to check if user has an active booking ---
$has_active_booking = false;
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $user_id = $_SESSION['id'];
    $check_sql = "SELECT id FROM bookings WHERE user_id = '$user_id' AND status != 'Cancelled' LIMIT 1";
    $check_res = mysqli_query($link, $check_sql);
    if (mysqli_num_rows($check_res) > 0) { $has_active_booking = true; }
}

// --- Fetch 3 Trending Attractions ---
$trending_sql = "SELECT * FROM attractions LIMIT 3";
$trending_res = mysqli_query($link, $trending_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Travel Guide Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body, html { margin: 0; padding: 0; font-family: 'Poppins', sans-serif; background-color: #f8f9fa; scroll-behavior: smooth; }

        /* --- HERO SECTION WITH YOUR IMAGE --- */
        .hero {
            height: 80vh;
            /* Points to your specific background image */
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), 
                        url('images/tconnect.background.jpg') no-repeat center center/cover;
            display: flex; flex-direction: column; justify-content: center; 
            align-items: center; text-align: center; color: white; padding: 0 20px;
        }

        .hero h1 { font-size: 3.5rem; margin-bottom: 10px; text-shadow: 2px 2px 10px rgba(0,0,0,0.5); }
        .hero p { font-size: 1.2rem; margin-bottom: 30px; opacity: 0.9; }

        /* --- MAIN CONTENT --- */
        .section-container { max-width: 1200px; margin: 80px auto; padding: 0 20px; }
        
        .section-header { 
            display: flex; justify-content: space-between; align-items: center; 
            margin-bottom: 40px; border-left: 5px solid #27ae60; padding-left: 20px;
        }
        .section-header h2 { font-size: 2.2rem; color: #2c3e50; margin: 0; }
        .btn-all { color: #27ae60; text-decoration: none; font-weight: 700; border: 2px solid #27ae60; padding: 8px 20px; border-radius: 30px; transition: 0.3s; }
        .btn-all:hover { background: #27ae60; color: white; }

        /* --- GRID CARDS --- */
        .trending-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); 
            gap: 30px; 
        }

        .card { 
            background: white; border-radius: 20px; overflow: hidden; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: 0.4s; 
        }
        .card:hover { transform: translateY(-12px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        
        /* Fixed image container for cards */
        .card-img-holder { height: 230px; width: 100%; overflow: hidden; position: relative; }
        .card-img-holder img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
        .card:hover .card-img-holder img { scale: 1.1; }

        .price-overlay {
            position: absolute; bottom: 15px; left: 15px; background: #27ae60;
            color: white; padding: 5px 15px; border-radius: 8px; font-weight: bold; font-size: 0.9rem;
        }

        .card-body { padding: 25px; }
        .card-body h3 { margin: 0 0 10px 0; font-size: 1.4rem; color: #2c3e50; }
        .card-body p { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 20px; }

        .btn-explore { 
            display: block; text-align: center; background: #f1f2f6; color: #2c3e50; 
            text-decoration: none; padding: 12px; border-radius: 12px; font-weight: 600; transition: 0.3s;
        }
        .btn-explore:hover { background: #27ae60; color: white; }

        @media (max-width: 768px) { .hero h1 { font-size: 2.5rem; } }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<section class="hero">
    <h1>Travel Guide Connect</h1>
    <p>Discover the hidden gems of Kenya with local experts.</p>
    
    <?php if($has_active_booking): ?>
        <a href="my_bookings.php" style="background:rgba(255,255,255,0.2); padding: 10px 25px; border-radius: 50px; color:white; text-decoration:none; backdrop-filter:blur(10px); border:1px solid rgba(255,255,255,0.3);">
            <i class="fas fa-hiking"></i> Track Your Active Trip
        </a>
    <?php else: ?>
        <a href="#trending" style="background:#27ae60; padding: 15px 40px; border-radius: 50px; color:white; text-decoration:none; font-weight:bold; font-size:1.1rem; box-shadow: 0 10px 20px rgba(39, 174, 96, 0.3);">Start Exploring</a>
    <?php endif; ?>
</section>

<div class="section-container" id="trending">
    <div class="section-header">
        <div>
            <h2>Trending Destinations</h2>
            <p style="color:#7f8c8d;">Handpicked locations for your next adventure.</p>
        </div>
        <a href="attractions.php" class="btn-all">Browse All <i class="fas fa-arrow-right"></i></a>
    </div>

    <div class="trending-grid">
        <?php while($row = mysqli_fetch_assoc($trending_res)): ?>
        <div class="card">
            <div class="card-img-holder">
                <img src="images/<?php echo !empty($row['img_url']) ? $row['img_url'] : 'default.jpg'; ?>" alt="Destination">
                <div class="price-overlay">Entry: Ksh <?php echo number_format($row['price']); ?></div>
            </div>
            <div class="card-body">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <p><i class="fas fa-map-marker-alt" style="color:#27ae60;"></i> <?php echo htmlspecialchars($row['location']); ?> County</p>
                
                <a href="attraction_details.php?id=<?php echo $row['id']; ?>" class="btn-explore">View Details & Guides</a>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>