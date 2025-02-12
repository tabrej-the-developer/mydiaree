<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit QIP | Mydiaree</title>
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css" />
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- <link rel="stylesheet" href="<?#= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css" /> -->
    <style>
        @media screen and (min-width: 1511px) {
          .qualityArea {
            max-width: 24.4%;
          }
        }
          @media screen and (min-width: 992px)  and (max-width: 1510px){
          .qualityArea {
            max-width: 24%;
          }
        }
          @media screen and (min-width: 768px) and (max-width: 991px) {
          .qualityArea {
            max-width: 23%;
          }
        }
    </style>
      <style>
        .form-check {
            display: flex;
            align-items: center;
        }
        .form-check-input {
            margin-top: 0;
            margin-right: 0.5rem;
        }
        .btn-link {
            padding: 0;
            font-size: 0.9rem;
        }
        
    </style>
</head>
<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?> 
    <main data-centerid="<?= isset($centerid)?$centerid:null; ?>">
    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>
        <div class="default-transition">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <h1>Edit QIP</h1>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('Qip').'?centerid='.$centerid; ?>">QIP</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Edit QIP</li>
                            </ol>
                        </nav>
                        <button class="btn btn-outline-primary" style="float:right;" data-toggle="modal" data-target="#printModal">Print</button>
                        <div class="separator mb-5"></div>
                    </div>
                </div>
                <div class="row">      
                    <?php 
                        $tp = 0;
                        $ttp = 0;
                        if (isset($areas) && !empty($areas)) {
                            foreach ($areas as $areaz => $area) {
                                $ttp = $ttp + $area->resultPer;
                                $tp = ceil($ttp/700);
                            }
                        }
                    ?>  
                    <div class="col-12">
                        <div class="mainRange col-12 mb-5 p-5 card">
                            <div class="qipInfo">
                                <span class="d-flex">
                                    <h2 data-qipid="<?= $qip->id; ?>" ><?= $qip->name; ?> &nbsp;</h2>
                                    <i class="simple-icon-pencil text-info mt-2" id="editQIPname"></i>
                                </span>
                            </div>
                            <div class="flexLabel">
                                <div class="labelProgress mb-2">Progress</div>
                                <span class="sr-only"><?= $tp; ?> / 100</span>
                            </div>
                            <div class="progress" style="height: 15px !important;">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?= $tp; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $tp; ?>%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                        <?php 
                            if (isset($areas) && !empty($areas)) {
                                $i = 1;
                                foreach ($areas as $areaz => $area) {
                        ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 my-3">
                            <div class="card" style="border: 1px solid <?= $area->color; ?>;">
                                <div class="card-body">
                                    <a href="<?= base_url('qip/view').'?qipid='.$_GET['id'].'&areaid='.$area->id; ?>">
                                        <h3 class="card-title">
                                            <?= "Quality Area ".$i; ?>
                                        </h3>
                                    </a>
                                    <p class="mb-2">
                                        <span><?= ucfirst(strtolower($area->title)); ?></span>
                                        <span class="float-right text-muted"><?= $area->resultPer; ?> / 100 </span>
                                    </p>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="<?= $area->resultPer; ?>" aria-valuemin="0" aria-valuemax="100" style="background: <?= $area->color; ?>;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php  
                                    $i++;
                                }
                            }else{
                                echo "<h3>No areas found!</h3>";
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>



    <!-- Modal -->
    <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="printModalLabel">Select Options to Print</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height:500px;overflow-y:auto;">
                    <form id="printForm">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                            <label class="form-check-label" for="selectAll">Select All</label>
                        </div>
                        <hr>
                        <!-- Quality Area Options -->
                        <div id="qualityAreas">
                            <!-- Loop for Quality Areas -->
                            <div class="form-group">
                                <div>
                                    <input type="checkbox" class="form-check-input area-checkbox" id="qa1" data-group="qa1">
                                    <label class="form-check-label" for="qa1">Quality Area 1</label> 
                                    <button type="button" class="btn btn-link btn-sm toggle-collapse" data-target="#qa1SubOptions">Expand</button>
                                </div>
                                <div id="qa1SubOptions" class="collapse pl-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input sub-checkbox" id="qa1_1" data-parent="qa1">
                                        <label class="form-check-label" for="qa1_1">Standard 1.1</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input sub-checkbox" id="qa1_2" data-parent="qa1">
                                        <label class="form-check-label" for="qa1_2">Standard 1.2</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input sub-checkbox" id="qa1_3" data-parent="qa1">
                                        <label class="form-check-label" for="qa1_3">Standard 1.3</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Repeat for other Quality Areas -->
                            <div class="form-group">
                                <div>
                                    <input type="checkbox" class="form-check-input area-checkbox" id="qa2" data-group="qa2">
                                    <label class="form-check-label" for="qa2">Quality Area 2</label>
                                    <button type="button" class="btn btn-link btn-sm toggle-collapse" data-target="#qa2SubOptions">Expand</button>
                                </div>
                                <div id="qa2SubOptions" class="collapse pl-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input sub-checkbox" id="qa2_1" data-parent="qa2">
                                        <label class="form-check-label" for="qa2_1">Standard 2.1</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input sub-checkbox" id="qa2_2" data-parent="qa2">
                                        <label class="form-check-label" for="qa2_2">Standard 2.2</label>
                                    </div>
                                </div>
                            </div>

                              <!-- Quality Area 3 -->
                              <div class="form-group">
                                <div>
                                    <input type="checkbox" class="form-check-input area-checkbox" id="qa3" data-group="qa3">
                                    <label class="form-check-label" for="qa3">Quality Area 3</label>
                                    <button type="button" class="btn btn-link btn-sm toggle-collapse" data-target="#qa3SubOptions">Expand</button>
                                </div>
                                <div id="qa3SubOptions" class="collapse pl-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input sub-checkbox" id="qa3_1" data-parent="qa3">
                                        <label class="form-check-label" for="qa3_1">Standard 3.1</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input sub-checkbox" id="qa3_2" data-parent="qa3">
                                        <label class="form-check-label" for="qa3_2">Standard 3.2</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Quality Area 4 -->
                            <div class="form-group">
                                <div>
                                    <input type="checkbox" class="form-check-input area-checkbox" id="qa4" data-group="qa4">
                                    <label class="form-check-label" for="qa4">Quality Area 4</label>
                                    <button type="button" class="btn btn-link btn-sm toggle-collapse" data-target="#qa4SubOptions">Expand</button>
                                </div>
                                <div id="qa4SubOptions" class="collapse pl-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input sub-checkbox" id="qa4_1" data-parent="qa4">
                                        <label class="form-check-label" for="qa4_1">Standard 4.1</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input sub-checkbox" id="qa4_2" data-parent="qa4">
                                        <label class="form-check-label" for="qa4_2">Standard 4.2</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Quality Area 5 -->
                            <div class="form-group">
                                <div>
                                    <input type="checkbox" class="form-check-input area-checkbox" id="qa5" data-group="qa5">
                                    <label class="form-check-label" for="qa5">Quality Area 5</label>
                                    <button type="button" class="btn btn-link btn-sm toggle-collapse" data-target="#qa5SubOptions">Expand</button>
                                </div>
                                <div id="qa5SubOptions" class="collapse pl-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input sub-checkbox" id="qa5_1" data-parent="qa5">
                                        <label class="form-check-label" for="qa5_1">Standard 5.1</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input sub-checkbox" id="qa5_2" data-parent="qa5">
                                        <label class="form-check-label" for="qa5_2">Standard 5.2</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Quality Area 6 -->
                            <div class="form-group">
                                <div>
                                    <input type="checkbox" class="form-check-input area-checkbox" id="qa6" data-group="qa6">
                                    <label class="form-check-label" for="qa6">Quality Area 6</label>
                                    <button type="button" class="btn btn-link btn-sm toggle-collapse" data-target="#qa6SubOptions">Expand</button>
                                </div>
                                <div id="qa6SubOptions" class="collapse pl-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input sub-checkbox" id="qa6_1" data-parent="qa6">
                                        <label class="form-check-label" for="qa6_1">Standard 6.1</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input sub-checkbox" id="qa6_2" data-parent="qa6">
                                        <label class="form-check-label" for="qa6_2">Standard 6.2</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Quality Area 7 -->
                            <div class="form-group">
                                <div>
                                    <input type="checkbox" class="form-check-input area-checkbox" id="qa7" data-group="qa7">
                                    <label class="form-check-label" for="qa7">Quality Area 7</label>
                                    <button type="button" class="btn btn-link btn-sm toggle-collapse" data-target="#qa7SubOptions">Expand</button>
                                </div>
                                <div id="qa7SubOptions" class="collapse pl-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input sub-checkbox" id="qa7_1" data-parent="qa7">
                                        <label class="form-check-label" for="qa7_1">Standard 7.1</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input sub-checkbox" id="qa7_2" data-parent="qa7">
                                        <label class="form-check-label" for="qa7_2">Standard 7.2</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Add similar blocks for Quality Areas 3 to 7 -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="printSelected">Print Selected</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js"></script> 
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/datatables.min.js"></script>
</body>
<script>
    $(document).on("click","#editQIPname",function(){
        let qipName = $(this).prev().text();
        let qipId = $(this).prev().data("qipid");
        $(".qipInfo span").hide();
        $(".qipInfo").find('input').remove();
        $(".qipInfo").append(`
            <input type="text" id="qip_name" class="form-control" data-qipid="`+ qipId +`" style="width: 30%;" value="`+ qipName +`">
        `);
    });

    $(document).on("blur","#qip_name",function(){
        let qipName = $(this).val();
        let qipId = $(this).data("qipid");
        if (qipName == "") {
            $(".qipInfo h2").show();
            $(".qipInfo span").show();
        }else{
            $.ajax({
                url: '<?= base_url("Qip/renameQip"); ?>',
                type: 'POST',
                data: {'name': qipName, 'id':qipId},
            })
            .done(function(msg) {
                res = jQuery.parseJSON(msg);
                $("#qip_name").remove();
                $(".qipInfo").empty();
                $(".qipInfo").append(`
                    <span class="d-flex">
                        <h2 data-qipid="`+res.qipId+`" >`+res.qipName+`</h2>
                        <i id="editQIPname" class="simple-icon-pencil text-info m-2"></i>
                    </span>
                `);
            });
        }        
    });

    $(document).on('keyup',"#qip_name",function(){
        if(event.keyCode==13){
            $(this).blur();
        }
    });
</script>

<script>
        $(document).ready(function() {
            // Handle Select All
            $('#selectAll').on('change', function() {
                const isChecked = $(this).is(':checked');
                $('.area-checkbox, .sub-checkbox').prop('checked', isChecked);
            });

            // Handle Quality Area Selection
            $('.area-checkbox').on('change', function() {
                const group = $(this).data('group');
                const isChecked = $(this).is(':checked');
                $(`#${group}SubOptions .sub-checkbox`).prop('checked', isChecked);
            });

            // Handle Sub-option Selection
            $('.sub-checkbox').on('change', function() {
                const parent = $(this).data('parent');
                const allSubChecked = $(`#${parent}SubOptions .sub-checkbox`).length === $(`#${parent}SubOptions .sub-checkbox:checked`).length;
                $(`#${parent}`).prop('checked', allSubChecked);
            });

            // Toggle Expand/Collapse
            $('.toggle-collapse').on('click', function() {
    const target = $(this).data('target');
    const isExpanded = $(target).hasClass('show'); // Check if it's currently expanded
    $(target).collapse('toggle'); // Toggle the collapse

    // Update the text based on the current state
    $(this).text(isExpanded ? 'Expand' : 'Collapse');
});

           


// Print Selected
            $('#printSelected').on('click', function() {
    // Get the selected options
    const selectedOptions = [];
    $('.sub-checkbox:checked').each(function() {
        selectedOptions.push($(this).attr('id'));
    });

    // Get the ID from the URL segment
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id'); // Extract the 'id' query parameter
    const center_id = urlParams.get('centerid'); // Extract the 'id' query parameter

    // AJAX request to send data to the controller
    $.ajax({
        url: '<?= base_url("Qip/print_selectedqip"); ?>', // Controller method to handle the request
        type: 'POST',
        data: {
            id: id,
            centerid: center_id,
            selectedOptions: selectedOptions
        },
        dataType: 'json',
        success: function(response) {
    // Handle success response
    if (response.status === 'success') {
        // Open the PDF URL in a new tab
        window.open(response.fileName, '_blank');
    } else {
        // Handle error message
        console.error('Error:', response.message);
        alert('Failed to update data: ' + response.message);
    }
},
error: function(xhr, status, error) {
    // Handle error response
    console.error('AJAX Error:', error);
    alert('An error occurred. Please try again.');
}
    });
});

       
       
        });
    </script>
</html>
