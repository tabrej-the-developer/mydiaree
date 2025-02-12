<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rooms List | Mydiaree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

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
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css" />
    <style>
        .list-thumbnail{
            height: 150px;
            width: 200px;
        }
        .obs-link{
            color: #008ecc;
        }
        .obs-link:hover{
            color: #000000;
        }
    </style>
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Rooms List</h1>
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
                        <?php 
                            $usertype = $this->session->userdata('UserType');
                            if (isset($userType)) {
                              if ($userType=="Superadmin") {
                                $addRoom = 1;
                                $deleteRoom = 1;
                                $viewRoom = 1;
                                $editRoom = 1;
                              }elseif($userType=="Staff"){

                                if ($permission != NULL && $permission->addRoom == 1) {
                                  $addRoom = 1;
                                } else {
                                  $addRoom = 0;
                                }

                                if ($permission != NULL && $permission->deleteRoom == 1) {
                                  $deleteRoom = 1;
                                } else {
                                  $deleteRoom = 0;
                                }

                                if ($permission != NULL && $permission->viewRoom == 1) {
                                  $viewRoom = 1;
                                } else {
                                  $viewRoom = 0;
                                }

                                if ($permission != NULL && $permission->editRoom == 1) {
                                  $editRoom = 1;
                                } else {
                                  $editRoom = 0;
                                }

                              }else{
                                $addRoom = 0;
                                $deleteRoom = 0;
                                $viewRoom = 0;
                                $editRoom = 0;
                              }
                            }else{
                              $addRoom = 0;
                              $deleteRoom = 0;
                              $viewRoom = 0;
                              $editRoom = 0;
                            }
                            
                            if ($addRoom == 1) {
                        ?>
                        <button type="button" class="btn btn-primary btn-lg top-right-button">ADD NEW</button>
                        <?php } ?>
                    </div>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Rooms List</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row">
                <?php 
                    if($viewRoom == 1){ 
                        $i=1; 
                        foreach($rooms as $room) {

                        }
                    }else{ 
                ?>
                <div class="col">
                    <div class="text-center">
                        <h6 class="mb-4">Ooops... looks like you lack of permission!</h6>
                        <p class="mb-0 text-muted text-small mb-0">Error code</p>
                        <p class="display-1 font-weight-bold mb-5">
                            303
                        </p>
                        <a href="<?= base_url('dashboard'); ?>" class="btn btn-primary btn-lg btn-shadow">GO BACK HOME</a>
                    </div>
                </div>
                <?php } ?>
            </div>  
        </div>
    </main>

    <?php $this->load->view('footer_v3'); ?>

    <div class="modal fade modal-right" id="filtersModal" tabindex="-1" role="dialog" aria-labelledby="filtersModalRight" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filters</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            
                        </div>
                    </div>          
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js"></script>
</body>
</html>