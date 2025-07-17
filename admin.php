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

      <br><br>

      <!-- Visual -->
      <?php
      include('database.php');
      $sql = "SELECT 
                SUM(quantity) AS total_products_sold, 
                COUNT(*) AS number_of_orders, 
                AVG(amount) AS avg_amount, 
                MIN(amount) AS min_amount, 
                MAX(amount) AS max_amount 
              FROM orders";
      $res = mysqli_query($con, $sql);
      if ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        $totalProducts = $row['total_products_sold'];
        $orderCount = $row['number_of_orders'];
        $avgAmount = number_format($row['avg_amount'], 2);
        $minAmount = number_format($row['min_amount'], 2);
        $maxAmount = number_format($row['max_amount'], 2);

        print "<table border='1' cellpadding='8' style='margin-bottom:20px;'>
                <tr style='background-color: antiquewhite; color: black;''>
                    <th>Total Products Sold</th>
                    <th>Number of Orders</th>
                    <th>Average Order Amount</th>
                    <th>Lowest Order Amount</th>
                    <th>Highest Order Amount</th>
                </tr>
                <tr>
                    <td>$totalProducts</td>
                    <td>$orderCount</td>
                    <td>₱$avgAmount</td>
                    <td>₱$minAmount</td>
                    <td>₱$maxAmount</td>
                </tr>
            </table>";
      }







      $userSql = "SELECT email, GROUP_CONCAT(item SEPARATOR ', ') AS items, SUM(amount) AS total_spent
                  FROM orders
                  GROUP BY email
                  ORDER BY total_spent DESC";
      $userRes = mysqli_query($con, $userSql);

      print "<table border='1' cellpadding='8' style='margin-bottom:20px; width: 69%;'>
              <tr style='background-color: antiquewhite; color: black;'>
                <th>Email</th>
                
                <th>Total Amount Spent</th>
              </tr>";
      while ($userRow = mysqli_fetch_assoc($userRes)) {
        $email = htmlspecialchars($userRow['email']);

        $totalSpent = number_format($userRow['total_spent'], 2);
        print "<tr>
                <td>$email</td>
                
                <td>₱$totalSpent</td>
              </tr>";
      }
      print "</table>";


      $pieData = [];
      $itemSql = "SELECT item, COUNT(*) AS cnt FROM orders GROUP BY item ORDER BY cnt DESC";
      $itemRes = mysqli_query($con, $itemSql);
      while ($itemRow = mysqli_fetch_assoc($itemRes)) {
        $pieData[] = [
          'label' => $itemRow['item'],
          'y' => (int)$itemRow['cnt']
        ];
      }

      $lineData = [];
      $dateSql = "SELECT order_date, SUM(quantity) AS total_sold FROM orders GROUP BY order_date ORDER BY order_date ASC";
      $dateRes = mysqli_query($con, $dateSql);
      while ($dateRow = mysqli_fetch_assoc($dateRes)) {

        $timestamp = strtotime($dateRow['order_date']) * 1000;
        $lineData[] = [
          'x' => $timestamp,
          'y' => (int)$dateRow['total_sold']
        ];
      }

      $barData = [];
      $barSql = "SELECT email, SUM(quantity) AS total_items FROM orders GROUP BY email ORDER BY total_items DESC";
      $barRes = mysqli_query($con, $barSql);
      while ($barRow = mysqli_fetch_assoc($barRes)) {
        $barData[] = [
          'label' => $barRow['email'],
          'y' => (int)$barRow['total_items']
        ];
      }
      ?>

      
      <script>
        window.onload = function() {
          // PIE CHART
          var pieChart = new CanvasJS.Chart("pie", {
            theme: "dark1",
            exportEnabled: true,
            animationEnabled: true,
            title: {
              text: "Most Frequent Shoes Ordered"
            },
            data: [{
              type: "pie",
              startAngle: 25,
              toolTipContent: "<b>{label}</b>: {y} orders",
              showInLegend: "true",
              legendText: "{label}",
              indexLabelFontSize: 16,
              indexLabel: "{label} - {y} orders",
              dataPoints: <?php echo json_encode($pieData, JSON_NUMERIC_CHECK); ?>
            }]
          });
          pieChart.render();

          // LINE CHART
          var lineChart = new CanvasJS.Chart("line", {
            theme: "dark1",
            animationEnabled: true,
            title: {
              text: "Items Sold Per Day"
            },
            axisX: {
              title: "Date",
              valueFormatString: "YYYY-MM-DD"
            },
            axisY: {
              title: "Items Sold",
              includeZero: true
            },
            data: [{
              type: "line",
              name: "Items Sold",
              xValueType: "dateTime",
              xValueFormatString: "YYYY-MM-DD",
              yValueFormatString: "#,##0",
              dataPoints: <?php echo json_encode($lineData, JSON_NUMERIC_CHECK); ?>
            }]
          });
          lineChart.render();

          // BAR CHART
          var barChart = new CanvasJS.Chart("barChartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "dark1",
            title: {
              text: "Top Customers by Items Purchased"
            },
            axisY: {
              title: "Total Items Purchased",
              includeZero: true
            },
            axisX: {
              title: "Email",
              labelAngle: -45
            },
            data: [{
              type: "column",
              indexLabel: "{y}",
              indexLabelFontColor: "#5A5757",
              indexLabelFontSize: 14,
              dataPoints: <?php echo json_encode($barData, JSON_NUMERIC_CHECK); ?>
            }]
          });
          barChart.render();
        }
      </script>

      <div id="pie" style="height: 300px; width: 880px; color:antiquewhite; background-color:black;"></div> <br><br><br>

      <div id="line" style="height: 300px; width: 880px;"></div>  <br><br><br>

      <div id="barChartContainer" style="height: 350px; width: 880px;"></div>
      <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>


      <div style="border: 2px solid antiquewhite; padding: 20px; margin: 100px; border-radius: 15px; width:800px;">
        <h1>ADMIN SIGN UP <img src='order/setting.png' width=70></h1>
        <br>
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