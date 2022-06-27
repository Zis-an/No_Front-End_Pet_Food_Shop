<?php
require_once("db_con.php");
$db_handle = new DBController();
session_start();

if(isset($_POST['update'])){
	$password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
	$psw=$_POST['psw'];
	$conpsw=$_POST['conpsw'];
	$id=$_SESSION['user'];
	if($psw == $conpsw){
		if(!preg_match($password_pattern, $psw)){
			echo '<script>alert("Password must contain alteast 8 character long, an uppercase letter, a lowercase letter and a number."); history.back();</script>';
		}else{
			$password_encrypted = password_hash($psw, PASSWORD_BCRYPT);
			$query="UPDATE `users` SET `password` = '{$password_encrypted}' WHERE `users`.`id` = '{$id}';";
			$user = $db_handle->updateQuery($query);
			if($user){
				echo "<script>
						alert('Password changed successfully.');
						location.replace(\"user.php\");
					</script>";
			}else{
				echo "<script>
						alert('Failed to update password. Please Try again.');
						history.back();
					</script>";
			}
		}
	}else{
		echo '<script>alert("Password not matched"); history.back();</script>';
	}
}else{
	echo '<script>alert("Failed to update password. Please Try again."); history.back();</script>';
}

?>