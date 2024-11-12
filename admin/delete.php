<?php 
@include 'conn.php';

$id = $_GET['delete'];
$uid=$_GET['did'];
$fid=$_GET['deid'];

session_start();
if(!isset($_SESSION['AdminLoginId'])){
   header("location:admin_login.php");
}
if(isset($id)){
$sql=mysqli_query($conn,"delete from products where pid='$id' ");
if($sql){
  
    header("Location:admin_page.php");
}
}

if(isset($uid)){
    $sql = "delete FROM user_login where uid='$uid'";
     $result = $conn->query($sql);
    if($sql){
      
        header("Location:users_record.php");
    }
    }

if(isset($fid)){
    $sql = "delete FROM feedback where fid='$fid'";
    $result = $conn->query($sql);
    if($sql){
        header("Location:feedback_record.php");
    }
}
    
?>