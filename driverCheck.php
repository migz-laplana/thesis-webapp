<?php
session_start();

include 'db_connect.php';
$finalArray;

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $passrfid = $_GET["rfid"];
    
	
	
	//CHECKING IF CARD TAPPED IS A REGISTERED DRIVER
    include 'db_connect.php';
    $driverid = "select RfidId from driver where RfidId = '$passrfid'";
	$driverid = mysqli_query($conn,$driverid);

	$drivercheck = mysqli_num_rows($driverid);	

	
	if ($drivercheck > 0)
	{
	    $finalArray = array("Yes");
	}

	else {
	    $finalArray = array("invalid");
	}
}

/* Set the content-type. */
header('Content-Type: application/json');

/* The JSON string created from the array. */
$json = json_encode($finalArray);

/* Return the JSON string. */
echo $json;

?>