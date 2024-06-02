<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

$student_id = $_GET['student_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];
    $outstanding_balance = $_POST['outstanding_balance'];

    $sql = "INSERT INTO payments (student_id, amount, payment_date, outstanding_balance) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idss", $student_id, $amount, $payment_date, $outstanding_balance);
    $stmt->execute();
    header("Location: payments.php?student_id=$student_id");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Payment</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Add Payment</h1>
    <form method="POST" action="">
        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
        <label for="amount">Amount:</label>
        <input type="number" step="0.01" id="amount" name="amount" required>
        <label for="payment_date">Payment Date:</label>
        <input type="date" id="payment_date" name="payment_date" required>
        <label for="outstanding_balance">Outstanding Balance:</label>
        <input type="number" step="0.01" id="outstanding_balance" name="outstanding_balance" required>
        <button type="submit">Add</button>
    </form>
</body>
</html>
