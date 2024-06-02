<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit();
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];
    $outstanding_balance = $_POST['outstanding_balance'];

    $sql = "UPDATE payments SET amount = ?, payment_date = ?, outstanding_balance = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dsdi", $amount, $payment_date, $outstanding_balance, $id);
    $stmt->execute();
    header("Location: payments.php?student_id=".$_POST['student_id']);
}

$sql = "SELECT * FROM payments WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$payment = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Payment</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Edit Payment</h1>
    <form method="POST" action="">
        <input type="hidden" name="student_id" value="<?php echo $payment['student_id']; ?>">
        <label for="amount">Amount:</label>
        <input type="number" step="0.01" id="amount" name="amount" value="<?php echo $payment['amount']; ?>" required>
        <label for="payment_date">Payment Date:</label>
        <input type="date" id="payment_date" name="payment_date" value="<?php echo $payment['payment_date']; ?>" required>
        <label for="outstanding_balance">Outstanding Balance:</label>
        <input type="number" step="0.01" id="outstanding_balance" name="outstanding_balance" value="<?php echo $payment['outstanding_balance']; ?>" required>
        <button type="submit">Update</button>
    </form>
</body>
</html>
