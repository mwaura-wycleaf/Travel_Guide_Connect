<?php
// Start session
session_start();

// If user already logged in redirect them
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

// Database connection
require_once "../includes/db.php";

// Variables
$email = $password = "";
$email_err = $password_err = "";

// When form is submitted
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

    // If no errors check database
    if(empty($email_err) && empty($password_err)){

        $sql = "SELECT id, name, email, password, role FROM users WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){

            mysqli_stmt_bind_param($stmt, "s", $param_email);

            $param_email = $email;

            if(mysqli_stmt_execute($stmt)){

                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){

                    mysqli_stmt_bind_result($stmt, $id, $name, $email, $hashed_password, $role);

                    if(mysqli_stmt_fetch($stmt)){

                        if(password_verify($password, $hashed_password)){

                            // Password correct start session
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["name"] = $name;
                            $_SESSION["role"] = $role;

                            // Redirect based on role
                            if($role == "admin"){
                                header("location: admin/index.php");
                            } else{
                                header("location: user/index.php");
                            }

                            exit;

                        } else{
                            $password_err = "Invalid password.";
                        }
                    }

                } else{
                    $email_err = "No account found with that email.";
                }

            } else{
                echo "Something went wrong. Please try again later.";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Travel Guide Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="images/cool.PNG" type="image/PNG">
    
</head>
<body>

<?php include '../includes/header.php'; ?>

    <div class="container">
        <div class="login-card">
            <div class="brand">
                <h2>Travel Guide connect</h2>
                <p>Explore.Connect.Experience</p>
            </div>
            
                        
            <form action="login.php" method="POST">
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required value="">
                </div>
                
                <div class="input-group">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <button type="button" class="toggle-password" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                
                <div class="forgot-password">
                    <a href="reset_password.php?from_login=true">Forgot Password?</a>
                </div>
                
                <button type="submit" class="btn-login">Login</button>
            </form>
            
            <form action="signup.php">
                <button class="switch-btn">Don't have an account? Sign Up</button>
            </form>
            
            <div class="security-info">
                <i class="fas fa-lock"></i> Your information is securely encrypted
            </div>
        </div>
    </div>