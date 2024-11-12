<?php
require("conn.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// primary validate function
	function validate($str) {
		return trim(htmlspecialchars($str));
	}
    $nameError = $emailError = $passwordError = $confirmError = $phoneError = "";
    $name = $email = $password = $confirm = $phone = "";
//validating name
	if (empty($_POST['name'])) {
		$nameError = 'Name should be filled';
	} 
    else {

		$name = validate($_POST['name']);
		if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
			$nameError = 'Name can only contain letters, and white spaces';
		}
	}
//validating email
	if (empty($_POST['email'])) {
		$emailError = 'Please enter your email';
	} 
    else {
		$email = validate($_POST['email']);
        if(!preg_match(' /^[a-zA-Z][A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i', $email)) {
		//if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailError = 'Invalid Email';
		}
	}
//validating password
	if (empty($_POST['password'])) {
		$passwordError = 'Password cannot be empty';
	} 
    else {
		$password = validate($_POST['password']);
		if (strlen($password) < 6) {
			$passwordError = 'Please should be longer than 6 characters';
		}
    }
//validating password retype
    if (empty($_POST['confirm'])) {
        $confirmError = 'Please retype your password';
    } else {
        $confirm = validate($_POST['confirm']);
        if ($password !== $confirm) {
            $confirmError = 'Passwords do not match';
        }
    }

    // Validating phone number
    if (empty($_POST['phone'])) {
		$phoneError = 'Phone number must be filled';
    }
    else {
		$phone = validate($_POST['phone']);
        if(!preg_match('/^(?:\+977|0)?[1-9]\d{9}$/',$phone)){
       // if(!preg_match('/^[0-9]{10}+$/', $phone)) {
            $phoneError=" Invalid Phone Number";
        }
    }

    // If there are no errors, proceed with database insertion
    if (empty($nameError) && empty($emailError) && empty($passwordError) && empty($confirmError) && empty($phoneError)) {
    //     echo "Form should be filled ";
    // }else{
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        // Insert into database
        $sql = "INSERT INTO user_login (name, email, password, phone) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email,$hashedPassword, $phone);
        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            echo 'Error: ' . $conn->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register here</title>
    <link rel="stylesheet" href="register.css"/>
    <script>
    //     function validateForm() {
    //         let valid = true;

    //         // Clear previous errors
    //         document.querySelectorAll('.error').forEach(el => el.textContent = '');

    //         // Validate name
    //         let name = document.forms["registerForm"]["name"].value;
    //         if (name == "") {
    //             document.getElementById('nameError').textContent = "Name should be filled";
    //             valid = false;
    //         } else if (!/^[a-zA-Z\s]+$/.test(name)) {
    //             document.getElementById('nameError').textContent = "Name can only contain letters and white spaces";
    //             valid = false;
    //         }

    //         // Validate email
    //         let email = document.forms["registerForm"]["email"].value;
    //         if (email == "") {
    //             document.getElementById('emailError').textContent = "Please enter your email";
    //             valid = false;
    //         } else if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/.test(email)) {
    //             document.getElementById('emailError').textContent = "Invalid Email";
    //             valid = false;
    //         }

    //         // Validate password
    //         let password = document.forms["registerForm"]["password"].value;
    //         if (password == "") {
    //             document.getElementById('passwordError').textContent = "Password cannot be empty";
    //             valid = false;
    //         } else if (password.length < 6) {
    //             document.getElementById('passwordError').textContent = "Password should be longer than 6 characters";
    //             valid = false;
    //         }

    //         // Validate confirm password
    //         let confirm = document.forms["registerForm"]["confirm"].value;
    //         if (confirm == "") {
    //             document.getElementById('confirmError').textContent = "Please retype your password";
    //             valid = false;
    //         } else if (password !== confirm) {
    //             document.getElementById('confirmError').textContent = "Passwords do not match";
    //             valid = false;
    //         }

    //         // Validate phone number
    //         let phone = document.forms["registerForm"]["phone"].value;
    //         if (phone == "") {
    //             document.getElementById('phoneError').textContent = "Phone number must be filled";
    //             valid = false;
    //         } else if (!/^[0-9]{10}$/.test(phone)) {
    //             document.getElementById('phoneError').textContent = "Invalid Phone Number";
    //             valid = false;
    //         }

    //         return valid;
    //     }
    // </script>
</head>
<body>
    <div class="container">
        <form name="registerForm" method="POST" class="form" action="" onsubmit="return validateForm()">
            <h1>Register Here</h1>
            <label>User Name:
                <input type="text" name="name" value="<?php if (isset($name)) echo $name ?>">
                <span class="error" id="nameError"><?php if (isset($nameError)) echo $nameError ?></span><br>
            </label>
            <label>Phone Number:
                <input type="number" name="phone" value="<?php if (isset($phone)) echo $phone ?>">
                <span class="error" id="phoneError"><?php if (isset($phoneError)) echo $phoneError ?></span><br>
            </label>
            <label>Email:
                <input type="email" name="email" value="<?php if (isset($email)) echo $email ?>"> 
                <span class="error" id="emailError"><?php if (isset($emailError)) echo $emailError ?></span><br>
            </label>
            <label>Password:
                <input type="password" name="password" value="<?php if (isset($password)) echo $password ?>">                     
                <span class="error" id="passwordError"><?php if (isset($passwordError)) echo $passwordError ?></span><br>
            </label>
            <label>Confirm Password:
                <input type="password" name="confirm" value="<?php if (isset($confirm)) echo $confirm ?>"> 
                <span class="error" id="confirmError"><?php if (isset($confirmError)) echo $confirmError ?></span><br>
            </label>
            <label>
                <button type="submit" name="reg_user">Register</button>
            </label>
            <label>
                <p>Already registered? <a href="login.php">Sign in</a></p>
            </label>
        </form>
    </div>
</body>
</html>
