<?php
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

	$query = "SELECT department FROM faculty WHERE email='$email'";

	$result = mysqli_query($connection, $query);

	if (!$result) {
		die("Error: " . mysqli_error($connection));
	}

	$row = mysqli_fetch_array($result);
	$department = $row['department'];

	mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width = device-width, initial-scale = 1.0">
<title>
faculty profile
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

section #profile {
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

form select {
  margin-bottom: 10px;
  padding: 5px;
  border-radius: 5px;
  border: 1px solid #ccc;
  font-size: 40px;
}

button {
  background-color: #333;
  color: #fff;
  padding: 10px;
  border: none;
  border-radius: 5px;
  font-size: 45px;
  cursor: pointer;
}

button:hover {
  background-color: #555;
}

.details {
  margin-top: 50px;
font-waight: bold;
font-size: 50px;

}

.detailss table {
  border-collapse: collapse;
  width: 100%;
}

.details th, .details td {
  text-align: left;
  padding: 8px;
}

.details th {
  background-color: #4CAF50;
  color: white;
}


.details tr:nth-child(even) {
  background-color: #f2f2f2;
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
<a href="faculty_dashboard.php">home</a>
<br>
<a href="profile.php" active>profile</a>
<br>
<a href="faculty_dashboard.php">upload marks</a>
</nav>
	<section id="profile">
<h2>your profile</h2>
<div class="details">
<h3>your details</h3>
<p>
<?php
	$connection = mysqli_connect("localhost", "root", "green ranger", "grading_system");

	if (!$connection) {
		die("Connection failed: " . mysqli_connect_error());
	}

$query = "select * from faculty where email = '$email'";
    $result = mysqli_query($connection, $query);

    $num = mysqli_num_rows($result);

    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<table>";
            echo "<tr>";
            echo "<th>name</th>";
            echo "<th>email</th>";
            echo "<th>department</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>{$row['name']}</td>";
            echo "<td>$email</td>";
            echo "<td>$row[department]</td>";
            echo "</tr>";
            echo "</table>";
        }
}
	mysqli_close($connection);
?>
</p>

<h3>your subjects</h3>
<p>
<?php
	$connection = mysqli_connect("localhost", "root", "green ranger", "grading_system");

	if (!$connection) {
		die("Connection failed: " . mysqli_connect_error());
	}

$query = "select * from faculty_subjects where email = '$email'";
    $result = mysqli_query($connection, $query);

    $num = mysqli_num_rows($result);

    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<table>";
            echo "<tr>";
            echo "<th>subject1</th>";
            echo "<th>subject2</th>";
            echo "<th>subject3</th>";
echo "<th>subject4</th>";
echo "<th>subject5</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>{$row['subject1']}</td>";
if($row['subject2']) {
            echo "<td>{$row['subject2']}</td>";
}
else {
echo "<td> </td>";
}
if($row['subject3']) {
            echo "<td>{$row['subject3']}</td>";
}
else {
echo "<td> </td>";
}
if($row['subject4']) {
            echo "<td>{$row['subject4']}</td>";
}
else {
echo "<td> </td>";
}
if($row['subject5']) {
            echo "<td>{$row['subject5']}</td>";
}
else {
echo "<td> </td>";
}

            echo "</tr>";
            echo "</table>";
        }
}
else {
echo "you have not saved your teaching subjects! please complete your profile!";
}
	mysqli_close($connection);
?>
</p>
</div>

<p>
please select the subjects  that you teach.
<br>
compleate your profile
ignore this if you have alredy completed the profile!
</p>
<p>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
$subject1 = $_POST['subject1'];
$subject2 = $_POST['subject2'];
$subject3 = $_POST['subject3'];
$subject4 = $_POST['subject4'];
$subject5 = $_POST['subject5'];

$conn = mysqli_connect('localhost', 'root', 'green ranger', 'grading_system');
$sql = "INSERT INTO `faculty_subjects` (`subject1`, `subject2`, `subject3`, `subject4`, `subject5`, `email`) VALUES ('$subject1', '$subject2', '$subject3', '$subject4', '$subject5', '$email')";
if (!mysqli_query($conn, $sql)) {
die("Error: " . mysqli_error($conn));
}

echo "subject saving successful!";

mysqli_close($conn);
}
?>

		<form action="profile.php" method="post">
			<label for="subject1">Subject 1:</label>
			<select name="subject1" id="subject1" required>
			<option value="">Select Subject</option>
			<?php
				$connection = mysqli_connect("localhost", "root", "green ranger", "grading_system");

				if (!$connection) {
					die("Connection failed: " . mysqli_connect_error());
				}

				$query = "SELECT subject_name FROM subjects WHERE department='$department'";

				$result = mysqli_query($connection, $query);

				while ($row = mysqli_fetch_array($result)) {
					echo "<option value='" . $row['subject_name'] . "'>" . $row['subject_name'] . "</option>";
				}

				mysqli_close($connection);
			?>

</select>
<br>
			<label for="subject2">Subject 2:</label>
			<select name="subject2" id="subject2">
			<option value="">Select Subject</option>
			<?php
				$connection = mysqli_connect("localhost", "root", "green ranger", "grading_system");

				if (!$connection) {
					die("Connection failed: " . mysqli_connect_error());
				}
				$query = "SELECT subject_name FROM subjects WHERE department='$department'";

				$result = mysqli_query($connection, $query);

				while ($row = mysqli_fetch_array($result)) {
					echo "<option value='" . $row['subject_name'] . "'>" . $row['subject_name'] . "</option>";
				}

				mysqli_close($connection);
			?>
</select>
<br>
			<label for="subject3">Subject 3:</label>
			<select name="subject3" id="subject3">
			<option value="">Select Subject</option>
			<?php
				$connection = mysqli_connect("localhost", "root", "green ranger", "grading_system");

				if (!$connection) {
					die("Connection failed: " . mysqli_connect_error());
				}

				$query = "SELECT subject_name FROM subjects WHERE department='$department'";

				$result = mysqli_query($connection, $query);

				while ($row = mysqli_fetch_array($result)) {
					echo "<option value='" . $row['subject_name'] . "'>" . $row['subject_name'] . "</option>";
				}

				mysqli_close($connection);
			?>
</select>
<br>
			<label for="subject4">Subject 4:</label>
			<select name="subject4" id="subject4">
			<option value="">Select Subject</option>
			<?php
				$connection = mysqli_connect("localhost", "root", "green ranger", "grading_system");

				if (!$connection) {
					die("Connection failed: " . mysqli_connect_error());
				}

				$query = "SELECT subject_name FROM subjects WHERE department='$department'";

				$result = mysqli_query($connection, $query);

				while ($row = mysqli_fetch_array($result)) {
					echo "<option value='" . $row['subject_name'] . "'>" . $row['subject_name'] . "</option>";
				}

				mysqli_close($connection);
			?>
</select>
<br>
			<label for="subject5">Subject 5:</label>
			<select name="subject5" id="subject5">
			<option value="">Select Subject</option>
			<?php
				$connection = mysqli_connect("localhost", "root", "green ranger", "grading_system");

				if (!$connection) {
					die("Connection failed: " . mysqli_connect_error());
				}

				$query = "SELECT subject_name FROM subjects WHERE department='$department'";

				$result = mysqli_query($connection, $query);

				while ($row = mysqli_fetch_array($result)) {
					echo "<option value='" . $row['subject_name'] . "'>" . $row['subject_name'] . "</option>";
				}

				mysqli_close($connection);
			?>
</select>
<br>
			<button>Save</button>
		</form>
	</section>
</body>
</html>