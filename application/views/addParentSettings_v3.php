<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Parent Settings | Mydiaree</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js?v=1.0.0"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
	<link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2-bootstrap.min.css?v=1.0.0" />
	<body id="app-container" class="menu-default show-spinner">
		<?php 
			$this->load->view('sidebar'); 

			if(isset($_GET['recordId'])){
				$label = "Edit Parent";
			}else{
				$label = "Add Parent";
			}
		?>
		<main>
			<div class="container-fluid">
	            <div class="row">
	                <div class="col-md-12">
	                    <h1><?= $label; ?></h1>
	                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
	                        <ol class="breadcrumb pt-0">
	                            <li class="breadcrumb-item">
	                                <a href="<?= base_url('dashboard'); ?>">Dashboard</a>
	                            </li>
	                            <li class="breadcrumb-item">
	                                <a href="#">Settings</a>
	                            </li>
	                            <li class="breadcrumb-item">
	                                <a href="<?= base_url('Settings/parentSettings'); ?>">Parent Settings</a>
	                            </li>
	                            <li class="breadcrumb-item active" aria-current="page"><?= $label; ?></li>
	                        </ol>
	                    </nav>
	                    <div class="separator mb-5"></div>
	                </div>
	            </div>
	            <div class="row">
	            	<div class="col-md-12">
	            		<div class="card">
	            			<div class="card-body">
	            				<h3 class="card-title">
	            					<?= $label; ?>
	            				</h3>
								<form action="<?= base_url("Settings/saveParentDetails"); ?>" method="post" enctype="multipart/form-data">
									<?php if (isset($_GET['recordId'])) { ?>
										<input type="hidden" name="recordId" value="<?php echo $_GET['recordId']; ?>">
									<?php } ?>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="name">Full Name</label>
												<input type="text" class="form-control" id="name" name="name" value="<?php echo isset($parents->name)?$parents->name:""; ?>">
											</div>
										</div>
										<input type="hidden" name="centerid" value="<?php echo $centerid; ?>">

										<div class="col-md-4">
											<div class="form-group">
												<label for="Gender">Gender</label>
												<select name="gender" id="gender" class="form-control">
													<?php if (isset($parents->gender)&&$parents->gender=="MALE") { ?>
													<option value="MALE" selected>MALE</option>
													<option value="FEMALE">FEMALE</option>
													<option value="OTHERS">OTHERS</option>
													<?php }elseif (isset($parents->gender)&&$parents->gender=="FEMALE") {?> 
													<option value="MALE">MALE</option>
													<option value="FEMALE" selected>FEMALE</option>
													<option value="OTHERS">OTHERS</option>
													<?php }elseif (isset($parents->gender)&&$parents->gender=="OTHERS"){ ?>
													<option value="MALE">MALE</option>
													<option value="FEMALE">FEMALE</option>
													<option value="OTHERS" selected>OTHERS</option>
													<?php }else{ ?>
													<option value="MALE">MALE</option>
													<option value="FEMALE">FEMALE</option>
													<option value="OTHERS">OTHERS</option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="dob">Date of Birth</label>
												<input type="text" class="form-control" id="dob" name="dob" value="<?= isset($parents->dob)?$parents->dob:""; ?>">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="phone">Contact Number</label>
												<input type="text" class="form-control" id="phone" name="contactNo" value="<?php echo isset($parents->contactNo)?$parents->contactNo:""; ?>">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="email">Email</label>
												<input type="email" class="form-control" id="email" name="emailid" value="<?php echo isset($parents->emailid)?$parents->emailid:""; ?>">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
											<?php if (isset($_GET['recordId'])) { ?>
												<label for="password">Password -<span style="color:green;">Optional (Fill only if you want to change Password otherwise remain Empty)</span></label>
												<?php }else{ ?>
													<label for="password">Password</label>
													<?php } ?>
												<input type="text" class="form-control" id="password" name="password" value="">
											</div>
										</div>
									</div>
									<div id="children-sec">
										<?php if (empty($parents->children)) { ?>
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label>Select Children</label>
													<select name="children[]" class="form-control">
														<option value="">-- Select Children --</option>
														<?php foreach ($children as $ch => $cobj){ ?>
															<option value="<?= $cobj->id; ?>"><?= $cobj->name; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-md-5">
												<div class="form-group">
													<label>Relation</label>
													<select name="relation[]" class="form-control">
														<option value="Mother">Mother</option>
														<option value="Father">Father</option>
														<option value="Brother">Brother</option>
														<option value="Sister">Sister</option>
														<option value="Relative">Relative</option>
													</select>
												</div>
											</div>
											<div class="col-md-2"></div>
										</div>
										<?php }else{ 
											$i=1;
											foreach ($parents->children as $childrens => $chl) {
										?>
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label>Select Children</label>
													<select name="children[]" class="form-control">
														<option value="">-- Select Children --</option>
														<?php foreach ($children as $ch => $cobj){ 

															if ($cobj->id==$chl->childid) {
														?>
														<option value="<?php echo $cobj->id; ?>" selected><?php echo $cobj->name; ?></option>
														<?php } else { ?>
														<option value="<?php echo $cobj->id; ?>"><?php echo $cobj->name; ?></option>
														<?php }  } ?>
													</select>
												</div>
											</div>
											<div class="col-md-5">
												<div class="form-group">
													<label>Relation</label>
													<select name="relation[]" class="form-control">
														<?php 
															if ($chl->relation == "Mother") {
														?>
														<option value="Mother" selected>Mother</option>
														<option value="Father">Father</option>
														<option value="Brother">Brother</option>
														<option value="Sister">Sister</option>
														<option value="Relative">Relative</option>
														<?php
															} elseif($chl->relation == "Father") {
														?>
														<option value="Mother">Mother</option>
														<option value="Father" selected>Father</option>
														<option value="Brother">Brother</option>
														<option value="Sister">Sister</option>
														<option value="Relative">Relative</option>
														<?php
															} elseif($chl->relation == "Brother") {
														?>
														<option value="Mother">Mother</option>
														<option value="Father">Father</option>
														<option value="Brother" selected>Brother</option>
														<option value="Sister">Sister</option>
														<option value="Relative">Relative</option>
														<?php
															} elseif($chl->relation == "Sister") {
														?>
														<option value="Mother">Mother</option>
														<option value="Father">Father</option>
														<option value="Brother">Brother</option>
														<option value="Sister" selected>Sister</option>
														<option value="Relative">Relative</option>
														<?php
															}elseif($chl->relation == "Relative") {
														?>
														<option value="Mother">Mother</option>
														<option value="Father">Father</option>
														<option value="Brother">Brother</option>
														<option value="Sister">Sister</option>
														<option value="Relative" selected>Relative</option>
														<?php
															} else{
														?>
														<option value="Mother">Mother</option>
														<option value="Father">Father</option>
														<option value="Brother">Brother</option>
														<option value="Sister">Sister</option>
														<option value="Relative">Relative</option>
														<?php } ?>
													</select>
												</div>
											</div>
											<?php if ($i > 1) { ?>
											<div class="col-md-2 pt-4">
												<button type="button" class="btn btn-outline-danger remove-btn-room btn-block">Remove</button>
											</div>
											<?php }  ?>
										</div>
										<?php $i++; } } ?>
									</div>
									<div class="row">
										<div class="col-md-12 text-right">
											<div class="form-group">
												<button type="button" class="btn btn-outline-primary btn-add">Add Child</button>
												<button type="submit" class="btn btn-primary">Submit</button>
											</div>
										</div>
									</div>
								</form>
	            			</div>
	            		</div>
	            	</div>
	            </div>
	        </div>
		</main>
		<?php $this->load->view('footer_v3'); ?>
	    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>
		<script src="<?= base_url('assets/v3'); ?>/js/vendor/select2.full.js?v=1.0.0"></script>
	    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
	    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
	    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
	    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
	    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
	    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>
		<script>
			$(document).ready(function(){
				$(".btn-add").on("click",function(){
					$("#children-sec").append(`
						<div class="row">
						    <div class="col-md-5">
						        <div class="form-group">
						            <label>Select Children</label>
						            <select name="children[]" class="form-control">
						            	<option value="">-- Select Children --</option>
						                <?php foreach ($children as $ch => $cobj){ ?>
						                <option value="<?php echo $cobj->id; ?>"><?php echo $cobj->name; ?></option>
						                <?php } ?>
						            </select>
						        </div>
						    </div>
						    <div class="col-md-5">
						        <div class="form-group">
						            <label>Relation</label>
						            <select name="relation[]" class="form-control">
						                <option value="Mother">Mother</option>
						                <option value="Father">Father</option>
						                <option value="Brother">Brother</option>
						                <option value="Sister">Sister</option>
						                <option value="Relative">Relative</option>
						            </select>
						        </div>
						    </div>
						    <div class="col-md-2 pt-4">
						        <button type="button" class="btn btn-outline-danger remove-btn-room btn-block">Remove</button>
						    </div>
						</div>
					`);
				});

				$(document).on("click",".remove-btn-room",function(){
					$(this).closest(".row").remove();
				});

				// $(document).on('click',".remove-btn-room",function(){
				// 	// alert("Hi");
				// 	$(this).closest(".flexFormGroup").remove();
				// });

				// $('#js-example-basic-hide-search-multi').select2();

				// $('.select2-multiple').on('select2:opening select2:closing', function( event ) {
				// 	var $searchfield = $(this).parent().find('.select2-search__field');
				// 	$searchfield.prop('disabled', true);
				// });
			});
		</script>
	</body>
</html>



		