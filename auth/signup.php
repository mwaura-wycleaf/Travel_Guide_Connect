<?php
// Include database connection
require_once "../includes/db.php";

$name = $email = $password = "";
$name_err = $email_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // 1. Validate Name
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // 2. Validate Email & Check if it already exists
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } else {
        $sql = "SELECT id FROM users WHERE email = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = trim($_POST["email"]);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else {
                    $email = trim($_POST["email"]);
                }
            }
            mysqli_stmt_close($stmt);
        }
    }

    // 3. Validate Password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // 4. Insert into Database
    if(empty($name_err) && empty($email_err) && empty($password_err)){
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_email, $param_password, $param_role);
            
            $param_name = $name;
            $param_email = $email;
            // SECURE HASHING
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_role = "user"; // Default role for new signups
            
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page after successful registration
                header("location: login.php?registration=success");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
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
    <title>Sign Up | Travel Guide Connect</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Create Account</h2>
        <form action="signup.php" method="post">
            <input type="text" name="name" placeholder="Full Name" required>
            <span class="error"><?php echo $name_err; ?></span>
            
            <input type="email" name="email" placeholder="Email" required>
            <span class="error"><?php echo $email_err; ?></span>
            
            <input type="password" name="password" placeholder="Password" required>
            <span class="error"><?php echo $password_err; ?></span>
            
            <button type="submit">Sign Up</button>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
</body>
</html>