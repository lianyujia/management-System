<?php
session_start();

use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$con = mysqli_connect("localhost", "root", "", "myhmsdb");
if (!$con) {
    die(json_encode(['success' => false, 'error' => 'Database connection failed']));
}

function encryptData($data) {
    $encryptionKey = $_ENV['ENCRYPTION_KEY'];
    $cipherMethod = $_ENV['CIPHER_METHOD'];
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));
    $encrypted = openssl_encrypt($data, $cipherMethod, $encryptionKey, 0, $iv);
    return [
        'data' => $encrypted,
        'iv' => base64_encode($iv),
    ];
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['pid'], $data['fname'], $data['lname'], $data['email'], $data['contact'])) {
    $pid = $data['pid'];
    $fname = $data['fname'];
    $lname = $data['lname'];
    $email = $data['email'];
    $contact = $data['contact'];

    // Encrypt updated values
    $encryptedEmail = encryptData($email);
    $encryptedContact = encryptData($contact);

    $query = "
        UPDATE patreg 
        SET fname = ?, lname = ?, email = ?, email_iv = ?, contact = ?, contact_iv = ?
        WHERE pid = ?
    ";
    $stmt = $con->prepare($query);
    $stmt->bind_param(
        "ssssssi",
        $fname,
        $lname,
        $encryptedEmail['data'],
        $encryptedEmail['iv'],
        $encryptedContact['data'],
        $encryptedContact['iv'],
        $pid
    );

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
        // Log the update activity
        if (!empty($_SESSION['username'])) {
            $activity = "Updated patient: " . $fname . " " . $lname;
            $encryptedActivity = encryptData($activity);

            date_default_timezone_set('Asia/Kuala_Lumpur');
            $created_on = date('Y-m-d H:i:s');

            $admin = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown';

            $logQuery = "
                INSERT INTO activity_log (activity, activity_iv, created_on, admin) 
                VALUES (?, ?, ?, ?)
            ";
            $logStmt = $con->prepare($logQuery);
            $logStmt->bind_param(
                "ssss",
                $encryptedActivity['data'],
                $encryptedActivity['iv'],
                $created_on,
                $admin
            );

            if (!$logStmt->execute()) {
                error_log("Failed to log activity: " . $logStmt->error);
            }
        } else {
            error_log("Activity log skipped: Admin username not found in session.");
        }
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
}
?>
