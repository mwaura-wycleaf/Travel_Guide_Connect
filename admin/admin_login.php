<?php
session_start();
include("../includes/db.php"); 

if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM admins WHERE email='$email'";
    $result = mysqli_query($link, $query);
    $admin = mysqli_fetch_assoc($result);

    if($admin && password_verify($password, $admin['password'])){
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_email'] = $admin['email'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid credentials. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | Travel Guide Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* EMBEDDED CSS - This solves the path issues */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
           
        }
        

        .login-body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
             background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('../images/tconnect.background.jpg') no-repeat center center fixed;
             background-size: cover;
            /* Relative path to image from this file */
        }

        .login-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            padding: 50px 40px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            width: 100%;
            max-width: 400px;
            text-align: center;
            color: white;
        }

        .login-box h2 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .login-box p.subtitle {
            margin-bottom: 30px;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .login-box input {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 30px;
            border: 1px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.1);
            color: white;
            box-sizing: border-box; /* Crucial for width */
        }

        .login-box input::placeholder {
            color: rgba(255,255,255,0.6);
        }

        .login-box button {
            width: 100%;
            padding: 15px;
            border-radius: 30px;
            border: none;
            background: #ff4757;
            color: white;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-box button:hover {
            background: #ff6b81;
            transform: scale(1.02);
        }

        .error-msg {
            color: #fab1a0;
            margin-top: 15px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="login-body">
    <div class="login-box">
        <h2>Travel Guide Connect</h2>
        <p>Explore.Connect.Experience</p>
        <p class="subtitle">Admin Portal Access</p>
        
        <form method="POST">
            <input type="email" name="email" placeholder="Admin Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button name="login">LOGIN</button>
        </form>

        <?php if(isset($error)): ?>
            <div class="error-msg">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>