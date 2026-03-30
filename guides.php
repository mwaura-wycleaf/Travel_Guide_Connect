<?php 
session_start();
require_once "includes/db.php"; 
include "includes/header.php"; 

// Get the filter value from the URL if it exists
$filter = isset($_GET['spec']) ? mysqli_real_escape_string($link, $_GET['spec']) : '';

/**
 * Helper function to generate a consistent background color based on a string
 * This ensures "Kamau" always gets one color, "Sarah" another, etc.
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Local Guides | Travel Guide Connect</title>
    <style>
        body { background-color: #f8fafc; font-family: 'Poppins', sans-serif; color: #334155; }
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        
        /* Filter Bar */
        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .filter-section select {
            padding: 10px 20px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            outline: none;
            flex-grow: 1;
        }
        .btn-filter {
            background: #1e293b;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
        }

        /* Guides Grid */
        .guides-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        /* Card Design matching Screenshot */
        .guide-card {
            background: white;
            border-radius: 20px;
            padding: 35px 25px;
            text-align: center;
            border: 1px solid #f1f5f9;
            transition: 0.3s;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .guide-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.08); }

        /* Avatar Styling with Dynamic Colors */
        .avatar-container {
            width: 115px;
            height: 115px;
            margin-bottom: 15px;
        }
        .guide-img-circle {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #2ecc71;
        }
        .initials-circle {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            border: 3px solid #2ecc71; /* The green ring from your screenshot */
        }
        
        .guide-card h3 { font-size: 1.3rem; margin: 10px 0 5px 0; color: #1e293b; font-weight: 700; }
        .spec-label { color: #2ecc71; font-weight: 600; font-size: 0.95rem; margin-bottom: 8px; }
        .rating-label { color: #64748b; font-size: 0.9rem; margin-bottom: 20px; }

        .view-btn {
            background: #334155; 
            color: white;
            text-decoration: none;
            padding: 12px 0;
            width: 100%;
            display: block;
            border-radius: 12px;
            font-weight: 600;
            transition: 0.2s;
        }
        .view-btn:hover { background: #1e293b; letter-spacing: 0.5px; }
    </style>
</head>
<body>

<div class="container">
    <div style="text-align:center; margin-bottom:40px;">
        <h1 style="font-weight: 800; font-size: 2.5rem; margin-bottom: 10px;">Professional Local Guides</h1>
        <p style="color: #64748b; font-size: 1.1rem;">Expert guidance for your journey through Kenya.</p>
    </div>

    <div class="filter-section">
        <form action="guides.php" method="GET" style="display:flex; gap:15px; width:100%;">
            <select name="spec">
                <option value="">All Specializations</option>
                <option value="Hiking" <?php if($filter == 'Hiking') echo 'selected'; ?>>Hiking & Mt. Kenya Trekking</option>
                <option value="Wildlife" <?php if($filter == 'Wildlife') echo 'selected'; ?>>Wildlife Safaris</option>
                <option value="Culture" <?php if($filter == 'Culture') echo 'selected'; ?>>Cultural Tours</option>
                <option value="Coastal" <?php if($filter == 'Coastal') echo 'selected'; ?>>Coastal & Deep Sea Fishing</option>
            </select>
            <button type="submit" class="btn-filter">Filter Guides</button>
            <?php if($filter): ?>
                <a href="guides.php" style="color:#ef4444; text-decoration:none; align-self:center; font-weight:600; margin-left: 10px;">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="guides-grid">
        <?php
        $sql = "SELECT * FROM guides";
        if (!empty($filter)) {
            $sql .= " WHERE specialization LIKE '%$filter%'";
        }
        $sql .= " ORDER BY rating DESC";
        
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $bg_color = getAvatarColor($row['name']);
                $text_color = getLetterColor($row['name']);
                ?>
                <div class="guide-card">
                    <div class="avatar-container">
                        <?php if(!empty($row['profile_img']) && file_exists("images/".$row['profile_img'])): ?>
                            <img src="images/<?php echo $row['profile_img']; ?>" class="guide-img-circle">
                        <?php else: ?>
                            <div class="initials-circle" style="background-color: <?php echo $bg_color; ?>; color: <?php echo $text_color; ?>;">
                                <?php 
                                    $parts = explode(" ", $row['name']);
                                    $initials = (isset($parts[0][0]) ? $parts[0][0] : '') . (isset($parts[1][0]) ? $parts[1][0] : '');
                                    echo strtoupper($initials);
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p class="spec-label"><?php echo htmlspecialchars($row['specialization']); ?></p>
                    <p class="rating-label"><?php echo number_format($row['rating'], 2); ?> / 5.0</p>
                    
                    <a href="guide_profile.php?id=<?php echo $row['id']; ?>" class="view-btn">View Full Profile</a>
                </div>
                <?php
            }
        } else {
            echo "<div style='grid-column: 1/-1; text-align:center; padding: 60px; background: white; border-radius: 20px;'>
                    <p style='color:#64748b; font-size: 1.2rem;'>No guides currently available in this category.</p>
                  </div>";
        }
        ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>
</body>
</html>