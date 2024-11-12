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

$selectedDate = $_GET['date'] ?? null;
$doctor = $_GET['doctor'] ?? null;
$fetchDoctors = isset($_GET['fetchDoctors']) && $_GET['fetchDoctors'] === 'true';

if ($selectedDate && !preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $selectedDate)) {
    echo json_encode(['error' => 'Invalid date format. Expected DD/MM/YYYY.']);
    exit;
}

$formattedDate = null;
if ($selectedDate) {
    list($day, $month, $year) = explode('/', $selectedDate);
    $formattedDate = "$year-$month-$day"; // convert to YYYY-MM-DD
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

// fetch doctors if selected
if ($fetchDoctors) {
    try {
        if (!$selectedDate) {
            echo json_encode(['error' => 'Date is required to fetch doctors.']);
            exit;
        }

        // get doctors involved for the selected date appointment
        $query = "
            SELECT DISTINCT a.doctor, a.appdate, a.appdate_iv
            FROM appointmenttb a
            WHERE a.appdate IS NOT NULL
              AND a.apptime IS NOT NULL
              AND a.appdate_iv IS NOT NULL
              AND a.apptime_iv IS NOT NULL
        ";

        $result = mysqli_query($con, $query);
        if (!$result) {
            throw new Exception('Query failed: ' . mysqli_error($con));
        }

        $doctors = [];
        $addedDoctors = []; 

        while ($row = mysqli_fetch_assoc($result)) {
            $decryptedDate = decryptData($row['appdate'], $row['appdate_iv']);

            // check if decrypted date matches the selected date
            if ($decryptedDate === $formattedDate) {
                $doc_id = $row['doctor'];

                if (in_array($doc_id, $addedDoctors)) {
                    continue;
                }

                // fetch the username for the doc_id from doctb
                $doctorQuery = "
                    SELECT username 
                    FROM doctb 
                    WHERE doc_id = '" . mysqli_real_escape_string($con, $doc_id) . "'
                ";
                $doctorResult = mysqli_query($con, $doctorQuery);
                if ($doctorResult) {
                    $doctorRow = mysqli_fetch_assoc($doctorResult);
                    if ($doctorRow) {
                        $doctors[] = [
                            'doc_id' => $doc_id, 
                            'username' => $doctorRow['username']
                        ];
                        $addedDoctors[] = $doc_id; 
                    }
                }
            }
        }

        echo json_encode(['doctors' => $doctors]);
        exit;
    } catch (Exception $e) {
        echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
        exit;
    }
}


// get appointment data
function getAppointmentsByDate($con, $formattedDate, $doctor = null) {
    $query = "
        SELECT appdate, appdate_iv, apptime, apptime_iv, doctor
        FROM appointmenttb
        WHERE appdate IS NOT NULL AND apptime IS NOT NULL
    ";

    if ($doctor) {
        $query .= " AND doctor = '" . mysqli_real_escape_string($con, $doctor) . "'";
    }

    $result = mysqli_query($con, $query);
    if (!$result) {
        throw new Exception('Query failed: ' . mysqli_error($con));
    }

    $hourlyAppointments = array_fill(0, 24, 0);
    $doctorAppointments = array_fill(0, 24, 0); 
    $totalAppointments = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $decryptedDate = $row['appdate'] && $row['appdate_iv']
            ? decryptData($row['appdate'], $row['appdate_iv'])
            : $row['appdate'];

        $decryptedTime = $row['apptime'] && $row['apptime_iv']
            ? decryptData($row['apptime'], $row['apptime_iv'])
            : $row['apptime'];

        if (!$decryptedDate || !$decryptedTime) {
            continue; 
        }

        if ($decryptedDate === $formattedDate) {
            $hour = (int)date('H', strtotime($decryptedTime));
            $hourlyAppointments[$hour]++;
            $totalAppointments++;

            if ($doctor && $row['doctor'] === $doctor) {
                $doctorAppointments[$hour]++;
            }
        }
    }

    return [
        'hourlyAppointments' => $hourlyAppointments,
        'doctorAppointments' => $doctorAppointments, 
        'recordCount' => $totalAppointments,
    ];
}


// fetch appointment data
if ($selectedDate) {
    try {
        $appointmentData = getAppointmentsByDate($con, $formattedDate, $doctor);
        echo json_encode($appointmentData);
        exit;
    } catch (Exception $e) {
        echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
        exit;
    }
}

echo json_encode(['error' => 'Invalid request.']);
exit;
?>
