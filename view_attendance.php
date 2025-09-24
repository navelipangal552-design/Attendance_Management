<?php
include 'db_connection.php';

if (isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];
    $sql = "SELECT a.student_id, s.name, a.check_in_time 
            FROM attendance a 
            JOIN students s ON a.student_id = s.student_id 
            WHERE a.student_id = '$student_id'
            ORDER BY a.check_in_time DESC";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center text-primary">🎓 Student Attendance History</h2>
        <form method="POST" class="mb-3">
            <label for="student_id">Enter Student ID:</label>
            <input type="text" name="student_id" class="form-control" required>
            <button type="submit" class="btn btn-success mt-2">🔍 View Attendance</button>
        </form>

        <?php if (isset($result)) { ?>
            <table class="table table-bordered table-striped mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Check-in Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['student_id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['check_in_time']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php } ?>
        <a href="index.php" class="btn btn-secondary">⬅ Back to Dashboard</a>
    </div>
</body>
</html>
