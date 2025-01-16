<?php
	$data['name']='Notice Period Settings'; 
	$this->load->view('header',$data);
?>

<div class="container settingsContainer">
    <div class="pageHead">
		<h1>Settings</h1>
    </div>
	<div class="settingsView">
		<form action="<?php echo base_url("Settings/saveNoticeSettings"); ?>" method="post">
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
							<?php 
								if(isset($Notice->days) && $Notice->days !="")
								{ 
									$checkstr = $Notice->days; 
								}else{ 
									$checkstr = "";
								} 
							?>
							<div class="form-group">
								<input type="number" name="number" class="form-control" placeholder="Enter number" value="<?= $checkstr; ?>"> Days 
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
			window.location.href="<?php echo base_url('Settings/noticePeriodSettings'); ?>?centerId="+$(this).val();
		});
	});
</script>