<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php 
	session_start();
	include 'styles.php';
	include 'script.php';
	include 'modal.php';
	?>
</head>

<body class="bgloginpage">
	<div class="left">
		<img src="IMG_0238.JPG" class="jeep">
	</div>
	<div class="bodylogin">
		<div class="loginform">
			<text class="loginpage">PUJ Payment Assistant System</text><br><br>
			<form action="db_login.php" method="post">
				<div>
					<input type="text" class="login" name="txtUsername" id="txtUsername" placeholder="Username" required="required">
				</div>
				<div>
					<input type="password" class="login" name="txtPassword" id="txtPassword" placeholder="Password" required="required">
				</div><br>
				
				<input type="submit" class="login" value="Log in"><br>
				<!--<a href="page_forgotpass.php" class="forgotpass">Forgot Password?</a>-->

			</form>
		</div>
	</div>
	
</body>
</html>