<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <title>Reset password | Mykronicle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
</head>

<body id="app-container" class="menu-default show-spinner">
<?php $this->load->view('sidebar'); ?> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
<main>
<div class="container settingsContainer">
<?php if ($this->session->flashdata('success')): ?>
        <p style="color: green;"><?php echo $this->session->flashdata('success'); ?></p>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <p style="color: red;"><?php echo $this->session->flashdata('error'); ?></p>
    <?php endif; ?>

    <div class="pageHead">
		<h1>Settings</h1>
    </div>
	<div class="settingsView">
		<form action="" method="post">
			<!-- <div class="sideMenu">
				 $this->load->view('settings-menu-sidebar');   add php tag here
			</div> -->

				<div class="formDiv">
 
    <div class="form-group">
        <label for="change_pin">Pin</label>
        <input type="password" class="form-control" name="change_pin" id="change_pin" 
               style="width: 40%;" maxlength="4" pattern="\d{4}" title="Enter 4 digits only" required>
        <span toggle="#password-field" class="fa fa-fw fa-eye-slash field_icon toggle-password2"></span>
    </div>
    <div class="form-group">
        <label for="confirm_pin">Confirm Pin</label>
        <input type="password" class="form-control" name="confirm_pin" id="confirm_pin" 
               style="width: 40%;" maxlength="4" pattern="\d{4}" title="Enter 4 digits only" required>
        <span toggle="#password-field" class="fa fa-fw fa-eye-slash field_icon toggle-password3"></span>
    </div>
</div>

				<div class="formSubmit">
					<button type="submit" style="border:2px solid blue;" class="btn btn-default btnBlue">Save</button>
				</div>
			</div>
		</form>
	</div>
	
</div>
</main>



    <script>


	$(document).on('click', '.toggle-password2', function() {

			$(this).toggleClass("fa-eye fa-eye-slash");

			var input = $("#change_pin");		
			input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password');


	});

	$(document).on('click', '.toggle-password3', function() {

			$(this).toggleClass("fa-eye fa-eye-slash");
			var input = $("#confirm_pin");		
			input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password');



	});
    </script>


<?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>
</body>
</html>
