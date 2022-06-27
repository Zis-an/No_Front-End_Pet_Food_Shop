<?php
require_once("db_con.php");
$db_handle = new DBController();
session_start();
if(isset($_POST['update'])){
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$email=$_POST['email'];
	$contact=$_POST['contact'];
	$address=$_POST['address'];
	$id=$_SESSION['user'];
	
	$query="UPDATE `users` SET `first_name` = '{$fname}', `last_name` = '{$lname}', `email` = '{$email}', `contact_no` = '{$contact}', `address` = '{$address}' WHERE `users`.`id` = '{$id}';";
	$user = $db_handle->updateQuery($query);
	if($user){
		echo "<script>
				alert('Profile updated successfully.');
				location.replace(\"user.php\");
			</script>";
	}else{
		echo "<script>
				alert('Failed to update user. Please Try again with different email and/or contact number.');
				history.back();
			</script>";
	}
}else{
	echo '<script>alert("Failed to update user. Please Try again."); history.back();</script>';
}

?>