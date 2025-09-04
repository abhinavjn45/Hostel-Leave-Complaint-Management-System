<?php
	date_default_timezone_set('Asia/Kolkata');
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "hostel";

	// Create connection
	$con = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($con->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
?>