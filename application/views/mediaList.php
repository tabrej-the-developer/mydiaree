<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Media | Mykronicle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2-bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?id=1234" />
    <style>
		a.delete-recipe-btn:hover {
			color: #ffffff;
			background: #ff0000;
		}
		a.delete-recipe-btn{
			color: #ff0000;
		}
		a.edit-recipe-btn:hover {
			color: #ffffff;
			background: #164768;
		}
		a.edit-recipe-btn{
			color: #164768;
		}
		a.load-recipe:hover {
			color: #ffffff;
			background: #37659d;
		}
		a.load-recipe-btn{
			color: #ff0000;
		}
	</style>
</head>
<body id="app-container" class="menu-default" style="background-color: #f8f8f8; top: -35px; bottom:0px;">
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
    <main class="default-transition" style="opacity: 1;">
        <div class="default-transition" style="opacity: 1;">
            <div class="container-fluid">
                <div class="row" style="">
                    <div class="col-12" style="margin-top: -15px;">
                        <h1>Media</h1>
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
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0" style="background-color: transparent;">
                                <li class="breadcrumb-item">
                                    <a href="#" style="color: dimgray;">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Media</li>
                            </ol>
                        </nav>
                        <div class="separator mb-5"></div>
                    </div>
                    <div class="col-12 list disable-text-selection pb-5" data-check-all="checkAll" style="height: fit-content;">
                        <form action="<?php echo base_url("media/fileUpload"); ?>" method="post" enctype="multipart/form-data" id="form-data">
                            <div class="col-md-12">
                                <div class="row card">
                                    <label for="fileUpload" class="custom-label col-10 card mt-5 mb-3 p-4" style="background-color: #f8f8f8; border: dashed; margin: auto;">
                                        <div class="mediaBox">
                                            <div class="mediaUpload">
                                                <div class="uploadContainer">
                                                    <div class="uploadText h5 text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                                        </svg>
                                                        <br>Upload Files
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                    <input type="file" class="hidden" name="fileUpload[]" id="fileUpload" multiple style="visibility: hidden;">
                                    <div class="ml-2 mr-2 mb-2">
                                        <div id="img-holder" class="row list pr-2 pl-2" data-check-all="checkAll">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3 text-center">
                                    <button type="submit" style="margin: 0 auto;" class="btn btn-primary">
                                        <i class="fa fa-cloud-upload" aria-hidden="true"></i>&nbsp;Upload
                                    </button>   
                                </div>
                            </div>
                        </form>

                        <?php 
                            if(!empty($Recent)){
                        ?>
                            <div class="weekListThumb col-12 p-0">
                                <h3 class="h3">Recent</h3>
                                <div class="weekListThumbBlock col-12 row p-0">
                                    <?php 
                                        if(empty($Recent)){
                                    ?>
                                    <p>No media is available</p>
                                    <?php
                                        }else{
                                            foreach ($Recent as $recent => $rct) { 
                                                if ($rct->type == "mp4") {
                                    
                                    ?>
                                    <div class="img-thumb">
                                        <video controls class="vid-thumb">
                                            <source src="<?php echo base_url("api/assets/media/").$rct->filename ?>" type="video/mp4">
                                        </video>
                                        <button class="media-remove delete-recipe-btn" data-mediaid="<?php echo $rct->id; ?>" style="border: 1px solid red; border-radius: 50% !important; display: inline-block; height: 2.5em; width: 2.5em; align-items: center; padding-top: 3px;">x</button>
                                        <button class="media-edit" data-mediaid="<?php echo $rct->id; ?>"   data-type="video" data-toggle="modal" data-target="#myModal" style="border: 1px solid #37659d; border-radius: 50% !important; display: inline-block; height: 2.5em; width: 2.5em; align-items: center; padding-top: 3px;">
                                            <i class="simple-icon-eye h6"></i>
                                        </button>
                                    </div>
                                    <?php }else{ $find_ext = explode('.',$rct->filename); ?>
                                        <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4 img-thumb list disable-text-selection pr-2 pl-2" data-check-all="checkAll">
                                            <?php if(trim($find_ext[1])=='mp4'){?>
                                                <video style='position: relative;width: 160px;height: 100px;'> 
                                                    <source src="<?php echo base_url("api/assets/media/").$rct->filename ?>" type='video/mp4'>
                                                </video>                    
                                                <button class="media-remove" data-mediaid="<?php echo $rct->id; ?>" style='right: -59px !important;'>x</button>
                                                <button class="media-edit" data-mediaid="<?php echo $rct->id; ?>" style='right: -59px !important;'  data-type="video" data-toggle="modal" data-target="#myModal">
                                                    <span class="material-icons-outlined">visibility</span>
                                                </button>
                                            <?php }else{?>
                                            <!-- <div class=""> -->
                                                <div class="card active h-100">
                                                    <div class="position-relative">
                                                        <a href="#">
                                                            <img class="img-responsive img-thumb w-100" src="<?php echo base_url("api/assets/media/").$rct->filename ?>" style="height: 200px;">
                                                        </a>
                                                    </div>
                                                    <div class="card-body p-2">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="card-footer text-center" style="background: transparent; border-top: none;">
                                                                    
                                                                    <a href="#!" class="delete-recipe-btn media-remove" data-mediaid="<?php echo $rct->id; ?>" style="border: 1px solid red; border-radius: 50% !important; display: inline-block; height: 2.5em; width: 2.5em; align-items: center; padding-top: 3px;">
                                                                        <i class="simple-icon-trash h6"></i>
                                                                    </a>
                                                                
                                                                    <a href="#!" data-toggle="modal" data-mediaid="<?php echo $rct->id; ?>" data-type="image" data-target="#myModal" class="media-edit load-recipe" style="border: 1px solid #37659d; border-radius: 50% !important; display: inline-block; height: 2.5em; width: 2.5em; align-items: center; padding-top: 3px;">
                                                                        <i class="simple-icon-eye h6"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <!-- </div> -->
                                            <?php
                                                }
                                            ?>
                                        </div>
                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php 
                            if(!empty($ThisWeek)){
                        ?>
                            <div class="weekListThumb col-12 p-0">
                                <h3 class="mt-4 h3">This Week</h3>
                                <div class="weekListThumbBlock">
                                    <?php 
                                        if(empty($ThisWeek)){
                                    ?>
                                    <p class="card p-5">No media is available</p>
                                    <?php
                                        }else{
                                            foreach ($ThisWeek as $thisweek => $rct) { 
                                                $find_ext = explode('.',$rct->filename); 
                                                if(trim($find_ext[1])=='mp4'){
                                    ?>
                                    <div class="img-thumb">
                                        <video controls class="vid-thumb"  style='position: relative;width: 160px;height: 100px;'>
                                            <source src="<?php echo base_url("api/assets/media/").$rct->filename ?>" type="video/mp4">
                                        </video>
                                        <button class="media-remove"  data-mediaid="<?php echo $rct->id; ?>" style='right: -59px !important;'>x</button>
                                        <button class="media-edit" data-mediaid="<?php echo $rct->id; ?>" style='right: -59px !important;' data-type="video" data-toggle="modal" data-target="#myModal">
                                            <span class="material-icons-outlined">visibility</span>
                                        </button>
                                    </div>
                                    <?php }else{ ?>
                                    <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4 img-thumb">
                                        <div class="card active h-100">
                                            <div class="position-relative">
                                                <a href="#">
                                                    <img class="img-responsive w-100 img-thumb" src="<?php echo base_url("api/assets/media/").$rct->filename ?>" style="height: 200px;">
                                                </a>
                                            </div>
                                            <div class="card-body p-2">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card-footer text-center" style="background: transparent; border-top: none;">
                                                            <a href="#!" class="delete-recipe-btn media-remove" data-mediaid="<?php echo $rct->id; ?>" style="border: 1px solid red; border-radius: 50% !important; display: inline-block; height: 2.5em; width: 2.5em; align-items: center; padding-top: 3px;">
                                                                <i class="simple-icon-trash h6"></i>
                                                            </a>
                                                            <a href="#!" title="View recipe" data-mediaid="<?php echo $rct->id; ?>" data-type="image" data-toggle="modal" data-target="#myModal" class="load-recipe media-edit" style="border: 1px solid #37659d; border-radius: 50% !important; display: inline-block; height: 2.5em; width: 2.5em; align-items: center; padding-top: 3px;">
                                                                <i class="simple-icon-eye h6"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php 
                            if(!empty($Earlier)){
                        ?>
                            <div class="weekListThumb col-12 p-0">
                                <h3 class="mt-4 h3">Earlier</h3>
                                <div class="weekListThumbBlock row p-0">
                                    <?php 
                                        if(empty($Earlier)){
                                    ?>
                                    <p class="card p-5">No media is available</p>
                                    <?php
                                        }else{
                                            foreach ($Earlier as $earlier => $rct) { 
                                                //if ($rct->type == "mp4") {
                                                    $find_ext = explode('.',$rct->filename); 
                                                //if ($rct->type == "mp4") {
                                                if(trim($find_ext[1])=='mp4'){
                                    
                                    ?>
                                    <div class="img-thumb">
                                        <video controls class="vid-thumb" style='position: relative;width: 160px;height: 100px;'>
                                            <source src="<?php echo base_url("api/assets/media/").$rct->filename ?>" type="video/mp4">
                                        </video>
                                        <button class="media-remove" data-mediaid="<?php echo $rct->id; ?>" style='right: -59px !important;'>x</button>
                                        <button class="media-edit" data-mediaid="<?php echo $rct->id; ?>" data-type="video" data-toggle="modal" style='right: -59px !important;' data-target="#myModal">
                                            <span class="material-icons-outlined">visibility</span>
                                        </button>
                                    </div>
                                    <?php }else{ ?>
                                        <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4 img-thumb">
                                        <div class="card active h-100">
                                            <div class="position-relative">
                                                <a href="#">
                                                    <img class="img-responsive w-100 img-thumb" src="<?php echo base_url("api/assets/media/").$rct->filename ?>" style="height: 200px;">
                                                </a>
                                            </div>
                                            <div class="card-body p-2">
                                                <div class="row p-0">
                                                    <div class="col-12">
                                                        <div class="card-footer text-center" style="background: transparent; border-top: none;">
                                                            <a href="#!" class="delete-recipe-btn media-remove" data-mediaid="<?php echo $rct->id; ?>" style="border: 1px solid red; border-radius: 50% !important; display: inline-block; height: 2.5em; width: 2.5em; align-items: center; padding-top: 3px;">
                                                                <i class="simple-icon-trash h6"></i>
                                                            </a>
                                                            <a href="#!" title="View recipe" data-mediaid="<?php echo $rct->id; ?>" data-type="image" data-toggle="modal" data-target="#myModal" class="load-recipe media-edit" style="border: 1px solid #37659d; border-radius: 50% !important; display: inline-block; height: 2.5em; width: 2.5em; align-items: center; padding-top: 3px;">
                                                                <i class="simple-icon-eye h6"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                                }
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="myModalForm">
                <div class="modal-header">
                    <h4 class="modal-title text-primary" id="myModalLabel">Manage tags</h4>
                    <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <img src="" id="imageContent" class="img-responsive rounded w-100">
                            <video id="videoContent" class="w-100" controls>
                                <source src=""  />
                            </video>
                            <input type="hidden" class="img-count" value="">
                            <div class="form-group">
                             <label>Childs</label>
                             <select class="select2-multiple form-control" multiple="multiple" name="childsId[]" id="child-tags" style="width: 100%;">
                                <?php foreach ($Children as $key => $ch) { ?>
                                <option value="<?php echo $ch->id; ?>"><?php echo $ch->name; ?></option>
                                <?php } ?>
                             </select>
                            </div>
                            <div class="form-group">
                             <label>Educators</label>
                             <select class="select2-multiple form-control" multiple="multiple" name="educatorsId[]" id="staff-tags" style="width: 100%;">
                             <?php foreach ($Users as $key => $ed) { ?>
                                <option value="<?php echo $ed->userid; ?>"><?php echo $ed->name; ?></option>
                             <?php } ?>
                             </select>
                            </div>
                            <div class="form-group">
                                <label>Caption</label>
                                <input type="text" class="form-control" id="imgCaption" value="">
                            </div>
                            <div class="temp-edit-sec">
                                <input type="hidden" id="imageNumber" value="">
                                <input type="hidden" id="mediaRecId" value="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="saveImgAttr" class="btn btn-primary myModalBtn" data-dismiss="modal">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/select2.full.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?id=1234"></script>
</body>
<script>

    $(document).ready(function(){
        $("#fileUpload").on('change', function() {
            // let prevImg = $('.img-preview').length;
            $(".img-preview").remove();
            //Get count of selected files
            const countFiles = $(this)[0].files.length;
            let allGood = true;
            const mainHolder = $("#img-holder");
            for (let i = 0; i < countFiles; i++) {
                const file = this.files[i];
                let fileSize = file.size;
                const url = URL.createObjectURL(file);
                const imgPath = file.name;
                const extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                const image_holder_name = "img-preview-" + i;
                if(fileSize<2097152){
                    if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg" || extn == "mp4") {
                        if (typeof(Blob) != "undefined") {
                            const image_holder = $("#img-preview-" + i);
                            if (extn == "mp4") {
                                mainHolder.append(`<div class="img-preview">
                                                   <video class="thumb-image" controls>
                                                      <source src="${url}" type="video/mp4">
                                                   </video>
                                                   <span class="img-remove">x</span>
                                                   <a class="img-edit" href="#!" data-imgcount="${i}" data-type="video" data-image="${url}" data-toggle="modal" data-target="#myModal"><span class="material-icons-outlined">visibility</span></a>
                                                </div>`);
                            } else {
                              mainHolder.append(`
                                                    <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
                                                        <div class="card active h-100">
                                                            <div class="position-relative">
                                                                <a href="#">
                                                                    <img class="thumb-image img-responsive w-100" src="${url}" style="height: 200px;">
                                                                </a>
                                                            </div>
                                                            <div class="card-body p-2">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="card-footer text-center" style="background: transparent; border-top: none;">
                                                                            <a href="#!" class="delete-recipe-btn img-remove" style="border: 1px solid red; border-radius: 50% !important; display: inline-block; height: 2.5em; width: 2.5em; align-items: center; padding-top: 3px;">
                                                                                <i class="simple-icon-trash h6"></i>
                                                                            </a>
                                                                            <a href="#!" title="View recipe" data-toggle="modal" data-target="#myModal" data-imgcount="${i}" data-type="image" data-image="${url}" class="load-recipe img-edit" style="border: 1px solid #37659d; border-radius: 50% !important; display: inline-block; height: 2.5em; width: 2.5em; align-items: center; padding-top: 3px;">
                                                                                <i class="simple-icon-eye h6"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                `);
                            }
                        }
                    } else {
                        allGood = false;
                        break;
                    }
                }else{
                    allGood = false;
                    break;
                }
                
            }

            if(!allGood){
                alert("Pls select only images and videos that are less than 2MB");
            }
        });

        $(document).on('click','.img-remove',function(){
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
            $(this).closest('.card').remove();
        });

        $(document).on('click','.media-remove',function(){
          var mediaid = $(this).data('mediaid');
          var userid = <?php echo $this->session->userdata('LoginId'); ?>;

                if (confirm('Are you sure,You want to Delete ?')) {
                    $.ajax({
                        traditional:true,
                        type: "GET",
                        url: "<?php echo base_url().'Media/deleteMedia/'; ?>"+userid+"/"+mediaid,
                        success: function(msg){
                            location.reload();
                            //console.log(msg);
                        }
                    });
                }
        });

        $(document).on('click','.img-edit', function (event) {
            let imgNum = $(this).data("imgcount");
            let imgUrl = $(this).data("image");
            $("#imageNumber").val(imgNum);
            $("#imageContent").attr("src",imgUrl);
            $("#saveImgAttr").remove();
            $('#saveImgProp').remove();
            $('.modal-footer').append('<button type="button" id="saveImgAttr" class="btn btn-primary myModalBtn btn-small btnBlue pull-right" data-dismiss="modal">Save Changes</button>');
        });

        $("#centerId").on("change",function(){
            $("#centerDropdown").submit();
            $("#centeridBox").remove();
            $("#form-data").append("<input type='hidden' id='centeridBox' name='centerid' value='"+$(this).val()+"'>");
        });

        $("#form-data").append("<input type='hidden' id='centeridBox' name='centerid' value='"+$("#centerId").val()+"'>");

        $("#saveImgAttr").on("click",function(){
            var imgNum = $("#imageNumber").val();
            var imgCap = $("#imgCaption").val().replace(/'/g, '&apos;');
            var childTags = $("#child-tags").select2("val");
            var eduTags = $("#staff-tags").select2("val");
            for(var i=0; i<childTags.length; i++){
                $("#form-data").append("<input type='hidden' name='childTags"+imgNum+"[]' value='"+childTags[i]+"'>");
            }
            for(var j=0; j<eduTags.length; j++){
                $("#form-data").append("<input type='hidden' name='eduTags"+imgNum+"[]' value='"+eduTags[j]+"'>");
            }
            $("#form-data").append("<input type='hidden' name='caption"+imgNum+"' value='"+imgCap+"'>");
            $("#mediaRecId").remove();           
        });

        $(document).on("click",".media-edit",function(){
            var mediaid = $(this).data("mediaid");
            var type = $(this).data("type");
            if (type=="image") {
                var imgUrl = $(this).siblings(".img-thumb").attr("src");
                $("#imageContent").attr("src",imgUrl);
                $("#videoContent").hide();
            } else {
                //var vidUrl = $(this).siblings(".vid-thumb").find('Source:first').attr('src');
                var vidUrl=$('.vid-thumb').find('Source:first').attr('src')
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
                    $("#staff-tags").val(staffTags);
                    $('#staff-tags').trigger('change');
                    $('#imgCaption').val(res.Media.caption);
                    $('#saveImgAttr').remove();
                    $('#saveImgProp').remove();
                    $('.modal-footer').append('<button type="button" id="saveImgProp" class="btn btn-primary myModalBtn btn-small btnBlue pull-right" data-dismiss="modal">Save Changes</button>');
                }
            });

            $('#myModal').draggable({
                handle: ".modal-header"
            });

        });
        
        $(document).on('click','#saveImgProp',function(){
            var childTags = $("#child-tags").select2("val");
            var mediaId = $('#mediaRecId').val();
            var staffTags = $('#staff-tags').select2("val");
            var imgCaption = $('#imgCaption').val();
            childTags = JSON.stringify(childTags);
            staffTags = JSON.stringify(staffTags);
            $.ajax({
                traditional: true,
                url: "<?php echo base_url("Media/saveImageTags")?>",
                type: "POST",
                data: {"mediaId":mediaId,"childTags":childTags,"staffTags":staffTags,"imgCaption":imgCaption},
                success: function(msg){
                    var res = jQuery.parseJSON(msg);
                    console.log(msg);
                }
            });
            $("#child-tags").select2('destroy').val("").select2();
            $('#staff-tags').select2('destroy').val("").select2();
            $('#mediaRecId').val("");
            $("#myModalForm").get(0).reset();
        });

        $("#form-data").on("submit",function(e){
            var checkFile = $("#fileUpload").val();
            if(checkFile==""){
                e.preventDefault();
                alert("Please select medias before uploading");
            }
        });
    });
</script>
</html>



