<?php
include("nav_old.php");
session_start();
require("conn.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="product.css">
     <!--link for font awesome cdn-->
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
</head>
<body>
<section id="product1" class="section-p1">
    <h2>Searched Products</h2>
    <div class="pro-container">
    <?php 

    if(isset($_POST['sbtn'])){
        $item=$_POST['searchitem'];

        $sql1=mysqli_query($conn,"SELECT * 
FROM products 
WHERE LOWER(name) LIKE LOWER('$item%')
   OR LOWER(name) LIKE LOWER('%$item')
   OR LOWER(name) LIKE LOWER('%$item%')
   OR LOWER(name) = LOWER('$item');
 ");
        if(mysqli_num_rows($sql1) > 0){
        while($data1=mysqli_fetch_assoc($sql1)){
      

    
       
        ?>
   
        <div class="pro">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">  
          <img src="<?php echo "./admin/".$data1['image']; ?>" alt="">
          <div class="des">
            <h5><?php echo $data1['name']; ?></h5>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h4><?php echo $data1['price']; ?>"</h4>
          </div>
          <p><button type="submit" name="add">Add to Cart</button></p>
          <input type="hidden" name="Item_Name" value="<?php echo $data1['name']; ?>">
            <input type="hidden" name="Price" value="<?php echo $data1['price']; ?>">
          </form>
        </div>
        <?php
        }
         } 
        } ?>
      
   
    </div>
  </section>