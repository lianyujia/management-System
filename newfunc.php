<?php
// session_start();
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// load .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$con = mysqli_connect("localhost", "root", "", "myhmsdb");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!function_exists('decryptData')) {
    function decryptData($encryptedData, $iv) {
        $encryptionKey = $_ENV['ENCRYPTION_KEY'];
        $cipherMethod = $_ENV['CIPHER_METHOD'];

        $decodedIV = base64_decode($iv);
        return openssl_decrypt($encryptedData, $cipherMethod, $encryptionKey, 0, $decodedIV);
    }
}


if(isset($_POST['update_data']))
{
 $contact=$_POST['contact'];
 $status=$_POST['status'];
 $query="update appointmenttb set payment='$status' where contact='$contact';";
 $result=mysqli_query($con,$query);
 if($result)
  header("Location:updated.php");
}


function display_specs() {
    global $con;

    // fetch distinct specializations
    $query = "SELECT spec, spec_iv FROM doctb";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Query Failed: " . mysqli_error($con));
    }

    $displayedSpecs = []; 

    while ($row = mysqli_fetch_array($result)) {
        $decryptedSpec = decryptData($row['spec'], $row['spec_iv']);

        if (!in_array($decryptedSpec, $displayedSpecs)) {
        
            echo '<option data-value="' . $decryptedSpec . '">' . $decryptedSpec . '</option>';

            $displayedSpecs[] = $decryptedSpec;
        }
    }
}



function display_docs()
{
    global $con;

    // fetch doctor details
    $query = "SELECT doc_id, username, docFees, doc_Fees_iv, spec, spec_iv FROM doctb";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Query Failed: " . mysqli_error($con));
    }

    while ($row = mysqli_fetch_array($result)) {

        $decryptedDocFees = decryptData($row['docFees'], $row['doc_Fees_iv']);
        $decryptedSpec = decryptData($row['spec'], $row['spec_iv']);

        $doc_id = $row['doc_id'];
        $username = $row['username'];

        echo '<option value="' . $doc_id . '" data-value="' . $decryptedDocFees . '" data-spec="' . $decryptedSpec . '">
                Dr. ' . $username . ' (' . $decryptedSpec . ')
              </option>';
    }
}


if(isset($_POST['doc_sub']))
{
    $username=$_POST['username'];
    $query="insert into doctb(username)values('$username')";
    $result=mysqli_query($con,$query);
    if($result)
    header("Location:adddoc.php");
}

?>