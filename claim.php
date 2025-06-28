<?php
ob_start();
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VORO - Purchased</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="order.css" />
</head>

<body style="background-image: url('order/or.jpg'); background-size: cover;">

<?php
if (!empty($_SESSION['email'])) {
    include("database.php");

    $email = $_SESSION['email'];

    // Sanitize and validate input
    $i = isset($_GET['item']) ? htmlspecialchars($_GET['item']) : '';
    $c = isset($_GET['cost']) ? floatval($_GET['cost']) : 0;
    $q = isset($_GET['qty']) ? intval($_GET['qty']) : 1;
    $image = isset($_GET['image']) ? htmlspecialchars($_GET['image']) : '';
    $sum = $c * $q;

    $order_date = date("Y-m-d");

    // Insert a new order with image
    $insert = "INSERT INTO orders (email, image, order_date, item, cost, quantity, amount) 
               VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $insert);
    if ($stmt) {
        // 'ssssddd' means: 4 strings, 3 numbers
        mysqli_stmt_bind_param($stmt, "ssssddd", $email, $image, $order_date, $i, $c, $q, $sum);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "<p style='color: red;'>Database error: Unable to insert order.</p>";
    }
} else {
    exit("Terminated <a href='login.php' class='btn' style='width: 200px; padding: 5px;'> Log In </a>");
}
?>

<div class="container text-white" style="border: 4px solid antiquewhite; border-radius: 15px; margin-top: 120px; background-color: black; padding: 8px;">
    <div class="row">
        <div class="col">
            <img src="<?= $image ?>" width="600" height="400" alt="Purchased Item Image">
        </div>
        <div class="col" style="text-align: left;">
            <img src="order/check-mark.png" width="60px" style="margin-left: 350px; position:absolute;">
            <h4>Congratulations! You have purchased</h4>
            <h1><?= $i ?></h1>
            <hr style="height: 3px; border: none; background: antiquewhite;" />
            <h4>Quantity: <?= $q ?></h4>
            <h4>Total: ₱<?= number_format($sum, 2) ?></h4>
            <p>Kindly have the payment ready upon delivery.</p>
            <button onclick="window.location.href='order.php'" style="margin-left: 400px; padding:10px;">Back</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
