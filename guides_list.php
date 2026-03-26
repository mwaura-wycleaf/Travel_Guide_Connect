<?php
include 'config.php';

// 1. Get the location from the URL (e.g., 'Makueni')
$target_location = isset($_GET['location']) ? $_GET['location'] : '';

// 2. Fetch ONLY guides from that specific location
$query = "SELECT * FROM guides WHERE location = ? AND is_available = 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $target_location);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="header">
    <h1>Local Experts in <?php echo htmlspecialchars($target_location); ?></h1>
    <p>We found <?php echo $result->num_rows; ?> guides ready to show you around.</p>
</div>

<div class="guide-grid">
    <?php while($guide = $result->fetch_assoc()): ?>
        <div class="guide-card">
            <div class="badge">Local Pro</div>
            <img src="images/guides/<?php echo $guide['profile_img']; ?>" alt="Guide">
            <h3><?php echo $guide['name']; ?></h3>
            <p><b>Specialty:</b> <?php echo $guide['specialization']; ?></p>
            <div class="stars">⭐ <?php echo $guide['rating']; ?></div>
            <a href="booking.php?guide_id=<?php echo $guide['id']; ?>" class="book-now">Book Now</a>
        </div>
    <?php endwhile; ?>
</div>