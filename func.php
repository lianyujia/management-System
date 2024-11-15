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

function decryptData($encryptedData, $iv) {
  $encryptionKey = $_ENV['ENCRYPTION_KEY']; 
  $cipherMethod = $_ENV['CIPHER_METHOD']; 

  $decodedIV = base64_decode($iv);

  // decrypt the data
  $decrypted = openssl_decrypt($encryptedData, $cipherMethod, $encryptionKey, 0, $decodedIV);

  return $decrypted; 
}



if (isset($_POST['patsub'])) {
  $email = $_POST['email'];
  $password = $_POST['password2']; 

  $email = mysqli_real_escape_string($con, $email);

  // check if the email exists
  $query = "SELECT * FROM patreg";
  $result = mysqli_query($con, $query);

  if (!$result) {
      die("Error: " . mysqli_error($con));
  }

  $isEmailValid = false; // if email matches
  $row = null; 

  // decrypt and match the email
  while ($record = mysqli_fetch_assoc($result)) {
      $decryptedEmail = decryptData($record['email'], $record['email_iv']);

      if ($decryptedEmail === $email) {
          $isEmailValid = true;
          $row = $record; 
          break; 
      }
  }

  if ($isEmailValid) {
      $stored_hashed_password = $row['password'];

      echo "Entered Password: $password<br>";
      echo "Stored Hashed Password: $stored_hashed_password<br>";

      if (password_verify($password, $stored_hashed_password)) {
          // password matches, set session variables
          $_SESSION['pid'] = $row['pid'];
          $_SESSION['username'] = $row['fname'] . " " . $row['lname'];
          $_SESSION['fname'] = $row['fname'];
          $_SESSION['lname'] = $row['lname'];
          $_SESSION['gender'] = decryptData($row['gender'], $row['gender_iv']); 
          $_SESSION['contact'] = decryptData($row['contact'], $row['contact_iv']); 
          $_SESSION['email'] = $email;

          $_SESSION['start_time'] = time(); // current time
          $_SESSION['expiration_time'] = 10800; // expiration time in 3 hours
          $_SESSION['end_time'] = $_SESSION['start_time'] + $_SESSION['expiration_time'];

          $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

          $csrf_token = $_SESSION['csrf_token'];

          // Use pid for updating csrf_token
          $update_query = "UPDATE patreg SET csrf_token='$csrf_token' WHERE pid=?";
          $update_stmt = $con->prepare($update_query);
          $update_stmt->bind_param("i", $row['pid']);
          $update_stmt->execute();
          $update_stmt->close();

          // insert into activity log
          $pid = $_SESSION['pid'];
          date_default_timezone_set('Asia/Kuala_Lumpur'); 
          $loginTime = date('Y-m-d H:i:s'); 

          // encrypt activity and login time
          $activity = "Patient logged in";
          $encryptedActivity = encryptData($activity);
          $encryptedLoginTime = encryptData($loginTime);

          $logQuery = "
              INSERT INTO activity_log (
                  activity, activity_iv, 
                  pid, 
                  login, login_iv, 
                  created_on
              ) VALUES (
                  '" . $encryptedActivity['data'] . "', '" . $encryptedActivity['iv'] . "',
                  '$pid',
                  '" . $encryptedLoginTime['data'] . "', '" . $encryptedLoginTime['iv'] . "',
                  NOW()
              )
          ";

          if (mysqli_query($con, $logQuery)) {
              echo "Activity logged successfully.";
          } else {
              echo "Error logging activity: " . mysqli_error($con);
          }

          header("Location: admin-panel.php");
          exit();
            
      } else {
          // Incorrect password
          echo "<script>alert('Invalid Password. Try Again!'); window.location.href = 'index1.php';</script>";
      }
  } else {
      // email not found
      echo "<script>alert('Email not found. Try Again!'); window.location.href = 'index1.php';</script>";
  }








// function display_docs()
// {
// 	global $con;
// 	$query="select * from doctb";
// 	$result=mysqli_query($con,$query);
// 	while($row=mysqli_fetch_array($result))
// 	{
// 		$name=$row['name'];
//     $cost=$row['docFees'];
// 		echo '<option value="'.$name.'" data-price="' .$cost. '" >'.$name.'</option>';
// 	}
// }

if(isset($_POST['doc_sub']))
{
	$doctor=$_POST['doctor'];
  $dpassword=$_POST['dpassword'];
  $demail=$_POST['demail'];
  $docFees=$_POST['docFees'];
	$query="insert into doctb(username,password,email,docFees)values('$doctor','$dpassword','$demail','$docFees')";
	$result=mysqli_query($con,$query);
	if($result)
		header("Location:adddoc.php");
}
function display_admin_panel(){
	echo '<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> Global Hospital</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
     <ul class="navbar-nav mr-auto">
       <li class="nav-item">
        <a class="nav-link" href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="#"></a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" method="post" action="search.php">
      <input class="form-control mr-sm-2" type="text" placeholder="enter contact number" aria-label="Search" name="contact">
      <input type="submit" class="btn btn-outline-light my-2 my-sm-0 btn btn-outline-light" id="inputbtn" name="search_submit" value="Search">
    </form>
  </div>
</nav>
  </head>
  <style type="text/css">
    button:hover{cursor:pointer;}
    #inputbtn:hover{cursor:pointer;}
  </style>
  <body style="padding-top:50px;">
 <div class="jumbotron" id="ab1"></div>
   <div class="container-fluid" style="margin-top:50px;">
    <div class="row">
  <div class="col-md-4">
    <div class="list-group" id="list-tab" role="tablist">
      <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Appointment</a>
      <a class="list-group-item list-group-item-action" href="patientdetails.php" role="tab" aria-controls="home">Patient List</a>
      <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Payment Status</a>
      <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-controls="messages">Prescription</a>
      <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">Doctors Section</a>
       <a class="list-group-item list-group-item-action" id="list-attend-list" data-toggle="list" href="#list-attend" role="tab" aria-controls="settings">Attendance</a>
    </div><br>
  </div>

  





  <div class="col-md-8">
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <center><h4>Create an appointment</h4></center><br>
              <form class="form-group" method="post" action="appointment.php">
                <div class="row">
                  <div class="col-md-4"><label>First Name:</label></div>
                  <div class="col-md-8"><input type="text" class="form-control" name="fname"></div><br><br>
                  <div class="col-md-4"><label>Last Name:</label></div>
                  <div class="col-md-8"><input type="text" class="form-control"  name="lname"></div><br><br>
                  <div class="col-md-4"><label>Email id:</label></div>
                  <div class="col-md-8"><input type="text"  class="form-control" name="email"></div><br><br>
                  <div class="col-md-4"><label>Contact Number:</label></div>
                  <div class="col-md-8"><input type="text" class="form-control"  name="contact"></div><br><br>
                  <div class="col-md-4"><label>Doctor:</label></div>
                  <div class="col-md-8">
                   <select name="doctor" class="form-control" >

                     <!-- <option value="" disabled selected>Select Doctor</option>
                     <option value="Dr. Punam Shaw">Dr. Punam Shaw</option>
                      <option value="Dr. Ashok Goyal">Dr. Ashok Goyal</option> -->
                      <?php display_docs();?>




                    </select>
                  </div><br><br>
                  <div class="col-md-4"><label>Payment:</label></div>
                  <div class="col-md-8">
                    <select name="payment" class="form-control" >
                      <option value="" disabled selected>Select Payment Status</option>
                      <option value="Paid">Paid</option>
                      <option value="Pay later">Pay later</option>
                    </select>
                  </div><br><br><br>
                  <div class="col-md-4">
                    <input type="submit" name="entry_submit" value="Create new entry" class="btn btn-primary" id="inputbtn">
                  </div>
                  <div class="col-md-8"></div>                  
                </div>
              </form>
            </div>
          </div>
        </div><br>
      </div>
      <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
        <div class="card">
          <div class="card-body">
            <form class="form-group" method="post" action="func.php">
              <input type="text" name="contact" class="form-control" placeholder="enter contact"><br>
              <select name="status" class="form-control">
               <option value="" disabled selected>Select Payment Status to update</option>
                <option value="paid">paid</option>
                <option value="pay later">pay later</option>
              </select><br><hr>
              <input type="submit" value="update" name="update_data" class="btn btn-primary">
            </form>
          </div>
        </div><br><br>
      </div>
      <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">...</div>
      <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
        <form class="form-group" method="post" action="func.php">
          <label>Doctors name: </label>
          <input type="text" name="name" placeholder="enter doctors name" class="form-control">
          <br>
          <input type="submit" name="doc_sub" value="Add Doctor" class="btn btn-primary">
        </form>
      </div>
       <div class="tab-pane fade" id="list-attend" role="tabpanel" aria-labelledby="list-attend-list">...</div>
    </div>
  </div>
</div>
   </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <!--Sweet alert js-->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
   <script type="text/javascript">
   $(document).ready(function(){
   	swal({
  title: "Welcome!",
  text: "Have a nice day!",
  imageUrl: "images/sweet.jpg",
  imageWidth: 400,
  imageHeight: 200,
  imageAlt: "Custom image",
  animation: false
})</script>
  </body>
</html>';
}
}
?>