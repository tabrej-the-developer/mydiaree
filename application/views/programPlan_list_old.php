<?php $data['name']='Program Plan'; $this->load->view('header',$data); ?>


<div class="container">
	<div class="pageHead">
		<h1>Program Plan</h1>
		<div class="headerForm">
			<form action="" id="centerDropdown">
				<select name="centerid" id="centerId" class="form-control">
					<?php 
						$dupArr = [];
						foreach ($this->session->userdata("centerIds") as $key => $center){
							if ( ! in_array($center, $dupArr)) {
								if (isset($_GET['centerid']) && $_GET['centerid'] != "" && $_GET['centerid']==$center->id) {
					?>
					<option value="<?php echo $center->id; ?>" selected><?php echo $center->centerName; ?></option>
					<?php }else{ ?>
					<option value="<?php echo $center->id; ?>"><?php echo $center->centerName; ?></option>
					<?php
								}
							}
							array_push($dupArr, $center);
						}
					?>
				</select>
			</form>
			<?php if(isset($permissions->deleteProgramPlan) && $permissions->addProgramPlan==1){ ?>
            	<a href="<?php echo base_url('programPlan/add'); ?>" class="btn btn-default btn-small btnBlue pull-right">
					<span class="material-icons-outlined">add</span> Add Plan
				</a>
            <?php } ?>
		</div>
	</div>

	<div class="programmePlanList">
		<?php 
		if (isset($permissions->viewProgramPlan) && $permissions->viewProgramPlan==1) {
			if(empty($plans)) { 
		?>
		<div class="folder">
			<img src="<?php echo base_url('assets/images/icons/folder.png'); ?>">			
			<span>No Program Plan is generated.</span>
		</div>
		<?php
			}else{
				foreach($plans as $plan) { 
		?>
		<div class="qipblock">
			<span class="qipname"><?php echo $plan->roomName; ?></span>
			<span class="pull-right">
				<span>
					<?php if(isset($permissions->deleteProgramPlan)&&$permissions->deleteProgramPlan==1){ ?>
					<a onclick="deletepp('<?php echo $plan->id; ?>');" class="delete">
						<span class="material-icons-outlined">delete</span>
					</a>
					<?php } ?>
				</span>
				<span style="margin-left: 10px;">
					<?php if(isset($permissions->editProgramPlan)&&$permissions->editProgramPlan==1){ ?>
					<a class="view" href="<?php echo base_url('programPlan/edit?id='.$plan->id); ?>">
						<span class="material-icons-outlined">visibility</span>
					</a>
					<?php } ?>
				</span>
			</span>
		</div>

		<?php
				}
			}
		} else {
		?>
			<div class="folder">
				<h3>You're not permitted to view Program Plans :/</h3>
			</div>

		<?php } ?>

	</div>
</div>


<?php $this->load->view('footer'); ?>
<script>
	function deletepp(id)
	{
		if (confirm('Are you Want Delete ?')) {
			var url="<?php echo base_url('programPlan/delete'); ?>?id="+id;
			location = url;
		 } else {
			return false;
       }
	}

	$(document).ready(function(){
		$("#centerId").on('change',function(){
		   $("#centerDropdown").submit();
		});
	});
</script>