<?php

include('func3.php');

// Database connection (make sure to replace with your credentials)
$servername = "localhost";
$username = "root";
$password = "";  // Database password
$dbname = "myhmsdb";

// Create connection
$con = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}


// Assuming $newPassword is the new password you want to set
$newPassword = 'Admin@123!';

// Encrypt the new password
$encryptionKey = $_ENV['ENCRYPTION_KEY'];
$cipherMethod = $_ENV['CIPHER_METHOD']; 
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));
$encryptedPassword = openssl_encrypt($newPassword, $cipherMethod, $encryptionKey, 0, $iv);

// Save the encrypted password and IV in the database
$encryptedIv = base64_encode($iv); // Base64 encode the IV for storage

// SQL query to update password and store the IV
$query = "UPDATE admintb SET password='$encryptedPassword', password_iv='$encryptedIv' WHERE username='admin';";
$result = mysqli_query($con, $query);

if ($result) {
    echo "Password updated successfully.";
} else {
    echo "Error updating password.";
}
?>

