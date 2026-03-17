<?php
session_start();
include("includes/db.php");
include("includes/header.php"); // Assuming your header has the nav bar

// 1. Fetch Featured Attractions (limit to 3 or 6)
$attr_res = mysqli_query($link, "SELECT * FROM attractions LIMIT 6");

// 2. Fetch Recent Reviews to display as Testimonials
$rev_res = mysqli_query($link, "SELECT r.*, a.name as attraction_name 
                                FROM reviews r 
                                JOIN attractions a ON r.attraction_id = a.id 
                                ORDER BY r.created_at DESC LIMIT 3");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Travel Guide Connect | Explore Kenya</title>
    <style>
        body { font-family: 'Poppins', sans-serif; margin: 0; background: #f9f9f9; }
        
        /* Hero Section */
        .hero {
            height: 60vh;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('images/hero_bg.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }
        .hero h1 { font-size: 3.5rem; margin: 0; }
        .hero p { font-size: 1.2rem; margin: 10px 0 20px; }

        /* Attractions Grid */
        .container { max-width: 1200px; margin: 50px auto; padding: 0 20px; }
        .section-title { text-align: center; margin-bottom: 40px; }
        
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; }
        
        .card { 
            background: white; border-radius: 15px; overflow: hidden; 
            box-shadow: 0 10px 20px rgba(0,0,0,0.05); transition: 0.3s; 
        }
        .card:hover { transform: translateY(-10px); }
        .card img { width: 100%; height: 200px; object-fit: cover; }
        .card-body { padding: 20px; }
        .card-body h3 { margin: 0 0 10px; color: #2c3e50; }
        .btn-book { 
            display: inline-block; background: #27ae60; color: white; 
            padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; 
        }

        /* Testimonials Section */
        .reviews-section { background: #2c3e50; color: white; padding: 60px 0; }
        .review-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .review-card { background: rgba(255,255,255,0.1); padding: 20px; border-radius: 10px; font-style: italic; }
        .stars { color: #f1c40f; }
    </style>
</head>
<body>

<section class="hero">
    <h1>Connect with Expert Guides</h1>
    <p>Discover the hidden gems of Kenya with local professionals.</p>
    <a href="#explore" class="btn-book" style="background: white; color: #27ae60; font-size: 1.1rem; padding: 15px 30px;">Start Exploring</a>
</section>

<div class="container" id="explore">
    <div class="section-title">
        <h2>Popular Destinations</h2>
        <p>Handpicked places just for you</p>
    </div>
    
    <div class="grid">
        <?php while($row = mysqli_fetch_assoc($attr_res)): ?>
        <div class="card">
            <img src="images/<?php echo $row['image']; ?>" onerror="this.src='images/default.jpg'">
            <div class="card-body">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <p style="color: #7f8c8d; font-size: 0.9rem;"><?php echo substr($row['description'], 0, 100); ?>...</p>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <span style="font-weight: bold; color: #27ae60;">KES <?php echo number_format($row['price']); ?></span>
                    <a href="attraction_details.php?id=<?php echo $row['id']; ?>" class="btn-book">View Details</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<section class="reviews-section">
    <div class="container">
        <h2 style="text-align: center; margin-bottom: 40px;">What Travelers Say</h2>
        <div class="review-grid">
            <?php while($rev = mysqli_fetch_assoc($rev_res)): ?>
            <div class="review-card">
                <div class="stars">
                    <?php for($i=0; $i<$rev['rating']; $i++) echo "★"; ?>
                </div>
                <p>"<?php echo htmlspecialchars($rev['comment']); ?>"</p>
                <small>— <?php echo htmlspecialchars($rev['user_name']); ?> at <strong><?php echo $rev['attraction_name']; ?></strong></small>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php include("includes/footer.php"); ?>

</body>
</html>