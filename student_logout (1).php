<?php
session_start();

session_unset();
session_destroy();

header("location: loginstudent.php");
exit;
?>