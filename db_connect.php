<?php
	/* DB Connection Function */
	
	// DB Credentials
	$servername = "us-cdbr-east-02.cleardb.com"; //host
	$username = "bf84837bc2d1de"; //db username
	$password = "8565c0fa"; //db password
	$database = "heroku_e9d41921be64189"; //db name
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $database);
	
	// Check connection
	if ($conn->connect_error) {
   		die("Connection failed: " . $conn->connect_error);
	}

?>

