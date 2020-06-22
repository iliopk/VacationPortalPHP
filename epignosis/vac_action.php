<?php
session_start();
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
//echo $_SESSION["user"];

//get the values of the html form fields
$s_firstDay = $_POST["firstDay"];
$s_lastDay = $_POST["lastDay"];
$s_reason = $_POST["reason"];
$s_current_date = $_POST["current_date"];
$s_status = $_POST["status"];
$s_user = $_SESSION["user"];

//insert new application's info in db
$sql = "INSERT INTO vacation (startingDate, endDate, reason, submitDate, status, uID)
VALUES ('$s_firstDay', '$s_lastDay', '$s_reason', '$s_current_date', '$s_status', '$s_user')";

if ($conn->query($sql) === TRUE) {
    //echo "New record created successfully";
} else {
    //echo "Error: " . $sql . "<br>" . $conn->error;
}

//get admin's email
$sql = "SELECT email FROM user WHERE userType='admin'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
 
$row = $result->fetch_assoc(); 
$admin_email=$row["email"];
//echo $admin_email;
}

//get employee's email
$sql = "SELECT * FROM user WHERE userID='$s_user'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
 
$row = $result->fetch_assoc(); 
$user_email=$row["email"];
$user_fname=$row["firstName"];
$user_lname=$row["lastName"];
}

//send email to admin
$to      = $admin_email;
$subject = 'VACATION REQUEST';
$message = '<html><body>';
$message .= '<p>Dear supervisor, employee '.$user_lname.' '.$user_fname.' requested for some time off, starting on '.$s_firstDay.' and ending on '.$s_lastDay.' stating the reason:<br>'.$s_reason.'<br>Click on one of the below links to approve or reject the application:</p><form action="localhost/epignosis/reply.php" method="post"><input type="submit" name="submit" value="Approve"><input type="hidden" name="uid" value="'.$s_user.'"><input type="hidden" name="firstday" value="'.$s_firstDay.'"><input type="hidden" name="lastday" value="'.$s_lastDay.'"><input type="hidden" name="subDate" value="'.$s_current_date.'"><input type="submit" name="submit" value="Reject"></form>';
$message .= '</body></html>';
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$headers .= 'From: '.$user_email.'' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

$result = mail($to, $subject, $message, $headers);
if( $result ) {
   //echo 'Success';
}else{
   //echo 'Fail';
}
//echo $_SESSION["user"];

$conn->close();


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8"> 
	<link rel="stylesheet" type="text/css" href="p_style.css">
  </head>
  <body>
    <a href="/epignosis/login.html">LOGOUT</a>
  </body>
</html>
