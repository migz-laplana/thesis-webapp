<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register Card</title>
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

	<div class="pagetitle"> Register Card </div> <hr> <br>

	<div class="bodymain">

		<!-- TABS -->
		<ul class="nav nav-tabs">
			<li>
				<a data-toggle="tab" class="nav-link active" href="#passengercard">New Passenger</a>
			</li>
			<li>
				<a data-toggle="tab" class="nav-link" href="#drivercard">New Driver</a>
			</li>
		</ul>

		<div class="tab-content">
			<!-- CONTENT-PASSENGER REG -->
			<div id="passengercard" class="tab-pane fade show active">
				<br><br>
				<div>
					<form action="db_insert.php" method="post">
						<div class="row">
							<div class="col-3 label">Card ID</div>
							<div class="col-9">
								<!-- retrieve info from database, CardID -->
								<!-- same para sa CardID mg driver -->
								<?php
								include 'db_connect.php';
								$sql = mysqli_query($conn, "SELECT MAX(CardId) AS CardId FROM card");
								$result = mysqli_fetch_array($sql);
								$CardId = (substr($result['CardId'], 1)) + 1;
								$NewCardId = "C" . str_pad($CardId,4,"0",STR_PAD_LEFT);
								?>
								<input type="text" class="input" name="CardID" id="CardID" readonly value="<?php echo $NewCardId; ?>">
							</div>
						</div>
						<div class="row">
							<div class="col-3 label">RFID ID <text class="textlorange">*</text> </div>
							<div class="col-9">
								<input type="text" class="input" name="RfidId" id="RfidId" placeholder="RFID ID" required>
							</div>
						</div>
						<div class="row">
							<div class="col-3 label">Passenger Type <text class="textlorange">*</text> </div>
							<div class="col-9">
								<div>
									<select class="input" name="PassengerType" id="PassengerType" required>
										<option selected disabled>- - - - -</option>
										<option value="1">Regular</option>
										<option value="2">Discounted</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-3 label">Balance: ₱ <text class="textlorange">*</text> </div>
							<div class="col-9">
								<input type="text" class="input" name="Balance" id="Balance" placeholder="Balance" required>
							</div>
						</div><br>

						<!-- CHECKBOX CONFIRM -->
						<div> 
							<center>
								<input type="checkbox" name="txtInfo" value="info" required> 
								<text class="label">
									I certify that the above information given is true and correct to the best of my knowledge.
								</text> 
							</center>
						</div><br>
						<div class="row">
							<div class="col-2"></div>
							<div class="col-4">
								<center>
									<input type="submit" class="add-register" name="btnRegisterPassenger" id="btnRegisterPassenger" value="Register Passenger">
								</center>
							</div>
							<div class="col-4">
								<center>
									<button type="reset" class="cancel">Cancel</button>
								</center>
							</div>
							<div class="col-2"></div>
						</div>
					</form>
				</div>
			</div>


			<!-- CONTENT-DRIVER REG -->	
			<div id="drivercard" class="tab-pane fade">
				<br><br>
				<div>
					<form action="db_insert.php" method="post">
						<div class="row">
							<div class="col-3 label">Card ID</div>
							<div class="col-9">
								<input type="text" class="input" name="CardID" id="CardID" readonly value="<?php echo $NewCardId; ?>">
							</div>
						</div>
						<div class="row">
							<div class="col-3 label">RFID ID <text class="textlorange">*</text> </div>
							<div class="col-9">
								<input type="text" class="input" name="RfidId" id="RfidId" placeholder="RFID ID" required>
							</div>
						</div>
						<div class="row">
							<div class="col-3 label">Driver ID</div>
							<div class="col-9">
								<!-- retrieve info from database, driverID -->
								<?php
								include 'db_connect.php';
								$sql = mysqli_query($conn, "SELECT MAX(DriverId) AS DriverId FROM driver");
								$result = mysqli_fetch_array($sql);
								$DriverId = (substr($result['DriverId'], 1)) + 1;
								$NewDriverId = "D" . str_pad($DriverId,4,"0",STR_PAD_LEFT);
								?>
								<input type="text" class="input" name="DriverID" id="DriverID" readonly value="<?php echo $NewDriverId; ?>">
							</div>
						</div>
						<div class="row">
							<div class="col-3 label">Jeep ID <text class="textlorange">*</text></div>
							<div class="col-9">
								<select class="input" name="JeepID" id="JeepID" required>
									<option selected disabled>- - - - -</option>
									<?php
									include 'db_connect.php';
									$sql = mysqli_query($conn, "SELECT JeepId, LicensePlate FROM jeep;");
									while($result = mysqli_fetch_array($sql)) {
										$JeepId = $result['JeepId'];

										echo "<option value='".$JeepId."'>".$JeepId."</option>";				
									}
									?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-3 label">Name <text class="textlorange">*</text> </div>
							<div class="col-9">
								<input type="text" class="input" class="form-control" name="Name" id="Name" placeholder="Name" required>
							</div>
						</div>
						<div class="row">
							<div class="col-3 label">Contact No. <text class="textlorange">*</text> </div>
							<div class="col-9">
								<input type="text" class="input" name="ContactNo" id="ContactNo" placeholder="Contact No." required>
							</div>
						</div>
						<div class="row">
							<div class="col-3 label">Address <text class="textlorange">*</text> </div>
							<div class="col-9">
								<input type="text" class="input" name="Address" id="Address" placeholder="Address" required>
							</div>
						</div>
						<div class="row">
							<div class="col-3 label">License ID <text class="textlorange">*</text> </div>
							<div class="col-9">
								<input type="text" class="input" name="LicenseID" id="LicenseID" placeholder="License ID" required>
							</div>
						</div><br>


						<!-- CHECKBOX CONFIRM -->
						<div> 
							<center>
								<input type="checkbox" name="txtInfo" value="info" required>  
								<text class="label">
									I certify that the above information given is true and correct to the best of my knowledge.
								</text>
							</center>
						</div><br>
						<div class="row">
							<div class="col-2"></div>
							<div class="col-4">
								<input type="submit" class="add-register" name="btnRegisterDriver" id="btnRegisterDriver" value="Register Driver">
							</div>
							<div class="col-4">
								<button type="reset" class="cancel">Cancel</button>
							</div>
							<div class="col-2"></div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>

<!-- JAVASCRIPT -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#regcard').empty();
		$('#regcard').append('<a class="active" href="page_registercard.php">Register Card</a>');
	});
</script>