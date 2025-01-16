<?php
	$data['name']='Child Groups'; 
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
			<h3><?php echo $data['name']; ?>
				<div class="filterAll">
					<a href="<?php echo base_url("Settings/addChildGroup"); ?>" class="btn btn-default btn-info pull-right btn-small btnBlue"><span class="material-icons-outlined">add</span> Add Group</a>
				</div>
			</h3>
			<div class="flexChildGroup">
				<?php foreach ($groups as $key => $grobj) { ?>
					<div class="flexChildGroupBlock col-sm-6" >
						<div class="users-box">
							<a href="<?php echo base_url("Settings/addChildGroup")."?groupId=".$grobj->id; ?>" class="users-name">
								<?php echo $grobj->name; ?>
							</a>
							<div class="childrenList">
							<?php 
								$i = 1;
								foreach ($grobj->children as $key => $childObj) {
									if (empty($childObj->imageUrl)) {
										$image = "https://via.placeholder.com/120x120.png?text=No+Image";
									} else {
										$image = base_url("api/assets/media/").$childObj->imageUrl;
									}
									if ($i < 7) {
							?>
							<img class="GroupChildImages" src="<?php echo $image; ?>">
							<?php
									}
									$i++;
								}
							?>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>

		</div>
	</div>
</div>

<?php $this->load->view('footer'); ?>
<script>
	$(document).ready(function(){
		
	});
</script>