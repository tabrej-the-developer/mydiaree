<?php
	$data['name']='Reflection_form'; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reflection | Mykronicle</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js?id=1234"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?id=1234" />
    <link rel="stylesheet"
        href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2-bootstrap.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/slick.css" />
    <style>
    .pageHead {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 0 0 30px;
        margin-top: 0px;
    }

    .obsMenuTop {
        display: flex;
    }

    .carousel-control-prev {
        left: 10px;
    }

    .carousel-control-next {
        right: 10px;
    }

    @media only screen and (min-width: 320px) and (max-width: 600px){
        .carousel-item.active{
            margin-left:0px!important;
            display: flex;
            justify-content: center;
        }
    }
    </style>
</head>

<body id="app-container" class="menu-default" style="background-color: #f8f8f8; top: -35px; bottom:0px;">
    <?php $this->load->view('sidebar'); ?>
    <?php 
        //PHP block 
        $role = $this->session->userdata("UserType");
        if ($role == "Superadmin") {
            $show = 1;
            $add = 1;
        } else {
            if ($role=="Staff") {
                if (isset($permissions->addAnnouncement)) {
                    if ($permissions->addAnnouncement==1) {
                        $add = 1;
                    } else {
                        $add = 0;
                    }
                    if ($permissions->viewAllAnnouncement==1) {
                        $show = 1;
                    } else {
                        $show = 0;
                    }
                } else {
                    $show = 0;
                    $add = 0;
                }
            }else{
                $show = 1;
                $add = 0;
            }
        }
    ?>
    <main class="default-transition" style="opacity: 1;">
        <div class="container-fluid observationListContainer">
            <br>
            <br>
            <div class="pageHead" style="margin-top: 20px;">
                
                <div class="col-12">
                    <h1>Announcement List</h1>
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
                        </div>
                        <a href="<?php echo base_url('Reflections/createReflection'); ?>" class="btn btn-primary btn-lg top-right-button">ADD NEW</a>
                    </div>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Reflection</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
        </div>
        <?php if($center->id) { ?>
        <?php foreach(array_reverse($reflection) as $Reflections => $ref): ?>
        <div class="reflection-main-content">
            <div class="reflection-inner-content bg-white row shadow" style="margin:20px 0px;">
                <div class="col m-auto">
                <?php if(empty($ref->media)){ ?> 
                    <div class="d-flex justify-content-center">
                        <img src="<?= base_url('assets/images/no-image-available.jpg') ?>" class="img-fluid" alt="no-image" style="width:200px;height:200px;">
                    </div>
                <?php }else{ ?> 
                    <div id="carousel-example-generic-<?= $ref->id; ?>" class="carousel slide row">
                        <div class="carousel-inner " role="listbox">
                            <?php $i = 1; foreach($ref->media as $refmedia => $mediadata) { ?>
                
                            <div class="carousel-item col text-center <?php if($i==1){ echo "active"; } ?>">
                                <img class="list-thumbnail responsive border-0 card-img" src="<?= BASE_API_URL."assets/media/".$mediadata->mediaUrl; ?>" alt="No media here">
                            </div>
                            <a class="left col previous round carousel-control-prev h1 text-warning" href="#carousel-example-generic-<?= $ref->id; ?>" role="button" data-slide="prev">
                                &#8249;
                            </a>
                            <a class="right col next round carousel-control-next h1 text-warning" href="#carousel-example-generic-<?= $ref->id; ?>" role="button" data-slide="next">
                                &#8250;
                            </a>
                            <?php $i++; } ?>
                        </div>
                    </div>
                <?php } ?>

                </div>
                <div class="col-sm-8 p-4 row">
                    <div class="col-3">
                        <h3 class="font-weight-bold mt-3"><?php echo $ref->title ?></h3>
                        <h5 class="text-primary" style="font-size:14px;">
                            <?php echo date('d M Y',strtotime($ref->createdAt)) ?>
                        </h5>
                    </div>
                    <div class="col">
                        <div class="reflection-child-data row" style="">
                            <?php foreach($ref->childs as $refChild => $childdata) { ?>
                            <span>
                                <span class="col-sm-1">
                                    <img src="<?= BASE_API_URL."assets/media/".$childdata->imageUrl;?>" alt="" style=" border-radius:50%;width:50px;height:50px;">
                                </span>
                                <h3 class="text-primary col-sm-1" style="margin-top:12px;">
                                    <?php echo $childdata->name; ?>
                                </h3>
                            </span>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if($ref->about) { ?>
                        <p class="reflection-text" style="margin-top:20px;font-size:14px;">
                            <?php echo $ref->about ?>
                        </p>
                    <?php } ?>
                </div>
                <div class="col-sm-2 d-flex justify-content-center align-items-center">
                    <!-- <a href="<?php# echo base_url('Reflections/Reflection_update/?reflectionid='.$ref->id); ?>">
                        <span data-id="<?#= $ref->id; ?>" class="reflection-edit col-md-1"
                            style="padding:4px;width:2%;font-size:20px;">
                            <i class="simple-icon-pencil text-primary"></i>
                        </span>
                    </a>
                    <span class="reflection-delete col-md-1" id="reflection-delete" data-id="<?#= $ref->id; ?>"
                        data-userid="<?#= $ref->createdBy; ?>" style='padding:4px;width:2%;font-size:20px;'>
                        <i class='simple-icon-trash text-danger'></i>
                    </span> -->
                    <div class="btn-group">
                        <a class="btn btn-outline-primary btn-xs reflection-edit" data-id="<?= $ref->id; ?>" href="<?= base_url('Reflections/Reflection_update/?reflectionid='.$ref->id); ?>">
                            <i class="simple-icon-pencil"></i>
                        </a>                                              
                        <a class="btn btn-outline-danger btn-xs reflection-delete" data-userid="<?= $ref->createdBy; ?>" id="reflection-delete" data-id="<?= $ref->id; ?>">
                            <i class="simple-icon-trash"></i>
                        </a>                                             
                    </div>
                    <?php if($ref->status == 'PUBLISHED') { ?>
                    <span class="btn-success col-md-6 text-center rounded"
                        style="padding:4px;margin-left:7%;border-radius:3px;"><?php echo $ref->status ?></span>
                    <?php }else{ ?>
                    <span class="btn-warning col-md-6 text-center rounded"
                        style="padding:4px;margin-left:7%;border-radius:3px;"><?php echo $ref->status ?></span>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php }else{} ?>
    </main>
    <?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/select2.full.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/slick.min.js?id=1234"></script>
    <script>
    $(document).ready(function() {
        $('#centerId').on('change', function() {
            centerId = $(this).val();
            window.location.href =
                "<?php echo base_url("Reflections/getUserReflections"); ?>?centerId=" +
                centerId;
        });
    });

    $(document).on('click', '.reflection-delete', function() {
        var reflectionid = $(this).data('id');
        var userid = $(this).data('userid');
        $.ajax({
            traditional: true,
            url: "<?php echo base_url('Reflections/deleteReflection'); ?>",
            type: "POST",
            data: {
                "userid": userid,
                "reflectionid": reflectionid
            },
            success: function(msg) {
                console.log(msg);
                res = JSON.parse(msg);
                if (res.Status == "SUCCESS") {
                    location.reload();
                } else {
                    console.log(res.Message);
                }
            }
        });
    });
    </script>
</body>

</html>