<?php

header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$con = mysqli_connect("localhost", "root", "", "myhmsdb");
if (!$con) {
    echo json_encode(['error' => 'Database connection failed: ' . mysqli_connect_error()]);
    exit;
}

use Dotenv\Dotenv;
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (!isset($_GET['date'])) {
    echo json_encode(['error' => 'No date provided.']);
    exit;
}

$selectedDate = $_GET['date'];

// date format is valid (YYYY-MM-DD)
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $selectedDate)) {
    echo json_encode(['error' => 'Invalid date format. Expected YYYY-MM-DD.']);
    exit;
}

function encryptData($data) {
    $encryptionKey = $_ENV['ENCRYPTION_KEY'];
    $cipherMethod = $_ENV['CIPHER_METHOD'];
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));
    $encrypted = openssl_encrypt($data, $cipherMethod, $encryptionKey, 0, $iv);
    return ['data' => $encrypted, 'iv' => base64_encode($iv)];
}

function decryptData($encryptedData, $iv) {
    $encryptionKey = $_ENV['ENCRYPTION_KEY'];
    $cipherMethod = $_ENV['CIPHER_METHOD'];
    $decodedIV = base64_decode($iv);
    return openssl_decrypt($encryptedData, $cipherMethod, $encryptionKey, 0, $decodedIV);
}

// fetch login data
function getDailyLogins($con, $selectedDate) {
    $query = "
        SELECT created_on, login, login_iv, logout, logout_iv
        FROM activity_log
        WHERE created_on IS NOT NULL
          AND DATE(created_on) = '$selectedDate'"; 

    $result = mysqli_query($con, $query);
    if (!$result) {
        throw new Exception('Database query failed: ' . mysqli_error($con));
    }

    $hourlyLogins = array_fill(0, 24, 0); 
    $totalDuration = 0;
    $recordCount = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        // only decrypt `login` and `logout` for rows matching the date
        $decryptedLogin = decryptData($row['login'], $row['login_iv']);
        $decryptedLogout = decryptData($row['logout'], $row['logout_iv']);

        if ($decryptedLogin && $decryptedLogout) {
            $loginTime = strtotime($decryptedLogin);
            $logoutTime = strtotime($decryptedLogout);
            $sessionDuration = ($logoutTime - $loginTime) / 60.0; // duration in minutes 

            $hour = (int)date('H', $loginTime);
            $hourlyLogins[$hour]++; // increment login count for that hour
            $totalDuration += $sessionDuration;
            $recordCount++;
        }
    }

    // calculate average duration (rounded to 2 decimal places)
    $averageDuration = $recordCount > 0 ? round($totalDuration / $recordCount, 2) : 0;

    return [
        'hourlyLogins' => $hourlyLogins,
        'averageDuration' => $averageDuration,
        'recordCount' => $recordCount,
    ];
}

// return login data
try {
 
    error_log("Received date: $selectedDate");

    $loginsData = getDailyLogins($con, $selectedDate);

    error_log("Response data: " . json_encode($loginsData));

    echo json_encode($loginsData);
    exit;
} catch (Exception $e) {
    echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
    exit;
}
