<?php

session_start();

include 'db_connect.php';

//--------ADD BALANCE TO CARD
if(isset($_POST["btnLoadCard"])) {
	$CardId = mysqli_real_escape_string($conn, $_POST['CardID']);
	$LoadAmt = mysqli_real_escape_string($conn, $_POST['LoadAmt']);
	
	$trans = mysqli_query($conn, "SELECT MAX(TransactionId) AS TransactionId FROM psngrloadrecords");
	$result = mysqli_fetch_array($trans);
	$TransactionId = (substr($result['TransactionId'], 1)) + 1;
	$TransId = "T" . str_pad($TransactionId,4,"0",STR_PAD_LEFT);

	$sql = "SELECT * 
	FROM card 
	WHERE CardId = '$CardId'";
	$result = mysqli_query($conn, $sql);
	while($res = mysqli_fetch_array($result)) {
		$cardtype = $res['CardTypeId'];
		$currCardBal = $res['CardBal'];
	}
	$count = mysqli_num_rows($result);

	if ($count > 0) {
	    if($cardtype == 1 || $cardtype == 2) {
	        include 'db_connect.php';
		    $sql2 = "UPDATE card 
		            SET CardBal = $currCardBal + '$LoadAmt'
                    WHERE CardId = '$CardId'";
		    if(mysqli_query($conn, $sql2)){
			    //-----CODE FOR ADDING A TRANSACTION RECORD
			    $AdminId = mysqli_real_escape_string($conn, $_SESSION["sesUname"]);
			    $sql3 = "INSERT INTO psngrloadrecords(TransactionId, CardId, Amount, AdminId, TransDate)
			            VALUES ('$TransId', '$CardId', '$LoadAmt', '$AdminId', now())";
			    mysqli_query($conn, $sql3);
			    
			    $_SESSION["sesSuccess"] = "P" . $LoadAmt . ".00 has been loaded to card ID " . $CardId . " successfully.";
		    	header("Location: page_loadcard.php");
		    }
		    else {
			    $_SESSION["sesError"] = "ERROR: " . mysqli_error($conn);
			    header("Location: page_loadcard.php");
		    }
	    }
	    else {
	        $_SESSION["sesError"] = "Invalid Card ID or Card ID belongs to a driver and is not permitted to be loaded. Please try again.";
		    header("Location: page_loadcard.php");
	    }
	}

	else {
		$_SESSION["sesError"] = "Invalid Card ID or Card ID belongs to a driver and is not permitted to be loaded. Please try again.";
		header("Location: page_loadcard.php");
	}
}


//admin details
if(isset($_POST["btnUpdateAdminDet"])) {
	$AdminId = mysqli_real_escape_string($conn, $_POST['AdminId']);
	$AdminName = mysqli_real_escape_string($conn, $_POST['AdminName']);
	$Contact = mysqli_real_escape_string($conn, $_POST['Contact']);
	$Birthday = mysqli_real_escape_string($conn, $_POST['Birthday']);
	$Address = mysqli_real_escape_string($conn, $_POST['Address']);
	$Station = mysqli_real_escape_string($conn, $_POST['Station']);

	//$sql = "CALL SP_UPDATE_ADMIN('" . $AdminId . "','" . $AdminName . "','" . $Contact . "','" . $Birthday . "','" . $Address . "','" . $Station . "');";
	$sql = "UPDATE adminaccount 
	SET AdminName = '$AdminName', ContactNo = '$Contact', Birthday = '$Birthday', Address = '$Address', StationId = '$Station'
	WHERE AdminId = '$AdminId'";
	if(mysqli_query($conn, $sql)){
		$_SESSION["sesSuccess"] = "Admin details update successful.";
		header("Location: page_admin.php");
	}
	else {
		$_SESSION["sesError"] = "ERROR: " . mysqli_error($conn);
		header("Location: page_admin.php");
	}

}



if(isset($_POST["btnTransIncome"])) {
	$CardId = mysqli_real_escape_string($conn, $_POST['DriverID']);
	$TransAmt = mysqli_real_escape_string($conn, $_POST['TransAmt']);

	$sql = "SELECT * 
	FROM card 
	WHERE CardId = '$CardId' AND CardBal > '$TransAmt' AND CardTypeId = '3'";
	$result = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($result);

	if ($count > 0) {
		include "db_connect.php";
		$subsql4 = "SELECT CardBal FROM card WHERE CardId = '$CardId'";
		$subsql4 = mysqli_fetch_row(mysqli_query($conn, $subsql4));
		$currCardBal = $subsql4[0];
		
		$sql4 = "UPDATE card 
		SET CardBal = $currCardBal - '$TransAmt'
		WHERE CardId = '$CardId'";
		if(mysqli_query($conn, $sql4)){
			//-------------TRANSCATION ADDITION CODE
			$AdminId = mysqli_real_escape_string($conn, $_SESSION["sesUname"]);
			$trans = mysqli_query($conn, "SELECT MAX(TransactionId) AS TransactionId FROM collectionrecords");
	        $result = mysqli_fetch_array($trans);
	        $TransactionId = (substr($result['TransactionId'], 1)) + 1;
	        $TransId = "T" . str_pad($TransactionId,4,"0",STR_PAD_LEFT);
	        
			include "db_connect.php";
			$sql5 = "INSERT INTO collectionrecords (TransactionId, CardId, Amount, AdminId, TransDate) 
			VALUES ('$TransId', '$CardId', '$TransAmt', '$AdminId', now())";
			mysqli_query($conn, $sql5);
			$_SESSION["sesSuccess"] = "P" . $TransAmt . ".00 was successfully deducted from the income of the driver with the card ID " . $CardId . ".";
			header("Location: page_drivercashout.php");
		}
		else {
			$_SESSION["sesError"] = "ERROR: " . mysqli_error($conn);
			header("Location: page_drivercashout.php");
		}	
	}
	else {
		$_SESSION["sesError"] = "Invalid Card ID or withdraw amount greater than current balance. Please try again.";
		header("Location: page_drivercashout.php");
	}
}



if(isset($_POST["btnUpdatePassenger"])) {
	$CardId = mysqli_real_escape_string($conn, $_POST['CardId']);
	$PassengerType = mysqli_real_escape_string($conn, $_POST['PassengerType']);

	//$sql = "CALL SP_UPDATE_PASSENGER('" . $CardId . "','" . $PassengerType . "');";
	$sql = "UPDATE card 
	SET CardTypeId = '$PassengerType' 
	WHERE CardId = '$CardId'";
	if(mysqli_query($conn, $sql)){
		$_SESSION["sesSuccess"] = "Passenger details update successful.";
		header("Location: page_carddetails.php");
	}
	else {
		$_SESSION["sesError"] = "ERROR: " . mysqli_error($conn);
		header("Location: page_carddetails.php");
	}
}



if(isset($_POST["btnUpdateDriver"])) {
	$DriverId = mysqli_real_escape_string($conn, $_POST['DriverId']);
	$CardId = mysqli_real_escape_string($conn, $_POST['CardId']);
	$JeepId = mysqli_real_escape_string($conn, $_POST['JeepId']);
	$Name = mysqli_real_escape_string($conn, $_POST['Name']);
	$Contact = mysqli_real_escape_string($conn, $_POST['Contact']);
	$Address = mysqli_real_escape_string($conn, $_POST['Address']);
	$License = mysqli_real_escape_string($conn, $_POST['License']);

	//$sql = "CALL SP_UPDATE_DRIVER('" . $DriverId . "','" . $CardId . "','" . $JeepId . "','" . $Name . "','" . $Contact . "','" . $Address . "','" . $License . "');";
	$sql = "UPDATE driver
	SET JeepId = '$JeepId', DrName = '$Name', ContactNo = '$Contact', Address = '$Address', LicenseId = '$License'
	WHERE CardId = '$CardId'";
	if(mysqli_query($conn, $sql)){
		$_SESSION["sesSuccess"] = "Driver details update successful.";
		header("Location: page_carddetails.php");
	}
	else {
		$_SESSION["sesError"] = "ERROR: " . mysqli_error($conn);
		header("Location: page_carddetails.php");
	}
}



if(isset($_POST["btnUpdateJeep"])) {
	$JeepId = mysqli_real_escape_string($conn, $_POST['JeepId']);
	$LicensePlate = mysqli_real_escape_string($conn, $_POST['LicensePlate']);

	$sql = "UPDATE jeep
	SET LicensePlate = '$LicensePlate'
	WHERE JeepId = '$JeepId'";
	if(mysqli_query($conn, $sql)){
		$_SESSION["sesSuccess"] = "Jeep details update successful.";
		header("Location: page_jeepdetails.php");
	}
	else {
		$_SESSION["sesError"] = "ERROR: " . mysqli_error($conn);
		header("Location: page_jeepdetails.php");
	}	
}



if(isset($_POST["btnChangePass"])) {
	$Username = mysqli_real_escape_string($conn, $_POST['txtUsername']);
	$Password = mysqli_real_escape_string($conn, $_POST['txtPassword']);

	//$sql = "CALL SP_VALIDATE_ADMIN('" . $Username . "');";
	$sql = "SELECT AdminId
	FROM adminaccount
	WHERE AdminId = '$Username'";
	$result = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($result);


	if($count > 0) {
		include 'db_connect.php';
		//$sql2 = "CALL SP_UPDATE_ADMINPASS('" . $Username . "','" . $Password . "');";
		$sql2 = "UPDATE adminaccount
		SET Passwordd = '$Password'
		WHERE AdminId = '$Username'";
		if(mysqli_query($conn, $sql2)){
			$_SESSION["sesSuccess"] = "Password update successful.";
			header("Location: index.php");
		}
		else {
			$_SESSION["sesError"] = "ERROR: " . mysqli_error($conn);
			header("Location: page_forgotpass.php");
		}
	}
	else {
		$_SESSION["sesError"] = "Admin ID is invalid. Please try again.";
		header("Location: page_forgotpass.php");
	}
}

?>
