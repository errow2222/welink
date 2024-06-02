<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $award = $_POST['award'];
    $date_awarded = $_POST['date_awarded'];

    $sql = "UPDATE records SET award = ?, date_awarded = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $award, $date_awarded, $id);
    $stmt->execute();
    header("Location: records.php?student_id=".$_POST['student_id']);
}

$sql = "SELECT * FROM records WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$record = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Record</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Edit Record</h1>
    <form method="POST" action="">
        <input type="hidden" name="student_id" value="<?php echo $record['student_id']; ?>">
        <label for="award">Award:</label>
        <input type="text" id="award" name="award" value="<?php echo $record['award']; ?>" required>
        <label for="date_awarded">Date Awarded:</label>
        <input type="date" id="date_awarded" name="date_awarded" value="<?php echo $record['date_awarded']; ?>" required>
        <button type="submit">Update</button>
    </form>
</body>
</html>