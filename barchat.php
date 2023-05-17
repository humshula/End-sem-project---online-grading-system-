<?php
$servername = "localhost";
$username = "root";
$password = "green ranger";
$dbname = "grading_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT subject_id, marks FROM marks";
$result = $conn->query($sql);

$subjects = array();
$marks = array();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    array_push($subjects, $row["subject_id"]);
    array_push($marks, $row["marks"]);
  }
} else {
  echo "No data found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Animated Bar Graph</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    canvas {
      -moz-user-select: block;
      -webkit-user-select: block;
      -ms-user-select: block;
    }
  </style>
</head>
<body>
  <canvas id="barChart"></canvas>
  <script>
    const data = {
      labels: <?php echo json_encode($subjects); ?>,
      datasets: [{
        label: 'Student Marks',
        data: <?php echo json_encode($marks); ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.5)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    };

    const config = {
      type: 'bar',
      data: data,
      options: {
        responsive: true,
        plugins: {
          title: {
            display: true,
            text: 'Animated Bar Graph of Student Marks'
          }
        }
      }
    };

    const myChart = new Chart(
      document.getElementById('barChart'),
      config
    );

    function updateChartData(newData) {
      myChart.data.datasets[0].data = newData;
      myChart.update();
    }

    // Animate the bar graph on page load
    $(document).ready(function() {
      const newMarks = [<?php echo implode(",", $marks); ?>];
      let i = 0;
      const interval = setInterval(function() {
        const newData = newMarks.slice(0, i + 1);
        updateChartData(newData);
        i++;
        if (i >= newMarks.length) {
          clearInterval(interval);
        }
      }, 1000);
    });
  </script>
</body>
</html>
