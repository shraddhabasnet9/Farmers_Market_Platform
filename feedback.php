
<?php

// Create connection
$conn = new mysqli("localhost", "root", "", "fmp_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    // Escape user inputs to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $comments = mysqli_real_escape_string($conn, $_POST['comments']);


    // Fetch UID from the users table based on the provided email
    $sql_fetch_uid = "SELECT uid FROM user_login WHERE email = '$email' AND name='$name'";
    $result = $conn->query($sql_fetch_uid);

    if ($result->num_rows > 0) {
        // Assuming that there is only one user with the provided email (unique email constraint)
        $row = $result->fetch_assoc();
        $uid = $row['uid'];

        // Insert feedback into the feedback table along with the fetched UID
        $sql_insert_feedback = "INSERT INTO feedback (uid, name, email, comments) VALUES ('$uid', '$name', '$email', '$comments')";

        if ($conn->query($sql_insert_feedback) === TRUE) {
            echo "<script>alert('Feedback is stored in the table successfully')</script>";
            echo "<script>window.open('dashboard.php','_self')</script>";
        } else {
            echo "<script>alert('Error posting values:')</script> " . $conn->error;
            echo "<script>window.open('dashboard.php','_self')</script>";
        }
    } else {
        echo "<script>alert('user and email address provided doesnot match.')</script>";
        echo "<script>window.open('dashboard.php','_self')</script>";
    }
$conn->close();

?>
