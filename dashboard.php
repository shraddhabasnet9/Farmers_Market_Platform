<?php
 include("nav_old.php");
 include_once("manage_cart.php");
 //session_start();
 require("conn.php");
?>
<!DOCTYPE html>
  <head>
    <html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmers Market Platform</title>
    <link rel="stylesheet" href="dash.css"/>
    <!-- bootstrap css link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--link for font awesome cdn-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
  </head>
  <body>
    <section id="hero">
      <h4>Welcome to Our Farmers Market</h4>
      <h2>Super value deals </h2>
      <h1> all Products</h1>
      <p>Discover fresh, locally sourced produce and artisanal products.</p>
      <button type="submit"><a href="product.php">Shop Now</a></button>
    </section>
    
    <section id="feature" class="section-p1">
      <div class="fe-box">
        <img src="./pictures/shipping.jpg" alt="">
        <h6>Free shipping</h6>
      </div>
      <div class="fe-box">
        <img src="./pictures/shopping.png" alt="">
        <h6>online order</h6>
      </div>
      <div class="fe-box">
        <img src="./pictures/m.jpg" alt="">
        <h6>Happy sell</h6>
      </div>
      <div class="fe-box">
        <img src="./pictures/buying.png" alt="">
        <h6>save money</h6>
      </div>
      <div class="fe-box">
        <img src="./pictures/g.png" alt="">
        <h6>save time</h6>
      </div>
      <div class="fe-box">
        <img src="./pictures/e.jpg" alt="">
        <h6>feedback</h6>
      </div>
    </section>

    <section id="product1" class="section-p1">
      <div class="product">
        <h2>Featured Products</h2>
        <p>
            Mostly Picked by Consumers
        </p>
        </div>
      <div class="pro-container">
        <?php 
        $sql1=mysqli_query($conn,"select * from products where pid <= 25");
           while($data1=mysqli_fetch_assoc($sql1)){

        ?>
        <div class="pro">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" >  
          <img src="<?php echo "./admin/" .$data1['image']; ?>" alt="">
          <div class="des">
            <h5><?php echo $data1['name']; ?></h5>
            <input type="hidden" name="Item_Name" value="<?php echo $data1['name']; ?>">
            <input type="hidden" name="Price" value="<?php echo $data1['price']; ?>">
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h4>Price: Rs <?php echo $data1['price']; ?></h4>
            <h4>Quantity: <?php echo $data1['quantity'];?></h4>
          </div>
          <p><button type="submit" name="add">Add to Cart  </button></p>     
          <input type="hidden" name="Item_Name" value="<?php echo $data['name']; ?>"> 
          <input type="hidden" name="Price" value="<?php echo $data['price']; ?>">
          </form>
        </div>
        <?php }  ?>
      
        
    </div>
  </section>
</body>
</html>
