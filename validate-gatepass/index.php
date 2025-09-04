<?php 
	session_start();
	require_once './assets/includes/db_connection.php';
    // require_once './assets/includes/fpdf/fpdf.php';
    // require_once './assets/includes/functions/functions.php';

	if (isset($_GET['application_code'])) {
		$application_code = $_GET['application_code'];

		$get_application_details = "SELECT * FROM leave_applications WHERE application_code = '$application_code'";
		$run_application_details = mysqli_query($con, $get_application_details);
		$count_application_details = mysqli_num_rows($run_application_details);
			if ($count_application_details <= 0) {
				echo "<h3 style='color: red;'>No Such Leave Application is There! Grab the Student and file a report against them!</h3>";
			} else {
				while ($row_application_details = mysqli_fetch_array($run_application_details)) {
					$application_from_date = $row_application_details['leave_from_date'];
					if ($application_from_date == date('Y-m-d')) {
						$application_status = $row_application_details['leave_status'];
						if ($application_status != "Gatepass Generated") {
							echo "<h3 style='color: red;'>This is not a Valid Gatepass, Grab the student and file a report against them!</h3>";
						} else {
							$student_finger_no = $row_application_details['student_finger_no'];

							$get_student_details = "SELECT * FROM students WHERE student_finger_no = '$student_finger_no' AND student_status = 'Active'";
							$run_student_details = mysqli_query($con, $get_student_details);
							$count_student_details = mysqli_num_rows($run_student_details);
								if ($count_student_details <= 0) {
									echo "<h3 style='color: red;'>No Student Available for this Leave Application!</h3>";
								} else {
									echo "<h3 style='color: green'>This is a valid Gatepass Allow Them outing!</h3>";
								}
						}
					} else {
						$display_from_date = date('d M, Y', strtotime($application_from_date));
						echo "<h3 style='color: red;'>This Application is not for Today, allow him only if today's date is: $display_from_date</h3>";
					}
				}
			}
	} else {
		echo "<script>window.parent.location.href='../'</script>";
	}
?>