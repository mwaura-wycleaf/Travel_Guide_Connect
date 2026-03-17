<?php
session_start();
include("../includes/db.php"); 

// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}

if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password = $_POST['password'];

    // Using a prepared statement is safer for the admin portal
    $query = "SELECT * FROM admins WHERE email=?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $admin = mysqli_fetch_assoc($result);

    if($admin && password_verify($password, $admin['password'])){
        // Set all necessary session variables for the gatekeeper
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_email'] = $admin['email'];
        $_SESSION['role'] = 'admin';
        $_SESSION['loggedin'] = true;
        
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid credentials. Access Denied.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Travel Guide Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        /* --- GLASSMORPHISM LOGIN STYLES --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body, html {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

        .login-body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            /* Path assumes background is in root /images folder */
            background: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), 
                        url('../images/tconnect.background.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px); /* Safari support */
            padding: 50px 40px;
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 45px rgba(0,0,0,0.5);
            width: 90%;
            max-width: 420px;
            text-align: center;
            color: white;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-box h2 {
            font-size: 2rem;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #27ae60; /* Brand Green */
        }

        .login-box p.brand-motto {
            font-size: 0.8rem;
            letter-spacing: 3px;
            margin-bottom: 5px;
            opacity: 0.7;
        }

        .login-box p.subtitle {
            margin-bottom: 35px;
            font-size: 1rem;
            font-weight: 300;
            border-top: 1px solid rgba(255,255,255,0.2);
            display: inline-block;
            padding-top: 10px;
        }

        /* Form Inputs */
        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.6);
        }

        .login-box input {
            width: 100%;
            padding: 15px 15px 15px 50px;
            border-radius: 30px;
            border: 1px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.05);
            color: white;
            font-size: 1rem;
            transition: 0.3s;
        }

        .login-box input:focus {
            outline: none;
            background: rgba(255,255,255,0.15);
            border-color: #27ae60;
            box-shadow: 0 0 15px rgba(39, 174, 96, 0.3);
        }

        .login-box input::placeholder {
            color: rgba(255,255,255,0.5);
        }

        /* Button */
        .login-box button {
            width: 100%;
            padding: 15px;
            margin-top: 10px;
            border-radius: 30px;
            border: none;
            background: #27ae60; /* Professional Green instead of Red */
            color: white;
            font-weight: bold;
            font-size: 1.1rem;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.4);
        }

        .login-box button:hover {
            background: #2ecc71;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(39, 174, 96, 0.5);
        }

        .error-msg {
            background: rgba(231, 76, 60, 0.2);
            color: #ff9f89;
            padding: 10px;
            border-radius: 10px;
            margin-top: 20px;
            font-size: 0.85rem;
            border: 1px solid rgba(231, 76, 60, 0.3);
        }

        /* Back to site link */
        .back-link {
            display: block;
            margin-top: 25px;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 0.8rem;
            transition: 0.3s;
        }
        .back-link:hover { color: white; }
    </style>
</head>
<body>

<div class="login-body">
    <div class="login-box">
        <h2>Travel Guide Connect</h2>
        <p class="brand-motto">EXPLORE • CONNECT • EXPERIENCE</p>
        <p class="subtitle">Secure Admin Portal</p>
        
        <form method="POST" action="admin_login.php">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Admin Email" required>
            </div>
            
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            
            <button type="submit" name="login">LOGIN TO DASHBOARD</button>
        </form>

        <?php if(isset($error)): ?>
            <div class="error-msg">
                <i class="fas fa-shield-alt"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <a href="../index.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Return to Main Website
        </a>
    </div>
</div>

</body>
</html>