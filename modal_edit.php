<?php

include 'db_connect.php';


$EditType = $_POST["EditType"];
?>

<form action="db_update.php" method="post">

	<?php

	//edit passenger details
	if($EditType == "passenger") {
		$CardId = $_POST["CardId"];
		//$sql = mysqli_query($conn, "CALL SP_GET_ROWPASSENGER('".$CardId."')");
		$sql = "SELECT c.CardId AS CardId, c.RfidId AS RfidId, c.CardBal AS CardBal, c.CardTypeId AS CardTypeId, ct.UserDescription AS UserDescription, c.RegDate AS RegDate
    			FROM card AS c
    			JOIN cardtype AS ct
    			ON c.CardTypeId = ct.CardTypeId
    			WHERE c.CardId = '$CardId'";
		$sql = mysqli_query($conn, $sql);
		while($result = mysqli_fetch_array($sql)) {
			$RfidId = $result['RfidId'];
			$CardBal = $result['CardBal'];
			$CardTypeId = $result['CardTypeId'];
			$UserDescription = $result['UserDescription'];
		}
		?>
		<div class="modal-header">
			<text class="subtitle">Passenger Details</text>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				&times;
			</button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-6 label-2"> Card ID
					<input type="text" class="input-modal" name="CardId" id="CardId" value="<?php echo $CardId; ?>" readonly>
				</div>
				<div class="col-6 label-2"> RFID ID
					<input type="text" class="input-modal" name="RfidId" id="RfidId" value="<?php echo $RfidId; ?>" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-6 label-2">Passenger Type <text class="textlorange">*</text>
					<select class="input-modal" name="PassengerType" id="PassengerType" required>
						<option value="<?php echo $CardTypeId; ?>"> <?php echo $UserDescription; ?> </option>
						<?php
						if($CardTypeId == '1') { ?>
							<option value="2">Discounted</option>
						<?php }
						if($CardTypeId == '2') { ?>
							<option value="1">Regular</option>
						<?php }
						?>
					</select>
				</div>
				<div class="col-6 label-2"> Balance
					<input type="text" class="input-modal" name="CardBal" id="CardBal" value="<?php echo $CardBal; ?>" readonly>
				</div>
			</div><br><hr>

			<center>
				<text class="label-2">
					<input type="checkbox" name="txtInfo" value="info" required>  I certify that the above information given is true and correct to the best of my knowledge.
				</text>
			</center> <br>
			<div class="row">
				<div class="col-2"></div>
				<div class="col-4">
					<input type="submit" class="modalbtn" name="btnUpdatePassenger" id="btnUpdatePassenger" value="Update Passenger Details">
				</div>
				<div class="col-4">
					<button type="reset" class="cancel">Revert changes</button>
				</div>
				<div class="col-2"></div>
			</div>
		</div>
		<?php
	}



	//edit driver details
	if($EditType == "driver") {
		$CardId = $_POST["CardId"];
		//$sql = mysqli_query($conn, "CALL SP_GET_ROWDRIVER('".$CardId."')");
		$sql = "SELECT d.DriverId AS DriverID, c.CardId AS CardId, c.RfidId AS RfidId,c.CardBal AS CardBal, d.JeepId AS JeepID, d.DrName AS DrName, d.ContactNo AS Contact, d.Address AS Address, d.LicenseID AS License, c.RegDate AS RegDate
    			FROM card AS c
    			JOIN driver AS d
    			ON c.CardId = d.CardId
    			WHERE c.CardTypeId = '3' AND c.CardId = '$CardId'";
    	$sql = mysqli_query($conn, $sql);
		while($result = mysqli_fetch_array($sql)) {
			$RfidId = $result['RfidId'];
			$DriverID = $result['DriverID'];
			$JeepID = $result['JeepID'];
			$CardBal = $result['CardBal'];
			$DrName = $result['DrName'];
			$Contact = $result['Contact'];
			$Address = $result['Address'];
			$License = $result['License'];
		}
		?>
		<div class="modal-header">
			<text class="subtitle">Driver Details</text>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				&times;
			</button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-4 label-2"> Card ID
					<input type="text" class="input-modal" name="CardId" id="CardId" value="<?php echo $CardId; ?>" readonly>
				</div>
				<div class="col-4 label-2"> RFID ID
					<input type="text" class="input-modal" name="RfidId" id="RfidId" value="<?php echo $RfidId; ?>" readonly>
				</div>
				<div class="col-4 label-2"> Balance
					<input type="text" class="input-modal" name="CardBal" id="CardBal" value="<?php echo $CardBal; ?>" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-4 label-2"> Driver ID
					<input type="text" class="input-modal" name="DriverId" id="DriverId" value="<?php echo $DriverID; ?>" readonly>
				</div>
				<input type="hidden" name="CurrJeepId" id="CurrJeepId" value="<?php echo $JeepID; ?>">
				<div class="col-4 label-2"> Jeep ID
					<select class="input-modal" name="JeepId" id="JeepId">
						<option selected disabled>- - - - -</option>
						<?php

						include 'db_connect.php';
						//$sql = mysqli_query($conn, "CALL SP_GET_JEEPTBL_INFO()");
						$sql = "SELECT JeepId FROM jeep";
    					$sql = mysqli_query($conn, $sql);
						while($result = mysqli_fetch_array($sql)) {
							$NJeepId = $result['JeepId'];

							if($JeepID == "") {
								echo "<option value='".$NJeepId."'>".$NJeepId."</option>";
							}
							else {
								if($NJeepId == $JeepID) {
									echo "<option value='".$JeepID."' selected>".$JeepID."</option>";
								}
								else {
									echo "<option value='".$NJeepId."'>".$NJeepId."</option>";
								}
							}
						}
						?>
					</select>
				</div>
				<div class="col-4 label-2"> Name <text class="textlorange">*</text>
					<input type="text" class="input-modal" name="Name" id="Name" value="<?php echo $DrName; ?>" required>
				</div>
			</div>
			<div class="row">
				<div class="col-4 label-2"> Contact No. <text class="textlorange">*</text>
					<input type="text" class="input-modal" name="Contact" id="Contact" value="<?php echo $Contact; ?>" required>
				</div>
				<div class="col-4 label-2"> Address <text class="textlorange">*</text>
					<input type="text" class="input-modal" name="Address" id="Address" value="<?php echo $Address; ?>" required>
				</div>
				<div class="col-4 label-2"> License ID <text class="textlorange">*</text>
					<input type="text" class="input-modal" name="License" id="License" value="<?php echo $License; ?>" required>
				</div>
			</div><br><hr>

			<center>
				<text class="label-2">
					<input type="checkbox" name="txtInfo" value="info" required>  I certify that the above information given is true and correct to the best of my knowledge.
				</text>
			</center> <br>

			<div class="row">
				<div class="col-2"></div>
				<div class="col-4">
					<input type="submit" class="modalbtn" name="btnUpdateDriver" id="btnUpdateDriver" value="Update Driver Details">
				</div>
				<div class="col-4"> 
					<button type="reset" class="cancel">Revert changes</button> 
				</div>
				<div class="col-2"></div>
			</div>
		</div>
		<?php
	}


	//edit jeep details
	if($EditType == "jeep") {
		$JeepId = $_POST["JeepId"];
		//$sql = mysqli_query($conn, "CALL SP_GET_ROWJEEP('".$JeepId."')");
		$sql = "SELECT * FROM jeep WHERE JeepId = '$JeepId';";
		$sql = mysqli_query($conn, $sql);
		while($result = mysqli_fetch_array($sql)) {
			$JeepId = $result['JeepId'];
			$LicensePlate = $result['LicensePlate'];
		}
		?>
		<div class="modal-header">
			<text class="subtitle">Jeep Details</text>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				&times;
			</button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-6 label-2"> Jeep ID
					<input type="text" class="input-modal" name="JeepId" id="JeepId" value="<?php echo $JeepId; ?>" readonly>
				</div>
				<div class="col-6 label-2"> License Plate <text class="textlorange">*</text>
					<input type="text" class="input-modal" name="LicensePlate" id="LicensePlate" value="<?php echo $LicensePlate; ?>" required>
				</div>
			</div><br><hr>

			<center>
				<text class="label-2">
					<input type="checkbox" name="txtInfo" value="info" required>  I certify that the above information given is true and correct to the best of my knowledge.
				</text>
			</center><br>

			<div class="row">
				<div class="col-2"></div>
				<div class="col-4">
					<input type="submit" class="modalbtn" name="btnUpdateJeep" id="btnUpdateJeep" value="Update Jeep Details">
				</div>
				<div class="col-4">
					<button type="reset" class="cancel">Revert changes</button>
				</div>
				<div class="col-2"></div>
			</div>

		</div>
		<?php
	}

	?>

</form>