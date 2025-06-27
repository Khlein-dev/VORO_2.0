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
    $i = isset($_GET['item']) ? $_GET['item'] : '';
    $c = isset($_GET['cost']) ? floatval($_GET['cost']) : 0;
    $q = isset($_GET['qty']) ? intval($_GET['qty']) : 1;
    $image = isset($_GET['image']) ? $_GET['image'] : '';
    $sum = $c * $q;

    
    $safe_image = htmlspecialchars($image);
    $safe_item = htmlspecialchars($i);
} else {
    exit("Terminated <a href='login.php' class='btn' style='width: 200px; padding: 5px;'> Log In </a>");
}
?>

<div class="container text-white" style="border: 4px solid antiquewhite; border-radius: 15px; margin-top: 120px; background-color: black; padding: 8px;">
    <div class="row">
        <div class="col">
            <img src="<?= $safe_image ?>" width="600" height="400" alt="Purchased Item Image">
        </div>
        <div class="col" style="text-align: left;">
            <img src="order/check-mark.png" width="60px" style="margin-left: 350px; position:absolute;">
            <h4>Congratulations! You have purchased</h4>
            <h1><?= $safe_item ?></h1>
            <hr style="height: 3px; border: none; background: antiquewhite;" />
            <h4>Quantity: <?= $q ?></h4>
            <h4>Total: ₱<?= number_format($sum, 2) ?></h4>
            <p>Kindly have the payment ready upon delivery.</p>
            <button onclick="window.location.href='order.php'" style="margin-left: 400px; padding:10px;">Back</button>

            <?php
            $order_date = date("Y-m-d");

            
            $update = "UPDATE orders SET order_date = ?, item = ?, cost = ?, quantity = ?, amount = ? WHERE email = ?";
            $stmt = mysqli_prepare($con, $update);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssddds", $order_date, $i, $c, $q, $sum, $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            } else {
                echo "<p style='color: red;'>Database error: Unable to update order.</p>";
            }
            ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
