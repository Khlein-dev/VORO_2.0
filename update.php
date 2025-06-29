<?php
session_start();
include("database.php");

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid ID");
}

$id = intval($_GET['id']);
$message = "";

// Get current order data
$stmt = mysqli_prepare($con, "SELECT id, order_date, email, item, image, cost, quantity FROM orders WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $orderDate = htmlspecialchars($row['order_date']);
    $email = htmlspecialchars($row['email']);
    $item = htmlspecialchars($row['item']);
    $image = htmlspecialchars($row['image']);  // ✅ include image column
    $cost = htmlspecialchars($row['cost']);
    $quantity = htmlspecialchars($row['quantity']);
} else {
    die("Order not found.");
}
mysqli_stmt_close($stmt);

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $newOrderDate = trim($_POST['order_date']);
    $newCost = floatval($_POST['cost']);
    $newQuantity = intval($_POST['quantity']);
    $newAmount = $newCost * $newQuantity;

    $updateStmt = mysqli_prepare($con, "UPDATE orders SET order_date = ?, cost = ?, quantity = ?, amount = ? WHERE id = ?");
    mysqli_stmt_bind_param($updateStmt, "sdddi", $newOrderDate, $newCost, $newQuantity, $newAmount, $id);

    if (mysqli_stmt_execute($updateStmt)) {
        echo "<script>alert('Order updated successfully!'); window.location.href='admin.php';</script>";
        exit;
    } else {
        $message = "Failed to update: " . mysqli_error($con);
    }
    mysqli_stmt_close($updateStmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="order.css" />
</head>

<body class="main">
    <div class="signup" style="margin: 100px;">
        <center>
            <h1 style="font-size: 75px;">Update Order</h1>

            <?php if (!empty($message)) : ?>
                <script>alert("<?= $message ?>");</script>
            <?php endif; ?>

            <form action="update.php?id=<?= $id ?>" method="POST" class="form-container">
                <div class="form-group">
                    <label for="order_date">Order Date</label>
                    <input type="text" name="order_date" id="order_date" value="<?= $orderDate ?>" required>
                </div>

                <div class="form-group">
                    <label>Email (Read Only)</label>
                    <input type="text" value="<?= $email ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Item (Read Only)</label>
                    <input type="text" value="<?= $item ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Product Image (Read Only)</label><br>
                    <img src="<?= $image ?>" alt="Product Image" style="width: 200px; border: 2px solid #ccc; padding: 5px;">
                </div>

                <div class="form-group">
                    <label for="cost">Cost</label>
                    <input type="number" step="0.01" name="cost" id="cost" value="<?= $cost ?>" required>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" value="<?= $quantity ?>" required>
                </div>

                <input class="btn btn-primary" type="submit" name="update" value="Update Now">
            </form>

            <br>
            <a href="admin.php" class="btn btn-secondary">Back to Admin Page</a>
        </center>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
