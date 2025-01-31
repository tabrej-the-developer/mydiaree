<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Program Plan | Mykronicle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2-bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
    <style>
        .form-control-color{
            border-width: 0px;
            background-color: transparent;
            margin: 5px;
        }
        .input-group-color{
            border: 1px solid #d7d7d7;
            border-right: none;
        }
        .heading_section{
            margin-top: 10px;
        }
        .content{
            margin-top: 10px;
            border-bottom: 1px dotted #d7d7d7;
        }
        .content > span{
            cursor: pointer;
        }
        .d-flex-custom{
            display: flex;
            align-items: center;
            justify-content: space-between;
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
    <?php $this->load->view('sidebar'); ?>
   
    <main data-centerid="<?= isset($centerid)?$centerid:null; ?>">
    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Create Template for Program Plan</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Program Plan List</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create Template</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-xl-12 col-left">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <h3>Create Template</h3>
                            </div>
                            <form action="<?= base_url('lessonPlanList/saveTemplate'); ?>" enctype="multipart/form-data" method="post" autocomplete="off">
                                <?php if (isset($centerid)) { ?>
                                <input type="hidden" name="centerid" value="<?= $centerid; ?>">
                                <?php } ?>
                              
                                <div id="manage-prog-plan">
                                    
                                
                                <div class="row">
                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group mb-1">
                                                <label>Template Name</label>
                                                <div class="input-group text">
                                                    <input type="text" class="form-control" name="template_name" required>
                                                </div>
                                            </div>
                                        </div>
                                </div>  


                                    <div class="row">
                                

                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label>More Options</label><br>
                                                <div>
                                                  
                                                    <button class="btn btn-outline-primary" id="newHeadingBtn" type="button"> + New Heading </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <h5>Add Headings</h5>
                                        </div>
                                    </div>
                                    <?php 
                                        $j = 1;
                                        if(isset($ProgramPlan)){
                                            foreach ($ProgramPlan->headings as $key => $obj) {
                                    ?>
                                    <div class="row heading_section" data-heading="<?= $j; ?>" id="<?= 'heading_section_'.$j; ?>">
                                        <div class="col-md-4 col-lg-4">
                                            <div class="input-group">
                                                <div class="input-group-color">
                                                    <input class="form-control-color" type="color" name="heading_color[]" value="<?= $obj->headingcolor; ?>">
                                                </div>
                                                <input type="text" class="form-control" name="heading_title[]" placeholder="Enter heading" value="<?= $obj->headingname; ?>">
                                            </div>
                                            <div class="form-group" id="<?= 'heading_content_'.$j; ?>">
                                                <p class="text-danger">Note: Click on the &#8595; item to delete it.</p>
                                                <?php 
                                                    foreach ($obj->contents as $conkey => $conobj) {
                                                ?>
                                                <div class="content d-flex-custom">
                                                    <div class="content-info">
                                                    <?= html_entity_decode($conobj->perhaps); ?>
                                                    <input type="hidden" name="<?= 'content_'.$j.'[]'; ?>" value="<?= html_entity_decode($conobj->perhaps); ?>">
                                                    </div>
                                                    <span class="badge badge-danger my-2">x</span>
                                                </div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6">
                                            <textarea id="<?= 'ckEditorClassic_'.$j; ?>"></textarea>
                                        </div>
                                        <div class="col-md-2 col-lg-2">
                                            <button class="btn btn-outline-primary btn-block btn-submit" data-for="<?= $j; ?>" type="button"> SUBMIT </button>
                                            <button class="btn btn-outline-danger btn-block btn-delete-sec" data-sec="<?= $j; ?>" type="button"> DELETE </button>
                                        </div>
                                    </div>
                                    <?php
                                                $j++;
                                            }
                                        }else{
                                    ?>
                                    <div class="row heading_section" data-heading="1" id="heading_section_1">
                                        <div class="col-md-4 col-lg-4">
                                            <div class="input-group">
                                                <div class="input-group-color">
                                                    <input class="form-control-color" type="color" name="heading_color[]" value="">
                                                </div>
                                                <input type="text" class="form-control" name="heading_title[]" placeholder="Enter heading">
                                            </div>
                                            <div class="form-group" id="heading_content_1">
                                                <p class="text-danger">Note: Click on the &#8595; item to delete it.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6">
                                            <textarea id="ckEditorClassic_1"></textarea>
                                        </div>
                                        <div class="col-md-2 col-lg-2">
                                            <button class="btn btn-outline-primary btn-block btn-submit" data-for="1" type="button"> SUBMIT </button>
                                            <button class="btn btn-outline-danger btn-block btn-delete-sec" data-sec="1" type="button"> DELETE </button>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="separator my-3"></div>
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">SAVE</button>
                                </div>
                            </form>
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
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap-datepicker.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/select2.full.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?v=1.0.0"></script>    
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>
    <!-- <script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script> -->
    <script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>

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

        $(document).ready(function(){
            $('.edit').on('click',function(){
                $('#overlay').show();
            })
        });

        function submit_comment(){
            let _comment = $('.commentar').val();
            insert_comment(_comment);
            refreshComments();
        }

        function insert_comment(get_comment){
            let id='<?php #$program_id; ?>';
            $.ajax({
              url:'<?= base_url("lessonPlanList/comments"); ?>',
              type:'POST',
              data:'user_comment='+get_comment+'&programplanparentid='+id,
              success:function(){
                return true;
              }
            });
        }

        function refreshComments() {
            $.ajax({
                url: '<?php #base_url("LessonPlanList/ProgPlanComments/").$program_id."/"; ?>2', //do not send 1
                type: 'GET',
            })
            .done(function(json) {
                res = $.parseJSON(json);
                if (res.Status == "SUCCESS") {
                    $('.commentar').val('');
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

        function set_cka(set_header){
    CKEDITOR.replace(set_header, {
        plugins: 'mentions,basicstyles,undo,link,wysiwygarea,toolbar,format,list',
        contentsCss: [
            'https://cdn.ckeditor.com/4.22.1/full-all/contents.css',
            'https://ckeditor.com/docs/ckeditor4/4.22.1/examples/assets/mentions/contents.css'
        ],
        height: 150,
        toolbar: [{
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
        ]
    });
}

        <?php 
            $j = 1;
            if(isset($ProgramPlan)){
                foreach ($ProgramPlan->headings as $key => $value) {
        ?>
        set_cka('<?= "ckEditorClassic_".$j; ?>');
        <?php
                    $j++;
                }
            }else{
        ?>
        set_cka('ckEditorClassic_1');
        <?php } ?>
        
        //get heading data
        $(document).on('click','.btn-submit', function(){
            let _headingNum = $(this).data('for');
            let _txtData = CKEDITOR.instances['ckEditorClassic_'+_headingNum].getData();

            if (_txtData==='')
            {
                alert('Please write some text in the text area!');
            }else{
                $('#heading_content_'+_headingNum).append(`
                    <div class="content d-flex-custom">
                        <div class="content-info">
                        `+ _txtData +`
                        <input type="hidden" name="content_` + _headingNum + `[]" value="` + _txtData + `">
                        </div>
                        <span class="badge badge-danger my-2">x</span>
                    </div>
                `);
                CKEDITOR.instances['ckEditorClassic_'+_headingNum].setData('');
            }
        });

        $(document).on('click','.content', function(){
            let _confirm = confirm('Are you sure to delte this item?');
            if(_confirm){ $(this).remove(); }
        });

        $(document).on('click','.btn-delete-sec',function(){
            if($('.heading_section').length <= 1){
                alert('Can not delete the item.');
            }else{
                $(this).closest('.heading_section').remove();
            }
        });

        $(document).on('click','#newHeadingBtn',function(){
            const $all = $('[id^="heading_section_"]');
            const maxID = Math.max.apply(Math, $all.map((i, el) => +el.id.match(/\d+$/g)[0]).get());
            let newNum = maxID + 1;
            
            $("#manage-prog-plan").append(`
                <div class="row heading_section" data-heading="`+newNum+`" id="heading_section_`+newNum+`">
                    <div class="col-md-4 col-lg-4">
                        <div class="input-group">
                            <div class="input-group-color">
                                <input class="form-control-color" type="color" name="heading_color[]" value="">
                            </div>
                            <input type="text" class="form-control" name="heading_title[]" placeholder="Enter heading">
                        </div>
                        <div class="form-group" id="heading_content_`+newNum+`">
                            <p class="text-danger">Note: Click on the &#8595; item to delete it.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <textarea id="ckEditorClassic_`+newNum+`"></textarea>
                    </div>
                    <div class="col-md-2 col-lg-2">
                        <button class="btn btn-outline-primary btn-block btn-submit" data-for="`+newNum+`" type="button"> SUBMIT </button>
                        <button class="btn btn-outline-danger btn-block btn-delete-sec" data-sec="`+newNum+`" type="button"> DELETE </button>
                    </div>
                </div>
            `);
            set_cka('ckEditorClassic_'+newNum);
        });

        // var exampleModal = document.getElementById('linkModal');
        $(document).on('show.bs.modal','#linkModal', function (event) {
            var button = event.relatedTarget;
            var type = button.getAttribute('data-at');
            $('#link_type').val(type);
            $('#linkModal').find('.modal-title').text('Link '+type)

            if(type == "observation"){
                loadObservation();
            } else if(type == "qip"){
                loadQip();
            } else if(type == "reflection"){
                loadReflection();
            } else{
                alert('Invalid Method!');             
            }
        });

      
        $(document).on('submit','#save-links-form', function(e){
            e.preventDefault();
            $.ajax({
                url: '<?= base_url('LessonPlanList/saveLinks'); ?>',
                type: 'POST',
                data: $('#save-links-form').serialize(),
            })
            .done(function(msg) {
                res = $.parseJSON(msg);
                alert(res.Message);
            });
            
        });
    </script>
</body>
</html>