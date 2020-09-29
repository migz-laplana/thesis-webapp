
<?php
//Error Modal Trigger
if(isset($_SESSION["sesError"])) {
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#modalError').modal('show');
		});
	</script>
	<?php
}
//Success Modal Trigger
if(isset($_SESSION["sesSuccess"])) {
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#modalSuccess').modal('show');
		});
	</script>
	<?php
}
?>



<!-- Error Modal -->
<div class="modal fade" id="modalError">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<text class="subtitle">Error</text>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					&times;
				</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body prompt-error">
				<text class="subtitle">
					<?php
					echo $_SESSION["sesError"];
					unset($_SESSION["sesError"]);
					?>
				</text>
			</div>
		</div>
	</div>
</div>


<!-- Success Modal -->
<div class="modal fade" id="modalSuccess">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<text class="subtitle">Success</text>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					&times;
				</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body prompt-success">
				<text class="subtitle">
					<?php
					echo $_SESSION["sesSuccess"];
					unset($_SESSION["sesSuccess"]);
					?>
				</text>
				
			</div>
		</div>
	</div>
</div>


<!----------------------------------------->
<!-- Info Modal -->
<div class="modal fade" id="infoModal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" id="info">
		</div>
	</div>
</div>
