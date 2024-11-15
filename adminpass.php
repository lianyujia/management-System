<?php
include('func3.php');
// Include Dotenv for loading .env variables
require __DIR__ . '/vendor/autoload.php'; // Ensure you have this for Dotenv to work
use Dotenv\Dotenv;

// Load environment variables from the .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database connection (use credentials from .env)
$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_NAME'];

// Create connection
$con = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Assuming the new password is stored in the .env file
$newPassword = $_ENV['ADMIN_PASWORD'];  // Load the password from the .env file

// Encrypt the new password using the encryption key and cipher method from .env
$encryptionKey = $_ENV['ENCRYPTION_KEY'];
$cipherMethod = $_ENV['CIPHER_METHOD']; 
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));
$encryptedPassword = openssl_encrypt($newPassword, $cipherMethod, $encryptionKey, 0, $iv);

// Base64 encode the IV for storage
$encryptedIv = base64_encode($iv);

// SQL query to update password and store the IV in the database
$query = "UPDATE admintb SET password='$encryptedPassword', password_iv='$encryptedIv' WHERE username='admin';";
$result = mysqli_query($con, $query);

// Check if the password was updated successfully
if ($result) {
    echo "Password updated successfully.";
} else {
    echo "Error updating password: " . mysqli_error($con); // Provide more details on error
}

// Close the database connection
mysqli_close($con);
?>
