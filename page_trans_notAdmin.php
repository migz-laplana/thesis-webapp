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
    
	<div class="pagetitle"> Your Transactions </div> <hr> <br>

	<div class="bodymain">
	    <?php
		$isDriver = 0;
		include 'db_connect.php';
		$cardid = mysqli_real_escape_string($conn, $_SESSION["sesUname"]);
		$sql = "SELECT * FROM driver WHERE CardId= '" . $cardid . "'";  //check if the person is a driver
		$result = mysqli_query($conn,$sql);
		$count = mysqli_num_rows($result);
		if ($count > 0) {
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$id = $row['DriverId'];
			$isDriver = 1;
		}
		
	    if ($isDriver == 1) {
			$sql = "SELECT TransactionId, CardId, DistanceId, Amount, TransDate     FROM psngrpayrecords
			        WHERE DriverId= '" . $id . "'";
		    ?>
	        <!-- TABS -->
	        <ul class="nav nav-tabs">
			    <li class="nav-item">
				    <a data-toggle="tab" class="nav-link active" href="#passjeep">Passenger Jeep Payments</a>
			    </li>
			    <li class="nav-item">
				    <a data-toggle="tab" class="nav-link" href="#incwith">Income Withdrawals</a>
			    </li>
		    </ul><br>
		            
		    <div class="tab-content">
		        <div id="passjeep" class="tab-pane fade show active">
		            <div class="scroll500">
		                <table class="table table-bordered table-sm" name="tblTransaction" id="tblTransaction">
		                    <thead>
				                <tr>
						            <th>Transaction ID</th>
						            <th>Passenger Card ID</th>
						            <th>Distance in Km</th>
						            <th>Amount</th>
						            <th>Transaction Date</th>
					            </tr>
				            </thead>
				            <tbody>
					            <?php
    				            $sql = mysqli_query($conn, $sql);
					            while($res = mysqli_fetch_array($sql)) {
						            echo "<tr>\n";
						            echo"<td>".$res['TransactionId']."</td>\n";
						            echo"<td>".$res['CardId']."</td>\n";
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
		        <div id="incwith" class="tab-pane fade">
		            <div class="scroll500">
		                <?php
		                $sql2 = "SELECT * FROM collectionrecords WHERE CardId = '" . $cardid . "'";
		                ?>
		                <table class="table table-bordered table-sm" name="tblTransaction" id="tblTransaction">
		                    <thead>
		                        <tr>
						            <th>Transaction ID</th>
						            <th>Amount Withdrew</th>
						            <th>Transaction Date</th>
					            </tr>
		                    </thead>
		                    <tbody>
		                        <?php
    				            $sql2 = mysqli_query($conn, $sql2);
					            while($res = mysqli_fetch_array($sql2)) {
						            echo "<tr>\n";
						            echo"<td>".$res['TransactionId']."</td>\n";
						            echo"<td>".$res['Amount']."</td>\n";
						            echo"<td>".$res['TransDate']."</td>\n";
						            echo "</tr>\n";
					            }
					            ?>
		                    </tbody>
		                </table>
		            </div>
		        </div>
	        </div>
	    <?php
	    }
	    else {
	        $sql = "SELECT TransactionId, DriverId, DistanceId, Amount, TransDate FROM psngrpayrecords WHERE CardId= '" . $cardid . "'";
	        ?>
	        <div class="scroll500">
	            <table class="table table-bordered table-sm" name="tblTransaction" id="tblTransaction">
	                <thead>
				        <tr>
						    <th>Transaction ID</th>
						    <th>Driver ID</th>
						    <th>Distance in Km</th>
						    <th>Amount</th>
						    <th>Transaction Date</th>
					    </tr>
				    </thead>
				    <tbody>
					    <?php
    				    $sql = mysqli_query($conn, $sql);
					    while($res = mysqli_fetch_array($sql)) {
						    echo "<tr>\n";
						    echo"<td>".$res['TransactionId']."</td>\n";
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
	    <?php 
	    }
	    ?>
	</div>
</body>

<!-- JAVASCRIPT -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#trans').empty();
		$('#trans').append('<a class="active" href="page_trans_notAdmin.php">Transactions</a>');
	});
</script>