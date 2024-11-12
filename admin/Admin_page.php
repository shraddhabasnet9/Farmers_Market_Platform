<?php
@include 'conn.php';
session_start();
if (!isset($_SESSION['AdminLoginId'])) {
    header("location:admin_login.php");
}

if (isset($_POST['submit']) && isset($_FILES['image'])) {
   
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $quantity= trim($_POST['quantity']);
    $image = $_FILES['image'];
    $imagename = $image['name'];
    $imagefiletemp = $image['tmp_name'];

    $filename_seprate = explode('.', $imagename);
    $file_extension = strtolower(end($filename_seprate));

    $allowed_extensions = array('jpg', 'png', 'jpeg');
    if (in_array($file_extension, $allowed_extensions)) {
        $upload_directory = 'upload/';
        $upload_image = $upload_directory . basename($imagename);

        // Check for duplicates
        $check_duplicate_query = "SELECT * FROM products WHERE name='$name' AND image='$upload_image'";
        $duplicate_result = $conn->query($check_duplicate_query);

        if ($duplicate_result->num_rows > 0) {
            echo "<script>alert('product already available');</script>";
        } else {
            if (move_uploaded_file($imagefiletemp, $upload_image)) {
                $sql3 = "INSERT INTO products (name, price, quantity, image) VALUES ('$name', '$price','$quantity', '$upload_image')";
                if ($conn->query($sql3)) {
                    echo "<script>alert('Product added successfully');</script>";
                } else {
                    echo 'Error: ' . $conn->error;
                }
            } else {
                echo 'Error: Failed to move the uploaded file.';
            }
        }
    } else {
      echo "<script> alert('Error: Invalid file extension. Only JPG, PNG, and JPEG files are allowed.');</script>";
    }
}

if(isset($_GET['delete'])){
   $id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM products WHERE id = $id");
   header('location:admin_page.php');
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>
   <style>
      div.header{
         display: flex;
         justify-content: space-between;
         align-items: center;
         padding: 25px 60px;
         background-color: #204969;
         color:white;
      }
      div.header button{
         background-color:black;
         color:white;
         font-size: 16px;
         font-weight: 500;
         padding: 8px 12px;
         border: 2px solid black;
         border-radius: 5px;
      }
      div.header button:hover{
         background-color:white;
         color:green;
      }
   </style>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="Admin_page.css">

</head>
<body>
   <div class="header">
      <h1>Welcome To Admin Panel -<?php echo $_SESSION['AdminLoginId']?></h1>
      <form method="POST">
         <button name="display">Users
            <a href="users_record.php"></a>
         </button>
         <button name="display_order">Orders
            <a href="record.php"></a>
         </button>
         <button name="display_feedback">Feedbacks
            <a href="feedback_record.php"></a>
         </button>
         <button name="logout">Log Out</button>
      </form>
   </div>
<?php
if(isset($_POST['logout'])){
   session_destroy();
   header("location:admin_login.php");
}
if(isset($_POST['display'])){
   header("location:users_record.php");
}
if(isset($_POST['display_order'])){
   header("location:record.php");
}
if(isset($_POST['display_feedback'])){
   header("location:feedback_record.php");
}
?>
<?php

if(isset($message)){
   foreach($message as $message){
      echo '<span class="message">'.$message.'</span>';
   }
}

?>
   
<div class="container">

   <div class="admin-product-form-container">

      <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" >
         <h3>add a new product</h3>
         <input type="text" placeholder="enter product name" name="name" class="box">
         <input type="number" placeholder="enter product price" name="price" class="box">
         <input type="number" placeholder="Enter product quantity" name="quantity" class="box" min="0" required>
         <input type="file" accept="image/png, image/jpeg, image/jpg" name="image" class="box">
         <input type="submit" class="btn" name="submit" value="add product">
      </form>

   </div>

   <?php

   $sql = mysqli_query($conn, "SELECT * FROM products");
   
   ?>
   <div class="product-display">
      <table class="product-display-table">
         <thead>
         <tr>
            <th>product image</th>
            <th>product name</th>
            <th>product price</th>
            <th>Product Quantity</th>
            <th>action</th>
         </tr>
         </thead>
         <?php

          while($row = mysqli_fetch_assoc($sql)){ ?>
         <tr>
            <td><img src="<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            <td>RS<?php echo $row['price']; ?>/-</td>
            <td><?php echo $row['quantity']; ?>/-</td>
            <td>
               <a href="admin_update.php?edit=<?php echo $row['pid']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
               <a href="delete.php?delete=<?php echo $row['pid']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
            </td>
         </tr>
      <?php } ?>
      </table>
   </div>

</div>

</body>
</html>