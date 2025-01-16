<?php
	$data['name']='Module Settings'; 
	$this->load->view('header',$data);
?>

<div class="container settingsContainer">
    <div class="pageHead">
		<h1>Settings</h1>
    </div>
	<div class="settingsView">
		<form action="<?php echo base_url("Settings/addModuleSettings"); ?>" method="post">
			<div class="sideMenu">
				<?php $this->load->view('settings-menu-sidebar'); ?>
			</div>
			<div class="rightFOrmSection">
				<h3><?php echo $data['name']; ?></h3>
				<div class="formDiv">

					<select name="centerid" id="centerId" class="form-control fullSelect">
				        <?php 
				          foreach ($this->session->userdata("centerIds") as $key => $center) {
				          	if ($centerid==$center->id || $_GET['centerId']==$center->id) {
				        ?>
				        <option value="<?php echo $center->id; ?>" selected><?php echo $center->centerName; ?></option>
				        <?php
				          	} else {
				        ?>
				        <option value="<?php echo $center->id; ?>"><?php echo $center->centerName; ?></option>
				        <?php
				          	}
				          }
				        ?>
				    </select>

						<div class="main-box">
							<div class="box-head">
								<div class="form-group">
									<input type="checkbox" class="pull-right" id="prog">
									<label for="prog">Programming</label>
								</div>
							</div>
							<div class="box-body">
								<div class="form-group">
									<input id="Observation" type="checkbox" class="programming pull-right" name="observation" <?php if(isset($modules->observation)&&$modules->observation==1){echo "value='".$modules->observation."' checked";}else{echo "value='1'";}?>>
									<label for="Observation">Observation</label>
								</div>
								<div class="form-group">
									<input id="Rooms" type="checkbox" class="programming pull-right" name="room"<?php if(isset($modules->room)&&$modules->room==1){echo "value='".$modules->room."' checked";}else{echo "value='1'";}?>>
									<label for="Rooms">Rooms</label>
								</div>
								<div class="form-group">
									<input id="progPlan" type="checkbox" class="programming pull-right" name="programplans" <?php if(isset($modules->programplans)&&$modules->programplans==1){echo "value='".$modules->programplans."' checked";}else{echo "value='1'";}?>>
									<label for="progPlan">Program Plans</label>
								</div>
							</div>
						</div>
						<div class="main-box">
							<div class="form-group single-form-group" >
								<input id="QIP" type="checkbox" class="pull-right" name="qip" <?php if(isset($modules->qip)&&$modules->qip==1){echo "value='".$modules->qip."' checked";}else{echo "value='1'";}?>>
								<label for="QIP">QIP</label>
							</div>
						</div>
						<div class="main-box">
							<div class="box-head">
								<div class="form-group">
									<input type="checkbox" class="pull-right" id="community">
									<label for="community">Community</label>
								</div>
							</div>
							<div class="box-body">
								<div class="form-group">
									<input id="Announcements" type="checkbox" class="community pull-right" name="announcements" <?php if(isset($modules->announcements)&&$modules->announcements==1){echo "value='".$modules->announcements."' checked";}else{echo "value='1'";}?>>
									<label for="Announcements">Announcements</label>
								</div>
								<div class="form-group">
									<input id="Surveys" type="checkbox" class="community pull-right" name="survey" <?php if(isset($modules->survey)&&$modules->survey==1){echo "value='".$modules->survey."' checked";}else{echo "value='1'";}?>>
									<label for="Surveys">Surveys</label>
								</div>
							</div>
						</div>
						<div class="main-box">
							<div class="box-head">
								<div class="form-group">
									<input type="checkbox" class="pull-right" id="health">
									<label for="health">Healthy Eating</label>
								</div>
							</div>
							<div class="box-body">
								<div class="form-group">
									<input id="Menus" type="checkbox" class="health pull-right" name="menu" <?php if(isset($modules->menu)&&$modules->menu==1){echo "value='".$modules->menu."' checked";}else{echo "value='1'";}?>>
									<label for="Menus">Menus</label>
								</div>
								<div class="form-group">
									<input id="Recipes" type="checkbox" class="health pull-right" name="recipe"  <?php if(isset($modules->recipe)&&$modules->recipe==1){echo "value='".$modules->recipe."' checked";}else{echo "value='1'";}?>>
									<label for="Recipes">Recipes</label>
								</div>
							</div>
						</div>
						<div class="main-box">
							<div class="box-head">
								<div class="form-group">
									<input type="checkbox" class="pull-right" id="daily-diary">
									<label for="daily-diary">Daily Diary</label>
								</div>
							</div>
							<div class="box-body">
								<div class="form-group">
									<input type="checkbox" id="dailydiary" class="daily-diary pull-right" name="dailydiary" <?php if(isset($modules->dailydiary)&&$modules->dailydiary==1){echo "value='".$modules->dailydiary."' checked";}else{echo "value='1'";}?>>
									<label for="dailydiary">Daily Diary</label>
								</div>
								<div class="form-group">
									<input type="checkbox" id="headchecks" class="daily-diary pull-right" name="headchecks" <?php if(isset($modules->headchecks)&&$modules->headchecks==1){echo "value='".$modules->headchecks."' checked";}else{echo "value='1'";}?>>
									<label for="headchecks">Head Checks</label>
								</div>
								<div class="form-group">
									<input type="checkbox" id="accidents" class="daily-diary pull-right" name="accidents" <?php if(isset($modules->accidents)&&$modules->accidents==1){echo "value='".$modules->accidents."' checked";}else{echo "value='1'";}?>>
									<label for="accidents">Accidents</label>
								</div>
							</div>
						</div>
						<div class="main-box">
							<div class="form-group single-form-group" >
								<input type="checkbox" id="resources" class="pull-right" name="resources"  <?php if(isset($modules->resources)&&$modules->resources==1){echo "value='".$modules->resources."' checked";}else{echo "value='1'";}?>>
								<label for="resources">Resources</label>
							</div>
						</div>
						<div class="main-box">
							<div class="form-group single-form-group" >
								<input id="servicedetails" type="checkbox" class="pull-right" name="servicedetails"  <?php if(isset($modules->servicedetails)&&$modules->servicedetails==1){echo "value='".$modules->servicedetails."' checked";}else{echo "value='1'";}?>>
								<label for="servicedetails">Service Details</label>
							</div>
						</div>
						
				<div class="formSubmit">
						<button type="submit" class="btn btn-default btnBlue pull-right">Save</button>
				</div>
				</div>
			</div>
		</form>
	</div>
</div>

		
				<?php 

					$role = $this->session->userdata('UserType');
					if ($role == "Superadmin") {
						$run = 1;
					} else {
						if ($role=="Staff") {
							if (isset($permissions)) {
								if ($permissions->updateModules==1) {
									$run = 1;
								}else{
									$run = 0;
								}
							} else {
								$run = 0;
							}
						}else{
							$run = 0;
						}
					}
					
					if ($run == 1) {
				?>
				<?php
					}
				?>

<?php $this->load->view('footer'); ?>
<script>
	$(document).ready(function(){
		var checkboxes = $('.programming:checkbox:checked').length;
	    var totalboxes = $('.programming:checkbox').length;
    	if(totalboxes==checkboxes){
    		$('#prog').prop('checked',true);
    	}else{
    		$('#prog').prop('checked',false);
    	}

    	var checkboxes = $('.community:checkbox:checked').length;
	    var totalboxes = $('.community:checkbox').length;
    	if(totalboxes==checkboxes){
    		$('#community').prop('checked',true);
    	}else{
    		$('#community').prop('checked',false);
    	}

    	var checkboxes = $('.health:checkbox:checked').length;
	    var totalboxes = $('.health:checkbox').length;
    	if(totalboxes==checkboxes){
    		$('#health').prop('checked',true);
    	}else{
    		$('#health').prop('checked',false);
    	}

    	var checkboxes = $('.daily-diary:checkbox:checked').length;
	    var totalboxes = $('.daily-diary:checkbox').length;
    	if(totalboxes==checkboxes){
    		$('#daily-diary').prop('checked',true);
    	}else{
    		$('#daily-diary').prop('checked',false);
    	}

		$(document).on('click','#prog',function() {
			if($(this).prop("checked")==true) {
	    		$('.programming').prop('checked',true);
			}else{
	    		$('.programming').prop('checked',false);
			}
		});

		$(document).on('click','.programming',function() {
		    var checkboxes = $('.programming:checkbox:checked').length;
		    var totalboxes = $('.programming:checkbox').length;
	    	if(totalboxes==checkboxes){
	    		$('#prog').prop('checked',true);
	    	}else{
	    		$('#prog').prop('checked',false);
	    	}
		});



		$(document).on('click','#community',function() {
			if($(this).prop("checked")==true) {
	    		$('.community').prop('checked',true);
			}else{
	    		$('.community').prop('checked',false);
			}
		});

		$(document).on('click','.community',function() {
		    var checkboxes = $('.community:checkbox:checked').length;
		    var totalboxes = $('.community:checkbox').length;
	    	if(totalboxes==checkboxes){
	    		$('#community').prop('checked',true);
	    	}else{
	    		$('#community').prop('checked',false);
	    	}
		});

		$(document).on('click','#health',function() {
			if($(this).prop("checked")==true) {
	    		$('.health').prop('checked',true);
			}else{
	    		$('.health').prop('checked',false);
			}
		});

		$(document).on('click','.health',function() {
		    var checkboxes = $('.health:checkbox:checked').length;
		    var totalboxes = $('.health:checkbox').length;
	    	if(totalboxes==checkboxes){
	    		$('#health').prop('checked',true);
	    	}else{
	    		$('#health').prop('checked',false);
	    	}
		});

		$(document).on('click','#daily-diary',function() {
			if($(this).prop("checked")==true) {
	    		$('.daily-diary').prop('checked',true);
			}else{
	    		$('.daily-diary').prop('checked',false);
			}
		});

		$(document).on('click','.daily-diary',function() {
		    var checkboxes = $('.daily-diary:checkbox:checked').length;
		    var totalboxes = $('.daily-diary:checkbox').length;
	    	if(totalboxes==checkboxes){
	    		$('#daily-diary').prop('checked',true);
	    	}else{
	    		$('#daily-diary').prop('checked',false);
	    	}
		});

		$("#centerId").on('change',function(){
			window.location.href="<?php echo base_url('Settings/moduleSettings'); ?>?centerId="+$(this).val();
		});
	});
</script>