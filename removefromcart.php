<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 
  include('conn.php');
  $pid=$_GET['pid'];
  if(isset($pid)){
    $sql="DELETE FROM buffer where pid='$pid'";
$exe=mysqli_query($conn,$sql);
if($exe){
    header("Location:cart.php");

}

  }
  



?>
    
</body>
</html>