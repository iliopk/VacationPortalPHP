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
//echo "Connected successfully";
//echo $_SESSION['user'];
$user=$_SESSION['user'];
$query = "SELECT userID FROM user WHERE email='$user'"; // select user whose properties are about to be updated
$result = $conn->query($query);
$row = $result->fetch_assoc();
$id=$row['userID'];


//get user's info from html form
$s_fname = $_POST["u_fname"];
$s_lname = $_POST["u_lname"];
$s_email = $_POST["u_email"];
$s_pwd = $_POST["u_pwd"];
$s_uType = $_POST["u_uType"];


//store info in db
$sql = "UPDATE user SET firstName='$s_fname', lastName='$s_lname', email='$s_email', password='$s_pwd', userType='$s_uType' WHERE userID='$id'";


if ($conn->query($sql) === TRUE) {
    //echo "New record created successfully";
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
