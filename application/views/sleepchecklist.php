<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SleepCheckList | Mydiaree</title>
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?id=1234" />

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?id=1234" />
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?id=1234"></script>
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
    </style>

<style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f4f8;
      padding: 20px;
      color: #333;
    }
    .container {
      max-width: 1200px;
      margin: auto;
    }
    .child-section {
      background-color: #ffffff;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 30px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .child-header {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 20px;
      color: #2c3e50;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 10px;
    }
    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #e1e4e8;
    }
    th {
      background-color: #ecf0f1;
      font-weight: 600;
    }
    input[type="time"],
    input[type="text"],
    input[type="number"],
    textarea {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }
    textarea {
      resize: vertical;
    }
    .add-row-btn {
      background-color: #3498db;
      color: white;
      border: none;
      padding: 10px 16px;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .add-row-btn:hover {
      background-color: #2980b9;
    }
    .section-divider {
      height: 1px;
      background-color: #dcdde1;
      margin: 30px 0;
    }
  </style>

</head>
<body id="app-container" class="menu-default show-spinner">
<?php $this->load->view('sidebar'); ?> 
<main class="default-transition">
    <div class="default-transition">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" style="margin-top: -15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h1>Sleep Check List</h1>
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
                                <ol class="breadcrumb pt-0" style="background-color: transparent;">
                                    <li class="breadcrumb-item">
                                        <a href="<?= base_url('dashboard'); ?>" style="color: dimgray;">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="#" style="color: dimgray;">Daily Journal</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Sleep Check List</li>
                                </ol>
                            </nav>
 
                        </div>
                    </div>
                    <div class="separator mb-5"></div>
                </div>



                <div class="container">
    <?php foreach ($children as $index => $child): ?>
    <div class="child-section" id="child<?php echo $child->id; ?>">
    <div class="child-header">
    <?php if (!empty($child->imageUrl)): ?>
        <div class="child-avatar" style="display: inline-block; margin-right: 10px;">
            <img src="<?php echo base_url('api/assets/media/' . $child->imageUrl); ?>" 
                 alt="<?php echo htmlspecialchars($child->name); ?>" 
                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
        </div>
    <?php else: ?>
        <div class="child-avatar" style="display: inline-block; margin-right: 10px;">
            <div style="width: 40px; height: 40px; border-radius: 50%; background-color: #ccc; display: inline-flex; align-items: center; justify-content: center;">
                <span style="font-size: 18px; color: #666;">
                    <?php echo strtoupper(substr($child->name, 0, 1)); ?>
                </span>
            </div>
        </div>
    <?php endif; ?>
    <span><?php echo htmlspecialchars($child->name . ' ' . $child->lastname); ?></span>
</div>
        <table>
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Sleep Position</th>
                    <th>Body Temperature (°C)</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="time" name="children[<?php echo $child->id; ?>][time][]"></td>
                    <td><input type="text" name="children[<?php echo $child->id; ?>][position][]" placeholder="e.g. Left side"></td>
                    <td><input type="number" step="0.1" name="children[<?php echo $child->id; ?>][temperature][]" placeholder="36.5"></td>
                    <td><textarea rows="2" name="children[<?php echo $child->id; ?>][notes][]" placeholder="Observation notes..."></textarea></td>
                </tr>
            </tbody>
        </table>
        <button class="add-row-btn" onclick="addRow('child<?php echo $child->id; ?>', <?php echo $child->id; ?>)">+ Add 10-Min Entry</button>
    </div>
    <?php endforeach; ?>
</div>
  


















                </div>
        </div>
    </div>
</main>
    <?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery.smartWizard.min.js" style="opacity: 1;"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap-datepicker.js?v=1.0.0"></script>
</body>

<script>
    function addRow(childId) {
      const tableBody = document.querySelector(`#${childId} table tbody`);
      const row = document.createElement('tr');
      row.innerHTML = `
        <td><input type="time"></td>
        <td><input type="text" placeholder="e.g. On back"></td>
        <td><input type="number" step="0.1" placeholder="36.5"></td>
        <td><textarea rows="2" placeholder="Observation notes..."></textarea></td>
      `;
      tableBody.appendChild(row);
    }
  </script>


</html>