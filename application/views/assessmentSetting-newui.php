<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assessment Settings | Mydiaree</title>
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
	<style>
		.assessmentCheck{
			display: inline-block;
		}

		div.rightFOrmSection > form {
			display: block;
		}
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
		.rightFOrmSection h3 {
			margin: 0 0 30px !important;
			line-height: 40px;
		}
		.assessmentCheck {
			display: inline-block;
			width: 100%;
		}
		.rightFOrmSection h3 .filterAll {
			float: right;
		}
		.filterAll {
			display: flex;
			align-items: center;
		}
		.assessmentCheck label {
			padding: 10px;
			/* background: #fff; */
			/* border: 1px solid #ddd; */
			/* margin: 0 0 20px; */
			/* border-radius: 10px; */
			display: flex;
			align-items: center;
			justify-content: space-between;
		}
	</style>
</head>
<body id="app-container" class="menu-default show-spinner">
<?php $this->load->view('sidebar'); ?> 
	<main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Assessment Settings</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Settings</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Assessment Settings</li>
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
								<h3>Assessment Settings</h3>
								<div class="form-group">
									<select name="centerid" id="centerId" class="form-control">
										<?php 
											$dupArr = [];
											foreach ($this->session->userdata("centerIds") as $key => $center){
												if ( ! in_array($center, $dupArr)) {
													if (isset($_GET['centerid']) && $_GET['centerid'] != "" && $_GET['centerid']==$center->id) {
										?>
										<option value="<?php echo $center->id; ?>" selected><?php echo $center->centerName; ?></option>
										<?php }else{ ?>
										<option value="<?php echo $center->id; ?>"><?php echo $center->centerName; ?></option>
										<?php
											}
											}
											array_push($dupArr, $center);
										}
										?>
									</select>
								</div>
								<?php 
									if (isset($_GET['centerid'])) {
										$montUrl = base_url("Settings/montessori")."?centerid=".$_GET['centerid'];
										$eylfUrl = base_url("Settings/eylf")."?centerid=".$_GET['centerid'];
										$devUrl = base_url("Settings/developmentmilestone")."?centerid=".$_GET['centerid'];
									} else {
										$montUrl = base_url("Settings/montessori");
										$eylfUrl = base_url("Settings/eylf");
										$devUrl = base_url("Settings/developmentmilestone");
									}
									
								?>
								<form action="<?= base_url("Settings/saveAsmntSettings"); ?>" method="post">
								<input type="hidden" name="centerid" value="<?= isset($Settings->centerid) ? $Settings->centerid : (isset($_GET['centerid']) ? $_GET['centerid'] : ''); ?>">
									<div class="assessmentCheck">
										<label for="Montessori" >
											<span class="assessmentCheckName"><a href="<?= $montUrl; ?>">Montessori</a></span>
											<input name="montessori" id="Montessori" type="checkbox" value="1" <?= (isset($Settings->montessori)&&$Settings->montessori==1)?'checked':NULL; ?> >
										</label>
										<label for="EYLF" >
											<span class="assessmentCheckName"><a href="<?= $eylfUrl; ?>">EYLF</a></span>
											<input name="eylf" id="EYLF" type="checkbox" value="1" <?= (isset($Settings->eylf)&&$Settings->eylf==1)?'checked':NULL; ?> >
										</label>
										<label for="Development-Milestone" >
											<span class="assessmentCheckName"><a href="<?= $devUrl; ?>">Development Milestone</a></span>
											<input name="devmile" id="Development-Milestone" type="checkbox" value="1" <?= (isset($Settings->devmile)&&$Settings->devmile==1)?'checked':NULL; ?> >
										</label>
									</div>
									<div class="form-group text-right">
										<?php 
											if ($this->session->userdata('UserType') == "Superadmin") {
												$show = 1;
											} elseif ($this->session->userdata('UserType') == "Staff") {
												$show = $Permissions->assessment;
											} else{
												$show = 0;
											}

											if ($show==1) {
										?>
										<button type="submit" class="btn btnBlue btn-primary">Save</button>
										<?php }else{ ?>
										<button type="button" class="btn btnBlue btn-primary" disabled>Save</button>
										<?php } ?>	
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
			let centerid = $(this).val();
			<?php  
				$qs = $_SERVER['QUERY_STRING'];
				if ($qs == "") {
					$url = "centerid=";
				}else{
					if (isset($_GET['centerid']) && $_GET['centerid']!="") {
						$url = str_replace('centerid='.$_GET['centerid'], 'centerid=', $_SERVER['QUERY_STRING']);
					} else {
						// $tempurl = str_replace('centerid=', '', $_SERVER['QUERY_STRING']);
						$url = $_SERVER['QUERY_STRING']."&centerid=";
					}
				} 
			?>
			var url = "<?php echo base_url('Settings/assessment?').$url; ?>"+centerid;
			var test = url.replace(/&/g, '&');
			window.location.href=test;
		});
	});
	</script>
</body>
</html>


<!-- <php $this->load->view('footer'); ?> -->
