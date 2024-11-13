<!DOCTYPE html>
<?php 
include('func.php');  
include('newfunc.php');
include('session_tracking.php');
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// load .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$con = mysqli_connect("localhost", "root", "", "myhmsdb");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$_SESSION['database_csrf_token'] = null;


if ($_SESSION['database_csrf_token'] == null) {
    $pid = $_SESSION['pid']; // or use $_SESSION['pid'] or any other identifier
    
    // Step 2: Query the database to get the CSRF token associated with the user
    $query = "SELECT csrf_token FROM patreg WHERE pid='$pid'";
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


if (!function_exists('decryptData')) {
  function decryptData($encryptedData, $iv) {
      $encryptionKey = getenv('ENCRYPTION_KEY');
      $cipherMethod = getenv('CIPHER_METHOD');
      
      // Decode the IV and check its length
      $decodedIV = base64_decode($iv);
      if (strlen($decodedIV) !== openssl_cipher_iv_length($cipherMethod)) {
          error_log("Decryption error: IV length is incorrect.");
          return null;
      }

      // Perform decryption
      $decryptedData = openssl_decrypt($encryptedData, $cipherMethod, $encryptionKey, 0, $decodedIV);
      if ($decryptedData === false) {
          error_log("Decryption error: Unable to decrypt data.");
      }

      return $decryptedData;
  }
}



$pid = $_SESSION['pid'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$fname = $_SESSION['fname'];
$gender = $_SESSION['gender'];
$lname = $_SESSION['lname'];
$contact = $_SESSION['contact'];

if (isset($_POST['app-submit'])) {

  date_default_timezone_set('Asia/Kolkata');

  // Session variables
  $pid = $_SESSION['pid'];
  $fname = $_SESSION['fname'];
  $lname = $_SESSION['lname'];
  $gender = $_SESSION['gender'];
  $email = $_SESSION['email'];
  $contact = $_SESSION['contact'];

  $doctor = $_POST['doctor'];
  $docFees = $_POST['docFees'];
  $appdate = $_POST['appdate'];
  $apptime = $_POST['apptime'];

  // current date and time
  $cur_date = date("Y-m-d");
  $cur_time = date("H:i:s");

  // convert to timestamp for validation
  $appdate1 = strtotime($appdate);
  $apptime1 = strtotime($apptime);

  $encryptedGender = encryptData($gender);
  $encryptedEmail = encryptData($email);
  $encryptedContact = encryptData($contact);
  $encryptedDocFees = encryptData($docFees);
  $encryptedAppDate = encryptData($appdate);
  $encryptedAppTime = encryptData($apptime);

  // validate date and time
  if ($appdate1 >= strtotime($cur_date) && ($appdate1 > strtotime($cur_date) || $apptime1 > strtotime($cur_time))) {

      // retrieve all appointments for the selected doctor
      $stmt = $con->prepare(
          "SELECT appdate, appdate_iv, apptime, apptime_iv FROM appointmenttb WHERE doctor = ?"
      );
      $stmt->bind_param("s", $doctor);
      $stmt->execute();
      $result = $stmt->get_result();

      $isSlotAvailable = true;

      while ($row = $result->fetch_assoc()) {
          $dbAppDate = decryptData($row['appdate'], $row['appdate_iv']);
          $dbAppTime = decryptData($row['apptime'], $row['apptime_iv']);

          if ($dbAppDate === $appdate && $dbAppTime === $apptime) {
              $isSlotAvailable = false;
              break;
          }
      }

      if ($isSlotAvailable) {
          $userStatus = 1;
          $doctorStatus = 1;

          // insert the appointment 
          $stmt = $con->prepare(
              "INSERT INTO appointmenttb (
                  pid, fname, lname, gender, gender_iv, email, email_iv, contact, contact_iv, doctor, 
                  docFees, docFees_iv, appdate, appdate_iv, apptime, apptime_iv, userStatus, doctorStatus
              ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
          );
          $stmt->bind_param(
              "isssssssssssssssss",
              $pid,
              $fname,
              $lname,
              $encryptedGender['data'],
              $encryptedGender['iv'],
              $encryptedEmail['data'],
              $encryptedEmail['iv'],
              $encryptedContact['data'],
              $encryptedContact['iv'],
              $doctor,
              $encryptedDocFees['data'],
              $encryptedDocFees['iv'],
              $encryptedAppDate['data'],
              $encryptedAppDate['iv'],
              $encryptedAppTime['data'],
              $encryptedAppTime['iv'],
              $userStatus,
              $doctorStatus
          );

          if ($stmt->execute()) {
            // fetch the doctor's username
            $stmt = $con->prepare("SELECT username FROM doctb WHERE doc_id = ?");
            $stmt->bind_param("s", $doctor);
            $stmt->execute();
            $result = $stmt->get_result();

            $doctorUsername = ""; 
            if ($row = $result->fetch_assoc()) {
                $doctorUsername = $row['username'];
            }
              // log activity
              $activity = "Appointment booked successfully with Dr. $doctorUsername on $appdate at $apptime";
              $encryptedActivity = encryptData($activity);

              $stmt = $con->prepare(
                  "INSERT INTO activity_log (activity, activity_iv, pid, doc_id) VALUES (?, ?, ?, ?)"
              );
              $stmt->bind_param(
                  "ssss",
                  $encryptedActivity['data'],
                  $encryptedActivity['iv'],
                  $pid,
                  $doctor
              );

              if ($stmt->execute()) {
                  echo "<script>alert('Your appointment has been successfully booked!');</script>";
              } else {
                  echo "<script>alert('Appointment booked but failed to log activity. Please contact support.');</script>";
              }
          } else {
              echo "<script>alert('Unable to process your request. Please try again!');</script>";
          }
      } else {
          echo "<script>alert('The doctor is not available at this time or date. Please choose a different time or date!');</script>";
      }
  } else {
      echo "<script>alert('Please select a time or date in the future!');</script>";
  }
}




if(isset($_GET['cancel']))
{
  $query=mysqli_query($con,"update appointmenttb set userStatus='0' where ID = '".$_GET['ID']."'");
  if($query)
  {
    echo "<script>alert('Your appointment successfully cancelled');</script>";
  }
}


function generate_bill($appointmentId) {
  $con = mysqli_connect("localhost", "root", "", "myhmsdb");

  if (!$con) {
      die("Connection failed: " . mysqli_connect_error());
  }

  // Ensure the appointment ID is passed and valid
  if (!$appointmentId) {
      echo "Invalid appointment ID.";
      return;
  }

  // Query to fetch data for the specific appointment ID
  $query = "
      SELECT 
          p.doctor,
          p.ID,
          a.appdate, a.appdate_iv,
          a.apptime, a.apptime_iv,
          p.disease, p.disease_iv,
          p.allergy, p.allergy_iv,
          p.prescription, p.prescription_iv
      FROM prestb p
      JOIN appointmenttb a ON p.ID = a.ID
      WHERE p.ID = '$appointmentId';
  ";

  $result = mysqli_query($con, $query);

  if (!$result) {
      echo "Error: " . mysqli_error($con);
      return;
  }

  $output = '';

  while ($row = mysqli_fetch_array($result)) {
      $decryptedAppDate = decryptData($row['appdate'], $row['appdate_iv']);
      $decryptedAppTime = decryptData($row['apptime'], $row['apptime_iv']);
      $decryptedDisease = decryptData($row['disease'], $row['disease_iv']);
      $decryptedAllergy = decryptData($row['allergy'], $row['allergy_iv']);
      $decryptedPrescription = decryptData($row['prescription'], $row['prescription_iv']);

      $output .= '
          <label>Patient ID:</label> ' . htmlspecialchars($row['ID']) . '<br/>
          <label>Doctor:</label> ' . htmlspecialchars($row['doctor']) . '<br/>
          <label>Appointment Date:</label> ' . htmlspecialchars($decryptedAppDate) . '<br/>
          <label>Appointment Time:</label> ' . htmlspecialchars($decryptedAppTime) . '<br/>
          <label>Disease:</label> ' . htmlspecialchars($decryptedDisease) . '<br/>
          <label>Allergies:</label> ' . htmlspecialchars($decryptedAllergy) . '<br/>
          <label>Prescription:</label> ' . htmlspecialchars($decryptedPrescription) . '<br/>
      ';
  }

  return $output;
}


if (isset($_GET['generate_bill']) && $_GET['generate_bill'] === 'true') {
  if (!isset($_GET['appointment_id']) || empty($_GET['appointment_id'])) {
      die("Error: Appointment ID is required to generate the bill.");
  }

  $appointmentId = $_GET['appointment_id'];

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

  $user_password = $email . $contact;

  $obj_pdf->SetProtection(['print', 'copy'], $user_password);

  // Fetch content for the specific appointment ID
  $content = '';
  $content .= '
      <br/>
      <h2 align="center"> Global Hospitals</h2><br/>
      <h3 align="center"> Bill</h3>
  ';
  $content .= generate_bill($appointmentId); // Pass the appointment ID to the function

  $obj_pdf->writeHTML($content);
  ob_end_clean();
  $obj_pdf->Output("bill.pdf", 'I');
}


function get_specs(){
  $con=mysqli_connect("localhost","root","","myhmsdb");
  $query=mysqli_query($con,"select username,spec from doctb");
  $docarray = array();
    while($row =mysqli_fetch_assoc($query))
    {
        $docarray[] = $row;
    }
    return json_encode($docarray);
}

?>
<html lang="en">
  <head>


  <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     -->
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


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
        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
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
    <h3 style = "margin-left: 40%;  padding-bottom: 20px; font-family: 'IBM Plex Sans', sans-serif;"> Welcome &nbsp<?php echo $username ?> 
   </h3>
   <div style="position: absolute; right: 10px; margin-top: -100px;">
        <button class="btn btn-primary" style="background-color: #313866;" data-toggle="modal" data-target="#activityLogModal">
            <i class="fas fa-file"></i> History
        </button>
    </div>
    <div class="row">
  <div class="col-md-4" style="max-width:25%; margin-top: 3%">
    <div class="list-group" id="list-tab" role="tablist">
      <a class="list-group-item list-group-item-action active" id="list-dash-list" data-toggle="list" href="#list-dash" role="tab" aria-controls="home">Dashboard</a>
      <a class="list-group-item list-group-item-action" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Book Appointment</a>
      <a class="list-group-item list-group-item-action" href="#app-hist" id="list-pat-list" role="tab" data-toggle="list" aria-controls="home">Appointment History</a>
      <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home">Prescriptions</a>
      
    </div><br>
  </div>
  
  <div class="col-md-8" style="margin-top: 3%;">
    <div class="tab-content" id="nav-tabContent" style="width: 950px;">


      <div class="tab-pane fade  show active" id="list-dash" role="tabpanel" aria-labelledby="list-dash-list">
        <div class="container-fluid container-fullw bg-white" >
              <div class="row">
               <div class="col-sm-4" style="left: 5%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-terminal fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;"> Book My Appointment</h4>
                      <script>
                        function clickDiv(id) {
                          document.querySelector(id).click();
                        }
                      </script>                      
                      <p class="links cl-effect-1">
                        <a href="#list-home" onclick="clickDiv('#list-home-list')">
                          Book Appointment
                        </a>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-4" style="left: 10%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body" >
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-paperclip fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">My Appointments</h2>
                    
                      <p class="cl-effect-1">
                        <a href="#app-hist" onclick="clickDiv('#list-pat-list')">
                          View Appointment History
                        </a>
                      </p>
                    </div>
                  </div>
                </div>
                </div>

                <div class="col-sm-4" style="left: 20%;margin-top:5%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body" >
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;">Prescriptions</h2>
                    
                      <p class="cl-effect-1">
                        <a href="#list-pres" onclick="clickDiv('#list-pres-list')">
                          View Prescription List
                        </a>
                      </p>
                    </div>
                  </div>
                </div>
                
         
            </div>
          </div>


      <div class="tab-pane fade" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <center><h4>Create an appointment</h4></center><br>
              <form class="form-group" method="post" action="admin-panel.php">
                <div class="row">
                  
                <?php
                  $con = mysqli_connect("localhost", "root", "", "myhmsdb");
                  if (!$con) {
                      die("Connection failed: " . mysqli_connect_error());
                  }

                  $query = mysqli_query($con, "SELECT doc_id, username, spec, docFees, doc_Fees_iv, spec_iv FROM doctb");
                  $docarray = [];

                  while ($row = mysqli_fetch_assoc($query)) {
                      // decrypt docFees
                      $decryptedDocFees = decryptData($row['docFees'], $row['doc_Fees_iv']);
                      $decryptedSpec = decryptData($row['spec'], $row['spec_iv']);
         
                      $row['docFees'] = $decryptedDocFees;
                      $row['spec'] = $decryptedSpec;
                     
           
                      $docarray[] = $row;
                  }

                  ?>
        

                    <div class="col-md-4">
                          <label for="spec">Specialization:</label>
                        </div>
                        <div class="col-md-8">
                          <select name="spec" class="form-control" id="spec">
                              <option value="" disabled selected>Select Specialization</option>
                              <?php 
                              display_specs();
                              ?>
                          </select>
                        </div>

                        <br><br>

                        <script>
                      document.getElementById('spec').onchange = function foo() {
                        let spec = this.value;   
                        console.log(spec)
                        let docs = [...document.getElementById('doctor').options];
                        
                        docs.forEach((el, ind, arr)=>{
                          arr[ind].setAttribute("style","");
                          if (el.getAttribute("data-spec") != spec ) {
                            arr[ind].setAttribute("style","display: none");
                          }
                        });
                      };

                  </script>

              <div class="col-md-4"><label for="doctor">Doctors:</label></div>
                <div class="col-md-8">
                    <select name="doctor" class="form-control" id="doctor" required="required">
                      <option value="" disabled selected>Select Doctor</option>
                
                      <?php display_docs(); ?>
                    </select>
                  </div><br/><br/> 


                        <script>
             document.getElementById('doctor').onchange = function () {
 
              let selection = document.querySelector(`[value="${this.value}"]`).getAttribute('data-value');
              document.getElementById('docFees').value = selection; 
          };

            </script>

                  
           
                <div class="col-md-4"><label for="consultancyfees">Consultancy Fees</label></div>
                  <div class="col-md-8">
                      <input class="form-control" type="text" name="docFees" id="docFees" readonly="readonly"/>
                  </div>
                  <br><br>

                  <div class="col-md-4"><label>Appointment Date</label></div>
                  <div class="col-md-8"><input type="date" class="form-control datepicker" name="appdate"></div><br><br>

                  <div class="col-md-4"><label>Appointment Time</label></div>
                  <div class="col-md-8">
                    <!-- <input type="time" class="form-control" name="apptime"> -->
                    <select name="apptime" class="form-control" id="apptime" required="required">
                      <option value="" disabled selected>Select Time</option>
                      <option value="08:00:00">8:00 AM</option>
                      <option value="10:00:00">10:00 AM</option>
                      <option value="12:00:00">12:00 PM</option>
                      <option value="14:00:00">2:00 PM</option>
                      <option value="16:00:00">4:00 PM</option>
                    </select>

                  </div><br><br>

                  <div class="col-md-4">
                    <input type="submit" name="app-submit" value="Create new entry" class="btn btn-primary" id="inputbtn">
                  </div>
                  <div class="col-md-8"></div>                  
                </div>
              </form>
            </div>
          </div>
        </div><br>
      </div>
      
      <div class="tab-pane fade" id="app-hist" role="tabpanel" aria-labelledby="list-pat-list">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Doctor Name</th>
                <th scope="col">Consultancy Fees</th>
                <th scope="col">Appointment Date</th>
                <th scope="col">Appointment Time</th>
                <th scope="col">Current Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $con = mysqli_connect("localhost", "root", "", "myhmsdb");
            if (!$con) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // fetch appointments for the specific patient
            $query = "SELECT 
            a.ID, 
            d.username AS doctorName, 
            a.docFees, a.docFees_iv, 
            a.appdate, a.appdate_iv, 
            a.apptime, a.apptime_iv, 
            a.userStatus, a.doctorStatus 
          FROM appointmenttb a
          JOIN doctb d ON a.doctor = d.doc_id
          WHERE a.fname = ? AND a.lname = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("ss", $_SESSION['fname'], $_SESSION['lname']);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
              
                $decryptedDocFees = decryptData($row['docFees'], $row['docFees_iv']);
                $decryptedAppDate = decryptData($row['appdate'], $row['appdate_iv']);
                $decryptedAppTime = decryptData($row['apptime'], $row['apptime_iv']);
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['doctorName']); ?></td>
                    <td><?php echo htmlspecialchars($decryptedDocFees); ?></td>
                    <td><?php echo htmlspecialchars($decryptedAppDate); ?></td>
                    <td><?php echo htmlspecialchars($decryptedAppTime); ?></td>
                    <td>
                        <?php 
                        if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) {
                            echo "Active";
                        } elseif (($row['userStatus'] == 0) && ($row['doctorStatus'] == 1)) {
                            echo "Cancelled by You";
                        } elseif (($row['userStatus'] == 1) && ($row['doctorStatus'] == 0)) {
                            echo "Cancelled by Doctor";
                        }
                        ?>
                    </td>
                    <td>
                        <?php if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) { ?>
                            <a href="admin-panel.php?ID=<?php echo $row['ID']; ?>&cancel=update" 
                              onClick="return confirm('Are you sure you want to cancel this appointment?')" 
                              title="Cancel Appointment" tooltip-placement="top" tooltip="Remove">
                              <button class="btn btn-danger">Cancel</button>
                            </a>
                        <?php } else {
                            echo "Cancelled";
                        } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
</div>



      <div class="tab-pane fade" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
        
              <table class="table table-hover">
                <thead>
                  <tr>
                    
                    <th scope="col">Doctor Name</th>
                    <th scope="col">Appointment ID</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                    <th scope="col">Diseases</th>
                    <th scope="col">Allergies</th>
                    <th scope="col">Prescriptions</th>
                    <th scope="col">Bill Payment</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 

                    $con=mysqli_connect("localhost","root","","myhmsdb");
                    global $con;

                    $query = "SELECT 
                    p.doctor,
                    p.ID,
                    a.appdate, a.appdate_iv, 
                    a.apptime, a.apptime_iv, 
                    p.disease, p.disease_iv, 
                    p.allergy, p.allergy_iv, 
                    p.prescription, p.prescription_iv 
                  FROM prestb p
                  JOIN appointmenttb a ON p.ID = a.ID
                  WHERE p.pid = '$pid';";
    
                  $result = mysqli_query($con, $query);
                  if (!$result) {
                      echo mysqli_error($con);
                  }
              
                  while ($row = mysqli_fetch_array($result)) {
                      $_SESSION['ID'] = $row['ID'];
               
                      $decryptedAppDate = decryptData($row['appdate'], $row['appdate_iv']);
                      $decryptedAppTime = decryptData($row['apptime'], $row['apptime_iv']);
                      $decryptedDisease = decryptData($row['disease'], $row['disease_iv']);
                      $decryptedAllergy = decryptData($row['allergy'], $row['allergy_iv']);
                      $decryptedPrescription = decryptData($row['prescription'], $row['prescription_iv']);
                  ?>
                      <tr>
                          <td><?php echo htmlspecialchars($row['doctor']); ?></td>
                          <td><?php echo htmlspecialchars($row['ID']); ?></td>
                          <td><?php echo htmlspecialchars($decryptedAppDate); ?></td>
                          <td><?php echo htmlspecialchars($decryptedAppTime); ?></td>
                          <td><?php echo htmlspecialchars($decryptedDisease); ?></td>
                          <td><?php echo htmlspecialchars($decryptedAllergy); ?></td>
                          <td><?php echo htmlspecialchars($decryptedPrescription); ?></td>
                        <td>
                        <form method="get" action="payment-details.php">
                        <td>
                            <button type="button" onclick="openPaymentModal('<?php echo $row['ID']; ?>')" class="btn btn-success">Pay Bill</button>
                        </td>

                      </form>


                    
                      </tr>
                    <?php }
                    ?>
                </tbody>
              </table>
        <br>
      </div>
             



      <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">...</div>
      <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
        <form class="form-group" method="post" action="func.php">
          <label>Doctors name: </label>
          <input type="text" name="name" placeholder="Enter doctors name" class="form-control">
          <br>
          <input type="submit" name="doc_sub" value="Add Doctor" class="btn btn-primary">
        </form>
      </div>
       <div class="tab-pane fade" id="list-attend" role="tabpanel" aria-labelledby="list-attend-list">...</div>
    </div>
  </div>
</div>

<div class="modal fade" id="activityLogModal" tabindex="-1" role="dialog" aria-labelledby="activityLogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="activityLogModalLabel">History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                // fetch activity log 
                $query = mysqli_query(
                    $con, 
                    "SELECT * FROM activity_log 
                     WHERE pid = '{$_SESSION['pid']}' 
                     AND (login = '' OR login IS NULL) 
                     ORDER BY created_on DESC"
                );
                if (mysqli_num_rows($query) > 0) {
                    echo "<table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th>Activity</th>
                                    <th>Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>";
                    while ($row = mysqli_fetch_assoc($query)) {
                        $decryptedActivity = decryptData($row['activity'], $row['activity_iv']);
                        echo "<tr>
                                <td>{$decryptedActivity}</td>
                                <td>{$row['created_on']}</td>
                              </tr>";
                    }
                    echo "</tbody>
                          </table>";
                } else {
                    echo "<p>No activity log found.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Enter Payment Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="paymentForm" method="get" action="admin-panel.php">
                    <div class="form-group">
                        <label for="creditCard">Credit Card Number:</label>
                        <input type="text" class="form-control" id="creditCard" name="credit_card" placeholder="1234 5678 9101 1121" required />
                    </div>
                    <div class="form-group">
                        <label for="expiryDate">Expiry Date:</label>
                        <input type="text" class="form-control" id="expiryDate" name="expiry" placeholder="MM/YY" required />
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV:</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123" required />
                    </div>
                    <input type="hidden" id="appointmentId" name="appointment_id" value="" />
                    <input type="hidden" name="generate_bill" value="true" />
                    <button type="submit" onclick="alert('Bill Paid Successfully');" class="btn btn-success">Pay Bill</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Modal Styling -->
<style>
  /* .modal { display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); }
  .modal-content { background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 300px; text-align: center; }
  .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; } */
</style>
   </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js">
   </script>
   <script>
  // open the modal
  function openPaymentModal(appointmentId) {
    // Set the appointment ID in the hidden input field
    document.getElementById('appointmentId').value = appointmentId;

    // Show the modal
    $('#paymentModal').modal('show');
}


// Close the modal using Bootstrap's modal method
function closePaymentModal() {
    $('#paymentModal').modal('hide');
}

// trigger modal close when clicking outside the modal
window.onclick = function(event) {
  const modal = document.getElementById("paymentModal");
  if (event.target === modal) {
    closePaymentModal();
  }
}
  // when the user clicks "Pay" in the modal
  function payBill() {
    alert("Bill Paid Successfully");
    closePaymentModal();
  }

  document.querySelector(".close").onclick = closePaymentModal;
</script>



  </body>
</html>
