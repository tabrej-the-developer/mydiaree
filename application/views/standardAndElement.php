<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Standard and Element | Mykronicle v2</title>
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <style>
        .align-icons{
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }
        .btn-block{
            min-width: 100px!important;
        }
        .d-flex-custom{
            align-items: center;
            justify-content: space-between;
        }
        .element-box {
            display: block;
            border: 1px solid #ececec;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .element-title{
            cursor: pointer;
            font-size: 15px;
        }
        span.publComments {
            margin-left: 15px;
        }
        .list-thumbnail{
            width: 128px!important;
        }
        .form-element {
            position: absolute;
            z-index: 1000;
            right: 0;
            top: 50%;
        }
        .h-140{
            width: 95px!important;
            height: 85px!important;
        }
        .cursor-pointer{
            font-size: 15px;
            cursor: pointer;
        }
    </style>
</head>
<body id="app-container" class="menu-default show-spinner">
<?php 
    $this->load->view('sidebar'); 
    //PHP Block
    $key = array_search($_GET['areaid'], array_column($QipAreas, 'id'));
?> 
    <main data-centerid="<?= isset($Centerid)?$Centerid:null; ?>">
        <div class="default-transition">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <h1>Standard and Element</h1>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('Qip').'?centerid='.$Centerid; ?>">QIP</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('qip/edit').'?id='.$_GET['qipid']; ?>">Edit QIP</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Standard & Element</li>
                            </ol>
                        </nav>
                        <div class="text-zero top-right-button-container">
                            <div class="btn-group mr-1">
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-outline-primary dropdown-toggle mb-1" type="button" id="areaDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= $QipAreas[$key]->title; ?> </button>
                                    <div class="dropdown-menu" aria-labelledby="areaDropdown">
                                        <?php 
                                            foreach ($QipAreas as $areaList => $arealist) { 
                                                if ($arealist->id==$_GET['areaid']) {
                                        ?>
                                        <a class="dropdown-item" href="#"><?= $arealist->title; ?></a>
                                        <?php   }else{ ?>
                                        <a class="dropdown-item" href="<?= base_url('qip/view').'?qipid='.$_GET['qipid'].'&areaid='.$arealist->id ;?>"><?= $arealist->title; ?></a>
                                        <?php } } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="separator mb-5"></div>
                    </div>
                </div>
                <div class="row mt-2 p-0">
                    <div class="col-4">
                        <div class="card mb-4">
                            <div class="position-absolute card-top-buttons">
                                <button class="btn btn-header-light icon-button" onclick="loadDiscussion()">
                                    <i class="simple-icon-refresh"></i>
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <h3>Discussion Boards</h3>
                                    <div class="separator mb-5"></div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="scroll ps ps--active-y" style="height: 400.813px;">
                                            <div class="scroll-content" id="users-comments">
                                                <?php  if ($discussion) {  foreach ($discussion as $discuss => $disObj) { ?>
                                                <div class="d-flex flex-row mb-3 border-bottom justify-content-between">
                                                    <?php if ($disObj->imageUrl) { ?>
                                                    <a href="#"><img src="<?= base_url("api/assets/media/").$disObj->imageUrl; ?>" alt="Harsha Mehta" class="rounded-circle" width="60px" height="60px" /></a>
                                                    <?php  }else{ ?>
                                                    <img class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall" src="https://via.placeholder.com/50">
                                                    <?php } ?>
                                                    <div class="pl-3 flex-grow-1">
                                                        <a href="#">
                                                            <p class="font-weight-medium mb-0"><?= $disObj->name; ?></p>
                                                        </a>
                                                        <p class="mt-3">
                                                            <?= $disObj->commentText; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <?php } } else { echo "<p>No comments available!</p>"; }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="comment-contaiener">
                                    <div class="input-group">
                                        <input type="text" class="form-control commentar add-comment" placeholder="Write your comment" id="txtComment" name="comment" autocomplete="off"/>
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" id="add-comment" type="submit">
                                                <i class="simple-icon-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Standards &amp; Elements</h3>
                                <?php 
                                    if (isset($Standards)) {
                                        $intCount = 0;
                                        foreach ($Standards as $standard => $std) {
                                            $intCount++;
                                ?>
                                <div class="element-box">
                                    <div class="element-heading mb-1 d-flex justify-content-between align-items-center pl-3">
                                        <a class="element-title collapsed" data-toggle="collapse" href="#<?= 'element_' . $intCount; ?>" role="button" aria-expanded="false" aria-controls="<?= 'element_' . $intCount; ?>">
                                            <?= $std->name; ?>
                                        </a>
                                        <div class="element-title-option d-flex justify-content-end">
                                            <a href="<?= base_url('Qip/editStandards').'?stdid='.$std->id.'&qipid='.$_GET['qipid'].'&centerid='.$Centerid.'&areaid='.$_GET['areaid']; ?>" class="btn btn-link">Edit</a>
                                            <a class="btn btn-link btn-collapsed collapsed" data-toggle="collapse" href="#<?= 'element_' . $intCount; ?>" role="button" aria-expanded="false" aria-controls="<?= 'element_' . $intCount; ?>">Expand</a>
                                        </div>
                                    </div>
                                    <div class="sub-element-list mb-2 collapse" id="<?= 'element_' . $intCount;?>">
                                        <?php if(empty($std->elements)){ ?>
                                        <div class="text-center">
                                            <p class="text-danger">Element not avaialable!</p>
                                        </div>
                                        <?php }else{ ?>
                                        <div class="p-0 m-2">

                                            <?php $intCounter = 0; foreach ($std->elements as $element => $elmt) { $intCounter = $intCount + $intCounter + 1;?>
                                            <div class="col-12 row p-0 pl-2 mt-2 mb-2">
                                                <div class="col-6 text-left d-flex align-items-center">
                                                    <span class="standardName"><?= $elmt->elementName; ?></span>
                                                    <span class="publComments"><?= $elmt->name; ?></span>
                                                </div>
                                                <div class="col-6 p-0 m-0">
                                                    <div class="row">
                                                        <div class="col-5">
                                                            <div class="eduMember text-left">
                                                                <?php if ($elmt->totalusers > 0) { ?>
                                                                <button class="btn btn-outline-primary btn-block"><?= $elmt->totalusers . " Educators"; ?></button>
                                                                <?php }else{ ?>
                                                                <button class="btn btn-outline-secondary btn-block"> No Educators </button>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-7">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="dropdown d-inline-block">
                                                                    <button class="btn btn-outline-primary dropdown-toggle mb-1 btn-block" type="button"
                                                                        id="<?= 'link'.$intCounter;?>" data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                        Link
                                                                    </button>
                                                                    <div class="dropdown-menu" aria-labelledby="<?= 'link'.$intCounter; ?>">
                                                                        <a class="dropdown-item" href="#!" data-toggle="modal" data-target="#myModal" data-type="Observation" data-elementid="<?= $elmt->id; ?>">Observation</a>
                                                                        <a class="dropdown-item" href="#!" data-toggle="modal" data-target="#myModal" data-type="Reflection" data-elementid="<?= $elmt->id; ?>">Reflection</a>
                                                                        <a class="dropdown-item" href="#!" data-toggle="modal" data-target="#myModal" data-type="Resources" data-elementid="<?= $elmt->id; ?>">Resources</a>
                                                                        <a class="dropdown-item" href="#!" data-toggle="modal" data-target="#myModal" data-type="Survey" data-elementid="<?= $elmt->id; ?>">Survey</a>
                                                                        <a class="dropdown-item" href="#!" data-toggle="modal" data-target="#myModal" data-type="ProgramPlan" data-elementid="<?= $elmt->id; ?>">Program Plan</a>
                                                                        <a class="dropdown-item" href="#!" data-toggle="modal" data-target="#myModal" data-type="Assessment" data-elementid="<?= $elmt->id; ?>">Assessment</a>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <a href="<?php echo base_url("qip/editElement")."?qipid=".$_GET['qipid']."&areaid=".$_GET['areaid']."&elementid=".$elmt->id; ?>" class="btn btn-outline-primary">
                                                                        View
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  
                                            <?php } ?>
                                        </div>
                                        <?php } ?> 
                                    </div>
                                </div>
                                <?php
                                        }
                                ?>
                            </div>
                            <?php }else{ ?>
                                <h3 class="text-center text-danger">No standards exists in database!</h3>
                            <?php } ?> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php $this->load->view('footer_v3'); ?>

    <!-- Links Modal -->
    <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-modal="true" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="txtType" value="">
                    <div class="appendCont row">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveQipLinks" data-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End of modal -->

    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>
    <script>
        let base_url = '<?php echo base_url(); ?>';
        let centerid = <?php echo $Centerid; ?>;
        let qipid = <?= $_GET['qipid']; ?>;
        let elementid = 0;

        function loadDiscussion(){
            let areaid = <?= $_GET['areaid'] ?>;
            let qipid = <?= $_GET['qipid'] ?>;
            let ajax = 1;
            $.ajax({
                url: '<?= base_url("Qip/getQipDiscussion"); ?>/'+qipid+'/'+areaid+'/'+ajax,
                type: 'GET'
            })
            .done(function(msg) {
                res = $.parseJSON(msg);
                if(res.Status == "SUCCESS"){
                    $(document).find("#users-comments").empty();
                    $.each(res.Comments, function(index, val) {

                        if (val.imageUrl=="") {
                            image = `https://via.placeholder.com/60`;
                        }else{
                            image = `<?= base_url('api/assets/media/'); ?>` + val.imageUrl ;
                        }

                        $("#users-comments").append(`
                            <div class="d-flex flex-row mb-3 border-bottom justify-content-between">
                                <a href="#">
                                    <img
                                        src="` + image + `"
                                        alt="` + val.name + `"
                                        class="rounded-circle"
                                        width="60px"
                                        height="60px"
                                    />
                                </a>
                                <div class="pl-3 flex-grow-1">
                                    <a href="#">
                                        <p class="font-weight-medium mb-0">` + val.name + `</p>
                                    </a>
                                    <p class="mt-3">
                                        ` + val.commentText + `
                                    </p>
                                </div>
                            </div>
                        `);
                    });
                }else{
                    alert("Something went wrong! Please refresh the page.");
                }
            });
        }

        $(document).on("click","#add-comment",function(){
            let areaid = <?= $_GET['areaid'] ?>;
            let qipid = <?= $_GET['qipid'] ?>;
            let comment = $("#txtComment").val();
            if (comment == "") {
                $("#txtComment").css('border-color','#FF0000');
            }else{
                $("#txtComment").css('border-color','#d7d7d7');
                $.ajax({
                    url: '<?= base_url("Qip/addComment"); ?>',
                    type: 'POST',
                    data: {'qipid': qipid,'areaid':areaid,'commentText':comment},
                })
                .done(function(msg) {
                    res = $.parseJSON(msg);
                    if(res.Status == "SUCCESS"){
                        loadDiscussion();
                        $("#txtComment").val("");
                    }else{
                        alert("Something went wrong! Please refresh the page.");
                    }
                });
            }
        });

        setInterval(function(){ loadDiscussion() }, 15000);

        $('#myModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var type = button.data('type'); // Extract info from data-type attributes
            elementid = button.data('elementid'); // Extract info from data-type attributes
            var modal = $(this);
            modal.find('.modal-title').text('Link ' + type);
            if (type=="Observation") {
                modal.find("#txtType").val("OBSERVATION");
                loadObservation();
            }else if(type=="ProgramPlan"){
                modal.find("#txtType").val("PROGRAMPLAN");
                loadProgramPlan();
            }else if(type=="Reflection"){
                modal.find("#txtType").val("REFLECTION");
                loadReflection();
            }else if(type=="Resources"){
                modal.find("#txtType").val("RESOURCES");
                loadResources();
            }else if(type=="Survey"){
                modal.find("#txtType").val("SURVEY");
                loadSurvey();
            }else if(type=="Assessment"){
                modal.find("#txtType").val("MONTESSORI");
                loadAssessment();
            }else{
                console.log("Match not found!");
            }        
        });

        function loadObservation(){
            $(document).find(".appendCont").empty();
            $.ajax({
                url: '<?= base_url("Qip/getPublishedObservations"); ?>/'+centerid+'/'+qipid+'/'+elementid,
                type: 'GET'
            })
            .done(function(msg) {
                res = $.parseJSON(msg);            
                if (res.Status == "SUCCESS") {
                    $.each(res.observations, function(index, val) {

                        if (val.observationsMedia.length > 0) {
                            imgUrl = base_url + 'api/assets/media/' + val.observationsMedia;
                        } else {
                            imgUrl = `https://via.placeholder.com/128x85?text=No+Image`;
                        }

                        $(".appendCont").append(`
                            <div class="col-12">
                                <div class="form-element">
                                    <input type="checkbox" name="linkids[]" class="modal-checkbox"  value="`+ val.id +`" `+val.checked+`>
                                </div>
                                <div class="d-flex flex-row mb-3 bg-white br-10">
                                    <a class="d-block position-relative" href="#">
                                        <img src="`+imgUrl+`" alt="Image" class="list-thumbnail border-0">
                                        <span class="badge badge-pill position-absolute badge-top-right badge-success">PUBLISHED</span>
                                    </a>
                                    <div class="pl-3 pt-2 pr-2 pb-2">
                                        <a href="#" class="obs-link">
                                            <p class="list-item-heading">`+ val.title +`</p>
                                            <div class="pr-4 d-none d-sm-block">
                                                <p class="text-muted mb-1 text-small"> By: `+ val.user_name +`</p>
                                            </div>
                                            <div class="text-primary text-small font-weight-medium d-none d-sm-block">`+ val.date_added +`</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                }else{
                    alert(res.Message);
                }
            }); 
        }

        function loadReflection(){
            $(document).find(".appendCont").empty();
            $.ajax({
                url: '<?= base_url("Qip/getPublishedReflections"); ?>/'+centerid+'/'+qipid+'/'+elementid,
                type: 'GET'
            })
            .done(function(msg) {
                res = $.parseJSON(msg);
                if (res.Status == "SUCCESS") {
                    $.each(res.reflections, function(index, val) {
                        $(".appendCont").append(`
                            <div class="col-12">
                                <div class="card d-flex flex-row mb-3">
                                    <a class="d-flex" href="#">
                                        <img src="<?= base_url('api/assets/media/'); ?>`+ val.mediaThumbnail +`" alt="`+ val.title +`" class="list-thumbnail h-140 responsive border-0 card-img-left" />
                                    </a>
                                    <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                                        <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center p-0">
                                            <a href="#" class="w-80 w-sm-100">
                                                <p class="list-item-heading mb-0 truncate">`+ val.title +`</p>
                                                <p class="text-muted text-small mb-0">`+ val.name +`</p>
                                                <p class="text-muted text-small">`+ val.createdAt +`</p>
                                            </a>
                                        </div>
                                        <label class="custom-control custom-checkbox mb-1 align-self-center pr-4">
                                            <input type="checkbox" class="modal-checkbox custom-control-input" name="linkids[]" value="`+ val.id +`" `+val.checked+`>
                                            <span class="custom-control-label">&nbsp;</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                }else{
                    alert(res.Message);
                }
            }); 
        }

        function loadResources(){
            $(document).find(".appendCont").empty();
            $.ajax({
                url: '<?= base_url("Qip/getPublishedResources"); ?>',
                type: 'POST',
                data:{'qipid':qipid,'elementid':elementid}
            })
            .done(function(msg) {
                res = $.parseJSON(msg);
                if (res.Status == "SUCCESS") {
                    $.each(res.Resources, function(index, val) {
                        $(".appendCont").append(`
                            <div class="col-12">
                                <div class="card d-flex flex-row mb-3">
                                    <a class="d-flex" href="#">
                                        <img src="<?= base_url('api/assets/media/'); ?>`+ val.mediaThumbnail +`" alt="`+ val.title +`" class="list-thumbnail h-140 responsive border-0 card-img-left" />
                                    </a>
                                    <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                                        <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center p-0">
                                            <a href="#" class="w-80 w-sm-100">
                                                <p class="list-item-heading mb-0 truncate">`+ val.title +`</p>
                                                <p class="text-muted text-small mb-0">`+ val.createdBy +`</p>
                                                <p class="text-muted text-small">`+ val.createdAt +`</p>
                                            </a>
                                        </div>
                                        <label class="custom-control custom-checkbox mb-1 align-self-center pr-4">
                                            <input type="checkbox" class="modal-checkbox custom-control-input" name="linkids[]" value="`+ val.id +`" `+val.checked+`>
                                            <span class="custom-control-label">&nbsp;</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                }else{
                    alert(res.Message);
                }
            }); 
        }

        function loadSurvey(){
            $(document).find(".appendCont").empty();
            $.ajax({
                url: '<?= base_url("Qip/getPublishedSurveys"); ?>/'+centerid+'/'+qipid+'/'+elementid,
                type: 'GET'
            })
            .done(function(msg) {
                res = $.parseJSON(msg);
                if (res.Status == "SUCCESS") {
                    $.each(res.Surveys, function(index, val) {
                        $(".appendCont").append(`
                            <div class="col-12">
                                <div class="card d-flex flex-row mb-3">
                                    <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                                        <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center">
                                            <a href="#" class="w-80 w-sm-100">
                                                <p class="list-item-heading  mb-0 truncate">`+ val.title +`</p>
                                                <p class="text-muted text-small mb-0">At: `+ val.createdAt +` by: `+ val.createdBy +`</p>
                                            </a>
                                        </div>
                                        <label class="custom-control custom-checkbox mb-1 align-self-center pr-4">
                                            <input type="checkbox" class="modal-checkbox custom-control-input" name="linkids[]" value="`+ val.id +`" `+val.checked+`>
                                            <span class="custom-control-label">&nbsp;</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                }else{
                    alert(res.Message);
                }
            }); 
        }

        function loadProgramPlan(){
            $(document).find(".appendCont").empty();
            $.ajax({
                url: '<?= base_url("Qip/getProgramPlan"); ?>/'+centerid+'/'+qipid+'/'+elementid,
                type: 'GET'
            })
            .done(function(msg) {
                res = $.parseJSON(msg);
                if (res.Status == "SUCCESS") {
                    $.each(res.ProgramPlans, function(index, val) {
                        $(".appendCont").append(`
                            <div class="col-12">
                                <div class="card d-flex flex-row mb-3">
                                    <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                                        <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center">
                                            <a href="#" class="w-80 w-sm-100">
                                                <p class="list-item-heading  mb-0 truncate">`+ val.startdate +`/`+ val.enddate +`</p>
                                                <p class="text-muted text-small mb-0"> Room no: `+ val.room_id +` <br/> Created At: `+ val.createdAt +` </p>
                                            </a>
                                        </div>
                                        <label class="custom-control custom-checkbox mb-1 align-self-center pr-4">
                                            <input type="checkbox" class="modal-checkbox custom-control-input" name="linkids[]" value="`+ val.id +`" `+val.checked+`>
                                            <span class="custom-control-label">&nbsp;</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                }else{
                    alert(res.Message);
                }
            }); 
        }

        function loadAssessment(){

            $(document).find(".appendCont").empty();
            $(".appendCont").append(`
                <div class="col-12 btn-group mb-3">
                    <button class="btn btn-primary" id="btnMon">Montessori</button>
                    <button class="btn btn-primary" id="btnDevMile">Developmental Milestone</button>
                    <button class="btn btn-primary" id="btnEylf">EYLF</button>
                </div>
                <div class="col-12">
                    <div id="assessment-area"></div>
                </div>
            `);

            $('#btnMon').trigger('click');
        }

        $(document).on("click", "#btnMon", function(){
            $(document).find("#assessment-area").empty();
            $(document).find("#txtType").val("MONTESSORI");
            $.ajax({
                url: '<?= base_url("Qip/getAllMonSubActs"); ?>/'+qipid+"/"+elementid,
                type: 'POST'
            })
            .done(function(msg) {
                res = $.parseJSON(msg);            
                if (res.Status == "SUCCESS") {
                    let _qiplist = 1;
                    $.each(res.Records, function(index, val) {
                        $("#assessment-area").append(`
                            <div class="ref-block">
                                <div class="ref-title row">
                                    <label for="montessori-item-`+_qiplist+`" class="col-9 cursor-pointer mb-1">`+ val.title +`</label>
                                    <span class="text-right col-3">
                                        <input id="montessori-item-`+_qiplist+`" type="checkbox" name="linkids[]" class="modal-checkbox"  value="`+ val.idSubActivity +`" `+val.checked+`>
                                    </span>
                                </div>  
                            </div>
                        `);
                        _qiplist = _qiplist + 1;
                    });
                }else{
                    alert(res.Message);
                }
            });
        });

        $(document).on("click","#btnDevMile",function(){
            $(document).find("#assessment-area").empty();
            $(document).find("#txtType").val("MILESTONE");
            $.ajax({
                url: '<?= base_url("Qip/getAllDevMiles"); ?>/'+qipid+"/"+elementid,
                type: 'POST'
            })
            .done(function(msg) {
                res = $.parseJSON(msg);            
                if (res.Status == "SUCCESS") {
                    let _qiplist = 1;
                    $.each(res.Records, function(index, val) {
                        $("#assessment-area").append(`
                            <div class="ref-block">
                                <div class="ref-title row">
                                    <label for="devmile-item-`+_qiplist+`" class="col-9 cursor-pointer mb-1">`+ val.name +`</label>
                                    <span class="text-right col-3">
                                        <input id="devmile-item-`+_qiplist+`" type="checkbox" name="linkids[]" class="modal-checkbox"  value="`+ val.id +`" `+val.checked+`>
                                    </span>
                                </div>   
                            </div>
                        `);
                        _qiplist = _qiplist + 1;
                    });
                }else{
                    alert(res.Message);
                }
            });
        });

        $(document).on("click","#btnEylf",function(){
            $(document).find("#assessment-area").empty();
            $(document).find("#txtType").val("EYLF");
            $.ajax({
                url: '<?= base_url("Qip/getAllEylf"); ?>/'+qipid+"/"+elementid,
                type: 'POST'
            })
            .done(function(msg) {
                res = $.parseJSON(msg);            
                if (res.Status == "SUCCESS") {
                    let _qiplist = 1;
                    $.each(res.Records, function(index, val) {
                        $("#assessment-area").append(`
                            <div class="ref-block">
                                <div class="ref-title row">
                                    <label for="eylf-item-`+_qiplist+`" class="col-9 cursor-pointer mb-1">`+ val.title +`</label>
                                    <span class="text-right col-3">
                                        <input type="checkbox" id="eylf-item-`+_qiplist+`" name="linkids[]" class="modal-checkbox" value="`+ val.id +`" `+val.checked+`>
                                    </span>
                                </div>    
                            </div>
                        `);
                        _qiplist = _qiplist + 1;
                    });
                }else{
                    alert(res.Message);
                }
            });
        });

        $(document).on("click","#saveQipLinks",function(){
            let type = $("#txtType").val();
            let ids = [];
            let qipid = <?= $_GET['qipid']; ?>;
            let element_id = elementid;

            $('.modal-checkbox:checked').each(function() {
                if (jQuery.inArray($(this).val(), ids) === -1) {
                   ids.push($(this).val());
                }
            });
            
            $.ajax({
                url: "<?php echo base_url('Qip/saveQipLinks'); ?>",
                type: "POST",
                data: {'linktype': type, 'linkids': JSON.stringify(ids), 'qipid': qipid, 'elementid':element_id}
            }).done(function(json){
                console.log(json);
            });
        });

        // $(document).ready(function(){
        //     $('#myModal').draggable({
        //             handle: ".modal-header"
        //     });
        // });

        $('.element-title, .btn-collapsed').on('click', function(){
            if ($(this).hasClass('collapsed')) {
                $(this).closest('.element-heading').css('border-bottom', '1px solid #ececec');
            }else{
                $(this).closest('.element-heading').css('border-bottom', 'none');
            }
        });
    </script>
</body>
</html>





