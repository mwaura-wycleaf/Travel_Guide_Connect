<?php
session_start();
include("../includes/db.php"); 

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Secure query
    $stmt = $link->prepare("SELECT * FROM guides WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows === 1){
        $guide = $result->fetch_assoc();

        if(password_verify($password, $guide['password'])){
            $_SESSION['guide_id'] = $guide['id'];
            $_SESSION['guide_name'] = $guide['name'];
            $_SESSION['role'] = 'guide';

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "Guide not found!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Guide Login | T-Connect</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)), 
                        url('../images/guide_bg.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 20px;
            width: 350px;
            text-align: center;
            color: white;
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }

        .login-box h2 {
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border-radius: 25px;
            border: none;
            outline: none;
            background: rgba(255,255,255,0.9);
        }

        input:focus {
            box-shadow: 0 0 5px #27ae60;
        }

        button {
            width: 100%;
            padding: 12px;
            border-radius: 25px;
            border: none;
            background: #27ae60;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
        }

        button:hover {
            background: #1e8449;
            transform: scale(1.03);
        }

        .error {
            margin-top: 10px;
            color: #ffb3a7;
            font-size: 14px;
        }

        .footer-text {
            margin-top: 15px;
            font-size: 12px;
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>Guide Portal</h2>

        <form method="POST">
            <input type="email" name="email" placeholder="Guide Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button name="login">LOGIN AS GUIDE</button>
        </form>

        <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

        <div class="footer-text">
            T-Connect © 2026
        </div>
    </div>
</body>
</html>
