<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){

$name = $_POST['name'];
$rollnumber = $_POST['rollno'];
$year = $_POST['year'];
$department = $_POST['department'];

$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if ($password != $confirm_password) {
die("Error: Passwords do not match");
}
            $hash = password_hash($password, PASSWORD_DEFAULT);

$conn = mysqli_connect('localhost', 'root', 'green ranger', 'grading_system');

$sql = "INSERT INTO `student` (`name`, `rollnumber`, `year`, `department`, `password`, `date`) VALUES ('$name', '$rollnumber', '$year', '$department', '$hash', current_timestamp())";
if (!mysqli_query($conn, $sql)) {
die("Error: " . mysqli_error($conn));
}
echo "student registration successful! your account is created!";
                header("location: loginstudent.php");

mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
<meta charset="UTF-8">
<meta name="viewport" content="width = device-width, initial-scale = 1.0">
    <title>Student Registration Form</title>
    <style>
      /* Add styles to make the form look nice */
      
      input[type="text"], input[type="password"], input[type="number"],select {
        text-decoration: underline;
        width: 150px;
        padding: 5px;
        margin-bottom: 10px;
        border-radius: 5px;
        border: rgba(0, 0, 0, 0.895);
        background-color: lavender;
      }
      input[type="submit"] {
        background-color: #4CAF50;
        color: rgba(0, 0, 0, 0.911) ;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
      }
      input[type="submit"]:hover {
        background-color: #45a049;
      }
      .error {
        color: red;
        margin-bottom: 10px;
      }
    
        body {
          background: #6a11cb;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to right, rgba(106, 7, 203, 1), rgba(37, 117, 252, 1));

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
          background: linear-gradient(to right, rgba(106, 7, 203, 1), rgba(37, 117, 252, 1))
            
            

         }
         .login-box {
  width: 320px;
  height: fit-content;
  background: rgba(0, 0, 0, 0.2);
  color: #805f5f;
  top: 50%;
  left: 50%;
  position: absolute;
  transform: translate(-50%, -50%);
  box-sizing: border-box;
  padding: 70px 30px;
  align-items: center;
  justify-content: center;
}
.login-box a{
  color:black;
}

       
    </style>

  </head>
  <div class="login-box">
  <body>
<a href="index.php">home</a>
<h1><a>Student Registration Form</a></h1>
    <form action="registration.php" method="post">
<label for="name"><a>Name:</a></label>
<input type="text" id="name" name="name" required>
<br>
<label for="rollno"><a>Roll No:</a></label>
<input type="number" id="rollno" name="rollno" required>
<br>
<label for="year"><Year:</label>
<select id="year" name="year">
<option value=""><a>select a year</a></option>
<option value="1">1st Year</option>
<option value="2">2nd Year</option>
<option value="3">3rd Year</option>
<option value="4">4th Year</option>
</select>
<br>
<label for="dept"><a>Department:</a></label>
<select id="dept" name="department">
<option value=""><a>select a department</a></option>
<?php
$conn = mysqli_connect('localhost', 'root', 'green ranger', 'grading_system');

$result = mysqli_query($conn, "SELECT * FROM department");
while ($row = mysqli_fetch_assoc($result)) {
					echo "<option value='".$row['department_name']."'>".$row['department_name']."</option>";
				}
			?>

</select>
<br>
<label for="password">Password:</label>
<input type="password" id="password" name="password" required>
<br>
<label for="confrim_password">confrim_Password:</label>
<input type="password" id="confirm_password" name="confirm_password"required>
<br>
<input type="submit"  onclick="checkpassword()" value="Submit">
</form>
      </div>
<div id="error_msg"></div>
</body>

</html>
<script>    
function checkpassword()  {
var password = document.getElementById("password").value;
var repassword = document.getElementById("confirm_password").value;
if (password != repassword) {
document.getElementById("error_msg").innerHTML = "Passwords do not match";
alert("password do not match");
return false;
}
}

</script>
