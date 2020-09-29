<!DOCTYPE html>
<html lang="en">
<head>
	<title>Transfer Income</title>
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

	<div class="pagetitle"> Transfer Driver Income </div> <hr> <br>

	<div class="bodymain">
		<form action="db_update.php" method="post">
			<div class="row">
				<div class="col-3 label">Card ID <text class="textlorange">*</text> </div>
				<div class="col-9">
					<input type="text" class="input" name="DriverID" id="DriverID" placeholder="Card ID" required>
				</div>
			</div>
			<div class="row">
				<div class="col-3 label">Current Balance: ₱</div>
				<div class="col-9">
					<input type="text" class="input" name="CurrBal" id="CurrBal" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-3 label">Amount to Transfer: ₱ <text class="textlorange">*</text> </div>
				<div class="col-9">
					<input type="text" class="input" name="TransAmt" id="TransAmt" placeholder="Amount to Transfer" required>
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
			<center>
				<text class="label">
					<input type="checkbox" name="txtInfo" value="info" required>  I certify that the above information given is true and correct to the best of my knowledge.
				</text>
			</center><br>
			<div class="row">
				<div class="col-2"></div>
				<div class="col-4">
					<input type="submit" class="add-register" name="btnTransIncome" id="btnTransIncome" value="Withdraw Income">
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
		$('#transfer').empty();
		$('#transfer').append('<a class="active" href="page_transferincome.php">Transfer Income</a>');
	});
</script>

<!-- CARD BALANCE AUTOFILL -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#DriverID').on('input',function(){
			var CardID = $(this).val();
			$.ajax({
				url : "autofill_cardbal.php",
				dataType: 'html',
				type: 'POST',
				data : { CardID : CardID },
				success : function(data) {
					var info = data.split('|');
					$('#CurrBal').val(info[0]);
				}
			}); 
		});
	});
</script>