<?php
session_start();

// Load dependencies and environment variables
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Initialize Dotenv to load the .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Encryption function (optional, only if needed for sensitive data)
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

// Connect to the database using environment variables
$con = mysqli_connect("localhost", "root", "", "myhmsdb");

// Check if the connection was successful
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if bill ID is passed
if (isset($_GET['ID'])) {
    $billID = $_GET['ID'];
} else {
    echo "No bill selected for payment.";
    exit();
}

function generate_bill(){
    $con=mysqli_connect("localhost","root","","myhmsdb");
    $pid = $_SESSION['pid'];
    $output='';
    $query=mysqli_query($con,"select p.pid,p.ID,p.fname,p.lname,p.doctor,p.appdate,p.apptime,p.disease,p.allergy,p.prescription,a.docFees from prestb p inner join appointmenttb a on p.ID=a.ID and p.pid = '$pid' and p.ID = '".$_GET['ID']."'");
    while($row = mysqli_fetch_array($query)){
      $output .= '
      <label> Patient ID : </label>'.$row["pid"].'<br/><br/>
      <label> Appointment ID : </label>'.$row["ID"].'<br/><br/>
      <label> Patient Name : </label>'.$row["fname"].' '.$row["lname"].'<br/><br/>
      <label> Doctor Name : </label>'.$row["doctor"].'<br/><br/>
      <label> Appointment Date : </label>'.$row["appdate"].'<br/><br/>
      <label> Appointment Time : </label>'.$row["apptime"].'<br/><br/>
      <label> Disease : </label>'.$row["disease"].'<br/><br/>
      <label> Allergies : </label>'.$row["allergy"].'<br/><br/>
      <label> Prescription : </label>'.$row["prescription"].'<br/><br/>
      <label> Fees Paid : </label>'.$row["docFees"].'<br/>
      
      ';
  
    }
    
    return $output;
  }
  
  
  if (isset($_GET["generate_bill"])) {
    require_once("TCPDF/tcpdf.php");
    $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $obj_pdf->SetCreator(PDF_CREATOR);
    $obj_pdf->SetTitle("Generate Bill");
    $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $obj_pdf->SetHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $obj_pdf->SetFooterFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $obj_pdf->SetDefaultMonospacedFont('helvetica');
    $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
    $obj_pdf->SetPrintHeader(false);
    $obj_pdf->SetPrintFooter(false);
    $obj_pdf->SetAutoPageBreak(TRUE, 10);
    $obj_pdf->SetFont('helvetica', '', 12);
    $obj_pdf->AddPage();
  
    // Password for the PDF
    $user_password = "user123";
    $owner_password = 123;
  
    // Set protection with the password
    $obj_pdf->SetProtection(array('print', 'copy'), $user_password, $owner_password);
  
    // Content of the PDF
    $content = '';
    $content .= '
        <br/>
        <h2 align="center">Global Hospitals</h2><br/>
        <h3 align="center">Bill</h3>
    ';
    $content .= generate_bill();
  
    $obj_pdf->writeHTML($content);
    ob_end_clean();
    $obj_pdf->Output("bill.pdf", 'I');
  }
?>

