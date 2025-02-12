<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Parents Settings | Mydiaree</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js?id=1234"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?id=1234" />

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?id=1234" />


	<style>
		.userSettings {
			display: block;
			width: 100%;
		}
		.rowUserSettings {
			display: flex;
			align-items: center;
			justify-content: space-between;
			margin: 0 0 30px;
		}
		.rowUserSettingsBlock .info-block {
			padding: 20px;
			background: var(--blue5);
			border: 1px solid var(--blue5);
		}
		.input-group.searchGroup {
			display: flex;
			align-items: center;
			width: 100%;
			position: relative;
		}
		.selectFilters {
			display: flex;
			align-items: center;
			justify-content: flex-end;
		}
		.userListContainer {
			display: flex;
			flex-wrap: wrap;
			width: 100%;
			align-items: flex-start;
			justify-content: flex-start;
			margin: 30px 0 0;
		}
		.users-box {
			display: flex;
			align-items: center;
		}
		.users-box .users-img {
			background: var(--grey5);
			margin-right: 20px;
			border-radius: 200px;
			display: inline-block;
			overflow: hidden;
			width: 120px;
			height: 120px;
		}
		.users-box .users-img img {
			width: 100%;
		}
		.users-info {
			width: calc(100% - 140px);
		}
		.userListContainer .col-sm-4 {
			flex: 0 0 calc(50% - 15px);
			padding: 30px;
			margin-bottom: 20px;
			margin-right: 10px;
			/* margin-top: 30px;
			margin-left: 30px; */
			box-shadow: 0 0 5px rgb(0 0 0 / 16%);
			-o-box-shadow: 0 0 5px rgb(0 0 0 / 16%);
			-ms-box-shadow: 0 0 5px rgb(0 0 0 / 16%);
			-moz-box-shadow: 0 0 5px rgb(0 0 0 / 16%);
			-webkit-box-shadow: 0 0 5px rgb(0 0 0 / 16%);
		}
		.rowUserSettingsBlock {
			width: 100%;
			text-align: center;
			margin-right: 20px;
		}
		 
		.input-group-text {
    		background-color: white;
			border-right: none;
		}

		@media only screen and (min-width: 320px) and (max-width: 600px){
			.userListContainer .col-sm-6 {
				flex:inherit;
				margin-bottom:20px;
			}
			.rowUserSettings {
				align-items:inherit;
				display:block;
			}
			.rowUserSettingsBlock {
				width: 100%;
				margin-right: 20px;
			}
			.selectFilters {
				justify-content: center;
			}
		}
	</style>
</head>

<body id="app-container" class="menu-default show-spinner">
<?php $this->load->view('sidebar'); ?> 
	<main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Parent Settings</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Settings</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Parent Settings</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3">
					<div class="card">
						<div class="card-body">
							<div class="text-center">
								<p>Total Parents</p>
								<h4><?= $parentStats->totalParents; ?></h4>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card">
						<div class="card-body">
							<div class="text-center">
								<p>Active Parents</p>
								<h4><?= $parentStats->activeParents; ?></h4>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card">
						<div class="card-body">
							<div class="text-center">
								<p>Inactive Parents</p>
								<h4><?= $parentStats->inactiveParents; ?></h4>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card">
						<div class="card-body">
							<div class="text-center">
								<p>Pending Parents</p>
								<h4><?= $parentStats->pendingParents; ?></h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="selectFilters my-4 text-right">
				        <div class="filterAll">
				            <?php 
					            if (isset($_GET['order']) && $_GET['order']=="ASC" || empty($_GET['order'])) {
					              $url = base_url("Settings/parentSettings")."?order=DESC";
					            } else { 
					              $url = base_url("Settings/parentSettings")."?order=ASC";
					            }
				            ?>
				            <a class="btn icon-btn btn-outline-primary" href="<?php echo $url; ?>">
				            	<div class="icon-btn">
				              		<img src="<?php echo base_url("assets/images/icons/sort.svg"); ?>" alt="sort">
				            	</div>
				          	</a>
				          	<a href="<?php echo base_url("Settings/addParent"); ?>" class="btn btn-primary">
				          		<span class="simple-icon-plus"></span> Add Parent
				          	</a>
				        </div>
				    </div>
				</div>
			</div>
		</div>	
		<div class="container-fluid">
			<div class="row">
	        <?php foreach ($parents as $key => $pobj) { ?>
				<div class="col-sm-4">
					<div class="users-box col1 bg-white">
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
					      <li class="users-list-item name">
					        <span class="simple-icon-user"></span> <?php echo $pobj->userType; ?>
					      </li>
					      <li class="users-list-item">
					        <span class="iconsminds-suitcase"></span> <?php echo $pobj->status; ?>
					      </li>
					      <li class="users-list-item">
					        <span class="simple-icon-calendar"></span> <?php echo date('d-m-y',strtotime($pobj->dob)); ?>
					      </li>
					    </ul>
					  </div>
					</div>
				</div>
	        <?php } ?>
        </div>
      </div>				
    </main>
	<?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?id=1234"></script>
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
</body>
</html>


<!-- <script>
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




</script> -->