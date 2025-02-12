<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit SelfAssessment | Mydiaree v2</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css" />

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css" />
    <!-- <link rel="stylesheet" href="<?#= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css" /> -->

    <style>
        ul{
            list-style: none;
            text-align: left;
        }
        table textarea{
            border: none;
        }
        table{
            background-color: white;
            text-align: center;
        }
        table tr td{
            border: 2px solid #dddddd;
        }
        #centerDropdown{
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        #centerDropdown .form-group{
            max-width: 350px!important;
            margin: 0px!important;
        }

        .qip-link{
            cursor: pointer;
        }

        .qip-link-area{
            display: none;
        }

        .go-back-btn{
            color: #003ba7;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            cursor: pointer;
        }

        .tab-footer{
            padding: 10px 30px 30px 10px;
        }

        #loading-gif{
            display: none;
        }
        a:link{
            color : black;
        }
        a:active{
            color : blue;
        }
        .litab.active.show{
            color: #287db5 !important;
            border-bottom:5px solid #287db5!important;
        }
        /* .sw-btn-prev , .sw-btn-next{
            display: none;
        } */
        .btn-toolbar.sw-toolbar.sw-toolbar-bottom.justify-content-end{
            display: none;
        }
        .user-images-sec{
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }
        .x-50{
            height: 50px;
            width: 50px;
        } 
        .table-list-ul{
            margin: 0px;
            padding: 0px;
        }
        .position-relative > a > img {
            height: 150px;
        }
        .modal-qip-box.qip-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 0px 8px 0px;
            text-transform: capitalize;
            border-bottom: 1px dotted #d7d7d7;
        }
        .modal-qip-box.qip-link:hover{
            background-color: #f9f9f9;
        }
        .qip-title {
            font-size: 15px;
        }
        .go-back-btn i {
            margin-right: 10px;
        }
        div#qipDropdown > select {
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .txt-ovrflw{
            white-space: nowrap; 
            width: 100%; 
            overflow: hidden;
            text-overflow: ellipsis;  
        }
    </style>
</head>
<body id="app-container" class="menu-default show-spinner">
<?php $this->load->view('sidebar'); ?> 
<main data-centerid="<?= isset($centerid)?$centerid:null; ?>">
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>
    <div class="default-transition">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1><?= $Details->name; ?></h1>
                    <div class="text-zero top-right-button-container">        
                        <div class="btn-group mr-1">
                            <form action="" method="get" id="centerDropdown">
                                <div class="form-group">
                                    <?php 
                                        if (isset($_GET['areaid']) && $_GET['areaid'] != "") { 
                                            foreach ($Areas as $areas => $area) {
                                                if ($area->id == $_GET['areaid']) {
                                    ?>
                                    <div class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split txt-ovrflw" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?= strtoupper($area->title); ?>
                                    </div> 
                                    <?php
                                                }
                                            }
                                        }else{ 
                                    ?>
                                    <div class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?= strtoupper($Areas[0]->title); ?> 
                                    </div>
                                    <?php } 
                                        if (!empty($Areas)) {
                                    ?>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <?php foreach($Areas as $areas => $area){ ?>
                                            <a class="dropdown-item" href="<?= current_url().'?id='.$_GET['id'].'&areaid='.$area->id; ?>">
                                                <?= strtoupper($area->title); ?>
                                            </a>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>                
                        <button class="btn btn-default btn-primary" type="button" data-toggle="modal" data-target="#educatorsModal">
                            <i class="iconsminds-add "></i> ADD EDUCATORS
                        </button>                        
                    </div>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0" style="background-color: transparent;">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url(); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('SelfAssessment')."?centerid=".$Details->centerid; ?>">Self Assessment</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?= 'Edit '.$Details->name; ?></li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div id="smartWizardClickable" class="sw-main sw-theme-default">
                            <ul class="nav nav-tabs">
                                <li class="line-nav-tab nav-item clickable active">
                                    <a class="nav-link active" href="#tabs-1" data-toggle="tab" aria-expanded="false">Legistative Requirements</a>
                                </li>
                                <li class="line-nav-tab nav-item clickable done">
                                    <a class="nav-link" href="#tabs-2" data-toggle="tab" aria-expanded="true">Quality Area</a>
                                </li>
                            </ul>
                            <?php 
$center_id = $this->input->get('center_id'); // Retrieve from the URL
?>
                            <div class="card-body sw-container tab-content">
                                <form action="<?= base_url("SelfAssessment/saveSelfAssessment"); ?>" method="post">
                                    <input type="hidden" class="form-control" name="asmnt_id" value="<?= $_GET['id']; ?>">
                                    <input type="hidden" name="center_id" value="<?php echo $center_id; ?>">
                                    <div class="tab-content mainTabObservation">
                                        <div class="tab-pane step-content active" id="tabs-1">
                                            <table class="qiptable table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td>National Law<br>(NL)</td>
                                                        <td>National Regulation<br>(NR)</td>
                                                        <td>Associated Element<br>(AE)</td>
                                                        <td>Status</td>
                                                        <td>Write Non Compliant Note <br> (Ignore if compliant)</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        if (isset($LR)) {
                                                            foreach ($LR as $lrkey => $lrobj) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $lrobj->national_law; ?></td>
                                                        <td><?= $lrobj->national_regulation; ?></td>
                                                        <td><?= $lrobj->associated_elements; ?></td>
                                                        <td width="15%">                            
                                                            <ul class="table-list-ul">
                                                                <?php 
                                                                    if ($lrobj->status == "Compliant") {
                                                                        $com = "checked";
                                                                        $noncom = "";
                                                                    } else if ($lrobj->status == "Noncompliant") {
                                                                        $com = "";
                                                                        $noncom = "checked";
                                                                    } else {
                                                                        $com = "";
                                                                        $noncom = "";
                                                                    }
                                                                ?>
                                                                <li>
                                                                    <input name="nl_status_<?= $lrobj->id; ?>" type="radio" value="Compliant" <?= $com; ?>>
                                                                    <label>Compliant</label>
                                                                </li>
                                                                <li>
                                                                    <input name="nl_status_<?= $lrobj->id; ?>" type="radio" value="Noncompliant" <?= $noncom; ?>>
                                                                    <label>Not Compliant</label>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            <textarea name="nl_ncnotice_<?= $lrobj->id; ?>" class="form-control" placeholder="Write Non Compliant Note"><?= $lrobj->actions; ?></textarea>
                                                        </td>  
                                                    </tr> 
                                                    <?php } } ?>              
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane step-content" id="tabs-2">
                                            <table class="qiptable table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td>Concept</td>
                                                        <td>Elements</td>
                                                        <td>Identifiend Practices</td>
                                                        <td>Status</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        if (isset($QA)) {
                                                            foreach ($QA as $qakey => $qaobj) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $qaobj->concept; ?></td>
                                                        <td><?= $qaobj->elements; ?></td>
                                                        <td>
                                                            <textarea id="<?= 'idtf_prac_'.$qaobj->id; ?>" class="form-control" name="<?= 'idtf_prac_'.$qaobj->id; ?>" rows="4" placeholder="Write here...!"><?= $qaobj->identified_practice; ?></textarea>
                                                        </td> 
                                                        <td>                            
                                                            <ul class="table-list-ul">
                                                                <?php 
                                                                    if ($qaobj->status == "Met") {
                                                                        $met = "checked";
                                                                        $notmet = "";
                                                                    } else if ($qaobj->status == "Not-met") {
                                                                        $met = "";
                                                                        $notmet = "checked";
                                                                    } else {
                                                                        $met = "";
                                                                        $notmet = "";
                                                                    }
                                                                    
                                                                ?>
                                                                <li>
                                                                    <input type="radio" name="<?= 'qa_status_'.$qaobj->id; ?>" value="Met" <?= $met; ?>> <label>Met</label>
                                                                </li>
                                                                <li>
                                                                    <input type="radio" name="<?= 'qa_status_'.$qaobj->id; ?>" value="Not-met" <?= $notmet; ?>> <label>Not Met</label>
                                                                </li>
                                                            </ul>
                                                            <a class="btn btn-outline-primary btn-xs btn-block" data-saqaid="<?= $qaobj->id; ?>" data-toggle="modal" data-target="#addToQipModal"> Add to QIP </a>
                                                        </td>  
                                                    </tr>
                                                    <?php } } ?>              
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-footer pr-0">
                                            <div class="text-right">
                                                <button class="btn btn-default btn-primary text-right" type="submit">Save Assessment</button>
                                            </div>
                                        </div>
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

<!-- Modal Start -->
<div class="modal" id="addToQipModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="myModalLabel">Add to QIP</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="loading-gif">
                    <img src="<?= base_url("assets/images/ajax-loader.gif"); ?>" alt="">
                </div>
                <div class="qip-content-area"> 
                </div>
                <div class="qip-h-con-area">
                </div>
                <div class="qip-link-area">
                    <div class="go-back-btn"><i class="simple-icon-arrow-left"></i> Go Back</div>
                        <div id="qipDropdown">
                            <select class="form-control" type="button" id="areaModalDropdown">
                                <option value="" hidden>Select Area</option>  
                                <?php foreach($Areas as $areas => $area) { ?>
                                <?php if(isset($_GET['areaid']) && $_GET['areaid'] == $area->id ) { ?>
                                <option value="<?php echo $area->id; ?>" selected><?php echo $area->title; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $area->id; ?>"><?php echo $area->title; ?></option>
                                <?php } } ?>                  
                            </select>
                            <select class="form-control" type="button" id="stdModalDropdown">
                                <option value="" selected>Select Standard</option>                
                            </select>
                            <select class="form-control" type="button" id="elmModalDropdown">
                                <option value="" selected>Select Element</option>               
                            </select>
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" id="saveToElementsBtn" data-dismiss="modal" disabled>Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button></div>
        </div> -->
    </div>
</div>
<!-- Modal End -->

<!-- Modal Start -->
<div class="modal fade" id="educatorsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="educatorsModalLabel">Select Educators</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="loading-gif">
                    <img src="<?= base_url("assets/images/ajax-loader.gif"); ?>" alt="">
                </div>
                <div class="modal-content-area row">   
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="saveEducatorsBtn">Save changes</button></div>
        </div>
    </div>
</div>
<!-- Modal End -->
<?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js"></script> 
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/datatables.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery.smartWizard.min.js" style="opacity: 1;"></script>
</body>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){
        $("#areaid").on('change',function(){
            let areaid = $(this).val();
            <?php  
                $qs = $_SERVER['QUERY_STRING'];
                if ($qs == "") {
            ?>
                $("#centerDropdown").submit();
            <?php
                }else{
                    if (isset($_GET['areaid']) && $_GET['areaid']!="") {
                        $qurl = str_replace('&areaid=' . $_GET['areaid'], '', $_SERVER['QUERY_STRING']);
                        $qurl = $qurl."&areaid=";
                    } else {
                        $qurl = $_SERVER['QUERY_STRING']."&areaid=";
                    }
            ?>
                var url = "<?php echo base_url('SelfAssessment/edit?').$qurl; ?>"+areaid;
                var test = url.replace(/&/g, '&');
                window.location.href=test;
            <?php } ?>
        });
    });

    $('#addToQipModal').on('show.bs.modal', function (event) {
        $(document).find(".qip-content-area").empty();
        var button = $(event.relatedTarget);
        var saqa_id = button.data('saqaid');
        let practicenotes = $("#idtf_prac_"+saqa_id).val();
        $(".qip-link-area").hide();
        $.ajax({
            url: '<?= base_url("Qip/getList"); ?>/1',
            type: 'GET'
        })
        .done(function(msg) {
            // console.log(msg);
            res = $.parseJSON(msg);            
            if (res.Status == "SUCCESS") {
                $("#loading-gif").hide();
                $.each(res.qips, function(index, val) {
                    $(".qip-content-area").append(`
                        <div class="modal-qip-box qip-link" data-qipid="`+val.id+`">
                            <div class="qip-title">`+val.name+`</div>
                            <div class="qip-checkbox">
                                <i class="simple-icon-arrow-right"></i>
                            </div>
                        </div>
                    `);
                });
            }else{
                alert(res.Message);
            }
        });
        $(".qip-h-con-area").append(`
            <input type="hidden" id="modal-idpr" name="idtf_prac_`+saqa_id+`" value="`+practicenotes+`">
            <input type="hidden" id="modal-qaid" name="saqa_id_`+saqa_id+`" value="`+saqa_id+`">
        `);
    });

    $(document).on('click', '.qip-link', function(event) {
        let qipid = $(this).data('qipid');
        $(".qip-content-area").hide();
        $(".qip-link-area").show();
        $(".qip-h-con-area").append(`
            <input type="hidden" name="qipid" id="modal-qipid" value="`+qipid+`">
        `);
        let areaval = $("#areaModalDropdown").val();
        if (areaval !== "") {
            $("#areaModalDropdown").trigger("change");
        }
    });

    $(document).on('click', '.go-back-btn', function(event) {
        $(".qip-content-area").show();
        $(".qip-link-area").hide();
        $("#modal-qipid").remove();
    });

    $("#areaModalDropdown").on("change",function(){
        let areaid = $(this).val();
        $("#saveToElementsBtn").prop('disabled','true');
        $.ajax({
            url: '<?= base_url("Qip/getAreaStandards"); ?>',
            type: 'POST',
            data: {'areaid': areaid}
        })
        .done(function(msg) {
            // console.log(msg);
            res = $.parseJSON(msg);
            $("#stdModalDropdown").empty();
            if (res.Status == "SUCCESS") {
                $("#stdModalDropdown").append(`
                    <option value="">Select Standard</option>
                `);
                $.each(res.AreaStd, function(index, val) {
                    $("#stdModalDropdown").prop("disabled",false);
                    $("#elmModalDropdown").prop("disabled",true);
                    $("#stdModalDropdown").append(`
                        <option value="`+val.id+`">`+val.name+`</option>
                    `);
                });
            }else{
                $("#stdModalDropdown").prop("disabled",true);
                $("#elmModalDropdown").prop("disabled",true);
                $("#stdModalDropdown").append(`
                    <option value="">-- No Options Found --</option>
                `);
            }
        });  
    });

    $("#stdModalDropdown").on("change",function(){
        let stdid = $(this).val();
        $.ajax({
            url: '<?= base_url("Qip/getStandardElements"); ?>',
            type: 'POST',
            data: {'stdid': stdid}
        })
        .done(function(msg) {
            res = $.parseJSON(msg);
            $("#elmModalDropdown").empty();
            if (res.Status == "SUCCESS") {
                $("#elmModalDropdown").append(`
                    <option value="">Select Element</option>
                `);
                $("#elmModalDropdown").prop("disabled",false);
                $.each(res.StdElements, function(index, val) {
                    $("#elmModalDropdown").append(`
                        <option value="`+val.id+`">`+val.elementName+`</option>
                    `);
                });
            }else{
                $("#elmModalDropdown").prop("disabled",true);
                $("#elmModalDropdown").append(`
                    <option value="">No Options Found</option>
                `);
            }
        });  
        $("#saveToElementsBtn").prop('disabled','true');
    });

    $(document).on("change","#elmModalDropdown",function(){
        $("#saveToElementsBtn").removeAttr('disabled');
    });

    $(document).on("click","#saveToElementsBtn",function(){    
        let notetext = $("#modal-idpr").val();
        let qipid = $("#modal-qipid").val();
        let elementid = $("#elmModalDropdown").val();
        let areaid = $("#areaModalDropdown").val();
        console.log(notetext);
        $.ajax({
            url: '<?= base_url("SelfAssessment/saveProgressNotes"); ?>',
            type: 'POST',
            data: {'qipid': qipid, 'areaid': areaid, 'elementid': elementid, 'pronotes': notetext},
        })
        .done(function(msg) {
            res = $.parseJSON(msg);
            retMsg = res.Message;
            if (res.Status == "SUCCESS") {
                swal("Success!", retMsg, "success");
                $(".qip-h-con-area").empty();
            }else{
                swal("Alert!", "Something went wrong", "error");
                $(".qip-h-con-area").empty();
            }
        });
    });

    $('#educatorsModal').on('show.bs.modal', function() {
        $("#loading-gif").show();
        $(".modal-content-area").empty();
        $.ajax({
            url: '<?= base_url("SelfAssessment/getSelfAsmntStaffs"); ?>',
            type: 'GET',
            data: {'self_id': <?= $_GET['id']; ?>},
        })
        .done(function(msg) {
            res = $.parseJSON(msg);
            if (res.Status == "SUCCESS") {
                $.each(res.Staffs, function(index, staffObj) {
                    $("#loading-gif").css('display', 'none');
                    if (staffObj.imageUrl == "") {
                        imgsrc = "https://via.placeholder.com/80x80?text=Image";
                    }else{
                        imgsrc = "<?= base_url('api/assets/media/'); ?>"+staffObj.imageUrl;
                    }
                    $(".modal-content-area").append(`
                        <div class="col-xl-4 col-lg-4 col-12 col-sm-6 mb-4">
                            <div class="card">
                                <div class="position-relative">
                                    <a href="#!">
                                        <img class="card-img-top" src="`+imgsrc+`">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="custom-control custom-checkbox pl-1">
                                                <label class="custom-control custom-checkbox  mb-0">
                                                    <input type="checkbox" name="staff[]" class="staff-cb custom-control-input" value="`+staffObj.userid+`" `+staffObj.selected+`>
                                                    <span class="custom-control-label">&nbsp;</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-10">
                                            <a href="#!">
                                                <p class="list-item-heading mb-4 pt-1">`+staffObj.name+`</p>
                                            </a>
                                            <footer>
                                                <p class="text-muted text-small mb-0 font-weight-light">`+staffObj.gender+`</p>
                                            </footer>
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
    });

    $(document).on('click','#saveEducatorsBtn',function(){
        var checkedId = [];
        $("input.staff-cb:checked").each(function(){
            checkedId.push($(this).val());
        });

        let staffids = JSON.stringify(checkedId);
        $.ajax({
            url: '<?= base_url("SelfAssessment/addSelfAssessmentStaffs"); ?>',
            type: 'POST',
            data: {'self_id': <?= $_GET['id']; ?>,'staffids': staffids}
        })
        .done(function(msg) {
            console.log(msg);
            res = $.parseJSON(msg);
            if (res.Status == "SUCCESS") {
                location.reload();
            }else{
                alert(res.Message);
            }
        });
    });

    $('#addToQipModal').on('hide.bs.modal', function (e) {
      $(".qip-content-area").show();
    });



    $(document).ready(function(){
        $('#addToQipModal,#educatorsModal').draggable({
                handle: ".modal-header"
      });
    })
</script>
</html>