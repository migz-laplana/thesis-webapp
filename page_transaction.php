<!DOCTYPE html>
<html lang="en">
<head>
	<title>Transaction</title>
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

	<div class="pagetitle"> Transactions </div> <hr> <br>

	<div class="bodymain">
		<!-- TABS -->
		<ul class="nav nav-tabs">
		    <li class="nav-item">
				<a data-toggle="tab" class="nav-link active" href="#jeeppayment">Passenger Jeep Payment</a>
			</li>
			<li class="nav-item">
				<a data-toggle="tab" class="nav-link" href="#cardload"> Card Loads</a>
			</li>
			<li class="nav-item">
				<a data-toggle="tab" class="nav-link" href="#cashout">Driver Cash Out</a>
			</li>
			<li class="nav-item">
				<a data-toggle="tab" class="nav-link" href="#cardreg"> Card Registers</a>
			</li>
			<li class="nav-item">
				<a data-toggle="tab" class="nav-link" href="#jeepreg"> Jeep Registers</a>
			</li>
		</ul>

		<div class="tab-content">

            <!-- CONTENT - JEEP PAYMENT -->
			<div id="jeeppayment" class="tab-pane fade show active"><br>
				<div class="scroll500">
					<table class="table table-bordered table-sm">
						<thead>
							<tr>
								<th>Transaction ID</th>
								<th>Passenger Card ID</th>
								<th>Driver ID</th>
								<th>Distance</th>
								<th>Amount</th>
								<th>Transaction Date</th>
							</tr>
						</thead>
						<tbody>
							<?php
							include 'db_connect.php';
							$sql = "SELECT * FROM psngrpayrecords";
							$sql = mysqli_query($conn, $sql);
							while($res = mysqli_fetch_array($sql)) {
								echo "<tr>\n";
								echo"<td>".$res['TransactionId']."</td>\n";
								echo"<td>".$res['CardId']."</td>\n";
								echo"<td>".$res['DriverId']."</td>\n";
								echo"<td>".$res['DistanceId']."</td>\n";
								echo"<td>".$res['Amount']."</td>\n";
								echo"<td>".$res['TransDate']."</td>\n";
								echo "</tr>\n";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>

			<!-- CONTENT - CARD REGISTER -->
			<div id="cardreg" class="tab-pane fade"><br>
				<div class="scroll500">
					<table class="table table-bordered table-sm">
						<thead>
							<tr>
								<th>Transaction ID</th>
								<th>Card ID</th>
								<th>Card Type</th>
								<th>Initial Balance</th>
								<th>Admin</th>
								<th>Register Date</th>
							</tr>
						</thead>
						<tbody>
							<?php
							include 'db_connect.php';
					
							
							$sql = "SELECT t.TransactionId AS TransactionId, t.CardId AS CardId, c.UserDescription AS UserDescription, t.InitialBal AS InitialBal, a.AdminName AS AdminName, t.RegDate AS RegDate
							FROM cardregrecords AS t
							JOIN adminaccount AS a
							ON t.AdminId = a.AdminId
							JOIN cardtype AS c
							ON t.CardTypeId = c.CardTypeId
							ORDER BY t.TransactionId ASC";
							$sql = mysqli_query($conn, $sql);
							while($res = mysqli_fetch_array($sql)) {
								echo "<tr>\n";
								echo"<td>".$res['TransactionId']."</td>\n";
								echo"<td>".$res['CardId']."</td>\n";
								echo"<td>".$res['UserDescription']."</td>\n";
								echo"<td>".$res['InitialBal']."</td>\n";
								echo"<td>".$res['AdminName']."</td>\n";
								echo"<td>".$res['RegDate']."</td>\n";
								echo "</tr>\n";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			
			<!-- CONTENT - JEEP REGISTER -->
			<div id="jeepreg" class="tab-pane fade"><br>
				<div class="scroll500">
					<table class="table table-bordered table-sm">
						<thead>
							<tr>
								<th>Transaction ID</th>
								<th>Jeep ID</th>
								<th>License Plate</th>
								<th>Admin</th>
								<th>Register Date</th>
							</tr>
						</thead>
						<tbody>
							<?php
							include 'db_connect.php';
							$sql = "SELECT t.TransactionId AS TransactionId, t.JeepId AS JeepId, t.LicensePlate AS LicensePlate, a.AdminName AS AdminName, t.RegDate AS RegDate
							FROM jeepregrecords AS t
							JOIN adminaccount AS a
							ON t.AdminId = a.AdminId";
							$sql = mysqli_query($conn, $sql);
							while($res = mysqli_fetch_array($sql)) {
								echo "<tr>\n";
								echo"<td>".$res['TransactionId']."</td>\n";
								echo"<td>".$res['JeepId']."</td>\n";
								echo"<td>".$res['LicensePlate']."</td>\n";
								echo"<td>".$res['AdminName']."</td>\n";
								echo"<td>".$res['RegDate']."</td>\n";
								echo "</tr>\n";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>

			<!-- CONTENT - CARD LOAD -->
			<div id="cardload" class="tab-pane fade"><br>
				<div class="scroll500">
					<table class="table table-bordered table-sm">
						<thead>
							<tr>
								<th>Transaction ID</th>
								<th>Card ID</th>
								<th>Amount</th>
								<th>Admin</th>
								<th>Transaction Date</th>
							</tr>
						</thead>
						<tbody>
							<?php
							include 'db_connect.php';
							$sql = "SELECT t.TransactionId AS TransactionId, t.CardId AS CardId, t.Amount AS Amount, a.AdminName AS AdminName, t.TransDate AS TransDate
							FROM psngrloadrecords AS t
							JOIN adminaccount AS a
							ON t.AdminId = a.AdminId";
							$sql = mysqli_query($conn, $sql);
							while($res = mysqli_fetch_array($sql)) {
								echo "<tr>\n";
								echo"<td>".$res['TransactionId']."</td>\n";
								echo"<td>".$res['CardId']."</td>\n";
								echo"<td>".$res['Amount']."</td>\n";
								echo"<td>".$res['AdminName']."</td>\n";
								echo"<td>".$res['TransDate']."</td>\n";
								echo "</tr>\n";
							} 
							?>
						</tbody>
					</table>
				</div>
			</div>

			<!-- CONTENT - DRIVER CASHOUTS -->	
			<div id="cashout" class="tab-pane fade"><br>
				<div class="scroll350">
					<table class="table table-bordered table-sm" name="TableDriverDet" id="TableDriverDet">
						<thead>
							<tr>
								<th>Transaction ID</th>
								<th>Card ID</th>
								<th>Amount</th>
								<th>Admin</th>
								<th>Transaction Date</th>
							</tr>
						</thead>
						<tbody>
							<?php
							include 'db_connect.php';
							//$sql = mysqli_query($conn, "CALL SP_GET_INCOMETRANS_DETAILS()");
							$sql = "SELECT t.TransactionId AS TransactionId, t.CardId AS CardId, t.Amount AS Amount, a.AdminName AS AdminName, t.TransDate AS TransDate
							FROM collectionrecords AS t
							JOIN adminaccount AS a
							ON t.AdminId = a.AdminId";
							$sql = mysqli_query($conn, $sql);
							while($res = mysqli_fetch_array($sql)) {
								echo "<tr>\n";
								echo"<td>".$res['TransactionId']."</td>\n";
								echo"<td>".$res['CardId']."</td>\n";
								echo"<td>".$res['Amount']."</td>\n";
								echo"<td>".$res['AdminName']."</td>\n";
								echo"<td>".$res['TransDate']."</td>\n";
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
		$('#trans').empty();
		$('#trans').append('<a class="active" href="page_transaction.php">Transactions</a>');
	});
</script>
