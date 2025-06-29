<?php
ob_start();
session_start();


if (isset($_GET['action']) && $_GET['action'] === 'logout') {
  session_destroy();
  print "<script>window.location.href='index.php';</script>";
  exit;
}


if (isset($_GET['action']) && $_GET['action'] === 'back') {
  session_destroy();
  print "<script>window.location.href='index.php';</script>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>VORO - My Orders</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="order.css" />
</head>

<script>
  window.addEventListener("pageshow", function(event) {
    if (event.persisted) {
      location.reload();
    }
  });
</script>

<body class="page2">

  <img src="order/main.jpg" class="poster">

  <h1 style="font-size: 150px; margin-top: -250px; margin-left: 30px;">VORO</h1>
  <p style="margin-top: -15px; margin-left: 50px; word-spacing: 15px; font-size: 25px;">
    Order fast. Move faster.
  </p>

  <div class="text-center">
    <div class="row">
      <div class="col-sm-12 col-lg-12 col-xl-12">
        <p style="padding: 30px; margin-top: -30px;">
          Voro is an innovative ordering system tailored for sports footwear retail.
          Designed to enhance the shopping experience, Voro offers a fast,
          intuitive platform where customers can explore, compare, and order shoes with ease.
          Whether used in-store through kiosks or online via mobile devices,
          Voro delivers convenience, speed, and style at every step.
        </p>
        <hr style="height: 3px; border: none; background: antiquewhite; margin: 30px; margin-top: -30px;" />
      </div>
    </div>

    
    <nav class="navbar bg-body-dark navi" style="height: 100px;">
      <center>
        <a href="order.php?action=back" class="btn btn-sm glow" style="width: 200px;">
          <img src="order/shopping-cart.png" width="25"> Back to Shopping
        </a>
        <a href="order.php" class="btn btn-sm glow" style="width: 100px;">
          <img src="order/setting.png" width="20"> Account
        </a>
        <a href="cart.php?action=logout" class="btn btn-sm glow" style="width: 100px;">
          <img src="order/logout.png" width="20"> Log Out
        </a>
      </center>
    </nav>

    <br><br>

    <?php
    if (!empty($_SESSION['email'])) {
      include("database.php");
      $email = $_SESSION['email'];

      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete']) && !empty($_POST['selected_ids'])) {
        foreach ($_POST['selected_ids'] as $idToDelete) {
          $delStmt = mysqli_prepare($con, "DELETE FROM orders WHERE id = ? AND email = ?");
          mysqli_stmt_bind_param($delStmt, "is", $idToDelete, $email);
          mysqli_stmt_execute($delStmt);
          mysqli_stmt_close($delStmt);
        }
        print "<script>alert('Selected orders deleted.'); window.location.href='cart.php';</script>";
        exit;
      }

      $search = '';
      if (isset($_GET['search'])) {
        $search = trim($_GET['search']);
      }

      if ($search !== '') {
        $searchTerm = '%' . $search . '%';
        $stmt = mysqli_prepare($con, "SELECT * FROM orders WHERE email = ? AND item LIKE ?");
        mysqli_stmt_bind_param($stmt, "ss", $email, $searchTerm);
      } else {
        $stmt = mysqli_prepare($con, "SELECT * FROM orders WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
      }

      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $count = mysqli_num_rows($result);
    ?>

      <div class="container text-center" style="margin-top: 50px;">
        <h1 style="font-size: 50px;">My Orders</h1>
        <hr style="height: 3px; border: none; background: antiquewhite;">

        <form method="GET" action="cart.php" class="mb-4">
          <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search by Item Name" style="width: 300px; padding: 5px;">
          <button type="submit" class="button">Search</button>
          <a href="cart.php" class="button">Clear</a>
        </form>

        <form method="POST" action="cart.php">
          <table style="border: 2px solid antiquewhite; width: 100%; color: antiquewhite">
            <thead>
              <tr style="background-color: antiquewhite; color: black">
                <th>Select</th>
                <th>Order Date</th>
                <th>Image</th>
                <th>Item Name</th>
                <th>Cost</th>
                <th>Quantity</th>
                <th>Total Amount</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($row = mysqli_fetch_assoc($result)) {
                $id = (int)$row['id'];
                print "
                <tr>
                  <td align='center'>
                    <input type='checkbox' name='selected_ids[]' value='$id' style='width: 10px;'>
                  </td>
                  <td>" . htmlspecialchars($row['order_date']) . "</td>
                  <td><img src='" . htmlspecialchars($row['image']) . "' alt='Product Image' width='150'></td>
                  <td>" . htmlspecialchars($row['item']) . "</td>
                  <td>₱" . number_format($row['cost'], 2) . "</td>
                  <td>" . htmlspecialchars($row['quantity']) . "</td>
                  <td>₱" . number_format($row['amount'], 2) . "</td>
                </tr>";
              }
              ?>
            </tbody>
          </table>

          <center>
            <p><?= $count ?> order(s) found.</p>
            <input type="submit" name="delete" value="Cancel Selected" class="button">
          </center>
        </form>
      </div>

      <br><br><br><br>

    <?php
      mysqli_stmt_close($stmt);
    } else {
      print "
      <div class='container text-center' style='margin-top: 50px;'> 
        <h2 style='color: white;'>Session expired or unauthorized access.</h2> <br>
        <a href='index.php' class='button' style='padding: 10px 30px; margin-top: 30px;'>Log In</a>
      </div>
      ";
      exit;
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
