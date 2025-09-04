<?php
	session_start();
	require_once '../assets/includes/db_connection.php';

	// Check Login Status
	if (!isset($_SESSION['finger_no'])) {
		echo "<script>alert('You are not authorized for this page, Please Login to continue!')</script>";
		echo "<script>window.parent.location.href = '../../login';</script>";
	} else {
		$student_finger_no = $_SESSION['finger_no'];
		if (isset($_GET['application_code'])) {
			$application_code = $_GET['application_code'];

			$get_application_details = "SELECT * FROM leave_applications WHERE application_code = '$application_code' AND student_finger_no = '$student_finger_no' AND leave_status = 'Gatepass Generated'";
			$run_application_details = mysqli_query($con, $get_application_details);
			$count_application_details = mysqli_num_rows($run_application_details);
				if ($count_application_details <= 0) {
					echo "<script>alert('No Such Leave Application Exists!')</script>";
					echo "<script>window.parent.location.href = '../../login';</script>";
				} else {
					$file_path = "../../warden-portal/assets/images/gatepass/" . $application_code . ".pdf"; 
					if (file_exists($file_path)) {
					    header('Content-Type: application/octet-stream');
					    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
					    header('Content-Length: ' . filesize($file_path));
					    echo "<script>window.parent.location.href = './';</script>";
					} else {
					    http_response_code(404);
					    echo "File not found!";
					}
				}
		} else {
			echo "<script>alert('You are not authorized for this page, Please Login to continue!')</script>";
			echo "<script>window.parent.location.href = '../../logout';</script>";
		}
	}
?>