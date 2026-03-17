<?php 
session_start();
require_once "includes/db.php"; 
include "includes/header.php"; 

// Get the filter value from the URL if it exists
$filter = isset($_GET['spec']) ? mysqli_real_escape_string($link, $_GET['spec']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Local Guides | Travel Guide Connect</title>
    <style>
        /* --- STYLES --- */
        body { background-color: #f8f9fa; font-family: 'Poppins', sans-serif; }
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        
        /* Filter Bar */
        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .filter-group select {
            padding: 10px 20px;
            border-radius: 20px;
            border: 1px solid #ddd;
            outline: none;
        }
        .btn-filter {
            background: #27ae60;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 20px;
            cursor: pointer;
        }

        .guides-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .guide-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            border: 1px solid #eee;
            transition: 0.3s;
        }
        .guide-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

        .guide-img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; border: 3px solid #27ae60; }
        
        .view-btn {
            background: #2c3e50;
            color: white;
            text-decoration: none;
            padding: 10px 0;
            display: block;
            border-radius: 10px;
            margin-top: 15px;
            font-weight: 600;
        }
        .view-btn:hover { background: #27ae60; }
    </style>
</head>
<body>

<div class="container">
    <div class="header-title" style="text-align:center; margin-bottom:30px;">
        <h1>Professional Local Guides</h1>
        <p>Filter by expertise to find your perfect match.</p>
    </div>

    <div class="filter-section">
        <form action="guides.php" method="GET" style="display:flex; gap:15px; width:100%;">
            <select name="spec">
                <option value="">All Specializations</option>
                <option value="Hiking" <?php if($filter == 'Hiking') echo 'selected'; ?>>Hiking & Trekking</option>
                <option value="Wildlife" <?php if($filter == 'Wildlife') echo 'selected'; ?>>Wildlife Safaris</option>
                <option value="Culture" <?php if($filter == 'Culture') echo 'selected'; ?>>Cultural Tours</option>
                <option value="Coastal" <?php if($filter == 'Coastal') echo 'selected'; ?>>Coastal/Water Sports</option>
            </select>
            <button type="submit" class="btn-filter">Filter Now</button>
            <?php if($filter): ?>
                <a href="guides.php" style="color:#e74c3c; text-decoration:none; align-self:center;">Clear</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="guides-grid">
        <?php
        // Construct Query based on filter
        $sql = "SELECT * FROM guides";
        if (!empty($filter)) {
            $sql .= " WHERE specialization LIKE '%$filter%'";
        }
        $sql .= " ORDER BY rating DESC";
        
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="guide-card">
                    <img src="images/<?php echo $row['profile_img']; ?>" class="guide-img" onerror="this.src='images/default_guide.jpg';">
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p style="color:#27ae60; font-weight:bold;"><?php echo $row['specialization']; ?></p>
                    <p><i class="fas fa-star" style="color:#f1c40f;"></i> <?php echo $row['rating']; ?> / 5.0</p>
                    
                    <a href="guide_profile.php?id=<?php echo $row['id']; ?>" class="view-btn">View Full Profile</a>
                </div>
                <?php
            }
        } else {
            echo "<p>No guides matching that category.</p>";
        }
        ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>
</body>
</html>