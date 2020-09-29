<?php
include 'db_connect.php';

?>
<div class="modal-header bgbody">
	<text class="subtitle">View Admins</text>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		&times;
	</button>
</div>
<!-- Modal Body -->
<div class="modal-body">
	<div>
		<table class="table table-bordered table-sm">
			<thead>
				<tr>
					<th>Admin ID</th>
					<th>Name</th>
					<th>Contact No.</th>
					<th>Address</th>
					<th>Station ID</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql = mysqli_query($conn, "SELECT * FROM adminaccount");
				while($res = mysqli_fetch_array($sql)) {
					echo "<tr>\n";
					echo"<td>".$res['AdminId']."</td>\n";
					echo"<td>".$res['AdminName']."</td>\n";
					echo"<td>".$res['ContactNo']."</td>\n";
					echo"<td>".$res['Address']."</td>\n";
					echo"<td>".$res['StationId']."</td>\n";
					echo "</tr>\n";
				}
				?>
			</tbody>
		</table>
	</div>
</div>