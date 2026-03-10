<?php

$server = "localhost";
$user = "root";
$password = "";
$database = "travel_guide_connect";
$port = 3307; // Add your custom MySQL port here

// Include the port in mysqli_connect
$link = mysqli_connect($server, $user, $password, $database, $port);

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

?>