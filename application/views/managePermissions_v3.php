<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Permissions | Mydiaree</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js?v=1.1.0"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.1.0" />

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.1.0" />
	<link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2.min.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2-bootstrap.min.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/permission-styles.css?v=1.1.0" />

	<style>
.permission-group {
    border: 1px solid #ddd;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 5px;
    background: #f9f9f9;
}

.checkbox-group {
    column-count: 2;
    column-gap: 20px;
}

.progress {
    height: 10px;
}

.progress-percentage {
    float: right;
    font-size: 12px;
    color: #666;
}
</style>
</head>

<body id="app-container" class="menu-default show-spinner">
<?php 
		
	$this->load->view('sidebar'); 
	//PHP Block


?> 
<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1>Manage Permissions Settings</h1>
                <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                    <ol class="breadcrumb pt-0">
                        <li class="breadcrumb-item">
                            <a href="#">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Settings</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Permissions Settings</li>
                    </ol>
                </nav>
				<button class="btn btn-outline-info" style="float:right;" data-toggle="modal" data-target="#permissionModal">Check Permission</button>        
				<div class="separator mb-5">		
				</div>
            </div>
        </div>
        <form action="<?= base_url('settings/savePermission'); ?>" method="post" id="permission-form">
			<div class="row">
				<div class="col-md-12">
					<div class="card d-flex flex-row">
						<div class="card-body">
							<div class="row flex-custom mb-4">
								<div class="col-md-5">
									<h5 class="card-title">Manage Permission</h5>
								</div>
								<div class="col-md-7">
									<div class="row">
										<div class="col">
											<select class="form-control select2-single" name="centerid" id="centerId" data-width="100%">
												<?php foreach ($centers as $key => $center) { ?>
												<option value="<?= $center->id; ?>"><?= $center->centerName; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col">
											<select class="form-control select2-multiple" name="users[]" id="users"  multiple="multiple" data-width="100%">
												<?php foreach ($users as $key => $usr) { ?>
												<option value="<?= $usr->userid; ?>" <?= $usr->checked; ?>><?= $usr->name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="separator mb-4"></div>
							<div class="row">
								<div class="col-md-4">
									<h6 class="mb-4">Permission Analytics</h6>
	                                <div class="chart-container chart">
	                                    <canvas id="permissionChart"></canvas>
	                                </div>
								</div>
								<div class="col-md-8">
									<div class="row">
										<div class="col-md-6">
											<div class="box">
												<div class="box-head">
													<input type="checkbox" id="obs" class="checkobs">
													<label for="obs" class="box-title">Observation</label>
												</div>
												<div class="box-body">
													<div class="form-group d-flex align-items-center">
														<input type="checkbox" id="cobs" name="addObservation" class="obs common-checkbox" value="1" <?php if(isset($permissions->addObservation)&&$permissions->addObservation==1){echo "checked";}?> >
														<label for="cobs">Create Observation</label>
													</div>
													<div class="form-group d-flex align-items-center">
														<input type="checkbox" id="aobs" name="approveObservation" class="obs common-checkbox" value="1" <?php if(isset($permissions->approveObservation)&&$permissions->approveObservation==1){echo "checked";}?>>
														<label for="aobs">Approve Observation</label>
													</div>
													<div class="form-group d-flex align-items-center">
														<input type="checkbox" id="dobs" name="deleteObservation" class="obs common-checkbox" value="1" <?php if(isset($permissions->deleteObservation)&&$permissions->deleteObservation==1){echo "checked";}?>>
														<label for="dobs">Delete Observation</label>
													</div>
													<div class="form-group d-flex align-items-center">
														<input type="checkbox" id="uobs" name="updateObservation" class="obs common-checkbox" value="1" <?php if(isset($permissions->updateObservation)&&$permissions->updateObservation==1){echo "checked";}?>>
														<label for="uobs">Update Observation</label>
													</div>
													<div class="form-group d-flex align-items-center">
														<input type="checkbox" id="vaobs" name="viewAllObservation" class="obs common-checkbox" value="1" <?php if(isset($permissions->viewAllObservation)&&$permissions->viewAllObservation==1){echo "checked";}?>>
														<label for="vaobs">View All Observation</label>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="box">
												<div class="box-head">
													<input type="checkbox" id="qip" class="checkqip common-checkbox">
													<label for="qip" class="box-title">QIP</label>
												</div>
												<div class="box-body">
													<div class="form-group  d-flex align-items-center">
														<input type="checkbox" id="cqip" name="addQIP" class="qip common-checkbox" value="1" <?php if(isset($permissions->addQIP)&&$permissions->addQIP==1){echo "checked";}?>>
														<label for="cqip">Create QIP</label>
													</div>
													<div class="form-group  d-flex align-items-center">
														<input type="checkbox" id="eqip" name="editQIP" class="qip common-checkbox" value="1" <?php if(isset($permissions->editQIP)&&$permissions->editQIP==1){echo "checked";}?>>
														<label for="eqip">Edit QIP</label>
													</div>
													<div class="form-group  d-flex align-items-center">
														<input type="checkbox" id="vqip" name="viewQip" class="qip common-checkbox" value="1" <?php if(isset($permissions->viewQip)&&$permissions->viewQip==1){echo "checked";}?>>
														<label for="vqip">View QIP</label>
													</div>
													<div class="form-group  d-flex align-items-center">
														<input type="checkbox" id="dqip" name="deleteQIP" class="qip common-checkbox" value="1" <?php if(isset($permissions->deleteQIP)&&$permissions->deleteQIP==1){echo "checked";}?>>													
														<label for="dqip">Delete QIP</label>
													</div>
													<div class="form-group  d-flex align-items-center">
														<input type="checkbox" id="dwqip" name="downloadQIP" class="qip common-checkbox" value="1" <?php if(isset($permissions->downloadQIP)&&$permissions->downloadQIP==1){echo "checked";}?>>													
														<label for="dwqip">Download QIP Report</label>
													</div>
													<div class="form-group  d-flex align-items-center">
														<input type="checkbox" id="prqip" name="printQIP" class="qip common-checkbox" value="1" <?php if(isset($permissions->printQIP)&&$permissions->printQIP==1){echo "checked";}?>>
														<label for="prqip">Print QIP Report</label>
													</div>
													<div class="form-group  d-flex align-items-center">
														<input type="checkbox" id="mqip" name="mailQIP" class="qip common-checkbox" value="1" <?php if(isset($permissions->mailQIP)&&$permissions->mailQIP==1){echo "checked";}?>>
														<label for="mqip">Mail QIP Report</label>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="box">
										<div class="box-head">
											<input type="checkbox" id="refl" class="checkrefl">
											<label for="refl" class="box-title">Reflections</label>
										</div>
										<div class="box-body">
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="arlf" name="addReflection" class="refl common-checkbox" value="1" <?php if(isset($permissions->addReflection)&&$permissions->addReflection==1){echo "checked";}?> >
												<label for="arlf">Add Reflection</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="aprfl" name="approveReflection" class="refl common-checkbox" value="1" <?php if(isset($permissions->approveReflection)&&$permissions->approveReflection==1){echo "checked";}?>>
												<label for="aprfl">Approve Reflection</label>
											</div>
                                            <div class="form-group d-flex align-items-center">
												<input type="checkbox" id="update-reflection" name="updatereflection" class="upref common-checkbox" value="1" <?php if(isset($permissions->updatereflection)&&$permissions->updatereflection==1){echo "checked";}?>>
												<label for="update-reflections">Update Reflection</label>
											</div>
                                            <div class="form-group d-flex align-items-center">
												<input type="checkbox" id="delete-reflection" name="deletereflection" class="delref common-checkbox" value="1" <?php if(isset($permissions->deletereflection)&&$permissions->deletereflection==1){echo "checked";}?>>
												<label for="delete-reflections">Delete Reflection</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="varefl" name="viewAllReflection" class="refl common-checkbox" value="1" <?php if(isset($permissions->viewAllReflection)&&$permissions->viewAllReflection==1){echo "checked";}?>>
												<label for="varefl">View All Reflection</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="box">
										<div class="box-head">
											<input type="checkbox" id="selfasmnt" class="checkselfasmnt">
											<label for="selfasmnt" class="box-title">Self Assessments</label>
										</div>
										<div class="box-body">
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="addsa" name="addSelfAssessment" class="selfasmnt common-checkbox" value="1" <?php if(isset($permissions->addSelfAssessment)&&$permissions->addSelfAssessment==1){echo "checked";}?> >
												<label for="addsa">Add Self Assessments</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="editsa" name="editSelfAssessment" class="selfasmnt common-checkbox" value="1" <?php if(isset($permissions->editSelfAssessment)&&$permissions->editSelfAssessment==1){echo "checked";}?>>
												<label for="editsa">Edit Self Assessments</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="delsa" name="deleteSelfAssessment" class="selfasmnt common-checkbox" value="1" <?php if(isset($permissions->deleteSelfAssessment)&&$permissions->deleteSelfAssessment==1){echo "checked";}?>>
												<label for="delsa">Delete Self Assessments</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="vasa" name="viewSelfAssessment" class="selfasmnt common-checkbox" value="1" <?php if(isset($permissions->viewSelfAssessment)&&$permissions->viewSelfAssessment==1){echo "checked";}?>>
												<label for="vasa">View All Self Assessments</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="box">
										<div class="box-head">
											<input type="checkbox" id="room" class="checkroom">
											<label for="room" class="box-title">Rooms</label>
										</div>
										<div class="box-body">
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="croom" name="addRoom" class="room common-checkbox" value="1" <?php if(isset($permissions->addRoom)&&$permissions->addRoom==1){echo "checked";}?>>
												<label for="croom">Create Room</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="eroom" name="editRoom" class="room common-checkbox" value="1" <?php if(isset($permissions->editRoom)&&$permissions->editRoom==1){echo "checked";}?>>
												<label for="eroom">Edit Room</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="droom" name="deleteRoom" class="room common-checkbox" value="1" <?php if(isset($permissions->deleteRoom)&&$permissions->deleteRoom==1){echo "checked";}?>>
												<label for="droom">Delete Room</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="vroom" name="viewRoom" class="room common-checkbox" value="1" <?php if(isset($permissions->viewRoom)&&$permissions->viewRoom==1){echo "checked";}?>>
												<label for="vroom">View Room</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="box">
										<div class="box-head">
											<input type="checkbox" id="pp" class="checkpp">
											<label for="pp" class="box-title">Program Plan</label>
										</div>
										<div class="box-body">
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="cpp" name="addProgramPlan" class="pp common-checkbox" value="1" <?php if(isset($permissions->addProgramPlan)&&$permissions->addProgramPlan==1){echo "checked";}?>>
												<label for="cpp">Create Program Plan</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="epp" name="editProgramPlan" class="pp common-checkbox" value="1" <?php if(isset($permissions->editProgramPlan)&&$permissions->editProgramPlan==1){echo "checked";}?>>
												<label for="epp">Edit Program Plan</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="vpp" name="viewProgramPlan" class="pp common-checkbox" value="1" <?php if(isset($permissions->viewProgramPlan)&&$permissions->viewProgramPlan==1){echo "checked";}?>>
												<label for="vpp">View Program Plan</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="dpp" name="deleteProgramPlan" class="pp common-checkbox" value="1" <?php if(isset($permissions->deleteProgramPlan)&&$permissions->deleteProgramPlan==1){echo "checked";}?>>
												<label for="dpp">Delete Program Plan</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="box">
										<div class="box-head">
											<input type="checkbox" id="announ" class="checkannoun">
											<label for="announ" class="box-title">Announcements</label>
										</div>
										<div class="box-body">
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="cannoun" name="addAnnouncement" class="announ common-checkbox" value="1" <?php if(isset($permissions->addAnnouncement)&&$permissions->addAnnouncement==1){echo "checked";}?>>
												<label for="cannoun">Create Announcements</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="aannoun" name="approveAnnouncement" class="announ common-checkbox" value="1" <?php if(isset($permissions->approveAnnouncement)&&$permissions->approveAnnouncement==1){echo "checked";}?>>
												<label for="aannoun">Approve Announcements</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="dannoun" name="deleteAnnouncement" class="announ common-checkbox" value="1" <?php if(isset($permissions->deleteAnnouncement)&&$permissions->deleteAnnouncement==1){echo "checked";}?>>
												<label for="dannoun">Delete Announcements</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="uannoun" name="updateAnnouncement" class="announ common-checkbox" value="1" <?php if(isset($permissions->updateAnnouncement)&&$permissions->updateAnnouncement==1){echo "checked";}?>>
												<label for="uannoun">Update Announcements</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="vaannoun" name="viewAllAnnouncement" class="announ common-checkbox" value="1" <?php if(isset($permissions->viewAllAnnouncement)&&$permissions->viewAllAnnouncement==1){echo "checked";}?>>
												<label for="vaannoun">View All Announcements</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="box">
										<div class="box-head">
											<input type="checkbox" id="surveys" class="checksur">
											<label for="surveys" class="box-title">Surveys</label>
										</div>
										<div class="box-body">
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="csur" name="addSurvey" class="sur common-checkbox" value="1" <?php if(isset($permissions->addSurvey)&&$permissions->addSurvey==1){echo "checked";}?>>
												<label for="csur">Create Survey</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="asur" name="approveSurvey" class="sur common-checkbox" value="1" <?php if(isset($permissions->approveSurvey)&&$permissions->approveSurvey==1){echo "checked";}?>>
												<label for="asur">Approve Survey</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="dsur" name="deleteSurvey" class="sur common-checkbox" value="1" <?php if(isset($permissions->deleteSurvey)&&$permissions->deleteSurvey==1){echo "checked";}?>>
												<label for="dsur">Delete Survey</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="usur" name="updateSurvey" class="sur common-checkbox" value="1" <?php if(isset($permissions->updateSurvey)&&$permissions->updateSurvey==1){echo "checked";}?>>
												<label for="usur">Update Survey</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="vasur" name="viewAllSurvey" class="sur common-checkbox" value="1" <?php if(isset($permissions->viewAllSurvey)&&$permissions->viewAllSurvey==1){echo "checked";}?>>
												<label for="vasur">View All Survey</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="box">
										<div class="box-head">
											<input type="checkbox" id="rcp" class="checkrcp">
											<label for="rcp" class="box-title">Recipes</label>
										</div>
										<div class="box-body">
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="crcp" name="addRecipe" class="rcp common-checkbox" value="1" <?php if(isset($permissions->addRecipe)&&$permissions->addRecipe==1){echo "checked";}?>>
												<label for="crcp">Create Recipe</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="arcp" name="approveRecipe" class="rcp common-checkbox" value="1" <?php if(isset($permissions->approveRecipe)&&$permissions->approveRecipe==1){echo "checked";}?>>
												<label for="arcp">Approve Recipe</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="drcp" name="deleteRecipe" class="rcp common-checkbox" value="1" <?php if(isset($permissions->deleteRecipe)&&$permissions->deleteRecipe==1){echo "checked";}?>>
												<label for="drcp">Delete Recipe</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="urcp" name="updateRecipe" class="rcp common-checkbox" value="1" <?php if(isset($permissions->updateRecipe)&&$permissions->updateRecipe==1){echo "checked";}?>>
												<label for="urcp">Update Recipe</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="box">
										<div class="box-head">
											<input type="checkbox" id="menus" class="checkmenu">
											<label for="menus" class="box-title">Menu</label>
										</div>
										<div class="box-body">
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="cmenu" name="addMenu" class="menus common-checkbox" value="1" <?php if(isset($permissions->addMenu)&&$permissions->addMenu==1){echo "checked";}?>>
												<label for="cmenu">Create Menu</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="amenu" name="approveMenu" class="menus common-checkbox" value="1" <?php if(isset($permissions->approveMenu)&&$permissions->approveMenu==1){echo "checked";}?>>
												<label for="amenu">Approve Menu</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="dmenu" name="deleteMenu" class="menus common-checkbox" value="1" <?php if(isset($permissions->deleteMenu)&&$permissions->deleteMenu==1){echo "checked";}?>>
												<label for="dmenu">Delete Menu</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="umenu" name="updateMenu" class="menus common-checkbox" value="1" <?php if(isset($permissions->updateMenu)&&$permissions->updateMenu==1){echo "checked";}?>>
												<label for="umenu">Update Menu</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="box">
										<div class="box-head">
											<input type="checkbox" id="progplan" class="checkprogplan">
											<label for="progplan" class="box-title">Progress Plan</label>
										</div>
										<div class="box-body">
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="cprogplan" name="addprogress" class="progplan common-checkbox" value="1" <?php if(isset($permissions->addprogress)&&$permissions->addprogress==1){echo "checked";}?>>
												<label for="cprogplan">Create Progress Plan</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="eprogplan" name="editprogress" class="progplan common-checkbox" value="1" <?php if(isset($permissions->editprogress)&&$permissions->editprogress==1){echo "checked";}?>>
												<label for="eprogplan">Edit Progress Plan</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="vprogplan" name="viewprogress" class="progplan common-checkbox" value="1" <?php if(isset($permissions->viewprogress)&&$permissions->viewprogress==1){echo "checked";}?>>
												<label for="vprogplan">View Progress Plan</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="box">
										<div class="box-head">
											<input type="checkbox" id="lsnplan" class="checklsnplan">
											<label for="lsnplan" class="box-title">Lesson Plan</label>
										</div>
										<div class="box-body">
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="clsnp" name="printpdflesson" class="lsnp common-checkbox" value="1" <?php if(isset($permissions->printpdflesson)&&$permissions->printpdflesson==1){echo "checked";}?>>
												<label for="clsnp">Print PDF Lesson</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="elsnp" name="editlesson" class="lsnp common-checkbox" value="1" <?php if(isset($permissions->editlesson)&&$permissions->editlesson==1){echo "checked";}?>>
												<label for="elsnp">Edit Lesson Plan</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="vlsnp" name="viewlesson" class="lsnp common-checkbox" value="1" <?php if(isset($permissions->viewlesson)&&$permissions->viewlesson==1){echo "checked";}?>>
												<label for="vlsnp">View Lesson Plan</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="box">
										<div class="box-head">
											<input type="checkbox" id="dailyjournal" class="checkdailyjournal">
											<label for="dailyjournal" class="box-title">Daily Journal</label>
										</div>
										<div class="box-body">
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="udd" class="dailyjournal" name="updateDailyDiary" value="1" <?php if(isset($permissions->updateDailyDiary)&&$permissions->updateDailyDiary==1){echo "checked";}?>>
												<label for="udd">Update Daily Diary</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="vdd" class="dailyjournal" name="viewDailyDiary" value="1" <?php if(isset($permissions->viewDailyDiary)&&$permissions->viewDailyDiary==1){echo "checked";}?>>
												<label for="vdd">View Daily Diary</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="uhc" class="dailyjournal" name="updateHeadChecks" value="1" <?php if(isset($permissions->updateHeadChecks)&&$permissions->updateHeadChecks==1){echo "checked";}?>>
												<label for="uhc">Update Head Checks</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="uacc" class="dailyjournal" name="updateAccidents" value="1" <?php if(isset($permissions->updateAccidents)&&$permissions->updateAccidents==1){echo "checked";}?>>
												<label for="uacc">Update Accidents</label>
											</div>

										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="box">
										<div class="box-head">
											<input type="checkbox" id="us" class="checkusers">
											<label for="us" class="box-title">User Settings</label>
										</div>
										<div class="box-body">
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="cus" name="addUsers" class="users common-checkbox" value="1" <?php if(isset($permissions->addUsers)&&$permissions->addUsers==1){echo "checked";}?>>
												<label for="cus">Create Users</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="vus" name="viewUsers" class="users common-checkbox" value="1" <?php if(isset($permissions->viewUsers)&&$permissions->viewUsers==1){echo "checked";}?>>
												<label for="vus">View Users</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="uus" name="updateUsers" class="users common-checkbox" value="1" <?php if(isset($permissions->updateUsers)&&$permissions->updateUsers==1){echo "checked";}?>>
												<label for="uus">Update Users</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="box">
										<div class="box-head">
											<input type="checkbox" id="cn" class="checkcenter">
											<label for="cn" class="box-title">Center Settings</label>
										</div>
										<div class="box-body">
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="ccn" name="addCenters" class="center common-checkbox" value="1" <?php if(isset($permissions->addCenters)&&$permissions->addCenters==1){echo "checked";}?>>
												<label for="ccn">Create Centers</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="vcn" name="viewCenters" class="center common-checkbox" value="1" <?php if(isset($permissions->viewCenters)&&$permissions->viewCenters==1){echo "checked";}?>>
												<label for="vcn">View Centers</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="ucn" name="updateCenters" class="center common-checkbox" value="1" <?php if(isset($permissions->updateCenters)&&$permissions->updateCenters==1){echo "checked";}?>>
												<label for="ucn">Update Centers</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="box">
										<div class="box-head">
											<input type="checkbox" id="ps" class="checkparent">
											<label for="ps" class="box-title">Parent Settings</label>
										</div>
										<div class="box-body">
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="cps" name="addParent" class="parent common-checkbox" value="1" <?php if(isset($permissions->addParent)&&$permissions->addParent==1){echo "checked";}?>>
												<label for="cps">Create Parents</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="vps" name="viewParent" class="parent common-checkbox" value="1" <?php if(isset($permissions->viewParent)&&$permissions->viewParent==1){echo "checked";}?>>
												<label for="vps">View Parents</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="ups" name="updateParent" class="parent common-checkbox" value="1" <?php if(isset($permissions->updateParent)&&$permissions->updateParent==1){echo "checked";}?>>
												<label for="ups">Update Parents</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="box">
										<div class="box-head">
											<input type="checkbox" id="cg" class="checkcg">
											<label for="cg" class="box-title">Child Groups</label>
										</div>
										<div class="box-body">
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="ccg" name="addChildGroup" class="cg common-checkbox" value="1" <?php if(isset($permissions->addChildGroup)&&$permissions->addChildGroup==1){echo "checked";}?>>
												<label for="ccg">Create Child Group</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="vcg" name="viewChildGroup" class="cg common-checkbox" value="1" <?php if(isset($permissions->viewChildGroup)&&$permissions->viewChildGroup==1){echo "checked";}?>>
												<label for="vcg">View Child Group</label>
											</div>
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="ucg" name="updateChildGroup" class="cg common-checkbox" value="1" <?php if(isset($permissions->updateChildGroup)&&$permissions->updateChildGroup==1){echo "checked";}?>>
												<label for="ucg">Update Child Group</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="box">
										<div class="box-head">
											<input type="checkbox" id="misc" class="checkmisc">
											<label for="misc" class="box-title">Misc Settings</label>
										</div>
										<div class="box-body">
											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="upstng" name="updatePermission" class="checkms common-checkbox" value="1" <?php if(isset($permissions->updatePermission)&&$permissions->updatePermission==1){echo "checked";}?>>
												<label for="upstng">Update Permission Setting</label>
											</div>

											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="assmnts" name="assessment" class="checkms common-checkbox" value="1" <?php if(isset($permissions->assessment)&&$permissions->assessment==1){echo "checked";}?>>
												<label for="assmnts">Update Assessments Setting</label>
											</div>

											<div class="form-group d-flex align-items-center">
												<input type="checkbox" id="ums" name="updateModules" class="checkms common-checkbox" value="1" <?php if(isset($permissions->updateModules)&&$permissions->updateModules==1){echo "checked";}?>>
												<label for="ums">Update Module Setting</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row mt-3">
								<div class="col text-right">
									<?php 
										$role = $this->session->userdata('UserType');
										if($role=="Superadmin"){
									?>
									<button type="submit" id="save-permission" class="btn btn-primary mb-2"> Save </button>
									<?php
										}else if($role=="Staff"){
											if ($savePermission==1) {
									?>
									<button type="submit" id="save-permission" class="btn btn-primary mb-2"> Save </button>
									<?php
											} else {
									?>
									<button type="button" class="btn btn-primary mb-2" data-toggle="tooltip" data-placement="top" title="Insufficient permission to save!"> Save </button>
									<?php
											}
											
										} else {
									?>
									<button type="button" class="btn btn-primary mb-2" data-toggle="tooltip" data-placement="top" title="Insufficient permission to save!"> Save </button>
									<?php } ?>
								</div>
							</div>			
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</main>


<!-- Modal -->
<div class="modal fade" id="permissionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document" style="margin-top:0px;">
        <div class="modal-content">
        <form id="permissionForm">
            <div class="modal-header">
                <h5 class="modal-title">Check Permissions</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="overflow-y:auto;max-height:550px;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select Center</label>
                            <select class="form-control" id="centerSelect">
                                <option value="">Select Center</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select Staff</label>
                            <select class="form-control" id="staffSelect" name="user_id" disabled>
                                <option value="">Select Staff</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Permission Groups -->
                <div id="permissionContainer" style="display: none;">
                  
				    <div class="permission-group">
                        <h6>Observation <span class="progress-percentage"></span></h6>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="addObservation" name="addObservation">
                                <label class="form-check-label" for="addObservation">Create Observation</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="approveObservation" name="approveObservation">
                                <label class="form-check-label" for="approveObservation">Approve Observation</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="deleteObservation" name="deleteObservation">
                                <label class="form-check-label" for="deleteObservation">Delete Observation</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="updateObservation" name="updateObservation">
                                <label class="form-check-label" for="updateObservation">Update Observation</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="viewAllObservation" name="viewAllObservation">
                                <label class="form-check-label" for="viewAllObservation">View All Observation</label>
                            </div>
                            <!-- Add other Observation permissions similarly -->
                        </div>
                    </div>




					<div class="permission-group">
                        <h6>QIP <span class="progress-percentage"></span></h6>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="addQIP" name="addQIP">
                                <label class="form-check-label" for="addQIP">Create QIP</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="editQIP" name="editQIP">
                                <label class="form-check-label" for="editQIP">Edit QIP</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="viewQip" name="viewQip">
                                <label class="form-check-label" for="viewQip">View QIP</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="deleteQIP" name="deleteQIP">
                                <label class="form-check-label" for="deleteQIP">Delete QIP</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="downloadQIP" name="downloadQIP">
                                <label class="form-check-label" for="downloadQIP">Download QIP Report</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="printQIP" name="printQIP">
                                <label class="form-check-label" for="printQIP">Print QIP Report</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="mailQIP" name="mailQIP">
                                <label class="form-check-label" for="mailQIP">Mail QIP Report</label>
                            </div>
                            <!-- Add other Observation permissions similarly -->
                        </div>
                    </div>



					<div class="permission-group">
                        <h6>Reflections <span class="progress-percentage"></span></h6>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="addReflection" name="addReflection">
                                <label class="form-check-label" for="addReflection">Add Reflection</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="approveReflection" name="approveReflection">
                                <label class="form-check-label" for="approveReflection">Approve Reflection</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="updatereflection" name="updatereflection">
                                <label class="form-check-label" for="updatereflection">Update Reflection</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="deletereflection" name="deletereflection">
                                <label class="form-check-label" for="deletereflection">Delete Reflection</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="viewAllReflection" name="viewAllReflection">
                                <label class="form-check-label" for="viewAllReflection">View All Reflection</label>
                            </div>
                            <!-- Add other Observation permissions similarly -->
                        </div>
                    </div>



					<div class="permission-group">
                        <h6>Self Assessments <span class="progress-percentage"></span></h6>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="addSelfAssessment" name="addSelfAssessment">
                                <label class="form-check-label" for="addSelfAssessment">Add Self Assessments</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="editSelfAssessment" name="editSelfAssessment">
                                <label class="form-check-label" for="editSelfAssessment">Edit Self Assessments</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="deleteSelfAssessment" name="deleteSelfAssessment">
                                <label class="form-check-label" for="deleteSelfAssessment">Delete Self Assessments</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="viewSelfAssessment" name="viewSelfAssessment">
                                <label class="form-check-label" for="viewSelfAssessment">View All Self Assessments</label>
                            </div>
                            <!-- Add other Observation permissions similarly -->
                        </div>
                    </div>


					<div class="permission-group">
                        <h6>Rooms<span class="progress-percentage"></span></h6>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="addRoom" name="addRoom">
                                <label class="form-check-label" for="addRoom">Create Room</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="editRoom" name="editRoom">
                                <label class="form-check-label" for="editRoom">Edit Room</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="deleteRoom" name="deleteRoom">
                                <label class="form-check-label" for="deleteRoom">Delete Room</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="viewRoom" name="viewRoom">
                                <label class="form-check-label" for="viewRoom">View Room</label>
                            </div>
                            <!-- Add other Observation permissions similarly -->
                        </div>
                    </div>


					<div class="permission-group">
                        <h6>Program Plan<span class="progress-percentage"></span></h6>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="addProgramPlan" name="addProgramPlan">
                                <label class="form-check-label" for="addProgramPlan">Create Program Plan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="editProgramPlan" name="editProgramPlan">
                                <label class="form-check-label" for="editProgramPlan">Edit Program Plan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="viewProgramPlan" name="viewProgramPlan">
                                <label class="form-check-label" for="viewProgramPlan">View Program Plan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="deleteProgramPlan" name="deleteProgramPlan">
                                <label class="form-check-label" for="deleteProgramPlan">Delete Program Plan</label>
                            </div>
                            <!-- Add other Observation permissions similarly -->
                        </div>
                    </div>


					<div class="permission-group">
                        <h6>Announcements<span class="progress-percentage"></span></h6>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="addAnnouncement" name="addAnnouncement">
                                <label class="form-check-label" for="addAnnouncement">Create Announcements</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="approveAnnouncement" name="approveAnnouncement">
                                <label class="form-check-label" for="approveAnnouncement">Approve Announcements</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="deleteAnnouncement" name="deleteAnnouncement">
                                <label class="form-check-label" for="deleteAnnouncement">Delete Announcements</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="updateAnnouncement" name="updateAnnouncement">
                                <label class="form-check-label" for="updateAnnouncement">Update Announcements</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="viewAllAnnouncement" name="viewAllAnnouncement">
                                <label class="form-check-label" for="viewAllAnnouncement">View All Announcements</label>
                            </div>
                            <!-- Add other Observation permissions similarly -->
                        </div>
                    </div>


					<div class="permission-group">
                        <h6>Surveys<span class="progress-percentage"></span></h6>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="addSurvey" name="addSurvey">
                                <label class="form-check-label" for="addSurvey">Create Survey</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="approveSurvey" name="approveSurvey">
                                <label class="form-check-label" for="approveSurvey">Approve Survey</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="deleteSurvey" name="deleteSurvey">
                                <label class="form-check-label" for="deleteSurvey">Delete Survey</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="updateSurvey" name="updateSurvey">
                                <label class="form-check-label" for="updateSurvey">Update Survey</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="viewAllSurvey" name="viewAllSurvey">
                                <label class="form-check-label" for="viewAllSurvey">View All Survey</label>
                            </div>
                            <!-- Add other Observation permissions similarly -->
                        </div>
                    </div>


					<div class="permission-group">
                        <h6>Recipes<span class="progress-percentage"></span></h6>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="addRecipe" name="addRecipe">
                                <label class="form-check-label" for="addRecipe">Create Recipe</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="approveRecipe" name="approveRecipe">
                                <label class="form-check-label" for="approveRecipe">Approve Recipe</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="deleteRecipe" name="deleteRecipe">
                                <label class="form-check-label" for="deleteRecipe">Delete Recipe</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="updateRecipe" name="updateRecipe">
                                <label class="form-check-label" for="updateRecipe">Update Recipe</label>
                            </div>
                            <!-- Add other Observation permissions similarly -->
                        </div>
                    </div>

					<div class="permission-group">
                        <h6>Menu<span class="progress-percentage"></span></h6>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="addMenu" name="addMenu">
                                <label class="form-check-label" for="addMenu">Create Menu</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="approveMenu" name="approveMenu">
                                <label class="form-check-label" for="approveMenu">Approve Menu</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="deleteMenu" name="deleteMenu">
                                <label class="form-check-label" for="deleteMenu">Delete Menu</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="updateMenu" name="updateMenu">
                                <label class="form-check-label" for="updateMenu">Update Menu</label>
                            </div>
                            <!-- Add other Observation permissions similarly -->
                        </div>
                    </div>


					<div class="permission-group">
                        <h6>Progress Plan<span class="progress-percentage"></span></h6>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="addprogress" name="addprogress">
                                <label class="form-check-label" for="addprogress">Create Progress Plan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="editprogress" name="editprogress">
                                <label class="form-check-label" for="editprogress">Edit Progress Plan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="viewprogress" name="viewprogress">
                                <label class="form-check-label" for="viewprogress">View Progress Plan</label>
                            </div>
                            <!-- Add other Observation permissions similarly -->
                        </div>
                    </div>

					<div class="permission-group">
                        <h6>Lesson Plan<span class="progress-percentage"></span></h6>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="printpdflesson" name="printpdflesson">
                                <label class="form-check-label" for="printpdflesson">Print PDF Lesson</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="editlesson" name="editlesson">
                                <label class="form-check-label" for="editlesson">Edit Lesson Plan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="viewlesson" name="viewlesson">
                                <label class="form-check-label" for="viewlesson">View Lesson Plan</label>
                            </div>
                            <!-- Add other Observation permissions similarly -->
                        </div>
                    </div>

					<div class="permission-group">
                        <h6>Daily Journal<span class="progress-percentage"></span></h6>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="updateDailyDiary" name="updateDailyDiary">
                                <label class="form-check-label" for="updateDailyDiary">Update Daily Diary</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="viewDailyDiary" name="viewDailyDiary">
                                <label class="form-check-label" for="viewDailyDiary">View Daily Diary</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="updateHeadChecks" name="updateHeadChecks">
                                <label class="form-check-label" for="updateHeadChecks">Update Head Checks</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="updateAccidents" name="updateAccidents">
                                <label class="form-check-label" for="updateAccidents">Update Accidents</label>
                            </div>
                            <!-- Add other Observation permissions similarly -->
                        </div>
                    </div>

					<div class="permission-group">
                        <h6>User Settings<span class="progress-percentage"></span></h6>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="addUsers" name="addUsers">
                                <label class="form-check-label" for="addUsers">Create Users</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="viewUsers" name="viewUsers">
                                <label class="form-check-label" for="viewUsers">View Users</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="updateUsers" name="updateUsers">
                                <label class="form-check-label" for="updateUsers">Update Users</label>
                            </div>
                            <!-- Add other Observation permissions similarly -->
                        </div>
                    </div>

					<div class="permission-group">
                        <h6>Center Settings<span class="progress-percentage"></span></h6>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="addCenters" name="addCenters">
                                <label class="form-check-label" for="addCenters">Create Centers</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="viewCenters" name="viewCenters">
                                <label class="form-check-label" for="viewCenters">View Centers</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="updateCenters" name="updateCenters">
                                <label class="form-check-label" for="updateCenters">Update Centers</label>
                            </div>
                            <!-- Add other Observation permissions similarly -->
                        </div>
                    </div>

					<div class="permission-group">
                        <h6>Parent Settings<span class="progress-percentage"></span></h6>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="addParent" name="addParent">
                                <label class="form-check-label" for="addParent">Create Parents</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="viewParent" name="viewParent">
                                <label class="form-check-label" for="viewParent">View Parents</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="updateParent" name="updateParent">
                                <label class="form-check-label" for="updateParent">Update Parents</label>
                            </div>
                            <!-- Add other Observation permissions similarly -->
                        </div>
                    </div>

					<div class="permission-group">
                        <h6>Child Groups<span class="progress-percentage"></span></h6>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="addChildGroup" name="addChildGroup">
                                <label class="form-check-label" for="addChildGroup">Create Child Group</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="viewChildGroup" name="viewChildGroup">
                                <label class="form-check-label" for="viewChildGroup">View Child Group</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="updateChildGroup" name="updateChildGroup">
                                <label class="form-check-label" for="updateChildGroup">Update Child Group</label>
                            </div>
                            <!-- Add other Observation permissions similarly -->
                        </div>
                    </div>

					<div class="permission-group">
                        <h6>Misc Settings<span class="progress-percentage"></span></h6>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="checkbox-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="updatePermission" name="updatePermission">
                                <label class="form-check-label" for="updatePermission">Update Permission Setting</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="assessment" name="assessment">
                                <label class="form-check-label" for="assessment">Update Assessments Setting</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="updateModules" name="updateModules">
                                <label class="form-check-label" for="updateModules">Update Module Setting</label>
                            </div>
                            <!-- Add other Observation permissions similarly -->
                        </div>
                    </div>




                    <!-- Add other permission groups similarly -->
                </div>
             
            </div>
            <div class="modal-footer" style="padding:12px;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update Permission</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('footer_v3'); ?>
	<script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.1.0"></script>
	<script src="<?= base_url('assets/v3'); ?>/js/vendor/select2.full.js?v=1.1.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.1.0"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.1.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?v=1.1.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.1.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/Chart.bundle.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/chartjs-plugin-datalabels.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.1.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?v=1.1.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.1.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.1.0"></script>
	<script src="<?= base_url('assets/v3/js/permissions.js?v=1.1.0'); ?>"></script>
	<script>
		$(document).ready(function(){
			//update users on center change
			$(document).on('change', '#centerId', function(){
				let _centerid = $(this).val();
				$.ajax({
					url: '<?= base_url('Settings/getCenterUsers'); ?>',
					type: 'POST',
					data: {centerid: _centerid},
				})
				.done(function(msg) {
					res = $.parseJSON(msg);
					if (res.Status == "SUCCESS") {
						$('#users').empty();
						$.each(res.users, function(index, val) {
							$('#users').append(`
								<option value="`+val.userid+`">`+val.name+`</option>
							`);
						});
					}else{
						alert("Something went wrong!");
					}
				});	
			});

			// console.log('pls change permission.js base url');

			$(document).on('submit','#permission-form', function(e){
				e.preventDefault();
				$.ajax({
					url: '<?= base_url('settings/savePermission'); ?>',
					type: 'POST',
					data: $(this).serialize(),
				})
				.done(function(msg) {
					console.log(msg);
					res = $.parseJSON(msg);
					if(res.Status == "SUCCESS"){
						swal("Success!", "Permission has been set for the users!", "success");
					}else{
						swal("Oops!", "Something Went Wrong!", "error");
					}
				});
			});
		});

		
	</script>	
 

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    // Load centers on modal open
    $('#permissionModal').on('shown.bs.modal', function() {
        $.ajax({
            url: '<?= base_url('settings/get_centers') ?>',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let options = '<option value="">Select Center</option>';
                $.each(response, function(i, center) {
                    options += `<option value="${center.id}">${center.centerName}</option>`;
                });
                $('#centerSelect').html(options);
            }
        });
    });

    // Load staff when center is selected
    $('#centerSelect').change(function() {
        let centerId = $(this).val();
        if(centerId) {
            $('#staffSelect').prop('disabled', true);
            $.ajax({
                url: '<?= base_url('settings/get_staff_by_center') ?>',
                method: 'POST',
                data: {center_id: centerId},
                dataType: 'json',
                success: function(response) {
                    let options = '<option value="">Select Staff</option>';
                    $.each(response, function(i, staff) {
                        options += `<option value="${staff.userid}">${staff.username}</option>`;
                    });
                    $('#staffSelect').html(options).prop('disabled', false);
                }
            });
        }
    });

    // Load permissions when staff is selected
    $('#staffSelect').change(function() {
        let userId = $(this).val();
        if(userId) {
            $.ajax({
                url: '<?= base_url('settings/get_permissions') ?>',
                method: 'POST',
                data: {user_id: userId},
                dataType: 'json',
                success: function(response) {
                    // Update checkbox states
                    $('#addObservation').prop('checked', response.addObservation == 1);
                    $('#approveObservation').prop('checked', response.approveObservation == 1);
                    $('#deleteObservation').prop('checked', response.deleteObservation == 1);
                    $('#updateObservation').prop('checked', response.updateObservation == 1);
                    $('#viewAllObservation').prop('checked', response.viewAllObservation == 1);
                   
					$('#addQIP').prop('checked', response.addQIP == 1);
                    $('#editQIP').prop('checked', response.editQIP == 1);
                    $('#viewQip').prop('checked', response.viewQip == 1);
                    $('#deleteQIP').prop('checked', response.deleteQIP == 1);
                    $('#downloadQIP').prop('checked', response.downloadQIP == 1);
                    $('#printQIP').prop('checked', response.printQIP == 1);
                    $('#mailQIP').prop('checked', response.mailQIP == 1);
                    
					$('#addReflection').prop('checked', response.addReflection == 1);
                    $('#approveReflection').prop('checked', response.approveReflection == 1);
                    $('#updatereflection').prop('checked', response.updatereflection == 1);
                    $('#deletereflection').prop('checked', response.deletereflection == 1);
                    $('#viewAllReflection').prop('checked', response.viewAllReflection == 1);
                    
					$('#addSelfAssessment').prop('checked', response.addSelfAssessment == 1);
                    $('#editSelfAssessment').prop('checked', response.editSelfAssessment == 1);
                    $('#deleteSelfAssessment').prop('checked', response.deleteSelfAssessment == 1);
                    $('#viewSelfAssessment').prop('checked', response.viewSelfAssessment == 1);
                    
					$('#viewRoom').prop('checked', response.viewRoom == 1);
                    $('#deleteRoom').prop('checked', response.deleteRoom == 1);
                    $('#editRoom').prop('checked', response.editRoom == 1);
                    $('#addRoom').prop('checked', response.addRoom == 1);
                  
					$('#addProgramPlan').prop('checked', response.addProgramPlan == 1);
                    $('#editProgramPlan').prop('checked', response.editProgramPlan == 1);
                    $('#viewProgramPlan').prop('checked', response.viewProgramPlan == 1);
                    $('#deleteProgramPlan').prop('checked', response.deleteProgramPlan == 1);
                   
					$('#addAnnouncement').prop('checked', response.addAnnouncement == 1);
                    $('#approveAnnouncement').prop('checked', response.approveAnnouncement == 1);
                    $('#deleteAnnouncement').prop('checked', response.deleteAnnouncement == 1);
                    $('#updateAnnouncement').prop('checked', response.updateAnnouncement == 1);
                    $('#viewAllAnnouncement').prop('checked', response.viewAllAnnouncement == 1);
                   
					$('#addSurvey').prop('checked', response.addSurvey == 1);
                    $('#approveSurvey').prop('checked', response.approveSurvey == 1);
                    $('#deleteSurvey').prop('checked', response.deleteSurvey == 1);
                    $('#updateSurvey').prop('checked', response.updateSurvey == 1);
                    $('#viewAllSurvey').prop('checked', response.viewAllSurvey == 1);
                   
					$('#addRecipe').prop('checked', response.addRecipe == 1);
                    $('#approveRecipe').prop('checked', response.approveRecipe == 1);
                    $('#deleteRecipe').prop('checked', response.deleteRecipe == 1);
                    $('#updateRecipe').prop('checked', response.updateRecipe == 1);
                  
					$('#addMenu').prop('checked', response.addMenu == 1);
                    $('#approveMenu').prop('checked', response.approveMenu == 1);
                    $('#deleteMenu').prop('checked', response.deleteMenu == 1);
                    $('#updateMenu').prop('checked', response.updateMenu == 1);
                   
					$('#addprogress').prop('checked', response.addprogress == 1);
                    $('#editprogress').prop('checked', response.editprogress == 1);
                    $('#viewprogress').prop('checked', response.viewprogress == 1);
                   
					$('#printpdflesson').prop('checked', response.printpdflesson == 1);
                    $('#viewlesson').prop('checked', response.viewlesson == 1);
                    $('#editlesson').prop('checked', response.editlesson == 1);
                   
					$('#updateDailyDiary').prop('checked', response.updateDailyDiary == 1);
                    $('#viewDailyDiary').prop('checked', response.viewDailyDiary == 1);
                    $('#updateHeadChecks').prop('checked', response.updateHeadChecks == 1);
                    $('#updateAccidents').prop('checked', response.updateAccidents == 1);
                   
					$('#addUsers').prop('checked', response.addUsers == 1);
                    $('#viewUsers').prop('checked', response.viewUsers == 1);
                    $('#updateUsers').prop('checked', response.updateUsers == 1);

                    $('#addCenters').prop('checked', response.addCenters == 1);
                    $('#viewCenters').prop('checked', response.viewCenters == 1);
                    $('#updateCenters').prop('checked', response.updateCenters == 1);

                    $('#addParent').prop('checked', response.addParent == 1);
                    $('#viewParent').prop('checked', response.viewParent == 1);
                    $('#updateParent').prop('checked', response.updateParent == 1);

                    $('#addChildGroup').prop('checked', response.addChildGroup == 1);
                    $('#viewChildGroup').prop('checked', response.viewChildGroup == 1);
                    $('#updateChildGroup').prop('checked', response.updateChildGroup == 1);

                    $('#updatePermission').prop('checked', response.updatePermission == 1);
                    $('#assessment').prop('checked', response.assessment == 1);
                    $('#updateModules').prop('checked', response.updateModules == 1);



                    


                    
					// Add similar lines for all permissions
                    
                    // Calculate and update progress bars
                    updateProgressBars();
                    $('#permissionContainer').show();
                }
            });
        }
    });

    // Update progress bars when checkboxes change
    $('input[type="checkbox"]').change(updateProgressBars);

    function updateProgressBars() {
        $('.permission-group').each(function() {
            let total = $(this).find('input[type="checkbox"]').length;
            let checked = $(this).find('input[type="checkbox"]:checked').length;
            let percentage = (checked / total) * 100;
            
            $(this).find('.progress-bar').css('width', percentage + '%');
            $(this).find('.progress-percentage').text(Math.round(percentage) + '%');
        });
    }


    // Handle form submission
    $('#permissionForm').submit(function(e) {
        e.preventDefault();
        
        let formData = $(this).serialize();
        
        $.ajax({
            url: '<?= base_url('settings/update_permissions') ?>',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    alert(response.message);
                    $('#permissionModal').modal('hide');
                    setTimeout(function() {
                        window.location.reload();
    }, 500); // Wait for 500 milliseconds (adjust as needed)
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Error updating permissions');
            }
        });
    });

});
</script>
</body>
</html>

	