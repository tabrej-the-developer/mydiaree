<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resources List | Mydiaree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/video-js.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/baguetteBox.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
    <style>
        .list-thumbnail.xsmall{
            width: 40px;
        }  
        button.carousel-control-next, button.carousel-control-prev {
            background: transparent;
            border: none;
        }
    </style>
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Resources List</h1>
                    <div class="text-zero top-right-button-container">
                        <a href="<?php echo base_url('Resources/add'); ?>" class="btn btn-primary btn-lg top-right-button">ADD NEW</a>
                    </div>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Resources List</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8" id="flexResourceListView">
                    <?php if(empty($resources)){ ?> 
                    <div class="col">
                        <div class="text-center">
                            <h6 class="mb-4">Ooops... looks like we don't have enough data!</h6>
                            <p class="mb-0 text-muted text-small mb-0">Error code</p>
                            <p class="display-1 font-weight-bold mb-5">
                                200
                                <!-- <img src="<?= base_url('api/assets/media/Asset 2.png'); ?>"> -->
                            </p>
                            <a href="<?= base_url('dashboard'); ?>" class="btn btn-primary btn-lg btn-shadow">GO BACK HOME</a>
                        </div>
                    </div>       
                    <?php 
                        }else{  
                            $i = 1;
                            foreach ($resources as $key => $res) {

                                if (empty($res->createdBy)) {
                                    $image = BASE_API_URL . "assets/media/dummy-user.jpg";
                                    $res->createdBy = new stdClass();
                                    $res->createdBy->name = "Unknown";
                                }else{
                                    if($res->createdBy->imageUrl == ""){
                                        $image = BASE_API_URL . "assets/media/dummy-user.jpg";
                                    }else{
                                        $image = BASE_API_URL . "assets/media/" . $res->createdBy->imageUrl;
                                    }
                                }   
                    ?>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex flex-row mb-3">
                                <a href="<?= base_url('resources/viewResource')."?resId=".$res->id; ?>">
                                    <img src="<?= $image; ?>" alt="<?= $res->createdBy->name; ?>" class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall" height="40px" width="40px"/>
                                </a>
                                <div class="pl-3">
                                    <a href="<?= base_url('resources/viewResource') . "?resId=" . $res->id; ?>">
                                        <p class="font-weight-medium mb-0 "><?= $res->createdBy->name; ?></p>
                                        <p class="text-muted mb-0 text-small"><?= date('d.m.Y - h:i',strtotime($res->createdAt)); ?></p>
                                    </a>
                                </div>
                                <?php if ($res->createdBy->id == $this->session->userdata('LoginId')) { ?>
                                <div class="position-absolute card-top-buttons">
                                    <button class="btn btn-header-light icon-button delete-post" data-id="<?= $res->id; ?>">
                                        <i class="simple-icon-trash"></i>
                                    </button>
                                </div>
                                <?php } ?>
                            </div>
                            <?= html_entity_decode($res->description); ?>
                            <?php 
                                if (!empty($res->media)) { 
                                    if (count($res->media) > 1) {
                                        $intCount = 1;
                            ?>
                            <div id="carousel-<?= $res->id; ?>" class="carousel slide mb-3" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php
                                        foreach ($res->media as $medias => $media) {
                                            if ($intCount == 1) {
                                                $active = " active";
                                            }else{
                                                $active = "";
                                            }

                                            if ($media->mediaType == "Image") {
                                    ?>
                                    <div class="carousel-item <?= $active; ?> text-center">
                                        <img src="<?= base_url('api/assets/media/') . $media->mediaUrl; ?>" class="border-0 border-radius" height="390px" alt="">
                                    </div>
                                    <?php   } else if($media->mediaType == "Video"){ ?>
                                    <div class="carousel-item<?= $active; ?> text-center">
                                        <video src="<?= BASE_API_URL."assets/media/".$media->mediaUrl; ?>" class="border-0 border-radius" height="390px" controls></video>
                                    </div>
                                    <?php
                                            }

                                            $intCount++;
                                        }
                                    ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-target="#carousel-<?= $res->id; ?>" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-target="#carousel-<?= $res->id; ?>" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </button>
                            </div>
                            <?php
                                    }else{
                                        //if single element
                                        foreach ($res->media as $medias => $media) {
                                            if ($media->mediaType == "Image") {
                            ?>
                            <a href="<?= base_url('api/assets/media/') . $media->mediaUrl; ?>" class="lightbox">
                                <img class="border-0 border-radius mb-3" height="390px" src="<?= base_url('api/assets/media/') . $media->mediaUrl; ?>"/>
                            </a>
                            <?php
                                            }else{
                            ?>
                            <div class="position-relative mb-3">
                                <video id="<?= "my-video-" . $res->id; ?>" class="video-js card-img video-content" controls preload="auto" poster="https://via.placeholder.com/1280x720?text=Click+to+play+video" data-setup="{}">
                                    <source src="<?= base_url('api/assets/media/') . $media->mediaUrl; ?>" type='video/mp4'>
                                </video>
                            </div>
                            <?php
                                            }
                                        }
                                    }
                                } 
                            ?>
                            
                            <div class="post-actions">
                                <?php if ($res->likes->liked==0) { ?>
                                    <div class="post-icon mr-3 d-inline-block like-btn do-like" data-resourceid="<?php echo $res->id; ?>">
                                        <a href="#!"><i class="far fa-heart mr-1"></i></a> 
                                        <span>
                                            <?php 
                                                if($res->likes->likesCount==1)
                                                { 
                                                    echo  $res->likes->likesCount." Like";
                                                }elseif($res->likes->likesCount>1){
                                                    echo  $res->likes->likesCount." Likes";
                                                }else{

                                                }
                                            ?>
                                        </span>
                                    </div>
                                <?php }else{ ?>
                                    <div class="post-icon mr-3 d-inline-block like-btn do-unlike" data-resourceid="<?php echo $res->id; ?>" data-likeid="<?php echo $res->likes->likeid; ?>">
                                        <a href="#!"><i class="fas fa-heart mr-1"></i></a> 
                                        <span>
                                            <?php 
                                                if($res->likes->likesCount==1)
                                                {
                                                    echo  $res->likes->likesCount." Like";
                                                }elseif($res->likes->likesCount > 1){
                                                    echo  $res->likes->likesCount." Likes";
                                                }else{

                                                }
                                            ?>
                                        </span>
                                    </div>
                                <?php } ?>
                                <?php if ($res->comments->totalComments > 0) { ?>
                                <div class="post-icon d-inline-block comments-count" id="comments-count-<?= $res->id; ?>"><i class="simple-icon-bubble mr-1"></i> <span><?= $res->comments->totalComments; ?> Comment</span></div>
                                <?php } else { ?>
                                <div class="post-icon d-inline-block comments-count" id="comments-count-<?= $res->id; ?>"><i class="simple-icon-bubble mr-1"></i> <span>0 Comment</span></div>
                                <?php } ?>                                
                            </div>
                            <div class="mt-5">
                                <div id="comments-section-<?= $res->id; ?>">
                                    <?php if ($res->comments->userCommented!=NULL) { ?>
                                    <div class="d-flex flex-row mb-4">
                                        <a href="#">
                                            <img src="<?= BASE_API_URL."assets/media/".$res->comments->userCommentedImage; ?>" alt="<?= $res->comments->userCommented; ?>" class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall"/>
                                        </a>
                                        <div class="pl-3">
                                            <a href="#">
                                                <p class="font-weight-medium mb-0 "><?= $res->comments->userCommented; ?></p>
                                                <p class="text-muted mb-0 text-small"><?= $res->comments->timeCmnted; ?></p>
                                            </a>
                                            <p class="mt-3"><?= $res->comments->lastComment; ?></p>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>

                                <div class="comment-contaiener">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Add a comment" id="resource-post-<?= $res->id; ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary add-comment" type="button" data-resourceid="<?= $res->id; ?>">
                                                <span class="d-inline-block">Send</span> 
                                                <i class="simple-icon-arrow-right ml-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } } ?>
                </div>

                <!-- filter and tags sidebar -->
                <div class="col-12 col-md-4" id="resource-sidebar">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Trending Tags</h5>
                            <div class="flexResourcesTags">
                                <?php 
                                    if (!empty($trendingTags)) {
                                        foreach ($trendingTags as $trendingtags => $trending) {
                                ?>
                                <button class="loadTag badge badge-pill badge-outline-theme-2 mb-1" data-tag="<?php echo $trending->tags; ?>">
                                    <?php echo $trending->tags; ?>
                                </button>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Filters</h5>
                            <form action="" method="get" autocomplete="off">
                                <div class="sub-panel-section">
                                    <div class="sub-panel-title">
                                        <strong>Show Resources</strong>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control datepickcal" name="fromdate" placeholder="Choose From date">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control datepickcal" name="todate" placeholder="Choose To date">
                                    </div>
                                </div>
                                <div class="sub-panel-section">
                                    <div class="sub-panel-title">
                                        <strong>Select Center</strong>
                                    </div>
                                    <div class="form-group">
                                        <select name="centerid" id="centerid" class="form-control">
                                            <option value="">Choose center</option>
                                            <?php 
                                                $dupArr = [];
                                                $centersList = $this->session->userdata("centerIds");
                                                if (empty($centersList)) {
                                            ?>
                                            <option value="">-- No centers available --</option>
                                            <?php
                                                }else{
                                                    foreach($centersList as $key => $center){
                                            ?>
                                            <option value="<?php echo $center->id; ?>"><?php echo $center->centerName; ?></option>
                                            <?php   } } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="sub-panel-section">
                                    <div class="sub-panel-title">
                                        <strong>Select Author</strong>
                                    </div>
                                    <div class="form-group">
                                        <select name="author" id="author" class="form-control">
                                            <option value="">Choose an Author</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="sub-panel-section text-center">
                                    <button type="submit" id="apply-filter" class="btn btn-primary">Apply</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- filter and tags sidebar -->
            </div>  
        </div>
    </main>

    <?php $this->load->view('footer_v3'); ?>
    
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="https://kit.fontawesome.com/5be04f7085.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/baguetteBox.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap-datepicker.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/video.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>
    <script>
        $(document).on('click','.do-like', function(){
            var elemObj = $(this);
            var resId = $(this).data('resourceid');
            var userid = <?php echo $this->session->userdata("LoginId"); ?>;
            //Perform Ajax
            $.ajax({
                traditional:true,
                type: "POST",
                url: "<?= base_url().'Resources/addLike'; ?>",
                data: {"userid":userid,'resourceId':resId},
                success: function(msg){
                    console.log(msg);
                    var ajaxObj = jQuery.parseJSON(msg);
                    if (ajaxObj.Message=="Liked") {
                        elemObj.addClass("do-unlike").removeClass("do-like");
                        elemObj.find('a').empty();
                        elemObj.find('a').append('<i class="fas fa-heart mr-1"></i>');
                        elemObj.find('span').empty();
                        elemObj.find('span').append(ajaxObj.likes);
                        elemObj.attr("data-likeid", ajaxObj.likeId);
                    } else {
                        alert(ajaxObj.Message);
                    }
                }
            });
        });

        $(document).on('click','.do-unlike',function(){
            var eleObj = $(this);
            var likeid = $(this).attr('data-likeid');
            var userid = <?= $this->session->userdata("LoginId"); ?>;
            //Perform Ajax
            $.ajax({
                traditional:true,
                type: "POST",
                url: "<?php echo base_url().'Resources/removeLike'; ?>",
                data: {"userid":userid,'likeId':likeid},
                success: function(msg){
                    console.log(msg);
                    var ajaxObj = jQuery.parseJSON(msg);
                    if (ajaxObj.Message=="Disliked") {
                        eleObj.addClass("do-like").removeClass("do-unlike");
                        eleObj.find('a').empty();
                        eleObj.removeAttr('data-likeid');
                        eleObj.find('a').append('<i class="far fa-heart mr-1"></i>');
                        eleObj.find('span').empty();
                        eleObj.find('span').append(ajaxObj.likes);
                    } else {
                        alert(ajaxObj.Message);
                    }
                }
            });
        });

        $(document).on('click',"button.add-comment", function(e){
            e.preventDefault();
            var resId = $(this).data("resourceid");
            var comment = $('#resource-post-'+resId).val();
            if (comment=="") {
                $('#resource-post'+resId).attr("placeholder","Please enter your comment.").css("border-bottom", "1px solid #FF0000");
            } else {
                $.ajax({
                    traditional:true,
                    type: "POST",
                    url: "<?= base_url().'Resources/addComment'; ?>",
                    data: {'comment':comment,'resourceId':resId},
                    success: function(msg){
                        console.log(msg);
                        var ajaxObj = jQuery.parseJSON(msg);

                        if (ajaxObj.Status=="SUCCESS") {
                            $('#resource-post-'+resId).val('');
                            $('#resource-post-'+resId).css({
                                "background": "#fff",
                                "color": "#3a3a3a",
                                "border-color": "#d7d7d7"
                            });

                            $('#comments-section-'+resId).empty();

                            var _totalComments = ajaxObj.Comments.length;
                            var _count = 1;

                            $.each(ajaxObj.Comments, function(index, val) {

                                if (_totalComments == _count) {
                                    _class = "d-flex flex-row mb-3";
                                } else {
                                    _class = "d-flex flex-row mb-3 border-bottom";
                                }

                                if (val.imageUrl == "") {
                                    _image = "https://via.placeholder.com/80x80";
                                } else {
                                    _image = "<?= BASE_API_URL."assets/media/"; ?>" + val.imageUrl;
                                }

                                $('#comments-section-'+resId).append(`
                                    <div class="`+_class+`">
                                        <a href="#">
                                            <img src="`+_image+`" alt="" class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall"/>
                                        </a>
                                        <div class="pl-3">
                                            <a href="#">
                                                <p class="font-weight-medium mb-0 ">`+val.name+`</p>
                                                <p class="text-muted mb-0 text-small">`+val.createdAt+`</p>
                                            </a>
                                            <p class="mt-3">`+val.comment+`</p>
                                        </div>
                                    </div>
                                `);

                                $('#comments-count-'+resId).find('span').text(ajaxObj.totalComments);
                                _count = _count + 1;
                            });

                        } else {
                            alert(ajaxObj.Message);
                        }
                    }
                });
            }
        });

        $(document).on('click', '.delete-post', function(){
            var _resourceId = $(this).data('id');
            var _obj = $(this);
            if (confirm('Are you sure to delete this post?')) {
                $.ajax({
                    url: "<?= base_url('Resources/deleteResource/'); ?>" + _resourceId
                })
                .done(function(msg) {
                    console.log(msg);
                    res = $.parseJSON(msg);
                    if (res.Status == "SUCCESS") {
                        _obj.closest('.card').remove();
                    } else {
                        alert(res.Message);
                    }
                });
            }
        });

        $(document).on("change","#centerid",function(){
            let centerid = $(this).val();
            $.ajax({
                url: '<?php echo base_url("Resources/getAuthorsFromCenter"); ?>',
                type: 'POST',
                data: {'centerid': centerid},
            })
            .done(function(msg) {
                res = jQuery.parseJSON(msg);
                if(res.Status == "SUCCESS"){
                    $("#author").empty();
                    $("#author").append('<option value="">Choose an Author</option>');
                    $(res.Authors).each(function(index,obj){
                        $("#author").append('<option value="'+obj.id+'">'+obj.name+'</option>');
                    });
                }else{
                    $("#author").empty();
                    $("#author").append('<option value="">No Authors Available</option>');
                }
            }); 
        });

        $(document).ready(function(){

            function findValueInArray(value,arr){
              var result = false;
             
              for(var i=0; i<arr.length; i++){
                var name = arr[i];
                if(name == value){
                  result = true;
                  break;
                }
              }

              return result;
            }

            //ajax for tags filter
            let tag = [];

            $(document).on("click", ".loadTag", function(){
                count = 1;
                let newTag = $(this).data("tag");
                
                //stop duplicate entries upon clicking on tags
                if (findValueInArray(newTag,tag)) {
                    //left empty for required scene
                }else{
                    tag.push(newTag);
                }

                $.ajax({
                    url: '<?php echo base_url("Resources/loadAjaxResources"); ?>',
                    type: 'POST',
                    data: {"tags": JSON.stringify(tag)},
                })
                .done(function(msg) {
                    console.log(msg);
                    res = JSON.parse(msg);
                    $("#flexResourceListView").empty();
                    if(res.Resources.length > 0){
                        $.each(res.Resources, function(index, val) {

                            /* for delete button */
                            userLogged = '<?php echo $this->session->userdata("LoginId"); ?>';

                            if(val.createdBy == userLogged){
                                deleteItem = `
                                    <div class="position-absolute card-top-buttons">
                                        <button class="btn btn-header-light icon-button delete-post" data-id="`+ val.id +`">
                                            <i class="simple-icon-trash"></i>
                                        </button>
                                    </div>
                                `;
                            }else{
                                deleteItem = ``;
                            }

                            /* for description */
                            resDesc = $("<div></div>").html(val.description).text(); 

                            /* iterate through media array or object */
                            mediaCount = val.media.length;
                            if (mediaCount > 0) {
                                if(mediaCount == 1){
                                    $.each(val.media, function(mediaIndex, mediaVal) {
                                        /* iterate through array or object */
                                        if(mediaVal.mediaType=="Image"){
                                            media = `
                                                <a href="<?= base_url('api/assets/media/'); ?>`+mediaVal.mediaUrl+`" class="lightbox">
                                                    <img class="border-0 border-radius mb-3" height="390px" src="<?= base_url('api/assets/media/'); ?>`+mediaVal.mediaUrl+`"/>
                                                </a>
                                            `;
                                        }else if(mediaVal.mediaType=="Video"){
                                            media = `

                                            <div class="position-relative mb-3">
                                                <video id="my-video-` + val.id + `" class="video-js card-img video-content" controls preload="auto" poster="https://via.placeholder.com/1280x720?text=Click+to+play+video" data-setup="{}">
                                                    <source src="<?= base_url('api/assets/media/'); ?>`+mediaVal.mediaUrl+`" type='video/mp4'>
                                                </video>
                                            </div>
                                            `;
                                        }else{
                                            media = ``;
                                        }
                                    });
                                } else{

                                    let _mcount = 1;

                                    $.each(val.media, function(mediaIndex, mediaVal) {

                                        if (_mcount == 1) {
                                            _active = "active";
                                        }else{
                                            _active = "";
                                        }

                                        /* iterate through array or object */
                                        if(mediaVal.mediaType=="Image"){

                                            _carouselmedia = `
                                                <div class="carousel-item ` + _active + ` text-center">
                                                    <img src="<?= BASE_API_URL."assets/media/"; ?>`+mediaVal.mediaUrl+`" class="border-0 border-radius" height="390px" alt="`+mediaVal.mediaUrl+`">
                                                </div>
                                            `;

                                        }else if(mediaVal.mediaType=="Video"){

                                            _carouselmedia = `
                                            <div class="carousel-item ` + _active + ` text-center">
                                                <video src="<?= BASE_API_URL."assets/media/"; ?>`+mediaVal.mediaUrl+`" class="border-0 border-radius" height="390px" controls></video>
                                            </div>
                                            `;

                                        }else{
                                            media = ``;
                                        }

                                        media = `
                                            <div id="carousel-` + val.id + `" class="carousel slide mb-3" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    ` + _carouselmedia + `
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-target="#carousel-` + val.id +`" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-target="#carousel-` + val.id +`" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </button>
                                            </div>
                                        `;

                                        _mcount = _mcount + 1;
                                    });
                                }
                            }else{
                                media = ``;
                            }
                            /*iteration end*/

                            /* check likes*/
                            if (val.likes.likesCount > 0) {
                                if (val.likes.likesCount == 1) {
                                    _likes = val.likes.likesCount + " Like";
                                } else {
                                    _likes = val.likes.likesCount + " Likes";
                                }
                                
                            }else{
                                _likes = "";
                            }

                            if (val.likes.liked==0) {
                                resLike = `
                                    <div class="post-icon mr-3 d-inline-block like-btn do-like" data-resourceid="`+val.id+`">
                                        <a href="#!">
                                            <i class="far fa-heart mr-1"></i>
                                        </a> 
                                        <span>
                                            `+_likes+`
                                        </span>
                                    </div>
                                `;
                            }else{
                                resLike = `
                                    <div class="post-icon mr-3 d-inline-block like-btn do-unlike" data-resourceid="`+val.id+`">
                                        <a href="#!">
                                            <i class="fas fa-heart mr-1"></i>
                                        </a> 
                                        <span>
                                            `+_likes+`
                                        </span>
                                    </div>
                                `;
                            }
                            /* check likes end*/

                            /*comments section */

                            if (val.comments.lastComment != null) {
                                _comments = `
                                    <div class="d-flex flex-row mb-4">
                                        <a href="#">
                                            <img src="<?= BASE_API_URL."assets/media/"; ?>`+val.comments.userImage+`" alt="`+val.comments.userCommented+`" class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall"/>
                                        </a>
                                        <div class="pl-3">
                                            <a href="#">
                                                <p class="font-weight-medium mb-0">`+val.comments.userCommented+`</p>
                                                <p class="text-muted mb-0 text-small">`+val.comments.timeCmnted+`</p>
                                            </a>
                                            <p class="mt-3">`+val.comments.lastComment+`</p>
                                        </div>
                                    </div>
                                `;
                            }else{
                                _comments = ``;
                            }

                            if(val.comments.totalComments == null){
                                _totalComment = `0 comments`;
                            }else{
                                if(val.comments.totalComments == 1){
                                    _totalComment = val.comments.totalComments + ` Comment`;
                                }else{
                                    _totalComment = val.comments.totalComments + ` Comments`;
                                }
                            }

                            /*comments section end */

                            records = `
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="d-flex flex-row mb-3">
                                            <a href='<?= base_url('resources/viewResource')."?resId="; ?>`+val.id+`'>
                                                <img src="<?= BASE_API_URL.'assets/media/'; ?>`+val.imageUrl+`" alt="`+val.userName+`" class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall" height="40px" width="40px"/>
                                            </a>
                                            <div class="pl-3">
                                                <a href='<?= base_url('resources/viewResource') . "?resId=" ?>`+val.id+`'>
                                                    <p class="font-weight-medium mb-0 "><?= $res->createdBy->name; ?></p>
                                                    <p class="text-muted mb-0 text-small"><?= date('d.m.Y - h:i',strtotime($res->createdAt)); ?></p>
                                                </a>
                                            </div>
                                            ` + deleteItem + `
                                        </div>
                                        `+ resDesc +`
                                        `+ media +`
                                        <div class="post-actions">
                                            `+resLike+`
                                            <div class="post-icon d-inline-block comments-count" id="comments-count-`+ val.id +`">
                                                <i class="simple-icon-bubble mr-1"></i> 
                                                <span>`+ _totalComment +`</span>
                                            </div>
                                        </div>
                                        <div class="mt-5">
                                            <div id="comments-section-`+ val.id +`">
                                                ` + _comments + `
                                            </div>
                                            <div class="comment-contaiener">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Add a comment" id="resource-post-`+val.id+`">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-secondary add-comment" type="button" data-resourceid="`+val.id+`">
                                                            <span class="d-inline-block">Send</span> 
                                                            <i class="simple-icon-arrow-right ml-2"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;

                            count = count + 1;
                            $("#flexResourceListView").append(records);
                        });
                    }else{
                        $("#flexResourceListView").append("<h1>No resources found!</h1>");
                    }
                });
            });

            var date = new Date();
            date.setDate(date.getDate());

            $('.datepickcal').datepicker({
                format: 'dd-mm-yyyy'
            });
        });

        
    </script>
</body>
</html>