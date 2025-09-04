<?php 
	require_once '../includes/db_connection.php';

	$msg = "";
	if (isset($_POST['contact-submit'])) {
		$contact_name = $_POST['contact-name'];
		$contact_email = $_POST['contact-email'];
		$contact_phone = $_POST['contact-phone'];
		$contact_subject = $_POST['contact-subject'];
		$contact_message = $_POST['contact-message'];

		$insert_query = "INSERT INTO `contact_query`(`contact_query_id`, `contact_query_name`, `contact_query_email`, `contact_query_phone`, `contact_query_subject`, `contact_query_message`, `contact_query_created_on`, `contact_query_status`) VALUES (NULL,'$contact_name','$contact_email','$contact_phone','$contact_subject','$contact_message',NOW(),'0')";
		if ($run_query = mysqli_query($con, $insert_query)) {
			echo "<script>alert('Contact Query Successfully Sent')</script>";
			echo "<script>window.history.go(-1)</script>";
		} else {
			echo "<script>alert('Some Error occurred! Please Try Again!')</script>";
			echo "<script>window.history.go(-1)</script>";
		}
	} else {
		echo "<script>alert('Not an Authorized Action!')</script>";
		echo "<script>window.history.go(-1)</script>";
	}
?>