<!DOCTYPE html>
<?php 
include('func1.php');
include('session_tracking.php');
$con=mysqli_connect("localhost","root","","myhmsdb");
use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

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

$doctor = $_SESSION['dname'];
if(isset($_GET['cancel']))
  {
    $query=mysqli_query($con,"update appointmenttb set doctorStatus='0' where ID = '".$_GET['ID']."'");
    if($query)
    {
      echo "<script>alert('Your appointment successfully cancelled');</script>";
    }
  }

  $doctorId = $_SESSION['doc_id'];
  $query = "SELECT email, email_iv FROM doctb WHERE doc_id = '$doctorId'";
  $result = mysqli_query($con, $query);

  // Check if the doctor exists
  if (mysqli_num_rows($result) > 0) {
      // Fetch the encrypted email and IV
      $row = mysqli_fetch_assoc($result);
      $encryptedEmail = $row['email'];
      $emailIv = $row['email_iv']; // Get the IV used during encryption

      // Decrypt the email using both encrypted data and IV
      $decryptedEmail = decryptData($encryptedEmail, $emailIv);
  } else {
      $decryptedEmail = ''; // Default value if no email is found
  }

 
?>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">   
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <a class="navbar-brand" href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> Global Hospital </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

    <style >
      .btn-outline-light:hover{
        color: #25bef7;
        background-color: #f8f9fa;
        border-color: #f8f9fa;
      }
    </style>

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
  </style>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownProfile" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle" style="color: white;"></i> Profile
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                <a class="dropdown-item" href="docprofile.php"><i class="fas fa-user"></i> My Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout1.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
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
    <h3 style = "margin-left: 40%; padding-bottom: 20px;font-family:'IBM Plex Sans', sans-serif;"> Welcome &nbsp<?php echo $_SESSION['dname']; ?>, Your ID: <?php echo $_SESSION['doc_id']; ?>
    </h3>
    <div style="position: absolute; left: 10px; margin-top: -100px;">
        <button class="btn btn-primary" style="background-color: #313866;" data-toggle="modal" data-target="#activityLogModal">
            <i class="fas fa-file"></i> History
        </button>
    </div>
    <div class="row">
  <div class="col-md-4" style="max-width:18%;margin-top: 3%;">
    <div class="list-group" id="list-tab" role="tablist">
      <a class="list-group-item list-group-item-action active" href="#list-dash" role="tab" aria-controls="home" data-toggle="list">Dashboard</a>
      <a class="list-group-item list-group-item-action" href="#list-app" id="list-app-list" role="tab" data-toggle="list" aria-controls="home">Appointments</a>
      <a class="list-group-item list-group-item-action" href="#list-pres" id="list-pres-list" role="tab" data-toggle="list" aria-controls="home"> Prescription List</a>
      
    </div><br>
  </div>
  <div class="col-md-8" style="margin-top: 3%;">
    <div class="tab-content" id="nav-tabContent" style="width: 950px;">
      <div class="tab-pane fade show active" id="list-dash" role="tabpanel" aria-labelledby="list-dash-list">
        
              <div class="container-fluid container-fullw bg-white" >
              <div class="row">

               <div class="col-sm-4" style="left: 10%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-list fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;"> View Appointments</h4>
                      <script>
                        function clickDiv(id) {
                          document.querySelector(id).click();
                        }
                      </script>                      
                      <p class="links cl-effect-1">
                        <a href="#list-app" onclick="clickDiv('#list-app-list')">
                          Appointment List
                        </a>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="col-sm-4" style="left: 15%">
                  <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                      <span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i> </span>
                      <h4 class="StepTitle" style="margin-top: 5%;"> Prescriptions</h4>
                        
                      <p class="links cl-effect-1">
                        <a href="#list-pres" onclick="clickDiv('#list-pres-list')">
                          Prescription List
                        </a>
                      </p>
                    </div>
                  </div>
                </div>    

             </div>
           </div>
         </div>
    

         <div class="tab-pane fade" id="list-app" role="tabpanel" aria-labelledby="list-home-list">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Patient ID</th>
                <th scope="col">Appointment ID</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Gender</th>
                <th scope="col">Email</th>
                <th scope="col">Contact</th>
                <th scope="col">Appointment Date</th>
                <th scope="col">Appointment Time</th>
                <th scope="col">Current Status</th>
                <th scope="col">Action</th>
                <th scope="col">Prescribe</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $con = mysqli_connect("localhost", "root", "", "myhmsdb");
            if (!$con) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $dname = $_SESSION['doc_id'];

            $query = "SELECT 
                        pid, ID, fname, lname, 
                        gender, gender_iv, 
                        email, email_iv, 
                        contact, contact_iv, 
                        appdate, appdate_iv, 
                        apptime, apptime_iv, 
                        userStatus, doctorStatus 
                      FROM appointmenttb 
                      WHERE doctor = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("s", $dname);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                // Decrypt necessary fields
                $decryptedGender = decryptData($row['gender'], $row['gender_iv']);
                $decryptedEmail = decryptData($row['email'], $row['email_iv']);
                $decryptedContact = decryptData($row['contact'], $row['contact_iv']);
                $decryptedAppDate = decryptData($row['appdate'], $row['appdate_iv']);
                $decryptedAppTime = decryptData($row['apptime'], $row['apptime_iv']);
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['pid']); ?></td>
                    <td><?php echo htmlspecialchars($row['ID']); ?></td>
                    <td><?php echo htmlspecialchars($row['fname']); ?></td>
                    <td><?php echo htmlspecialchars($row['lname']); ?></td>
                    <td><?php echo htmlspecialchars($decryptedGender); ?></td>
                    <td><?php echo htmlspecialchars($decryptedEmail); ?></td>
                    <td><?php echo htmlspecialchars($decryptedContact); ?></td>
                    <td><?php echo htmlspecialchars($decryptedAppDate); ?></td>
                    <td><?php echo htmlspecialchars($decryptedAppTime); ?></td>
                    <td>
                    <?php if(($row['userStatus']==1) && ($row['doctorStatus']==1))  
                    {
                      echo "Active";
                    }
                    if(($row['userStatus']==0) && ($row['doctorStatus']==1))  
                    {
                      echo "Cancelled by Patient";
                    }

                    if(($row['userStatus']==1) && ($row['doctorStatus']==0))  
                    {
                      echo "Cancelled by You";
                    }
                        ?></td>

                     <td>
                        <?php if(($row['userStatus']==1) && ($row['doctorStatus']==1))  
                        { ?>

													
	                        <a href="doctor-panel.php?ID=<?php echo $row['ID']?>&cancel=update" 
                              onClick="return confirm('Are you sure you want to cancel this appointment ?')"
                              title="Cancel Appointment" tooltip-placement="top" tooltip="Remove"><button class="btn btn-danger">Cancel</button></a>
	                        <?php } else {

                                echo "Cancelled";
                                } ?>
                        
                        </td>

                        <td>

                        <?php if(($row['userStatus']==1) && ($row['doctorStatus']==1))  
                        { ?>

                        <a href="prescribe.php?pid=<?php echo $row['pid']?>&ID=<?php echo $row['ID']?>&fname=<?php echo $row['fname']?>&lname=<?php echo $row['lname']?>&appdate=<?php echo $row['appdate']?>&apptime=<?php echo $row['apptime']?>"
                        tooltip-placement="top" tooltip="Remove" title="prescribe">
                        <button class="btn btn-success">Prescibe</button></a>
                        <?php } else {

                            echo "-";
                            } ?>
                        
                        </td>


                      </tr></a>
                    <?php } ?>
                </tbody>
              </table>
        <br>
      </div>

      

      <div class="tab-pane fade" id="list-pres" role="tabpanel" aria-labelledby="list-pres-list">
        <table class="table table-hover">
                <thead>
                  <tr>
                    
                    <th scope="col">Patient ID</th>
                    
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Appointment ID</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                    <th scope="col">Disease</th>
                    <th scope="col">Allergy</th>
                    <th scope="col">Prescribe</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 

                      $con = mysqli_connect("localhost", "root", "", "myhmsdb");
                      global $con;

                      $query = "SELECT 
                        p.pid, 
                        p.fname, p.fname_iv, 
                        p.lname, p.lname_iv, 
                        p.ID, 
                        a.appdate, a.appdate_iv, 
                        a.apptime, a.apptime_iv, 
                        p.disease, p.disease_iv, 
                        p.allergy, p.allergy_iv, 
                        p.prescription, p.prescription_iv 
                      FROM prestb p
                      JOIN appointmenttb a ON p.ID = a.ID
                      WHERE p.doctor = '$doctor';";

                  $result = mysqli_query($con, $query);
                  if (!$result) {
                      echo mysqli_error($con);
                  }

                  while ($row = mysqli_fetch_array($result)) {
            
                      $decryptedFname = decryptData($row['fname'], $row['fname_iv']);
                      $decryptedLname = decryptData($row['lname'], $row['lname_iv']);
                      $decryptedAppDate = decryptData($row['appdate'], $row['appdate_iv']);
                      $decryptedAppTime = decryptData($row['apptime'], $row['apptime_iv']);
                      $decryptedDisease = decryptData($row['disease'], $row['disease_iv']);
                      $decryptedAllergy = decryptData($row['allergy'], $row['allergy_iv']);
                      $decryptedPrescription = decryptData($row['prescription'], $row['prescription_iv']);
                  ?>
                      <tr>
                          <td><?php echo htmlspecialchars($row['pid']); ?></td>
                          <td><?php echo htmlspecialchars($decryptedFname); ?></td>
                          <td><?php echo htmlspecialchars($decryptedLname); ?></td>
                          <td><?php echo htmlspecialchars($row['ID']); ?></td>
                          <td><?php echo htmlspecialchars($decryptedAppDate); ?></td>
                          <td><?php echo htmlspecialchars($decryptedAppTime); ?></td>
                          <td><?php echo htmlspecialchars($decryptedDisease); ?></td>
                          <td><?php echo htmlspecialchars($decryptedAllergy); ?></td>
                          <td><?php echo htmlspecialchars($decryptedPrescription); ?></td>
                      </tr>
                    <?php }
                    ?>
                </tbody>
              </table>
      </div>




      <div class="tab-pane fade" id="list-app" role="tabpanel" aria-labelledby="list-pat-list">
        
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Doctor Name</th>
                    <th scope="col">Consultancy Fees</th>
                    <th scope="col">Appointment Date</th>
                    <th scope="col">Appointment Time</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 

                    $con=mysqli_connect("localhost","root","","myhmsdb");
                    global $con;

                    $query = "select * from appointmenttb;";
                    $result = mysqli_query($con,$query);
                    while ($row = mysqli_fetch_array($result)){
              
                      #$fname = $row['fname'];
                      #$lname = $row['lname'];
                      #$email = $row['email'];
                      #$contact = $row['contact'];
                  ?>
                      <tr>
                        <td><?php echo $row['fname'];?></td>
                        <td><?php echo $row['lname'];?></td>
                        <td><?php echo $row['email'];?></td>
                        <td><?php echo $row['contact'];?></td>
                        <td><?php echo $row['doctor'];?></td>
                        <td><?php echo $row['docFees'];?></td>
                        <td><?php echo $row['appdate'];?></td>
                        <td><?php echo $row['apptime'];?></td>
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
                  <div class="col-md-8"><input type="text" class="form-control" name="doctor" required></div><br><br>
                  <div class="col-md-4"><label>Password:</label></div>
                  <div class="col-md-8"><input type="password" class="form-control"  name="dpassword" required></div><br><br>
                  <div class="col-md-4"><label>Email ID:</label></div>
                  <div class="col-md-8"><input type="email"  class="form-control" name="demail" required></div><br><br>
                  <div class="col-md-4"><label>Consultancy Fees:</label></div>
                  <div class="col-md-8"><input type="text" class="form-control"  name="docFees" required></div><br><br>
                </div>
          <input type="submit" name="docsub" value="Add Doctor" class="btn btn-primary">
        </form>
      </div>
       <div class="tab-pane fade" id="list-attend" role="tabpanel" aria-labelledby="list-attend-list">...</div>
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
                <?php
                // get logged-in doctor's ID from the session
                $docId = $_SESSION['doc_id'];

                // fetch activity log for the logged-in doctor
                $query = mysqli_query($con, "
                    SELECT 
                        a.activity, 
                        a.activity_iv, 
                        a.created_on, 
                        p.fname AS patient_fname, 
                        p.lname AS patient_lname
                    FROM activity_log a
                    LEFT JOIN patreg p ON a.pid = p.pid
                    WHERE a.doc_id = '$docId'
                    AND (login = '' OR login IS NULL) 
                    ORDER BY a.created_on DESC
                ");
                if (mysqli_num_rows($query) > 0) {
                    echo "<table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th>Activity</th>
                                    <th>Patient</th>
                                    <th>Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>";
                    while ($row = mysqli_fetch_assoc($query)) {
                        $decryptedActivity = decryptData($row['activity'], $row['activity_iv']);
                        $patientName = !empty($row['patient_fname']) ? "{$row['patient_fname']} {$row['patient_lname']}" : "N/A";
                        echo "<tr>
                                <td>{$decryptedActivity}</td>
                                <td>{$patientName}</td>
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

<script>

    document.getElementById('save-btn').addEventListener('click', function () {
        const email = document.getElementById('email').value;

        // send OTP to the email via AJAX
        fetch('doctor-panel.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `send_otp=1&email=${email}`
        })
        .then(response => response.text())
        .then(data => {
            alert(data); 
            document.getElementById('otp-section').style.display = 'block'; // show OTP section
            document.getElementById('save-btn').style.display = 'none';
            document.getElementById('verify-btn').style.display = 'inline-block';
        });
    });

    document.getElementById('verify-btn').addEventListener('click', function () {
        const otp = document.getElementById('otp').value;

        // validate OTP via AJAX
        fetch('doctor-panel.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `validate_otp=1&otp=${otp}`
        })
        .then(response => response.text())
        .then(data => {
            alert(data); 
            if (data.includes('OTP is valid')) {
                // proceed to reset password
                document.getElementById('password-section').style.display = 'block';
            }
        });
    });
</script>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js"></script>
  </body>
</html>