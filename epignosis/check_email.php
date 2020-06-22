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

// received ajax call
$request = $_POST["email"];

// try to find in db if email already exists
$query = "SELECT * FROM user WHERE email LIKE '$request%'";
$result = $conn->query($query);


// if at least one row exists then alert message
if ($result->num_rows > 0) {
   echo "User already exists!";
}



$conn->close();

?>