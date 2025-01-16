<?php

	$data['name']='Child Group Settings'; 
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
						<select class="js-example-basic-multiple form-control" multiple="multiple" name="children[]">
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
				
				<div class="formSubmit">
					<input type="submit" class="btn btn-default btnBlue pull-right" value="SAVE">
				</div>
			</div>
		</form>
	</div>
</div>



<?php $this->load->view('footer'); ?>
<script>
	$(document).ready(function(){
		
	});
</script>		