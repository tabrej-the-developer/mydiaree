<?php
	$data['name']='Change Email'; 
	$this->load->view('header',$data);
?>
<div class="container settingsContainer">
    <div class="pageHead">
		<h1>Settings</h1>
    </div>
	<div class="settingsView">
		<form action="<?php echo base_url("Settings/changeEmail"); ?>" method="post">
			<div class="sideMenu">
				<?php $this->load->view('settings-menu-sidebar'); ?>
			</div>
			<div class="rightFOrmSection">
				<h3><?php echo $data['name']; ?></h3>
			
			<div class="formDiv">
				<?php 
					if (isset($Status)) {
						if ($Status == "SUCCESS") {
				?>
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<div class="alert alert-success alert-dismissible" role="alert">
						    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						    </button>
						    <strong>Success!</strong> <?php echo $Message; ?>.
						</div>
					</div>
				</div>
				<?php	
						} else {
				?>
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<div class="alert alert-danger alert-dismissible" role="alert">
						    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    	<span aria-hidden="true">&times;</span>
						    </button>
						    <strong>Oh Snap!</strong> <?php echo $Message; ?>.
						</div>
					</div>
				</div>
				<?php
						}
					}
				?>
					<div class="form-group">
						<label for="currentEmail">Current Email</label>
						<input type="text" class="form-control" name="currentEmail" id="currentEmail">
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="text" class="form-control" name="email" id="email">
					</div>
					<div class="form-group">
						<label for="confirmEmail">Confirm Email</label>
						<input type="text" class="form-control" name="confirmEmail" id="confirmEmail">
					</div>
				
				</div>
				<div class="formSubmit">
					<button type="submit" class="btn btn-default btnBlue pull-right">Save</button>
				</div>
			</div>
		</form>
	</div>	
</div>


<?php $this->load->view('footer'); ?>