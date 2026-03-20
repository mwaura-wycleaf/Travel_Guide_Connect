<?php
session_start();
if(!isset($_SESSION['guide_id'])){
    header("Location: guide_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard | T-Connect</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body {
            background: linear-gradient(rgba(255,255,255,0.2), rgba(255,255,255,0.1)), 
                        url('../images/guide_bg.jpg') no-repeat center center fixed;
            background-size: cover; color: #333; min-height: 100vh;
        }
        .container { padding: 40px; max-width: 1200px; margin: auto; }
        .header {
            display: flex; justify-content: space-between; align-items: center;
            background: white; padding: 20px 30px; border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .logout-btn {
            padding: 10px 25px; border-radius: 25px; background: #e74c3c;
            color: white; text-decoration: none; font-weight: 600;
        }
        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 30px; }
        .card {
            background: rgba(255,255,255,0.9); padding: 30px; border-radius: 20px;
            text-align: center; border: 1px solid #eee; transition: 0.3s;
        }
        .card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .card a { display: inline-block; margin-top: 10px; color: #27ae60; font-weight: bold; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Guide Dashboard</h1>
        <a href="Travel_Guide_Connect\guide\iincludes\guide_logout" class="logout-btn">Logout</a>
    </div>
    <div style="margin: 20px 0;">Welcome, <?php echo htmlspecialchars($_SESSION['guide_name']); ?> 👋</div>
    <div class="cards">
        <div class="card"><h3>Availability</h3><a href="#">Open</a></div>
        <div class="card"><h3>Bookings</h3><a href="#">Open</a></div>
        <div class="card"><h3>Reviews</h3><a href="#">Open</a></div>
        <div class="card"><h3>Profile</h3><a href="#">Open</a></div>
    </div>
</div>
</body>
</html>
