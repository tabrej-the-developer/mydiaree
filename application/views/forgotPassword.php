 <!DOCTYPE html>
<html lang="en">
<head>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/style_new.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/login.css'); ?>">
	<title>Forgot Password</title>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@200&display=swap');
		@import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@500&display=swap');
		@import url('https://fonts.googleapis.com/css2?family=Stoke&display=swap');
		body{
			font-family: 'Nunito', sans-serif; 
			font-weight: 400;
			background: #F7FAFE;
		}
		.form-control{
			border: none;
			border-bottom: 1px solid #77869E;
			width: 100%;
			background-color: transparent;
			outline:none;
			margin-right: 5px;
			color: #000;
		}
		.btn-info-2{
			display: inline-block;
			width: 100%;
			background: #297DB6;
			font-family: 'Nunito', sans-serif; 
			color: #fff;
		}
		.btn-info-2:hover{
			background-color: #0047CC;
			color: #fff;
		}
		.company-logo{
			margin: 100px 0px 50px 0px;
			height:48px;
			width:68px;
		}
		.main-title{
			font-family: 'Roboto Slab', serif;
			font-size: 24px;
			color: #1B2E4B;
			margin-bottom: 60px;
		}
		label{ 
			color: #77869E; 
			font-family: 'Nunito', sans-serif; 
			font-weight: 400;
		}
		.link{
			text-decoration: none;
			font-family: 'Nunito', sans-serif; 
			color: #0047CC;
			margin:15px 0px;
		}
		.link:hover{
			text-decoration: none;

		}
		.left-title{
			background-image: url('../assets/images/bg-welcome-img.jpg');
			background-size: cover;
			background-repeat: no-repeat;
			height: 100vh;
		}
		.left-title>h3{
			font-family: Roboto Slab;
			font-style: normal;
			font-weight: normal;
			font-size: 36px;
			line-height: 47px;
			padding-top: 200px;
		}
		.left-title>h1{
			margin-top: 50px;
			font-family: 'Stoke', serif;
			font-style: normal;
			font-weight: normal;
			font-size: 36px;
			line-height: 45px;
		}
	</style>
</head>
<body>
<div id="wrapper">
	<div class="container-fluid" style="padding:0px;">
		<div class="row">
			<div class="col-md-6 text-center">
				<div class="left-title">
					<h3>Welcome to</h3>
					<h1>MyDiaree</h1>
				</div>
			</div>
			<?php 
				if (isset($_GET['email'])) {
					$email = $_GET['email'];
				} else {
					$email = "";
				}
				
			?>
			<div class="col-md-6">
				<div class="row">
					<div class="text-center">
						<img src="<?php echo base_url('assets/images/icons/loginlogo.png'); ?>" class="company-logo">
						<div class="main-title">Forgot Password</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3" id="form-msg">
						<?php 
							if (isset($Status)) {
								if ($Status=="SUCCESS") {
						?>
						<div class="alert alert-success" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<strong><?php echo $Message; ?></strong>	
						</div>
						<?php
								} elseif ($Status=="ERROR") {
						?>
						<div class="alert alert-danger" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<strong><?php echo $Message; ?></strong>	
						</div>
						<?php
								}
							}
						?>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
					<form action="<?php echo base_url('login/exeForgotPassword'); ?>" method="get" id="forgot-pwd">
						<div class="form-group">
							<label>E-mail Address</label>
							<input type="email" name="txtEmail" id="txtEmail" class="form-control" value="<?php echo $email; ?>">
						</div>
						<a href="<?php echo base_url(); ?>" class="link pull-right">Go to Login Page!</a>
						<button class="btn btn-info-2 btn-block" type="submit">Send Reset Link</button>
					</form>
					</div>
				</div>
			</div>
		</div>
		<div class="bottom">Powered By &nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo base_url('assets/images/icons/bottomlogo.png'); ?>"></div>
	</div>
</div>
</body>
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/vendor/bootstrap/bootstrap.min.js"></script>
<script>
	$(document).ready(function(){
		$("#forgot-pwd").on("submit",function(e){
			var txtEmail = $("#txtEmail").val();
			var errMsg = "";
			var errVar = 0;
			if (txtEmail=="") {
				errMsg = "Please enter your email";
				errVar = 1;
				$("#form-msg").append('<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+errMsg+'</div>');
			}

			if (errVar==1) {
				e.preventDefault();
			}


		});
	});
</script>
</html>