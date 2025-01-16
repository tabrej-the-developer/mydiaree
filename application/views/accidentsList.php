<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Accident Reports | Mykronicle</title>
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
    </style>
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); 
    $usertype = $this->session->userdata('UserType');
    if ($usertype == "Superadmin") {
        $add = 1;
        $edit = 1;
        $delete = 1;
    } else {
        if ($usertype == "Staff") {
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
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Accident Reports</h1>
                        <?php if($this->session->userdata("UserType")!="Parent"){ ?>
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
                                    <a class="dropdown-item" href="<?= current_url().'?centerid='.$center->id; ?>">
                                        <?= strtoupper($center->centerName); ?>
                                    </a>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="btn-group mr-1">
                            <?php 
                                if(empty($rooms)){
                            ?>
                            <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> NO ROOMS AVAILABLE </div>
                            <?php   
                                }else{
                                    $count = count($rooms);
                                    $int = 0;
                                    foreach ($rooms as $room => $rObj) { 
                                        if ($rObj->id==$roomid || (isset($_GET['roomid']) && $_GET['roomid']==$rObj->id)) {
                            ?>
                            <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= strtoupper($rObj->name); ?> </div>
                            <?php
                                        }
                                        $int++;
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
                            if(isset($date)){
                                $calDate = date('d-m-Y',strtotime($date));
                            }else if (isset($_GET['date']) && $_GET['date'] != "") {
                                $calDate = date('d-m-Y',strtotime($_GET['date']));
                            }else{
                                $calDate = date('d-m-Y');
                            }
                        ?>
                        <div class="form-group">
                            <button class="btn btn-primary btn-lg top-right-button" id="new-accident-btn" data-roomid="<?= $roomid ?>" data-centerid="<?= $centerid ?>" type="button">ADD NEW ACCIDENT</button>
                        </div>
                    </div>
                    <?php } ?>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Daily Journal</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Accident</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>  
            <div class="row">
                <div class="col-lg-12 col-md-12 mb-4 accidentListCont">
                    <div class="card">
                        <div class="card-body">
                            <!-- <h5 class="card-title">Accident</h5> -->
                            <table class="table data-table data-tables-pagination">
                                <thead>
                                    <tr>
                                        <th scope="col">S No</th>
                                        <th scope="col">Child Name</th>
                                        <th scope="col">Created By</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $i = 1; 
                                        foreach ($accidents as $acckey => $accobj) {
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $i; ?></th>
                                        <td><a href="<?= base_url('accident/view').'?id='.$accobj->id.'&centerid='.$centerid.'&roomid='.$roomid; ?>"><?= $accobj->child_name; ?></a></td>
                                        <td><?php echo $accobj->username; ?></td>
                                        <?php
                                        $newDate = date("d.m.Y", strtotime($accobj->incident_date));
                                        ?>
                                        <td><?= $newDate; ?></td>
                                    </tr>
                                    <?php $i++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </main>



<?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/datatables.min.js" style="opacity: 1;"></script>
</body>
<script>
	$(document).ready(function(){
        $('#new-accident-btn').on('click', function(event) {
            // var _centerid = $('#centerid').val();
            // var _roomid = $('#roomId').val();
            var _centerid = $(this).data('centerid');
            var _roomid = $(this).data('roomid');
            var _url = '<?= base_url("accident/add"); ?>?centerid='+_centerid+'&roomid='+_roomid;
            window.location.href = _url;            
        });
    });

    $('#roomId').on('change', function(event) {
        var _centerid = $('#centerid').val();
        var _roomid = $('#roomId').val();
        var _url = '<?= base_url("accident"); ?>?centerid='+_centerid+'&roomid='+_roomid;
        window.location.href = _url;            
    });

    $("#centerid").on('change',function(){
        let _centerid = $(this).val();
        $.ajax({
            url: '<?= base_url('Accident/getCenterRooms'); ?>',
            type: 'POST',
            data: {'centerid': _centerid},
        }).done(function(json) {
            res = $.parseJSON(json);
            if (res.Status == "SUCCESS") {
                $("#roomId").empty();
                $("#roomId").append(`
                    <option value="">-- Select Center --</option>
                `);
                $.each(res.Rooms, function(index, val) {
                    console.log(val);
                    $("#roomId").append(`
                        <option value="`+val.id+`">`+val.name+`</option>
                    `);
                });
            } else {
                console.log(res.Message);
                $("#roomId").empty();
                $("#roomId").append(`
                    <option value="">No room found!</option>
                `);
            }
        });
        
    });
</script>