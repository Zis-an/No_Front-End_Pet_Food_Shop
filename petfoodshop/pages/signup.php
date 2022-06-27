<?php
session_start();
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
    <form action="register_db.php" method="post">
            <input type="text" placeholder="First Name" name="fname" required>
            <input type="text" placeholder="Last Name" name="lname" required>
            <input type="email" placeholder="Enter Email" name="email" required>
            <input type="text" placeholder="Enter Contact No" name="contact" required>
            <input type="text" placeholder="Enter Address" name="address" required>
            <input type="password" placeholder="Enter Password" name="psw" required>
            <input type="password" placeholder="Confirm Password" name="conpsw" required>
            <button type="submit" name="register">Sign Up</button>
            <br>
            <small><a href="login.php">Already a member?</a></small>
    </form>
</div>
</body>
</html>