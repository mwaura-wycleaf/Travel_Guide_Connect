<?php
session_start();

// Redirect if already logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

require_once "../includes/db.php";

$email = $password = "";
$email_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else {
        $email = trim($_POST["email"]);
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

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
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["name"] = $name;
                            $_SESSION["role"] = $role;

                            if($role == "admin"){
                                header("location: admin/dashboard.php");
                            } else {
                                header("location: index.php");
                            }
                            exit;
                        } else {
                            $password_err = "Invalid password.";
                        }
                    }
                } else {
                    $email_err = "No account found with that email.";
                }
            } else {
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
    
    <style>
        /* --- EMBEDDED CSS --- */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Poppins', sans-serif;
            overflow: hidden; /* Keeps the card perfectly centered */
        }

        .page-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100vh;
            /* Update the path to your chosen background image */
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

        .brand h2 {
            font-size: 2rem;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .brand p {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-bottom: 30px;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 15px 20px;
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
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            opacity: 0.7;
        }

        .btn-login {
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
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #2ecc71;
            transform: scale(1.02);
        }

        .forgot-password, .switch-btn {
            margin-top: 15px;
            font-size: 0.85rem;
        }

        .forgot-password a, .switch-btn {
            color: white;
            text-decoration: none;
            opacity: 0.8;
            background: none;
            border: none;
            cursor: pointer;
        }

        .forgot-password a:hover { text-decoration: underline; }

        .error-msg {
            color: #ff7675;
            font-size: 0.85rem;
            margin-top: 5px;
            display: block;
        }

        .security-info {
            margin-top: 25px;
            font-size: 0.75rem;
            opacity: 0.6;
        }
    </style>
</head>
<body>

<div class="page-wrapper">
    <div class="login-card">
        <div class="brand">
            <h2>Travel Guide Connect</h2>
            <p>Explore.Connect.Experience</p>
        </div>
        
        <form action="login.php" method="POST">
            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required value="<?php echo $email; ?>">
                <span class="error-msg"><?php echo $email_err; ?></span>
            </div>
            
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <button type="button" class="toggle-password" id="togglePassword">
                    <i class="fas fa-eye" id="eyeIcon"></i>
                </button>
                <span class="error-msg"><?php echo $password_err; ?></span>
            </div>
            
            <div class="forgot-password">
                <a href="reset_password.php?from_login=true">Forgot Password?</a>
            </div>
            
            <button type="submit" class="btn-login">Login</button>
        </form>
        
        <button class="switch-btn" onclick="location.href='signup.php'">Don't have an account? Sign Up</button>
        
        <div class="security-info">
            <i class="fas fa-lock"></i> Your information is securely encrypted
        </div>
    </div>
</div>

<script>
    /* --- EMBEDDED JAVASCRIPT --- */
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');

    togglePassword.addEventListener('click', function (e) {
        // Toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // Toggle the icon
        eyeIcon.classList.toggle('fa-eye');
        eyeIcon.classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>