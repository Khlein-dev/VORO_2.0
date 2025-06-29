<?php
ob_start();
session_start();


if (isset($_GET['action']) && $_GET['action'] === 'logout') {
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
  <title>VORO - Admin Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="order.css" />
  <style>
    body {
      margin: 40px;
      color: antiquewhite;
    }

    a {
      text-decoration: none;
    }
  </style>


</head>

<script>
  window.addEventListener("pageshow", function(event) {
    if (event.persisted) {
      location.reload();
    }
  });
</script>

<body class="page2">

  <?php if (!empty($_SESSION['email'])) : ?>
    <center>
      <h1 style="font-size: 60px;">LIST OF ORDERS</h1>
      <hr style="height: 3px; border: none; background: antiquewhite;">

    
      <form action="admin.php" method="GET">
        <input type="search" name="find" placeholder="Enter Email or Item" required>
        <input class="button" style="width: 80px" type="submit" name="btnsearch" value="Search">
      </form>
      <br>

      <?php
      include("database.php");

     
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
        if (!empty($_POST['selected'])) {
          $selectedIds = $_POST['selected'];
          $placeholders = implode(',', array_fill(0, count($selectedIds), '?'));
          $types = str_repeat('i', count($selectedIds));
          $stmt = mysqli_prepare($con, "DELETE FROM orders WHERE id IN ($placeholders)");
          mysqli_stmt_bind_param($stmt, $types, ...$selectedIds);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_close($stmt);
          print "<script>alert('Selected records deleted successfully!'); window.location.href='admin.php';</script>";
          exit;
        } else {
          print "<script>alert('No records selected for deletion!');</script>";
        }
      }

      
      if (!empty($_GET['btnsearch'])) {
        $find = trim($_GET['find']);
        $stmt = mysqli_prepare($con, "SELECT * FROM orders WHERE email LIKE ? OR item LIKE ?");
        $param = "%$find%";
        mysqli_stmt_bind_param($stmt, 'ss', $param, $param);
      } else {
        $stmt = mysqli_prepare($con, "SELECT * FROM orders");
      }

      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $count = mysqli_num_rows($result);
      ?>

      
      <form method="POST" action="admin.php">
        <table align="center" style="border: 2px solid antiquewhite; width: 100%;">
          <tr style="background-color: antiquewhite; color: black;">
            <th></th>
            <th>Order Date</th>
            <th>User</th>
            <th>Image</th>
            <th>Item Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Amount</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>

          <?php
          $allChecked = !empty($_GET['checkall']);
          while ($rows = mysqli_fetch_assoc($result)) :
            $id = htmlspecialchars($rows['id']);
            $date = htmlspecialchars($rows['order_date']);
            $email = htmlspecialchars($rows['email']);
            $image = htmlspecialchars($rows['image']);
            $itemName = htmlspecialchars($rows['item']);
            $cost = htmlspecialchars($rows['cost']);
            $quantity = htmlspecialchars($rows['quantity']);
            $amount = htmlspecialchars($rows['amount']);
            $checked = $allChecked ? "checked" : "";
          ?>
            <tr>
              <td align='center'>
                <input type='checkbox' name='selected[]' value='<?= $id ?>' <?= $checked ?> style="width: 20px;">
              </td>
              <td><?= $date ?></td>
              <td><a href='view.php?id=<?= urlencode($id) ?>'><?= $email ?></a></td>
              <td><img src='<?= $image ?>' width='150'></td>
              <td><?= $itemName ?></td>
              <td>₱<?= number_format($cost, 2) ?></td>
              <td><?= $quantity ?></td>
              <td>₱<?= number_format($amount, 2) ?></td>
              <td>
                <a href='update.php?id=<?= urlencode($id) ?>'>
                  <img src='order/editing.png' width='30'>
                </a>
              </td>
              <td>
                <a href='delete.php?id=<?= urlencode($id) ?>'>
                  <img src='order/cancel.png' width='30'>
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        </table>

        <p><?= $count ?> record(s) found.</p>
        <input class="button" type="submit" name="delete" value="Delete Selected">
      </form>

      <br>
      <a href="admin.php?checkall=yes">Check All</a> | <a href="admin.php">Clear All</a>

     
      <br><br>
      <a href="admin.php?action=logout" class="btn btn-sm glow" style="width: 100px; position: absolute; right: 20px; top: 20px;">
        <img src="order/logout.png" width="20"> Log Out
      </a>

     
      <div style="border: 2px solid antiquewhite; padding: 20px; margin: 100px; border-radius: 15px; width:800px;">
        <h1>ADMIN SIGN UP <img src='order/setting.png' width=70></h1>

        <form action="admin.php" method="POST">
          <table>
            <tr>
              <td>EMAIL</td>
              <td><input type="email" name="admin_email" required></td>
            </tr>
            <tr>
              <td>Password</td>
              <td><input type="password" name="admin_password" required></td>
            </tr>
            <tr>
              <td><input class="btn" type="submit" value="Save" name="save_admin"></td>
              <td><input class="btn" type="reset" value="Clear"></td>
            </tr>
          </table>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['save_admin'])) {
          $adminEmail = trim($_POST['admin_email']);
          $adminPassword = trim($_POST['admin_password']);

          if (!empty($adminEmail) && !empty($adminPassword)) {
            $stmt = mysqli_prepare($con, "SELECT id FROM admin WHERE email = ?");
            mysqli_stmt_bind_param($stmt, "s", $adminEmail);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
              print "<script>alert('Admin already exists with that email!');</script>";
            } else {
              $hashed = password_hash($adminPassword, PASSWORD_DEFAULT);
              $insertStmt = mysqli_prepare($con, "INSERT INTO admin (email, password) VALUES (?, ?)");
              mysqli_stmt_bind_param($insertStmt, "ss", $adminEmail, $hashed);

              if (mysqli_stmt_execute($insertStmt)) {
                print "<script>alert('Admin account created successfully!');</script>";
              } else {
                print "<script>alert('Error: " . mysqli_error($con) . "');</script>";
              }

              mysqli_stmt_close($insertStmt);
            }

            mysqli_stmt_close($stmt);
          } else {
            print "<script>alert('Please fill in all fields!');</script>";
          }
        }
        ?>
      </div>
    </center>
  <?php else : ?>
    <?php exit("Terminated <a href='index.php' class='btn'>Log In</a>"); ?>
  <?php endif; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>