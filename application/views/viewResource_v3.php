<?php
// echo "<pre>";
// print_r($users);
// exit();
$data['name']='View Resource'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Resource | Mykronicle</title>
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
    <!-- Slick Slider -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
<style>
    /* .glide__slide.active.glide__slide--active{
        width: 100px !important;
    } */
</style>
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <main data-centerid="<?= isset($centerid)?$centerid:null; ?>">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>View Resource</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?php echo base_url('Resources'); ?>">Resources</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"> | <?php echo $data['name']; ?></li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8 col-xl-8 col-left">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="glide details glide--ltr glide--slider glide--swipeable text-center">
                                <div class="glide__track" data-glide-el="track">
                                    <ul class="glide__slides"
                                        style="transition: transform 400ms cubic-bezier(0.165, 0.84, 0.44, 1) 0s; width: 5364px; transform: translate3d(-2682px, 0px, 0px);">
                                        <?php 
                                            if(isset($Resource->media)){
                                                foreach($Resource->media as $key => $media){
                                                    if($media->mediaType == "Image") {
                                        ?>
                                        <li class="glide__slide" style="width: 884px; margin-right: 5px;">
                                            <img src="<?= BASE_API_URL.'assets/media/'.$media->mediaUrl; ?>" class="responsive border-0 border-radius img-fluid mb-3">
                                        </li>
                                        <?php
                                                }elseif($media->mediaType == "Video"){
                                        ?>
                                        <video width="100%" height="auto" controls>
                                            <source src="<?php echo BASE_API_URL."assets/media/".$media->mediaUrl; ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <?php
                                                }else{
                                        ?>
                                        <div>Not a valid file!</div>
                                        <?php
                                                    }
                                                }
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="glide thumbs glide--ltr glide--slider glide--swipeable" style="width: 350px;">
                                <div class="glide__track" data-glide-el="track">
                                    <ul class="glide__slides"
                                        style="transition: transform 400ms cubic-bezier(0.165, 0.84, 0.44, 1) 0s; width: 432px; transform: translate3d(-72px, 0px, 0px);">
                                        <?php 
                                            if(isset($Resource->media)){
                                                foreach($Resource->media as $key => $media){
                                                    if($media->mediaType == "Image") {
                                        ?>
                                        <li class="glide__slide" style="width: 100px; margin-right: 5px;">
                                            <img src="<?= BASE_API_URL.'assets/media/'.$media->mediaUrl; ?>" class="responsive border-0 border-radius img-fluid">
                                        </li>
                                        <?php
                                                }elseif($media->mediaType == "Video"){
                                        ?>
                                        <video width="100%" height="auto" controls>
                                            <source src="<?php echo BASE_API_URL.'assets/media/'.$media->mediaUrl; ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <?php
                                                }else{
                                        ?>
                                        <div>Not a valid file!</div>
                                        <?php
                                                    }
                                                }
                                            }
                                        ?>
                                    </ul>
                                </div>
                                <div class="glide__arrows" data-glide-el="controls" style="display: block;">
                                    <button class="glide__arrow glide__arrow--left" data-glide-dir="<">
                                        <i class="simple-icon-arrow-left"></i>
                                    </button>
                                    <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
                                        <i class="simple-icon-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-4 col-xl-4 col-right">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="col-sm-12">
                                    <h2 class="resource-block-title">
                                        <?php echo $Resource->title; ?>
                                    </h2>
                                    <div class="resource-info">
                                        <?php 
                                            $date = time();
                                            $post_date = strtotime($Resource->createdAt);
                                            $difference = abs($date - $post_date)/3600;
                                            if ($difference > 24){
                                                echo date("d-m-Y",$post_date)." on ".date("H:ia",$post_date);
                                            }else{
                                                echo number_format($difference,0)." hours ago";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 resource-block-descr">
                                    <?= html_entity_decode(html_entity_decode($Resource->description));?>
                                </div>

                                <div class="col-sm-12 resource-action-btn-group">
                                    <div class="row">
                                        <div class="col text-center">
                                            <?php
                                                if ($Resource->likes->liked==0) {
                                            ?>
                                            <div class="resource-like-block text-center do-like" data-resourceid="<?php echo $Resource->id; ?>">
                                                <i class="simple-icon-heart mr-1"></i>
                                            </div>
                                            <?php 
                                                }else{
                                            ?>
                                            <div class="resource-like-block text-center do-unlike" data-resourceid="<?php echo $Resource->id; ?>" data-likeid="<?php echo $Resource->likes->likeid; ?>">
                                                <i class="simple-icon-heart mr-1"></i>
                                            </div>
                                            <?php
                                                } 
                                            ?>
                                            <p class="likes-count">
                                                <?php 
                                                    if($Resource->likes->likesCount > 1){
                                                        echo $Resource->likes->likesCount." Likes";
                                                    }elseif($Resource->likes->likesCount == 1){
                                                        echo $Resource->likes->likesCount." Like";
                                                    }else{
                                                        echo "No Likes";
                                                    }
                                                ?>
                                            </p>
                                        </div>

                                        <div class="col text-center">
                                            <div class="resource-comment-block">
                                                <i class="simple-icon-bubble mr-1"></i><br>
                                                Comment
                                            </div>
                                        </div>

                                        <div class="col text-center">
                                            <div class="resource-share-block">
                                                <!-- <img src="<?php// echo base_url()."assets/images/icons/share.svg"; ?>" alt="share-btn"> -->
                                                <i class="simple-icon-share"></i><br>
                                                Share
                                            </div>
                                        </div>

                                        <div class="col-12 resource-block-comments">
                                            <?php 
                                                foreach ($Resource->comment->commentsList as $key => $comObj) {
                                            ?>
                                            <div class="comment-row">
                                                <div class="commenter">
                                                    <?php echo $comObj->userName; ?> : 
                                                </div>
                                                <div class="comment">
                                                <?php echo $comObj->userComment; ?>
                                                </div>
                                                <div style="clear:both;"></div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        
                                        <div class="col-sm-12 comment-contaiener">
                                            <form class="comment-form" data-resourceid="<?php echo $Resource->id; ?>" autocomplete="off">
                                                <div class="input-group">
                                                    <input type="text" name="comment" class="form-control add-comment" placeholder="Add a comment">
                                                    <div class="input-group-append add-comment-btn">
                                                        <button class="btn btn-primary post-comment-btn" type="submit">
                                                            <span class="d-inline-block">Send</span>
                                                            <i class="simple-icon-arrow-right ml-2"></i>
                                                        </button>
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
    

    <script>
        $(document).ready(function(){
            

            $(document).on('click','.do-like',function(){
                var elemObj = $(this);
                var resId = $(this).data('resourceid');
                var userid = <?php echo $this->session->userdata("LoginId"); ?>;
                //Perform Ajax
                $.ajax({
                    traditional:true,
                    type: "POST",
                    url: "<?php echo base_url().'resources/addLike'; ?>",
                    beforeSend: function(request) {
                    request.setRequestHeader("x-device-id", "<?php echo $this->session->userdata('x-device-id');?>");
                    request.setRequestHeader("x-token", "<?php echo $this->session->userdata('AuthToken');?>");
                    },
                    data: {"userid":userid,'resourceId':resId},
                    success: function(msg){
                    // console.log(msg);
                        var ajaxObj = jQuery.parseJSON(msg);
                        // console.log(ajaxObj.Message);
                        if (ajaxObj.Message=="Liked") {
                            elemObj.addClass("do-unlike").removeClass("do-like");
                            elemObj.find('.fa-heart-o').addClass('fa-heart').removeClass('fa-heart-o');
                            elemObj.attr("data-likeid", ajaxObj.likeId);
                            location.reload();
                        } else {
                            alert(ajaxObj.Message);
                        }
                    }
                });
            });

            $(document).on('click','.do-unlike',function(){
                var eleObj = $(this);
                var likeid = $(this).data('likeid');
                var userid = <?php echo $this->session->userdata("LoginId"); ?>;
                //Perform Ajax
                $.ajax({
                    traditional:true,
                    type: "POST",
                    url: "<?php echo base_url().'resources/removeLike'; ?>",
                    beforeSend: function(request) {
                    request.setRequestHeader("x-device-id", "<?php echo $this->session->userdata('x-device-id');?>");
                    request.setRequestHeader("x-token", "<?php echo $this->session->userdata('AuthToken');?>");
                    },
                    data: {"userid":userid,'likeId':likeid},
                    success: function(msg){
                        var ajaxObj = jQuery.parseJSON(msg);
                        if (ajaxObj.Message=="Disliked") {
                            eleObj.addClass("do-like").removeClass("do-unlike");
                            eleObj.find('.fa-heart').addClass('fa-heart-o').removeClass('fa-heart');
                            location.reload();
            
                        } else {
                            alert(ajaxObj.Message);
                        }
                    }
                });
            });

            $(document).on('submit',".comment-form",function(e){
                e.preventDefault();
                var eleFormObj = $(this);
                var comment = $(this).find(".add-comment").val();
                var resId = $(this).data("resourceid");
                var userid = <?php echo $this->session->userdata("LoginId"); ?>;
                if (comment=="") {
                    eleFormObj.find("input").attr("placeholder","Please enter your comment.").css("border-bottom", "1px solid #FF0000");
                } else {
                    $.ajax({
                        traditional:true,
                        type: "POST",
                        url: "<?php echo base_url().'resources/addComment'; ?>",
                        beforeSend: function(request) {
                        request.setRequestHeader("x-device-id", "<?php echo $this->session->userdata('x-device-id');?>");
                        request.setRequestHeader("x-token", "<?php echo $this->session->userdata('AuthToken');?>");
                        },
                        data: {"userid":userid,'comment':comment,'resourceId':resId},
                        success: function(msg){
                            var ajaxObj = jQuery.parseJSON(msg);
                            if (ajaxObj.Status=="SUCCESS") {
                                eleFormObj.trigger("reset");
                                window.location.reload();
                            } else {
                                alert(ajaxObj.Message);
                            }
                            // console.log(msg);
                        }
                    });
                }
            });

            $(".resource-medias").slick();

        });
    </script>
</body>
</html>