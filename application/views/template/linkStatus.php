 <!DOCTYPE html>
<html lang="en">
<head>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/style_new.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/login.css'); ?>">
	<title><?php echo $Message; ?></title>
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
		.text-dark{
			font-size: 18px;
		    margin-top: 15px;
			color:  #1B2E4B;
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
					<h1>MY KRONICLE</h1>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12">
						<div class="text-center">
						<?php
							if(isset($Status)){
								if ($Status == "SUCCESS") {
						?>
						<img src="<?php echo base_url("assets/images/icons/Tick.svg"); ?>" class="company-logo">
						<div class="main-title"><?php echo $Status; ?></div>
						<p class="text-dark"><?php echo $Message; ?></p>
						<?php } else { ?>
						<img src="<?php echo base_url("assets/images/icons/Cross.svg"); ?>" class="company-logo">
						<div class="main-title"><?php echo $Status; ?></div>
						<p class="text-dark"><?php echo $Message; ?></p>
						<?php
								}
							} else {
								redirect(base_url());
							}
						?>
						</div>
						<div class="text-center" style="margin-top: 20px;">
							<a href="<?php echo base_url(); ?>">Back to Homepage!</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="bottom">Powered By &nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo base_url('assets/images/icons/bottomlogo.png'); ?>"></div>
	</div>
</div>
</body>
<script src="../assets/js/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		
	});

	function validateForm()
	{
		if($('#user_name').val()=='')
		{
			alert('Please Enter User Name');
			return false;
		}
		if($('#password').val()=='')
		{
			alert('Please Enter Password');
			return false;
		}
	}
</script>
</html>