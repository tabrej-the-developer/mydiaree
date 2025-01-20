<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Media | Mykronicle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2-bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/dropzone.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
    <style>
		.dropzone .dz-preview.dz-image-preview .edit, .dropzone .dz-preview.dz-file-preview .edit {
            position: absolute;
            right: 5px;
            top: 35px;
            color: #008ecc!important;
            cursor: pointer!important;
        }
        .dropzone .dz-preview.dz-file-preview .remove, .dropzone .dz-preview.dz-image-preview .remove{
            cursor: pointer!important;
        }
        .library-app .dropzone.dz-clickable .dz-message span, .select-from-library-container .dropzone.dz-clickable .dz-message span {
            top: 45px!important;
        }
        .top-right {
            position: absolute;
            top: 8px;
            right: 16px;
            }
            .card-img-top{
                border-bottom-left-radius: 0.75rem !important;
                border-bottom-right-radius: 0.75rem !important;
            }
            .card.active, .position-relative, .card-img-top{
                height: 100%;
            }
	</style>
</head>
<body id="app-container" class="menu-default show-spinner">
<?php $this->load->view('sidebar'); 
    $role = $this->session->userdata('UserType');
    if ($role == "Superadmin") {
        $add = 1;
        $edit = 1;
        $delete = 1;
    } else {
        if ($role == "Staff") {
            if (isset($permissions) && !empty($permissions)) {
                $p = $permissions;
                if ($p->addRecipe == 1) {
                    $add = 1;
                } else {
                    $add = 0;
                }

                if ($p->deleteRecipe == 1) {
                    $delete = 1;
                } else {
                    $delete = 0;
                }

                if ($p->updateRecipe == 1) {
                    $edit = 1;
                } else {
                    $edit = 0;
                }
                
            }else{
                $add = 0;
                $edit = 0;
                $delete = 0;
            }
        } else {
            $add = 0;
            $edit = 0;
            $delete = 0;
        }
    }
?> 
<main data-centerid="<?= isset($centerid)?$centerid:null; ?>">
    <div class="default-transition">
        <div class="container-fluid library-app">
            <div class="row">
                <div class="col-12">
                    <h1>Media</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Media</li>
                        </ol>
                    </nav>
                    <div class="text-zero top-right-button-container">
                        <div class="btn-group mr-1">
                            <?php 
                                $dupArr = [];
                                $centersList = $this->session->userdata("centerIds");
                                if (empty($centersList)) {
                            ?>
                                <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> EMPTY CENTER </div>
                            <?php
                                }else{
                                    if (isset($_GET['centerid'])) {
                                        foreach($centersList as $key => $center){
                                            if ( ! in_array($center, $dupArr)) {
                                                if ($_GET['centerid']==$center->id) {
                            ?>
                            <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= strtoupper($center->centerName); ?> </div>
                            <?php
                                                }
                                            }
                                            array_push($dupArr, $center);
                                        }
                                    } else {
                            ?>
                                <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= strtoupper($centersList[0]->centerName); ?> </div>
                            <?php
                                    }
                                }

                                if (!empty($centersList)) {
                            ?>
                            <div class="dropdown-menu dropdown-menu-right">
                                <?php foreach($centersList as $key => $center){ ?>
                                    <a class="dropdown-item" href="<?= current_url().'?centerid='.$center->id; ?>">
                                        <?= strtoupper($center->centerName); ?>
                                    </a>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="<?= base_url("media/fileUpload"); ?>" enctype="multipart/form-data" method="post" id="form-data">
                                <div class="dropzone">
                                </div>
                            </form>
                            <div class="text-center mt-3">
                                <button class="btn btn-outline-primary" id="clearall">Clear All</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php if(!empty($Recent)){ ?>
                    <div class="col-12 list disable-text-selection mb-5">
                        <h3 class="mb-3">Recent uploads</h3>
                        <div class="row list disable-text-selection" data-check-all="checkAll">
                            <?php 
                                $integerCount = 0;
                                foreach ($Recent as $recent => $rct) { $integerCount++;
                            ?>
                            <div class="col-xl-3 col-lg-3 col-12 col-sm-6 mb-4 main-card-tag" style="max-height:300px;">
                                <div class="card active">
                                    <div class="position-relative">
                                        <a class="" href="#">
                                            <?php if ($rct->type == "Video") { ?>
                                                <i class="iconsminds-camera-4"></i>
                                            <?php } else { ?>
                                                <img src="<?= base_url('api/assets/media/').$rct->filename; ?>" alt="uploaded image" class="card-img-top" />
                                                <a class="top-right text-white" href="#!" id="dropdown-<?= $integerCount; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="simple-icon-options-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdown-<?= $integerCount; ?>">
                                                    <a class="dropdown-item view-media" href="#!" data-mediaid="<?= $rct->id; ?>" data-toggle="modal" data-target="#viewModal">View</a>
                                                    <a class="dropdown-item media-tags" href="#!" data-mediaid="<?= $rct->id; ?>" data-toggle="modal" data-target="#myModal">Tags</a>
                                                    <a class="dropdown-item delete-media" href="#!" data-mediaid="<?= $rct->id; ?>">Delete</a>
                                                </div>
                                            <?php } ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if(!empty($ThisWeek)){ ?>
                    <div class="col-12 list disable-text-selection mb-5">
                        <h3 class="mb-3">This Week</h3>
                        <div class="row list disable-text-selection" data-check-all="checkAll">
                            <?php $integerCount = 0; foreach ($ThisWeek as $thisweek => $rct) { $integerCount++; ?> 
                            <div class="col-xl-2 col-lg-3 col-12 col-sm-6 mb-4 main-card-tag">
                                <div class="card active">
                                    <div class="position-relative">
                                        <a class="" href="#">
                                            <?php if ($rct->type == "Video") { ?>
                                                <i class="iconsminds-camera-4"></i>
                                            <?php } else { ?>
                                                <img src="<?= base_url('api/assets/media/').$rct->filename; ?>" alt="uploaded image" class="card-img-top" />
                                                <a class="top-right text-white" href="#!" id="dropdown-<?= $integerCount; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="simple-icon-options-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdown-<?= $integerCount; ?>">
                                                    <a class="dropdown-item view-media" href="#!" data-mediaid="<?= $rct->id; ?>" data-toggle="modal" data-target="#viewModal">View</a>
                                                    <a class="dropdown-item media-tags" href="#!" data-mediaid="<?= $rct->id; ?>" data-toggle="modal" data-target="#myModal">Tags</a>
                                                    <a class="dropdown-item delete-media" href="#!" data-mediaid="<?= $rct->id; ?>">Delete</a>
                                                </div>
                                            <?php } ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div> 
                <?php } ?>
                <?php if(!empty($Earlier)){ ?>
                    <div class="col-12 list disable-text-selection mb-5">
                        <h3 class="mb-3">Earlier</h3>
                        <div class="row list disable-text-selection" data-check-all="checkAll">
                            <?php $integerCount = 0;foreach ($Earlier as $earlier => $rct) { $integerCount++; ?>
                                <div class="col-xl-3 col-lg-3 col-12 col-sm-6 mb-4 main-card-tag" style="max-height:300px;">
                                <div class="card active">
                                    <div class="position-relative">
                                        <a class="" href="#">
                                            <?php if ($rct->type == "Video") { ?>
                                                <i class="iconsminds-camera-4"></i>
                                            <?php } else { ?>
                                                <img src="<?= base_url('api/assets/media/').$rct->filename; ?>" alt="uploaded image" class="card-img-top" />
                                                <a class="top-right text-white" href="#!" id="dropdown-<?= $integerCount; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="simple-icon-options-vertical"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdown-<?= $integerCount; ?>">
                                                    <a class="dropdown-item view-media" href="#!" data-mediaid="<?= $rct->id; ?>" data-toggle="modal" data-target="#viewModal">View</a>
                                                    <a class="dropdown-item media-tags" href="#!" data-mediaid="<?= $rct->id; ?>" data-toggle="modal" data-target="#myModal">Tags</a>
                                                    <a class="dropdown-item delete-media" href="#!" data-mediaid="<?= $rct->id; ?>">Delete</a>
                                                </div>
                                            <?php } ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
<!-- Tags Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="myModalForm">
                <div class="modal-header">
                    <h4 class="modal-title text-primary" id="myModalLabel">Manage tags</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <img src="" id="imageContent" class="img-responsive rounded w-100">
                            <video id="videoContent" class="w-100" controls>
                                <source src=""  />
                            </video> -->
                            <div class="form-group">
                                <label>Childs<?php //print_r($Children); ?></label>
                                <select class="select2-multiple form-control" multiple="multiple" name="childTags[]" id="child-tags" style="width: 100%;">
                                    <?php foreach ($Children as $key => $ch) {

                                        ?>
                                    <option value="<?php echo $ch->childid; ?>"><?php echo $ch->childname; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Educators <?php// print_r($Users); ?></label>
                                <select class="select2-multiple form-control" multiple="multiple" name="staffTags[]" id="staff-tags" style="width: 100%;">
                                    <?php foreach ($Users as $key => $ed) { ?>
                                    <option value="<?php echo $ed->userid; ?>"><?php echo $ed->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Caption</label>
                                <input type="text" class="form-control" id="imgCaption" name="imgCaption" value="">
                            </div>
                            <div class="temp-edit-sec">
                                <input type="hidden" id="mediaRecId" name="mediaId" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" id="saveImgAttr" class="btn btn-primary myModalBtn" data-dismiss="modal">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Tags Modal End -->

<!-- View Media Modal -->
<div class="modal fade bd-example-modal-lg" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="viewModalLabel">View Media</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="viewMediaBody" style="background-color: #d8d8d8;">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- View Media Modal End -->

<?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/dropzone.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/select2.full.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>
</body>
<script>
    $(function() {
        if ($().dropzone && !$(".dropzone").hasClass("disabled")) {

        let formData = $('#form-data');
          $(".dropzone").dropzone({
            maxFilesize: 100000,
            timeout:0,
            url: "<?= base_url('Media/uploadFiles'); ?>",
            init: function () {
                this.on("success", function (file, responseText) {
                    result = $.parseJSON(responseText);
                    if (result.Status=="SUCCESS") {
                        file.previewElement.id = result.recordid;
                        $(document).find('.dz-preview[id="' + result.recordid + '"]').attr('data-type', result.type);
                    }else{
                        alert(result.Message);
                    }
                });

                this.on("sending", function(file, xhr, formData) {
                  formData.append("centerid", $('main').data('centerid'));
                });

                this.on('error', function(file, responseText) {
                    result = $.parseJSON(responseText);
                    $(file.previewElement).find('.dz-error-message').text(result.Message);
                });
            },
            thumbnailWidth: 160,
            previewTemplate: `
                <div class="dz-preview dz-file-preview mb-3" data-type="">
                    <div class="d-flex flex-row">
                        <div class="p-0 w-30 position-relative">
                            <div class="dz-error-mark">
                                <span><i></i></span>
                            </div>
                            <div class="dz-success-mark">
                                <span><i></i></span>
                            </div>
                            <div class="preview-container">
                                <img data-dz-thumbnail class="img-thumbnail border-0"/>
                                <i class="simple-icon-doc preview-icon"></i>
                            </div>
                        </div>
                        <div class="pl-3 pt-2 pr-2 pb-1 w-70 dz-details position-relative">
                            <div><span data-dz-name></span></div>
                            <div class="text-primary text-extra-small" data-dz-size />
                            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                            <div class="dz-error-message"><span data-dz-errormessage></span></div>
                        </div>
                    </div>
                    <a href="#/" class="remove"><i class="glyph-icon simple-icon-trash"></i></a>
                    <a href="#/" class="edit" data-image="data-dz-thumbnail" data-toggle="modal" data-target="#myModal"><i class="glyph-icon simple-icon-tag"></i></a>
                </div>
            `
          });
        }

        $(document).on('click','.edit', function (event) {
            let _id = $(this).closest('.dz-preview').attr('id');
            let _type = $(this).closest('.dz-preview').data('type');
            if (_type == "Image" || _type == "Video") {
                $.ajax({
                    url: '<?= base_url("Media/getTagsArr"); ?>',
                    type: 'POST',
                    data: {'mediaid': _id},
                })
                .done(function(msg) {
                    console.log(msg);
                    res = jQuery.parseJSON(msg);
                    var childTags = [];
                    var staffTags = [];
                    $(res.ChildTags).each(function(){
                       childTags.push(this.userid);
                    });
                    console.log(childTags);
                    $(res.StaffTags).each(function(){
                       staffTags.push(this.userid);
                    });
                    $("#child-tags").val(childTags);
                    $('#child-tags').trigger('change');
                    $("#staff-tags").val(staffTags);
                    $('#staff-tags').trigger('change');
                    $('#imgCaption').val(res.Media.caption);
                    $('#mediaRecId').val(_id);
                });
            } else {
                alert('Unsupported file! Please select a valid Image or Video file.');
            }
        });

        $("#saveImgAttr").on("click", function(){
            $.ajax({
                traditional: true,
                url: "<?php echo base_url('Media/storeImageTags')?>",
                type: "POST",
                data: $('#myModalForm').serialize(),
                success: function(msg){
                    // var res = jQuery.parseJSON(msg);
                    console.log(msg);
                }
            });
        });

        $(document).on('click', '.remove', function(){
            var mediaid = $(this).closest('.dz-preview').attr('id');
            if (confirm('Are you sure you want to Delete ?')) {
                deleteMedia(mediaid);
                $(this).closest('.dz-preview').remove();
            }
        });

        function deleteMedia(mediaid = null){
            $.ajax({
                traditional:true,
                type: "GET",
                url: "<?= base_url('Media/deleteMedia/'); ?>"+ mediaid,
                success: function(msg){
                    res = $.parseJSON(msg);
                    console.log(res.Message);
                    location.reload();
                }
            });
        }

        $('#clearall').on('click', function() {
            location.reload();
        });

        $(document).on('click','.delete-media',function(){
            var mediaid = $(this).data('mediaid');
            if (confirm('Are you sure,You want to Delete ?')) {
                deleteMedia(mediaid);
                $('#recents-' + mediaid).remove();
                $('#earlier-' + mediaid).remove();
                $('#thisweek-' + mediaid).remove();
            }
        });

        $(document).on('click','.media-tags', function (event) {
            let _id = $(this).data('mediaid');
            $.ajax({
                url: '<?= base_url("Media/getTagsArr"); ?>',
                type: 'POST',
                data: {'mediaid': _id},
            })
            .done(function(msg) {
                res = jQuery.parseJSON(msg);
                var childTags = [];
                var staffTags = [];
                $(res.ChildTags).each(function(){
                   childTags.push(this.userid);
                });
                console.log(childTags);
                $(res.StaffTags).each(function(){
                   staffTags.push(this.userid);
                });
                $("#child-tags").val(childTags);
                $('#child-tags').trigger('change');
                $("#staff-tags").val(staffTags);
                $('#staff-tags').trigger('change');
                $('#imgCaption').val(res.Media.caption);
                $('#mediaRecId').val(_id);
            });
        });

        $(document).on('click','.view-media', function (event) {
            let _id = $(this).data('mediaid');
            console.log(_id);
            $.ajax({
                url: '<?= base_url("Media/getMediaInfo"); ?>',
                type: 'POST',
                data: {'mediaid': _id},
            })
            .done(function(msg) {
                
                res = jQuery.parseJSON(msg);
                if (res.Status == "SUCCESS") {

                    if (res.Media.userImage == "") {
                        res.Media.userImage = 'https://via.placeholder.com/80x80?text=No+Media';
                    }

                    if(res.Media.type == "Image"){
                        media = `<img class="img-fluid border-0 border-radius mb-3" src="<?= base_url('api/assets/media/'); ?>` + res.Media.filename + `">`;
                    }else{
                        media = `
                                <video id="my-video" class="video-js card-img video-content" controls preload="auto" poster="https://via.placeholder.com/1920x1080?text=No+Video+Thumbnail" data-setup="{}">
                                    <source src="<?= base_url('api/assets/media/'); ?>` + res.Media.filename + `" type='video/mp4'>
                                </video>
                        `;
                    }
                    let tags = "";
                    $.each(res.Media.tags, function(index, val) {
                        if(val.type == "child"){
                            tags = tags + `
                                <div class="badge badge-pill badge-outline-success mb-1">
                                    `+val.name+`
                                </div>
                            `;
                        }else{
                            tags = tags + `
                                <div class="badge badge-pill badge-outline-primary mb-1">
                                    `+val.name+`
                                </div>
                            `;
                        }
                        
                    });

                    $('#viewMediaBody').empty();

                    $('#viewMediaBody').append(`
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex flex-row mb-3">
                                    <a href="#">
                                        <img src="<?= base_url('api/assets/media/'); ?>` + res.Media.userImage + `" alt="` + res.Media.createdBy + `" class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall">
                                    </a>
                                    <div class="pl-3">
                                        <a href="#">
                                            <p class="font-weight-medium mb-0 ">` + res.Media.createdBy + `</p>
                                            <p class="text-muted mb-0 text-small">` + res.Media.uploaded_date + `</p>
                                        </a>
                                    </div>
                                </div>
                                <p>
                                    ` + res.Media.caption + `
                                </p>
                                <a href="https://via.placeholder.com/1920x1080?text=No+Media" class="lightbox">
                                    `+ media +`
                                </a>
                                <div>
                                    ` + tags + `
                                </div>
                            </div>
                        </div>
                    `);
                }else{
                    $('#viewMediaBody').append('<div class="text-center"><h1 class="fw-light">No Media Found!</h1><p class="text-muted">If this was an error caused due to platform, Please contact to support team.</p></div>');
                }
            });
        });
    });
</script>
</html>