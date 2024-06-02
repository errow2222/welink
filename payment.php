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
    <title>Payment Records</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Payment Records</h1>
    <form method="GET" action="">
        <label for="student_id">Student ID:</label>
        <input type="text" id="student_id" name="student_id" required>
        <button type="submit">Search</button>
    </form>

    <?php
    if (isset($_GET['student_id'])) {
        $student_id = $_GET['student_id'];
        $sql = "SELECT * FROM payments WHERE student_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        echo "<table border='1'>";
        echo "<tr><th>Payment Date</th><th>Amount</th><th>Outstanding Balance</th>";
        if ($role == 'admin') echo "<th>Action</th>";
        echo "</tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['payment_date']."</td>";
            echo "<td>".$row['amount']."</td>";
            echo "<td>".$row['outstanding_balance']."</td>";
            if ($role == 'admin') {
                echo "<td><a href='edit_payment.php?id=".$row['id']."'>Edit</a></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        if ($role == 'admin') {
            echo "<button onclick=\"location.href='add_payment.php?student_id=$student_id'\">Add Payment</button>";
        }
    }
    ?>
</body>
</html>