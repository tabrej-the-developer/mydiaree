<?php
	$data['name']='Manage Permissions'; 
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
		<div class="rightFOrmSection">
			<h3><?php echo $data['name']; ?></h3>
			<div class="flexFormDiv">
				<form action="" method="get" id="getPerForm">
				<select name="user" class="form-control" id="user">
					<option>Select User</option>
					<?php 
						foreach ($users as $key => $usr) {
							if (isset($_GET['user']) && $_GET['user']==$usr->userid) {
					?>
					<option value="<?php echo $usr->userid; ?>" selected><?php echo $usr->name; ?></option>
					<?php   } else { ?>
					<option value="<?php echo $usr->userid; ?>"><?php echo $usr->name; ?></option>
					<?php   } } ?>
				</select>
				<select name="center" class="form-control" id="center">
					<option>Select Center</option>
					<?php 
						foreach ($centers as $key => $center) {
							if (isset($_GET['center']) && $_GET['center']==$center->id) {
					?>
					<option value="<?php echo $center->id; ?>" selected><?php echo $center->centerName; ?></option>
					<?php   } else { ?>
					<option value="<?php echo $center->id; ?>"><?php echo $center->centerName; ?></option>
					<?php   } } ?>
				</select>				
				</form>

				<div class="checkPermList">
				<form action="<?php echo base_url("Settings/savePermission"); ?>" method="post">
				<?php 
					if(isset($_GET['center'])){
				?>
				<input type="hidden" name="center" value="<?php echo $_GET['center']; ?>">
				<?php
					}

					if(isset($_GET['user'])){
				?>
				<input type="hidden" name="user" value="<?php echo $_GET['user']; ?>">
				<?php
					}
				?>
					<div class="form-group headFormGroup">
						<label for="obs"><b>Observation</b></label>
						<input type="checkbox" id="obs" class="checkobs pull-right">
					</div>
					<div class="form-group">
						<label for="cobs">Create Observation</label>
						<input type="checkbox" id="cobs" name="addObservation" class="obs pull-right" value="1" <?php if(isset($permissions->addObservation)&&$permissions->addObservation==1){echo "checked";}?> >
					</div>
					<div class="form-group">
						<label for="aobs">Approve Observation</label>
						<input type="checkbox" id="aobs" name="approveObservation" class="obs pull-right" value="1" <?php if(isset($permissions->approveObservation)&&$permissions->approveObservation==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="dobs">Delete Observation</label>
						<input type="checkbox" id="dobs" name="deleteObservation" class="obs pull-right" value="1" <?php if(isset($permissions->deleteObservation)&&$permissions->deleteObservation==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="uobs">Update Observation</label>
						<input type="checkbox" id="uobs" name="updateObservation" class="obs pull-right" value="1" <?php if(isset($permissions->updateObservation)&&$permissions->updateObservation==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="vaobs">View All Observation</label>
						<input type="checkbox" id="vaobs" name="viewAllObservation" class="obs pull-right" value="1" <?php if(isset($permissions->viewAllObservation)&&$permissions->viewAllObservation==1){echo "checked";}?>>
					</div>

					<div class="form-group headFormGroup">
						<label for="qip"><b>QIP</b></label>
						<input type="checkbox" id="qip" class="checkqip pull-right">
					</div>
					<div class="form-group">
						<label for="cqip">Create QIP</label>
						<input type="checkbox" id="cqip" name="addQIP" class="qip pull-right" value="1" <?php if(isset($permissions->addQIP)&&$permissions->addQIP==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="eqip">Edit QIP</label>
						<input type="checkbox" id="eqip" name="editQIP" class="qip pull-right" value="1" <?php if(isset($permissions->editQIP)&&$permissions->editQIP==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="dqip">Delete QIP</label>
						<input type="checkbox" id="dqip" name="deleteQIP" class="qip pull-right" value="1" <?php if(isset($permissions->deleteQIP)&&$permissions->deleteQIP==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="dwqip">Download QIP Report</label>
						<input type="checkbox" id="dwqip" name="downloadQIP" class="qip pull-right" value="1" <?php if(isset($permissions->downloadQIP)&&$permissions->downloadQIP==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="prqip">Print QIP Report</label>
						<input type="checkbox" id="prqip" name="printQIP" class="qip pull-right" value="1" <?php if(isset($permissions->printQIP)&&$permissions->printQIP==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="mqip">Mail QIP Report</label>
						<input type="checkbox" id="mqip" name="mailQIP" class="qip pull-right" value="1" <?php if(isset($permissions->mailQIP)&&$permissions->mailQIP==1){echo "checked";}?>>
					</div>

					<div class="form-group headFormGroup">
						<label for="room"><b>Rooms</b></label>
						<input type="checkbox" id="room" class="checkroom pull-right">
					</div>
					<div class="form-group">
						<label for="croom">Create Room</label>
						<input type="checkbox" id="croom" name="addRoom" class="room pull-right" value="1" <?php if(isset($permissions->addRoom)&&$permissions->addRoom==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="eroom">Edit Room</label>
						<input type="checkbox" id="eroom" name="updateRoom" class="room pull-right" value="1" <?php if(isset($permissions->updateRoom)&&$permissions->updateRoom==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="droom">Delete Room</label>
						<input type="checkbox" id="droom" name="deleteRoom" class="room pull-right" value="1" <?php if(isset($permissions->deleteRoom)&&$permissions->deleteRoom==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="vroom">View Room</label>
						<input type="checkbox" id="vroom" name="viewRoom" class="room pull-right" value="1" <?php if(isset($permissions->viewRoom)&&$permissions->viewRoom==1){echo "checked";}?>>
					</div>

					<div class="form-group">
						<label for="pp"><b>Program Plan</b></label>
						<input type="checkbox" id="pp" class="checkpp pull-right">
					</div>
					<div class="form-group">
						<label for="cpp">Create Program Plan</label>
						<input type="checkbox" id="cpp" name="addProgramPlan" class="pp pull-right" value="1" <?php if(isset($permissions->addProgramPlan)&&$permissions->addProgramPlan==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="epp">Edit Program Plan</label>
						<input type="checkbox" id="epp" name="editProgramPlan" class="pp pull-right" value="1" <?php if(isset($permissions->editProgramPlan)&&$permissions->editProgramPlan==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="vpp">View Program Plan</label>
						<input type="checkbox" id="vpp" name="viewProgramPlan" class="pp pull-right" value="1" <?php if(isset($permissions->viewProgramPlan)&&$permissions->viewProgramPlan==1){echo "checked";}?>>
					</div>

					<div class="form-group headFormGroup">
						<label for="announ"><b>Announcements</b></label>
						<input type="checkbox" id="announ" class="checkannoun pull-right">
					</div>
					<div class="form-group">
						<label for="cannoun">Create Announcements</label>
						<input type="checkbox" id="cannoun" name="addAnnouncement" class="announ pull-right" value="1" <?php if(isset($permissions->addAnnouncement)&&$permissions->addAnnouncement==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="aannoun">Approve Announcements</label>
						<input type="checkbox" id="aannoun" name="approveAnnouncement" class="announ pull-right" value="1" <?php if(isset($permissions->approveAnnouncement)&&$permissions->approveAnnouncement==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="dannoun">Delete Announcements</label>
						<input type="checkbox" id="dannoun" name="deleteAnnouncement" class="announ pull-right" value="1" <?php if(isset($permissions->deleteAnnouncement)&&$permissions->deleteAnnouncement==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="uannoun">Update Announcements</label>
						<input type="checkbox" id="uannoun" name="updateAnnouncement" class="announ pull-right" value="1" <?php if(isset($permissions->updateAnnouncement)&&$permissions->updateAnnouncement==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="vaannoun">View All Announcements</label>
						<input type="checkbox" id="vaannoun" name="viewAllAnnouncement" class="announ pull-right" value="1" <?php if(isset($permissions->viewAllAnnouncement)&&$permissions->viewAllAnnouncement==1){echo "checked";}?>>
					</div>

					<div class="form-group headFormGroup">
						<label for="surveys"><b>Surveys</b></label>
						<input type="checkbox" id="surveys" class="checksur pull-right">
					</div>
					<div class="form-group">
						<label for="csur">Create Survey</label>
						<input type="checkbox" id="csur" name="addSurvey" class="sur pull-right" value="1" <?php if(isset($permissions->addSurvey)&&$permissions->addSurvey==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="asur">Approve Survey</label>
						<input type="checkbox" id="asur" name="approveSurvey" class="sur pull-right" value="1" <?php if(isset($permissions->approveSurvey)&&$permissions->approveSurvey==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="dsur">Delete Survey</label>
						<input type="checkbox" id="dsur" name="deleteSurvey" class="sur pull-right" value="1" <?php if(isset($permissions->deleteSurvey)&&$permissions->deleteSurvey==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="usur">Update Survey</label>
						<input type="checkbox" id="usur" name="updateSurvey" class="sur pull-right" value="1" <?php if(isset($permissions->updateSurvey)&&$permissions->updateSurvey==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="vasur">View All Survey</label>
						<input type="checkbox" id="vasur" name="viewAllSurvey" class="sur pull-right" value="1" <?php if(isset($permissions->viewAllSurvey)&&$permissions->viewAllSurvey==1){echo "checked";}?>>
					</div>

					<div class="form-group headFormGroup">
						<label for="rcp"><b>Recipes</b></label>
						<input type="checkbox" id="rcp" class="checkrcp pull-right">
					</div>
					<div class="form-group">
						<label for="crcp">Create Recipe</label>
						<input type="checkbox" id="crcp" name="addRecipe" class="rcp pull-right" value="1" <?php if(isset($permissions->addRecipe)&&$permissions->addRecipe==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="arcp">Approve Recipe</label>
						<input type="checkbox" id="arcp" name="approveRecipe" class="rcp pull-right" value="1" <?php if(isset($permissions->approveRecipe)&&$permissions->approveRecipe==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="drcp">Delete Recipe</label>
						<input type="checkbox" id="drcp" name="deleteRecipe" class="rcp pull-right" value="1" <?php if(isset($permissions->deleteRecipe)&&$permissions->deleteRecipe==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="urcp">Update Recipe</label>
						<input type="checkbox" id="urcp" name="updateRecipe" class="rcp pull-right" value="1" <?php if(isset($permissions->updateRecipe)&&$permissions->updateRecipe==1){echo "checked";}?>>
					</div>

					<div class="form-group headFormGroup">
						<label for="menus"><b>Menus</b></label>
						<input type="checkbox" id="menus" class="checkmenu pull-right">
					</div>
					<div class="form-group">
						<label for="cmenu">Create Menu</label>
						<input type="checkbox" id="cmenu" name="addMenu" class="menu pull-right" value="1" <?php if(isset($permissions->addMenu)&&$permissions->addMenu==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="amenu">Approve Menu</label>
						<input type="checkbox" id="amenu" name="approveMenu" class="menu pull-right" value="1" <?php if(isset($permissions->approveMenu)&&$permissions->approveMenu==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="dmenu">Delete Menu</label>
						<input type="checkbox" id="dmenu" name="deleteMenu" class="menu pull-right" value="1" <?php if(isset($permissions->deleteMenu)&&$permissions->deleteMenu==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="umenu">Update Menu</label>
						<input type="checkbox" id="umenu" name="updateMenu" class="menu pull-right" value="1" <?php if(isset($permissions->updateMenu)&&$permissions->updateMenu==1){echo "checked";}?>>
					</div>

					<div class="form-group headFormGroup">
						<label for="udd"><b>Update Daily Diary</b></label>
						<input type="checkbox" id="udd" name="updateDailyDiary" class="pull-right" value="1" <?php if(isset($permissions->updateDailyDiary)&&$permissions->updateDailyDiary==1){echo "checked";}?>>
					</div>
					<div class="form-group headFormGroup">
						<label for="uhc"><b>Update Head Checks</b></label>
						<input type="checkbox" id="uhc" name="updateHeadChecks" class="pull-right" value="1" <?php if(isset($permissions->updateHeadChecks)&&$permissions->updateHeadChecks==1){echo "checked";}?>>
					</div>
					<div class="form-group headFormGroup">
						<label for="uacc"><b>Update Accidents</b></label>
						<input type="checkbox" id="uacc" name="updateAccidents" class="pull-right" value="1" <?php if(isset($permissions->updateAccidents)&&$permissions->updateAccidents==1){echo "checked";}?>>
					</div>

					<div class="form-group headFormGroup">
						<label for="ums"><b>Update Module Settings</b></label>
						<input type="checkbox" id="ums" name="updateModules" class="pull-right" value="1" <?php if(isset($permissions->updateModules)&&$permissions->updateModules==1){echo "checked";}?>>
					</div>

					<div class="form-group headFormGroup">
						<label for="us"><b>User Settings</b></label>
						<input type="checkbox" id="us" class="checkusers pull-right">
					</div>
					<div class="form-group">
						<label for="cus">Create Users</label>
						<input type="checkbox" id="cus" name="addUsers" class="users pull-right" value="1" <?php if(isset($permissions->addUsers)&&$permissions->addUsers==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="vus">View Users</label>
						<input type="checkbox" id="vus" name="viewUsers" class="users pull-right" value="1" <?php if(isset($permissions->viewUsers)&&$permissions->viewUsers==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="uus">Update Users</label>
						<input type="checkbox" id="uus" name="updateUsers" class="users pull-right" value="1" <?php if(isset($permissions->updateUsers)&&$permissions->updateUsers==1){echo "checked";}?>>
					</div>

					<div class="form-group headFormGroup">
						<label for="cn"><b>Center Settings</b></label>
						<input type="checkbox" id="cn" class="checkcenter pull-right">
					</div>
					<div class="form-group">
						<label for="ccn">Create Centers</label>
						<input type="checkbox" id="ccn" name="addCenters" class="center pull-right" value="1" <?php if(isset($permissions->addCenters)&&$permissions->addCenters==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="vcn">View Centers</label>
						<input type="checkbox" id="vcn" name="viewCenters" class="center pull-right" value="1" <?php if(isset($permissions->viewCenters)&&$permissions->viewCenters==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="ucn">Update Centers</label>
						<input type="checkbox" id="ucn" name="updateCenters" class="center pull-right" value="1" <?php if(isset($permissions->updateCenters)&&$permissions->updateCenters==1){echo "checked";}?>>
					</div>

					<div class="form-group headFormGroup">
						<label for="ps"><b>Parent Settings</b></label>
						<input type="checkbox" id="ps" class="checkparent pull-right">
					</div>
					<div class="form-group">
						<label for="cps">Create Parents</label>
						<input type="checkbox" id="cps" name="addParent" class="parent pull-right" value="1" <?php if(isset($permissions->addParent)&&$permissions->addParent==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="vps">View Parents</label>
						<input type="checkbox" id="vps" name="viewParent" class="parent pull-right" value="1" <?php if(isset($permissions->viewParent)&&$permissions->viewParent==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="ups">Update Parents</label>
						<input type="checkbox" id="ups" name="updateParent" class="parent pull-right" value="1" <?php if(isset($permissions->updateParent)&&$permissions->updateParent==1){echo "checked";}?>>
					</div>

					<div class="form-group headFormGroup">
						<label for="cg"><b>Child Groups</b></label>
						<input type="checkbox" id="cg" class="checkcg pull-right">
					</div>
					<div class="form-group">
						<label for="ccg">Create Child Group</label>
						<input type="checkbox" id="ccg" name="addChildGroup" class="cg pull-right" value="1" <?php if(isset($permissions->addChildGroup)&&$permissions->addChildGroup==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="vcg">View Child Group</label>
						<input type="checkbox" id="vcg" name="viewChildGroup" class="cg pull-right" value="1" <?php if(isset($permissions->viewChildGroup)&&$permissions->viewChildGroup==1){echo "checked";}?>>
					</div>
					<div class="form-group">
						<label for="ucg">Update Child Group</label>
						<input type="checkbox" id="ucg" name="updateChildGroup" class="cg pull-right" value="1" <?php if(isset($permissions->updateChildGroup)&&$permissions->updateChildGroup==1){echo "checked";}?>>
					</div>

					<div class="form-group headFormGroup">
						<label for="ups"><b>Update Permission Setting</b></label>
						<input type="checkbox" id="ups" name="updatePermission" class="cg pull-right" value="1" <?php if(isset($permissions->updatePermission)&&$permissions->updatePermission==1){echo "checked";}?>>
					</div>

				
					<div class="formSubmit">
						<input type="submit" class="btn btn-default btnBlue pull-right" value="SAVE">
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
</div>




<?php $this->load->view('footer'); ?>
<script src="<?php echo base_url('assets/js/permissions.js'); ?>"></script>
	