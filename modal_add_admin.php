<?php
include 'db_connect.php';
?>
<form action="db_insert.php" method="post">
	<!-- Modal Header -->
	<div class="modal-header">
		<text class="subtitle">Add New Admin</text>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			&times;
		</button>
	</div>
	<!-- Modal Body -->
	<div class="modal-body">
		<div class="row">
			<div class="col-4 label-2"> Admin ID
				<?php
				$sql = mysqli_query($conn, "SELECT MAX(AdminId) AS AdminId FROM adminaccount");
				$result = mysqli_fetch_array($sql);
				$AdminId = (substr($result['AdminId'],1)) + 1;
				$NewAdminId = "A" . str_pad($AdminId,4,"0",STR_PAD_LEFT);
				?>
				<input type="text" class="input-modal" name="AdminId" id="AdminId" value="<?php echo $NewAdminId; ?>" readonly>
			</div>
			<div class="col-4 label-2"> Name <text class="textlorange">*</text>
				<input type="text" class="input-modal" name="AdminName" id="AdminName" required="">
			</div>
			<div class="col-4 label-2"> Contact No. <text class="textlorange">*</text>
				<input type="text" class="input-modal" name="AdminContact" id="AdminContact" required="">
			</div>
		</div>
		<div class="row">
			<div class="col-4 label-2"> Birthday <text class="textlorange">*</text>
				<input type="date" class="input-modal" name="AdminBday" id="AdminBday" required="">
			</div>
			<div class="col-4 label-2"> Address <text class="textlorange">*</text>
				<input type="text" class="input-modal" name="AdminAddress" id="AdminAddress" required="">
			</div>
			<div class="col-4 label-2"> Station ID <text class="textlorange">*</text>
				<input type="text" class="input-modal" name="AdminStation" id="AdminStation" required="">
			</div>
		</div><br>

		<div class="row">
			<div class="col-4 label-2"> Password (6 characters min) <text class="textlorange">*</text>
				<input type="password" minlength="6" maxlength="25" class="input-modal" name="password" id="password" required="">
			</div>
			<div class="col-4 label-2"> Confirm Password <text class="textlorange">*</text>
				<input type="password" minlength="6" maxlength="25" class="input-modal" name="confirmpass" id="confirmpass" required="">
			</div>
			<div class="col-4 label-2"> <text class="textlorange">*</text>
				<input type="text" class="input-modal" id="message" readonly="">
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
				<input type="submit" class="modalbtn" name="btnAddAdmin" id="btnAddAdmin" value="Add Admin" disabled="">
			</div>
			<div class="col-4">
				<button type="reset" class="cancel">Cancel</button>
			</div>
			<div class="col-2"></div>
		</div>

	</div>
</form>



<script type="text/javascript">
	$('#password, #confirmpass').on('keyup', function () {
		if (($('#password').val() == $('#confirmpass').val())) {
			$('#message').val('Passwords matched.').css('color', 'green');
			$('#btnAddAdmin').prop('disabled', false);
		} 
		else if (($('#password').val().length == 0 )) {
			$('#message').val('Password cannot be empty.').css('color', 'red');
			$('#btnAddAdmin').prop('disabled', true);
		}
		else {
			$('#message').val('Passwords do not match.').css('color', 'red');
			$('#btnAddAdmin').prop('disabled', true);
		}
	});
</script>

