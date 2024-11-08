<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include('contact.php'); // Make sure this file connects to your database

if (isset($_POST['email'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']); // Sanitize the email input

    // Query to check if the email exists in the database
    $email_check_query = "SELECT * FROM patreg WHERE email = '$email' LIMIT 1";
    $email_check_result = mysqli_query($con, $email_check_query);

    if ($email_check_result === false) {
        // If query fails, output an error message
        echo "Query failed: " . mysqli_error($con);
        exit();
    }

    if (mysqli_num_rows($email_check_result) > 0) {
        echo "exists"; // Email exists
    } else {
        echo "available"; // Email is available
    }
}
?>
