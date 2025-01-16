<?php 

	$data['name']='createReflection'; 
	// $this->load->view('header',$data); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Reflection | Mykronicle</title>
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
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/slick.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/dropzone.min.css" />
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <main class="default-transition">
        <!-- Observation code use -->
        <div class="container-fluid observationListContainer">
            <div class="pageHead">
                <h1>Reflection</h1>
            </div>
            <!-- <ul class="breadcrumb" style="background-color: none !important;">
                <li class=""><a href="#">Add New Reflection</a></li>
            </ul> -->
            <form action="<?php echo base_url('Reflections/addreflection'); ?>" method="post"
                enctype="multipart/form-data">
                <input type="hidden" name="centerid" value="<?php echo $centerid; ?>">
                <div class="row mb-3">
					<div class="col-lg-6 col-sm-6 col-md-6">
						<label for="">Children</label>
						<select id="Children" name="Children[]"
								class="popinput js-example-basic-multiple multiple_selection form-control select2-multiple"
								multiple="multiple">
								<?php foreach($child as $childs => $objchild) { ?>
								<option name="<?php echo $objchild->name; ?>"
									value="<?php echo $objchild->childid; ?>"><?php echo $objchild->name; ?>
								</option>
								<?php }?>
						</select>
					</div>
					<div class="col-lg-6 col-sm-6 col-md-6">
						<label for="">Educators</label>
						<select id="room_educators" name="Educator[]"
								class="popinput js-example-basic-multiple multiple_selection form-control select2-multiple"
								multiple="multiple">
								<?php foreach($Educator as $Educators => $objEducator) { ?>
								<option name="<?php echo $objEducator->name; ?>"
									value="<?php echo $objEducator->userid; ?>"><?php echo $objEducator->name; ?>
								</option>
								<?php }?>
						</select>
					</div>
				</div>

				<div class="row mb-3">
					<div class="col-lg-12 col-sm-12 col-md-12">
						<label for="title">Title</label>
                        <input type="text" name="title" class="form-control title" id="title">
					</div>
				</div>

				<div class="row mb-3">
					<div class="col-lg-12 col-sm-12 col-md-12">
						<label for="about">Reflection</label>
                        <textarea name="about" class="form-control about rounded-1" id="about" rows="10" style=""></textarea>
					</div>
				</div>
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="mb-4">Upload Single/Multiple Images</h5>
                        <input type="file" name="media[]" id="fileUpload" class="form-control-hidden" multiple>
                    </div>
                </div>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-check-inline">
                            <label class="form-check-label custom-control custom-checkbox mb-1 align-self-center pr-4">
                                <input type="radio" class="form-check-input custom-control-input" name="status" value="PUBLISHED" checked>
                                <span class="custom-control-label">PUBLISHED</span>
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label custom-control custom-checkbox mb-1 align-self-center pr-4 pl-0">
                                <input type="radio" class="form-check-input custom-control-input" name="status" value="DRAFT">
                                <span class="custom-control-label">DRAFT</span>
                            </label>
                        </div>
					</div>
				</div>
                <!-- </div> -->

                <div class="row mr-1" style="margin-top:1%;display: flex;justify-content: end;">
                    <div class="form-row">
                        <div class="col">
                            <button class="btn btn-primary" type="submit" style="color: #fff !important;background-color: #337ab7 !important;border-color: #2e6da4 !important;">Save</button>
                        </div>
                        <div class="col">
                            <button class="btn btn-danger" style="margin-right:1%;">
                                <a class="text-white" href="<?php echo base_url('Reflections/getUserReflections'); ?>">Close</a>
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
        <!-- end observation code -->
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
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/slick.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/ckeditor5-build-classic/ckeditor.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/dropzone.min.js"></script>
    <script>
    function updImg() {
        $("#uploadImg").click();
    }

    $("#uploadImg").change(function() {
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#blah').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    var id = "<?php echo $id; ?>";
    var childId = "<?php echo $childId; ?>";

    function saveChild() {
        var json = true;
        if ($("input[name=firstname]").val() == '') {
            json = false;
            $('.error_firstname').html('(Please Enter Firstname)');
        } else {
            $('.error_firstname').html('');
        }
        if ($("input[name=lastname]").val() == '') {
            json = false;
            $('.error_lastname').html('(Please Enter Lastname)');
        } else {
            $('.error_lastname').html('');
        }
        if ($("input[name=dob]").val() == '') {
            json = false;
            $('.error_dob').html('(Please Select Date of Birth)');
        } else {
            $('.error_dob').html('');
        }
        if ($("input[name=startDate]").val() == '') {
            json = false;
            $('.error_doj').html('(Please Select Date of Join)');
        } else {
            $('.error_doj').html('');
        }
        if (json) {
            if (childId) {
                var url = "<?php echo base_url('room/editChild'); ?>?id=" + id + "&childId=" + childId;
                var test = url.replace(/&amp;/g, '&');
                document.getElementById("form-child").action = test;
                document.getElementById("form-child").submit();

            } else {
                var url = "<?php echo base_url('room/addChild'); ?>?id=" + id;
                var test = url.replace(/&amp;/g, '&');
                document.getElementById("form-child").action = test;
                document.getElementById("form-child").submit();
            }

        }
    }
    $(document.body).delegate('.viewarea', 'click', function() {
        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
            $('.imgview').html(
                '<img    src="<?php echo base_url('assets/images/icons/DownArrowBule.png'); ?>">');
            $('.moredetails').hide();
        } else {
            $(this).addClass("active");
            $('.imgview').html('<img    src="<?php echo base_url('assets/images/icons/UpArrowBule.png'); ?>">');
            $('.moredetails').show();
        }
    });
    </script>
</body>

</html>

<!-- <php echo base_url('Reflections/getForm?id=' . $room->id); ?> -->

<!-- <php $this->load->view('footer'); ?> -->