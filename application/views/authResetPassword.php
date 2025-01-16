<?php #print_r($User->userType);exit(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/style_new.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/login.css'); ?>">
	<title>Reset Password</title>
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
			background-image: url('<?php echo base_url('assets/images/bg-welcome-img.jpg'); ?>');
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
		.text-secondary{
			color: #77869e;
		}
		.pin{
			color: #000;
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
					<div class="text-center">
						<img src="<?php echo base_url('assets/images/icons/loginlogo.png'); ?>" class="company-logo">
						<div class="main-title">Reset Password</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3" id="form-msg">
						
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
					<form action="<?php echo base_url('Login/exeResetPassword'); ?>" method="post" id="reset-pwd">
						<input type="hidden" name="token" value="<?php echo $this->uri->segment(4); ?>">
						<input type="hidden" name="userid" value="<?php echo $this->uri->segment(3); ?>">
						<?php if (isset($User) && $User->userType == "Staff") { ?>
						<div class="form-group">
							<label>PIN</label>
							<br>
							<input type="text" name="pin[]" class="pin" maxlength="1" required>
							<input type="text" name="pin[]" class="pin" maxlength="1" required>
							<input type="text" name="pin[]" class="pin" maxlength="1" required>
							<input type="text" name="pin[]" class="pin" maxlength="1" required>
						</div>

						<div class="form-group">
							<label>Confirm PIN</label>
							<br>
							<input type="text" name="confirm_pin[]" class="pin" maxlength="1" required>
							<input type="text" name="confirm_pin[]" class="pin" maxlength="1" required>
							<input type="text" name="confirm_pin[]" class="pin" maxlength="1" required>
							<input type="text" name="confirm_pin[]" class="pin" maxlength="1" required>
						</div>
						<?php } else { ?>
						<div class="form-group">
							<label>Password</label>
							<input type="text" name="password" class="form-control" placeholder="Enter Password">
						</div>
						<div class="form-group">
							<label>Confirm Password</label>
							<input type="text" name="confirm_password" class="form-control" placeholder="Enter Confirm Password">
						</div>
						<?php } ?>
						<button class="btn btn-info-2 btn-block btnSubmit" type="submit">Reset Password</button>
					</form>
					</div>
				</div>
			</div>
		</div>
		<div class="bottom">Powered By &nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo base_url('assets/images/icons/bottomlogo.png'); ?>"></div>
	</div>
</div>
</body>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vendor/bootstrap/bootstrap.min.js"></script>
<script>
	$(document).ready(function(){

		$(".pin").keyup(function() {
			console.log("KeyUp");
		    if(this.value.length == 1) {
		      $(this).next('.pin').focus();
		    }
		});

		$('.pin').keydown(function(e) {
		    if ((e.which == 8 || e.which == 46) && $(this).val() =='') {
		        $(this).prev('.pin').focus();
		    }
		});

		$("#reset-pwd").on("submit",function(e){
			var pin = "";
			var cpin = "";

			$("input[name='pin[]']").each(function(){
				pin = pin + $(this).val();
			});

			$("input[name='confirm_pin[]']").each(function(){
				cpin = cpin + $(this).val();
			});

			if (pin!=cpin) {
				$("#form-msg").append('<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Pins do not match!</strong></div>');
				e.preventDefault();
			}else{
				$("#reset-pwd").append('<input type="hidden" name="password" value="'+pin+'">');
			}
			
		});

	});
</script>
</html>