<?php

$servername = "localhost";
$dbUsername = "payment";
$dbPassword = "payment";
$dbName = 'paymentsystem';

$conn = mysqli_connect($servername, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
  die("Connection failed: ".mysqli_connect_error());
}



 ?>
