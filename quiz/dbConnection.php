<?php
	$con= new mysqli('localhost','','','')or die("Could not connect to mysql".mysqli_error($con));
	mysqli_set_charset($con, "utf8");
?>