<!DOCTYPE html>
<?php 
$con=mysqli_connect("localhost","root","","myhmsdb");

use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

// Load .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$_SESSION['database_csrf_token'] = NULL;

if ($_SESSION['database_csrf_token'] != NULL) {
  $username = $_SESSION['username']; // or use $_SESSION['pid'] or any other identifier
  
  // Step 2: Query the database to get the CSRF token associated with the user
  $query = "SELECT csrf_token FROM admintb WHERE username='$username'";
  $result = mysqli_query($con, $query);

  if ($result && mysqli_num_rows($result) == 1) {
      // Step 3: Fetch the CSRF token from the database
      $row = mysqli_fetch_assoc($result);
      $_SESSION['database_csrf_token'] = $row['csrf_token'];

      // Step 4: Compare the CSRF token from the form, session, and database
      if ($_SESSION['database_csrf_token'] !== $_SESSION['csrf_token']) {
          // Tokens do not match, redirect to the error page
          header("Location: csrf_error.php");
          exit();
      }
  } else {
      // If no CSRF token is found in the database, redirect to the error page
      header("Location: csrf_error.php");
      exit();
  }
}


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


include('newfunc.php');
include('session_tracking.php');
if (isset($_POST['docsub'])) {
  $doctor = $_POST['doctor'];
  $demail = $_POST['demail'];
  $spec = $_POST['special'];
  $docFees = $_POST['docFees'];

  // generate random password
  function generateRandomPassword($length = 8) {
      return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
  }

  $encryptedEmail = encryptData($demail);
  $encryptedSpec = encryptData($spec);
  $encryptedDocFees = encryptData($docFees);

  // generate a random password
  $randomPassword = generateRandomPassword(); // 8-character password
  $hashedPassword = password_hash($randomPassword, PASSWORD_BCRYPT); // hash the password

  // insert into the database
  $query = "INSERT INTO doctb (username, password, email, email_iv, spec, spec_iv, docFees, doc_Fees_iv) 
              VALUES ('$doctor', '$hashedPassword', '" . $encryptedEmail['data'] . "', '" . $encryptedEmail['iv'] . "', 
                      '" . $encryptedSpec['data'] . "', '" . $encryptedSpec['iv'] . "', 
                      '" . $encryptedDocFees['data'] . "', '" . $encryptedDocFees['iv'] . "')";
    $result = mysqli_query($con, $query);

  if ($result) {
      echo "<script>alert('Doctor added successfully!');</script>";

      $adminUsername = $_SESSION['username'];

      // add activity log
      $activity = "New doctor added: $doctor with specialization $spec.";
      $encryptedActivity = encryptData($activity);

      $log_query = "INSERT INTO activity_log (activity, activity_iv, admin, created_on) VALUES 
                    ('" . $encryptedActivity['data'] . "', '" . $encryptedActivity['iv'] . "', '$adminUsername', NOW())";
      $log_result = mysqli_query($con, $log_query);

      if (!$log_result) {
          echo "<script>alert('Error logging activity.');</script>";
      }

      // send the email
      try {
          $mail = new PHPMailer(true);

          // SMTP configuration
          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com'; 
          $mail->SMTPAuth = true;
          $mail->Username = $_ENV['EMAIL_USERNAME']; 
          $mail->Password = $_ENV['EMAIL_PASSWORD']; 
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
          $mail->Port = 587;
      
          // email settings
          $mail->setFrom($_ENV['EMAIL_USERNAME'], 'Admin'); 
          $mail->addAddress($demail, $doctor); 
          $mail->Subject = 'Welcome to Global Hospitals!';
          $mail->Body = "Hello $doctor,\n\nYour doctor account has been created successfully.\nYour login credentials are:\nUsername: $doctor\nPassword: $randomPassword\n\nPlease change your password after logging in.";
      
          $mail->send();
          echo "<script>alert('An email with login credentials has been sent to the doctor.');</script>";
      } catch (Exception $e) {
          echo "<script>alert('Error sending email: {$mail->ErrorInfo}');</script>";
      }
  } else {
      echo "<script>alert('Error adding doctor!');</script>";
  }
}

if(isset($_POST['docsub1']))
{
  $demail=$_POST['demail'];
  $query="delete from doctb where email='$demail';";
  $result=mysqli_query($con,$query);
  if($result)
    {
      echo "<script>alert('Doctor removed successfully!');</script>";
      $activity = "Doctor removed: $doctorName";
      $encryptedActivity = encryptData($activity); 

      date_default_timezone_set('Asia/Kuala_Lumpur'); 
      $created_on = date('Y-m-d H:i:s'); 
      $logQuery = "
          INSERT INTO activity_log (activity, activity_iv, created_on, admin) 
          VALUES ('{$encryptedActivity['data']}', '{$encryptedActivity['iv']}', '$created_on', '{$_SESSION['username']}')";
      $logResult = mysqli_query($con, $logQuery);

      if (!$logResult) {
          echo "<script>alert('Failed to record activity log.');</script>";
      }
  } else {
      echo "<script>alert('Unable to delete!');</script>";
  }
}

?>
<html lang="en">
  <head>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
  <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> Global Hospital </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <script >
    var check = function() {
  if (document.getElementById('dpassword').value ==
    document.getElementById('cdpassword').value) {
    document.getElementById('message').style.color = '#5dd05d';
    document.getElementById('message').innerHTML = 'Matched';
  } else {
    document.getElementById('message').style.color = '#f55252';
    document.getElementById('message').innerHTML = 'Not Matching';
  }
}

    function alphaOnly(event) {
  var key = event.keyCode;
  return ((key >= 65 && key <= 90) || key == 8 || key == 32);
};
  </script>

  <style >
    .bg-primary {
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
}

.col-md-4{
  max-width:20% !important;
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

#cpass {
  display: -webkit-box;
}

#list-app{
  font-size:15px;
}

.btn-primary{
  background-color: #3c50c1;
  border-color: #3c50c1;
}
  </style>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
     <ul class="navbar-nav mr-auto">
       <li class="nav-item">
        <a class="nav-link" href="logout1.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="#"></a>
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
    <h3 style = "margin-left: 40%; padding-bottom: 20px;font-family: 'IBM Plex Sans', sans-serif;"> WELCOME RECEPTIONIST </h3>
    <div style="position: absolute; right: 10px; margin-top: -100px;">
        <button class="btn btn-primary" style="background-color: #313866;" data-toggle="modal" data-target="#activityLogModal">
            <i class="fas fa-file"></i> History
        </button>
    </div>
    <div class="row">
  <div class="col-md-4" style="max-width:25%;margin-top: 3%;">
    <div class="list-group" id="list-tab" role="tablist">
      <a class="list-group-item list-group-item-action active" id="list-dash-list" data-toggle="list" href="#list-dash" role="tab" aria-controls="home">Dashboard</a>
      <a class="list-group-item list-group-item-action" href="#list-doc" id="list-doc-list"  role="tab"    aria-controls="home" data-toggle="list">Doctor List</a>
      <a class="list-group-item list-group-item-action" href="#list-pat" id="list-pat-list"  role="tab" data-toggle="list" aria-controls="home">Patient List</a>
      <a class="list-group-item list-group-item-action" href="#list-app" id="list-app-list"  role="tab" data-toggle="list" aria-controls="home">Appointment Details</a>
      <a class="list-group-item list-group-item-action" href="#list-settings" id="list-adoc-list"  role="tab" data-toggle="list" aria-controls="home">Add Doctor</a>
      <a class="list-group-item list-group-item-action" href="#list-settings1" id="list-ddoc-list"  role="tab" data-toggle="list" aria-controls="home">Delete Doctor</a>
      <a class="list-group-item list-group-item-action" href="#list-insight" id="list-insight-list"  role="tab" data-toggle="list" aria-controls="home">Daily Login Analysis</a>
      <a class="list-group-item list-group-item-action" href="#list-insight-appt" id="list-insight-appt-list"  role="tab" data-toggle="list" aria-controls="home">Doctor Appointments Analysis</a>
    </div><br>
  </div>
  <div class="col-md-8" style="margin-top: 3%;">
    <div class="tab-content" id="nav-tabContent" style="width: 950px;">



      <div class="tab-pane fade show active" id="list-dash" role="tabpanel" aria-labelledby="list-dash-list">
        <div class="container-fluid container-fullw bg-white" >
              <div class="row">
               <div class="col-sm-4">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-users fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Doctor List</h4>
                      <script>
                        function clickDiv(id) {
                          document.querySelector(id).click();
                        }
                      </script> 
                      <p class="links cl-effect-1">
                        <a href="#list-doc" onclick="clickDiv('#list-doc-list')">
                          View Doctors
                        </a>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-4" style="left: -3%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body" >
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-users fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Patient List</h4>
                      
                      <p class="cl-effect-1">
                        <a href="#app-hist" onclick="clickDiv('#list-pat-list')">
                          View Patients
                        </a>
                      </p>
                    </div>
                  </div>
                </div>
              

                <div class="col-sm-4">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body" >
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-paperclip fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Appointment Details</h4>
                    
                      <p class="cl-effect-1">
                        <a href="#app-hist" onclick="clickDiv('#list-app-list')">
                          View Appointments
                        </a>
                      </p>
                    </div>
                  </div>
                </div>
                </div>

                <div class="row">
                

                <div class="col-sm-4" style="left: 18%;margin-top: 5%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body" >
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-plus fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Manage Doctors</h4>
                    
                      <p class="cl-effect-1">
                        <a href="#app-hist" onclick="clickDiv('#list-adoc-list')">Add Doctors</a>
                        &nbsp|
                        <a href="#app-hist" onclick="clickDiv('#list-ddoc-list')">
                          Delete Doctors
                        </a>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-4" style="left: 18%;margin-top: 5%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body" >
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-bar-chart fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">View Insights</h4>
                    
                      <p class="cl-effect-1">
                        <a href="#app-hist" onclick="clickDiv('#list-insight-list')">View Daily Login</a>
                        &nbsp|
                        <a href="#app-hist" onclick="clickDiv('#list-insight-appt-list')">
                          View Doctor Appointments
                        </a>
                      </p>
                    </div>
                  </div>
                </div>

                </div>
                  
                

      
                
              </div>
            </div>

    <div class="tab-pane fade" id="list-doc" role="tabpanel" aria-labelledby="list-home-list">
              

    <div class="col-md-8">
        <input type="text" id="filterDoctorInput" class="form-control" placeholder="Search for any keyword..." onkeyup="filterDoctorTable()">
    </div>
            <table class="table table-hover" id="doctorTable" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th scope="col">Doctor Name</th>
                    <th scope="col">Specialization</th>
                    <th scope="col">Email</th>
                    <th scope="col">Fees</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $con = mysqli_connect("localhost", "root", "", "myhmsdb");
                if (!$con) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $query = "SELECT username, spec, spec_iv, email, email_iv, docFees, doc_Fees_iv FROM doctb";
                $result = mysqli_query($con, $query);

                while ($row = mysqli_fetch_array($result)) {
                    // Decrypt the necessary fields
                    $username = $row['username']; // Not encrypted
                    $decryptedSpec = decryptData($row['spec'], $row['spec_iv']);
                    $decryptedEmail = decryptData($row['email'], $row['email_iv']);
                    $decryptedDocFees = decryptData($row['docFees'], $row['doc_Fees_iv']);

                    echo "<tr>
                        <td>$username</td>
                        <td>$decryptedSpec</td>
                        <td>$decryptedEmail</td>
                        <td>$decryptedDocFees</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <br>
      </div>
    

    <div class="tab-pane fade" id="list-pat" role="tabpanel" aria-labelledby="list-pat-list">

    <div class="col-md-8">
        <input type="text" id="filterPatientInput" class="form-control" placeholder="Search for any keyword..." onkeyup="filterPatientTable()">
    </div>
          <table class="table table-hover" id="patientTable" style="margin-top: 20px;">
          <thead>
              <tr>
                  <th scope="col">Patient ID</th>
                  <th scope="col">First Name</th>
                  <th scope="col">Last Name</th>
                  <th scope="col">Gender</th>
                  <th scope="col">Email</th>
                  <th scope="col">Contact</th>
              </tr>
          </thead>
          <tbody>
              <?php 
              $con = mysqli_connect("localhost", "root", "", "myhmsdb");
              if (!$con) {
                  die("Connection failed: " . mysqli_connect_error());
              }

              $query = "SELECT pid, fname, lname, gender, gender_iv, email, email_iv, contact, contact_iv FROM patreg";
              $result = mysqli_query($con, $query);

              while ($row = mysqli_fetch_array($result)) {
                  // Decrypt the necessary fields
                  $pid = $row['pid'];
                  $fname = $row['fname'];
                  $lname = $row['lname'];
                  $decryptedGender = decryptData($row['gender'], $row['gender_iv']);
                  $decryptedEmail = decryptData($row['email'], $row['email_iv']);
                  $decryptedContact = decryptData($row['contact'], $row['contact_iv']);
            

                  echo "<tr>
                      <td>$pid</td>
                      <td>$fname</td>
                      <td>$lname</td>
                      <td>$decryptedGender</td>
                      <td>$decryptedEmail</td>
                      <td>$decryptedContact</td>
                    
                  </tr>";
              }
              ?>
          </tbody>
      </table>

        <br>
      </div>

      <div class="tab-pane fade" id="list-app" role="tabpanel" aria-labelledby="list-pat-list">

      <div class="col-md-8">
          <input type="text" id="filterInput" class="form-control" placeholder="Search for any keyword..." onkeyup="filterAppointmentTable()">
      </div>

          <table class="table table-hover" id="appointmentTable" style="margin-top: 20px;">
            <thead>
            <tr>
              <th scope="col">Appointment ID</th>
              <th scope="col">Patient ID</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Gender</th>
                <th scope="col">Email</th>
                <th scope="col">Contact</th>
                <th scope="col">Doctor Name</th>
                <th scope="col">Consultancy Fees</th>
                <th scope="col">Appointment Date</th>
                <th scope="col">Appointment Time</th>
                <th scope="col">Appointment Status</th>
              </tr>
            </thead>
            <tbody>
              <?php 

                $con=mysqli_connect("localhost","root","","myhmsdb");
                global $con;

                $query = "SELECT a.*, d.username AS doctor_username 
                FROM appointmenttb a
                LEFT JOIN doctb d ON a.doctor = d.doc_id 
                ORDER BY STR_TO_DATE(a.appdate, '%Y-%m-%d') DESC;";
                $result = mysqli_query($con,$query);
                while ($row = mysqli_fetch_array($result)) {

                  // Decrypt data fields
                  $decryptedGender = decryptData($row['gender'], $row['gender_iv']);
                  $decryptedEmail = decryptData($row['email'], $row['email_iv']);
                  $decryptedContact = decryptData($row['contact'], $row['contact_iv']);
                  $decryptedAppDate = decryptData($row['appdate'], $row['appdate_iv']);
                  $decryptedAppTime = decryptData($row['apptime'], $row['apptime_iv']);
                  $decryptedFee = decryptData($row['docFees'], $row['docFees_iv']);
            ?>
              <tr>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['pid']; ?></td>
                <td><?php echo $row['fname']; ?></td>
                <td><?php echo $row['lname']; ?></td>
                <td><?php echo $decryptedGender; ?></td>
                <td><?php echo $decryptedEmail; ?></td>
                <td><?php echo $decryptedContact; ?></td>
                <td><?php echo $row['doctor_username']; ?></td> 
                <td><?php echo $decryptedDocFees; ?></td>
                <td><?php echo $decryptedAppDate; ?></td>
                <td><?php echo $decryptedAppTime; ?></td>
                <td>
                  <?php 
                    // Display appointment status
                    if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) {
                      echo "Active";
                    } elseif (($row['userStatus'] == 0) && ($row['doctorStatus'] == 1)) {
                      echo "Cancelled by Patient";
                    } elseif (($row['userStatus'] == 1) && ($row['doctorStatus'] == 0)) {
                      echo "Cancelled by Doctor";
                    }
                  ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
          </table>
        <br>
      </div>

<div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">...</div>

      <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
        <form class="form-group" method="post" action="admin-panel1.php">
          <div class="row">
                  <div class="col-md-4"><label>Doctor Name:</label></div>
                  <div class="col-md-8"><input type="text" class="form-control" name="doctor" onkeydown="return alphaOnly(event);" required></div><br><br>
                  <div class="col-md-4"><label>Specialization:</label></div>
                  <div class="col-md-8">
                   <select name="special" class="form-control" id="special" required="required">
                      <option value="head" name="spec" disabled selected>Select Specialization</option>
                      <option value="General" name="spec">General</option>
                      <option value="Cardiologist" name="spec">Cardiologist</option>
                      <option value="Neurologist" name="spec">Neurologist</option>
                      <option value="Pediatrician" name="spec">Pediatrician</option>
                    </select>
                    </div><br><br>
                  <div class="col-md-4"><label>Email ID:</label></div>
                  <div class="col-md-8"><input type="email"  class="form-control" name="demail" required></div><br><br>
                                   
                  <div class="col-md-4"><label>Consultancy Fees:</label></div>
                  <div class="col-md-8"><input type="text" class="form-control"  name="docFees" required></div><br><br>
                </div>
          <input type="submit" name="docsub" value="Add Doctor" class="btn btn-primary">
        </form>
      </div>

      <div class="tab-pane fade" id="list-settings1" role="tabpanel" aria-labelledby="list-settings1-list">
        <form class="form-group" method="post" action="admin-panel1.php">
          <div class="row">
          
                  <div class="col-md-4"><label>Email ID:</label></div>
                  <div class="col-md-8"><input type="email"  class="form-control" name="demail" required></div><br><br>
                  
                </div>
          <input type="submit" name="docsub1" value="Delete Doctor" class="btn btn-primary" onclick="confirm('do you really want to delete?')">
        </form>
      </div>

      <div class="tab-pane fade" id="list-insight" role="tabpanel" aria-labelledby="list-insight-list">

      <h3>Daily Login Time Analysis</h3>
        <div class="form-group">
            <label for="datePicker">Select Date:</label>
            <input type="date" id="datePicker" class="form-control" onchange="fetchLoginsByDate()">
        </div>
        <div id="chartContainer">
            <canvas id="dailyChart"></canvas>
            
        </div>
        <br>
        <h5 id="averageDuration"></h3>
        <br>
      </div>

      <div class="tab-pane fade" id="list-insight-appt" role="tabpanel" aria-labelledby="list-insight-appt-list">

        <h3>Appointment Analysis</h3>
        <div class="form-group">
            <label for="datePicker2">Select Date:</label>
            <input type="date" id="datePicker2" class="form-control" onchange="fetchAppointmentByDate()">
        </div>
        <div class="form-group">
            <label for="doctorSelect">Select Doctor:</label>
            <select id="doctorSelect" class="form-control" onchange="fetchAppointmentsByDoctor()">
                <option value="">All Doctors</option>
               
            </select>
        </div>
        <div id="chartContainer2">
            <canvas id="apptChart"></canvas>
        </div>
        <br>
        
        <br>
    </div>

    </div>
  </div>
</div>
   </div>

   <div class="modal fade" id="activityLogModal" tabindex="-1" role="dialog" aria-labelledby="activityLogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="activityLogModalLabel">Activity Log</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Filter Dropdown -->
                <div class="form-group">
                    <label for="filter">Filter Activity Log By:</label>
                    <select id="filter" class="form-control" onchange="filterLog()">
                        <option value="patient_doctor">Patient/Doctor</option>
                        <option value="admin">Admin</option>
                        <option value="login_logout">Login/Logout</option>
                    </select>
                </div>

                <!-- Activity Log Table -->
                <div id="activityLogTable">
                    <?php
                    $query = mysqli_query($con, "
                        SELECT 
                            a.activity, 
                            a.activity_iv, 
                            a.created_on, 
                            a.admin, 
                            a.login, 
                            a.login_iv, 
                            a.logout, 
                            a.logout_iv, 
                            p.fname AS patient_fname, 
                            p.lname AS patient_lname, 
                            d.username AS doctor_username
                        FROM activity_log a
                        LEFT JOIN patreg p ON a.pid = p.pid
                        LEFT JOIN doctb d ON a.doc_id = d.doc_id
                        ORDER BY a.created_on DESC
                    ");

                    if (mysqli_num_rows($query) > 0) {
                        echo "<table class='table table-bordered'>
                                <thead>
                                    <tr id='table-headers'></tr>
                                </thead>
                                <tbody id='table-body'>";
                        while ($row = mysqli_fetch_assoc($query)) {
                            $decryptedActivity = decryptData($row['activity'], $row['activity_iv']);
                            $decryptedLogin = !empty($row['login']) ? decryptData($row['login'], $row['login_iv']) : null;
                            $decryptedLogout = !empty($row['logout']) ? decryptData($row['logout'], $row['logout_iv']) : null;
                            $patientName = !empty($row['patient_fname']) ? "{$row['patient_fname']} {$row['patient_lname']}" : null;
                            $doctorName = !empty($row['doctor_username']) ? $row['doctor_username'] : null;
                            $adminName = !empty($row['admin']) ? $row['admin'] : null;

                            echo "<tr class='log-row' data-category='" . getLogCategory($row) . "'>
                                    <td class='activity'>{$decryptedActivity}</td>
                                    <td class='patient'>" . ($patientName ?: '') . "</td>
                                    <td class='doctor'>" . ($doctorName ?: '') . "</td>
                                    <td class='admin'>" . ($adminName ?: '') . "</td>
                                    <td class='login'>" . ($decryptedLogin ?: '') . "</td>
                                    <td class='logout'>" . ($decryptedLogout ?: '') . "</td>
                                    <td class='created_on'>{$row['created_on']}</td>
                                  </tr>";
                        }
                        echo "</tbody>
                              </table>";
                    } else {
                        echo "<p>No activity log found.</p>";
                    }

                    function getLogCategory($row) {
                        if (!empty($row['admin']) && empty($row['login']) && empty($row['logout'])) {
                            return 'admin';
                        } elseif (!empty($row['login']) || !empty($row['logout'])) {
                            return 'login_logout';
                        } else {
                            return 'patient_doctor';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
   let dailyChart; 

    function fetchLoginsByDate() {
        const selectedDate = document.getElementById('datePicker').value;

        if (!selectedDate) {
            alert('Please select a date.');
            return;
        }

        // fetch data from the server
        fetch(`fetch_login.php?date=${selectedDate}`)
            .then(response => response.json())
            .then(data => {
                if (data.recordCount === 0) {
                    // no record found
                    document.getElementById('chartContainer').innerHTML = `
                        <p>No records for the selected date (${selectedDate}).</p>
                    `;
          
                    const averageDurationElement = document.getElementById('averageDuration');
                    if (averageDurationElement) {
                        averageDurationElement.innerHTML = '';
                    }

                    if (dailyChart) {
                        dailyChart.destroy(); // destroy the previous chart 
                    }
                } else {
                    // reset the chart container
                    document.getElementById('chartContainer').innerHTML = `
                        <canvas id="dailyChart"></canvas>
                    `;

                    const ctx = document.getElementById('dailyChart').getContext('2d');
                    const hourlyLogins = data.hourlyLogins;
                    const averageDuration = data.averageDuration;

                    if (dailyChart) {
                        dailyChart.destroy();
                    }

                    // create a new chart 
                    dailyChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: Array.from({ length: 24 }, (_, i) => `${i}:00`), // 24-hour labels
                            datasets: [{
                                label: 'Login Count',
                                data: hourlyLogins,
                                borderColor: '#1D267D',
                                fill: false,
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: `Login Count for ${selectedDate}`
                                }
                            },
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Hour of the Day'
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Login Count'
                                    },
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // show average
                    const averageDurationElement = document.getElementById('averageDuration');
                    if (averageDurationElement) {
                        averageDurationElement.innerHTML = 
                            `Average Duration Spent: <strong>${averageDuration} minutes</strong>`;
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                alert('An error occurred while fetching data.');
            });
    }

    let apptChart; 

    function formatDateToDDMMYYYY(date) {
      const [year, month, day] = date.split('-'); // YYYY-MM-DD
      return `${day}/${month}/${year}`; 
    }

    function fetchAppointmentByDate() {
    const selectedDate = document.getElementById('datePicker2').value;

    if (!selectedDate) {
        alert('Please select a date.');
        return;
    }

    const formattedDate = formatDateToDDMMYYYY(selectedDate);

    // fetch total appointments for the date
    fetch(`fetch_appointment.php?date=${formattedDate}`)
        .then(response => response.json())
        .then(data => {
            const chartContainer2 = document.getElementById('chartContainer2');

            if (data.recordCount === 0) {
                chartContainer2.innerHTML = `<p>No appointments for the selected date.</p>`;
                updateDoctorDropdown([]); // disable dropdown if no appointments
                return;
            }

            const canvasContainer = document.getElementById('chartContainer2');
            canvasContainer.innerHTML = '<canvas id="apptChart"></canvas>'; 
            const ctx = document.getElementById('apptChart').getContext('2d');

            if (apptChart) {
                apptChart.destroy();
            }

            apptChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Array.from({ length: 24 }, (_, i) => `${i}:00`), // Hours
                    datasets: [{
                        label: 'Total Appointments',
                        data: data.hourlyAppointments,
                        borderColor: '#7776B3',
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: `Appointments Analysis for ${formattedDate}`
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Hour of the Day'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Appointments Count'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error fetching appointment data:', error);
            alert('An error occurred while fetching data.');
        });

    // fetch doctors for the selected date and update the dropdown
    fetch(`fetch_appointment.php?date=${formattedDate}&fetchDoctors=true`)
        .then(response => response.json())
        .then(data => {
            updateDoctorDropdown(data.doctors || []);
        })
        .catch(error => {
            console.error('Error fetching doctors:', error);
            alert('An error occurred while fetching doctors.');
        });
}


function fetchAppointmentsByDoctor() {
    const selectedDate = document.getElementById('datePicker2').value;
    const doctorSelect = document.getElementById('doctorSelect');
    const selectedDoctorId = doctorSelect.value; 

    if (!selectedDate || !selectedDoctorId) {
        alert('Please select both a date and a doctor.');
        return;
    }

    const formattedDate = formatDateToDDMMYYYY(selectedDate);

    // keep the selected doctor as the active option
    Array.from(doctorSelect.options).forEach(option => {
        if (option.value === selectedDoctorId) {
            option.selected = true;
        }
    });

    // fetch doctor data and overlay it on the graph
    fetch(`fetch_appointment.php?date=${formattedDate}&doctor=${selectedDoctorId}`)
        .then(response => response.json())
        .then(data => {
            if (data.recordCount === 0) {
                alert(`No appointments for Doctor ${doctorSelect.selectedOptions[0].text} on this date.`);
                return;
            }

            // add the doctor's data as a new dataset to the current chart
            const doctorDataset = {
                label: `Appointments for Doctor ${doctorSelect.selectedOptions[0].text}`,
                data: data.doctorAppointments, // hourly data for the selected doctor
                borderColor: 'green', 
                pointBackgroundColor: 'red', 
                fill: true, 
            };

      
            if (apptChart) {
                apptChart.data.datasets.push(doctorDataset); 
                apptChart.update(); 
            } else {
                console.error('Chart instance not found. Please ensure the main chart is created before adding a doctor-specific line.');
            }
        })
        .catch(error => {
            console.error('Error fetching doctor-specific data:', error);
            alert('An error occurred while fetching data.');
        });
}


function updateDoctorDropdown(doctors) {
    const doctorSelect = document.getElementById('doctorSelect');
    doctorSelect.innerHTML = '<option value="">View by Doctor</option>';

    if (doctors.length > 0) {
        doctors.forEach(doctor => {
            const option = document.createElement('option');
            option.value = doctor.doc_id; 
            option.textContent = doctor.username; // display doctor username
            doctorSelect.appendChild(option);
        });

        doctorSelect.disabled = false;
    } else {
        doctorSelect.disabled = true;
    }
}


    function filterLog() {
        const filter = document.getElementById('filter').value;
        const rows = document.querySelectorAll('.log-row');
        const headers = document.getElementById('table-headers');
        const visibleColumns = {
            'patient_doctor': ['activity', 'patient', 'doctor', 'created_on'],
            'admin': ['activity', 'created_on'],
            'login_logout': ['activity', 'patient', 'doctor', 'admin', 'login', 'logout']
        };

        headers.innerHTML = '';
        visibleColumns[filter].forEach(column => {
            headers.innerHTML += `<th class="${column}">${column.replace('_', ' ').toUpperCase()}</th>`;
        });

        rows.forEach(row => {
            const category = row.getAttribute('data-category');
            row.style.display = category === filter ? '' : 'none';
            row.querySelectorAll('td').forEach(td => {
                td.style.display = visibleColumns[filter].includes(td.className) ? '' : 'none';
            });
        });
    }

    window.onload = () => {
     
        document.getElementById('filter').value = 'patient_doctor';
        filterLog();
    };

    function filterAppointmentTable() {
        // get the value entered 
        const filter = document.getElementById("filterInput").value.toUpperCase();
        const table = document.getElementById("appointmentTable");
        const rows = table.getElementsByTagName("tr");

        // loop through table rows and hide rows that don't match the filter
        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName("td");
            let match = false;
            
            // loop through each cell in the row
            for (let j = 0; j < cells.length; j++) {
                if (cells[j]) {
                    const textValue = cells[j].textContent || cells[j].innerText;
                    if (textValue.toUpperCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }
            }
            
            // show the row if a match is found
            rows[i].style.display = match ? "" : "none";
        }
    }

    function filterPatientTable() {
        // get the value entered 
        const filter = document.getElementById("filterPatientInput").value.toUpperCase();
        const table = document.getElementById("patientTable");
        const rows = table.getElementsByTagName("tr");

        // loop through table rows and hide rows that don't match the filter
        for (let i = 1; i < rows.length; i++) { 
            const cells = rows[i].getElementsByTagName("td");
            let match = false;

            // loop through each cell in the row
            for (let j = 0; j < cells.length; j++) {
                if (cells[j]) {
                    const textValue = cells[j].textContent || cells[j].innerText;
                    if (textValue.toUpperCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }
            }

            // show the row if a match is found
            rows[i].style.display = match ? "" : "none";
        }
    }

    function filterDoctorTable() {
        // get the value entered 
        const filter = document.getElementById("filterDoctorInput").value.toUpperCase();
        const table = document.getElementById("doctorTable");
        const rows = table.getElementsByTagName("tr");

        // loop through table rows and hide rows that don't match the filter
        for (let i = 1; i < rows.length; i++) { 
            const cells = rows[i].getElementsByTagName("td");
            let match = false;

            // loop through each cell in the row
            for (let j = 0; j < cells.length; j++) {
                if (cells[j]) {
                    const textValue = cells[j].textContent || cells[j].innerText;
                    if (textValue.toUpperCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }
            }

            // show the row if a match is found
            rows[i].style.display = match ? "" : "none";
        }
    }
</script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js"></script>
  </body>
</html>