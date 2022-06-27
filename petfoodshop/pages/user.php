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
    <link rel="stylesheet" type="text/css" href="../css/user.css">
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
            <div style="display: flex; border-radius: 5px; border: 3px solid #519259; padding: 10px; justify-content:center; align-items:flex-start; flex-direction:column; background-color: #7CD1B8; text-align: left;">
                <div style="display:flex; padding: 3px;">
                    <div style="margin: 3px 0px; user-select: none;"><h3>Name:</h3></div>
                    <div style="margin-left: 5px;  user-select: none; padding:5px; border-radius: 5px;"><p><?php echo $result["first_name"]." ".$result["last_name"] ?></p></div>
                </div>
                <div style="display:flex; padding: 3px; ">
                    <div style="margin: 3px 0px;  user-select: none;"><h3>Email:</h3></div>
                    <div style="margin-left: 5px;  user-select: none; padding:5px; border-radius: 5px;"><p><?php echo $result["email"] ?></p></div>
                </div>
                <div style="display:flex; padding: 3px;">
                    <div style="margin: 3px 0px;  user-select: none;"><h3>Contact No:</h3></div>
                    <div style="margin-left: 5px;  user-select: none; padding:5px; border-radius: 5px;"><p><?php echo $result["contact_no"] ?></p></div>
                </div>
                <div style="display:flex; padding: 3px;">
                    <div style="margin: 3px 0px;  user-select: none;"><h3>Address:</h3></div>
                    <div style="margin-left: 5px;  user-select: none; padding:5px; border-radius: 5px;"><p><?php echo $result["address"] ?></p></div>
                </div>
                <div style="display:flex;justify-content: center; width:100%">
                    <button style="margin-right: 5px;" onclick="logout()">Logout</button>
                    <button onclick="edit()">Edit Profile</button>
                </div>
            </div>
        </div>

    <script>
        function logout() {
                $.post('logout.php', function(response){
                    console.log(response);
                    location.replace("login.php");
                });
        }
        function edit() {
            window.location.href = "editprofile.php";
        }
    </script>


</body>
</html>