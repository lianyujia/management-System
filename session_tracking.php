<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

// check if the user is logged in
if (isset($_SESSION['username']) || isset($_SESSION['doc_id']) || isset($_SESSION['pid'])) {
    echo "<script>console.log('Session Active');</script>";

    if (isset($_SESSION['start_time']) && isset($_SESSION['end_time'])) {
        $end_time = $_SESSION['end_time'];
        $current_time = time();
        $time_left = $end_time - $current_time;

        echo "<script>
            console.log('Session End Time: {$end_time}');
            console.log('Current Time: {$current_time}');
            console.log('Time Left: {$time_left}');
            
            // Set up a timer to check session expiration
            setTimeout(() => {
                // Show an alert and wait for user confirmation before redirecting
                if (confirm('Your session has expired. Please log in again. Click OK to continue.')) {
                    console.log('Session Expired');
                    window.location.href = 'logout.php'; 
                } else {
                    console.log('User chose to stay on the page.');
                }
            }, {$time_left} * 1000); // Convert seconds to milliseconds
        </script>";
    } else {
        echo "<script>console.log('Session Time Variables Not Set');</script>";
    }
} else {
    // redirect to login page if session is not active
    echo "<script>console.log('Session Not Active');</script>";
    header("Location: index1.php");
    exit();
}


// record logout time in activity log
function recordLogoutTime($con) {
    if (isset($_SESSION['pid']) || isset($_SESSION['doc_id']) || isset($_SESSION['username'])) {
        $pid = $_SESSION['pid'] ?? null; // Patients
        $doc_id = $_SESSION['doc_id'] ?? null; // Doctors
        $admin = $_SESSION['username'] ?? null; // Admin
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $logoutTime = date('Y-m-d H:i:s');

        $encryptedLogoutTime = encryptData($logoutTime);

        if ($pid) {
            // Patient logout
            $updateQuery = "
                UPDATE activity_log 
                SET logout = '" . $encryptedLogoutTime['data'] . "', logout_iv = '" . $encryptedLogoutTime['iv'] . "' 
                WHERE pid = '$pid' 
                AND logout = '' 
                ORDER BY created_on DESC 
                LIMIT 1
            ";
        } elseif ($doc_id) {
            // Doctor logout
            $updateQuery = "
                UPDATE activity_log 
                SET logout = '" . $encryptedLogoutTime['data'] . "', logout_iv = '" . $encryptedLogoutTime['iv'] . "' 
                WHERE doc_id = '$doc_id' 
                AND logout = '' 
                ORDER BY created_on DESC 
                LIMIT 1
            ";
        } elseif ($admin) {
            // Admin logout
            $updateQuery = "
                UPDATE activity_log 
                SET logout = '" . $encryptedLogoutTime['data'] . "', logout_iv = '" . $encryptedLogoutTime['iv'] . "' 
                WHERE admin = '$admin' 
                AND logout = '' 
                ORDER BY created_on DESC 
                LIMIT 1
            ";
        }

        if (mysqli_query($con, $updateQuery)) {
            session_destroy(); // end the session
            echo "<script>console.log('Logout time recorded successfully.');</script>";
        } else {
            echo "<script>console.error('Error updating logout time: " . mysqli_error($con) . "');</script>";
        }
    }
}
