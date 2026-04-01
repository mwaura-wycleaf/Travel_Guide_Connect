<?php
// 1. Always start the session first
session_start();
require_once "../includes/db.php";

// 2. Updated Security Check: Match the new Unified Login variables
if(!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'guide'){
    // Redirect to the central login if they aren't a logged-in guide
    header("Location: ../auth/login.php");
    exit();
}

// 3. Check if the ID and Action are passed in the URL
if (isset($_GET['id']) && isset($_GET['action'])) {
    $booking_id = $_GET['id'];
    $action = $_GET['action'];
    $guide_id = $_SESSION['id']; // Using the unified session ID

    // Determine the new status based on the action parameter
    if ($action === 'confirm') {
        $new_status = 'confirmed';
    } elseif ($action === 'cancel') {
        $new_status = 'cancelled';
    } else {
        // Handle invalid manual URL tampering
        header("Location: manage_bookings.php?error=invalid_action");
        exit();
    }

    // 4. Update the database using Prepared Statements
    // We include guide_id in the WHERE clause as a security layer
    $stmt = $link->prepare("UPDATE bookings SET status = ? WHERE id = ? AND guide_id = ?");
    $stmt->bind_param("sii", $new_status, $booking_id, $guide_id);

    if ($stmt->execute()) {
        // Success! Redirect back with a success message
        // Using urlencode for the message to handle spaces safely in the URL
        header("Location: manage_bookings.php?msg=" . urlencode("Booking " . ucfirst($new_status)));
    } else {
        // Technical error handling
        echo "Error updating record: " . $stmt->error;
    }
    $stmt->close();
    
} else {
    // If parameters are missing, just go back to the list
    header("Location: manage_bookings.php");
    exit();
}
?>