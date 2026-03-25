<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Clear the specific variables the Auth script looks for
unset($_SESSION['guide_id']);
unset($_SESSION['role']);

// 2. Destroy the entire session memory
$_SESSION = array();
session_destroy();

// 3. Clear the session cookie (Force the browser to forget)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Redirect to the login page
header("Location: ../guide_login.php?status=loggedout");
exit();
?>