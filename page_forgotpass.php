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
			<text class="loginpage">Password Forgotten</text><br><br>
			<form action="db_update.php" method="post">
				<div class="label"> Enter your username <text class="textlorange">*</text> <br>
 					<input type="text" class="login" name="txtUsername" id="txtUsername" placeholder="Username" required="required">
				</div><br>
				<div class="label"> Enter your new password (6 characters min) <text class="textlorange">*</text> <br>
					<input type="password" minlength="6" maxlength="25" class="login" name="txtPassword" id="txtPassword" placeholder="Password" required="required">
				</div>
				<div class="label"> Confirm password <text class="textlorange">*</text> <br>
					<input type="password" minlength="6" maxlength="25" class="login" name="ConfirmPass" id="ConfirmPass" placeholder="Confirm Password" required="required">
				</div>
				<div id="message"></div>
				<br>
				
				<input type="submit" class="login" name="btnChangePass" id="btnChangePass" value="Change Password"><br>
				<a href="index.php" class="label"> << BACK</a>

			</form>
		</div>
	</div>
	
</body>
</html>

<script type="text/javascript">
	$('#txtPassword, #ConfirmPass').on('keyup', function () {
		if (($('#txtPassword').val() == $('#ConfirmPass').val())) {
			$('#message').html('Passwords matched.').css('color', 'green');
			$('#btnChangePass').prop('disabled', false);
		} 
		else if (($('#txtPassword').val().length == 0 )) {
			$('#message').html('Password cannot be empty.').css('color', 'red');
			$('#btnChangePass').prop('disabled', true);
		}
		else {
			$('#message').html('Passwords do not match.').css('color', 'red');
			$('#btnChangePass').prop('disabled', true);
		}
	});
</script>

