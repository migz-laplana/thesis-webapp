<?php
	/* DB Connection Function */

	// DB Credentials
	$servername = "localhost"; //host
	$username = "triplempay"; //db username
	$password = "triplempay"; //db password
	$database = "paymentsystem"; //db name

	// Create connection
	$conn = new mysqli($servername, $username, $password, $database);

	// Check connection
	if ($conn->connect_error) {
   		die("Connection failed: " . $conn->connect_error);
	}

?>
