<!DOCTYPE html>
<html lang="en">
<head>
	<title>Card Details</title>
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
	<?php include 'header.php';?>

	<div class="pagetitle"> Card Details </div> <hr> <br>

	<div class="bodymain">
		
		<!-- TABS -->
		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a data-toggle="tab" class="nav-link active" href="#passengercard"> Passenger</a>
			</li>
			<li class="nav-item">
				<a data-toggle="tab" class="nav-link" href="#drivercard">Driver</a>
			</li>
		</ul>

		<div class="tab-content">
			<!-- CONTENT-PASSENGER REG -->
			<div id="passengercard" class="tab-pane fade show active"><br>
				<text class="label">Click row to view and edit details.</text>
				<div class="scroll500">
					<table class="table table-bordered table-sm" name="tblPassengerDetails" id="tblPassengerDetails">
						<thead>
							<th>Card ID</th>
							<th>RFID ID</th>
							<th>Balance</th>
							<th>Passenger Type</th>
							<th>Register Date</th>
						</thead>
						<tbody>
							<?php
							include 'db_connect.php';
							//$sql = mysqli_query($conn, "CALL SP_GET_CARD_DETAILS()");
							$sql = "SELECT c.CardId AS CardId, c.RfidId AS RfidId, c.CardBal AS CardBal, ct.UserDescription AS UserDescription, c.RegDate AS RegDate
    								FROM card AS c
    								JOIN cardtype AS ct
    								ON c.CardTypeId = ct.CardTypeId
    								WHERE c.CardTypeId = '1' OR c.CardTypeId = '2'
    								ORDER BY c.CardId ASC";
    						$sql = mysqli_query($conn, $sql);
							while($res = mysqli_fetch_array($sql)) {
								echo "<tr>\n";
								echo"<td>".$res['CardId']."</td>\n";
								echo"<td>".$res['RfidId']."</td>\n";
								echo"<td>".$res['CardBal']."</td>\n";
								echo"<td>".$res['UserDescription']."</td>\n";
								echo"<td>".$res['RegDate']."</td>\n";
								echo "</tr>\n";
							} 
							?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- CONTENT-DRIVER REG -->	
			<div id="drivercard" class="tab-pane fade"><br>
				<text class="label">Click row to view and edit details.</text>
				<div class="scroll350">
					<table class="table table-bordered table-sm" name="tblDriverDetails" id="tblDriverDetails">
						<thead class="head">
							<th>Card ID</th>
							<th>RFID ID</th>
							<th>Driver ID</th>
							<th>Jeep ID</th>
							<th>Balance</th>
							<th>License ID</th>
							<th>Register Date</th>
						</thead>
						<tbody>
							<?php
							include 'db_connect.php';
							//$sql = mysqli_query($conn, "CALL SP_GET_DRIVER_DETAILS()");
							$sql = "SELECT d.DriverId AS DriverID, c.CardId AS CardId, c.RfidId AS RfidId, c.CardBal AS CardBal, d.JeepId AS JeepID, d.DrName AS DrName, d.ContactNo AS Contact, d.Address AS Address, d.LicenseID AS License, c.RegDate AS RegDate
    								FROM card AS c
    								JOIN driver AS d
    								ON c.CardId = d.CardId
    								WHERE c.CardTypeId = '3'";
    						$sql = mysqli_query($conn, $sql);
							while($res = mysqli_fetch_array($sql)) {
								echo "<tr>\n";
								echo"<td>".$res['CardId']."</td>\n";
								echo"<td>".$res['RfidId']."</td>\n";
								echo"<td>".$res['DriverID']."</td>\n";
								echo"<td>".$res['JeepID']."</td>\n";
								echo"<td>".$res['CardBal']."</td>\n";
								echo"<td>".$res['License']."</td>\n";
								echo"<td>".$res['RegDate']."</td>\n";
								echo "</tr>\n";
							} 
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

</body>

<!-- JAVASCRIPT -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#carddet').empty();
		$('#carddet').append('<a class="active" href="page_carddetails.php">Card Details</a>');
	});
</script>


<script type="text/javascript">
	$("#tblPassengerDetails tr").click(function(event){
		var id = $(this).find('td:first').text();
		var type = "passenger";
		$.ajax({
			type: "POST",
			url: "modal_edit.php",
			data: {CardId:id, EditType:type},
			dataType: "html",
			success: function (data) {
				$('#info').html(data);
				$('#infoModal').modal("show");
			}
		});
	});
</script>

<script type="text/javascript">
	$("#tblDriverDetails tr").click(function(event){
		
		var id = $(this).find('td:first').text();
		var type = "driver";
		$.ajax({
			type: "POST",
			url: "modal_edit.php",
			data: {CardId:id, EditType:type},
			dataType: "html",
			success: function (data) {
				$('#info').html(data);
				$('#infoModal').modal("show");
			}
		});
		
	});
</script>

