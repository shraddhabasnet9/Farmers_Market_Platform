
<?php
session_start();

//initializing variables
$name="";
$email="";
$errors=array();

//connect to the database
$db=mysqli_connect('localhost','root','','productss');
error_reporting(E_ALL);
ini_set('display_errors', 1);

//Register user
if(isset($_POST['reg_user'])){

    //receive inputs from form
    $name=mysqli_real_escape_string($db,$_POST['name']);
    $email=mysqli_real_escape_string($db,$_POST['email']);
    $phone=mysqli_real_escape_string($db,$_POST['phone']);
    $password=mysqli_real_escape_string($db,$_POST['password']);
    $confirm =mysqli_real_escape_string($db,$_POST['confirm']);
    
    //form validation
    /*if(empty($name)){ array_push($errors,"username is required"); }
    if(empty($email)){ array_push($errors,"email is required"); }
    if(empty($phone)){ array_push($errors,"phone no. is required"); }
    if(empty($password)){ array_push($errors,"password is required"); }
    if($password != $confirm){
        array_push($errors,"The two passwords donot match");
    }*/
    //check if the user already exist or not
    $user_check_query="SELECT * FROM user_login WHERE name='$name' OR email='$email' LIMIT 1";
    $result=mysqli_query($db,$user_check_query);
    $user=mysqli_fetch_assoc($result);

    //if user exists
    if($user){
        if($user['name']===$name){
            array_push($errors,"Username already exists");
        }
        if($user['email']===$email){
            array_push($errors,"Email already exists");
        }
    }
    //register user if no error found
    if(count($errors)==0){
        $password=md5($password);//encrypt the password before saving in db
        $query = "INSERT INTO user_login (name, phone, email, password) VALUES ('$name', '$phone', '$email', '$password')"; 
        mysqli_query($db,$query);
        $_SESSION['name']=$name;
        $_SESSION['success']="You are now successfully registered ";
        header('location: login.php');
    }
}
//login user
if(isset($_POST['login_user'])){
    $email=mysqli_real_escape_string($db,$_POST['email']);
    $password=mysqli_real_escape_string($db,$_POST['password']);

    if(empty($email)){ 
        array_push($errors,"username is required"); }

    if(empty($password)){ 
        array_push($errors,"password is required"); }

    if(count($errors)==0){
        $password=md5($password);
        $query="SELECT * FROM user_login WHERE email='$email' AND password='$password'";
        $results=mysqli_query($db,$query);
        if(mysqli_num_rows($results)==1){
            $data=mysqli_fetch_assoc($results);
            $_SESSION['uid']=$data['uid'];
            $_SESSION['success']="You are now successfully logged in";
            header("Location:dashboard.php");
            exit;
        }
        else{
            array_push($errors,"Wrong username/password combination");
        }
    }
}
?>