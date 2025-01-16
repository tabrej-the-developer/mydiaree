<?php
	$data['name']='Application Settings'; 
	$this->load->view('header',$data);
?>

<div class="container settingsContainer">
    <div class="pageHead">
		<h1>Settings</h1>
    </div>
	<div class="settingsView">
		<form action="<?php echo base_url("Settings/saveApplicationSettings"); ?>" method="post">
			<div class="sideMenu">
				<?php $this->load->view('settings-menu-sidebar'); ?>
			</div>
			<div class="rightFOrmSection">
				<h3><?php echo $data['name']; ?></h3>
				<div class="formDiv">
					<select name="centerid" id="centerId" class="form-control fullSelect">
				        <?php 
				          foreach ($this->session->userdata("centerIds") as $key => $center) {
				          	if ((!empty($JournalTabs) && $JournalTabs->centerid == $center->id) || (isset($_GET['centerId']) && $_GET['centerId']==$center->id)) {
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
						<div class="box-head box-item">
							<div class="form-group">
								<?php 
									if(isset($JournalTabs->breakfast) && $JournalTabs->breakfast==1)
									{ 
										$checkstr = "value='".$JournalTabs->breakfast."' checked"; 
									}else{ 
										$checkstr = "value='0'"; 
									} 
								?>
								<input id="breakfast" type="checkbox" class="programming pull-right" name="breakfast" <?= $checkstr; ?>>
								<label for="breakfast">breakfast</label>
							</div>
						</div>
						<div class="box-head box-item">
							<div class="form-group">
								<?php 
									if(isset($JournalTabs->morningtea) && $JournalTabs->morningtea==1)
									{ 
										$checkstr = "value='".$JournalTabs->morningtea."' checked"; 
									}else{ 
										$checkstr = "value='0'"; 
									} 
								?>
								<input id="morningtea" type="checkbox" class="programming pull-right" name="morningtea" <?= $checkstr; ?>>
								<label for="morningtea">morningtea</label>
							</div>
						</div>
						<div class="box-head box-item">
							<div class="form-group">
								<?php 
									if(isset($JournalTabs->lunch) && $JournalTabs->lunch==1)
									{ 
										$checkstr = "value='".$JournalTabs->lunch."' checked"; 
									}else{ 
										$checkstr = "value='0'"; 
									} 
								?>
								<input id="lunch" type="checkbox" class="programming pull-right" name="lunch" <?= $checkstr; ?>>
								<label for="lunch">lunch</label>
							</div>
						</div>
						<div class="box-head box-item">
							<div class="form-group">
								<?php 
									if(isset($JournalTabs->sleep) && $JournalTabs->sleep==1)
									{ 
										$checkstr = "value='".$JournalTabs->sleep."' checked"; 
									}else{ 
										$checkstr = "value='0'"; 
									} 
								?>
								<input id="sleep" type="checkbox" class="programming pull-right" name="sleep" <?= $checkstr; ?>>
								<label for="sleep">sleep</label>
							</div>
						</div>
						<div class="box-head box-item">
							<div class="form-group">
								<?php 
									if(isset($JournalTabs->afternoontea) && $JournalTabs->afternoontea==1)
									{ 
										$checkstr = "value='".$JournalTabs->afternoontea."' checked"; 
									}else{ 
										$checkstr = "value='0'"; 
									} 
								?>
								<input id="afternoontea" type="checkbox" class="programming pull-right" name="afternoontea" <?= $checkstr; ?>>
								<label for="afternoontea">afternoontea</label>
							</div>
						</div>
						<div class="box-head box-item">
							<div class="form-group">
								<?php 
									if(isset($JournalTabs->latesnacks) && $JournalTabs->latesnacks==1)
									{ 
										$checkstr = "value='".$JournalTabs->latesnacks."' checked"; 
									}else{ 
										$checkstr = "value='0'"; 
									} 
								?>
								<input id="latesnacks" type="checkbox" class="programming pull-right" name="latesnacks" <?= $checkstr; ?>>
								<label for="latesnacks">latesnacks</label>
							</div>
						</div>
						<div class="box-head box-item">
							<div class="form-group">
								<?php 
									if(isset($JournalTabs->sunscreen) && $JournalTabs->sunscreen==1)
									{ 
										$checkstr = "value='".$JournalTabs->sunscreen."' checked"; 
									}else{ 
										$checkstr = "value='0'"; 
									} 
								?>
								<input id="sunscreen" type="checkbox" class="programming pull-right" name="sunscreen" <?= $checkstr; ?>>
								<label for="sunscreen">sunscreen</label>
							</div>
						</div>
						<div class="box-head box-item">
							<div class="form-group">
								<?php 
									if(isset($JournalTabs->toileting) && $JournalTabs->toileting==1)
									{ 
										$checkstr = "value='".$JournalTabs->toileting."' checked"; 
									}else{ 
										$checkstr = "value='0'"; 
									} 
								?>
								<input id="toileting" type="checkbox" class="programming pull-right" name="toileting" <?= $checkstr; ?>>
								<label for="toileting">toileting</label>
							</div>
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
<?php $this->load->view('footer'); ?>
<script>
	$(document).ready(function(){
		$("#centerId").on('change',function(){
			window.location.href="<?php echo base_url('Settings/applicationSettings'); ?>?centerId="+$(this).val();
		});
	});
</script>