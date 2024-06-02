<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Dashboard</h1>
    <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
    <div>
        <button onclick="location.href='attendance.php'">Student Attendance</button>
        <button onclick="location.href='records.php'">Student Records</button>
        <button onclick="location.href='payments.php'">Payment Records</button>
    </div>
</body>
</html>