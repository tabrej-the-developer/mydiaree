<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Users | Mydiaree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2-bootstrap.min.css?v=1.0.0">
	<link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2.min.css?v=1.0.0">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	
	<style type="text/css">
		.north {
			transform: rotate(0deg);
			-ms-transform: rotate(0deg);
			-webkit-transform: rotate(0deg);
		}

		.west {
			transform: rotate(90deg);
			-ms-transform: rotate(90deg);
			-webkit-transform: rotate(90deg);
		}

		.south {
			transform: rotate(180deg);
			-ms-transform: rotate(180deg);
			-webkit-transform: rotate(180deg);
		}

		.east {
			transform: rotate(270deg);
			-ms-transform: rotate(270deg);
			-webkit-transform: rotate(270deg);
		}
		.form-group.uploadFile {
		    border: 2px dashed #e1dfdf;
		    padding: 10px;
		    width: 100%;
		    display: flex;
		    align-items: center;
		}
		.form-group label.file-upload-field {
			display: flex;
		}
		.form-group.uploadFile label {
			margin-right: 15px;
			text-transform: uppercase;
			font-weight: 600;
			height: 120px;
			width: 120px;
		}
		.form-group label {
			display: inline-block;
			width: 100%;
			margin-bottom: 5px;
			font-weight: 400;
			text-align: left;
		}
		label.file-upload-field {
			background: rgba(41, 125, 182, 0.06);
			border: 1px dashed #e1dfdf;
			align-items: center;
			display: inline-flex;
			justify-content: center;
			max-width: 120px;
			font-size: 14px;
			font-weight: 600;
			flex-direction: column;
			margin: 0;
			margin-right: 0px;
			margin-bottom: 0px;
			margin-left: 0px;
			height: 100px;
			width: 100px;
			padding: 40px 0px;
			margin-left: 4px;
		}
		input.form-control-hidden {
			display: none;
		}
		table th, table td {
			padding: 10px;
			border: 1px solid #e1dfdf;
		}
		.circleimage {
			border:  1px solid #d8d8d8;
		}
		.form-input-pin{
			width: 40px;
			margin-right: 10px;
			text-align: center;
		}
		.btn-view-pin{
    		padding: 0.5rem!important;
    		font-size: 14px!important;
		    width: 40px;
		    text-align: center;
		    display: inline-block;
		    background-color: #fdfdfd!important;
    	}
	</style>
</head>

<body id="app-container" class="menu-default show-spinner">
	<?php $this->load->view('sidebar'); ?> 
	<main data-centerid="<?= isset($_GET['centerid'])?$_GET['centerid']:''; ?>">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>User Settings</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Settings</a>
                            </li>
                            <li class="breadcrumb-item">
                            	<?php 
                            		if(isset($_GET['centerid'])){
                            			$settings_url = base_url() . 'Settings/userSettings?centerid=' . $_GET['centerid'];
                            		}else{
                            			$settings_url = base_url() . 'Settings/userSettings';
                            		}
                            	?>
                                <a href="<?= $settings_url; ?>"> User Settings </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                            	<?php if (isset($_GET['recordId'])) { ?> Edit User <?php } else { ?> Add User <?php } ?>
                            </li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
			<div class="row">
				<div class="col-md-12">
					<div class="card d-flex flex-row">
						<div class="card-body">
							<?php if (isset($_GET['recordId'])) { ?>
								<h3>Edit User </h3>
							<?php } else { ?>
								<h3>Add User</h3>
							<?php } ?>
							<form id="save-staff" action="<?= base_url('Settings/saveUsersDetails'); ?>" method="post" enctype="multipart/form-data">
								<?php if (isset($_GET['recordId'])) { ?>
									<input type="hidden" name="recordId" value="<?= $_GET['recordId']; ?>">
								<?php } ?>

								<?php if (!isset($_GET['recordId'])) { ?>
									<input type="hidden" name="userType" value="Staff">
								<?php } ?>

								<div class="flexFormGroup">
									<div class="form-group">
										<label for="centerId">Select Center</label>
										<?php ?>
										<select id="centerId" name="centerIds[]" class="form-control select2-multiple" multiple="multiple" data-width="100%">
											<?php 
												if (isset($_GET['recordId'])) {
													
													foreach($centers as $key => $center){
											?>
											<option value="<?= $center->id; ?>" <?= $center->selected; ?>><?= $center->centerName; ?></option>
											<?php
													}
												}else{
													$centers = $this->session->userdata("centerIds");
													foreach($centers as $key => $center){
											?>
											<option value="<?= $center->id; ?>"><?= $center->centerName; ?></option>
											<?php
													}
												}
											?>
										</select>
									</div>
								</div>
								<h4 class="title">Personal Details</h4>
								<div class="flexFormGroup">
									<div class="row">
										<div class="col">
											<div class="form-group">
												<label for="name">Full Name</label>
												<input type="text" class="form-control" id="name" name="name" value="<?php echo isset($userdata->name)?$userdata->name:""; ?>">
											</div>
										</div>
										<div class="col">
											<div class="form-group">
												<label for="Gender">Gender</label>
												<select name="gender" id="gender" class="form-control">
													<?php if (isset($userdata->gender)&&$userdata->gender=="MALE") { ?>
													<option value="MALE" selected>MALE</option>
													<option value="FEMALE">FEMALE</option>
													<option value="OTHERS">OTHERS</option>
													<?php }elseif (isset($userdata->gender)&&$userdata->gender=="FEMALE") {?> 
													<option value="MALE">MALE</option>
													<option value="FEMALE" selected>FEMALE</option>
													<option value="OTHERS">OTHERS</option>
													<?php }elseif (isset($userdata->gender)&&$userdata->gender=="OTHERS"){ ?>
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
										<div class="col">
											<div class="form-group">
												<label for="dob">Date of Birth</label>
												<input type="text" class="form-control datepicker" id="dob" name="dob" 
       value="<?= isset($userdata->dob) ? date('d-m-Y', strtotime($userdata->dob)) : ""; ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label for="phone">Contact Number</label>
												<!-- <input type="text" class="form-control" id="phone" name="contactNo" onchange='check_length(this.id)' value="<?php echo isset($userdata->contactNo)?$userdata->contactNo:''; ?>" pattern="[1-9]{1}[0-9]{9}" > -->
												<input type="text" class="form-control" id="phone" name="contactNo" value="<?php echo isset($userdata->contactNo)?$userdata->contactNo:''; ?>" >

											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="email">Email</label>
												<input type="email" class="form-control" id="email" name="emailid" value="<?= isset($userdata->emailid)?$userdata->emailid:''; ?>">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="title">Title</label>
												<input type="text" class="form-control" id="title" name="title" value="<?= isset($userdata->title)?$userdata->title:''; ?>">
											</div>
										</div>
										<?php 
										if(!isset($_GET['recordId'])){
									    ?>
										<div class="col-md-4">
											<div class="form-group">
												<label for="password">Password</label>
												<input type="password" class="form-control" name="password" 
													id="password" pattern="^\d{4}$" maxlength="4" 
													inputmode="numeric" 
													placeholder="Enter 4 digit PIN" required title="Please enter a 4-digit PIN">
												<small id="passwordHelp" class="form-text text-muted">Please enter a 4-digit PIN.</small>
											</div>
										</div>
                                        <?php } ?>
									</div>
								</div>

								
								<h4 class="title">Account Details</h4>
								<div class="row">
									<div class="col-md-6">
										<?php if(isset($_GET['recordId'])){ ?>
										<div class="row">
											<div class="col">
												<div class="form-group">
													<label for="usertype">Usertype</label>
													<select class="form-control" id="usertype" name="userType" readonly>
    <?php if ($userdata->userType == "Superadmin"): ?>
        <option value="Superadmin" selected>Superadmin</option>
    <?php elseif ($userdata->userType == "Staff"): ?>
        <option value="Staff" selected>Staff</option>
    <?php endif; ?>
</select>

												</div>
											</div>
											<div class="col">
												<div class="form-group">
													<label for="status">Status</label>
													<select class="form-control" id="status" name="status">
														<option value="ACTIVE"<?= ($userdata->status == "ACTIVE")?'selected':''; ?>>Active</option>
														<option value="IN-ACTIVE"<?= ($userdata->status == "IN-ACTIVE")?'selected':''; ?>>In-active</option>
													</select>
												</div>
											</div>
										</div>
										<?php } ?>
										<div class="row">
											<div class="col-12">
												<?php if(isset($_GET['recordId'])){ ?>
												<div class="form-group empcode">
													<label for="empCode">Employee Code</label>
													<input type="text" class="form-control" id="empCode" name="username" value="<?= isset($userdata->username)?$userdata->username:""; ?>" placeholder="e.g. EMP0001" readonly>
												</div>
												<div class="err-empcode"></div>
												<?php } else { ?>
												<div class="form-group empcode">
													<label for="empCode">Employee Code</label>
													<input type="text" class="form-control" id="empCode" name="username" value="<?= isset($userdata->username)?$userdata->username:""; ?>" placeholder="e.g. EMP0001">
												</div>
												<div class="err-empcode"></div>
												<?php } ?>
											</div>
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group uploadFile">
											<div id="img-holder">
												<?php 
													if(isset($_GET['recordId'])){
														if (empty($userdata->imageUrl)) {
															$image = "https://via.placeholder.com/120x120.png?text=No+Image";
														} else {
															$image = base_url("api/assets/media/").$userdata->imageUrl;
														}
												?>
												<img class="circleimage" src="<?php echo $image; ?>" height="120px" width="120px">
												<?php } ?>
												
											</div>
											<label class="file-upload-field" for="fileUpload" style="min-width: 82px;max-height: 20px;">
												<i class="simple-icon-plus"></i><span></span>
											</label>
											<input type="file" name="image" id="fileUpload" class="form-control-hidden" accept="image/*">
										</div>
									</div>

								</div>
								<div class="form-group text-right">
									
									<?php 
										if(isset($_GET['recordId'])){ 
									?>
										<a href="<?= base_url('Settings/adminresetpassword') . '?recordId=' . $_GET['recordId']; ?>" class="btn btn-outline-danger">Reset Password</a>
										<button type="submit" class="btn btn-primary btn-submit" id="btn-action">Submit</button>
									<?php
										}else{
									?>
									<button type="reset" class="btn btn-outline-primary" id="btn-reset">Reset</button>
									<button type="submit" class="btn btn-primary" id="btn-action" >Submit</button>
									<?php
										}
									?>
									
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
        </div>
    </main>
	<?php $this->load->view('footer_v3'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap-datepicker.js"></script>
	<script src="<?= base_url('assets/v3'); ?>/js/vendor/select2.full.js?v=1.0.0"></script>
	<script src="https://kit.fontawesome.com/5be04f7085.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>
	<script>
	document.getElementById("password").addEventListener("input", function(event) {
		// Allow only digits and ensure length is 4
		this.value = this.value.replace(/\D/g, '').slice(0, 4);  // Remove non-digits and limit to 4 digits
	});
	</script>

	<script>
		$(document).ready(function(){

			$("button[type='reset']").on('click', function(e) {
    // Prevent the default reset behavior
    e.preventDefault();
    
    // Show SweetAlert confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: "This will reset all input fields. Do you want to continue?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, reset it!',
        cancelButtonText: 'No, cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // If user confirms, reset the form and clear error messages
            $(this).closest('form')[0].reset();
            $('.err-empcode').empty();
            
            // Optional: Show success message
            Swal.fire(
                'Reset!',
                'Your form has been reset.',
                'success'
            );
        }
    });
});

			$("#usertype").on("change",function(){
				var userval = $(this).val();
				if(userval=="STAFF") {
					$(".empcode").css("display","block");
					$(".pin").css("display","block");
					$(".password").css("display","none");
				} else {
					$(".empcode").css("display","none");
					$(".pin").css("display","none");
					$(".password").css("display","block");
				}
			});

		
			var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'heic', 'heif'];
    var cropper;
    var selectedFile;
    var croppedBlob;
    var hasExistingImage = $('#img-holder img').length > 0;

    $("#fileUpload").change(function () {
        var input = $(this)[0];
        if (input.files && input.files[0]) {
            selectedFile = input.files[0];
            hasExistingImage = false;  // Reset flag when new file is selected

            var fileName = selectedFile.name;
            var fileSize = selectedFile.size / 1024 / 1024; // Convert to MB
            var fileExt = fileName.split('.').pop().toLowerCase();

            // Validate file extension
            if (!allowedExtensions.includes(fileExt)) {
                Swal.fire("Invalid File", "Only JPG, JPEG, PNG, GIF, WEBP, HEIC, HEIF images are allowed.", "error");
                $(this).val(''); // Clear file input
                return;
            }

            // Validate file size (Max 2MB)
            if (fileSize > 2) {
                Swal.fire("File Too Large", "Image size must be under 2MB.", "error");
                $(this).val(''); // Clear file input
                return;
            }

            // Read and preview image
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img-holder').html('<img id="imageCropper" src="' + e.target.result + '" style="max-width:100%;"/>');

                // Initialize Cropper
                var image = document.getElementById('imageCropper');
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(image, {
                    aspectRatio: 1, // Square crop
                    viewMode: 1,
                    minContainerWidth: 300,
                    minContainerHeight: 300,
                });

                // Show Crop Button
                $("#cropBtn").remove();
                $("#img-holder").after('<button type="button" id="cropBtn" class="btn btn-success mt-2" style="min-width:110px;">Crop Image</button>');
            };
            reader.readAsDataURL(selectedFile);
        }
    });

    // Handle Crop
    $(document).on("click", "#cropBtn", function () {
        var canvas = cropper.getCroppedCanvas({
            width: 200,
            height: 200
        });

        // Convert to Blob
        canvas.toBlob(function (blob) {
            croppedBlob = blob; // Store cropped image for later upload

            // Show preview of cropped image
            var previewUrl = URL.createObjectURL(blob);
            $('#img-holder').html('<img src="' + previewUrl + '" width="120px" height="120px"/>');

            // Remove Crop button after cropping
            $("#cropBtn").remove();
        }, "image/jpeg");
    });

    // Handle Form Submission
    $('#save-staff').on('submit', function (event) {
        event.preventDefault();

        // Only check for cropped image if a new file was uploaded
        if (!hasExistingImage && !croppedBlob) {
            Swal.fire("Error!", "Please crop the image before submitting.", "error");
            return;
        }

        var formdata = new FormData(this);
        
        // Only append the cropped blob if a new image was uploaded and cropped
        if (croppedBlob) {
            formdata.append("image", croppedBlob, "cropped-image.jpg");
        }

        $.ajax({
            url: $('#save-staff').attr('action'),
            type: 'POST',
            data: formdata,
            processData: false,
            contentType: false,
            beforeSend: function () {
                Swal.fire({
                    title: "Uploading...",
                    text: "Please wait while we upload your image.",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function (response) {
                Swal.close();
                var res = JSON.parse(response);
                if (res.Status === "SUCCESS") {
                    Swal.fire("Success!", res.Message, "success").then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire("Error!", res.Message, "error");
                }
            },
            error: function () {
                Swal.fire("Error!", "Something went wrong. Please try again.", "error");
            }
        });
    });
});
		

		$(document).on('keyup','#empCode',function(){
			let _value = $(this).val();
			if(_value.length > 3){
				$.ajax({
					url: '<?= base_url('Settings/fetchEmpCodeAvl'); ?>',
					type: 'POST',
					data: {'empCode': _value},
				})
				.done(function(msg) {
				
				
					res = $.parseJSON(msg);
					$('.err-empcode').empty();
					if(res.count == 0){
						$('.err-empcode').append('<div class="text-success">'+res.Message+'</div>');
						$("#btn-action").addClass('btn-submit').removeAttr('disabled');
					}else{
						$('.err-empcode').append('<div class="text-danger">'+res.Message+'</div>');
						$("#btn-action").removeClass('btn-submit').prop('disabled','disabled');
					}
				});
				
			}
		});
	</script>		
</body>
</html>


 	