<?php
	
	// session_start();
	$password_header_text = 'Forgot';
	$password_button_text = 'Retrieve';
	$email = '';
	if(isset($_GET['email'])){
		$email = $_GET['email'];
		$password_header_text = 'Reset';
		$password_button_text = 'Reset';
	}

	$response = '';
	if (isset($_GET['success'])) {
		if($_GET['success'] == 1) {
			$response = "<span style='color: red;'>Something Went Wrong!!</span>";
		}elseif ($_GET['success'] == 0) {
			$response = "<span style='color: Red;'>Error. The two password are not the same</span>";
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Ekomi Recruitment - Change Password page</title>
  	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="vendor/css/bootstrap.min.css">
	<script src="vendor/js/jquery.min.js"></script>
	<script src="vendor/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?<?php echo time(); ?>">
	<link rel="shortcut icon" href="images/ekomi_gold.png" type="image/x-icon">
	<link rel="icon" href="images/ekomi_gold.png" type="image/x-icon">
</head>
<body class="container">
	<!-- header starts here -->
	<header class="container-fluid">
		<div class="row">
			<div>
				<div class="center">
					<img src="images/ekomi_gold.png" style="width:80px">
				</div>
				<div class="center">
					<p style="font-size: 18px; font-weight: bold; padding: 15px; color: #313541;">Ekomi Recruitment System</p>
				</div>
			</table>
		</div>
		<div class="row sub-header text-center">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h1 class="pa-h1 d-inline-block">Change Password</h1>
			</div>
		</div>
	</header>
	<!-- header ends here -->
	<div class="row">
		<?php echo "<div id='toast_message'> ".$response." </div>"; ?>
	</div>
	<!-- page content starts here -->
	<section id="page-container" style="min-height:55vh; height:55vh; overflow:hidden;">
		<div id="content-wrap">
			<div class="row">
				<div class="pa-tbl-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
					<div class="pa-cta-cnt" style='margin:80px;'>
						<form action="functions/functions.php" method="POST">
							<div class="col-md-6 col-md-offset-3 text-center" style="background-color: rgba(255, 255, 255, .5);">
                                <div class="form-group">
									<label for="password">New Password</label>
									<input type="password" name="newpassword" class="form-control text-center" id="newpassword" placeholder="New Password" required>
								</div>
                                <div class="form-group">
									<label for="password">Confirm Password</label>
									<input type="password" name="confirmpassword" class="form-control text-center" id="confirmpassword" placeholder="Confirm Password" required>
								</div>
								<input type="hidden" name="actionType" value="changePassword">
								<input type="hidden" name="email" value="<?php echo $email; ?>">

								<div class="pa-cta-cnt pull-center">
									<button class="primary btn">Set New Password</button>
								</div>
								<div class="clear"></div></br>
								<a href='index.php'>Log In?</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- page content ends here -->
	</section>
	<!-- footer starts here -->
	<?php include('footer.php') ?>
	<!-- footer ends here -->
</body>
</html>