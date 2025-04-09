<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Observation | MyDiaree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2-bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/slick.css">  
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/slick-theme.css">
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css"> 
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        .tag{
            color:  #ffffff;
        }
        .bootstrap-tagsinput{
            border: none!important;
        }
        #img-droppable{
            display: inline-block;
            background: #ffffff;
            border: 1px dashed #d8d8d8;
            padding: 15px;
            min-height: 285px;
            width: 100%;
            margin-bottom:15px;
        }
        label.file-upload-field{
            background: rgb(248,248,248);
            border: 1px dashed var(--grey5);
            align-items: center;
            display: inline-flex;
            justify-content: center;
            max-width: 108px;
            font-size: 14px;
            font-weight: 600;
            flex-direction: column;
            margin: 0;
            height: 100px;
            width: 100px;
            padding: 40px 0px;
            margin-left: 4px;
            cursor: pointer;
        }
        .thumb-image, .thumb-video{
            height: 100px;
            width: 100px;
        }
        .img-preview span.img-remove, a.img-edit {
            text-align: center;
            background: #ffffff;
            border: 1px solid #d7d7d7;
            color: #000000;
            font-weight: 600;
            padding: 5px 9px;
            display: inline-block;
            height: 30px;
            width: 30px;
            border-radius: 50%;
        }
        a.img-edit{
            position: absolute;
            top: 35px;
            right: 2px;
        }
        .img-remove, .vid-remove, .image-remove, .video-remove{
            font-size: 11px;
            background-color: #f5f5f5;
            color: rgb(0 0 0 / 95%);
            height: 20px;
            width: 20px;
            border-radius: 50%;
            position: absolute;
            border: 1px solid #000;
            line-height: 1.4;
            top: 2px;
            right: 2px;
            z-index: 10;
            cursor: pointer;
        }
        .img-preview, .vid-preview{
            position: relative;
            width: 100px;
            float: left;
            overflow-x: hidden;
            margin: 0px 2px;
        }
        .custom-obs-thumbnail{
            width: 115px!important;
        }
        .list-obs-links{
            height: 150px!important;
        }
        .imgBlock{
            position: relative;
        }
        .hover-image:hover{
            box-shadow: 0px 0px 4px 0px #0087ad;
            cursor: pointer;
        }
        .uploaded-media-list{
            position: absolute;
            top: 7px;
            right: 7px;
        }
        .d-flex-custom{
            display: flex;
            align-items: center;
            justify-content: start;
        }
        .d-flex-custom > label {
            margin: 0px 5px;
            font-size: 15px;
        }

        .qip-list-item{
            border-bottom: 1px dotted #d7d7d7;
            padding-bottom: 10px;
            margin-top: 5px;
        }

        .pp-title > label {
            margin: 0px 5px;
        }

        .bg-grey{
            background-color: #F8F8F8!important;
        }

        .modal-slider-image{
            width: 100%!important;
            height: 239px!important;
        }

        .childSpan.child-info-tag{
            display: inline-flex;
            align-items: center;
            background-color: #3E695A;
            color: #ffffff;
            font-weight: 600;
            padding: 1px 10px 1px 1px;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            margin: 5px 2px;
        }
        .childSpan.educator-info-tag{
            display: inline-flex;
            align-items: center;
            background-color: #6E519D;
            color: #ffffff;
            font-weight: 600;
            padding: 1px 10px 1px 1px;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            margin: 5px 2px;
        }
        .thumbMedia{
            display: flex;
            flex-wrap: nowrap;
            overflow-x: hidden;
        }
        .thumbMedia span img {
            height: 50px;
            width: 50px;
            margin: 5px 2px;
            border-radius: 10px;
        }
        .obs-modal-links, .qip-modal-links, .pp-modal-links, .ref-modal-links{
            height: 430px;
        }
        /*.cke_autocomplete_opened{
            top: 400px!important;
        }*/
    </style>

<style>
    .custom-nav .nav-link {
        background-color: #f8f9fa; /* Light background */
        color: #007bff; /* Blue text */
        padding: 10px;
        border: 1px solid #ddd;
        margin-bottom: 5px;
        transition: 0.3s ease-in-out;
        text-align: center;
    }

    .custom-nav .nav-link:hover {
        background-color: #e9ecef; /* Lighter background on hover */
        color: #0056b3; /* Darker blue */
    }

    .custom-nav .nav-link.active {
        background-color: #007bff; /* Active link background */
        color: #fff; /* White text */
        border-color: #0056b3;
        font-weight: bold;
    }

      /* Panel Styling */
      .custom-panel {
        padding: 15px;
        background-color: #f9f9f9;
        border-radius: 8px;
        border: 1px solid #ddd;
        margin-bottom: 10px;
    }

    /* Collapsible Button Styling */
    .custom-panel .btn-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        text-align: left;
        background-color: #007bff;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        transition: 0.3s ease-in-out;
        font-weight: bold;
        text-decoration: none;
    }

    .custom-panel .btn-link:hover {
        background-color: #0056b3;
        text-decoration: none;
    }

    /* Arrow Indicator */
    .custom-panel .btn-link::after {
        content: "\25BC"; /* Down Arrow */
        font-size: 14px;
        transition: 0.3s ease-in-out;
    }

    .custom-panel .btn-link[aria-expanded="true"]::after {
        content: "\25B2"; /* Up Arrow */
    }

    /* Collapsible Content */
    .custom-panel .collapse {
        padding: 10px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-top: 5px;
    }

    .custom-panel .collapse.show {
        background-color: #e9ecef;
    }

      /* Styling for Activity Title */
      .custom-subactivity .activity-title {
        font-weight: bold;
        display:flex;
        align-items:center;
        font-size: 16px;
        margin-bottom: 5px;
        color: #333;
    }

    .activity-title{
        width: 350px;
    }

    /* Box styling */
    .custom-subactivity .subactivity-box {
        padding: 10px;
        border-bottom: 1px solid #ddd; /* Adds lower border for separation */
        display: flex;
        align-items: center;
        gap: 15px; /* Adds space between radio buttons */
    }

    /* Label Styling */
    .custom-subactivity .subactivity-box label {
        display: flex;
        align-items: center;
        font-size: 14px;
        font-weight: 500;
        color: #555;
        cursor: pointer;
    }

    /* Radio Button Styling */
    .custom-subactivity .subactivity-box input[type="radio"] {
        margin-right: 5px;
        accent-color: #007bff; /* Blue color */
        transform: scale(1.2); /* Slightly increase size */
    }

     /* Container for checkbox group */
     .custom-checkbox-group {
        display: flex;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #ddd; /* Adds separation */
        gap: 10px; /* Space between elements */
    }

    /* Custom Checkbox Styling */
    .custom-checkbox-group .custom-control {
        display: flex;
        align-items: center;
        font-size: 14px;
        font-weight: 500;
        color: #333;
        cursor: pointer;
    }

    /* Checkbox Input Styling */
    .custom-checkbox-group .custom-control-input {
        width: 18px;
        height: 18px;
        accent-color: #007bff; /* Bootstrap blue */
        margin-right: 8px;
        transform: scale(1.1); /* Slightly increase size */
    }

    /* Checkbox Label Styling */
    .custom-checkbox-group .custom-control-label {
        cursor: pointer;
    }
</style>



</head>
<body id="app-container" class="menu-default show-spinner">
    <?php 
        $this->load->view('sidebar'); 
        $role = $this->session->userdata('UserType');
        if ($role=="Staff") {
            if (isset($permissions)) {
                if ($permissions->addObservation == 1) {
                   $addObservation = 1;
                } else {
                   $addObservation = 0;
                }

                if ($permissions->updateObservation == 1) {
                   $updateObservation = 1;
                } else {
                   $updateObservation = 0;
                }              
            }else {
                $addObservation = 0;
                $updateObservation = 0;           
            }
        } else {
            $addObservation = 1;
            $updateObservation = 1;        
        }

        //get centerid
        if(isset($_GET['centerid'])){
            $centerid = $_GET['centerid'];
        } else if (isset($observation->centerid)){
            $centerid = $observation->centerid;
        } else {
            $centerid = "";
        }
    ?>
    <main data-centerid="<?= isset($observation->centerid)?$observation->centerid:null; ?>">



    <!-- <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h4>Add Milestone</h4>
                    </div>
                    <div class="card-body">
                        <form id="milestoneForm">
                            <div class="mb-3">
                                <label for="milestoneid" class="form-label">Milestone ID</label>
                                <input type="number" class="form-control" id="milestoneid" value="44" name="milestoneid" required>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        <div id="successMessage" class="alert alert-success mt-3" style="display: none;">
                            Milestone added successfully!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Manage Observation</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Observation/observationList?centerid='.$centerid); ?>">Observation List</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Observation</li>
                        </ol>
                    </nav>
                    <div class="text-zero top-right-button-container">
                        <button class="btn btn-outline-primary btn-lg mr-1" data-toggle="modal" data-backdrop="static" data-target="#modal-preview" id="btn-preview">
                            PREVIEW
                        </button>
                    </div>                    
                    <ul class="nav nav-tabs separator-tabs ml-0 mb-5" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link <?= ($type=='observation')?'active':''; ?>" id="first-tab" data-toggle="tab" href="#first" role="tab" aria-controls="first" aria-selected="<?= ($type=='observation')?'true':'false'; ?>">OBSERVATION</a>
                        </li>
                        <?php if ($_SESSION['UserType'] != 'Parent') { ?>   
                        <li class="nav-item">
                            <a class="nav-link <?= ($type=='assessments')?'active':''; ?>" id="second-tab" data-toggle="tab" href="#second" role="tab" aria-controls="second" aria-selected="<?= ($type=='assessments')?'true':'false'; ?>">ASSESSMENTS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($type=='links')?'active':''; ?>" id="third-tab" data-toggle="tab" href="#third" role="tab" aria-controls="third" aria-selected="<?= ($type=='links')?'true':'false'; ?>">LINKS</a>
                        </li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane <?= ($type=='observation')?'show active':'fade'; ?>" id="first" role="tabpanel" aria-labelledby="first-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                Observation Details
                                            </h5>
                                            <form action="<?= base_url('observation/addNew'); ?>" id="form-observation" method="post" enctype="multipart/form-data">
                                                <?php 
                                                    if (isset($observation)) {
                                                ?>
                                                <input type="hidden" id="obs_author" value="<?= $observation->user_name; ?>">
                                                <?php
                                                    } else {
                                                ?>
                                                <input type="hidden" id="obs_author" value="<?= $_SESSION['Name']; ?>">
                                                <?php 
                                                    }
                                                    
                                                ?>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div id="select-children">
                                                            <button type="button" class="btn btn-outline-primary mb-1" data-toggle="modal" data-backdrop="static" data-target="#selectChildrenModal"> + Add Children </button> &nbsp;<span style="color:red;">* Required</span>
                                                            <div class="bootstrap-tagsinput">
                                                                <?php 
                                                                    if(!empty($observationChildrens)) {
                                                                        foreach($observationChildrens as $observationChildren) {
                                                                            $date1 = new DateTime($observationChildren->dob);
                                                                            $date2 = new DateTime(date('Y-m-d'));
                                                                            $diff = $date1->diff($date2); 
                                                                ?>
                                                                <span class="tag label label-info">
                                                                    <input type="hidden" name="childrens[]" value="<?= $observationChildren->child_id; ?>" data-name="<?= $observationChildren->child_name; ?>"> <?= $observationChildren->child_name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?> <span class="rem" data-role="remove">x</span>
                                                                </span>
                                                                <?php } } ?>
                                                            </div>
                                                        </div> 
                                                        <hr>

                                                        <div id="room">
    <div class="form-group">
        <label>Classroom &nbsp;<span style="color:red">*Required</span></label>
        <select id="room" name="room[]"
                class="popinput js-example-basic-multiple multiple_selection form-control select2-multiple"
                multiple="multiple">
            <?php
            // Convert the comma-separated room IDs into an array
            $selectedRooms = isset($observation->room) ? explode(',', $observation->room) : [];

            // Loop through available rooms and set selected attribute if present in $selectedRooms
            foreach ($roomss as $objRooms) {
                $isSelected = in_array($objRooms['id'], $selectedRooms) ? 'selected' : '';
            ?>
                <option name="<?php echo $objRooms['name']; ?>"
                        value="<?php echo $objRooms['id']; ?>" <?php echo $isSelected; ?>>
                    <?php echo $objRooms['name']; ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>

                                             <hr> 


                                                        <div id="obs-title">
                                                            <div class="form-group required">
                                                                <label class=" control-label" ><strong>Observation Title</strong></label> &nbsp;&nbsp;&nbsp; <button type="button" style="font-size:10px;font-weight:bold;margin-bottom:3px;" class="btn btn-outline-primary refine-btn btn-sm" data-editor="obs_title">Refine Text</button>
                                                                <textarea name="title" id="obs_title" class="form-control" data-sample-short><?php echo isset($observation->title)?$observation->title:''; ?></textarea>
                                                            </div>
                                                           
                                                        </div>

                                                       

                                                        <div id="obs-notes">
                                                            <div class="form-group required">
                                                                <label class="control-label"><strong>Analysis/Evaluation</strong></label>  &nbsp;&nbsp;&nbsp;  <button type="button" style="font-size:10px;font-weight:bold;margin-bottom:3px;" class="btn btn-outline-primary refine-btn btn-sm" data-editor="obs_notes">Refine Text</button>
                                                                <textarea name="notes" style="height: 73px;" id="obs_notes"><?php echo isset($observation->notes)?$observation->notes:''; ?></textarea>
                                                            </div>
                                                            
                                                        </div>

                                                        <div id="obs-reflection">
                                                            <?php if ($_SESSION['UserType'] != 'Parent') { ?>
                                                                <div class="form-group required">
                                                                    <label class=" control-label" ><strong>Reflection</strong></label>  &nbsp;&nbsp;&nbsp;  <button type="button" style="font-size:10px;font-weight:bold;margin-bottom:3px;" class="btn btn-outline-primary refine-btn btn-sm" data-editor="obs_reflection">Refine Text</button>
                                                                    <textarea style="height: 73px;" id="obs_reflection" name="reflection" class="form-control"><?php echo isset($observation->reflection)?$observation->reflection:''; ?></textarea>
                                                                </div>
                                                                
                                                            <?php } ?>
                                                        </div>
                                                        

                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div id="img-droppable">
                                                            <div class="form-group">                     
                                                                <div id="img-holder">
                                                                <?php 
                                                                    if (!empty($observationMedia)) {
                                                                       foreach ($observationMedia as $key => $obsMedia) {
                                                                ?>
                                                                    <div class="img-preview sticky-preview" data-origin="OBSERVED" data-mediaid="<?= $obsMedia->id; ?>" data-key="<?= $obsMedia->id; ?>">
                                                                        <img class="thumb-image" src="<?php echo BASE_API_URL."assets/media/".$obsMedia->mediaUrl;?>">
                                                                        <span id="<?php echo $obsMedia->id; ?>" class="img-remove deleteMedia">X</span>
                                                                        <!-- <a class="img-edit img-real-edit" href="#!" data-imgcount="<?= $key; ?>" data-mediaid="<?= $obsMedia->id; ?>" data-image="<?= BASE_API_URL."assets/media/".$obsMedia->mediaUrl; ?>" data-toggle="modal" data-target="#myModal" data-edit="1" data-mediaorigin="OBSERVED">#</a> -->
                                                                    </div>
                                                                <?php
                                                                       }
                                                                    }
                                                                ?>
                                                                </div>
                                                                <label class="file-upload-field" data-toggle="modal" data-target="#uploadMediaModal" style="border:2px solid cornflowerblue;">
                                                                    <span>+</span><span>Upload</span>
                                                                </label>
                                                                <input type="file" name="obsMedia[]" id="fileUpload" multiple accept="image/*" style="display: none;">
                                                            </div>
                                                        </div>

                                                   
                                                        <div id="child-voice">
                                                            <?php if ($_SESSION['UserType'] != 'Parent') { ?>
                                                                <div class="form-group">
                                                                    <label class=" control-label" ><strong>Child's Voice</strong></label>  &nbsp;&nbsp;&nbsp;  <button type="button" style="font-size:10px;font-weight:bold;margin-bottom:3px;" class="btn btn-outline-primary refine-btn btn-sm" data-editor="child_voice">Refine Text</button>
                                                                    <textarea style="height: 73px;" id="child_voice" name="child_voice" class="form-control"><?php echo isset($observation->child_voice)?$observation->child_voice:''; ?></textarea>
                                                                </div>
                                                               
                                                            <?php } ?>
                                                        </div>
                                                        <div id="Future Plan/Extension">
                                                            <?php if ($_SESSION['UserType'] != 'Parent') { ?>
                                                                <div class="form-group">
                                                                    <label class=" control-label" ><strong>Future Plan/Extension</strong></label>  &nbsp;&nbsp;&nbsp;  <button type="button" style="font-size:10px;font-weight:bold;margin-bottom:3px;" class="btn btn-outline-primary refine-btn btn-sm" data-editor="future_plan">Refine Text</button>
                                                                    <textarea style="height: 73px;" id="future_plan" name="future_plan" class="form-control"><?php echo isset($observation->future_plan)?$observation->future_plan:''; ?></textarea>
                                                                </div>
                                                               
                                                            <?php } ?>
                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 text-right">
                                                        <a href="<?= base_url('observation/ObservationList'); ?>" class="btn btn-danger">Cancel</a>
                                                        <?php
                                                            if ($role == 'Parent') {
                                                                if(empty($id)) {
                                                       ?>
                                                       <button type="button" onclick="saveObservation();" class="btn btn-primary">Publish</button>
                                                       <!-- <button type="button" onclick="draftObservation();" class="btn btn-primary">Draft</button> -->
                                                       <?php }else{ ?>
                                                       <button type="button" onclick="editObservation();"  class="btn btn-primary">Update</button>
                                                       <?php
                                                                }
                                                            }else{                  
                                                                if(empty($id)) {
                                                                    if ($addObservation==1) {
                                                       ?>
                                                       <button type="button" onclick="saveObservation();" class="btn btn-primary">Save & Next</button>
                                                       <?php
                                                            }
                                                        }else{
                                                            if ($updateObservation==1) {
                                                       ?>
                                                       <button type="button" onclick="editObservation();"  class="btn btn-primary">Update</button>
                                                       <a href="<?= base_url('observation/addNew').'?type=assessments&sub_type=Montessori&id='.$_GET['id']; ?>" class="btn btn-outline-primary">Skip <i class="simple-icon-control-end"></i></a>
                                                       <?php
                                                                    }
                                                                }
                                                            }
                                                       ?>
                                                   </div>
                                                </div>  
                                            </form>                                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                            if ($role != 'Parent') { 

                                if (isset($assessments)) {
                                   if ( isset($assessments->montessori)&&$assessments->montessori == 1) {
                                      $mon = 1;
                                   }else{
                                      $mon = 0;
                                   }

                                   if ( isset($assessments->eylf)&&$assessments->eylf == 1) {
                                      $eylf = 1;
                                   }else{
                                      $eylf = 0;
                                   }

                                   if ( isset($assessments->devmile)&&$assessments->devmile == 1) {
                                      $devmile = 1;
                                   }else{
                                      $devmile = 0;
                                   }
                                }else{
                                   $mon = 0;
                                   $eylf = 0;
                                   $devmile = 0;
                                }

                         ?>
                        <div class="tab-pane <?= ($type=='assessments')?'show active':'fade'; ?>" id="second" role="tabpanel" aria-labelledby="second-tab">
                            <?php if ($mon == 1 || $eylf == 1 || $devmile == 1) { ?>
                            <div class="row">
                                <div class="col-12">
                                    <ul class="nav nav-tabs separator-tabs ml-0 mb-5" role="tablist">
                                        <?php if ($mon == 1) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?php if($sub_type=='Montessori'){ echo 'active'; } ?>" id="montes-tab" data-toggle="tab" href="#montes" role="tab" aria-controls="first" aria-selected="<?= ($sub_type=='Montessori')?'true':'false'; ?>">MONTESSORI</a>
                                        </li> 
                                        <?php } ?>
                                        <?php if ($eylf == 1) { ?> 
                                        <li class="nav-item">
                                            <a class="nav-link <?php if($sub_type=='EYLF'){ echo 'active'; } ?>" id="eylf-tab" data-toggle="tab" href="#eylf" role="tab" aria-controls="eylf" aria-selected="<?= ($sub_type=='EYLF')?'true':'false'; ?>">EYLF</a>
                                        </li>
                                        <?php } ?>
                                        <?php if ($devmile == 1) { ?>  
                                        <li class="nav-item">
                                            <a class="nav-link <?php if($sub_type=='Milestones'){ echo 'active'; } ?>" id="devmile-tab" data-toggle="tab" href="#devmile" role="tab" aria-controls="devmile" aria-selected="<?= ($sub_type=='Milestones')?'true':'false'; ?>">DEVELOPMENTAL MILESTONE</a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                    
                                    <div class="tab-content">
                                        <div class="tab-pane <?= ($sub_type=='Montessori')?'show active':'fade'; ?>" id="montes" role="tabpanel" aria-labelledby="montes-tab">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                <div style="display: flex; justify-content: space-between; align-items: center;">
    <h5 class="card-title">Montessori</h5>
    <div>
    <button class="btn btn-outline-primary" id="addActivityBtn">Add Activity</button>&nbsp;
        <button class="btn btn-outline-primary" id="addSubActivityBtn">Add Sub-Activity</button>
    </div>
</div>
                                                    <form action="" method="post" enctype="multipart/form-data" id="form-montessori" class="form-horizontal">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                            <nav class="nav flex-column custom-nav">
    <?php 
        $i=1; 
        foreach($mon_subjects as $mon_subject) { 
            $name = str_replace(" ","",$mon_subject->name);
            if($i==1){
                $actv = "nav-link active";
                $asel = "true";
            }else{
                $actv = "nav-link";
                $asel = "false";
            }
    ?>
    <a class="<?= $actv; ?>" id="<?= 'nav-'.$name.'-tab'; ?>" data-toggle="tab" data-target="<?= '#'.$name; ?>" type="button" role="tab" aria-controls="<?= 'nav-'.$name; ?>" aria-selected="<?= $asel; ?>"><?= $mon_subject->name; ?></a>
    <?php 
            $i++; 
        } 
    ?>
</nav>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="tab-content" id="nav-tabContent">
                                                                    <?php 
                                                                        $i=1; 
                                                                        foreach($mon_subjects as $mon_subject) { 
                                                                            $name = str_replace(" ","",$mon_subject->name);
                                                                            if($i==1){
                                                                                $actv = "tab-pane fade show active";
                                                                                $asel = "true";
                                                                            }else{
                                                                                $actv = "tab-pane fade";
                                                                                $asel = "false";
                                                                            }
                                                                    ?>


                                                                    <div class="custom-panel <?= $actv; ?>" id="<?= $name; ?>" role="tabpanel" aria-labelledby="<?= 'nav-'.$name.'-tab'; ?>">
                                                                        <div class="pull-left" id="<?= 'accord-'.$name; ?>">

                                                                            <?php  
                                                                                $j = 1;
                                                                                if(!empty($mon_activites[$mon_subject->idSubject])) {
                                                                                    foreach($mon_activites[$mon_subject->idSubject] as $key1=>$mon_activity) { 
                                                                                        $target = 'collapse-'.$mon_activity->idActivity;
                                                                                        if($j==1){
                                                                                            $expanded = "true";
                                                                                            $collapse = "collapse show";
                                                                                        }else{
                                                                                            $expanded = "";
                                                                                            $collapse = "collapse";
                                                                                        }
                                                                                        $j++;
                                                                            ?>
                                                                            <div class="border">
                                                                                <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#<?= $target; ?>" aria-expanded="<?= $expanded; ?>" aria-controls="<?= $target; ?>">
                                                                                    <?= ucwords(strtolower($mon_activity->title)); ?>
                                                                                </button>


                                                                                <div id="<?= $target; ?>" class="<?= $collapse; ?>" data-parent="#<?= 'accord-'.$name; ?>">
                                                                                    <?php 
                                                                                    if(!empty($mon_sub_activites[$mon_activity->idActivity])) {
                                                                                        foreach($mon_sub_activites[$mon_activity->idActivity] as $key2 => $mon_sub_activity) { 
                                                                                    ?>
                                                                                    <div class="activity-box custom-subactivity d-flex justify-content-between px-3">

                                                                                    <div class="activity-title"><?= $mon_sub_activity->title; ?></div>
    <div class="subactivity-box">
        <label>
            <input type="radio" class="mon-sub" id="<?= $mon_sub_activity->idSubActivity; ?>montessoriNotAssessed" 
                name="montessori[<?= $mon_sub_activity->idSubActivity; ?>]" value="Not Assessed" 
                data-subactid="<?= $mon_sub_activity->idSubActivity; ?>">
            Not Assessed
        </label>
        
        <label>
            <input type="radio" class="mon-sub" id="<?= $mon_sub_activity->idSubActivity; ?>montessoriIntroduced" 
                name="montessori[<?= $mon_sub_activity->idSubActivity; ?>]" value="Introduced" 
                data-subactid="<?= $mon_sub_activity->idSubActivity; ?>">
            Introduced
        </label>

        <label>
            <input type="radio" class="mon-sub" id="<?= $mon_sub_activity->idSubActivity; ?>montessoriWorking" 
                name="montessori[<?= $mon_sub_activity->idSubActivity; ?>]" value="Working" 
                data-subactid="<?= $mon_sub_activity->idSubActivity; ?>">
            Working
        </label>

        <label>
            <input type="radio" class="mon-sub" id="<?= $mon_sub_activity->idSubActivity; ?>montessoriCompleted" 
                name="montessori[<?= $mon_sub_activity->idSubActivity; ?>]" value="Completed" 
                data-subactid="<?= $mon_sub_activity->idSubActivity; ?>">
            Completed
        </label>
                     <?php 
                                                                                            if (!empty($obsMontessori)) {
                                                                                              foreach ($obsMontessori as $key => $obsMon) {
                                                                                                 if ($obsMon->idSubActivity==$mon_sub_activity->idSubActivity) {

                                                                                                       ?>
                                                                                                       <script type="text/javascript">
                                                                                                          var _assesment = "<?= $obsMon->assesment;?>";
                                                                                                          var _id = "<?php echo $mon_sub_activity->idSubActivity;?>";
                                                                                                          if(_assesment == "Not Assessed"){
                                                                                                            document.getElementById(`${_id}montessoriNotAssessed`).checked = true;
                                                                                                            document.getElementById(`${_id}montessoriNotAssessed`).setAttribute('checked',
                                                                                                                'checked');
                                                                                                          }
                                                                                                          else if(_assesment == "Introduced"){
                                                                                                            document.getElementById(`${_id}montessoriIntroduced`).checked = true;
                                                                                                            document.getElementById(`${_id}montessoriIntroduced`).setAttribute('checked',
                                                                                                                'checked');
                                                                                                          }
                                                                                                          else if(_assesment == "Working"){
                                                                                                            document.getElementById(`${_id}montessoriWorking`).checked = true;
                                                                                                            document.getElementById(`${_id}montessoriWorking`).setAttribute('checked',
                                                                                                                'checked');
                                                                                                          }
                                                                                                          else if(_assesment == "Completed"){
                                                                                                            document.getElementById(`${_id}montessoriCompleted`).checked = true;
                                                                                                            document.getElementById(`${_id}montessoriCompleted`).setAttribute('checked',
                                                                                                                'checked');
                                                                                                          }
                                                                                                       </script>
                                                                                                    <?php }
                                                                                                 }
                                                                                              }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row" style="margin-bottom: 15px;">
                                                                                        <?php if(!empty($mon_extras[$mon_sub_activity->idSubActivity])) {
                                                                                           echo "<div class='col-sm-12'><strong><i>Extras</i></strong></div>";
                                                                                           foreach($mon_extras[$mon_sub_activity->idSubActivity] as $key2=>$mon_extra) {
                                                                                              if (!empty($obsMontessori)) {
                                                                                                 $var = true;
                                                                                                 foreach($obsMontessori as $obs => $ob){
                                                                                                    if ($mon_sub_activity->idSubActivity==$ob->idSubActivity) {
                                                                                                       foreach($ob->idExtra as $extra => $obExtra){
                                                                                                          if ($mon_extra->idExtra==$obExtra) {
                                                                                                             $var = false;
                                                                                        ?>
                                                                                        <div class="col-md-12">
                                                                                           <input type="checkbox" class="extras" name="extras[<?php echo $mon_sub_activity->idSubActivity; ?>][]" value="<?php echo $mon_extra->idExtra; ?>" checked>&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo $mon_extra->title; ?></label>
                                                                                        </div>
                                                                                        <?php
                                                                                                          }
                                                                                                       }
                                                                                                    }
                                                                                                 }
                                                                                                 if ($var == true) {
                                                                                        ?>
                                                                                        <div class="col-md-12">
                                                                                           <input type="checkbox" class="extras" name="extras[<?php echo $mon_sub_activity->idSubActivity; ?>][]" value="<?php echo $mon_extra->idExtra; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo $mon_extra->title; ?></label>
                                                                                        </div>
                                                                                        <?php
                                                                                                 }
                                                                                              } else {
                                                                                        ?>
                                                                                        <div class="col-md-12">
                                                                                           <input type="checkbox" name="extras[<?php echo $mon_sub_activity->idSubActivity; ?>][]" value="<?php echo $mon_extra->idExtra; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo $mon_extra->title; ?></label>
                                                                                        </div>
                                                                                        <?php
                                                                                              }
                                                                                           }

                                                                                        }
                                                                                        ?>
                                                                                     </div>
                                                                                     <?php } } ?>
                                                                                </div>
                                                                            </div>
                                                                            <?php } } ?>
                                                                        </div>
                                                                    </div>
                                                                    <?php 
                                                                            $i++; 
                                                                        } 
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php if($id) { ?>
                                                            <div class="row">
                                                                <div class="col-12 text-right mt-4">
                                                                   <a href="<?php echo base_url('observation/addNew?type=observation&id='.$id); ?>" class="btn btn-danger">Cancel</a>
                                                                   <button type="button" onclick="saveMontessori();" class="btn btn-primary">Save</button>
                                                                   <a href="<?= base_url('observation/addNew').'?type=assessments&sub_type=EYLF&id='.$_GET['id']; ?>" class="btn btn-outline-primary">Skip <i class="simple-icon-control-end"></i></a>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane <?= ($sub_type=='EYLF')?'show active':'fade'; ?>" id="eylf" role="tabpanel" aria-labelledby="eylf-tab">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">EYLF</h5>
                                                    <form action="" method="post" enctype="multipart/form-data" id="form-eylf" class="form-horizontal">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <nav class="nav flex-column custom-nav">
                                                                    <?php 
                                                                        $i=1; 
                                                                        foreach($eylf_outcomes as $eylf_outcome) { 
                                                                            $name = str_replace(" ","",$eylf_outcome->title);
                                                                            if($i==1){
                                                                                $actv = "nav-link active";
                                                                                $asel = "true";
                                                                            }else{
                                                                                $actv = "nav-link";
                                                                                $asel = "false";
                                                                            }
                                                                    ?>
                                                                    <a class="<?= $actv; ?>" id="<?= 'nav-'.$name.'-tab'; ?>" data-toggle="tab" data-target="<?= '#'.$name; ?>" type="button" role="tab" aria-controls="<?= 'nav-'.$name; ?>" aria-selected="<?= $asel; ?>"><?= $eylf_outcome->title; ?></a>
                                                                    <?php 
                                                                            $i++; 
                                                                        } 
                                                                    ?>
                                                                </nav>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="tab-content" id="nav-tabContent">
                                                                    <?php 
                                                                        $i=1; 
                                                                        foreach($eylf_outcomes as $eylf_outcome) { 
                                                                            $name = str_replace(" ","",$eylf_outcome->title);
                                                                            if($i==1){
                                                                                $actv = "tab-pane fade show active";
                                                                                $asel = "true";
                                                                            }else{
                                                                                $actv = "tab-pane fade";
                                                                                $asel = "false";
                                                                            }
                                                                    ?>
                                                                    <div class="custom-panel <?= $actv; ?>" id="<?= $name; ?>" role="tabpanel" aria-labelledby="<?= 'nav-'.$name.'-tab'; ?>">
                                                                        <div class="pull-left" id="<?= 'accord-'.$name; ?>">

                                                                            <?php  
                                                                                $j = 1;
                                                                                if(!empty($eylf_activites[$eylf_outcome->id])){
                                                                                    foreach($eylf_activites[$eylf_outcome->id] as $key1=>$eylf_activity) { 
                                                                                        $target = 'collapse-'.$eylf_activity->id;
                                                                                        if($j==1){
                                                                                            $expanded = "true";
                                                                                            $collapse = "collapse show";
                                                                                        }else{
                                                                                            $expanded = "";
                                                                                            $collapse = "collapse";
                                                                                        }
                                                                                        $j++;
                                                                            ?>
                                                                            <div class="border">
                                                                                <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#<?= $target; ?>" aria-expanded="<?= $expanded; ?>" aria-controls="<?= $target; ?>">
                                                                                     <?= ucwords(strtolower($eylf_activity->title)); ?>
                                                                                </button>
                                                                                <div id="<?= $target; ?>" class="<?= $collapse; ?> p-4" data-parent="#<?= 'accord-'.$name; ?>">
                                                                                    <?php 
                                                                                    if(!empty($eylf_sub_activites[$eylf_activity->id])) {
                                                                                       foreach($eylf_sub_activites[$eylf_activity->id] as $key2=>$eylf_sub_activity){
                                                                                    ?>
                                                                                  <div class="custom-checkbox-group d-flex">
    <div class="custom-control custom-checkbox mb-2">
        <input type="checkbox" class="custom-control-input eylfsubactivity" 
               name="eylf[<?= $eylf_activity->id; ?>][]" 
               id="<?= "cb-".$eylf_sub_activity->id; ?>" 
               value="<?= $eylf_sub_activity->id; ?>" 
               data-eylfsubactvt="<?= $eylf_sub_activity->id; ?>" 
               <?php if(!empty($observationEylf[$eylf_activity->id][$eylf_sub_activity->id])) { ?>checked<?php } ?>>
        <label class="custom-control-label" for="<?= "cb-".$eylf_sub_activity->id; ?>">
            <?= $eylf_sub_activity->title; ?>
        </label>
    </div>
</div>
                                                                                    <?php } } ?>
                                                                                </div>
                                                                            </div>
                                                                            <?php } } ?>
                                                                        </div>
                                                                    </div>
                                                                    <?php 
                                                                            $i++; 
                                                                        } 
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php if(!empty($id)) { ?>
                                                           <div class="row">
                                                                <div class="col-12 text-right mt-4">
                                                                    <a href="<?php echo base_url('observation/addNew?type=observation&sub_type=Montessori&id='.$id); ?>" class="btn btn-danger">Cancel</a>
                                                                    <button type="button" onclick="saveEylf();"  class="btn btn-primary">Save</button>
                                                                    <a href="<?= base_url('observation/addNew').'?type=assessments&sub_type=Milestones&id='.$_GET['id']; ?>" class="btn btn-outline-primary">Skip <i class="simple-icon-control-end"></i></a>
                                                                </div>
                                                           </div>
                                                        <?php } ?>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane <?= ($sub_type=='Milestones')?'show active':'fade'; ?>" id="devmile" role="tabpanel" aria-labelledby="devmile-tab">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <h5 class="card-title">Developmental Milestone</h5>
                                                    <form action="" method="post" enctype="multipart/form-data" id="form-milestones" class="form-horizontal">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <nav class="nav flex-column custom-nav">
                                                                    <?php 
                                                                        $i=1; 
                                                                        foreach($milestones as $milestone) { 
                                                                            $name = str_replace(" ","",$milestone->ageGroup);
                                                                            if($i==1){
                                                                                $actv = "nav-link active";
                                                                                $asel = "true";
                                                                            }else{
                                                                                $actv = "nav-link";
                                                                                $asel = "false";
                                                                            }
                                                                    ?>
                                                                    <a class="<?= $actv; ?>" id="<?= 'nav-'.$name.'-tab'; ?>" data-toggle="tab" data-target="<?= '#dm'.$name; ?>" type="button" role="tab" aria-controls="<?= 'nav-'.$name; ?>" aria-selected="<?= $asel; ?>"><?= $milestone->ageGroup; ?></a>
                                                                    <?php 
                                                                            $i++; 
                                                                        } 
                                                                    ?>
                                                                </nav>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="tab-content" id="nav-tabContent">
                                                                    <?php 
                                                                        $i=1; 
                                                                        foreach($milestones as $milestone) { 
                                                                            $name = str_replace(" ","",$milestone->ageGroup);
                                                                            if($i==1){
                                                                                $actv = "tab-pane fade show active";
                                                                                $asel = "true";
                                                                            }else{
                                                                                $actv = "tab-pane fade";
                                                                                $asel = "false";
                                                                            }
                                                                    ?>
                                                                    <div class="custom-panel <?= $actv; ?>" id="dm<?= $name; ?>" role="tabpanel" aria-labelledby="<?= 'nav-'.$name.'-tab'; ?>">
                                                                        <div class="pull-left" id="<?= 'accord-'.$name; ?>">
                                                                            <?php  
                                                                                $j = 1;
                                                                                if(!empty($dev_activites[$milestone->id])) {
                                                                                    foreach($dev_activites[$milestone->id] as $key1=>$dev_activity) { 
                                                                                        $target = 'collapse-'.$dev_activity->name;
                                                                                        if($j==1){
                                                                                            $expanded = "true";
                                                                                            $collapse = "collapse show";
                                                                                        }else{
                                                                                            $expanded = "";
                                                                                            $collapse = "collapse";
                                                                                        }
                                                                                        $j++;
                                                                            ?>
                                                                            <div class="border">
                                                                                <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#<?= $target; ?>" aria-expanded="<?= $expanded; ?>" aria-controls="<?= $target; ?>">
                                                                                    <?= ucwords(strtolower($dev_activity->name)); ?>
                                                                                </button>
                                                                                <div id="<?= $target; ?>" class="<?= $collapse; ?> p-4" data-parent="#<?= 'accord-'.$name; ?>">
                                                                                    <?php 
                                                                                    if(!empty($dev_sub_activites[$dev_activity->id])) {
                                                                                        foreach($dev_sub_activites[$dev_activity->id] as $key2=>$dev_sub_activity) {  
                                                                                    ?>
                                                                                    <div class="sub-act-row mb-2">
                                                                                        <div class="main-row d-flex justify-content-between">
                                                                                            <div class="left-col divtable">
                                                                                               <?php echo $dev_sub_activity->name; ?>
                                                                                            </div>
                                                                                            <div class="right-col divtable">
                                                                                            <select name="milestones[<?php echo $dev_sub_activity->id; ?>]" class="form-control devmilesub" data-devsubactid="<?php echo $dev_sub_activity->id; ?>">
    <?php 
    // Define the available options
    $options = ["Introduced", "Working towards", "Achieved"];

    // Initialize the selected value as empty
    $selectedValue = "";

    // Check if there's a matching record in $obsMilestones
    if (!empty($obsMilestones)) {
        foreach ($obsMilestones as $obsDev) {
            if ($obsDev->devMilestoneId == $dev_sub_activity->id) {
                $selectedValue = $obsDev->assessment;
                break; // Exit loop after the first match
            }
        }
    }

    // Default "Select Option"
    echo '<option value="">--Select Option--</option>';

    // Loop through each option and mark the selected one
    foreach ($options as $option) {
        $selected = ($option == $selectedValue) ? 'selected' : '';
        echo "<option value='$option' $selected>$option</option>";
    }
    ?>
</select>



                                                                                        <!-- <select name="milestones[<?php echo $dev_sub_activity->id; ?>]" class="form-control devmilesub" data-devsubactid="<?php echo $dev_sub_activity->id; ?>">
                                                                                                  <?php 
                                                                                                     if (!empty($obsMilestones)) {
                                                                                                        foreach ($obsMilestones as $key => $obsDev) {
                                                                                                           if ($obsDev->devMilestoneId==$dev_sub_activity->id) {
                                                                                                              if ($obsDev->assessment=="Introduced") {
                                                                                                  ?>
                                                                                                  <option value="Introduced" selected>Introduced</option>
                                                                                                  <option value="Working towards">Working towards</option>
                                                                                                  <option value="Achieved">Achieved</option>
                                                                                                  <?php
                                                                                                              } else if($obsDev->assessment=="Working towards"){
                                                                                                  ?>
                                                                                                  <option value="Introduced">Introduced</option>
                                                                                                  <option value="Working towards" selected>Working towards</option>
                                                                                                  <option value="Achieved">Achieved</option>
                                                                                                  <?php 
                                                                                                              }else if($obsDev->assessment=="Achieved"){
                                                                                                  ?>
                                                                                                  <option value="Introduced">Introduced</option>
                                                                                                  <option value="Working towards">Working towards</option>
                                                                                                  <option value="Achieved" selected>Achieved</option>
                                                                                                  <?php
                                                                                                              }else{
                                                                                                  ?>
                                                                                                  <option value="">--Select Option--</option>
                                                                                                  <option value="Introduced">Introduced</option>
                                                                                                  <option value="Working towards">Working towards</option>
                                                                                                  <option value="Achieved">Achieved</option>
                                                                                                  <?php
                                                                                                              }
                                                                                                           }
                                                                                                        }  
                                                                                                     }else{
                                                                                                  ?>
                                                                                                  <option value="">--Select Option--</option>
                                                                                                  <option value="Introduced">Introduced</option>
                                                                                                  <option value="Working towards">Working towards</option>
                                                                                                  <option value="Achieved">Achieved</option>
                                                                                                  <?php   } ?>
                                                                                                </select> -->


                                                                                            </div>
                                                                                        </div>
                                                                                        <?php  
                                                                                            if(!empty($dev_extras[$dev_sub_activity->id])) {
                                                                                        ?>
                                                                                        <div class="sub-row">
                                                                                           <div class="main-sub-row">
                                                                                              <div><strong>Extras</strong></div>
                                                                                              <?php
                                                                                                 foreach($dev_extras[$dev_sub_activity->id] as $key2=>$dev_extra) {
                                                                                                    if(!empty($obsMilestones)){
                                                                                                       $var = true;
                                                                                                       foreach($obsMilestones as $obs => $ob){
                                                                                                          if ($ob->devMilestoneId==$dev_sub_activity->id) {
                                                                                                             foreach($ob->idExtras as $extra => $obExtra){
                                                                                                                if ($dev_extra->id==$obExtra) {
                                                                                                                   $var = false;
                                                                                                                   ?>
                                                                                                                   <div class="col-md-12">
                                                                                                                      <input type="checkbox" class="devextras" name="extras[<?php echo $dev_sub_activity->id; ?>][]" value="<?php echo $dev_extra->id; ?>" checked>&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo $dev_extra->title; ?></label>
                                                                                                                   </div>
                                                                                                                   <?php
                                                                                                                }
                                                                                                             }
                                                                                                          }
                                                                                                       }
                                                                                                       if ($var == true) {
                                                                                                          ?>
                                                                                                          <div class="col-md-12">
                                                                                                             <input type="checkbox" class="devextras" name="extras[<?php echo $dev_sub_activity->id; ?>][]" value="<?php echo $dev_extra->id; ?>" >&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo $dev_extra->title; ?></label>
                                                                                                          </div>
                                                                                                          <?php
                                                                                                       }
                                                                                                    }else{
                                                                                                       ?>
                                                                                                       <div class="col-md-12">
                                                                                                          <input type="checkbox" class="devextras" name="extras[<?php echo $dev_sub_activity->id; ?>][]" value="<?php echo $dev_extra->id; ?>" >&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo $dev_extra->title; ?></label>
                                                                                                       </div>
                                                                                                       <?php
                                                                                                    }
                                                                                                 }
                                                                                              ?>
                                                                                           </div>
                                                                                        </div>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                    <?php } } ?>
                                                                                </div>
                                                                            </div>
                                                                            <?php } } ?>
                                                                        </div>
                                                                    </div>
                                                                    <?php 
                                                                            $i++; 
                                                                        } 
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php if($id) { ?>
                                                        <div class="row">
                                                            <div class="col-12 text-right mt-2">
                                                                <a href="<?php echo base_url('observation/addNew?type=observation&sub_type=EYLF&id='.$id); ?>" class="btn btn-danger">Cancel</a>
                                                                <button type="button" onclick="saveMilestones();"  class="btn btn-primary">Save</button>
                                                                <a href="<?= base_url('observation/addNew').'?type=links&id='.$_GET['id']; ?>" class="btn btn-outline-primary">Skip <i class="simple-icon-control-end"></i></a>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } else { ?>
                            <div class="text-center">
                                Assessment record for this center doesn't exists in the table!
                            </div>
                            <?php } ?>
                            
                        </div>
                        <div class="tab-pane <?= ($type=='links')?'show active':'fade'; ?>" id="third" role="tabpanel" aria-labelledby="third-tab">
                            <div class="row mb-5">
                                <div class="col-12">
                                    <div class="d-flex justify-content-start">
                                        <button type="button" class="btn btn-primary mx-2" data-toggle="modal" data-target="#modal-linkobs">
                                           + Link Observation
                                        </button>
                                        <button type="button" class="btn btn-success mx-2" data-toggle="modal" data-target="#modal-linkref">
                                           + Link Reflection
                                        </button>
                                        <button type="button" class="btn btn-info mx-2" data-toggle="modal" data-target="#modal-linkqip">
                                           + Link QIP
                                        </button>
                                        <button type="button" class="btn btn-warning mx-2" data-toggle="modal" data-target="#modal-linkprogplan">
                                           + Link Program Plan
                                        </button>
                                    </div>

                                    <!-- Link Observation Modal -->

                                    <form method="post" id="form-link">
                                        <input type="hidden" name="linkType" value="OBSERVATION">
                                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="modal-linkobs" aria-labelledby="myLargeModalLabel">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">Link Observation</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body obs-modal-links">
                                                        <?php 
                                                            if(isset($obsPublished)){ 
                                                                foreach($obsPublished as $link) {
                                                                    $obsId = $link->id;
                                                        ?>
                                                        <div class="col-12">
                                                            <div class="d-flex flex-row mb-3 bg-white">
                                                                <div class="p-4">
                                                                    <input type="checkbox" name="obsLinks[]" value="<?php echo $link->id; ?>">
                                                                </div>
                                                              
                                                                <a class="d-block position-relative" href="<?= base_url('observation/view?id='.$obsId); ?>">
                                                                    <?php if(empty($link->observationsMedia)) { ?>
                                                                        <img src="https://via.placeholder.com/320x240?text=No+Media" alt="No Media" class="list-thumbnail border-0 custom-obs-thumbnail">
                                                                    <?php 
                                                                        } else { 
                                                                            if($link->observationsMediaType=='Image') {
                                                                    ?>
                                                                        <img src="<?= base_url('/api/assets/media/'.$link->observationsMedia); ?>" alt="Image" class="list-thumbnail border-0 custom-obs-thumbnail">
                                                                    <?php
                                                                            } else if($link->observationsMediaType=='Video') {
                                                                    ?>
                                                                    <img src="<?= base_url('/api/assets/media/video-thumb.jpg'); ?>" alt="video" class="list-thumbnail border-0 custom-obs-thumbnail">
                                                                    <?php
                                                                            }
                                                                        }
                                                                    ?>
                                                                    <?php if($link->status=='Published'){ ?>
                                                                    <span class="badge badge-pill position-absolute badge-top-right badge-success">PUBLISHED</span>
                                                                    <?php }else{ ?>
                                                                    <span class="badge badge-pill position-absolute badge-top-right badge-danger">DRAFT</span>
                                                                    <?php } ?>
                                                                </a>
                                                                <div class="pl-3 pt-2 pr-2 pb-2">
                                                                    <a href="<?= base_url('observation/view?id='.$obsId); ?>" class="obs-link">
                                                                        <p class="list-item-heading">
                                                                            <?= substr_replace(strip_tags(html_entity_decode($link->title)),'...',40); ?>
                                                                        </p>
                                                                        <div class="pr-4 d-none d-sm-block">
                                                                            <p class="text-muted mb-1 text-small">
                                                                                By: <?= $link->user_name; ?>
                                                                            </p>
                                                                        </div>
                                                                        <div class="text-primary text-small font-weight-medium d-none d-sm-block">
                                                                            <?= date("d.m.Y",strtotime($link->date_added)); ?>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        <?php } } ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                                        <button type="button" onclick="createLinks();" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>




                                    <!-- Link Observation Modal End-->

                                    <!-- Link Reflection Modal -->
                                    <form method="post" id="form-link-ref">
                                        <input type="hidden" name="linkType" value="REFLECTION">
                                        <!-- Link Reflection Modal -->
                                        <div class="modal fade" id="modal-linkref" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">Link Reflection</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                           <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body ref-modal-links">
                                                        <div class="row">
                                                            <?php 
                                                                if(isset($refPublished)){ 
                                                                    foreach($refPublished as $ref) {  
                                                            ?>
                                                            <div class="col-md-12">
                                                                <div class="d-flex flex-row mb-3 bg-white justify-content-between">
                                                                    <div class="py-4">
                                                                        <input type="checkbox" name="obsLinks[]" value="<?php echo $ref->id; ?>">
                                                                    </div>
                                                                    <div>
                                                                        <?= ucwords(strtolower($ref->title)); ?>
                                                                        <div class="ref-status">
                                                                            <?= "Created By: " . ucwords(strtolower($ref->name)); ?>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <div class="badge badge-success"><?= $ref->status; ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php } } ?>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                       <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                                       <button type="button" class="btn btn-primary" onclick="saveReflection();">Save changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Link Reflection Modal end -->
                                    </form>
                                    <!-- Link Reflection Modal End-->

                                    <!-- Link QIP Modal -->
                                    <form method="post" id="form-link-qip">
                                        <input type="hidden" name="linkType" value="QIP">
                                        <!-- Link qip Modal -->
                                        <div class="modal fade" id="modal-linkqip" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">Link QIP</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body qip-modal-links">
                                                        <div class="row">
                                                           <?php 
                                                           if (empty($qipPublished)) {
                                                           ?>
                                                              <h3>QIP is not available!</h3>
                                                           <?php
                                                            } else{
                                                              foreach($qipPublished as $qipArr => $qipObj) {  
                                                           
                                                           ?>
                                                           <div class="col-md-12 modal-qip-box mb-2">
                                                                <div class="d-flex-custom qip-list-item">
                                                                    <input type="checkbox" name="obsLinks[]" id="list-<?= $qipObj->id; ?>" value="<?= $qipObj->id; ?>">
                                                                    <label for="list-<?= $qipObj->id; ?>"><?= $qipObj->name; ?></label>
                                                                </div>
                                                           </div>
                                                           <?php 
                                                                 }
                                                              }
                                                           ?>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                       <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                       <button type="button" class="btn btn-danger" onclick="saveQip();">Save changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Link qip Modal end -->
                                    </form>
                                    <!-- Link QIP Modal End -->

                                    <!-- Link Program Plan Modal -->
                                    <form method="post" id="form-link-pp">
                                        <input type="hidden" name="linkType" value="PROGRAMPLAN">
                                        <!-- Link Reflection Modal -->
                                        <div class="modal fade" id="modal-linkprogplan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                           <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">Link Program Plan</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body pp-modal-links">
                                                        <div class="row">
                                                            <?php  
                                                            if(isset($progPlanPublished)){
                                                                foreach($progPlanPublished as $ppArr => $ppObj) {  
                                                            ?>
                                                            <div class="col-md-12 d-flex-custom qip-list-item">
                                                                <div class="pp-checkbox">
                                                                    <input type="checkbox" name="obsLinks[]" id="proplan<?= $ppObj->id; ?>" value="<?= $ppObj->id; ?>">
                                                                </div>
                                                                <div class="pp-title">
                                                                    <label for="proplan<?= $ppObj->id; ?>"><?= date('d-m-Y',strtotime($ppObj->startdate))."/".date('d-m-Y',strtotime($ppObj->enddate)); ?></label>
                                                                </div>
                                                            </div>
                                                            <?php
                                                                }
                                                            }
                                                           ?>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                       <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                       <button type="button" class="btn btn-primary" onclick="saveProplan();">Save changes</button>
                                                    </div>
                                              </div>
                                           </div>
                                        </div>
                                        <!-- Link Reflection Modal end -->
                                    </form>
                                    <!-- Link Program Plan Modal End -->
                                </div>
                            </div>
                            <div class="row">
                                <?php if (empty($links)) { ?>
                                    <div class="col-12">
                                        <div class="text-center">
                                            <i class="simple-icon-question my-3" style="font-size: 50px;"></i>
                                            <h3>No links found!</h3>
                                        </div>
                                    </div>
                                <?php } else{ 
                                    foreach ($links as $linKey => $linkObj) {
                                        if($linkObj->type == "OBSERVATION"){
                                ?>
                                <div class="col-md-6 col-sm-12">
                                    <div class="d-flex flex-row mb-3 bg-white">
                                        <div class="position-absolute card-top-buttons">
                                            <a class="btn btn-header-light icon-button delete-post" onclick="return confirm('Are you sure to delete this link?');" href="<?= base_url('Observation/deleteLink').'?linkId='.$linkObj->id.'&id='.$_GET['id']; ?>">
                                                <i class="simple-icon-trash"></i>
                                            </a>
                                        </div>
                                        <a class="d-block position-relative" href="<?= base_url('observation/view?id='.$linkObj->linkedId); ?>">
                                            
                                            <img src="<?= base_url('api/assets/media/').$linkObj->media; ?>" alt="media" class="list-thumbnail list-obs-links border-0">
                                        
                                            <?php if($linkObj->status=='Published'){ ?>
                                            <span class="badge badge-pill position-absolute badge-top-right badge-success">PUBLISHED</span>
                                            <?php }else{ ?>
                                            <span class="badge badge-pill position-absolute badge-top-right badge-danger">DRAFT</span>
                                            <?php } ?>
                                        </a>
                                        <div class="pl-3 pt-2 pr-2 pb-2">
                                            <a href="<?= base_url('observation/view?id='.$linkObj->linkedId); ?>" class="obs-link">
                                                <p class="list-item-heading">
                                                    (OBS)<?= substr_replace(strip_tags(html_entity_decode($linkObj->title)),'...',40); ?>
                                                </p>
                                                <div class="pr-4 d-none d-sm-block">
                                                    <p class="text-muted mb-1 text-small">
                                                        By: <?= $linkObj->author; ?>
                                                    </p>
                                                </div>
                                                <div class="text-primary text-small font-weight-medium d-none d-sm-block">
                                                    <?= $linkObj->createdAt; ?>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                        }else if($linkObj->type == "REFLECTION"){
                                            if (file_exists('api/assets/media/'.$linkObj->media)) {
                                                $refMedia = base_url('api/assets/media/') . $linkObj->media;
                                            }else{
                                                $refMedia = base_url('api/assets/media/no-image.png');
                                            }
                                ?>
                                <div class="col-md-6 col-sm-12">
                                    <div class="d-flex flex-row mb-3 bg-white">
                                        <div class="position-absolute card-top-buttons">
                                            <a class="btn btn-header-light icon-button delete-post" onclick="return confirm('Are you sure to delete this link?');" href="<?= base_url('Observation/deleteLink').'?linkId='.$linkObj->id.'&id='.$_GET['id']; ?>">
                                                <i class="simple-icon-trash"></i>
                                            </a>
                                        </div>
                                        <a class="d-block position-relative" href="<?= base_url('Reflections/view?id='.$linkObj->linkedId); ?>">
                                            
                                            <img src="<?= $refMedia; ?>" alt="media" class="list-thumbnail list-obs-links border-0">
                                        
                                            <?php if($linkObj->status=='PUBLISHED'){ ?>
                                            <span class="badge badge-pill position-absolute badge-top-right badge-success">PUBLISHED</span>
                                            <?php }else{ ?>
                                            <span class="badge badge-pill position-absolute badge-top-right badge-danger">DRAFT</span>
                                            <?php } ?>
                                        </a>
                                        <div class="pl-3 pt-2 pr-2 pb-2">
                                            <a href="<?= base_url('Reflections/view?id='.$linkObj->linkedId); ?>" class="obs-link">
                                                <p class="list-item-heading">
                                                    (REF)<?= substr_replace(strip_tags(html_entity_decode($linkObj->title)),'...',40); ?>
                                                </p>
                                                <div class="pr-4 d-none d-sm-block">
                                                    <p class="text-muted mb-1 text-small">
                                                        By: <?= $linkObj->author; ?>
                                                    </p>
                                                </div>
                                                <div class="text-primary text-small font-weight-medium d-none d-sm-block">
                                                    <?= $linkObj->createdAt; ?>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                        }else if($linkObj->type == "QIP"){
                                ?>
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="position-absolute card-top-buttons">
                                                <a class="btn btn-header-light icon-button delete-post" onclick="return confirm('Are you sure to delete this link?');" href="<?= base_url('Observation/deleteLink').'?linkId='.$linkObj->id.'&id='.$_GET['id']; ?>">
                                                    <i class="simple-icon-trash"></i>
                                                </a>
                                            </div>
                                            <div class="card-title mb-0"> QIP </div>
                                            <h4><?= $linkObj->title; ?></h4>
                                            Author: <?= $linkObj->author; ?> <br>
                                            On: <?= $linkObj->createdAt; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                        }else{
                                ?>
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="position-absolute card-top-buttons">
                                                <a class="btn btn-header-light icon-button delete-post" onclick="return confirm('Are you sure to delete this link?');" href="<?= base_url('Observation/deleteLink').'?linkId='.$linkObj->id.'&id='.$_GET['id']; ?>">
                                                    <i class="simple-icon-trash"></i>
                                                </a>
                                            </div>
                                            <div class="card-title mb-0">
                                              <span>Program Plan</span>
                                            </div>
                                            <h4><?= $linkObj->title; ?></h4>
                                            Author: <?= $linkObj->author; ?> <br>
                                            On: <?= $linkObj->createdAt; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                        }
                                    } 
                                } ?>
                            </div>          
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div> 
        </div>
    </main>

     <!-- button design -->
    <?php if(!empty($id)) { ?>
        <div class="formSubmit text-right px-5" >
            <a href="<?php echo base_url('observation/changeObsStatus')."?obsid=".$id."&status=0"; ?>" class="btn btn-default btn-danger btnRed">Make Draft</a>
            <a href="<?php echo base_url('observation/changeObsStatus')."?obsid=".$id."&status=1"; ?>" class="btn btn-default btn-primary btnBlue">Publish Now</a>
        </div>
    <?php } ?>

    <!-- Select Children Modal Popup -->
    <div class="modal fade modal-right" id="selectChildrenModal" tabindex="-1" role="dialog" aria-labelledby="selectChildrenModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Children</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y:auto;max-height:500px;">
                    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search by Name, Date of Birth(day or year first) or UPN" class="form-control">
                    <br>
                    <ul class="nav nav-tabs separator-tabs ml-0 mb-5" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="children-tab" data-toggle="tab" href="#children" role="tab" aria-controls="children" aria-selected="true">CHILDREN</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " id="rooms-tab" data-toggle="tab" href="#rooms" role="tab" aria-controls="rooms" aria-selected="false">ROOMS</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="children" role="tabpanel" aria-labelledby="children-tab">
                            <div class="text-right selectAllCheck">
                                Select All <input type="checkbox" class="btn-child-select-all button_child select_all">
                            </div>
                            <table id="myTable"  data-name="listtable" class="listtable table">
                            <?php 
                                foreach($childs as $child) {
                                    $date1 = new DateTime($child->dob);
                                    $date2 = new DateTime(date('Y-m-d'));
                                    $diff = $date1->diff($date2); 
                                    $var = false;
                                    if(!empty($observationChildrens)){
                                       foreach ($observationChildrens as $obsCh) {
                                          if ($child->id==$obsCh->child_id) {
                                             $var = true;
                                             ?>
                                             <tr>
                                                <td><?php echo $child->name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?></td>
                                                <td class="text-right">
                                                   <input class="selected_check childcheck check<?php echo $child->id; ?>" id="<?php echo $child->name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?>" value="<?php echo $child->id; ?>" type="checkbox" checked>
                                                </td>
                                             </tr>
                                             <?php
                                          }
                                       }
                                       if($var==false){
                                          ?>
                                          <tr>
                                             <td><?php echo $child->name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?></td>
                                             <td class="text-right">
                                                <input class="selected_check childcheck check<?php echo $child->id; ?>" id="<?php echo $child->name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?>" value="<?php echo $child->id; ?>" type="checkbox" >
                                             </td>
                                          </tr>
                                          <?php
                                       }
                                    }else{
                                       ?>
                                       <tr>
                                          <td><?php echo $child->name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?></td>
                                          <td class="text-right">
                                             <input class="selected_check childcheck check<?php echo $child->id; ?>" data-name="<?php echo $child->name; ?>" id="<?php echo $child->name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?>" value="<?php echo $child->id; ?>" type="checkbox" name='<?php echo $child->name?>'>
                                          </td>
                                       </tr>
                                       <?php
                                    }
                                }
                            ?>  
                            </table>
                            <div class="no-childerns">O Children Selected</div>
                        </div>
                        <div class="tab-pane" id="rooms" role="tabpanel" aria-labelledby="rooms-tab">
                            <?php 
                                $group_row=0; 
                                foreach($groups as $key=>$group) { 
                                    if($key!="Status"){  
                            ?>
                            <span> <?php echo $key; ?>
                                <div class="text-right">
                                    Select All <input type="checkbox" id="group<?php echo $group_row; ?>" class="btn-child-select-all btngroup sa">
                                </div>
                            </span>
                            <table id="myTable" data-name="listtable" class="listtable table table-bordered">
                            <?php 
                                foreach($group as $key=>$child) {
                                    $date1 = new DateTime($child->dob);
                                    $date2 = new DateTime(date('Y-m-d'));
                                    $diff = $date1->diff($date2);
                            ?>                                                                                                                  
                            <tr>
                                <td><?php echo $child->child_name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?></td>
                                <td class="text-right"><input class="selected_check groupcheck check<?php echo $child->child_id; ?> group<?php echo $group_row; ?>" data-name="<?php echo $child->child_name; ?>" id="<?php echo $child->child_name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?>"  value="<?php echo $child->child_id; ?>" type="checkbox"></td>
                            </tr>
                            <?php }?>
                            </table>
                            <?php  $group_row++; } ?>
                            <?php }?>
                            <div class="no-childerns">O Children Selected</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="select_children();" class="btn btn-primary" data-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Select Children Modal Popup -->

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="tagsModalLabel">   
      <div class="modal-dialog" role="document">
       <div class="modal-content">
         <form id="myModalForm">
            <div class="modal-header">
                <h4 class="modal-title" id="tagsModalLabel">Add Image Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <img src="" alt="" class="img-fluid">
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" class="img-count" value="">
                        <div class="form-group">
                            <label>Childs</label>
                            <select class="select2-multiple form-control" multiple="multiple" name="childsId[]" id="child-tags">
                               <?php foreach ($childs as $key => $ch) { ?>
                               <option value="<?php echo $ch->id; ?>"><?php echo $ch->name; ?></option>
                               <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Educators</label>
                            <select class="select2-multiple form-control" multiple="multiple" name="educatorsId[]" id="educator-tags">
                                <?php foreach ($educators as $key => $ed) { ?>
                                    <option value="<?= $ed->userid; ?>"><?= $ed->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Caption</label>
                            <input type="text" class="form-control" id="imgCaption" value="">
                        </div>
                        <div class="temp-edit-sec">
                            <input type="hidden" id="ed-mda-id" value="">
                        </div>
                 </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="button" id="saveImgAttr" class="btn btn-primary myModalBtn" data-dismiss="modal">Save changes</button>
            </div>
         </form>
       </div>
      </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="uploadMediaModal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Select Media</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs separator-tabs ml-0 mb-5" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="upload-new-tab" data-toggle="tab" href="#uploadNew" role="tab" aria-controls="uploadNew" aria-selected="true">UPLOAD NEW</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="media-library-tab" data-toggle="tab" href="#uploadedImages" role="tab" aria-controls="uploadedImages" aria-selected="true">MEDIA LIBRARY</a>
                    </li> -->
                </ul>

               <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="uploadNew">
                        <label class="file-upload-field" for="fileUpload" style="border:2px solid cornflowerblue;">
                            <span>+</span>
                            <span>Upload</span>
                        </label>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="uploadedImages">
                        <div class="row">
                            <?php 
                               if (isset($uploadedMedia) && !empty($uploadedMedia)) {
                                    foreach ($uploadedMedia as $uploadedMedias => $uplMedia) {
                                        if ($uplMedia->type == "Image") {
                            ?>
                            <div class="col-md-2">
                                <div class="imgBlock">
                                    <input type="checkbox" id="<?php echo "check".$uplMedia->id; ?>" name="uploadedImgList[]" value="<?php echo $uplMedia->id; ?>" class="uploaded-media-list" data-type="image" data-url="<?php echo BASE_API_URL."assets/media/".$uplMedia->filename; ?>">
                                    <label for="<?php echo "check".$uplMedia->id; ?>">
                                        <img src="<?php echo BASE_API_URL."assets/media/".$uplMedia->filename; ?>" class="img-fluid hover-image">
                                    </label>
                                </div>
                            </div>
                            <?php } elseif ($uplMedia->type == "Video") { ?>
                            <div class="col-md-2">
                                <div class="imgBlock">
                                    <input type="checkbox" id="<?php echo "check".$uplMedia->id; ?>" name="uploadedImgList[]" value="<?php echo $uplMedia->id; ?>" class="uploaded-media-list" data-type="video" data-url="<?php echo BASE_API_URL."assets/media/".$uplMedia->filename; ?>">
                                    <label for="<?php echo "check".$uplMedia->id; ?>">
                                        <video src="<?php echo BASE_API_URL."assets/media/".$uplMedia->filename; ?>" class="img-fluid hover-image"></video>
                                    </label>
                                </div>
                            </div>
                            <?php  
                                        }
                                    }
                                }else{
                            ?>
                            <p>No media found!</p>
                            <?php } ?>
                        </div>
                        <div class="text-right">
                            <button type="button" id="addImgToForm" class="btn btn-primary" data-dismiss="modal">Select</button>
                        </div>
                    </div>
               </div>
            </div>
         </div>
      </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade bs-example-modal-lg" id="modal-preview" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">                    
         <div class="modal-content">                    
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Preview Observation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>   
            <div class="modal-body bg-grey">
                <div class="modal-container">
                    <div class="row">
                        <div class="col">
                            <ul class="nav nav-tabs separator-tabs ml-0 mb-5" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="first-tab-modal" data-toggle="tab" href="#modal-first" role="tab" aria-controls="modal-first" aria-selected="true">INFORMATION</a>
                                </li> 
                                <li class="nav-item">
                                    <a class="nav-link" id="second-tab-modal" data-toggle="tab" href="#modal-second" role="tab" aria-controls="modal-second" aria-selected="false">CHILDREN</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="third-tab-modal" data-toggle="tab" href="#modal-third" role="tab" aria-controls="modal-third" aria-selected="false">MONTESSORI</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="fourth-tab-modal" data-toggle="tab" href="#modal-fourth" role="tab" aria-controls="modal-fourth" aria-selected="false">EYLF</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="fifth-tab-modal" data-toggle="tab" href="#modal-fifth" role="tab" aria-controls="modal-fifth" aria-selected="false">DEVELOPMENTAL MILESTONE</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row" id="obser-info">
                        <div class="col">
                            <div class="tab-content">
                                <div class="tab-pane show active" id="modal-first" role="tabpanel" aria-labelledby="first-tab-modal">
                                    <div class="card">
                                        <div class="position-absolute card-top-buttons">
                                            <a class="btn btn-header-light icon-button" href="#!">
                                                <i class="simple-icon-arrow-left"></i>
                                            </a>
                                            <a class="btn btn-header-light icon-button" href="#!">
                                                <i class="simple-icon-arrow-right"></i>
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <h3 class="card-title" id="obsPreviewTitle">Not Available</h3>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div id="obsAuthorsSec">
                                                        <strong>Author:</strong>
                                                        <p class="mt-1" id="obsPreviewAuthor"></p>
                                                    </div>

                                                    <div id="obsNotesSec">
                                                       <strong>Notes:</strong>
                                                       <p class="mt-1" id="obsNotes"></p>
                                                    </div>
                                                    <?php if ($role!="Parent") { ?>
                                                    <div id="obsReflectionSec">
                                                       <strong>Reflection:</strong>
                                                       <p class="mt-1" id="obsReflection"></p>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="wrap-modal-slider">
                                                        <div class="your-class"></div>
                                                    </div>
                                                    <div class="scroll">
                                                        <div class="thumbMedia scroll-content"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="modal-second" role="tabpanel" aria-labelledby="second-tab-modal">
                                    <div class="row" id="obsChildren">
                                        
                                    </div>
                                </div>
                                <div class="tab-pane" id="modal-third" role="tabpanel" aria-labelledby="third-tab-modal">
                                    <div class="row">
                                        <div class="col-md-3 mon-prv-sub">
                                            
                                        </div>
                                        <div class="col-md-9" id="previewMontessori">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="modal-fourth" role="tabpanel" aria-labelledby="fourth-tab-modal">
                                    <div class="row">
                                        <div class="col-md-3 eylf-prvw-sub">
                                            
                                        </div>
                                        <div class="col-md-9" id="previewEYLF">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="modal-fifth" role="tabpanel" aria-labelledby="fifth-tab-modal">
                                    <div class="row">
                                        <div class="col-md-3 dev-mil-prv">
                                            
                                        </div>
                                        <div class="col-md-9" id="previewDevMile">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>         
         </div>
        </div>            
    </div>
    <!-- Preview Modal End -->


    <!-- Modal Structure -->
    <div class="modal fade" id="activityModal" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="activityModalLabel">Add New Activity</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="activityForm">
          <div class="mb-3">
            <label for="subjectSelect" class="form-label">Montessori Subject</label>
            <select class="form-select" id="subjectSelect" name="idSubject" required>
              <option value="" selected disabled>Select a subject</option>
              <!-- Options will be loaded via AJAX -->
            </select>
          </div>
          <div class="mb-3">
            <label for="activityTitle" class="form-label">Activity Title</label>
            <input type="text" class="form-control" id="activityTitle" name="title" required>
            <!-- Success message will appear here -->
            <div class="alert alert-success mt-2" id="successMessage" style="display: none;">
              Activity added successfully!
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="saveActivityBtn">Save Activity</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal Structure -->
<div class="modal fade" id="subActivityModal" tabindex="-1" aria-labelledby="subActivityModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="subActivityModalLabel">Add New Sub-Activity</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="subActivityForm">
          <div class="mb-3">
            <label for="subjectSelectForSub" class="form-label">Montessori Subject</label>
            <select class="form-select" id="subjectSelectForSub" name="idSubject" required>
              <option value="" selected disabled>Select a subject</option>
              <!-- Options will be loaded via AJAX -->
            </select>
          </div>
          <div class="mb-3">
            <label for="activitySelect" class="form-label">Activity</label>
            <select class="form-select" id="activitySelect" name="idActivity" required disabled>
              <option value="" selected disabled>Select a subject first</option>
              <!-- Options will be loaded via AJAX based on subject selection -->
            </select>
          </div>
          <div class="mb-3">
            <label for="subActivityTitle" class="form-label">Sub-Activity Title</label>
            <input type="text" class="form-control" id="subActivityTitle" name="title" required>
            <!-- Success message will appear here -->
            <div class="alert alert-success mt-2" id="subActivitySuccessMessage" style="display: none;">
              Sub-Activity added successfully!
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="saveSubActivityBtn">Save Sub-Activity</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>




    <?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/select2.full.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>
    <script src="<?= base_url(); ?>assets/js/slick.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/observation.js?v=1.0.0"></script>
    <!-- <script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script> -->
    <script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>



    <script src="<?= base_url(); ?>assets/js/vendor/jquery/jquery-ui.min.js"></script>
    
    <script>
        $(document).ready(function(){
            var _obs = new PerfectScrollbar('.obs-modal-links');
            var _ref = new PerfectScrollbar('.ref-modal-links');
            var _qip = new PerfectScrollbar('.qip-modal-links');
            var _pp = new PerfectScrollbar('.pp-modal-links');
        });

        var users = <?php echo $getStaffChild; ?>,tags = <?php echo $getTagsList; ?>;

    //     CKEDITOR.replace('obs_notes', {
    //       plugins: 'mentions,basicstyles,undo,link,wysiwygarea,toolbar,format,list',
    //       contentsCss: [
    //          'http://cdn.ckeditor.com/4.16.2/full-all/contents.css',
    //          'https://ckeditor.com/docs/ckeditor4/4.16.2/examples/assets/mentions/contents.css'
    //       ],
    //       height: 150,
    //       toolbar: [{
    //           name: 'document',
    //           items: ['Undo', 'Redo']
    //       },
    //       {
    //           name: 'basicstyles',
    //           items: ['Bold', 'Italic', 'Strike', 'Format']
    //       },
    //       {
    //           name: 'links',
    //           items: ['Link', 'Unlink', 'NumberedList', 'BulletedList']
    //       }],
    //       extraAllowedContent: '*[*]{*}(*)',
    //       mentions: [{  
    //          feed: dataFeed,
    //             itemTemplate: '<li data-id="{id}">' +
    //                '<strong class="username">{name}</strong>' +
    //                '</li>',
    //             outputTemplate: '<a href="user_{id}">{name}</a>',
    //             minChars: 0
    //          },
    //          {
    //             feed: tagsFeed,
    //             marker: '#',
    //             itemTemplate: '<li data-id="{id}"><strong>{title}</strong></li>',
    //             outputTemplate: '<a href="#tags_{rid}" data-tagid="{rid}" data-type="{type}" data-toggle="modal" data-target="#tagsModal">#{title}</a>',
    //             minChars: 0
    //          }
    //       ]
    //    });

   // Common configuration that can be reused for all instances
// Wait for DOM to be ready

// Add this before the DOMContentLoaded event
// var users = [
//     { id: 1, name: "John Doe" },
//     { id: 2, name: "Jane Smith" }
//     // ... other users
// ];

var tags = [
    { id: 1, title: "important", rid: "1", type: "tag" },
    { id: 2, title: "urgent", rid: "2", type: "tag" }
    // ... other tags
];

document.addEventListener('DOMContentLoaded', function() {
    // First define the feed functions
    function dataFeed(opts, callback) {
        var matchProperty = 'name',
        data = users.filter(function(item) {
            return item[matchProperty].indexOf(opts.query.toLowerCase()) == 0;
        });

        data = data.sort(function(a, b) {
            return a[matchProperty].localeCompare(b[matchProperty], undefined, {
                sensitivity: 'accent'
            });
        });
        callback(data);
    }

    function tagsFeed(opts, callback) {
        var matchProperty = 'title',
        data = tags.filter(function(item) {
            return item[matchProperty].indexOf(opts.query.toLowerCase()) == 0;
        });

        data = data.sort(function(a, b) {
            return a[matchProperty].localeCompare(b[matchProperty], undefined, {
                sensitivity: 'accent'
            });
        });
        callback(data);
    }

    // Make sure 'users' and 'tags' arrays are defined
    var users = window.users || []; // Define default if not exists
    var tags = window.tags || [];   // Define default if not exists

    // Then define the common configuration
    const commonConfig = {
        plugins: 'mentions,basicstyles,undo,link,wysiwygarea,toolbar,format,list',
        contentsCss: [
            'https://cdn.ckeditor.com/4.25.0-lts/full-all/contents.css',
            'https://ckeditor.com/docs/ckeditor4/4.25.0/examples/assets/mentions/contents.css'
        ],
        height: 150,
        toolbar: [
            {
                name: 'document',
                items: ['Undo', 'Redo']
            },
            {
                name: 'basicstyles',
                items: ['Bold', 'Italic', 'Strike', 'Format']
            },
            {
                name: 'links',
                items: ['Link', 'Unlink', 'NumberedList', 'BulletedList']
            }
        ],
        extraAllowedContent: '*[*]{*}(*)',
        mentions: [
            {  
                feed: dataFeed,
                itemTemplate: '<li data-id="{id}">' +
                              '<strong class="username">{name}</strong>' +
                              '</li>',
                outputTemplate: '<a href="user_{id}">{name}</a>',
                minChars: 0
            },
            {
                feed: tagsFeed,
                marker: '#',
                itemTemplate: '<li data-id="{id}"><strong>{title}</strong></li>',
                outputTemplate: '<a href="#tags_{rid}" data-tagid="{rid}" data-type="{type}" data-toggle="modal" data-target="#tagsModal">#{title}</a>',
                minChars: 0
            }
        ]
    };

    // Finally initialize the editors
    if (document.getElementById('obs_title')) {
        CKEDITOR.replace('obs_title', commonConfig);
    }
    
    if (document.getElementById('obs_notes')) {
        CKEDITOR.replace('obs_notes', commonConfig);
    }
    
    if (document.getElementById('obs_reflection')) {
        CKEDITOR.replace('obs_reflection', commonConfig);
    }
    if (document.getElementById('child_voice')) {
        CKEDITOR.replace('child_voice', commonConfig);
    }
    if (document.getElementById('future_plan')) {
        CKEDITOR.replace('future_plan', commonConfig);
    }


    document.querySelectorAll(".refine-btn").forEach(button => {
    button.addEventListener("click", function() {
        let editorId = this.getAttribute("data-editor");
        let content = CKEDITOR.instances[editorId].getData();

        // Save original text and disable the button
        let originalText = this.innerText;
        this.innerText = "Refining...";
        this.disabled = true;

        fetch("<?= base_url('observation/refine_text') ?>", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ text: content })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                CKEDITOR.instances[editorId].setData(data.refined_text);
            } else {
                alert("Error refining text: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Something went wrong!");
        })
        .finally(() => {
            // Revert button text and re-enable it
            this.innerText = originalText;
            this.disabled = false;
        });
    });
});


});



    </script>
    
    <script type="text/javascript">
        $('.button_child').click(function () {
          if ($(this).hasClass('select_all')) {
             var obj = {};
             var i = 0;
             $('.selected_check').each(function () {
                $(this).prop('checked', true);
                if (obj[$(this).val()] === undefined) {
                   obj[$(this).val()] = 0;
                   i++;
                }
             });

             if (i == 1) {
                $('.no-childerns').html(i + ' Child Selected');
             } else {
                $('.no-childerns').html(i + ' Children Selected');
             }
             $(this).removeClass("select_all");
             $(this).addClass("deselect_all");

             $('.btn-child-select-all').removeClass("select_all");
             $('.btn-child-select-all').addClass("deselect_all");
             $('.btn-child-select-all').prop('checked', true);
          } else {
             $('.selected_check').each(function () {
                $(this).prop('checked', false);
             });
             $('.no-childerns').html('O Children Selected');
             $(this).removeClass("deselect_all");
             $(this).addClass("select_all");

             $('.btn-child-select-all').removeClass("deselect_all");
             $('.btn-child-select-all').addClass("select_all");
             $('.btn-child-select-all').prop('checked', false);
          }
        });

        $('.btngroup').click(function() {
            var id = $(this).attr('id');
            if ($(this).hasClass('sa')) {
                var obj = {};
                var i = 0;
                $('.' + id).each(function () {
                $(this).prop('checked', true);
                var val = $(this).val()
                $('.check' + val).prop('checked', true);
                });
                $('.selected_check').each(function () {
                if ($(this).prop("checked") == true) {
                if (obj[$(this).val()] === undefined) {
                  obj[$(this).val()] = 0;
                  i++;
                }
                }
                });
                if (i == 1) {
                $('.no-childerns').html(i + ' Child Selected');
                } else {
                $('.no-childerns').html(i + ' Childern Selected');
                }
                $(this).removeClass("sa");
                $(this).addClass("dsa");
                $(this).prop('checked', true);
            } else {

                $('.' + id).each(function () {
                $(this).prop('checked', false);
                var val = $(this).val()
                $('.check' + val).prop('checked', false);
                });
                var obj = {};
                var i = 0;
                $('.selected_check').each(function () {
                if ($(this).prop("checked") == true) {
                   if (obj[$(this).val()] === undefined) {
                      obj[$(this).val()] = 0;
                      i++;
                   }
                }
                });
                if (i == 1) {
                $('.no-childerns').html(i + ' Child Selected');
                } else {
                $('.no-childerns').html(i + ' Childern Selected');
                }
                $(this).removeClass("dsa");
                $(this).addClass("sa");
                $(this).prop('checked', false);
            }
            total();
        });

        $('.selected_check').click(function () {
            var val = $(this).val();
            if ($(this).prop("checked") == true) {
                $('.check' + val).prop('checked', true);
            } else {
                $('.check' + val).prop('checked', false);
            }
            total();
        });

       function total() {
          var i = 0;
          var count = $('.childcheck').length;
          $('.childcheck').each(function () {
             if ($(this).prop("checked") == true) {
                i++;
             }
          });
          if (i == count) {
             $('.button_child').removeClass("select_all");
             $('.button_child').addClass("deselect_all");
             $('.button_child').prop('checked', true);;
          } else {
             $('.button_child').removeClass("deselect_all");
             $('.button_child').addClass("select_all");
             $('.button_child').prop('checked', false);;
          }
          $('.btngroup').each(function () {
             var id = $(this).attr('id');
             var i = 0;
             var count = $('.' + id).length;
             $('.' + id).each(function () {
                if ($(this).prop("checked") == true) {
                   i++;
                }
             });
             if (i == count) {
                $(this).removeClass("select_all");
                $(this).addClass("deselect_all");
                $(this).prop('checked', true);;
             } else {
                $(this).removeClass("deselect_all");
                $(this).addClass("select_all");
                $(this).prop('checked', false);
             }
          });
          var obj = {};
          var i = 0;
          $('.selected_check').each(function () {
             if ($(this).prop("checked") == true) {
                if (obj[$(this).val()] === undefined) {
                   obj[$(this).val()] = 0;
                   i++;
                }
             }
          });
          if (i == 1) {
             $('.no-childerns').html(i + ' Child Selected');
          } else {
             $('.no-childerns').html(i + ' Childern Selected');
          }
       }

       function saveMontessori() {
          var url = "<?php echo base_url('observation/addNew?type=assessments&sub_type=EYLF&id='.$id); ?>";
          var test = url.replace(/&/g, '&');
          document.getElementById("form-montessori").action = test;
          document.getElementById("form-montessori").submit();
       }

       function saveEylf() {
          var url = "<?php echo base_url('observation/addNew?type=assessments&sub_type=Milestones&id='.$id); ?>";
          var test = url.replace(/&/g, '&');
          document.getElementById("form-eylf").action = test;
          document.getElementById("form-eylf").submit();
       }

       function createLinks() {
          var url = "<?php echo base_url('observation/addNew?type=links&status=true&id='.$id); ?>";
          var test = url.replace(/&/g, '&');
          document.getElementById("form-link").action = test;
          document.getElementById("form-link").submit();
       }




       function saveReflection() {
          var url = "<?php echo base_url('observation/addNew?type=links&status=true&id='.$id); ?>";
          var test = url.replace(/&/g, '&');
          document.getElementById("form-link-ref").action = test;
          document.getElementById("form-link-ref").submit();
       }

       function saveQip() {
          var url = "<?php echo base_url('observation/addNew?type=links&status=true&id='.$id); ?>";
          var test = url.replace(/&/g, '&');
          document.getElementById("form-link-qip").action = test;
          document.getElementById("form-link-qip").submit();
       }

        function saveProplan() {
            var url = "<?php echo base_url('observation/addNew?type=links&status=true&id='.$id); ?>";
            var test = url.replace(/&/g, '&');
            document.getElementById("form-link-pp").action = test;
            document.getElementById("form-link-pp").submit();
        }

        function editObservation() {
            $(".img-preview").each(function(){
                $("#form-observation").append('<input type="hidden" name="origin[]" value="'+$(this).data("origin")+'">');
                $("#form-observation").append('<input type="hidden" name="priority[]" value="'+$(this).data("key")+'">');
            });

            $(".uploaded-imgs").each(function(){
                $("#form-observation").append('<input type="hidden" name="mediaid[]" value="'+$(this).data("mediaid")+'">');
            });

            $(".nonsticky-preview").each(function(){
                $("#form-observation").append('<input type="hidden" name="fileno[]" value="'+$(this).data("fileno")+'">');
            });

            if ($('#obs_title').val() == '') {
                alert('Plz Enter Title');
                return false;
            }
            var url = "<?= base_url('observation/addNew?type=assessments&sub_type=Montessori&id='.$id); ?>";
            var test = url.replace(/&/g, '&');
            document.getElementById("form-observation").action = test;
            document.getElementById("form-observation").submit();
        }

        function saveObservation() {
            $(".img-preview").each(function(){
                $("#form-observation").append('<input type="hidden" name="origin[]" value="'+$(this).data("origin")+'">');
                $("#form-observation").append('<input type="hidden" name="priority[]" value="'+$(this).data("key")+'">');
            });

            $(".uploaded-imgs").each(function(){
                $("#form-observation").append('<input type="hidden" name="mediaid[]" value="'+$(this).data("mediaid")+'">');
            });

            $(".nonsticky-preview").each(function(){
                $("#form-observation").append('<input type="hidden" name="fileno[]" value="'+$(this).data("fileno")+'">');
            });

            var url = "<?php echo base_url('observation/addNew?type=assessments'); ?>";
            var test = url.replace(/&/g, '&');
            document.getElementById("form-observation").action = test;
            document.getElementById("form-observation").submit();
        }

        function draftObservation() {
            $(".img-preview").each(function(){
                $("#form-observation").append('<input type="hidden" name="origin[]" value="'+$(this).data("origin")+'">');
                $("#form-observation").append('<input type="hidden" name="priority[]" value="'+$(this).data("key")+'">');
            });

            $(".uploaded-imgs").each(function(){
                $("#form-observation").append('<input type="hidden" name="mediaid[]" value="'+$(this).data("mediaid")+'">');
            });

            $(".nonsticky-preview").each(function(){
                $("#form-observation").append('<input type="hidden" name="fileno[]" value="'+$(this).data("fileno")+'">');
            });

            $("#form-observation").append('<input type="hidden" name="status" value="Draft">');

            var url = "<?php echo base_url('observation/addNew?type=assessments'); ?>";
            var test = url.replace(/&/g, '&');
            document.getElementById("form-observation").action = test;
            document.getElementById("form-observation").submit();
        }

        function saveMilestones() {
    var url = "<?php echo base_url('observation/addNew?type=links&id='.$id); ?>";
    var test = url.replace(/&/g, '&');

    // Remove empty selects before submission
    document.querySelectorAll('.devmilesub').forEach(function(select) {
        if (select.value === "") {
            select.remove();
        }
    });

    document.getElementById("form-milestones").action = test;
    document.getElementById("form-milestones").submit();
    console.log(test);
}

       function myFunction() {
          var input, filter, table, tr, td, i, alltables;
          alltables = document.querySelectorAll("table[data-name=listtable]");
          input = document.getElementById("myInput");
          filter = input.value.toUpperCase();
          alltables.forEach(function (table) {
             tr = table.getElementsByTagName("tr");
             for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                   if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                      tr[i].style.display = "";
                   } else {
                      tr[i].style.display = "none";
                   }
                }
             }
          });
       }

       <?php if(!empty($observationChildrens)) { ?>
       $('.bootstrap-tagsinput').show();
       <?php  } else { ?>
       $('.bootstrap-tagsinput').hide();
       <?php } ?>

       function select_children() {
          var obj = {};
          var msg = '';
          $('.selected_check').each(function () {
             if ($(this).prop("checked") == true) {
                if (obj[$(this).val()] === undefined) {
                   obj[$(this).val()] = 0;
                   msg += '<span class="tag label label-info"><input type="hidden" name="childrens[]" data-name="'+ $(this).data("name") +'" value="' + $(this).val() + '">' + $(this).attr('id') + ' <span class="rem" data-role="remove">x</span></span>';
                }
                // console.log($(this));
             }
          });
          // msg += '<input type="text" readonly="" placeholder="" size="1">';
          $('.bootstrap-tagsinput').html(msg);
          $('.bootstrap-tagsinput').show();
       }

       $(document.body).delegate('.rem', 'click', function () {
          $(this).parent().remove();
       });
       $(document.body).delegate('.dz-remove', 'click', function () {
          $(this).parent().remove();
       });

       $(document).on('click','.rem',function(){
          var val = $(this).parent().find('input').val();
          $("input.selected_check[value='"+val+"']").prop("checked",false);
       });

       $(document).ready(function(){

          var child_count = $(".childcheck:checked").length;
          var group_child_count = $(".groupcheck:checked").length;

          if (child_count>0) {
             $('.no-childerns').text(child_count+" Children Selected");
          }

          if (group_child_count>0) {
             $('.no-childerns').text(child_count+" Children Selected");
          }

          $('.childcheck').each(function(index){
             var checkbox = $(this).val();
             if ($(this).is(":checked")) {
                $("input.selected_check[value='"+checkbox+"']").prop("checked",true);
             }else{
                $('input.selected_check[value="'+checkbox+'"]').prop("checked",false);
             }
          });

          $('#myModal').on('show.bs.modal', function (event) {
             var button = $(event.relatedTarget);
             var edit = button.data('edit');
             var img = button.data('image');
             var imgCount = button.data('imgcount');
             var modal = $(this);
             modal.find('img').prop("src",img);
             modal.find('.img-count').val(imgCount);

             if (edit==1) {
                $('#ed-mda-id').val(button.data('mediaid'));
                $(".myModalBtn").attr("id","saveImgProp");         
             } else if(edit==2){
                $('#ed-mda-id').val(button.data('mediaid'));
                $(".myModalBtn").attr("id","addImgTags");  
             } else {
                $(".myModalBtn").attr("id","saveImgAttr");
                let tagsChildsArr = [];
                let tagsStaffsArr = [];

                $('input[name="obsImage_'+imgCount+'[]"]').each(function(index, el) {
                    tagsChildsArr.push(el.value);
                });

                $('input[name="obsEducator_'+imgCount+'[]"]').each(function(index, el) {
                    tagsStaffsArr.push(el.value);
                });

                $("#educator-tags").val(tagsStaffsArr);
                $('#educator-tags').trigger('change');

                $("#child-tags").val(tagsChildsArr);
                $('#child-tags').trigger('change');

                $("#imgCaption").val($('input[name="obsCaption_'+imgCount+'"]').val());

             }
          }); 

        //form data save
        $(document).on('click','#saveImgAttr',function(){
            var ctext = $('#child-tags').select2('data');
            var emediaId = $('#ed-mda-id').val();
            var educatorIds = $('#educator-tags').select2('data');
            var imgCaption = $('#imgCaption').val();
            var imgCount = $('.img-count').val();

             $('input[name="obsImage_'+imgCount+'[]"]').remove();

             for(d=0; d < ctext.length; d++){
                $("#form-observation").append('<input type="hidden" name="obsImage_'+ imgCount +'[]" value="'+ctext[d].id+'" data-name="'+ctext[d].text+'">');
             }

             $('input[name="obsEducator_'+imgCount+'[]"]').remove();

             for(j=0; j < educatorIds.length; j++){
                
                $("#form-observation").append('<input type="hidden" name="obsEducator_'+ imgCount +'[]" value="'+educatorIds[j].id+'"data-name="'+educatorIds[j].text+'">');
             }

             $('input[name="obsMediaId_'+imgCount+'"]').remove();

             if(imgCount!=""){
                $("#form-observation").append('<input type="hidden" name="obsMediaId_'+imgCount+'" value="'+emediaId+'">');
             }

             $('input[name="obsCaption_'+imgCount+'"]').remove();

             $("#form-observation").append('<input type="hidden" name="obsCaption_'+imgCount+'" value="'+imgCaption+'">');

             $("#child-tags").select2('destroy').val("").select2();
             $('#educator-tags').select2('destroy').val("").select2();
             $('#ed-mda-id').val("");
             $("#myModalForm").get(0).reset();
        });

          //db save
          $(document).on('click','#saveImgProp',function(){
             var obsId = "<?php echo isset($_GET['id'])?$_GET['id']:0; ?>";
             var childIds = $("#child-tags").select2("val");
             var emediaId = $('#ed-mda-id').val();
             var educatorIds = $('#educator-tags').select2("val");
             var imgCaption = $('#imgCaption').val();
             childIds = JSON.stringify(childIds);
             educatorIds = JSON.stringify(educatorIds);
             $.ajax({
                traditional: true,
                url: "<?php echo base_url("Observation/saveImageTags")?>",
                type: "POST",
                data: {"obsId":obsId,"childIds":childIds,"emediaId":emediaId,"educatorIds":educatorIds,"imgCaption":imgCaption},
                success: function(msg){
                   // var res = jQuery.parseJSON(msg);
                   console.log(msg);
                }
             });

             $("#child-tags").select2('destroy').val("").select2();
             $('#educator-tags').select2('destroy').val("").select2();
             $('#ed-mda-id').val("");
             $("#myModalForm").get(0).reset();
          });

          //uploaded media save
          $(document).on('click','#addImgTags',function(){
             var childIds = $("#child-tags").select2("data");
             var educatorIds = $('#educator-tags').select2("data");
             var imgCaption = $('#imgCaption').val();
             var mediaId = $('#ed-mda-id').val();
             $("#child-tags").select2('destroy').val("").select2();
             $('#educator-tags').select2('destroy').val("").select2();
             $("#myModalForm").get(0).reset();
             $(childIds).each(function(index,element){
                $("#form-observation").append('<input type="hidden" name="upl-media-tags-child'+mediaId+'[]" value="'+element.id+'" data-name="'+element.name+'">');
             });

             $(educatorIds).each(function(index,element){
                $("#form-observation").append('<input type="hidden" name="upl-media-tags-educator'+mediaId+'[]" value="'+element.id+'" data-name="'+element.name+'">');
             });

             $("#form-observation").append('<input type="hidden" name="upl-media-tags-caption'+mediaId+'" value="'+imgCaption+'">');
          });


          $("#fileUpload").on('change', function() {
             let imgPrevs = $(".img-preview").length;
             if(imgPrevs==0){
                imgPrevs = 1;
             }else{
                imgPrevs = imgPrevs + 1;
             }
             $(".nonsticky-preview").remove();
             //Get count of selected files
             const countFiles = $(this)[0].files.length;
             let allGood = true;
             const mainHolder = $("#img-holder");
             for (let i = 0; i < countFiles; i++) {
                const file = this.files[i];
                const url = URL.createObjectURL(file);
                const imgPath = file.name;
                const extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                const image_holder_name = "img-preview-" + i;
                if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg" || extn == "mp4" || extn == "heic" || extn == "heif") {
                   if (typeof(Blob) != "undefined") {
                     const image_holder = $("#img-preview-" + i);
                     if (extn == "mp4") {
                        mainHolder.append(`<div class="img-preview nonsticky-preview" data-origin="NEW" data-fileno="${i}" data-key="${i}">
                                              <video class="thumb-image" controls>
                                                 <source src="${url}" type="video/mp4">
                                              </video>
                                              <span class="img-remove">
                                                X
                                              </span>
                                              <a class="img-edit" href="#!" data-mediaorigin="NEW" data-imgcount="${i}" data-image="${url}" data-toggle="modal" data-target="#myModal" data-priority="${imgPrevs}" data-edit="3">
                                                #
                                              </a>
                                           </div>`);
                     } else {
                        mainHolder.append(`<div class="img-preview nonsticky-preview" data-origin="NEW" data-fileno="${i}" data-key="${i}">
                                              <img class="thumb-image" src="${url}">
                                              <span class="img-remove">X</span>
                                              <a class="img-edit" href="#!" data-mediaorigin="NEW" data-imgcount="${i}" data-image="${url}" data-toggle="modal" data-target="#myModal" data-priority="${imgPrevs}" data-edit="3">
                                                #
                                              </a>
                                           </div>`);
                     }
                   }
                } else {
                   allGood = false;
                   alert("use image extension - gif,png,jpg,jpeg,mp4,heic,heif.");
                   break;
                }
                imgPrevs = imgPrevs + 1;
             }

             if (!allGood) {
                alert("Pls select only images and videos");
             }

             // $("#fileUpload").val("");
             $("#uploadMediaModal").modal("hide");
          });



//         $("#fileUpload").on('change', function() {
//     let imgPrevs = $(".img-preview").length;
//     imgPrevs = imgPrevs === 0 ? 1 : imgPrevs + 1;
//     $(".nonsticky-preview").remove();

//     const countFiles = $(this)[0].files.length;
//     let allGood = true;
//     const mainHolder = $("#img-holder");

//     for (let i = 0; i < countFiles; i++) {
//         const file = this.files[i];
//         const url = URL.createObjectURL(file);
//         const imgPath = file.name;
//         const extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
//         const image_holder_name = "img-preview-" + i;
//         const fileSizeMB = file.size / (1024 * 1024); // Convert bytes to MB

//         if (fileSizeMB > 2) {
//             alert("File size exceeds 2MB: " + imgPath);
//             allGood = false;
//             continue; // Skip this file
//         }

//         if (["gif", "png", "jpg", "jpeg", "mp4", "heic", "heif"].includes(extn)) {
//             if (typeof Blob !== "undefined") {
//                 if (extn === "mp4") {
//                     mainHolder.append(`<div class="img-preview nonsticky-preview" data-origin="NEW" data-fileno="${i}" data-key="${i}">
//                         <video class="thumb-image" controls>
//                             <source src="${url}" type="video/mp4">
//                         </video>
//                         <span class="img-remove">X</span>
//                         <a class="img-edit" href="#!" data-mediaorigin="NEW" data-imgcount="${i}" data-image="${url}" data-toggle="modal" data-target="#myModal" data-priority="${imgPrevs}" data-edit="3">#</a>
//                     </div>`);
//                 } else {
//                     mainHolder.append(`<div class="img-preview nonsticky-preview" data-origin="NEW" data-fileno="${i}" data-key="${i}">
//                         <img class="thumb-image" src="${url}">
//                         <span class="img-remove">X</span>
//                         <a class="img-edit" href="#!" data-mediaorigin="NEW" data-imgcount="${i}" data-image="${url}" data-toggle="modal" data-target="#myModal" data-priority="${imgPrevs}" data-edit="3">#</a>
//                     </div>`);
//                 }
//             }
//         } else {
//             alert("Use image/video extensions - gif, png, jpg, jpeg, mp4, heic, heif.");
//             allGood = false;
//             break;
//         }
//         imgPrevs++;
//     }

//     if (!allGood) {
//         alert("Please select only images and videos under 2MB.");
//     }

//     $("#uploadMediaModal").modal("hide");
// });




          $(document).on('click','.img-remove',function(){
             if (confirm("Are you sure?")) {
                var img = $(this).data('imgcount');
                var imgArr = $('#fileUpload')[0].files;
                var length = $('#fileUpload')[0].files.length;
                var len = $(this).parent("div").prevAll().length;
                let list = new DataTransfer();
                let myFileList;
                for(i=0;i<length;i++){
                   if($(this).parent('div').prevAll().length != i){
                      let file = new File(["content"], imgArr[i].name);
                      list.items.add(file);
                      myFileList = list.files;
                   }
                }
                $('#fileUpload')[0].files  = myFileList
                $(this).parent().remove();

                $("input[type='hidden'][name='obsImage_"+img+"[]']").remove();
                $("input[type='hidden'][name='obsEducator_"+img+"[]']").remove();
                $("input[type='hidden'][name='obsCaption_"+img+"']").remove();
             }      
          });

          $(document).on('click','.deleteMedia',function(){
             var id = $(this).attr('id');
             var img = $(this).data('imgcount');
             var userid = <?php echo $this->session->userdata('LoginId'); ?>;
             $.ajax({
                traditional:true,
                type: "GET",
                url: "<?php echo BASE_API_URL.'observation/deleteMedia/'; ?>"+userid+"/"+id,
                beforeSend: function(request) {
                   request.setRequestHeader("X-Device-Id", "<?php echo $this->session->userdata('X-Device-Id');?>");
                   request.setRequestHeader("X-Token", "<?php echo $this->session->userdata('AuthToken');?>");
                   },
                   success: function(msg){
                   console.log("Success");
                }
             });
          });

          $(document).on('click','.img-real-edit', function (event) {
             var mediaid = $(this).data('mediaid');
             $("#ed-mda-id").val(mediaid);
             $.ajax({
                traditional:true,
                type: "POST",
                url: "<?= base_url('Observation/getMediaTags/'); ?>",
                data: {"mediaid":mediaid},
                success: function(msg){
                    console.log(msg);
                   res = jQuery.parseJSON(msg);
                   var childTags = [];
                   var educatorTags = [];
                   $(res.ChildTags).each(function(){
                      childTags.push(this.childId);
                   });
                   $(res.EducatorTags).each(function(){
                      educatorTags.push(this.userId);
                   });
                   $("#child-tags").val(childTags);
                   $('#child-tags').trigger('change');
                   $("#educator-tags").val(educatorTags);
                   $('#educator-tags').trigger('change');
                   $('#imgCaption').val(res.MediaInfo.caption);
                }
             });
          });

          $(document).on("click",".img-uploaded-edit",function(){
             var mediaid = $(this).data("mediaid");
             var type = $(this).data("type");
             if (type=="image") {
                 var imgUrl = $(this).siblings(".img-thumb").attr("src");
                 $("#imageContent").attr("src",imgUrl);
                 $("#videoContent").hide();
             } else {
                 var vidUrl = $(this).siblings(".vid-thumb").find('Source:first').attr('src');
                 $("#videoContent").find('Source').attr("src", vidUrl);
                 $("#imageContent").hide();
             }
             $("#mediaRecId").val(mediaid);
             $.ajax({
                 traditional:true,
                 type: "POST",
                 url: "<?php echo base_url('Media/getTagsArr'); ?>",
                 data: {"mediaid":mediaid},
                 success: function(msg){
                     res = jQuery.parseJSON(msg);
                     var childTags = [];
                     var staffTags = [];
                     $(res.ChildTags).each(function(){
                        childTags.push(this.userid);
                     });
                     $(res.StaffTags).each(function(){
                        staffTags.push(this.userid);
                     });
                     $("#child-tags").val(childTags);
                     $('#child-tags').trigger('change');
                     $("#educator-tags").val(staffTags);
                     $('#educator-tags').trigger('change');
                     $('#imgCaption').val(res.Media.caption);
                     $('.modal-footer > #saveImgAttr').remove();
                     $('#saveImgProp').remove();
                     $('.modal-footer').append('<button type="button" id="addImgTags" class="btn btn-primary myModalBtn btn-small btnBlue pull-right" data-dismiss="modal">Save Changes</button>');
                     $("input[name='upl-media-tags-child"+mediaid+"[]']").remove();
                     $("input[name='upl-media-tags-educator"+mediaid+"[]']").remove();
                     $("input[name='upl-media-tags-caption"+mediaid+"']").remove();
                     $("#ed-mda-id").val(mediaid);
                 }
             });
          });

          <?php if (isset($_GET['id'])) { ?>
             $( "#img-holder" ).sortable({ 
                items: "> .img-preview",
                beforeStop: function( event, ui ) {
                   let countImages = $("#img-holder .img-preview").length - 1;
                   let arr = [];
                   $("#img-holder .img-preview a").each(function(){
                      let mediaId = $(this).data("mediaid");
                      if(mediaId == undefined){
                         arr.push(0);
                      } else {
                         arr.push(mediaId);
                      }              
                   });
                   $.ajax({
                      traditional: true,
                      url: "<?php echo base_url('Observation/updateImagePriority')?>",
                      type: "POST",
                      data: {priority:JSON.stringify(arr)},
                      success: function(msg){
                         // var res = jQuery.parseJSON(msg);
                         console.log(msg);
                      }
                   });
                } 
             });
          <?php } else { ?>
             $( "#img-holder" ).sortable({ 
                items: "> .img-preview" 
             });
          <?php } ?>

          $("#img-holder").disableSelection();

          $(document).on("click","#addImgToForm",function(){
             let imgPrevs = $(".img-preview").length;
             if(imgPrevs==0){
                imgPrevs = 1;
             }
             $(".uploaded-media-list:checked").each(function(){
                let ftype = $(this).data("type");
                let fmedia = $(this).data("url");
                let fmediaid = $(this).val();
                getTagsForUploadedMedia(fmediaid);
                if (ftype=="image") {
                   $("#img-holder").append('<div class="img-preview sticky-preview uploaded-imgs" data-origin="UPLOADED" data-mediaid="'+fmediaid+'" data-key="'+fmediaid+'"><img class="thumb-image" src="'+fmedia+'"><span id="'+fmediaid+'" class="img-remove deleteMedia">X</span><a class="img-edit img-uploaded-edit" href="#!" data-mediaid="'+fmediaid+'" data-image="'+fmedia+'" data-toggle="modal" data-target="#myModal" data-mediaorigin="UPLOADED" data-edit="2" data-priority="'+imgPrevs+'">#</a></div>');
                } else if (ftype=="video"){
                   $("#img-holder").append('<div class="img-preview nonsticky-preview uploaded-imgs" data-origin="UPLOADED" data-mediaid="'+fmediaid+'" data-key="'+fmediaid+'"> <video class="thumb-image" controls> <source src="'+fmedia+'" type="video/mp4"> </video> <span class="img-remove">X</span> <a class="img-edit img-uploaded-edit" href="#!" data-image="'+fmedia+'" data-toggle="modal" data-target="#myModal" data-mediaorigin="UPLOADED" data-edit="2" data-priority="'+imgPrevs+'">#</a> </div>');
                }
                imgPrevs = imgPrevs + 1;
             });
          });

          function getTagsForUploadedMedia(mediaId) {
             $.ajax({
                traditional:true,
                type: "POST",
                url: "<?php echo base_url('Media/getTagsArr'); ?>",
                data: {"mediaid":mediaId},
                success: function(msg){
                   // console.log(msg);
                   res = jQuery.parseJSON(msg);
                   var childTags = [];
                   var staffTags = [];
                   $(res.ChildTags).each(function(index,element){
                      $("#form-observation").append('<input type="hidden" name="upl-media-tags-child'+mediaId+'[]" value="'+element.userid+'">');
                      
                   });
                   $(res.StaffTags).each(function(index,element){
                      $("#form-observation").append('<input type="hidden" name="upl-media-tags-educator'+mediaId+'[]" value="'+element.userid+'">');
                   });

                   $("#form-observation").append('<input type="hidden" name="upl-media-tags-caption'+mediaId+'" value="'+res.Media.caption+'">');
                }
             });
          }
       });

       $(document).ready(function(){
          check_val='<?php echo $get_child;?>';
          if(check_val!=''){
             console.log(check_val);
             $("input[name='"+check_val+"']").prop('checked', true);
          }
       });

       $(document).ready(function(){
             $('#modal-preview,#modal-linkobs,#modal-linkref,#modal-linkqip,#modal-linkprogplan').draggable({
                      handle: ".modal-header"
             });
    });
    </script>


<script>
    $(document).ready(function() {
        $('#milestoneForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: '<?php echo base_url("Observation/addmilestones"); ?>',
                type: 'POST',
                data: {
                    milestoneid: $('#milestoneid').val(),
                    name: $('#name').val()
                },
                dataType: 'json',
                success: function(response) {
                    if(response.status == 'success') {
                        // Show success message
                        $('#successMessage').show();
                        
                        // Clear the form
                        $('#milestoneForm')[0].reset();
                        
                        // Hide success message after 3 seconds
                        setTimeout(function() {
                            $('#successMessage').hide();
                        }, 3000);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        });
    });
    </script>

<!-- JavaScript for Modal and AJAX -->
<!-- JavaScript for Modal and AJAX -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const addActivityBtn = document.getElementById('addActivityBtn');
  const activityForm = document.getElementById('activityForm');
  const subjectSelect = document.getElementById('subjectSelect');
  const activityModal = new bootstrap.Modal(document.getElementById('activityModal'));
  const successMessage = document.getElementById('successMessage');
  
  // When the Add Activity button is clicked
  addActivityBtn.addEventListener('click', function() {
    // Fetch subjects via AJAX before opening the modal
    fetchSubjects();
  });
  
  // Function to fetch subjects from the database
  function fetchSubjects() {
    // Show loading state
    subjectSelect.innerHTML = '<option value="" selected disabled>Loading subjects...</option>';
    
    // AJAX call to get subjects
    $.ajax({
      url: '<?= base_url('Observation/getSubjects') ?>',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        // Clear loading state
        subjectSelect.innerHTML = '<option value="" selected disabled>Select a subject</option>';
        
        // Add the fetched subjects to the select element
        data.forEach(function(subject) {
          const option = document.createElement('option');
          option.value = subject.idSubject;
          option.textContent = subject.name;
          subjectSelect.appendChild(option);
        });
        
        // Open the modal after data is loaded
        activityModal.show();
      },
      error: function(xhr, status, error) {
        console.error('Error fetching subjects:', error);
        alert('Failed to load subjects. Please try again.');
      }
    });
  }
  
  // Form submission handler
  activityForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get form data
    const idSubject = subjectSelect.value;
    const title = document.getElementById('activityTitle').value;
    
    // AJAX call to save the activity
    $.ajax({
      url: '<?= base_url('Observation/addActivity') ?>',
      type: 'POST',
      data: {
        idSubject: idSubject,
        title: title
      },
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          // Clear the title field
          document.getElementById('activityTitle').value = '';
          
          // Show success message below the input
          successMessage.style.display = 'block';
          
          // Hide success message after 3 seconds
          setTimeout(function() {
            successMessage.style.display = 'none';
          }, 3000);
        } else {
          alert('Failed to add activity: ' + response.message);
        }
      },
      error: function(xhr, status, error) {
        console.error('Error adding activity:', error);
        alert('Failed to add activity. Please try again.');
      }
    });
  });
  
  // Ensure page refresh when modal is closed
  document.getElementById('activityModal').addEventListener('hidden.bs.modal', function() {
    location.reload();
  });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
  const addSubActivityBtn = document.getElementById('addSubActivityBtn');
  const subActivityForm = document.getElementById('subActivityForm');
  const subjectSelectForSub = document.getElementById('subjectSelectForSub');
  const activitySelect = document.getElementById('activitySelect');
  const subActivityModal = new bootstrap.Modal(document.getElementById('subActivityModal'));
  const subActivitySuccessMessage = document.getElementById('subActivitySuccessMessage');
  
  // When the Add Sub-Activity button is clicked
  addSubActivityBtn.addEventListener('click', function() {
    // Fetch subjects via AJAX before opening the modal
    fetchSubjectsForSubActivity();
  });
  
  // Function to fetch subjects from the database
  function fetchSubjectsForSubActivity() {
    // Show loading state
    subjectSelectForSub.innerHTML = '<option value="" selected disabled>Loading subjects...</option>';
    
    // AJAX call to get subjects
    $.ajax({
      url: '<?= base_url('Observation/getSubjects') ?>',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        // Clear loading state
        subjectSelectForSub.innerHTML = '<option value="" selected disabled>Select a subject</option>';
        
        // Add the fetched subjects to the select element
        data.forEach(function(subject) {
          const option = document.createElement('option');
          option.value = subject.idSubject;
          option.textContent = subject.name;
          subjectSelectForSub.appendChild(option);
        });
        
        // Open the modal after data is loaded
        subActivityModal.show();
      },
      error: function(xhr, status, error) {
        console.error('Error fetching subjects:', error);
        alert('Failed to load subjects. Please try again.');
      }
    });
  }
  
  // Function to fetch activities based on selected subject
  function fetchActivitiesBySubject(subjectId) {
    // Disable activity select and show loading
    activitySelect.disabled = true;
    activitySelect.innerHTML = '<option value="" selected disabled>Loading activities...</option>';
    
    // AJAX call to get activities for the selected subject
    $.ajax({
      url: '<?= base_url('Observation/getActivitiesBySubject') ?>',
      type: 'GET',
      data: { idSubject: subjectId },
      dataType: 'json',
      success: function(data) {
        // Clear loading state
        activitySelect.innerHTML = '<option value="" selected disabled>Select an activity</option>';
        
        if (data.length === 0) {
          activitySelect.innerHTML = '<option value="" selected disabled>No activities found for this subject</option>';
        } else {
          // Add the fetched activities to the select element
          data.forEach(function(activity) {
            const option = document.createElement('option');
            option.value = activity.idActivity;
            option.textContent = activity.title;
            activitySelect.appendChild(option);
          });
          
          // Enable the activity select
          activitySelect.disabled = false;
        }
      },
      error: function(xhr, status, error) {
        console.error('Error fetching activities:', error);
        activitySelect.innerHTML = '<option value="" selected disabled>Error loading activities</option>';
      }
    });
  }
  
  // When subject is selected, fetch related activities
  subjectSelectForSub.addEventListener('change', function() {
    const selectedSubjectId = this.value;
    if (selectedSubjectId) {
      fetchActivitiesBySubject(selectedSubjectId);
    } else {
      // Reset and disable activity select if no subject is selected
      activitySelect.innerHTML = '<option value="" selected disabled>Select a subject first</option>';
      activitySelect.disabled = true;
    }
  });
  
  // Form submission handler
  subActivityForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get form data
    const idActivity = activitySelect.value;
    const title = document.getElementById('subActivityTitle').value;
    
    // AJAX call to save the sub-activity
    $.ajax({
      url: '<?= base_url('Observation/addSubActivity') ?>',
      type: 'POST',
      data: {
        idActivity: idActivity,
        title: title
      },
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          // Clear the title field
          document.getElementById('subActivityTitle').value = '';
          
          // Show success message below the input
          subActivitySuccessMessage.style.display = 'block';
          
          // Hide success message after 3 seconds
          setTimeout(function() {
            subActivitySuccessMessage.style.display = 'none';
          }, 3000);
        } else {
          alert('Failed to add sub-activity: ' + response.message);
        }
      },
      error: function(xhr, status, error) {
        console.error('Error adding sub-activity:', error);
        alert('Failed to add sub-activity. Please try again.');
      }
    });
  });
  
  // Ensure page refresh when modal is closed
  document.getElementById('subActivityModal').addEventListener('hidden.bs.modal', function() {
    location.reload();
  });
});
</script>
<script>
  $(document).ready(function() {
    $('#activityModal').on('hidden.bs.modal', function () {
      location.reload();
    });
  });
</script>
<script>
  $(document).ready(function() {
    $('#subActivityModal').on('hidden.bs.modal', function () {
      location.reload();
    });
  });
</script>

</body>
</html>