<?php
	session_start();
	$password_header_text = 'Forgot';
	$password_button_text = 'Retrieve';
	$email = '';
	if(isset($_GET['email'])){
		$email = $_GET['email'];
		$password_header_text = 'Reset';
		$password_button_text = 'Reset';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ekomi Recruitment - Forgot Password page</title>
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
				<h1 class="pa-h1"><?php echo $password_header_text; ?> Password</h1>
			</div>
		</div>
	</header>
	<!-- header ends here -->
	<?php 
		if(strlen($_SESSION['msg'])){
			echo "<div id='toast_message'> ".$_SESSION['msg']." </div>";
		}
		$_SESSION['msg'] = '';
	?>
	<script type="text/javascript">
		$('#toast_message').delay(2500).fadeOut();
	</script>
	<!-- page content starts here -->
	<section id="page-container" style="min-height:60vh; height:60vh; overflow:hidden;">
		<div id="content-wrap">
			<div class="row">
				<div class="pa-tbl-cnt col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
					<div class="pa-cta-cnt" style='margin:80px;'>
						<form action="functions/functions.php" method="POST">
							<div class="col-md-6 col-md-offset-3 text-center" style="background-color: rgba(255, 255, 255, .5);">
								<div class="form-group">
									<label for="email" >Email</label>
									<input type="input" name="email" class="form-control text-center" id="email" aria-describedby="emailHelp" placeholder="Enter email" value="<?php echo $email; ?>">
									<small id="emailHelp" class="form-text text-muted">Please use you email address.</small>
								</div>
								<input type="hidden" name="actionType" value="forgotPassword">
								<button class="primary btn"><?php echo $password_button_text; ?></button>
								<div class="clear"></div></br>
								<a href='index.php'>Login?</a>
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