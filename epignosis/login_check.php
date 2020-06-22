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
//html form fields values
$s_email = $_POST["email"];
$s_pwd = $_POST["pwd"];

//check if user is employee or admin 
$get_user="SELECT userType from user WHERE email='$s_email'";
$result = $conn->query($get_user);

// create session variable with user type
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); 
    $_SESSION["userType"]= $row["userType"];
}

//admin action
if ($_SESSION["userType"]=="admin") {
	echo '<button id="create">Create User</button><br><br>';

    $query = "SELECT * FROM user";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
	   echo '<table id="mytbl" style="width:100%;background-color:#f2f2f2;">
          <tr>
             <th style="text-align:left">User Firstname</th>
             <th style="text-align:left">User Lastname</th> 
             <th style="text-align:left">User Email</th>
             <th style="text-align:left">User Type</th> 			 
         </tr>';
	    while($row = $result->fetch_assoc()) {
          echo "<tr><td>".$row['firstName']."</td>";
	      echo "<td>".$row['lastName']."</td>";
	      echo "<td>".$row['email']."</td>";
	      echo "<td>".$row['userType']."</td></tr>";
        }
    }

//$conn->close();
echo '<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="p_style.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
         $(document).ready(function(){ 
			 $("#c_email").on("blur", function(){
			 
				var email=$(this).val();
				  if (email != ""){
                 $.ajax({
				       method:"POST",	
                       url: "/epignosis/check_email.php", 
                       data:{email:email},
					    success: function(response){					    
                           alert (response);						
                       }
				 });
              }		
				 }
			 );
			
		 });
</script>	
 
</head>
<body>
  
  <div id="myModal1" class="modal">
       <!-- Modal content -->
       <div class="modal-content">
         <form action="/epignosis/update_user_action.php" id="u_usrform" method="post">
	      
	      <label for="u_fname">First name:</label><br>
          <input type="text" id="u_fname" name="u_fname" ><br>
          <label for="u_lname">Last name:</label><br>
          <input type="text" id="u_lname" name="u_lname" ><br>
          <label for="email">Enter your email:</label>
          <input type="email" id="u_email" name="u_email"><br> 
          <label for="u_pwd">Password:</label>
          <input type="password" id="u_pwd" name="u_pwd"><br>
          <label for="u_confirm_pwd">Confirm Password:</label>
          <input type="password" id="u_confirm_pwd" name="u_confirm_pwd"><br>
          <label for="u_uType">User Type:</label>
          <select name="u_uType" id="u_uType" required>
		    <option value="" readonly selected hidden>Please choose</option>
		    <option value="employee">Employee</option>
			<option value="admin">Admin</option>
		  </select> 		  
          
		  <input type="submit" id="update" value="Update">
         </form>  
       </div>
   </div>
   <div id="myModal2" class="modal">
       <!-- Modal content -->
       <div class="modal-content">
         <form action="/epignosis/create_user_action.php" id="c_usrform" method="post">
	      
	      <label for="c_fname">First name:</label><br>
          <input type="text" id="c_fname" name="c_fname" required><br>
          <label for="c_lname">Last name:</label><br>
          <input type="text" id="c_lname" name="c_lname" required><br>
          <label for="c_email">Enter your email:</label>
          <input type="email" id="c_email" name="c_email" placeholder="Please enter your email" onchange="checkEmail()" required><br> 
          <label for="c_pwd">Password:</label>
          <input type="password" id="c_pwd" name="c_pwd" placeholder="Please enter your password" required><br>
          <label for="c_confirm_pwd">Confirm Password:</label>
          <input type="password" id="c_confirm_pwd" name="c_confirm_pwd" placeholder="Please confirm your password"  required><br>
          <label for="c_uType">User Type:</label>
          <select name="c_uType" id="c_uType" required>
		    <option value="" readonly selected hidden>Please choose</option>
		    <option value="employee">Employee</option>
			<option value="admin">Admin</option>
		  </select> 		  
          <input type="submit" id="submit" value="Create">
     </form> 
       </div>
   </div>
      <script>
	  // pre-populate form
	  $("#mytbl").on("click", "tr", function(){ 
        var user=$(this).find("td:eq(2)").text();
           $.ajax({
               url: "/epignosis/fetch_users.php",
               type: "POST",	
              	dataType: "json",   
               data: {user:user},
        success: function(data) {
   
		  $("#u_fname").val(data.firstName);
		  $("#u_lname").val(data.lastName);
		  $("#u_email").val(data.email);
		  $("#u_uType").val(data.userType);
		  
     
        },
       
    });	
	
       $("#myModal1").css("display","block")//open update modal
         
});

     $("#update").on("click", function(){
		 $("#myModal1").css("display","none")//close update modal
	 })
     
	 $("#create").on("click", function(){
		 $("#myModal2").css("display","block")//open create modal
	 })
	 
	 $("#submit").on("click", function(){
		 $("#myModal2").css("display","none")//close create modal
	 })
	 
	 // check if password fields contain same password
	 document.getElementById("confirm_pwd").onchange = function() {checkPassword()};
	 function checkPassword(){
	    var p1 = document.getElementById("pwd").value;
		var p2 = document.getElementById("confirm_pwd").value;
		
		if (p1!=p2){
		   alert("passwords dont match!");
		}
		}
	
</script>

</body>
</html>';
	
} else {
   echo ' <br><button id="submitRequest">Submit Request</button><br><br>';
   $get_user="SELECT userID from user WHERE email='$s_email'";
   $result = $conn->query($get_user);

if ($result->num_rows > 0) {
 
$row = $result->fetch_assoc(); 
$uid= $row["userID"];
$_SESSION["user"]=$row["userID"];
  //echo $uid;
  //echo $_SESSION["user"];
}


$get_vac="SELECT * from vacation WHERE uID='$uid' ORDER BY submitDate DESC";
$result1 = $conn->query($get_vac);



if ($result1->num_rows > 0) {
	echo '<table id="mytb2" style="width:100%;background-color:#f2f2f2;">
          <tr>
             <th style="text-align:left">Date Submitted</th>
             <th style="text-align:left">Dates Requested</th> 
             <th style="text-align:left">Days Requested</th>
             <th style="text-align:left">Status</th> 			 
         </tr>';
	while($row1 = $result1->fetch_assoc()) {
       echo "<tr><td>".$row1["submitDate"]."</td>";
	   echo "<td>".$row1["startingDate"]."-".$row1["endDate"]."</td>";
	   $datetime1 = date_create($row1["startingDate"]);
       $datetime2 = date_create($row1["endDate"]);
       $interval = date_diff($datetime1, $datetime2);
	   echo "<td>".$interval->format('%d')."</td>";   
	   echo "<td>".$row1["status"]."</td></tr>";
    }
}

echo '<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="p_style.css">
</head>
  <body>
    
  
  
    <div id="myModal" class="modal">
       <!-- Modal content -->
       <div class="modal-content">
            <form id="vac_request" action="/epignosis/vac_action.php" method="post">
                <label for="firstDay">Vacation starting on:</label>
                <input type="date" id="firstDay" name="firstDay" required><br> 
                <label for="pwd">Vacation ending on:</label>
                <input type="date" id="lastDay" name="lastDay" onchange="checkDate()" required><br> 
		        <textarea id="reason" rows="4" cols="50" name="reason"  form="vac_request"></textarea><br>
		        <input type="hidden" id="current_date" name="current_date"><br> 
		        <input type="hidden" id="status" name="status" value="pending" ><br> 
                <button type="submit" id="submit">Submit</button>
             </form>  
       </div>
     </div>
   
   <script>
      var modal = document.getElementById("myModal");

      // Get the submit element that opens the modal
      var open = document.getElementById("submitRequest");
	  // Get the submit element that closes the modal
	  var close = document.getElementById("submit");
	  
	  //get today"s date		 
      var today = new Date();
      var date = today.getFullYear()+"-"+(today.getMonth()+1)+"-"+today.getDate();
      document.getElementById("current_date").value = date;
	 
	  // check if date interval is correct
	  function checkDate(){
		  var start = new Date(document.getElementById("firstDay").value);	
          var end = new Date(document.getElementById("lastDay").value);
          if( start > end){
               alert("vacation end date cannot be before start date");
	      }
      }	 
       
      // display modal	   
	  open.onclick = function() {
            modal.style.display = "block";
       }
	   
	   // close modal
         close.onclick = function() {
			 if ((document.getElementById("firstDay").value)!="" &(document.getElementById("lastDay").value)!=""){
                modal.style.display = "none";
			    document.getElementById("vac_request").submit();
			 }
       }
	</script>
      
   
  </body>
</html>';
}

//$conn->close();
?>