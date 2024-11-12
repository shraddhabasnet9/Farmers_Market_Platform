<?php
session_start();
//$pid=$_SESSION['pid'];
$pid=10;
require("conn.php");

if (mysqli_connect_error()) {
    echo "<script>
    alert('Cannot connect to the database');
    window.location.href='cart.php';
    </script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['purchase'])) {
    $fn = mysqli_real_escape_string($conn, $_POST['Full_Name']);
    $pn = mysqli_real_escape_string($conn, $_POST['Phone_No']);
    $ad = mysqli_real_escape_string($conn, $_POST['Address']);
    $pm = mysqli_real_escape_string($conn, $_POST['Pay_Mode']);

    // Fetch user ID
    $sql_fetch_uid = "SELECT uid FROM user_login WHERE name = ? AND phone = ?";
    $stmt_fetch_uid = $conn->prepare($sql_fetch_uid);
    $stmt_fetch_uid->bind_param("ss", $fn, $pn);
    $stmt_fetch_uid->execute();
    $result = $stmt_fetch_uid->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $uid = $row['uid'];

        // Insert order details
        $query1 = "INSERT INTO `order_manager`(`Order_Id`,`Full_Name`, `Phone_No`, `Address`, `Pay_Mode`) VALUES (?,?, ?, ?, ?)";
        $stmt_insert_order = $conn->prepare($query1);
        $stmt_insert_order->bind_param("sssss", $Order_Id,$fn, $pn, $ad, $pm);

        if ($stmt_insert_order->execute()) {
            $Order_Id = $stmt_insert_order->insert_id;

            // Fetch product IDs
            $productIds = [];
            foreach ($_SESSION['cart'] as $key => $values) {
                $Item_Name = mysqli_real_escape_string($conn, $values['Item_Name']);
                $sql_fetch_pid = "SELECT pid FROM products WHERE name='$Item_Name'";
                $result_pid = mysqli_query($conn, $sql_fetch_pid);

                if ($result_pid && $row_pid = mysqli_fetch_assoc($result_pid)) {
                    $productIds[$Item_Name] = $row_pid['pid'];
                } else {
                    echo "<script>
                        alert('Failed to fetch pid for $Item_Name');
                        window.location.href='cart.php';
                    </script>";
                    exit;
                }
            }

            // Now, you have $Order_Id, $uid, and $productIds
           // print_r($productIds);
            // ... Continue with the remaining code

        } else {
            echo "<script>
                alert('Failed to execute the order_manager query');
                window.location.href='cart.php';
            </script>";
        }
    } else {
        echo "<script>
        alert('User not found');
        window.location.href='cart.php';
        </script>";
    }
}
?>
<?php
// ... (previous code)

// Insert order items
$query2 = "INSERT INTO `user_orders`(`Order_Id`, `Item_Name`, `Price`, `Quantity`,`uid`, `pid`) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query2);

if ($stmt) {
    foreach ($_SESSION['cart'] as $key => $values) {
        $Item_Name = mysqli_real_escape_string($conn, $values['Item_Name']);
        $Price = $values['Price'];
        $Quantity = $values['Quantity'];
        $pid = $productIds[$Item_Name];

        // Use 's' for strings, 'd' for double, and 'i' for integers
        mysqli_stmt_bind_param($stmt, "isdiii", $Order_Id, $Item_Name, $Price, $Quantity, $uid, $pid);
        mysqli_stmt_execute($stmt);

        if(mysqli_stmt_affected_rows($stmt) > 0) {
            echo "<script>
                console.log('Successfully inserted: $Item_Name');
            </script>";
        } else {
            $error_msg = mysqli_error($conn);
            echo "<script>
                console.error('Failed to insert: $Item_Name. Error: $error_msg');
            </script>";
        }
    }

    // Move unset outside the loop
    unset($_SESSION['cart']);

    echo "<script>
        alert('Order Placed');
        window.location.href='dashboard.php';
    </script>";
} else {
    echo "<script>
        alert('SQL Query Prepared Error');
        window.location.href='cart.php';
    </script>";
}
?>
