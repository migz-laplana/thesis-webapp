<!DOCTYPE html>
<html lang="en">
<head>
	<title>Home</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php
	include 'session.php';
	include 'styles.php';
	include 'script.php';
	include 'modal.php';
	?>

</head>

<body class="bgbody">
	<?php include 'header.php';
	include 'db_connect.php';
	//$sql = mysqli_query($conn, "CALL SP_GET_ADMIN_LOGIN('" . $_SESSION["sesUname"] . "','" . $_SESSION["sesContactNo"] .  "','2')");
	$AdminId = mysqli_real_escape_string($conn, $_SESSION["sesUname"]);
	$sql = "SELECT *
	FROM adminaccount
	WHERE AdminId = '$AdminId'";
	$sql = mysqli_query($conn, $sql);
	while($result = mysqli_fetch_array($sql)) {
		$AdminName = $result['AdminName'];
	}
	?>

	<div class="bodymain"><br><br><br>
		<center>
			<text class="hello-admin">Hello, Admin <?php echo $AdminName; ?>!</text><br>
			<text class="subtitle">Welcome to the PUJ Payment System. What do you want to do here?</text><hr><br>
			<img src="IMG_jeep.JPG" class="jeep-home">
			<br><br>
		</center>
		
		 FOR TESTING
    	<form action="fromRPI.php" method="post">
    	    <input type="text" name="driverid" id="driverid" placeholder="Driver ID" required="required">
    	    <input type="text" name="rfid" id="rfid" placeholder="RFID ID" required="required">
    	    <input type="text" name="lat1" id="lat1" placeholder="lat 1" required="required">
    	    <input type="text" name="long1" id="long1" placeholder="long 1" required="required">
    	    <input type="text" name="lat2" id="lat2" placeholder="lat 2" required="required">
    	    <input type="text" name="long2" id="long2" placeholder="long 2" required="required">
    	    
    	    <input type="submit" value="send"><br>
    	</form> 
    	
	</div>
	
</body>

<!-- JAVASCRIPT -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#home').empty();
		$('#home').append('<a class="active" href="page_home.php">Home</a>');
	});
</script>