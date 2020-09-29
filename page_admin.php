<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin Account</title>
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
	<?php include 'header.php';
	include 'db_connect.php';
	//$sql = mysqli_query($conn, "CALL SP_GET_ADMIN_LOGIN('" . $_SESSION["sesUname"] . "','" . $_SESSION["sesContactNo"] .  "','2')");
	$AdminId = mysqli_real_escape_string($conn, $_SESSION["sesUname"]);
	$sql = "SELECT *
    		FROM adminaccount
    		WHERE AdminId = '$AdminId'";
    $sql = mysqli_query($conn, $sql);

	while($result = mysqli_fetch_array($sql)) {
		$AdminName = $result['AdminName'];
		$ContactNo = $result['ContactNo'];
		$Birthday = $result['Birthday'];
		$Address = $result['Address'];
		$StationId = $result['StationId'];
	}
	?>

	<div class="pagetitle"> Admin <?php echo $AdminName; ?> </div> <hr> <br>

	<div class="bodymain">
		
		<form action="db_update.php" method="post">
			<div class="row">
				<div class="col-4 label"> Admin ID
					<input type="text" class="input" name="AdminId" id="AdminId" value="<?php echo $_SESSION["sesUname"];?>" readonly>
				</div>
				<div class="col-4 label"> Name <text class="textlorange">*</text> 
					<input type="text" class="input" name="AdminName" id="AdminName" value="<?php echo $AdminName?>" required>
				</div>
				<div class="col-4 label"> Contact No. <text class="textlorange">*</text>
					<input type="text" class="input" name="Contact" id="Contact" value="<?php echo $ContactNo;?>" required>
				</div>
			</div>
			<div class="row">
				<div class="col-4 label"> Birthday (dd/mm/yyyy) <text class="textlorange">*</text> 
					<input type="date" class="input" name="Birthday" id="Birthday" value="<?php echo $Birthday;?>" required>
				</div>
				<div class="col-4 label"> Address <text class="textlorange">*</text> 
					<input type="text" class="input" name="Address" id="Address" value="<?php echo $Address;?>" required>
				</div>
				<div class="col-4 label"> Station ID <text class="textlorange">*</text> 
					<input type="text" class="input" name="Station" id="Station" value="<?php echo $StationId;?>" required>
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
					<input type="submit" class="add-register" name="btnUpdateAdminDet" id="btnUpdateAdminDet" value="Update Admin Details">
				</div>
				<div class="col-4">
					<button type="reset" class="cancel">Revert Changes</button>
				</div>
				<div class="col-2"></div>
			</div>
		</form><br><br><hr>

		
		<center>
			<text class="subtitle"> Other Admin </text>
		</center><br>
		
		<div class="row">
			<div class="col-2"></div>
			<div class="col-4">
				<button type="button" class="add-register" name="btnAddAdmin" id="btnAddAdmin">Add a new admin</button>
			</div>
			<div class="col-4">
				<button type="button" class="cancel" name="btnViewOtherAdmin" id="btnViewOtherAdmin">View Admins</button>
			</div>
			<div class="col-2"></div>
			<!-- javascript call for buttons -->
		</div>
	</div>
</body>

<!-- JAVASCRIPT -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#admin').empty();
		$('#admin').append('<a class="active" href="page_admin.php">Admin Account</a>');
	});
</script>

<!-- add admin action -->
<script type="text/javascript">
	$("#btnAddAdmin").click(function() {
		$.ajax({
			type: "POST",
			url: "modal_add_admin.php",
			dataType: "html",
			success: function (data) {
				$('#info').html(data);
				$('#infoModal').modal("show");
			}
		});
	})
</script>

<!-- view admin action -->
<script type="text/javascript">
	$("#btnViewOtherAdmin").click(function() {
		$.ajax({
			type: "POST",
			url: "modal_view_admin.php",
			dataType: "html",
			success: function (data) {
				$('#info').html(data);
				$('#infoModal').modal("show");
			}
		});
	})
</script>
