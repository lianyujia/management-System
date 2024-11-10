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

// if(isset($_POST['submit'])){
//  $username=$_POST['username'];
//  $password=$_POST['password'];
//  $query="select * from logintb where username='$username' and password='$password';";
//  $result=mysqli_query($con,$query);
//  if(mysqli_num_rows($result)==1)
//  {
//   $_SESSION['username']=$username;
//   $_SESSION['pid']=
//   header("Location:admin-panel.php");
//  }
//  else
//   header("Location:error.php");
// }
if(isset($_POST['update_data']))
{
 $contact=$_POST['contact'];
 $status=$_POST['status'];
 $query="update appointmenttb set payment='$status' where contact='$contact';";
 $result=mysqli_query($con,$query);
 if($result)
  header("Location:updated.php");
}

// function display_docs()
// {
//  global $con;
//  $query="select * from doctb";
//  $result=mysqli_query($con,$query);
//  while($row=mysqli_fetch_array($result))
//  {
//   $username=$row['username'];
//   $price=$row['docFees'];
//   echo '<option value="' .$username. '" data-value="'.$price.'">'.$username.'</option>';
//  }
// }


function display_specs() {
  global $con;

  // Query to fetch distinct specializations
  $query = "SELECT DISTINCT(spec), spec_iv FROM doctb";
  $result = mysqli_query($con, $query);

  if (!$result) {
      die("Query Failed: " . mysqli_error($con));
  }

  while ($row = mysqli_fetch_array($result)) {
      // Decrypt the specialization
      $decryptedSpec = decryptData($row['spec'], $row['spec_iv']);

      // Generate the option tag
      echo '<option data-value="' . $decryptedSpec . '">' . $decryptedSpec . '</option>';
  }
}


function display_docs()
{
    global $con;

    // Query to fetch doctor details
    $query = "SELECT doc_id, username, docFees, doc_Fees_iv, spec, spec_iv FROM doctb";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Query Failed: " . mysqli_error($con));
    }

    while ($row = mysqli_fetch_array($result)) {
        // Decrypt the docFees and spec
        $decryptedDocFees = decryptData($row['docFees'], $row['doc_Fees_iv']);
        $decryptedSpec = decryptData($row['spec'], $row['spec_iv']);

        // Extract other details
        $doc_id = $row['doc_id'];
        $username = $row['username'];

        // Generate the option tag with decrypted spec and fees
        echo '<option value="' . $doc_id . '" data-value="' . $decryptedDocFees . '" data-spec="' . $decryptedSpec . '">
                Dr. ' . $username . ' (' . $decryptedSpec . ')
              </option>';
    }
}

// function display_specs() {
//   global $con;
//   $query = "select distinct(spec) from doctb";
//   $result = mysqli_query($con,$query);
//   while($row = mysqli_fetch_array($result))
//   {
//     $spec = $row['spec'];
//     $username = $row['username'];
//     echo '<option value = "' .$spec. '">'.$spec.'</option>';
//   }
// }


if(isset($_POST['doc_sub']))
{
 $username=$_POST['username'];
 $query="insert into doctb(username)values('$username')";
 $result=mysqli_query($con,$query);
 if($result)
  header("Location:adddoc.php");
}

?>