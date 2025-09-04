<?php 
	session_start();
	require_once '../assets/includes/db_connection.php';

	// Check Login Status
	if (!isset($_SESSION['finger_no'])) {
		echo "<script>alert('You are not authorized for this page, Please Login to continue!')</script>";
		echo "<script>window.parent.location.href = '../../login';</script>";
	} else {
		$finger_number = $_SESSION['finger_no'];
		$get_details = "SELECT * FROM students WHERE student_finger_no = '$finger_number' AND student_status = 'Active'";
		$run_details = mysqli_query($con, $get_details);
		$count_details = mysqli_num_rows($run_details);
		    if ($count_details <= 0) {
		        echo "<script>window.parent.location.href = '../../logout';</script>";
		    } else {
		        $row_details = mysqli_fetch_array($run_details);
		        	$student_enrollment_no = $row_details['student_enrollment_no'];
		            $student_finger_no = $row_details['student_finger_no'];
		            $student_name = $row_details['student_name'];
		            $student_college = $row_details['student_college'];
		            	$get_college_details = "SELECT * FROM colleges WHERE college_code = '$student_college'";
		            	$run_college_details = mysqli_query($con, $get_college_details);
		            	$row_college_details = mysqli_fetch_array($run_college_details);
		            		$student_college_name = $row_college_details['college_name'];

		            $student_course = $row_details['student_course'];
		            	$get_program_details = "SELECT * FROM programs WHERE program_code = '$student_course'";
		            	$run_program_details = mysqli_query($con, $get_program_details);
		            	$row_program_details = mysqli_fetch_array($run_program_details);
		            		$student_program_name = $row_program_details['program_name'];

		            $student_semester = $row_details['student_semester'];
		            $student_addmission_year = $row_details['student_admission_year'];
		            $student_date_of_birth = $row_details['student_date_of_birth'];
                		$student_dob = date('d M, Y', strtotime($student_date_of_birth));
                	$student_hostel = $row_details['student_hostel'];
                		$get_hostel_details = "SELECT * FROM hostels WHERE hostel_code = '$student_hostel'";
		            	$run_hostel_details = mysqli_query($con, $get_hostel_details);
		            	$row_hostel_details = mysqli_fetch_array($run_hostel_details);
		            		$student_hostel_name = $row_hostel_details['hostel_name'];

                	$student_hostel_category = $row_details['student_hostel_category'];
                	$student_permanent_address = $row_details['student_permanent_address'];
                		$display_address = wordwrap($student_permanent_address, 30, "<br>");
                	$student_phone_no = $row_details['student_phone_no'];
		            $student_email = $row_details['student_email'];
		            $student_father_name = $row_details['student_father_name'];
		            $student_father_phone_no = $row_details['student_father_phone_no'];
		            $student_mother_name = $row_details['student_mother_name'];
		            $student_mother_phone_no = $row_details['student_mother_phone_no'];
		            $student_blood_group = $row_details['student_blood_group'];
		            $student_room_no = $row_details['student_room_no'];
		            $student_image = $row_details['student_image'];
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
	<style type="text/css">
		.profile li:hover {
			background-color: #ffc03d;
			cursor: pointer;
		}

		button:hover {
			background-color: #ffc03d;
		}

		tr a {
			text-decoration: none;
			color: #000000;
		}

		a.cancel-link {
			color: #000000;
			text-decoration: none;
		}

		a.cancel-link:hover {
			font-weight: bold;
		}

		a.success-link {
			color: #ffffff;
			text-decoration: none;
		}

		a.success-link:hover {
			font-weight: bold;
		}
	</style>
	<script type="text/javascript">
		function redirectLogout() {
			window.parent.location.href = '../../logout/';
		}
	</script>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-12 mb-3">
				<div class="card profile" style="border-radius: 0;">
					<img src="./student-images/<?php echo "$student_image" ?>" class="card-img-top" alt="<?php echo "$student_name-image"; ?>" style="border-radius: 0;">
				  	<div class="card-body" style="text-align: center;">
				    	<h5 class="card-title"><?php echo "$student_name" ?></h5>
				    	<p class="card-text"><?php echo "$student_finger_no <br> $student_room_no" ?></p>
				  	</div>
				  	<ul class="list-group list-group-flush" style="border-radius: 0;">
				    	<li class="list-group-item" onclick="redirectLogout()">Logout</li></a>
				  	</ul>
				</div>
			</div>
			<div class="col-lg-8 col-md-8 col-sm-12 mb-3">
				<div class="accordion" id="accordionPanelsStayOpenExample" style="border-radius: 0;">
  					<div class="accordion-item" style="border-radius: 0;">
    					<h2 class="accordion-header" id="panelsStayOpen-headingOne" style="border-radius: 0;">
      						<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne" style="border-radius: 0;">
        						My Profile
      						</button>
    					</h2>
    					<div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne" style="border-radius: 0;">
      						<div class="accordion-body">
        						<table class="table table-hover">
								  	<tbody>
								  		<tr>
								  			<th>Enrollment No:</th>
								  			<td><?php echo "$student_enrollment_no"; ?></td>
								  		</tr>
								  		<tr>
								  			<th>College:</th>
								  			<td><?php echo "$student_college_name"; ?></td>
								  		</tr>
								  		<tr>
								  			<th>Program:</th>
								  			<td><?php echo "$student_program_name"; ?></td>
								  		</tr>
								  		<tr>
								  			<th>Year:</th>
								  			<td><?php echo "$student_semester"; ?></td>
								  		</tr>
								  		<tr>
								  			<th>Addmission Year:</th>
								  			<td><?php echo "$student_addmission_year"; ?></td>
								  		</tr>
								  		<tr>
								  			<th>Date of Birth:</th>
								  			<td><?php echo "$student_dob"; ?></td>
								  		</tr>
								  		<tr>
								  			<th>Hostel:</th>
								  			<td><?php echo "$student_hostel_name"; ?></td>
								  		</tr>
								  		<tr>
								  			<th>Hostel Category:</th>
								  			<td><?php echo "$student_hostel_category"; ?></td>
								  		</tr>
								  		<tr>
								  			<th>Phone No:</th>
								  			<td><?php echo "<a href='tel:$student_phone_no'>$student_phone_no</a>"; ?></td>
								  		</tr>
								  		<tr>
								  			<th>E-mail Adress:</th>
								  			<td><?php echo "<a href='mailto:$student_email'>$student_email</a>"; ?></td>
								  		</tr>
								  		<tr>
								  			<th>Father's Name:</th>
								  			<td><?php echo "$student_father_name"; ?></td>
								  		</tr>
								  		<tr>
								  			<th>Father's Phone No:</th>
								  			<td><?php echo "<a href='tel:$student_father_phone_no'>$student_father_phone_no</a>"; ?></td>
								  		</tr>
								  		<tr>
								  			<th>Mother's Name:</th>
								  			<td><?php echo "$student_mother_name"; ?></td>
								  		</tr>
								  		<tr>
								  			<th>Father's Phone No:</th>
								  			<td><?php echo "<a href='tel:$student_mother_phone_no'>$student_mother_phone_no</a>"; ?></td>
								  		</tr>
								  		<tr>
								  			<th>Blood Group:</th>
								  			<td><?php echo "$student_blood_group"; ?></td>
								  		</tr>
								  		<tr>
								  			<th>Permanent Address:</th>
								  			<td><?php echo "$display_address"; ?></td>
								  		</tr>
								  	</tbody>
								</table>
      						</div>
    					</div>
  					</div>
  					<div class="accordion-item" style="border-radius: 0;">
    					<h2 class="accordion-header" id="panelsStayOpen-headingTwo" style="border-radius: 0;">
      						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo" style="border-radius: 0;">
	        					Room Complaint History
      						</button>
    					</h2>
    					<div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo" style="border-radius: 0;">
      						<div class="accordion-body">
        						<div class="row">
        							<?php 
        								$get_room_complaints = "SELECT * FROM room_complaints WHERE student_finger_no = '$finger_number' AND student_room_no = '$student_room_no' AND complaint_status NOT IN ('Deleted') ORDER BY room_complaint_id DESC LIMIT 0, 6";
        								$run_room_complaints = mysqli_query($con, $get_room_complaints);
        								$count_room_complaints = mysqli_num_rows($run_room_complaints);
        									if ($count_room_complaints <= 0) {
        										echo "
        											<div class='col-lg-12 col-md-12 col-sm-12 mb3'>
        												<center>
        													<h4>You have not raised any Room Complaint as of now!</h4>
        													<p>If you want to raise a room complaint, <a href='../../raise-complaint'>Click Here</a></p>
        												</center>
        											</div>
        										";
        									} else {
        										echo "
        											<div class='col-lg-12 col-md-12 col-sm-12 mb3'>
        												<center>
        													<h6>You can only see last 6 Complaints Here!<h6>
        												</center>
        											</div>
        										";

        										while ($row_room_complaints = mysqli_fetch_array($run_room_complaints)) {
        											$room_complaint_id = $row_room_complaints['room_complaint_id'];
        											$complaint_code = $row_room_complaints['complaint_code'];
        											$complaint_category = $row_room_complaints['complaint_category'];
        											$complaint_sub_category = $row_room_complaints['complaint_sub_category'];
        											$complaint_desc = $row_room_complaints['complaint_description'];
        											$raised_on = date("d M, Y", strtotime($row_room_complaints['complaint_raised_on']));
        											$complaint_status = $row_room_complaints['complaint_status'];
        												if ($complaint_status == 'Pending') {
        													$card_class = "text-bg-info";
        													$card_footer = "
        														<div class='card-footer $card_class' style='display: flex; justify-content: space-between;'>
					        										<div class='status'>
											                        	<span style='font-weight: 500;'>Status:</span> $complaint_status
											                        </div>
											                    </div>
        													";
        												} elseif ($complaint_status == 'Assigned') {
        													$card_class = "text-bg-primary";
        													$card_footer = "
        														<div class='card-footer $card_class' style='display: flex; justify-content: space-between;'>
					        										<div class='status'>
											                        	<span style='font-weight: 500;'>Status:</span> $complaint_status
											                        </div>
											                    </div>
        													";
        												} elseif ($complaint_status == 'Denied') {
        													$card_class = "text-bg-warning";
        													$card_footer = "
        														<div class='card-footer $card_class' style='display: flex; justify-content: space-between;'>
					        										<div class='status'>
											                        	<span style='font-weight: 500;'>Status:</span> $complaint_status
											                        </div>
											                    </div>
        													";
        												} elseif ($complaint_status == 'Completed') {
        													$card_class = "text-bg-success";
        													$card_footer = "
        														<div class='card-footer $card_class' style='display: flex; justify-content: space-between;'>
					        										<div class='status'>
											                        	<span style='font-weight: 500;'>Status:</span> $complaint_status
											                        </div>
											                    </div>
        													";
        												} elseif ($complaint_status == 'Cancelled') {
        													$card_class = "text-bg-danger";
        													$card_footer = "
        														<div class='card-footer $card_class' style='display: flex; justify-content: space-between;'>
					        										<div class='status'>
											                        	<span style='font-weight: 500;'>Status:</span> $complaint_status
											                        </div>
											                    </div>
        													";
        												} elseif (strpos($complaint_status, 'Cannot be Completed') !== false) {
        													$card_class = "text-bg-secondary";
        													$card_footer = "
        														<div class='card-footer $card_class' style='display: flex; justify-content: space-between;'>
					        										<div class='status'>
											                        	<span style='font-weight: 500;'>Status:</span> $complaint_status
											                        </div>
											                    </div>
        													";
        												}

        											echo "
        												<div class='col-lg-6 col-md-6 col-sm-12 mb-3'>
					        								<div class='card'>
					        									<div class='card-header $card_class text-center'>
					        										<span style='font-weight: 500;'>Complaint Code:</span>
					        										<span>#$complaint_code</span>
					        									</div>
					        									<div class='card-body'>
					        										<table class='table table-hover table-borderless'>
											                            <tbody>
											                                <tr>
											                                    <th scope='row'>Category:</th>
											                                    <td>$complaint_category</td>
											                                </tr>
											                                <tr>
											                                    <th scope='row'>For:</th>
											                                    <td>$complaint_sub_category</td>
											                                </tr>
											                                <tr>
											                                    <th scope='row'>For:</th>
											                                    <td>$complaint_desc</td>
											                                </tr>
											                                <tr>
											                                    <th scope='row'>Raised on:</th>
											                                    <td>$raised_on</td>
											                                </tr>
											                            </tbody>
											                        </table>
					        									</div>
					        									$card_footer
					        								</div>
					        							</div>
        											";
        										}
        									}
        							?>
        						</div>
      						</div>
    					</div>
  					</div>
  					<div class="accordion-item" style="border-radius: 0;">
    					<h2 class="accordion-header" id="panelsStayOpen-headingThree" style="border-radius: 0;">
      						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree" style="border-radius: 0;">
        						Leave History
      						</button>
    					</h2>
    					<div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree" style="border-radius: 0;">
      						<div class="accordion-body">
        						<div class="row">
        							<?php 
        								$get_leave_history = "SELECT * FROM leave_applications WHERE student_finger_no = '$finger_number' ORDER BY leave_application_id DESC LIMIT 0, 6";
        								$run_leave_history = mysqli_query($con, $get_leave_history);
        								$count_leave_history = mysqli_num_rows($run_leave_history);
        									if ($count_leave_history <= 0) {
        										echo "
        											<div class='col-lg-12 col-md-12 col-sm-12 mb3'>
        												<center>
        													<h4>You have not applied for Hostel Leave as of now!</h4>
        													<p>If you want to apply for Hostel Leave, <a href='../../leave-application'>Click Here</a></p>
        												</center>
        											</div>
        										";
        									} else {
        										echo "
        											<div class='col-lg-12 col-md-12 col-sm-12 mb3'>
        												<center>
        													<h6>You can only see last 6 Applications Here!<h6>
        												</center>
        											</div>
        										";
        										while ($row_leave_history = mysqli_fetch_array($run_leave_history)) {
        											$leave_application_id = $row_leave_history['leave_application_id'];
        											$application_code = $row_leave_history['application_code'];
        											$leave_from = date("d M, Y", strtotime($row_leave_history['leave_from_date']));
        											$leave_to = date("d M, Y", strtotime($row_leave_history['leave_to_date']));
        											$reason = $row_leave_history['leave_reason'];
        											$going_to = $row_leave_history['leave_address_city'] . ", " . $row_leave_history['leave_address_state'] . ", " . $row_leave_history['leave_address_pincode'];
        											$applied_on = date("d M, Y", strtotime($row_leave_history['leave_applied_on']));
        											$leave_status = $row_leave_history['leave_status'];
        												if ($leave_status == "Pending") {
        													$card_class = "text-bg-info";
        													$card_footer = "
        														<div class='card-footer $card_class' style='display: flex; justify-content: space-between;'>
					        										<div class='status'>
											                        	<span style='font-weight: 500;'>Status:</span> $leave_status
											                        </div>
											                    </div>
        													";
        												} elseif ($leave_status == "Gatepass Generated") {
        													$card_class = "text-bg-success";
        													$card_footer = "
        														<div class='card-footer $card_class' style='display: flex; justify-content: space-between;'>
					        										<div class='status'>
					        											<a href='download_gatepass.php?application_code=$application_code' class='success-link'>Download Gate Pass</a>
											                        </div>
											                    </div>
        													";
        												} elseif ($leave_status == "Cancelled by Warden") {
        													$card_class = "text-bg-danger";
        													$card_footer = "
        														<div class='card-footer $card_class' style='display: flex; justify-content: space-between;'>
					        										<div class='status'>
											                        	<span style='font-weight: 500;'>Status:</span> $leave_status
											                        </div>
											                    </div>
        													";
        												} elseif (strpos($leave_status, 'Denied') !== false) {
        													$card_class = "text-bg-warning";
        													$card_footer = "
        														<div class='card-footer $card_class' style='display: flex; justify-content: space-between;'>
					        										<div class='status'>
											                        	<span style='font-weight: 500;'>Status:</span> $leave_status
											                        </div>
											                    </div>
        													";
        												} elseif (strpos($leave_status, 'Approved') !== false) {
        													$card_class = "text-bg-primary";
        													$card_footer = "
        														<div class='card-footer $card_class' style='display: flex; justify-content: space-between;'>
					        										<div class='status'>
											                        	<span style='font-weight: 500;'>Status:</span> $leave_status
											                        </div>
											                    </div>
        													";
        												}

        											echo "
        												<div class='col-lg-6 col-md-6 col-sm-12 mb-3'>
					        								<div class='card'>
					        									<div class='card-header $card_class text-center'>
					        										<span style='font-weight: 500;'>Application Code:</span>
					        										<span>#$application_code</span>
					        									</div>
					        									<div class='card-body'>
					        										<table class='table table-hover table-borderless'>
											                            <tbody>
											                                <tr>
											                                    <th scope='row'>From:</th>
											                                    <td>$leave_from</td>
											                                </tr>
											                                <tr>
											                                    <th scope='row'>To:</th>
											                                    <td>$leave_to</td>
											                                </tr>
											                                <tr>
											                                    <th scope='row'>Reason:</th>
											                                    <td>$reason</td>
											                                </tr>
											                                <tr>
											                                    <th scope='row'>Going To:</th>
											                                    <td>$going_to</td>
											                                </tr>
											                                <tr>
											                                    <th scope='row'>Applied on:</th>
											                                    <td>$applied_on</td>
											                                </tr>
											                            </tbody>
											                        </table>
					        									</div>
					        									$card_footer
					        								</div>
					        							</div>
        											";
        										}
        									}
        							?>
        						</div>
      						</div>
    					</div>
  					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php } ?>