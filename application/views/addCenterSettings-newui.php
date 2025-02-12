<?php
	$data['name']='Center Settings'; 
	// $this->load->view('header',$data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Mydiaree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

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
	<style>
	.flexFormGroup {
		flex-wrap: wrap;
		display: flex;
		width: 100%;
		position: relative;
	}
	.flexFormGroup .form-group {
		margin: 0 0 30px 30px;
		margin-left: 10px;
		flex: 0 0 calc(33% - 17px);
	}
	</style>
</head>

<body id="app-container" class="menu-default" style="background-color: #f8f8f8; top: -35px; bottom:0px;">
<?php $this->load->view('sidebar'); ?> 
<main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Add Center</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Settings</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Add Center</li>
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
		<form action="<?php echo base_url("Settings/saveCenterDetails"); ?>" method="post" enctype="multipart/form-data">
		<div class="rightFOrmSection">
			<?php if (isset($_GET['centerId'])) { ?>
				<h3>Edit Center</h3>
			<?php } else { ?>
				<h3>Add Center</h3>
			<?php } ?>
				<?php if (isset($_GET['centerId'])) { ?>
					<input type="hidden" name="centerId" value="<?php echo $_GET['centerId']; ?>">
				<?php } ?>
				
				<h4 class="title">Center Details</h4>
				<div class="flexFormGroup">
					<div class="form-group">
						<label for="name">Center Name</label>
						<input type="text" class="form-control" id="name" name="centerName" value="<?php echo isset($centerName)?$centerName:""; ?>" required>
					</div>
					<div class="form-group">
						<label for="dob">Address Street</label>
						<input type="text" class="form-control" id="dob" name="adressStreet" value="<?php echo isset($adressStreet)?$adressStreet:""; ?>">
					</div>
					<div class="form-group">
						<label for="phone">Address City</label>
						<input type="text" class="form-control" id="phone" name="addressCity" value="<?php echo isset($addressCity)?$addressCity:""; ?>">
					</div>
					<div class="form-group">
						<label for="email">Address State</label>
						<input type="text" class="form-control" id="email" name="addressState" value="<?php echo isset($addressState)?$addressState:""; ?>">
					</div>
					<div class="form-group">
						<label for="azip">Address ZIP</label>
						<input type="number" class="form-control" id="azip" maxlength="6" name="addressZip" value="<?php echo isset($addressZip)?$addressZip:""; ?>">
					</div>
				</div>
				
				<?php if (empty($Rooms)) { ?>
				<div class="roomList  room-section">
					<h4 class="title">Add room <button type="button" class="btn btn-default btn-small btnBlue pull-right add-btn-room">Add</button></h4>
					<div class="flexFormGroup">
						<div class="form-group">
							<label>Room Name</label>
							<input type="text" class="form-control" name="roomName[]">
						</div>
						<div class="form-group">
							<label>Room Capacity</label>
							<input type="text" class="form-control" name="roomCapacity[]">
						</div>
						<div class="form-group">
							<label>Room Status</label>
							<select type="text" class="form-control" name="roomStatus[]">
								<option value="Active">Active</option>
								<option value="Inactive">In-Active</option>
							</select>
						</div>
						<div class="form-group">
							<label>Room Color</label>
							<input type="color" name="roomColor[]" value="#FF0000" class="form-control">
						</div>
					</div>
				</div>
				<?php  } else { 
					$i=1;
					foreach ($Rooms as $key => $robj) { ?>

				<div class="col-sm-12 room-box">
					<input type="hidden" name="roomid[]" value="<?php echo $robj->id; ?>">
					
					<div class="roomList">
						<div class="titleFlex">
						<?php if($i == 1) { ?>
							<h4 class="title">Add room</h4>
							<button type="button" class="btn btn-default btn-small btnBlue pull-right add-btn-room"><span class="simple-icon-plus"></span></button>
						<?php } else { ?>
							<button type="button" class="btn btn-default btn-small btnRed pull-right remove-btn-room" style="margin-top:2%;display:grid;place-items:center;height: 40px;margin-left: 10px;"><span class="simple-icon-minus"></span></button>
						<?php } ?>
						</div>
						<div class="flexFormGroup">
							<div class="form-group">
								<label>Room Name</label>
								<input type="text" class="form-control" name="roomName[]" value="<?php echo $robj->name; ?>">
							</div>
							<div class="form-group">
								<label>Room Capacity</label>
								<input type="text" class="form-control" name="roomCapacity[]" value="<?php echo $robj->capacity; ?>">
							</div>
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
									<option value="Inactive" Selected>In-Active</option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label>Room Color</label>
								<input type="color" name="roomColor[]" value="<?php echo $robj->color; ?>" class="form-control">
							</div>
						</div>
					</div>
					
				</div>
				<?php
						$i++;
					}
				} ?>
				<div class="formSubmit text-right">
					<input type="submit" class="btn btn-default btnBlue pull-right btn-primary">
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
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?id=1234"></script>
	<script>
		$(document).ready(function(){
			$(document).on("click",".add-btn-room",function(){
				$(".room-section").append('<div class="flexFormGroup"><div class="form-group"> <label>Room Name</label> <input type="text" class="form-control" name="roomName[]"></div><div class="form-group"> <label>Room Capacity</label> <input type="text" class="form-control" name="roomCapacity[]"></div><div class="form-group"> <label>Room Status</label><select type="text" class="form-control" name="roomStatus[]"><option value="Active">Active</option><option value="Inactive">In-Active</option> </select></div><div class="form-group"> <label>Room Color</label> <input type="color" name="roomColor[]" value="#FF0000" class="form-control"></div><button type="button" class="btn btn-small btnRed btn-danger pull-right remove-btn-room" style="margin-top:2%;display:grid;place-items:center;height: 40px;margin-left: 10px;"><span class="simple-icon-minus"></span></button></div>');
			});

			$(document).on('click',".remove-btn-room",function(){
				// alert("Hi");
				$(this).closest(".flexFormGroup").remove();
			});
		});
	</script>	
</body>
</html>