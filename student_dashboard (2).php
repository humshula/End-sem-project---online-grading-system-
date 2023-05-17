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
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width = device-width, initial-scale = 1.0">
	<title>student dashboard</title>
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

/* Styles for the home section */
#home {
  padding: 50px;
  text-align: center;
font-waight: bold;
font-size: 50px;
}

/* Styles for the view section */
#view {
  padding: 50px;
font-waight: bold;
font-size: 50px;

}

#marks_form {
  display: flex;
  text-align: center;
}

#marks_form label {
  display: block;
  margin: 20px 0 10px 0;
  font-size: 40px;
font-waight: bold;
}

#marks_form select {
  padding: 5px;
  border-radius: 5px;
  border: 1px solid #ccc;
  font-size: 45px;
  width: 300px;
  margin-bottom: 20px;
}

#marks_form input[type="submit"] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 50px;
}

.view_marks {
  margin-top: 50px;
font-waight: bold;
font-size: 50px;

}

.view_marks table {
  border-collapse: collapse;
  width: 100%;
}

.view_marks th, .view_marks td {
  text-align: left;
  padding: 8px;
}

.view_marks th {
  background-color: #4CAF50;
  color: white;
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


.view_marks tr:nth-child(even) {
  background-color: #f2f2f2;
}
</style>
</head>
<body>
	<nav>
		<a href="#" id="home-link">Home</a>
<br>
		<a href="#" id="marks-link">view Marks</a>
<br>
<a href="barchat.php">pictorial representationn of marks</a>
<br>
<a href="query.php">post a query here for your marks</a>
<br>
<a href="student_logout.php">
<button id="logout" name="logout">logout</button>
</a>

	</nav>
	<section id="home">
	<h1>student Dashboard</h1>

		<p>
<?php
echo "hello $name";
?>
<br>
welcome to your dashboard.
<br>
you can view the student marks by clicking on the view marks link given in the nav bar
<br>
thank you
</p>
	</section>
	<section id="view">
<h2>view marks</h2>
<p>
please select the type of exam and subject.
</p>
	<form id="marks_form" method="post" action="student_dashboard.php" enctype="multipart/form-data">
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
<input type="submit" value="view">
</form>
<div class="view_marks" id="view_marks">
<?php
$connection = mysqli_connect("localhost", "root", "green ranger", "grading_system");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = mysqli_real_escape_string($connection, $_POST['subject']);
    $exam = mysqli_real_escape_string($connection, $_POST['exam']);

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

    $query = "SELECT * FROM marks WHERE subject_id='$subject_id' AND rollnumber='$rollnumber' AND exam_id='$exam_id'";
    $result = mysqli_query($connection, $query);

    $num = mysqli_num_rows($result);

    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<table>";
            echo "<tr>";
            echo "<th>subject name</th>";
            echo "<th>exam name</th>";
            echo "<th>name</th>";
            echo "<th>roll number</th>";
            echo "<th>marks</th>";
echo "<th>grade</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<td>$subject</td>";
            echo "<td>$exam</td>";
            echo "<td>$row[name]</td>";
            echo "<td>{$row['rollnumber']}</td>";
            echo "<td>{$row['marks']}</td>";
if($exam_id == 1 || $exam_id == 3) {
if($row['marks'] >= 3 && $row['marks'] < 4) {
echo "<td>p</td>";
}
else if($row['marks'] >= 4 && $row['marks'] < 5) {
echo "<td>d</td>";
}
else if($row['marks'] >= 5 && $row['marks'] < 6) {
echo "<td>c</td>";
}
else if($row['marks'] >= 6 && $row['marks'] < 7) {
echo "<td>b</td>";
}
else if($row['marks'] >= 7 && $row['marks'] < 8) {
echo "<td>a</td>";
}
else if($row['marks'] >= 8 && $row['marks'] <= 10) {
echo "<td>ex</td>";
}
else {
echo "<td>f</td>";
}
}
else if($exam_id == 2) {
if($row['marks'] >= 10 && $row['marks'] < 13) {
echo "<td>p</td>";
}
else if($row['marks'] >= 13 && $row['marks'] < 15) {
echo "<td>d</td>";
}
else if($row['marks'] >= 15 && $row['marks'] < 18) {
echo "<td>c</td>";
}
else if($row['marks'] >= 18 && $row['marks'] < 21) {
echo "<td>b</td>";
}
else if($row['marks'] >= 21 && $row['marks'] < 24) {
echo "<td>a</td>";
}
else if($row['marks'] >= 24 && $row['marks'] <= 30) {
echo "<td>ex</td>";
}
else {
echo "<td>f</td>";
}
}
else if($exam_id == 4) {
if($row['marks'] >= 17 && $row['marks'] < 20) {
echo "<td>p</td>";
}
else if($row['marks'] >= 20 && $row['marks'] < 25) {
echo "<td>d</td>";
}
else if($row['marks'] >= 25 && $row['marks'] < 30) {
echo "<td>c</td>";
}
else if($row['marks'] >= 30 && $row['marks'] < 35) {
echo "<td>b</td>";
}
else if($row['marks'] >= 35 && $row['marks'] < 40) {
echo "<td>a</td>";
}
else if($row['marks'] >= 40 && $row['marks'] <= 50) {
echo "<td>ex</td>";
}
else {
echo "<td>f</td>";
}
}
            echo "</tr>";
            echo "</table>";
        }
echo "<div>";
    $query = "SELECT picture_name FROM pictures WHERE rollnumber='$rollnumber' AND exam_id='$exam_id' and subject_id='$subject_id'";
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
$filename = $row['picture_name'];
}
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES[$filename]["name"]);

if (file_exists($target_file)) {
    echo '<img src="$target_file" alt="answer  script" id="answer_script">';
echo '<div id="image">';
echo '<img src="" id="modal-image">';

echo "</div>";

} else {
    echo "No image file specified!";
}
echo "</div>";

    } else {
        echo "Sorry, no marks are updated for the selected exam and subject! <br>";
        echo "This might be because the exam is not complete or that particular subject exam marks are not released!<br>";
        echo "Please try after some time!";
    }

}

mysqli_close($connection);
?>
</div>
</section>

</body>
</html>
<script>
const homeLink = document.getElementById('home-link');
const marksLink = document.getElementById('marks-link');
const queryLink = document.getElementById('query-link');

const homeSection = document.getElementById('home');
const marksSection = document.getElementById('view');
const querySection = document.getElementById('query');
window.addEventListener('DOMContentLoaded', () => {
  // Hide the marks and query sections
  marksSection.style.display = 'none';
  querySection.style.display = 'none';
});
homeLink.addEventListener('click', () => {
  homeSection.style.display = 'block';
  marksSection.style.display = 'none';
  querySection.style.display = 'none';
});

marksLink.addEventListener('click', () => {
  homeSection.style.display = 'none';
  marksSection.style.display = 'block';
  querySection.style.display = 'none';
});

queryLink.addEventListener('click', () => {
  homeSection.style.display = 'none';
  marksSection.style.display = 'none';
  querySection.style.display = 'block';
});
const thumbnail = document.getElementById('answer_script');
const modal = document.getElementById('image');
const modalImg = document.getElementById('modal-image');

// When the user clicks on the thumbnail, open the modal and display the full-size image
thumbnail.addEventListener('click', () => {
  modal.style.display = 'block';
  modalImg.src = '<?php echo $target_file; ?>'; // set the source of the image to the image data retrieved from the database
});
</script>