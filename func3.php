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


if(isset($_POST['adsub'])){
	$username=$_POST['username1'];
	$password=$_POST['password2'];
	$query="select * from admintb where username='$username' and password='$password';";
	$result=mysqli_query($con,$query);
	if(mysqli_num_rows($result)==1)
	{
		$_SESSION['username']=$username;
		$_SESSION['start_time'] = time(); // current time
        $_SESSION['expiration_time'] = 1800; // expiration time in 30 minutes
        $_SESSION['end_time'] = $_SESSION['start_time'] + $_SESSION['expiration_time'];

		// Generate and set new CSRF token
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $csrf_token = $_SESSION['csrf_token'];
        
        // Update CSRF token in the database
        $update_query = "UPDATE admintb SET csrf_token='$csrf_token' WHERE username='$username';";
        mysqli_query($con, $update_query);

		// insert into activity log
        date_default_timezone_set('Asia/Kuala_Lumpur'); 
        $loginTime = date('Y-m-d H:i:s'); 
        $activity = "Admin logged in";

        $encryptedActivity = encryptData($activity);
        $encryptedLoginTime = encryptData($loginTime);

        $logQuery = "
            INSERT INTO activity_log (
                activity, activity_iv, 
                admin, 
                login, login_iv, 
                created_on
            ) VALUES (
                '" . $encryptedActivity['data'] . "', '" . $encryptedActivity['iv'] . "',
                '$username',
                '" . $encryptedLoginTime['data'] . "', '" . $encryptedLoginTime['iv'] . "',
                NOW()
            )
        ";

        if (mysqli_query($con, $logQuery)) {
            // logged successfully
            header("Location: admin-panel1.php");
            exit();
        } else {
            echo "<script>
                alert('Error logging activity. Please try again.');
                window.location.href = 'index.php';
                </script>";
        }
	}
	else
		// header("Location:error2.php");
		echo("<script>alert('Invalid Username or Password. Try Again!');
          window.location.href = 'index.php';</script>");
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




function display_docs()
{
	global $con;
	$query="select * from doctb";
	$result=mysqli_query($con,$query);
	while($row=mysqli_fetch_array($result))
	{
		$name=$row['name'];
		# echo'<option value="" disabled selected>Select Doctor</option>';
		echo '<option value="'.$name.'">'.$name.'</option>';
	}
}

if(isset($_POST['doc_sub']))
{
	$name=$_POST['name'];
	$query="insert into doctb(name)values('$name')";
	$result=mysqli_query($con,$query);
	if($result)
		header("Location:adddoc.php");
}
