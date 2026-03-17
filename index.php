<?php 
session_start();
// Include the database connection just in case you want to fetch dynamic data later
include 'includes/db.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Travel Guide Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* --- EMBEDDED CSS --- */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
            background-color: #f8f9fa;
        }

        /* Hero Section Styling */
        .hero {
            height: 80vh;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url('images/tconnect.background.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 0 20px;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            margin-bottom: 10px;
            letter-spacing: 2px;
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .btn-primary {
            background: #27ae60;
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            font-size: 1.1rem;
            transition: 0.3s;
            display: inline-block;
        }

        .btn-primary:hover {
            background: #2ecc71;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        /* Services Section Styling */
        .services {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            padding: 80px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .service-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            flex: 1;
            min-width: 300px;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: 0.3s;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        }

        .service-card i {
            font-size: 3rem;
            color: #27ae60;
            margin-bottom: 20px;
        }

        .service-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .service-card p {
            color: #7f8c8d;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .btn-secondary {
            border: 2px solid #27ae60;
            color: #27ae60;
            padding: 10px 25px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-secondary:hover {
            background: #27ae60;
            color: white;
        }

        #welcome-msg {
            font-size: 1.5rem;
            background: rgba(255, 255, 255, 0.2);
            display: inline-block;
            padding: 10px 20px;
            border-radius: 10px;
            backdrop-filter: blur(5px);
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .hero-content h1 { font-size: 2.2rem; }
            .service-card { min-width: 100%; }
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<section class="hero">
    <div class="hero-content">
        <h1>Travel Guide Connect</h1>
        <p>Explore. Connect. Experience.</p>
        
        <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
            <h2 id="welcome-msg">Welcome back, <?php echo htmlspecialchars($_SESSION["name"]); ?>!</h2>
        <?php else: ?>
            <div class="auth-buttons">
                <a href="auth/signup.php" class="btn-primary">Get Started</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="services">
    <div class="service-card" id="attractions-card">
        <i class="fas fa-map-marked-alt"></i>
        <h3>Attractions</h3>
        <p>Discover top Kenyan destinations, from the peak of Mt. Kenya to the beaches of Diani.</p>
        <a href="attractions.php" class="btn-secondary">Explore Now</a>
    </div>

    <div class="service-card" id="guides-card">
        <i class="fas fa-user-tie"></i>
        <h3>Local Guides</h3>
        <p>Connect with expert local guides who know the hidden gems and culture of our beautiful country.</p>
        <a href="guides.php" class="btn-secondary">Find Guides</a>
    </div>
</section>

<script>
    /* --- EMBEDDED JAVASCRIPT --- */
    // Simple scroll animation for the cards
    window.addEventListener('scroll', () => {
        const cards = document.querySelectorAll('.service-card');
        cards.forEach(card => {
            const cardTop = card.getBoundingClientRect().top;
            if(cardTop < window.innerHeight - 100) {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }
        });
    });

    // Console log to check port for you
    console.log("App running on Port 8080. Connection variable $link active.");
</script>

<?php include 'includes/footer.php'; ?>

</body>
</html>