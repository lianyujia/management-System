<?php
use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

session_start(); 

$con = mysqli_connect("localhost", "root", "", "myhmsdb");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// read JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

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

if (isset($data['docId'])) {
    $docId = $data['docId'];
    $username = $data['username'];
    $spec = $data['spec'];
    $email = $data['email'];
    $fees = $data['fees'];

    $encryptedSpec = encryptData($spec);
    $encryptedEmail = encryptData($email);
    $encryptedFees = encryptData($fees);

    // update doctor data
    $query = "
        UPDATE doctb 
        SET username = ?, spec = ?, spec_iv = ?, email = ?, email_iv = ?, docFees = ?, doc_Fees_iv = ? 
        WHERE doc_id = ?
    ";

    $stmt = $con->prepare($query);
    $stmt->bind_param(
        "sssssssi",
        $username,
        $encryptedSpec['data'],
        $encryptedSpec['iv'],
        $encryptedEmail['data'],
        $encryptedEmail['iv'],
        $encryptedFees['data'],
        $encryptedFees['iv'],
        $docId
    );

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);

        // log the update activity
        if (!empty($_SESSION['username'])) {
            $activity = "Updated doctor: $username";
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

        $mail = new PHPMailer(true);
        try {
          
          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com'; 
          $mail->SMTPAuth = true;
          $mail->Username = $_ENV['EMAIL_USERNAME']; 
          $mail->Password = $_ENV['EMAIL_PASSWORD']; 
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
          $mail->Port = 587;
      
          // email settings
          $mail->setFrom($_ENV['EMAIL_USERNAME'], 'Admin'); 
            $mail->addAddress($email, $username);

            $mail->isHTML(true);
            $mail->Subject = 'Security Alert: Global Hospital Profile Updated';
            $mail->Body = "
                <p>Dear $username,</p>
                <p>Your profile was recently updated. If this was not you, please contact our support team immediately.</p>
                <p>Thank you,<br>Support Team</p>
            ";

            $mail->send();
        } catch (Exception $e) {
            error_log("Email could not be sent. Error: {$mail->ErrorInfo}");
        }
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid data.']);
}

mysqli_close($con);

?>
