<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>headchecks | Mydiaree</title>
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
                            <h1>Head Checks</h1>
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
                                    <li class="breadcrumb-item active" aria-current="page">Headchecks</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                    <div class="separator mb-5"></div>
                </div>

                <div class="col-lg-12 col-xl-12">
                    <div class="row">
                        <div class="col-12">
                            <!-- <h3 class="service-title">Head Checks</h3> -->
                            <form action="<?php echo base_url("HeadChecks/addHeadChecks"); ?>" method="post" id="headCheckForm">
                                <input type="hidden" name="roomid" id="roomid" value="<?= isset($_GET['roomid'])?$_GET['roomid']:$roomid; ?>">
                                <input type="hidden" name="centerid" id="centerId" value="<?= isset($_GET['centerid'])?$_GET['centerid']:$centerid; ?>">
                                <input type="hidden" name="diarydate" id="txtCalendar" value="<?= isset($calDate)?$calDate:$calDate=$date; ?>">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="headCheckViewConyainer w-100 p-4 card" style="background-color: #ffffff!important;display: inline-block;">
                                            <div id="form-fields">
                                                <?php 
                                                $i=1;
                                                if (empty($headChecks)) {
                                                ?>

<?php
date_default_timezone_set('Australia/Sydney');
$hour = date('G'); // Current hour
$mins = date('i'); // Current minute
?>
                                                <div class="form-row rowInnerHeadCheck w-100" >
                                                    <div class="form-group col-md-3 col-sm-12">
                                                        <label>Time</label>
                                                        <br>
        <input type="number" min="0" max="24" value="<?php echo $hour; ?>" name="hour[]" class="form-hour form-number w-40"> H : 
        <input type="number" min="00" max="59" value="<?php echo $mins; ?>" name="mins[]" class="form-mins form-number w-40"> M
        &nbsp;<i class="fa-solid fa-clock"></i>&nbsp;<input type="time" name="timePicker[]" class="form-time" value="<?php echo sprintf('%02d:%02d', $hour, $mins); ?>">
                                                     </div>
                                                    <div class="form-group col-md-3 col-sm-12">
                                                        <label>Head Count</label>
                                                        <input type="number" class="form-control" name="headCount[]" value="">
                                                    </div>
                                                    <div class="form-group col-md-3 col-sm-12">
                                                        <label>Signature</label>
                                                        <input type="text" class="form-control" name="signature[]">
                                                    </div>
                                                    <div class="form-group commentGroup col-md-3 col-sm-12">
                                                        <label>Comments</label>
                                                        <input type="text" class="form-control commentField" name="comments[]">
                                                    </div>
                                                    <!-- <div class="form-group lastGroup col-md-1 col-sm-12" style="margin-top: 38px;">
                                                        <a href="#!" class="btn-outline-primary add-btn">
                                                            <span class="simple-icon-plus"></span>
                                                        </a>
                                                    </div> -->
                                                    <?php if ($i!=1) { ?>
                                                        <div class="btn-group">
                                                            <div class="form-group lastGroup col-md-1 col-sm-12" style="margin-top: 38px;">
                                                                <a href="#!" class="btn-outline-danger minus-btn">
                                                                    <span class="simple-icon-minus"></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <?php
                                                } else {
                                                    foreach ($headChecks as $key => $hc) { 
                                                        if (empty($hc->time)) {
                                                            $hour = date('G'); // Current hour
                                                            $mins = date('i'); // Current minute
                                                        } else {
                                                            $time = explode(":",$hc->time);
                                                            $hour = str_replace("h","",$time[0]);
                                                            $mins = str_replace("m","",$time[1]);
                                                        }
                                                ?>
                                                <div class="form-row row InnerHeadCheck w-100">
                                                    <div class="form-group col-md-3 col-sm-12">
                                                        <label>Time</label>
                                                        <br>
        <input type="number" min="0" max="24" name="hour[]" class="form-hour w-40 form-number" value="<?php echo $hour; ?>"> H : 
        <input type="number" min="00" max="59" name="mins[]" class="form-mins form-number w-40" value="<?php echo $mins; ?>"> M
        &nbsp;<i class="fa-solid fa-clock"></i>&nbsp;<input type="time" name="timePicker[]" class="form-time" value="<?php echo sprintf('%02d:%02d', $hour, $mins); ?>">
          </div>
                                                    <div class="form-group col-md-3 col-sm-12">
                                                        <label>Head Count</label>
                                                        <input type="number" class="form-control" name="headCount[]" value="<?php echo $hc->headcount; ?>">
                                                    </div>
                                                    <div class="form-group col-md-3 col-sm-12">
                                                        <label>Signature</label>
                                                        <input type="text" class="form-control" name="signature[]" value="<?php echo $hc->signature; ?>">
                                                    </div>
                                                    <div class="form-group commentGroup col-md-3 col-sm-12">
                                                        <label>Comments</label>
                                                        <input type="text" class="form-control commentField" name="comments[]" value="<?php echo $hc->comments; ?>">
                                                    </div>
                                                    <?php if ($i!=1 && $date == date("Y-m-d")) { ?>
                                                        <div class="btn-group ">
                                                            <div class="form-group lastGroup col-md-1 col-sm-12" style="margin-top: 38px;">
                                                                <a href="#!" class="btn btn-outline-danger minus-btn">
                                                                    <!-- <span class="simple-icon-minus"></span> -->
                                                                    Remove
                                                                </a>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <?php 
                                                    $i++; 
                                                    } 
                                                } ?>
                                            </div>
                                            <div class="form-group text-right" style="margin-top: 20px;">
                                                <?php
                                                //  if ($i==1) {
                                                    if(isset($date)?$date:$date=date("Y-m-d")){
                                                        if($date == date("Y-m-d")){
                                                ?>
                                                    <button type="button" class="btn btn-outline-primary my-2 add-btn"> + New</button>
                                                    <button class="btn btn-outline-success" id="save_headcheck" type="button">Save</button>
                                                <?php
                                                    } }
                                                ?>
                                            </div>
                                     
                                        </div>
                                    </div>
                                </div>
                            </form>	      
                        </div>
                    </div>
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
	$(document).ready(function(){

   // Function to synchronize time picker with hour and minute inputs
function syncTimePicker(row) {
    const hourInput = row.querySelector('.form-hour');
    const minsInput = row.querySelector('.form-mins');
    const timePicker = row.querySelector('.form-time');

    if (!hourInput || !minsInput || !timePicker) {
        console.error('One or more elements not found in the row.');
        return;
    }

    // Update hour and minute inputs when time picker changes
    timePicker.addEventListener('change', function () {
        const [hour, mins] = this.value.split(':');
        hourInput.value = hour;
        minsInput.value = mins;
    });

    // Update time picker when hour or minute inputs change
    hourInput.addEventListener('change', function () {
        timePicker.value = `${hourInput.value.padStart(2, '0')}:${minsInput.value.padStart(2, '0')}`;
    });

    minsInput.addEventListener('change', function () {
        timePicker.value = `${hourInput.value.padStart(2, '0')}:${minsInput.value.padStart(2, '0')}`;
    });
}

// Apply synchronization to all existing rows on page load
document.querySelectorAll('.rowInnerHeadCheck, .InnerHeadCheck').forEach(row => {
    syncTimePicker(row);
});

// Add button click event
$('.add-btn').on('click', function () {
    const currentTime = new Date().toLocaleTimeString('en-AU', { timeZone: 'Australia/Sydney', hour12: false, hour: '2-digit', minute: '2-digit' });
    const [hour, mins] = currentTime.split(':');

    const newRow = `
        <div class="row rowInnerHeadCheck form-row w-100">
            <div class="form-group col-md-3 col-sm-12">
                <label>Time</label>
                <br>
                <input type="number" min="0" max="24" value="${hour}" name="hour[]" class="form-hour form-number w-40"> H : 
                <input type="number" min="00" max="59" value="${mins}" name="mins[]" class="form-mins form-number w-40"> M
                &nbsp;<i class="fa-solid fa-clock"></i>&nbsp;<input type="time" name="timePicker[]" class="form-time" value="${currentTime}">
            </div>
            <div class="form-group col-md-3 col-sm-12">
                <label>Head Count</label>
                <input type="number" class="form-control" name="headCount[]">
            </div>
            <div class="form-group col-md-3 col-sm-12">
                <label>Signature</label>
                <input type="text" class="form-control" name="signature[]">
            </div>
            <div class="form-group commentGroup col-md-3 col-sm-12">
                <label>Comments</label>
                <input type="text" class="form-control commentField" name="comments[]">
            </div>
            <div class="btn-group" style="display:contents;">
                <div class="form-group lastGroup col-md-1 col-sm-12" style="margin-top: 28px;">
                    <a href="#!" class="btn btn-outline-danger minus-btn btn-block" style="width: fit-content;">Remove</a>
                </div>
            </div>
        </div>
    `;

    $('#form-fields').append(newRow);

    // Sync time picker for the new row
    const addedRow = $('#form-fields .rowInnerHeadCheck').last()[0];
    syncTimePicker(addedRow);
});

// Remove button click event
$(document).on('click', '.minus-btn', function () {
    $(this).closest('.rowInnerHeadCheck, .InnerHeadCheck').remove();
});

		// $(document).on('click','.minus-btn',function(){
		// 	$(this).closest(".row").remove();
		// });

		$(document).on('change','#centerId',function(){
			var centerId = $(this).val();
			$.ajax({
				traditional: true,
				url: "<?php echo base_url("DailyDiary/getCenterRooms")?>",
				type: "POST",
			    beforeSend: function(request) {
			      request.setRequestHeader("x-device-Id", "");
			      request.setRequestHeader("x-token", "609ca994bf421");
			    },
			    data: {"userid":3, 'centerId':centerId},
			    success: function(msg){
			    	$("#roomid").html("");
					var res = jQuery.parseJSON(msg);
					$("#roomid").append('<option>-- Select Room --</option>');
					for (loop=0; loop < res.Rooms.length; loop++) {
				     	$("#roomid").append('<option value="'+ res.Rooms[loop].id +'">'+ res.Rooms[loop].name +'</option>');
					}
				}
			});
		});

		$(document).on('change','#roomid',function(){
			$('#headCheckForm').submit();
		});

		$(document).on('change','#txtCalendar',function(){
			// $('#headCheckForm').submit();
            let date = $(this).val();
            let url = "<?= base_url('HeadChecks').'?centerid='.$centerid.'&roomid='.$roomid.'&date='; ?>"+date;
            window.location.href = url;
		});

		$(document).on('click','#save_headcheck',function(){
			$("#headCheckForm").submit();
		});
	});
</script>
</html>