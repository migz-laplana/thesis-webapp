<?php

session_start();

include 'db_connect.php';

if(isset($_POST["btnRegisterPassenger"])) {
	$CardID = mysqli_real_escape_string($conn, $_POST['CardID']);
	$RfidId = mysqli_real_escape_string($conn, $_POST['RfidId']);
	$PsgrType = mysqli_real_escape_string($conn, $_POST['PassengerType']);
	$Balance = mysqli_real_escape_string($conn, $_POST['Balance']);

	$sql = "INSERT INTO card (CardId, RfidId, pass, CardBal, CardTypeId, RegDate) 
	VALUES ('$CardID', '$RfidId', '$RfidId', '$Balance', '$PsgrType', now())";

	if(mysqli_query($conn, $sql)){
		//-----CODE FOR ADDING A TRANSACTION RECORD
	    $sql = mysqli_query($conn, "SELECT MAX(TransactionId) AS TransactionId FROM cardregrecords");
	    $result = mysqli_fetch_array($sql);
	    $TransactionId = (substr($result['TransactionId'], 1)) + 1;
	    $TransId = "T" . str_pad($TransactionId,4,"0",STR_PAD_LEFT);
		$AdminId = mysqli_real_escape_string($conn, $_SESSION["sesUname"]);
		
		include "db_connect.php";
		$sql2 = "INSERT INTO cardregrecords (TransactionId, CardId, CardTypeId, InitialBal, AdminId, RegDate) 
		VALUES ('$TransId', '$CardID', '$PsgrType', '$Balance', '$AdminId', now())";
		mysqli_query($conn, $sql2);

        if($PsgrType == 1) {
            $_SESSION["sesSuccess"] = "Regular passenger registration successful.";
        }
        else if($PsgrType == 2) {
             $_SESSION["sesSuccess"] = "Discounted passenger registration successful.";
        }
		header("Location: page_registercard.php");
	}
	else{
		$_SESSION["sesError"] = "ERROR: " . mysqli_error($conn);
		header("Location: page_registercard.php");
	}
}


if(isset($_POST["btnRegisterDriver"])) {
	$CardID = mysqli_real_escape_string($conn, $_POST['CardID']);
	$RfidId = mysqli_real_escape_string($conn, $_POST['RfidId']);
	$DriverID = mysqli_real_escape_string($conn, $_POST['DriverID']);
	$JeepID = mysqli_real_escape_string($conn, $_POST['JeepID']);
	$Name = mysqli_real_escape_string($conn, $_POST['Name']);
	$ContactNo = mysqli_real_escape_string($conn, $_POST['ContactNo']);
	$Address = mysqli_real_escape_string($conn, $_POST['Address']);
	$LicenseID = mysqli_real_escape_string($conn, $_POST['LicenseID']);

	$sql = "INSERT INTO driver (DriverId, CardId, RfidId, JeepId, DrName, ContactNo, Address, LicenseId)
	VALUES ('$DriverID', '$CardID', '$RfidId', '$JeepID', '$Name', '$ContactNo', '$Address', '$LicenseID');";
	$sql .= "INSERT INTO card (CardId, RfidId, pass, CardTypeId, RegDate) 
	VALUES ('$CardID', '$RfidId', '$RfidId', '3', now())";

	//if(mysqli_query($conn, $sql)){
	if(mysqli_multi_query($conn, $sql)){
		//-----CODE FOR ADDING A TRANSACTION RECORD
		include "db_connect.php";
	    $sql = mysqli_query($conn, "SELECT MAX(TransactionId) AS TransactionId FROM cardregrecords");
	    $result = mysqli_fetch_array($sql);
	    $TransactionId = (substr($result['TransactionId'], 1)) + 1;
	    $TransId = "T" . str_pad($TransactionId,4,"0",STR_PAD_LEFT);
		$AdminId = mysqli_real_escape_string($conn, $_SESSION["sesUname"]);
		
		include "db_connect.php";
		$sql2 = "INSERT INTO cardregrecords (TransactionId, CardId, CardTypeId, InitialBal, AdminId, RegDate) 
		VALUES ('$TransId', '$CardID', '3', '0', '$AdminId', now())";
		mysqli_query($conn, $sql2);

		$_SESSION["sesSuccess"] = "Driver registration successful.";
		header("Location: page_registercard.php");
	}
	else{
		$_SESSION["sesError"] = "ERROR: " . mysqli_error($conn);
		header("Location: page_registercard.php");
	}
}

if(isset($_POST["btnRegisterJeep"])) {
	$JeepId = mysqli_real_escape_string($conn, $_POST['JeepId']);
	$LicensePlate = mysqli_real_escape_string($conn, $_POST['LicensePlate']);

	$sql = "INSERT INTO jeep (JeepId, LicensePlate, RegDate) 
	VALUES ('$JeepId', '$LicensePlate', now())";

	if(mysqli_query($conn, $sql)){
		$AdminId = mysqli_real_escape_string($conn, $_SESSION["sesUname"]);
		
		include 'db_connect.php';
		$sql = mysqli_query($conn, "SELECT MAX(TransactionId) AS TransactionId FROM jeepregrecords");
		$result = mysqli_fetch_array($sql);
		$TransactionId = (substr($result['TransactionId'], 1)) + 1;
		$TransId = "T" . str_pad($TransactionId,4,"0",STR_PAD_LEFT);
		
		include "db_connect.php";
		$sql2 = "INSERT INTO jeepregrecords (TransactionId, JeepId, LicensePlate, AdminId, RegDate) 
		VALUES ('$TransId', '$JeepId', '$LicensePlate', '$AdminId', now())";
		mysqli_query($conn, $sql2);

		$_SESSION["sesSuccess"] = "Jeep registration successful.";
		header("Location: page_registerjeep.php");
	}
	else{
		$_SESSION["sesError"] = "ERROR: " . mysqli_error($conn);
		header("Location: page_registerjeep.php");
	}

}

//------ADD ADMIN
if(isset($_POST["btnAddAdmin"])) {
	$AdminId = mysqli_real_escape_string($conn, $_POST['AdminId']);
	$AdminName = mysqli_real_escape_string($conn, $_POST['AdminName']);
	$AdminContact = mysqli_real_escape_string($conn, $_POST['AdminContact']);
	$AdminBday = mysqli_real_escape_string($conn, $_POST['AdminBday']);
	$AdminAddress = mysqli_real_escape_string($conn, $_POST['AdminAddress']);
	$AdminStation = mysqli_real_escape_string($conn, $_POST['AdminStation']);
	$AdminPassword = mysqli_real_escape_string($conn, $_POST['password']);

	//$sql = "CALL SP_INSERT_NEWADMIN('" . $AdminId . "','" . $AdminName . "','" . $AdminContact . "','" . $AdminBday . "','" . $AdminAddress . "','" . $AdminStation . "','" . $AdminPassword . "');";

	$sql = "INSERT INTO adminaccount (AdminId, AdminName, ContactNo, Birthday, Address, StationId, Passwordd) 
	VALUES ('$AdminId', '$AdminName', '$AdminContact', '$AdminBday', '$AdminAddress', '$AdminStation', '$AdminPassword')";

	if(mysqli_query($conn, $sql)){
		$_SESSION["sesSuccess"] = "Admin registration successful.";
		header("Location: page_admin.php");
	}
	else{
		$_SESSION["sesError"] = "ERROR: " . mysqli_error($conn);
		header("Location: page_admin.php");
	}

}


?>
