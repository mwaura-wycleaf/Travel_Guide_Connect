<?php
require_once "includes/db.php";

// Capture the search and season strings
$search = isset($_GET['search']) ? mysqli_real_escape_string($link, $_GET['search']) : '';
$season = isset($_GET['season']) ? mysqli_real_escape_string($link, $_GET['season']) : '';

// Base query
$sql = "SELECT * FROM attractions WHERE 1=1";

// 1. Filter by Name or Location
if (!empty($search)) {
    $sql .= " AND (name LIKE '$search%' OR location LIKE '$search%')";
}

// 2. Filter by Boolean Season Columns
if ($season === 'Dry Season') {
    $sql .= " AND is_dry_season = 1";
} elseif ($season === 'Long Rains') {
    $sql .= " AND is_long_rains = 1";
} elseif ($season === 'Short Rains') {
    $sql .= " AND is_short_rains = 1";
}

$sql .= " ORDER BY name ASC";

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
                <div class="season-badges">
                    <?php if($row['is_dry_season']): ?>
                        <span class="season-tag">☀️ Dry</span>
                    <?php endif; ?>
                    <?php if($row['is_long_rains']): ?>
                        <span class="season-tag">🌧️ Long Rains</span>
                    <?php endif; ?>
                    <?php if($row['is_short_rains']): ?>
                        <span class="season-tag">🌦️ Short Rains</span>
                    <?php endif; ?>
                </div>

                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                
                <span class="location-tag">
                    <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['location']); ?> County
                </span>
                
                <p><?php echo htmlspecialchars(substr($row['description'] ?? '', 0, 100)) . '...'; ?></p>
                
                <a href="attraction_details.php?id=<?php echo $row['id']; ?>" class="btn-view">
                    View Details & Guides
                </a>
            </div>
        </div>
        <?php
    }
} else {
    echo "<div style='grid-column: 1/-1; text-align: center; padding: 60px 20px;'>
            <i class='fas fa-search-minus fa-3x' style='color: #bdc3c7; margin-bottom: 15px;'></i>
            <h3 style='color: #7f8c8d;'>No destinations found.</h3>
            <p style='color: #bdc3c7;'>Try adjusting your filters.</p>
          </div>";
}
?>