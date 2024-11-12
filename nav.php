<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>


    <title>navbar</title>
</head>
<body>
    <nav>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fa fa-bars"></i>
        </label>
        <img src="logo.png" class="hello">
        <ul>
            <li><a class="active"href="dashboard.php">Home</a></li>
           <li><a href="#">About us</a></li>
            <li><a href="product.php">Products</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li>
                <form action="search.php" method="post">
                    <input type="text" class="search-box" name="searchitem" placeholder="Search products...">
                    <button class="btn btn-outline-success" name="sbtn" type="submit" value="click">Search</button>
                </form>
                </li>
            <li><a href="login.php">login</a></li>
            <li><a href="logout.php">logout</a></li>
        </ul>
    </nav>
</body>
</html>