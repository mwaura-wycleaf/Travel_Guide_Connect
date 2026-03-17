<?php
session_start();
include("../includes/db.php"); 

if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM guides WHERE email='$email'";
    $result = mysqli_query($link, $query);
    $guide = mysqli_fetch_assoc($result);

    if($guide && password_verify($password, $guide['password'])){
        $_SESSION['guide_id'] = $guide['id'];
        $_SESSION['guide_name'] = $guide['name'];
        $_SESSION['role'] = 'guide';
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid Guide credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Guide Login | T-Connect</title>
    <style>
        
        body { background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('../images/guide_bg.jpg') no-repeat center center fixed; background-size: cover; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 40px; border-radius: 20px; color: white; text-align: center; border: 1px solid rgba(255,255,255,0.2); width: 350px; }
        input { width: 100%; padding: 12px; margin: 10px 0; border-radius: 25px; border: none; }
        button { width: 100%; padding: 12px; border-radius: 25px; border: none; background: #27ae60; color: white; font-weight: bold; cursor: pointer; }
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
        <?php if(isset($error)) echo "<p style='color: #ff9f89;'>$error</p>"; ?>
    </div>
</body>
</html>
