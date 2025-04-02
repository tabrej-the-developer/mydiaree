<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Child Diary | Mydiaree</title>
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet"
        href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2-bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    .drop-down {
        border: 1px solid #008ecc !important;
        border-bottom-left-radius: 50px !important;
        border-bottom-right-radius: 50px !important;
        border-top-left-radius: 50px !important;
        border-top-right-radius: 50px !important;
        background-color: transparent !important;
        color: #008ecc !important;
        text-transform: uppercase !important;
        font-weight: bold !important;
        display: block !important;
        line-height: 19.2px !important;
        font-size: 12.8px !important;
        letter-spacing: 0.8px !important;
        vertical-align: middle !important;
        padding: 12px 41.6px 9.6px 41.6px !important;
        height: 42.78px !important;
        text-align: center !important;
        -webkit-transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        transition-property: color, background-color, border-color, box-shadow, -webkit-box-shadow;
        transition-duration: 0.15s, 0.15s, 0.15s, 0.15s, 0.15s;
        transition-timing-function: ease-in-out, ease-in-out, ease-in-out, ease-in-out, ease-in-out;
        transition-delay: 0s, 0s, 0s, 0s, 0s;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
    }

    .drop-down:hover {
        color: #ffffff !important;
        background-color: #008ecc !important;
    }

    .custom-cal {
        position: absolute;
        vertical-align: middle;
        top: 8px;
        right: 10px;
        border: none;
        color: #0085bf;
        background: transparent;
        pointer-events: none;
    }

    .custom-cal:hover {
        color: #ffffff;
        background-color: transparent;
    }

    .input-group-text {
        color: #008ecc !important;
        background-color: transparent !important;
    }

    .btn-lg {
        height: 42.78px !important;
    }

    .form-number {
        border: 1px solid #d7d7d7;
        outline: none;
        height: 35px;
    }

    .dailyDiaryTable td {
        text-align: center !important;
    }

    .dailyDiaryTable tr.records>td:first-child {
        text-align: left !important;
        align-items: center;
        font-size: 15px;
        font-weight: 600;
    }

    .theme-link {
        color: #007bff !important;
    }

    .theme-link:hover {
        color: #000000 !important;
    }

    .dailyDiaryTable th {
        text-align: center !important;
    }

    .dailyDiaryTable tr>th:first-child {
        text-align: left !important;
        align-items: center;
    }

    .common-dd-tbl td,
    .common-dd-tbl th {
        align-items: center !important;
        text-align: center !important;
    }

    .x-small {
        height: 40px !important;
        width: 40px !important;
    }

    td {
        vertical-align: middle !important;
    }

    .table-header {
        position: sticky;
        top: 0;
    }

    textarea {
        line-height: 1.6 !important;
    }
    </style>
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <main>
        <?php 
            foreach ($child as $key => $cobj) {
        ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1><?php echo $cobj->name; ?></h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <?php
                                        if($_GET['roomid']){
                                        $roomid = $_GET['roomid'];
                                        }else{
                                            $roomid;
                                        }
                                    ?>
                                <a
                                    href="<?= base_url('dailyDiary').'/list?centerid='.$_GET['centerid'].'&roomid='.$roomid; ?>">Daily
                                    Diary</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $cobj->roomName; ?></li>
                        </ol>
                    </nav>
                    <button class="btn btn-outline-primary" style="float:right;" id="resetButton">Reset</button>
                    <div class="separator mb-5"></div>
                </div>
            </div>
          

            <form
                action="<?php echo base_url("dailyDiary/updateChildDailyDiary?centerid=").$_GET['centerid'].'&roomid='.$roomid; ?>"
                method="post" id="ucdd" enctype="multipart/form-data" autocomplete="off">
                <div class="row">
                    <div class="col-12">

                        <div class="card mb-2">
                            <div class="card-body">
                                <input type="hidden" name="childid" value="<?php echo $_GET['childid']; ?>">
                                <input type="hidden" name="diarydate" value="<?php echo $_GET['date']; ?>">
                                <h3 class="card-title">Breakfast</h3>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Time</label>
                                            <br>

                                            <?php
                                   if (empty($cobj->breakfast->startTime)) {
                                  date_default_timezone_set('Australia/Sydney');

                                         // Get the current hour and minute
                                            $hour = date('G'); // 'G' gives the hour in 24-hour format without leading zeros
                                            $mins = date('i'); // 'i' gives the minutes with leading zeros
                                        } else {
                                     $time = explode(":", $cobj->breakfast->startTime);
                                          $hour = str_replace("h", "", $time[0]);
                                     $mins = str_replace("m", "", $time[1]);
                              }
                                                 ?>

                                            <input type="number" min="0" max="24" value="<?php echo $hour; ?>"
                                                name="bfhour" class="form-hour form-number" id="bfhour"> H :
                                            <input type="number" min="0" max="59" value="<?php echo $mins; ?>"
                                                name="bfmins" id="bfmins" class="form-mins form-number"> M
                                            &nbsp;<i class="fa-solid fa-clock"></i><input type="time" name="bfTime"
                                                id="bfTime" style="margin-left:3px;"
                                                value="<?php echo sprintf('%02d:%02d', $hour, $mins); ?>">
                                        </div>

                                        <div class="form-group">
    <label>Item</label>
    <br>
    <select name="bfitem[]" id="bfitem"
        class="form-control select2-single select2-hidden-accessible modal-form-control"
        data-width="100%" multiple="multiple" tabindex="-1" aria-hidden="true">
        
        <?php 
        // Decode the stored JSON data
        $selectedItems = isset($cobj) && isset($cobj->breakfast) ? json_decode($cobj->breakfast->item, true) : [];

        foreach ($breakfast as $key => $bf) {
            // Check if the item exists in the selected items array
            $selected = (is_array($selectedItems) && in_array($bf->itemName, $selectedItems)) ? 'selected' : '';
        ?>
            <option value="<?php echo htmlspecialchars($bf->itemName); ?>" <?php echo $selected; ?>>
                <?php echo htmlspecialchars($bf->itemName); ?>
            </option>
        <?php } ?>
    </select>
</div>


                                    </div>


                                    <div class="col-4">
                                        <div class="form-group">
                                            <?php
                                                    if(empty($cobj->breakfast->calories)){
                                                        $calories = "";
                                                    } else {
                                                        $calories = $cobj->breakfast->calories;
                                                    }
                                                ?>
                                            <label>Calories</label>
                                            <input type="text" name="bfcalories" id="bfcalories"
                                                class="form-control modal-form-control"
                                                value="<?php echo $calories; ?>">
                                        </div>
                                        <div class="form-group">
                                            <?php
                                                    if(empty($cobj->breakfast->qty)){
                                                        $qty = "";
                                                    } else {
                                                        $qty = $cobj->breakfast->qty;
                                                    }
                                                ?>
                                            <label for="qty">Quantity</label>
                                            <input type="text" id="bfqty" name="bfqty"
                                                class="form-control modal-form-control" value="<?php echo $qty; ?>">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <?php
                                                    if(empty($cobj->breakfast->comments)){
                                                        $comments = "";
                                                    } else {
                                                        $comments = $cobj->breakfast->comments;
                                                    }
                                                ?>
                                            <label for="comments">Comments</label>
                                            <textarea name="bfcomments" class="form-control modal-form-control"
                                                id="bfcomments" rows="5"><?php echo $comments; ?></textarea>
                                            <div class="clear-btn text-right">
                                                <button class="btn-link btn-link-clear btn btn-outline-primary mt-1"
                                                    type="button">Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <div class="card mb-2">
                            <div class="card-body">
                                <h3 class="card-title">Morning Tea</h3>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Time</label>
                                            <br>
                                            <?php

                                                    if(empty($cobj->morningtea->startTime)){
                                                        date_default_timezone_set('Australia/Sydney');

                                                        // Get the current hour and minute
                                                        $hour = date('G'); // 'G' gives the hour in 24-hour format without leading zeros
                                                        $mins = date('i'); // 'i' gives the minutes with leading zeros
                                                    } else {
                                                        $time = explode(":",$cobj->morningtea->startTime);
                                                        $hour = str_replace("h","",$time[0]);
                                                        $mins = str_replace("m","",$time[1]);
                                                    }
                                                    
                                                ?>
                                            <input type="number" min="0" max="24" value="<?php echo $hour; ?>"
                                                name="mthour" id="mthour" class="form-hour form-number"> H :
                                            <input type="number" min="0" max="59" value="<?php echo $mins; ?>"
                                                name="mtmins" id="mtmins" class="form-mins form-number"> M
                                            &nbsp;<i class="fa-solid fa-clock"></i><input type="time" name="mtTime"
                                                id="mtTime" style="margin-left:3px;"
                                                value="<?php echo sprintf('%02d:%02d', $hour, $mins); ?>">
                                        </div>

                                    </div>
                                    <!-- <div class="form-group">
                                                <label>Item</label>
                                                    <br>
                                                <select name="mtitem" id="mtitem" class="form-control select2-single select2-hidden-accessible modal-form-control" data-width="100%" tabindex="-1" aria-hidden="true">
                                                    <?php 

                                                        // if (empty($cobj->morningtea->item)) {
                                                        //     foreach ($tea as $key => $teaObj) {
                                                    ?>
                                                    <option value="<?php# echo $teaObj->itemName; ?>"><?php# echo $teaObj->itemName; ?></option>
                                                    <?php
                                                        //     }
                                                        // } else {
                                                        //     foreach ($tea as $key => $teaObj) {
                                                        //         if ($teaObj->itemName == $cobj->morningtea->item) {
                                                    ?>
                                                    <option value="<?php# echo $teaObj->itemName; ?>" selected><?php# echo $teaObj->itemName; ?></option>
                                                    <?php
                                                                // } else {
                                                    ?>
                                                    <option value="<?php# echo $teaObj->itemName; ?>"><?php# echo $teaObj->itemName; ?></option>
                                                    <?php #} } } ?>
                                                </select>
                                            </div> -->

                                    <div class="col-4">
                                        <div class="form-group">
                                            <?php
                                                    if(empty($cobj->morningtea->calories)){
                                                        $calories = "";
                                                    } else {
                                                        $calories = $cobj->morningtea->calories;
                                                    }
                                                ?>
                                            <label>Calories</label>
                                            <input type="text" name="mtcalories" id="mtcalories"
                                                class="form-control modal-form-control"
                                                value="<?php echo $calories; ?>">
                                        </div>
                                        <!-- <div class="form-group">
                                                <?php
                                                    // if(empty($cobj->morningtea->qty)){
                                                    //     $qty = "";
                                                    // } else {
                                                    //     $qty = $cobj->morningtea->qty;
                                                    // }
                                                ?>
                                                <label for="qty">Quantity</label>
                                                <input type="text" id="mtqty" name="mtqty" class="form-control modal-form-control" value="<?php# echo $qty; ?>">
                                            </div> -->
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <?php
                                                    if(empty($cobj->morningtea->comments)){
                                                        $comments = "";
                                                    } else {
                                                        $comments = $cobj->morningtea->comments;
                                                    }
                                                ?>
                                            <label for="comments">Comments</label>
                                            <textarea name="mtcomments" class="form-control modal-form-control"
                                                id="mtcomments" rows="1"><?php echo $comments; ?></textarea>
                                            <div class="clear-btn text-right">
                                                <button class="btn-link btn-link-clear btn btn-outline-primary mt-1"
                                                    type="button">Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-2">
                            <div class="card-body">
                                <h3 class="card-title">Lunch</h3>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Time</label>
                                            <br>
                                            <?php
                                                    if(empty($cobj->lunch->startTime)){
                                                        date_default_timezone_set('Australia/Sydney');

                                                        // Get the current hour and minute
                                                        $hour = date('G'); // 'G' gives the hour in 24-hour format without leading zeros
                                                        $mins = date('i'); // 'i' gives the minutes with leading zeros
                                                    } else {
                                                        $time = explode(":",$cobj->lunch->startTime);
                                                        $hour = str_replace("h","",$time[0]);
                                                        $mins = str_replace("m","",$time[1]);
                                                    }
                                                ?>
                                            <input type="number" min="0" max="24" value="<?php echo $hour; ?>"
                                                name="lnhour" id="lnhour" class="form-hour form-number"> H :
                                            <input type="number" min="0" max="59" value="<?php echo $mins; ?>"
                                                name="lnmins" id="lnmins" class="form-mins form-number"> M
                                            &nbsp;<i class="fa-solid fa-clock"></i>&nbsp;<input type="time"
                                                name="lnTime" id="lnTime"
                                                value="<?php echo sprintf('%02d:%02d', $hour, $mins); ?>">
                                        </div>
                                        
                                        <div class="form-group">
    <label>Item</label>
    <br>
    <select name="lnitem[]" id="lnitem"
        class="form-control select2-single select2-hidden-accessible modal-form-control"
        data-width="100%" multiple="multiple" tabindex="-1" aria-hidden="true">

        <?php 
        // Decode the stored JSON data for lunch items
        $selectedLunchItems = isset($cobj->lunch->item) ? json_decode($cobj->lunch->item, true) : [];

        foreach ($lunch as $key => $lunchObj) {
            // Check if the item exists in the selected items array
            $selected = (is_array($selectedLunchItems) && in_array($lunchObj->itemName, $selectedLunchItems)) ? 'selected' : '';
        ?>
            <option value="<?php echo htmlspecialchars($lunchObj->itemName); ?>" <?php echo $selected; ?>>
                <?php echo htmlspecialchars($lunchObj->itemName); ?>
            </option>
        <?php } ?>
    </select>
</div>



                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <?php
                                                    if(empty($cobj->lunch->calories)){
                                                        $calories = "";
                                                    } else {
                                                        $calories = $cobj->lunch->calories;
                                                    }
                                                ?>
                                            <label>Calories</label>
                                            <input type="text" name="lncalories" id="lncalories"
                                                class="form-control modal-form-control"
                                                value="<?php echo $calories; ?>">
                                        </div>
                                        <div class="form-group">
                                            <?php
                                                    if(empty($cobj->lunch->qty)){
                                                        $qty = "";
                                                    } else {
                                                        $qty = $cobj->lunch->qty;
                                                    }
                                                ?>
                                            <label for="qty">Quantity</label>
                                            <input type="text" id="lnqty" name="lnqty"
                                                class="form-control modal-form-control" value="<?php echo $qty; ?>">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <?php
                                                    if(empty($cobj->lunch->comments)){
                                                        $comments = "";
                                                    } else {
                                                        $comments = $cobj->lunch->comments;
                                                    }
                                                ?>
                                            <label for="comments">Comments</label>
                                            <textarea name="lncomments" class="form-control modal-form-control"
                                                id="lncomments" rows="5"><?php echo $comments; ?></textarea>
                                            <div class="clear-btn text-right">
                                                <button class="btn-link btn-link-clear btn btn-outline-primary mt-1"
                                                    type="button">Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-2">
                            <div class="card-body">
                                <h3 class="card-title">Sleep</h3>
                                <div class="sleep-block-row">
                                    <?php 
                                        if (!empty($cobj->sleep)) {
                                            $i=1;
                                            foreach ($cobj->sleep as $sleepObj => $slp){
                                        ?>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <?php
                                                            if(empty($slp->startTime)){
                                                                $shour = 22;
                                                                $smins = 00;
                                                            } else {
                                                                $stime = explode(":",$slp->startTime);
                                                                $shour = str_replace("h","",$stime[0]);
                                                                $smins = str_replace("m","",$stime[1]);
                                                            }

                                                            if(empty($slp->endTime)){
                                                                $ehour = 07;
                                                                $emins = 00;
                                                            } else {
                                                                $etime = explode(":",$slp->endTime);
                                                                $ehour = str_replace("h","",$etime[0]);
                                                                $emins = str_replace("m","",$etime[1]);
                                                            }

                                                        ?>
                                                <label>Time</label>
                                                <br>
                                                <input type="number" min="0" max="24" name="slshour[]" id="slshour"
                                                    class="form-hour from-hour form-number"
                                                    value="<?php echo $shour; ?>"> H : <input type="number" min="0"
                                                    max="59" name="slsmins[]" id="slsmins"
                                                    class="form-mins from-mins form-number"
                                                    value="<?php echo $smins; ?>"> M to
                                                <input type="number" min="0" max="24" name="slehour[]" id="slehour"
                                                    class="form-hour to-hour form-number" value="<?php echo $ehour; ?>">
                                                H : <input type="number" min="0" max="59" name="slemins[]" id="slemins"
                                                    class="form-mins to-mins form-number" value="<?php echo $emins; ?>">
                                                M
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="form-group">
                                                <?php
                                                            if(empty($slp->comments)){
                                                                $comments = "";
                                                            } else {
                                                                $comments = $slp->comments;
                                                            }
                                                        ?>
                                                <label for="slcomments">Comments</label>
                                                <input name="slcomments[]" class="form-control modal-form-control"
                                                    id="slcomments" value="<?php echo $comments; ?>">
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="form-group">
                                                <?php if ($i==1) { ?>
                                                <button type="button"
                                                    class="btn w-100 btn-info btn-sm pull-right btn-default btn-small btnBlue add-sleep-row"
                                                    style="margin-top: 25px;">Add</button>
                                                <?php } else { ?>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm pull-right btn-default btn-small btnRed remove-sleep-row">Remove</button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } } else{ ?>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <?php 
                                                         $shour = 22;
                                                         $smins = 00;
                                                         $ehour = 07;
                                                         $emins = 00;
                                                        ?>
                                                <label>Time</label>
                                                <br>
                                                <input type="number" min="0" max="24" name="slshour[]" id="slshour"
                                                    class="form-hour from-hour form-number"
                                                    value="<?php echo $shour; ?>"> H : <input type="number" min="0"
                                                    max="59" name="slsmins[]" id="slsmins"
                                                    class="form-mins from-mins form-number"
                                                    value="<?php echo $smins; ?>"> M to
                                                <input type="number" min="0" max="24" name="slehour[]" id="slehour"
                                                    class="form-hour to-hour form-number" value="<?php echo $ehour; ?>">
                                                H : <input type="number" min="0" max="59" name="slemins[]" id="slemins"
                                                    class="form-mins to-mins form-number" value="<?php echo $emins; ?>">
                                                M
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                            <div class="form-group">
                                                <label for="slcomments">Comments</label>
                                                <input name="slcomments[]" class="form-control modal-form-control"
                                                    id="slcomments">
                                            </div>

                                        </div>
                                        <!-- <div class="col-md-1 col-sm-12">
                                                    <div class="form-group">
                                                        <button class="btn btn-outline-danger remove-sunscreen-row" style="margin-top: 25px;">Remove</button>
                                                    </div>
                                                </div> -->
                                    </div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-2">
                            <div class="card-body">
                                <h3 class="card-title">Afternoon Tea</h3>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <?php
                                                if(empty($cobj->afternoontea->startTime)){
                                                    date_default_timezone_set('Australia/Sydney');

                                                    // Get the current hour and minute
                                                    $hour = date('G'); // 'G' gives the hour in 24-hour format without leading zeros
                                                    $mins = date('i'); // 'i' gives the minutes with leading zeros
                                                } else {
                                                    $time = explode(":",$cobj->afternoontea->startTime);
                                                    $hour = str_replace("h","",$time[0]);
                                                    $mins = str_replace("m","",$time[1]);
                                                }

                                                ?>
                                            <label>Time</label>
                                            <br>
                                            <input type="number" min="0" max="24" name="athour" id="athour"
                                                class="form-hour form-number" value="<?php echo $hour; ?>"> H :
                                            <input type="number" min="0" max="59" id="atmins" name="atmins"
                                                class="form-mins form-number" value="<?php echo $mins; ?>"> M
                                            &nbsp;<i class="fa-solid fa-clock"></i><input type="time" name="atTime"
                                                id="atTime" style="margin-left:3px;"
                                                value="<?php echo sprintf('%02d:%02d', $hour, $mins); ?>">
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                                <label>Item</label>
                                                <br>
                                                <select name="atitem" id="atitem" class="form-control select2-single select2-hidden-accessible modal-form-control" data-width="100%" tabindex="-1" aria-hidden="true">
                                                    <?php 
                                                    // if (empty($cobj->afternoontea->item)) {
                                                    //     foreach ($tea as $key => $atObj) {
                                                    ?>
                                                        <option value="<?php# echo $atObj->itemName; ?>"><?php# echo $atObj->itemName; ?></option>
                                                    <?php
                                                    //     }
                                                    // } else {
                                                    //     foreach ($tea as $key => $atObj) {
                                                    //         if ($atObj->itemName == $cobj->afternoontea->item) {
                                                    ?>
                                                    <option value="<?php# echo $atObj->itemName; ?>" selected><?php# echo $atObj->itemName; ?></option>
                                                    <?php
                                                            // } else {
                                                    ?>
                                                    <option value="<?php# echo $atObj->itemName; ?>"><?php# echo $atObj->itemName; ?></option>
                                                    <?php #} } }?>
                                                </select>
                                            </div> -->

                                    <div class="col-4">
                                        <div class="form-group">
                                            <?php
                                                    if(empty($cobj->afternoontea->calories)){
                                                        $calories = "";
                                                    } else {
                                                        $calories = $cobj->afternoontea->calories;
                                                    }
                                                ?>
                                            <label>Calories</label>
                                            <input type="text" name="atcalories" id="atcalories"
                                                class="form-control modal-form-control"
                                                value="<?php echo $calories; ?>">
                                        </div>
                                        <!-- <div class="form-group">
                                                <?php
                                                    // if(empty($cobj->afternoontea->qty)){
                                                    //     $qty = "";
                                                    // } else {
                                                    //     $qty = $cobj->afternoontea->qty;
                                                    // }
                                                ?>
                                                <label for="qty">Quantity</label>
                                                <input type="text" id="atqty" name="atqty" class="form-control modal-form-control" value="<?php# echo $qty; ?>">
                                            </div> -->
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <?php
                                                    if(empty($cobj->afternoontea->comments)){
                                                        $comments = "";
                                                    } else {
                                                        $comments = $cobj->afternoontea->comments;
                                                    }
                                                ?>
                                            <label for="atcomments">Comments</label>
                                            <textarea name="atcomments" class="form-control modal-form-control"
                                                id="atcomments" rows="1"><?php echo $comments; ?></textarea>
                                            <div class="clear-btn text-right">
                                                <button class="btn-link btn-link-clear btn btn-outline-primary mt-1"
                                                    type="button">Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-2">
                            <div class="card-body">
                                <h3 class="card-title">Late Snacks</h3>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <?php
                                                if(empty($cobj->snack->startTime)){
                                                    date_default_timezone_set('Australia/Sydney');

                                                    // Get the current hour and minute
                                                    $hour = date('G'); // 'G' gives the hour in 24-hour format without leading zeros
                                                    $mins = date('i'); // 'i' gives the minutes with leading zeros
                                                } else {
                                                    $time = explode(":",$cobj->snack->startTime);
                                                    $hour = str_replace("h","",$time[0]);
                                                    $mins = str_replace("m","",$time[1]);
                                                }

                                                ?>
                                            <label>Time</label>
                                            <br>
                                            <input type="number" min="0" max="24" name="lshour" id="lshour"
                                                class="form-hour form-number" value="<?php echo $hour; ?>"> H :
                                            <input type="number" min="0" max="59" name="lsmins" id="lsmins"
                                                class="form-mins form-number" value="<?php echo $mins; ?>"> M
                                            &nbsp;<i class="fa-solid fa-clock"></i><input type="time" name="lsTime"
                                                id="lsTime" style="margin-left:3px;"
                                                value="<?php echo sprintf('%02d:%02d', $hour, $mins); ?>">

                                        </div>

                                        <div class="form-group">
    <label>Item</label>
    <br>
    <select name="lsitem[]" id="lsitem"
        class="form-control select2-single select2-hidden-accessible modal-form-control"
        data-width="100%" multiple="multiple" tabindex="-1" aria-hidden="true">

        <?php 
        // Decode the stored JSON data for snack items
        $selectedSnackItems = isset($cobj->snack->item) ? json_decode($cobj->snack->item, true) : [];

        foreach ($snack as $key => $snObj) {
            // Check if the item exists in the selected items array
            $selected = (is_array($selectedSnackItems) && in_array($snObj->itemName, $selectedSnackItems)) ? 'selected' : '';
        ?>
            <option value="<?php echo htmlspecialchars($snObj->itemName); ?>" <?php echo $selected; ?>>
                <?php echo htmlspecialchars($snObj->itemName); ?>
            </option>
        <?php } ?>
    </select>
</div>



                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <?php
                                                    if(empty($cobj->snack->calories)){
                                                        $calories = "";
                                                    } else {
                                                        $calories = $cobj->snack->calories;
                                                    }
                                                ?>
                                            <label>Calories</label>
                                            <input type="text" name="lscalories" id="lscalories"
                                                class="form-control modal-form-control"
                                                value="<?php echo $calories; ?>">
                                        </div>
                                        <div class="form-group">
                                            <?php
                                                    if(empty($cobj->snack->qty)){
                                                        $qty = "";
                                                    } else {
                                                        $qty = $cobj->snack->qty;
                                                    }
                                                ?>
                                            <label for="lsqty">Quantity</label>
                                            <input type="text" id="lsqty" name="lsqty"
                                                class="form-control modal-form-control" value="<?php echo $qty; ?>">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <?php
                                                    if(empty($cobj->snack->comments)){
                                                        $comments = "";
                                                    } else {
                                                        $comments = $cobj->snack->comments;
                                                    }
                                                ?>
                                            <label for="lscomments">Comments</label>
                                            <textarea name="lscomments" class="form-control modal-form-control"
                                                id="lscomments" rows="5"><?php echo $comments; ?></textarea>
                                            <div class="clear-btn text-right">
                                                <button class="btn-link btn-link-clear btn btn-outline-primary mt-1"
                                                    type="button">Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-2">
                            <div class="card-body">
                                <h3 class="card-title">Sunscreen</h3>
                                <div class="sunscreen-block">
                                    <?php if(empty($cobj->sunscreen)) { ?>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <label>Time</label>
                                                <br>
                                                <?php
                        date_default_timezone_set('Australia/Sydney');
                        $hour = date('G'); // Current hour
                        $mins = date('i'); // Current minute
                        ?>
                                                <input type="number" min="0" max="24" value="<?php echo $hour; ?>"
                                                    name="sshour[]" class="form-hour from-hour form-number"> H :
                                                <input type="number" min="0" max="59" value="<?php echo $mins; ?>"
                                                    name="ssmins[]" class="form-mins from-mins form-number"> M
                                                &nbsp;<i class="fa-solid fa-clock"></i>&nbsp;<input type="time"
                                                    name="sstimePicker[]" class="form-time"
                                                    value="<?php echo sprintf('%02d:%02d', $hour, $mins); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                            <div class="form-group">
                                                <label for="sscomments">Comments</label>
                                                <input name="sscomments[]" class="form-control modal-form-control"
                                                    id="sscomments">
                                            </div>
                                        </div>
                                    </div>
                                    <?php } else { 
            $i = 1;
            foreach ($cobj->sunscreen as $key => $sunscreen) {
            ?>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group">
                                                <?php 
                        if (empty($sunscreen->startTime)) {
                            $hour = date('G');
                            $mins = date('i');
                        } else {
                            $time = explode(":",$sunscreen->startTime);
                            $hour = str_replace("h","",$time[0]);
                            $mins = str_replace("m","",$time[1]);
                        }
                        ?>
                                                <label>Time</label>
                                                <br>
                                                <input type="number" min="0" max="24" value="<?php echo $hour; ?>"
                                                    name="sshour[]" class="form-hour from-hour form-number"> H :
                                                <input type="number" min="0" max="59" value="<?php echo $mins; ?>"
                                                    name="ssmins[]" class="form-mins from-mins form-number"> M
                                                &nbsp;<i class="fa-solid fa-clock"></i>&nbsp;<input type="time"
                                                    name="sstimePicker[]" class="form-time"
                                                    value="<?php echo sprintf('%02d:%02d', $hour, $mins); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-7 col-sm-12">
                                            <div class="form-group">
                                                <?php
                        if(empty($sunscreen->comments)){
                            $comments = "";
                        } else {
                            $comments = $sunscreen->comments;
                        }
                        ?>
                                                <label for="sscomments">Comments</label>
                                                <input name="sscomments[]" class="form-control modal-form-control"
                                                    id="sscomments" value="<?php echo $comments; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-sm-12">
                                            <?php if ($i==1) { ?>
                                            <button type="button"
                                                class="btn w-100 btn-info btn-sm pull-right btn-default btn-small btnBlue add-sunscreen-row"
                                                style="margin-top: 25px;">Add</button>
                                            <?php } else { ?>
                                            <button type="button"
                                                class="btn btn-danger btn-sm pull-right btn-default btn-small btnRed remove-sunscreen-row">Remove</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php
                $i++;
            }
        } 
        ?>
                                </div>
                                <?php if(empty($sunscreen->startTime)){ ?>
                                <div class="text-right">
                                    <button type="button"
                                        class="btn btn-outline-primary add-sunscreen-row mt-2 mb-1 mr-4">Add</button>
                                </div>
                                <?php } ?>
                            </div>
                        </div>


                        <div class="card mb-2">
                            <div class="card-body">
                                <h3 class="card-title">Toileting</h3>
                                <div class="toileting-block">
                                    <?php
            if (!empty($cobj->toileting)) {
                foreach ($cobj->toileting as $index => $entry) {
                    if (empty($entry->startTime)) {
                        $hour = date('G'); // Current hour
                        $mins = date('i'); // Current minute
                    } else {
                        $time = explode(":", str_replace(['h', 'm'], '', $entry->startTime));
                        $hour = $time[0];
                        $mins = $time[1];
                    }


                    // Extract values
                    // $startTime = $entry->startTime ?? '1h:00m';
                    // $nappy = $entry->nappy ?? '';
                    // $potty = $entry->potty ?? '';
                    // $toilet = $entry->toilet ?? '';
                    $nappy_status = $entry->status ?? '';
                    $signature = $entry->signature ?? '';
                    $comments = $entry->comments ?? '';

                    // Split time into hours and minutes
                    // list($hour, $minute) = explode(':', str_replace(['h', 'm'], '', $startTime));
            ?>

                                    <div class="row" style="margin-top:20px;">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Time</label><br>
                                                <input type="number" min="0" max="24" value="<?php echo $hour; ?>"
                                                    name="hour[]" class="form-hour from-hour form-number"> H :
                                                <input type="number" min="0" max="59" value="<?php echo $mins; ?>"
                                                    name="mins[]" class="form-mins from-mins form-number"> M
                                                &nbsp;<i class="fa-solid fa-clock"></i>&nbsp;<input type="time"
                                                    name="timePicker[]" class="form-time"
                                                    value="<?php echo sprintf('%02d:%02d', $hour, $mins); ?>">


                                            </div>



                                            <!-- <div class="form-group">
                                <label for="nappy">Nappy</label><br>
                                <input type="text" class="form-control modal-form-control" name="nappy[]" id="nappy" value="<?php echo $nappy; ?>">
                            </div> -->
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="nappy_status">Nappy Status</label><br>
                                                <select class="form-control modal-form-control" name="nappy_status[]"
                                                    id="nappy_status">
                                                    <option value="Dry"
                                                        <?php echo ($nappy_status == 'Dry') ? 'selected' : ''; ?>>Dry
                                                    </option>
                                                    <option value="Wet"
                                                        <?php echo ($nappy_status == 'Wet') ? 'selected' : ''; ?>>Wet
                                                    </option>
                                                    <option value="Soiled"
                                                        <?php echo ($nappy_status == 'Soiled') ? 'selected' : ''; ?>>
                                                        Soiled</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- <div class="col-4">
                            <div class="form-group">
                                <label for="potty">Potty</label>
                                <input type="text" class="form-control modal-form-control" name="potty[]" id="potty" value="<?php echo $potty; ?>">
                            </div>
                            <div class="form-group">
                                <label for="toilet">Toilet</label>
                                <input type="text" class="form-control modal-form-control" name="toilet[]" id="toilet" value="<?php echo $toilet; ?>">
                            </div>
                        </div> -->
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="signature">Signature</label>
                                                <input type="text" class="form-control modal-form-control"
                                                    name="signature[]" id="signature" value="<?php echo $signature; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="ttcomments">Comments</label>
                                                <input type="text" name="ttcomments[]"
                                                    class="form-control modal-form-control" id="ttcomments"
                                                    value="<?php echo $comments; ?>">
                                            </div>
                                        </div>
                                        <?php if ($index !== 0) { ?>
                                        <div class="col-12 text-right">
                                            <button type="button"
                                                class="btn btn-outline-danger btn-sm remove-toileting-row mt-2 mb-1" style="margin-right:21px;">Remove</button>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <?php
                }
            } else {
                // Show an empty row with no data
            ?>
                                    <?php
date_default_timezone_set('Australia/Sydney');
$hour = date('G'); // Current hour
$mins = date('i'); // Current minute
?>
                                    <div class="row" style="margin-top:20px;">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Time</label><br>
                                                <input type="number" min="0" max="24" value="<?php echo $hour; ?>"
                                                    name="hour[]" class="form-hour from-hour form-number"> H :
                                                <input type="number" min="0" max="59" value="<?php echo $mins; ?>"
                                                    name="mins[]" class="form-mins from-mins form-number"> M
                                                &nbsp;<i class="fa-solid fa-clock"></i>&nbsp;<input type="time"
                                                    name="timePicker[]" class="form-time"
                                                    value="<?php echo sprintf('%02d:%02d', $hour, $mins); ?>">

                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="nappy_status">Nappy Status</label><br>
                                                <select class="form-control modal-form-control" name="nappy_status[]"
                                                    id="nappy_status">
                                                    <option value="Dry">Dry</option>
                                                    <option value="Wet">Wet</option>
                                                    <option value="Soiled">Soiled</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group">
                            <label for="nappy">Nappy</label><br>
                            <input type="text" class="form-control modal-form-control" name="nappy[]" id="nappy">
                        </div> -->

                                        <!-- <div class="col-4">
                        <div class="form-group">
                            <label for="potty">Potty</label>
                            <input type="text" class="form-control modal-form-control" name="potty[]" id="potty">  
                        </div>
                        <div class="form-group">
                            <label for="toilet">Toilet</label>
                            <input type="text" class="form-control modal-form-control" name="toilet[]" id="toilet">
                        </div>
                    </div> -->
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="signature">Signature</label>
                                                <input type="text" class="form-control modal-form-control"
                                                    name="signature[]" id="signature">
                                            </div>
                                            <div class="form-group">
                                                <label for="ttcomments">Comments</label>
                                                <input type="text" name="ttcomments[]"
                                                    class="form-control modal-form-control" id="ttcomments">
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="text-right">
                                    <button type="button"
                                        class="btn btn-outline-primary add-toileting-row mt-2 mb-1 mr-4">Add</button>
                                </div>
                            </div>
                        </div>





                        <?php if ($this->session->userdata('UserType') != "Parent") { ?>
                        <div class="formSubmit text-center mt-3 mb-4">
                            <button type="submit"
                                class="btn btn-info btn-default btnBlue pull-right btn-sm">SAVE</button>
                        </div>
                        <?php } ?>
                    </div>

                </div>
            </form>
        </div>
        <?php }	?>
    </main>


    <!-- Reset Modal -->
<div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="resetModalLabel">Reset Data</h5>
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
        <div class="form-check mb-2">
          <input class="form-check-input" type="checkbox" id="selectAll">
          <label class="form-check-label" for="selectAll">
            <strong>Select All</strong>
          </label>
        </div>
        <hr>
        <div id="resetOptions">
          <!-- Checkboxes will be dynamically added here -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="confirmReset">Reset Selected</button>
      </div>
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
</body>
<script>
$(document).ready(function() {
    $('#bfitem').select2();
    $('#mtitem').select2();
    $('#lnitem').select2();
    $('#atitem').select2();
    $('#lsitem').select2();

    $(document).on("click", ".add-sleep-row", function() {
        $(".sleep-block-row").append(
            '<div class="row" style="padding: 5px 15px;margin-top: 5px;"><div class="col-sm-4"><div class="form-group"> <label>Time</label> <br> <input type="number" min="0" max="24" name="slshour[]" id="slshour" class="form-hour from-hour form-number" value="22"> H : <input type="number" min="0" max="59" name="slsmins[]" id="slsmins" class="form-mins from-mins form-number" value="00"> M to <input type="number" min="0" max="24" name="slehour[]" id="slehour" class="form-hour to-hour form-number" value="07"> H : <input type="number" min="0" max="59" name="slemins[]" id="slemins" class="form-mins to-mins" value="00"> M</div></div><div class="col-sm-4" style="height:50px;position: relative;"><div class="form-group"> <label for="slcomments">Comments</label> <input name="slcomments[]" class="form-control modal-form-control" id="slcomments"></div></div><div class="col-sm-4" style="padding-top: 1.5rem;"> <button class="btn btn-danger btn-sm pull-right btn-default btnRed btn-small remove-sunscreen-row">Remove</button></div></div>'
            );
    });

    $(document).on("click", ".remove-sleep-row", function() {
        $(this).closest(".row").remove();
    });


    //sunscrenn code --------------------------------------------------------------------------------------------------------------
    // Function to synchronize time picker with hour and minute inputs
    // Function to synchronize time picker with hour and minute inputs
    function syncSunscreenTimePicker(row) {
        const hourInput = row.querySelector('.form-hour');
        const minsInput = row.querySelector('.form-mins');
        const timePicker = row.querySelector('.form-time');

        if (!hourInput || !minsInput || !timePicker) {
            console.error('One or more elements not found in the row.');
            return;
        }

        // Update hour and minute inputs when time picker changes
        timePicker.addEventListener('change', function() {
            const [hour, mins] = this.value.split(':');
            hourInput.value = hour;
            minsInput.value = mins;
        });

        // Update time picker when hour or minute inputs change
        hourInput.addEventListener('change', function() {
            timePicker.value =
            `${hourInput.value.padStart(2, '0')}:${minsInput.value.padStart(2, '0')}`;
        });

        minsInput.addEventListener('change', function() {
            timePicker.value =
            `${hourInput.value.padStart(2, '0')}:${minsInput.value.padStart(2, '0')}`;
        });
    }

    // Apply synchronization to all existing rows on page load
    document.querySelectorAll('.sunscreen-block .row').forEach(row => {
        syncSunscreenTimePicker(row);
    });

    // Add button click event
    $(document).on("click", ".add-sunscreen-row", function() {
        const currentTime = new Date().toLocaleTimeString('en-AU', {
            timeZone: 'Australia/Sydney',
            hour12: false,
            hour: '2-digit',
            minute: '2-digit'
        });
        const [hour, mins] = currentTime.split(':');

        const newRow = `
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <label>Time</label>
                    <br>
                    <input type="number" min="0" max="24" value="${hour}" name="sshour[]" class="form-hour from-hour form-number"> H : 
                    <input type="number" min="0" max="59" value="${mins}" name="ssmins[]" class="form-mins from-mins form-number"> M
                    &nbsp;<i class="fa-solid fa-clock"></i>&nbsp;<input type="time" name="sstimePicker[]" class="form-time" value="${currentTime}">
                </div>
            </div>
            <div class="col-md-7 col-sm-12" style="height:50px;position: relative;">
                <div class="form-group">
                    <label for="sscomments">Comments</label>
                    <input name="sscomments[]" class="form-control modal-form-control form-number" id="sscomments">
                </div>
            </div>
            <div class="col-md-1 col-sm-12" style="padding-top: 1.5rem;">
                <button type="button" class="btn btn-outline-danger btn-sm pull-right btn-default btnRed btn-small remove-sunscreen-row">Remove</button>
            </div>
        </div>
    `;

        $(".sunscreen-block").append(newRow);

        // Sync time picker for the new row
        const addedRow = $(".sunscreen-block .row").last()[0];
        syncSunscreenTimePicker(addedRow);
    });

    // Remove button click event
    $(document).on("click", ".remove-sunscreen-row", function() {
        $(this).closest(".row").remove();
    });




    //----------------------------------------------------------------------------------------------------------


    //toileting ------------------------------------------------------------------------------------------------------------------


    // Function to synchronize time picker with hour and minute inputs
    function syncToiletingTimePicker(row) {
        const hourInput = row.querySelector('.form-hour');
        const minsInput = row.querySelector('.form-mins');
        const timePicker = row.querySelector('.form-time');

        if (!hourInput || !minsInput || !timePicker) {
            console.error('One or more elements not found in the row.');
            return;
        }

        // Update hour and minute inputs when time picker changes
        timePicker.addEventListener('change', function() {
            const [hour, mins] = this.value.split(':');
            hourInput.value = hour;
            minsInput.value = mins;
        });

        // Update time picker when hour or minute inputs change
        hourInput.addEventListener('change', function() {
            timePicker.value =
            `${hourInput.value.padStart(2, '0')}:${minsInput.value.padStart(2, '0')}`;
        });

        minsInput.addEventListener('change', function() {
            timePicker.value =
            `${hourInput.value.padStart(2, '0')}:${minsInput.value.padStart(2, '0')}`;
        });
    }

    // Add button click event
    $(document).on("click", ".add-toileting-row", function() {
        const currentTime = new Date().toLocaleTimeString('en-AU', {
            timeZone: 'Australia/Sydney',
            hour12: false,
            hour: '2-digit',
            minute: '2-digit'
        });
        const [hour, mins] = currentTime.split(':');

        const newRow = `
        <div class="row" style="margin-top:20px;">
            <div class="col-4">
                <div class="form-group">
                    <label>Time</label><br>
                    <input type="number" min="0" max="24" value="${hour}" name="hour[]" class="form-hour from-hour form-number"> H :
                    <input type="number" min="0" max="59" value="${mins}" name="mins[]" class="form-mins from-mins form-number"> M
                    &nbsp;<i class="fa-solid fa-clock"></i>&nbsp;<input type="time" name="timePicker[]" class="form-time" value="${currentTime}">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="nappy_status">Nappy Status</label><br>
                    <select class="form-control modal-form-control" name="nappy_status[]" id="nappy_status">
                        <option value="Dry">Dry</option>
                        <option value="Wet">Wet</option>
                        <option value="Soiled">Soiled</option>
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="signature">Signature</label>
                    <input type="text" class="form-control modal-form-control" name="signature[]" id="signature">
                </div>
                <div class="form-group">
                    <label for="ttcomments">Comments</label>
                    <input type="text" name="ttcomments[]" class="form-control modal-form-control" id="ttcomments">
                </div>
            </div>
            <div class="col-12 text-right">
                <button type="button" class="btn btn-outline-danger btn-sm remove-toileting-row mt-2 mb-1" style="margin-right:20px;">Remove</button>
            </div>
        </div>
    `;

        $(".toileting-block").append(newRow);

        // Sync time picker for the new row
        const addedRow = $(".toileting-block .row").last()[0];
        syncToiletingTimePicker(addedRow);
    });

    // Remove button click event
    $(document).on("click", ".remove-toileting-row", function() {
        $(this).closest(".row").remove();
    });

    // Apply synchronization to all existing rows on page load
    document.querySelectorAll('.toileting-block .row').forEach(row => {
        syncToiletingTimePicker(row);
    });

    //----------------------------------------------------------------------------------------------------------------------------


    $(document).on("click", ".btn-link-clear", function() {
        $(this).closest('.row').find('input:text, select, textarea').each(function() {
            $(this).val('');
        });
    });

    <?php if ($this->session->userdata('UserType')=="Parent") { ?>
    $("#ucdd :input").prop("disabled", true);
    $("#ucdd :select").prop("disabled", true);
    <?php } ?>
});
</script>





<script>
// Function to handle time synchronization for a specific group
function setupTimeGroup(timePickerId, hourInputId, minsInputId) {
    const timePicker = document.getElementById(timePickerId);
    const hourInput = document.getElementById(hourInputId);
    const minsInput = document.getElementById(minsInputId);

    if (!timePicker || !hourInput || !minsInput) {
        console.error(`One or more elements not found for group: ${timePickerId}`);
        return;
    }

    // Update hour and minute inputs when time picker changes
    timePicker.addEventListener('change', function() {
        const time = this.value.split(':');
        hourInput.value = time[0];
        minsInput.value = time[1];
    });

    // Update time picker when hour or minute inputs change
    hourInput.addEventListener('change', function() {
        timePicker.value = `${hourInput.value.padStart(2, '0')}:${minsInput.value.padStart(2, '0')}`;
    });

    minsInput.addEventListener('change', function() {
        timePicker.value = `${hourInput.value.padStart(2, '0')}:${minsInput.value.padStart(2, '0')}`;
    });
}

// Set up time synchronization for each group
setupTimeGroup('bfTime', 'bfhour', 'bfmins'); // Breakfast
setupTimeGroup('mtTime', 'mthour', 'mtmins'); // Morning Tea
setupTimeGroup('lnTime', 'lnhour', 'lnmins'); // Lunch
setupTimeGroup('atTime', 'athour', 'atmins'); // Afternoon Tea
setupTimeGroup('lsTime', 'lshour', 'lsmins'); // Lunch Snack
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Get the button and add event listener
  const resetButton = document.getElementById('resetButton');
  resetButton.addEventListener('click', openResetModal);
  
  // Select All checkbox event
  const selectAllCheckbox = document.getElementById('selectAll');
  selectAllCheckbox.addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('#resetOptions input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
      checkbox.checked = selectAllCheckbox.checked;
    });
  });
  
  // Function to open the reset modal
  function openResetModal() {
    // Get the data from PHP (assuming it's already passed to JavaScript)
    const childData = <?php echo isset($child) ? json_encode($child[0]) : 'null'; ?>;

console.log("Child Data:", childData);

if (!childData || childData === "null") {
    alert('Error: Child data is not available');
    return;
}

    
    // List of all possible options
    const allOptions = ['breakfast', 'morningtea', 'lunch', 'sleep', 'afternoontea', 'snack', 'sunscreen', 'toileting'];
    
    // Clear previous options
    const resetOptions = document.getElementById('resetOptions');
    resetOptions.innerHTML = '';
    
    // Reset select all checkbox
    selectAllCheckbox.checked = false;
    
    // Filter options that are not null and create checkboxes
    let availableOptions = [];
    
    allOptions.forEach(option => {
      if (childData[option] !== null && childData[option] !== '') {
        availableOptions.push(option);
        
        // Create checkbox for this option
        const div = document.createElement('div');
        div.className = 'form-check';
        
        const input = document.createElement('input');
        input.className = 'form-check-input';
        input.type = 'checkbox';
        input.id = `reset_${option}`;
        input.name = 'reset_options[]';
        input.value = option;
        
        const label = document.createElement('label');
        label.className = 'form-check-label';
        label.htmlFor = `reset_${option}`;
        
        // Format the label to be more readable (capitalize first letter)
        const formattedOption = option.charAt(0).toUpperCase() + option.slice(1);
        if (option === 'morningtea') {
          label.textContent = 'Morning Tea';
        } else if (option === 'afternoontea') {
          label.textContent = 'Afternoon Tea';
        } else {
          label.textContent = formattedOption;
        }
        
        div.appendChild(input);
        div.appendChild(label);
        resetOptions.appendChild(div);
      }
    });
    
    // Show the modal
    const resetModal = new bootstrap.Modal(document.getElementById('resetModal'));
    resetModal.show();
    
    // Add event listener for the confirm button
    document.getElementById('confirmReset').addEventListener('click', function() {
      const selectedOptions = [];
      document.querySelectorAll('#resetOptions input[type="checkbox"]:checked').forEach(checkbox => {
        selectedOptions.push(checkbox.value);
      });
      
      if (selectedOptions.length > 0) {
        // Send the selected options to the server for processing
        resetSelectedData(selectedOptions, childData.id);
      } else {
        alert('Please select at least one item to reset.');
      }
    });
  }
  
  // Function to reset the selected data
  function resetSelectedData(options, childId) {
    // AJAX call to your CodeIgniter controller
    $.ajax({
      url: '<?php echo base_url("dailyDiary/reset_data"); ?>',
      type: 'POST',
      data: {
        options: options,
        child_id: childId,
        date: '<?php echo date("Y-m-d"); ?>'
      },
      success: function(response) {
        try {
      response = JSON.parse(response); // Ensure response is properly parsed
    } catch (e) {
      console.error("JSON Parsing Error:", e, response);
      alert("An error occurred while processing the response.");
      return;
    }
        console.log("response",response);
        console.log("response-success",response.status);
    if (response.status === 'success') {
        // Close the modal
        // bootstrap.Modal.getInstance(document.getElementById('resetModal')).hide();
        
        // Show success message
        alert('Data reset successfully: ' + response.message);
        
        // Reload the page to reflect changes
        location.reload();
    } else {
        alert('Error: ' + response.message);
    }
},
      error: function() {
        alert('An error occurred while processing your request.');
      }
    });
  }

  
});
</script>

    </html>