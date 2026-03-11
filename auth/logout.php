<?php
session_start();
session_destroy(); // Clears the user data
header("location: login.php"); // Sends you back to the start
exit;
?>