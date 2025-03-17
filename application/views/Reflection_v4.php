<?php
	$data['name']='Reflection_form'; 
    // echo "<pre>";
    // print_r($reflection);
    // if($_SESSION['UserType'] == "Superadmin"){
    //     echo "hello this is SuperAdmin...";
    // }
    // print_r($permission->deletereflection);
    // print_r($permission->updatereflection);
    // exit();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reflection | Mydiaree</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

    /* .slick-prev.slick-arrow */
    .slick-arrow{
        display: none !important;
    }
  
    .slick-list.draggable, .slick-track{
        height: 100%;
    }
    .slick-track{
        padding: 0 !important;
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

<body id="app-container" class="menu-default show-spinner">
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
    <main class="default-transition">
        <div class="container-fluid observationListContainer">
            <div class="pageHead">
                <div class="col-12">
                    <h1>Daily Reflections</h1>
                    <div class="text-zero top-right-button-container">
                        <div class="btn-group mr-1">
                            <?php 
                                $centersList = $this->session->userdata("centerIds");
                                $selectedCenterName = "EMPTY CENTER"; // Default text

                                if (!empty($centersList)) {
                                    $dupArr = []; // Track unique centers
                                    $selectedCenterId = $_GET['centerid'] ?? $centersList[0]->id;

                                    // Find the selected center name
                                    foreach ($centersList as $center) {
                                        if (!in_array($center, $dupArr)) {
                                            array_push($dupArr, $center);

                                            if ($selectedCenterId == $center->id) {
                                                $selectedCenterName = strtoupper($center->centerName);
                                            }
                                        }
                                    }
                                }
                            ?>

                            <!-- Dropdown button displaying selected center or EMPTY CENTER if no centers exist -->
                            <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $selectedCenterName; ?>
                            </div>

                            <!-- Center dropdown options, if any -->
                            <?php if (!empty($centersList)) { ?>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php foreach($centersList as $center) { ?>
                                        <a class="dropdown-item" href="<?= current_url().'?centerid='.$center->id; ?>">
                                            <?= strtoupper($center->centerName); ?>
                                        </a>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- Conditional 'Add New' button -->
                        <?php 
    $hasPermissionToAdd = ($_SESSION['UserType'] == "Superadmin") || 
                         (isset($permission) && $permission && $permission->addReflection == 1);
    
    if ($hasPermissionToAdd && isset($selectedCenterId)) {
?>
    <a href="<?= base_url('Reflections/createReflection?centerid=' . $selectedCenterId); ?>" 
       class="btn btn-primary btn-lg top-right-button">ADD NEW</a>
<?php } ?>
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
        <div class="row">
        <?php foreach(array_reverse($reflection) as $Reflections => $ref): ?>
<!-- ADDED V4 -->
            <div class="col-12 col-lg-6 mb-5">
                <div class="card flex-row listing-card-container" style="height: 200px; overflow: hidden;">
                    <div class="w-40 position-relative">
                        <a href="#">
                            <!-- <img class="card-img-left" src="img/details/small-5.jpg" alt="Card image cap"> -->
                            <?php if(empty($ref->media)){ ?>
                                <img src="<?= base_url('assets/images/no-image-available.jpg') ?>" class="card-img-left" alt="no-image" style="width:200px;height:200px;">
                            <?php }else{ ?> 
                                <div class="single-item" style="height:100% !important;">
                                    <?php foreach($ref->media as $refmedia => $mediadata) { ?>
                                        <img class="card-img-left" src="<?= BASE_API_URL."assets/media/".$mediadata->mediaUrl; ?>" alt="No media here">
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <?php if($ref->status == 'PUBLISHED') { ?>
                                    <span class="badge badge-pill badge-theme-1 position-absolute badge-top-right">
                                        <?php echo $ref->status ?>
                                </span>
                                <?php }else{ ?>
                                    <span class="badge badge-pill badge-theme-1 position-absolute badge-top-right">
                                        <?php echo $ref->status ?>
                                </span>
                            <?php } ?>
                        </a>
                    </div>
                    <div class="w-60 d-flex align-items-center">
                        <div class="card-body" style="position:relative;">
                            <div class="parent-main">
                                <h3 class="font-weight-bold"><?php echo $ref->title ?></h3>
                                <h5 class="text-primary" style="font-size:14px;">
                                    <?php echo date('d M Y',strtotime($ref->createdAt)) ?>
                                </h5>
                            
                                <div class="reflection-child-data row" style="height: 60px;">
                                    <?php foreach($ref->childs as $refChild => $childdata) { ?>
                                    <div class="mb-3" style="display: flex;">
                                        <div class="col pr-0 d-flex align-items-center">
                                            <img src="<?= BASE_API_URL."assets/media/".$childdata->imageUrl;?>" alt="" style=" border-radius:50%;width:30px;height:30px;">
                                            <?= "&nbsp;".$childdata->name; ?>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="btn-group" style="position:absolute; top: 25px; right: 15px;">

          

                                <?php if($_SESSION['UserType'] == "Superadmin"){ ?>

                                    <a class="btn btn-outline-primary btn-xs" href="<?= base_url('Reflections/print/') . $ref->id ?>" target="_blank">
        <i class="fa-solid fa-print fa-beat fa-lg" style="color: #74C0FC;"></i>
    </a>

                                    <a class="btn btn-outline-primary btn-xs reflection-edit" data-id="<?= $ref->id; ?>" href="<?= base_url('Reflections/Reflection_update/?reflectionid='.$ref->id); ?>">
                                        <i class="simple-icon-pencil"></i>
                                    </a>
                                    <?php } elseif(isset($permission) && is_object($permission) && $permission->updatereflection == 1) { ?>
    <a class="btn btn-outline-primary btn-xs reflection-edit" 
       data-id="<?= $ref->id; ?>" 
       href="<?= base_url('Reflections/Reflection_update/?reflectionid='.$ref->id); ?>">
        <i class="simple-icon-pencil"></i>
    </a>
                                <?php }else{} ?>   
                                <?php if($_SESSION['UserType'] == "Superadmin"){ ?>                                           
                                    <a class="btn btn-outline-danger btn-xs reflection-delete" data-userid="<?= $ref->createdBy; ?>" id="reflection-delete" data-id="<?= $ref->id; ?>">
                                        <i class="simple-icon-trash"></i>
                                    </a>    
                                    <?php } elseif(isset($permission) && is_object($permission) && $permission->deletereflection == 1) { ?>
    <a class="btn btn-outline-danger btn-xs reflection-delete" 
       data-userid="<?= $ref->createdBy; ?>" 
       id="reflection-delete" 
       data-id="<?= $ref->id; ?>">
        <i class="simple-icon-trash"></i>
    </a>
<?php } else {} ?>                                      
                            </div>
                            <?php if($ref->about) { ?>
                                <p class="text-truncate">
                                    <?= substr($ref->about,0,70).'...'; ?>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
<!-- END V4 -->
        <?php endforeach; ?>
        </div>
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

        $('.single-item').slick({
            autoplay: true,
            infinite: true,
            speed: 3000,
            loop: true
        });
    });


    $(document).on('click', '.reflection-delete', function() {
        var reflectionid = $(this).data('id');
        var userid = $(this).data('userid');

        // Confirmation prompt
        if (confirm("Are you sure you want to delete this reflection?")) {
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
                    var res = JSON.parse(msg);
                    if (res.Status == "SUCCESS") {
                        location.reload();
                    } else {
                        console.log(res.Message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error: " + error);
                }
            });
        } else {
            console.log("Deletion cancelled by the user.");
        }
    });

    </script>
</body>

</html>