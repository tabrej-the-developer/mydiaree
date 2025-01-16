<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Center Settings | Mykronicle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
	<style>
	</style>
</head>

<body id="app-container" class="menu-default show-spinner">
	<?php 
		$this->load->view('sidebar'); 
		//PHP Block
		if (isset($_GET['centerId'])) {
			$label = "Edit Center";
		}else{
			$label = "Add Center";
		}
	?> 
	<main>
		<div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1><?= $label; ?></h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Settings</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('settings/centerSettings'); ?>">Center Settings</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?= $label; ?></li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>

            <div class="row mb-3">
            	<div class="col-md-12">
            		<div class="card">
            			<div class="card-body">
            				<h3 class="card-title">
            					<?= isset($centerName)?$centerName:"Add New"; ?>
            				</h3>
            				<form action="<?= base_url('settings/saveCenterDetails'); ?>" method="post">
            				<?php if(isset($_GET['centerId'])){ ?>
            				<input type="hidden" name="centerid" value="<?= $_GET['centerId']; ?>">
            				<?php } ?>
            				<div class="row mb-5">
            					<div class="col-md-4">
	            					<div class="form-group">
										<label for="name">Center Name</label>
										<input type="text" class="form-control" id="name" name="centerName" value="<?= isset($centerName)?$centerName:""; ?>" required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="dob">Address Street</label>
										<input type="text" class="form-control" id="dob" name="adressStreet" value="<?= isset($adressStreet)?$adressStreet:""; ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="phone">Address City</label>
										<input type="text" class="form-control" id="phone" name="addressCity" value="<?= isset($addressCity)?$addressCity:""; ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="email">Address State</label>
										<input type="text" class="form-control" id="email" name="addressState" value="<?= isset($addressState)?$addressState:""; ?>">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="azip">Address ZIP</label>
										<input type="number" class="form-control" id="azip" maxlength="6" name="addressZip" value="<?= isset($addressZip)?$addressZip:""; ?>">
									</div>
								</div>
            				</div>
            				<h3 class="mb-3">Rooms</h3>
            				<?php 
            					if (empty($Rooms)) {
            				?>
            				<div class="row">
            					<div class="col-md-4">
            						<div class="form-group">
										<label>Room Name</label>
										<input type="text" class="form-control" name="roomName[]">
									</div>
            					</div>
            					<div class="col-md-2">
            						<div class="form-group">
										<label>Room Capacity</label>
										<input type="text" class="form-control" name="roomCapacity[]">
									</div>
            					</div>
            					<div class="col-md-2">
            						<div class="form-group">
										<label>Room Status</label>
										<select type="text" class="form-control" name="roomStatus[]">
											<option value="Active">Active</option>
											<option value="Inactive">In-Active</option>
										</select>
									</div>
            					</div>
            					<div class="col-md-2">
            						<div class="form-group">
										<label>Room Color</label>
										<input type="color" name="roomColor[]" value="#FF0000" class="form-control">
									</div>
            					</div>
            					<div class="col-md-2">
            						<div class="form-group">
	            						<label>&nbsp;</label><br>
	            						<button class="btn btn-outline-danger btn-block remove-btn-room">Remove</button>
	            					</div>
            					</div>
            				</div>
            				<?php }else{ ?>
            				<div id="rooms-records">
            				<?php
            						$i=1;
									foreach ($Rooms as $key => $robj) {
							?>
							<div class="row">
								<input type="hidden" name="roomid[]" value="<?= $robj->id; ?>">
								<div class="col-md-4">
            						<div class="form-group">
										<label>Room Name</label>
										<input type="text" class="form-control" name="roomName[]" value="<?= $robj->name; ?>">
									</div>
            					</div>
            					<div class="col-md-2">
            						<div class="form-group">
										<label>Room Capacity</label>
										<input type="text" class="form-control" name="roomCapacity[]" value="<?= $robj->capacity; ?>">
									</div>
            					</div>
            					<div class="col-md-2">
            						<div class="form-group">
										<label>Room Status</label>
										<select type="text" class="form-control" name="roomStatus[]">
											<?php 
												if($robj->status=="Active") {
											?>
											<option value="Active" selected>Active</option>
											<option value="Inactive">In-Active</option>
											<?php
												} else {
											?>
											<option value="Active">Active</option>
											<option value="Inactive" selected>In-Active</option>
											<?php } ?>
										</select>
									</div>
            					</div>
            					<div class="col-md-2">
            						<div class="form-group">
										<label>Room Color</label>
										<input type="color" name="roomColor[]" value="<?= $robj->color; ?>" class="form-control">
									</div>
            					</div>
            					<div class="col-md-2">
            						<div class="form-group">
	            						<label>&nbsp;</label><br>
	            						<button class="btn btn-outline-danger btn-block remove-btn-room">Remove</button>
	            					</div>
            					</div>
							</div>
							<?php
									}
            					}
            				?>
            				</div>
							<div class="formSubmit text-right">
								<button type="button" class="btn btn-outline-primary add-btn-room">+ New Room</button>
								<input type="submit" class="btn btn-primary" value="Submit">
							</div>
							</form>
            			</div>
            		</div>
            	</div>
            </div>
        </div>
	</main>
	<?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>
	<script>
		$(document).ready(function(){
			$(document).on("click",".add-btn-room",function(){
				$("#rooms-records").append(`
					<div class="row">
    					<div class="col-md-4">
    						<div class="form-group">
								<label>Room Name</label>
								<input type="text" class="form-control" name="roomName[]">
							</div>
    					</div>
    					<div class="col-md-2">
    						<div class="form-group">
								<label>Room Capacity</label>
								<input type="text" class="form-control" name="roomCapacity[]">
							</div>
    					</div>
    					<div class="col-md-2">
    						<div class="form-group">
								<label>Room Status</label>
								<select type="text" class="form-control" name="roomStatus[]">
									<option value="Active">Active</option>
									<option value="Inactive">In-Active</option>
								</select>
							</div>
    					</div>
    					<div class="col-md-2">
    						<div class="form-group">
								<label>Room Color</label>
								<input type="color" name="roomColor[]" value="#FF0000" class="form-control">
							</div>
    					</div>
    					<div class="col-md-2">
    						<div class="form-group">
        						<label>&nbsp;</label><br>
        						<button class="btn btn-outline-danger btn-block remove-btn-room">Remove</button>
        					</div>
    					</div>
    				</div>
				`);
			});

			$(document).on('click', ".remove-btn-room", function(){
				$(this).closest(".row").remove();
			});
		});
	</script>	
</body>
</html>