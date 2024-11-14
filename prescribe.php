<!DOCTYPE html>
<?php
include('func1.php');
use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

// Load .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

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

  // decrypt the data
  $decrypted = openssl_decrypt($encryptedData, $cipherMethod, $encryptionKey, 0, $decodedIV);

  return $decrypted; 
}

$pid='';
$ID='';
$appdate='';
$apptime='';
$fname = '';
$lname= '';
$doctor = $_SESSION['dname'];
if(isset($_GET['pid']) && isset($_GET['ID']) && ($_GET['appdate']) && isset($_GET['apptime']) && isset($_GET['fname']) && isset($_GET['lname'])) {
$pid = $_GET['pid'];
  $ID = $_GET['ID'];
  $fname = $_GET['fname'];
  $lname = $_GET['lname'];
  $appdate = $_GET['appdate'];
  $apptime = $_GET['apptime'];
}



if (
  isset($_POST['prescribe']) && 
  isset($_POST['pid']) && 
  isset($_POST['ID']) && 
  isset($_POST['appdate']) && 
  isset($_POST['apptime']) && 
  isset($_POST['lname']) && 
  isset($_POST['fname'])
) {
  $appdate = $_POST['appdate'];
  $apptime = $_POST['apptime'];
  $disease = $_POST['disease'];
  $allergy = $_POST['allergy'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $pid = $_POST['pid'];
  $ID = $_POST['ID'];
  $prescription = $_POST['prescription'];
  $doctor = $_SESSION['dname']; 
  $doc_id = $_SESSION['doc_id'];

  $encryptedFname = encryptData($fname);
  $encryptedLname = encryptData($lname);
  $encryptedDisease = encryptData($disease);
  $encryptedAllergy = encryptData($allergy);
  $encryptedPrescription = encryptData($prescription);

  $query = mysqli_query($con, "INSERT INTO prestb (
      doctor,
      pid,
      ID,
      fname, fname_iv,
      lname, lname_iv,
      appdate,
      apptime,
      disease, disease_iv,
      allergy, allergy_iv,
      prescription, prescription_iv
  ) VALUES (
      '$doctor',
      '$pid',
      '$ID',
      '{$encryptedFname['data']}', '{$encryptedFname['iv']}',
      '{$encryptedLname['data']}', '{$encryptedLname['iv']}',
      '$appdate',
      '$apptime',      
      '{$encryptedDisease['data']}', '{$encryptedDisease['iv']}',
      '{$encryptedAllergy['data']}', '{$encryptedAllergy['iv']}',
      '{$encryptedPrescription['data']}', '{$encryptedPrescription['iv']}'
  )");

if ($query) {
  // add activity log
  $activity = "Prescription added for patient: $fname $lname (ID: $pid) by Dr. $doctor.";
  $encryptedActivity = encryptData($activity);

  $log_query = "INSERT INTO activity_log (activity, activity_iv, pid, doc_id) VALUES 
                ('" . $encryptedActivity['data'] . "', '" . $encryptedActivity['iv'] . "', '$pid', '$doc_id')";
  $log_result = mysqli_query($con, $log_query);

  if (!$log_result) {
      echo "<script>alert('Prescription saved but failed to log activity.');</script>";
  } else {
      echo "<script>alert('Prescribed successfully!');</script>";
  }
} else {
  echo "<script>alert('Unable to process your request. Try again!');</script>";
}


}

?>

<html lang="en">
  <head>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <meta name="viewport" content="width=device-width, -scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    
        <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> Global Hospital </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <style >
    .bg-primary {
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
}
.list-group-item.active {
    z-index: 2;
    color: #fff;
    background-color: #342ac1;
    border-color: #007bff;
}
.text-primary {
    color: #342ac1!important;
}

.btn-primary{
  background-color: #3c50c1;
  border-color: #3c50c1;
}
  </style>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
     <ul class="navbar-nav mr-auto">
       <li class="nav-item">
        <a class="nav-link" href="logout1.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
        
      </li>
       <li class="nav-item">
       <a class="nav-link" href="doctor-panel.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Back</a>
      </li>
    </ul>
  </div>
</nav>

</head>
  <style type="text/css">
    button:hover{cursor:pointer;}
    #inputbtn:hover{cursor:pointer;}
  </style>

<body style="padding-top:50px;">
   <div class="container-fluid" style="margin-top:50px;">
    <h3 style = "margin-left: 40%;  padding-bottom: 20px; font-family: 'IBM Plex Sans', sans-serif;"> Welcome &nbsp<?php echo $doctor ?>
   </h3>

   <div class="tab-pane" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
        <form class="form-group" name="prescribeform" method="post" action="prescribe.php">
        
          <div class="row">
                  <div class="col-md-4"><label>Disease:</label></div>
                  <div class="col-md-8">
                  <!-- <input type="text" class="form-control" name="disease" required> -->
                  <textarea id="disease" cols="86" rows ="5" name="disease" required></textarea>
                  </div><br><br><br>
                  
                  <div class="col-md-4"><label>Allergies:</label></div>
                  <div class="col-md-8">
                  <!-- <input type="text"  class="form-control" name="allergy" required> -->
                  <textarea id="allergy" cols="86" rows ="5" name="allergy" required></textarea>
                  </div><br><br><br>
                  <div class="col-md-4"><label>Prescription:</label></div>
                  <div class="col-md-8">
                  <!-- <input type="text" class="form-control"  name="prescription"  required> -->
                  <textarea id="prescription" cols="86" rows ="10" name="prescription" required></textarea>
                  </div><br><br><br>
                  <input type="hidden" name="fname" value="<?php echo $fname ?>" />
                  <input type="hidden" name="lname" value="<?php echo $lname ?>" />
                  <input type="hidden" name="appdate" value="<?php echo $appdate ?>" />
                  <input type="hidden" name="apptime" value="<?php echo $apptime ?>" />
                  <input type="hidden" name="pid" value="<?php echo $pid ?>" />
                  <input type="hidden" name="ID" value="<?php echo $ID ?>" />
                  <br><br><br><br>
          <input type="submit" name="prescribe" value="Prescribe" class="btn btn-primary" style="margin-left: 40pc;">
          
        </form>
        <br>
        
      </div>
      </div>
      

  
