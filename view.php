<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>View Order</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="order.css" />
</head>

<body class="main">
  <div class="signup" style="margin: 100px;">
    <center>
      <?php
      include("database.php");

      // ✅ Validate ID
      if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
        $id = intval($_GET['id']);

        $stmt = mysqli_prepare($con, "SELECT * FROM orders WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $date = htmlspecialchars($row['order_date']);
            $email = htmlspecialchars($row['email']);
            $image = htmlspecialchars($row['image']);
            $item = htmlspecialchars($row['item']);
            $cost = htmlspecialchars($row['cost']);
            $quantity = htmlspecialchars($row['quantity']);
            $amount = htmlspecialchars($row['amount']);

            echo "<h1 style='font-size: 50px;'>Order Details (ID: $id)</h1>";

            echo "<table border=1 align='center' style='font-size: 24px; margin-top: 40px;'>";
            echo "<tr><td><strong>Order Date</strong></td><td>$date</td></tr>";
            echo "<tr><td><strong>Email</strong></td><td>$email</td></tr>";
            echo "<tr><td><strong>Item</strong></td><td>$item</td></tr>";
            echo "<tr><td><strong>Price</strong></td><td>₱" . number_format($cost, 2) . "</td></tr>";
            echo "<tr><td><strong>Quantity</strong></td><td>$quantity</td></tr>";
            echo "<tr><td><strong>Total Amount</strong></td><td>₱" . number_format($amount, 2) . "</td></tr>";
            echo "<tr><td><strong>Image</strong></td><td><img src='$image' width='200'></td></tr>";
            echo "</table>";
          }
        } else {
          echo "<p style='font-size: 24px;'>No order found with that ID.</p>";
        }

        mysqli_stmt_close($stmt);
      } else {
        echo "<p style='font-size: 24px;'>Invalid ID specified.</p>";
      }
      ?>

      <br>
      <a href="admin.php" style="text-decoration:none;color:blue; font-size: 24px;">Back</a>
    </center>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
