<?php
session_start();
// Using your established path and variable
include("../includes/db.php"); 

if(isset($_POST['login'])){
    // Sanitize input to prevent SQL Injection
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password = $_POST['password'];

    // Change $conn to $link to match your db.php
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

<div class="login-body">
    <div class="login-box">
        <h2>Admin Login</h2>
        <form method="POST">
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button name="login">Login</button>
        </form>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </div>
</div>