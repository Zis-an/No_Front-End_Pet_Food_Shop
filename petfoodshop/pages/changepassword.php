<?php
    session_start();
    if(!isset($_SESSION['user']))
        echo("<script type='text/javascript'>
            location.replace(\"login.php\");
        </script>");
    require_once("db_con.php");
    $db_handle = new DBController();
    $id = $_SESSION['user'];
    $query="SELECT * FROM users where id='{$id}'";
    $result = $db_handle->runQuery($query);
    if(!isset($result[0]) && !empty(!isset($result[0]))){
        unset($_SESSION['user']);
        echo("<script type='text/javascript'>
            location.replace(\"login.php\");
        </script>"); 
    }
    else
        $result = $result[0];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Website</title>
    <link rel="icon" href="../img/logo.jpg">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

        <div class="user-container">

        <form action="update_password_db.php" method="post">
                <input type="password" placeholder="Enter Password" name="psw" required>
                <input type="password" placeholder="Retype Password" name="conpsw" required>
                <button type="submit" name="update">Update Password</button>
                <br>
        </form>
    </div>


</body>
</html>