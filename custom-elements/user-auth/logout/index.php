<?php 
	session_start();

	if (!isset($_SESSION['finger_no'])) {
		echo "<script>alert('You are not Logged In')</script>";
		echo "<script>window.parent.location.href = '../../../login';</script>";	
	} else {
		session_destroy();
		echo "<script>alert('Logged Out')</script>";
		echo "<script>window.parent.location.href = '../../../login';</script>";
	}
?>