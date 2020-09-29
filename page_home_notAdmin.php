<!DOCTYPE html>
<html lang="en">
<head>
	<title>Home</title>
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
    <?php include 'header_notAdmin.php'; ?>
    
	<div class="pagetitle"> Your Card Details </div> <hr> <br>

	<div class="bodymain">
		<div class="scroll350">
			<table class="table table-bordered table-sm" name="tblCardDet" id="tblCardDet">
				<thead>
					<tr>
						<th>Card Id</th>
						<th>Card Balance</th>
						<th>Card Type</th>
						<th>Register Date</th>
					</tr>
				</thead>
				<tbody>
					<?php
					include 'db_connect.php';
					//$sql = mysqli_query($conn, "CALL SP_GET_JEEPTBL_INFO()");
	                $id = mysqli_real_escape_string($conn, $_SESSION["sesUname"]);
					$sql = "SELECT CardId, CardBal, CardTypeId, RegDate
    						FROM card WHERE CardId= '" . $id . "'";
    				$sql = mysqli_query($conn, $sql);
					while($res = mysqli_fetch_array($sql)) {
						echo "<tr>\n";
						echo"<td>".$res['CardId']."</td>\n";
						echo"<td>".$res['CardBal']."</td>\n";
						    if ($res['CardTypeId'] == 1) {
				                echo"<td>Regular</td>\n";
						    }
						    else if ($res['CardTypeId'] == 2) {
				                echo"<td>Discounted</td>\n";
						    }
						    else if ($res['CardTypeId'] == 3) {
				                echo"<td>Driver</td>\n";
						    }
						echo"<td>".$res['RegDate']."</td>\n";
						echo "</tr>\n";
					} 
					?>
				</tbody>
			</table>
			<br>
			
			<?php
			include 'db_connect.php';
			$id = mysqli_real_escape_string($conn, $_SESSION["sesUname"]);
		    $sql = "SELECT CardTypeId FROM card WHERE CardId= '" . $id . "'";
    		$sql = mysqli_query($conn, $sql);
			while($res = mysqli_fetch_array($sql)){
			    $CardType = $res['CardTypeId'];
			}
			
			if($CardType == 3){ ?>
			    <table class="table table-bordered table-sm" name="tblCardDet" id="tblCardDet">
			        <thead>
					    <tr>
						    <th>Driver ID</th>
						    <th>Jeep ID</th>
						    <th>License ID</th>
						    <th>Name</th>
						    <th>Contact No.</th>
						    <th>Address</th>
					    </tr>
				    </thead>
				    <tbody>
				        <?php
				        include 'db_connect.php';
				        $id = mysqli_real_escape_string($conn, $_SESSION["sesUname"]);
					    $sql = "SELECT *
    						FROM driver WHERE CardId= '" . $id . "'";
    				    $sql = mysqli_query($conn, $sql);
    				    while($res = mysqli_fetch_array($sql)) {
    				        echo "<tr>\n";
						    echo"<td>".$res['DriverId']."</td>\n";
						    echo"<td>".$res['JeepId']."</td>\n";
						    echo"<td>".$res['LicenseId']."</td>\n";
						    echo"<td>".$res['DrName']."</td>\n";
						    echo"<td>".$res['ContactNo']."</td>\n";
						    echo"<td>".$res['Address']."</td>\n";
						    echo "</tr>\n";
    				    }
				        ?>
				</tbody>
			</table>
			<?php
			}
			else {
			    
			}
			?>
		</div>
	</div>
	
</body>

<!-- JAVASCRIPT -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#home').empty();
		$('#home').append('<a class="active" href="page_home_notAdmin.php">Card Details</a>');
	});
</script>