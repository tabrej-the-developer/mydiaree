<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Center Settings | Mydiaree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
</head>

<body id="app-container" class="menu-default show-spinner">
	<?php $this->load->view('sidebar'); ?> 
	<main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Center Settings</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('dashboard'); ?>">Dashboard</a>
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
		
		<div class="row mb-3">
			<div class="col-md-5 text-right">
				
			</div>
			<div class="col-md-4"></div>
			<div class="col-md-3">
				<?php 
                    if (isset($_GET['order']) && $_GET['order']=="ASC" || empty($_GET['order'])) {
                        $url = base_url("Settings/centerSettings")."?order=DESC";
                        $orderby = "Newest First";
                    } else { 
                        $url = base_url("Settings/centerSettings")."?order=ASC";
                        $orderby = "Oldest First";
                    }
                ?>
				<a href="<?= $url; ?>" class="btn btn-outline-primary dropdown-toggle"><?= $orderby; ?></a>
				<a href="<?= base_url("Settings/addCenter"); ?>" class="btn btn-primary"> Add Center </a>
			</div>
		</div>	

		<div class="row">
			<?php foreach ($centers as $key => $cobj) { ?>
			<div class="col-md-4">
				<div class="card d-flex flex-row mb-4">
	                <a class="d-flex" href="#">
	                	<?php 
							if (empty($cobj->imageUrl)) {
								$image = "https://via.placeholder.com/120x120.png?text=No+Image";
							} else {
								$image = base_url("api/assets/media/").$cobj->imageUrl;
							}
						?>
	                    <img alt="Profile" src="<?= $image;?>" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center">
	                </a>
	                <div class="d-flex flex-grow-1 min-width-zero">
	                    <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
	                        <div class="min-width-zero">
	                            <a href="<?= base_url("Settings/addCenter")."?centerId=".$cobj->id; ?>">
	                                <p class="list-item-heading mb-1 truncate"><?= ucwords(strtolower($cobj->centerName)); ?></p>
	                            </a>
	                            <p class="mb-2 text-muted text-small"><?= $cobj->addressState; ?></p>
	                            <a href="<?= base_url("Settings/addCenter")."?centerId=".$cobj->id; ?>" class="btn btn-xs btn-outline-primary ">View</a>
	                        </div>
	                    </div>
	                </div>
	            </div>
			</div>
			<?php } ?>
		</div>		
	</main>
	<?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>
</body>
</html>
