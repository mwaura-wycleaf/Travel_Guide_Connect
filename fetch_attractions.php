<?php
require_once "includes/db.php";

// Capture the search string
$search = isset($_GET['search']) ? mysqli_real_escape_string($link, $_GET['search']) : '';

// PREFIX LOGIC: Only match if the name/location STARTS with the search term
if (!empty($search)) {
    $sql = "SELECT * FROM attractions 
            WHERE name LIKE '$search%' 
            OR location LIKE '$search%' 
            ORDER BY name ASC";
} else {
    $sql = "SELECT * FROM attractions ORDER BY name ASC";
}

$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="attraction-card">
            <div class="attraction-image">
                <img src="images/<?php echo htmlspecialchars($row['img_url']); ?>" 
                     onerror="this.src='images/default.jpg';">
            </div>
            
            <div class="attraction-details">
                <span class="location-tag">
                    <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['location']); ?>
                </span>
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                
                <a href="attraction_details.php?id=<?php echo $row['id']; ?>" class="btn-view">
                    Explore Local Guides <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        <?php
    }
} else {
    echo "<div style='grid-column: 1/-1; text-align: center; padding: 60px 20px;'>
            <i class='fas fa-search-minus fa-3x' style='color: #ddd; margin-bottom: 15px;'></i>
            <h3 style='color: #7f8c8d;'>No destinations start with \"" . htmlspecialchars($search) . "\"</h3>
          </div>";
}
?>