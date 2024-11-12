<?php
$conn=mysqli_connect("localhost","root","","fmp_db");
if(mysqli_connect_error()){
    echo "connection error" . $conn->connect_error;

}
?>