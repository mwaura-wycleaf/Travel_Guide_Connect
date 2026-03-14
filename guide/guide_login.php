<?php
session_start();
require_once "../includes/db.php";

// Redirect if already logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["role"] === "guide"){
    header("location: dashboard.php");
    exit;
}

$email = $password = "";
$email_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Check credentials
    if(empty($email_err) && empty($password_err)){
        $sql = "SELECT id, name, email, password, role FROM users WHERE email = ? AND role='guide'";

        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = $email;

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    mysqli_stmt_bind_result($stmt, $id, $name, $email, $hashed_password, $role);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Login success
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["name"] = $name;
                            $_SESSION["role"] = $role;
                            header("location: dashboard.php");
                            exit;
                        } else{
                            $password_err = "Invalid password.";
                        }
                    }
                } else{
                    $email_err = "No guide account found with that email.";
                }
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Guide Login | Travel Guide Connect</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
* {margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;}
body {
    background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('../../images/tconnect.background.jpg') no-repeat center center fixed;
    background-size: cover;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}
.login-card {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    padding: 40px 30px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.5);
    width: 350px;
    text-align: center;
}
.login-card h2 {
    color: #fff;
    margin-bottom: 15px;
    text-transform: uppercase;
    letter-spacing: 2px;
}
.login-card p {
    color: rgba(255,255,255,0.7);
    margin-bottom: 25px;
}
.input-group {
    position: relative;
    margin-bottom: 20px;
}
.input-group input {
    width: 100%;
    padding: 14px 20px;
    border-radius: 50px;
    border: 2px solid rgba(255,255,255,0.1);
    outline: none;
    color: #fff;
    background: rgba(255,255,255,0.08);
    font-size: 14px;
}
.input-group input::placeholder {
    color: rgba(255,255,255,0.5);
}
.btn-login {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg,#ff416c,#ff4b2b);
    border: none;
    border-radius: 50px;
    color: #fff;
    font-weight: 600;
    cursor: pointer;
    font-size: 16px;
    transition: all 0.4s ease;
}
.btn-login:hover {
    background: linear-gradient(135deg,#ff4b2b,#ff416c);
}
.forgot-password {
    margin-top: 10px;
}
.forgot-password a {
    color: rgba(255,255,255,0.7);
    text-decoration: none;
    font-size: 12px;
}
.forgot-password a:hover { color:#fff; text-decoration: underline;}
.error-message {
    background: rgba(255,0,0,0.2);
    color: #ff9e9e;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 10px;
}
</style>
</head>
<body>

<div class="login-card">
<h2>Guide Login</h2>
<p>Manage your tours and bookings</p>

<?php 
if(!empty($email_err)){ echo '<div class="error-message">'.$email_err.'</div>'; }
if(!empty($password_err)){ echo '<div class="error-message">'.$password_err.'</div>'; }
?>

<form action="guide_login.php" method="post">
    <div class="input-group">
        <input type="email" name="email" placeholder="Email" required value="<?php echo $email; ?>">
    </div>
    <div class="input-group">
        <input type="password" name="password" placeholder="Password" required>
    </div>
    <button type="submit" class="btn-login">LOGIN</button>
</form>
<p style="margin-top:15px;"><a href="login.php" style="color:#fff; text-decoration:underline;">Back to User Login</a></p>
</div>

</body>
</html>
