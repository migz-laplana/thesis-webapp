<?php
	session_start();
	include 'db_connect.php';

	if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form

		$username = $_POST['txtUsername'];
      	$password = $_POST['txtPassword'];

		//$sql = "SELECT * FROM tblusers WHERE strUsername = '$myusername' and strPassword = '$mypassword'";
      	//$sql = "CALL SP_GET_ADMIN_LOGIN('" . $username . "','" . $password . "','1');";

      	$sql = "SELECT * 
      			FROM adminaccount 
      			WHERE AdminId = '$username' && Passwordd = '$password'";
      			
      	$sql2 = "SELECT * 
      			FROM card 
      			WHERE CardId = '$username' && pass = '$password'";

		$result = mysqli_query($conn,$sql);
		$count = mysqli_num_rows($result);
		
		$result2 = mysqli_query($conn,$sql2);
		$count2 = mysqli_num_rows($result2);

      	// If result matched $myusername and $mypassword, table row must be 1 row
		if($count > 0) {
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$_SESSION["sesUname"] = $username;
			$_SESSION["sesName"] = $row['AdminName'];
			$_SESSION["sesContactNo"] = $row['ContactNo'];
			$_SESSION["sesBirthday"] = $row['Birthday'];
			$_SESSION["sesAddress"] = $row['Address'];
			$_SESSION["sesStationId"] = $row['StationId'];
			header("location:page_home.php");
		}
		else if($count2 > 0) {     //if the person is a passenger/driver
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$_SESSION["sesUname"] = $username;
			//$_SESSION["sesName"] = $row['AdminName'];
			//$_SESSION["sesContactNo"] = $row['ContactNo'];
			//$_SESSION["sesBirthday"] = $row['Birthday'];
			//$_SESSION["sesAddress"] = $row['Address'];
			//$_SESSION["sesStationId"] = $row['StationId'];
			header("location:page_home_notAdmin.php");
		}
		
		
		
		
		
		else {
			$_SESSION["sesError"] = "Your username or password is invalid.";
			header("Location: index.php");
		}
	}
?>
