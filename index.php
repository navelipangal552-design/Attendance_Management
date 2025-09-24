<?php
include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function fetchAttendance() {
            $.ajax({
                url: 'index.php?fetch_data=1', // Fetch updated attendance data
                type: 'GET',
                success: function(response) {
                    $('#attendanceTable tbody').html(response); // Update table body with new data
                }
            });
        }

        $(document).ready(function() {
            fetchAttendance(); // Load data when page loads
            setInterval(fetchAttendance, 10000); // Auto-refresh every 10 seconds
        });
    </script>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center text-primary">📅 Today's Attendance</h2>
        <table id="attendanceTable" class="table table-bordered table-striped mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Check-in Time</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan='3' class='text-center'>Loading...</td></tr>
            </tbody>
        </table>
        <a href="view_attendance.php" class="btn btn-primary">View Student Attendance</a>
    </div>
</body>
</html>

<?php
// Fetch data if requested via AJAX
if (isset($_GET['fetch_data'])) {
    $date = date("Y-m-d");
    $sql = "SELECT a.student_id, s.name, a.check_in_time 
            FROM attendance a 
            JOIN students s ON a.student_id = s.student_id 
            WHERE DATE(a.check_in_time) = '$date'
            ORDER BY a.check_in_time DESC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['student_id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['check_in_time']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='3' class='text-center'>No attendance records found</td></tr>";
    }
    exit; // Stop further execution
}
?>
