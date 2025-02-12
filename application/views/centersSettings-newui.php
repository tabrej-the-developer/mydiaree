<?php
	$data['name']='Center Settings'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Mydiaree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

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
			margin: 10px 0px;
			border: 1px solid #d7d7d7;
			padding: 10px;
			border-radius: 5px;
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
		.users-info {
			width: calc(100% - 140px);
		}
		.userListContainer .col-sm-4 {
			flex: 0 0 calc(50% - 15px);
			padding: 30px;
			margin-top: 10px;
			margin-right: 10px;
			/* margin-left: 30px; */
			box-shadow: 0 0 5px rgb(0 0 0 / 16%);
			-o-box-shadow: 0 0 5px rgb(0 0 0 / 16%);
			-ms-box-shadow: 0 0 5px rgb(0 0 0 / 16%);
			-moz-box-shadow: 0 0 5px rgb(0 0 0 / 16%);
			-webkit-box-shadow: 0 0 5px rgb(0 0 0 / 16%);
		}
		.input-group-text {
    		background-color: white;
			border-right: none;
		}

		@media only screen and (min-width: 320px) and (max-width: 600px){
			.userListContainer .col-sm-4 {
				flex:inherit;
				margin-bottom:20px;
			}
		}
	</style>
</head>

<body id="app-container" class="menu-default show-spinner" style="background-color: #f8f8f8; top: -35px; bottom:0px;">
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
                            <li class="breadcrumb-item active" aria-current="page">Center Settings</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
		</div>
		
		<div class="row">
				<div class="col-md-12">
					<div class="card d-flex flex-row">
						<div class="card-body">
						
						<div class="settingsView">
		           v       <div class="rightFOrmSection">
                             <h3>
                            <?php echo $data['name']; ?>
                            <div class="filterAll float-right">
                                <?php 
                                    if (isset($_GET['order']) && $_GET['order']=="ASC" || empty($_GET['order'])) {
                                        $url = base_url("Settings/centerSettings")."?order=DESC";
                                    } else { 
                                        $url = base_url("Settings/centerSettings")."?order=ASC";
                                    }
                                    
                                ?>
						      </h3>
                        <div class="input-group searchGroup mt-4">
                            <span class="input-group-text" id="search">
                            <img src="<?php echo base_url("assets/images/icons/search.svg"); ?>" alt="search">
                            </span>
                            <input type="text" class="form-control form-search" placeholder="Search" aria-describedby="search" style="border-left:none;">
                  </div>
				         <div class="my-3 text-right">
                                <a class="btn icon-btn btn-primary" href="<?php echo $url; ?>">
                                    <span class="iconsminds-align-right" title="order-sorting"></span>
                                </a>
                                <a href="<?php echo base_url("Settings/addCenter"); ?>" class="btn btn-primary">
								 <span class="simple-icon-plus btn-primary"></span> Add Center</a>
                            </div>
							<div class="container-fluid">
								<div class="row">
								<?php foreach ($centers as $key => $cobj) { ?>
				<div class="col-sm-4">
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
</main>

								</div>
							</div>

		
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
</body>
</html>
