<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

$student_id = $_GET['student_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $award = $_POST['award'];
    $date_awarded = $_POST['date_awarded'];

    $sql = "INSERT INTO records (student_id, award, date_awarded) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $student_id, $award, $date_awarded);
    $stmt->execute();
    header("Location: records.php?student_id=$student_id");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Record</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Add Record</h1>
    <form method="POST" action="">
        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
        <label for="award">Award:</label>
        <input type="text" id="award" name="award" required>
        <label for="date_awarded">Date Awarded:</label>
        <input type="date" id="date_awarded" name="date_awarded" required>
        <button type="submit">Add</button>
    </form>
</body>
</html>