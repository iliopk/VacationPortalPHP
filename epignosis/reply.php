<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "myCompany";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Make greek characters readable from db
mysqli_set_charset($conn,"utf8");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
/*echo "Connected successfully";*/
if (isset($_POST['submit'])) {
    echo '<br />The ' . $_POST['submit'] . ' submit button was pressed<br />';
	if ($_POST['submit']=="Approve"){
	$status= "approved";
} else {
	$status= "rejected";
}
}

//echo $status;
//echo $_POST['uid'];
$date=$_POST['subDate'];
$user=$_POST['uid'];
$start=$_POST['firstday'];
$end=$_POST['lastday'];

//update status of application based on admin's answer
$sql = "UPDATE vacation SET status='$status' WHERE uID='$user' AND startingDate='$start' AND endDate='$end'";

if ($conn->query($sql) === TRUE) {
   // echo "New record updated successfully";
} else {
   // echo "Error: " . $sql . "<br>" . $conn->error;
}

//get the user email
$sql = "SELECT email FROM user WHERE userID='$user'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
 
$row = $result->fetch_assoc(); 
$user_email=$row["email"];
}
//echo $user_email;

//get the admin email
$sql = "SELECT email FROM user WHERE userType='admin'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
 
$row = $result->fetch_assoc(); 
$admin_email=$row["email"];
//echo $admin_email;
}

//send  email to the user 
$to      = $user_email; //recipient
$subject = 'VACATION STATUS UPDATE';
$message = '<html><body>';
$message .= '<p>Dear Employee, your supervisor has '.$status.' your application submitted on '.$date.'</p>';
$message .= '</body></html>';
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$headers .= 'From: '.$admin_email.'' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

$result = mail($to, $subject, $message, $headers);
if( $result ) {
   //echo 'Success';
}else{
   //echo 'Fail';
}


$conn->close();


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8"> 
	<link rel="stylesheet" type="text/css" href="p_style.css">
  </head>
  <body>
    <p>Submit was successful!</p>
	<script>window.close();</script>
  </body>
</html>
