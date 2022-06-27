<?php
session_start();
echo(isset($_SESSION['user']));
if(isset($_SESSION['user']))
    echo("<script type='text/javascript'>
        location.replace(\"user.php\");
    </script>");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Website</title>
    <link rel="icon" href="../img/logo.jpg">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>
<body>

    <div class="topnav">
        <a href="aboutus.php">About Us</a>
        <a href="feedback.php">Feedback</a>
        <a href="cart.php">Cart</a>
        <a href="login.php">User Profile</a>
        <a href="product.php">Product</a>
        <a href="index.php" style="float: left; font-weight: bold; margin-left: 20px; font-size: 20px;">PetCart</a>
    </div>
    <div class="form-container">
    <form action="login_db.php" method="post">

            <input type="email" placeholder="Enter Email" name="email" required>
            <br>
            <input type="password" placeholder="Enter Password" name="psw" required>
            <button type="submit" name="signin">Login</button>
            <br>
            <small><a href="signup.php">Not a member yet?</a></small>
    </form>
    <div>
</body>
</html>
