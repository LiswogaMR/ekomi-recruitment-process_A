<?php
	
	ini_set("log_errors", 1);
	ini_set("error_log", "error.txt");
	error_log( "Hello, errors!" );

	$response = '';
	if (isset($_GET['success'])) {
		if($_GET['success'] == 1) {
			$response = "<span style='color: red;'>Incorrect password!</span>";
		}elseif ($_GET['success'] == 0) {
			$response = "<span style='color: Red;'>Error. User does not exist</span>";
		}
	}

	session_start();
	// if(isset($_SESSION['id']))
	// 	header("Location: employee.php");
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ekomi Recruitment - Index page</title>
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
				<h1 class="pa-h1 d-inline-block">Login</h1>
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
									<label for="email" >Email</label>
									<input type="input" name="email" class="form-control text-center" id="email" aria-describedby="emailHelp" placeholder="Enter email" required>
									<small id="emailHelp" class="form-text text-muted">Please use you email address.</small>
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" name="password" class="form-control text-center" id="password" placeholder="Password" required>
								</div>
								<input type="hidden" name="actionType" value="login">
								<button class="primary btn">Login</button>
								<div class="clear"></div></br>
								<a href='forgot-password.php'>Forgot password?</a>
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