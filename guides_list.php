<?php 
session_start();
// 1. Point to your ACTUAL database file
require_once "includes/db.php"; 
include "includes/header.php"; 

// 2. Get the location from the URL with a fallback for the title
$raw_location = isset($_GET['location']) ? $_GET['location'] : '';
$target_location = mysqli_real_escape_string($link, $raw_location);
$display_location = !empty($raw_location) ? htmlspecialchars($raw_location) : "Our Featured Destinations";

// 3. Helper functions for the dynamic initials fallback
function getAvatarColor($name) {
    $colors = ['#d1fae5', '#fef3c7', '#e0e7ff', '#fce7f3', '#ffedd5'];
    return $colors[abs(crc32($name)) % count($colors)];
}
function getLetterColor($name) {
    $colors = ['#065f46', '#92400e', '#3730a3', '#9d174d', '#9a3412'];
    return $colors[abs(crc32($name)) % count($colors)];
}

// 4. Fetch ONLY guides from that specific location
// If location is empty, it will show 0 results by design, or you can remove the WHERE clause to show all.
$query = "SELECT * FROM guides WHERE location = ? AND is_available = 1";
$stmt = $link->prepare($query);
$stmt->bind_param("s", $target_location);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body { background-color: #f8fafc; font-family: 'Poppins', sans-serif; color: #334155; }
        .guide-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
            gap: 25px; 
            padding: 20px 0; 
        }
        .guide-card { 
            background: white; 
            padding: 30px 20px; 
            border-radius: 24px; 
            border: 1px solid #e2e8f0; 
            text-align: center; 
            transition: 0.3s;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .guide-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        
        .avatar-box { width: 110px; height: 110px; margin: 0 auto 15px; }
        .img-square, .initials-square { 
            width: 100%; height: 100%; border-radius: 20px; border: 3px solid #2ecc71; 
            object-fit: cover; display: flex; align-items: center; justify-content: center; 
            font-weight: bold; font-size: 2rem;
        }

        .guide-name { font-size: 1.2rem; font-weight: 700; color: #1e293b; margin: 10px 0 5px; }
        .spec-text { color: #2ecc71; font-weight: 600; font-size: 0.9rem; margin-bottom: 10px; }
        
        .stats-row { 
            border-top: 1px solid #f1f5f9; 
            margin-top: 15px; 
            padding-top: 15px; 
            font-size: 0.85rem; 
            font-weight: 600;
            display: flex;
            justify-content: center;
            gap: 8px;
        }
        .price-text { color: #059669; }
        .star-icon { color: #fbbf24; }

        .book-now { 
            display: block; 
            background: #1e293b; 
            color: white; 
            padding: 12px; 
            border-radius: 12px; 
            text-decoration: none; 
            margin-top: 20px; 
            font-weight: 600;
            transition: 0.2s;
        }
        .book-now:hover { background: #334155; }
    </style>
</head>
<body>

<div class="container" style="max-width: 1100px; margin: auto; padding: 40px 20px;">
    <div class="header" style="text-align: center; margin-bottom: 40px;">
        <h1 style="font-size: 2.2rem; font-weight: 800;">Local Experts in <?php echo $display_location; ?></h1>
        <p style="color: #64748b;">Found <?php echo $result->num_rows; ?> verified guides ready to show you around.</p>
    </div>

    <div class="guide-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while($guide = $result->fetch_assoc()): ?>
                <div class="guide-card">
                    <div class="avatar-box">
                        <?php if(!empty($guide['profile_img']) && file_exists("images/".$guide['profile_img'])): ?>
                            <img src="images/<?php echo $guide['profile_img']; ?>" class="img-square">
                        <?php else: ?>
                            <div class="initials-square" style="background: <?php echo getAvatarColor($guide['name']); ?>; color: <?php echo getLetterColor($guide['name']); ?>;">
                                <?php 
                                    $n = explode(" ", $guide['name']);
                                    echo strtoupper($n[0][0] . (isset($n[1][0]) ? $n[1][0] : ''));
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <h3 class="guide-name"><?php echo htmlspecialchars($guide['name']); ?></h3>
                    <p class="spec-text"><?php echo htmlspecialchars($guide['specialization']); ?></p>
                    
                    <div class="stats-row">
                        <span class="star-icon">★ <?php echo number_format($guide['rating'], 1); ?></span>
                        <span style="color: #cbd5e1;">|</span>
                        <span><?php echo $guide['experience_years']; ?> Yrs</span>
                        <span style="color: #cbd5e1;">|</span>
                        <span class="price-text">Ksh <?php echo number_format($guide['rate_per_day']); ?></span>
                    </div>

                    <a href="guide_profile.php?id=<?php echo $guide['id']; ?>" class="book-now">Book <?php echo explode(" ", $guide['name'])[0]; ?></a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="grid-column: 1/-1; text-align: center; padding: 50px; background: white; border-radius: 20px;">
                <p style="color: #64748b;">No guides listed for this location yet.</p>
                <a href="guides.php" style="color: #2ecc71; font-weight: 600; text-decoration: none;">Browse all guides instead &rarr;</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>
</body>
</html>