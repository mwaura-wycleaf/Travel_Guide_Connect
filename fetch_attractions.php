<?php
require_once "includes/db.php";

// Capture the search string
$search = isset($_GET['search']) ? mysqli_real_escape_string($link, $_GET['search']) : '';

// Query logic
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
        $formatted_price = number_format($row['price'] ?? 0);
        ?>
        <div class="attraction-card">
            <div class="attraction-image">
                <div class="price-badge">
                    Entry: Ksh <?php echo $formatted_price; ?>
                </div>
                
                <img src="images/<?php echo htmlspecialchars($row['img_url']); ?>" 
                     onerror="this.src='images/default_kenya.jpg';">
            </div>
            
            <div class="attraction-details">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                
                <span class="location-tag">
                    <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['location']); ?> County
                </span>
                
                <p><?php echo htmlspecialchars(substr($row['description'], 0, 100)) . '...'; ?></p>
                
                <a href="attraction_details.php?id=<?php echo $row['id']; ?>" class="btn-view">
                    View Details & Guides
                </a>
            </div>
        </div>
        <?php
    }
} else {
    // Elegant "No Results" state
    echo "<div style='grid-column: 1/-1; text-align: center; padding: 60px 20px;'>
            <i class='fas fa-search-minus fa-3x' style='color: #bdc3c7; margin-bottom: 15px;'></i>
            <h3 style='color: #7f8c8d;'>No destinations found matching \"" . htmlspecialchars($search) . "\"</h3>
            <p style='color: #bdc3c7;'>Try searching for a different county or landmark.</p>
          </div>";
}
?>