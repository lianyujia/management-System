<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email'])) {
    $input_email = $_POST['email']; // user input

    $query = "SELECT * FROM patreg";
    $result = mysqli_query($con, $query);

    if (!$result) {
        echo "Database query failed: " . mysqli_error($con);
        exit();
    }

    $email_found = false; // track if email is found

    while ($row = mysqli_fetch_assoc($result)) {
        $encrypted_email = $row['email']; // encrypted email
        $iv = $row['email_iv']; // IV stored in the database

        // decrypt email
        $decrypted_email = decryptData($encrypted_email, $iv);

        // compare decrypted email with the user-entered email
        if ($decrypted_email === $input_email) {
            $email_found = true;

            // generate temporary password
            $temp_password = bin2hex(random_bytes(4)); // Random 8-character password
            $hashed_password = password_hash($temp_password, PASSWORD_DEFAULT);

            // update password in database
            $update_stmt = $con->prepare("UPDATE patreg SET password = ? WHERE email = ?");
            $update_stmt->bind_param("ss", $hashed_password, $encrypted_email); // Use encrypted email for update

            if ($update_stmt->execute()) {
                // send email 
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = $_ENV['EMAIL_USERNAME'];
                    $mail->Password = $_ENV['EMAIL_PASSWORD'];
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom($_ENV['EMAIL_USERNAME'], 'Admin');
                    $mail->addAddress($input_email); 
                    $mail->isHTML(true);
                    $mail->Subject = "Password Reset Request";
                    $mail->Body = "<p>Dear User,</p>
                        <p>Your temporary password is: <strong>$temp_password</strong></p>
                        <p>Please log in with this temporary password and change it after logging in.</p>";

                        if ($mail->send()) {
                            echo "<script>
                                alert('Email sent successfully. Please check your inbox for the temporary password.');
                                window.location.href = 'index.php'; 
                            </script>";
                        } 
                } catch (Exception $e) {
                    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Failed to update password in database.";
            }
            break; 
        }
    }

    if (!$email_found) {
        echo "<p>Email not found in our records.</p>";
    }
}
?>
