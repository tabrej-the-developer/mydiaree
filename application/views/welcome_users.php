<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Mydiaree</title>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<script src='https://kit.fontawesome.com/a076d05399.js'></script>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/login.css'); ?>">
</head>
<body>
 
<div class="split leftImg left">
		<img src="<?php echo base_url('assets/images/OBJECTS.png'); ?>">
</div>

<div class="split1 right rightCont">
		<div class="logoMykronicle"><img src="<?php echo base_url('assets/images/MYDIAREE-new-logo.png'); ?>"></div>
		
	<div class="midCont">	
		<div class="page-sub-title">Choose an account</div>
		</br>
		<div class="mainRowRightPart">
			<?php foreach($users as $user) { ?>
			<div class="rightdiv">
				<div><img src="<?php echo base_url('assets/images/icons/Vector.png'); ?>"></div>
				<div style="margin-left: 10px;">
					<div class="rightuser">
						<a href="<?php echo base_url('login?user_name='.$user->username).'&type='.$user->userType; ?>"><?php echo $user->name; ?></a>
					</div>
					<div class="rightuser"><?php echo $user->userType; ?></div>
				</div>
			</div>
			<?php } ?>
			<div class="rightdiv">
				<div><img src="<?php echo base_url('assets/images/icons/Vector1.png'); ?>"></div>
				<div style="margin-left: 10px;">
					<div class="rightuser" style="padding-top: 5px;">
						<a href="<?php echo base_url('welcome/account'); ?>">
							<span style="color:#297DB6;">Use another account</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	

  
	<div class="bottom" >
		Powered By &nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo base_url('assets/images/icons/bottomlogo.png'); ?>" >
	</div>
</div>

</body>
<script src="assets/js/jquery-3.2.1.min"></script>
<script>
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