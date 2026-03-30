<?php 
session_start();
require_once "includes/db.php"; 
include "includes/header.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Kenya | Travel Guide Connect</title>
<style>
    body { background-color: #f4f7f6; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
    .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
    .text-center { text-align: center; }
    .display-4 { font-size: 2.8rem; color: #2c3e50; font-weight: 700; margin-bottom: 10px; }
    .lead { color: #7f8c8d; font-size: 1.1rem; margin-bottom: 30px; }

    /* --- Search Bar --- */
    .search-wrapper { max-width: 600px; margin: 0 auto 50px; position: relative; }
    .search-input {
        width: 100%; padding: 18px 30px 18px 55px; border-radius: 50px;
        border: 2px solid #eee; outline: none; font-size: 1.1rem;
        transition: 0.3s; box-shadow: 0 10px 25px rgba(0,0,0,0.05); box-sizing: border-box;
    }
    .search-input:focus { border-color: #27ae60; box-shadow: 0 10px 30px rgba(39, 174, 96, 0.15); }
    .search-icon { position: absolute; left: 22px; top: 50%; transform: translateY(-50%); color: #bdc3c7; }

    /* --- Grid & Cards --- */
    .attractions-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 30px; }
    
    .attraction-card {
        background: #fff; 
        border-radius: 25px; 
        overflow: hidden; 
        box-shadow: 0 8px 20px rgba(0,0,0,0.04); 
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); /* Smooth easing for the lift */
        border: 1px solid #f0f0f0; 
        display: flex; 
        flex-direction: column;
        cursor: pointer;
    }

    /* --- HOVER EFFECTS: Lift and Green Glow --- */
    .attraction-card:hover { 
        transform: translateY(-12px); 
        border-color: rgba(39, 174, 96, 0.3);
        box-shadow: 0 20px 40px rgba(39, 174, 96, 0.15); /* The Green Glow */
    }
    
    .attraction-image { position: relative; height: 220px; overflow: hidden; }
    
    /* --- IMAGE ZOOM ON HOVER --- */
    .attraction-image img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
        transition: transform 0.6s ease; /* Transition for the zoom */
    }

    .attraction-card:hover .attraction-image img {
        transform: scale(1.1); /* Zoom effect */
    }

    /* --- GREEN PRICE BADGE --- */
    .price-badge {
        position: absolute;
        bottom: 15px; 
        left: 15px;   
        background: #27ae60; 
        padding: 6px 14px;
        border-radius: 8px;
        font-weight: 700;
        color: #ffffff;
        font-size: 0.9rem;
        z-index: 10;
        transition: 0.3s;
    }

    .attraction-details { padding: 25px; flex-grow: 1; display: flex; flex-direction: column; }
    
    .location-tag { font-size: 0.9rem; color: #95a5a6; font-weight: 500; margin-bottom: 15px; display: flex; align-items: center; }
    .location-tag i { color: #27ae60; margin-right: 8px; font-size: 1.1rem; }

    .attraction-details h3 { margin: 0 0 8px 0; font-size: 1.6rem; color: #2c3e50; font-weight: 700; }
    .attraction-details p { font-size: 0.95rem; color: #7f8c8d; height: 50px; overflow: hidden; margin-bottom: 20px; line-height: 1.6; }

    /* --- VIEW DETAILS BUTTON --- */
    .btn-view {
        margin-top: auto; 
        background: #f1f3f5; /* Initial light grey */
        color: #2c3e50;      
        text-align: center; 
        padding: 12px; 
        border-radius: 15px;
        text-decoration: none; 
        font-weight: 700; 
        transition: 0.3s;
    }

    /* --- BUTTON INTERACTION: Turns green when the WHOLE card is hovered --- */
    .attraction-card:hover .btn-view { 
        background: #27ae60;
        color: #ffffff;
        box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
    }

    #loader { display: none; text-align: center; margin-bottom: 20px; color: #27ae60; font-size: 2rem; }
</style>
</head>
<body>

<div class="container">
    <div class="text-center">
        <h1 class="display-4">Explore Kenya</h1>
        <p class="lead">Start typing to filter destinations by the first letter...</p>
    </div>

    <div class="search-wrapper">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="live_search" class="search-input" placeholder="e.g., A for Aberdares..." autocomplete="off">
    </div>

    <div id="loader"><i class="fas fa-spinner fa-spin"></i></div>
    <div class="attractions-grid" id="search_results"></div>
</div>

<script>
    const searchInput = document.getElementById('live_search');
    const resultsDiv = document.getElementById('search_results');
    const loader = document.getElementById('loader');

    function load_data(query = '') {
        loader.style.display = 'block';
        fetch('fetch_attractions.php?search=' + encodeURIComponent(query))
            .then(response => response.text())
            .then(data => {
                resultsDiv.innerHTML = data;
                loader.style.display = 'none';
            });
    }

    // Initial load
    window.onload = () => load_data('');

    // Character-by-character listener
    searchInput.addEventListener('input', function() {
        load_data(this.value);
    });
</script>

<?php include "includes/footer.php"; ?>
</body>
</html>