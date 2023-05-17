<?php
error_reporting(0);
	session_start();

	if (!isset($_SESSION['username'])) {
		header("Location: login.php");
		exit();
	}

	$email = $_SESSION['username'];

	$connection = mysqli_connect("localhost", "root", "green ranger", "grading_system");

	if (!$connection) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$query = "SELECT * FROM faculty WHERE email='$email'";

	$result = mysqli_query($connection, $query);

	if (!$result) {
		die("Error: " . mysqli_error($connection));
	}

	$row = mysqli_fetch_array($result);
	$department = $row['department'];
$name = $row['name'];
	mysqli_close($connection);
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width = device-width, initial-scale = 1.0">

	<title>view queries</title>
<style>
/* Styles for the nav bar */
nav {
  background-color: #333;
  overflow: hidden;
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

nav a.active {
  background-color: #4CAF50;
  color: white;
}

/* Styles for the view section */
#view_queries {
  padding: 50px;
font-waight: bold;
font-size: 50px;

}

form {
  display: flex;
  text-align: center;
}

form label {
  display: block;
  margin: 20px 0 10px 0;
  font-size: 40px;
font-waight: bold;
}

form select {
  padding: 5px;
  border-radius: 5px;
  border: 1px solid #ccc;
  font-size: 45px;
  width: 300px;
  margin-bottom: 20px;
}

form input[type="submit"] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 50px;
}

.view_queries {
  margin-top: 50px;
font-waight: bold;
font-size: 50px;

}

.view_queries table {
  border-collapse: collapse;
  width: 100%;
}

.view_queries th, .view_queries td {
  text-align: left;
  padding: 8px;
}

.view_queries th {
  background-color: #4CAF50;
  color: white;
}

.view_queries tr:nth-child(even) {
  background-color: #f2f2f2;
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

</style>

</head>
<body>

	<nav>
		<a href="faculty_dashboard.php" id="home-link">Home</a>
<br>
		<a href="profile.php" id="profile">Profile</a>
<br>
		<a href="faculty_dashboard.php" id="upload-link">Upload Marks</a>
<br>
<a href="view_querries.php" id="view_queries" active>view the queries</a>
<br>
<a href="faculty_logout.php">
<button id="logout" name="logout">logout</button>
</a>

	</nav>
<section id="view_queries">
<h2>view queries</h2>
<p>
<div class="view_queries">
<?php

	$connection = mysqli_connect("localhost", "root", "green ranger", "grading_system");

	if (!$connection) {
		die("Connection failed: " . mysqli_connect_error());
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$subject = $_POST["subject"];
    $query = "SELECT * FROM subjects WHERE subject_name='$subject'";
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $subject_id = $row['subject_id'];
    }
    $query = "SELECT * FROM queries WHERE subject_id='$subject_id'";
    $result = mysqli_query($connection, $query);
    $num = mysqli_num_rows($result);

    if ($num >= 1) {
echo "<table>";
echo "<tr>";
echo "<th>subject name</th>";
echo "<th>exam id/th>";
echo "<th>roll number</th>";
echo "<th>message</th>";
echo "</tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>$subject</td>";
echo "<td>{$row['exam_id']}</td>";
            echo "<td>{$row['rollnumber']}</td>";
if ($row['message'] == "on") {
echo "<td>I'm satisfied with my marks and i have no doubts with my marks</td>";
}
else {
            echo "<td>{$row['message']}</td>";
}
            echo "</tr>";
        }
            echo "</table>";
}
else {
echo "there are no queries found this mite be because you did not post any marks";
}
}
	mysqli_close($connection);
?>
</div>

	<form method="post" action="view_querries.php" enctype="multipart/form-data">
		<label for="subject">Select Subject:</label>
<br>
		<select id="subject" name="subject" required>
			<option value="">Select Subject</option>
			<?php
				$connection = mysqli_connect("localhost", "root", "green ranger", "grading_system");

				if (!$connection) {
					die("Connection failed: " . mysqli_connect_error());
				}

				$query = "SELECT * FROM faculty_subjects WHERE email='$email'";

				$result = mysqli_query($connection, $query);

				while ($row = mysqli_fetch_array($result)) {
									echo "<option value='" . $row['subject1'] . "'>" . $row['subject1'] . "</option>";

					echo "<option value='" . $row['subject2'] . "'>" . $row['subject2'] . "</option>";
					echo "<option value='" . $row['subject3'] . "'>" . $row['subject3'] . "</option>";
					echo "<option value='" . $row['subject4'] . "'>" . $row['subject4'] . "</option>";
					echo "<option value='" . $row['subject5'] . "'>" . $row['subject5'] . "</option>";
}
				mysqli_close($connection);
			?>
		</select>
<input type="submit" name="submit" value="view">
</form>
</p>
</section>
</body>
</html>