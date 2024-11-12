<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// load .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

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
        // send email to the system's official email
        try {
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['EMAIL_USERNAME']; 
            $mail->Password = $_ENV['EMAIL_PASSWORD']; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587; 

            // Recipients
            $mail->setFrom($_ENV['EMAIL_USERNAME'], 'System Admin');
            $mail->addAddress($_ENV['EMAIL_USERNAME']); 
            $mail->addReplyTo($email, $name); // reply-to set to sender's email

            // Content
            $mail->isHTML(true);
            $mail->Subject = "New Contact Us Submission";
            $mail->Body = "
                <h3>New Message from Contact Us Form</h3>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Contact:</strong> $contact</p>
                <p><strong>Message:</strong> $message</p>
            ";

            $mail->send();
            echo '<script type="text/javascript">'; 
            echo 'alert("Message sent successfully!");'; 
            echo 'window.location.href = "contact.html";';
            echo '</script>';
        } catch (Exception $e) {
            echo '<script type="text/javascript">'; 
            echo 'alert("Message saved but failed to send email. Error: ' . $mail->ErrorInfo . '");'; 
            echo 'window.location.href = "contact.html";';
            echo '</script>';
        }
    } else {
        echo '<script type="text/javascript">'; 
        echo 'alert("Failed to save message. Please try again.");'; 
        echo 'window.location.href = "contact.html";';
        echo '</script>';
    }
}
?>