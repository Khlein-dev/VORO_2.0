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
        crossorigin="anonymous" />
    <link rel="stylesheet" href="order.css" />
</head>

<body class="main">

    <div class="signup">
        <center>

            <?php
            session_start();
            ?>

            <br><br>
            <h1 style="font-size: 75px;">Sign Up</h1>

            <form action=signup.php method=POST>
                <table>
                    <tr>
                        <td>EMAIL
                        <td><Input type=email name=email required>
                    <tr>
                        <td>Password
                        <td><Input type=password name=password required>
                    <tr>
                        <td><Input class="btn" type=submit value=save name=save>
                        <td><Input class="btn" type=reset value=clear>
                </table>
            </form>

            <?php
            if (!empty($_POST['save'])) {
                $e = $_POST['email'];
                $p = $_POST['password'];


                include("database.php");
                $search = "SELECT * from orders where (email='$e')";
                $result = mysqli_query($con, $search);
                $count = mysqli_num_rows($result);

                if ($count == 0) {

                    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $insert = "INSERT into orders (email, password) values ('$e','$password_hash')";
                    mysqli_query($con, $insert);
                    print "Record Saved!";
                } else {
                    print "Invalid credentials";
                }
            }
            ?>
            <br><br><br><br>
            <a href="index.php">Go back</a>


        </center>

    </div>



    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
</body>

</html>