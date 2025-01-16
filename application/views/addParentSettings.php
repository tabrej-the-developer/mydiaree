<?php
	$data['name']='Parent Settings'; 
	$this->load->view('header',$data);
?>

<main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Add Parent</h1>
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
		<div class="sideMenu">
			<?php $this->load->view('settings-menu-sidebar'); ?>
		</div>

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
						<select class="form-control" id="js-example-basic-hide-search-multi" name="states[]" multiple="multiple">
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
					<div class="form-group">
						<label for="name">Full Name</label>
						<input type="text" class="form-control" id="name" name="name" value="<?php echo isset($parents->name)?$parents->name:""; ?>">
					</div>
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
					<div class="form-group">
						<label for="dob">Date of Birth</label>
						<input type="text" class="form-control" id="dob" name="dob" value="<?php echo isset($parents->dob)?$parents->dob:""; ?>">
					</div>
					<div class="form-group">
						<label for="phone">Contact Number</label>
						<input type="text" class="form-control" id="phone" name="contactNo" value="<?php echo isset($parents->contactNo)?$parents->contactNo:""; ?>">
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" id="email" name="emailid" value="<?php echo isset($parents->emailid)?$parents->emailid:""; ?>">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="text" class="form-control" id="password" name="password" value="">
					</div>
				</div>

				<div class="roomList  room-section" id="children-sec">
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
							<button type="button" class="btn btn-danger btn-small btnRed btn-block btn-remove">Remove</button>
							<?php } ?>


					<?php  $i++; } } ?>
					
					
				</div>

				
				<div class="formSubmit">
					<input type="submit" class="btn btn-default btnBlue pull-right" value="SAVE">
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

<?php $this->load->view('footer'); ?>
<script>
	$(document).ready(function(){
		$(".btn-add").on("click",function(){
			$("#children-sec").append('<div class="flexFormGroup"><div class="form-group"> <label>Select Children</label> <select name="children[]" class="form-control"> <?php foreach ($children as $ch => $cobj){ ?><option value="<?php echo $cobj->id; ?>"><?php echo $cobj->name; ?></option> <?php } ?> </select></div><div class="form-group"> <label>Relation</label> <select name="relation[]" class="form-control"><option value="Mother">Mother</option><option value="Father">Father</option><option value="Brother">Brother</option><option value="Sister">Sister</option><option value="Relative">Relative</option> </select></div><button type="button" class="btn btn-danger btn-small btnRed btn-block btn-remove">Remove</button></div>');
		});

		$(document).on("click",".btn-remove",function(){
			$(this).closest(".row").remove();
		});

		$('#js-example-basic-hide-search-multi').select2();

		$('#js-example-basic-hide-search-multi').on('select2:opening select2:closing', function( event ) {
			var $searchfield = $(this).parent().find('.select2-search__field');
			$searchfield.prop('disabled', true);
		});
	});
</script>		