<?php
session_start();
require 'database_connection.php'; // Ensure the database connection is included

if (isset($_POST['confirm_payment'])) {
    $billID = $_POST['ID'];
    $cardNumber = $_POST['card_number'];
    $expiryDate = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $cardholderName = $_POST['cardholder_name'];

    // Optional: Add validation for payment details here

    // Process payment logic here
    // For example, mark the bill as paid in the database
    $query = "UPDATE bills SET status='Paid' WHERE ID=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $billID);
    if ($stmt->execute()) {
        echo "<script>alert('Payment successful!'); window.location.href='admin-panel.php';</script>";
    } else {
        echo "<script>alert('Payment failed. Please try again.'); window.location.href='payment-details.php?ID=" . $billID . "';</script>";
    }
}
?>
