<?php
	$data['name']='Parent Settings'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Mydiaree</title>
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
	<body id="app-container" class="menu-default" style="background-color: #f8f8f8; top: -35px; bottom:0px;">
<?php $this->load->view('sidebar'); ?> 

<main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Add Parent Settings</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Settings</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Add Parent</li>
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
		<form action="<?php echo base_url("Settings/saveParentDetails"); ?>" method="post" enctype="multipart/form-data">
			<div class="rightFOrmSection">
				<?php if (isset($_GET['recordId'])) { ?>
					<h3>Edit Parent</h3>
				<?php } else { ?>
					<h3>Add Parent</h3>
				<?php } ?>

				<?php if (isset($_GET['recordId'])) { ?>
					<input type="hidden" name="recordId" value="<?php echo $_GET['recordId']; ?>">
				<?php } ?>

				<div class="flexFormGroup">
					<div class="form-group">
						<label for="name">Select Center</label>
						<select class="select2-multiple" data-width="100%" id="js-example-basic-hide-search-multi" name="states[]" multiple="multiple">
							<option value="AL">Alabama</option>
							<option value="WY">Wyoming</option>
							<option value="AL">Alabama</option>
							<option value="WY">Wyoming</option>
							<option value="AL">Alabama</option>
							<option value="WY">Wyoming</option>
							<option value="AL">Alabama</option>
							<option value="WY">Wyoming</option>
						</select>
					</div>
				</div>

				<h4 class="title">Personal Details</h4>
				<div class="flexFormGroup">
					<div class="form-row">
						<div class="col">
							<div class="form-group">
								<label for="name">Full Name</label>
								<input type="text" class="form-control" id="name" name="name" value="<?php echo isset($parents->name)?$parents->name:""; ?>">
							</div>
						</div>
						<div class="col">
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
						<div class="col">
							<div class="form-group">
								<label for="dob">Date of Birth</label>
								<input type="date" class="form-control" id="dob" name="dob" value="<?php echo isset($parents->dob)?$parents->dob:""; ?>">
							</div>
						</div>
					</div>

					<div class="form-row">
						<div class="col">
							<div class="form-group">
								<label for="phone">Contact Number</label>
								<input type="text" class="form-control" id="phone" name="contactNo" value="<?php echo isset($parents->contactNo)?$parents->contactNo:""; ?>">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" class="form-control" id="email" name="emailid" value="<?php echo isset($parents->emailid)?$parents->emailid:""; ?>">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label for="password">Password</label>
								<input type="text" class="form-control" id="password" name="password" value="">
							</div>
						</div>
					</div>




				</div>

				<div class="roomList room-section" id="children-sec">
					<h4 class="title">Add Child <button type="button" class="btn btn-default btn-small btnBlue pull-right btn-add">Add</button></h4>
					<div class="flexFormGroup">
					
					<?php if (empty($parents->children)) { ?>
						<div class="form-group">
							<label>Select Children</label>
							<select name="children[]" class="form-control">
								<?php foreach ($children as $ch => $cobj){ ?>
									<option value="<?php echo $cobj->id; ?>"><?php echo $cobj->name; ?></option>
								<?php } ?>
							</select>
						</div>
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

					<?php }else{ 
						$i=1;
						foreach ($parents->children as $childrens => $chl) {
					?>
						<div class="form-group">
							<label>Select Children</label>
							<select name="children[]" class="form-control">
								<?php foreach ($children as $ch => $cobj){ 

									if ($cobj->id==$chl->childid) {
								?>
								<option value="<?php echo $cobj->id; ?>" selected><?php echo $cobj->name; ?></option>
								<?php } else { ?>
								<option value="<?php echo $cobj->id; ?>"><?php echo $cobj->name; ?></option>
								<?php }  } ?>
							</select>
						</div>
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

							<?php if ($i>1) { ?>
							<button type="button" class="btn btn-danger btn-small btnRed btn-block remove-btn-room">Remove</button>
							<?php } ?>
					<?php  $i++; } } ?>
				</div>
			</div>
			<div class="formSubmit mt-3 text-right">
					<input type="submit" class="btn btn-default btnBlue pull-right btn-primary" value="SAVE">
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
			$(".btn-add").on("click",function(){
				$("#children-sec").append('<div class="flexFormGroup mt-3"><div class="form-group"> <label>Select Children</label> <select name="children[]" class="form-control"> <?php foreach ($children as $ch => $cobj){ ?><option value="<?php echo $cobj->id; ?>"><?php echo $cobj->name; ?></option> <?php } ?> </select></div><div class="form-group"> <label>Relation</label> <select name="relation[]" class="form-control"><option value="Mother">Mother</option><option value="Father">Father</option><option value="Brother">Brother</option><option value="Sister">Sister</option><option value="Relative">Relative</option> </select></div><button type="button" class="btn btn-danger btn-small btnRed btn-block remove-btn-room">Remove</button></div>');
			});

			// $(document).on("click",".btn-remove",function(){
			// 	$(this).closest(".row").remove();
			// });

			$(document).on('click',".remove-btn-room",function(){
				// alert("Hi");
				$(this).closest(".flexFormGroup").remove();
			});

			// $('#js-example-basic-hide-search-multi').select2();

			$('.select2-multiple').on('select2:opening select2:closing', function( event ) {
				var $searchfield = $(this).parent().find('.select2-search__field');
				$searchfield.prop('disabled', true);
			});
		});
	</script>
</body>
</html>



		