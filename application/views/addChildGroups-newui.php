<?php

	$data['name']='Child Group Settings'; 
	// $this->load->view('header',$data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Mydiaree</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js?id=1234"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?id=1234" />

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?id=1234" />
	<link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2-bootstrap.min.css?id=1234" />
</head>

<body id="app-container" class="menu-default show-spinner">
<?php $this->load->view('sidebar'); ?> 
<main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Reset Password</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Settings</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Add Child</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
			<div class="row">
				<div class="col-md-4 offset-md-4">
					<div class="card d-flex flex-row">
						<div class="card-body">
						<div class="settingsView">
		<!-- <div class="sideMenu">
			<php $this->load->view('settings-menu-sidebar'); ?>
		</div> -->
		<form action="<?php echo base_url("Settings/saveChildGroup"); ?>" method="post" enctype="multipart/form-data">
			<div class="rightFOrmSection">
				<?php if (isset($_GET['groupId'])) { ?>
					<h3>Edit Child Group</h3>
				<?php } else { ?>
					<h3>Add Child Group</h3>
				<?php } ?>

				<?php if (isset($_GET['groupId'])) { ?>
					<input type="hidden" name="groupId" value="<?php echo $_GET['groupId']; ?>">
				<?php } ?>

				<div class="formDiv">
					<div class="form-group">
						<label for="name">Group Name</label>
						<input type="text" class="form-control" id="name" name="name" value="<?php echo isset($groupData->name)?$groupData->name:""; ?>">
					</div>
					<div class="form-group">
						<label for="description">Description</label>
						<textarea class="form-control" id="description" name="description"><?php echo isset($groupData->description)?$groupData->description:""; ?></textarea>
					</div>
					<div class="form-group">
						<label>Select Children</label>
						<select class="js-example-basic-multiple form-control select2-multiple" multiple="multiple" name="children[]">
							<?php 
								if (empty($groupData->children)) {
									foreach ($children as $child => $cobj) {
							?>
							<option value="<?php echo $cobj->id; ?>"><?php echo $cobj->name; ?></option>
							<?php
									}
								}else{
									foreach ($children as $child => $cobj) {
									$val = NULL;
									foreach ($groupData->children as $key => $chobj) {
										if ($chobj->child_id == $cobj->id) {
											$cid = $cobj->id;
											$val = $cobj->name;
										}									
									}
									if ($val!=NULL) {
							?>
							<option value="<?php echo $cid; ?>" selected><?php echo $val; ?></option>
							<?php
									}else{
							?>
							<option value="<?php echo $cobj->id; ?>"><?php echo $cobj->name; ?></option>
							<?php
									}
								}											}
							?>
						</select>
					</div>				

				</div>
				
				<div class="formSubmit text-right">
					<input type="submit" class="btn btn-default btnBlue pull-right btn-primary" value="SAVE">
				</div>
			</div>
		</form>
	</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </main>
<?php $this->load->view('footer_v3'); ?>
	<script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?id=1234"></script>
	<script src="<?= base_url('assets/v3'); ?>/js/vendor/select2.full.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?id=1234"></script>
</body>
</html>




<!-- <php $this->load->view('footer'); ?>
<script>
	$(document).ready(function(){
		
	});
</script>		 -->