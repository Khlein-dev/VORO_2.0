<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VORO - Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="order.css" />
</head>

<body style="background-image: url('order/cbg.jpg'); background-size:cover;">
    <center>
        <form action=claim.php method=get>

            <div class="container text-white" style="border: 4px solid antiquewhite; border-radius: 15px; margin-top: 120px; background-color:black; padding: 8px; ">
                <div class="row">
                    <div class="col">

                        <?php $image = $_GET['image'];
                        print "<img src=$image width=600 height=400>"; ?>

                        <input type=hidden name=image value="
                        <?php
                        print $_GET['image'];
                        ?>
                    
                    ">

                    </div>
                    <div class="col" style="text-align: left;">



                        <h1> <?php print $_GET['item']; ?> </h1>

                        <h4><?php print "₱ " . $_GET['cost'] . " per pair" ?> </h4>

                        <hr style="height: 3px; border: none; background: antiquewhite" />

                        <input type="hidden" name="item" value="<?php print $_GET['item'];?>">

                        <input type="hidden" name=cost value="<?php print $_GET ['cost'];?>">



                        <center>


                            <br><br>

                            <input type="number" name="qty" placeholder="Enter Quantity" required>

                            <br><br>

                            <input class="gee" type="submit" name=submit value='Order Now'>

                            <br><br>

                        </center>







                    </div>
                </div>
            </div>

        </form>
    </center>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>