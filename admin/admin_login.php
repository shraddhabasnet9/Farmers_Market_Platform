<?php
require("conn.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Panel</title>
    <link rel="stylesheet" href="admin_login.css">
</head>
<body>
    <div class="login-form">
        <h2>Admin Login Panel</h2>
        <form method="POST">
            <div class="input">
                <label>Admin Name:</label>
                <input type="text" name="adminName" placeholder="Admin Name">
            </div>
            <div class="input">
                <label>Admin Password:</label>
                <input type="password" name="adminPassword" placeholder="Password">
            </div>
            <button type="submit" class="btn" name="signup">Log In</button>
        </form>
    </div>
    <?php
    if(isset($_POST['signup'])){
        $adminName = $_POST['adminName'];
        $adminPassword = $_POST['adminPassword'];
    
        $query = "SELECT * FROM `admin_login` WHERE `admin_name`=? AND `admin_password`=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $adminName, $adminPassword);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if($result->num_rows == 1){
            session_start();
            $_SESSION['AdminLoginId'] = $adminName;
            header("location: Admin_page.php");
        } else {
            echo "<script>alert('This admin doesnot exist');</script>";
        }
    }
    ?>
</body>
</html>