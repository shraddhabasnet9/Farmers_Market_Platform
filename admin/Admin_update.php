<?php

@include 'conn.php';

$id = $_GET['edit'];


session_start();
if(!isset($_SESSION['AdminLoginId'])){
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

        if (move_uploaded_file($imagefiletemp, $upload_image)) {
            $sql3 = "update products set name='$name', price='$price', quantity='$quantity', image='$upload_image' where pid='$id'";
                        if ($conn->query($sql3)) {
               header('Location: admin_page.php');
                
            } else {
                echo 'Error: ' . $conn->error;
            }
        } else {
            echo 'Error: Failed to move the uploaded file.';
        }
    } else {
        echo 'Error: Invalid file extension. Only JPG, PNG, and JPEG files are allowed.';
    }
}


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
         <button type="submit">Display
            <a href="users_record.php"></a>
         </button>
         <button name="logout">Log Out</button>
      </form>
   </div>
<?php
if(isset($_POST['logout'])){
   session_destroy();
   header("location:admin_login.php");
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
      <?php 
 $sql = mysqli_query($conn, "SELECT * FROM products where pid='$id' "); 
 
 if($sql){

    $data=mysqli_fetch_assoc($sql);

   ?>



      <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" >
         <h3>Update The product Details</h3>
         <input type="text" placeholder="enter product name" name="name" value="<?php echo $data['name']; ?>" class="box">
         <input type="number" placeholder="enter product price"  value="<?php echo $data['price']; ?>"  name="price" class="box">
         <input type="number" placeholder="enter product quantity"  value="<?php echo $data['quantity']; ?>"  name="quantity" class="box">
         <input type="file" accept="image/png, image/jpeg, image/jpg"  value="<?php echo $data['image']; ?>"  name="image" class="box">
         <input type="submit" class="btn" name="submit" value="Update">
      </form>

   </div>
   <?php
}
?>
   
  


</body>
</html>