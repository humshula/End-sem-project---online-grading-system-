<?php
error_reporting(0);
	session_start();

	if (!isset($_SESSION['username'])) {
		header("Location: login.php");
		exit();
	}

	$rollnumber = $_SESSION['username'];

	$connection = mysqli_connect("localhost", "root", "green ranger", "grading_system");

	if (!$connection) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$query = "SELECT * FROM student WHERE rollnumber='$rollnumber'";

	$result = mysqli_query($connection, $query);

	if (!$result) {
		die("Error: " . mysqli_error($connection));
	}

	$row = mysqli_fetch_array($result);
	$department = $row['department'];
$name = $row['name'];
$year = $row['year'];

	mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<title>
queries
</title>
<style>
/* Body styles */
body {
  font-family: Arial, sans-serif;
  font-size: 90px;
  line-height: 1.5;
  margin: 0;
  padding: 0;
}

/* Navigation styles */
nav {
  background-color: #333;
  overflow: hidden;
display :flex;
}

nav a {
  float: left;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 40px;
}

nav a:hover {
  background-color: #ddd;
  color: green;
}

/* Section styles */
section {
  margin: 50px;
  font-weight: bold;
  display: block;

}

section h2 {
  font-size: 40px;
  margin-bottom: 20px;
}

section p {
  font-size: 50px;
}

section #queries {
  display: block;
}

/* Form styles */
form {
  display: flex;
  flex-direction: column;
}

form label {
  font-weight: bold;
font-size: 35px;
}

form input[type="text"],
form input[type="checkbox"],
form select {
  margin-bottom: 10px;
  padding: 5px;
  border-radius: 5px;
  border: 1px solid #ccc;
  font-size: 40px;
}

form input[type="submit"] {
  background-color: #333;
  color: #fff;
  padding: 10px;
  border: none;
  border-radius: 5px;
  font-size: 45px;
  cursor: pointer;
}

form input[type="submit"]:hover {
  background-color: #555;
}

/* Logout button styles */
#logout {
  background-color: red;
  color: #333;
  padding: 5px;
  border: none;
  border-radius: 5px;
  font-size: 20px;
  cursor: pointer;
  font-weight: bold;

}

#logout:hover {
  background-color: #ccc;
}

a {
  color: #fff;
  text-decoration: none;
  padding: 10px;
  border-radius: 5px;
}

a:hover {
  background-color: #555;
}

/* Responsive styles */
@media (max-width: 2000px) {
  nav {
    flex-direction: row;
    height: auto;
  }

  nav a {
    margin: 5px;
  }

  section {
    margin: 20px;
  }

  section h2 {
    font-size: 30px;
    margin-bottom: 10px;
  }

  section p {
    font-size: 40px;
  }
}
</style>

</head>
<body>
<nav>
<a href="student_dashboard.php">home</a>
<br>
<a href="query.php" active>enter your queries for marks</a>
<br>
<a href="student_logout.php">
<button id="logout" name="logout">logout</button>
</a>
</nav>
<section id="queries">
<h2>queries</h2>

<p>
post your query if you have any doubts for the marks that you obtained
</p>
<p>
<?php
	$connection = mysqli_connect("localhost", "root", "green ranger", "grading_system");

	if (!$connection) {
		die("Connection failed: " . mysqli_connect_error());
	}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$subject = $_POST["subject"];
$exam = $_POST["exam"];
    $query = "SELECT * FROM subjects WHERE subject_name='$subject'";
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $subject_id = $row['subject_id'];
    }

    $query = "SELECT exam_id FROM exams WHERE exam_name='$exam'";
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $exam_id = $row['exam_id'];
    }

    if (isset($_POST["message1"]) && !empty($_POST["message1"])) {
        $message = $_POST["message1"];

    $query = "SELECT * FROM marks WHERE subject_id='$subject_id' AND rollnumber='$rollnumber' AND exam_id='$exam_id'";
    $result = mysqli_query($connection, $query);

    $num = mysqli_num_rows($result);

    if ($num == 1) {
    $query = "SELECT * FROM queries WHERE message = '$message' and exam_id = '$exam_id' and rollnumber = '$rollnumber' and subject_id='$subject_id'";
    $result = mysqli_query($connection, $query);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
echo "you have alredy posted for the given exam and subject!";
}
else {
    $query = "insert into  `queries` (`message`, `exam_id`, `rollnumber`, `subject_id`) values ('$message', '$exam_id', '$rollnumber', '$subject_id')";
    $result = mysqli_query($connection, $query);
if($result) {
echo "marks accepted and finalised!";
}
}
}
else {
echo "error the marks of the selected subject and exam are not released!";
echo "please try after some days!";
}
    }
    else if (isset($_POST["message2"]) && !empty($_POST["message2"])) {
        $message = $_POST["message2"];
    $query = "SELECT * FROM marks WHERE subject_id='$subject_id' AND rollnumber='$rollnumber' AND exam_id='$exam_id'";
    $result = mysqli_query($connection, $query);

    $num = mysqli_num_rows($result);

    if ($num == 1) {
    $query = "insert into  queries  (`message`, `exam_id`, `rollnumber`, `subject_id`) values ('$message', '$exam_id', '$rollnumber', '$subject_id')";
    $result = mysqli_query($connection, $query);
if($result) {
echo "query recieved with the selected exam and subject!";
}
}
else {
echo "error the marks of the selected subject and exam are not released!";
echo "please try after some days!";
}
    }
    else {
        echo "error!";
    }
}
	mysqli_close($connection);

?>

	<form id="query_form" method="post" action="query.php" enctype="multipart/form-data">
		<label for="subject">Select Subject:</label>
<br>
		<select id="subject" name="subject" required>
			<option value="">Select Subject</option>
			<?php
				$connection = mysqli_connect("localhost", "root", "green ranger", "grading_system");

				if (!$connection) {
					die("Connection failed: " . mysqli_connect_error());
				}
if($year == 1) {
				$query = "SELECT * FROM subjects WHERE year='$year'";

				$result = mysqli_query($connection, $query);

				while ($row = mysqli_fetch_array($result)) {
									echo "<option value='" . $row['subject_name'] . "'>" . $row['subject_name'] . "</option>";
}
}
else {
				$query = "SELECT * FROM subjects WHERE year='$year' and department='$department'";

				$result = mysqli_query($connection, $query);

				while ($row = mysqli_fetch_array($result)) {
									echo "<option value='" . $row['subject_name'] . "'>" . $row['subject_name'] . "</option>";
}
}

				mysqli_close($connection);
			?>
		</select>
<br>
		<label for="exams">Select exam:</label>
<br>
		<select id="exam" name="exam" required>
			<option value="">Select exam</option>
			<?php
				$connection = mysqli_connect("localhost", "root", "green ranger", "grading_system");

				if (!$connection) {
					die("Connection failed: " . mysqli_connect_error());
				}

				$query = "SELECT * FROM exams";

				$result = mysqli_query($connection, $query);

				while ($row = mysqli_fetch_array($result)) {
					echo "<option value='" . $row['exam_name'] . "'>" . $row['exam_name'] . "</option>";
				}

				mysqli_close($connection);
			?>
		</select>
<br>
<label>
<input type="checkbox" name="message1" id="message1">

I'm satisfied with my marks and i have no doubts with my marks
</label>


<br>
<p>
please enter your query hear:</p>
<input type="text" id="message2" name="message2">
<br>
<input type="submit" value="submit">
</form>
</p>
</section>
<hr>
<a href=""student_dashboard.php">click hear to go back to home</a>
</body>
</html>
