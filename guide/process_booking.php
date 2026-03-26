<?php
session_start();
require_once "../includes/db.php";

// 1. Security Check: Only logged-in guides can process bookings
if (!isset($_SESSION['guide_id'])) {
    header("Location: guide_login.php");
    exit();
}

// 2. Check if the ID and Action are passed in the URL
if (isset($_GET['id']) && isset($_GET['action'])) {
    $booking_id = mysqli_real_escape_string($link, $_GET['id']);
    $action = $_GET['action'];
    $guide_id = $_SESSION['guide_id'];

    // Determine the new status based on the button clicked
    if ($action === 'confirm') {
        $new_status = 'Confirmed';
    } elseif ($action === 'cancel') {
        $new_status = 'Cancelled';
    } else {
        // If someone messes with the URL manually
        header("Location: manage_bookings.php?error=invalid_action");
        exit();
    }

    // 3. Update the database
    // We include guide_id in the WHERE clause so a guide can't accidentally cancel someone else's booking
    $sql = "UPDATE bookings SET status = '$new_status' WHERE id = '$booking_id' AND guide_id = '$guide_id'";

    if (mysqli_query($link, $sql)) {
        // Success! Redirect back with a success message
        header("Location: manage_bookings.php?msg=Booking " . $new_status);
    } else {
        echo "Error updating record: " . mysqli_error($link);
    }
} else {
    // If IDs are missing
    header("Location: manage_bookings.php");
}
?>