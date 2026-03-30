<?php 
session_start();
require_once "includes/db.php"; 
include "includes/header.php"; 

// 1. Get the Guide ID from the URL
if(!isset($_GET['id']) || empty($_GET['id'])){
    header("location: guides.php");
    exit;
}
$guide_id = mysqli_real_escape_string($link, $_GET['id']);

// 2. Fetch Guide Details
$sql = "SELECT * FROM guides WHERE id = '$guide_id'";
$result = mysqli_query($link, $sql);
$guide = mysqli_fetch_assoc($result);

if(!$guide){
    echo "<div class='container'><h2>Guide not found.</h2></div>";
    include "includes/footer.php";
    exit;
}

/**
 * Helper functions for dynamic avatar colors
 */
function getAvatarColor($name) {
    $colors = ['#d1fae5', '#fef3c7', '#e0e7ff', '#fce7f3', '#ffedd5', '#f1f5f9'];
    $hash = crc32($name);
    return $colors[abs($hash) % count($colors)];
}

function getLetterColor($name) {
    $colors = ['#065f46', '#92400e', '#3730a3', '#9d174d', '#9a3412', '#475569'];
    $hash = crc32($name);
    return $colors[abs($hash) % count($colors)];
}

// 3. Handle New Review Submission
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_review'])){
    $u_name = mysqli_real_escape_string($link, $_POST['u_name']);
    $u_rating = mysqli_real_escape_string($link, $_POST['u_rating']);
    $u_comment = mysqli_real_escape_string($link, $_POST['u_comment']);

    $ins_sql = "INSERT INTO reviews (guide_id, user_name, rating, comment) VALUES ('$guide_id', '$u_name', '$u_rating', '$u_comment')";
    mysqli_query($link, $ins_sql);
    header("Location: guide_profile.php?id=" . $guide_id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($guide['name']); ?> | Profile</title>
    <style>
        body { background: #f8fafc; font-family: 'Poppins', sans-serif; color: #334155; }
        .profile-container { max-width: 900px; margin: 40px auto; padding: 20px; }
        
        /* Profile Header Card */
        .profile-card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            display: flex;
            gap: 40px;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
        }

        /* Square-ish Avatar Logic */
        .profile-avatar-box {
            width: 220px;
            height: 220px;
            flex-shrink: 0;
        }

        .profile-img, .initials-square {
            width: 100%;
            height: 100%;
            border-radius: 24px; /* Rounded Square */
            object-fit: cover;
            border: 5px solid #2ecc71;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            font-weight: 700;
        }

        .profile-info h1 { margin: 10px 0; color: #1e293b; font-size: 2.2rem; }
        .badge-spec { 
            background: #d1fae5; 
            color: #065f46; 
            padding: 6px 18px; 
            border-radius: 30px; 
            font-size: 0.9rem; 
            font-weight: 600;
            display: inline-block;
        }

        .info-row { display: flex; gap: 20px; margin: 15px 0; color: #64748b; font-size: 1rem; }
        .guide-bio { line-height: 1.7; color: #475569; margin-bottom: 25px; }

        .btn-contact { 
            background: #1e293b; 
            color: white; 
            border: none; 
            padding: 12px 35px; 
            border-radius: 12px; 
            cursor: pointer; 
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-contact:hover { background: #334155; transform: translateY(-2px); }

        /* Review Section */
        .review-section { margin-top: 50px; }
        .review-box {
            background: white;
            padding: 25px;
            border-radius: 18px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        }
        .star-rating { color: #fbbf24; margin-left: 10px; }

        /* Review Form */
        .add-review {
            background: #fff;
            padding: 35px;
            border-radius: 24px;
            margin-top: 50px;
            border: 1px solid #e2e8f0;
        }
        .add-review input, .add-review textarea, .add-review select {
            width: 100%; padding: 14px; margin-bottom: 15px; border: 1px solid #e2e8f0; border-radius: 12px; outline: none;
        }

        @media (max-width: 768px) {
            .profile-card { flex-direction: column; text-align: center; }
            .info-row { justify-content: center; }
        }
    </style>
</head>
<body>

<div class="profile-container">
    <div class="profile-card">
        <div class="profile-avatar-box">
            <?php if(!empty($guide['profile_img']) && file_exists("images/".$guide['profile_img'])): ?>
                <img src="images/<?php echo $guide['profile_img']; ?>" class="profile-img">
            <?php else: ?>
                <div class="initials-square" style="background-color: <?php echo getAvatarColor($guide['name']); ?>; color: <?php echo getLetterColor($guide['name']); ?>;">
                    <?php 
                        $parts = explode(" ", $guide['name']);
                        $initials = (isset($parts[0][0]) ? $parts[0][0] : '') . (isset($parts[1][0]) ? $parts[1][0] : '');
                        echo strtoupper($initials);
                    ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="profile-info">
            <span class="badge-spec"><?php echo htmlspecialchars($guide['specialization']); ?></span>
            <h1><?php echo htmlspecialchars($guide['name']); ?></h1>
            
            <div class="info-row">
                <span><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($guide['location']); ?></span>
                <span><i class="fas fa-briefcase"></i> <?php echo $guide['experience_years']; ?> Years Exp.</span>
                <span style="color: #059669; font-weight: bold;">Ksh <?php echo number_format($guide['rate_per_day']); ?>/day</span>
            </div>

            <p class="guide-bio"><?php echo nl2br(htmlspecialchars($guide['bio'])); ?></p>
            
            <a href="mailto:<?php echo $guide['email']; ?>" class="btn-contact">Contact Guide Now</a>
        </div>
    </div>

    <div class="review-section">
        <h3>Traveler Feedback</h3>
        <?php
        $rev_sql = "SELECT * FROM reviews WHERE guide_id = '$guide_id' ORDER BY created_at DESC";
        $rev_res = mysqli_query($link, $rev_sql);
        if(mysqli_num_rows($rev_res) > 0){
            while($rev = mysqli_fetch_assoc($rev_res)){
                ?>
                <div class='review-box'>
                    <div style="display:flex; justify-content: space-between; align-items: center;">
                        <strong><?php echo htmlspecialchars($rev['user_name']); ?></strong>
                        <span class='star-rating'>
                            <?php for($i=1; $i<=$rev['rating']; $i++) echo "★"; ?>
                        </span>
                    </div>
                    <p style="margin: 15px 0; color: #475569;"><?php echo htmlspecialchars($rev['comment']); ?></p>
                    <small style='color:#94a3b8;'><?php echo date('F d, Y', strtotime($rev['created_at'])); ?></small>
                </div>
                <?php
            }
        } else {
            echo "<p style='color: #64748b;'>This guide hasn't received any reviews yet. Be the first!</p>";
        }
        ?>
    </div>

    <div class="add-review">
        <h3>Rate your experience</h3>
        <form action="" method="POST">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <input type="text" name="u_name" placeholder="Your Name" required>
                <select name="u_rating" required>
                    <option value="5">5 Stars - Excellent</option>
                    <option value="4">4 Stars</option>
                    <option value="3">3 Stars</option>
                </select>
            </div>
            <textarea name="u_comment" rows="4" placeholder="Tell other travelers about your trip..." required></textarea>
            <button type="submit" name="submit_review" class="btn-contact" style="border:none;">Post My Review</button>
        </form>
    </div>
</div>

<?php include "includes/footer.php"; ?>
</body>
</html>