<?php
$server = "localhost";
$username = "root";
$password = "green ranger";
$database = "grading_system";

$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn){
//     echo "success";
// }
// else{
    die("Error". mysqli_connect_error());
}

?>