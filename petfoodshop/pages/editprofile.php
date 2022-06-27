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

    <form action="update_db.php" method="post">
            <input type="text" placeholder="First Name" name="fname" value= "<?php echo $result["first_name"] ?>" required>
            <input type="text" placeholder="Last Name" name="lname" value= "<?php echo $result["last_name"] ?>" required>
            <input type="email" placeholder="Enter Email" name="email" value= "<?php echo $result["email"] ?>" required>
            <input type="text" placeholder="Enter Contact No" name="contact" value= "<?php echo $result["contact_no"] ?>" required>
            <input type="text" placeholder="Enter Address" name="address" value= "<?php echo $result["address"] ?>" required>
            <button type="submit" name="update">Update</button>
            <button type="button" onclick="changePassword()">Change Password</button>
            <br>
    </form>
        </div>

    <script>
        function changePassword() {
            location.replace("changepassword.php");
        }
    </script>


</body>
</html>