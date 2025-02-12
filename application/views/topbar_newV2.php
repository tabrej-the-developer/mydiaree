<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Topbar | Mydiaree v2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/v2/styles.css');?>" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/');?>font/iconsmind-s/css/iconsminds.css" />
    <link rel="stylesheet" href="<?= base_url('assets/');?>font/simple-line-icons/css/simple-line-icons.css" />

    <link rel="stylesheet" href="<?= base_url('assets/css/v2/bootstrap.min.css');?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/v2/bootstrap.rtl.only.min.css');?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/v2/fullcalendar.min.css');?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/v2/dataTables.bootstrap4.min.css');?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/v2/datatables.responsive.bootstrap4.min.css');?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/v2/select2.min.css');?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/v2/perfect-scrollbar.css');?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/v2/glide.core.min.css');?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/v2/bootstrap-stars.css');?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/v2/nouislider.min.css');?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/v2/bootstrap-datepicker3.min.css');?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/v2/component-custom-switch.min.css');?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/v2/main.css');?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/v2/dore.light.bluenavy.min.css');?>" />
    <!-- <link rel="stylesheet" href="http://localhost/Mydiaree_v2/css/dore.light.bluenavy.min.css" /> -->
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"></script>
</head>

<body id="app-container" class="menu-default" style="background-color: #f8f8f8; top: -35px;">
<nav class="navbar fixed-top" style="height: auto;">
    <div class="d-flex align-items-center navbar-left">
        <a href="#" class="menu-button d-none d-md-block">
            <svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17">
                <rect x="0.48" y="0.5" width="7" height="1" />
                <rect x="0.48" y="7.5" width="7" height="1" />
                <rect x="0.48" y="15.5" width="7" height="1" />
            </svg>
            <svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17">
                <rect x="1.56" y="0.5" width="16" height="1" />
                <rect x="1.56" y="7.5" width="16" height="1" />
                <rect x="1.56" y="15.5" width="16" height="1" />
            </svg>
        </a>

        <a href="#" class="menu-button-mobile d-xs-block d-sm-block d-md-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17">
                <rect x="0.5" y="0.5" width="25" height="1" />
                <rect x="0.5" y="7.5" width="25" height="1" />
                <rect x="0.5" y="15.5" width="25" height="1" />
            </svg>
        </a>
    </div>
    <a class="navbar-logo" href="#">
        <img class="d-block d-xs-none" style="width:200px; height:50px; background-color: gray; padding: 10px; border-radius: 20px; box-shadow: 0px 3px 18px #888888;" src="<?php echo base_url('/assets/images/Mydiaree-logo-white.png'); ?>">
    </a>                                                    
    <div class="navbar-right">
        <div class="header-icons d-inline-block align-middle">
            <div class="position-relative d-none d-sm-inline-block">
            </div>
            <div class="position-relative d-inline-block notification-on">
                <button class="header-icon btn btn-empty header-icon-notifications" type="button" id="notificationButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="simple-icon-bell"></i>
                    <span class="count">3</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right mt-3 position-absolute notification-on" id="notificationDropdown">
                    <div class="scroll">
                        <div class="d-flex flex-row mb-3 pb-3 border-bottom">
                            <a href="#">
                                <img src="<?= base_url('assets/') ?>img/profiles/l-2.jpg" alt="Notification Image"
                                    class="img-thumbnail list-thumbnail xsmall border-0 rounded-circle" />
                            </a>
                            <div class="pl-3">
                                <a href="#">
                                    <p class="font-weight-medium mb-1">Joisse Kaycee just sent a new comment!</p>
                                    <p class="text-muted mb-0 text-small">09.04.2018 - 12:45</p>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex flex-row mb-3 pb-3 border-bottom">
                            <a href="#">
                                <img src="<?= base_url('assets/') ?>img/notifications/1.jpg" alt="Notification Image"
                                    class="img-thumbnail list-thumbnail xsmall border-0 rounded-circle" />
                            </a>
                            <div class="pl-3">
                                <a href="#">
                                    <p class="font-weight-medium mb-1">1 item is out of stock!</p>
                                    <p class="text-muted mb-0 text-small">09.04.2018 - 12:45</p>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex flex-row mb-3 pb-3 border-bottom">
                            <a href="#">
                                <img src="<?= base_url('assets/') ?>img/notifications/2.jpg" alt="Notification Image"
                                    class="img-thumbnail list-thumbnail xsmall border-0 rounded-circle" />
                            </a>
                            <div class="pl-3">
                                <a href="#">
                                    <p class="font-weight-medium mb-1">New order received! It is total $147,20.</p>
                                    <p class="text-muted mb-0 text-small">09.04.2018 - 12:45</p>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex flex-row mb-3 pb-3 ">
                            <a href="#">
                                <img src="<?= base_url('assets/') ?>img/notifications/3.jpg" alt="Notification Image"
                                    class="img-thumbnail list-thumbnail xsmall border-0 rounded-circle" />
                            </a>
                            <div class="pl-3">
                                <a href="#">
                                    <p class="font-weight-medium mb-1">3 items just added to wish list by a user!
                                    </p>
                                    <p class="text-muted mb-0 text-small">09.04.2018 - 12:45</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="user d-inline-block show-drp-f">
            <button class="btn btn-empty p-0 show-drp-s" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span>
                <img alt="Profile Picture" src="<?= base_url('assets/') ?>img/profiles/l-1.jpg" />
                </span>
                <span class="name"><?php echo $this->session->userdata('Name');?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-right mt-3 show-drp-t">
                <!-- <a class="dropdown-item" href="<?php echo base_url('logout'); ?>"><span class="material-icons">My Account</span> </a> -->
                <a class="dropdown-item" href="<?php echo base_url('logout'); ?>"><span class="material-icons">Log Out</span> </a>                                                     
            </div>
        </div>
    </div>
</nav>
</body>
</html>