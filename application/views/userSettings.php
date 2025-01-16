<?php
	$data['name']='User Settings'; 
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
			<div class="userSettings">
				<div class="rowUserSettings">
					<div class="rowUserSettingsBlock">
						<div class="info-block">
							<div class="info-title">
								Total Users
							</div>
							<div class="info-number">
								<?php echo $userStats->totalUsers; ?>
							</div>
						</div>
					</div>
					<div class="rowUserSettingsBlock">
						<div class="info-block">
							<div class="info-title">
								Active Users
							</div>
							<div class="info-number">
								<?php echo $userStats->activeUsers; ?>
							</div>
						</div>
					</div>
					<div class="rowUserSettingsBlock">
						<div class="info-block">
							<div class="info-title">
								In-active Users
							</div>
							<div class="info-number">
								<?php echo $userStats->inactiveUsers; ?>
							</div>
						</div>
					</div>
					<div class="rowUserSettingsBlock">
						<div class="info-block">
							<div class="info-title">
								Pending Users
							</div>
							<div class="info-number">
								<?php echo $userStats->pendingUsers; ?>
							</div>
						</div>
					</div>
				</div>


			</div>

			<div class="input-group searchGroup">
				<span class="input-group-addon" id="search">
					<span class="material-icons-outlined">search</span>
				</span>
				<input type="text" class="form-control form-search" placeholder="Search" aria-describedby="search">
			</div>

			<div class="selectFilters">
				<!-- <div class="selectAll">
						<input type="checkbox" class="selectall-users" id="select-all">
						<label for="select-all">Select All</label>
					</div> -->
					<div class="filterAll">
						<?php 
							if (isset($_GET['order']) && $_GET['order']=="ASC" || empty($_GET['order'])) {
								$url = base_url("Settings/userSettings")."?order=DESC";
							} else { 
								$url = base_url("Settings/userSettings")."?order=ASC";
							}
							
						?>
						<a class="btn icon-btn" href="<?php echo $url; ?>">
							<span class="material-icons-outlined">sort</span>
						</a>
						<div class="btn icon-btn" id="filters">
							<span class="material-icons-outlined">filter_alt</span>
						</div>
						
						<a href="<?php echo base_url("Settings/export_excel"); ?>" class="btn btn-default bgGreen btn-small"><span class="material-icons">publish</span> Export</a>
						<a href="<?php echo base_url("Settings/addUsers"); ?>" class="btn btn-default btnBlue btn-small"> <span class="material-icons-outlined">add</span> Add User</a>
					</div>
			</div>
			<form action="" method="post">
				<div class="filtersAreaRow" id="filters-area">
					<h4>Apply Filters</h4>
					<div class="col-sm-12">
						<div class="row">
							<div class="col-sm-4" style="padding: 0px;">
								<div class="filter-title">Groups</div>
								<?php 
									foreach ($groups as $key => $grObj) {
								?>
								<div class="form-group">
									<input type="checkbox" name="groups[]" id="<?php echo "groups".$grObj->id; ?>" value="<?php echo $grObj->id; ?>">
									<label for="<?php echo "groups".$grObj->id; ?>"><?php echo $grObj->name; ?></label>
								</div>
								<?php
									}

								?>
							</div>
							<div class="col-sm-4" style="padding: 0px;">
								<div class="filter-title">Status</div>
								<div class="form-group">
									<input type="checkbox" name="status[]" id="u-active" value="ACTIVE">
									<label for="u-active">Active</label>
								</div>
								<div class="form-group">
									<input type="checkbox" name="status[]" id="u-inactive" value="IN-ACTIVE">
									<label for="u-inactive">In-Active</label>
								</div>
								<div class="form-group">
									<input type="checkbox" name="status[]" id="u-pending" value="PENDING">
									<label for="u-pending">Pending</label>
								</div>
							</div>
							<div class="col-sm-4" style="padding: 0px;">
								<div class="filter-title">Gender</div>
								<div class="form-group">
									<input type="checkbox" name="gender[]" id="u-male" value="MALE">
									<label for="u-male">Male</label>
								</div>
								<div class="form-group">
									<input type="checkbox" name="gender[]" id="u-female" value="FEMALE">
									<label for="u-female">Female</label>
								</div>
								<div class="form-group">
									<input type="checkbox" name="gender[]" id="u-others" value="OTHERS">
									<label for="u-others">Others</label>
								</div>
							</div>
						</div>
					</div>
					<div class="formSubmit">
						<input type="submit" class="btn btn-default btnBlue pull-right" name="filter" value="Apply Filters">
					</div>
				</div>
			</form>

			<div class="userListContainer">
				<?php foreach ($users as $key => $uobj) { ?>
				<div class="col-sm-6">
					<div class="users-box col1">
						<div class="users-img">
							<?php 
								if (empty($uobj->imageUrl)) {
									$image = "https://via.placeholder.com/120x120.png?text=No+Image";
								} else {
									$image = base_url("api/assets/media/").$uobj->imageUrl;
								}
							?>
							<img class="circleimage" src="<?php echo $image; ?>">
						</div>
						<div class="users-info ">
							<a href="<?php echo base_url("Settings/addUsers")."?recordId=".$uobj->userid; ?>" class="users-name"><?php echo $uobj->name; ?></a>
							<ul class="list-unstyled">
								<li class="users-list-item name">
									<span class="material-icons-outlined">person</span> <?php echo $uobj->userType; ?>
								</li>
								<li class="users-list-item">
								<span class="material-icons-outlined">business_center</span> <?php echo $uobj->status; ?>
								</li>
								<li class="users-list-item">
								<span class="material-icons-outlined">date_range</span> <?php echo date('d-m-y',strtotime($uobj->dob)); ?>
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
		$(document).on('click','#filters',function(){
			$("#filters-area").toggle();
			console.log("Click");
		});
	});


	$(document).ready(function(){
		
		$('.form-search').keyup(function(){
			var matcher = new RegExp($(this).val(), 'gi');
            $('.col1').show().not(function(){
                    return matcher.test($(this).find('.name').text());
            }).hide();
		});
	});
</script>