<?php
$login = false;
$showError = false;
$name;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'db.php';
    $email = $_POST["email"];
    $password = $_POST["password"];
  if (isset($_POST['remember_me'])) {
    setcookie('username', $email, time() + (86400 * 30), "/");
    setcookie('password', $password, time() + (86400 * 30), "/");
  }
    $sql = "Select * from faculty where email='$email'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1){
        while($row=mysqli_fetch_assoc($result)){
$name = $row['name'];
            if (password_verify($password, $row['password'])){
                $login = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $email;
                header("location: faculty_dashboard.php");
            } 
            else{
                $showError = "Invalid Credentials";
            }
        }
        
    } 
    else{
        $showError = "Invalid Credentials";
    }
}
    
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Login Page</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color:lavenderblush;
        justify-content: center;
        align-items: center;
      }

      #login-form {
        width: 300px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px 0px 10px #888888;
        
      }

      h1 {
        text-align: center;
      }

      label {
        display: block;
        margin-bottom: 10px;
      }

      input[type="text"],
      input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 20px;
      }

      input[type="submit"] {
        background-color: #af4c96;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
      }

      input[type="submit"]:hover {
        background-color: #a0458b;
      }

      .error {
        color: red;
        font-size: 0.8em;
        margin-top: 5px;
      }
    </style>
  </head>
  <body>
    <div id="login-form">
      <h1>faculty login</h1>
<p>
login for faculty
    <?php
    if($login){
    echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> You are logged in
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
    }
    if($showError){
    echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> '. $showError.'
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
    }
    ?>

      <form action="loginfaculty.php" method="post">
        <label for="username">email-id</label>
        <input type="email" id="email" name="email" placeholder="enter your email-id" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="enter your password" required>
<label>

        <input type="checkbox" name="remember_me" id="remember_me"> Remember me
</label>
<a href="index.php">
      <button type="button" class="cancelbtn"> Cancel</button> <br>
</a>
<br>
      <a href="forgot.php"> Forgot password? </a> 

        <input type="submit" value="Login">
      </form>
    </div>
  </body>
</html>
