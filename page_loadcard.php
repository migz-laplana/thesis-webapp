<!DOCTYPE html>
<html lang="en">
<head>
	<title>Load Card</title>
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

	<div class="pagetitle"> Load Card </div> <hr> <br>
	
	
		<form action="db_update.php" method="post">
			<div class="row">
				<div class="col-3 label">Card ID <text class="textlorange">*</text> </div>
				<div class="col-9">
					<input type="text" class="input" name="CardID" id="CardID" placeholder="Card ID" required>
				</div>
			</div>
			<div class="row">
				<div class="col-3 label">Current Balance: ₱</div>
				<div class="col-9">
					<input type="text" class="input" name="CurrBal" id="CurrBal" readonly>
				</div>
			</div>
			<div class="row">
				<div class="col-3 label">Load Amount: ₱ <text class="textlorange">*</text> </div>
				<div class="col-9" id="loadamount">
				    <input type="text" class="input" name="LoadAmt" id="LoadAmt" placeholder="Load Amount" required>
				</div>
			</div><br>

			<!-- CHECKBOX CONFIRM -->
			<center>
				<text class="label">
					<input type="checkbox" name="txtInfo" value="info" required>  I certify that the above information given is true and correct to the best of my knowledge.
				</text>
			</center><br>
			<div class="row">
				<div class="col-2"></div>
				<div class="col-4">
					<input type="submit" class="add-register" name="btnLoadCard" id="btnLoadCard" value="Load Card">
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
		$('#load').empty();
		$('#load').append('<a class="active" href="page_loadcard.php">Load Card</a>');
	});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $("div:contains('Card ID belongs to a driver and is not permitted to be loaded.')").('#loadamount').empty();
    }
</script>

<!-- CARD BALANCE AUTOFILL -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#CardID').on('input',function(){
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
