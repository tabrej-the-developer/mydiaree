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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

	<style>
		.list-thumbnail{
			width: 85px!important;
		}
	</style>
</head>
<body id="app-container" class="menu-default show-spinner">
	<?php $this->load->view('sidebar'); ?> 
   

<main>
        <div class="container-fluid">

        <div class="row">
                <div class="col-12">
                    <h1>SuperAdmin Settings</h1>
             

                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Settings</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Superadmin Settings</li>
                        </ol>
                    </nav>
                    <button class="btn btn-outline-primary" style="float:right;" data-bs-toggle="modal" data-bs-target="#addSuperadminModal">
        Add Superadmin
    </button>
                    <div class="separator mb-5"></div>
               
                </div>
               
            </div>
        


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
                                        <a href="<?= base_url('Settings/addUsers') . '?recordId=' . $obj->userid ?>" class="btn btn-xs btn-outline-primary ">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
				<?php } ?>
			</div>

    </div>
    </main>














<!-- Modal Form -->
<div class="modal fade" id="addSuperadminModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Add New Superadmin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height:500px;overflow-y:auto;">
                <form id="superadminForm">
                    <!-- Superadmin Details Section -->
                    <h6 class="mb-3">Superadmin Details</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email ID</label>
                            <input type="email" class="form-control" name="emailid" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact No</label>
                            <input type="tel" class="form-control" name="contactNo" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" name="dob" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select class="form-select" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="MALE">Male</option>
                                <option value="FEMALE">Female</option>
                                <option value="OTHERS">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Profile Image</label>
                            <input type="file" class="form-control" name="imageUrl" accept="image/*">
                        </div>
                    </div>

                    <!-- Center Details Section -->
                    <h6 class="mt-4 mb-3">Center Details</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Center Name</label>
                            <input type="text" class="form-control" name="centerName" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Street Address</label>
                            <input type="text" class="form-control" name="adressStreet" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" name="addressCity" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">State</label>
                            <input type="text" class="form-control" name="addressState" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ZIP Code</label>
                            <input type="text" class="form-control" name="addressZip" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitSuperadminForm()">Save</button>
            </div>
        </div>
    </div>
</div>



    <?php $this->load->view('footer_v3'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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

 
    <script>
function submitSuperadminForm() {
    const form = document.getElementById('superadminForm');
    const formData = new FormData(form);
    
    // Add userType for superadmin
    formData.append('userType', 'Superadmin');

    // Show loading state
    const submitBtn = document.querySelector('[onclick="submitSuperadminForm()"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Saving...';

    $.ajax({
        url: '<?php echo base_url("Settings/addsuperadmin"); ?>',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            const data = JSON.parse(response);
            if (data.status === 'success') {
                // Show success message
                alert('Superadmin added successfully!');
                
                // Close modal
                $('#addSuperadminModal').modal('hide');
                
                // Reload page to show new data
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        },
        error: function(xhr, status, error) {
            alert('Error occurred while saving data. Please try again.');
        },
        complete: function() {
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Save';
        }
    });
}

    </script>
</body>
</html>