<?php 
	require_once '../assets/includes/db_connection.php';

	$msg = "";
	if (isset($_POST['contact-submit'])) {
		$contact_name = $_POST['contact-name'];
		$contact_email = $_POST['contact-email'];
		$contact_phone = $_POST['contact-phone'];
		$contact_subject = $_POST['contact-subject'];
		$contact_message = $_POST['contact-message'];

		$insert_query = "INSERT INTO `contact_query`(`contact_query_id`, `contact_query_name`, `contact_query_email`, `contact_query_phone`, `contact_query_subject`, `contact_query_message`, `contact_query_created_on`, `contact_query_status`) VALUES (NULL,'$contact_name','$contact_email','$contact_phone','$contact_subject','$contact_message',NOW(),'0')";
		if ($run_query = mysqli_query($con, $insert_query)) {
			$msg = "<div class='alert alert-success alert-dismissable fade show' role='alert'>Your query has been successfully sent.</div>";
			// echo "<script>window.parent.location.href = '../../';</script>";
		} else {
			$msg = "<div class='alert alert-warning' role='alert'>There has been an error while sending your query.</div>";
			// echo "<script>window.parent.location.href = '../../';</script>";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Contact Form</title>

	<!-- Bootstap Styles -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Font Awesome Styles -->

	<style type="text/css">
		body{
			background: transparent;
		}
	</style>
</head>
<body>
	<div class="container">
		<?php echo "$msg"; ?>
		<form action="" method="post">
			<div class="mb-3">
		    	<input type="text" class="form-control" name="contact-name" id="contact-name" placeholder="Enter your Name" required style="border-radius: 0;">
		  	</div>
		  	<div class="mb-3">
		    	<input type="email" class="form-control" name="contact-email" id="contact-email" placeholder="Enter your Email Address" required style="border-radius: 0;">
		  	</div>
		  	<div class="mb-3">
			    <input type="tel" pattern="[0-9]{10}" class="form-control" name="contact-phone" id="contact-phone" placeholder="Enter your Phone Number" required style="border-radius: 0;">
		  	</div>
		  	<div class="mb-3">
			    <input type="text" class="form-control" name="contact-subject" id="contact-subject" placeholder="Enter your Subject" required style="border-radius: 0;" maxlength="255">
		  	</div>
		  	<div class="mb-3">
			    <textarea class="form-control" name="contact-message" id="contact-message" placeholder="Enter your Message" required rows="5" style="resize: none; border-radius: 0;"></textarea>
		  	</div>
		  	<input type="submit" class="btn btn-md btn-warning" name="contact-submit" id="contact-submit" value="SEND MESSAGE" style="font-weight: 400; border-radius: 0;">
		</form>
	</div>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>