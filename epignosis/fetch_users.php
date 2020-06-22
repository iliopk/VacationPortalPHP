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

// get the email address of selected user
$user=$_POST["user"];
$_SESSION['user']=$user;
// get the user's info
$query = "SELECT * FROM user WHERE email='$user'";
$result = $conn->query($query);
$row = $result->fetch_assoc();

//respond to ajax call
echo json_encode($row);

$conn->close();

?>