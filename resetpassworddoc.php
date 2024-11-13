<?php
include('resetpassworddoc.html');
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

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email'])) {
    $input_email = $_POST['email'];
    $_SESSION['input_email'] = $input_email;

    // find email in the database
    $query = "SELECT * FROM doctb";
    $result = mysqli_query($con, $query);
    if (!$result) {
        echo "Database query failed: " . mysqli_error($con);
        exit();
    }

    $email_found = false;
    while ($row = mysqli_fetch_assoc($result)) {
        $encrypted_email = $row['email'];
        $iv = $row['email_iv'];
        $decrypted_email = decryptData($encrypted_email, $iv);

        if ($decrypted_email === $input_email) {
            $email_found = true;
            $_SESSION['email'] = $encrypted_email;

            // generate OTP, store in session, and set expiry time (2 minutes from now)
            $otp = random_int(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_expiry'] = time() + 120; // 2 minutes from now

            // send OTP email
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
                $mail->Subject = "OTP for Password Reset";
                $mail->Body = "<p>Your OTP is: <strong>$otp</strong> .The OTP will expire within 2 minutes.</p>";

                if ($mail->send()) {
                    echo "<script>
                        alert('OTP sent to your email. Please check your inbox.');
                        window.onload = function() { showOtpSection(); };
                    </script>";
                }
            } catch (Exception $e) {
                echo "OTP email could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            break;
        }
    }

    if (!$email_found) {
        echo "<script>alert('Email not found in our records.');</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['otp'])) {
    if (isset($_SESSION['otp']) && isset($_SESSION['otp_expiry'])) {
        $current_time = time();
        if ($current_time > $_SESSION['otp_expiry']) {
            echo "<script>
                alert('OTP has expired. Please request a new one.');
                window.onload = function() { document.getElementById('email-section').style.display = 'block'; document.getElementById('otp-section').style.display = 'none'; };
            </script>";
            unset($_SESSION['otp'], $_SESSION['otp_expiry']);
        } elseif ($_POST['otp'] == $_SESSION['otp']) {
            // generate temporary password
            $temp_password = bin2hex(random_bytes(4));
            $hashed_password = password_hash($temp_password, PASSWORD_DEFAULT);

            $update_stmt = $con->prepare("UPDATE doctb SET password = ? WHERE email = ?");
            $update_stmt->bind_param("ss", $hashed_password, $_SESSION['email']);

            if ($update_stmt->execute()) {
                // send temporary password
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
                    $mail->addAddress($_SESSION['input_email']);
                    $mail->isHTML(true);
                    $mail->Subject = "Temporary Password";
                    $mail->Body = "<p>Your temporary password is: <strong>$temp_password</strong></p>";

                    if ($mail->send()) {
                        echo "<script>
                            alert('Temporary password sent. Please check your inbox.');
                            window.location.href = 'index.php';
                        </script>";
                    }
                } catch (Exception $e) {
                    echo "Temporary password email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        } else {
            echo "<script>
                alert('Invalid OTP. Please try again.');
                window.onload = function() { document.getElementById('email-section').style.display = 'block'; document.getElementById('otp-section').style.display = 'none'; };
            </script>";
        }
    }
}
?>