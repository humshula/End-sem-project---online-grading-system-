<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm-password'];
$department = $_POST['department'];
$subjects = $_POST['subjects'];

if ($password != $confirm_password) {
die("Error: Passwords do not match");
}
            $hash = password_hash($password, PASSWORD_DEFAULT);

$conn = mysqli_connect('localhost', 'root', 'green ranger', 'grading_system');

$sql = "INSERT INTO `faculty` (`name`, `email`, `password`, `department`, `date`) VALUES ('$name', '$email', '$hash', '$department', current_timestamp())";
if (!mysqli_query($conn, $sql)) {
die("Error: " . mysqli_error($conn));
}

echo "Signup successful!";
                header("location: loginfaculty.php");

mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html>
   <head>
<meta charset="UTF-8">
<meta name="viewport" content="width = device-width, initial-scale = 1.0">
<title>faculty registration</titel>
      <style>
         body {
          background: #6a11cb;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to right, rgba(106, 7, 203, 1), rgba(37, 117, 252, 1));

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
          background: linear-gradient(to right, rgba(106, 7, 203, 1), rgba(37, 117, 252, 1))
            
            

         }
         .container{
      
      width:250px;
      height:fit-content;
      background-color: rgb(200, 214, 214);
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0px 0px 10px #888888;
      align-items: center;
      justify-content: center;
      
    }
    
    .login-box {
  width: 320px;
  height:fit-content;
  background: rgba(0, 0, 0, 0.2);
  color: #805f5f;
  top: 50%;
  left: 50%;
  position: absolute;
  transform: translate(-50%, -50%);
  box-sizing: border-box;
  padding: 70px 30px;
}
.login-box a{
  color:black;
}
input{
  width: 150px;
 padding: 5px;
  margin-bottom: 10px;
  border-radius: 5px;
  border:none;
  border-radius: 5px;
  
}
      </style> 
       
   </head>

    <center>
        <body>
         <div class="login-box">
<a href="index.php">home</a>

        <h1><a>faculty signup</a></h1>

<form action="faculty.php" method="post">
      <label for="facultyname"><a>facultyname : </a></label> 
          <b><input type="text" id="facultyname" placeholder="Enter name" name="name" required></b><br>
          <br>
          <label for="email"><a>email : </a></label> 
       <b> <input type="email" id="email" placeholder="Enter email" name="email" required></b><br>
        <br>
        <label for="password"><a>password :</a> </label> 
      <b>  <input type="password" id="password" placeholder="Enter password" name="password" required></b><br>
        <br>
        <label for="cpassword" > <a>confirm password :</a></label> 
      <b>  <input type="password" id="cpassword" placeholder="confirm password" name="confirm-password" required></b><br>
        <br>
<p id="error_msg">
<span></span>
</p>
       <!-- HTML code -->
<label for="departments">Choose a department:</label>
<select id="departments" name="department" onchange="showSubjects()">
  <option value="">Select department</option>
<?php
$conn = mysqli_connect('localhost', 'root', 'green ranger', 'grading_system');

$result = mysqli_query($conn, "SELECT * FROM department");
while ($row = mysqli_fetch_assoc($result)) {
					echo "<option value='".$row['department_name']."'>".$row['department_name']."</option>";
				}
			?>

</select>

<div id="subjects" name="subjects"></div>

<button onclick="showSelectedSubjects()">Show selected subjects</button>


        
        <button type="submit" onclick="checkpassword()">signup</button> 
</form>
         </div>
     </body></center>
     
</html>

<script>
    function checkpassword()  {
      var password = document.getElementById("password").value;
       var repassword = document.getElementById("cpassword").value;
      //let flag=0;
    if (password != repassword) {
         //document.getElementById("error_msg").innerHTML = "Passwords do not match";
          alert('password do not match');
          return false;
         // flag=1;
        }
        
      }
    </script>
