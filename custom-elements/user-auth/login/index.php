<?php 
	session_start();
	require_once '../../assets/includes/db_connection.php';

	if (isset($_SESSION['finger_no'])) {
		echo "<script>window.parent.location.href = '../../../';</script>";
	} else {
		$msg = "";
		if (isset($_POST['login'])) {
			$login_finger_number = $_POST['login-finger-no'];
			$login_password = $_POST['login-password'];

			$get_student = "SELECT * FROM students WHERE student_finger_no = '$login_finger_number' AND student_login_password = '$login_password' AND student_status = 'active'";
			$run_student = mysqli_query($con, $get_student);
			$count_student = mysqli_num_rows($run_student);
			if ($count_student <= 0) {
				$msg = "<div class='alert alert-danger' role='alert'>Student with Similar Credentials Not Found!</div>";
			} else {
				$_SESSION['finger_no'] = $login_finger_number;
				echo "<script>window.parent.location.href = '../../../';</script>";
			}
		}

		if (isset($_POST['register'])) {
			echo "<script>window.parent.location.href='../../../student-registration';</script>";
		}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>

	<!-- Bootstap Styles -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Font Awesome Styles -->

	
</head>
<body>
	<div class="container">
		<?php echo "$msg"; ?>
		<form action="" method="post">
			<div class="mb-3">
				<label for="login-finger-no">Finger Number:</label>
		    	<input type="tel" class="form-control" name="login-finger-no" id="login-finger-no" placeholder="Enter your Finger Number" pattern="[0-9]{8}" required style="border-radius: 0;">
		  	</div>
		  	<div class="mb-3">
		    	<label for="login-password">Password:</label>
		    	<input type="password" class="form-control" name="login-password" id="login-password" placeholder="Enter your Password" required style="border-radius: 0;">
		  	</div>
			<input type="submit" class="btn btn-md btn-warning" name="login" id="login" value="LOGIN" style="font-weight: 400; border-radius: 0;">
		</form>
		<br>
		<form action="" method="post">
			<input type="submit" class="btn btn-md btn-primary" name="register" id="register" value="Not have an Account?" style="font-weight: 400; border-radius: 0;">
		</form>
	</div>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php } ?>