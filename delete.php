<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Delete Order</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="order.css" />
</head>
<body class="main">
  <div class="signup" style="margin: 100px;">
    <center>
      <?php
        include("database.php");

        // ✅ Validate ID
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
          echo "<script>alert('Invalid ID.'); window.location.href='admin.php';</script>";
          exit;
        }

        $id = intval($_GET['id']);

        // ✅ Prepare & execute
        $stmt = mysqli_prepare($con, "DELETE FROM orders WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
          echo "<script>alert('Order deleted successfully!'); window.location.href='admin.php';</script>";
        } else {
          echo "<script>alert('Error deleting order.'); window.location.href='admin.php';</script>";
        }

        mysqli_stmt_close($stmt);
      ?>
    </center>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
