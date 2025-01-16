<?php 
    $reflectionid = $_GET['reflectionid'];
    $data['name']='createReflection'; 
    // $this->load->view('header',$data); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reflection Update | Mykronicle</title>
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
    <div class="container-fluid observationListContainer">
<div class="pageHead">
    <h1>Edit Reflection</h1>
</div>
<form action="<?php echo base_url('Reflections/updateReflection?reflectionId='.$reflectionid); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="centerid" value="<?php echo $Reflections->centerid; ?>">

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <label for="">Children</label>
            <select class="js-example-basic-multiple  multiple_selection form-control select2-multiple" name="Children[]" multiple="multiple">
                <?php foreach($Childs as $childs => $objchild) { ?>
                    <option name="<?php echo $objchild->name; ?>" value="<?php echo $objchild->childid; ?>"><?php echo $objchild->name; ?></option>
                <?php }?>
            </select>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <label for="">Educators</label>
            <select id="room_educators" name="Educator[]" class="js-example-basic-multiple  multiple_selection form-control select2-multiple" multiple="multiple">
                <?php foreach($Reflections->staffs as $staff => $objstaff) { ?>
                        <option  value="<?php echo $objstaff->userid; ?>"></option>
                <?php }?>
                <?php foreach($Educators as $educator => $objEducator) { ?>
                        <option name="<?php echo $objEducator->name; ?>" value="<?php echo $objEducator->userid; ?>"><?php echo $objEducator->name; ?></option>
                <?php }?>
            </select>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control title" id="title" value="<?= $Reflections->title ?>">
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <label for="about">Reflection</label>
            <textarea name="about" class="form-control about rounded-1" id="about" rows="10" value="<?= $Reflections->about ?>" placeholder="<?= $Reflections->about ?>"><?= $Reflections->about ?></textarea>
        </div>
    </div>
    <div class="card mb-4 mt-4">
        <div class="card-body">
            <h5 class="mb-4">Upload Single/Multiple Images</h5>
            <div class="d-flex row">
                <input type="file" visbility="hidden" name="media[]" id="fileUpload" class="form-control-hidden col" multiple value="">
                <?php foreach($Reflections->refMedia as $media => $objmedia) {?>
                    <input type="hidden" visbility="hidden" name="media[]" id="fileUpload" class="form-control-hidden col" multiple value="<?php echo $objmedia->mediaUrl; ?>">
                <?php
                        //echo $objmedia->mediaUrl;
                        echo '<img class="card-img mr-2" src="'.BASE_API_URL."assets/media/".$objmedia->mediaUrl.'" alt="No media here" style="width:200px;height:200px;">';
                    }
                ?>
            </div>
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
    <div class="row" style="margin-top:1%;display: flex;justify-content: end;">
        <div class="form-row">
            <div class="col">
                <button class="btn btn-primary" type="submit">UPDATE</button>
            </div>
            <div class="col">
                <a href="<?php echo base_url('Reflections/getUserReflections'); ?>" class="btn btn-danger mr-1">CLOSE</a>
            </div>
        </div>
    </div>
</form>
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
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/slick.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/ckeditor5-build-classic/ckeditor.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/dropzone.min.js"></script>
</body>
</html>