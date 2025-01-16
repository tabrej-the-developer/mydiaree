<?php
	$data['name']='Parent Settings'; 
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
								Total Parents
							</div>
							<div class="info-number">
								<?php echo $parentStats->totalParents; ?>
							</div>
						</div>
					</div>
					<div class="rowUserSettingsBlock">
						<div class="info-block">
							<div class="info-title">
								Active Parents
							</div>
							<div class="info-number">
								<?php echo $parentStats->activeParents; ?>
							</div>
						</div>
					</div>
					<div class="rowUserSettingsBlock">
						<div class="info-block">
							<div class="info-title">
								In-active Parents
							</div>
							<div class="info-number">
								<?php echo $parentStats->inactiveParents; ?>
							</div>
						</div>
					</div>
					<div class="rowUserSettingsBlock">
						<div class="info-block">
							<div class="info-title">
								Pending Parents
							</div>
							<div class="info-number">
								<?php echo $parentStats->pendingParents; ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			
			<div class="input-group searchGroup">
				<span class="input-group-addon" id="search">
					<span class="material-icons-outlined">search</span>
				</span>
				<input type="text" onkeyup="myFunction()" id='search' class="form-control form-search" placeholder="Search" aria-describedby="search">
			</div>
			<div class="selectFilters">
				<div class="filterAll">
					<?php 
						if (isset($_GET['order']) && $_GET['order']=="ASC" || empty($_GET['order'])) {
							$url = base_url("Settings/parentSettings")."?order=DESC";
						} else { 
							$url = base_url("Settings/parentSettings")."?order=ASC";
						}
						
					?>
					<a class="btn icon-btn" href="<?php echo $url; ?>">
						<div class="icon-btn">
							<img src="<?php echo base_url("assets/images/icons/sort.svg"); ?>" alt="sort">
						</div>
					</a>
					<a href="<?php echo base_url("Settings/addParent"); ?>" class="btn btn-info btn-small btnBlue"><span class="material-icons-outlined">add</span> Add Parent</a>
				</div>
			</div>
			<div class="userListContainer">
				<?php foreach ($parents as $key => $pobj) { ?>
					<div class="col-sm-6">
						<div class="users-box">
							<div class="users-img">
								<?php 
									if (empty($pobj->imageUrl)) {
										$image = "https://via.placeholder.com/120x120.png?text=No+Image";
									} else {
										$image = base_url("api/assets/media/").$pobj->imageUrl;
									}
								?>
								<img class="circleimage" src="<?php echo $image; ?>">
							</div>
							<div class="users-info">
								<a href="<?php echo base_url("Settings/addParent")."?recordId=".$pobj->userid; ?>" class="users-name"><?php echo $pobj->name; ?></a>
								<ul class="list-unstyled">
									<li class="users-list-item">
										<span class="material-icons-outlined">person</span> <?php echo $pobj->userType; ?>
									</li>
									<li class="users-list-item">
										<span class="material-icons-outlined">business_center</span> <?php echo $pobj->status; ?>
									</li>
									<li class="users-list-item">
										<span class="material-icons-outlined">date_range</span> <?php echo date('d-m-y',strtotime($pobj->dob)); ?>
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

		/*$('#search').on('keyup',function(){
			myFunction();
		})*/

		
	});

	//function myFunction() {
				//console.log(';p;p;');
			//var input = document.getElementById("search");
			//var filter = input.value.toLowerCase();
			//var nodes = document.getElementsByClassName('users-info');

			/*for (i = 0; i < nodes.length; i++) {
				if (nodes[i].innerText.toLowerCase().includes(filter)) {
				nodes[i].style.display = "block";
				} else {
				nodes[i].style.display = "none";
				}
			}*/
		//	input = document.getElementById("search");
			//console.log(input.value);
			//console.log(input.match(/^[A-Z]{4}/));
			
			
    		//filter = input.value.toUpperCase();

		/*	filter = input.value;
    		var length = document.getElementsByClassName('users-info').length;
			console.log(length);

    		for (i=0; i<length; i++){
				if(document.getElementsByClassName('users-info')[i].innerHTML.toUpperCase().indexOf(filter) > -1) {     
    					document.getElementsByClassName("users-info")[i].style.display = "block";
            	}*/
        		/*else{
        				document.getElementsByClassName("users-info")[i].style.display = "none";
        		}*/
    		/*}
		}*/




</script>