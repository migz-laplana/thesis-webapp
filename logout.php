<?php
	/* Logout Function */
	session_start();
	session_destroy();
	header("Location: index.php");
?>
