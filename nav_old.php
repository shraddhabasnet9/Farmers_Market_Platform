<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmers Market Platform</title>
    <link rel="stylesheet" href="nav_old.css"/>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
</head>
<body>
    <div id="navbar">
        <!-- Menu Toggle Button for Small Screens -->
        <button id="menu-toggle" class="btn btn-primary d-lg-none">
            <i class="fas fa-bars"></i>
        </button>
        
        <div id="logo">
            <img src="logo.png" alt="FarmersMarket.com">
        </div>
        
        <!-- Navbar Content -->
        <div id="navbar-content">
            <ul>
                <li class="item"><a href="dashboard.php">Home</a></li>
                <li class="item"><a href="product.php">Products</a></li>
                <li class="item"><a href="feedback.html">Feedback</a></li>
                <li><a href="cart.php">Cart <i class="fa fa-shopping-cart"></i></a></li>
            </ul>
            
            <div class="search-container">
                <form action="search.php" method="post">
                    <input type="text" class="search-box" name="searchitem" placeholder="Search products..."/>
                    <input class="btn btn-outline-success" name="sbtn" type="submit" value="Search"/>
                </form>
            </div>
            
            <ul class="profile">
                <li class="item"><a href="login.php">Login</a></li>
                <li class="item"><a href="register.php">Register</a></li>
                <li class="item"><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
    
    <!-- Optional JavaScript -->
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            const navbarContent = document.getElementById('navbar-content');
            navbarContent.classList.toggle('active');
        });
    </script>
</body>
</html>