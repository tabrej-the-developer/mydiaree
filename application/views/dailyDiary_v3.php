<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daily Diary | Mykronicle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0"/>
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0"/>
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0"/>
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0"/>
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0"/>
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2-bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0"/>
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0"/>
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
        .dailyDiaryTable  td {
            text-align: center!important;
        }
        .dailyDiaryTable tr.records > td:first-child {
            text-align: left!important;
            align-items: center;
            font-size: 15px;
            font-weight: 600;
        }

        .theme-link {
            color: #007bff!important;
        }

        .theme-link:hover {
            color: #000000!important;
        }

        .dailyDiaryTable  th {
            text-align: center!important;
        }
        .dailyDiaryTable tr> th:first-child {
            text-align: left!important;
            align-items: center;
        }
        .common-dd-tbl td, .common-dd-tbl th{
            align-items: center!important;
            text-align: center!important;
        }
        .x-small{
            height: 40px!important;
            width: 40px!important;
        }
        td{
            vertical-align: middle!important;
        }
        .table-header {
            position: sticky;
            top:0;
        }

        @media (max-width: 575px) {
        .top-right-button-container {
          flex-wrap: wrap;
          
       }
}

    </style>
</head>
<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <main data-centerid="<?= isset($_GET['centerid'])?$_GET['centerid']:$centerid; ?>">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Daily Diary </h1>
                   
                    <div class="text-zero top-right-button-container d-flex flex-row">
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
                                    <a class="dropdown-item" href="<?= current_url() . '?centerid=' . $center->id; ?>">
                                        <?= strtoupper($center->centerName); ?>
                                    </a>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>

                       

                        <div class="btn-group mr-1 my-2">
                            <?php 
                          
                                if(empty($rooms)){
                            ?>
                            <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> NO ROOMS AVAILABLE </div>
                            <?php   
                                }else{
                                    foreach ($rooms as $room => $rObj) { 
                                        if(isset($_GET['roomid'])){
                                            if($_GET['roomid']==$rObj->id){
                            ?>
                            <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= strtoupper($rObj->name); ?> </div>
                            <?php
                                            }
                                        }else{
                                            if($rObj->id == $roomid){
                            ?>
                            <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= strtoupper($rObj->name); ?> </div>
                            <?php
                                            }
                                        }
                                    }
                            ?>
                            <div class="dropdown-menu dropdown-menu-right">
                                <?php foreach ($rooms as $room => $rObj) { ?>
                                    <a class="dropdown-item" href="<?= current_url().'?centerid='.$centerid.'&roomid='.$rObj->id; ?>">
                                        <?= strtoupper($rObj->name); ?>
                                    </a>
                                <?php } ?>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                        <?php 
                            if (isset($_GET['date']) && $_GET['date'] != "") {
                                $calDate = date('d-m-Y',strtotime($_GET['date']));
                            }else if(isset($date)){
                                $calDate = date('d-m-Y',strtotime($date));
                            } else {
                                $calDate = date('d-m-Y');
                            }
                        ?>
                        <div class="form-group">
                            <div class="input-group date">
                                <input type="text" class="form-control drop-down" id="txtCalendar" name="start_date" value="<?= $calDate; ?>">
                                <span class="input-group-text input-group-append input-group-addon custom-cal">
                                    <i class="simple-icon-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Daily Diary</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-5">
                        <div class="card-body" style="overflow: scroll;">
                            <h5 class="card-title">Add or View Information</h5>
                            <table class="dailyDiaryTable table table-bordered" width="100%">
                                <thead style="position: sticky; top: 60px; background: #FFFFFF; box-shadow: 0px 1px 1px #d7d7d7;">
                                    <tr>
                                        <th class="child-name-cell-title table-header ">
                                            <?php if ($this->session->userdata("UserType")!="Parent") { ?>
                                            <input type="checkbox" id="checkAllStudents"> 
                                            <?php } ?>
                                            <span>Child Name</span>
                                        </th>
                                        <?php if($columns->breakfast==1){ ?>
                                        <th class="table-header"> Breakfast </th>
                                        <?php } ?>
                                        <?php if($columns->morningtea==1){ ?>
                                        <th class="table-header"> Morning Tea </th>
                                        <?php } ?>
                                        <?php if($columns->lunch==1){ ?>
                                        <th class="table-header"> Lunch </th>
                                        <?php } ?>
                                        <?php if($columns->sleep==1){ ?>
                                        <th class="table-header"> Sleep </th>
                                        <?php } ?>
                                        <?php if($columns->afternoontea==1){ ?>
                                        <th class="table-header"> Afternoon Tea </th>
                                        <?php } ?>
                                        <?php if($columns->latesnacks==1){ ?>
                                        <th class="table-header"> Late Snacks </th>
                                        <?php } ?>
                                        <?php if($columns->sunscreen==1){ ?>
                                        <th class="table-header"> SunScreen </th>
                                        <?php } ?>
                                        <?php if($columns->toileting==1){ ?>
                                        <th class="table-header"> Toileting </th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if (empty($childs)) {
                                ?>
                                <tr>
                                    <td colspan="9" class="text-center">No childrens are there in this room</td>
                                </tr>
                                <?php
                                    }else{
                                        foreach ($childs as $child => $cobj) {
                                            if (empty($cobj->imageUrl)) {
                                                $childImage = "https://via.placeholder.com/50";
                                            } else {
                                                $childImage = BASE_API_URL."assets/media/".$cobj->imageUrl;
                                            }                                            
                                    ?>
                                    <?php 
    //                                // Print the object in a readable format
    // echo "<pre>";
    // print_r($cobj); // or use var_dump($cobj);  
    // echo "</pre>";
                                    ?>
                                    <tr class="records">
                                        <td class="kids-cell d-flex flex-row justify-content-start">
                                            <?php if ($this->session->userdata("UserType")!="Parent") { ?>
                                            <input type="checkbox" id="<?= 'child-'.$cobj->id; ?>" class="check-kids" value="<?php echo $cobj->id; ?>" name="kids[]">
                                            <?php } ?>
                                            <label for="<?= 'child-'.$cobj->id; ?>">
                                                <img src="<?= $childImage; ?>" class="img-thumbnail border-0 mx-1 rounded-circle list-thumbnail x-small" alt="">
                                            </label>
                                            <?php
                                                if(isset($_GET['centerid'])){
                                                    $centerid = $_GET['centerid'];
                                                }else{
                                                    $centerid = 1;
                                                }
                                            ?>
                                            <a class="theme-link" href="<?php echo base_url("dailyDiary/viewChildDiary")."?childid=".$cobj->id."&date=".$date."&centerid=".$centerid.'&roomid='.$roomid; ?>"><?php echo $cobj->name; ?></a>
                                        </td>
                                        <?php if($columns->breakfast==1){ ?>
                                        <td>
                                            <?php 
                                                if (empty($cobj->breakfast->startTime)) {
                                            ?>
                                            <button class="btn btn-outline-primary btn-sm btn-add" data-toggle="modal" data-target="#foodModal" data-bgcolor="#FFECB3" data-title="Add Breakfast" data-type="BREAKFAST" data-childid="<?php echo $cobj->id; ?>"> Add </button>
                                            <?php
                                                } else {
                                                    echo $cobj->breakfast->startTime;
                                                }
                                            ?>
                                        </td>
                                        <?php } ?>
                                        <?php if($columns->morningtea==1){ ?>
                                        <td>
                                            <?php 
                                                if (empty($cobj->morningtea->startTime)) {
                                            ?>
                                            <button class="btn btn-outline-primary btn-sm btn-add" data-toggle="modal" data-target="#foodModal" data-bgcolor="#C0CCD9" data-title="Add Morning Tea" data-type="morningtea" data-childid="<?php echo $cobj->id; ?>"> Add </button>
                                            <?php
                                                } else {
                                                    echo $cobj->morningtea->startTime;
                                                }
                                            ?>
                                        </td>
                                        <?php } ?>
                                        <?php if($columns->lunch==1){ ?>
                                        <td>
                                            <?php 
                                                if (empty($cobj->lunch->startTime)) {
                                            ?>
                                            <button class="btn btn-outline-primary btn-sm btn-add" data-toggle="modal" data-target="#foodModal" data-bgcolor="#D0E2FD" data-title="Add Lunch" data-type="lunch" data-childid="<?php echo $cobj->id; ?>"> Add </button>
                                            <?php
                                                } else {
                                                    echo $cobj->lunch->startTime;
                                                }
                                            ?>
                                        </td>
                                        <?php } ?>
                                        <?php if($columns->sleep==1){ ?>
                                        <td>
                                            <?php 
                                                if (empty($cobj->sleep[0]->startTime)) {
                                            ?>
                                            <button class="btn btn-outline-primary btn-sm btn-add btn-sleep" data-toggle="modal" data-target="#sleepModal" data-bgcolor="#F5E18F" data-title="Add Sleep" data-type="sleep" data-childid="<?php echo $cobj->id; ?>"> Add </button>
                                            <?php
                                                } else {
                                                    echo $cobj->sleep[0]->startTime ." to ".$cobj->sleep[0]->endTime;
                                                }
                                            ?>
                                        </td>
                                        <?php } ?>
                                        <?php if($columns->afternoontea==1){ ?>
                                        <td>
                                            <?php 
                                                if (empty($cobj->afternoontea->startTime)) {
                                            ?>
                                            <button class="btn btn-outline-primary btn-sm btn-add" data-toggle="modal" data-target="#foodModal" data-bgcolor="#F0CDFF" data-title="Add Afternoon Tea" data-type="afternoontea" data-childid="<?php echo $cobj->id; ?>"> Add </button>
                                            <?php
                                                } else {
                                                    echo $cobj->afternoontea->startTime;
                                                }
                                            ?>
                                        </td>
                                        <?php } ?>
                                        <?php if($columns->latesnacks==1){ ?>
                                        <td>
                                            <?php 
                                                if (empty($cobj->snacks->startTime)) {
                                            ?>
                                            <button class="btn btn-outline-primary btn-sm btn-add" data-toggle="modal" data-target="#foodModal" data-bgcolor="#FEC093" data-title="Add Snacks" data-type="snacks" data-childid="<?php echo $cobj->id; ?>"> Add </button>
                                            <?php
                                                } else {
                                                    echo $cobj->snacks->startTime;
                                                }
                                            ?>
                                        </td>
                                        <?php } ?>
                                        <?php if($columns->sunscreen==1){ ?>
                                        <td>
                                            <?php 
                                                if (empty($cobj->sunscreen[0]->startTime)) {
                                            ?>
                                            <button class="btn btn-outline-primary btn-sm btnSunscreen" data-toggle="modal" data-target="#sunscreenModal" data-bgcolor="#E07F7F" data-title="Add Sunscreen" data-type="sunscreen" data-childid="<?= $cobj->id; ?>"> Add </button>
                                            <?php
                                                } else {
                                                    $totalMinutes2 = 0;

                                                    // Check if 'toileting' exists and is an array
                                                    if (isset($cobj->sunscreen) && is_array($cobj->sunscreen)) {
                                                        foreach ($cobj->sunscreen as $toiletEntry) {
                                                            // Display the startTime for each entry
                                                            // echo "Start Time: " . htmlspecialchars($toiletEntry->startTime) . "<br>";
                                                
                                                            // Parse the startTime
                                                            if (preg_match('/(\d+)h:(\d+)m/', $toiletEntry->startTime, $matches)) {
                                                                $hours = (int)$matches[1];
                                                                $minutes = (int)$matches[2];
                                                
                                                                // Convert to total minutes
                                                                $totalMinutes2 += ($hours * 60) + $minutes;
                                                            }
                                                        }
                                                    }
                                                
                                                    // Convert total minutes back to hours and minutes
                                                    $totalHours = floor($totalMinutes2 / 60);
                                                    $remainingMinutes = $totalMinutes2 % 60;
                                                
                                                    // Display the total time
                                                    echo  $totalHours . "h:" . str_pad($remainingMinutes, 2, '0', STR_PAD_LEFT) . "m<br>";
                                                }
                                            ?>
                                        </td>
                                        <?php } ?>
                                        <?php if($columns->toileting==1){ ?>
                                        <td>
                                            <?php 
                                                if (empty($cobj->toileting[0]->startTime)) {
                                            ?>
                                            <button class="btn btn-outline-primary btn-sm btnToileting" data-toggle="modal" data-target="#toiletingModal" data-bgcolor="#D1FFCD" data-title="Add Toileting Info" data-type="toileting" data-childid="<?php echo $cobj->id; ?>"> Add </button>
                                            <?php
                                                } else {
                                                    $totalMinutes = 0;

                                                    // Check if 'toileting' exists and is an array
                                                    if (isset($cobj->toileting) && is_array($cobj->toileting)) {
                                                        foreach ($cobj->toileting as $toiletEntry) {
                                                            // Display the startTime for each entry
                                                            // echo "Start Time: " . htmlspecialchars($toiletEntry->startTime) . "<br>";
                                                
                                                            // Parse the startTime
                                                            if (preg_match('/(\d+)h:(\d+)m/', $toiletEntry->startTime, $matches)) {
                                                                $hours = (int)$matches[1];
                                                                $minutes = (int)$matches[2];
                                                
                                                                // Convert to total minutes
                                                                $totalMinutes += ($hours * 60) + $minutes;
                                                            }
                                                        }
                                                    }
                                                
                                                    // Convert total minutes back to hours and minutes
                                                    $totalHours = floor($totalMinutes / 60);
                                                    $remainingMinutes = $totalMinutes % 60;
                                                
                                                    // Display the total time
                                                    echo  $totalHours . "h:" . str_pad($remainingMinutes, 2, '0', STR_PAD_LEFT) . "m<br>";
                                                }
                                            ?>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                    <?php }  }?>
                                </tbody>
                            </table>
                            <table class="common-dd-tbl table table-bordered" width="100%">
                                <thead>
                                    <tr>
                                      <?php if($columns->breakfast==1){ ?>
                                        <th> Breakfast </th>
                                        <?php } ?>
                                        <?php if($columns->morningtea==1){ ?>
                                        <th> Morning Tea </th>
                                        <?php } ?>
                                        <?php if($columns->lunch==1){ ?>
                                        <th> Lunch </th>
                                        <?php } ?>
                                        <?php if($columns->sleep==1){ ?>
                                        <th> Sleep </th>
                                        <?php } ?>
                                        <?php if($columns->afternoontea==1){ ?>
                                        <th> Afternoon Tea </th>
                                        <?php } ?>
                                        <?php if($columns->latesnacks==1){ ?>
                                        <th> Late Snacks </th>
                                        <?php } ?>
                                        <?php if($columns->sunscreen==1){ ?>
                                        <th> SunScreen </th>
                                        <?php } ?>
                                        <?php if($columns->toileting==1){ ?>
                                        <th> Toileting </th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php if($columns->breakfast==1){ ?>
                                        <td>
                                            <button class="btn cmn-btn-add btn-outline-primary" data-toggle="modal" data-target="#foodModal" data-bgcolor="#FFECB3" data-title="Add Breakfast" data-type="BREAKFAST">Add</button>
                                        </td>
                                        <?php } ?>
                                        <?php if($columns->morningtea==1){ ?>
                                        <td>
                                            <button class="btn cmn-btn-add btn-outline-primary" data-toggle="modal" data-target="#foodModal" data-bgcolor="#C0CCD9" data-title="Add Morning Tea" data-type="morningtea">Add</button>
                                        </td>
                                        <?php } ?>
                                        <?php if($columns->lunch==1){ ?>
                                        <td>
                                            <button class="btn cmn-btn-add btn-outline-primary" data-toggle="modal" data-target="#foodModal" data-bgcolor="rgba(19, 109, 246, 0.2)" data-title="Add Lunch" data-type="lunch">Add</button>
                                        </td>
                                        <?php } ?>
                                        <?php if($columns->sleep==1){ ?>
                                        <td>
                                            <button class="btn cmn-btn-add btn-outline-primary" data-toggle="modal" data-target="#sleepModal" data-bgcolor="rgba(239, 206, 74, 0.62)" data-title="Add Sleep" data-type="sleep">Add</button>
                                        </td>
                                        <?php } ?>
                                        <?php if($columns->afternoontea==1){ ?>
                                        <td>
                                            <button class="btn cmn-btn-add btn-outline-primary" data-toggle="modal" data-target="#foodModal" data-bgcolor="#F0CDFF" data-title="Add Afternoon Tea" data-type="afternoontea">Add</button>
                                        </td>
                                        <?php } ?>
                                        <?php if($columns->latesnacks==1){ ?>
                                        <td>
                                            <button class="btn cmn-btn-add btn-outline-primary" data-toggle="modal" data-target="#foodModal" data-bgcolor="#FEC093" data-title="Add Snacks" data-type="snacks">Add</button>
                                        </td>
                                        <?php } ?>
                                        <?php if($columns->sunscreen==1){ ?>
                                        <td>
                                            <button class="btn cmn-btn-add btn-outline-primary" data-toggle="modal" data-target="#sunscreenModal" data-bgcolor="#E07F7F" data-title="Add Sunscreen" data-type="sunscreen">Add</button>
                                        </td>
                                        <?php } ?>
                                        <?php if($columns->toileting==1){ ?>
                                        <td>
                                            <button class="btn cmn-btn-add btn-outline-primary" data-toggle="modal" data-target="#toiletingModal" data-bgcolor="#D1FFCD" data-title="Add Toileting" data-type="toileting">Add</button>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </main>

    <!-- Modal Section -->
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="foodModal" id="foodModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" id="addDailyFoodRecord" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="foodModalLabel">Title</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Time</label>
                        <br>
                        <input type="number" min="0" max="12" value="1" name="hour" class="form-hour form-number"> H : <input type="number" min="0" max="59" value="0" name="mins" class="form-mins form-number"> M
                    </div>
                    <div class="form-group common-item">
                        <label>Item</label>
                        <select name="item" id="item" class="form-control select2-single" data-width="100%">
                        </select>
                    </div>
                    <div class="form-group common-item">
                        <label>Calories</label>
                        <input type="text" name="calories" id="calories" class="form-control modal-form-control">
                    </div>
                    <div class="form-group common-item">
                        <label for="qty">Quantity</label>
                        <input type="text" id="qty" name="qty" class="form-control modal-form-control">
                    </div>
                    <div class="form-group">
                        <label for="comments">Comments</label>
                        <textarea name="comments" class="form-control modal-form-control" id="comments" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info btn-small btn-default btn-small pull-right">SAVE</button>
                </div>
            </form>
        </div>
      </div>
    </div>

    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="sleepModal" id="sleepModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" id="addDailySleepRecord" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="sleepModalLabel">Add Sleep Record</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Time</label>
                        <br>
                        <input type="number" min="0" max="12" value="1" name="hour" class="form-hour from-hour form-number"> H : <input type="number" min="0" max="59" value="00" name="mins" class="form-mins from-mins form-number"> M to
                        <input type="number" min="1" max="12" value="1" name="hour" class="form-hour to-hour form-number"> H : <input type="number" min="0" max="59" value="00" name="mins" class="form-mins to-mins form-number"> M
                    </div>
                    <div class="form-group">
                        <label for="comments">Comments</label>
                        <textarea name="comments" class="form-control modal-form-control sl-comments" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info btn-sm">SAVE</button>
                </div>
            </form>
        </div>
      </div>
    </div>

    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="toiletingModal" id="toiletingModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" id="addDailyToiletingRecord" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="toiletingModalLabel">Add Toileting Info</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Time</label>
                        <br>
                        <input type="number" min="0" max="12" value="1" name="hour" class="form-hour form-hour-toilet form-number"> H : <input type="number" min="0" max="59" value="00" name="mins" class="form-mins form-mins-toilet form-number"> M 
                    </div>
                    <div class="form-group">
                        <label for="nappy">Nappy</label>
                        <input type="text" class="form-control modal-form-control" name="nappy" id="nappy">
                    </div>
                    <div class="form-group">
                        <label for="potty">Potty</label>
                        <input type="text" class="form-control modal-form-control" name="potty" id="potty">
                    </div>
                    <div class="form-group">
                        <label for="toilet">Toilet</label>
                        <input type="text" class="form-control modal-form-control" name="toilet" id="toilet">
                    </div>
                    <div class="form-group">
                        <label for="signature">Signature</label>
                        <input type="text" class="form-control modal-form-control" name="signature" id="signature">
                    </div>
                    <div class="form-group">
                        <label for="comments">Comments</label>
                        <textarea name="comments" class="form-control modal-form-control tt-comments" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info btn-sm">SAVE</button>
                </div>
            </form>
        </div>
      </div>
    </div>

    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="sunscreenModal" id="sunscreenModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" id="addDailySunscreenRecord" method="post">
                <div class="modal-header">
                    <h4 class="modal-title" id="sunscreenModal">Add Sunscreen</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Time</label>
                        <br>
                        <input type="number" min="0" max="12" value="1" name="hour" class="form-hour form-hour-ss form-number"> H : <input type="number" min="0" max="59" value="00" name="mins" class="form-mins form-mins-ss form-number"> M 
                    </div>
                    <div class="form-group">
                        <label for="comments">Comments</label>
                        <textarea name="comments" class="form-control modal-form-control ss-comments" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info btn-sm">SAVE</button>
                </div>
            </form>
        </div>
      </div>
    </div>

    <?php $this->load->view('footer_v3'); ?>

    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/select2.full.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap-datepicker.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>
    <script>
        $(document).ready(function(){
            var type = "";
            //when add button clicked for food 
            $(document).on("click",".btn-add",function(){
                var title = $(this).data("title");
                var bgcolor = "#FFFFFF";
                type = $(this).data("type");
                var childid = $(this).data("childid");
                $("#foodModal").find("input[name='childids[]']").remove();
                $("#foodModal").find("input[name='type']").remove();
                $("#foodModal").find(".modal-body").append('<input type="hidden" class="childid" name="childids[]" value="'+childid+'">');
                $("#foodModal").find(".modal-body").append('<input type="hidden" class="type" name="type" value="'+type+'">');
                $("#foodModal").find('.modal-header').css({"background":bgcolor,"color":"#000000"});
                $("#foodModal").find('.modal-title').text(title);
                if(type!=""){
                    if(type=="morningtea" || type=="afternoontea"){
                        $("#foodModal").find(".common-item").hide();
                    }else{
                        $("#foodModal").find(".common-item").show();
                        $('#item').select2({
                            ajax: { 
                                url: "<?= base_url('dailyDiary/getItems'); ?>/"+type,
                                type: "post",
                                dataType: 'json',
                                delay: 250,
                                data: function (params) {
                                    return {
                                        searchTerm: params.term // search term
                                    };
                                },
                                processResults: function (response) {
                                    return {
                                        results: response
                                    };
                                },
                                cache: true
                            },
                            dropdownParent: $('#foodModal .modal-content')
                        });
                    }
                }
            });

            var typesleep = "";
            // When Click on Sleep Modal button
            $(document).on("click",".btn-sleep",function(){
                var titlesleep = $(this).data("title");
                var bgcolor = $(this).data("bgcolor");
                var bgcolor = "#FFFFFF";
                typesleep = $(this).data("type");
                var childidsleep = $(this).data("childid");
                $("#sleepModal").find("input[name='childids[]']").remove();
                $("#sleepModal").find("input[name='type']").remove();
                $("#sleepModal").find(".modal-body").append('<input type="hidden" class="childid" name="childids" value="'+childidsleep+'">');
                $("#sleepModal").find(".modal-body").append('<input type="hidden" class="type" name="type" value="'+typesleep+'">');
                $("#sleepModal").find('.modal-header').css({"background":bgcolor,"color":"#000000"});
                $("#sleepModal").find('.modal-title').text(title);
            });

            //for submitting food modal
            $(document).on("submit","#addDailyFoodRecord",function(e){
                e.preventDefault();
                var hour = $(".form-hour").val();
                var mins = $(".form-mins").val();
                var startTime = hour+"h:"+mins+"m";
                var childids = [];
                $("input[name='childids[]']").each(function(){
                    childids.push(this.value);
                });
                var item = $("#item").val();
                var qty = $("#qty").val();
                var comments = $("#comments").val();
                var calories = $("#calories").val();
                var today = new Date();
                var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                var createdAt = date+' '+time;
                var diarydate = '<?= isset($_GET['date'])?$_GET['date']:$date; ?>';
                var type = $("#addDailyFoodRecord").find('input[name="type"]').val();
                $.ajax({
                    traditional:true,
                    type: "POST",
                    url: "<?= base_url().'dailyDiary/addFoodRecord'; ?>",
                    data: {'startTime':startTime,'item':item,'qty':qty,'comments':comments,'diarydate':diarydate,'childid':JSON.stringify(childids),'type':type,'calories':calories},
                    success: function(msg){
                        var res = jQuery.parseJSON(msg);
                        if (res.Status == "SUCCESS") {
                            window.location.reload();
                        } else {
                            alert(res.Message);
                        }
                    }
                });
            });

            //for submitting sleep modal
            $(document).on("submit","#addDailySleepRecord",function(e){
                e.preventDefault();
                var hour = $(".from-hour").val();
                var mins = $(".from-mins").val();
                var startTime = hour+"h:"+mins+"m";
                var endhour = $(".to-hour").val();
                var endmins = $(".to-mins").val();
                var endTime = endhour+"h:"+endmins+"m";

                var childids = [];
                $("input[name='childids[]']").each(function(){
                    childids.push(this.value);
                });
                var comments = $(".sl-comments").val();
                var today = new Date();
                var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                var createdAt = date+' '+time;
                var diarydate = '<?= isset($_GET['date'])?$_GET['date']:$date; ?>';
                $.ajax({
                    traditional:true,
                    type: "POST",
                    url: "<?php echo base_url().'dailyDiary/addSleepRecord'; ?>",
                    beforeSend: function(request) {
                      request.setRequestHeader("x-device-id", "<?php echo $this->session->userdata('x-device-id');?>");
                      request.setRequestHeader("x-token", "<?php echo $this->session->userdata('AuthToken');?>");
                    },
                    data: {"userid":<?php echo $this->session->userdata('LoginId');?>,'startTime':startTime,'endTime':endTime,'comments':comments,'diarydate':diarydate,'childid':JSON.stringify(childids)},
                    success: function(msg){
                      var res = jQuery.parseJSON(msg);
                      if (res.Status == "SUCCESS") {
                        window.location.reload();
                      } else {
                        alert(res.Message);
                      }
                    }
                });
            });

            $('.btnToileting').on('click', function(){
                var childid = $(this).data("childid");
                $("#toiletingModal").find("input[name='childids[]']").remove();
                $("#toiletingModal").find(".modal-body").append('<input type="hidden" class="childid" name="childids[]" value="'+childid+'">');
            });

            $('#toiletingModal').on('hidden.bs.modal', function (e) {
              $("#toiletingModal").find("input[name='childids[]']").remove();
            });

            //for submitting toileting modal
            $(document).on("submit","#addDailyToiletingRecord",function(e){
                e.preventDefault();
                var hour = $(".form-hour-toilet").val();
                var mins = $(".form-mins-toilet").val();
                var startTime = hour+"h:"+mins+"m";
                var nappy = $("#nappy").val();
                var potty = $("#potty").val();
                var toilet = $("#toilet").val();
                var signature = $("#signature").val();
                var childids = [];
                $("input[name='childids[]']").each(function(){
                    childids.push(this.value);
                });
                var comments = $(".tt-comments").val();
                var today = new Date();
                var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                var createdAt = date+' '+time;
                var diarydate = '<?= isset($_GET['date'])?$_GET['date']:$date; ?>';
                $.ajax({
                    traditional:true,
                    type: "POST",
                    url: "<?php echo base_url().'dailyDiary/addToiletingRecord'; ?>",
                    data: {"userid":<?php echo $this->session->userdata('LoginId');?>,'startTime':startTime,'nappy':nappy,'comments':comments,'signature':signature,'potty':potty,'toilet':toilet,'diarydate':diarydate,'childid':JSON.stringify(childids)},
                    success: function(msg){
                      var res = jQuery.parseJSON(msg);
                      if (res.Status == "SUCCESS") {
                        window.location.reload();
                      } else {
                        alert(res.Message);
                      }
                    }
                });
            });

            $('.btnSunscreen').on('click', function(){
                var childid = $(this).data("childid");
                $("#sunscreenModal").find("input[name='childids[]']").remove();
                $("#sunscreenModal").find(".modal-body").append('<input type="hidden" class="childid" name="childids[]" value="'+childid+'">');
            });

            $('#sunscreenModal').on('hidden.bs.modal', function (e) {
              $("#sunscreenModal").find("input[name='childids[]']").remove();
            });

            //for submitting sunscreen modal
            $(document).on("submit","#addDailySunscreenRecord",function(e){
                e.preventDefault();
                var hour = $(".form-hour-ss").val();
                var mins = $(".form-mins-ss").val();
                var startTime = hour+"h:"+mins+"m";
                var childids = [];
                $("input[name='childids[]']").each(function(){
                    childids.push(this.value);
                });
                var comments = $(".ss-comments").val();
                var today = new Date();
                var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                var createdAt = date+' '+time;
                var diarydate = '<?= isset($_GET['date'])?$_GET['date']:$date; ?>';
                $.ajax({
                    traditional:true,
                    type: "POST",
                    url: "<?= base_url().'dailyDiary/addSunscreenRecord'; ?>",
                    data: {'startTime':startTime,'comments':comments,'diarydate':diarydate,'childid':JSON.stringify(childids)},
                    success: function(msg){
                      var res = jQuery.parseJSON(msg);
                      if (res.Status == "SUCCESS") {
                        window.location.reload();
                      } else {
                        alert(res.Message);
                      }
                    }
                });
            });

            //select all kids
            $(".common-dd-tbl").css("display","none");

            $(document).on('click','#checkAllStudents',function(){
                if($(this).prop('checked') == true) {
                    $('.check-kids').prop("checked",true);
                    $(".common-dd-tbl").css("display","table");
                } else {
                    $('.check-kids').prop('checked', false);
                    $(".common-dd-tbl").css("display","none");
                }
            });

            $(document).on('click','.check-kids',function() {
                var checkboxes = $('.check-kids:checkbox:checked').length;
                var totalKids = $('.check-kids:checkbox').length;
                if(checkboxes>1) {
                    $(".common-dd-tbl").css("display","table");
                    if(totalKids==checkboxes){
                        $('#checkAllStudents').prop('checked',true);
                    }else{
                        $('#checkAllStudents').prop('checked',false);
                    }
                } else {
                    $(".common-dd-tbl").css("display","none");
                }
            });

            $(document).on('click','.cmn-btn-add',function(){
                var type = $(this).data("type");
                var bgcolor = $(this).data("bgcolor");
                var bgcolor = "#FFFFFF";
                var title = $(this).data("title");



                if(type!=""){
                    if(type=="morningtea" || type=="afternoontea"){
                        $("#foodModal").find(".common-item").hide();
                    }
                }

                $(".modal-header").css({"background":bgcolor,"color":"#000000"});
                $(".modal-title").text(title);

                if(type=="BREAKFAST" || type=="morningtea" || type=="lunch" || type=="afternoontea" || type=="snacks") {
                    var modalName = "#addDailyFoodRecord";
                    var modalId = "#foodModal";
                }else if (type=="sunscreen") {
                    var modalName = "#addDailySunscreenRecord";
                    var modalId = "#sunscreenModal";
                }else if (type=="sleep") {
                    var modalName = "#addDailySleepRecord";
                    var modalId = "#sleepModal";
                }else{
                    var modalName = "#addDailyToiletingRecord";
                    var modalId = "#toiletingModal";
                }

                $(modalId).find("input[name='childids[]']").remove();
                $(modalId).find("input[name='type']").remove();
                $(modalName).find(".modal-body").append('<input type="hidden" class="type" name="type" value="'+type+'">');



                $('input[name="kids[]"]:checked').each(function() {
                   $(modalName).find(".modal-body").append('<input type="hidden" class="childid" name="childids[]" value="'+this.value+'">');
                });

                if(type=="BREAKFAST" || type=="lunch" || type=="snacks"){
                    $("#foodModal").find(".common-item").show();
                    console.log(type);
                    $('#item').select2({
                        ajax: { 
                            url: "<?php echo base_url('dailyDiary/getItems'); ?>/"+type,
                            type: "post",
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    searchTerm: params.term // search term
                                };
                            },
                            processResults: function (response) {
                                return {
                                    results: response
                                };
                            },
                            cache: true
                        },
                        dropdownParent: $(modalId+' .modal-content')
                    });
                }
            });

            $(document).on('change', '#txtCalendar', function(){
                let date = $(this).val();
                let url = "<?= base_url('dailyDiary/list').'?centerid='.$centerid.'&roomid='.$roomid.'&date='; ?>"+date;
                window.location.href = url;
            });
        });


        // $(document).ready(function(){
        //     $('#foodModal,#sleepModal,#sunscreenModal,#toiletingModal').draggable({
        //         handle: ".modal-header"
        //     });
        // });
    </script>
</body>
</html>