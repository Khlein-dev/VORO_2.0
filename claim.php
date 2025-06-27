<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VORO - Purchased</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="order.css" />
</head>

<body style="background-image: url('order/cbg.jpg'); background-size:cover;">

    <?php
    $i = $_GET['item'];
    $c = $_GET['cost'];
    $q = $_GET['qty'];
    $image = $_GET['image'];
    $sum = $c * $q;
    ?>


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

             <img src="order/check-mark.png" width="60px" style="margin-left: 350px; position:absolute;">

                <h4>Congratulations! you have purchased </h4>

                <h1> <?php print $_GET['item']; ?> </h1>



                <hr style="height: 3px; border: none; background: antiquewhite" />

                <h4><?php print "Quantity: " . $q ?> </h4>

                <h4><?php print "Total: ₱" . $sum ?> </h4>

                <p>Kindly have the payment ready upon delivery.</p>


                <button onclick="window.location.href='index.html'" style="margin-left: 400px; padding:10px;">Back</button>






            </div>
        </div>
    </div>







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>