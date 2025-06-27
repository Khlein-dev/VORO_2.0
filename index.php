<?php
session_start();


$con = mysqli_connect("localhost", "root", "", "student") or die("Error in connection");

$error = "";


if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['email']) && !empty($_POST['password'])) {
    $e = $_POST['email'];
    $p = $_POST['password'];

    
    $stmt = mysqli_prepare($con, "SELECT password FROM orders WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $e);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 0) {
        $error = "Email doesn't exist";
    } else {
        mysqli_stmt_bind_result($stmt, $hash);
        mysqli_stmt_fetch($stmt);

        if (password_verify($p, $hash)) {
            $_SESSION['email'] = $e;
            header("Location: order.php");
            exit;
        } else {
            $error = "Password is invalid";
        }
    }

    mysqli_stmt_close($stmt);
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>VORO</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="order.css" />
  </head>
  <body class="main">
      <div class="intro" style="margin-top: 90px;">

        <h1>VORO</h1>
        <p style="margin-top: -15px; margin-left: 10px">
          Order fast. Move faster.
        </p>

        <hr style="height: 3px; border: none; background: antiquewhite" />

        <p>
          Voro is a smart and efficient ordering system for sports shoes. It
          offers a smooth user experience, from browsing top brands to quick and
          secure checkout—perfect for both customers and retailers on the go.
        </p>
        <center>

          <?php
            if (!empty($error)) {
                echo "<p style='margin-left: 168px;'>$error <img src='order/warning.png' width=30px></p>";
            }
            ?>

             <form action="index.php" method="post">
                <br>
                <input type="email" name="email" placeholder="Enter Email" required>
                <br><br>
                <input type="password" name="password" placeholder="Enter Password" required>
                <br><br>
                <input  type="submit" value="Login Now">
            </form>

            <br><br>

            <a href="signup.php">Sign Up</a>

          
        </center>
        
      </div>

      <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"
      ></script>
  </body>
</html>
