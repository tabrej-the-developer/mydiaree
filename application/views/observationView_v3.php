<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Observation | Mydiaree</title>
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
        .tags-section{
            margin: 10px 0px;
        }
        .childSpan> img {
            border-radius: 50%;
        }
        .caption{
            margin-top: 15px;
        }
        .collapse-title{
            display: block;
            border-bottom: 1px solid #d7d7d7;
        }
    </style>
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <?php
        //PHP Block
        $user = $_SESSION['Name'];
    ?>
    <main data-centerid="<?= $centerid; ?>">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>View Observation</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('observation/observationList?centerid=' . $centerid); ?>">Observation List</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">View Observation</li>
                        </ol>
                    </nav>
                    
                    <?php  
                    if ($this->session->userdata('UserType')!='Parent') {                        
                        // if ($observation->status != "Published" || $user == $observation->user_name) { 
                    ?>
                        <div class="text-zero top-right-button-container">
                            <a href="<?= base_url('observation/addNew?type=observation&id='.$id); ?>" class="btn btn-outline-primary btn-lg top-right-button">EDIT</a>

                            <button id="printButton" style="margin-left:5px;" class="btn btn-outline-primary btn-lg">
                            <i class="fa fa-print"></i> Print Observation
                            </button>
                        </div>

       

                    <?php 
                    // }
                 } ?> 

                    <ul class="nav nav-tabs separator-tabs ml-0 mb-5" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab" aria-controls="first" aria-selected="true">INFORMATION</a>
                        </li> 
                        <li class="nav-item">
                            <a class="nav-link" id="second-tab" data-toggle="tab" href="#second" role="tab" aria-controls="second" aria-selected="false">CHILDREN</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="third-tab" data-toggle="tab" href="#third" role="tab" aria-controls="third" aria-selected="false">MONTESSORI</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="fourth-tab" data-toggle="tab" href="#fourth" role="tab" aria-controls="fourth" aria-selected="false">EYLF</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="fifth-tab" data-toggle="tab" href="#fifth" role="tab" aria-controls="fifth" aria-selected="false">DEVELOPMENTAL MILESTONE</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="first" role="tabpanel" aria-labelledby="first-tab">
                        <div style="display: flex; justify-content: flex-end;">
  <button class="btn btn-sm btn-primary" style="margin-bottom:5px;" 
          onclick="openImageModal(<?= $observation->id; ?>)">Edit Image</button>
</div>
<input type="hidden" id="reflectionIds" value="<?= $observation->id ?>">

                            <div class="card">
                                <div class="position-absolute card-top-buttons">
                                    <a class="btn btn-header-light icon-button" href="<?= base_url()."observation/view?id=".$nextObsId; ?>">
                                        <i class="simple-icon-arrow-left"></i>
                                    </a>
                                    <a class="btn btn-header-light icon-button" href="<?= base_url()."observation/view?id=".$prevObsId; ?>">
                                        <i class="simple-icon-arrow-right"></i>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $observation->title; ?></h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Author:</strong>
                                            <p><a href="#"><?php echo $observation->user_name; ?></a> </p>

                                            <?php if($observation->notes) { ?>
                                                <strong>Notes:</strong>
                                                <p><?php echo nl2br($observation->notes); ?></p>
                                            <?php } ?>

                                            <?php if($observation->reflection) { ?>
                                                <strong>Reflection:</strong>
                                                <p><?php echo nl2br($observation->reflection); ?></p>
                                            <?php } ?>

                                            <?php if($observation->child_voice) { ?>
                                                <strong>Child Voice:</strong>
                                                <p><?php echo nl2br($observation->child_voice); ?></p>
                                            <?php } ?>

                                            <?php if($observation->future_plan) { ?>
                                                <strong>Future plan:</strong>
                                                <p><?php echo nl2br($observation->future_plan); ?></p>
                                            <?php } ?>


                                        </div>
                                        <div class="col-md-6">
                                            <div id="carousel-example-generic" class="carousel slide" data-bs-ride="carousel">
                                                <!-- Wrapper for slides -->
                                                <div class="carousel-inner" role="listbox">
                                                    <?php 
                                                        $i = 1;
                                                        foreach($Media as $media) { 
                                                            if($media->mediaType=='Image') {
                                                    ?>
                                                    <div class="carousel-item <?php if($i==1){ echo "active"; } ?>">
                                                        <img class="img-fluid" src="<?php echo base_url('/api/assets/media/'.$media->mediaUrl); ?>">
                                                        <div class="tags-section">
                                                            <div class="child-tags">
                                                                <?php foreach ($media->childs as $key => $ch) { 
                                                                    if (file_exists(base_url('/api/assets/media/'.$ch->imageUrl))) {
                                                                ?>
                                                                    <span class="childSpan">
                                                                        <img src="<?php echo base_url('/api/assets/media/'.$ch->imageUrl); ?>" width="15" height="15">
                                                                        <span style="color: #3E695A;"><?php echo $ch->name; ?></span>
                                                                    </span>
                                                                <?php
                                                                    } else {
                                                                ?>
                                                                <span class="childSpan">
                                                                    <img src="https://via.placeholder.com/50">
                                                                    <span style="color: #3E695A;"><?php echo $ch->name; ?></span>
                                                                </span>
                                                                <?php
                                                                    }
                                                                    
                                                                } ?>
                                                                <?php foreach ($media->educators as $key => $ch) {
                                                                    if (file_exists(base_url('/api/assets/media/'.$ch->imageUrl))) {
                                                                ?>
                                                                <span class="childSpan">
                                                                    <img src="<?php echo base_url('/api/assets/media/'.$ch->imageUrl); ?>" width="15" height="15">
                                                                    <span style="color: #6E519D;"><?php echo $ch->name; ?></span>
                                                                </span>
                                                                <?php
                                                                    } else {
                                                                ?>
                                                                <span class="childSpan">
                                                                        <img src="https://via.placeholder.com/50">
                                                                        <!-- <img src="<?php// echo base_url('assets/images/user-alt-512.webp'); ?>" width="15" height="15"> -->
                                                                        <span style="color: #6E519D;"><?php echo $ch->name; ?></span>
                                                                    </span>
                                                                <?php
                                                                    }
                                                                } ?>
                                                            </div>
                                                            <div class="caption"> <?php echo $media->caption; ?> </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                            } elseif($media->mediaType=='Video') {
                                                    ?>
                                                    <div class="carousel-item <?php if($i==1){ echo "active"; } ?>">
                                                        <video style="width:100%" controls>
                                                            <source src="<?php echo base_url('/api/assets/media/'.$media->mediaUrl); ?>" >
                                                        </video>
                                                        <div class="tags-section">
                                                            <div class="child-tags">
                                                                <?php foreach ($media->childs as $key => $ch) { 
                                                                    if (file_exists(base_url('/api/assets/media/'.$ch->imageUrl))) {
                                                                ?>
                                                                    <span>
                                                                        <img src="<?php echo base_url('/api/assets/media/'.$ch->imageUrl); ?>" width="15" height="15">
                                                                        <span style="color: #3E695A;"><?php echo $ch->name; ?></span>
                                                                    </span>
                                                                <?php
                                                                    } else {
                                                                ?>
                                                                    <span>
                                                                        <img src="<?php echo base_url('assets/images/user-alt-512.webp'); ?>" width="15" height="15">
                                                                        <span style="color: #3E695A;"><?php echo $ch->name; ?></span>
                                                                    </span>
                                                                <?php
                                                                    }
                                                                    
                                                                } ?>
                                                                <?php foreach ($media->educators as $key => $ch) {
                                                                    if (file_exists(base_url('/api/assets/media/'.$ch->imageUrl))) {
                                                                ?>
                                                                    <span>
                                                                        <img src="<?php echo base_url('/api/assets/media/'.$ch->imageUrl); ?>" width="15" height="15">
                                                                        <span style="color: #3E695A;"><?php echo $ch->name; ?></span>
                                                                    </span>
                                                                <?php
                                                                    } else {
                                                                ?>
                                                                    <span>
                                                                        <img src="<?php echo base_url('assets/images/user-alt-512.webp'); ?>" width="15" height="15">
                                                                        <span style="color: #3E695A;"><?php echo $ch->name; ?></span>
                                                                    </span>
                                                                <?php
                                                                    }
                                                                } ?>
                                                            </div>
                                                            <div class="caption">
                                                            <?php echo $media->caption; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                            }
                                                            $i++;
                                                        }
                                                    ?>
                                                </div>

                                                <!-- Controls -->
                                                <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></button>

                                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></button> -->
                                            </div>
                                            <div class="thumbMedia">
                                                <?php 
                                                    $k = 0;
                                                    $countMedia = count($Media);
                                                    if ($countMedia > 1) {
                                                    
                                                        foreach($Media as $media) { 
                                                            if($media->mediaType=='Image') {
                                                ?>
                                                <a href="#!" data-target="#carousel-example-generic" data-slide-to="<?php echo $k; ?>">
                                                    <img src="<?php echo base_url('/api/assets/media/'.$media->mediaUrl); ?>" width="150" height="150">
                                                </a>
                                                <?php
                                                            } elseif($media->mediaType=='Video') {
                                                ?>
                                                <a href="#!" data-target="#carousel-example-generic" data-slide-to="<?php echo $k; ?>">
                                                    <video style="width:150px;width: 150px;">
                                                        <source src="<?php echo base_url('/api/assets/media/'.$media->mediaUrl); ?>" >
                                                    </video>
                                                </a>
                                                <?php
                                                            }
                                                            $k++;
                                                        }
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>All Comments</label>
                                            <div class="commentSection">
                                                <?php 
                                                if(!empty($Comments)) { 
                                                    foreach($Comments as $comment) { 
                                                ?>
                                                <div class="d-flex flex-row mb-3 border-bottom justify-content-between">
                                                    <a href="#">
                                                        <img src="<?= base_url(); ?>api/assets/media/<?= $comment->img; ?>" alt="<?= $comment->userName; ?>" class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall" width="40px" height="40px">
                                                    </a>
                                                    <div class="pl-3 flex-grow-1">
                                                        <a href="#">
                                                            <p class="font-weight-medium mb-0 "><?= $comment->userName; ?></p>
                                                            <p class="text-muted mb-0 text-small"><?= date('d.m.Y h:i',strtotime($comment->date_added)); ?></p>
                                                        </a>
                                                        <p class="mt-3"><?= $comment->comments; ?></p>
                                                    </div>
                                                </div>
                                                <?php } } ?>
                                            </div>
                                        </div>  
                                        <div class="col-md-6">
                                            <form action="" id="form-comment" method="post">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="comment" id="comment" data-sample-short placeholder="write your comment"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" onclick="commentobs();"class="btn btn-primary">Add Comment</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="second" role="tabpanel" aria-labelledby="second-tab">
                            <div class="row">
                            <?php foreach($childrens as $observationChildren) { ?>
                            <div class="col-md-4">
                                <div class="card d-flex flex-row mb-4">
                                    <a class="d-flex" href="#">
                                        <img alt="Profile" src="<?php echo base_url('/api/assets/media/'.$observationChildren->imageUrl); ?>" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center">
                                    </a>
                                    <div class=" d-flex flex-grow-1 min-width-zero">
                                        <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                                            <div class="min-width-zero">
                                                <a href="#">
                                                    <p class="list-item-heading mb-1 truncate"><?php echo $observationChildren->child_name; ?></p>
                                                </a>
                                                <?php 
                                                    $usertype = strtoupper($this->session->userdata('UserType')); 
                                                    if ($usertype == "PARENT" || $usertype == "PARENTS") {
                                                     
                                                    } else {     
                                                ?>
                                                <button type="button" class="btn btn-xs btn-outline-primary ">View</button>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>       
                            <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="third" role="tabpanel" aria-labelledby="third-tab">
                            <div class="row">
                                <div class="col-md-3">
                                    <?php 
                                        if (isset($montessoriSubjects) && !empty($montessoriSubjects)) {
                                            $i = 1;
                                            foreach ($montessoriSubjects as $montessoriSubs => $monSubs) {
                                                if ($i == 1) {
                                                    $actv = 'aria-expanded="true"';
                                                }else{
                                                    $actv = 'aria-expanded="false"';
                                                }
                                                $string = $monSubs->name;
                                                $s = ucfirst($string);
                                                $bar = ucwords(strtolower($s));
                                                $name = preg_replace('/\s+/', '', $bar);
                                    ?>
                                    <a class="btn btn-primary mb-1 btn-block" data-toggle="collapse" href="#<?php echo $name; ?>" role="button"  aria-controls="<?php echo $name; ?>" <?= $actv; ?>><?php echo $monSubs->name; ?></a>
                                    <?php
                                                $i++;
                                            }   
                                        }
                                    ?>
                                </div>
                                <div class="col-md-9">
                                    <?php 
                                        if (isset($montessoriSubjects) && !empty($montessoriSubjects)) {
                                            $i = 1;
                                            $j = 1;
                                            foreach ($montessoriSubjects as $montessoriSubs => $monSubs) {
                                                if ($i == 1) {
                                                    $actv = 'aria-expanded="true"';
                                                    $show = "show";
                                                }else{
                                                    $actv = 'aria-expanded="false"';
                                                    $show = "";
                                                }
                                                $string = $monSubs->name;
                                                $s = ucfirst($string);
                                                $bar = ucwords(strtolower($s));
                                                $name = preg_replace('/\s+/', '', $bar);
                                    ?>
                                    <div class="collapse multi-collapse <?= $show; ?>" id="<?php echo $name; ?>">
                                        <div id="accordion"> 
                                            <div class="card mt-2">
                                                <div class="card-body">          
                                                    <h5 class="card-title"><?= $string; ?></h5>                                 
                                                    <?php
                                                        foreach ($monSubs->Activity as $activity => $actvt) {
                                                            $target = "collapse".$j;
                                                            if ($j==1) {
                                                                $show = "show";
                                                                $true = "true";
                                                            } else {
                                                                $show = "";
                                                                $true = "";
                                                            }
                                                    ?>
                                                    <div class="border">
                                                        <div class="collapse-title">
                                                            <button class="btn btn-link" data-toggle="collapse" data-target="#<?= $target; ?>" aria-expanded="<?= $true; ?>" aria-controls="<?= $target; ?>">
                                                                <?= $actvt->title; ?>
                                                            </button>
                                                        </div>
                                                        <div id="<?= $target; ?>" class="collapse <?= $show; ?>" data-parent="#accordion">
                                                            <div class="p-4">
                                                                <?php 

                                                                if (isset($actvt->subActivity)) {
                                                                    foreach ($actvt->subActivity as $subActvts => $subAct){ 
                                                                ?>
                                                                    <strong><?= $subAct->title; ?></strong>
                                                                    <p><?= $subAct->subject; ?></p>
                                                                <?php } } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                            $j++;
                                                        }
                                                    ?>.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                                $i++;
                                            }   
                                        }
                                    ?> 
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="fourth" role="tabpanel" aria-labelledby="fourth-tab">
                            <div class="row">
                                <div class="col-md-3">
                                    <?php 
                                        if (isset($outcomes) && !empty($outcomes)) {
                                            $i = 1;
                                            foreach ($outcomes as $outcomesArr => $outcomeObj) {
                                                if ($i == 1) {
                                                    $actv = 'aria-expanded="true"';
                                                }else{
                                                    $actv = 'aria-expanded="false"';
                                                }
                                                $string = $outcomeObj->title;
                                                $s = ucfirst($string);
                                                $bar = ucwords(strtolower($s));
                                                $name = preg_replace('/\s+/', '', $bar);
                                    ?>
                                    <a class="btn btn-primary mb-1 btn-block" data-toggle="collapse" href="#<?= $name; ?>" role="button"  aria-controls="<?= $name; ?>" <?= $actv; ?>><?= $outcomeObj->title; ?></a>
                                    <?php
                                                $i++;
                                            }   
                                        }
                                    ?>
                                </div>
                                <div class="col-md-9">
                                    <?php 
                                        if (isset($outcomes) && !empty($outcomes)) {
                                            $i = 1;
                                            
                                            foreach ($outcomes as $outcomesArr => $outcomeObj) {

                                                if ($i == 1) {
                                                    $show = 'show';
                                                }else{
                                                    $show = '';
                                                }

                                                $string = $outcomeObj->title;
                                                $s = ucfirst($string);
                                                $bar = ucwords(strtolower($s));
                                                $name = preg_replace('/\s+/', '', $bar);
                                    ?>
                                    <div class="collapse multi-collapse <?= $show; ?>" id="<?= $name; ?>">
                                        <div id="accordionEYLF">         
                                            <div class="card mb-5">
                                                <div class="card-body">   
                                                    <h5 class="card-title"> <?= $string; ?> </h5>                                
                                                    <?php 
                                                        $j = 1;
                                                        foreach ($outcomeObj->Activity as $activity => $actvt) {
                                                            $target = "collapseEYLF" . $j;
                                                            if ($j==1) {
                                                                $show = "show";
                                                                $true = "true";
                                                            } else {
                                                                $show = "";
                                                                $true = "";
                                                            } 
                                                            $j++;
                                                    ?>
                                                    <div class="border">
                                                        <div class="collapse-title">
                                                            <button class="btn btn-link" data-toggle="collapse" data-target="#<?= $target; ?>" aria-expanded="<?= $true; ?>" aria-controls="<?= $target; ?>" style="text-align: left;"> <?= $actvt->title; ?> </button>
                                                        </div>
                                                        <div id="<?= $target; ?>" class="collapse <?= $show; ?>" data-parent="#accordionEYLF">
                                                            <div class="p-4">
                                                                <?php foreach ($actvt->subActivity as $subActvts => $subAct): ?>
                                                                    <p><?php echo $subAct->title; ?></p>
                                                                <?php endforeach ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php   
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++; } } ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="fifth" role="tabpanel" aria-labelledby="fifth-tab">
                            <div class="row">
                                <div class="col-md-3">
                                    <?php 
                                        if (isset($devMilestone) && !empty($devMilestone)) {
                                            $i = 1;
                                            foreach ($devMilestone as $devMilestoneArr => $devMilestoneObj) {
                                                if ($i == 1) {
                                                    $actv = ' class="active"';
                                                    $expanded = 'true';
                                                }else{
                                                    $actv = "";
                                                    $expanded = 'false';
                                                }
                                                $string = $devMilestoneObj->ageGroup;
                                                $s = ucfirst($string);
                                                $bar = ucwords(strtolower($s));
                                                $name = strtolower(preg_replace('/\s+/', '', $bar));
                                    ?>
                                    <a class="btn btn-primary mb-1 btn-block" data-toggle="collapse" href="#<?= $name; ?>" role="button"  aria-controls="<?= $name; ?>" <?= $actv; ?> aria-expanded="<?= $expanded; ?>"><?= $devMilestoneObj->ageGroup; ?></a>
                                    <?php
                                                $i++;
                                            }   
                                        }
                                    ?>
                                </div>
                                <div class="col-md-9">
                                    <?php 
                                        if (isset($devMilestone) && !empty($devMilestone)) {
                                            $i = 1;
                                            $j = 1;
                                            foreach ($devMilestone as $devMilestoneArr => $devMilestoneObj) {
                                                if ($i == 1) {
                                                    $actv = ' class="active"';
                                                    $show = "show";
                                                }else{
                                                    $actv = "";
                                                    $show = "";
                                                }
                                                $string = $devMilestoneObj->ageGroup;
                                                $s = ucfirst($string);
                                                $bar = ucwords(strtolower($s));
                                                $name = strtolower(preg_replace('/\s+/', '', $bar));
                                    ?>
                                    <div class="collapse multi-collapse <?= $show; ?>" id="<?php echo $name; ?>">
                                        <div id="accordionDM">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h3 class="card-title"><?= $string; ?></h3>
                                                    <?php 
                                                        foreach ($devMilestoneObj->Main as $main => $mainObj) {
                                                            $target = "collapsedm".$j;
                                                            if ($j==1) {
                                                                $show = "show";
                                                                $true = "true";
                                                            } else {
                                                                $show = "";
                                                                $true = "";
                                                            }
                                                            $j++;
                                                    ?>
                                                    <div class="border">
                                                        <div class="collapse-title">
                                                            <button class="btn btn-link" data-toggle="collapse" data-target="#<?= $target; ?>" aria-expanded="<?= $true; ?>" aria-controls="<?= $target; ?>"> <?= $string; ?> </button>
                                                        </div>
                                                        
                                                        <div id="<?= $target; ?>" class="collapse <?= $show; ?>" data-parent="#accordionDM">
                                                            <div class="p-4">
                                                                <?php foreach ($mainObj->Subjects as $subjects => $subject): ?>
                                                                    <div class="text">
                                                                        <strong><?php echo $subject->name; ?></strong>
                                                                        <p><?php echo $subject->subject; ?></p>
                                                                        <ul>
                                                                        <?php 
                                                                            if(isset($subject->extras) && !empty($subject->extras)){
                                                                                foreach ($subject->extras as $extras => $xtra) { 
                                                                        ?>
                                                                            <li><?php echo $xtra->title; ?></li>        
                                                                        <?php 
                                                                                }
                                                                            }else{
                                                                                echo "Not available!";
                                                                            }
                                                                        ?>
                                                                        </ul>
                                                                    </div>
                                                                <?php endforeach ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                                $i++;
                                            }   
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>     
                </div>
            </div>  
        </div>
    </main>

    <!-- Modal -->
    <div class="modal" id="tagsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">View Tag Details</h4>
          </div>
          <div class="modal-body">

          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->

    <!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Edit Images</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height:550px;overflow-y:auto;">
      <div class="form-group">
    <label for="fileUpload" class="btn btn-primary mb-3">Add More Images</label>
    <input type="file" name="media[]" id="fileUpload" class="form-control-hidden" multiple accept="image/*" style="display: none;">
  </div>
    
        <div id="imagesContainer" class="row">
          <!-- Images will be loaded here dynamically -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="rotateModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Rotate Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
      </div>
      <div class="modal-body text-center" style="max-height:500px;overflow-y:auto;">
        <canvas id="imageCanvas" style="max-width: 100%;"></canvas>
        <br>
        <button class="btn btn-primary mt-2" onclick="rotateCurrentImage()">Rotate</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="saveRotatedImage()" id="saveButton">Save</button>
      </div>
    </div>
  </div>
</div>

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
    <!-- <script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script> -->
    <script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>

        $(document).ready(function(){
            $("#carousel-example-generic").carousel();
        });

        $('#tagsModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget);
          var type = button.data('type');
          var tagid = button.data('tagid');
          var modal = $(this);
          $.ajax({
            url: '<?= base_url("Observation/getActTagInfo"); ?>',
            type: 'GET',
            data: {'type': type,'tagid':tagid},
          })
          .done(function(json) {
            res = jQuery.parseJSON(json);
            if(res.Status == "SUCCESS"){

                if (res.Tag.imageUrl == "") {
                    var _imageurl = "https://via.placeholder.com/350x260/FFFF00/000000?text=Image+not+found";
                }else{
                    var _imageurl = "<?= base_url('api/assets/media/'); ?>"+res.Tag.imageUrl;
                }

                if(res.Tag.extras.length > 0){
                    var _extras = `<ul>`;
                    $.each(res.Tag.extras, function(index, val) {
                        _extras += `<li>`+val.title+`</li>`
                    });
                    _extras += `</ul>`;
                }else{
                    var _extras = `<p>No extension available for this Subactivity.</p>`;
                }
                modal.find('.modal-body').append(`
                    <div class="main-block">
                    <div class="main-block-details">
                        <div class="main-img">
                            <img src="`+_imageurl+`" class="img-fluid" alt="">
                        </div>
                        <div class="main-info">
                            <h3>`+res.Tag.title+`</h3>
                            <p>`+res.Tag.subject+`</p>
                        </div>
                    </div>
                    <div class="main-block-extras">
                        <h4>Extras</h4>
                        <div class="extras-block">
                            `
                            +_extras+
                            `
                        </div>
                    </div>  
                </div>
                `);
            }else{
                alert(res.Message);
            }
          });
        });

        var users = <?php echo $getStaffChild; ?>;

// Define feed functions first
function dataFeed(opts, callback) {
    var matchProperty = 'name',
    data = users.filter(function(item) {
        return item[matchProperty].indexOf(opts.query.toLowerCase()) == 0;
    });

    data = data.sort(function(a, b) {
        return a[matchProperty].localeCompare(b[matchProperty], undefined, {
            sensitivity: 'accent'
        });
    });

    callback(data);
}

function tagsFeed(opts, callback) {
    var matchProperty = 'title',
    data = tags.filter(function(item) {
        return item[matchProperty].indexOf(opts.query.toLowerCase()) == 0;
    });

    data = data.sort(function(a, b) {
        return a[matchProperty].localeCompare(b[matchProperty], undefined, {
            sensitivity: 'accent'
        });
    });
    callback(data);
}

// Initialize CKEditor for comments
CKEDITOR.replace('comment', {
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
    }],
    mentions: [{  
        feed: dataFeed,
        itemTemplate: '<li data-id="{id}">' +
            '<strong class="username">{name}</strong>' +
            '</li>',
        outputTemplate: '<a href="#">{name}</a><span>&nbsp;</span>',
        minChars: 0
    }]
});

var id = "<?php echo $id; ?>"; 

function commentobs() {
    if(CKEDITOR.instances.comment.getData() == '') {
        alert('Please Enter Comments');
        return false;
    }
    var url = "<?php echo base_url('observation/comment'); ?>?id=" + id;
    var test = url.replace(/&amp;/g, '&');
    document.getElementById("form-comment").action = test;
    document.getElementById("form-comment").submit();
}

</script>

<script>
$(document).ready(function() {
    $("#printButton").click(function() {
        // Get the current observation ID from the URL
        var urlParams = new URLSearchParams(window.location.search);
        var observationId = urlParams.get('id');
        
        // Open the print page in a new window
        window.open('<?= base_url("observation/print/") ?>' + observationId, '_blank');
    });
});
</script>

<script>
function openImageModal(observationId) {
  // Clear previous images
  $('#imagesContainer').empty();
  
  // Show the modal
  $('#imageModal').modal('show');
  
  // Fetch images using AJAX
  $.ajax({
    url: '<?= base_url('Observation/get_observation_images') ?>',
    type: 'GET',
    data: { observation_id: observationId },
    dataType: 'json',
    success: function(response) {
      if(response.status === 'success') {
        // Display images in the modal
        $.each(response.images, function(index, image) {
          $('#imagesContainer').append(
            '<div class="image-box uploaded" id="image-' + image.id + '" style="position:relative;" data-rotation="0">' +
              '<img class="card-img rotatable" src="<?= base_url('/api/assets/media/') ?>' + image.mediaUrl + '" alt="No media here">' +
              '<button class="btn btn-sm btn-danger delete-image" ' +
                     'data-observationid="' + observationId + '" ' +
                     'data-mediaurl="' + image.mediaUrl + '" ' +
                     'style="position:absolute;top:0;right:0;">X</button>' +
            '</div>'
          );
        });
      } else {
        $('#imagesContainer').html('<div class="col-12"><p>No images found.</p></div>');
      }
    },
    error: function() {
      $('#imagesContainer').html('<div class="col-12"><p>Error loading images. Please try again.</p></div>');
    }
  });
}
</script>

<script type="text/javascript">
  var baseUrl = '<?= base_url() ?>';
</script>

<script>
// Event handler for observation image delete button
$(document).on('click', '.delete-image', function(event) {
    event.preventDefault();

    var observationId = $(this).data('observationid');
    var mediaurl = $(this).data('mediaurl');
  
    function getBaseUrl() {
      if (typeof baseUrl !== 'undefined') {
        return baseUrl;
      } else {
        console.error("Base URL not defined.");
        return "";
      }
    }

    var mediaurl2 = getBaseUrl() + "api/assets/media/" + mediaurl;
    console.log("mediaurl2", mediaurl2);
    console.log("observationId", observationId);
    console.log("mediaurl", mediaurl);

    var button = $(this);

    Swal.fire({
        title: 'Delete Image',
        text: "Would you like to download this image before deleting?",
        icon: 'warning',
        showCancelButton: true,
        showDenyButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        denyButtonColor: '#3085d6',
        confirmButtonText: 'Download & Delete',
        denyButtonText: 'Delete without Download',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Download the image first
            downloadImage(mediaurl2, function() {
                console.log("mediaurl",mediaurl2);
                // After download is initiated, delete the image
                deleteObservationImage(observationId, mediaurl, button);
            });
        } else if (result.isDenied) {
            // Delete without downloading
            deleteObservationImage(observationId, mediaurl, button);
        }
    });
});

function downloadImage(mediaurl2, callback) {
    // Create a temporary anchor element to trigger download
    var downloadLink = document.createElement('a');
    downloadLink.href = mediaurl2;
    downloadLink.download = mediaurl2.split('/').pop();
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
    
    // Add a small delay to ensure download begins before deletion
    setTimeout(function() {
        if (callback) callback();
    }, 1000);
}

// Function to handle the observation image deletion
function deleteObservationImage(observationId, mediaurl, button) {
    // console.log("mediaurl2", mediaurl2);
    console.log("observationId", observationId);
    console.log("mediaurl", mediaurl);
    $.ajax({
        url: "<?= base_url('Observation/deleteMedia') ?>",
        method: "POST",
        data: { observation_id: observationId, mediaurl: mediaurl },
        success: function(response) {
            var res = JSON.parse(response);
            if(res.status === 'success') {
                button.parent().remove();
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Image deleted successfully',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to delete image',
                    icon: 'error'
                });
            }
        },
        error: function() {
            Swal.fire({
                title: 'Error!',
                text: 'Server error occurred',
                icon: 'error'
            });
        }
    });
}
</script>

<script>
let imageFiles = [];
let currentIndex = 0;
let angle = 0;
let img = new Image();

document.getElementById('fileUpload').addEventListener('change', function (e) {
    imageFiles = Array.from(e.target.files);
    currentIndex = 0;
    if (imageFiles.length > 0) {
        openModalWithImage(imageFiles[currentIndex]);
    }
});

function openModalWithImage(file) {
    angle = 0;
    const reader = new FileReader();
    reader.onload = function (event) {
        img = new Image();
        img.onload = () => drawImage();
        img.src = event.target.result;
    };
    reader.readAsDataURL(file);
    $('#rotateModal').modal('show');
}

function rotateCurrentImage() {
    angle = (angle + 90) % 360;
    drawImage();
}

function drawImage() {
    const canvas = document.getElementById('imageCanvas');
    const ctx = canvas.getContext('2d');

    let width = img.width;
    let height = img.height;

    if (angle === 90 || angle === 270) {
        canvas.width = height;
        canvas.height = width;
    } else {
        canvas.width = width;
        canvas.height = height;
    }

    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.save();
    ctx.translate(canvas.width / 2, canvas.height / 2);
    ctx.rotate(angle * Math.PI / 180);
    ctx.drawImage(img, -width / 2, -height / 2);
    ctx.restore();
}

function saveRotatedImage() {
    const canvas = document.getElementById('imageCanvas');
    const saveBtn = document.getElementById('saveButton'); // Assuming button has this ID

    // Disable button and show loading
    saveBtn.disabled = true;
    saveBtn.innerText = 'Saving...';

    canvas.toBlob(function(blob) {
        const formData = new FormData();
        const filename = 'image_' + Date.now() + '.jpg';
        formData.append('image', blob, filename);

        const reflectionId = $('#reflectionIds').val(); // Get from hidden input
        formData.append('reflectionIds', reflectionId);

        fetch("<?= base_url('Observation/receive_rotated_image') ?>", {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(response => {
            console.log(response);
            // Reset button
            saveBtn.disabled = false;
            saveBtn.innerText = 'Save';

            currentIndex++;
            if (currentIndex < imageFiles.length) {
                openModalWithImage(imageFiles[currentIndex]);
            } else {
                $('#rotateModal').modal('hide');
                location.reload(); // All images saved
            }
        })
        .catch(err => {
            console.error(err);
            saveBtn.disabled = false;
            saveBtn.innerText = 'Save';
        });
    }, 'image/jpeg', 0.95);
}

// Reload page when modal is closed by user manually
$('#rotateModal').on('hidden.bs.modal', function () {
    location.reload();
});
</script>


</body>
</html>