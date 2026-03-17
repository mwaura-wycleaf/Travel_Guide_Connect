<?php 
session_start();
include 'includes/header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Travel Guide Connect</title>
    <style>
        /* --- EMBEDDED ABOUT PAGE CSS --- */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                        url('images/tconnect.background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            min-height: 100vh;
        }

        .about-container {
            max-width: 1000px;
            margin: 60px auto;
            padding: 20px;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .about-hero {
            text-align: center;
            margin-bottom: 50px;
        }

        .about-hero h1 {
            font-size: 3rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
            color: #27ae60; /* Brand Green */
        }

        .about-hero p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .about-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .mission, .team-info {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        h2 {
            color: #2ecc71;
            margin-bottom: 20px;
            font-size: 1.8rem;
            border-bottom: 2px solid rgba(46, 204, 113, 0.3);
            display: inline-block;
            padding-bottom: 5px;
        }

        .mission p {
            line-height: 1.8;
            font-size: 1.1rem;
        }

        .team-info ul {
            list-style: none;
            padding: 0;
        }

        .team-info li {
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
        }

        .team-info li strong {
            color: #2ecc71;
            display: block;
            font-size: 1.1rem;
        }

        /* Custom checkmark icons */
        .team-info li::before {
            content: "\f058"; /* FontAwesome check-circle */
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            margin-right: 15px;
            color: #27ae60;
            font-size: 1.2rem;
        }

        /* Mobile adjustments */
        @media (max-width: 768px) {
            .about-hero h1 { font-size: 2rem; }
            .about-container { margin: 30px auto; }
        }
    </style>
</head>
<body>

<main class="about-container">
    <section class="about-hero">
        <h1>About Us</h1>
        <p>Connecting you to the heart of Kenya through local expertise.</p>
    </section>

    <section class="about-content">
        <div class="mission">
            <h2>Our Mission</h2>
            <p>We aim to empower local Kenyan guides by connecting them directly with global travelers. At <strong>Travel Guide Connect</strong>, we believe the best way to see Kenya is through the eyes of someone who calls it home. We ensure an authentic experience for tourists and a sustainable, fair income for our local partners.</p>
        </div>

        <div class="team-info">
            <h2>Why Choose Us?</h2>
            <ul>
                <li>
                    <span><strong>Verified Local Guides</strong><br>Every guide on our platform is vetted for deep local knowledge, safety, and professionalism.</span>
                </li>
                <li>
                    <span><strong>Authentic Experiences</strong><br>Go beyond the usual tourist paths and discover the hidden gems of the 254.</span>
                </li>
                <li>
                    <span><strong>Direct Impact</strong><br>Your bookings support local communities directly, fostering economic growth in tourism.</span>
                </li>
            </ul>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>