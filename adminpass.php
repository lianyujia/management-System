<?php
include('func3.php');

require __DIR__ . '/vendor/autoload.php'; 
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_NAME'];

$con = mysqli_connect($servername, $username, $password, $dbname);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$newPassword = $_ENV['ADMIN_PASWORD'];  // load the password from the .env file

$encryptionKey = $_ENV['ENCRYPTION_KEY'];
$cipherMethod = $_ENV['CIPHER_METHOD']; 
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));
$encryptedPassword = openssl_encrypt($newPassword, $cipherMethod, $encryptionKey, 0, $iv);

// base64 encode the IV for storage
$encryptedIv = base64_encode($iv);

// update password and store the IV in the database
$query = "UPDATE admintb SET password='$encryptedPassword', password_iv='$encryptedIv' WHERE username='admin';";
$result = mysqli_query($con, $query);

// check if the password was updated successfully
if ($result) {
    echo "Password updated successfully.";
} else {
    echo "Error updating password: " . mysqli_error($con); 
}

mysqli_close($con);
?>
