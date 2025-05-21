<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Observation List | Mydiaree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.1.1" />
    <link rel="stylesheet"
        href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.1.1" />

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.1.1" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?v=1.1.1" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.1.1" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?v=1.1.1" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css?v=1.1.1" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?v=1.1.1" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.1.1" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.1.1" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.1.1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    .list-thumbnail {
        height: 150px !important;
        width: 200px !important;
    }

    .obs-link {
        color: #008ecc;
    }

    .obs-link:hover {
        color: #000000;
    }

    .br-10 {
        border-radius: 10px;
    }



    @media (max-width: 575px) {
        .top-right-button-container {
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 10px;
        }

        .filterbutton {
            width: 100% !important;
            ;
        }
    }
    </style>
    <style>
    .list-thumbnail {
        max-width: 100px;
        height: 75px;
        object-fit: cover;
        border-radius: 4px;
    }

    .checkbox input[type="checkbox"] {
        margin-top: 0;
    }

    #observationsList .checkbox:hover {
        background-color: #f8f9fa;
    }

    .icon-actions {
        min-width: 60px;
        /* Width of right icons area */
        text-align: center;
    }

    .icon-actions i {
        font-size: 22px;
        margin-bottom: 30px;
    }

    .list-thumbnail {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
    }

    </style>
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <main data-centerid="<?= $centerid; ?>">
        <div class="container-fluid">
            <div class="d-flex ">
                <div class="col-12 ">
                    <h1>Observation List</h1>
                    <?php 
                            $role = $this->session->userdata('UserType');
                         ?>

                    <div class="text-zero top-right-button-container ">
                        <?php if($role!="Parent"){ ?>
                        <button class="btn btn-outline-primary btn-lg mr-1 filterbutton" data-toggle="modal"
                            data-backdrop="static" data-target="#filtersModal">
                            FILTERS
                        </button>
                        <?php }   ?>

                        <div class="btn-group mr-1 filterbutton">
                            <?php 
                                $dupArr = [];
                                $centersList = $this->session->userdata("centerIds");
                                if (empty($centersList)) {
                            ?>
                            <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> EMPTY CENTER </div>
                            <?php
                                }else{
                                    if (isset($_GET['centerid'])) {
                                        foreach($centersList as $key => $center){
                                            if ( ! in_array($center, $dupArr)) {
                                                if ($_GET['centerid']==$center->id) {
                            ?>
                            <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= strtoupper($center->centerName); ?> </div>
                            <?php
                                                }
                                            }
                                            array_push($dupArr, $center);
                                        }
                                    } else {
                            ?>
                            <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= strtoupper($centersList[0]->centerName); ?> </div>
                            <?php
                                    }
                                }

                                if (!empty($centersList)) {
                            ?>
                            <P><?php// print_r($centersList); ?></P>
                            <div class="dropdown-menu dropdown-menu-right ">
                                <?php foreach($centersList as $key => $center){ ?>
                                <a class="dropdown-item filterbutton"
                                    href="<?= current_url().'?centerid='.$center->id; ?>">
                                    <?= strtoupper($center->centerName); ?>
                                </a>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>

                        <?php 
                            $role = $this->session->userdata('UserType');
                         
                            

                            if ($role=="Staff") {
                                $showList = 1;
                                // $show = 1;
                                if (isset($permissions)) {
                                    if ($permissions->addObservation == 1) {
                                        $show = 1;
                                    } else {
                                        $show = 0;
                                    }

                                    if ($permissions->viewAllObservation == 1) {
                                        $showList = 1;
                                    } else {
                                        $showList = 0;
                                    }
                                    
                                }else {
                                    $show = 0;
                                    $showList = 0;
                                }
                              
                            } else {
                                $show = 1;
                                $showList = 1;
                            }
                            
                            if ($show == 1) {
                                if(isset($_GET['centerid']) && is_numeric($_GET['centerid'])){
                                    $newObsUrl = base_url('observation/addNew')."?centerid=".$_GET['centerid'];
                                }else{
                                    $newObsUrl = base_url('observation/addNew');
                                }
                        ?>

                        <?php if($role!="Parent"){ ?>
                        <a type="button" class="btn btn-primary btn-lg top-right-button" href="<?= $newObsUrl; ?>">ADD
                            NEW</a>
                        <?php } ?>

                        <?php } ?>

                        <?php if($role!="Parent"){ ?>
                        <button id="checkDraftObservationsBtn" class="btn btn-outline-danger"
                            style="margin-left:5px;">Draft Observations</button>
                        <?php } ?>
                    </div>

                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Observation List</li>


                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>

            <div class="row" id="observations-list">
                <?php 
                    if($showList == 1){ 
                        if (!empty($observations)) {
                            foreach($observations as $observation) {
                                $obsId = $observation->id; 
                ?>
                <h1><?php //echo $obsId; ?></h1>




                <!-- <div class="col-lg-6 col-md-3">
                    <div class="d-flex flex-row mb-3 bg-white br-10">
                        <?php if($role!="Parent"){ ?>
                        <a class="d-block position-relative" href="<?= base_url('observation/view?id='.$obsId); ?>">
                            <?php }else{ ?>
                            <a class="d-block position-relative" href="<?= base_url('observation/print/') . $obsId ?>"
                                target="_blank">
                                <?php } ?>

                                <?php if(empty($observation->observationsMedia)) { ?>
                                <img src="https://skala.or.id/wp-content/uploads/2024/01/dummy-post-square-1-1.jpg"
                                    alt="No Media" class="list-thumbnail border-0">
                                <?php 
                                } else{ 
                                    if($observation->observationsMediaType=='Image') {
                                        if (file_exists('api/assets/media/'.$observation->observationsMedia)) {
                            ?>
                                <img src="<?= base_url('/api/assets/media/'.$observation->observationsMedia); ?>"
                                    alt="Image" class="list-thumbnail border-0">
                                <?php } else { ?>
                                <img src="https://via.placeholder.com/320x240?text=Media+Deleted" alt="Image"
                                    class="list-thumbnail border-0">
                                <?php
                                        }
                                    } else if($observation->observationsMediaType=='Video') {
                            ?>
                                <img src="<?= base_url('/api/assets/media/video-thumb.jpg'); ?>" alt="video"
                                    class="list-thumbnail border-0">
                                <?php
                                    }
                                } 
                            
                                if($observation->status=='Published') {
                            ?>
                                <span
                                    class="badge badge-pill position-absolute badge-top-right badge-success">PUBLISHED</span>
                                <?php }else{ ?>
                                <span
                                    class="badge badge-pill position-absolute badge-top-right badge-danger">DRAFT</span>
                                <?php } ?>
                            </a>
                            <div class="pl-5 pt-2 pr-2 pb-2">
                                <?php if($role!="Parent"){ ?>
                                <a href="<?= base_url('observation/view?id='.$obsId); ?>" class="obs-link">
                                    <?php }else{ ?>
                                    <a href="<?= base_url('observation/print/'.$obsId); ?>" class="obs-link"
                                        target="_blank">
                                        <?php } ?>

                                        <p class="list-item-heading">
                                            <?= substr_replace(strip_tags(html_entity_decode($observation->title)),'...',40); ?>
                                        </p>
                                        <div class="pr-4 d-none d-sm-block">
                                            <p class="text-muted mb-1 text-small">
                                                By: <?= $observation->user_name; ?>
                                            </p>
                                        </div>
                                        <div class="text-primary text-small font-weight-medium d-none d-sm-block">
                                            <?= date("d.m.Y",strtotime($observation->date_added)); ?>
                                        </div>
                                    </a>
                            </div>

                            <?php if($role!="Parent"){ ?>
                            <div class="pl-5 pt-2 pr-2 pb-2">
                                <a href="<?= base_url('observation/print/') . $obsId ?>" target="_blank">
                                    <i class="fa-solid fa-print fa-beat fa-lg" style="color: #74C0FC;"></i>
                                </a>
                            </div>
                            <?php }   ?>

                            <?php if($role!="Parent"){ ?>
                            <div class="pl-5 pt-2 pr-2 pb-2">
                                <i class="fa-sharp fa-solid fa-trash fa-lg" style="color: #da0711;cursor:pointer;"
                                    onclick="deleteObservation(<?php echo $obsId; ?>)"></i>
                            </div>
                            <?php }   ?>

                            <?php if($role=="Parent"){ ?>
                            <div class="pl-5 pt-2 pr-2 pb-2">
                                <i class="fa-solid fa-comment fa-bounce" style="color: #74C0FC;cursor:pointer;"
                                    onclick="openAddCommentModal(<?php echo $obsId; ?>)"> Add Comments</i>
                            </div>
                            <?php }   ?>


                    </div>
                </div> -->






                <div class="col-lg-6 col-md-3">
                    <div class="d-flex flex-row mb-3 bg-white br-10 align-items-center justify-content-between p-3">

                        <!-- LEFT SIDE: Image + Content -->
                        <div class="d-flex flex-row align-items-center">

                            <?php if($role!="Parent"){ ?>
                            <a class="d-block position-relative" href="<?= base_url('observation/view?id='.$obsId); ?>">
                                <?php } else { ?>
                                <a class="d-block position-relative"
                                    href="<?= base_url('observation/print/'.$obsId); ?>" target="_blank">
                                    <?php } ?>

                                    <!-- Image Part -->
                                    <?php if(empty($observation->observationsMedia)) { ?>
                                    <img src="https://skala.or.id/wp-content/uploads/2024/01/dummy-post-square-1-1.jpg"
                                        alt="No Media" class="list-thumbnail border-0"
                                        style="width:100px;height:100px;object-fit:cover;">
                                    <?php 
                          } else { 
                       if($observation->observationsMediaType == 'Image') {
                    if(file_exists('api/assets/media/'.$observation->observationsMedia)) {
                          ?>
                                    <img src="<?= base_url('/api/assets/media/'.$observation->observationsMedia); ?>"
                                        alt="Image" class="list-thumbnail border-0"
                                        style="width:100px;height:100px;object-fit:cover;">
                                    <?php } else { ?>
                                    <img src="https://via.placeholder.com/320x240?text=Media+Deleted" alt="Image"
                                        class="list-thumbnail border-0"
                                        style="width:100px;height:100px;object-fit:cover;">
                                    <?php
                     }
                       } else if($observation->observationsMediaType == 'Video') {
                      ?>
                                    <img src="<?= base_url('/api/assets/media/video-thumb.jpg'); ?>" alt="Video"
                                        class="list-thumbnail border-0"
                                        style="width:100px;height:100px;object-fit:cover;">
                                    <?php
                   }
                     } 
            
                    if($observation->status=='Published') {
                       ?>
                                    <span
                                        class="badge badge-pill position-absolute badge-top-right badge-success">PUBLISHED</span>
                                    <?php } else { ?>
                                    <span
                                        class="badge badge-pill position-absolute badge-top-right badge-danger">DRAFT</span>
                                    <?php } ?>

                                </a>

                                <!-- Title and Details -->
                                <div class="pl-3">
                                    <?php if($role!="Parent"){ ?>
                                    <a href="<?= base_url('observation/view?id='.$obsId); ?>" class="obs-link">
                                        <?php } else { ?>
                                        <a href="<?= base_url('observation/print/'.$obsId); ?>" class="obs-link"
                                            target="_blank">
                                            <?php } ?>

                                         <p class="list-item-heading mb-1">
    <?= !empty($observation->obestitle) 
        ? strip_tags(($observation->obestitle)) 
        : substr_replace(strip_tags(html_entity_decode($observation->title)), '...', 40); ?>
</p>
                                        </a>

                                        <p class="text-muted mb-1 text-small">
                                            By: <?= $observation->user_name ?? 'Unknown'; ?>
                                        </p>

                                        <p class="text-primary text-small font-weight-medium mb-0">
                                            <?= date("d.m.Y",strtotime($observation->date_added)); ?>
                                        </p>
                                </div>

                        </div>

                        <!-- RIGHT SIDE: Icons (Print/Delete/Comment) -->
                        <div class="d-flex flex-column align-items-center icon-actions">
                            <?php if($role!="Parent"){ ?>
                            <a href="<?= base_url('observation/print/') . $obsId ?>" target="_blank" class="mb-2">
                                <i class="fa-solid fa-print fa-lg fa-beat" style="color: #74C0FC;"></i>
                            </a>
                            <i class="fa-sharp fa-solid fa-trash fa-lg fa-fade" style="color: #da0711;cursor:pointer;"
                                onclick="deleteObservation(<?php echo $obsId; ?>)"></i>
                            <?php } else { ?>
                            <i class="fa-solid fa-comment fa-bounce fa-sm" style="color: #74C0FC;cursor:pointer;"
                                onclick="openAddCommentModal(<?php echo $obsId; ?>)"></i>
                            <?php } ?>
                        </div>

                    </div>
                </div>

                <?php } }else{ ?>
                <div class="col">
                    <div class="text-center">
                        <h6 class="mb-4">You don't have any Observations, Create New Observations.....</h6>
                        <!-- <p class="mb-0 text-muted text-small mb-0">Error code</p> -->
                        <!-- <p class="display-1 font-weight-bold mb-5"> -->
                        <!-- 200 -->
                        <!-- </p> -->
                        <a href="<?= base_url('dashboard'); ?>" class="btn btn-primary btn-lg btn-shadow">GO BACK
                            HOME</a>
                    </div>
                </div>
                <?php 
                        }
                    }else{ 
                ?>
                <div class="col">
                    <div class="text-center">
                        <h6 class="mb-4">Ooops... looks like you lack of permission!</h6>
                        <p class="mb-0 text-muted text-small mb-0">Error code</p>
                        <p class="display-1 font-weight-bold mb-5">
                            303
                        </p>
                        <a href="<?= base_url('dashboard'); ?>" class="btn btn-primary btn-lg btn-shadow">GO BACK
                            HOME</a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </main>

    <?php $this->load->view('footer_v3'); ?>

    <div class="modal fade modal-right" id="filtersModal" tabindex="-1" role="dialog"
        aria-labelledby="filtersModalRight" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filters</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="accordion">
                            <div class="border">
                                <button class="btn btn-link dropdown-toggle" data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Status
                                </button>
                                <div id="collapseOne" class="collapse show " data-parent="#accordion">
                                    <div class="p-4">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="status_draft" name="obs_status_filter"
                                                class="custom-control-input filter_observation" value="Draft">
                                            <label class="custom-control-label" for="status_draft">Draft</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="status_published" name="obs_status_filter"
                                                class="custom-control-input filter_observation" value="Published">
                                            <label class="custom-control-label" for="status_published">Published</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border">
                                <button class="btn btn-link dropdown-toggle collapsed" data-toggle="collapse"
                                    data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Added
                                </button>
                                <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                    <div class="p-4">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="added_none" name="filter_added"
                                                class="custom-control-input filter_added" value="None">
                                            <label class="custom-control-label" for="added_none">None</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="added_today" name="filter_added"
                                                class="custom-control-input filter_added" value="Today">
                                            <label class="custom-control-label" for="added_today">Today</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="added_this_week" name="filter_added"
                                                class="custom-control-input filter_added" value="This Week">
                                            <label class="custom-control-label" for="added_this_week">This Week</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="added_this_month" name="filter_added"
                                                class="custom-control-input filter_added" value="This Month">
                                            <label class="custom-control-label" for="added_this_month">This
                                                Month</label>
                                        </div>

                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="added_custom" name="filter_added"
                                                class="custom-control-input filter_added" value="Custom">
                                            <label class="custom-control-label" for="added_custom">Custom Date</label>
                                        </div>
                                        <div id="custom_date_range" style="display:none; margin-top: 10px;">
                                            <input type="date" id="from_date" class="form-control mb-2"
                                                placeholder="From Date">
                                            <input type="date" id="to_date" class="form-control" placeholder="To Date">
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="border">
                                <button class="btn btn-link dropdown-toggle collapsed" data-toggle="collapse"
                                    data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Child
                                </button>
                                <div id="collapseThree" class="collapse" data-parent="#accordion">
                                    <div class="p-4">
                                        <div class="custom-control custom-checkbox mb-4">
                                            <input type="checkbox" class="custom-control-input filter_child"
                                                id="fitler_child_selectall" value="All">
                                            <label class="custom-control-label" for="fitler_child_selectall">Select
                                                All</label>
                                        </div>
                                        <?php 
                                        if (isset($childs)) {
                                            foreach($childs as $child) {
                                        ?>
                                        <div class="custom-control custom-checkbox mb-4">
                                            <input type="checkbox" class="custom-control-input filter_child"
                                                id="<?= "filter_child_".$child->name; ?>" value="<?= $child->id; ?>">
                                            <label class="custom-control-label"
                                                for="<?= "filter_child_".$child->name; ?>"><?= $child->name; ?></label>
                                        </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="border">
                                <button class="btn btn-link dropdown-toggle collapsed" data-toggle="collapse"
                                    data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Author
                                </button>
                                <div id="collapseFour" class="collapse" data-parent="#accordion">
                                    <div class="p-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_author"
                                                id="filter_author_any" value="Any">
                                            <label class="custom-control-label" for="filter_author_any">Any</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_author"
                                                id="filter_author_me" value="Me">
                                            <label class="custom-control-label" for="filter_author_me">Me</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_author"
                                                id="filter_author_staff" value="Staff">
                                            <label class="custom-control-label" for="filter_author_staff">Staff</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="border">
                                <button class="btn btn-link dropdown-toggle collapsed" data-toggle="collapse"
                                    data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Assessments </button>
                                <div id="collapseFive" class="collapse" data-parent="#accordion">
                                    <div class="p-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_assessment"
                                                id="filter_assessment_1" value="Does Not Have Any Assessment">
                                            <label class="custom-control-label" for="filter_assessment_1">Does Not Have
                                                Any Assessment</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_assessment"
                                                id="filter_assessment_2" value="Has Montessori">
                                            <label class="custom-control-label" for="filter_assessment_2">Has
                                                Montessori</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_assessment"
                                                id="filter_assessment_3" value="Has Early Years Learning Framework">
                                            <label class="custom-control-label" for="filter_assessment_3">Has Early
                                                Years Learning Framework</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_assessment"
                                                id="filter_assessment_4" value="Has Developmental Milestones">
                                            <label class="custom-control-label" for="filter_assessment_4">Has
                                                Developmental Milestones</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_assessment"
                                                id="filter_assessment_5" value="Does Not Have Montessori">
                                            <label class="custom-control-label" for="filter_assessment_5">Does Not Have
                                                Montessori</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_assessment"
                                                id="filter_assessment_6"
                                                value="Does Not Have Early Years Learning Framework">
                                            <label class="custom-control-label" for="filter_assessment_6">Does Not Have
                                                Early Years Learning Framework</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_assessment"
                                                id="filter_assessment_7" value="Does Not Have Developmental Milestones">
                                            <label class="custom-control-label" for="filter_assessment_7">Does Not Have
                                                Developmental Milestones</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border">
                                <button class="btn btn-link dropdown-toggle collapsed" data-toggle="collapse"
                                    data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    Media
                                </button>
                                <div id="collapseSix" class="collapse" data-parent="#accordion">
                                    <div class="p-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_media"
                                                id="filter_media_1" value="Any">
                                            <label class="custom-control-label" for="filter_media_1">Any</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_media"
                                                id="filter_media_2" value="Image">
                                            <label class="custom-control-label" for="filter_media_2">Image</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_media"
                                                id="filter_media_3" value="Video">
                                            <label class="custom-control-label" for="filter_media_3">Video</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border">
                                <button class="btn btn-link dropdown-toggle collapsed" data-toggle="collapse"
                                    data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                    Comments
                                </button>
                                <div id="collapseSeven" class="collapse" data-parent="#accordion">
                                    <div class="p-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_comment"
                                                id="filter_comment_1" value="Any">
                                            <label class="custom-control-label" for="filter_comment_1">Any</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_comment"
                                                id="filter_comment_2" value="With Comments">
                                            <label class="custom-control-label" for="filter_comment_2">With
                                                Comments</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_comment"
                                                id="filter_comment_3" value="With Staff Comments">
                                            <label class="custom-control-label" for="filter_comment_3">With Staff
                                                Comments</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_comment"
                                                id="filter_comment_4" value="With Relative Comments">
                                            <label class="custom-control-label" for="filter_comment_4">With Relative
                                                Comments</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_comment"
                                                id="filter_comment_5" value="No Comments">
                                            <label class="custom-control-label" for="filter_comment_5">No
                                                Comments</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_comment"
                                                id="filter_comment_6" value="No Staff Comments">
                                            <label class="custom-control-label" for="filter_comment_6">No Staff
                                                Comments</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_comment"
                                                id="filter_comment_7" value="No Relative Comments">
                                            <label class="custom-control-label" for="filter_comment_7">No Relative
                                                Comments</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border">
                                <button class="btn btn-link dropdown-toggle collapsed" data-toggle="collapse"
                                    data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                    Links
                                </button>
                                <div id="collapseEight" class="collapse" data-parent="#accordion">
                                    <div class="p-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_link"
                                                id="filter_link_1" value="Not Filtered">
                                            <label class="custom-control-label" for="filter_link_1">Not Filtered</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_link"
                                                id="filter_link_2" value="Linked to anything">
                                            <label class="custom-control-label" for="filter_link_2">Linked to
                                                anything</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_link"
                                                id="filter_link_3" value="Not Linked to anything">
                                            <label class="custom-control-label" for="filter_link_3">Not Linked to
                                                anything</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_link"
                                                id="filter_link_4" value="Linked to observations">
                                            <label class="custom-control-label" for="filter_link_4">Linked to
                                                observations</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_link"
                                                id="filter_link_5" value="Not Linked to observations">
                                            <label class="custom-control-label" for="filter_link_5">Not Linked to
                                                observations</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_link"
                                                id="filter_link_6" value="Linked to reflections">
                                            <label class="custom-control-label" for="filter_link_6">Linked to
                                                reflections</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input filter_link"
                                                id="filter_link_7" value="Not Linked to reflections">
                                            <label class="custom-control-label" for="filter_link_7">Not Linked to
                                                reflections</label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button class="btn btn-primary" id="btn-apply-filters">Apply Filters</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Draft Observations Modal -->
    <div class="modal fade" id="draftObservationsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <!-- Changed to modal-xl -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Draft Observations (14+ Days Old)</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height:500px;overflow-y:auto;">
                    <div id="observationCount" class="mb-3"></div>
                    <div id="observationsList"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" onclick="deleteSelectedObservations()">Delete
                        Selected</button>
                    <button type="button" class="btn btn-outline-success"
                        onclick="publishSelectedObservations()">Publish Selected</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal for comments -->
    <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="commentModalLabel">Observation Comments</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Comment form -->
                    <form id="commentForm">
                        <input type="hidden" id="observationId" name="observationId">
                        <div class="form-group">
                            <label for="commentText">Add a comment:</label>
                            <textarea class="form-control" id="commentText" name="commentText" rows="3"
                                required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Comment</button>
                    </form>

                    <hr>

                    <!-- Comment list -->
                    <h6>All Comments</h6>
                    <div id="commentsList" class="mt-3">
                        <!-- Comments will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>





    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.1.1"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.1.1"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.1.1"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.1.1"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.1.1"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.1.1"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.1.1"></script>

    <!-- jQuery CDN -->

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>




    <script>

    // Handle "Select All" functionality
    $(document).ready(function() {
        // Handle "Select All" checkbox click
        $('#fitler_child_selectall').change(function() {
            $('.filter_child:not(#fitler_child_selectall)').prop('checked', $(this).prop('checked'));
        });

        // Update "Select All" when individual checkboxes change
        $('.filter_child:not(#fitler_child_selectall)').change(function() {
            var allChecked = $('.filter_child:not(#fitler_child_selectall)').length ===
                $('.filter_child:not(#fitler_child_selectall):checked').length;
            $('#fitler_child_selectall').prop('checked', allChecked);
        });
    });


    $(function() {
        function filters() {
            var childs = getSelectedChildIds();

            // Define this function elsewhere in your code
            function getSelectedChildIds() {
                var childs = [];
                var hasSelectAll = false;

                $('.filter_child').each(function() {
                    if ($(this).prop("checked") == true) {
                        if ($(this).val() == 'All') {
                            hasSelectAll = true;
                        } else {
                            // Only add if not already in the array (prevents duplicates)
                            if (childs.indexOf($(this).val()) === -1) {
                                childs.push($(this).val());
                            }
                        }
                    }
                });

                // If "Select All" is checked, get all child IDs
                if (hasSelectAll) {
                    childs = []; // Reset array
                    $('.filter_child:not(#fitler_child_selectall)').each(function() {
                        // Only add if not already in the array (prevents duplicates)
                        if (childs.indexOf($(this).val()) === -1) {
                            childs.push($(this).val());
                        }
                    });
                }

                return childs;
            }

            var authors = [];
            $('.filter_author').each(function() {
                if ($(this).prop("checked") == true) {
                    authors.push($(this).val());
                }
            });

            // var assessments = [];
            // $('.filter_assessment').each(function() {
            //     if ($(this).prop("checked") == true) {
            //         assessments.push($(this).val());
            //     }
            // });

            var observations = [];
            $('.filter_observation').each(function() {
                if ($(this).prop("checked") == true) {
                    observations.push($(this).val());
                }
            });

            // var added = [];
            // $('.filter_added').each(function() {
            //     if ($(this).prop("checked") == true) {
            //         if ($(this).val() == 'All') {
            //             added = [];
            //             return false;
            //         } else {
            //             added.push($(this).val());
            //         }
            //     }
            // });

            var added = [];
            var fromDate = '';
            var toDate = '';

            $('.filter_added').each(function() {
                if ($(this).prop("checked") == true) {
                    let val = $(this).val();
                    if (val == 'All') {
                        added = [];
                        return false;
                    } else {
                        added.push(val);
                        if (val === 'Custom') {
                            fromDate = $('#from_date').val();
                            toDate = $('#to_date').val();
                        }
                    }
                }
            });


            // var media = [];
            // $('.filter_media').each(function() {
            //     if ($(this).prop("checked") == true) {
            //         if ($(this).val() == 'Any') {
            //             media = [];
            //             return false;
            //         } else {
            //             media.push($(this).val());
            //         }
            //     }
            // });

            // var comments = [];
            // $('.filter_comment').each(function() {
            //     if ($(this).prop("checked") == true) {
            //         if ($(this).val() == 'Any') {
            //             comments = [];
            //             return false;
            //         } else {
            //             comments.push($(this).val());
            //         }
            //     }
            // });

            // var links = [];
            // $('.filter_link').each(function() {
            //     if ($(this).prop("checked") == true) {
            //         if ($(this).val() == 'Not Filtered') {
            //             links = [];
            //             return false;
            //         } else {
            //             links.push($(this).val());
            //         }
            //     }
            // });

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('observation/listfilters'); ?>',
                data: 'childs=' + childs + '&authors=' + authors +
                    '&observations=' + observations + '&added=' + added + '&fromDate=' + fromDate +
                    '&toDate=' + toDate,
                // data: 'childs=' + childs + '&authors=' + authors + '&assessments=' + assessments +
                //     '&observations=' + observations + '&added=' + added + '&media=' + media +
                //     '&comments=' + comments + '&links=' + links,
                datatype: 'json',
                success: function(json) {
                    json = JSON.parse(json);
                    if (json.Status == "SUCCESS") {
                        $('#observations-list').empty();
                        $.each(json.observations, function(key, val) {
                            var _status = '';
                            var _mediaUrl = '';
                            var _role =
                            '<?= $role ?>'; // You must pass the PHP role into JavaScript

                            // Media Handling
                            if (val.media == "" || val.media == null) {
                                _mediaUrl =
                                    "https://skala.or.id/wp-content/uploads/2024/01/dummy-post-square-1-1.jpg";
                            } else {
                                _mediaUrl = "<?= base_url('/api/assets/media/'); ?>" + val
                                    .media;
                            }

                            // Status Badge
                            if (val.status == "Published") {
                                _status =
                                    `<span class="badge badge-pill position-absolute badge-top-right badge-success">PUBLISHED</span>`;
                            } else {
                                _status =
                                    `<span class="badge badge-pill position-absolute badge-top-right badge-danger">DRAFT</span>`;
                            }

                            // Link based on Role
                            var viewLink = (_role !== "Parent") ?
                                "<?= base_url('observation/view?id='); ?>" + val.id :
                                "<?= base_url('observation/print/'); ?>" + val.id;

                            var targetAttr = (_role !== "Parent") ? '' : 'target="_blank"';

                            // Icons on Right side
                            var iconsHtml = '';
                            if (_role !== "Parent") {
                                iconsHtml = `
                    <a href="<?= base_url('observation/print/'); ?>${val.id}" target="_blank" class="mb-2">
                        <i class="fa-solid fa-print fa-lg fa-beat" style="color: #74C0FC;"></i>
                    </a>
                    <i class="fa-sharp fa-solid fa-trash fa-lg fa-fade" style="color: #da0711;cursor:pointer;" onclick="deleteObservation(${val.id})"></i>
                `;
                            } else {
                                iconsHtml = `
                    <i class="fa-solid fa-comment fa-bounce fa-sm" style="color: #74C0FC;cursor:pointer;" onclick="openAddCommentModal(${val.id})"></i>
                `;
                            }

                            // Now build full card
                            $('#observations-list').append(`
                <div class="col-lg-6 col-md-3">
                    <div class="d-flex flex-row mb-3 bg-white br-10 align-items-center justify-content-between p-3">

                        <div class="d-flex flex-row align-items-center">
                            <a class="d-block position-relative" href="${viewLink}" ${targetAttr}>
                                <img src="${_mediaUrl}" alt="Media" class="list-thumbnail border-0" style="width:100px;height:100px;object-fit:cover;">
                                ${_status}
                            </a>

                            <div class="pl-3">
                                <a href="${viewLink}" class="obs-link" ${targetAttr}>
                                    <p class="list-item-heading mb-1">
                                        ${val.title.length > 40 ? val.title.substring(0, 40) + '...' : val.title}
                                    </p>
                                </a>

                                <p class="text-muted mb-1 text-small">
                                    By: ${val.userName ?? 'Unknown'}
                                </p>

                                <p class="text-primary text-small font-weight-medium mb-0">
                                    ${val.date_added}
                                </p>
                            </div>
                        </div>

                        <div class="d-flex flex-column align-items-center icon-actions">
                            ${iconsHtml}
                        </div>

                    </div>
                </div>
            `);
                        });
                        $('#btn-apply-filters').prop('disabled', false).html('Apply Filters');
                    } else {
                        alert(json.Message);
                        $('#btn-apply-filters').prop('disabled', false).html('Apply Filters');
                    }
                }



            });
        }

        $('#btn-apply-filters').on('click', function() {
            // console.log("filter clicked");
            $(this).prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                );
            filters();
        });


    });





    function loadDraftObservations() {
        $.ajax({
            url: '<?= base_url("observation/getDraftObservations") ?>',
            type: 'GET',
            success: function(response) {
                const data = typeof response === 'string' ? JSON.parse(response) : response;
                console.log(data);
                if (data.status === 'success') {
                    // Show count
                    $('#observationCount').html(`<strong>${data.count} draft observations found</strong>`);

                    // Generate list
                    let html = '<div class="form-group">';

                    function processTitle(title, maxLength = 40) {
                        // Decode HTML entities
                        const textArea = document.createElement('textarea');
                        textArea.innerHTML = title;
                        let decodedTitle = textArea.value;

                        // Strip HTML tags
                        decodedTitle = decodedTitle.replace(/<[^>]*>/g, '');

                        // Truncate the string and append '...' if it exceeds maxLength
                        if (decodedTitle.length > maxLength) {
                            decodedTitle = decodedTitle.substring(0, maxLength) + '...';
                        }

                        return decodedTitle;
                    }

                    if (data.count > 0) {
                        data.observations.forEach(obs => {
                            const date = new Date(obs.date_added).toLocaleDateString();
                            const processedTitle = processTitle(obs.title);
                            const imageUrl = obs.mediaUrl ?
                                `<?= base_url('/api/assets/media/') ?>${obs.mediaUrl}` :
                                'https://via.placeholder.com/320x240?text=Media+Deleted';

                            html += `
                            <div class="checkbox d-flex align-items-center mb-3 p-2 border rounded">
                                <div class="mr-3">
                                    <input type="checkbox" name="observation" value="${obs.id}">
                                </div>
                                <div class="mr-3" style="width: 100px;">
                                    <img src="${imageUrl}" 
                                         alt="Observation Media" 
                                         class="list-thumbnail border-0"
                                         style="width: 100%; height: auto;">
                                </div>
                                <div style="margin-left:100px;">
                                    <label class="mb-0">
                                    ${processedTitle}
                                        <br>
                                        <small class="text-muted">Created: ${date}</small>
                                        <span class="badge badge-warning ml-2">Draft</span>
                                    </label>
                                </div>
                            </div>
                        `;
                        });
                    } else {
                        html += '<p>No draft observations older than 14 days found.</p>';
                    }

                    html += '</div>';
                    $('#observationsList').html(html);
                    $('#draftObservationsModal').modal('show');
                } else {
                    alert('Error loading observations. Please try again.');
                }
            },
            error: function() {
                alert('Failed to connect to the server. Please try again.');
            }
        });
    }

    function updateObservations(action) {
        const selectedIds = [];
        $('input[name="observation"]:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            alert('Please select at least one observation.');
            return;
        }

        if (action === 'delete' && !confirm('Are you sure you want to delete the selected observations?')) {
            return;
        }

        $.ajax({
            url: '<?= base_url("observation/updateObservations") ?>',
            type: 'POST',
            data: {
                action: action,
                selectedIds: JSON.stringify(selectedIds)
            },
            success: function(response) {
                const result = typeof response === 'string' ? JSON.parse(response) : response;

                if (result.status === 'success') {
                    alert(action === 'delete' ? 'Observations deleted successfully!' :
                        'Observations published successfully!');
                    loadDraftObservations(); // Reload the list
                } else {
                    alert('Error updating observations. Please try again.');
                }
            },
            error: function() {
                alert('Failed to connect to the server. Please try again.');
            }
        });
    }

    // Helper functions for the buttons
    function deleteSelectedObservations() {
        updateObservations('delete');
    }

    function publishSelectedObservations() {
        updateObservations('publish');
    }

    // Add event listener for the check button
    $(document).ready(function() {
        $('#checkDraftObservationsBtn').click(function() {
            loadDraftObservations();
        });
    });
    </script>

    <script>
    function deleteObservation(observationId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Perform AJAX delete
                $.ajax({
                    url: '<?= base_url("observation/delete_observation") ?>',
                    type: 'POST',
                    data: {
                        observation_id: observationId
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Observation has been deleted.',
                                'success'
                            ).then(() => {
                                // Reload the page after deletion
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'Failed to delete observation.',
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'Something went wrong with the request.',
                            'error'
                        );
                    }
                });
            }
        });
    }
    </script>




    <script>
    function openAddCommentModal(obsId) {
        $('#observationId').val(obsId);
        $('#commentModal').modal('show');
        loadComments(obsId);
    }

    function loadComments(obsId) {
        $.ajax({
            url: '<?php echo base_url("observation/getComments"); ?>',
            type: 'POST',
            data: {
                observationId: obsId
            },
            dataType: 'json',
            success: function(response) {
                var html = '';
                if (response.comments.length > 0) {
                    $.each(response.comments, function(index, comment) {
                        html += '<div class="card mb-2">';
                        html += '<div class="card-body p-3">';
                        html += '<p class="mb-1">' + comment.comments + '</p>';
                        html += '<div class="d-flex justify-content-between">';
                        html += '<small class="text-muted">By ' + comment.userName + ' on ' +
                            comment.date_added + '</small>';
                        if (comment.userId == <?php echo $this->session->userdata('LoginId'); ?>) {
                            html +=
                                '<button class="btn btn-sm btn-danger" onclick="deleteComment(' +
                                comment.id + ')"><i class="fa fa-trash"></i> Delete</button>';
                        }
                        html += '</div></div></div>';
                    });
                } else {
                    html = '<p class="text-muted">No comments yet.</p>';
                }
                $('#commentsList').html(html);
            },
            error: function() {
                alert('Error loading comments. Please try again.');
            }
        });
    }

    function deleteComment(commentId) {
        if (confirm('Are you sure you want to delete this comment?')) {
            $.ajax({
                url: '<?php echo base_url("observation/deleteComment"); ?>',
                type: 'POST',
                data: {
                    commentId: commentId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        loadComments($('#observationId').val()); // Reload comments
                        toastr.success('Comment deleted successfully');
                    } else {
                        toastr.error('Error deleting comment');
                    }
                },
                error: function() {
                    toastr.error('Error deleting comment. Please try again.');
                }
            });
        }
    }

    $(document).ready(function() {
        $('#commentForm').submit(function(e) {
            e.preventDefault();

            var observationId = $('#observationId').val();
            var commentText = $('#commentText').val();

            if (commentText.trim() === '') {
                toastr.error('Please enter a comment');
                return false;
            }

            $.ajax({
                url: '<?php echo base_url("observation/addComment"); ?>',
                type: 'POST',
                data: {
                    observationId: observationId,
                    commentText: commentText
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#commentText').val(''); // Clear the form
                        loadComments(observationId); // Reload comments
                        toastr.success('Comment added successfully');
                    } else {
                        toastr.error('Error adding comment');
                    }
                },
                error: function() {
                    toastr.error('Error adding comment. Please try again.');
                }
            });
        });
    });


    $('input[name="filter_added"]').change(function() {
        if ($(this).val() == 'Custom') {
            $('#custom_date_range').show();
        } else {
            $('#custom_date_range').hide();
            $('#from_date').val('');
            $('#to_date').val('');
        }
    });

    </script>


</body>/

</html>