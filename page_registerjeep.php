<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register Jeep</title>
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

	<div class="pagetitle"> Register Jeep </div> <hr> <br>

	<div class="bodymain">
		<form action="db_insert.php" method="post">
			<div class="row">
				<label class="col-3 label">Jeep ID</label>
				<div class="col-9">
					<!-- retrieve info from database, JeepID -->
					<?php
					include 'db_connect.php';
					$sql = mysqli_query($conn, "SELECT MAX(JeepId) AS JeepId FROM jeep");
					$result = mysqli_fetch_array($sql);
					$JeepId = (substr($result['JeepId'], 1)) + 1;
					$NewJeepId = "J" . str_pad($JeepId,4,"0",STR_PAD_LEFT);
					?>

					<input type="text" class="input" name="JeepId" id="JeepId" readonly value="<?php echo $NewJeepId; ?>">
				</div>
			</div>
			<div class="row">
				<label class="col-3 label">License Plate <text class="textlorange">*</text> </label>
				<div class="col-9">
					<input type="text" class="input" name="LicensePlate" id="LicensePlate" placeholder="License Plate" required>
				</div>
			</div><br>

			<?php
			include 'db_connect.php';
			$sql = mysqli_query($conn, "SELECT MAX(TransactionId) AS TransactionId FROM transrecords");
			$result = mysqli_fetch_array($sql);
			$TransactionId = (substr($result['TransactionId'], 1)) + 1;
			$NewTransactionId = "T" . str_pad($TransactionId,4,"0",STR_PAD_LEFT);
			?>
			<input type="hidden" name="TransId" id="TransId" value="<?php echo $NewTransactionId; ?>">
			
			<!-- CHECKBOX CONFIRM -->
			<div> 
				<center>
					<text class="label">
						<input type="checkbox" name="txtInfo" value="info" required>  I certify that the above information given is true and correct to the best of my knowledge.
					</text>
				</center>
			</div><br>
			<div class="row">
				<div class="col-2"></div>
				<div class="col-4">
					<input type="submit" class="add-register" name="btnRegisterJeep" id="btnRegisterJeep" value="Register Jeep">
				</div>
				<div class="col-4">
					<button type="reset" class="cancel">Cancel</button>
				</div>
				<div class="col-2"></div>
			</div>
		</form>
	</div>	
</body>

<!-- JAVASCRIPT -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#regjeep').empty();
		$('#regjeep').append('<a class="active" href="page_registerjeep.php">Register Jeep</a>');
	});
</script>