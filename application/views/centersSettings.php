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
		<div class="rightFOrmSection">
			<h3>
				<?php echo $data['name']; ?>
				<div class="filterAll">
					<?php 
						if (isset($_GET['order']) && $_GET['order']=="ASC" || empty($_GET['order'])) {
							$url = base_url("Settings/centerSettings")."?order=DESC";
						} else { 
							$url = base_url("Settings/centerSettings")."?order=ASC";
						}
						
					?>
					<a class="btn icon-btn" href="<?php echo $url; ?>">
						<span class="material-icons-outlined">sort</span>
					</a>
					<a href="<?php echo base_url("Settings/addCenter"); ?>" class="btn btn-default btnBlue btn-small"> <span class="material-icons-outlined">add</span> Add Center</a>
				</div>
			</h3>
			<div class="input-group searchGroup">
				<span class="input-group-addon" id="search">
				<img src="<?php echo base_url("assets/images/icons/search.svg"); ?>" alt="search">
				</span>
				<input type="text" class="form-control form-search" placeholder="Search" aria-describedby="search">
			</div>

			<div class="userListContainer">
				<?php foreach ($centers as $key => $cobj) { ?>
				<div class="col-sm-6">
					<div class="users-box">
						<div class="users-img">
							<?php 
								if (empty($cobj->imageUrl)) {
									$image = "https://via.placeholder.com/120x120.png?text=No+Image";
								} else {
									$image = base_url("api/assets/media/").$cobj->imageUrl;
								}
							?>
							<img class="circleimage" src="https://via.placeholder.com/120x120.png?text=No+Image">
						</div>
						<div class="users-info">
							<a href="<?php echo base_url("Settings/addCenter")."?centerId=".$cobj->id; ?>" class="users-name"><?php echo $cobj->centerName; ?></a>
							<ul class="list-unstyled">
								<li>
									<?php echo $cobj->adressStreet; ?>
								</li>
								<li>
									<?php echo $cobj->addressCity; ?>
								</li>
								<li>
									<?php echo $cobj->addressState; ?>
								</li>
							</ul>
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