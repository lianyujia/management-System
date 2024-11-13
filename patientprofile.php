<?php 
include('func1.php');
include('session_tracking.php');
$con = mysqli_connect("localhost", "root", "", "myhmsdb");
use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

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

function decryptData($encryptedData, $iv) {
    $encryptionKey = $_ENV['ENCRYPTION_KEY']; 
    $cipherMethod = $_ENV['CIPHER_METHOD']; 
    $decodedIV = base64_decode($iv);
    return openssl_decrypt($encryptedData, $cipherMethod, $encryptionKey, 0, $decodedIV);
}

function validatePassword($password) {
    if (strlen($password) < 6) {
        return "Password must be at least 6 characters long.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        return "Password must include at least one uppercase letter.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        return "Password must include at least one lowercase letter.";
    }
    if (!preg_match('/\d/', $password)) {
        return "Password must include at least one number.";
    }
    if (!preg_match('/[\W_]/', $password)) {
        return "Password must include at least one special character.";
    }
    return true;
}

// fetch doctor's profile data
$pId = $_SESSION['pid'];
$query = "SELECT pid, fname, lname, email, email_iv, gender, gender_iv, contact, contact_iv FROM patreg WHERE pid = '$pId'";
$result = mysqli_query($con, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $decryptedEmail = decryptData($row['email'], $row['email_iv']);
    $name = $row['fname'] . " " . $row['lname'];
    $gender = decryptData($row['gender'], $row['gender_iv']);
    $contact = decryptData($row['contact'], $row['contact_iv']);
} else {
    $decryptedEmail = '';
    $name = '';
    $gender = '';
    $contact = '';
}

// send otp
$otpSentFlag = false;
$passwordInput = '';

if (isset($_POST['send_otp'])) {
    $passwordInput = $_POST['password'];
    $email = $_POST['email'];

    $passwordValidation = validatePassword($passwordInput);
    if ($passwordValidation !== true) {
        echo "<script>alert('$passwordValidation');</script>";
    } else if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expiry'] = time() + 120;

        // send OTP via email
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['EMAIL_USERNAME']; 
            $mail->Password = $_ENV['EMAIL_PASSWORD']; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($_ENV['EMAIL_USERNAME'], 'Admin');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body    = "Your OTP code is <b>$otp</b>. This code is valid for 2 minutes.";

            $mail->send();
            $otpSentFlag = true; // set the flag
        } catch (Exception $e) {
            echo "<script>alert('Failed to send OTP. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Invalid email address!');</script>";
    }
}

if (isset($_POST['validate_otp'])) {
    $enteredOtp = $_POST['otp'];
    $newPassword = $_POST['password'];

    if (empty($enteredOtp)) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    document.getElementById('otp-section').style.display = 'block';
                    document.getElementById('save-btn').style.display = 'none';
                    document.getElementById('verify-btn').style.display = 'inline-block';
                    alert('Please enter the OTP');
                });
              </script>";
    } else if ($_SESSION['otp'] == $enteredOtp && time() < $_SESSION['otp_expiry']) {
        // hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // update password
        $updateQuery = "UPDATE patreg SET password = ? WHERE pid = ?";
        $stmt = $con->prepare($updateQuery);
        $stmt->bind_param("ss", $hashedPassword, $pId);

        if ($stmt->execute()) {
            echo "<script>
            alert('Password reset successfully.');
            window.location.href = 'admin-panel.php';
          </script>";
        } else {
            echo "<script>alert('Error updating password. Please try again later.');</script>";
        }

        $stmt->close();
        // clear the OTP session data after successful password reset
        unset($_SESSION['otp'], $_SESSION['otp_expiry']);
    } else if ($_SESSION['otp'] != $enteredOtp && time() < $_SESSION['otp_expiry']) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    document.getElementById('otp-section').style.display = 'block';
                    document.getElementById('save-btn').style.display = 'none';
                    document.getElementById('verify-btn').style.display = 'inline-block';
                    alert('Invalid OTP. Please try again.');
                });
              </script>";
    } else {
        echo "<script>alert('OTP expired. Please request a new one.');</script>";
        unset($_SESSION['otp'], $_SESSION['otp_expiry']); 
    }
}


?>


<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <title>Doctor Profile</title>
    <style>
        #otp-section, #verify-btn {
            display: none;
        }
    </style>
  </head>
  <body style="padding-top:50px; font-family: 'IBM Plex Sans', sans-serif;">
    <div class="container">
      <h3 class="text-center">Patient Profile</h3>
      <div class="card mt-4">
        <div class="card-header bg-primary text-white">
          <h5>Profile Information</h5>
        </div>
        <div class="card-body">
          <form method="post">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" value="<?php echo htmlspecialchars($name); ?>" readonly>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($decryptedEmail); ?>" readonly>
            </div>
            <div class="form-group">
              <label for="spec">Gender</label>
              <input type="text" class="form-control" id="spec" value="<?php echo htmlspecialchars($gender); ?>" readonly>
            </div>
            <div class="form-group">
              <label for="fee">Contact Number</label>
              <input type="text" class="form-control" id="fee" value="<?php echo htmlspecialchars($contact); ?>" readonly>
            </div>
            <div class="form-group">
              <label for="password">New Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password">
              <input type="hidden" id="password-input-hidden" value="<?php echo htmlspecialchars($passwordInput); ?>">
              <span id="message"></span>
            </div>
            <div class="form-group" id="otp-section">
              <label for="otp">Enter OTP</label>
              <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP">
            </div>
            <input type="hidden" id="otp-sent-flag" value="<?php echo $otpSentFlag ? 'true' : 'false'; ?>">

            <div style="float: right;">
                <button type="button" id="discard-btn" class="btn btn-secondary">Discard</button>
                <button type="submit" id="save-btn" name="send_otp" class="btn btn-primary">Save</button>
                <button type="submit" id="verify-btn" name="validate_otp" class="btn btn-success">Verify OTP</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
   
    
    document.addEventListener('DOMContentLoaded', () => {
        const otpSentFlag = document.getElementById('otp-sent-flag').value;
        const passwordInputHidden = document.getElementById('password-input-hidden').value;

        // restore password input
        if (passwordInputHidden) {
            document.getElementById('password').value = passwordInputHidden;
        }

        // show OTP section if OTP was sent
        if (otpSentFlag === 'true') {
            otpSentSuccess();
        }
    });

    document.getElementById('save-btn').addEventListener('click', (event) => {
        const password = document.getElementById('password').value;
        const passwordValidationRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/;
        const message = document.getElementById('message'); 
        if (!passwordValidationRegex.test(password)) {
            event.preventDefault();
            message.innerText = 'Password must be at least 6 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.';
            message.style.color = 'red'; 
        } else {
            message.innerText = ''; 
        }
    });


    const otpSection = document.getElementById('otp-section');
    const saveBtn = document.getElementById('save-btn');
    const verifyBtn = document.getElementById('verify-btn');

    function otpSentSuccess() {
        alert('OTP sent successfully!');
        otpSection.style.display = 'block';
        saveBtn.style.display = 'none';
        verifyBtn.style.display = 'inline-block';
    }

    
</script>




    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </body>
</html>
