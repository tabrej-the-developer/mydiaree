<?php
	$data['name']='Notice Period Settings'; 
	// $this->load->view('header',$data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Mykronicle</title>
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
	<link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2-bootstrap.min.css?id=1234" />
	</head>
<body id="app-container" class="menu-default show-spinner">
<?php $this->load->view('sidebar'); ?> 
<main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Notice Period Settings</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Settings</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Notice Period Settings</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
			<div class="row">
				<div class="col-md-4 offset-md-4">
					<div class="card d-flex flex-row">
						<div class="card-body">
						<div class="settingsView">
		<form action="<?php echo base_url("Settings/saveNoticeSettings"); ?>" method="post">
			<!-- <div class="sideMenu">
				<php $this->load->view('settings-menu-sidebar'); ?>
			</div> -->
			<div class="rightFOrmSection">
				<h3><?php echo $data['name']; ?></h3>
				<div class="formDiv">
					<select name="centerid" id="centerId" class="form-control fullSelect">
				        <?php 
				          foreach ($this->session->userdata("centerIds") as $key => $center) {
				          	if ((!empty($JournalTabs) && $JournalTabs->centerid == $center->id) || (isset($_GET['centerId']) && $_GET['centerId']==$center->id)) {
				        ?>
				        <option value="<?php echo $center->id; ?>" selected><?php echo $center->centerName; ?></option>
				        <?php
				          	} else {
				        ?>
				        <option value="<?php echo $center->id; ?>"><?php echo $center->centerName; ?></option>
				        <?php
				          	}
				          }
				        ?>
				    </select>
					<div class="main-box mt-4">
						<div class="box-head box-item">
							<?php 
								if(isset($Notice->days) && $Notice->days !="")
								{ 
									$checkstr = $Notice->days; 
								}else{ 
									$checkstr = "";
								} 
							?>
							<div class="input-group mb-3">
								<input type="number" name="number" class="form-control" placeholder="Enter number" value="<?= $checkstr; ?>">
								<span class="input-group-text" id="basic-addon2">Days</span>
							</div>
						</div>
					</div>
					<div class="formSubmit text-right">
						<button type="submit" class="btn btn-default btnBlue pull-right btn-primary">Save</button>
					</div>
				</div>
			</div>
		</form>
	</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </main>
<?php $this->load->view('footer_v3'); ?>
	<script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?id=1234"></script>
	<script src="<?= base_url('assets/v3'); ?>/js/vendor/select2.full.js?id=1234"></script>
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
		$("#centerId").on('change',function(){
			window.location.href="<?php echo base_url('Settings/noticePeriodSettings'); ?>?centerId="+$(this).val();
		});
	});
</script>
</body>
</html>