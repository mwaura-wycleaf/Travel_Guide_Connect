<?php 
// 1. PHP LOGIC - PROCESSING THE FORM
session_start();
require_once "includes/db.php"; // Ensure this path is correct for your root folder

$success_msg = "";
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_contact'])) {
    // Sanitize
    $name    = mysqli_real_escape_string($link, trim($_POST['name']));
    $email   = mysqli_real_escape_string($link, trim($_POST['email']));
    $subject = mysqli_real_escape_string($link, trim($_POST['subject']));
    $message = mysqli_real_escape_string($link, trim($_POST['message']));

    if (!empty($name) && !empty($email) && !empty($message)) {
        $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $subject, $message);
            if (mysqli_stmt_execute($stmt)) {
                $success_msg = "Message sent successfully! We will get back to you soon.";
            } else {
                $error_msg = "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        $error_msg = "Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Travel Guide Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* --- EMBEDDED CSS --- */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('images/tconnect.background.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            color: #333;
        }

        .contact-container {
            max-width: 1100px;
            margin: 50px auto;
            padding: 20px;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .contact-hero {
            text-align: center;
            color: white;
            margin-bottom: 40px;
        }

        .contact-hero h1 { font-size: 3rem; color: #27ae60; margin-bottom: 10px; }
        .contact-hero p { font-size: 1.1rem; opacity: 0.9; }

        .contact-content {
            display: flex;
            flex-wrap: wrap;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
        }

        /* Form Section */
        .contact-form-section {
            flex: 2;
            padding: 40px;
            min-width: 320px;
        }

        .contact-form-section h2 { margin-bottom: 25px; color: #2c3e50; }

        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
            outline: none;
            transition: 0.3s;
        }

        .form-group input:focus, .form-group textarea:focus {
            border-color: #27ae60;
            box-shadow: 0 0 8px rgba(39, 174, 96, 0.2);
        }

        .btn-submit {
            background: #27ae60;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
        }

        .btn-submit:hover { background: #2ecc71; transform: scale(1.02); }

        /* Sidebar Section */
        .contact-info-section {
            flex: 1;
            background: #27ae60;
            color: white;
            padding: 40px;
            min-width: 280px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .info-item { display: flex; align-items: flex-start; margin-bottom: 30px; }
        .info-item i { font-size: 1.5rem; margin-right: 15px; margin-top: 5px; }
        .info-item p { margin: 0; line-height: 1.6; font-size: 1rem; }

        .social-links h3 { font-size: 1.2rem; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.3); display: inline-block; padding-bottom: 5px; }
        .icons a { color: white; font-size: 1.5rem; margin-right: 20px; transition: 0.3s; }
        .icons a:hover { color: #2c3e50; }

        /* Alert Boxes */
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        @media (max-width: 768px) {
            .contact-content { flex-direction: column; }
            .contact-hero h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<main class="contact-container">
    <section class="contact-hero">
        <h1>Get In Touch</h1>
        <p>Your journey across Kenya starts with a single message.</p>
    </section>

    <div class="contact-content">
        <div class="contact-form-section">
            <h2>Send us a Message</h2>

            <?php if($success_msg): ?>
                <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo $success_msg; ?></div>
            <?php endif; ?>

            <?php if($error_msg): ?>
                <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo $error_msg; ?></div>
            <?php endif; ?>

            <form action="contact.php" method="POST">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Mwaura Wycleaf" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="example@tconnect.co.ke" required>
                </div>

                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" placeholder="How can we help?">
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" placeholder="Tell us more about your travel plans..." required></textarea>
                </div>

                <button type="submit" name="send_contact" class="btn-submit">Send Message</button>
            </form>
        </div>

        <div class="contact-info-section">
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <p><strong>Our Office</strong><br>Nairobi CBD, Kenya<br>Travel House, 4th Floor</p>
            </div>
            
            <div class="info-item">
                <i class="fas fa-phone-alt"></i>
                <p><strong>Call Us</strong><br>+254 700 000 000</p>
            </div>

            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <p><strong>Email Us</strong><br>info@tconnect.co.ke</p>
            </div>

            <div class="social-links">
                <h3>Connect With Us</h3>
                <div class="icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>

</body>
</html>