<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Settings | Mykronicle v2</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js?v=1.0.0"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
	<style>
		.list-thumbnail{
			width: 85px!important;
		}
	</style>
</head>

<body id="app-container" class="menu-default show-spinner">
	<?php $this->load->view('sidebar'); ?> 
   
	<main data-centerid="<?= $centerid; ?>">
        <div class="container-fluid">
        	<!-- Breadcrumb area -->
            <div class="row">
                <div class="col-12">
                    <h1>User Settings</h1>
                    <div class="text-zero top-right-button-container d-flex flex-row">
                        <div class="btn-group mr-1">
                            <?php 
                                $dupArr = [];
                                $centersList = $this->session->userdata("centerIds");
                                if (empty($centersList)) {
                            ?>
                            <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> EMPTY CENTER </div>
                            <?php
                                }else{
                                    if (isset($_GET['centerid'])) {
                                        foreach($centersList as $key => $center){
                                            if ( ! in_array($center, $dupArr)) {
                                                if ($_GET['centerid']==$center->id) {
                            ?>
                            <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= strtoupper($center->centerName); ?> </div>
                            <?php
                                                }
                                            }
                                            array_push($dupArr, $center);
                                        }
                                    } else {
                            ?>
                            <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= strtoupper($centersList[0]->centerName); ?> </div>
                            <?php
                                    }
                                }

                                if (!empty($centersList)) {
                            ?>
                            <div class="dropdown-menu dropdown-menu-right">
                                <?php foreach($centersList as $key => $center){ ?>
                                    <a class="dropdown-item" href="<?= current_url() . '?centerid=' . $center->id; ?>">
                                        <?= strtoupper($center->centerName); ?>
                                    </a>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
	                </div>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Settings</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">User Settings</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <!-- Breadcrumb area end-->

            <!-- Ticker area -->
			<div class="row mb-5">
				<div class="col-md-3">
					<div class="card">
						<div class="card-body text-center">
							<h3><?= $userStats->totalUsers; ?></h3>
							<p class="text-muted">Total Users</p>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card">
						<div class="card-body text-center">
							<h3><?= $userStats->activeUsers; ?></h3>
							<p class="text-muted">Active Users</p>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card">
						<div class="card-body text-center">
							<h3><?= $userStats->inactiveUsers; ?></h3>
							<p class="text-muted">In-active Users</p>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card">
						<div class="card-body text-center">
							<h3><?= $userStats->pendingUsers; ?></h3>
							<p class="text-muted">Pending Users</p>
						</div>
					</div>
				</div>
			</div>
			<!-- Ticker area end-->

			<!-- Options -->
			<div class="row mb-5">
				<div class="col-md-6">
					<div class="input-group typeahead-container">
                        <input type="text" class="form-control typeahead" name="query" id="query" placeholder="Start typing something to search..." data-provide="typeahead" autocomplete="off">
                        <div class="input-group-append ">
                            <button type="submit" class="btn btn-primary">
                                <i class="simple-icon-magnifier"></i>
                            </button>
                        </div>
                    </div>
				</div>
				<div class="col-md-6 text-right">
					<?php 
						if (isset($_GET['order']) && $_GET['order']=="ASC" || empty($_GET['order'])) {
							$url = base_url("Settings/userSettings")."?centerid=".$centerid."&order=DESC";
						} else { 
							$url = base_url("Settings/userSettings")."?centerid=".$centerid."&order=ASC";
						}
					?>
					<a class="btn icon-btn btn-primary" href="<?= $url; ?>">
						<span class="simple-icon-list"></span>
					</a>
					<a href="<?= base_url("Settings/export_excel"); ?>" class="btn btn-primary">
						<span class="simple-icon-login"></span> Export</a>
					<a href="<?= base_url('Settings/addUsers') . '?centerid=' . $centerid; ?>" class="btn btn-primary"> 
						<span class="simple-icon-user-follow"></span> Add User</a>
				</div>
			</div>
			<!-- Options End-->

			<!-- Users -->
			<div class="row">
				<?php 
					foreach ($users as $key => $obj){ 
						if (empty($obj->imageUrl)) {
							$imageSrc = "https://via.placeholder.com/80x80?text=No+Image";
						}else{
							if (file_exists('api/assets/media/'.$obj->imageUrl)) {
								$imageSrc = base_url('api/assets/media/').$obj->imageUrl;
							} else {
								$imageSrc = "https://via.placeholder.com/80x80?text=No+Image";
							}
						}
				?>
					<div class="col-md-4">
						<div class="card d-flex flex-row mb-4">
                            <a class="d-flex" href="#">
                                <img alt="Profile" src="<?= $imageSrc;?>" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center">
                            </a>
                            <div class="d-flex flex-grow-1 min-width-zero">
                                <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                                    <div class="min-width-zero">
                                        <a href="#">
                                            <p class="list-item-heading mb-1 truncate"><?= ucwords(strtolower($obj->name)); ?></p>
                                        </a>
                                        <p class="mb-2 text-muted text-small"><?= $obj->status; ?></p>
                                        <a href="<?= base_url('Settings/addUsers') . '?recordId=' . $obj->userid . '&centerid=' . $centerid; ?>" class="btn btn-xs btn-outline-primary ">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
				<?php } ?>
			</div>
			<!-- Users End-->

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
	<script>
		$(document).ready(function(){
		});
	</script>
</body>
</html>



