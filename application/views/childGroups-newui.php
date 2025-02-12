<?php
	$data['name']='Child Groups'; 
	// $this->load->view('header',$data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Mydiaree</title>
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
		.rightFOrmSection {
			/* background: var(--white);
			margin-left: 30px; */
			width: 100%;
			/* padding: 30px; */
			min-height: calc(100vh - 190px);
			display: flex;
			flex-direction: column;
			overflow: hidden;
				overflow-y: hidden;
			overflow-y: auto;
			border-radius: 10px;
			-o-border-radius: 10px;
			-webkit-border-radius: 10px;
		}
		.flexChildGroup {
			display: flex;
			align-items: flex-start;
			flex-wrap: wrap;
		}
		.flexChildGroupBlock .users-box {
			/* background: var(--white); */
			padding: 30px;
			box-sizing: border-box;
			box-shadow: 0 0 10px var(--black)00014;
			display: block;
		}
		.flexChildGroupBlock .users-box a {
			display: inline-block;
			font-size: 18px;
			/* color: var(--blue2); */
			font-weight: 600;
			margin: 0 0 20px;
		}
		.childrenList {
			display: flex;
			align-items: center;
			justify-content: flex-start;
		}
		.flexChildGroup .flexChildGroupBlock {
			/* margin-left: 30px; */
			margin-bottom: 30px;
			width: calc(50% - 15px);
		}
		.childrenList img {
			width: 80px;
			height: 80px;
			display: inline-block;
			margin-left: 10px;
			border-radius: 80px;
			-o-border-radius: 80px;
			-webkit-border-radius: 80px;
		}
	</style>
</head>

<body id="app-container" class="menu-default show-spinner">
<?php $this->load->view('sidebar'); ?> 

<main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Child Group</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Settings</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Child Group</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
			<div class="row">
				<div class="col-md-12">
					<div class="card d-flex flex-row">
						<div class="card-body">
						<div class="settingsView">
		<!-- <div class="sideMenu">
			<php $this->load->view('settings-menu-sidebar'); ?>
		</div> -->
		<div class="rightFOrmSection">
			<h3><?php echo $data['name']; ?>
				<div class="filterAll">
					<a href="<?php echo base_url("Settings/addChildGroup"); ?>" class="btn btn-default btn-info pull-right btn-small btnBlue float-right"><span class="simple-icon-plus"></span> Add Group</a>
				</div>
			</h3>
			<div class="flexChildGroup">
					<?php foreach ($groups as $key => $grobj) { ?>
						<div class="flexChildGroupBlock col-sm-6">
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
				</div>
			</div>
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
</body>
</html>



<!-- <php $this->load->view('footer'); ?>
<script>
	$(document).ready(function(){
		
	});
</script> -->