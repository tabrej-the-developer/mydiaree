<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Permissions | Mykronicle</title>
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
                <div class="separator mb-5"></div>
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
</body>
</html>

	