<?php 
session_start();
include('conn.php');

$error = '';

if(isset($_POST['login_user'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate user input to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $email);

    // Use prepared statement to securely fetch user details
    $sql = "SELECT * FROM user_login WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($result)){
        // Verify hashed password
        if(password_verify($password, $row['password'])){
            $_SESSION['uid'] = $row['uid'];
            header('Location: Dashboard.php');
            exit();
        } else {
            $error = "Incorrect password";
        }
    } else {
        $error = "User not found";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="box">
        <h1>Login Form</h1>
        <form method="post" name="myform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateform();">
            <div id="username">
                <p class="formerror"><?php if(isset($error)) echo $error ?></p>
                <label for="email">UserName</label>
                <input type="text" name="email" id="email" value="<?php if(isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>">
                <p class="formerror"></p>
            </div>
            <br>
            <div id="password">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
                <p class="formerror"></p>
            </div>
            <div id='button'>
                <button type="submit" class="btn" name="login_user">Login</button>
            </div>
            <br>
            <div>
                <label>Not registered yet? <a href="register.php">Sign up</a></label>
            </div>
        </form>
    </div>

    <script>
        function seterror(id, error) {
            var ele = document.getElementById(id);
            ele.getElementsByClassName("formerror")[0].innerHTML = error;
        }

        function clearerr() {
            errors = document.getElementsByClassName('formerror');
            for (let item of errors) {
                item.innerHTML = "";
            }
        }

        function validateform() {
            var returnval = true;
            clearerr();
            var email = document.forms['myform']['email'].value;
            var pass = document.forms['myform']['password'].value;
            if (email == "") {
                seterror("username", "Enter your email");
                returnval = false;
            }
            if (pass == "") {
                seterror("password", "Enter your password");
                returnval = false;
            }
            return returnval;
        }

        function clearError(id) {
            seterror(id, '');
        }

        document.forms['myform']['email'].addEventListener('input', function() {
            clearError('username');
        });

        document.forms['myform']['password'].addEventListener('input', function() {
            clearError('password');
        });
    </script>
</body>
</html>
