<?php
require_once("db_con.php");
$db_handle = new DBController();
if(isset($_POST['signin'])){
	$email=$_POST['email'];
	$psw=$_POST['psw'];
	$query="SELECT * FROM users WHERE email='{$email}';";
	$user = $db_handle->runQuery($query);
	if((isset($user) && isset($user[0])) && !empty($user[0])){
		
	echo(password_verify($psw, $user[0]['password']));
		if(password_verify($psw, $user[0]['password'])){
			session_start();
			$_SESSION['user'] = $user[0]['id'];
			echo "<script>
				location.replace(\"user.php\");
			</script>";
		}else{
			echo "<script>
					alert('Invalid password.');
					history.back();
				</script>";
		}
	}else{
		echo "<script>
				alert('Invalid email.');
				history.back();
			</script>";
	}
}else{
	echo '<script>alert("Failed to login user. Please Try again."); history.back();</script>';
}

?>