<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// load .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function encryptData($data) {
    $encryptionKey = $_ENV['ENCRYPTION_KEY']; 
    $cipherMethod = $_ENV['CIPHER_METHOD']; 
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));
    $encrypted = openssl_encrypt($data, $cipherMethod, $encryptionKey, 0, $iv);
    return [
        'data' => $encrypted,
        'iv' => base64_encode($iv) 
    ];
}

$con = mysqli_connect("localhost", "root", "", "myhmsdb");

if (isset($_POST['btnSubmit'])) {
    $name = $_POST['txtName'];
    $email = $_POST['txtEmail'];
    $contact = $_POST['txtPhone'];
    $message = $_POST['txtMsg'];

    // encrypt email, contact, and message
    $encryptedEmail = encryptData($email);
    $encryptedContact = encryptData($contact);
    $encryptedMessage = encryptData($message);

    // insert into database
    $query = "INSERT INTO contact (name, email, contact, message, email_iv, contact_iv, message_iv) VALUES (
        '$name',
        '" . $encryptedEmail['data'] . "',
        '" . $encryptedContact['data'] . "',
        '" . $encryptedMessage['data'] . "',
        '" . $encryptedEmail['iv'] . "',
        '" . $encryptedContact['iv'] . "',
        '" . $encryptedMessage['iv'] . "'
    );";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo '<script type="text/javascript">'; 
        echo 'alert("Message sent successfully!");'; 
        echo 'window.location.href = "contact.html";';
        echo '</script>';
    }
}
?>
