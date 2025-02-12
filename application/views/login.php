<!DOCTYPE html>
<html lang="en">
<head>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/style_new.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/login.css'); ?>">
	<title>Welcome to MY Mydiaree</title>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@200&display=swap');
		@import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@500&display=swap');
		@import url('https://fonts.googleapis.com/css2?family=Stoke&display=swap');
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
			border-bottom: 1px solid #77869E;
			width: 100%;
			background-color: transparent;
			outline:none;
			margin-right: 5px;
			color: #000;
		}
		.mt-3{
			margin-top: 30px;
		}
		.link{
			text-decoration: none;
			font-family: 'Nunito', sans-serif; 
			color: #297DB6;
		}
		.link:hover{
			text-decoration: none;

		}

		/*.btn-info-2{
			background: #297DB6;
			font-family: 'Nunito', sans-serif; 
			color: #fff;
		}
		 .btn-info-2:hover{
			background-color: #297DB6;
			color: #fff;
		} */
		
		
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
			background-color: #297DB6;
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
			color: #297DB6;
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
<!-- <div id="wrapper">
	<div class="container-fluid">
		<div class="col-md-6">
			
		</div>
		<div class="col-md-6">
			
		</div>
	</div>
</div> -->
<div class="split left">
  <img src="<?php echo base_url('assets/images/icons/Rectangle1.png'); ?>"  >
 <img src="<?php echo base_url('assets/images/icons/Rectangle2.png'); ?>" >
 <span class="leftspan">  Welcome to </span>
 <span class="leftspan1"> MY Mydiaree </span>
</div>

<div class="split1 right">
	<span class="rightlogo"><img src="<?php echo base_url('assets/images/icons/loginlogo.png'); ?>" style="height:38px;width:58px;"></span>
  </br>
	<span class="righttitle"><?php echo $heading; ?> Login</span>
	</br>
	
<?php 
	
	if ($_GET['type'] == "Staff") {
?>
<div class="container" style="margin-left: 40px;">
	<div class="row">
		<div class="col-md-3 col-md-offset-1">
			<form method="post" onsubmit="return validateForm();" action="<?php echo base_url('login/Userlogin'); ?>">
				<div class="form-group">
					<label for="employeeCode">Employee Code</label>
					<br>
					<input type="text" class="form-control" name="user_name" value="<?php echo isset($email)?$email:''; ?>" id="user_name" placeholder="">
				</div>
				<div class="form-group">
					<label for="pin">PIN</label>
					<br>
					<input type="text" name="pin[]" class="pin" maxlength="1" required>
					<input type="text" name="pin[]" class="pin" maxlength="1" required>
					<input type="text" name="pin[]" class="pin" maxlength="1" required>
					<input type="text" name="pin[]" class="pin" maxlength="1" required>
				</div>
				<div class="form-group mt-3">
					<a href="login/forgotPassword" class="link pull-right">Forgot Password?</a>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-info-2 btn-block">Login</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
	} else {
?>
<div class="centered">
	<form method="post" onsubmit="return validateForm();" action="<?php echo base_url('login/Userlogin'); ?>">    
	<div>
		</br>
		</br>
		</br>
		<div class="label">Username</div>
	    <input type="text" name="user_name" value="<?php echo isset($email)?$email:''; ?>" id="user_name" placeholder="" class="input-group">
	</div>
	<div>
		<div class="label">Password</div>
	    <input type="password" name="password" value="<?php echo isset($password)?$password:''; ?>" id="password" placeholder="" class="input-group">
	    <span id="viewPassword"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
		<?php if(!empty($errorText)){ ?>
		<div style="color:red"><?php echo $errorText; ?></div>
		<?php } ?>
	</div>
	<table style="width: 100%;">
  		<tr>
  			<td class="alignLeft"><input type="radio">&nbsp;&nbsp;Remember Me</td>
  			<td class="alignRight"><a>Forgot Password?</a></td>
  		</tr>
	</table>
	</br>
	</br>
	<button type="submit" class="button-group">Login</button>
	</form>
</div>
<?php } ?>
	<div class="bottom" >Powered By &nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo base_url('assets/images/icons/bottomlogo.png'); ?>" ></div>
</div>
</body>
<script src="assets/js/jquery.min.js"></script>
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