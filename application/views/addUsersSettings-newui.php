<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Users | Mykronicle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<script type="text/javascript" src="<?php echo base_url('assets/js/vendor/jquery/jquery.min.js?id=1234'); ?>"></script>
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
	<link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2-bootstrap.min.css?id=1234">
	<link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2.min.css?id=1234">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-jcrop/0.9.9/js/jquery.Jcrop.min.js?id=1234"></script>
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
				padding: 50px;
				width: 100%;
				display: flex;
				align-items: center;
				justify-content: center;
			}
			.form-group label.file-upload-field {
				display: flex;
			}
			.form-group.uploadFile label {
				margin-right: 15px;
				text-transform: uppercase;
				font-weight: 600;
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
				max-width: 108px;
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
                                <a href="<?= base_url() . 'Settings/userSettings?centerid=' . isset($_GET['centerid'])?$_GET['centerid']:''; ?>">User Settings</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Add User</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
			<div class="row">
				<div class="col-md-12">
					<div class="card d-flex flex-row">
						<div class="card-body">
						<div class="settingsView">
		<!-- <div class="sideMenu">
			<php $this->load->view('settings-menu-sidebar'); ?>
		</div> -->
		<div class="rightFOrmSection">
			<?php if (isset($_GET['recordId'])) { ?>
				<h3>Edit User</h3>
			<?php } else { ?>
				<h3>Add User</h3>
			<?php } ?>

			
			<form class="flexDirColoumn" action="<?php echo base_url("Settings/saveUsersDetails"); ?>" method="post" enctype="multipart/form-data">
				<?php if (isset($_GET['recordId'])) { ?>
					<input type="hidden" name="recordId" value="<?php echo $_GET['recordId']; ?>">
				<?php } ?>
				<div class="flexFormGroup">
					<div class="form-group">
					<label for="centers">Select Center</label>
					<?php $centers = $this->session->userdata("centerIds");?>
					<select id="centerId" name="centerIds[]" class="form-control select2-multiple" multiple data-width="100%">
						<?php foreach($centers as $key => $center){ ?> 
						<!-- <option value="<php echo $center->id; ?>" <= $center->selected;?>><php echo $center->centerName; ?></option> -->
						<option value="<?php echo $center->id; ?>"><?php echo $center->centerName; ?></option>
						<?php } ?>
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
								<input type="date" class="form-control bs-datepicker" id="dob" name="dob" value="<?php echo isset($userdata->dob)?$userdata->dob:""; ?>">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="phone">Contact Number</label>
						<input type="text" class="form-control" id="phone" name="contactNo" onchange='check_length(this.id)' value="<?php echo isset($userdata->contactNo)?$userdata->contactNo:""; ?>" pattern="[1-9]{1}[0-9]{9}" >
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" id="email" name="emailid" value="<?php echo isset($userdata->emailid)?$userdata->emailid:""; ?>">
					</div>
				</div>

				
				<h4 class="title">Account Details</h4>
				<div class="flexFormGroup">
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="title">Title</label>
								<input type="text" class="form-control" id="title" name="title" value="<?php echo isset($userdata->title)?$userdata->title:""; ?>">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label for="usertype">Usertype</label>
								<select class="form-control" id="usertype" name="userType">
									<?php if(strtoupper($userdata->userType)=="SUPERADMIN"){ ?>
									<option value="SUPERADMIN" selected>SUPERADMIN</option>
									<option value="STAFF">STAFF</option>
									<?php } elseif(strtoupper($userdata->userType)=="STAFF"){ ?>
									<option value="SUPERADMIN">SUPERADMIN</option>
									<option value="STAFF" selected>STAFF</option>	
									<?php }else{ ?>
									<option value="SUPERADMIN">SUPERADMIN</option>
									<option value="STAFF">STAFF</option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<?php if(isset($userdata->userType)&&strtoupper($userdata->userType)=="STAFF"){  ?>
						<div class="empcode form-group">
								<label for="empCode">Employee Code</label>
								<input type="text" class="form-control" id="empCode" name="username" value="<?php echo isset($userdata->username)?$userdata->username:""; ?>">
						</div>
					<?php } ?>
					<?php #if(isset($userdata->userType)&&strtoupper($userdata->userType)=="STAFF"){ ?>
					<!-- <div class="pin form-group" >
							<label for="password">PIN</label>
							<br>
							<input type= "text" maxlength="1" name="pin[]" class="pin-box">
							<input type="text" maxlength="1" name="pin[]" class="pin-box"> 
							<input type="text" maxlength="1" name="pin[]" class="pin-box">
							<input type="text" maxlength="1" name="pin[]" class="pin-box">
					</div> -->
					<?php #}else{ ?>
					<!-- <div class="form-group">
						<label for="password">Password</label>
						<input type="text" class="form-control" id="password" name="password" value="">
					</div> -->
					<?php #} ?>
				</div>

				<div class="form-group uploadFile " style='height:462px'>
					<div class="text-center">
						<div id="img-holder" style="margin-bottom: 10px;margin-right: 10px;">
							<?php 
								if (empty($userdata->imageUrl)) {
									$image = "https://via.placeholder.com/120x120.png?text=No+Image";
								} else {
									$image = base_url("api/assets/media/").$userdata->imageUrl;
								}
							?>
							<img class="circleimage img-fluid" src="<?php echo $image; ?>">
						</div>
						<label class="file-upload-field" id='label_hide' for="FileUpload1">
							<i class="simple-icon-plus"></i><span>Upload</span>
						</label>
					</div>
					<!--<input type="file" name="image" id="fileUpload" class="form-control-hidden">-->
					<input type="file" name="image" id="FileUpload1" class="form-control-hidden"/>
    					<br /><br />
					
						<div class=''>
							<table border="0" cellpadding="0" cellspacing="5">
								<tr>
									<td><img id="Image1" class="img-fluid" src="" alt="" style="display: none;width:500px;height:300px;" /></td>
									<td  id="image" class="north">
									<canvas id="canvas" height="5" width="5"></canvas>
									</td>
								</tr> 
							</table>
							<br>

							<input type="button" id="btnCrop" value="Crop" style="display: none" />
							<input type="button" id="btnRotate" value="Rotate" style="display: none" />
						</div>
					
				</div>

				<!--<input type="file" id="FileUpload1"/>
    				<br /><br />
					<table border="0" cellpadding="0" cellspacing="5">
        				<tr>
            				<td><img id="Image1" src="" alt="" style="display: none" /></td>
            				<td  id="image" class="north">
                			<canvas id="canvas" height="5" width="5"></canvas>
            				</td>
        				</tr> 
    				</table>
					<br>-->
					<input type='hidden' name='image_position' id='image_position' />
					<input type='hidden' name='file_type' id='file_type' />
    				<input type="hidden" id="imgX1" />
    				<input type="hidden" id="imgY1" />
    				<input type="hidden" id="imgWidth" />
    				<input type="hidden" id="imgHeight" />
    				<input type="hidden" name="imgCropped" id="imgCropped" />

				<div class="formSubmit text-right">
					<input type="submit" class="btn btn-default btnBlue pull-right btn-primary">
				</div>
			</form>
		</div>

	</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </main>
<?php $this->load->view('footer_v3'); ?>
    <!-- <script src="<= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?id=1234"></script> -->
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?id=1234"></script>
	<!-- <php $this->load->view('footer'); ?> -->

	<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js?id=1234"></script> -->
	<script src="<?= base_url('assets/v3'); ?>/js/vendor/select2.full.js?id=1234"></script>

	<script type="text/javascript">
		$(function () {
			$('#FileUpload1').change(function () {
				$('#Image1').hide();
				var reader = new FileReader();
				reader.onload = function (e) {
					$('#Image1').show();
					$('#Image1').attr("src", e.target.result);
					$('#Image1').Jcrop({
						onChange: SetCoordinates,
						onSelect: SetCoordinates
					});
				}
				
				reader.readAsDataURL($(this)[0].files[0]);
			});

			$('#btnCrop').click(function () {
				var x1 = $('#imgX1').val();
				var y1 = $('#imgY1').val();
				var width = $('#imgWidth').val();
				var height = $('#imgHeight').val();
				var canvas = $("#canvas")[0];
				var context = canvas.getContext('2d');
				var img = new Image();
				
				img.onload = function () {
					canvas.height = height;
					canvas.width = width;
					context.drawImage(img, x1, y1, width, height, 0, 0, width, height);
					
					$('#imgCropped').val(canvas.toDataURL());
					$('[id*=btnRotate]').show();
					$('[id*=btnUpload]').show();
				};
				img.src = $('#Image1').attr("src");
			});

			$("#btnRotate").click(function () {
				var img = $('#image');
				if (img.hasClass('north')) {
					$('#image_position').val('west');
					img.attr('class', 'west');
					
				} else if (img.hasClass('west')) {
					$('#image_position').val('south');
					img.attr('class', 'south');
					
				} else if (img.hasClass('south')) {
					$('#image_position').val('east');
					img.attr('class', 'east');
					
				} else if (img.hasClass('east')) {
					$('#image_position').val('north');
					img.attr('class', 'north');
					
				}
			});
		});
		function SetCoordinates(c) {
			$('#imgX1').val(c.x);
			$('#imgY1').val(c.y);
			$('#imgWidth').val(c.w);
			$('#imgHeight').val(c.h);
			$('#btnCrop').show();
		};
	</script>
	<script>
		$(document).ready(function(){

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

			$("#fileUpload").change(function () {
				input = $(this)[0];
				console.log(input.files);
				if (input.files && input.files[0]) {
					var reader = new FileReader();
					reader.onload = function (e) {
						$('#label_hide').remove();
						$('#img-holder').empty();
						$('#img-holder').after('<img src="'+e.target.result+'" width="450" height="300"/>');
					};
					reader.readAsDataURL(input.files[0]);
				}
			});

		});

		function check_length(get_id){
			if( $('#'+get_id).val().length!=10 && $('#'+get_id).val().length >0 ){
				alert('Please Given 10 digit Contact Number Only!!');
				return false;
			}
		}
		
	</script>		
</body>
</html>


 	