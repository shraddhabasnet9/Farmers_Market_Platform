<?php
require("conn.php");
include("nav_old.php");
include_once("manage_cart.php");
// $uid=$_SESSION['uid'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display products</title>
    <link rel="stylesheet" href="product.css">
     <!--link for font awesome cdn-->
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
</head>
<body>
 <section id="product1" class="section-p1">
    <h2>Newly Listed Products</h2>
    <div class="pro-container">
    <?php 
        $sql=mysqli_query($conn,"select * from products where pid >1 ");
          while( $data=mysqli_fetch_assoc($sql)){
            ?>
            <div class="pro">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">  
              <img src="<?php echo "./admin/" .$data['image']; ?>" alt="">
              <div class="des">
                <h5><?php echo $data['name']; ?></h5>
                <div class="star">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                </div>
                <h4>Price: Rs <?php echo $data['price']; ?></h4>
                <h4>Quantity: <?php echo $data['quantity'];?></h4>
              </div>
              <p><button type="submit" name="add"> Add to Cart</a></button></p>
              <input type="hidden" name="Item_Name" value="<?php echo $data['name']; ?>">
                <input type="hidden" name="Price" value="<?php echo $data['price']; ?>">
              </form>
            </div>
      <?php }  ?>
    </div>
  </section>
</body>
</html>