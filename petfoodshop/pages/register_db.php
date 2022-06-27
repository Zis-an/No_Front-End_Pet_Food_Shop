<?php
require_once("db_con.php");
$db_handle = new DBController();
if(isset($_POST['register'])){
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$email=$_POST['email'];
	$contact=$_POST['contact'];
	$address=$_POST['address'];
	$psw=$_POST['psw'];
	$conpsw=$_POST['conpsw'];
	$password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
	if($psw == $conpsw){
		if(!preg_match($password_pattern, $psw)){
			echo '<script>alert("Password must contain alteast 8 character long, an uppercase letter, a lowercase letter and a number."); history.back();</script>';
		}else{
			$password_encrypted = password_hash($psw, PASSWORD_BCRYPT);
			$query="INSERT INTO users (first_name, last_name, email, contact_no, address, password)
				VALUES('{$fname}','{$lname}','{$email}','{$contact}','{$address}','{$password_encrypted}');";
			$user = $db_handle->registerUser($query);
			if($user){
				session_start();
				$_SESSION['user'] = $user;
				echo "<script>
						location.replace(\"user.php\");
					</script>";
			}else{
				echo "<script>
						alert('Failed to register user. Please try again with different email and/or contact number.');
						history.back();
					</script>";
			}
		}
	}else{
		echo '<script>alert("Password not matched"); history.back();</script>';
	}	
}else{
	echo '<script>alert("Failed to register user. Please try again."); history.back();</script>';
}

?>