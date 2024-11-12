<?php
require("conn.php");
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['AdminLoginId'])) {
    header("location: admin_login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display users with orders</title>
    <style>
        h1 {
            font-size: 36px;
            color: rgb(26, 85, 85);
            padding: 10px 24px;
            text-align: center;
        }

        th {
            font-size: 20px;
            width: 200px;
            height: 40px;
            background-color: grey;
        }

        td {
            border: 0.5px solid black;
            height: 60px;
            font-size: larger;
            text-align: center;
            background-color: azure;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                <h1>Orders Record</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Order Id</th>
                            <th>Customer Name</th>
                            <th>Phone No</th>
                            <th>Address</th>
                            <th>Pay Mode</th>
                            <th>Orders</th>
                           <!-- <th>Action</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM `order_manager`";
                        $user_result = mysqli_query($conn, $query);
                        while ($user_fetch = mysqli_fetch_assoc($user_result)) {
                            echo "<tr>";
                            echo "<td>{$user_fetch['Order_Id']}</td>";
                            echo "<td>{$user_fetch['Full_Name']}</td>";
                            echo "<td>{$user_fetch['Phone_No']}</td>";
                            echo "<td>{$user_fetch['Address']}</td>";
                            echo "<td>{$user_fetch['Pay_Mode']}</td>";
                            echo "<td>";
                            echo "<table>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>Item Name</th>";
                            echo "<th>Price</th>";
                            echo "<th>Quantity</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            $order_query = "SELECT * FROM `user_orders` WHERE `Order_Id` = '{$user_fetch['Order_Id']}'";
                            $order_result = mysqli_query($conn, $order_query);
                            while ($order_fetch = mysqli_fetch_assoc($order_result)) {
                                echo "<tr>";
                                echo "<td>{$order_fetch['Item_Name']}</td>";
                                echo "<td>{$order_fetch['Price']}</td>";
                                echo "<td>{$order_fetch['Quantity']}</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            echo "</td>";
                            /*echo "<td>";
                            echo "<a href='delete.php?delete_id={$user_fetch['Order_Id']}'>";
                            echo "<button>Delete</button> ";
                            echo "</a>";
                            echo "</td>";
*/
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
