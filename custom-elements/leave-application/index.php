<?php 
	session_start();
	require_once '../assets/includes/db_connection.php';

	// Check Login Status
	if (!isset($_SESSION['finger_no'])) {
		echo "<script>window.parent.location.href = '../../login';</script>";
	} else {
		$msg = "";
		$finger_number = $_SESSION['finger_no'];

		if (isset($_POST['apply_leave'])) {

			$application_code = "LVAP" . time();
			$check_application_code = "SELECT * FROM leave_applications WHERE application_code = '$application_code'";
			$run_application_code = mysqli_query($con, $check_application_code);
			$count_application_code = mysqli_num_rows($run_application_code);
				if ($count_application_code <= 0) {
					$check_student_previous_application = "SELECT * FROM leave_applications WHERE student_finger_no = '$finger_number' AND leave_applied_on > CURRENT_TIMESTAMP - INTERVAL 1 DAY";
					$run_student_previous_application = mysqli_query($con, $check_student_previous_application);
					$count_student_previous_application = mysqli_num_rows($run_student_previous_application);
						if ($count_student_previous_application <= 1) {
							$leave_from = $_POST['leave-from-date'];
							$leave_to = $_POST['leave-to-date'];
							$leave_days = date_diff(date_create($leave_from), date_create($leave_to))->format('%a') + 1;
							$leave_reason = $_POST['leave-reason'];
							$leave_address1 = $_POST['leave-address1'];
							$leave_address2 = $_POST['leave-address2'];
							$leave_address3 = $_POST['leave-address3'];
							$leave_pincode = $_POST['leave-address4'];
							$leave_city = $_POST['leave-address5'];
							$leave_state = $_POST['leave-address6'];
							$leave_status = "Pending";

							$apply_leave = "INSERT INTO `leave_applications`(`leave_application_id`, `application_code`, `student_finger_no`, `leave_from_date`, `leave_to_date`, `leave_days`, `leave_reason`, `leave_address1`, `leave_address2`, `leave_address3`, `leave_address_pincode`, `leave_address_city`, `leave_address_state`, `leave_applied_on`, `leave_status`) VALUES (NULL,'$application_code','$finger_number','$leave_from','$leave_to', '$leave_days','$leave_reason','$leave_address1','$leave_address2','$leave_address3','$leave_pincode','$leave_city','$leave_state',NOW(),'$leave_status')";
							if ($run_apply_leave = mysqli_query($con, $apply_leave)){
								echo "<script>alert('Leave Applied!')</script>";
								echo "<script>window.parent.location.href = '../../my-profile';</script>";
							} else {
								echo "<script>alert('Error While Applying Leave!')</script>";
								echo "<script>parent.location.reload();</script>";
							}
						} else {
							echo "<script>alert('You have already applied for 2 Leaves with 24 Hours, Please Try Again Tomorrow!')</script>";
							echo "<script>window.parent.location.href = '../../my-profile';</script>";
						}
				} else {
					echo "<script>alert('An Application with this Code already Exists, Please Try Again!')</script>";
					echo "<script>parent.location.reload();</script>";
				}
		}
		
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Leave Application Form</title>

	<!-- Bootstap Styles -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Font Awesome Styles -->

	
</head>
<body>
	<div class="container">
		<?php echo "$msg"; ?>
		<form action="" method="post">
			<div class="mb-3">
				<label for="leave-from-date">From Date:</label>
		    	<input type="date" class="form-control" name="leave-from-date" id="leave-from-date" onchange="updateEndDateMin()" required style="border-radius: 0;">
		  	</div>
		  	<div class="mb-3">
		    	<label for="leave-to-date">To Date:</label>
		    	<input type="date" class="form-control" name="leave-to-date" id="leave-to-date" required style="border-radius: 0;">
		  	</div>
		  	<div class="mb-3">
		  		<label for="leave-reason">Reason for Leave:</label>
			    <input type="text" class="form-control" name="leave-reason" id="leave-reason" placeholder="Enter your Reason" required style="border-radius: 0;" maxlength="255">
		  	</div>
		  	<div class="mb-3">
		  		<label for="leave-address">Address During Leave Period:</label>
			    <input type="text" class="form-control mb-2" name="leave-address1" id="leave-address1" placeholder="Apartment Name / Number" required style="border-radius: 0;">
			    <input type="text" class="form-control mb-2" name="leave-address2" id="leave-address2" placeholder="Street / Colony  / Area" required style="border-radius: 0;">
			    <input type="text" class="form-control mb-2" name="leave-address3" id="leave-address3" placeholder="Landmark" style="border-radius: 0;">
			    <input type="tel" class="form-control mb-2" name="leave-address4" id="leave-address4" placeholder="Pincode" pattern="[0-9]{6}" required style="border-radius: 0;">
			    <input type="text" class="form-control mb-2" name="leave-address5" id="leave-address5" placeholder="City" required style="border-radius: 0;">
			    <input type="text" class="form-control mb-3" name="leave-address6" id="leave-address6" placeholder="State" required style="border-radius: 0;">
		  	</div>
			<input type="submit" class="btn btn-md btn-warning" name="apply_leave" id="apply_leave" value="APPLY LEAVE" style="font-weight: 400; border-radius: 0;">
		</form>
	</div>

	<!-- Custom JS -->
	<script>
		// Get today's date
		var today = new Date();

		// Format today's date as YYYY-MM-DD (required by the input type="date" format)
		var formattedToday = today.toISOString().split('T')[0];

		// Set the min attribute of the date input to today
		document.getElementById('leave-from-date').min = formattedToday;

		function updateEndDateMin() {
		    // Get the value of the start date input
		    var startDate = document.getElementById('leave-from-date').value;

		    // Set the minimum date for the end date input to the selected start date
		    document.getElementById('leave-to-date').min = startDate;

		    // Enable the end date input
		    document.getElementById('leave-to-date').disabled = false;
		}
	</script>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php } ?>