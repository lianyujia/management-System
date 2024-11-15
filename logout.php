<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// load .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$con = mysqli_connect("localhost", "root", "", "myhmsdb");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!function_exists('encryptData')) {
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
}

if (isset($_SESSION['pid']) || isset($_SESSION['doc_id']) || isset($_SESSION['username'])) {

  // get the user
  $pid = $_SESSION['pid'] ?? null; // patients
  $doc_id = $_SESSION['doc_id'] ?? null; // doctors
  $admin = $_SESSION['username'] ?? null; // admin
  date_default_timezone_set('Asia/Kuala_Lumpur'); 
  $logoutTime = date('Y-m-d H:i:s'); 

  $encryptedLogoutTime = encryptData($logoutTime);

  if ($pid) {
    // Patient logout
    if (isset($_SESSION['activity_log_id'])) {
        $activityLogId = $_SESSION['activity_log_id'];

        date_default_timezone_set('Asia/Kuala_Lumpur');
        $logoutTime = date('Y-m-d H:i:s');
        $encryptedLogoutTime = encryptData($logoutTime);

        // set logout time based on activity_log ID
        $updateQuery = "
            UPDATE activity_log 
            SET logout = '" . $encryptedLogoutTime['data'] . "', 
                logout_iv = '" . $encryptedLogoutTime['iv'] . "' 
            WHERE log_id = $activityLogId
        ";

        if (mysqli_query($con, $updateQuery)) {
            // successfully updated the logout time
            session_destroy(); // destroy the session
            header("Location: index.php"); 
            exit();
        } else {
            echo "<script>
                alert('Error updating logout time. Please try again.');
                window.location.href = 'admin-panel.php';
                </script>";
        }
    } else {
        echo "<script>
            alert('No active session found. Please log in again.');
            window.location.href = 'index.php';
            </script>";
    }


  } elseif ($doc_id) {
    // Doctor logout
    if (isset($_SESSION['activity_log_id'])) {
        $activityLogId = $_SESSION['activity_log_id'];

        date_default_timezone_set('Asia/Kuala_Lumpur');
        $logoutTime = date('Y-m-d H:i:s');
        $encryptedLogoutTime = encryptData($logoutTime);

        // set logout time based on activity_log ID
        $updateQuery = "
            UPDATE activity_log 
            SET logout = '" . $encryptedLogoutTime['data'] . "', 
                logout_iv = '" . $encryptedLogoutTime['iv'] . "' 
            WHERE log_id = $activityLogId
        ";

        if (mysqli_query($con, $updateQuery)) {
            // successfully updated the logout time
            session_destroy(); // destroy the session
            header("Location: index.php"); 
            exit();
        } else {
            echo "<script>
                alert('Error updating logout time. Please try again.');
                window.location.href = 'doctor-panel.php';
                </script>";
        }
    } else {
        echo "<script>
            alert('No active session found. Please log in again.');
            window.location.href = 'index.php';
            </script>";
    }


  } elseif ($admin) {
    // Admin logout
    if (isset($_SESSION['activity_log_id'])) {
        $activityLogId = $_SESSION['activity_log_id'];

        date_default_timezone_set('Asia/Kuala_Lumpur');
        $logoutTime = date('Y-m-d H:i:s');
        $encryptedLogoutTime = encryptData($logoutTime);

        // Update query to set logout time based on activity_log ID
        $updateQuery = "
            UPDATE activity_log 
            SET logout = '" . $encryptedLogoutTime['data'] . "', 
                logout_iv = '" . $encryptedLogoutTime['iv'] . "' 
            WHERE log_id = $activityLogId
        ";

        if (mysqli_query($con, $updateQuery)) {
            // Successfully updated the logout time
            session_destroy(); // Destroy the session
            header("Location: index.php"); // Redirect to the login page
            exit();
        } else {
            echo "<script>
                alert('Error updating logout time. Please try again.');
                window.location.href = 'admin-panel1.php';
                </script>";
        }
    } else {
        echo "<script>
            alert('No active session found. Please log in again.');
            window.location.href = 'index.php';
            </script>";
    }
}


  if (mysqli_query($con, $updateQuery)) {

      session_destroy(); // end the session
  } else {
      echo "Error updating logout time: " . mysqli_error($con);
  }
} else {
  session_destroy(); 
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <style >
      .btn-outline-light:hover {
        color: #0076d4;
        background-color: #f8f9fa;
        border-color: #f8f9fa;
}
    </style>
  </head>
  <body style="background: -webkit-linear-gradient(left, #3931af, #00c6ff);color:white;padding-top:100px;text-align:center;">
    <h3>You have logged out.</h3><br><br>
    <a href="index1.php" class="btn btn-outline-light">Back to Login Page</a>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  </body>
</html>