<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Element | Mykronicle v2</title>
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0"/>
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <style>
        .img-cicle{
            height: 50px;
            width: 50px;
            border-radius: 50%;
        }
        .qip-educators-section{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .qip-educators-add{
            text-align: right;
        }
        .qip-educators-images{
            padding-left: 30px;
        }
        .user-name{
            font-size: 17px;
        }
    </style>
</head>
<body id="app-container" class="menu-default show-spinner">
<?php $this->load->view('sidebar'); ?> 
    <main data-centerid="<?= isset($Centerid)?$Centerid:null; ?>">
        <div class="default-transition">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <h1>Edit Standard</h1>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('Qip').'?centerid=' . $Centerid; ?>">QIP</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('qip/edit').'?id=' . $_GET['qipid']; ?>">Edit QIP</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('qip/view').'?qipid=' . $_GET['qipid'].'&areaid='.$_GET['areaid']; ?>">Standard & Element</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Element</li>
                            </ol>
                        </nav>
                        <div class="text-zero top-right-button-container">
                            <div class="btn-group mr-1">
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-outline-primary mb-1" type="button" id="educatorsBtn" data-toggle="modal" data-target="#educatorsModal"> ADD EDUCATORS </button>
                                </div>
                            </div>
                        </div>
                        <div class="separator mb-5"></div>
                    </div>
                </div>
                <div id="qipDropdown" class="row mb-5">
                    <div class="col-4">
                        <select id="areaDropdown" class="form-control">
                            <option value="" hidden>-- Select Area --</option>
                            <?php 
                                foreach ($QipAreas as $areaList => $arealist) { 
                                    if ($arealist->id == $AreaId) {
                            ?>
                                <option value="<?= $arealist->id; ?>" selected="selected"><?= $arealist->title; ?></option>
                                <?php }else{ ?>
                                <option value="<?= $arealist->id; ?>"><?= $arealist->title; ?></option>
                            <?php } } ?>                    
                        </select>
                    </div>
                    <div class="col-4">
                        <select id="stdDropdown" class="form-control">
                            <option value="" hidden>SELECT STANDARD</option>
                            <?php 
                                foreach ($QipStandards as $Standard => $standard) { 
                                    if ($standard->id == $StandardId) {
                            ?>
                            <option value="<?= $standard->id; ?>" selected="selected"><strong><?= $standard->name; ?></strong></option>
                            <?php   }else{ ?>
                            <option value="<?= $standard->id; ?>"><strong><?= $standard->name; ?></strong></option>
                            <?php } } ?>
                        </select>
                    </div>
                    <div class="col-4">
                        <select id="elmDropdown" class="form-control">
                            <option value="" hidden>SELECT ELEMENT</option>
                            <?php 
                                foreach ($QipElements as $Elements => $element) { 
                                    if ($element->id == $ElementId) {
                            ?>
                            <option value="<?= $element->id; ?>" selected="selected"><?= $element->elementName; ?></option>
                            <?php   }else{ ?>
                            <option value="<?= $element->id; ?>"><?= $element->elementName; ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>

                <div class="col-12 mt-5 editStandardAndElement">
                    <?php 
                        if(isset($_GET['tab'])){
                            if ($_GET['tab'] == 1) {
                                $tab1 = "active";
                                $tab2 = "";
                                $tab3 = "";

                                $tab_content1 = "tab-pane show active";
                                $tab_content2 = "tab-pane fade";
                                $tab_content3 = "tab-pane fade";
                            }elseif($_GET['tab'] == 2){
                                $tab1 = "";
                                $tab2 = "active";
                                $tab3 = "";

                                $tab_content1 = "tab-pane face";
                                $tab_content2 = "tab-pane show active";
                                $tab_content3 = "tab-pane fade";
                            }elseif($_GET['tab'] == 3){
                                $tab1 = "";
                                $tab2 = "";
                                $tab3 = "active";

                                $tab_content1 = "tab-pane face";
                                $tab_content2 = "tab-pane fade";
                                $tab_content3 = "tab-pane show active";
                            }else{
                                $tab1 = "active";
                                $tab2 = "";
                                $tab3 = "";

                                $tab_content1 = "tab-pane show active";
                                $tab_content2 = "tab-pane fade";
                                $tab_content3 = "tab-pane fade";
                            }
                        }else{
                            $tab1 = "active";
                            $tab2 = "";
                            $tab3 = "";

                            $tab_content1 = "tab-pane show active";
                            $tab_content2 = "tab-pane fade";
                            $tab_content3 = "tab-pane fade";
                        }
                    ?>
                    <ul class="nav nav-tabs separator-tabs ml-0 mb-5 pt-2" role="tablist">
                        <li class="nav-item"><a class="nav-link <?= $tab1; ?>" id="first-tab" data-toggle="tab" href="#first" role="tab" aria-controls="first" aria-selected="false">PROGRESS NOTES</a></li>
                        <li class="nav-item"><a class="nav-link <?= $tab2; ?>" id="second-tab" data-toggle="tab" href="#second" role="tab" aria-controls="second" aria-selected="false">ISSUE</a></li>
                        <li class="nav-item"><a class="nav-link <?= $tab3; ?>" id="third-tab" data-toggle="tab" href="#third" role="tab" aria-controls="third" aria-selected="false">COMMENTS</a></li>
                        <li class="nav-item"><a class="nav-link" id="fourth-tab" data-toggle="tab" href="#fourth" role="tab" aria-controls="fourth" aria-selected="false">EDUCATORS</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="<?= $tab_content1; ?>" id="first" role="tabpanel" aria-labelledby="first-tab">
                            <div class="card">
                                <div class="card-body">
                                    <form action="<?= base_url("qip/saveProgressNotes"); ?>" method="post" id="progress-notes">
                                        <input type="hidden" value="<?= $_GET['qipid']; ?>" name="qipid">
                                        <input type="hidden" value="<?= $_GET['areaid']; ?>" name="areaid">
                                        <input type="hidden" value="<?= $_GET['elementid']; ?>" name="elementid">
                                        <textarea id="pronotes" class="form-control" name="pronotes" data-sample-short></textarea>
                                        <div class="text-center mt-4">
                                            <button type="button" class="btn btn-primary" id="progress-notes-submit"> Submit </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="comments-list row my-4">
                                <?php 
                                    if (isset($ProgressNotes)) {
                                        foreach ($ProgressNotes as $progressnotes => $prognotes) {
                                ?>
                                <div class="col-4 d-none d-md-block mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-row">
                                                <a class="d-block position-relative" href="#">
                                                    <div class="user-img">
                                                        <?php 
                                                            if (empty($prognotes->user_img)) {
                                                                $userImg = "https://via.placeholder.com/80/FFFF00/000000?Text=User";
                                                            }else{
                                                                $userImg = base_url("api/assets/media/").$prognotes->user_img;
                                                            }
                                                        ?>
                                                        <img class="rounded-circle" src="<?= $userImg; ?>" height="80px" width="80px" alt="">
                                                    </div>
                                                </a>
                                                <div class="pl-3 pt-2 pr-2 pb-2">
                                                    <p class="list-item-heading">
                                                        <div class="user-info">
                                                            <div class="user-name"> <?= $prognotes->added_by; ?> </div>
                                                            <div class="comment-text"> <?= html_entity_decode($prognotes->notetext); ?> </div>
                                                        </div>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="<?= $tab_content2; ?>" id="second" role="tabpanel" aria-labelledby="second-tab">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h3>Issues</h3>
                                </div>
                                <div class="col-md-6 text-right p-0">
                                    <button class="btn btn-primary addIssue" type="Submit" data-toggle="modal" data-target="#myModal">
                                        <i class="iconsminds-add">Add Issue</i> 
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 card">
                                    <div class="card-body">
                                        <div id="accordion">
                                            <?php 
                                                if (empty($Issues)) {
                                                    echo "No issues are there!";
                                                }else{
                                                    $countInt = 1;
                                                    foreach ($Issues as $issueKey => $issueObj) {

                                                        if($countInt == 1){
                                                            $expanded = "true";
                                                            $class = "collapse show";
                                                        }else{
                                                            $expanded = "false";
                                                            $class = "collapse";
                                                        }

                                                        $controls = "collapse-" . $countInt;

                                                        $countInt++;
                                            ?>
                                            <div class="border">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#<?= $controls; ?>" aria-expanded="<?= $expanded; ?>" aria-controls="<?= $controls; ?>">
                                                    <?= "ISSUE: " . $issueObj->issueIdentified; ?>  
                                                </button>
                                                <div id="<?= $controls; ?>" class="<?= $class; ?>" data-parent="#accordion">
                                                    <div class="p-4">
                                                        <form action="<?= base_url("qip/saveElementIssues"); ?>" method="post">
                                                            <input type="hidden" value="<?= $_GET['qipid']; ?>" name="qipid">
                                                            <input type="hidden" value="<?= $_GET['areaid']; ?>" name="areaid">
                                                            <input type="hidden" value="<?= $_GET['elementid']; ?>" name="elementid">
                                                            <input type="hidden" value="<?= $issueObj->id; ?>" name="issueid">
                                                            <div id="divcontentFirst" class="divcontent">
                                                                <div class="formGroupDiv mb-3">
                                                                    <label for="issues-identified">Issues Identified</label>
                                                                    <input id="issues-identified" type="text" class="form-control" name="issueIdentified" value="<?= $issueObj->issueIdentified; ?>">
                                                                </div>
                                                                <div class="formGroupDiv mb-3">
                                                                    <label for="what-outcomes">What outcome do you seek ?</label>
                                                                    <input id="what-outcomes" type="text" class="form-control" name="outcome" value="<?= $issueObj->outcome; ?>">
                                                                </div>
                                                                <div class="formGroupDiv mb-3">
                                                                    <label for="priority">Priority</label>
                                                                    <select id="priority" type="text" class="form-control" name="priority">
                                                                        <?php 
                                                                            if (empty($issueObj->priority)) {
                                                                        ?>
                                                                        <option value="">Select Priority</option>
                                                                        <option value="HIGH">High</option>
                                                                        <option value="MEDIUM">Medium</option>
                                                                        <option value="LOW">Low</option>
                                                                        <?php
                                                                            }else{
                                                                                if ($issueObj->priority=="HIGH") {
                                                                        ?>
                                                                        <option value="HIGH" selected>High</option>
                                                                        <option value="MEDIUM">Medium</option>
                                                                        <option value="LOW">Low</option>
                                                                        <?php
                                                                                }else if ($issueObj->priority=="MEDIUM") {
                                                                        ?>
                                                                        <option value="HIGH">High</option>
                                                                        <option value="MEDIUM" selected>Medium</option>
                                                                        <option value="LOW">Low</option>
                                                                        <?php
                                                                                }else{
                                                                        ?>
                                                                        <option value="HIGH">High</option>
                                                                        <option value="MEDIUM">Medium</option>
                                                                        <option value="LOW" selected>Low</option>
                                                                        <?php
                                                                                }
                                                                            }
                                                                        ?>
                                                                        
                                                                    </select>
                                                                </div>
                                                                <div class="formGroupDiv mb-3">
                                                                    <label for="by-when">By when</label>
                                                                    <div class="input-group">
                                                                        <input id="by-when" class="form-control datepickcal" type="text" name="expectedDate" value="<?= date("d/m/Y", strtotime($issueObj->expectedDate)); ?>">
                                                                        <span class="input-group-text input-group-append input-group-addon">
                                                                            <i class="simple-icon-calendar"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="formGroupDiv mb-3">
                                                                    <label for="success-measure">Success Measure</label>
                                                                    <input id="success-measure" type="text" class="form-control" name="successMeasure" value="<?= $issueObj->successMeasure; ?>">
                                                                </div>
                                                                <div class="formGroupDiv mb-3">
                                                                    <label for="how-will">How will you get the outcome </label>
                                                                    <input id="how-will" type="text" class="form-control" name="howToGetOutcome" value="<?= $issueObj->howToGetOutcome; ?>">
                                                                </div>
                                                                <div class="formGroupDiv mb-3">
                                                                    <label for="how-will">Status </label>
                                                                    <select id="how-will" type="text" class="form-control" name="status">
                                                                        <?php if ($issueObj->status=="OPEN") { ?>
                                                                        <option value="OPEN" selected>Open</option>
                                                                        <option value="CLOSED">Closed</option>
                                                                        <?php }else{ ?>
                                                                        <option value="OPEN">Open</option>
                                                                        <option value="CLOSED" selected>Closed</option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="formSubmit text-right mt-3">
                                                                    <button class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                                                                    <button class="btn btn-primary" type="Submit">Save</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                                    
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="<?= $tab_content3; ?>" id="third" role="tabpanel" aria-labelledby="third-tab">
                            <div class="card mb-4">
                                <div class="position-absolute card-top-buttons">
                                    <button class="btn btn-header-light icon-button">
                                        <i class="simple-icon-refresh"></i>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <h3>Comments</h3>
                                        <div class="separator mb-5"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="scroll ps ps--active-y" style="height: 400.813px;">
                                                <div class="scroll-content" id="users-comments">
                                                    <?php 
                                                        if ($Comments) {
                                                            foreach ($Comments as $comntsKey => $cmtObj) {
                                                    ?>
                                                    <div class="d-flex flex-row mb-3 border-bottom justify-content-between">
                                                        <?php 
                                                            if (empty($cmtObj->user_img)) { 
                                                                $imageUrl = "https://via.placeholder.com/50";
                                                            }else{
                                                                $imageUrl = base_url("api/assets/media/").$cmtObj->user_img;
                                                            }
                                                        ?>
                                                        <a href="#">
                                                            <img src="<?= $imageUrl; ?>" alt="Harsha Mehta" class="rounded-circle" width="60px" height="60px"
                                                            />
                                                        </a>
                                                        <div class="pl-3 flex-grow-1">
                                                            <a href="#">
                                                                <p class="font-weight-medium mb-0"><?= $cmtObj->added_by; ?></p>
                                                            </a>
                                                            <p class="mt-3">
                                                                <?= $cmtObj->commentText; ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="<?= base_url("qip/saveElementComment"); ?>" method="post">
                                        <input type="hidden" value="<?= $_GET['qipid']; ?>" name="qipid">
                                        <input type="hidden" value="<?= $_GET['areaid']; ?>" name="areaid">
                                        <input type="hidden" value="<?= $_GET['elementid']; ?>" name="elementid">
                                        <div class="comment-contaiener line">
                                            <div class="input-group">
                                                <input type="text" name="comment" class="form-control commentar add-comment" placeholder="Write your comment" />
                                                <div class="input-group-append">
                                                    <button class="btn btn-secondary" type="submit">
                                                        <span class="d-inline-block">Send</span> <i class="simple-icon-arrow-right ml-2"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="fourth" role="tabpanel" aria-labelledby="fourth-tab">
                            <div class="row" id="staffs-section">
                                <?php foreach ($ElementUsers as $eukey => $euobj) { ?>
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="card d-flex flex-row mb-4">
                                        <a class="d-flex" href="#">
                                            <img alt="Profile" src="<?= base_url('api/assets/media/') . $euobj->imageUrl; ?>" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center">
                                        </a>
                                        <div class=" d-flex flex-grow-1 min-width-zero">
                                            <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                                                <div class="min-width-zero">
                                                    <a href="#">
                                                        <p class="list-item-heading mb-1 truncate"><?= $euobj->name; ?></p>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>   
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php $this->load->view('footer_v3'); ?>
    <!-- Modal Start -->
    <div class="modal" id="educatorsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Select Educators</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="loading-gif">
                        <img class="rounded-circle" src="<?= base_url("assets/images/ajax-loader.gif"); ?>" alt="">
                    </div>
                    <div class="modal-content-area">
                        
                    </div>
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveEducatorsBtn" data-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End -->

    <!-- Issues Modal -->
    <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add Issue</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url("qip/saveElementIssues"); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" value="<?= $_GET['qipid']; ?>" name="qipid">
                    <input type="hidden" value="<?= $_GET['areaid']; ?>" name="areaid">
                    <input type="hidden" value="<?= $_GET['elementid']; ?>" name="elementid">
                    <div id="divcontentFirst" class="divcontent">
                        <div class="formGroupDiv mb-3">
                            <label for="issues-identified">Issues Identified</label>
                            <input id="issues-identified" type="text" class="form-control" name="issueIdentified">
                        </div>
                        <div class="formGroupDiv mb-3">
                            <label for="what-outcomes">What outcome do you seek ?</label>
                            <input id="what-outcomes" type="text" class="form-control" name="outcome">
                        </div>
                        <div class="formGroupDiv mb-3">
                            <label for="priority">Priority</label>
                            <select id="priority" type="text" class="form-control" name="priority">
                                <option value="HIGH">High</option>
                                <option value="MEDIUM">Medium</option>
                                <option value="LOW">Low</option>
                            </select>
                        </div>
                        <div class="formGroupDiv mb-3">
                            <label for="by-when">By when</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="expectedDate" id="by-when">
                                <span class="input-group-text input-group-append input-group-addon">
                                    <i class="simple-icon-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="formGroupDiv mb-3">
                            <label for="success-measure">Success Measure</label>
                            <input id="success-measure" type="text" class="form-control" name="successMeasure">
                        </div>
                        <div class="formGroupDiv mb-3">
                            <label for="how-will">How will you get the outcome </label>
                            <input id="how-will" type="text" class="form-control" name="howToGetOutcome">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="Submit">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal End -->

    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap-datepicker.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script> 
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/datatables.min.js?v=1.0.0"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js?v=1.0.0"></script>
    <script>
        $(document).ready(function(){
            CKEDITOR.replace('pronotes', {
                plugins: 'mentions,emoji,basicstyles,undo,link,wysiwygarea,toolbar',
                contentsCss: [
                    'https://cdn.ckeditor.com/4.16.2/full-all/contents.css',
                    'https://ckeditor.com/docs/ckeditor4/4.16.2/examples/assets/mentions/contents.css'
                ],
                height: 150,
                toolbar: [{
                    name: 'document',
                    items: ['Undo', 'Redo']
                    },
                    {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Strike']
                    },
                    {
                    name: 'links',
                    items: ['EmojiPanel', 'Link', 'Unlink']
                    }
                ],
                extraAllowedContent: '*[*]{*}(*)'
            });

            var date = new Date();
            date.setDate(date.getDate());

            $('#by-when').datepicker({
                format: 'dd-mm-yyyy',
                startDate: date
            });

            $(document).on("change", "#areaDropdown", function(){
                let areaid = $(this).val();
                $.ajax({
                    url: '<?= base_url("Qip/getAreaStandards"); ?>',
                    type: 'POST',
                    data: {'areaid': areaid}
                })
                .done(function(msg) {
                    console.log(msg);
                    res = $.parseJSON(msg);
                    $("#stdDropdown").empty();
                    if (res.Status == "SUCCESS") {
                        $("#stdDropdown").append(`
                            <option value="">-- Select Standard --</option>
                        `);
                        $.each(res.AreaStd, function(index, val) {
                            $("#stdDropdown").prop("disabled",false);
                            $("#elmDropdown").prop("disabled",true);
                            $("#stdDropdown").append(`
                                <option value="`+val.id+`">`+val.name+`</option>
                            `);
                        });
                    }else{
                        $("#stdDropdown").prop("disabled",true);
                        $("#elmDropdown").prop("disabled",true);
                        $("#stdDropdown").append(`
                            <option value="">-- No Options Found --</option>
                        `);
                    }
                });  
            });

            $(document).on("change", "#stdDropdown", function(){
                let stdid = $(this).val();
                $.ajax({
                    url: '<?= base_url("Qip/getStandardElements"); ?>',
                    type: 'POST',
                    data: {'stdid': stdid}
                })
                .done(function(msg) {
                    res = $.parseJSON(msg);
                    $("#elmDropdown").empty();
                    if (res.Status == "SUCCESS") {
                        $("#elmDropdown").append(`
                            <option value="">-- Select Standard --</option>
                        `);
                        $("#elmDropdown").prop("disabled",false);
                        $.each(res.StdElements, function(index, val) {
                            $("#elmDropdown").append(`
                                <option value="`+val.id+`">`+val.elementName+`</option>
                            `);
                        });
                    }else{
                        $("#elmDropdown").prop("disabled",true);
                        $("#elmDropdown").append(`
                            <option value="">-- No Options Found --</option>
                        `);
                    }
                });  
            });

            $(document).on("change", "#elmDropdown", function(){
                let qipid = <?= $_GET['qipid']; ?>;
                let _areaid = $("#areaDropdown").val();
                let elementid = $(this).val();
                let hrefUrl = '<?php echo base_url('qip/editElement'); ?>'+'?qipid='+qipid+'&areaid='+_areaid+'&elementid='+elementid;
                window.location.href = hrefUrl;
            });

            $(document).on('show.bs.modal', '#educatorsModal', function() {
                $("#loading-gif").show();
                $(".modal-content-area").empty();
                $.ajax({
                    url: '<?= base_url("Qip/getCenterStaffs"); ?>',
                    type: 'GET',
                    data: {'qipid': <?= $_GET['qipid']; ?>,'elementid':<?= $_GET['elementid']; ?>},
                })
                .done(function(msg) {
                    res = $.parseJSON(msg);
                    if (res.Status == "SUCCESS") {
                        $("#loading-gif").hide();
                        $.each(res.Staffs, function(index, staffObj) {
                            if (staffObj.imageUrl == "") {
                                imgsrc = "https://via.placeholder.com/80x80?text=Image";
                            }else{
                                imgsrc = "<?= base_url('api/assets/media/'); ?>"+staffObj.imageUrl;
                            }

                            $(".modal-content-area").append(`
                                <div class="staff-item">
                                    
                                    <div class="staff-info-div col-12 row m-3 p-0">
                                    <div class="col-1">
                                        <input type="checkbox" class="staff-cb" name="staff[]" value="`+staffObj.userid+`" `+staffObj.selected+` style="margin-top: 30px;">
                                    </div>
                                        <div class="staff-img col-3">
                                            <img class="rounded-circle" src="`+imgsrc+`" height="80px" width="80px" alt="">
                                        </div>
                                        <div class="staff-info col-8" style="margin-top: 15px;">
                                            <div class="staff-name">Name: <span>`+staffObj.name+`</span></div>
                                            <div class="staff-gender">Gender: `+staffObj.gender+`</div>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                    }else{
                        console.log("Check the data!");
                    }
                });          
            });
        });

        $(document).on('click','#saveEducatorsBtn',function(){
            var checkedId = [];
            $("input.staff-cb:checked").each(function(){
                checkedId.push($(this).val());
            });
            let staffids = JSON.stringify(checkedId);
            $.ajax({
                url: '<?= base_url("Qip/addElementStaffs"); ?>',
                type: 'GET',
                data: {'qipid': <?= $_GET['qipid']; ?>,'areaid':<?= $_GET['areaid']; ?>,'elementid':<?= $_GET['elementid']; ?>, 'staffids': staffids}
            })
            .done(function(msg) {
                res = $.parseJSON(msg);
                if(res.Status == "SUCCESS"){
                    //ajax block
                    $.ajax({
                        url: '<?= base_url("Qip/getElementStaffs"); ?>',
                        type: 'GET',
                        data: {'qipid': <?= $_GET['qipid']; ?>,'elementid':<?= $_GET['elementid']; ?>},
                    })
                    .done(function(msg2) {
                        res2 = $.parseJSON(msg2);
                        if (res2.Status == "SUCCESS") {
                            $("#staffs-section").empty();
                            $.each(res2.Staffs, function(index, staffObj) {
                                if (staffObj.imageUrl == "") {
                                    imgsrc = "https://via.placeholder.com/80x80?text=Image";
                                }else{
                                    imgsrc = "<?= base_url('api/assets/media/'); ?>"+staffObj.imageUrl;
                                }

                                $("#staffs-section").append(`
                                    <div class="col-12 col-md-4 col-lg-4">
                                        <div class="card d-flex flex-row mb-4">
                                            <a class="d-flex" href="#">
                                                <img alt="Profile" src="`+imgsrc+`" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center">
                                            </a>
                                            <div class=" d-flex flex-grow-1 min-width-zero">
                                                <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                                                    <div class="min-width-zero">
                                                        <a href="#">
                                                            <p class="list-item-heading mb-1 truncate">`+staffObj.name+`</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                `);
                            });
                        }else{
                            console.log("Check the data!");
                        }
                    });
                    //ajax block end
                }else{
                    alert('Something went wrong!');
                }
            });
        });

        $(document).on('click', '#progress-notes-submit', function(){
            var _contents = CKEDITOR.instances.pronotes.document.getBody().getText();
            console.log(_contents.length);
            if (_contents.length <= 1) {
                alert('Please enter some notes in the textarea!');
            }else{
                $('#progress-notes').submit();
            }
        })
    </script>
</body>
</html>





