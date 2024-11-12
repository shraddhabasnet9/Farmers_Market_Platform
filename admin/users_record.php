<?php
    require 'conn.php';
    if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM user_login";
$result = $conn->query($sql);
?>
<html>
<head>
    <title>User Records</title>
</head>
<style>
 h1{
        text-align:center;
        margin-top:50px;
        color:gray;
    }
    th{
    
        width:200px;
        height:40px;
        background-color:green;
    }
    table{
        position:relative;
        left:10%;
        top:10%;
    }
    button{
        padding:5px 20px 5px 20px;
        margin-left:20%;
    }
    td{
        height:60px;
        font-size:larger;
        text-align:center;
        
    }
    
</style>
<body>
    <h1>User Records</h1>
    <table border="1">
        <tr> <th>Id</th>
            <th>Email</th>

            <th>Name</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
        <?php 
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                ?>


            <tr> 
               <td><?php echo $row['uid']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><a href="delete.php?did=<?php echo $row['uid']; ?>"><button>Delete</button> </a></td>



            </tr>
            <?php 
        }
    } else {
        echo "No users found.";
    }

    $conn->close();
    ?>

    </table>
</body>
</html>