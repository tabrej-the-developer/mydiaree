<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit QIP | Mykronicle</title>
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
</html>
