<!DOCTYPE html>
<html lang="en">
<head>
	<title>Jeep Details</title>
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

	<div class="pagetitle"> Jeep Details </div> <hr> <br>

	<div class="bodymain">
		<div class="scroll350">
			<table class="table table-bordered table-sm" name="tblJeepDetails" id="tblJeepDetails">
				<thead>
					<tr>
						<th>Jeep ID</th>
						<th>License Plate</th>
						<th>Register Date</th>
					</tr>
				</thead>
				<tbody>
					<?php
					include 'db_connect.php';
					//$sql = mysqli_query($conn, "CALL SP_GET_JEEPTBL_INFO()");
					$sql = "SELECT JeepId, LicensePlate, RegDate
    						FROM jeep";
    				$sql = mysqli_query($conn, $sql);
					while($res = mysqli_fetch_array($sql)) {
						echo "<tr>\n";
						echo"<td>".$res['JeepId']."</td>\n";
						echo"<td>".$res['LicensePlate']."</td>\n";
						echo"<td>".$res['RegDate']."</td>\n";
						echo "</tr>\n";
					} 
					?>
				</tbody>
			</table>
		</div>
	</div>
	
</body>

<!-- JAVASCRIPT -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#jeepdet').empty();
		$('#jeepdet').append('<a class="active" href="page_jeepdetails.php">Jeep Details</a>');
	});
</script>

<script type="text/javascript">
	$("#tblJeepDetails tr").click(function(event){

			var id = $(this).find('td:first').text();
			var type = "jeep";
			$.ajax({
				type: "POST",
				url: "modal_edit.php",
				data: {JeepId:id, EditType:type},
				dataType: "html",
				success: function (data) {
					$('#info').html(data);
					$('#infoModal').modal("show");
				}
			});
		
	});
</script>