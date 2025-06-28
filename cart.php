<?php
ob_start();
session_start();
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

<body class="page2">


    <img src="order/main.jpg" class="poster">

    <h1 style="font-size: 150px; margin-top: -250px; margin-left: 30px;">VORO</h1>
    <p style="margin-top: -15px; margin-left: 50px; word-spacing: 15px; font-size: 25px;">
        Order fast. Move faster.
    </p>

    <div class=" text-center">
        <div class="row">
            <div class="col-sm-12 col-lg-12 col-xl-12">

                <p style="padding: 30px;  margin-top: -30px;">Voro is an innovative ordering system tailored for sports footwear retail.
                    Designed to enhance the shopping experience, Voro offers a fast,
                    intuitive platform where customers can explore, compare, and order shoes with ease.
                    Whether used in-store through kiosks or online via mobile devices,
                    Voro delivers convenience, speed, and style at every step.</p>

                <hr style="height: 3px; border: none; background: antiquewhite; margin: 30px; margin-top: -30px;" />

            </div>

        </div>

        <!-- Navibar -->
        <nav class="navbar bg-body-dark navi" style="height: 100px;">
            <form class="container-fluid ">

                <center>
                    <a href="cart.php" button class="btn btn-sm glow" type="button" style="width: 100px;"><img src="order/shopping-cart.png" width="25"> Cart</button></a>
                    <a href="index.html" button class="btn btn-sm glow" type="button" style="width: 100px;"><img src="order/setting.png" width="20"> Account</button></a>
                    <a href="index.php" button class="btn btn-sm glow" type="button" style="width: 100px;"><img src="order/logout.png" width="20"> Log Out</button></a>
                </center>


            </form>
        </nav>

        <br><br>

        <?php
        if (!empty($_SESSION['email'])) {
            include("database.php");
            $email = $_SESSION['email'];


            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
                if (!empty($_POST['selected'])) {
                    foreach ($_POST['selected'] as $orderId) {
                        $orderId = intval($orderId);
                        $deleteQuery = "DELETE FROM orders WHERE email = $orderId AND email = '$email'";
                        mysqli_query($con, $deleteQuery);
                    }
                    echo "<script>alert('Selected orders deleted successfully!');</script>";
                    echo "<script>window.location.href='cart.php';</script>";
                    exit;
                } else {
                    echo "<script>alert('No orders selected for deletion.');</script>";
                }
            }


            $query = "SELECT * FROM orders WHERE email = '$email'";
            $result = mysqli_query($con, $query);
            $count = mysqli_num_rows($result);
        ?>

            <div class="container text-center" style="margin-top: 50px;">
                <h1 style="font-size: 50px;">My Orders</h1>
                <hr style="height: 3px; border: none; background: antiquewhite;">

                <form method="POST" action="cart.php">
                    <table style="border: 2px solid antiquewhite; width: 1115px; color:antiquewhite">
                        <thead>
                            <tr style="background-color: antiquewhite; color:black">
                                <th></th>
                                <th >Order Date</th>
                                <th >Item</th>
                                <th>Item Name</th>
                                <th>Cost</th>
                                <th>Quantity</th>
                                <th>Total Amount</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                $email = $row['email'];
                                echo "
            <tr>
              <td><input type='checkbox' name='selected[]' value='$email' style='width: 20px;'></td>
              <td>{$row['order_date']}</td>
              <td><img src='{$row['image']}' alt='Product Image' width='150'></td>
              <td>{$row['item']}</td>
              <td>₱" . number_format($row['cost'], 2) . "</td>
              <td>{$row['quantity']}</td>
              <td>₱" . number_format($row['amount'], 2) . "</td>
              
            </tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <center>

                        <p><?= $count ?> order(s) found.</p>

                    </center>

                    <input type="submit" name="delete" value="Cancel Selected" class="button">
                </form>

                            
            </div>

            <br><br><br><br>

        <?php
        } else {
            
            echo "
    <div class='container text-center' style='margin-top: 200px;'>
      <h2 style='color: white;'>Session expired or unauthorized access.</h2>
      <a href='login.php' class='btn btn-warning mt-3' style='padding: 10px 30px;'>Log In</a>
    </div>
  ";
            exit;
        }
        ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>