<?php
session_start();
require("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        if (!isset($_SESSION['uid'])) {
            echo "<script>
                alert('Login First');
                window.location.href='login.php';
            </script>";
            exit();
        }

        $item_name = $_POST['Item_Name'];
        $price = $_POST['Price'];

        // Fetch product details (pid and quantity) from the database
        $sql_fetch_product = "SELECT pid, quantity FROM products WHERE name = ?";
        $stmt = $conn->prepare($sql_fetch_product);
        $stmt->bind_param('s', $item_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $pid = $row['pid'];
            $available_quantity = $row['quantity'];

            if ($available_quantity > 0) {
                // Proceed if there is enough quantity
                if (isset($_SESSION['cart'])) {
                    $myitems = array_column($_SESSION['cart'], 'Item_Name');
                    if (in_array($item_name, $myitems)) {
                        echo "<script>
                            alert('Item Already Added');
                            window.location.href='product.php';
                        </script>";
                    } else {
                        $count = count($_SESSION['cart']);
                        $_SESSION['cart'][$count] = array('Item_Name' => $item_name, 'Price' => $price, 'Quantity' => 1, 'pid' => $pid);

                        // Decrement the quantity in the database
                        $new_quantity = $available_quantity - 1;
                        $update_sql = "UPDATE products SET quantity = ? WHERE pid = ?";
                        $update_stmt = $conn->prepare($update_sql);
                        $update_stmt->bind_param('ii', $new_quantity, $pid);
                        $update_stmt->execute();

                        echo "<script>
                            alert('Item Added. Remaining Quantity: $new_quantity');
                            window.location.href='product.php';
                        </script>";
                    }
                } else {
                    $_SESSION['cart'][0] = array('Item_Name' => $item_name, 'Price' => $price, 'Quantity' => 1, 'pid' => $pid);

                    // Decrement the quantity in the database
                    $new_quantity = $available_quantity - 1;
                    $update_sql = "UPDATE products SET quantity = ? WHERE pid = ?";
                    $update_stmt = $conn->prepare($update_sql);
                    $update_stmt->bind_param('ii', $new_quantity, $pid);
                    $update_stmt->execute();

                    echo "<script>
                        alert('Item Added. Remaining Quantity: $new_quantity');
                        window.location.href='product.php';
                    </script>";
                }

            } else {
                // If no stock is available
                echo "<script>
                    alert('Out of stock');
                    window.location.href='product.php';
                </script>";
            }

        } else {
            echo "<script>
                alert('Product not found');
                window.location.href='product.php';
            </script>";
        }
    }
    // Remove item from cart logic
    if (isset($_POST['Remove_Item'])) {
        foreach ($_SESSION['cart'] as $key => $value) {
            if ($value['Item_Name'] == $_POST['Item_Name']) {
                // Restore the product quantity in the database when an item is removed
                $pid = $value['pid'];
                
                // Fetch current quantity
                $fetch_quantity_sql = "SELECT quantity FROM products WHERE pid = ?";
                $stmt = $conn->prepare($fetch_quantity_sql);
                $stmt->bind_param('i', $pid);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $current_quantity = $row['quantity'];

                // Increase the quantity in the database
                $new_quantity = $current_quantity + $value['Quantity'];
                $update_sql = "UPDATE products SET quantity = ? WHERE pid = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param('ii', $new_quantity, $pid);
                $update_stmt->execute();

                // Remove the item from the session cart
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);

                echo "<script>
                    alert('Item removed from cart. Quantity Restored: $new_quantity');
                    window.location.href='cart.php';
                </script>";
            }
        }
    }
}
?>
