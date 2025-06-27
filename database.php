<?php
     $con = mysqli_connect("localhost", "root", "", "student")
        or die("Error in connection");
?>

<!-- Note 
 Database name: student
 table name: orders
 
 order_date = date 10
 email = varchar 256 
 item = varchar 100
 cost = int 5
 quantity = int 5
 amount = int 10
 password = varchar 256 -->