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
            background: #fff; border-radius: 20px; overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.04); transition: 0.4s;
            border: 1px solid #f0f0f0; display: flex; flex-direction: column;
        }
        .attraction-card:hover { transform: translateY(-10px); box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
        .attraction-image { height: 220px; overflow: hidden; }
        .attraction-image img { width: 100%; height: 100%; object-fit: cover; transition: 0.6s; }

        .attraction-details { padding: 25px; flex-grow: 1; display: flex; flex-direction: column; }
        .location-tag { font-size: 0.85rem; color: #27ae60; font-weight: 700; text-transform: uppercase; margin-bottom: 10px; }
        .attraction-details h3 { margin: 0 0 12px 0; font-size: 1.5rem; color: #2c3e50; }
        .attraction-details p { font-size: 0.95rem; color: #7f8c8d; height: 60px; overflow: hidden; margin-bottom: 25px; line-height: 1.6; }

        /* --- THE BUTTON STYLING --- */
        .btn-view {
            margin-top: auto; background: #2c3e50; color: white;
            text-align: center; padding: 14px; border-radius: 12px;
            text-decoration: none; font-weight: 600; transition: all 0.3s ease;
        }
        .btn-view:hover { background: #27ae60; transform: scale(1.02); box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3); }
        .btn-view i { transition: transform 0.3s ease; margin-left: 8px; }
        .btn-view:hover i { transform: translateX(5px); }

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