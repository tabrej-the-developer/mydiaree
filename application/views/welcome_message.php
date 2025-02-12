<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Welcome to MY Mydiaree</title>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/login.css'); ?>">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<style>
			.mainRow {
				width:80% !important;
			}
		</style>
	</head>
	<body>
		<div class="split leftImg left">
			<img src="<?php echo base_url('assets/images/OBJECTS.png'); ?>">
		</div>

		<div class="split1 right rightCont">
			<div class="logoMykronicle ">
				<img src="<?php echo base_url('assets/images/MYDIAREE-new-logo.png'); ?>">
			</div>
			<div class="midCont">
				<span class="righttitle ">Select User type</span>
				<div class="mainRow">
					<div class="Column ">
						<a href="<?php echo base_url('login?type=Superadmin'); ?>">
							<img src="<?php echo base_url('assets/images/adminIcon.png'); ?>">
							<span class="typename">Admin</span>
						</a>
					</div>
					&nbsp;&nbsp;
					<div class="Column ">
						<a href="<?php echo base_url('login?type=Staff'); ?>">
							<img src="<?php echo base_url('assets/images/staffIcon.png'); ?>" >
							<span class="typename">Staff</span>
						</a>
					</div>
					&nbsp;&nbsp;
					<div class="Column ">
						<a href="<?php echo base_url('login?type=Parent'); ?>">
							<img src="<?php echo base_url('assets/images/parentIcon.png'); ?>" >
							<span class="typename">Parent</span>
						</a>
					</div>
				</div>
			</div>

			<div class="bottom" >
				Powered By &nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo base_url('assets/images/icons/bottomlogo.png'); ?>" >
			</div>
		</div>
	</body>
	<script src="assets/js/jquery-3.2.1.min"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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