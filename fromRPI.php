<?php
session_start();

include 'db_connect.php';
$finalArray;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $driverrfid = $_POST["driverid"];
	$rfid = $_POST["rfid"];
	$lat1 = $_POST["lat1"];
	$long1 = $_POST["long1"];
	$lat2 = $_POST["lat2"];
	$long2 = $_POST["long2"];
	
	//get card details
	$fromCard = "SELECT * from card where RfidId = '$rfid'";
	$fromCard = mysqli_query($conn, $fromCard);
	while($result = mysqli_fetch_array($fromCard)) {
        $passCardType = $result['CardTypeId'];
        $PassCardId = $result['CardId'];
        $currPassBal = $result['CardBal'];
    }
    
    //get current bal and card id of driver and driver id
    include 'db_connect.php';
    $fromDriver = "SELECT c.CardBal AS CardBal, c.CardId AS CardId, d.DriverId as DriverId
                FROM card as c
                JOIN driver as d
                ON c.CardId = d.CardId
                WHERE d.RfidId = '$driverrfid'";
    $fromDriver = mysqli_query($conn, $fromDriver);
    while($result = mysqli_fetch_array($fromDriver)) {
        $currDriverBal = $result['CardBal'];
        $driverCardId = $result['CardId'];
        $driverid = $result['DriverId'];
    }
    
    //----------------------------------------------------
    //DISTANCE CALC
    
    function GetDrivingDistance($lat1, $lat2, $long1, $long2)
{
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=pl-PL&key=AIzaSyAjJiWf7cWVVagqIAsHvwMvmZTxp-Qgmwk";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

    return array('distance' => $dist, 'time' => $time);
}

        include 'db_connect.php';
        $sqlPassPay = "INSERT INTO testing (rfid, driverid, distance, fare) VALUES ('$lat1', '$lat2', '$long1', '$long2')";
        mysqli_query($conn, $sqlPassPay);





    $dist = GetDrivingDistance($lat1, $lat2, $long1, $long2);
    //echo 'Distance: <b>'.$dist['distance'].'</b>';
    $distArray = 'Distance: <b>'.$dist['distance'].'</b>';
    //echo $distArray;
    $distString = '';
    $distString = $dist['distance'];
    //echo $distString;
    //echo '<br>';
    $almost = substr($distString, 0, -2);

    $finalDist = str_replace(",", ".", $almost);
    $finalDist = ROUND($finalDist);
    
        include 'db_connect.php';
        $sqlPassPay = "INSERT INTO testing (rfid) VALUES ('$finalDist')";
        mysqli_query($conn, $sqlPassPay);
    
    //----------------------------------------------------
    
    if($passCardType == 1) {
        $sqlFareReg = "SELECT FareReg from fare WHERE DistanceId = '$finalDist'";
        $sqlFareReg = mysqli_fetch_row(mysqli_query($conn, $sqlFareReg));
        $sqlFareReg = $sqlFareReg[0];
        
        //generate transaction id
        $sqlTransId = "SELECT MAX(TransactionId) AS TransactionId 
                    FROM psngrpayrecords";
        $sqlTransId = mysqli_query($conn, $sqlTransId);
        $result = mysqli_fetch_array($sqlTransId);
        $TransactionId = (substr($result['TransactionId'], 1)) + 1;
		$TransId = "T" . str_pad($TransactionId,4,"0",STR_PAD_LEFT);
		
		//update passenger (balance - payment)
        include 'db_connect.php';
        $sqlPassPay = "UPDATE card
                    SET CardBal = $currPassBal - $sqlFareReg
                    WHERE RfidId = '$rfid'";
        mysqli_query($conn, $sqlPassPay);
        
        //update driver (balance + payment)
        include 'db_connect.php';
        $sqlDriverIn = "UPDATE card
                    SET CardBal = $currDriverBal  + $sqlFareReg
                    WHERE CardId = '$driverCardId'";
        mysqli_query($conn, $sqlDriverIn);
		
		//insert transaction record
		include 'db_connect.php';
		$PayTrans = "INSERT INTO psngrpayrecords (TransactionId, CardId, DriverId, DistanceId, Amount, TransDate)
		            VALUES ('$TransId', '$PassCardId', '$driverid', '$finalDist', '$sqlFareReg', now())";
		mysqli_query($conn, $PayTrans);
    }
    else if($passCardType == 2) {
        $sqlFareDisc = "SELECT FareDisc from fare WHERE DistanceId = '$finalDist'";
        $sqlFareDisc = mysqli_fetch_row(mysqli_query($conn, $sqlFareDisc));
        $sqlFareDisc = $sqlFareDisc[0];
        
        //generate transaction id
        $sqlTransId = "SELECT MAX(TransactionId) AS TransactionId 
                    FROM psngrpayrecords";
        $sqlTransId = mysqli_query($conn, $sqlTransId);
        $result = mysqli_fetch_array($sqlTransId);
        $TransactionId = (substr($result['TransactionId'], 1)) + 1;
		$TransId = "T" . str_pad($TransactionId,4,"0",STR_PAD_LEFT);
		
		//update passenger (balance - payment)
        include 'db_connect.php';
        $sqlPassPay = "UPDATE card
                    SET CardBal = $currPassBal - $sqlFareDisc
                    WHERE RfidId = '$rfid'";
        mysqli_query($conn, $sqlPassPay);
        
        //update driver (balance + payment)
        include 'db_connect.php';
        $sqlDriverIn = "UPDATE card
                    SET CardBal = $currDriverBal  + $sqlFareDisc
                    WHERE CardId = '$driverCardId'";
        mysqli_query($conn, $sqlDriverIn);
		
		//insert transaction record
		include 'db_connect.php';
		$PayTrans = "INSERT INTO psngrpayrecords (TransactionId, CardId, DriverId, DistanceId, Amount, TransDate)
		            VALUES ('$TransId', '$PassCardId', '$driverid', '$finalDist', '$sqlFareDisc', now())";
		mysqli_query($conn, $PayTrans);
    }
    
}

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $passrfid = $_GET["rfid"];
    
    include 'db_connect.php';
    $rfid = "select RfidId, CardBal from card where RfidId = '$passrfid'";
	$rfid = mysqli_query($conn,$rfid);
// 	$testing = mysqli_query($conn,"INSERT INTO testing (rfid)
// VALUES ('" . $passrfid . "')");
	$count = mysqli_num_rows($rfid);
	
    include 'db_connect.php';
    $driverid = "select RfidId from driver where RfidId = '$passrfid'";
	$driverid = mysqli_query($conn,$driverid);

	$drivercheck = mysqli_num_rows($driverid);	

	
	if($count > 0) {
	    while($result = mysqli_fetch_array($rfid)) {
		    $PassBal = $result['CardBal'];
		}

		if($PassBal < 55.00) {
		    $finalArray = array("No");
		}
    	else if($PassBal >= 55.00) {
    	    $finalArray = array("Yes");
    	}
	}
	else if ($drivercheck > 0)
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