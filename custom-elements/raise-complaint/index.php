<?php 
	session_start();
	require_once '../assets/includes/db_connection.php';

	// Check Login Status
	if (!isset($_SESSION['finger_no'])) {
		echo "<script>window.parent.location.href = '../../login';</script>";
	} else {
		$msg = "";
		$finger_number = $_SESSION['finger_no'];
		$get_user_details = "SELECT * FROM students WHERE student_finger_no = '$finger_number'";
		$run_user_details = mysqli_query($con, $get_user_details);
		$row_user_details = mysqli_fetch_array($run_user_details);
			$room_number = $row_user_details['student_room_no'];

		if (isset($_POST['raise-complaint-submit'])) {
			$complaint_category = ucwords($_POST['complaint-category']);
			$complaint_sub_category = ucwords($_POST['complaint-sub-category']);
				if ($complaint_category == 'Aluminium') {
					if ($complaint_sub_category == 'Almirah') {
						$complaint_code = "ALUALM" . time();
					} elseif ($complaint_sub_category == 'Gate') {
						$complaint_code = "ALUGATE" . time();
					} elseif ($complaint_sub_category == 'Hanger') {
						$complaint_code = "ALUHAN" . time();
					} else {
						echo "<script>alert('Please select Relative Sub Category!')</script>";
						if ($complaint_code == NULL) {
									echo "<script>alert('Error Complaint has been already raised, Please Try Again Tomorrow!')</script>";
									echo "<script>window.parent.location.href = '';</script>";
						}
					}
				} elseif ($complaint_category == 'Carpenter') {
					if ($complaint_sub_category == 'Bed') {
						$complaint_code = "CARBED" . time();
					} elseif ($complaint_sub_category == 'Chair') {
						$complaint_code = "CARCHA" . time();
					} elseif ($complaint_sub_category == 'Mirror') {
						$complaint_code = "CARMIR" . time();
					} elseif ($complaint_sub_category == 'Shelf') {
						$complaint_code = "CARSHE" . time();
					} elseif ($complaint_sub_category == 'Study Table') {
						$complaint_code = "CARSTU" . time();
					} else {
						echo "<script>alert('Please select Relative Sub Category!')</script>";
						echo "<script>window.parent.location.href = '';</script>";
					}
				} elseif ($complaint_category == 'Electricity') {
					if ($complaint_sub_category == 'Cooler') {
						$complaint_code = "ELECOO" . time();
					} elseif ($complaint_sub_category == 'Fan') {
						$complaint_code = "ELEFAN" . time();
					} elseif ($complaint_sub_category == 'Geyser') {
						$complaint_code = "ELEGEY" . time();
					} elseif ($complaint_sub_category == 'Switch Board') {
						$complaint_code = "ELESWI" . time();
					} elseif ($complaint_sub_category == 'Tubelight') {
						$complaint_code = "ELETUB" . time();
					} else {
						echo "<script>alert('Please select Relative Sub Category!')</script>";
						echo "<script>window.parent.location.href = '';</script>";
					}
				} elseif ($complaint_category == 'Plumbing') {
					if ($complaint_sub_category == 'Flush') {
						$complaint_code = "PLUFLU" . time();
					} elseif ($complaint_sub_category == 'Handshower') {
						$complaint_code = "PLUHSH" . time();
					} elseif ($complaint_sub_category == 'Jetspary') {
						$complaint_code = "PLUJET" . time();
					} elseif ($complaint_sub_category == 'Shower') {
						$complaint_code = "PLUSHO" . time();
					} elseif ($complaint_sub_category == 'Tap') {
						$complaint_code = "ELETAP" . time();
					} else {
						echo "<script>alert('Please select Relative Sub Category!')</script>";
						echo "<script>window.parent.location.href = '';</script>";
					}
				} elseif ($complaint_category == 'Room Cleaning') {
					if ($complaint_sub_category == 'Room') {
						$complaint_code = "CLNROOM" . time();
					} elseif ($complaint_sub_category == 'Bathroom') {
						$complaint_code = "CLNBATH" . time();
					} elseif ($complaint_sub_category == 'Washroom') {
						$complaint_code = "CLNWASH" . time();
					} elseif ($complaint_sub_category == 'Fullroom') {
						$complaint_code = "CLNFULL" . time();
					} else {
						echo "<script>alert('Please select Relative Sub Category!')</script>";
						echo "<script>window.parent.location.href = '';</script>";
					}
				}

				$check_complaint_code = "SELECT * FROM room_complaints WHERE complaint_code = '$complaint_code'";
				$run_complaint_code = mysqli_query($con, $check_complaint_code);
				$count_complaint_code = mysqli_num_rows($run_complaint_code);
					if ($count_complaint_code <= 0) {
						$check_similar_complaint = "SELECT * FROM room_complaints WHERE student_room_no = '$room_number' AND complaint_category = '$complaint_category' AND complaint_sub_category = '$complaint_sub_category' AND complaint_status NOT IN ('Completed', 'Cancelled', 'Denied', 'Cannot be Fulfilled', 'Deleted') AND complaint_raised_on > CURRENT_TIMESTAMP - INTERVAL 1 DAY";
						$run_similar_complaint = mysqli_query($con, $check_similar_complaint);
						$count_similar_complaint = mysqli_num_rows($run_similar_complaint);
							if ($count_similar_complaint <= 0) {
								$complaint_desc = $_POST['complaint-desc-issue'];
								$complaint_status = 'Pending';

								if ($complaint_code == NULL) {
									echo "<script>alert('Error Complaint has been already raised, Please Try Again Tomorrow!')</script>";
									echo "<script>window.parent.location.href = '../../raise-complaint';</script>";
								}

								$raise_complaint = "INSERT INTO `room_complaints`(`room_complaint_id`, `complaint_code`, `student_finger_no`, `student_room_no`, `complaint_category`, `complaint_sub_category`, `complaint_description`, `complaint_raised_on`, `complaint_status`) VALUES (NULL,'$complaint_code','$finger_number','$room_number','$complaint_category','$complaint_sub_category','$complaint_desc',NOW(),'$complaint_status')";
								if ($run_raise_complaint = mysqli_query($con, $raise_complaint)) {
									echo "<script>alert('Complaint Raised!')</script>";
									echo "<script>window.parent.location.href = '../../my-profile';</script>";
								} else {
									echo "<script>alert('Error While Raising Complaint!')</script>";
									echo "<script>window.parent.location.href = '../../raise-complaint';</script>";
								}
							} else {
								echo "<script>alert('Similar Complaint has been already raised, Please Try Again Tomorrow!')</script>";
								echo "<script>window.parent.location.href = '../../raise-complaint';</script>";
							}
					} else {
						echo "<script>alert('A Complaint with this Code already Exists, Please Try Again!')</script>";
						echo "<script>window.parent.location.href = '../../raise-complaint';</script>";
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
				<label for="complaint-category">Complaint Category:</label>
				<select class="form-control" name="complaint-category" id="complaint-category" required style="border-radius: 0;">
					<option selected disabled>Select Complaint Category</option>
					<option value="aluminium">Aluminium</option>
					<option value="carpenter">Carpenter</option>
					<option value="electricity">Electricity</option>
					<option value="plumbing">Plumbing</option>
					<option value="room cleaning">Room Cleaning</option>
					<option disabled>If you have complaint which is not listed here you can fill the Contact Form on the Home Page</option>
				</select>
		  	</div>
		  	<div class="mb-3">
				<label for="complaint-sub-category">Complaint Sub Category:</label>
				<select class="form-control" name="complaint-sub-category" id="complaint-sub-category" required style="border-radius: 0;">
					<option selected disabled>Select Complaint Sub Category</option>
					<option disabled>Aluminium -></option>
						<option value="almirah">&nbsp; &nbsp; &nbsp; &nbsp;Almirah</option>
						<option value="gate">&nbsp; &nbsp; &nbsp; &nbsp;Gate</option>
						<option value="hanger">&nbsp; &nbsp; &nbsp; &nbsp;Hanger</option>
					<option disabled>Carpenter -></option>
						<option value="bed">&nbsp; &nbsp; &nbsp; &nbsp;Bed</option>
						<option value="chair">&nbsp; &nbsp; &nbsp; &nbsp;Chair</option>
						<option value="mirror">&nbsp; &nbsp; &nbsp; &nbsp;Mirror</option>
						<option value="shelf">&nbsp; &nbsp; &nbsp; &nbsp;Shelf</option>
						<option value="study table">&nbsp; &nbsp; &nbsp; &nbsp;Study Table</option>
						<option value="other furniture">&nbsp; &nbsp; &nbsp; &nbsp;Other Furniture</option>
					<option disabled>Electricity -></option>
						<option value="cooler">&nbsp; &nbsp; &nbsp; &nbsp;Cooler</option>
						<option value="fan">&nbsp; &nbsp; &nbsp; &nbsp;Fan</option>
						<option value="geyser">&nbsp; &nbsp; &nbsp; &nbsp;Geyser</option>
						<option value="switch board">&nbsp; &nbsp; &nbsp; &nbsp;Switch Board</option>
						<option value="tubelight">&nbsp; &nbsp; &nbsp; &nbsp;Tubelight</option>
					<option disabled>Plumbing -></option>
						<option value="flush">&nbsp; &nbsp; &nbsp; &nbsp;Flush</option>
						<option value="handshower">&nbsp; &nbsp; &nbsp; &nbsp;Hand Shower</option>
						<option value="jetspary">&nbsp; &nbsp; &nbsp; &nbsp;Jet Spray</option>
						<option value="shower">&nbsp; &nbsp; &nbsp; &nbsp;Shower</option>
						<option value="tap">&nbsp; &nbsp; &nbsp; &nbsp;Tap</option>
					<option disabled>Room Cleaning -></option>
						<option value="room">&nbsp; &nbsp; &nbsp; &nbsp;Room</option>
						<option value="bathroom">&nbsp; &nbsp; &nbsp; &nbsp;Bathroom</option>
						<option value="washroom">&nbsp; &nbsp; &nbsp; &nbsp;Wash Room</option>
						<option value="fullroom">&nbsp; &nbsp; &nbsp; &nbsp;Full Room</option>
					<option disabled>If you have complaint which is not listed here you can fill the Contact Form on the Home Page</option>
				</select>
		  	</div>
		  	<div class="mb-3">
		  		<label for="complaint-desc-issue">Describe Issue:</label>
			    <input type="text" class="form-control" name="complaint-desc-issue" id="complaint-desc-issue" placeholder="Describe Issue" required style="border-radius: 0;" maxlength="255">
		  	</div>
		  	<input type="submit" class="btn btn-md btn-warning" name="raise-complaint-submit" id="raise-complaint-submit" value="RAISE COMPLAINT" style="font-weight: 400; border-radius: 0;">
		</form>
	</div>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php } ?>