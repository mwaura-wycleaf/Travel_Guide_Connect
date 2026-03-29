<?php
// 1. Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travel_guide_connect";
$port = 3307; 

$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 2. Get the ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;
$query = "SELECT * FROM attractions WHERE id = $id";
$result = mysqli_query($conn, $query);
$attraction = mysqli_fetch_assoc($result);

if (!$attraction) {
    die("Attraction not found.");
}

// Use floatval to ensure these are passed as numbers to JavaScript
$lat = (!empty($attraction['latitude'])) ? floatval($attraction['latitude']) : -0.7167; 
$lng = (!empty($attraction['longitude'])) ? floatval($attraction['longitude']) : 37.1333;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map - <?php echo htmlspecialchars($attraction['name']); ?></title>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; padding: 20px; background-color: #f4f7f6; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        
        /* THE FIX: Ensure the map container has a visible background and explicit height */
        #map { 
            height: 500px; 
            width: 100%; 
            border-radius: 8px; 
            border: 1px solid #ccc;
            background: #e0e0e0; /* Visual cue if tiles fail */
        }

        /* Prevent potential CSS conflicts from other stylesheets */
        .leaflet-tile { visibility: visible !important; }
        
        .back-btn { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #2c3e50; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>

<div class="container">
    <h1><?php echo htmlspecialchars($attraction['name']); ?></h1>
    <p style="color: #27ae60; font-weight: bold;">📍 <?php echo htmlspecialchars($attraction['location']); ?></p>
    <p><?php echo htmlspecialchars($attraction['description']); ?></p>

    <div id="map"></div>

    <a href="index.php" class="back-btn">← Back to Destinations</a>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var lat = <?php echo $lat; ?>;
        var lng = <?php echo $lng; ?>;

        // Initialize map
        var map = L.map('map').setView([lat, lng], 15);

        // ALTERNATIVE TILE SERVER: Using the 'Humanitarian' style which often loads better
        L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Add Marker
        var marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup("<b><?php echo htmlspecialchars($attraction['name']); ?></b>").openPopup();

        // THE REFRESH FIX: Force tiles to render if the container was hidden/resized
        setTimeout(function() {
            map.invalidateSize();
        }, 300);
        
        // Final fallback: try to re-load tiles after 2 seconds
        setTimeout(function() {
            map.invalidateSize();
        }, 2000);
    });
</script>

</body>
</html>