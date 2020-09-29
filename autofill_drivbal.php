<?php 
include 'db_connect.php';

$CardID = $_POST["CardID"];
$CurrBal = "";

//$sql = mysqli_query($conn, "CALL SP_GET_CARD_BALANCE('".$CardID."','0','1')");
$sql = "SELECT * FROM card WHERE CardId = '$CardID'";
$sql = mysqli_query($conn, $sql);
$count = mysqli_num_rows($sql);
while($result = mysqli_fetch_array($sql)) {
    $ID = $result['CardId'];
    $CardType = $result['CardTypeId'];
	$CardBal = $result['CardBal'];
}


if ($CardType == 3) {
    echo $CardBal;
}
else {
	echo 'Card ID is invalid.';
}



?>