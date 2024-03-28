<?php
require 'config/config.php';

$username = "";
$password = "";

if(isset($_POST['signin'])){
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$_SESSION['username'] = $username;
	
	$check_database_query = mysqli_query($con, "SELECT * FROM users WHERE email = '$username' AND password = '$password'");
	$check_login_query = mysqli_num_rows($check_database_query);
	
	if($check_login_query == 1){
		$row = mysqli_fetch_array($check_database_query);
        $username = $row['username'];
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
	}
}
?>

<!DOCTYPE html>
<html lang = "en">
<head>
	<link rel="stylesheet" href="style.css">
	<title>To-do List</title>
</head>
<body>
	<div class = "loginform">
		<img src="todolist.jpg" alt="ToDoListPhoto" class="forphoto">
	<form action="login.php" method="POST">
		<br>
		<input type="text" name="username" placeholder="Username" style="display:block; margin : 0 auto;" value ="
			<?php
				if(isset($_SESSION['username'])){
					echo $_SESSION['username'];
				}
			?>
		">
		<br>
		<input type="password" name="password" placeholder="Password" style="display:block; margin : 0 auto;">
		<br>
		<div class = "buttonsCenter">
			<input type="submit" name="signin" value="Log In">
			<input type="submit" name="signup" value="Sign Up">
		</div>
	</form>
	</div>
</body>
</html>