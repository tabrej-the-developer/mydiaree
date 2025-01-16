<?php
	$data['name']='Application Settings'; 
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
		.formDiv {
			min-height: calc(100vh - 335px);
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: flex-start;
			text-align: center;
		}
		.main-box {
			display: block;
			margin: 30px 0 0;
			width: 100%;
		}
		.box-item {
			border-radius: 5px !important;
			margin: 5px 0px;
		}
		.box-head {
			display: block;
			border: 1px solid var(--grey5);
			overflow: hidden;
			border-radius: 5px 5px 0 0;
			-o-border-radius: 5px 5px 0 0;
			-webkit-border-radius: 5px 5px 0 0;
			line-height: 30px;
		}
		.box-head .form-group {
			display: flex;
			box-sizing: border-box;
			width: 100%;
			align-items: center;
			justify-content: space-between;
			padding: 0;
			line-height: 24px;
			margin: 0;
		}
	</style>
</head>
<body id="app-container" class="menu-default show-spinner">
<?php $this->load->view('sidebar'); ?> 
<main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Application Settings</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Settings</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Application Settings</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
			<div class="row">
				<div class="col-md-4 offset-md-4">
					<div class="card d-flex flex-row">
						<div class="card-body">
					
					
		<form action="<?php echo base_url("Settings/saveApplicationSettings"); ?>" method="post">
			<!-- <div class="sideMenu">
				<php $this->load->view('settings-menu-sidebar'); ?>
			</div> -->
		
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
					<div class="main-box">
						<div class="box-head box-item">
							<div class="form-group">
								<?php 
									if(isset($JournalTabs->breakfast) && $JournalTabs->breakfast==1)
									{ 
										$checkstr = "value='".$JournalTabs->breakfast."' checked"; 
									}else{ 
										$checkstr = "value='0'"; 
									} 
								?>
								<label for="breakfast">breakfast</label>
								<input id="breakfast" type="checkbox" class="programming pull-right" name="breakfast" <?= $checkstr; ?>>
							</div>
						</div>
						<div class="box-head box-item">
							<div class="form-group">
								<?php 
									if(isset($JournalTabs->morningtea) && $JournalTabs->morningtea==1)
									{ 
										$checkstr = "value='".$JournalTabs->morningtea."' checked"; 
									}else{ 
										$checkstr = "value='0'"; 
									} 
								?>
								<label for="morningtea">morningtea</label>
								<input id="morningtea" type="checkbox" class="programming pull-right" name="morningtea" <?= $checkstr; ?>>
							</div>
						</div>
						<div class="box-head box-item">
							<div class="form-group">
								<?php 
									if(isset($JournalTabs->lunch) && $JournalTabs->lunch==1)
									{ 
										$checkstr = "value='".$JournalTabs->lunch."' checked"; 
									}else{ 
										$checkstr = "value='0'"; 
									} 
								?>
								<label for="lunch">lunch</label>
								<input id="lunch" type="checkbox" class="programming pull-right" name="lunch" <?= $checkstr; ?>>
							</div>
						</div>
						<div class="box-head box-item">
							<div class="form-group">
								<?php 
									if(isset($JournalTabs->sleep) && $JournalTabs->sleep==1)
									{ 
										$checkstr = "value='".$JournalTabs->sleep."' checked"; 
									}else{ 
										$checkstr = "value='0'"; 
									} 
								?>
								<label for="sleep">sleep</label>
								<input id="sleep" type="checkbox" class="programming pull-right" name="sleep" <?= $checkstr; ?>>
							</div>
						</div>
						<div class="box-head box-item">
							<div class="form-group">
								<?php 
									if(isset($JournalTabs->afternoontea) && $JournalTabs->afternoontea==1)
									{ 
										$checkstr = "value='".$JournalTabs->afternoontea."' checked"; 
									}else{ 
										$checkstr = "value='0'"; 
									} 
								?>
								<label for="afternoontea">afternoontea</label>
								<input id="afternoontea" type="checkbox" class="programming pull-right" name="afternoontea" <?= $checkstr; ?>>
							</div>
						</div>
						<div class="box-head box-item">
							<div class="form-group">
								<?php 
									if(isset($JournalTabs->latesnacks) && $JournalTabs->latesnacks==1)
									{ 
										$checkstr = "value='".$JournalTabs->latesnacks."' checked"; 
									}else{ 
										$checkstr = "value='0'"; 
									} 
								?>
								<label for="latesnacks">latesnacks</label>
								<input id="latesnacks" type="checkbox" class="programming pull-right" name="latesnacks" <?= $checkstr; ?>>
							</div>
						</div>
						<div class="box-head box-item">
							<div class="form-group">
								<?php 
									if(isset($JournalTabs->sunscreen) && $JournalTabs->sunscreen==1)
									{ 
										$checkstr = "value='".$JournalTabs->sunscreen."' checked"; 
									}else{ 
										$checkstr = "value='0'"; 
									} 
								?>
								<label for="sunscreen">sunscreen</label>
								<input id="sunscreen" type="checkbox" class="programming pull-right" name="sunscreen" <?= $checkstr; ?>>
							</div>
						</div>
						<div class="box-head box-item">
							<div class="form-group">
								<?php 
									if(isset($JournalTabs->toileting) && $JournalTabs->toileting==1)
									{ 
										$checkstr = "value='".$JournalTabs->toileting."' checked"; 
									}else{ 
										$checkstr = "value='0'"; 
									} 
								?>
								<label for="toileting">toileting</label>
								<input id="toileting" type="checkbox" class="programming pull-right" name="toileting" <?= $checkstr; ?>>
							</div>
						</div>
					</div>
					<div class="formSubmit">
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
				window.location.href="<?php echo base_url('Settings/applicationSettings'); ?>?centerId="+$(this).val();
			});
		});
	</script>
</body>
</html>

<!-- <php $this->load->view('footer'); ?> -->
