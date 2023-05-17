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

	<title>Faculty Dashboard</title>
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

section h1 {
  font-size: 40px;
  margin-bottom: 20px;
}

section p {
  font-size: 50px;
}

section #upload {
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
form input[type="number"],
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
  background-color:red;
  color: #333;
  padding: 20px;
  border: none;
  border-radius: 5px;
  font-size: 20px;
  cursor: pointer;
  font-weight: bold;

}

#logout:hover {
  background-color: #ccc;
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

  section h1 {
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
		<a href="#" id="home-link">Home</a>
<br>
		<a href="profile.php" id="profile">Profile</a>
<br>
		<a href="#" id="upload-link">Upload Marks</a>
<br>
<a href="view_querries.php" id="view_queries">view queries</a>
<br>
<a href="faculty_logout.php">
<button id="logout" name="logout">logout</button>
</a>

	</nav>
	<section id="home">
	<h1>Faculty Dashboard</h1>

		<p>
<?php
echo "hello  $name";
?>
<br>
welcome to your dashboard.
<br>
you can upload the student marks by clicking on the upload marks link given in the nav bar
<br>
thank you
</p>
	</section>
	<section id="upload">
<h2>upload marks</h2>
<p>
<?php

	$connection = mysqli_connect("localhost", "root", "green ranger", "grading_system");

	if (!$connection) {
		die("Connection failed: " . mysqli_connect_error());
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		$subject = $_POST['subject'];
		$rollnumber = $_POST['roll_number'];
$exam = $_POST['exam'];
		$marks = $_POST['marks'];


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
				$query = "SELECT * FROM student WHERE rollnumber='$rollnumber'";

				$result = mysqli_query($connection, $query);

				while ($row = mysqli_fetch_array($result)) {
$name = $row['name'];
}

		$query = "INSERT INTO marks (subject_id, rollnumber, name, exam_id, marks, email) VALUES ('$subject_id', '$rollnumber', '$name', '$exam_id', '$marks', '$email')";
		if (mysqli_query($connection, $query)) {
			echo "Marks uploaded successfully!";
		} else {
			echo "Error uploading marks: " . mysqli_error($connection);
	}
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		$query = "INSERT INTO pictures (picture_name, rollnumber, exam_id, email, subject_id) VALUES ('$target_file', '$rollnumber', '$exam_id', '$email', '$subject_id')";
				$result = mysqli_query($connection, $query);

// Check if image file is an actual image or fake image
  $check = getimagesize($_FILES["file"]["tmp_name"]);
  if($check !== false) {  // change from 'true' to 'false' to fix the condition
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["file"]["size"] > 5000000) {  // change the file size limit to 500KB (500000 bytes)
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow only certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check for errors
if ($_FILES["file"]["error"] !== UPLOAD_ERR_OK) {  // check if there is no error during file upload
  echo "Sorry, there was an error uploading your file.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
}

	mysqli_close($connection);
?>
</p>
	<form method="post" action="faculty_dashboard.php" enctype="multipart/form-data">
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
<br>
		<label for="roll_number">Select Roll Number:</label>
<br>
		<select id="roll_number" name="roll_number" required>
			<option value="">Select Roll Number</option>
			<?php
				$connection = mysqli_connect("localhost", "root", "green ranger", "grading_system");

				if (!$connection) {
					die("Connection failed: " . mysqli_connect_error());
				}

				$query = "SELECT rollnumber FROM student WHERE department='$department'";

				$result = mysqli_query($connection, $query);

				while ($row = mysqli_fetch_array($result)) {
					echo "<option value='" . $row['rollnumber'] . "'>" . $row['rollnumber'] . "</option>";
				}

				mysqli_close($connection);
			?>
		</select>
<br>
		<label for="exams">Select exam:</label>
<br>
		<select id="exam" name="exam" required>
<option value="">select a exam</option>
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
		<label for="marks">marks:</label>
<br>
		<input type="number" id="marks" name="marks">
<label for="answer_script">Answer Script:</label>
<input type="file" id="file" name="file">
<input type="submit" value="Submit">
</form>
</section>
</body>
</html>

<script>
const homeLink = document.getElementById('home-link');
const marksLink = document.getElementById('upload-link');

const homeSection = document.getElementById('home');
const marksSection = document.getElementById('upload');
window.addEventListener('DOMContentLoaded', () => {
  marksSection.style.display = 'none';
});
homeLink.addEventListener('click', () => {
  homeSection.style.display = 'block';
  marksSection.style.display = 'none';
});

marksLink.addEventListener('click', () => {
  homeSection.style.display = 'none';
  marksSection.style.display = 'block';
});

</script>