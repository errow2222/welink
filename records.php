<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Records</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Student Records</h1>
    <form method="GET" action="">
        <label for="student_id">Student ID:</label>
        <input type="text" id="student_id" name="student_id" required>
        <button type="submit">Search</button>
    </form>

    <?php
    if (isset($_GET['student_id'])) {
        $student_id = $_GET['student_id'];
        $sql = "SELECT * FROM records WHERE student_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        echo "<table border='1'>";
        echo "<tr><th>Date Awarded</th><th>Award</th>";
        if ($role == 'admin') echo "<th>Action</th>";
        echo "</tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['date_awarded']."</td>";
            echo "<td>".$row['award']."</td>";
            if ($role == 'admin') {
                echo "<td><a href='edit_record.php?id=".$row['id']."'>Edit</a></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        if ($role == 'admin') {
            echo "<button onclick=\"location.href='add_record.php?student_id=$student_id'\">Add Record</button>";
        }
    }
    ?>
</body>
</html>