<?php
   session_start();

   if(!isset($_SESSION["sesUname"])) {
      $_SESSION["sesError"] = "Session has expired. Please re-login to continue.";
      header("Location: page_login.php");
   }
?>