<!DOCTYPE html>
<html lang="en">
<head>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/style_new.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/login.css'); ?>">
	<title>Login</title>
	<style>
		/* @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@200&display=swap');
		@import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@500&display=swap');
		@import url('https://fonts.googleapis.com/css2?family=Stoke&display=swap'); */
		.pb-50{
			padding-bottom: 50px;
		}
		body{
			font-family: 'Nunito', sans-serif; 
			font-weight: 400;
			background: #F7FAFE;
		}
		label{ 
			color: #77869E; 
			font-family: 'Nunito', sans-serif; 
			font-weight: 400;
		}
		input[type="checkbox"]{
			margin:0;
		}
		.ptb-12 {
			padding:12px 0px;
		}
		.pin{
			border: none;
			border-bottom: 1px solid #77869E;
			width: 40px;
			float: left;
			background-color: transparent;
			outline:none;
			margin-right: 10px;
			text-align: center;
			padding: 2px;
			color: #000;
		}
		.form-control{
			border: none;
			border-bottom: 1px solid #D8D8D8;
			width: 100%;
			background-color: transparent;
			outline:none;
			margin-right: 5px;
			color: #000;
			border-radius: 0px;
		}
		.form-control:focus{
			border-bottom: 1px solid #77869E;
		}
		.btn-info-2{
			display: inline-block;
			width: 100%;
			background: #297DB6;
			font-family: 'Nunito', sans-serif; 
			color: #fff;
		}
		.btn-info-2:hover{
			background-color: #297DB6;
			color: #fff;
		}
		.company-logo{
			margin: 50px 0px 50px 0px;
			height:48px;
			width:68px;
		}
		.main-title{
			font-family: 'Roboto Slab', serif;
			font-size: 24px;
			color: #1B2E4B;
			margin-bottom: 40px;
		}
		label{ 
			color: #77869E; 
			font-family: 'Nunito', sans-serif; 
			font-weight: 400;
		}
		.link{
			text-decoration: none;
			font-family: 'Nunito', sans-serif; 
			color: #297DB6;
		}
		.link:hover{
			text-decoration: none;
		}
		.extra-links{
			text-decoration: none;
			font-family: 'Nunito', sans-serif; 
			color: #000;
			text-align: center;
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
		.login-form{
			padding:15px;
		}
		.text-danger{
			color: #FF0000!important;
		}
		.unErrMsg{
			padding: 5px 0px;
		}
	</style>
</head>
<body>
	<?php
	   if(empty($type)){
		$type = " ";
	   }
	?>
	<div id="wrapper">
		<div class="container-fluid" style="padding:0px;">
			
			<div class="split leftImg left">
				<!-- <img src="<?php // echo base_url('assets/images/icons/Rectangle1.png'); ?>"  >
				<img src="<?php // echo base_url('assets/images/icons/Rectangle2.png'); ?>" >
				<span class="leftspan">  Welcome to </span>
				<span class="leftspan1"> MY KRONICLE </span> -->
				<img src="<?php echo base_url('assets/images/OBJECTS.png'); ?>">
			</div>
				<div class="split1 right rightCont">
				<div class="logoMykronicle"><img src="<?php echo base_url('assets/images/MYDIAREE-new-logo.png'); ?>"></div>
		
					<div class="midCont">
						<?php //print_r($data); exit; ?>
						
						<form class="login-form" id="login-form" action="<?php echo base_url('login/Userlogin'); ?>" method="post" autocomplete="off">
							<input type="hidden" value="<?php echo $type; ?>" name="type">
							<h3 class="headTitle"><?php if(!empty($heading)){ echo $heading; }else{ echo " ";} ?> Login</h3>
							<?php 
								if ($type == "Superadmin" || $type == "Parent") {
							?>
							
							<div class="form-group">
								<!-- <label for="username">Username</label>
								<br> -->
								<input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo isset($email)?$email:''; ?>">
								<span class="unErrMsg text-danger"></span>
							</div>
							<div class="form-group PassField">
								<!-- <label for="password">Password</label>
								<br> -->
								<input type="password" class="form-control password" name="password" placeholder="Password" value="" id="password">
								<input type="checkbox" onclick="myFunction()">
								<span id="viewPassword"></span>
								<div class="pwErrMsg text-danger"></div>
							</div>
							<?php 
								} else if ($type == "Staff") {
							?>
							<div class="form-group">
								<!-- <label for="employeeCode">Employee Code</label>
								<br> -->
								<input type="text" class="form-control" name="username" placeholder="Employee Code" value="<?php echo isset($email)?$email:''; ?>" id="username">
								<div class="unErrMsg text-danger"></div>
							</div>
							<div class="form-group">
								<!-- <label for="pin">PIN</label>
								<br> -->
								<input type="text" name="pin[]" class="pin" maxlength="1" fieldType="pin">
								<input type="text" name="pin[]" class="pin" maxlength="1" fieldType="pin">
								<input type="text" name="pin[]" class="pin" maxlength="1" fieldType="pin">
								<input type="text" name="pin[]" class="pin" maxlength="1" fieldType="pin">
								
								<p class="pinErrMsg text-danger"></p>
							</div>
							<?php } ?>	
							<?php 
							if(!empty($errorText)){ ?>
							<div style="color:red;"><?php echo $errorText; ?></div>
							<?php } ?>

							<!-- <div id="error-message" style="color:red; display:none;"></div> -->


							<div class="form-group">
								<div class="row ">
									<div class="col-sm-6">
										<div class="form-group">
											<input type="checkbox" name="remember" id="remember-me">
											<label for="remember-me">Remember Me</label>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<a href="<?php echo base_url('login/forgotPassword'); ?>" class="link pull-right">Forgot Password?</a>
										</div>
									</div>
								</div>
							</div>
							<button class="btn btn-info-2 btn-block btnSubmit" type="submit">Login</button>
						</form>
							<div class="extra-links">
								Not a <?php if(!empty($heading)){ echo $heading; }else{ echo " ";} ?>? <a href="<?php echo base_url('welcome/account'); ?>">Go Back to Login Type!</a>
							</div>
					</div>
					<div class="bottom">Powered By &nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo base_url('assets/images/icons/bottomlogo.png'); ?>"></div>
				</div>
		</div>
	</div>
	<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>

	<!-- <script>
		document.getElementById('login-form').onsubmit = function(event) {
			event.preventDefault(); // Prevent default form submission

			const formData = new FormData(this);
			fetch(this.action, {
				method: 'POST',
				body: formData,
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					// Redirect on successful login
					window.location.href = data.redirect;
				} else {
					// Show error message
					const errorMessageDiv = document.getElementById('error-message');
					errorMessageDiv.innerText = data.error;
					errorMessageDiv.style.display = 'block'; // Show the error message
				}
			})
			.catch(error => console.error('Error:', error));
		};
    </script> -->

	<script>
		$(document).ready(function(){

			$(".pin").keyup(function() {
			    if(this.value.length == 1) {
			      $(this).next('.pin').focus();
			    }
			});

			$('.pin').keydown(function(e) {
			    if ((e.which == 8 || e.which == 46) && $(this).val() =='') {
			        $(this).prev('.pin').focus();
			    }
			});

			$('.login-form').on('submit',function(e){
				e.preventDefault();
				
				var staffPin = [];
				var username = "";
				var password = "";
				var password1 = "";
				var password2 = "";

				if ($('#username').val()=="") {
					$('#username').css("border-bottom-color","#FF0000");
					$('.unErrMsg').text("Oops! Looks like you missed this field.");
				}else{

					if($('#username').val().length > 80){
						$('#username').css("border-bottom-color","#FF0000");
						$('.unErrMsg').text("Username is very large to send!");
					}else{
						username = $('#username').val();
					}
				}

				if ($('#password').val()=="") {
					$('#password').css("border-bottom-color","#FF0000");
					$('.pwErrMsg').text("Password field is left blank!");
				}else{
					password1 = $('#password').val();
				}

				$("input[name='pin[]']").each(function() {
				    var value = $(this).val();
				    if (value) {
				        staffPin.push(value);
				    }
				});

				if(staffPin.length === 0){
					$('.pin').css("border-bottom-color","#FF0000");
					$('.pinErrMsg').text("Please enter pin to continue!");
				}else{
					password2 = staffPin[0]+staffPin[1]+staffPin[2]+staffPin[3];
				}

				if (password1 === null || password1 === undefined) {
					password = password2;
				}else{
					password = password1;
				}
				
				if (username !="" && password !="") {
				    
				    $(this).unbind('submit').submit();

				}
			});



		});

		function myFunction() {
			var x = document.getElementById("password");
			if (x.type === "password") {
				x.type = "text";
			} else {
				x.type = "password";
			}
			}
	</script>
</body>
</html>