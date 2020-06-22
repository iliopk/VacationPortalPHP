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
//echo "Connected successfully";

//get user's info from html form
$s_fname = $_POST["c_fname"];
$s_lname = $_POST["c_lname"];
$s_email = $_POST["c_email"];
$s_pwd = $_POST["c_pwd"];
$s_uType = $_POST["c_uType"];

//store info in db
$sql = "INSERT INTO user (firstName, lastName, email, password, userType) VALUES ('$s_fname', '$s_lname', '$s_email', '$s_pwd', '$s_uType')";

if ($conn->query($sql) === TRUE) {
   // echo "New record created successfully";
} else {
    //echo "Error: " . $sql . "<br>" . $conn->error;
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
    <a href="/epignosis/login.html">LOGOUT</a>
  </body>
</html>