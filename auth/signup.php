<?php
// Database connection
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
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_role = "user"; 
            
            if(mysqli_stmt_execute($stmt)){
                header("location: login.php?registration=success");
                exit();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Travel Guide Connect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* --- EMBEDDED CSS --- */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

        .page-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url('../images/tconnect.background.jpg') no-repeat center center/cover;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-width: 400px;
            text-align: center;
            color: white;
        }

        .login-card h2 {
            font-size: 2rem;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-group {
            position: relative;
            margin-bottom: 15px;
            text-align: left;
        }

        .input-group input {
            width: 100%;
            padding: 12px 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 30px;
            color: white;
            font-size: 1rem;
            box-sizing: border-box;
            outline: none;
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 22px; /* Adjusted for error message spacing */
            transform: translateY(-50%);
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            opacity: 0.7;
        }

        .error-msg {
            color: #ff7675;
            font-size: 0.75rem;
            margin-left: 15px;
            display: block;
            margin-top: 4px;
        }

        .btn-1 {
            width: 100%;
            padding: 15px;
            background: #27ae60;
            border: none;
            border-radius: 30px;
            color: white;
            font-weight: bold;
            font-size: 1.1rem;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 15px;
        }

        .btn-1:hover {
            background: #2ecc71;
            transform: scale(1.02);
        }

        p {
            margin-top: 20px;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        p a {
            color: #2ecc71;
            text-decoration: none;
            font-weight: bold;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="page-wrapper">
    <div class="login-card">
        <h2>Create Account</h2>
        <form action="signup.php" method="POST">
            
            <div class="input-group">
                <input type="text" name="name" placeholder="Full Name" value="<?php echo $name; ?>" required>
                <span class="error-msg"><?php echo $name_err; ?></span>
            </div>

            <div class="input-group">
                <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
                <span class="error-msg"><?php echo $email_err; ?></span>
            </div>
            
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <button type="button" class="toggle-password" id="togglePassword">
                    <i class="fas fa-eye" id="eyeIcon"></i>
                </button>
                <span class="error-msg"><?php echo $password_err; ?></span>
            </div>
            
            <button type="submit" class="btn-1">Sign Up</button>
            
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
</div>

<script>
    /* --- EMBEDDED JAVASCRIPT --- */
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        eyeIcon.classList.toggle('fa-eye');
        eyeIcon.classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>