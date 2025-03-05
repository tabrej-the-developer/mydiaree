<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Healthy Eating | Mydiaree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
    <style>
        .drop-down{
            border: 1px solid #008ecc!important;
            border-bottom-left-radius: 50px!important;
            border-bottom-right-radius: 50px!important;
            border-top-left-radius: 50px!important;
            border-top-right-radius: 50px!important;
            background-color: transparent!important;
            color: #008ecc!important;
            text-transform: uppercase!important;
            font-weight: bold!important;
            display: block!important;
            line-height: 19.2px!important;
            font-size: 12.8px!important;
            letter-spacing: 0.8px!important;
            vertical-align: middle!important;
            padding: 12px 41.6px 9.6px 41.6px!important;
            height: 42.78px!important;
            text-align: center!important;
            -webkit-transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,-webkit-box-shadow 0.15s ease-in-out;
            transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,-webkit-box-shadow 0.15s ease-in-out;
            transition-property: color, background-color, border-color, box-shadow, -webkit-box-shadow;
            transition-duration: 0.15s, 0.15s, 0.15s, 0.15s, 0.15s;
            transition-timing-function: ease-in-out, ease-in-out, ease-in-out, ease-in-out, ease-in-out;
            transition-delay: 0s, 0s, 0s, 0s, 0s;
            transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out;
            transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out,-webkit-box-shadow 0.15s ease-in-out;
        }
        .drop-down:hover{
            color: #ffffff!important;
            background-color: #008ecc!important;
        }
        .custom-cal{
            position: absolute;
            vertical-align: middle;
            top: 8px;
            right: 10px;
            border: none;
            color: #0085bf;
            background: transparent;
            pointer-events: none;
        }
        .custom-cal:hover{
            color: #ffffff;
            background-color: transparent;
        }
        .input-group-text{
            color: #008ecc!important;
            background-color: transparent!important;
        }
        .btn-lg{
            height: 42.78px!important;
        }
        .form-number{
            border: 1px solid #d7d7d7;
            outline: none;
            height: 35px;
        }
        .btn-item-title{
            padding: 4px 0px 0px 0px!important;
            margin-bottom: 0px!important;
            font-size: 15px!important;
            color: #000000!important;
        }
    </style>
</head>
<body id="app-container" class="menu-default show-spinner">
<?php 
    $this->load->view('sidebar'); 
    $role = $this->session->userdata('UserType');
    $loggedUser = $this->session->userdata('LoginId');
    if ($role == "Superadmin") {
    	$add = 1;
    	$edit = 1;
    	$delete = 1;
    } else {
    	if ($role == "Staff") {
    		if (isset($output->permissions)) {
    			$p = $output->permissions;
    			if ($p->addRoom == 1) {
    				$add = 1;
    			} else {
    				$add = 0;
    			}

    			if ($p->deleteMenu == 1) {
    				$delete = 1;
    			} else {
    				$delete = 0;
    			}

    			if ($p->updateMenu == 1) {
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
<main class="default-transition">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1>Healthy Eating</h1>
                <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                    <ol class="breadcrumb pt-0">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('dashboard'); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Healthy Eating</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Menu</li>
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
                        <?php 
                            if (isset($_GET['date']) && $_GET['date'] != "") {
                                $calDate = date('d-m-Y',strtotime($_GET['date']));
                            } else if(isset($date)){
                                $calDate = date('d-m-Y',strtotime($date));
                            }else{
                                $calDate = date('d-m-Y');
                            }
                        ?>
                        <div class="form-group ml-1">
                            <div class="input-group date">
                                <input type="text" id="txtCalendar" class="form-control drop-down" name="start_date" value="<?= $calDate; ?>">
                                <span class="input-group-text input-group-append input-group-addon custom-cal">
                                    <i class="simple-icon-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <ul class="nav nav-tabs separator-tabs ml-0 mb-5" role="tablist">
                    <li class="nav-item">
                        <a class="<?= ($day=="monday")?'nav-link active':'nav-link'; ?>" id="first-tab" data-toggle="tab" href="#first" role="tab" aria-controls="first" aria-selected="true">MONDAY</a>
                    </li>
                    <li class="nav-item">
                        <a class="<?= ($day=="tuesday")?'nav-link active':'nav-link'; ?>" id="second-tab" data-toggle="tab" href="#second" role="tab" aria-controls="second" aria-selected="false">TUESDAY</a>
                    </li>
                    <li class="nav-item">
                        <a class="<?= ($day=="wednesday")?'nav-link active':'nav-link'; ?>" id="third-tab" data-toggle="tab" href="#third" role="tab" aria-controls="third" aria-selected="false">WEDNESDAY</a>
                    </li>
                    <li class="nav-item">
                        <a class="<?= ($day=="thursday")?'nav-link active':'nav-link'; ?>" id="fourth-tab" data-toggle="tab" href="#fourth" role="tab" aria-controls="fourth" aria-selected="false">THURSDAY</a>
                    </li>
                    <li class="nav-item">
                        <a class="<?= ($day=="friday")?'nav-link active':'nav-link'; ?>" id="fifth-tab" data-toggle="tab" href="#fifth" role="tab" aria-controls="fifth" aria-selected="false">FRIDAY</a>
                    </li>
                </ul>
            </div>
            <div class="col-12">
                <div class="tab-content">
                    <div class="tab-pane <?= ($day=="monday")?'show active':'fade'; ?>" id="first" role="tabpanel" aria-labelledby="first-tab">
                        <div class="container-fluid">
                           
                        
                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <h3>Breakfast</h3>
                                </div>
                                <div class="col-md-3 text-right">
                                    <?php if ($add==1) { ?>
                                    <button type="button" data-toggle="modal" data-date="<?= $monday; ?>" data-day="monday" data-type="breakfast" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row rowListMenu">
                                <?php 
                                    if (!empty($output->Menu[0][0])) {
                                        foreach ($output->Menu[0][0] as $key => $value) { 
                                ?>
                                <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="position-relative">
                                            <?php
                                                if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                                                    $imgurl = "https://via.placeholder.com/307x218?text=No+Image+Available";
                                                } else {
                                                    $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                                                }
                                            ?>
                                            <a href="#">
                                                <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php  if ($loggedUser == $value->addedBy) { ?>
                                                    <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                                                        <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                                                        <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                                                    </div>
                                                    <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                                                    <?php  } else { ?>
                                                    <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>    
                            </div>
                              <hr>



                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <h3>Morning Tea</h3>
                                </div>
                                <div class="col-md-3 text-right">
                                    <?php if ($add==1) { ?>
                                    <button type="button" data-toggle="modal" data-date="<?= $monday; ?>" data-day="monday" data-type="MORNING_TEA" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row rowListMenu">
                                <?php 
                                    if (!empty($output->Menu[0][3])) {
                                        foreach ($output->Menu[0][3] as $key => $value) { 
                                ?>
                                <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="position-relative">
                                            <?php
                                                if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                                                    $imgurl = base_url('api/assets/media/no-image.png');
                                                } else {
                                                    $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                                                }
                                            ?>
                                            <a href="#">
                                                <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php  if ($loggedUser == $value->addedBy) { ?>
                                                    <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                                                        <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                                                        <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                                                    </div>
                                                    <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                                                    <?php  } else { ?>
                                                    <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>    
                            </div>
                          <hr>


                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <h3>Lunch</h3>
                                </div>
                                <div class="col-md-3 text-right">
                                    <?php if ($add==1) { ?>
                                    <button type="button" data-toggle="modal" data-date="<?= $monday; ?>" data-day="monday" data-type="lunch" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row rowListMenu">
                                <?php 
                                    if (!empty($output->Menu[0][1])) {
                                        foreach ($output->Menu[0][1] as $key => $value) { 
                                ?>
                                <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="position-relative">
                                            <?php
                                                if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                                                    $imgurl = "https://via.placeholder.com/307x218?text=No+Image+Available";
                                                } else {
                                                    $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                                                }
                                            ?>
                                            <a href="#">
                                                <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php  if ($loggedUser == $value->addedBy) { ?>
                                                    <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                                                        <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                                                        <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                                                    </div>
                                                    <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                                                    <?php  } else { ?>
                                                    <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>    
                            </div>
                            <hr>

                                  
                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <h3>Afternoon Tea</h3>
                                </div>
                                <div class="col-md-3 text-right">
                                    <?php if ($add==1) { ?>
                                    <button type="button" data-toggle="modal" data-date="<?= $monday; ?>" data-day="monday" data-type="AFTERNOON_TEA" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row rowListMenu">
                                <?php 
                                    if (!empty($output->Menu[0][4])) {
                                        foreach ($output->Menu[0][4] as $key => $value) { 
                                ?>
                                <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="position-relative">
                                            <?php
                                                if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                                                    $imgurl = base_url('api/assets/media/no-image.png');
                                                } else {
                                                    $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                                                }
                                            ?>
                                            <a href="#">
                                                <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php  if ($loggedUser == $value->addedBy) { ?>
                                                    <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                                                        <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                                                        <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                                                    </div>
                                                    <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                                                    <?php  } else { ?>
                                                    <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>    
                            </div>


                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <h3>Snacks</h3>
                                </div>
                                <div class="col-md-3 text-right">
                                    <?php if ($add==1) { ?>
                                    <button type="button" data-toggle="modal" data-date="<?= $monday; ?>" data-day="monday" data-type="snacks" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row rowListMenu">
                                <?php 
                                    if (!empty($output->Menu[0][2])) {
                                        foreach ($output->Menu[0][2] as $key => $value) { 
                                ?>
                                <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="position-relative">
                                            <?php
                                                if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                                                    $imgurl = "https://via.placeholder.com/307x218?text=No+Image+Available";
                                                } else {
                                                    $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                                                }
                                            ?>
                                            <a href="#">
                                                <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php  if ($loggedUser == $value->addedBy) { ?>
                                                    <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                                                        <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                                                        <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                                                    </div>
                                                    <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                                                    <?php  } else { ?>
                                                    <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>    
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane <?= ($day=="tuesday")?'show active':'fade'; ?>" id="second" role="tabpanel" aria-labelledby="second-tab">
                        <div class="container-fluid">
                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <h3>Breakfast</h3>
                                </div>
                                <div class="col-md-3 text-right">
                                    <?php if ($add==1) { ?>
                                    <button type="button" data-toggle="modal" data-date="<?= $tuesday; ?>" data-day="tuesday" data-type="breakfast" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row rowListMenu">
                                <?php 
                                    if (!empty($output->Menu[1][0])) {
                                        foreach ($output->Menu[1][0] as $key => $value) { 
                                ?>
                                <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="position-relative">
                                            <?php
                                                if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                                                    $imgurl = "https://via.placeholder.com/307x218?text=No+Image+Available";
                                                } else {
                                                    $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                                                }
                                            ?>
                                            <a href="#">
                                                <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php  if ($loggedUser == $value->addedBy) { ?>
                                                    <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                                                        <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                                                        <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                                                    </div>
                                                    <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                                                    <?php  } else { ?>
                                                    <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>    
                            </div>


                            <hr>



<div class="row mb-3">
    <div class="col-md-9">
        <h3>Morning Tea</h3>
    </div>
    <div class="col-md-3 text-right">
        <?php if ($add==1) { ?>
        <button type="button" data-toggle="modal" data-date="<?= $tuesday; ?>" data-day="tuesday" data-type="MORNING_TEA" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
        <?php } ?>
    </div>
</div>

<div class="row rowListMenu">
    <?php 
        if (!empty($output->Menu[1][3])) {
            foreach ($output->Menu[1][3] as $key => $value) { 
    ?>
    <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
        <div class="card">
            <div class="position-relative">
                <?php
                    if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                        $imgurl = base_url('api/assets/media/no-image.png');
                    } else {
                        $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                    }
                ?>
                <a href="#">
                    <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <?php  if ($loggedUser == $value->addedBy) { ?>
                        <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                            <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                            <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                        </div>
                        <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                        <?php  } else { ?>
                        <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } } ?>    
</div>
<hr>



                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <h3>Lunch</h3>
                                </div>
                                <div class="col-md-3 text-right">
                                    <?php if ($add==1) { ?>
                                    <button type="button" data-toggle="modal" data-date="<?= $tuesday; ?>" data-day="tuesday" data-type="lunch" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row rowListMenu">
                                <?php 
                                    if (!empty($output->Menu[1][1])) {
                                        foreach ($output->Menu[1][1] as $key => $value) { 
                                ?>
                                <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="position-relative">
                                            <?php
                                                if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                                                    $imgurl = "https://via.placeholder.com/307x218?text=No+Image+Available";
                                                } else {
                                                    $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                                                }
                                            ?>
                                            <a href="#">
                                                <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php  if ($loggedUser == $value->addedBy) { ?>
                                                    <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                                                        <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                                                        <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                                                    </div>
                                                    <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                                                    <?php  } else { ?>
                                                    <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>    
                            </div>


                            <hr>

                                  
<div class="row mb-3">
    <div class="col-md-9">
        <h3>Afternoon Tea</h3>
    </div>
    <div class="col-md-3 text-right">
        <?php if ($add==1) { ?>
        <button type="button" data-toggle="modal" data-date="<?= $tuesday; ?>" data-day="tuesday" data-type="AFTERNOON_TEA" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
        <?php } ?>
    </div>
</div>

<div class="row rowListMenu">
    <?php 
        if (!empty($output->Menu[1][4])) {
            foreach ($output->Menu[1][4] as $key => $value) { 
    ?>
    <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
        <div class="card">
            <div class="position-relative">
                <?php
                    if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                        $imgurl = base_url('api/assets/media/no-image.png');
                    } else {
                        $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                    }
                ?>
                <a href="#">
                    <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <?php  if ($loggedUser == $value->addedBy) { ?>
                        <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                            <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                            <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                        </div>
                        <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                        <?php  } else { ?>
                        <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } } ?>    
</div>


<hr>


                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <h3>Snacks</h3>
                                </div>
                                <div class="col-md-3 text-right">
                                    <?php if ($add==1) { ?>
                                    <button type="button" data-toggle="modal" data-date="<?= $tuesday; ?>" data-day="tuesday" data-type="snacks" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row rowListMenu">
                                <?php 
                                    if (!empty($output->Menu[1][2])) {
                                        foreach ($output->Menu[1][2] as $key => $value) { 
                                ?>
                                <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="position-relative">
                                            <?php
                                                if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                                                    $imgurl = "https://via.placeholder.com/307x218?text=No+Image+Available";
                                                } else {
                                                    $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                                                }
                                            ?>
                                            <a href="#">
                                                <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php  if ($loggedUser == $value->addedBy) { ?>
                                                    <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                                                        <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                                                        <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                                                    </div>
                                                    <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                                                    <?php  } else { ?>
                                                    <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>    
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane <?= ($day=="wednesday")?'show active':'fade'; ?>" id="third" role="tabpanel" aria-labelledby="third-tab">
                        <div class="container-fluid">
                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <h3>Breakfast</h3>
                                </div>
                                <div class="col-md-3 text-right">
                                    <?php if ($add==1) { ?>
                                    <button type="button" data-toggle="modal" data-date="<?= $wednesday; ?>" data-day="wednesday" data-type="breakfast" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row rowListMenu">
                                <?php 
                                    if (!empty($output->Menu[2][0])) {
                                        foreach ($output->Menu[2][0] as $key => $value) { 
                                ?>
                                <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="position-relative">
                                            <?php
                                                if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                                                    $imgurl = "https://via.placeholder.com/307x218?text=No+Image+Available";
                                                } else {
                                                    $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                                                }
                                            ?>
                                            <a href="#">
                                                <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php  if ($loggedUser == $value->addedBy) { ?>
                                                    <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                                                        <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                                                        <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                                                    </div>
                                                    <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                                                    <?php  } else { ?>
                                                    <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>    
                            </div>


                            <hr>



<div class="row mb-3">
    <div class="col-md-9">
        <h3>Morning Tea</h3>
    </div>
    <div class="col-md-3 text-right">
        <?php if ($add==1) { ?>
        <button type="button" data-toggle="modal" data-date="<?= $wednesday; ?>" data-day="wednesday" data-type="MORNING_TEA" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
        <?php } ?>
    </div>
</div>

<div class="row rowListMenu">
    <?php 
        if (!empty($output->Menu[2][3])) {
            foreach ($output->Menu[2][3] as $key => $value) { 
    ?>
    <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
        <div class="card">
            <div class="position-relative">
                <?php
                    if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                        $imgurl = base_url('api/assets/media/no-image.png');
                    } else {
                        $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                    }
                ?>
                <a href="#">
                    <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <?php  if ($loggedUser == $value->addedBy) { ?>
                        <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                            <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                            <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                        </div>
                        <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                        <?php  } else { ?>
                        <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } } ?>    
</div>
<hr>



                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <h3>Lunch</h3>
                                </div>
                                <div class="col-md-3 text-right">
                                    <?php if ($add==1) { ?>
                                    <button type="button" data-toggle="modal" data-date="<?= $wednesday; ?>" data-day="wednesday" data-type="lunch" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row rowListMenu">
                                <?php 
                                    if (!empty($output->Menu[2][1])) {
                                        foreach ($output->Menu[2][1] as $key => $value) { 
                                ?>
                                <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="position-relative">
                                            <?php
                                                if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                                                    $imgurl = "https://via.placeholder.com/307x218?text=No+Image+Available";
                                                } else {
                                                    $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                                                }
                                            ?>
                                            <a href="#">
                                                <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php  if ($loggedUser == $value->addedBy) { ?>
                                                    <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                                                        <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                                                        <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                                                    </div>
                                                    <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                                                    <?php  } else { ?>
                                                    <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>    
                            </div>


                            <hr>

                                  
<div class="row mb-3">
    <div class="col-md-9">
        <h3>Afternoon Tea</h3>
    </div>
    <div class="col-md-3 text-right">
        <?php if ($add==1) { ?>
        <button type="button" data-toggle="modal" data-date="<?= $wednesday; ?>" data-day="wednesday" data-type="AFTERNOON_TEA" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
        <?php } ?>
    </div>
</div>

<div class="row rowListMenu">
    <?php 
        if (!empty($output->Menu[2][4])) {
            foreach ($output->Menu[2][4] as $key => $value) { 
    ?>
    <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
        <div class="card">
            <div class="position-relative">
                <?php
                    if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                        $imgurl = base_url('api/assets/media/no-image.png');
                    } else {
                        $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                    }
                ?>
                <a href="#">
                    <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <?php  if ($loggedUser == $value->addedBy) { ?>
                        <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                            <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                            <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                        </div>
                        <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                        <?php  } else { ?>
                        <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } } ?>    
</div>


<hr>



                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <h3>Snacks</h3>
                                </div>
                                <div class="col-md-3 text-right">
                                    <?php if ($add==1) { ?>
                                    <button type="button" data-toggle="modal" data-date="<?= $wednesday; ?>" data-day="wednesday" data-type="snacks" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row rowListMenu">
                                <?php 
                                    if (!empty($output->Menu[2][2])) {
                                        foreach ($output->Menu[2][2] as $key => $value) { 
                                ?>
                                <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="position-relative">
                                            <?php
                                                if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                                                    $imgurl = "https://via.placeholder.com/307x218?text=No+Image+Available";
                                                } else {
                                                    $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                                                }
                                            ?>
                                            <a href="#">
                                                <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php  if ($loggedUser == $value->addedBy) { ?>
                                                    <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                                                        <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                                                        <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                                                    </div>
                                                    <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                                                    <?php  } else { ?>
                                                    <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>    
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane <?= ($day=="thursday")?'show active':'fade'; ?>" id="fourth" role="tabpanel" aria-labelledby="fourth-tab">
                        <div class="container-fluid">
                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <h3>Breakfast</h3>
                                </div>
                                <div class="col-md-3 text-right">
                                    <?php if ($add==1) { ?>
                                    <button type="button" data-toggle="modal" data-date="<?= $thursday; ?>" data-day="thursday" data-type="breakfast" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row rowListMenu">
                                <?php 
                                    if (!empty($output->Menu[3][0])) {
                                        foreach ($output->Menu[3][0] as $key => $value) { 
                                ?>
                                <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="position-relative">
                                            <?php
                                                if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                                                    $imgurl = "https://via.placeholder.com/307x218?text=No+Image+Available";
                                                } else {
                                                    $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                                                }
                                            ?>
                                            <a href="#">
                                                <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php  if ($loggedUser == $value->addedBy) { ?>
                                                    <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                                                        <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                                                        <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                                                    </div>
                                                    <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                                                    <?php  } else { ?>
                                                    <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>    
                            </div>



                            <hr>



<div class="row mb-3">
    <div class="col-md-9">
        <h3>Morning Tea</h3>
    </div>
    <div class="col-md-3 text-right">
        <?php if ($add==1) { ?>
        <button type="button" data-toggle="modal" data-date="<?= $thursday; ?>" data-day="thursday" data-type="MORNING_TEA" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
        <?php } ?>
    </div>
</div>

<div class="row rowListMenu">
    <?php 
        if (!empty($output->Menu[3][3])) {
            foreach ($output->Menu[3][3] as $key => $value) { 
    ?>
    <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
        <div class="card">
            <div class="position-relative">
                <?php
                    if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                        $imgurl = base_url('api/assets/media/no-image.png');
                    } else {
                        $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                    }
                ?>
                <a href="#">
                    <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <?php  if ($loggedUser == $value->addedBy) { ?>
                        <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                            <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                            <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                        </div>
                        <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                        <?php  } else { ?>
                        <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } } ?>    
</div>
<hr>




                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <h3>Lunch</h3>
                                </div>
                                <div class="col-md-3 text-right">
                                    <?php if ($add==1) { ?>
                                    <button type="button" data-toggle="modal" data-date="<?= $thursday; ?>" data-day="thursday" data-type="lunch" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row rowListMenu">
                                <?php 
                                    if (!empty($output->Menu[3][1])) {
                                        foreach ($output->Menu[3][1] as $key => $value) { 
                                ?>
                                <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="position-relative">
                                            <?php
                                                if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                                                    $imgurl = "https://via.placeholder.com/307x218?text=No+Image+Available";
                                                } else {
                                                    $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                                                }
                                            ?>
                                            <a href="#">
                                                <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php  if ($loggedUser == $value->addedBy) { ?>
                                                    <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                                                        <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                                                        <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                                                    </div>
                                                    <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                                                    <?php  } else { ?>
                                                    <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>    
                            </div>




                            <hr>

                                  
<div class="row mb-3">
    <div class="col-md-9">
        <h3>Afternoon Tea</h3>
    </div>
    <div class="col-md-3 text-right">
        <?php if ($add==1) { ?>
        <button type="button" data-toggle="modal" data-date="<?= $thursday; ?>" data-day="thursday" data-type="AFTERNOON_TEA" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
        <?php } ?>
    </div>
</div>

<div class="row rowListMenu">
    <?php 
        if (!empty($output->Menu[3][4])) {
            foreach ($output->Menu[3][4] as $key => $value) { 
    ?>
    <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
        <div class="card">
            <div class="position-relative">
                <?php
                    if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                        $imgurl = base_url('api/assets/media/no-image.png');
                    } else {
                        $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                    }
                ?>
                <a href="#">
                    <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <?php  if ($loggedUser == $value->addedBy) { ?>
                        <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                            <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                            <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                        </div>
                        <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                        <?php  } else { ?>
                        <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } } ?>    
</div>


<hr>


                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <h3>Snacks</h3>
                                </div>
                                <div class="col-md-3 text-right">
                                    <?php if ($add==1) { ?>
                                    <button type="button" data-toggle="modal" data-date="<?= $thursday; ?>" data-day="thursday" data-type="snacks" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row rowListMenu">
                                <?php 
                                    if (!empty($output->Menu[3][2])) {
                                        foreach ($output->Menu[3][2] as $key => $value) { 
                                ?>
                                <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="position-relative">
                                            <?php
                                                if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                                                    $imgurl = "https://via.placeholder.com/307x218?text=No+Image+Available";
                                                } else {
                                                    $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                                                }
                                            ?>
                                            <a href="#">
                                                <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php  if ($loggedUser == $value->addedBy) { ?>
                                                    <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                                                        <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                                                        <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                                                    </div>
                                                    <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                                                    <?php  } else { ?>
                                                    <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>    
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane <?= ($day=="friday")?'show active':'fade'; ?>" id="fifth" role="tabpanel" aria-labelledby="fifth-tab">
                        <div class="container-fluid">
                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <h3>Breakfast</h3>
                                </div>
                                <div class="col-md-3 text-right">
                                    <?php if ($add==1) { ?>
                                    <button type="button" data-toggle="modal" data-date="<?= $friday; ?>" data-day="friday" data-type="breakfast" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row rowListMenu">
                                <?php 
                                    if (!empty($output->Menu[4][0])) {
                                        foreach ($output->Menu[4][0] as $key => $value) { 
                                ?>
                                <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="position-relative">
                                            <?php
                                                if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                                                    $imgurl = "https://via.placeholder.com/307x218?text=No+Image+Available";
                                                } else {
                                                    $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                                                }
                                            ?>
                                            <a href="#">
                                                <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php  if ($loggedUser == $value->addedBy) { ?>
                                                    <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                                                        <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                                                        <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                                                    </div>
                                                    <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                                                    <?php  } else { ?>
                                                    <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>    
                            </div>


                            <hr>



<div class="row mb-3">
    <div class="col-md-9">
        <h3>Morning Tea</h3>
    </div>
    <div class="col-md-3 text-right">
        <?php if ($add==1) { ?>
        <button type="button" data-toggle="modal" data-date="<?= $friday; ?>" data-day="friday" data-type="MORNING_TEA" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
        <?php } ?>
    </div>
</div>

<div class="row rowListMenu">
    <?php 
        if (!empty($output->Menu[4][3])) {
            foreach ($output->Menu[4][3] as $key => $value) { 
    ?>
    <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
        <div class="card">
            <div class="position-relative">
                <?php
                    if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                        $imgurl = base_url('api/assets/media/no-image.png');
                    } else {
                        $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                    }
                ?>
                <a href="#">
                    <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <?php  if ($loggedUser == $value->addedBy) { ?>
                        <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                            <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                            <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                        </div>
                        <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                        <?php  } else { ?>
                        <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } } ?>    
</div>
<hr>




                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <h3>Lunch</h3>
                                </div>
                                <div class="col-md-3 text-right">
                                    <?php if ($add==1) { ?>
                                    <button type="button" data-toggle="modal" data-date="<?= $friday; ?>" data-day="friday" data-type="lunch" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row rowListMenu">
                                <?php 
                                    if (!empty($output->Menu[4][1])) {
                                        foreach ($output->Menu[4][1] as $key => $value) { 
                                ?>
                                <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="position-relative">
                                            <?php
                                                if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                                                    $imgurl = "https://via.placeholder.com/307x218?text=No+Image+Available";
                                                } else {
                                                    $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                                                }
                                            ?>
                                            <a href="#">
                                                <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php  if ($loggedUser == $value->addedBy) { ?>
                                                    <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                                                        <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                                                        <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                                                    </div>
                                                    <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                                                    <?php  } else { ?>
                                                    <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>    
                            </div>



                            <hr>

                                  
<div class="row mb-3">
    <div class="col-md-9">
        <h3>Afternoon Tea</h3>
    </div>
    <div class="col-md-3 text-right">
        <?php if ($add==1) { ?>
        <button type="button" data-toggle="modal" data-date="<?= $friday; ?>" data-day="friday" data-type="AFTERNOON_TEA" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
        <?php } ?>
    </div>
</div>

<div class="row rowListMenu">
    <?php 
        if (!empty($output->Menu[4][4])) {
            foreach ($output->Menu[4][4] as $key => $value) { 
    ?>
    <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
        <div class="card">
            <div class="position-relative">
                <?php
                    if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                        $imgurl = base_url('api/assets/media/no-image.png');
                    } else {
                        $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                    }
                ?>
                <a href="#">
                    <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <?php  if ($loggedUser == $value->addedBy) { ?>
                        <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                        <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                            <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                            <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                        </div>
                        <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                        <?php  } else { ?>
                        <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } } ?>    
</div>


<hr>



                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <h3>Snacks</h3>
                                </div>
                                <div class="col-md-3 text-right">
                                    <?php if ($add==1) { ?>
                                    <button type="button" data-toggle="modal" data-date="<?= $friday; ?>" data-day="friday" data-type="snacks" data-target="#myModal2" class="btn btn-outline-primary btn-sm add-item-btn">Add Item</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row rowListMenu">
                                <?php 
                                    if (!empty($output->Menu[4][2])) {
                                        foreach ($output->Menu[4][2] as $key => $value) { 
                                ?>
                                <div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="position-relative">
                                            <?php
                                                if (empty($value->recipeDetails->media[0]->mediaUrl)) { 
                                                    $imgurl = "https://via.placeholder.com/307x218?text=No+Image+Available";
                                                } else {
                                                    $imgurl = base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl;
                                                }
                                            ?>
                                            <a href="#">
                                                <img class="card-img-top" src="<?= $imgurl; ?>" alt="Card image cap">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php  if ($loggedUser == $value->addedBy) { ?>
                                                    <button id="btnGroup-7" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $value->recipeDetails->itemName; ?></button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroup-7">
                                                        <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>">View</a>
                                                        <a class="dropdown-item delete-recipe-menu" href="#!" data-recipeid="<?php echo $value->recipeDetails->id; ?>">Delete</a>
                                                    </div>
                                                    <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y', strtotime($value->recipeDetails->createdAt)); ?></p>
                                                    <?php  } else { ?>
                                                    <p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>"><?= $value->recipeDetails->itemName; ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } } ?>    
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- View Recipe Modal -->
<div class="modal right fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="view-recipe-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="view-recipe-modal"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="modal-close" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3>Ingredient</h3>
                <div id="modal-ingredient-list"></div>
                <h3>Methods</h3>
                <div id="modal-recipe-method"></div>
                <h3>Medias</h3>
                <div id="modal-recipe-media">
                    
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-danger" type="reset">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End View Recipe Modal -->

<!-- Add item modal -->
<div class="modal right fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel2">Add Menu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="modal-closer" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo base_url("menu/addToMenu"); ?>" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <?php 

                    $centers = $this->session->userdata("centerIds");

                    if(!empty($_GET)){
                        $centerId = $_GET['centerid'];
                    } else {
                        $centerId = $centers[0]->id;
                    }
                ?>
                <input type="hidden" name="centerid" value="<?php echo $centerId; ?>">
                <input type="hidden" name="mealType" value="" id="mealType">
                <input type="hidden" name="curDate" value="" id="currentDate">
                <div class="form-group">
                    <label for="item-name">Recipes</label>
                </div>
                <div class="form-group" id="rcp-list"></div>
                
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-outline-primary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-primary" type="submit">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end Add Item Modal -->

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
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap-datepicker.js" style="opacity: 1;"></script>
</body>
<script>
	$(document).ready(function(){
		<?php if(isset($_GET['centerid'])){ ?>
			let centerId = "<?= $_GET['centerid']; ?>";
		<?php }else{ ?>
			let centerId = <?= $centerId; ?>;
		<?php } ?>

		$(document).on('click','.add-item-btn',function(){
			var type = $(this).data('type');
			var currentDate = $(this).data('date');
			$("#mealType").val(type);
			$("#currentDate").val(currentDate);
			$("#rcp-list").html('');
			$.ajax({ 
				traditional:true,
				url: "<?php echo base_url('Menu/getRecipesList'); ?>",
				type: "POST",
				data: {
					centerid: centerId, type: type, date: currentDate
				},
				success: function(msg){
					var res = jQuery.parseJSON(msg);
					var	total_recipes = res.Recipes.length;
                    if(total_recipes > 0){
    					for (let i = 0; i < total_recipes; i++) {
    						$("#rcp-list").append('<div class="flexLabel"><input type="checkbox" name="recipe[]" value="'+res.Recipes[i].id+'" id="rcp'+res.Recipes[i].id+'"><label for="rcp'+res.Recipes[i].id+'">&nbsp;&nbsp;'+res.Recipes[i].itemName+'</label></div>');
    					}
                    }else{
                        $("#rcp-list").append('<h3>No recipes found!</h3>');
                    }
				}
			});
		});

		$(document).on('click','.load-recipe',function(){
	    	var rcpId = $(this).data("recipeid");
	    	$.ajax({ 
	    		traditional:true,
			    url: "<?php echo base_url('Recipe/getRecipeDetails'); ?>",
			    type: "GET",
			    beforeSend: function(request) {
			      request.setRequestHeader("x-device-id", "<?php echo $this->session->userdata('x-device-id');?>");
			      request.setRequestHeader("x-token", "<?php echo $this->session->userdata('AuthToken');?>");
			    },
			    data: {"userid":<?php echo $this->session->userdata('LoginId'); ?>,'rcpId':rcpId},
			    success: function(msg){
			    	var res = jQuery.parseJSON(msg);
			        $("#modal-ingredient-list").empty();
			        $("#modal-recipe-method").empty();
			        $("#modal-recipe-media").empty();
			        $('#view-recipe-modal').text(res.Recipes.itemName);
			        var ing = res.Recipes.ingredients;
			        for(i=0;i<ing.length;i++){
			        	$("#modal-ingredient-list").append("<div>"+res.Recipes.ingredients[i].name+"</div>");
			        }
			        $("#modal-recipe-method").append("<div>"+res.Recipes.recipe+"</div>");
			        var media = res.Recipes.media;
			        for(i=0;i<media.length;i++){
			        	if(res.Recipes.media[i].mediaType=="Video") {
			        		$("#modal-recipe-media").append("<div><video style='max-height:191px' src='<?php echo base_url('api/assets/media/');?>"+res.Recipes.media[i].mediaUrl+"' controls></video></div>");
			        	} 
			        	if (res.Recipes.media[i].mediaType=="Image") {
			        		$("#modal-recipe-media").append("<div><img src='<?php echo base_url('api/assets/media/');?>"+res.Recipes.media[i].mediaUrl+"' style='width: 100%;'></div>");
			        	}
			        }
			        $('#modal-recipe-media').slick({
			        	dots: true,
			        	arrows: false
			        });
			    }
			});
	    });
		
		$('#txtCalendar').on('change', function(e) { 
            let _date = $('#txtCalendar').val(); 
            let _url = "<?= base_url('Menu'); ?>?centerid=<?= $centerid; ?>&date="+_date;
            location.href = _url;
        });  

		$(".delete-recipe-menu").on('click', function(){
			let _recipeid = $(this).data('recipeid');
			let _obj = $(this);
			$.ajax({
				url: '<?php echo "Menu/deleteMenuItem/";?>'+_recipeid,
				type: 'GET',
			})
			.done(function(json) {
				_res = $.parseJSON(json);
				if (_res.Status=="SUCCESS") {
					_obj.closest('.mb-4').remove();
				}else{
					alert('Something went wrong!');
				}
			});
		});
	});
</script>
</html>