<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Module Settings | Mykronicle v2</title>
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
		.formDiv {
			min-height: calc(100vh - 335px);
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: flex-start;
			/* text-align: center; */
		}
		.main-box {
			display: block;
			margin: 30px 0 0;
			width: 100%;
		}
		.box-head {
			display: block;
			/* border: 1px solid #dfdfdf; */
			overflow: hidden;
			/* border-radius: 5px 5px 0 0;
			-o-border-radius: 5px 5px 0 0;
			-webkit-border-radius: 5px 5px 0 0; */
			/* line-height: 30px; */
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
		.rightFOrmSection {
			/* background: #fff;
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
		.form-group{
			display: flex;
			justify-content: space-between;
		}

	</style>
</head>

<body id="app-container" class="menu-default show-spinner">
<?php $this->load->view('sidebar'); ?> 
    <main data-centerid="<?= isset($_GET['centerid'])?$_GET['centerid']:$centerid; ?>">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Module Settings</h1>
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
                                    <a class="dropdown-item" href="<?= current_url().'?centerid='.$center->id; ?>">
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
							<li class="breadcrumb-item active" aria-current="page">Module Settings</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
			<div class="row text-left">
                <div class="col-md-3"></div>
                <div class="col-md-6 col-sm-12">
					<div class="card d-flex flex-row">
						<div class="card-body">
						    <div class="settingsView">
                                <form action="<?php echo base_url("Settings/addModuleSettings") . '?centerid=' . $centerid; ?>" method="post">
                                    <div class="rightFOrmSection">

                                        <div class="main-box" id="accordion">
                                            <div class="box-head" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <div class="form-group" >
                                                    <label for="Prog" class="list-item-heading text-left text-one">Programming</label>
                                                    <input type="checkbox" class="pull-right" id="prog">
                                                </div>
                                            </div>
                                            <hr class="m-0">
                                            <div class="box-body mt-2" id="collapseOne" class="collapse show" data-parent="#accordion" style="">
                                                <div class="form-group accordion-content">
                                                    <label for="Observation">Observation</label>
                                                    <input id="Observation" type="checkbox" class="programming pull-right" name="observation" <?php if(isset($modules->observation)&&$modules->observation==1){echo "value='".$modules->observation."' checked";}else{echo "value='1'";}?>>
                                                </div>
                                                <div class="form-group accordion-content">
                                                    <label for="Rooms">Rooms</label>
                                                    <input id="Rooms" type="checkbox" class="programming pull-right" name="room"<?php if(isset($modules->room)&&$modules->room==1){echo "value='".$modules->room."' checked";}else{echo "value='1'";}?>>
                                                </div>
                                                <div class="form-group">
                                                    <label for="progPlan">Program Plans</label>
                                                    <input id="progPlan" type="checkbox" class="programming pull-right" name="programplans" <?php if(isset($modules->programplans)&&$modules->programplans==1){echo "value='".$modules->programplans."' checked";}else{echo "value='1'";}?>>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="main-box">
                                            <div class="box-head" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                <div class="form-group">
                                                    <label for="qip" class="list-item-heading text-left text-one">QIP</label>
                                                    <input type="checkbox" class="pull-right" id="QIP">
                                                </div>
                                            </div>
                                            <hr class="m-0">
                                            <div class="box-body mt-2" id="collapseTwo" class="collapse show" data-parent="#accordion" style="">
                                                <div class="form-group accordion-content">
                                                    <label for="SelfAssessment ">Self Assessment</label>
                                                    <input id="SelfAssessment" type="checkbox" class="qip pull-right" name="selfAssessment" <?php if(isset($modules->selfAssessment)&&$modules->selfAssessment==1){echo "value='".$modules->selfAssessment."' checked";}else{echo "value='1'";}?>>
                                                </div>
                                                <div class="form-group accordion-content">
                                                    <label for="QIP">Quality Improvment Plan</label>
                                                    <input id="Qip" type="checkbox" class="qip pull-right" name="qip"<?php if(isset($modules->qip)&&$modules->qip==1){echo "value='".$modules->qip."' checked";}else{echo "value='1'";}?>>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="main-box">
                                            <div class="box-head" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                                <div class="form-group">
                                                    <label for="community" class="list-item-heading text-left text-one">Community</label>
                                                    <input type="checkbox" class="pull-right" id="community">
                                                </div>
                                            </div>
                                            <hr class="m-0">
                                            <div class="box-body mt-2" id="collapseThree" class="collapse show" data-parent="#accordion" style="">
                                                <div class="form-group accordion-content">
                                                    <label for="Announcements">Announcements</label>
                                                    <input id="Announcements" type="checkbox" class="community pull-right" name="announcements" <?php if(isset($modules->announcements)&&$modules->announcements==1){echo "value='".$modules->announcements."' checked";}else{echo "value='1'";}?>>
                                                </div>
                                                <div class="form-group accordion-content">
                                                    <label for="Surveys">Surveys</label>
                                                    <input id="Surveys" type="checkbox" class="community pull-right" name="survey" <?php if(isset($modules->survey)&&$modules->survey==1){echo "value='".$modules->survey."' checked";}else{echo "value='1'";}?>>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="main-box">
                                            <div class="box-head" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                                <div class="form-group">
                                                    <label for="health" class="list-item-heading text-left text-one">Healthy Eating</label>
                                                    <input type="checkbox" class="pull-right" id="health">
                                                </div>
                                            </div>
                                            <hr class="m-0">
                                            <div class="box-body mt-2" id="collapseFour" class="collapse show" data-parent="#accordion" style="">
                                                <div class="form-group accordion-content">
                                                    <label for="Menus">Menus</label>
                                                    <input id="Menus" type="checkbox" class="health pull-right" name="menu" <?php if(isset($modules->menu)&&$modules->menu==1){echo "value='".$modules->menu."' checked";}else{echo "value='1'";}?>>
                                                </div>
                                                <div class="form-group accordion-content">
                                                    <label for="Recipes">Recipes</label>
                                                    <input id="Recipes" type="checkbox" class="health pull-right" name="recipe"  <?php if(isset($modules->recipe)&&$modules->recipe==1){echo "value='".$modules->recipe."' checked";}else{echo "value='1'";}?>>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="main-box">
                                            <div class="box-head" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                                <div class="form-group">
                                                    <label for="daily-diary" class="list-item-heading text-left text-one">Daily Journal</label>
                                                    <input type="checkbox" class="pull-right" id="daily-diary">
                                                </div>
                                            </div>
                                            <hr class="m-0">
                                            <div class="box-body mt-2" id="collapseFive" class="collapse show" data-parent="#accordion" style="">
                                                <div class="form-group accordion-content">
                                                    <label for="dailydiary">Daily Diary</label>
                                                    <input type="checkbox" id="dailydiary" class="daily-diary pull-right" name="dailydiary" <?php if(isset($modules->dailydiary)&&$modules->dailydiary==1){echo "value='".$modules->dailydiary."' checked";}else{echo "value='1'";}?>>
                                                </div>
                                                <div class="form-group accordion-content">
                                                    <label for="headchecks">Head Checks</label>
                                                    <input type="checkbox" id="headchecks" class="daily-diary pull-right" name="headchecks" <?php if(isset($modules->headchecks)&&$modules->headchecks==1){echo "value='".$modules->headchecks."' checked";}else{echo "value='1'";}?>>
                                                </div>
                                                <div class="form-group accordion-content">
                                                    <label for="accidents">Accidents</label>
                                                    <input type="checkbox" id="accidents" class="daily-diary pull-right" name="accidents" <?php if(isset($modules->accidents)&&$modules->accidents==1){echo "value='".$modules->accidents."' checked";}else{echo "value='1'";}?>>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="main-box">
                                            <div class="form-group single-form-group">
                                            <label for="resources">Resources</label>
                                                <input type="checkbox" id="resources" class="pull-right" name="resources"  <?php if(isset($modules->resources)&&$modules->resources==1){echo "value='".$modules->resources."' checked";}else{echo "value='1'";}?>>
                                            </div>
                                        </div>
                                        <div class="main-box">
                                            <div class="form-group single-form-group">
                                            <label for="servicedetails">Service Details</label>
                                                <input id="servicedetails" type="checkbox" class="pull-right" name="servicedetails"  <?php if(isset($modules->servicedetails)&&$modules->servicedetails==1){echo "value='".$modules->servicedetails."' checked";}else{echo "value='1'";}?>>
                                            </div>
                                        </div>
                                                
                                        <div class="formSubmit text-center">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>    
			</div>
        </div>
    </main>
      

	<?php 

$role = $this->session->userdata('UserType');
if ($role == "Superadmin") {
	$run = 1;
} else {
	if ($role=="Staff") {
		if (isset($permissions)) {
			if ($permissions->updateModules==1) {
				$run = 1;
			}else{
				$run = 0;
			}
		} else {
			$run = 0;
		}
	}else{
		$run = 0;
	}
}

if ($run == 1) {
?>
<?php
}
?>
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
		var checkboxes = $('.programming:checkbox:checked').length;
	    var totalboxes = $('.programming:checkbox').length;
    	if(totalboxes==checkboxes){
    		$('#prog').prop('checked',true);
    	}else{
    		$('#prog').prop('checked',false);
    	}

        var checkboxes = $('.qip:checkbox:checked').length;
	    var totalboxes = $('.qip:checkbox').length;
    	if(totalboxes==checkboxes){
    		$('#QIP').prop('checked',true);
    	}else{
    		$('#QIP').prop('checked',false);
    	}

    	var checkboxes = $('.community:checkbox:checked').length;
	    var totalboxes = $('.community:checkbox').length;
    	if(totalboxes==checkboxes){
    		$('#community').prop('checked',true);
    	}else{
    		$('#community').prop('checked',false);
    	}

    	var checkboxes = $('.health:checkbox:checked').length;
	    var totalboxes = $('.health:checkbox').length;
    	if(totalboxes==checkboxes){
    		$('#health').prop('checked',true);
    	}else{
    		$('#health').prop('checked',false);
    	}

    	var checkboxes = $('.daily-diary:checkbox:checked').length;
	    var totalboxes = $('.daily-diary:checkbox').length;
    	if(totalboxes==checkboxes){
    		$('#daily-diary').prop('checked',true);
    	}else{
    		$('#daily-diary').prop('checked',false);
    	}

		$(document).on('click','#prog',function() {
			if($(this).prop("checked")==true) {
	    		$('.programming').prop('checked',true);
			}else{
	    		$('.programming').prop('checked',false);
			}
		});

        $(document).on('click','#QIP',function() {
			if($(this).prop("checked")==true) {
	    		$('.qip').prop('checked',true);
			}else{
	    		$('.qip').prop('checked',false);
			}
		});

		$(document).on('click','.programming',function() {
		    var checkboxes = $('.programming:checkbox:checked').length;
		    var totalboxes = $('.programming:checkbox').length;
	    	if(totalboxes==checkboxes){
	    		$('#prog').prop('checked',true);
	    	}else{
	    		$('#prog').prop('checked',false);
	    	}
		});

        $(document).on('click','.qip',function() {
		    var checkboxes = $('.qip:checkbox:checked').length;
		    var totalboxes = $('.qip:checkbox').length;
	    	if(totalboxes==checkboxes){
	    		$('#QIP').prop('checked',true);
	    	}else{
	    		$('#QIP').prop('checked',false);
	    	}
		});

		$(document).on('click','#community',function() {
			if($(this).prop("checked")==true) {
	    		$('.community').prop('checked',true);
			}else{
	    		$('.community').prop('checked',false);
			}
		});

		$(document).on('click','.community',function() {
		    var checkboxes = $('.community:checkbox:checked').length;
		    var totalboxes = $('.community:checkbox').length;
	    	if(totalboxes==checkboxes){
	    		$('#community').prop('checked',true);
	    	}else{
	    		$('#community').prop('checked',false);
	    	}
		});

		$(document).on('click','#health',function() {
			if($(this).prop("checked")==true) {
	    		$('.health').prop('checked',true);
			}else{
	    		$('.health').prop('checked',false);
			}
		});

		$(document).on('click','.health',function() {
		    var checkboxes = $('.health:checkbox:checked').length;
		    var totalboxes = $('.health:checkbox').length;
	    	if(totalboxes==checkboxes){
	    		$('#health').prop('checked',true);
	    	}else{
	    		$('#health').prop('checked',false);
	    	}
		});

		$(document).on('click','#daily-diary',function() {
			if($(this).prop("checked")==true) {
	    		$('.daily-diary').prop('checked',true);
			}else{
	    		$('.daily-diary').prop('checked',false);
			}
		});

		$(document).on('click','.daily-diary',function() {
		    var checkboxes = $('.daily-diary:checkbox:checked').length;
		    var totalboxes = $('.daily-diary:checkbox').length;
	    	if(totalboxes==checkboxes){
	    		$('#daily-diary').prop('checked',true);
	    	}else{
	    		$('#daily-diary').prop('checked',false);
	    	}
		});

		$("#centerId").on('change',function(){
			window.location.href="<?php echo base_url('Settings/moduleSettings'); ?>?centerId="+$(this).val();
		});
	});
</script>
</body>
</html>


		

