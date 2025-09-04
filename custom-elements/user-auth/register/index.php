<?php 
	session_start();
	require_once '../../assets/includes/db_connection.php';

	if (isset($_SESSION['finger_no'])) {
		echo "<script>window.parent.location.href = '../../../';</script>";
	} else {
		$msg = "";

		if (isset($_POST['register'])) {
			$register_enrollment_no = strtoupper(str_replace(" ", "", $_POST['register-enrollment-no']));
			$register_finger_no = $_POST['register-finger-no'];
			$register_password = $_POST['register-password'];
			$register_student_name = ucwords($_POST['register-student-name']);
			$register_student_college = $_POST['register-student-college'];
			$register_student_program = $_POST['register-student-program'];
			$register_student_year = $_POST['register-student-year'];
			$register_addmission_year = $_POST['register-addmission-year'];
			$register_dob = $_POST['register-dateofbirth'];
			$register_hostel = $_POST['register-hostel'];
			$register_hostel_category = $_POST['register-hostel-category'];
			$register_permanent_address = ucwords($_POST['register-permanent-address1'] . ", " . $_POST['register-permanent-address2'] . ", " . $_POST['register-permanent-address3'] . ", " . $_POST['register-permanent-address4'] . ", " . $_POST['register-permanent-address5'] . ", " . $_POST['register-permanent-address6']);
			$register_student_phone = $_POST['register-student-phone'];
			$register_student_email = strtolower($_POST['register-student-email']);
			$register_father_name = ucwords($_POST['register-father-name']);
			$register_father_phone = $_POST['register-father-phone'];
			$register_mother_name = ucwords($_POST['register-mother-name']);
			$register_mother_phone = $_POST['register-mother-phone'];
			$register_blood_group = $_POST['register-blood-group'];
			$register_room_number = $_POST['register-room-no'] . " " . $_POST['register-room-block'];
			$register_passport_photo = $_FILES['register-passport-photo']['name'];
			$register_passport_tmpName = $_FILES['register-passport-photo']['tmp_name'];
			$image_ext = pathinfo($register_passport_photo, PATHINFO_EXTENSION);
			$image_size = $_FILES['register-passport-photo']['size'];
			$register_status = "Pending";

			$check_sameStudent = "SELECT * FROM students WHERE student_enrollment_no = '$register_enrollment_no' OR student_finger_no = '$register_finger_no' OR student_phone_no = '$register_student_phone' OR student_email = '$register_student_email'";
			$run_sameStudent = mysqli_query($con, $check_sameStudent);
			$count_sameStudent = mysqli_num_rows($run_sameStudent);
				if ($count_sameStudent <= 0) {
					if ($image_ext == 'png' || $image_ext == 'jpg' || $image_ext == 'jpeg') {
						if ($image_size <= 3*1024*1024) {
							$new_fileName = $register_finger_no . time() . "." . $image_ext;
							if (move_uploaded_file($register_passport_tmpName, "../../student-profile/student-images/$new_fileName")) {
								$register_student = "INSERT INTO `students`(`student_id`, `student_enrollment_no`, `student_finger_no`, `student_login_password`, `student_name`, `student_college`, `student_course`, `student_semester`, `student_admission_year`, `student_date_of_birth`, `student_hostel`, `student_hostel_category`, `student_permanent_address`, `student_phone_no`, `student_email`, `student_father_name`, `student_father_phone_no`, `student_mother_name`, `student_mother_phone_no`, `student_blood_group`, `student_room_no`, `student_image`, `student_created_on`, `student_status`) VALUES (NULL,'$register_enrollment_no','$register_finger_no','$register_password','$register_student_name','$register_student_college','$register_student_program','$register_student_year','$register_addmission_year','$register_dob','$register_hostel','$register_hostel_category','$register_permanent_address','$register_student_phone','$register_student_email','$register_father_name','$register_father_phone','$register_mother_name','$register_mother_phone','$register_blood_group','$register_room_number','$new_fileName',NOW(),'$register_status')";
								$run_register_student = mysqli_query($con, $register_student);
									if ($run_register_student) {
										$parent_unique_id = "PR_" . $register_finger_no;
										$insert_parent = "INSERT INTO `parents`(`parent_id`, `parent_unique_id`, `parent_password`, `parent_for_student`) VALUES (NULL,'$parent_unique_id','$register_password','$register_finger_no')";
										$run_insert_parent = mysqli_query($con, $insert_parent);
											if ($run_insert_parent) {
												echo "<script>alert('Student registered Successfully, Please wait until your profile gets verified!')</script>";
												echo "<script>window.parent.location.href = '../../../';</script>";
											} else {
												$error_delete_student = "DELETE FROM students WHERE student_finger_no = '$register_finger_no' AND student_status = 'Pending'";
												$run_error_delete = mysqli_query($con, $error_delete_student);
													if ($run_error_delete) {
														echo "<script>alert('Error in registering student, please try again!')</script>";
														echo "<script>window.parent.location.href = '../../../';</script>";
													} else {
														echo "<script>alert('Error in deleting student, please try again!')</script>";
														echo "<script>window.parent.location.href = '../../../';</script>";
													}
											}
									} else {
										echo "<script>alert('Some error occurred while registration, Please try again!')</script>";
										echo "<script>window.parent.location.href = './';</script>";
									}
							} else {
								echo "<script>alert('Some error occurred while Uploading File, Please try again!')</script>";
								echo "<script>window.parent.location.href = './';</script>";
							}
						} else {
							echo "<script>alert('Uploaded image is more than 3MB in size, Please upload an image of less than 3MB!')</script>";
							echo "<script>window.parent.location.href = './';</script>";
						}
					} else {
						echo "<script>alert('Uploaded file is of $image_ext format, we only support .png, .jpg and .jpeg file type!')</script>";
						echo "<script>window.parent.location.href = './';</script>";
					}
				} else {
					echo "<script>alert('A student with similar details already exists, Please try again!')</script>";
					echo "<script>window.parent.location.href = '';</script>";
				}
		}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registration</title>

	<!-- Bootstap Styles -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Font Awesome Styles -->

	
</head>
<body>
	<div class="container">
		<?php echo "$msg"; ?>
		<form action="" method="post" enctype="multipart/form-data">
			<div class="mb-3">
				<label for="register-enrollment-no">Student's Enrollment Number:</label>
		    	<input type="text" class="form-control" name="register-enrollment-no" id="register-enrollment-no" placeholder="Enter your Enrollment Number" required style="border-radius: 0;">
		  	</div>
			<div class="mb-3">
				<label for="register-finger-no">Student's Finger Number:</label>
		    	<input type="tel" class="form-control" name="register-finger-no" id="register-finger-no" placeholder="Enter your Finger Number" pattern="[0-9]{8}" required style="border-radius: 0;">
		  	</div>
		  	<div class="mb-3">
		    	<label for="register-password">Set Password:</label>
		    	<input type="password" class="form-control" name="register-password" id="register-password" placeholder="Enter your Password" required style="border-radius: 0;">
		  	</div>
		  	<div class="mb-3">
		    	<label for="register-student-name">Student's Name:</label>
		    	<input type="text" class="form-control" name="register-student-name" id="register-student-name" placeholder="Enter your Full Name" required style="border-radius: 0;">
		  	</div>
		  	<div class="mb-3">
		    	<label for="register-student-program">Student's College:</label>
		    	<select class="form-control" name="register-student-college" id="register-student-college" required style="border-radius: 0;">
		    		<option selected disabled>Select your College</option>
		    		<?php 
		    			$get_all_colleges = "SELECT * FROM colleges WHERE college_status = 'Active'";
		    			$run_all_colleges = mysqli_query($con, $get_all_colleges);
		    			$count_all_colleges = mysqli_num_rows($run_all_colleges);
		    				if ($count_all_colleges <= 0) {
		    					echo "<option disabled>No College Available at the Moment!</option>";
		    				} else {
		    					while ($row_all_colleges = mysqli_fetch_array($run_all_colleges)) {
		    						$college_id = $row_all_colleges['college_id'];
		    						$college_code = $row_all_colleges['college_code'];
		    						$college_name = $row_all_colleges['college_name'];

		    						echo "<option value='$college_code'>$college_name</option>";
		    					}
		    				}
		    		?>
		    	</select>
		  	</div>
		  	<div class="mb-3">
		    	<label for="register-student-program">Student's Program:</label>
		    	<select class="form-control" name="register-student-program" id="register-student-program" required style="border-radius: 0;">
		    		<option selected disabled>Select your Program</option>
		    		<?php 
		    			$get_all_programs = "SELECT * FROM programs WHERE program_status = 'active'";
		    			$run_all_programs = mysqli_query($con, $get_all_programs);
		    			$count_all_programs = mysqli_num_rows($run_all_programs);
		    				if ($count_all_programs <= 0) {
		    					echo "<option disabled>No Programs Available at the Moment!</option>";
		    				} else {
		    					while ($row_all_programs = mysqli_fetch_array($run_all_programs)) {
		    						$program_id = $row_all_programs['program_id'];
		    						$program_code = $row_all_programs['program_code'];
		    						$program_name = $row_all_programs['program_name'];

		    						echo "<option value='$program_code'>$program_name ($program_code)</option>";
		    					}
		    				}
		    		?>
		    	</select>
		  	</div>
		  	<div class="mb-3">
		    	<label for="register-student-year">Student's Current Year:</label>
		    	<input type="tel" pattern="[1-5]{1}" class="form-control" name="register-student-year" id="register-student-year" placeholder="Mention Year you are studing in" required style="border-radius: 0;">
		  	</div>
		  	<div class="mb-3">
		    	<label for="register-addmission-year">Addmission Year:</label>
		    	<input type="number" class="form-control" name="register-addmission-year" id="register-addmission-year" min="<?php echo date('Y')-6; ?>" max="<?php echo date('Y'); ?>" step="1" value="<?php echo date('Y')-6; ?>" required style="border-radius: 0;">
		  	</div>
		  	<div class="mb-3">
		    	<label for="register-dateofbirth">Student's Date of Birth:</label>
		    	<input type="date" class="form-control" name="register-dateofbirth" id="register-dateofbirth" required style="border-radius: 0;">
		  	</div>
		  	<div class="mb-3">
		    	<label for="register-hostel-category">Student's Hostel:</label>
		    	<select class="form-control" name="register-hostel" id="register-hostel" required style="border-radius: 0;">
		    		<option selected disabled>Select your Hostel</option>
		    		<?php
		    			$get_hostels = "SELECT * FROM hostels WHERE hostel_status = 'Active'";
		    			$run_hostels = mysqli_query($con, $get_hostels);
		    			$count_hostels = mysqli_num_rows($run_hostels);
		    				if ($count_hostels <= 0) {
		    					echo "<option disabled>No Hostels Available at the Moment!</option>";
		    				} else {
		    					while ($row_hostels = mysqli_fetch_array($run_hostels)) {
		    						$hostel_id = $row_hostels['hostel_id'];
		    						$hostel_code = $row_hostels['hostel_code'];
		    						$hostel_name = $row_hostels['hostel_name'];

		    						echo "<option value='$hostel_code'>$hostel_name</option>";
		    					}
		    				}
		    		?>
		    	</select>
		  	</div>
		  	<div class="mb-3">
		    	<label for="register-hostel-category">Student's Hostel Category:</label>
		    	<select class="form-control" name="register-hostel-category" id="register-hostel-category" required style="border-radius: 0;">
		    		<option selected disabled>Select your Hostel Category</option>
		    		<option value="2 ST Attach">2 ST Attach</option>
		    		<option value="3 ST Attach">3 ST Attach</option>
		    		<option value="3 ST Attach">4 ST Attach</option>
		    		<option value="2 ST Common">2 ST Attach</option>
		    		<option value="3 ST Common">3 ST Attach</option>
		    		<option value="4 ST Common">4 ST Attach</option>
		    		<option value="3 ST Basement">3 ST Basement</option>
		    	</select>
		  	</div>
		  	<div class="mb-3">
		    	<label for="register-permanent-address">Student's Permanent Address:</label>
		    	<input type="text" class="form-control mb-2" name="register-permanent-address1" id="register-permanent-address1" placeholder="Apartment Name / Number" required style="border-radius: 0;">
			    <input type="text" class="form-control mb-2" name="register-permanent-address2" id="register-permanent-address2" placeholder="Street / Colony  / Area" required style="border-radius: 0;">
			    <input type="text" class="form-control mb-2" name="register-permanent-address3" id="register-permanent-address3" placeholder="Landmark" style="border-radius: 0;">
			    <input type="tel" class="form-control mb-2" name="register-permanent-address4" id="register-permanent-address4" placeholder="Pincode" pattern="[0-9]{6}" required style="border-radius: 0;">
			    <input type="text" class="form-control mb-2" name="register-permanent-address5" id="register-permanent-address5" placeholder="City" required style="border-radius: 0;">
			    <input type="text" class="form-control mb-3" name="register-permanent-address6" id="register-permanent-address6" placeholder="State" required style="border-radius: 0;">
		  	</div>
		  	<div class="mb-3">
		    	<label for="register-student-phone">Student's Phone Number:</label>
		    	<input type="tel" pattern="[0-9]{10}" class="form-control" name="register-student-phone" id="register-student-phone" placeholder="Enter you Phone Number" required style="border-radius: 0;">
		  	</div>
		  	<div class="mb-3">
		    	<label for="register-student-email">Student's E-mail:</label>
		    	<input type="email" class="form-control" name="register-student-email" id="register-student-email" placeholder="Enter your E-mail Address" required style="border-radius: 0;">
		  	</div>
		  	<div class="mb-3">
		    	<label for="register-father-name">Father's Name:</label>
		    	<input type="text" class="form-control" name="register-father-name" id="register-father-name" placeholder="Enter Father's Name" required style="border-radius: 0;">
		  	</div>
		  	<div class="mb-3">
		    	<label for="register-father-phone">Father's Phone Number:</label>
		    	<input type="tel" pattern="[0-9]{10}" class="form-control" name="register-father-phone" id="register-father-phone" placeholder="Enter Father's Phone Number" required style="border-radius: 0;">
		  	</div>
		  	<div class="mb-3">
		    	<label for="register-mother-name">Mother's Name:</label>
		    	<input type="text" class="form-control" name="register-mother-name" id="register-mother-name" placeholder="Enter Mother's Name" required style="border-radius: 0;">
		  	</div>
		  	<div class="mb-3">
		    	<label for="register-mother-phone">Mother's Phone Number:</label>
		    	<input type="tel" pattern="[0-9]{10}" class="form-control" name="register-mother-phone" id="register-mother-phone" placeholder="Enter Mother's Phone Number" required style="border-radius: 0;">
		  	</div>
		  	<div class="mb-3">
		    	<label for="register-blood-group">Student's Blood Group:</label>
		    	<select class="form-control" name="register-blood-group" id="register-blood-group" required style="border-radius: 0;">
		    		<option selected disabled>Select your Blood Group</option>
		    		<option value="A+">A+</option>
		    		<option value="A-">A-</option>
		    		<option value="B+">B+</option>
		    		<option value="B-">B-</option>
		    		<option value="AB+">AB+</option>
		    		<option value="AB-">AB-</option>
		    		<option value="O+">O+</option>
		    		<option value="O-">O-</option>
		    	</select>
		  	</div>
		  	<div class="mb-3">
		    	<label for="register-room-no">Student's Room Number:</label>
		    	<div class="input-group">
		    		<input type="tel" pattern="[0-9]{3}" class="form-control" name="register-room-no" id="register-room-no" placeholder="Enter your Room Number" required style="border-radius: 0;">
			    	<select class="form-control" name="register-room-block" id="register-room-block" required style="border-radius: 0;">
			    		<option selected disabled>Select your Block</option>
			    		<option value="A">A</option>
			    		<option value="B">B</option>
			    		<option value="C">C</option>
			    		<option value="Base">Base</option>
			    	</select>
		    	</div>
		  	</div>
		  	<div class="mb-3">
		    	<label for="register-passport-photo">Student's Passport Size Photograph:</label>
		    	<input type="file" class="form-control" name="register-passport-photo" id="register-passport-photo" required style="border-radius: 0;">
		  	</div>
			<input type="submit" class="btn btn-md btn-warning" name="register" id="register" value="Register" style="font-weight: 400; border-radius: 0;">
		</form>
	</div>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php } ?>