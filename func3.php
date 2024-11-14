<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$con = mysqli_connect("localhost", "root", "", "myhmsdb");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!function_exists('encryptData')) {
    function encryptData($data) {
        $encryptionKey = $_ENV['ENCRYPTION_KEY']; // Get the encryption key from .env
        $cipherMethod = $_ENV['CIPHER_METHOD'];   // Get the cipher method from .env
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));
        $encrypted = openssl_encrypt($data, $cipherMethod, $encryptionKey, 0, $iv);
        return [
            'data' => $encrypted,
            'iv' => base64_encode($iv) // Store IV in base64
        ];
    }
}

if (!function_exists('decryptData')) {
    function decryptData($encryptedData, $iv) {
        $encryptionKey = $_ENV['ENCRYPTION_KEY']; // Get the encryption key from .env
        $cipherMethod = $_ENV['CIPHER_METHOD'];   // Get the cipher method from .env
        $iv = base64_decode($iv);  // Decode the IV from base64
        $decrypted = openssl_decrypt($encryptedData, $cipherMethod, $encryptionKey, 0, $iv);
        return $decrypted;
    }
}

if (isset($_POST['adsub'])) {
    $username = $_POST['username1'];
    $password = $_POST['password2'];

    // Fetch the encrypted password and IV from the database
    $query = "SELECT password, password_iv FROM admintb WHERE username='$username';";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $encryptedPassword = $row['password'];
        $passwordIv = $row['password_iv'];

        // Decrypt the password from the database
        $decryptedPassword = decryptData($encryptedPassword, $passwordIv);

        // Check if the decrypted password matches the input password
        if ($decryptedPassword == $password) {
            $_SESSION['username'] = $username;
            $_SESSION['start_time'] = time(); // current time
            $_SESSION['expiration_time'] = 1800; // expiration time in 30 minutes
            $_SESSION['end_time'] = $_SESSION['start_time'] + $_SESSION['expiration_time'];

            // Generate and set new CSRF token
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $csrf_token = $_SESSION['csrf_token'];

            // Update CSRF token in the database
            $update_query = "UPDATE admintb SET csrf_token='$csrf_token' WHERE username='$username';";
            mysqli_query($con, $update_query);

            // Insert into activity log
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $loginTime = date('Y-m-d H:i:s');
            $activity = "Admin logged in";

            $encryptedActivity = encryptData($activity);
            $encryptedLoginTime = encryptData($loginTime);

            $logQuery = "
                INSERT INTO activity_log (
                    activity, activity_iv, 
                    admin, 
                    login, login_iv, 
                    created_on
                ) VALUES (
                    '" . $encryptedActivity['data'] . "', '" . $encryptedActivity['iv'] . "',
                    '$username',
                    '" . $encryptedLoginTime['data'] . "', '" . $encryptedLoginTime['iv'] . "',
                    NOW()
                )
            ";

            if (mysqli_query($con, $logQuery)) {
                // Logged successfully
                header("Location: admin-panel1.php");
                exit();
            } else {
                echo "<script>
                    alert('Error logging activity. Please try again.');
                    window.location.href = 'index.php';
                    </script>";
            }
        } else {
            echo("<script>alert('Invalid Username or Password. Try Again!');
                window.location.href = 'index.php';</script>");
        }
    } else {
        echo("<script>alert('Invalid Username or Password. Try Again!');
            window.location.href = 'index.php';</script>");
    }
}
?>