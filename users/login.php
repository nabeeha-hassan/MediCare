<?php
session_start();
include('includes/config.php');

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $query = mysqli_query($bd, "SELECT * FROM users WHERE email='$email' AND password='$password'");
    $row = mysqli_fetch_array($query);

    if($row){
        $_SESSION['login'] = $row['email'];
        $_SESSION['id'] = $row['id'];

        header("location:index.php");
        exit();
    } else {
        echo "<script>alert('Invalid Email or Password');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
</head>
<body>

<h2>User Login</h2>

<form method="post">
    <input type="email" name="email" placeholder="Enter Email" required><br><br>
    <input type="password" name="password" placeholder="Enter Password" required><br><br>
    <button type="submit" name="login">Login</button>
</form>

</body>
</html>