<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gradings</title>
    <style>
		body{
			background-image: url("image1.jpg");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
		}
.navbar {
	display: flex;
	flex-direction: row;
	align-items: center;
	justify-content: space-between;
	background-color: #333;
	color: #fff;
	padding: 10px;
}

.logo a {
	color: #fff;
	font-size: 24px;
	font-weight: bold;
	text-decoration: none;
}

.navlinks a {
	color: #fff;
	font-size: 18px;
	text-decoration: none;
	margin-left: 20px;
}

.dropdown {
	position: relative;
	display: inline-block;
}

.dropbtn {
	background-color: #333;
	color: #fff;
	font-size: 18px;
	border: none;
	cursor: pointer;
}

.dropdown-content {
	display: none;
	position: absolute;
	background-color: #f9f9f9;
	z-index: 1;
	min-width: 160px;
	box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
}

.dropdown-content a {
	color: #333;
	padding: 12px 16px;
	text-decoration: none;
	display: block;
}

.dropdown-content a:hover {
	background-color: #f1f1f1;
}

.dropdown:hover .dropdown-content {
	display: block;
}



.content {
	margin-top: 50px;
	padding: 20px;
}

    </style>
    
</head>
<body>
	<div class="navbar">
		<div class="logo">
			<a href="#">Grading Website</a>
		</div>
		<div class="navlinks">
			<a href="#">Home</a>
			<a href="about.html">About</a>
			<div class="dropdown">
					<a href="faculty.php">faculty register</a>
<a href="loginfaculty.php">
				<button class="dropbtn">faculty portal</button>
</a>
				<div class="dropdown-content">
					
				</div>
			</div>
			<div class="dropdown">
					<a href="registration.php">student register</a>
<a href="loginstudent.php">
				<button class="dropbtn">student portal</button>
</a>
				<div class="dropdown-content">
					
				</div>
			</div>
		</div>
		
	</div>
	<div class="content">
		<h1>Welcome to gradings website!</h1>
		<p>This is the website that will unable students to view marks and faculty to upload marks of students .</p>
	</div>
</body>
</html>

