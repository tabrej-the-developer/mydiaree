<?php
	$data['name']='Center Settings'; 
	$this->load->view('header',$data);
?>

<div class="container settingsContainer">
    <div class="pageHead">
		<h1>Settings</h1>
    </div>
	<div class="settingsView">
		<div class="sideMenu">
			<?php $this->load->view('settings-menu-sidebar'); ?>
		</div>
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
							<button type="button" class="btn btn-default btn-small btnBlue pull-right add-btn-room">Add</button>
						<?php } else { ?>
							<button type="button" class="btn btn-default btn-small btnRed pull-right remove-btn-room">Remove</button>
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
				<div class="formSubmit">
					<input type="submit" class="btn btn-default btnBlue pull-right">
				</div>

		</div>
		</form>
	</div>
</div>


<?php $this->load->view('footer'); ?>
<script>
	$(document).ready(function(){
		$(document).on("click",".add-btn-room",function(){
			$(".room-section").append('<div class="flexFormGroup"><div class="form-group"> <label>Room Name</label> <input type="text" class="form-control" name="roomName[]"></div><div class="form-group"> <label>Room Capacity</label> <input type="text" class="form-control" name="roomCapacity[]"></div><div class="form-group"> <label>Room Status</label><select type="text" class="form-control" name="roomStatus[]"><option value="Active">Active</option><option value="Inactive">In-Active</option> </select></div><div class="form-group"> <label>Room Color</label> <input type="color" name="roomColor[]" value="#FF0000" class="form-control"></div><button type="button" class="btn btn-small btnRed btn-danger pull-right remove-btn-room">Remove</button></div>');
		});

		$(document).on('click',".remove-btn-room",function(){
			alert("Hi");
			$(this).closest(".flexFormGroup").remove();
		});
	});
</script>		