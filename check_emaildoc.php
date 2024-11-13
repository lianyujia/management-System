<?php

session_start();
require_once __DIR__ . '/vendor/autoload.php';  
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$con = mysqli_connect("localhost", "root", "", "myhmsdb");
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

function decryptData($encryptedData, $iv) {
    $encryptionKey = $_ENV['ENCRYPTION_KEY'];
    $cipherMethod = $_ENV['CIPHER_METHOD'];
    $decodedIV = base64_decode($iv);
    return openssl_decrypt($encryptedData, $cipherMethod, $encryptionKey, 0, $decodedIV);
}

if (isset($_POST['email'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']); 

    // get the encrypted emails from the database
    $email_check_query = "SELECT email, email_iv FROM doctb"; 
    $email_check_result = mysqli_query($con, $email_check_query);

    if ($email_check_result === false) {
        echo "Query failed: " . mysqli_error($con);
        exit();
    }

    // check if email exists
    $email_found = false;

    // loop through and decrypt each email
    while ($row = mysqli_fetch_assoc($email_check_result)) {
        $encrypted_email = $row['email'];
        $iv = $row['email_iv'];
        
        $decrypted_email = decryptData($encrypted_email, $iv);

        // compare decrypted email with the input email
        if ($decrypted_email === $email) {
            $email_found = true;
            break; // email is found
        }
    }

    if ($email_found) {
        echo "exists"; // email exists
    } else {
        echo "available"; // email is available, can proceed
    }
} else {

    echo "No email provided.";
}
?>
