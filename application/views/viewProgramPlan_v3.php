<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Program Plan | Mykronicle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
    <style>
        .obs-link{
            color: #008ecc;
        }
        .obs-link:hover{
            color: #000000;
        }
        .comment-section{
            width: 100%;
            display: block;
        }
        .list-thumbnail{
            width: 85px!important;
        }
        .list-thumbnail.xsmall{
            width: 40px!important;
        }
        .d-flex-custom{
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .content > p{
            font-size: 1rem!important;
        }
    </style>
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <main data-centerid="<?= isset($centerid)?$centerid:null; ?>">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>View Program Plan</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('lessonPlanList/programPlanList'); ?>">Program Plan List</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">View Program Plan</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-xl-4 col-left">
                    <div class="card mb-4">
                        <div class="position-absolute card-top-buttons">
                            <button class="btn btn-header-light icon-button" onclick="refreshComments()">
                                <i class="simple-icon-refresh"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h3>Comments</h3>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="scroll" style="height: 400.813px;">
                                        <div class="scroll-content" id="users-comments">
                                            <?php 
                                                if(isset($Comments)){
                                                    foreach ($Comments as $cmntKey => $cmntObj) {
                                                        if(empty($cmntObj->userImage)){
                                                            $uimage = "https://via.placeholder.com/50x50?text=No+Media";
                                                        }else{
                                                            $uimage = base_url()."api/assets/media/".$cmntObj->userImage;
                                                        }
                                            ?>
                                            <div class="d-flex flex-row mb-3 border-bottom justify-content-between">
                                                <a href="#">
                                                    <img src="<?= $uimage; ?>" alt="<?= $cmntObj->userName; ?>" class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall" width="40px" height="40px">
                                                </a>
                                                <div class="pl-3 flex-grow-1">
                                                    <a href="#">
                                                        <p class="font-weight-medium mb-0 "><?= $cmntObj->userName; ?></p>
                                                        <p class="text-muted mb-0 text-small"><?= $cmntObj->commentdatetime; ?></p>
                                                    </a>
                                                    <p class="mt-3">
                                                        <?= $cmntObj->commenttext; ?>
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
                            <div class="comment-contaiener">
                                <div class="input-group">
                                    <input type="text" class="form-control commentar" placeholder="Add a comment">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary btn-submit-comment" type="button">
                                            <span class="d-inline-block">Send</span> 
                                            <i class="simple-icon-arrow-right ml-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-xl-8 col-right">
                    <ul class="nav nav-tabs separator-tabs ml-0 mb-5" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab" aria-controls="first" aria-selected="false">DETAILS</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="second-tab" data-toggle="tab" href="#second" role="tab" aria-controls="second" aria-selected="true">USERS</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="first" role="tabpanel" aria-labelledby="first-tab">    
                            <?php foreach ($ProgramPlan->headings as $programs => $prog) { ?>
                            <div class="card mb-4">
                                <div class="card-body" style="border-left: 5px solid <?= $prog->headingcolor; ?>; border-radius: inherit;">
                                    <div class="mb-3 d-flex d-flex-custom">
                                        <h3 style="color: <?= $prog->headingcolor; ?>;"><?= ucfirst($prog->headingname); ?></h3>
                                    </div>
                                    <div class="content">
                                        <?php
                                            foreach ($prog->contents as $conkey => $conval) {
                                                echo html_entity_decode($conval->perhaps);
                                            } 
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="tab-pane" id="second" role="tabpanel" aria-labelledby="second-tab">
                            <div class="row">
                                <?php 
                                    if (isset($ProgramPlan->users) && !empty($ProgramPlan->users)) {
                                        foreach ($ProgramPlan->users as $proUsersKey => $proUsersObj) {
                                            if (empty($proUsersObj->imageUrl)) {
                                                $userImage = "https://via.placeholder.com/80x80?text=No+Media";
                                            }else{
                                                $userImage = base_url()."api/assets/media/".$proUsersObj->imageUrl;
                                            }
                                ?>
                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="card d-flex flex-row mb-4">
                                        <a class="d-flex" href="#">
                                            <img alt="Profile" src="<?= $userImage; ?>" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center">
                                        </a>
                                        <div class=" d-flex flex-grow-1 min-width-zero">
                                            <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                                                <div class="min-width-zero">
                                                    <a href="#">
                                                        <p class="list-item-heading mb-1 truncate"><?= $proUsersObj->name; ?></p>
                                                    </a>
                                                    <p class="mb-2 text-muted text-small"><?= $proUsersObj->userType; ?></p>
                                                    <button type="button" class="btn btn-xs btn-outline-primary ">View</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                        }
                                    }else{
                                ?>
                                <div class="lead">
                                    No users are there in this program plan.
                                </div>
                                <?php }  ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </main>
    <?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>

    <script type="text/javascript">
        $(document).on('click','.delete',function(){
            var id = $(this).attr('id');
            var that = this;
            if (confirm('Are you sure You want to Delete?')) {
                $.ajax({
                url : '<?php echo base_url()?>lessonPlanList/delete',
                type : 'POST',
                data :'id='+$(this).attr('id'),
                    success : function(response){
                        location.reload();
                    }
                });
            }
        });

        function refreshComments() {
            $.ajax({
                url: '<?= base_url("LessonPlanList/ProgPlanComments/").$program_id."/"; ?>2', //do not send 1
                type: 'GET',
            })
            .done(function(json) {
                res = $.parseJSON(json);
                if (res.Status == "SUCCESS") {
                    $("#users-comments").empty();
                    $.each(res.Comments, function(index, val) {
                        if(val.userImage.length == 0){
                            uimage = "https://via.placeholder.com/50x50?text=No+Media";
                        }else{
                            uimage = '<?= base_url()."api/assets/media/"; ?>' + val.userImage;
                        }
                        $("#users-comments").append(`
                            <div class="d-flex flex-row mb-3 border-bottom justify-content-between">
                                <a href="#">
                                    <img src="`+ uimage +`" alt="`+ val.userName +`" class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall" width="40px" height="40px">
                                </a>
                                <div class="pl-3 flex-grow-1">
                                    <a href="#">
                                        <p class="font-weight-medium mb-0 ">`+ val.userName +`</p>
                                        <p class="text-muted mb-0 text-small">`+ val.commentdatetime +`</p>
                                    </a>
                                    <p class="mt-3">
                                        `+ val.commenttext+`
                                    </p>
                                </div>
                            </div>
                        `);
                    });
                }else{
                    alert(res.Message);
                }
            });
        }

        function submit_comment(){
            let _comment = $('.commentar').val();
            if(_comment == ""){
                alert('Please enter some text!');
            }else{
                insert_comment(_comment);
                $('.commentar').val('');
                refreshComments();
            }
        }

        function insert_comment(get_comment){
            let id='<?= $program_id; ?>';
            $.ajax({
              url:'<?= base_url("lessonPlanList/comments"); ?>',
              type:'POST',
              data:'user_comment='+get_comment+'&programplanparentid='+id,
              success:function(data){
                console.log(data);
                
                return true;
              }
            });
        }

        $(document).ready(function(){
            $('.edit').on('click',function(){
                $('#overlay').show();
            });

            $('.btn-submit-comment').on('click', function(event) {
                event.preventDefault();
                submit_comment();
            });
        });
    </script>
</body>
</html>